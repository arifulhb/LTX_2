<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model
{
    //var $photo_path;
    
    public function __construct()
    {
        parent::__construct();
    }//end constract
    
    
    public function insert($data=null){
    
        $res =$this->db->insert('tbluser', $data); 
        if($res==true){
            $res=array('status'=>true,'new_id'=>$this->db->insert_id());
        }else{
            
        }
        return $res;
    }//end function
        

    public function getList($per_page,$offset){
        if($offset==''){
            $offset=0;
        }
        
        $this->db->select('u.user_sn, u.user_name, u.user_email, u.user_type, u.mrcnt_sn, m.mrcnt_name');
        $this->db->limit($per_page,$offset);
        $this->db->from('tbluser AS u');
        $this->db->join('tblmerchant as m','m.mrcnt_sn=u.mrcnt_sn','LEFT OUTER');
        $this->db->order_by('u.user_sn','DESC');
        $res=$this->db->get();
        
        //echo $this->db->last_query();
        return $res->result_array();
        
    }//end function
    
        
    public function signin($data){
        
        $user_id=$data['user_id'];
        $user_pass=md5($data['user_pass']);
        
        $this->db->select('u.user_sn,u.user_email, u.user_name, u.user_type, u.mrcnt_sn');
        $this->db->from('tbluser AS u');        
        $this->db->where('u.user_email',$user_id);
        $this->db->where('u.user_pass',$user_pass);
        $res=$this->db->get();        
        return $res->result_array();
        
    }//end function


    /**
     * Get Partner Info for Merchant
     *
     * @param Integer $mrcnt_sn Merchant SN
     *
     * @return mixed
     *
     */
    public function getMerchantPartnerRecord($mrcnt_sn){

        $this->db->select('p.*');
        $this->db->from('tblpartner AS p');
        $this->db->join('tblmerchant as m ','m.partner_sn = p.partner_sn',"LEFT");
        $this->db->join('tbluser as u ','u.mrcnt_sn = m.mrcnt_sn',"LEFT");
        $this->db->where('u.mrcnt_sn', $mrcnt_sn);
        $this->db->limit(1);
        $res=$this->db->get();
        return $res->result_array();

    }//end function

    /**
     * getPartnerRecord
     *
     * Get Default Partner info
     *
     *
     * @return mixed
     */
    public function getPartnerRecord($partner_id){
        
        $this->db->select('p.*');
        $this->db->from('tblpartner AS p');        
        $this->db->where('p.partner_sn',$partner_id);

        $this->db->limit(1);
        $res=$this->db->get();        
        return $res->result_array();
        
    }//end function

    /**
     *
     * Get All Partners
     *
     * @return mixed
     *
     */
    public function getPartners(){

        $this->db->select('p.*');
        $this->db->from('tblpartner AS p');
        $res=$this->db->get();
        return $res->result_array();

    }//end function


    public function getRecord($_sn=NULL){
        
        $this->db->select('u.*,m.mrcnt_name');
        $this->db->from('tbluser as u');
        $this->db->join('tblmerchant as m','m.mrcnt_sn=u.mrcnt_sn','LEFT OUTER');
        //$this->db->join('avcd_outlet as o','o.ol_sn=u.ol_sn','LEFT OUTER');
        $this->db->where('u.user_sn',$_sn);        
        $res=$this->db->get();
        
        return $res->result_array();
        
    }//end function
    
    public function update($data, $_sn){
        
        //$this->db->set($data);
        $this->db->where('user_sn',$_sn);   
        $res=$this->db->update('tbluser',$data);
        return $res;
        
    }//end function
    
    public function delete($data=null){
        
        $res= $this->db->delete('tbluser', array('user_sn' => $data));         
        return $res;
        
    }//end function

    public function getTotalNum(){
        
        $this->db->select('user_sn');
        $this->db->from('tbluser');
        $res=$this->db->get();
        return $res->num_rows;
    }//end function
    
    public function getAllRecords(){
        $this->db->select('u.*');
        $this->db->from('`tbluser` AS u');
        //$this->db->join('`avcd_outlet` AS o','o.ol_sn=u.`ol_sn`','LEFT');
        //$this->db->order_by('ol_name');
        $res=$this->db->get();
        
        return $res->result_array();
    }//end function
     
    public function getAllRoles(){
        $this->db->select('*');
        $this->db->from('avcd_user_role');
        $this->db->order_by('rank');
        $res=$this->db->get();
        
        return $res->result_array();
    }//end function
    
    public function setToken($user_sn, $data){
        
        $this->db->where('user_sn',$user_sn);
        $res =$this->db->update('tbluser',$data);
        
        return $res;
        
    }//end function
    
    public function changepassword($data,$user_sn){
    
        $this->db->where('user_sn', $user_sn);
        $res =$this->db->update('tbluser', $data); 
        
        return $res;
    }//end function            
    
}//end class