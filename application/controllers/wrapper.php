<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wrapper  extends CI_Controller {

    
/*    public function __construct()
    {
           parent::__construct();                        

//            no_cache();

    }//end constractor*/
    
    public function process()
    {
//        $data   = json_decode($this->input->post('mydata'),TRUE);
        $method   = $this->input->post('method');
        $params  = $this->input->post('params');


        $lrpc   = new \AppioLab\LRPC\LRPC();
//        $this->load->library('Posios');

        $api_token  = $this->session->userdata('posios_api_token');
        $api_endpoint = $this->session->userdata('api_endpoint');

        $lrpc->setApiToken($api_token);
        $lrpc->setServerUrl($api_endpoint);



        switch($method){

            case 'getPaymentTypes';

//                $this->posios->setCompanyId($params);

                $lrpc->setCompanyId($params);
                $result = $lrpc->getPaymentTypes();

                echo json_encode($result);
                break;

            case 'getReceiptsByDate';

                $data=explode(',',$params);
                $company_id = $data[0];
                $from       = $data[1];
                $to         = $data[2];

                $lrpc->setCompanyId($company_id);

                $result = $lrpc->getReceiptsByDate($from,$to);
//				@TODO make the result to payment types and count and sent back

                echo json_encode($result);
                break;

			case 'getGroupPaymentTypesByDate';

				$data=explode(',',$params);
				$company_id = $data[0];
				$from       = $data[1];
				$to         = $data[2];

				$lrpc->setCompanyId($company_id);

				$result = $lrpc->getReceiptsByDate($from,$to);

//				echo json_encode($result->result);
//				exit();

				if(isset($result->result)){
					$lstoxero = new \AppioLab\LsToXero\LsToXero();
					$groupPaymentTypes = $lstoxero->getLSPaymentGroupResult($result->result);

//					echo json_encode($groupPaymentTypes);
					$this->session->set_userdata(Array("groupPaymentTypes" => $groupPaymentTypes));

					$this->output
						->set_content_type('application/json')
						->set_output(json_encode($groupPaymentTypes));

				}else{

					$this->output
						->set_content_type('application/json')
						->set_output(json_encode(null));
//					echo json_encode(null);
				}

				break;

				break;
            case 'getCompanies';

                $data=explode(',',$params);
                $start      = $data[0];
                $amount     = $data[1];

                $result = $lrpc->getCompanies($start,$amount);

                echo json_encode($result);
                break;

        }//end switch


        
    }//end index
        
}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */