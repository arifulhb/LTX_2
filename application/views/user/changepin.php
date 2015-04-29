    <section class="panel">
        <header class="panel-heading clearfix">Change Pin</header>
        <div class="panel-body">
            <?php
            $cp=$this->session->flashdata('cp');
            $_error=$this->session->flashdata('_error');
            if($cp==TRUE && strlen($_error)==0){                 
                ?>            
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Congatulations!</strong> Your PIN has been updated!
                  </div>
                <?php                
            }//end if
            else{?>
                       
            <h2 style="margin: 0px 0 5px 0;">Welcome, <?php echo $this->session->userdata('user_name');?></h2>
            <p>Change Your PIN Here</p>
            <hr>
             <?php
            
                if($_error!=''){
                    ?>            
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Sorry!</strong> 
                        <?php echo $this->session->flashdata('_error');?>
                    </div>
                      
                <?php
                }
            ?>
            <form class="form-horizontal" role="form" method="post"
                  action="<?php echo base_url().'user/cpinvalidation'?>">                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="newPassword" class="col-sm-4 control-label">New PIN</label>
                            <div class="col-lg-8">
                            <input type="password" class="form-control" name="newPassword"
                                   id="newPassword" required="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="confirmPassword" class="col-sm-4 control-label">Confirm PIN</label>
                            <div class="col-lg-8">
                            <input type="password" class="form-control" name="confirmPassword" required=""
                                   id="confirmPassword">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="confirmPassword" class="col-sm-4 control-label"></label>
                            <div class="col-lg-8">
                                <button class="btn btn-warning" type="submit"><i class="fa fa-lock"></i> Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            }//end else
            ?>
        </div>
    </section>