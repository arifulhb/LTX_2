<?php
$search_by=$this->input->get('by');
$keyword=$this->input->get('s');
?>
<div class="panel panel-default">
    <div class="panel-heading">Search</div>
    <div class="panel-body">
        <form class="form-inline" method="GET" 
              action="<?php echo base_url().'customer/search';?>">
            <div class="form-group col-sm-3">
                <select class="form-control" id="search_by" name="by">
                    <option <?php echo $search_by=='name' || $search_by==''?'SELECTED':'' ;?> value="name">Search by Name</option>
                    <option <?php echo $search_by=='nric'?'SELECTED':'' ;?> value="nric">Search by NRIC</option>
                    <option <?php echo $search_by=='card_number'?'SELECTED':'' ;?>  value="card_number">Search by Card Number</option>
                    <option <?php echo $search_by=='car_number'?'SELECTED':'' ;?>  value="car_number">Search by Car number</option>
                </select>
            </div>
            <div class="form-group col-sm-6">
                <div class="input-group">
                    <input type="text" id="search_keyword" name="s" value="<?php echo $keyword;?>"
                           class="form-control" placeholder="Customer Search Keyword">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>