<li>Report</li> 
<li class="active">Transactions Report</li>
</ul>
<div class="panel panel-default">    
    <div class="panel-body">        
        <form class="form-inline pull-right" method="GET" action="<?php echo base_url();?>report/transactions">
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
                <th>Date/Time</th> 
                <th>Trans ID</th>
                <th>Customer</th>
                <th>Campaign Name</th>
                <th>Activity</th>
                <th>Details</th>
                <th>Recorded by</th>
                <th>Outlet</th>
                <th>Description</th>                                
            </tr>
        </thead>
        <tbody id="customer-list">
            <?php
            foreach ($_list as $row): ?>
            <tr id='row_<?php echo $row['cust_sn'];?>'>
                
                <td><?php echo date('d M, Y h:ia ',$row['trn_date']);?></td>
                <td><a href="<?php echo base_url().'customer/details_campaign/'.$row['cust_sn'].'/'.$row['cmpn_sn'];?>"><?php echo $row['trn_sn'];?></a></td>                
                <td><?php echo $row['cust_name'];?></td>
                <td><?php echo $row['cmpn_name'];?></td>
                <td><?php echo $row['tran_activity'];?></td>
                <td><?php echo $row['tran_value'];?></td>
                <td><?php echo $row['recorded_by'];?></td>
                <td><?php echo $row['ol_name'];?></td>
                <td><?php echo $row['tran_description'];?></td>
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
