<li class="active">Merchant</li>
</ul>

<section class="panel">
    <header class="panel-heading clearfix">
        Merchant
        <a class="btn btn-primary pull-right" href="<?php echo base_url().'merchant/new';?>" 
           role="button">Add New Merchant</a>
    </header>    
    
    <table class="table table-striped table-advance table-hover">
        <thead>
            <tr>
                <th style="width: 90px!important;"><i class=" fa fa-edit"></i></th>
                <th>Merchant Name</th>
                <th>Email</th> 
                
                <th>Accounts</th>                              
                <th>Transactions</th>
                <th>Manual Post</th> 
                <th style="width: 170px!important;">Date Added.</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="customer-list">
            <?php
            foreach ($_list as $row):

                $row_color='';

                if( $row['mrcnt_status']=='inactive' ||
                    $row['mrcnt_xero_api_key'] == '' ||
                    $row['mrcnt_xero_api_secret'] == '' ||
                    $row['mrcnt_xero_revenew_code_id'] == '' ||
                    $row['mrcnt_pos_company_id'] == '' ||
                    $row['mrcnt_status']== null ){

                    $row_color='danger';
                }

                ?>

            <tr id='row_<?php echo $row['mrcnt_sn'];?>' class="<?php echo $row_color; ?>">
                <td>                    
                    <a href="<?php echo base_url().'merchant/edit/'.$row['mrcnt_sn'];?>" 
                       class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                    <button class="btn btn-danger remove_cust btn-xs" value='<?php echo $row['mrcnt_sn'];?>'>
                        <i class="fa fa-trash-o "></i></button>
                </td>
                <td><a href="<?php echo base_url().'merchant/view/'.$row['mrcnt_sn'];?>">
                        <span class='name'><?php echo $row['mrcnt_name'];?></span></a>
                </td>
                        
               <td><?php echo $row['mrcnt_email'];?></td>
               
                               
               <td>Accounts</td>
               <td>
                   <?php
                   if(($row['tran_success']+$row['tran_failed'])==0){ ?>
                    <span class="label label-default">0 Transactions</span>
                       <?php
                   }else{                       
                   
                    if($row['tran_success']>0){?>
                    <span class="label label-success">Success <?php echo $row['tran_success'];?></span>
                        <?php
                    }
                    if($row['tran_failed']>0){ ?>
                    <span class="label label-danger">Failed <?php echo $row['tran_failed'];?></span>
                        <?php
                    }
                   }
                   ?>                   
                   
               </td>
                <td>
                    <?php
                    if($row['mrcnt_status']=='active'){ ?>
                    <a href='<?php echo base_url().'merchant/daily-report/'.$row['mrcnt_sn'];?>' 
                       class='btn btn-xs btn-default' title='Todays Sales Report'
                       ><i class='fa fa-upload'></i> Manual Post</a>
                        <?php 
                    }//end if
                    ?>
                    
                </td>
                <td><?php echo $row['addDate']!=0?date('d M Y : h:i A',strtotime($row['addDate'])):'';?></td>
                <td><?php echo ucfirst($row['mrcnt_status']);?></td>
            </tr>            
                <?php
            endforeach;
            ?>            
        </tbody>
    </table>
    <div class="text-center pull-up-double pull-down-double"><?php echo $this->pagination->create_links();?></div>
</section>