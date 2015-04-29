<li><a href="<?php echo base_url() . 'merchant';?>">Merchant</a></li>
<li><a href="<?php echo base_url() . 'merchant/view/'.$this->uri->segment(3); ?>"><?php echo $_record[0]['mrcnt_name'];?></a></li>
<li class="active">Config</li>
</ul>
<section class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-list"></i> <strong>All Transactions</strong>  <div class="pull-right"><?php echo $_record[0]['mrcnt_name'];?></div> </div>
    <div class="panel-body">

        <table class="table table-condensed table-striped table-responsive table-hover">
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
                foreach($_transactions as $tran): ?>
                    <tr  id="tran_row_<?php echo $tran['tran_sn'];?>"
                        <?php echo $tran['tran_status']!='success'?'class="warning"':'';?>>
                        <td><?php echo $tran['tran_sn'];?></td>
                        <td><?php echo date('d M, Y',$tran['tran_date']);?></td>
                        <td><?php echo $tran['tran_mode'];?></td>
                        <td><?php 
                            if($tran['tran_status']!='success'){
                            echo '<span class="label label-danger">'.$tran['tran_status'].'</span><br>';    
                            //echo '<a href="#" class="btn btn-info btn-xs" style="margin-top:10px;"><i class="fa fa-upload"></i> Post Manually</a>';
                            echo '<a href="'.base_url().'merchant/daily-report/'.$_record[0]['mrcnt_sn'].'?date='.date('d-m-Y',$tran['tran_date']).'" class="btn btn-info btn-xs" style="margin-top:10px;"><i class="fa fa-upload"></i> Post Manually</a>';
                            }else{
                            echo '<span class="label label-success">'.$tran['tran_status'].'</span>';    
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
                        <td><?php echo $tran['invoice_number'];?></td>
                        <td><?php echo $tran['details'];?></td>                        
                        <td><?php echo date('d M, Y h:i a',strtotime($tran['date_added']));?></td>
                        <td><?php echo $tran['user_name'].' ('.$tran['user_type'].')';?></td>
                        <td><button type="button" class="removeTransaction btn btn-xs btn-default" title="Remove Transaction"
                                    value="<?php echo $tran['tran_sn'];?>">
                                <i class="fa fa-trash-o"></i></button></td>
                    </tr>                
                    <?php
                endforeach;
                ?>                
            </tbody>
        </table>
        
        <?php echo $this->pagination->create_links();?>
    </div>
</section>
<script> require(['page/customer_view']); </script>