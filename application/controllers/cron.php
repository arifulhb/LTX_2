<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	use AppioLab\LRPC\Lrpc;



	error_reporting(E_ALL);
	ini_set('display_errors', 1);

//	cron run command
//	 php /var/www/html/ls2xero.vi/public_html/cron.php cron/dailyCron

class Cron extends CI_Controller {

//	@TODO update targat date
    private $targetDate         = -2;


    private $xp_mail_address    = 'xp@launchstars.sg';      //xp@launchstars.sg
    private $xp_mail_name       = 'XP Launchstars';         //XP Launchstars

    private $post_success   = Array();
    private $post_fail      = Array();
    private $post_no_receipt= Array();

    public function __construct()
    {
           parent::__construct();

            $this->load->model("customer_model");
            $this->load->model("transaction_model");
            $this->load->model("user_model");

			$this->load->library('Xero');


    }//end constractor

	public function dailyCron(){

        $partners = $this->user_model->getPartners();
		$lstoxero = new \AppioLab\LsToXero\LsToXero();

        foreach($partners as $partner){
//            echo  $partner['partner_sn'].". Country: ".$partner['partner_country'].PHP_EOL;

//            Connect to partner server

            $params['url']      = $partner['api_endpoint'];
            $params['email']    = $partner['email'];
            $params['password'] = $partner['password'];
            $params['appid']    = $partner['applicationid'];

//            print_r($params);

//			Get Merchante
			$merchants = $this->customer_model->getMerchantsByPartner($partner['partner_sn']);


			if(count($merchants)>0){


				$lrpc       = new \AppioLab\LRPC\LRPC($params);


				$connectionStatus   = $lrpc->connectToLightspeed();

				if($connectionStatus['status']==1){

					$apiToken           = $lrpc->getApiToken();
					$lrpc->setApiToken($apiToken);

					foreach($merchants as $merchent){

//						echo "Name: ".$merchent['mrcnt_name'].PHP_EOL;

//						Check if Transaction for target date is available
						$res = $this->transaction_model->checkTransactionStatus($merchent['mrcnt_sn'], date('Y-m-d',strtotime($this->targetDate." days")));

						if(count($res) <= 0){

//                      ORIGINAL DATE TIME FOR THE SYSTEM

							$mrcnt_end_time_is_same_date = $merchent['mrcnt_end_time_is_same_date'];

							$start      = explode(":",$merchent['mrcnt_start_time']);
							$startTime  = mktime($start[0], $start[1], substr($start[2],0,2), date('m'), date('d')+intval($this->targetDate), date('Y'));

							$end        = explode(":",$merchent['mrcnt_end_time']);
							if($mrcnt_end_time_is_same_date == 0){
								$endTime    = mktime($end[0], $end[1], substr($end[2],0,2), date('m'), date('d')+intval($this->targetDate+1), date('Y'));
							}
							else{
								$endTime    = mktime($end[0], $end[1], substr($end[2],0,2), date('m'), date('d')+intval($this->targetDate), date('Y'));
							}


//							Set Company ID
							$lrpc->setCompanyId($merchent['mrcnt_pos_company_id']);

//                        Get Receipt Data from Lightspeed
							$result = $lrpc->getReceiptsByDate($startTime.'000', $endTime.'000');

							if(count($result->result) > 0){

								$key = array(   'consumer_key'  => $merchent['mrcnt_xero_api_key'],
												'shared_secret' => $merchent['mrcnt_xero_api_secret']);

								$times['startTime'] = $startTime;
								$times['endTime']   = $endTime;

								$accounts = $this->customer_model->getMerchantLinkedAccountsBySn($merchent['mrcnt_sn']);


								$paymentGroup       = $lstoxero->getLSPaymentGroupResult($result->result);


								$invoice		= $lstoxero->prepareXeroInvoice($merchent, $accounts, $times, $paymentGroup );
								/*print_r($invoice);
								echo PHP_EOL;*/

								$this->xero->setKey($key);
								$invoice_result = $this->xero->save($invoice['invoice'], 'invoice');

/*								echo "Xero Result".PHP_EOL;
								print_r($result);*/

								if($invoice_result['result']['status']=='ok') {
//                              INVOICE SAVED TO XERO

//                              LIST NAMES OF Merchants for successful transactions
									array_push($this->post_success, Array($merchent['mrcnt_name'], $startTime, $endTime));

									$InvoiceId      = (array)$invoice_result['result']['result']->Invoice->InvoiceID;
									$InvoiceNumber  = (array)$invoice_result['result']['result']->Invoice->InvoiceNumber;


									//SAVE INVOICE TRANSACTION TO DATABASE
									$tran['mrcnt_sn']       = $merchent['mrcnt_sn'];
									$tran['tran_date']      = convertMyDate(date('d-m-Y',$startTime));
									$tran['invoice_number'] = $InvoiceNumber[0];
									$tran['details']		= $invoice['details'];
									$tran['tran_status']    = 'success';
									$tran['tran_mode']      = 'auto';
									$tran['date_added']     = date('Y-m-d H:i:s');
									$tran['update_by']      = '0';// 0 [OR could be 1] = SYSTEM


//			                    ADD TRANSACTION SUCCESS MESSAGE TO DATABASE
									$res = $this->transaction_model->getRecord($tran['mrcnt_sn'],$tran['tran_date']);

									if(count($res)==0){
										$this->transaction_model->insert($tran);
									}else{
										$this->transaction_model->update($tran);
									}


                                $xeroPayment     = $lstoxero->prepareXeroPayment( $InvoiceId[0], $accounts, $times , $paymentGroup );
								$payment_result =  $this->xero->save($xeroPayment, "payment");

                                /*
                                 	echo "PAYMENT Result".PHP_EOL;
                                	print_r($payment_result);
                                	echo PHP_EOL;
                                */

//									echo "Xero Invoice successful ".$InvoiceNumber[0].PHP_EOL;
								}
//								else{
//									Transaction failed
//									echo "XERO Invoice Transaction faild".PHP_EOL;
//								}


								echo PHP_EOL;

							}
							else{

//							============================================
//                          Notice: Payment Receipt not found in POSiOS
//                          ============================================

//  		                NO RESULT FOUND FOR THIS DATE
//                          EMAIL to Merchant about No result found

								array_push($post_no_receipt,Array($merchent['mrcnt_name'],$startTime, $endTime));


								$body   ='<p>Dear '.$merchent['mrcnt_name'].'</p>';
								$body   .='<p>No payment receipt found in POSiOS from '.date('d M, Y - h:i:s a',$startTime).' to '.date('d M, Y - h:i:s a',$endTime).' for your ';
								$body   .='company id ['.$merchent['mrcnt_pos_company_id'].'].</p>';
								$body   .='<p>If you consider this an error in system and there is originally payments made for specified date, ';
								$body   .='please Login to your system in XP App and submit a  manual post to Xero.</p>';
								$body   .='<br><p>Thank You<br>The XP App<br></p>';


								$altBody    ='Dear '.$merchent['mrcnt_name'].'\n';
								$altBody    .='No payment receipt found in POSiOS for the date of '.date('d M, Y - h:i:s a',$startTime).' to '.date('d M, Y - h:i:s a',$endTime).' for your ';
								$altBody    .='company id ['.$merchent['mrcnt_pos_company_id'].'].\n';
								$altBody    .='If you consider this an error in system and there is originally payments made for specified date, please Login to your system in XP App and submit a  manual post to Xero.';
								$altBody    .='Thank You\n The XP App';


								$mail_conf  = Array();

								$mail_conf['to_email']  = $merchent['mrcnt_email'];
								$mail_conf['to_name']   = $merchent['mrcnt_name'];

								$mail_conf['subject']   = 'Notice: Payment Receipt not found in POSiOS for  '.date('d M, Y',$startTime);
								$mail_conf['body']      = $body;
								$mail_conf['altBody']   = $altBody;

								$result = $this->xpmail($mail_conf);

							}//else




						}//end if Transaction check
//

					}//end foreach $merchants

				}
				else{
//                Connection Failure Email
//                @TODO Email to admin about connection failure

				}



			}//end if... merchent found

        }//end foreach




//      #############################################################################################
//      PROCESS ALL SUCCESSFUL AND FAILED TRANSACTIONS AND MAIL TO Launchstars.sg about the cron status.

		$this->transactionProcessStatus(   $this->post_success,
									$this->post_fail,
									$this->post_no_receipt,
									Array(	'address'	=> $this->xp_mail_address,
											'name'		=> $this->xp_mail_name));

//      #############################################################################################


    }//end function


	private function transactionProcessStatus($success, $failed, $no_receipt, $xp_email){


		$mail_body      = 'Dear XP Team<br><br><p>Details of Todays ('.date("l, d M, Y").') XP Cron status:</p><br>';


		if(count($success)>0){

			$success_list   = '<p>List of Successful transactions for <ol>';

			foreach($success as $s){

				$success_list .= '<li>'.$s[0].' from '.date('d M Y - h:i:s a',$s[1]).' to '.date('d M Y - h:i:s a',$s[2]).'</li>';

			}//end foreach

			$mail_body .= $success_list.'</ol></p>';

		}//end if
		else{
			$mail_body .= '<p>No successful transactions found.</p>';
		}

		if(count($failed)>0){

			$failed_list    = '<p>List of Failed transactions for <ol>';

			foreach($failed as $f){

				$failed_list .= '<li>'.$f[0].' from '.date('d M Y - h:i:s a',$f[1]).' to '.date('d M Y - h:i:s a',$f[2]).'</li>';

			}//end foreach

			$mail_body .= $failed_list.'</ol></p>';

		}else{
			$mail_body .= '<p>No failed transactions found.</p>';
		}


		if(count($no_receipt)>0){

			$receipt_list   = '<p>List of Merchants with No Receipt: <ol>';

			foreach($no_receipt as $r){

				$receipt_list .= '<li>'.$r[0].' from '.date('d M Y - h:i:s a',$r[1]).' to '.date('d M Y - h:i:s a',$r[2]).'</li>';

			}//end foreach

			$mail_body .= $receipt_list.'</ol></p>';

		}//end if


		$mail_body  .= '<br><p>This Report is generated at '.date("d M Y - h:i:s a").'</p>';
		$mail_body  .='<p>Thanks<br>XP APP</p>';

		//  Mail Configuration
		$mail_conf=Array();

		$mail_conf['body']      = $mail_body;
		$mail_conf['to_email']  = $xp_email['address'];
		$mail_conf['to_name']   = $xp_email['name'];
		$mail_conf['subject']   = 'XP Cron Status Report for '.date('l, d M, Y');


//		print_r($mail_conf['body']);
//		echo PHP_EOL;
		$res = $this->xpmail($mail_conf);


	}//end function



	/**
	 *
	 * Common Mail Function for emailing service
	 *
	 * @param $mail_conf
	 * @return bool
	 * @throws Exception
	 * @throws phpmailerException
	 */
    private function xpmail($mail_conf){



		//      INITILIZE MAILER
		$mail = new PHPMailer;

		//      EMAIL TO XP APP support about error
		$from_email = 'mail@p2xero.com';
		$from_name  = 'XP App';

		$mail->isSMTP();
		$mail->Host = 'mail.emailsrvr.com';                         // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                                     // Enable SMTP authentication
		$mail->Username = 'mail@p2xero.com';                        // SMTP username
		$mail->Password = 'aidi9639';                               // SMTP password
		//    $mail->SMTPSecure = 'tls';                                // Enable encryption, 'ssl' also accepted



		//        TO
		$mail->addAddress($mail_conf['to_email'],$mail_conf['to_name']);
		//        FROM
		$mail->setFrom($from_email,$from_name);

		//        ReplyTo
		$mail->addReplyTo($from_email,$from_name);

		//        BCC
		if (array_key_exists('bcc_email', $mail_conf)) {
			$mail->addBCC($mail_conf['bcc_email'],$mail_conf['bcc_name']);
		}

		$mail->Subject  = $mail_conf['subject'];

		$mail->Body     = $mail_conf['body'];

		if (array_key_exists('altBody', $mail_conf)) {
			$mail->AltBody     =$mail_conf['altBody'];
		}


//        echo 'MAIL SUBJECT: '.$mail->Subject.PHP_EOL;
		$mail->isHTML(true);


		$result = $mail->send();
//		$result = false;

//        echo 'MAIL STATUS: '.$result. ' SENT TO: '.$mail_conf['to_email'].PHP_EOL;
		unset($mail);

		return $result;



    }//end function

    

        
}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */