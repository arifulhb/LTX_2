<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 03 Jul, 2014
 * Time: 11:51 PM
 */

class Posios {

    protected $_ci;

    private $_server_url 	= null;

    private $_api_token		= null;

    private $_email			= null;
    private $_password		= null;
    private $_app_id		= null;
    private $_company_id	= null;


    function __construct($params=null) {

        $this->_ci =&get_instance();

        if(ENVIRONMENT=='development'){
            $this->_server_url='http://dev.posios.com:8080/PosServer/JSON-RPC';
        }elseif(ENVIRONMENT=='testing'){
            $this->_server_url='http://sg1.posios.com:8080/PosServer/JSON-RPC';
        }elseif(ENVIRONMENT=='production'){
            $this->_server_url='http://sg1.posios.com:8080/PosServer/JSON-RPC';
        }

/*        print_r($params[0]);
        echo'<br>';
        echo 'URL: '.$params[0]['url'].'<BR>';*/

        if(count($params)>0){
            //SET THE
            $this->_server_url	= $params[0]['url'];
            $this->_email		= $params[0]['email'];
            $this->_password	= $params[0]['password'];
            $this->_app_id		= $params[0]['appid'];

            $response = $this->connectToPOSiOS();
            $this->_api_token = $response->result;
        }

    }//end constractor


    public function getCompanyId(){

        return $this->_company_id;

    }

    public function setCompanyId($value){
        //echo 'SET COMPANY ID: '.$value.'<BR>';
        $this->_company_id=$value;

    }

    // CONNECT TO POSiOS api server to get apiToken
    private function connectToPOSiOS(){

        $params=array($this->_email,$this->_password,$this->_app_id,"","","","",false,"","");
//        echo '<PRE>connection params';
//        print_r($params);
//        echo '</pre>';

        $response = $this->invoke(1,'posiosApi.getApiToken',$params);

        return $response;

    }//end function


    /*
    *
    */
    public function getPaymentTypes(){

        $params=array($this->_api_token,$this->_company_id);

        $response = $this->invoke(2,'posiosApi.getPaymentTypes',$params);
//        return $response->result;
        return $response;

    }//end function


    public function getReceiptsByDate($from,$to){


        $params=array($this->_api_token,$this->_company_id,$from,$to);

        $response = $this->invoke(3,'posiosApi.getReceiptsByDate',$params);

        return $response;


    }//end function


    public function getCompanies($start,$amount){

        $params=array($this->_api_token,$start,$amount);

        $response = $this->invoke(6,'posiosApi.getCompanies',$params);

        return $response;


    }//end function

    public function getReceiptsByStatus($status){


        $params=array($this->_api_token,$this->_company_id,$status);

        $response = $this->invoke(4,'posiosApi.getReceiptsByStatus',$params);

        return $response;


    }//end function


    public function getApiToken(){

//        echo 'get api token<br>';
        return $this->_api_token;

    }//end function


    public function setApiToken($api_token){

        $this->_api_token=$api_token;

    }//end function


    public function getVersion(){

        $response=$this->invoke(9999,'posiosApi.getVersion',array());

        return $response;

    }


    public function getServerUrl(){

        return $this->_server_url;
    }

    public function setServerUrl($value){

        $this->_server_url=$value;

    }

    /**
     * CALL THE jsonMethod through CURL
     *
     */
    private function invoke($id,$method,$params){

        /*echo('<br>INVOKE ID:'.$id.' METHOD: '.$method.' params: ');
        print_r($params);
        echo 'server url: '.$this->_server_url.'<br>';
        echo "<br><br>";*/
        //$url='http://dev.posios.com:8080/PosServer/JSON-RPC';

        //PREPARE FOR JSON
        $data=array("id"=>$id,
            "method"=>$method,
            "params"=>$params);

        $content=json_encode($data);
        $curl = curl_init($this->_server_url);

        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 5000); //in miliseconds


        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //curl error SSL certificate problem, verify that the CA cert is OK

        $result     = curl_exec($curl);

        /*print_r($result);
        echo '<pre>';
        echo 'show results<br>';*/
        $response   = json_decode($result);


/*        print_r($response);
        echo '</pre>';*/

        curl_close($curl);

        return $response;
        //var_dump($response);


    }//end function invoke



}//end class