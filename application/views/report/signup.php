<li>Report</li> 
<li class="active">Signup Report</li>
</ul>

<div class="panel panel-default">    
    <div class="panel-body">        
        <form class="form-inline pull-right" method="GET" action="<?php echo base_url();?>report/signups">
            <fieldset>                                      
                <label class="control-label label label-primary">From: </label>&nbsp;
                <input type="text" id="from" name="from" value="<?php echo revertMyDate($filter['from']);?>" 
                       class="input-sm" placeholder="From">
                
                &nbsp;&nbsp;
                <label class="control-label label label-primary">To: </label>&nbsp;
                    <input type="text" id="to" name="to" value="<?php echo revertMyDate($filter['to']);?>" 
                       class="input-sm" placeholder="To">                                    
                
            
                
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                </fieldset>                
            
        </form>
    </div>
</div>

<section class="panel">
    <header class="panel-heading clearfix">
        New Customers
    </header>    
    <table class="table table-striped table-advance table-hover">
        <thead>
            <tr>
                <?php /*<th style="width: 90px!important;"><i class=" fa fa-edit"></i></th>*/?>
                <th>Contact Name</th>
                <th>Card ID</th>
                <th>Campaigns</th>
                <th>Car No.</th>
                <th>Hp No.</th>
                <th style="width: 180px;">Additional Info</th>
                <th style="width: 170px!important;">Date Added.</th>
            </tr>
        </thead>
        <tbody id="customer-list">
            <?php
            foreach ($_list as $row): ?>
            <tr id='row_<?php echo $row['cust_sn'];?>'>
                <?php /*
                <td>
                    <a href="<?php echo base_url().'customer/edit/'.$row['cust_sn'].'/#subscribe';?>" 
                       title="Subscribe"
                       class="btn btn-info btn-xs"><i class="fa fa-thumb-tack"></i></a>
                    <a href="<?php echo base_url().'customer/edit/'.$row['cust_sn'];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                    <button class="btn btn-danger remove_cust btn-xs" value='<?php echo $row['cust_sn'];?>'>
                        <i class="fa fa-trash-o "></i></button>
                </td> */?>
                <td><a href="<?php echo base_url().'customer/details/'.$row['cust_sn'];?>">
                        <span class='name'><?php echo $row['cust_first_name'].' '.$row['cust_last_name'];?></span></a></td>
                <td><?php echo $row['cust_card_id'];?></td>
                <td>
                    <?php echo $row['cmpn_name'];?>
                </td>
                <td><?php echo $row['cust_car_no'];?></td>
                <td><?php echo $row['cust_mobile'];?></td>
                <td><?php echo $row['cust_additional'];?></td>
                <td><?php echo $row['date_added']!=0?date('d M Y : h:i A',$row['date_added']):'';?></td>
            </tr>            
                <?php
            endforeach;
            ?>            
        </tbody>
    </table>
</section>
<section class="panel">
  <div class="panel-body">
      <div class="text-center">
          <?php echo $this->pagination->create_links();?>
      </div>
  </div>
</section>
<script> require(['page/report']); </script> 
