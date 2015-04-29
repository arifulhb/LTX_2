<?php

class Template
{
    protected $_ci;

    function __construct()
    {
        $this->_ci =&get_instance();
    }//end construct
    
    function access_denied($data){
        
        $data['_content']=$this->_ci->load->view('inc/access',$data,true);

        $data['_page_title']='Access Denied';
        //Page Class Name
        $data['_page_class']='access_denied';
        
        //noindex nofollow
        $data['_noindex_meta']=true;

        //Load the page
        $this->_ci->load->view('access_denied_template.php',$data);
        
        
    }//end function

    //Load the Home Page
    function home($data=null)
    {
        //Loadign the template        
        
        $data['_navbar_home']=$this->_ci->load->view('inc/navbar_home',$data,true);        
        $data['_content']=$this->_ci->load->view('',$data,true);
        
        //Page Class Name        
        $data['_page_class']='home';

        //Load the page
        $this->_ci->load->view('page_template.php',$data);

    }//end home


    /**
     * User Management
     */
    function user_index($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('user/index',$data,true);

        //Page Class Name
        $data['_page_class']='user_index';
        $data['thisPage']='userPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                          
    }//end function
    
    function user_profile($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('user/view',$data,true);

        //Page Class Name
        $data['_page_class']='user_profile';
        $data['thisPage']='userPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                  
        
    }//end function
    
    
    function user_change_pass($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('user/change_pass',$data,true);

        //Page Class Name
        $data['_page_class']='user_change_pass';
        $data['thisPage']='userPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
   
     function user_add($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('user/form',$data,true);

        //Page Class Name
        $data['_page_class']='user_add';
        $data['thisPage']='userPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
    function user_edit($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('user/form',$data,true);

        //Page Class Name
        $data['_page_class']='user_edit';
        $data['thisPage']='userPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
    function user_changepassword($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('user/changepass',$data,true);

        //Page Class Name
        $data['_page_class']='user_edit';
        $data['thisPage']='userPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
    function user_changepin($data){
    
               //Loadign the template       

        $data['_content']=$this->_ci->load->view('user/changepin',$data,true);

        //Page Class Name
        $data['_page_class']='user_edit';
        $data['thisPage']='userPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('front_template.php',$data);
    
        
    }//end function
    
    
    function subscription_view($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('subscription/view',$data,true);

        //Page Class Name
        $data['_page_class']='pending_index';
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                          
    }//end function
    
    function subscription_receipt($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('subscription/re_receipt',$data,true);

        //Page Class Name
        $data['_page_class']='pending_index';
        $data['_noindex_meta']=true;
        $data['_print_css']=true;
        
        //Load the page
        $this->_ci->load->view('front_template.php',$data);
                          
    }//end function
    
    /**
     * Pending
     */
    function pending_index($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('pending/index',$data,true);

        //Page Class Name
        $data['_page_class']='pending_index';
        $data['thisPage']='userPending';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                          
    }//end function
    
     function pending_view($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('pending/view',$data,true);

        //Page Class Name
        $data['_page_class']='pending_index';
        $data['thisPage']='userPending';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                          
    }//end function
    
    function pending_edit($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('pending/form',$data,true);

        //Page Class Name
        $data['_page_class']='pending_index';
        $data['thisPage']='userPending';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                          
    }//end function
    
    /**
     * Transaction
     */
    function transaction_index($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('transaction/index',$data,true);

        //Page Class Name
        $data['_page_class']='transaction_index';
        $data['thisPage']='transaction';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                  
        
    }//end function
    
   function campaign_details($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('campaign/view',$data,true);

        //Page Class Name
        $data['_page_class']='campaign_details';
        $data['thisPage']='campaignPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
                  
        
    }//end function
    

    /**
     * Customer
     */
    
    function customer_index($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('customer/index',$data,true);        
         
        //Page Class Name
        $data['_page_class']='customer_index';
        $data['thisPage']='customerPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
     function customer_add($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('customer/form',$data,true);

        //Page Class Name
        $data['_page_class']='customer_add';
         $data['thisPage']='customerPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function

    function customer_edit($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/form',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_edit';
        $data['thisPage']='customerPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
    
    function customer_view($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/view',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_view';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        $data['thisPage']='customerPage';
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
        
    
    function customer_daily_report($data)
    {
           //Loadign the template       

        $data['_content']=$this->_ci->load->view('customer/daily_report',$data,true);        
         
        //Page Class Name
        $data['_page_class']='customer_index';
        $data['thisPage']='customerPage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
    function customer_config($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/config',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_config';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        $data['thisPage']='customerPage';
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function

    function customer_bci($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/bci',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_bci';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        $data['thisPage']='ban';
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
  function customer_confirm($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/confirm',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_confirm';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        //$data['thisPage']='customerPage';
        //Load the page
        $this->_ci->load->view('front_template.php',$data);
            
    }//end function
       
    function customer_receipt($data){
        
        $data['_content']=$this->_ci->load->view('customer/tran_receipt',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_confirm';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        $data['_print_css']=true;
        //$data['thisPage']='customerPage';
        //Load the page
        $this->_ci->load->view('front_template.php',$data);
        
    }//end function
            
    function customer_confirm_final($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/confirm_final',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_confirm';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        //$data['thisPage']='customerPage';
        //Load the page
        $this->_ci->load->view('front_template.php',$data);
            
    }//end function
    
    function customer_campaign($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/campaign',$data,true);
        
        //Page Class Name
        $data['_page_class']='customer_view';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        $data['thisPage']='customerPage';
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
    function customer_transactions($data)
    {
        //Loadign the template       
        
        $data['_content']=$this->_ci->load->view('customer/all_transaction',$data,true);
        
        //Page Class Name
        $data['_page_class']='all_transaction';
        
        //noindex nofollow
        $data['_noindex_meta']=true;
        $data['thisPage']='customerPage';
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
            
    }//end function
    
    /*
     * ADMIN
     */

    function admin_home($data=null)
    {        

        $data['_content']=$this->_ci->load->view('admin/index',$data,true);

        //Page Class Name
        $data['_page_class']='admin_index';
          $data['thisPage']='homePage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);

    }//end home
    
        function admin_user_home($data=null)
    {        

        $data['_content']=$this->_ci->load->view('admin/user_home',$data,true);

        //Page Class Name
        $data['_page_class']='admin_index';
        $data['thisPage']='homePage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);

    }//end home
    
    function profile_home($data=null)
    {        

        $data['_content']=$this->_ci->load->view('profile/index',$data,true);

        //Page Class Name
        $data['_page_class']='admin_index';
        $data['thisPage']='profile';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);

    }//end home
    
    function profile_edit($data=null)
    {        

        $data['_content']=$this->_ci->load->view('profile/form',$data,true);

        //Page Class Name
        $data['_page_class']='profile_edit';
        $data['thisPage']='profile';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);

    }//end home
    
    
    function admin_login($data=null)
    {
        //Loadign the template        
                
        $data['_content']=$this->_ci->load->view('login/index',$data,true);
        
        //Page Class Name
        $data['_page_class']='admin_login';

        //Load the page
        $this->_ci->load->view('login_template.php',$data);

    }//end home
    
    
    /**
     * FRONT END TEMPLATE
     */
    
    function front_login($data){
                        
        $data['_content']=$this->_ci->load->view('login/front_login',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_login';
        
        $this->_ci->load->view('front_template.php',$data);
        
    }//end function

    function front_home($data){
        
        $data['_content']=$this->_ci->load->view('home/index',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_home';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);
        
    }//end front_home
           
    public function front_past_receipts($data){
        
                
        $data['_content']=$this->_ci->load->view('subscription/past_receipts',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_customer_search';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);
        
        
    }//end function 
    
    public function front_customer_search($data){
        
                
        $data['_content']=$this->_ci->load->view('customer/front_search',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_customer_search';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);
        
        
    }//end function 
    
        public function front_customer_view($data){
        
                
        $data['_content']=$this->_ci->load->view('customer/front_member',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_customer_member';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);
        
        
    }//end function 
    
    function front_add_customer($data){
        
        $data['_content']=$this->_ci->load->view('customer/front_add',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_add_customer';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);
        
    }//end front_home
    
    function front_existing_customer($data){
        
        $data['_content']=$this->_ci->load->view('customer/front_existing',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_existing_customer';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);
        
    }//end front_home    
            
    function front_campaign_list($data){
        $data['_content']=$this->_ci->load->view('customer/campaign_list',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_campaign_list';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function 
    
    function front_campaign_activate_visit($data){
        $data['_content']=$this->_ci->load->view('customer/activate_visit',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_activate_visit';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function 
    
    function front_campaign_session_redeem($data){
        $data['_content']=$this->_ci->load->view('customer/session_reedem',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_session_reedem';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function 
    
    function front_campaign_giftcard($data){
        $data['_content']=$this->_ci->load->view('customer/giftcard',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_giftcard';

        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function 
    
    
    function front_campaign_visit_receipt($data){
        $data['_content']=$this->_ci->load->view('campaign/visit_receipt',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_activate_visit';
        $data['_print_css']=true;
        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function
    
    function front_campaign_session_receipt($data){
        $data['_content']=$this->_ci->load->view('campaign/session_receipt',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_activate_visit';
        $data['_print_css']=true;
        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function
    
    function front_campaign_giftcard_receipt($data){
        $data['_content']=$this->_ci->load->view('campaign/giftcard_receipt',$data,true);
        
        //Page Class Name
        $data['_page_class']='front_activate_visit';
        $data['_print_css']=true;
        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function
    
    
    function front_subscription_expired($data){
        $data['_content']=$this->_ci->load->view('customer/subscription_expired',$data,true);
        $data['_page_title']="Warning message";
        //Page Class Name
        $data['_page_class']='front_subscription_expired';
        $data['_print_css']=true;
        //Load the page
        $this->_ci->load->view('front_template.php',$data);        
    }//end function
    
    public function report_signup($data){        
        
        $data['_content']=$this->_ci->load->view('report/signup',$data,true);

        //Page Class Name
        $data['_page_class']='report_signup';
        $data['thisPage']='homePage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
        
    }//end function
    
public function report_transaction($data){        
        
        $data['_content']=$this->_ci->load->view('report/transection',$data,true);

        //Page Class Name
        $data['_page_class']='report_transection';
        $data['thisPage']='homePage';
        //noindex nofollow
        $data['_noindex_meta']=true;
        
        //Load the page
        $this->_ci->load->view('page_template.php',$data);
        
    }//end function
}//end class