<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    
    public function __construct()
    {
            parent::__construct();
            
            if($this->session->userdata('is_front_logged_in')==TRUE )
            {
                $this->load->library('template');
            }else{
                redirect('login');
            }            
            no_cache();            

    }//end constractor
    
    public function index(){
               
        if($this->session->userdata('is_front_logged_in')==TRUE){ 
            $data=  site_data();
            $data['_page_title']='New Transaction';
            $this->template->front_home($data);                        
        }else{
            //user not logged in
            //FRONT END LOGIN
            redirect('login');
            
        }//end else
        
        
    }//end function
    
    public function search_member(){
        
        if($this->session->userdata('is_front_logged_in')==TRUE){   
            
            $data=  site_data();
            $data['_page_title']='Search Members';

            $this->template->front_customer_search($data);                        
            
        }else{
              //user not logged in
            //FRONT END LOGIN
            redirect('login');
        }//end else               
        
    }//end function searchMembers()
    
    
    public function past_receipt(){
        
        if($this->session->userdata('is_front_logged_in')==TRUE){
            
            $data=site_data();
            
            $data['_page_title']='Past Receipts';
            
            $this->load->model('subscription_model');
            $data['_list']=$this->subscription_model->getPastReceipts(50);
            
                        
            $this->template->front_past_receipts($data);
            
        }else{
              //user not logged in
            //FRONT END LOGIN
            redirect('login');
        }//end if
        
    }//end function 
    
    public function member(){
        
        if($this->session->userdata('is_front_logged_in')==TRUE){
            
            $data=  site_data();
            $data['_page_title']='Member view';
            $cust_sn=$this->uri->segment(3);
            
            
            $this->load->model('customer_model');
            $data['_record']=$this->customer_model->getRecord($cust_sn);
            $data['_card_ids']=$this->customer_model->getCardListByCustomer($cust_sn);

            $this->load->model('subscription_model');            
            $data['_request_history']=$this->subscription_model->getSubscriptionRequestHistory($cust_sn);
            
            $data['_country']=  getCountry();
            
            $this->template->front_customer_view($data); 
                        
        }else{
            //user not logged in
            //FRONT END LOGIN
            redirect('login');
        }
        
    }//end function

    public function search(){
        
        
        if($this->session->userdata('is_front_logged_in')==TRUE){
            
            $keyword    = trim($this->input->get('s'));
            $search_by  = $this->input->get('by');
            
            $data=  site_data();

          //Load pagination library
            $this->load->library('pagination');

            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            
            $config['base_url'] = base_url().'home/search?by='.$search_by.'&s='.$keyword;
            $this->load->model('customer_model');    

            $config['total_rows'] = $this->customer_model->getTotalSearchNum($keyword,$search_by);//total search result        
            $config['use_page_numbers']=true;
            $config['per_page'] = 20;
            $config['num_links'] = 5;        
            $config['uri_segment'] = 3;                        
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);
            
            $_page=$this->input->get('per_page');

            $data['_total_rows']=$config['total_rows'];                        
                        
            $this->load->model('customer_model');    
            
             if($_page!=''){

                $last=$this->uri->segment(3)*$config['per_page']>$config['total_rows']?$config['total_rows']:$_page*$config['per_page'];                              
                $data['_list']= $this->customer_model->search($keyword,$search_by,$config['per_page'],($config['per_page']*($_page-1)));
            }else{                
                if($config['total_rows']>$config['per_page']){                    
                    $last=$config['per_page'];      
                }else{                    
                    $last=$config['total_rows'];      
                }

              $data['_pagi_msg'] = '1 - '.$last;              

              //$data['_list']=$this->customer_model->getList($config['per_page'],$this->uri->segment(3));
              $data['_list']= $this->customer_model->search($keyword,$search_by,$config['per_page'],$_page);
              
            }//end else
                        
            
           $data['_page_title']='Search Result';
           $this->template->front_customer_search($data);       
              
        }else{            
            redirect('signin');
            
        }//end else
        
    }//end function search

    public function addCustomer(){
        
        if($this->session->userdata('is_front_logged_in')==TRUE){            
            $data=  site_data();
            $data['_page_title']='Add Customer';
            $data['_action']='add';
            $data['_country']=  getCountry();
            $this->template->front_add_customer($data);                        
        }else{
            //user not logged in
            //FRONT END LOGIN
            redirect('login');
            
        }//end else
        
        
    }//end function
    
    public function existingCustomer(){
        
        if($this->session->userdata('is_front_logged_in')==TRUE){            
            $data=  site_data();
            $data['_page_title']='Existing Customer';
            $data['_action']='add';
            $data['_country']=  getCountry();
            $this->template->front_existing_customer($data);                        
        }else{
            //user not logged in
            //FRONT END LOGIN
            redirect('login');
            
        }//end else
        
        
    }//end function
    
        
}//end home