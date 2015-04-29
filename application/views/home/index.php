<section class="panel scancard">
               
    <div class="panel-body">   
      
        <?php                
        $_status            = $this->session->flashdata('_error');
        $_card_suspended    = $this->session->flashdata('_card_suspended');
        if($_status==TRUE){
           //BACK TO PAGE AFTER NOT FINDING ANY CAMPAIGN LIST
            ?>
               <div class="alert alert-warning fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Sorry!</strong> Customer <strong>CARD ID</strong> or <strong>ID Number</strong> Does not match or Campaign List not found.
              </div> 
                
                <?php
        }// end if            

        if($_card_suspended!=''){
           //BACK TO PAGE AFTER NOT FINDING ANY CAMPAIGN LIST
            ?>
               <div class="alert alert-warning fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Sorry!</strong> <?php echo $_card_suspended;?>
              </div>                 
                <?php
        }// end if            

        
        $_front_save=$this->session->flashdata('front_save');
                            
        if($_front_save==TRUE){
           //BACK TO PAGE AFTER NOT FINDING ANY CAMPAIGN LIST
            ?>
               <div class="alert alert-success fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Congratulations!</strong> New Customer is added to database.
              </div> 
                
                <?php
        }// end if    
        ?>
        
        <form role="form" method="POST" class="keypad"
              action="<?php echo base_url().'customer/campaign_list';?>">
            <div class="form-group">
                <label for="customer_card_id" class="sr-only">Scan Card</label>
                <input type="text" class="form-control input-lg text-center key_display" 
                       id="customer_card_id" name="customer_card_id" placeholder="Scan Card">
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-1">1</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-2">2</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-3">3</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-4">4</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-5">5</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-6">6</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-7">7</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-8">8</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-9">9</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key-back">Back</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key  key-0">0</a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-block btn-default btn-lg key-clear">Clear</a>
                </div>
            </div>
            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
        </form>

    </div>
</section>