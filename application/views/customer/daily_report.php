<?php
if($this->session->userdata('user_type')==1){ ?>
<li><a href="<?php echo base_url() . 'merchant';?>">Merchant</a></li>
<li><a href="<?php echo base_url() . 'merchant/view/'.$this->uri->segment(3); ?>"><?php echo $_record[0]['mrcnt_name'];?></a></li>
<li class="active">Manual Post</li>
</ul>
<?php 
} else if($this->session->userdata('user_type')==2){  ?>
<li><a href="<?php echo base_url() . 'profile';?>">My Profile</a></li>
<li class="active">Daily Report</li>
</ul>

<?php
}//end if

    $_date=$this->input->get('date');

    
?>

<?php

	if($_record[0]['partner_sn'] != $this->session->userdata('partner_sn')){ ?>

		<div class="row">
			<div class="col-lg-4 col-lg-offset-4">
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>Warning</h3><strong></strong>
					You need to change the server to<strong><a data-toggle="modal" data-target="#changeServer" href="#">
							<span> <?php echo $_record[0]['partner_country']?></span></a></strong> .
				</div>
			</div>
		</div>
	<?php
	}

?>

<input type="hidden" id="date_from" value="">
<input type="hidden" id="date_to" value="">
<input type="hidden" id='company_id' value="<?php echo $_record[0]['mrcnt_pos_company_id'];?>">
<section class="panel panel-info">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-8">
                <p class=""><i class="fa fa-user"></i> <strong><?php echo $_record[0]['mrcnt_name'];?></strong> Daily Report</p>
            </div>
            <div class="col-sm-4">
                <div class="">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" id="report_date" value="<?php echo $_date;?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-primary" id="search_daily_report"
                                title="Search"><i class="fa fa-search"></i> Search</button></span>
                    </div>        
                </div>
            </div>
        </div>
                
    </div>    
    <div class="panel-body">
        
        <div class="row">
            <div class="col-sm-6">
                <h3>Payments</h3>
                <div id="receipts">
                    <table class="table table-condensed table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Payment Mode</th>
                                <th>Amount</th>                                
                            </tr>
                        </thead>
                        <tbody id="receiptPayments">                        
                        </tbody>
                    </table>
                    <button id="submit_to_xero" class="btn btn-info pull-right" disabled
                            title="Submit to Xero"><i class="fa fa-arrow-circle-right"></i> Submit to Xero</button>
                </div>
            </div>
            <div class="col-sm-6">
                
                <div id="result">
                    
                </div>
            </div>
        </div>      
        
    </div>
</section>
<div class="spinner" style="position: absolute;top: 25%;left: 50%;">
   <div style="height:200px">
      <span id="searching_spinner_center" style="position: absolute;display: block;top: 50%;left: 50%;"></span>
    </div>
</div>
<script> require(['page/customer_daily_report']); </script>