<li><a href="<?php echo base_url().'user';?>">User</a></li>
</ul>
<?php 
//print_r($_record);
//exit();
if($_action=='update'){ ?>
    
    <?php

    $_name      = $_record[0]['user_name'];
    
    $_role_type = $_record[0]['user_type'];    
    $_user_sn    = $_record[0]['user_sn'];
    $_userEmail     = $_record[0]['user_email'];
    $_mrcnt_name    = $_record[0]['mrcnt_name'];

}//end if
else{
    
    $_name      = '';    
    $_role_type   = '';    
    $_user_sn    = '';
    $_userEmail = '';
    $_mrcnt_name    = "";
}
?>

<section class="panel">
    <header class="panel-heading clearfix">
        <?php echo $_action=='add'?'Add New User':'Edit User';?>
    </header>
    <div class="panel-body">
        <?php
        if(isset($_error)){ ?>
            <div class="alert alert-warning fade in">
            <button data-dismiss="alert" class="close close-sm" type="button">
                <i class="fa fa-times"></i>
            </button>
            <strong>Warning!</strong><br>
            <?php echo $_error;?>
        </div>
            <?php                
                        
            $_name      = $_record[0]['user_name'];            
            $_user_sn    = $_record[0]['user_sn'];
            $_userEmail = $_record[0]['user_email'];
            $_role_type   = $_record[0]['user_type'];             
            
        }//
        ?>
        <form class="form-horizontal" role="form" method="POST"
              action="<?php echo base_url().'user/save';?>" >
            <input type="hidden" id="_action" name="_action" value="<?php echo $_action;?>"/>
            <?php if($_action=='update'){ ?>
            <input type="hidden" id="_sn" name="_sn" value="<?php echo $_sn;?>"/>
                <?php
            }?>
            <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputUserName" class="col-lg-3 col-sm-3 control-label">Display Name *</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" id="inputUserName" maxlength="250"
                                   name="inputUserName" placeholder="Display Name" value="<?php echo $_name;?>" required="">
                        </div>
                    </div>
                </div>                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputOutlet" class="col-lg-3 col-sm-3 control-label">Email Address</label>
                        <div class="col-lg-9">                                                        
                            <input type="email" class="form-control" id="inputUserEmail" maxlength="250"
                                   name="inputUserEmail" placeholder="User Email" value="<?php echo $_userEmail;?>" required="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">                        
                        <label for="inputOutletUserRole" class="col-lg-3 col-sm-3 control-label">User Role</label>
                        <div class="col-lg-9">
                            <select class="form-control" id="inputUserRole" name="inputUserRole">
                                <option value="1" <?php echo $_role_type==1?'SELECTED':'';?>>Admin</option>
                                <option value="2" <?php echo $_role_type==2?'SELECTED':'';?>>Merchant</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">                        
                        <label for="" class="col-lg-3 col-sm-3 control-label">Merchant Info</label>
                        <div class="col-lg-9">                            
                            <label class="control-label"><?php echo $_mrcnt_name;?></label>
                                
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <input type="submit" class="finish btn btn-primary" value="<?php echo ucfirst($_action);?> User">
                    </p>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="panel panel-warning">
    <header class="panel-heading clearfix"><i class="fa fa-unlock-alt"></i> Change Password</header>
    <div class="panel-body">
        <div class='row'>
            <div class='col-sm-6'>
                <div class='form-horizontal'>
                  <div class="form-group">
                      <label for="up_new_password" class="col-md-4 control-label">New Password</label>
                      <div class="col-md-8">
                          <input type="password" class="form-control" id="up_new_password"  value=""
                                 name="up_new_password" placeholder="Password"  maxlength="20">
                      </div>
                  </div>            
                  <div class="form-group">
                      <label for="up_re_new_password" class="col-md-4 control-label">Re New Password</label>
                      <div class="col-md-8">
                          <input type="password" class="form-control" id="up_re_new_password"  value=""
                                 name="up_re_new_password" placeholder="Re Password" maxlength="20">
                      </div>
                  </div>            
                  <div class="form-group">
                      <label for="up_re_new_password" class="col-md-4 control-label"></label>
                      <div class="col-md-8">
                          <button type="button" class="btn btn-sm btn-default" id='change_password'>
                              <i class='fa fa-lock'></i> Change Password</button>
                      </div>
                  </div>            
                  </div>  
            </div>
            <div class='col-sm-6'>      
              <div class="error" style="display: none;">
                  <div class="alert alert-warning alert-dismissable" style="margin-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p id="error_message_password"></p>
                    
                  </div>
              </div>
                <div class="success" style="display: none;">
                  <div class="alert alert-success alert-dismissable" style="margin-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Congratulations!</strong> Password updated successfully.
                    
                  </div>
              </div>
            </div>
        </div>
    </div>
</section>

<script> require(['page/user_form']); </script> 