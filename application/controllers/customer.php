<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();
            
            if(($this->session->userdata('is_logged_in')==TRUE) ||
                ($this->session->userdata('is_front_logged_in')==TRUE))
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
            
          //Load pagination library
            $this->load->library('pagination');

            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            $config['base_url'] = base_url().'customer/index';
            $this->load->model('customer_model');    

            $config['total_rows'] = $this->customer_model->getTotalNum();        
            $config['use_page_numbers']=true;
            $config['per_page'] = 20;
            $config['num_links'] = 5;        
            $config['uri_segment'] = 3;                        
            $this->pagination->initialize($config);


            $data['_total_rows']=$config['total_rows'];

            if($this->uri->segment(3)!=''){

                $last=$this->uri->segment(3)*$config['per_page']>$config['total_rows']?$config['total_rows']:$this->uri->segment(3)*$config['per_page'];

                $data['_pagi_msg']=  (($this->uri->segment(3)-1)*($config['per_page']+1)).' - '.$last;            

                $data['_list']=$this->customer_model->getList($config['per_page'],($config['per_page']*($this->uri->segment(3)-1)));
            }else{                
                if($config['total_rows']>$config['per_page']){                    
                    $last=$config['per_page'];      
                }else{                    
                    $last=$config['total_rows'];      
                }

              $data['_pagi_msg'] = '1 - '.$last;              

              $data['_list']=$this->customer_model->getList($config['per_page'],$this->uri->segment(3));
            }
            
            $data['_page_title']='Merchant';
            $this->template->customer_index($data);                
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end index
    
    public function search(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
            
            $keyword    = $this->input->get('s');
            $search_by  = $this->input->get('by');
            
            $data=  site_data();

          //Load pagination library
            $this->load->library('pagination');

            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            
            $config['base_url'] = base_url().'customer/search?by='.$search_by.'&s='.$keyword;
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
           $this->template->customer_index($data);       
              
        }else{            
            redirect('signin');
            
        }//end else
    }//end function
    
    public function add(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
            $data=  site_data();
            $data['_page_title']='Add New Customer';
            $data['_action']='add';            

            $this->template->customer_add($data);                        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    
    public function edit(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
        
            $data=  site_data();
            $data['_page_title']='Edit Merchant';
            $data['_action']='update';
            $data['_sn']=$this->uri->segment(3);
            
            
            $this->load->model('customer_model');
            $data['_record']=$this->customer_model->getRecord($data['_sn']);
                                    
            
            $this->template->customer_edit($data);                        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
    }//end function
    
    
   
    /**
     * VIEW CUSTOMER DATA
     */
    public function view(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
 
            $data=  site_data();                        
            $data['_page_title']='Merchant Details';
            
            
            $data['_sn']=$this->uri->segment(3);
            $this->load->model('customer_model');
            $data['_record']=$this->customer_model->getRecord($data['_sn']);                                   
            $data['_linked_accounts']=$this->customer_model->getLinkAccountList($data['_sn']);

            $this->load->model('transaction_model');
            $data['_transactions']=$this->transaction_model->getAllRecordsByMerchantSn($data['_sn'],10,0);
            
            $this->template->customer_view($data);  
            
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    
    /**
     * 
     */
    public function show_all_transactions(){
        
        
        if($this->session->userdata('is_logged_in')==TRUE){
 
            $data=  site_data();                        
            $data['_page_title']='Merchant Show All Transactions';
            
            
            $data['_sn']=$this->uri->segment(3);
            $this->load->model('customer_model');
            $data['_record']=$this->customer_model->getRecord($data['_sn']);                                               

            $this->load->model('transaction_model');
            //$data['_transactions']=$this->transaction_model->getAllRecordsByMerchantSn($data['_sn'],10);
                        
            //Load pagination library
            $this->load->library('pagination');
            
            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            $config['base_url'] = base_url().'merchant/view/'.$data['_sn'].'/all-transactions';
            

            $config['total_rows'] = $this->transaction_model->getTotalNumByMrchangeSn($data['_sn']);        
            
            $config['use_page_numbers']=true;
            $config['per_page'] = 30;
            $config['num_links'] = 5;        
            $config['uri_segment'] = 5;                        
            
            $this->pagination->initialize($config);

            
            $data['_total_rows']=$config['total_rows'];
            
            //echo 'sg5: '.$this->uri->segment(5);
            if($this->uri->segment(5)!=''){
                
                $data['_transactions']=$this->transaction_model->getAllRecordsByMerchantSn($data['_sn'],$config['per_page'],($config['per_page']*($this->uri->segment(5)-1)));                
            }else{                
                
              $data['_transactions']=$this->transaction_model->getAllRecordsByMerchantSn($data['_sn'],$config['per_page'],$this->uri->segment(5));
              //$data['_list']=$this->customer_model->getList();
            }
            
            //print_r($data['_transactions']);
            //exit();
            $this->template->customer_transactions($data);  
            
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end functions

    /**
     * SAVE A CUSTOMER
     */
    public function save(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
            
        $this->load->library('form_validation');
        
        $_action = $this->input->post('_action');                
                               
        if($_action!='add'){                        
            $data['mrcnt_sn']            =$this->input->post('_sn');
        }

        $this->form_validation->set_rules('inputMerchantName', 'Merchant Name',     'trim|required|max_length[50]|xss_clean');                
        $this->form_validation->set_rules('inputMerchantEmail', 'Merchant Email',   'trim|required|max_length[50]|valid_email|xss_clean');        
        $this->form_validation->set_rules('inputPOSiOSId', 'POSiOS Company ID',     'trim|required|max_length[5]|xss_clean');
        $this->form_validation->set_rules('inputXeroApiKey', 'XERO API KEY',     'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('inputXeroApiSecret', 'XERO API SECRET',     'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('inputMrcntStatus', 'Merchant Status',     'trim|max_length[255]|xss_clean');

        $this->form_validation->set_rules('inputMrcntStartTime', 'Start Time',     'trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('inputMrcntEndTime', 'End Time',     'trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('inputMrcntAutoSync', 'Auto Sync',     'trim|required|max_length[1]|xss_clean');

        $data['mrcnt_name']                 = $this->input->post('inputMerchantName');                
        $data['mrcnt_email']                = $this->input->post('inputMerchantEmail');
        $data['mrcnt_pos_company_id']       = $this->input->post('inputPOSiOSId');        
        
        $data['mrcnt_xero_api_key']         = $this->input->post('inputXeroApiKey');        
        $data['mrcnt_xero_api_secret']      = $this->input->post('inputXeroApiSecret');

        $data['mrcnt_status']               = $this->input->post('inputMrcntStatus');
        $data['mrcnt_auto_sync']               = $this->input->post('inputMrcntAutoSync');

        $data['mrcnt_start_time']               = $this->input->post('inputMrcntStartTime');
        $data['mrcnt_end_time']               = $this->input->post('inputMrcntEndTime');
        $data['mrcnt_end_time_is_same_date']               = $this->input->post('inputEndTimeIsSameDay');



        $data['partner_sn']               	= $this->input->post('inputMrcntServer');
        $data['mrcnt_xero_lineAmount']      = $this->input->post('inputXeroLineAmount');


        $date = new DateTime();
        $data['addDate']                    = $date->format("Y-m-d H:i:s");
        $data['user_sn']                    = $this->session->userdata('user_sn');        
        
        $this->load->model('customer_model');
        
       
        if ($this->form_validation->run() == true)
        {             
            $res=false;
            
            if($_action=='add'){
                $res= $this->customer_model->insert($data); 
                
                
                if($res['status']==TRUE){
                    
                    //CREATE NEW USER FOR THE MERCHANT
                    $this->load->model('user_model');
                    $user['user_name']  = $data['mrcnt_name'];
                    $user['user_email'] = $data['mrcnt_email'];
                    $user['user_pass']  = md5($data['mrcnt_email']);
                    $user['user_type']  = 2;
                    $user['mrcnt_sn'] = $res['new_id'];

                    $this->user_model->insert($user);
                    
                    redirect('merchant/view/'.$res['new_id']);
                }else{
                    //show error message
                    echo 'show error message: customer add operation fail';
                }
                
            }else{
                //UPDATE CUSTOMER
                $id=$this->input->post('_sn');
                $res=$this->customer_model->update($data,$id);                   
                if($res==TRUE){
                    redirect('merchant/view/'.$id);
                }else{
                    //show error message
                    echo 'show error message: customer UPDATE operation fail';
                }
            }//end else
            
        }//end if
        else{
            
            //echo validation_errors();
            //exit();
             $data=  site_data();
             
            //echo 'error: '.  validation_errors();
            $data['_error']=  validation_errors();                    
            
            $_action = $this->input->post('_action');                
                               
            if($_action!='add'){                                            
                $data['_record'][0]['mrcnt_sn']=$this->input->post('_sn');
            }
            
            
            $data['_record'][0]['mrcnt_name']=$this->input->post('inputMerchantName');
            $data['_record'][0]['mrcnt_email']=$this->input->post('inputMerchantEmail');
            $data['_record'][0]['mrcnt_pos_company_id']=$this->input->post('inputPOSiOSId');
            
            $data['_record'][0]['mrcnt_xero_api_key']=$this->input->post('inputXeroApiKey');
            $data['_record'][0]['mrcnt_xero_api_secret']=$this->input->post('inputXeroApiSecret');
            
            
            if($_action=='add'){
                $data['_page_title']='Add New Customer';
                $data['_action']='add';                                                
                $this->template->customer_add($data);  
            }else{
                
                $data['_sn']=$this->input->post('_sn');
                
                $data['_page_title']='Update Customer';
                $data['_action']='update';                                                                
            }
            
        }//end else        
        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    
    public function delete(){
        if($this->session->userdata('is_logged_in')==TRUE){
        
            $data['_sn']=$this->input->post('_sn');        
            $this->load->model('customer_model');
            $res= $this->customer_model->delete($data['_sn']);

            echo $res;
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
    }//end function
    
   

    /**
     * SET POSiOS api token into cookie
     */
    public function setApiTokenAjax(){
        
        $use_sn=$this->session->userdata('user_sn');
        $data['tmpTokenId']=$this->input->post('_api_token');
        
        $this->load->model('user_model');
        
        $res = $this->user_model->setToken($use_sn,$data);
        
        
        $cookie_partner_apitoken = array('name'   => 'pos_api_token','value'  => $data['tmpTokenId'],
                'expire' => 0,'path'   => '/','prefix' => 'posios2xero_');                    

        $this->input->set_cookie($cookie_partner_apitoken);
        
        
        echo $res;
        
        
    }//end function
    
    
    /**
     * Page to configure POSiOS and XERO accounts
     * 
     * 
     * TASK 1: GET ALL XERO accounts on LOAD and list in a Listbox
     * TASK 2: GET ALL POSiOS ACCOUNTS AND LIST IN A LIST,
     * TASK 3: Match both account in a new list box
     * TASK 4: SAVE the list, 
     *          Also make it Editable
     * 
     */
    public function account_config(){
        
        $cust_sn=$this->uri->segment(3);
        $data=  site_data();                
        $data['_page_title']='Customer Account Config';
        
        
        $this->load->model('customer_model');
        $data['_record']=$this->customer_model->getRecord($cust_sn);                
        
        $key=array('consumer_key'=>$data['_record'][0]['mrcnt_xero_api_key'],
                    'shared_secret'=>$data['_record'][0]['mrcnt_xero_api_secret']);
        

        $this->load->library('Xero',$key);
        $data['_accounts']=$this->xero->getAccounts();

        $data['_categories']=$this->xero->getTrackingCategory();


        $data['_linked_accounts']=$this->customer_model->getLinkAccountList($cust_sn);
        
                
        $this->template->customer_config($data);  
        
    }//end function
    
    /**
     * Receive POST data from jquery ajax and save to database 
     * sent sucess/fail result to ajax request
     */
    public function addAccountConfigAjax(){
        
        $this->load->library('form_validation');
        //SET VALIDATION RULES
        
        $this->form_validation->set_rules('_pos_name', 'POSiOS Payment Type Name', 'required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('_pos_sec', 'POSiOS Sequence', 'required|max_length[4]|xss_clean');
        $this->form_validation->set_rules('_pos_oid', 'POSiOS OID', 'required|max_length[5]|xss_clean');
        $this->form_validation->set_rules('_pos_type_id', 'POSiOS TypeId', 'required|max_length[10]|xss_clean');

        $this->form_validation->set_rules('_xero_name', 'XERO Account Name', 'required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('_xero_acc_id', 'XERO Account ID', 'required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('_xero_code_id', 'XERO Code ID', 'required|max_length[6]|xss_clean');
        
        $this->form_validation->set_rules('_mrcnt_sn', 'Merchant SN', 'required|numeric|xss_clean');

        $this->form_validation->set_rules('_acc_link_type', 'Link Type', 'required|numeric|xss_clean');

        if($this->form_validation->run()){
            //FORM VALIDATION PASS
            
            //prepare data here            
            
            $data['mrcnt_sn']               = $this->input->post('_mrcnt_sn');
            
            $data['pos_payment_type_name']  = $this->input->post('_pos_name');
            $data['pos_payment_type_oid']   = $this->input->post('_pos_oid');
			$data['pos_payment_type_id']    = $this->input->post('_pos_type_id');
            $data['pos_payment_type_sequence']= $this->input->post('_pos_sec');
            
            $data['xero_account_id']        = $this->input->post('_xero_acc_id');
            $data['xero_account_name']      = $this->input->post('_xero_name');
            $data['xero_code_id']           = $this->input->post('_xero_code_id');


            $data['acc_link_type']           =$this->input->post('_acc_link_type');

            $this->load->model('customer_model');
            $res=$this->customer_model->insertAccount($data);
            if($res['status']==true){
                echo $res['new_id'];
            }else{
                echo FALSE;
            }            
            
        }else{
            //validation fail            
            echo validation_errors();
        }
                
        
    }//end function


    /**
     * This function is to remove linked account
     * 
     * call from customer_config.js
     */
    public function removeaccajax(){
        
        $this->load->library('form_validation');
        //SET VALIDATION RULES
        
        $this->form_validation->set_rules('accsn', 'Account SN', 'required|numeric|xss_clean');        
        if($this->form_validation->run()){
            
            
            $this->load->model('customer_model');
            $accsn      = $this->input->post('accsn');            
            
            $res=$this->customer_model->remove_linked_account($accsn);
            
            echo $res;
            
        }else{
            echo 'ERROR IN FUNCTION';
        }
        
    }//end function
    
    /**
     * Show Daily Report
     * 
     */
    public function daily_report(){
        
        if($this->session->userdata('is_logged_in')==TRUE){

            $data=site_data();
            $data['_sn']=$this->uri->segment(3);        
            $this->load->model('customer_model');
            $data['_record']=$this->customer_model->getRecord($data['_sn']);
        
            $data['_page_title']='Merchant Daily Report';
            $this->template->customer_daily_report($data);   
            
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    
    /**
     * 
     * CALLED FROM customer_daily_report.js
	 *
	 * @Depricated
     */
    public function post_manual_to_xero(){
       
        $data   = json_decode($this->input->post('receipts'),TRUE);
        $_date  = json_decode($this->input->post('_date'));
        
        $this->load->model('transaction_model');                                
        $this->load->model('customer_model');


        if($this->session->userdata('user_type')==1)
        {
            //ADMIN
            $accounts=$this->customer_model->getMerchantLinkedAccountsBySn($this->uri->segment(3));
        }elseif($this->session->userdata('user_type')==2){
            //USER
            $accounts=$this->customer_model->getMerchantLinkedAccountsBySn($this->session->userdata('mrcnt_sn'));
        }

        $key=array( 'consumer_key'  => $accounts[0]['xero_api_key'],
                    'shared_secret' => $accounts[0]['xero_api_secret']);


        $mrcnt_xero_revenew_code_id = $accounts[0]['mrcnt_xero_revenew_code_id'];
        $mrcnt_xero_tc_id           = $accounts[0]['mrcnt_xero_tc_id'];
        $mrcnt_xero_tc_name         = $accounts[0]['mrcnt_xero_tc_name'];
        $mrcnt_xero_tc_group_name   = $accounts[0]['mrcnt_xero_tc_group_name'];
        $tran['details']='';
        
        $invoices="<Invoices>";
        $invoices.="<Invoice>";
        
//        TYPE
//          ACCPAY (A bill – commonly known as a Accounts Payable or supplier invoice),
//          ACCREC (A sales invoice – commonly known as an Accounts Receivable or customer invoice)
        $invoices.="<Type>ACCREC</Type>"; 

//        Status [DRAFT, SUBMITTED, DELETED, AUTHORISED, PAID, VOIDED]
        $invoices.="<Status>AUTHORISED</Status>";
        $invoices.="<Contact>";
        $invoices.="<Name>".$accounts[0]['mrcnt_name']."</Name>";
        $invoices.="</Contact>";
        $invoices.="<Date>".convertMyDate($_date)."T00:00:00</Date>";
        $invoices.="<DueDate>".convertMyDate($_date)."T00:00:00</DueDate>";


        //REFERENCE
//        $invoices.="<Reference>Daily Sales: ".$mrcnt_name."</Reference>";
        $invoices.="<Reference>Daily Sales</Reference>";

        $_total = 0;

//      $lines FOR INVOICE LINE ITEMS;
        $lines  =   '';

        foreach($accounts as $acc):

            //inner loop to match cid
            foreach($data as $row):

//                if acc_link_type = 1 then SUM total
//                  elseif acc_link_type = 2 then add item to $lines;
                if( $acc['acc_link_type']==1 &&
                    $row['id']==$acc['pos_payment_type_oid'] &&
                    $row['amount']>0 ){

//                  PAYMENT ITEM SUM
//                    DETAILS TEXT to save as description
                    $tran['details'].= $acc['pos_payment_type_name'].' '.number_format($row['amount'],2,'.',',').'<br>';

                    $_total += $row['amount'];

                }// end inner for*/
                elseif($acc['acc_link_type'] == 2 &&
                    $row['id']==$acc['pos_payment_type_oid']){

//                    INVENTORY ITEM
                    $lines.="<LineItem>";
                    $lines.='<Description>'.$acc['xero_account_name'].'</Description>';
                    $lines.="<Quantity>1</Quantity>";

//                    $unit_amount= number_format((-1 * $row['amount']),2,'.',',');
                    $unit_amount= (-1 * $row['amount']);
                    $lines.="<UnitAmount>".$unit_amount."</UnitAmount>";

                    $lines.='<LineAmount>'.$unit_amount.'</LineAmount>';

//                    $lines.="<AccountCode>".$acc['mrcnt_xero_revenew_code_id'].'</AccountCode>';
//                    $lines.="<AccountCode>".$acc['xero_account_id'].'</AccountCode>';
                    $lines.="<AccountCode>".$acc['xero_code_id'].'</AccountCode>';
                    $lines.="</LineItem>";

                    unset($unit_amount);

                }//END IF


            endforeach;

        endforeach;

//        TAX = 1.075%

        $tran['details'].='Total: '.number_format($_total,2,'.',',').'<br>';

//        LineAmount Types [Exclusive, Inclusive, NoTax]
        $invoices.='<LineAmountTypes>Inclusive</LineAmountTypes>';
        $invoices.="<LineItems>";


        $item="<LineItem>";
        $item.='<Description>'.$acc['mrcnt_name'].' Sales</Description>';
        $item.="<Quantity>1</Quantity>";
//        $item.="<UnitAmount>".($_total-$tax)."</UnitAmount>";
        $item.="<UnitAmount>".$_total."</UnitAmount>";


        $item.='<LineAmount>'.$_total.'</LineAmount>';

        $item.="<AccountCode>".$mrcnt_xero_revenew_code_id.'</AccountCode>';

//        $tc=false;
//        IF TrackingCategory is selected, than use TrackingCategory
        if(strlen($mrcnt_xero_tc_id)>1 ){

            $item.='<Tracking>';
            $item.='<TrackingCategory>';
            $item.='<TrackingCategoryID>'.$mrcnt_xero_tc_id.'</TrackingCategoryID>';
            $item.='<Name>'.$mrcnt_xero_tc_group_name.'</Name>';
            $item.='<Option>'.$mrcnt_xero_tc_name.'</Option>';
            $item.='</TrackingCategory>';
            $item.='</Tracking>';

        }//end if

        $item.="</LineItem>";

        $item.=$lines;

        $item.='</LineItems>';

        $invoices.=$item;

        $invoices.="</Invoice>";
        $invoices.="</Invoices>";


        //SAVE AN INVOICE TO XERO
        $this->load->library('Xero',$key);
        $result=$this->xero->save($invoices,'invoice');
        
        //INVOICE SAVE STATUS CHECK
        if($result['result']['status']=='ok'){
            
                //INVOICE ID
                $InvoiceId      = (array)$result['result']['result']->Invoice->InvoiceID;
                $InvoiceNumber  = (array)$result['result']['result']->Invoice->InvoiceNumber;
            
                //SAVE INVOICE TRANSACTION TO DATABASE
                
                $tran['mrcnt_sn']       = $this->uri->segment(3);
                $tran['tran_date']      = convertMyDate($_date);
                $tran['date_added']     = date('Y-m-d H:i:s');
                $tran['tran_status']    = 'success';
                $tran['invoice_number'] = $InvoiceNumber[0];
                $tran['tran_mode']      = 'auto';
                $tran['update_by']      = 0;
                
                
                //INSERT or UPDATE
                //CONDITION = if
                
                // checkTransactionStatus search on NON sucess transactions only                
                $res=$this->transaction_model->getRecord($tran['mrcnt_sn'],$tran['tran_date']);
                if(count($res)==0){
                    $this->transaction_model->insert($tran);
                }else{
                    $this->transaction_model->update($tran);
                }
                

                //CREATE PAYMENTS IN BATCH
                $paymentXml='<Payments>';


                foreach($accounts as $acc):
                    
                    foreach($data as $row):

                        if( $acc['acc_link_type']==1 &&
                            $row['id']==$acc['pos_payment_type_oid'] &&
                            $row['amount']>0 ){

                            $paymentXml.='<Payment>';
                            $paymentXml.='<Invoice><InvoiceID>'.$InvoiceId[0].'</InvoiceID></Invoice>';
                            $paymentXml.='<Account><Code>'.$acc['xero_code_id'].'</Code></Account>';
                            $paymentXml.='<Date>'.convertMyDate($_date).'T00:00:00</Date>';
                            $paymentXml.='<Reference>'.$acc['mrcnt_name']. ' - ' . $acc['pos_payment_type_name'].': '.$acc['pos_payment_type_oid'].'</Reference>';
                            //$paymentXml.='<CurrencyRate>1.00</CurrencyRate>';

                            $paymentXml.='<Amount>'.($row['amount']).'</Amount>';

                            $paymentXml.='</Payment>';
                        }

                    endforeach;
                    
                endforeach;
                                
                $paymentXml.='</Payments>';

                
           //SAVE A PAYMENT TO XERO
           $PaymentResult=$this->xero->save($paymentXml,'payment');
           
           //PAYMENT SAVE STATUS CHECK
            if($PaymentResult['result']['status']=='ok'){

                //print_r(Array($InvoiceId[0],$InvoiceNumber[0]));        
                $PaymentId=(array)$PaymentResult['result']['result']->Payment->PaymentID;
                echo json_encode(Array( 'Invoice_status'=>'ok',
                                        'InvoicdId'=>$InvoiceNumber[0],
                                        'payment_status'=>'ok',
                                        'PaymentId'=>$PaymentId[0]));
            }else{

//                PAYMENT NOT UPDATED. MAKE A NOTE IN DATABASE.
                $error_xml  = simplexml_load_string($PaymentResult['result']['result']->response['response']);


                $note['note']           ='Incomplete Invoice! Payment Processing Failed. Please look at XERO for manual update';
                $note['mrcnt_sn']       =$tran['mrcnt_sn'];
                $note['tran_date']      =$tran['tran_date'];

                $this->transaction_model->updateNote($note);

                echo json_encode(Array( 'Invoice_status'=>'ok',
                                        'InvoiceId'=>$InvoiceNumber[0],
                                        'payment_status'=>'failed',
                                        'error_type'=>$error_xml->Type,
                                        'error_type_message'=>$error_xml->Message,
                                        'paymentError'=>$error_xml->Elements
                ));
            }

                
        }else{
//            ERROR IN XERO. TRANSACTION WAS UNSUCCESSFUL

            $error_xml  = simplexml_load_string($result['result']['result']->response['response']);

            echo json_encode((Array('Invoice_status'=>'failed',
                                    'error_type'=>$error_xml->Type,
                                    'error_type_message'=>$error_xml->Message,
                                    'message'=>$error_xml->Elements
            )));
//            echo json_encode((Array('Result'=>$invoices)));
        }
        
        
        //echo $invoices;
        
    }//end functon

	/**
	 *
	 *
	 */
	public function post_to_xero(){

//		$data   = json_decode($this->input->post('receipts'),TRUE);
//		$_date  = json_decode($this->input->post('_date'));

		$this->load->model('transaction_model');
		$this->load->model('customer_model');


		$mrcnt_sn = '';
		if($this->session->userdata('user_type')==1)
		{
			//ADMIN
			$mrcnt_sn	= $this->uri->segment(3);
			$accounts=$this->customer_model->getMerchantLinkedAccountsBySn($this->uri->segment(3));
		}elseif($this->session->userdata('user_type')==2){
			//USER
			$mrcnt_sn = $this->session->userdata('mrcnt_sn');
			$accounts=$this->customer_model->getMerchantLinkedAccountsBySn($this->session->userdata('mrcnt_sn'));
		}

		$merchents = $this->customer_model->getRecord($mrcnt_sn);
		$merchent = $merchents[0];


		$times = Array(
					"startTime"	=> $this->input->post("startFrom"),
					"endTime"	=> $this->input->post("startTo")
					);

//		echo date("Y-m-d",substr($times['startTime'],0,10));
////		echo date("d M Y",substr($times['startTime'],0,10));
//		exit();


		$key=array( 'consumer_key'  => $accounts[0]['xero_api_key'],
			'shared_secret' => $accounts[0]['xero_api_secret']);

		$this->load->library('Xero',$key);


		$groupPaymentTypes = $this->session->userdata('groupPaymentTypes');


		//SAVE AN INVOICE TO XERO
		$lstoxero = new \AppioLab\LsToXero\LsToXero();


		/*echo json_encode(
			Array(	"date" => $lstoxero->convertMyDate(date('d-m-Y', substr($times['startTime'],0, 10))),
					"time" =>  substr($times['startTime'],0, 10)
			));
		exit();*/

		$xeroInvoice = $lstoxero->prepareXeroInvoice($merchent, $accounts, $times, $groupPaymentTypes);

/*		$xeroInvoice;
		echo json_encode((Array('invoice'=>$xeroInvoice)));
		exit();*/

		$result = $this->xero->save($xeroInvoice ['invoice'],'invoice');

		//INVOICE SAVE STATUS CHECK
		if($result['result']['status']=='ok'){

			//INVOICE ID
			$InvoiceId      = (array)$result['result']['result']->Invoice->InvoiceID;
			$InvoiceNumber  = (array)$result['result']['result']->Invoice->InvoiceNumber;

			//SAVE INVOICE TRANSACTION TO DATABASE

			$tran['mrcnt_sn']       = $this->uri->segment(3);
			$tran['tran_date']      = date("Y-m-d",substr($times['startTime'],0,10));
//			$tran['tran_date']      = date("d M Y",substr($times['startTime'],0,10));

			$tran['date_added']     = date('Y-m-d H:i:s');
			$tran['details']     	= $xeroInvoice['details'];

			$tran['tran_status']    = 'success';
			$tran['invoice_number'] = $InvoiceNumber[0];
			$tran['tran_mode']      = 'manual';
			$tran['update_by']      = 0;


			//INSERT or UPDATE
			//CONDITION = if

			// checkTransactionStatus search on NON sucess transactions only
			$res=$this->transaction_model->getRecord($tran['mrcnt_sn'],$tran['tran_date']);
			if(count($res)==0){
				$this->transaction_model->insert($tran);
			}else{
				$this->transaction_model->update($tran);
			}


			//CREATE PAYMENTS IN BATCH
			$xeroPayment     = $lstoxero->prepareXeroPayment( $InvoiceId[0], $accounts, $times , $groupPaymentTypes );
			$payment_result =  $this->xero->save($xeroPayment, "payment");


			//PAYMENT SAVE STATUS CHECK
			if($payment_result['result']['status']=='ok'){

				//print_r(Array($InvoiceId[0],$InvoiceNumber[0]));
				$PaymentId=(array)$payment_result['result']['result']->Payment->PaymentID;
				echo json_encode(Array( 'Invoice_status'=>'ok',
					'InvoicdId'=>$InvoiceNumber[0],
					'payment_status'=>'ok',
					'PaymentId'=>$PaymentId[0]));
			}else{

//                PAYMENT NOT UPDATED. MAKE A NOTE IN DATABASE.
				$error_xml  = simplexml_load_string($payment_result['result']['result']->response['response']);


				$note['note']           ='Incomplete Invoice! Payment Processing Failed. Please look at XERO for manual update';
				$note['mrcnt_sn']       =$tran['mrcnt_sn'];
				$note['tran_date']      =$tran['tran_date'];

				$this->transaction_model->updateNote($note);

				echo json_encode(Array( 'Invoice_status'	=>'ok',
										'InvoiceId'			=> $InvoiceNumber[0],
										'payment_status'	=>'failed',
										'error_type'		=> $error_xml->Type,
										'error_type_message'=> $error_xml->Message,
										'paymentError'		=> $error_xml->Elements
				));
			}


		}else{
//            ERROR IN XERO. TRANSACTION WAS UNSUCCESSFUL

			$error_xml  = simplexml_load_string($result['result']['result']->response['response']);

			echo json_encode((Array('Invoice_status'=>'failed',
				'error_type'=>$error_xml->Type,
				'error_type_message'=>$error_xml->Message,
				'message'=>$error_xml->Elements
			)));
//            echo json_encode((Array('Result'=>$invoices)));
		}


		//echo $invoices;

	}//end functon



	public function set_xero_revenue_code(){

        $mrcnt_id           = $this->input->post('mrcnt_sn');
        $data['mrcnt_xero_revenew_code_id']       = $this->input->post('x_code_id');
        $data['mrcnt_xero_revenew_account_id']    = $this->input->post('x_account_id');
        $data['mrcnt_xero_revenew_account_name']  = $this->input->post('x_account_name');

        $this->load->model('customer_model');

        $res = $this->customer_model->setRevenueAccount($data,$mrcnt_id);

        echo $res;

    }// end function


    public function setTC(){

        $mrcnt_id           = $this->input->post('mrcnt_sn');
        $data['mrcnt_xero_tc_id']       = $this->input->post('_tc');
        $data['mrcnt_xero_tc_group_name']       = $this->input->post('_group_name');
        $data['mrcnt_xero_tc_name']       = $this->input->post('_op_name');

        $this->load->model('customer_model');

        $res = $this->customer_model->update($data,$mrcnt_id);

        echo $res;

    }//end function

}//end class