<li  class="active"><a href="<?php echo base_url() . 'user'; ?>">User</a></li>
</ul>

<section class="panel">
    <header class="panel-heading clearfix">
        User
        <a class="btn btn-primary pull-right" href="<?php echo base_url().'user/add'?>" role="button">Add New User</a>
    </header>
    <div class="panel-body">
        
    
    <table class="table table-striped table-advance table-hover">
        <thead>
            <tr>
                <th><i class=" fa fa-edit"></i></th>                
                <th>User Name</th>                                
                <th>User Email</th>                                
                <th>Role</th>
                <th>Merchant</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($_list as $row): ?>
                <tr id="row_<?php echo $row['user_sn'];?>">                    
                    <td>
                        <a href="<?php echo base_url().'user/edit/'.$row['user_sn'];?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                        <button value="<?php echo $row['user_sn'];?>" class="btn remove_user btn-danger  btn-xs"><i class="fa fa-trash-o "></i></button>
                    </td>
                    <td><a href="<?php echo base_url().'user/details/'.$row['user_sn'];;?>">
                            <span class="user_name"><?php echo $row['user_name'];?></span></a></td>
                    <td><?php echo $row['user_email'];?></td>
                    <td>
                        <?php if ($row['user_type']==1){
                            echo 'Admin';
                        }else if($row['user_type']==2){
                            echo 'Merchant';
                        }else{
                            $row['user_type'];
                        }
                        ?>
                    </td>                    
                    <td><a href="<?php echo base_url().'customer/view/'.$row['mrcnt_sn'];?>"><?php echo $row['mrcnt_name'];?></a></td>
                </tr>            
                
                
                <?php                
            endforeach;
            ?>            
        </tbody>
    </table>
    </div>
</section>
<section class="panel">
  <div class="panel-body">
      <div class="text-center">
          <?php echo $this->pagination->create_links();?>
      </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Remove user</h4>
      </div>
      <div class="modal-body">
          Are you sure to delete <strong><span id="remove_name"></span></strong> User?
          <input type="hidden" value="" id="remove_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btn_delete" class="btn btn-danger">Remove</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script> require(['page/user_index']); </script> 