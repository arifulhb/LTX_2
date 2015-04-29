<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }//end constract
    
    /**
     * INSERT DATA INTO DATABASE
     * 
     * @param type $data
     * @return boolean
     */
    public function insert($data=null){
    
        $res =$this->db->insert('tblmerchant', $data); 
        if($res==true){
            $res=array('status'=>true,'new_id'=>$this->db->insert_id());
        }else{
            $res=array('status'=>FALSE);
        }
        return $res;
    }//end function
    
    public function search($keyword, $search_by,$limit,$offset){
        
        if($offset==''){
            $offset=0;
        }
        
        $sql='SELECT c.cust_sn, c.cust_card_id, cust_first_name, cust_last_name, cust_mobile, cust_car_no, IFNULL(UNIX_TIMESTAMP(c.date_added),0) as date_added, ';
        $sql.='(SELECT GROUP_CONCAT(n.cmpn_name SEPARATOR ", ") FROM avcd_subscription AS s LEFT OUTER JOIN avcd_campaign AS n ON n.cmpn_sn=s.cmpn_sn WHERE s.cust_sn=c.cust_sn ) AS cmpn_name ';
        $sql.='FROM (avcd_customer AS c) ';
        //$sql.='';        
        switch ($search_by):
            case 'name':
                $sql.='WHERE c.cust_first_name LIKE "%'.$keyword.'%" OR c.cust_last_name LIKE"%'.$keyword.'%" ';
                
                break;
            case 'nric':
                $sql.='LEFT OUTER JOIN avcd_customer_id AS i ON i.cust_sn = c.cust_sn ';
                $sql.='WHERE c.cust_card_id LIKE "%'.$keyword.'%" ';
                $sql.='OR i.cust_card_id LIKE  "%'.$keyword.'%" ';
                break;
            case 'card_number':
                $sql.='WHERE c.cust_id LIKE "%'.$keyword.'%" ';
                break;
            case 'car_number':
                $sql.='WHERE c.cust_car_no LIKE "%'.$keyword.'%" ';
                break;
        endswitch;
                $sql.='GROUP BY c.cust_sn ';
                $sql.='ORDER BY c.cust_first_name ';
                $sql.='LIMIT '.$offset.', '.$limit;
                
         $res=$this->db->query($sql);
         
         //echo 'SQL: '.$this->db->last_query();         
         //exit();
         
         return $res->result_array();
        
    }//end function
    
    public function getTotalSearchNum($keyword, $search_by){
        
        
        $sql='SELECT cust_sn ';
        //$sql.='(SELECT GROUP_CONCAT(n.cmpn_name SEPARATOR ", ") FROM avcd_subscription AS s LEFT OUTER JOIN avcd_campaign AS n ON n.cmpn_sn=s.cmpn_sn WHERE s.cust_sn=c.cust_sn ) AS cmpn_name ';
        $sql.='FROM (avcd_customer AS c) ';
        //$sql.='';        
        switch ($search_by):
            case 'name':
                $sql.='WHERE c.cust_first_name LIKE "%'.$keyword.'%" OR c.cust_last_name LIKE"%'.$keyword.'%" ';
                
                break;
            case 'nric':
                $sql.='WHERE c.cust_card_id LIKE "%'.$keyword.'%" ';
                break;
            case 'card_number':
                $sql.='WHERE c.cust_id LIKE "%'.$keyword.'%" ';
                break;
            case 'car_number':
                $sql.='WHERE c.cust_car_no LIKE "%'.$keyword.'%" ';
                break;
        endswitch;
                //$sql.='GROUP BY c.cust_sn ';                  
         $res=$this->db->query($sql);
         
         //echo 'SQL: '.$this->db->last_query();
         
         return $res->num_rows();
        
    }//end function

          

    public function getList($per_page,$offset){
        if($offset==''){
            $offset=0;
        }
        
        $sql='SELECT m.mrcnt_sn, m.mrcnt_name, m.mrcnt_email, m.mrcnt_xero_api_key, m.mrcnt_xero_api_secret, m.mrcnt_xero_revenew_code_id, m.mrcnt_pos_company_id, ';
        $sql.='(SELECT COUNT(i.tran_sn) AS c FROM tbltransactions AS i WHERE i.mrcnt_sn=m.mrcnt_sn AND i.tran_status="success" ) AS tran_success, ';
        $sql.='(SELECT COUNT(f.tran_sn) AS c FROM tbltransactions AS f WHERE f.mrcnt_sn=m.mrcnt_sn AND f.tran_status="failed" ) AS tran_failed, ';
        $sql.='m.addDate, m.mrcnt_status, m.user_sn ';
        $sql.='FROM tblmerchant m '; 
        $sql.='LIMIT '.$offset.','.$per_page;       
        $res=$this->db->query($sql);        
        return $res->result_array();
        
    }//end function
    
        public function getListFilter($per_page,$offset,$filter){
            
        if($offset==''){
            $offset=0;
        }
        
        $sql='SELECT `cust_sn`, `cust_card_id`, `cust_first_name`, `cust_last_name`, `cust_mobile`, `cust_car_no`, IFNULL(UNIX_TIMESTAMP(c.date_added),0) as date_added, cust_additional,';
        $sql.='(SELECT GROUP_CONCAT(n.cmpn_name SEPARATOR ", ") FROM avcd_subscription AS s LEFT OUTER JOIN avcd_campaign AS n ON n.cmpn_sn=s.cmpn_sn WHERE s.cust_sn=c.cust_sn ) AS cmpn_name ';
        $sql.='FROM (`avcd_customer` AS c) ';
        $sql.='WHERE c.date_added >= "'.$filter['from'].' 00:00:00" ';
        $sql.='AND c.date_added <= "'.$filter['to'].' 23:59:59" ';
        $sql.='GROUP BY `c`.`cust_sn` ';
        $sql.='ORDER BY `c`.`date_added` DESC ';        
        $sql.=' LIMIT '.$offset.','.$per_page;       
        $res=$this->db->query($sql);
        //echo $this->db->last_query();
        //print_r($res->result_array());
        //exit();
        return $res->result_array();
        
    }//end function
    
   
        
    public function getRecord($_sn=NULL){

        $this->db->select("m.*, p.*");
        $this->db->from("tblmerchant as m");
        $this->db->join("tblpartner as p", "m.partner_sn = p.partner_sn", "LEFT");
        $this->db->where('mrcnt_sn', $_sn);
        $res = $this->db->get();

//        $sql='SELECT * ';
//        $sql.='FROM tblmerchant ';
//        $sql.=""
//        $sql.='WHERE mrcnt_sn ='.$_sn;
//        $res=$this->db->query($sql);

        
        return $res->result_array();
        
    }//end function

      
    
    public function update($data, $_sn){
        
        
        $this->db->where('mrcnt_sn',$_sn);   
        $res=$this->db->update('tblmerchant',$data);
        return $res;
        
    }//end function
    
    

    public function delete($data=null){
        
        $this->db->trans_start();
        
            $this->db->delete('avcd_customer', array('cust_sn' => $data)); 
            $this->db->delete('avcd_subscription', array('cust_sn' => $data));             
            
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === TRUE)
        {            
            $res=TRUE;
            
        }else
        {
            //GENERATE ERROR            
            $res=FALSE;
        }          
        
        return $res;
        
    }//end function

    public function getTotalNum(){
        
        $this->db->select('mrcnt_sn');
        $this->db->from('tblmerchant');
        $res=$this->db->get();
        return $res->num_rows;
    }//end function
    
    public function getTotalNumFilter($filter){
        
        $this->db->select('mrcnt_sn');
        $this->db->from('tblmerchant');        
        $this->db->where('addDate >=',$filter['from'].' 00:00:00 ');
        $this->db->where('addDate <=',$filter['to'].' 23:59:59 ');
        $res=$this->db->get();
        return $res->num_rows;
    }//end function
    
    public function getAllRecords(){
        $this->db->select('*');
        $this->db->from('tblmerchant');
        $this->db->order_by('addDate');
        $res=$this->db->get();
        
        return $res->result_array();
    }//end function



	public function getMerchantsByPartner($partner_sn)
	{

		$this->db->select("m.*");
		$this->db->from("tblmerchant as m");
		$this->db->where("m.partner_sn", $partner_sn);
		$this->db->where("m.mrcnt_status", "active");
		$this->db->where("m.mrcnt_auto_sync", 1);

		$res = $this->db->get();

		return $res->result_array();

	}//end function
    
    /**
     * INSERT INTO tblaccounts
     */
    public function insertAccount($data){
        
        $res =$this->db->insert('tblaccounts', $data); 
        if($res==true){
            $res=array('status'=>TRUE,'new_id'=>$this->db->insert_id());
        }else{
            $res=array('status'=>FALSE);
        }
        return $res;
        
    }//end function
    
    /**
     * RETURN ALL LINKED ACCOUNTS FROM POSiOS and XERO API
     * @param type $mrcnt_sn
     */
    public function getLinkAccountList($mrcnt_sn){
        
        $this->db->select('*');
        $this->db->from('tblaccounts');
        $this->db->where('mrcnt_sn',$mrcnt_sn);
        $res =$this->db->get();        
        return $res->result_array();
        
    }//end function
    
    /**
     * REMOVE LINKED ACCOUNT
     * 
     * USED IN Customer controller
     * 
     * @param type $accsn
     * @param type $mrcnt_sn
     */
    public function remove_linked_account($accsn){
        
        $this->db->where('acc_sn',$accsn);        
        $res=$this->db->delete('tblaccounts');
        
        return $res;
        
    }//end function 
    
    /**
     * USED IN Customer controller
     * 
     * @param type $mrcntsn
     */
    public function getMerchantLinkedAccountsBySn($mrcntsn){
        
        $this->db->select('m.mrcnt_sn, m.mrcnt_name, m.mrcnt_email, a.acc_sn, a.pos_payment_type_oid,a.pos_payment_type_name,a.xero_code_id, a.xero_account_id, a.xero_account_name, m.mrcnt_xero_api_key as xero_api_key, m.mrcnt_xero_api_secret as xero_api_secret, m.mrcnt_xero_revenew_code_id, m.mrcnt_xero_tc_id, m.mrcnt_xero_tc_name, m.mrcnt_xero_tc_group_name, a.acc_link_type');
        $this->db->from('tblaccounts AS a');
        $this->db->join('tblmerchant AS m','m.mrcnt_sn=a.mrcnt_sn','LEFT');
        $this->db->where('a.mrcnt_sn',$mrcntsn);
        $res=$this->db->get();
                
        return $res->result_array();
        
    }//end function



    public  function setRevenueAccount($data,$mrcnt_sn){

        $this->db->where('mrcnt_sn',$mrcnt_sn);

        $res=$this->db->update('tblmerchant',$data);

        return $res;


    }//end function

    public function getTransTime($_mrcnt_sn){

        $sql='SELECT mrcnt_start_time, mrcnt_end_time, mrcnt_end_time_is_same_date ';
        $sql.='FROM tblmerchant ';
        $sql.='WHERE mrcnt_sn ='.$_mrcnt_sn;
        $res=$this->db->query($sql);

        return $res->result_array();

    }//end function get TransTime

}//end class