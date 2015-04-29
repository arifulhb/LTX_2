<li><a href="<?php echo base_url() . 'profile'; ?>">Profile </a></li>
<li class="active"><?php echo $_action == 'add' ? 'Add New' : 'Edit'; ?></li>
</ul>
<?php
if($_action=='update'){
    
//  print_r($_record[0]);
  
  $_sn                   =   $_record[0]['mrcnt_sn'];
  $MerchantName         =   $_record[0]['mrcnt_name'];
  $MerchantEmail        =   $_record[0]['mrcnt_email'];
  $CompanyId            =   $_record[0]['mrcnt_pos_company_id'];
  $XERO_key             =   $_record[0]['mrcnt_xero_api_key'];
  $XERO_secret          =   $_record[0]['mrcnt_xero_api_secret'];

    $mrnct_start_time     = $_record[0]['mrcnt_start_time'];
    $mrnct_end_time       = $_record[0]['mrcnt_end_time'];
    $mrnct_end_time_is_same_day = $_record[0]['mrcnt_end_time_is_same_date'];
    $mrcnt_auto_sync      = $_record[0]['mrcnt_auto_sync'];

  
}
?>
<section class="panel">
    <header class="panel-heading clearfix">
        <i class="fa fa-pencil"></i>
        <?php echo $_page_title;   ?>
    </header>
    <div class="panel-body">       
        <div class="row">
            <div class="col-sm-12">
                <form class="form-horizontal" role="form" method="POST"
              action="<?php echo base_url().'profile/update_validation';?>">
            
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
                <label for="inputPOSiOSId" class="col-md-4 control-label">POSiOS Company ID</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="inputPOSiOSId"  maxlength="5"
                           value="<?php echo trim($CompanyId);?>"
                           name="inputPOSiOSId" placeholder="POSiOS Company ID" required="">
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
                        <label for="inputMrcntAutoSync" class="col-md-4 control-label">Auto Sync</label>
                        <div class="col-md-8">
                            <select id="inputMrcntAutoSync" class="form-control" name='inputMrcntAutoSync'>

                                <option value="0" <?php echo $mrcnt_auto_sync=='0'?'SELECTED':''; ?>>No</option>
                                <option value="1" <?php echo $mrcnt_auto_sync=='1'?'SELECTED':''; ?>>Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputMrcntStartTime" class="col-md-4 control-label">Start Time</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="inputMrcntStartTime"
                                   value="<?php echo $mrnct_start_time;?>" maxlength="11" required=""
                                   name="inputMrcntStartTime" placeholder="06:00:00 am">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputMrcntEndTime" class="col-md-4 control-label">End Time</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="inputMrcntEndTime"
                                   value="<?php echo $mrnct_end_time;?>" maxlength="11" required=""
                                   name="inputMrcntEndTime" placeholder="05:59:59 am">
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


<script> require(['page/customer_form']); </script> 