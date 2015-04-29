<li><i class="fa fa-list"></i> Transactions</li>
</ul>
<aside class="panel panel-default">
    <?php /*<div class="panel-heading">Filter</div>*/
   // echo "NOW:  date('Y-m-d H:i:s'): ". date('M d, Y h:i a').'<BR>';
    $mName      = $this->input->get('merchant');
    $mStatus    = $this->input->get('status');
    ?>
    <div class="panel-body">
        <form class="form-inline" method="get" action="<?php echo base_url().'transaction'?>">                        
            <div class="row">
                <div class="col-sm-4">
                    <div class="input-group">                
                       <span class="input-group-addon"><i class="fa fa-user"></i></span>
                       <select id="merchant" name="merchant" class="form-control">
                           <option disabled <?php echo $mName==''?'SELECTED':';'?>>Select A Merchant</option>
                           <?php
                           foreach($_merchants as $opt): ?>
                           <option value="<?php echo $opt['mrcnt_sn'];?>"
                                   <?php echo $mName==$opt['mrcnt_sn']?'SELECTED':';'?>><?php echo $opt['mrcnt_name'];?></option>
                               <?php
                           endforeach;
                           ?>
                           
                       </select>
                    </div>
                </div>
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

if(isset($_transactions)) {
    if (count($_transactions) > 0) {
        // print_r($_transactions);
        ?>

        <section class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-list"></i> Transactions</div>
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
                        <th>...</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($_transactions as $tran):
                        ?>
                        <tr  id="tran_row_<?php echo $tran['tran_sn'];?>"
                            <?php echo $tran['tran_status'] != 'success' ? 'class="warning"' : ''; ?>>
                            <td><?php echo $tran['tran_sn']; ?></td>
                            <td><?php echo date('d M, Y', $tran['tran_date']); ?></td>
                            <td><?php echo $tran['tran_mode']; ?></td>
                            <td><?php
                                if ($tran['tran_status'] != 'success') {
                                    echo '<span class="label label-danger">' . $tran['tran_status'] . '</span><br>';
                                    echo '<a href="' . base_url() . 'merchant/daily-report/' . $mName . '?date=' . date('d-m-Y', $tran['tran_date']) . '" class="btn btn-info btn-xs" style="margin-top:10px;"><i class="fa fa-upload"></i> Post Manually</a>';
                                } else {
                                    echo '<span class="label label-success">' . $tran['tran_status'] . '</span>';
                                }
                                if(strlen($tran['note'])>0){

                                    echo '<br><br><div class="btn-group" data-toggle="buttons">';
                                    echo '<button type="button" class="btn btn-xs btn-warning error" id="error_'.$tran['tran_sn'].'"
                                        data-container="body" data-toggle="popover" data-placement="top" title="Payment Processing Error!"
                                        data-content="'.$tran['note'].'. Clear the message Error if you already fixed it."><i class="fa fa-bug"></i> Error!</button>';
                                    echo '<button type="button" id="'.$tran['tran_sn'].'" class="btn btn-xs btn-primary fix"
                                        title="Clear the Error"><i class="fa fa-eraser"></i> Clear</button>';
                                    echo '</div>';
                                }
                                ?>
                            </td>
                            <td><?php echo $tran['invoice_number']; ?></td>
                            <td><?php echo $tran['details']; ?></td>
                            <?php /*<td><?php echo date('d M, Y h:i a',$tran['date_added']);?></td>*/ ?>
                            <td><?php echo date('d M, Y h:i a', strtotime($tran['date_added'])); ?></td>
                            <td><?php echo $tran['user_name'] . ' (' . $tran['user_type'] . ')'; ?></td>
                            <td><button type="button" class="removeTransaction btn btn-xs btn-default" title="Remove Transaction"
                                        value="<?php echo $tran['tran_sn'];?>">
                                    <i class="fa fa-trash-o"></i></button></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>

                <div class="col-sm-12">
                    <?php echo $this->pagination->create_links(); ?>
                </div>


            </div>
        </section>

    <?php
    }
    //end if

}//end if isset
?>
<script> require(['page/customer_view']); </script>