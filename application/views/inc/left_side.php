<!--sidebar start-->

<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <?php
            if($this->session->userdata('user_type')==1){
                //FOR ADMIN
                ?>
                <li>
                    <a class="<?php if ($thisPage=="homePage")      echo "active"; ?>"
                       href="<?php echo base_url().'admin';?>">
                        <i class="fa fa-home"></i><span>Home</span>
                    </a>
                </li>
                <li>
                    <a class="<?php if ($thisPage=="customerPage")  echo "active"; ?>"
                       href="<?php echo base_url().'merchant';?>">
                        <i class="fa fa-user"> </i><span>Merchant</span>
                    </a>
                </li>
                <li>
                    <a class="<?php if ($thisPage=="transaction")  echo "active"; ?>"
                       href="<?php echo base_url().'transaction';?>">
                        <i class="fa fa-list"></i><span>Transactions</span>
                    </a>
                </li>
                <?php /*
                <li>
                    <a class="<?php if ($thisPage=="manualPost")    echo "active"; ?>"
                       href="<?php echo base_url().'manual-post';?>">
                        <i class="fa fa-upload"></i><span>Manual Post</span>
                    </a>
                </li> */?>
                <li>
                    <a class="<?php if ($thisPage=="userPage")      echo "active"; ?>"
                       href="<?php echo base_url().'user';?>">
                        <i class="fa fa-users"></i><span>User</span>
                    </a>
                </li>
                <hr style="margin: 0; padding: 5px 0;"/>
                <li>
                    <?php

                    if($this->session->userdata('posios_api_token')==''){
                        $connection_string = "Connection faild at ";
                        $button_class       ="text-warning";
                    }else{
                        $connection_string = "Connected at ";
                        $button_class       ="text-success";
                    }

                    ?>
                    <label class="label">
                        <i class="fa fa-globe"></i> <?php echo $connection_string;?>
                        <span class="<?php echo $button_class;?>"> <?php echo $this->session->userdata('partner_country');?></span>
                    </label>
                </li>
                <li>

                    <a  style="margin: 0; padding: 5px 15px;"
                            data-toggle="modal" data-target="#changeServer" href="#">
                        <i class="fa fa-server"></i><span> Change Server</span>
                    </a>
                </li>
            
            <?php
            }else if($this->session->userdata('user_type')==2){
                //for merchant
                ?>
                <li>
                    <a class="<?php if ($thisPage=="homePage")      echo "active"; ?>"
                       href="<?php echo base_url().'admin';?>">
                        <i class="fa fa-home"></i><span>My Admin</span>
                    </a>
                </li>                
                <li>
                    <a class="<?php if ($thisPage=="profile")      echo "active"; ?>"
                       href="<?php echo base_url().'profile';?>">
                        <i class="fa fa-user"></i><span>My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="<?php if ($thisPage=="manual")      echo "active"; ?>"
                       href="<?php echo base_url().'profile/manual-post/'.$this->session->userdata('mrcnt_sn');?>">
                        <i class="fa fa-cog"></i><span>Manual Post</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url().'user/signout';?>">
                        <i class="fa fa-power-off"></i><span>Sign out</span>
                    </a>
                </li>
                <?php
            }//end if
            ?>
            
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->

<!-- Modal -->
<div class="modal fade" id="changeServer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-server"></i> Change Server</h4>
            </div>
            <form method="post" action="<?php echo base_url().'admin/changeServer'?>">
                <div class="modal-body">

                        <div class="form-group">
                            <label for="serverList" class="control-label">Select a Server</label>
                            <select class="form-control" id="serverList" name="partner_server">
                                    <option value="1" >Singapore</option>
                                    <option value="2" >Australia</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Connect</button>
                </div>
            </form>
        </div>
    </div>
</div>