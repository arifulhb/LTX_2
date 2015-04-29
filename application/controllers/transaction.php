<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller {

    
    public function __construct()
    {                
        parent::__construct();
        if(($this->session->userdata('is_logged_in')==TRUE))
        {
            $this->load->library('template');
        }else{
            redirect('signin');
        }            

        no_cache();

    }//end constractor
    
    public function index()
    {
        
        if($this->session->userdata('is_logged_in')==TRUE){
        
        $data=  site_data();
        $this->load->model('customer_model');
        $data['_merchants']=$this->customer_model->getAllRecords();
        
        $mrcnt_sn       =$this->input->get('merchant');
        $tran_status    =$this->input->get('status');
        
        if($mrcnt_sn!='' && $tran_status!=''){
            // load the transactions and pagination
            
            $this->load->library('pagination');
            $this->load->model('transaction_model');
            
            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            $config['base_url'] = base_url().'transaction/?merchant='.$mrcnt_sn.'&status='.$tran_status;
            

            $config['total_rows'] = $this->transaction_model->getTotalNum($mrcnt_sn,$tran_status);        
            $config['use_page_numbers']=true;
            $config['per_page'] = 30;
            $config['num_links'] = 5;        
            $config['uri_segment'] = 2;      
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);


            $data['_total_rows']=$config['total_rows'];
            $_page=$this->input->get('per_page');
            
            if($_page!=''){

                $data['_transactions']=$this->transaction_model->getListByMerchantSn($mrcnt_sn,$tran_status,$config['per_page'],($config['per_page']*($_page-1)));
            }else{                

              $data['_transactions']=$this->transaction_model->getListByMerchantSn($mrcnt_sn,$tran_status,$config['per_page'],$_page);
            }
            
        }//
        
        
        $data['_page_title']='Transactions';
        $this->template->transaction_index($data);                        
         }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
         
    }//end index
    
    public function add(){
        /*
       if($this->session->userdata('is_logged_in')==TRUE){
 
            $data=  site_data();
            $data['_page_title']='Add Campaign';
            $data['_action']='add';
            $this->template->campaign_add($data);                        
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
         * 
         */
    }//end function
    
    
    public function save(){
        /*
        if($this->session->userdata('is_logged_in')==TRUE){
 
        $this->load->library('form_validation');
        
        $data['cmpn_name']=$this->input->post('inputCampaignName');
        $data['cmpn_type']=$this->input->post('inputCampaignType');
        $data['cmpn_expire_duration']=$this->input->post('inputExpireDuration');
        $data['cmpn_duration_type']=$this->input->post('inputExpireDurationType');
        
        $_action=$this->input->post('_action');
        
        $this->form_validation->set_rules('inputCampaignName', 'Campaign Name', 'trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('inputCampaignType', 'Campaign Type', 'trim|required|max_length[10]|xss_clean');
        $this->form_validation->set_rules('inputExpireDuration', 'Expire Duration', 'trim|required|is_natural|xss_clean');
        $this->form_validation->set_rules('inputExpireDurationType', 'Expire Duration Type', 'trim|required|max_length[7]|xss_clean');
        
        if($data['cmpn_type']=='visit'){
            //Validate if Visit Type
            $data['cmpn_visit_active_button']=$this->input->post('inputVisitActivateButton');        
            //$this->form_validation->set_rules('inputVisitActivateButton', 'Visit Activate Button', 'trim|required|max_length[50]|xss_clean');
        }elseif($data['cmpn_type']=='session'){
            
            $iter=$this->input->post('totalRedumSessions');            
            $redimSession=array();
            
            for($i=1;$i<=$iter;$i++){
                array_push($redimSession,
                        array('redem_sn'=>$_action=='add'?$i:$this->input->post('red_sn_'.$i),
                                'red_sessions'=>$this->input->post('red_session_'.$i),
                                'red_name'=>$this->input->post('red_name_'.$i),
                                'red_description'=>$this->input->post('red_desc_'.$i)
                                ));//END ARRAY PUSH
            }//end for loop
        }
            
        if ($this->form_validation->run() == true)
        {             
            $res=false;
            $this->load->model('campaign_model');
            if($_action=='add'){
                
                if($data['cmpn_type']=='session'){
                    $res = $this->campaign_model->insert_session($data,$redimSession);    
                }else{
                    $res = $this->campaign_model->insert($data);        
                }
                
                
                
                if($res['status']==TRUE){
                    redirect('campaign/details/'.$res['new_id']);  
                }else{
                    //show error message
                }
            }else{
                $id=$this->input->post('_sn');
                if($data['cmpn_type']=='session'){
                    $res=$this->campaign_model->update_session($data,$id,$redimSession);         
                }
                else{
                $res=$this->campaign_model->update($data,$id);             
                }
                
                
                
                if($res==TRUE){
                    redirect('campaign/details/'.$id);  
                }else{
                    //show error message
                }
            }//end else
            
            //RETURN THE RESULT            
            //return $res;
            
        }//end if
        else{
            
            //echo validation_errors();
            //exit();
             $data=  site_data();
             
            //echo 'error: '.  validation_errors();
            $data['_error']=  validation_errors();
            
            $data['_record'][0]['cmpn_name']=$this->input->post('inputCampaignName');
            $data['_record'][0]['cmpn_type']=$this->input->post('inputCampaignType');
            $data['_record'][0]['cmpn_expire_duration']=$this->input->post('inputExpireDuration');
            $data['_record'][0]['cmpn_duration_type']=$this->input->post('inputExpireDurationType');
            
            if($data['cmpn_type']=='visit'){
            $data['_record'][0]['cmpn_visit_active_button']=$this->input->post('inputVisitActivateButton');    
            }
                
            $_action=$this->input->post('_action');
            
            if($_action=='add'){
                $data['_page_title']='Add Campaign';
                $data['_action']='add';                                
                $data['_country']=  getCountry();
                $this->template->campaign_add($data);  
            }else{
                
                $data['_sn']=$this->input->post('_sn');
                
                $data['_page_title']='Update Campaign';
                $data['_action']='update';                                                
                $this->template->campaign_add($data);  
            }
            
        }//end else        
        
        
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
         * 
         */
    }//end function   
    
    public function delete(){
    /*
        if($this->session->userdata('is_logged_in')==TRUE){
 
                $data['_sn']=$this->input->post('_sn');        
                $this->load->model('campaign_model');
                $res= $this->campaign_model->delete($data['_sn']);

                echo $res;
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
        */
    }//end function

    
    public function edit(){
        /*
         if($this->session->userdata('is_logged_in')==TRUE){
             
        $data=  site_data();
        $data['_page_title']='Edit Campaign';
        $data['_action']='update';
        
        $this->load->model('campaign_model');                
        $data['_sn']=$this->uri->segment(3);;
        $data['_record']=$this->campaign_model->getRecord($data['_sn']);         
                
        if($data['_record'][0]['cmpn_type']=='session'){
            $data['_session_record']=$this->campaign_model->getSessionRecord($data['_sn']);         
        }
                
        $this->template->campaign_edit($data);
        
        
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
      
        */
    }//end function

    
    public function view(){
    
        
       if($this->session->userdata('is_logged_in')==TRUE){

            $data=  site_data();
            $data['_page_title']='Campaign Details';

            $this->load->model('campaign_model');        
            $_id=$this->uri->segment(3);
            $data['_record']=$this->campaign_model->getRecord($_id);         

            if($data['_record'][0]['cmpn_type']=='session'){
                $data['_session_record']=$this->campaign_model->getSessionRecord($_id);         
            }

            $this->template->campaign_details($data);  
        
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
         
    }//end function



    public function getTransactionTime(){

        $_mrcnt_sn  = $this->input->post('_mrcnt_sn');

        $this->load->model('customer_model');
        $res = $this->customer_model->getTransTime($_mrcnt_sn);

        echo json_encode(Array('times'=>$res));

    }//end function getTransactionTime()

    /**
     * CHECK IF A TRANSACTIOIN OF A DATE AND MERCHANT IS ALREADY DONE
     * 
     * @return boolean
     */
    public function checkTransaction(){
       
        
        $_date  = $this->input->post('_date');
        $_mrcnt_sn  = $this->input->post('_msn');
        $this->load->model('transaction_model');
        $res = $this->transaction_model->checkTransactionStatus($_mrcnt_sn, convertMyDate($_date));
        
        //echo json_encode(Array('invoices'=>$res));
        echo json_encode(Array('count'=>count($res),'invoices'=>$res));
                
    }//end function


    /**
     *  clearNoteAjax
     *
     *  remove the value in note column from tbltransaction
     *
     */
    public function clearNoteAjax(){


        $_tran_sn  = $this->input->post('_tran_sn');

        $this->load->model('transaction_model');

        $res = $this->transaction_model->clearNote($_tran_sn);

        echo json_encode(Array('result'=>$res));


    }//end function


    /**
     * Call from customer_view.js
     * Merchant view page to remove transaction
     *
     */
    public function removeTransactionAjax()
    {
        if($this->session->userdata('is_logged_in')==TRUE) {

            $_tran_sn  = $this->input->post('_tran_sn');

            $this->load->model('transaction_model');

            $res = $this->transaction_model->removeTransaction($_tran_sn);

            echo $res;

        }else{
            echo false;
        }

    }//end if
    
}//end class
