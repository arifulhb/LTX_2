<li><a href="<?php echo base_url() . 'merchant'; ?>">Merchant </a></li>
<li class="active"><?php echo $_action == 'add' ? 'Add New' : 'Edit'; ?> Merchant</li>
</ul>
<?php
if($_action=='update'){
    
  //print_r($_record[0]);
  
   $_sn                   =   $_record[0]['mrcnt_sn'];
   $MerchantName         =   $_record[0]['mrcnt_name'];
   $MerchantEmail        =   $_record[0]['mrcnt_email'];
   $CompanyId            =   $_record[0]['mrcnt_pos_company_id'];
   $XERO_key             =   $_record[0]['mrcnt_xero_api_key'];
   $XERO_secret          =   $_record[0]['mrcnt_xero_api_secret'];
   $mrcnt_statust        =   $_record[0]['mrcnt_status'];
   $mrnct_start_time     = $_record[0]['mrcnt_start_time'];
   $mrnct_end_time       = $_record[0]['mrcnt_end_time'];
   $mrnct_end_time_is_same_day = $_record[0]['mrcnt_end_time_is_same_date'];
   $mrcnt_auto_sync      = $_record[0]['mrcnt_auto_sync'];
   $mrcnt_server  		= $_record[0]['partner_sn'];

   $xero_lineAmount  	= $_record[0]['mrcnt_xero_lineAmount'];


//exit();
  
  
}else{
    $_sn                   	=   '';
    $MerchantName         	=   '';
    $MerchantEmail        	=   '';
    $CompanyId            	=   '';
    $XERO_key             	=   '';
    $XERO_secret            =   '';
	$xero_lineAmount  		=   '';;

    $mrcnt_statust          =   '';
    $mrnct_start_time       =   '';
    $mrnct_end_time         =   '';
    $mrcnt_auto_sync        =1;
	$mrcnt_server			=1;
    $mrnct_end_time_is_same_day = 0;

}

?>
<section class="panel">
    <header class="panel-heading clearfix">
        <i class="fa fa-pencil"></i>
        <?php echo $_page_title;
        
        if($_action=='update'){  ?>        
        <a class="btn btn-info pull-right" 
           href="<?php echo base_url().'merchant/view/'.$_sn;?>" role="button">View Merchant</a>
        <?php 
        }//end if
        ?>
    </header>
    <div class="panel-body">
       <?php
       /*
        if(isset($_error)){ ?>
            <div class="alert alert-warning fade in">
            <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-times"></i>
            </button>
            <strong>Warning!</strong><br>
            <?php echo $_error;?>
        </div>
            <?php                
             
            if($_action=='update'){
            $_sn        = $_record[0]['cust_sn'];
            }else{
                $_sn='';
            }
            $_card_id      = $_record[0]['cust_card_id'];
            $_cust_id      = $_record[0]['cust_id'];  
            $_first_name      = $_record[0]['cust_first_name'];
            $_last_name      = $_record[0]['cust_last_name'];
            $_mobile       = $_record[0]['cust_mobile'];
            $_phone       = $_record[0]['cust_phone'];
            $_email       = $_record[0]['cust_email'];
            if($_record[0]['cust_dob']!=''){
            $_dob         = date('d-m-Y',$_record[0]['cust_dob']);
            }else{
            $_dob         =''    ;
            }
            $_address     = $_record[0]['cust_address_line1'];
            $_address2    = $_record[0]['cust_address_line2'];
            $_city        = $_record[0]['cust_city'];
            $_zip         = $_record[0]['cust_zip'];
            $_country_key = $_record[0]['cust_country'];

            $_car_no          = $_record[0]['cust_car_no'];
            $_car_model       = $_record[0]['cust_car_model'];
            $_car_color       = $_record[0]['cust_car_color'];
            $_additional  = $_record[0]['cust_additional'];
            //print_r($_record);
            
        }//end error
        * 
        */
        ?>
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" role="form" method="POST"
              action="<?php echo base_url().'customer/save';?>">
            
            <input type="hidden" id="_action" name="_action" value="<?php echo $_action;?>">
            <?php
            if($_action=='update'): ?>
            <input type="hidden" id="_sn" name="_sn" value="<?php echo $_sn;?>">
                <?php
            endif;
            ?>            
            <div class="form-group">
                <label for="inputMerchantName" class="col-md-4 control-label">Name</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputMerchantName"  
                           value="<?php echo trim($MerchantName);?>"
                           name="inputMerchantName" placeholder="Merchant Name" required="">
                </div>
            </div>
           
           <div class="form-group">
                <label for="inputMerchantEmail" class="col-md-4 control-label">Email</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" id="inputMerchantEmail"  
                           value="<?php echo trim($MerchantEmail);?>"
                           name="inputMerchantEmail" placeholder="Email" required="">
                </div>
            </div>
            <hr>
             <div class="form-group">
                <label for="inputPOSiOSId" class="col-md-4 control-label">Lightspeed Company ID</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputPOSiOSId"  maxlength="5"
                           value="<?php echo trim($CompanyId);?>"
                           name="inputPOSiOSId" placeholder="Lightspeed Company ID" required="">
                </div>
            </div>
					<div class="form-group">
						<label for="inputMrcntAutoSync" class="col-md-4 control-label">Auto Sync</label>
						<div class="col-md-2">
							<select id="inputMrcntAutoSync" class="form-control" name='inputMrcntAutoSync'>

								<option value="0" <?php echo $mrcnt_auto_sync=='0'?'SELECTED':''; ?>>No</option>
								<option value="1" <?php echo $mrcnt_auto_sync=='1'?'SELECTED':''; ?>>Yes</option>
							</select>
						</div>

						<label for="inputMrcntServer" class="col-md-2 control-label">Server</label>
						<div class="col-md-4">
							<select id="inputMrcntServer" class="form-control" name='inputMrcntServer'>
								<option value="1" <?php echo $mrcnt_server=='1'?'SELECTED':''; ?>>Singapore</option>
								<option value="2" <?php echo $mrcnt_server=='2'?'SELECTED':''; ?>>Australia</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="inputMrcntStartTime" class="col-md-4 control-label">Start Time</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="inputMrcntStartTime"
								   value="<?php echo $mrnct_start_time;?>" maxlength="11" required=""
								   name="inputMrcntStartTime" placeholder="00:00:00">
						</div>
					</div>
					<div class="form-group">
						<label for="inputMrcntEndTime" class="col-md-4 control-label">End Time</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="inputMrcntEndTime"
								   value="<?php echo $mrnct_end_time;?>" maxlength="11" required=""
								   name="inputMrcntEndTime" placeholder="23:59:59">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEndTimeIsSameDay" class="col-md-4 control-label">End Time Is Same Day?</label>
						<div class="col-md-8">
							<select id="inputEndTimeIsSameDay" class="form-control" name='inputEndTimeIsSameDay'>

								<option value="0" <?php echo $mrnct_end_time_is_same_day =='0'?'SELECTED':''; ?>>No</option>
								<option value="1" <?php echo $mrnct_end_time_is_same_day =='1'?'SELECTED':''; ?>>Yes</option>
							</select>
						</div>
					</div>

            <hr>
              <div class="form-group">
                <label for="inputXeroApiKey" class="col-md-4 control-label">XERO API Key</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputXeroApiKey"  
                           value="<?php echo trim($XERO_key);?>"
                           name="inputXeroApiKey" placeholder="XERO API KEY">
                </div>
            </div>
            <div class="form-group">
                <label for="inputXeroApiSecret" class="col-md-4 control-label">XERO API Secret</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputXeroApiSecret"  
                           value="<?php echo trim($XERO_secret);?>"
                           name="inputXeroApiSecret" placeholder="XERO API Secret">
                </div>
            </div>

			<div class="form-group">
				<label for="inputXeroLineAmount" class="col-md-4 control-label">XERO LineAmount Types</label>
				<div class="col-md-8">
					<select id="inputXeroLineAmount" class="form-control" name='inputXeroLineAmount'>
							<option <?php echo $xero_lineAmount =='Exclusive'?'SELECTED':''?> value="Exclusive"  >Exclusive</option>
							<option <?php echo $xero_lineAmount =='Inclusive'?'SELECTED':''?> value="Inclusive" >Inclusive</option>
							<option <?php echo $xero_lineAmount =='NoTax'?'SELECTED':''?> value="NoTax" >NoTax</option>
					</select>

				</div>
			</div>

			<hr>

            <div class="form-group">
                <label for="inputXeroApiSecret" class="col-md-4 control-label">Status</label>
                <div class="col-md-8">
                    <select id="mrcnt_status" class="form-control" name='inputMrcntStatus'>
                        <option disabled selected>Please Select</option>
                        <option value="active" <?php echo $mrcnt_statust=='active'?'SELECTED':''; ?>>Active</option>
                        <option value="inactive" <?php echo $mrcnt_statust=='inactive'?'SELECTED':''; ?>>In Active</option>
                    </select>
                </div>
            </div>


			<div class="form-group">
                <label for="" class="col-md-4 control-label"></label>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-info btn-save btn-block" title="Save">
                        <i class="fa fa-save"></i> Save</button>
                </div>
            </div>

           
        </form>
                
            </div>

        </div>    
        
    </div>
</section>

<?php        
/*
    if($_action=='update'){   ?>
<section class="panel">
    <div class="panel-heading"><i class="fa fa-key"></i> Change Password</div>
    <div class="panel-body">
        
            <form class="form-horizontal" name="change_password"
                  action="<?php echo base_url().'user/cpvalidation';?>">
                <input type="hidden" name="user_id" value="<?php echo $_record[0]['cust_sn'];?>"/>
                <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label for="inputNewPassword" class="col-md-4 control-label">New Password</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" id="inputNewPassword"                                         
                                       name="newPassword" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputRePassword" class="col-md-4 control-label">Re Password</label>
                            <div class="col-md-8">
                                <input type="password" class="form-control" id="inputRePassword"                                         
                                       name="confirmPassword" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMerchantName" class="col-md-4 control-label"></label>
                            <div class="col-md-8">
                                <button type="submit" name="btnChangePassword"
                                        class="btn btn-warning">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        
    </div>
</section>

        <?php
 
    }//end if
 * * 
 */

    ?>

<script> require(['page/customer_form']); </script> 