<section id="container" >
        <!--header start-->
        <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="/admin" class="logo"><?php echo $_site_title;?></a>
            <!--logo end-->
            
            <div class="top-nav ">

                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="<?php echo base_url().'assets/images/avatar1_small.jpg';?>">
                            <span class="username"><?php echo $this->session->userdata('user_name');?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="<?php echo base_url().'user/changepassword';?>"><i class="fa fa-pencil"></i> Change password</a></li>
                            <li><a href="<?php echo base_url().'user/signout';?>"><i class="fa fa-key"></i> Sign Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->