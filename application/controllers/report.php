<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

    
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
        
    }//end index
    
    
    
    public function signups(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
            
            $data=  site_data();
            
            $filter=array();
            
            $filter['from']=  $this->input->get('from')!=''?convertMyDate($this->input->get('from')):date('Y-m-d');
            $filter['to']= $this->input->get('to')!=''?convertMyDate($this->input->get('to')):date('Y-m-d');
            $data['filter']=$filter;
            //Load pagination library
            $this->load->library('pagination');

            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            $config['base_url'] = base_url().'report/signups?from='.revertMyDate($filter['from']).'&to='.revertMyDate($filter['to']);
            $this->load->model('customer_model');    

            $config['total_rows'] = $this->customer_model->getTotalNumFilter($filter);        
            $config['use_page_numbers']=true;
            $config['per_page'] = 20;
            $config['num_links'] = 5;        
            $config['uri_segment'] = 3;      
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);


            $data['_total_rows']=$config['total_rows'];
            $_page=$this->input->get('per_page');
            
            if($_page!=''){

                $last=$this->uri->segment(3)*$config['per_page']>$config['total_rows']?$config['total_rows']:$this->uri->segment(3)*$config['per_page'];

                $data['_pagi_msg']=  $_page.' - '.$last;            

                $data['_list']=$this->customer_model->getListFilter($config['per_page'],($config['per_page']*($_page-1)),$filter);
            }else{                
                if($config['total_rows']>$config['per_page']){                    
                    $last=$config['per_page'];      
                }else{                    
                    $last=$config['total_rows'];      
                }

              $data['_pagi_msg'] = '1 - '.$last;              

              $data['_list']=$this->customer_model->getListFilter($config['per_page'],$_page,$filter);
            }          
            
            
            $data['_page_title']='Signup Report';
            $this->template->report_signup($data);                
            
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else                
        
    }//end function
    
    
    public function transactions(){
        
        
        if($this->session->userdata('is_logged_in')==TRUE){
        
            $data=  site_data();
            
            $filter=array();
            
            $filter['from']=  $this->input->get('from')!=''?convertMyDate($this->input->get('from')):date('Y-m-d');
            $filter['to']= $this->input->get('to')!=''?convertMyDate($this->input->get('to')):date('Y-m-d');
            $data['filter']=$filter;
            //Load pagination library
            $this->load->library('pagination');

            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            $config['base_url'] = base_url().'report/transactions?from='.revertMyDate($filter['from']).'&to='.revertMyDate($filter['to']);
            
            $this->load->model('customer_model');    

            $config['total_rows'] = $this->customer_model->getTotalTransectionNum($filter);        
            $config['use_page_numbers']=true;
            $config['per_page'] = 20;
            $config['num_links'] = 5;        
            $config['uri_segment'] = 3;       
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);


            $data['_total_rows']=$config['total_rows'];
            $_page=$this->input->get('per_page');

            if($_page!=''){

                $last=$this->uri->segment(3)*$config['per_page']>$config['total_rows']?$config['total_rows']:$this->uri->segment(3)*$config['per_page'];
                
                $data['_pagi_msg']=  $_page.' - '.$last;           
                $data['_list']=$this->customer_model->getListTransactions($config['per_page'],($config['per_page']*($_page-1)),$filter);
            }else{                
                if($config['total_rows']>$config['per_page']){                    
                    $last=$config['per_page'];      
                }else{                    
                    $last=$config['total_rows'];      
                }

              $data['_pagi_msg'] = '1 - '.$last;              

              $data['_list']=$this->customer_model->getListTransactions($config['per_page'],$_page,$filter);              
            }          
            
            
            $data['_page_title']='Transaction Report';
            $this->template->report_transaction($data);     
            
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else     
        
        
    }//end function
        
}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */