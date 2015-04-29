<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    
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

            $data['_page_title']='Admin';

            if($this->session->userdata('user_type')==1){
//                ADMIN

                $this->template->admin_home($data);              
                
            }else if($this->session->userdata('user_type')==2){



                $data['_sn']    =$this->session->userdata('mrcnt_sn');
                $this->load->model('customer_model');
                $data['_record']   = $this->customer_model->getRecord($data['_sn']);

                //$data['_merchants']=$this->customer_model->getAllRecords();

                
                $tran_status    =$this->input->get('status');

                if($tran_status!=''){
                    // load the transactions and pagination
                    $mrcnt_sn       =$this->session->userdata('mrcnt_sn');
                    
                    $this->load->library('pagination');
                    $this->load->model('transaction_model');

                    //set pagination configuration
                    $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
                    $config['base_url'] = base_url().'admin/?status='.$tran_status;


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
                
                $this->template->admin_user_home($data);              
            }
                      
        }else{
            //user not logged in
            //redirect to login
            redirect('signin');
            
        }//end else
        
    }//end index

    public function changeserver(){


        if($this->session->userdata('is_logged_in')==TRUE){


            $server_id = $this->input->post("partner_server", true);

            $this->load->model('user_model');
            $partner = $this->user_model->getPartnerRecord($server_id);

            $params= Array( 'url'       => $partner[0]['api_endpoint'],
                            'email'     => $partner[0]['email'],
                            'password'  => $partner[0]['password'],
                            'appid'     => $partner[0]['applicationid']
            );
            $lrpc              = new \AppioLab\LRPC\LRPC($params);
            $lrpc_connection   = $lrpc->connectToLightspeed();

            if($lrpc_connection['status']==1){
                $api_token = $lrpc->getApiToken();
            }else{
                $api_token='';
            }

            $update_apitoken = array(
                'posios_api_token'  => $api_token,
                'api_endpoint'      => $partner[0]['api_endpoint'],
                'partner_country'   => $partner[0]['partner_country'],
                'partner_sn'        => $partner[0]['partner_sn'],
            );

            $this->session->set_userdata($update_apitoken);

            redirect($_SERVER['HTTP_REFERER']);

        }else{
                //user not logged in
                //redirect to login
                redirect('signin');

            }//end else

    }//end function

}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */