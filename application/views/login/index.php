<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <a class="nav-brand" href="<?php echo base_url();?>" title="<?php echo $_site_title;?>"><?php echo $_site_title;?></a>
    <div class="row m-n">
      <div class="col-md-4 col-md-offset-4 m-t-lg">
        <section class="panel">
          <header class="panel-heading text-center">
            Sign in
          </header>
            <form action="<?php echo base_url().'signin/signin_validation';?>" method="post" class="panel-body">                
            <div class="form-group">
              <label class="control-label">User Email</label>
              <input type="email" id="user_id" name="user_id" placeholder="User Email" 
                     class="form-control" required maxlength="255" value="<?php echo $this->session->flashdata('user_id');?>">
            </div>
            <div class="form-group">
              <label class="control-label">Password</label>
              <input type="password" id="user_pass" name="user_pass" placeholder="Password" 
                     class="form-control" required maxlength="50">
            </div>
                <?php
                //echo 'Server Time: '.date('Y-m-d h:i:s A').'<br>';
                echo 'Server Time: '.date( "Y-m-d h:i:s A", time() ).'<br>';
                if($this->session->flashdata('notice')!='')
                { ?>
                  <div class="alert alert-warning fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Sorry!</strong> <?php echo $this->session->flashdata('notice');?>.
                </div>  
                    <?php                    
                }//end if notice
                ?>                
            <div class="checkbox">
              <label>
                <input type="checkbox"> Keep me logged in
              </label>
            </div>
            <a href="#" class="pull-right m-t-xs"><small>Forgot password?</small></a>
            <button type="submit" class="btn btn-info"><i class="icon-signin"></i> Sign in</button>
            
          </form>
        </section>
      </div>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder clearfix">
      <p>
        <small>Developed by <a href="http://launchstars.sg" target="_blank">Launchstars</a> &copy; 2014</small>
      </p>
    </div>
  </footer>