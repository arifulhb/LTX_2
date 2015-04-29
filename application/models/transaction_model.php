<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }//end constract 
    
    public function insert($data)
    {
        
        $this->db->set($data);
        $res=$this->db->insert('tbltransactions');
        
        return $res;
        
    }//end function
    
     public function getListByMerchantSn($mrcnt_sn,$tran_status,$per_page,$offset)
     {
                
        if($offset==''){
            $offset=0;
        }
        $this->db->select('t.tran_sn, t.mrcnt_sn, UNIX_TIMESTAMP(t.tran_date) AS tran_date,t.tran_mode, t.tran_status, t.details,t.invoice_number,t.date_added AS date_added, t.update_by, u.`user_name`, u.user_type, t.note ');
        $this->db->from('tbltransactions as t');
        $this->db->where('t.mrcnt_sn',$mrcnt_sn);
        if($tran_status!='all'){
            $this->db->where('tran_status',$tran_status);    
        }
        $this->db->join('tbluser AS u ','t.update_by =u.user_sn','LEFT');
        $this->db->order_by('t.tran_date','DESC');
        $this->db->limit($per_page,$offset);
        $res=$this->db->get();
        
        //echo 'sql: '.$this->db->last_query();
        return $res->result_array();
        
    }//end function
    
    public function getAllRecordsByMerchantSn($mrcnt_sn,$per_page,$offset)
    {
                
        if($offset==''){
            $offset=0;
        }
        $this->db->select('t.tran_sn, t.mrcnt_sn, UNIX_TIMESTAMP(t.tran_date) AS tran_date,t.tran_mode, t.tran_status, t.details,t.invoice_number,t.date_added AS date_added, t.update_by, u.`user_name`, u.user_type, t.note ');
        $this->db->from('tbltransactions as t');
        $this->db->where('t.mrcnt_sn',$mrcnt_sn);
        $this->db->join('tbluser AS u ','t.update_by =u.user_sn','LEFT');
        $this->db->order_by('t.tran_date','DESC');
        $this->db->limit($per_page,$offset);
        $res=$this->db->get();
        
        //echo 'sql: '.$this->db->last_query();
        return $res->result_array();
        
    }//end function
    
    
    
    public function getTotalNum($mrcnt_sn,$tran_status)
    {
        
        $this->db->select('mrcnt_sn');
        $this->db->from('tbltransactions');
        $this->db->where('mrcnt_sn',$mrcnt_sn);
        if($tran_status!='all'){
            $this->db->where('tran_status',$tran_status);    
        }
        
        $res=$this->db->get();
        return $res->num_rows;
        
    }//end function

    public function getTotalNumByMrchangeSn($mrcnt_sn){
    
        $this->db->select('mrcnt_sn');
        $this->db->from('tbltransactions');
        $this->db->where('mrcnt_sn',$mrcnt_sn);
        $res=$this->db->get();
        return $res->num_rows;
        
    }//end function

    public function getRecord($mrcnt_sn, $date){
                
        $this->db->select('*');
        $this->db->from('tbltransactions');
        $this->db->where('mrcnt_sn',$mrcnt_sn);
        $this->db->where('tran_date = "'.$date.'"');
        //$this->db->where('tran_date BETWEEN "'.$_from.'" AND "'.$_to.'"');
        
        $res=$this->db->get();
        
        return $res->result_array();
        
    }//end function

    
    public function update($tran)
    {
        
        $data['invoice_number']     = $tran['invoice_number'];
        $data['tran_status']        = $tran['tran_status'];
        $data['tran_mode']          = $tran['tran_mode'];
        $data['details']            = $tran['details'];
        $data['date_added']         = $tran['date_added'];
        $data['update_by']          = $tran['update_by'];
                
        $this->db->where('mrcnt_sn', $tran['mrcnt_sn']);
        $this->db->where('tran_date',  $tran['tran_date']);
        $this->db->update('tbltransactions', $data); 
        
    }//end function

    public function updateNote($note)
    {

        $data['note']       = $note['note'];

        $this->db->where('mrcnt_sn', $note['mrcnt_sn']);
        $this->db->where('tran_date',  $note['tran_date']);

        $this->db->update('tbltransactions', $data);

    }//end function

    public function clearNote($tran_sn)
    {

        $data['note']       = null;

        $this->db->where('tran_sn', $tran_sn);
        $res = $this->db->update('tbltransactions', $data);

        return $res;

    }//end function

    public function checkTransactionStatus($mrcnt_sn,$date)
    {
        
        $this->db->select('*');
        $this->db->from('tbltransactions');
        $this->db->where('mrcnt_sn',$mrcnt_sn);
        $this->db->where('tran_date',$date);
        $this->db->where('tran_status','success');
        
        $res=$this->db->get();
        
        return $res->result_array();
        
    }//end funciton


    public function removeTransaction($_tran_sn)
    {
        $res = $this->db->delete('tbltransactions', array('tran_sn' => $_tran_sn));

        return $res;

    }//end function
    
}//end class
