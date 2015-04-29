<?php 
if($this->session->userdata('user_type')==1){ ?>
<li><a href="<?php echo base_url() . 'merchant';?>">Merchant</a></li>
<li><a href="<?php echo base_url() . 'merchant/view/'.$this->uri->segment(3); ?>"><?php echo $_record[0]['mrcnt_name'];?></a></li>
<li class="active">Config</li>
</ul>
    <?php
}else if($this->session->userdata('user_type')==2) { ?>
<li><a href="<?php echo base_url() . 'profile';?>">Profile</a></li>
<li class="active">Account Config</li>
</ul>
    <?php
}//end else


?>
<input type="hidden" id="mrcnt_company_id" value="<?php echo $_record[0]['mrcnt_pos_company_id'];?>">

<?php

if($_record[0]['partner_sn'] != $this->session->userdata('partner_sn')){ ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Warning</h3><strong></strong>
                You need to change the server to <strong><?php echo $_record[0]['partner_country']?></strong>.
            </div>
        </div>
    </div>
    <?php
}

?>


<section class="panel panel-info">
    <div class="panel-heading"><i class="fa fa-cog"></i> <strong><?php echo $_record[0]['mrcnt_name'];?></strong> [Configure Payment Types]</div>
    <div class="panel-body">
        
        <input type="hidden" id="mrcnt_pos_company" 
               value="<?php echo $_record[0]['mrcnt_sn'];?>">
        <div class="row">
            <div class="col-sm-3">
                <h4>Lightspeed Payment Types</h4>
                <h5 id="selected_pos"></h5>
                <input type="hidden" id="pos_sec" value="">
                <input type="hidden" id="pos_oid" value="">
                <input type="hidden" id="pos_type_id" value="">
                <div id="pos_payments">
                    
                </div>
            </div>
            <div class="col-sm-4">
                <h4>Xero Accounts</h4>
                <h5 id="selected_xero"></h5>
                <input type="hidden" id="xero_acc_id" value="">
                <input type="hidden" id="xero_code_id" value="">
                <div id="xero_accounts" class="llist-group">
                <?php 
                //print_r($_accounts['result']['result']);
                foreach($_accounts['result']['result'] as $item):
                    //print_r($item);
                    if($item->Status=='ACTIVE'){ ?>
                    <a id="<?php echo $item->AccountID;?>" class="list-group-item account"
                       href="#"><?php echo $item->Name;?> <small>[<?php echo $item->Class;?>]</small></a>
                    <input type="hidden" id="xero_code_<?php echo $item->AccountID?>"
                           value="<?php echo $item->Code?>">
                    <?php                        
                    }//END IF
                endforeach;
                ?>
               </div>
            </div>            
            <div class="col-sm-5">

                <h4 class="text-center">Link Accounts</h4>

                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-primary btn-block" id="create_payment_account" disabled=""
                                title="Create Account"><i class="fa fa-file"></i> Create Payment Account</button>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-info btn-block" id="create_inventory_item" disabled=""
                                title="Create Inventory Item"><i class="fa fa-file"></i> Create Inventory Item</button>
                    </div>
                </div>
                <br>
                <div id="app_accounts">
                    <table class="table table-condensed table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>LS Payment Type</th>
                                <th>XERO Account</th>
                                <th>Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="app_account_records">
                            <?php
                            foreach($_linked_accounts as $item):
                                if($item['acc_link_type']==1){
                                    $link_type='Payment' ;
                                }elseif($item['acc_link_type']==2){
                                    $link_type='Invoice';
                                }

                                ?>
                                <tr id="acc_<?php echo $item['acc_sn'];?>">                                    
                                    <td><?php echo $item['pos_payment_type_name'];?></td>
                                    <td><?php echo $item['xero_account_name'];?></td>
                                    <td><?php echo $link_type;?></td>
                                    <td class="text-center">
                                        <button class="btn btn-xs btn-danger btn-remove-acc" title="Remove"
                                                value="<?php echo $item['acc_sn'];?>">
                                            <i class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>                                                        
                        </tbody>
                    </table>
                </div>

                <div class="well well-sm">
                    <h4>XERO Revenue Account</h4>
                    <p id="xero_revenew_account_name"><?php echo $_record[0]['mrcnt_xero_revenew_account_name'].' : '.$_record[0]['mrcnt_xero_revenew_code_id']; ?></p>
                    <p><button class="btn btn-info btn-block" id="btnrevenue">
                            <i class="fa fa-circle"></i> Make Revenue Account</button></p>
                </div>

                <div class="well well-sm">
                    <h4 class="">Select  Tracking Category</h4>

                    <select id="tracking_cat" class="form-control">
                    <option disabled selected value="">Select a Tracking Category</option>

                    <?php
                    foreach($_categories['result']['result']->TrackingCategory as $item){?>

                        <optgroup label="<?php echo $item->Name;?>">

                        <?php

                        $Options=(Array)$item->Options;
                        foreach($Options as $option):

                        foreach($option as $row){ ?>

                            <option value="<?php echo (String)$row->TrackingOptionID;?>"
                                <?php echo $_record[0]['mrcnt_xero_tc_id']==(String)$row->TrackingOptionID?'SELECTED':''; ?>
                                ><?php echo (String)$row->Name;?></option>

                            <?php
                        }

                        endforeach; ?>

                        </optgroup>
                            <?php
                    }//end foreach

                    ?>
                    </select>
                    <br>
                    <button class="btn btn-block btn-sm btn-primary" id="btnTrackingCategory"
                        ><i class="fa fa-anchor"></i> Set Tracking Category</button>

                </div><!--well-->
            </div>
        </div>

    </div>
</section>
<div class="spinner" style="position: absolute;top: 25%;left: 50%;">
    <div style="height:200px">
        <span id="searching_spinner_center" style="position: absolute;display: block;top: 50%;left: 50%;"></span>
    </div>
</div>
<script> require(['page/customer_config']); </script> 