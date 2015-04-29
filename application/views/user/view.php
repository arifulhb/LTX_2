<li><a href="<?php echo base_url().'user';?>">User</a></li>
<li class="active">User Details</li>
</ul>

<section class="panel">
    <header class="panel-heading clearfix">
        User Details
        <a class="btn btn-primary pull-right" href="<?php echo base_url().'user/edit/'.$_record[0]['user_sn'];?>" role="button">Edit this User</a>
    </header>
    <div class="panel-body">
        <form class="form-horizontal" role="form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputUserName" class="col-lg-3 col-sm-3 control-label">Username</label>
                        <div class="col-lg-9">
                            <p class="form-control-static"><?php echo $_record[0]['user_name'];?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputOutlet" class="col-lg-3 col-sm-3 control-label">Email Address</label>
                        <div class="col-lg-9">
                            <p class="form-control-static"><?php echo $_record[0]['user_email'];?></p>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputOutletUserRole" class="col-lg-3 col-sm-3 control-label">User Role</label>
                        <div class="col-lg-9">
                            <p class="form-control-static">
                                <?php 
                                if($_record[0]['user_type']==1){
                                    echo 'Admin';
                                }else if($_record[0]['user_type']==2){
                                    echo 'Merchant';
                                }else{
                                    echo $_record[0]['user_type'];
                                }
                            
                            ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>