<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

    
    public function __construct()
    {
           parent::__construct();                        
           
           if(($this->session->userdata('is_logged_in')==TRUE) )
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
            
            $data['_page_title']='My Profile';
            if($this->session->userdata('user_type')==1){
                
                $this->template->admin_home($data);              
                
            }else if($this->session->userdata('user_type')==2){
                
                
                $this->load->model('customer_model');
                
                $data['_sn']=$this->session->userdata('mrcnt_sn');
                $this->load->model('customer_model');
                $data['_record']=$this->customer_model->getRecord($data['_sn']);                                   
                $data['_linked_accounts']=$this->customer_model->getLinkAccountList($data['_sn']);

                $this->load->model('transaction_model');
                $data['_transactions']=$this->transaction_model->getAllRecordsByMerchantSn($data['_sn'],10,0);

                                                
                $this->template->profile_home($data);              
            }
                      
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
        
    }//end index
    
    
    /**
     * 
     * MANUAL POST
     */
    public function manual_post(){
        
        if($this->session->userdata('is_logged_in')==TRUE){            
        
            if($this->session->userdata('user_type')==2){
                
                $data=  site_data();
                
                //$data['_sn']=$this->uri->segment(3);        
                $this->load->model('customer_model');
                $data['_record']=$this->customer_model->getRecord($this->session->userdata('mrcnt_sn'));

                $data['_page_title']='Merchant Daily Report';
                $this->template->customer_daily_report($data);   
                
            }else{
                echo 'You are not a Merchant!';
            }
            
        
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
        }
        
    }//end function 
    
    public function update_validation(){
        
        if($this->session->userdata('is_logged_in')==TRUE &&
                $this->session->userdata('user_type')==2){
            
            
            
        
            $_action = $this->input->post('_action');                

            if($_action!='add'){                        
                $data['mrcnt_sn']            =$this->input->post('_sn');
            }
            
            
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('inputMerchantName', 'Merchant Name',     'trim|required|max_length[50]|xss_clean');                
            $this->form_validation->set_rules('inputMerchantEmail', 'Merchant Email',   'trim|required|max_length[50]|valid_email|xss_clean');        
            $this->form_validation->set_rules('inputPOSiOSId', 'POSiOS Company ID',     'trim|required|max_length[5]|xss_clean');
            $this->form_validation->set_rules('inputXeroApiKey', 'XERO API KEY',     'trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules('inputXeroApiSecret', 'XERO API SECRET',     'trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules('inputMrcntStartTime', 'Start Time',     'trim|required|max_length[11]|xss_clean');
            $this->form_validation->set_rules('inputMrcntEndTime', 'End Time',     'trim|required|max_length[11]|xss_clean');
            $this->form_validation->set_rules('inputMrcntAutoSync', 'Auto Sync',     'trim|required|max_length[1]|xss_clean');

            $data['mrcnt_name']                 = $this->input->post('inputMerchantName');                
            $data['mrcnt_email']                = $this->input->post('inputMerchantEmail');
            $data['mrcnt_pos_company_id']       = $this->input->post('inputPOSiOSId');        

            $data['mrcnt_xero_api_key']         = $this->input->post('inputXeroApiKey');        
            $data['mrcnt_xero_api_secret']      = $this->input->post('inputXeroApiSecret');

            $data['mrcnt_auto_sync']               = $this->input->post('inputMrcntAutoSync');
            $data['mrcnt_start_time']               = $this->input->post('inputMrcntStartTime');
            $data['mrcnt_end_time']               = $this->input->post('inputMrcntEndTime');
            $data['mrcnt_end_time_is_same_date']               = $this->input->post('inputEndTimeIsSameDay');

            //$date = new DateTime();  
            //$data['addDate']                    = $date->format("Y-m-d H:i:s");
            //$data['user_sn']                    = $this->session->userdata('user_sn');        

            $this->load->model('customer_model');
            
            
       
        if ($this->form_validation->run() == true)
        {             
            $res=false;
                       
            //UPDATE CUSTOMER
            $id     = $this->input->post('_sn');
            
            $res    = $this->customer_model->update($data,$id);                   
                        
            if($res==TRUE){
                redirect('profile');  
            }else{
                //show error message
                echo 'show error message: customer UPDATE operation fail';
            }
            
            
        }//end if
        else{
            
            //echo validation_errors();
            //exit();
             $data=  site_data();
                         
            $data['_error']=  validation_errors();                    
            
            $_action = $this->input->post('_action');                
                                                       
            
            $data['_record'][0]['mrcnt_name']=$this->input->post('inputMerchantName');
            $data['_record'][0]['mrcnt_email']=$this->input->post('inputMerchantEmail');
            $data['_record'][0]['mrcnt_pos_company_id']=$this->input->post('inputPOSiOSId');
            
            $data['_record'][0]['mrcnt_xero_api_key']=$this->input->post('inputXeroApiKey');
            $data['_record'][0]['mrcnt_xero_api_secret']=$this->input->post('inputXeroApiSecret');
            
            
            
            $data['_sn']=$this->input->post('_sn');

            $data['_page_title']='Update Customer';
            $data['_action']='update';                                                                
            
            
        }//end else        
        
            
            
            
            
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
        }
                
    }//end function

    public function edit(){
        
        if($this->session->userdata('is_logged_in')==TRUE &&
                $this->session->userdata('user_type')==2){
        
            $data=  site_data();
            $data['_page_title']='Edit Profile';
            $data['_action']='update';
            $data['_sn']=$this->session->userdata('mrcnt_sn');
            
            
            $this->load->model('customer_model');
            $data['_record']=$this->customer_model->getRecord($data['_sn']);
                                    
            
            $this->template->profile_edit($data);                        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end functoin
    
    public function account_config(){
        
        if($this->session->userdata('is_logged_in')==TRUE &&
                $this->session->userdata('user_type')==2){

                $cust_sn=$this->session->userdata('mrcnt_sn');
                $data=  site_data();
                $data['_page_title']='Account Config';


                $this->load->model('customer_model');
                $data['_record']=$this->customer_model->getRecord($cust_sn);                

                $key=array('consumer_key'=>$data['_record'][0]['mrcnt_xero_api_key'],
                            'shared_secret'=>$data['_record'][0]['mrcnt_xero_api_secret']);


//                CONFIGURE XERO ACCOUNTS
                $this->load->library('Xero',$key);
                $data['_accounts']=$this->xero->getAccounts();
                $data['_categories']=$this->xero->getTrackingCategory();


                $data['_linked_accounts']=$this->customer_model->getLinkAccountList($cust_sn);


                $this->template->customer_config($data); 
            
            
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
        
        
    }//end function
    
    
        
}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */