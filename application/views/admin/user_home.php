<li>Admin</li>
</ul>

<?php

        //pos api token cookie        
        $pos_api_token=$this->input->cookie('posios2xero_pos_api_token');
        
        if($pos_api_token==''){
            //get the pos api token ?>
            <input type="hidden" id="pos_api_token" value="">
            <script>require(['page/admin']);</script>        
            
        <?php                    
            $pos_api_token=$this->input->cookie('posios2xero_pos_api_token');
        }//end pos api token
               

?>

<aside class="panel panel-default">
    <?php /*<div class="panel-heading">Filter</div>*/
   // echo "NOW:  date('Y-m-d H:i:s'): ". date('M d, Y h:i a').'<BR>';
    $mName      = $this->input->get('merchant');
    $mStatus    = $this->input->get('status');
    $mSn        = $this->session->userdata('mrcnt_sn');
    ?>
    <div class="panel-body">

        <?php

        $_mrcnt_pos_company_id    = $_record[0]['mrcnt_pos_company_id'];
        $_mrcnt_xero_api_key      = $_record[0]['mrcnt_xero_api_key'];
        $_mrcnt_xero_api_secret   = $_record[0]['mrcnt_xero_api_secret'];
        $_xero_revenue_id         = $_record[0]['mrcnt_xero_revenew_code_id'];


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
                       href="<?php echo base_url().'customer/edit/'.$this->session->userdata('mrcnt_sn') ; ?>"><i class="fa fa-pencil"></i> Update</a></p>
            </div>

        <?php
        }//end if

        if($_mrcnt_xero_api_key !=''  && $_mrcnt_xero_api_secret !=''){

            /* ALERT IF Revenue Account is not SET */
            if($_xero_revenue_id=='' || $_xero_revenue_id == null){ ?>
                <div role="alert" class="alert alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4>Oh snap! XERO Revenue Account is Not Configured!</h4>
                    <p>Please configure the XERO Revenue Account from
                        <a class="btn btn-danger btn-sm" type="button" title="Config"
                           href="<?php echo base_url().'merchant/account-config/'.$_sn.'/?accounts=1' ?>"><i class="fa fa-cog"></i> Config</a> Page.</p>
                </div>

            <?php }// END revenue_id check

//            echo 'LA: '.count($_linked_accounts);
            /* ALERT IF Configuration is not SET */
            if(count($_linked_accounts)>0){ ?>

                <div role="alert" class="alert alert-danger fade in">
                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4>Oh snap! POSiOS and XERO Accounts are not Linked!</h4>
                    <p>Please Link the accounts from
                        <a class="btn btn-danger btn-sm" type="button" title="Config"
                           href="<?php echo base_url().'merchant/account-config/'.$_sn.'/?accounts=1'; ?>"><i class="fa fa-cog"></i> Config</a> Page.</p>
                </div>

            <?php }//end if

        }//end if

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


        <form class="form-inline" method="get" action="<?php echo base_url().'admin'?>">                        
            <div class="row">               
                <div class="col-sm-4">
                    <div class="input-group">                        
                        <span class="input-group-addon"><i class="fa fa-folder-open"></i></span>
                        <select id="status" name="status" class="form-control">                            
                            <option disabled <?php echo $mStatus==''?'selected':'';?>>Select A Status</option>
                            <option value="all" 
                                    <?php echo $mStatus=='all'?'selected':'';?>>All</option>
                            <option value="success"
                                    <?php echo $mStatus=='success'?'selected':'';?>>Success</option>
                            <option value="failed"
                                    <?php echo $mStatus=='failed'?'selected':'';?>>Failed</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">                
                        <button class="btn btn-info" type="submit"> <i class="fa fa-filter"></i> Show</button>
                    </div>
                </div>
            </div>
            
            
        </form>
    </div>
</aside>
<?php

if(isset($_transactions)){


if(count($_transactions)>0){   
   // print_r($_transactions);
    ?>

<section class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-list"></i>  Transactions</div>
    <div clas="body">
        <table class="table table-condensed table-striped table-hover table-responsive">
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
                foreach($_transactions as $tran):                     
                    ?>
                    <tr <?php echo $tran['tran_status']!='success'?'class="warning"':'';?>>
                        <td><?php echo $tran['tran_sn'];?></td>
                        <td><?php echo date('d M, Y',$tran['tran_date']);?></td>
                        <td><?php echo $tran['tran_mode'];?></td>
                        <td><?php 
                            if($tran['tran_status']!='success'){
                            echo '<span class="label label-danger">'.$tran['tran_status'].'</span><br>';    
                            echo '<a href="'.base_url().'profile/manual-post/'.$mSn.'/'.$mName.'?date='.date('d-m-Y',$tran['tran_date']).'" class="btn btn-info btn-xs" style="margin-top:10px;"><i class="fa fa-upload"></i> Post Manually</a>';
                            }else{
                            echo '<span class="label label-success">'.$tran['tran_status'].'</span>';    
                            }
                            
                        ?>
                        </td>
                        <td><?php echo $tran['invoice_number'];?></td>
                        <td><?php echo $tran['details'];?></td>                        
                        <?php /*<td><?php echo date('d M, Y h:i a',$tran['date_added']);?></td>*/?>
                        <td><?php echo date('d M, Y h:i a',strtotime($tran['date_added']));?></td>
                        <td><?php echo $tran['user_name'].' ('.$tran['user_type'].')';?></td>
                    </tr>                
                    <?php
                endforeach;
                ?>                
            </tbody>
        </table>
        
            <div class="col-sm-12">
                <?php echo $this->pagination->create_links();?>
            </div>
        
        
    </div>
</section>    

    <?php
}//end if

}//end is set
?>