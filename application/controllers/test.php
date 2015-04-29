<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

    
    public function __construct()
    {
           parent::__construct();

    }//end constractor
    
    public function index()
    {

        $param['url'] = 'http://au1.posios.com:8080/PosServer/JSON-RPC';
        $param['email'] = 'as@launchstars.sg';
        $param['password'] = 'aidi9639';
        $param['appid'] = 'test';

        $lrpc = new \AppioLab\LRPC\LRPC($param);

        $response = $lrpc->connectToLightspeed();

        print_r($response);
                
        echo "test controller";
        
    }//end index
        
}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */