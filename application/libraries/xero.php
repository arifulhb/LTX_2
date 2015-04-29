<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xero
 *
 * @author User
 */
class Xero {
    //put your code here

     //protected $_ci;
    private $initialCheck;
    private $checkErrors;
    private $XeroOAuth;

    function __construct($key_array = null)
    {
		if($key_array != null){

			$this->setKey($key_array);

			/*		$this->_ci =&get_instance();
			$useragent = "XeroOAuth-PHP Private Launchstars App";

			$signatures = array (
				'consumer_key' => $key_array['consumer_key'],//
				'shared_secret' => $key_array['shared_secret'],//
				// API versions
				'core_version' => '2.0',
				'payroll_version' => '1.0'
			);


			//GET CERT KEY FOR SIGNATURE
			$signatures ['rsa_private_key'] = BASE_PATH . 'certs/privatekey.pem';
			$signatures ['rsa_public_key'] = BASE_PATH . 'certs/publickey.cer';


			//XEROOAuth
			include APPPATH . '/third_party/XeroOAuth.php';

			$this->XeroOAuth = new XeroOAuth ( array_merge ( array (
				'application_type' => XRO_APP_TYPE,
				'oauth_callback' => OAUTH_CALLBACK,
				'user_agent' => $useragent
			), $signatures ) );

			$this->initialCheck = $this->XeroOAuth->diagnostics ();

			$this->checkErrors= count ( $this->initialCheck );*/

		}//end if


    }//end construct

	public function setKey($key_array)
	{

		$useragent = "XeroOAuth-PHP Private Launchstars App";

		$signatures = array (
			'consumer_key' => $key_array['consumer_key'],//
			'shared_secret' => $key_array['shared_secret'],//
			// API versions
			'core_version' => '2.0',
			'payroll_version' => '1.0'
		);


		//GET CERT KEY FOR SIGNATURE
		$signatures ['rsa_private_key'] = BASE_PATH . 'certs/privatekey.pem';
		$signatures ['rsa_public_key'] = BASE_PATH . 'certs/publickey.cer';


		//XEROOAuth
		include APPPATH . '/third_party/XeroOAuth.php';

		$this->XeroOAuth = new XeroOAuth ( array_merge ( array (
			'application_type' => XRO_APP_TYPE,
			'oauth_callback' => OAUTH_CALLBACK,
			'user_agent' => $useragent
		), $signatures ) );

		$this->initialCheck = $this->XeroOAuth->diagnostics ();

		$this->checkErrors= count ( $this->initialCheck );




	}//end function



    public function getAccounts(){

        
        $_status=$this->XeroOAuthErrorCheck();

        if($_status['status']==true){


            $oauthSession = retrieveSession ();

            if (isset ( $oauthSession ['oauth_token'] )) {


                $this->XeroOAuth->config ['access_token'] = $oauthSession ['oauth_token'];
                $this->XeroOAuth->config ['access_token_secret'] = $oauthSession ['oauth_token_secret'];

                  if (isset($_REQUEST)){
                        if (!isset($_REQUEST['where'])) $_REQUEST['where'] = "";
                   }

                   if ( isset($oauthSession['oauth_token']) && isset($_REQUEST) ) {

                        $this->XeroOAuth->config['access_token']  = $oauthSession['oauth_token'];
                        $this->XeroOAuth->config['access_token_secret'] = $oauthSession['oauth_token_secret'];
                        $this->XeroOAuth->config['session_handle'] = $oauthSession['oauth_session_handle'];

                        
                        /**
                         * this part is to change in every function
                         */
                        $_result=$this->fetch_xero_accoutns($this->XeroOAuth);

                        //RETURN
                        $_return=array('success'=>TRUE,'result'=>$_result);
                        return $_return;


                    }else{

                        //RETURN                            
                        $_return=array('success'=>FALSE,'result'=>'ERROR: oAuth token not set.');
                        return $_return;
                    }


            }else{
                
                //RETURN                
                $_return=array('success'=>FALSE,'result'=>'Auth session not set');
                return $_return;
            }

        }else{
            //errors
            $_return=array('success'=>FALSE,'result'=>$_status['errors']);
            return $_return;
        }    
    }//end function

    public function getTrackingCategory(){


        $_status=$this->XeroOAuthErrorCheck();

        if($_status['status']==true){


            $oauthSession = retrieveSession ();

            if (isset ( $oauthSession ['oauth_token'] )) {


                $this->XeroOAuth->config ['access_token'] = $oauthSession ['oauth_token'];
                $this->XeroOAuth->config ['access_token_secret'] = $oauthSession ['oauth_token_secret'];

                if (isset($_REQUEST)){
                    if (!isset($_REQUEST['where'])) $_REQUEST['where'] = "";
                }

                if ( isset($oauthSession['oauth_token']) && isset($_REQUEST) ) {

                    $this->XeroOAuth->config['access_token']  = $oauthSession['oauth_token'];
                    $this->XeroOAuth->config['access_token_secret'] = $oauthSession['oauth_token_secret'];
                    $this->XeroOAuth->config['session_handle'] = $oauthSession['oauth_session_handle'];


                    /**
                     * this part is to change in every function
                     */
                    $_result=$this->fetch_xero_tracking($this->XeroOAuth);

                    //RETURN
                    $_return=array('success'=>TRUE,'result'=>$_result);
                    return $_return;


                }else{

                    //RETURN
                    $_return=array('success'=>FALSE,'result'=>'ERROR: oAuth token not set.');
                    return $_return;
                }


            }else{

                //RETURN
                $_return=array('success'=>FALSE,'result'=>'Auth session not set');
                return $_return;
            }

        }else{
            //errors
            $_return=array('success'=>FALSE,'result'=>$_status['errors']);
            return $_return;
        }
    }//end function
    
    /**
     * 
     * CALLED IN customer controller
     * 
     * @param type $xml as invoice xml     
     * @return boolean|string
     */
    public function save($xml, $action){
        
        $_status=$this->XeroOAuthErrorCheck();

        if($_status['status']==true){


            $oauthSession = retrieveSession ();

            if (isset ( $oauthSession ['oauth_token'] )) {


                $this->XeroOAuth->config ['access_token'] = $oauthSession ['oauth_token'];
                $this->XeroOAuth->config ['access_token_secret'] = $oauthSession ['oauth_token_secret'];


                   if ( isset($oauthSession['oauth_token']) && isset($_REQUEST) ) {

                        $this->XeroOAuth->config['access_token']  = $oauthSession['oauth_token'];
                        $this->XeroOAuth->config['access_token_secret'] = $oauthSession['oauth_token_secret'];
                        $this->XeroOAuth->config['session_handle'] = $oauthSession['oauth_session_handle'];

                        
                        /**
                         * this part is to change in every function
                         */
                        

                        //RETURN
                        if($action=='invoice'){
                            $_result=$this->post_xero_invoice($this->XeroOAuth,$xml);
                        }elseif($action=='payment'){
                            $_result=$this->post_xero_payment($this->XeroOAuth,$xml);
                        }
                        
                        $_return=array('success'=>TRUE,'result'=>$_result);
                        
                        return $_return;


                    }else{

                        //RETURN                            
                        $_return=array('success'=>FALSE,'result'=>'ERROR: oAuth token not set.');
                        return $_return;
                    }


            }else{
                
                //RETURN                
                $_return=array('success'=>FALSE,'result'=>'Auth session not set');
                return $_return;
            }

        }else{
            //errors
            $_return=array('success'=>FALSE,'result'=>$_status['errors']);
            return $_return;
        }    
        
    }//end function

    /**
     *
     * @return boolean
     */
    private function XeroOAuthErrorCheck(){

        if($this->checkErrors>0){

            $_errors=array();
            foreach ( $this->initialCheck as $check ) {
                array_push($_errors, $check.PHP_EOL);
                    //echo 'Error: ' . $check . PHP_EOL;
            }//end foreach

            $_status=array('status'=>FALSE,'errors'=>$_errors);

            return $_status;

        }else{
            
            $session = persistSession ( array (
			'oauth_token' => $this->XeroOAuth->config ['consumer_key'],
			'oauth_token_secret' => $this->XeroOAuth->config ['shared_secret'],
			'oauth_session_handle' => '' ) );
            
            $_status=array('status'=>TRUE);
            return $_status;
        }

    }//end function


     private function fetch_xero_accoutns($XeroOAuth){


        if (isset($_REQUEST['accounts'])) {

                $response = $XeroOAuth->request('GET', $XeroOAuth->url('Accounts', 'core'), array('Where' => $_REQUEST['where']));

                if ($XeroOAuth->response['code'] == 200) {
                    $accounts = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                   // echo "There are " . count($accounts->Accounts[0]). " accounts in this Xero organisation, the first one is: </br>";

                    $_result=array('status'=>'ok','result'=>$accounts->Accounts[0]);
                    return $_result;

                } else {

                    //ERROR
                    $_result=array('status'=>'error','result'=>$XeroOAuth);
                    return $_result;
                }
            }//end if
            else{
                $_result=array('status'=>'error','result'=>'accounts $_REQEST is not set.');
                return $_result;

            }//end else

    }//end function

    private function fetch_xero_tracking($XeroOAuth){


//        if (isset($_REQUEST['accounts'])) {

            $response = $XeroOAuth->request('GET', $XeroOAuth->url('trackingcategories', 'core'), array('Where' => $_REQUEST['where']));

            if ($XeroOAuth->response['code'] == 200) {
                $trackingcategories = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
//                echo '<pre>';
//                print_r($trackingcategories->TrackingCategories-);
//                echo '</pre>';
//                 echo "There are " . count($trackingcategories->Accounts[0]). " accounts in this Xero organisation, the first one is: </br>";

                $_result=array('status'=>'ok','result'=>$trackingcategories->TrackingCategories);
                return $_result;

            } else {

                //ERROR
                $_result=array('status'=>'error','result'=>$XeroOAuth);
                return $_result;
            }
//        }//end if
//        else{
//            $_result=array('status'=>'error','result'=>'Tracking Categories $_REQEST is not set.');
//            return $_result;
//
//        }//end else

    }//end function
    
    /**
     * 
     * @param type $XeroOAuth
     */
    private function post_xero_invoice($XeroOAuth,$xml){
        
       // if (isset($_REQUEST['invoice'])) {

                //$response = $XeroOAuth->request('GET', $XeroOAuth->url('Accounts', 'core'), array('Where' => $_REQUEST['where']));
                //$response = $XeroOAuth->request('PUT', $XeroOAuth->url('Invoices', 'core'), array(), $xml);
            
                $response = $XeroOAuth->request('PUT', $XeroOAuth->url('Invoices', 'core'), array(), $xml);
                
                if ($XeroOAuth->response['code'] == 200) {
                    
                    $invoice = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                    
                    //echo "" . count($invoice->Invoices[0]). " invoice created in this Xero organisation.";
                    
                    //if (count($invoice->Invoices[0])>0) {
                        //echo "The first one is: </br>";
                        //pr($invoice->Invoices[0]->Invoice);
                        //outputError($XeroOAuth);
                    //}
                    
                    //$accounts = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                    //echo "There are " . count($accounts->Accounts[0]). " accounts in this Xero organisation, the first one is: </br>";
                    //$_result=array('status'=>'ok','result'=>$accounts->Accounts[0]);
                    
                    $_result=array('status'=>'ok','result'=>$invoice->Invoices[0]);
                    return $_result;

                } else {

                    //ERROR
                    $_result=array('status'=>'error','result'=>$XeroOAuth);
                    return $_result;
                }
            /*}//end if
            else{
                $_result=array('status'=>'error','result'=>'Invoice $_REQEST is not set.');
                return $_result;

            }//end else
            */
        
    }//end function
    
    
    private function post_xero_payment($XeroOAuth,$xml){
        

            $response = $XeroOAuth->request('PUT', $XeroOAuth->url('Payments', 'core'), array(), $xml);

            if ($XeroOAuth->response['code'] == 200) {

                $payments = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);

                $_result=array('status'=>'ok','result'=>$payments->Payments[0]);
                return $_result;

            } else {

                //ERROR
                $_result=array('status'=>'error','result'=>$XeroOAuth);
                return $_result;
            }            
        
    }//end function

}//end class
