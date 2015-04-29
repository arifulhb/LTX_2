<li class="active">My Profile</li>
</ul>
<?php

  $_sn                      = $_record[0]['mrcnt_sn'];

  $_mrcnt_name              = $_record[0]['mrcnt_name'];
  $_mrcnt_email                 = $_record[0]['mrcnt_email'];
  $_mrcnt_pos_company_id    = $_record[0]['mrcnt_pos_company_id'];
//  $_mrcnt_pos_api_token     = $_record[0]['mrcnt_pos_api_token'];
  $_mrcnt_xero_api_key      = $_record[0]['mrcnt_xero_api_key'];
  $_mrcnt_xero_api_secret   = $_record[0]['mrcnt_xero_api_secret'];
  $_xero_revenue_id            = $_record[0]['mrcnt_xero_revenew_code_id'];
  $_xero_revenue_name       = $_record[0]['mrcnt_xero_revenew_account_name'];
  $_xero_tc_name            = $_record[0]['mrcnt_xero_tc_name'];
  $_mrcnt_status            = $_record[0]['mrcnt_status'];
$_mrcnt_start_time        = $_record[0]['mrcnt_start_time'];
$_mrcnt_end_time          = $_record[0]['mrcnt_end_time'];
$_mrcnt_end_time_same_date= $_record[0]['mrcnt_end_time_is_same_date'];
$_mrcnt_auto_sync         = $_record[0]['mrcnt_auto_sync'];
?>
<section class="panel">
    <header class="panel-heading clearfix">
        <strong><i class="fa fa-user"></i> Merchant Details</strong>
        <a class="btn btn-link pull-right" href="<?php echo base_url().'profile/edit/';?>" 
           style="padding: 0 10px;"
           role="button"><i class="fa fa-pencil"></i> Edit Profile</a>
    </header>
    <input type='hidden' id='cust_sn' value='<?php echo $_sn;?>'>
    <div class="panel-body">

        <?php

        /**
         * ALTER IF NOT CONFIGURED PROPERLY
         *
         */


        /* XERO API KEY AND XERO API SECRET */

        if($_mrcnt_xero_api_key=='' || $_mrcnt_xero_api_secret ==''){ ?>

            <div role="alert" class="alert alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4>Oh snap! XERO Api not Configured!</h4>
                <p><strong>XERO API Key</strong> or <strong>XERO API Secret</strong> is not updated. Please
                    <a class="btn btn-danger btn-sm" type="button" title="Config"
                       href="<?php echo base_url().'customer/edit/'.$_sn; ?>"><i class="fa fa-pencil"></i> Update</a></p>
            </div>

        <?php
        }//end if


        if($_mrcnt_xero_api_secret !='' && $_mrcnt_xero_api_key !=''){

            /* ALERT IF Revenue Account is not SET */
            if($_xero_revenue_id=='' || $_xero_revenue_id == null){ ?>
                <div role="alert" class="alert alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4>Oh snap! XERO Revenue Account is Not Configured!</h4>
                    <p>Please configure the XERO Revenue Account from
                        <a class="btn btn-danger btn-sm" type="button" title="Config"
                           href="<?php echo base_url().'profile/account-config/?accounts=1/'; ?>"><i class="fa fa-cog"></i> Config</a> Page.</p>
                </div>

            <?php }// END revenue_id check

            /* ALERT IF Configuration is not SET */
            if(count($_linked_accounts) <= 0){ ?>

                <div role="alert" class="alert alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4>Oh snap! POSiOS and XERO Accounts are not Linked!</h4>
                    <p>Please Link the accounts from
                        <a class="btn btn-danger btn-sm" type="button" title="Config"
                           href="<?php echo base_url().'profile/account-config/?accounts=1/'; ?>"><i class="fa fa-cog"></i> Config</a> Page.</p>
                </div>

            <?php }//end if

        }//end CONFIG SETUP

        /* POSiOS Company ID */

        if($_mrcnt_pos_company_id =='' || $_mrcnt_pos_company_id == null){ ?>

            <div role="alert" class="alert alert-danger fade in">
                <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4>Oh snap! POSiOS Company ID!</h4>
                <p><strong>POSiOS Company ID</strong>  is not updated. Please
                    <a class="btn btn-danger btn-sm" type="button" title="Config"
                       href="<?php echo base_url().'customer/edit/'.$_sn; ?>"><i class="fa fa-pencil"></i> Update</a></p>
            </div>

        <?php
        }//end if



        ?>

        <form class="form-horizontal" role="form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-lg-4 col-sm-4 control-label">Merchant Name</label>
                        <div class="col-lg-8">
                            <p class="form-control-static"><?php echo $_mrcnt_name;?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-lg-4 col-sm-4 control-label">Email</label>
                        <div class="col-lg-8">
                            <p class="form-control-static"><?php echo $_mrcnt_email;?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputMobileNo" class="col-lg-4 col-sm-4 control-label">Status</label>
                        <div class="col-lg-8">
                            <p class="form-control-static"><?php echo ucfirst($_mrcnt_status);?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="col-lg-4 col-sm-4 control-label">Auto Sync</label>
                        <div class="col-lg-8">
                            <p class="form-control-static"><?php echo $_mrcnt_auto_sync==0?"No":"Yes";?></p>
                        </div>
                    </div>
                </div>
            </div>

        </form>                
    </div>
</section>

<div class="row">

    <!--posios-->
    <div class="col-lg-6">
        <section class="panel panel-info">
            <div class="panel-heading">POSiOS</div>
            <div class="panel-body">

                <form class="form-horizontal">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="col-lg-6 col-sm-6 control-label">POSiOS Company ID</label>
                                <div class="col-lg-6">
                                    <p class="form-control-static">: <?php echo $_mrcnt_pos_company_id;?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                &nbsp;
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="inputMobileNo" class="col-lg-6 col-sm-6 control-label">Start Time</label>
                                <div class="col-lg-6">
                                    <p class="form-control-static">: <?php echo ($_mrcnt_start_time);?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputMobileNo" class="col-lg-6 col-sm-6 control-label">End Time</label>
                                <div class="col-lg-6">
                                    <p class="form-control-static">: <?php echo $_mrcnt_end_time;?></p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <div class="form-group">
                                <label for="inputMobileNo" class="col-lg-8 col-sm-8 control-label">End time Is Same Date</label>
                                <div class="col-lg-4">
                                    <p class="form-control-static">: <?php echo $_mrcnt_end_time_same_date==0?"No":"Yes";?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </section>
    </div>
    <!--XERO-->
    <div class="col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">XERO</div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputMobileNo" class="col-lg-4 col-sm-4 control-label">Tracking Category</label>
                                <div class="col-lg-8">
                                    <p class="form-control-static">: <?php echo $_xero_tc_name;?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="col-lg-4 col-sm-4 control-label">Xero Revenue Account</label>
                                <div class="col-lg-8">
                                    <p class="form-control-static">: <?php echo $_xero_revenue_name.' : '.$_xero_revenue_id;?></p>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputMobileNo" class="col-lg-4 col-sm-4 control-label">XERO API KEY</label>
                                <div class="col-lg-8">
                                    <p class="form-control-static">: <?php echo $_mrcnt_xero_api_key;?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputPhoneNumber" class="col-lg-4 col-sm-4 control-label">XERO API SECRET</label>
                                <div class="col-lg-8">
                                    <p class="form-control-static">: <?php echo $_mrcnt_xero_api_secret;?></p>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>

</div>

<?php

if(count($_transactions)>0){ ?>
<section id="mrcnt_transactions" class="panel panel-default">
    <div class="panel-heading"><strong>Recent Transactions</strong>
        <a class="btn btn-link pull-right" href="<?php echo base_url().'admin/?status=all';?>" 
           title="Show All"role="button"><i class="fa fa-list"></i> Show All</a>
    </div>
    <div class="panel-body">
        <table class="table table-hover table-condensed table-striped table-responsive">
            <thead>
                <tr>
                    <th>Trans SN</th>
                    <th>Date</th>
                    <th>Mode</th>
                    <th>Status</th>
                    <th>Invoice No</th>
                    <th>Details</th>
                    <th>Added On</th>
                    <th>By</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($_transactions as $tran): ?>
                    <tr>
                        <td><?php echo $tran['tran_sn'];?></td>
                        <td><?php echo date('d M, Y',$tran['tran_date']);?></td>
                        <td><?php echo $tran['tran_mode'];?></td>
                        <td><?php 
                            if($tran['tran_status']!='success'){
                            echo '<span class="label label-warning">'.$tran['tran_status'].'</span>';    
                            }else{
                            echo '<span class="label label-success">'.$tran['tran_status'].'</span>';    
                            }
                            if(strlen($tran['note'])>0){

                                echo '<br><br><div class="btn-group" data-toggle="buttons">';
                                echo '<button type="button" class="btn btn-xs btn-warning error"
                                        data-container="body" data-toggle="popover" data-placement="top" title="Payment Processing Error!"
                                        data-content="'.$tran['note'].'. Clear the message Error if you already fixed it."><i class="fa fa-bug"></i> Error!</button>';
                                echo '<button type="button" id="'.$tran['tran_sn'].'" class="btn btn-xs btn-primary fix"
                                        title="Clear the Error"><i class="fa fa-eraser"></i> Clear</button>';
                                echo '</div>';
                            }
                            
                        ?>
                        </td>
                        <td><?php echo $tran['invoice_number'];?></td>
                        <td><?php echo $tran['details'];?></td>                        
                        <td><?php echo date('d M, Y h:i a',strtotime($tran['date_added']));?></td>
                        <td><?php echo $tran['user_name'].' ('.$tran['user_type'].')';?></td>
                    </tr>                
                    <?php
                endforeach;
                ?>                
            </tbody>
        </table>
    </div>
</section>    
    <?php
}//end transactions
?>
<section class="panel panel-default">
    <div class="panel-heading"><strong>Accounts</strong>

        <?php

        if($_mrcnt_xero_api_key !='' && $_mrcnt_xero_api_secret !=''){ ?>
            <a class="btn btn-default btn-sm pull-right" href="<?php echo base_url().'profile/account-config/?accounts=1';?>"
               title="Configure Accounts"role="button"><i class="fa fa-cog"></i> Config</a>
            <?php
        }?>


    </div>
    <div class="panel-body">
        <?php         
        if(count($_linked_accounts)>0){ ?>
        <table class="table table-hover table-striped table-condensed">
            <thead>
                <tr>
                    <th>POS Payment Type</th>
                    <th>OID</th>
                    <th>XERO Account</th>
                    <th>Code ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($_linked_accounts as $row): ?>
                    <tr>
                        <td><?php echo $row['pos_payment_type_name'];?></td>
                        <td><?php echo $row['pos_payment_type_oid'];?></td>
                        <td><?php echo $row['xero_account_name'];?></td>
                        <td><?php echo $row['xero_code_id'];?></td>
                    </tr>
                
                    <?php
                endforeach;
                ?>                
            </tbody>
        </table>
        <?php
        }//end if
        ?>
    </div>
</section>
<script> require(['page/customer_view']); </script>