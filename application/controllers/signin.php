<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->library('template');

    }//end constractor

    public function index()
    {
      
        $data=  site_data();
        $data['_page_title']='Signin';
        $this->template->admin_login($data);                        

    }//end index
    
     public function signin_validation(){

		 echo "signing in...<br>";

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('user_id', 'User Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('user_pass', 'Password', 'trim|required|xss_clean');
                
        if($this->form_validation->run()==TRUE){

            $data['user_id']=$this->input->post('user_id');
            $data['user_pass']=$this->input->post('user_pass');
            
            $this->load->model('user_model');            
            $user = $this->user_model->signin($data);

             if(count($user)==1){

                 $partner = Array();

                 if($user[0]['user_type']==1){
//                     ADMIN, LOAD DEFAULT PARTNER

                     $partner = $this->user_model->getPartnerRecord(1); //1 is partner_sn 1

                 }else if($user[0]['user_type']==2){
//                     Load User Partner
                     $partner = $this->user_model->getMerchantPartnerRecord($user[0]['mrcnt_sn']);

                 }else{
                     echo "Unexpected data!";
                 }


                $partner_email      = $partner[0]['email'];
                $partner_password   = $partner[0]['password'];
                $app_id             = $partner[0]['applicationid'];
                $posios_server_url  = $partner[0]['api_endpoint'];

//                 echo 'url: '.$posios_server_url.' : '.$partner_email .' | '.$partner_password.' | '.$app_id.'<br>';
                 $params= Array( 'url'      => $posios_server_url,
                                'email'     => $partner_email,
                                'password'  => $partner_password,
                                'appid'     => $app_id
                 );

//                 print_r($params);


                 $lrpc              = new \AppioLab\LRPC\LRPC($params);
                 $lrpc_connection   = $lrpc->connectToLightspeed();

                 if($lrpc_connection['status']==1){
                     $api_token = $lrpc->getApiToken();
                 }else{
                     $api_token='';
                 }
//                $this->load->library('Posios',array($params));
//                $api_token          = $this->posios->getApiToken();

                //pass                                 
                    $user_ses = array(
                            'user_sn'           => $user[0]['user_sn'],
                            'user_id'           => $user[0]['user_email'],
                            'user_name'         => $user[0]['user_name'],
                            'user_type'         => $user[0]['user_type'],   //1 is admin 2 is merchant
                            'mrcnt_sn'          => $user[0]['mrcnt_sn'],     //User mrcnt sn
                            'partner_email'     => $partner[0]['partner_email'],
                            'partner_pass'      => $partner[0]['partner_password'],
                            'application_id'    => $partner[0]['application_id'],
                            'user_pos_cust_id'  => $user[0]['user_role'],
                            'posios_api_token'  => $api_token,
                            'api_endpoint'        => $partner[0]['api_endpoint'],
                            'partner_country'   => $partner[0]['partner_country'],
                            'partner_sn'        => $partner[0]['partner_sn'],
                            'is_logged_in'      => true
                    );

//
//                 print_r($user_ses);
//                 exit();

                    $this->session->set_userdata($user_ses);

                    
                    redirect('admin');
//				 	redirect($_SERVER['HTTP_REFERER']);
            
            }else{
                //Signin Auth fail
                //echo 'signin auth fail';                
                $this->session->set_flashdata('user_id', $data['user_id']);
                $this->session->set_flashdata('notice', 'User or Password does not match!' );
                redirect ('signin');
            }
                                    
            
        }//end run validation
        else{
            //if validatin fail
            echo 'do what to do in validation fail<br>';

			echo validation_errors();
        }//end if validation fail
                                                      
        
    }//end function
    
 
    
}//end class
?>