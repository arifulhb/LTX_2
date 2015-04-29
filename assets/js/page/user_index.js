require(['order!jquery','order!apppath','order!jquery-ui'], function($,apppath){ 
    
    $('.remove_user').click(function(){
        var id=$(this).val();
        
        var _name=$('#row_'+id).find('.user_name').text();
        $('#remove_name').text(_name);
        $('#remove_id').val(id);
        $('#remove_modal').modal('show');        
        
    });// row delete button click
    
    $('#btn_delete').click(function(){
        var id=$('#remove_id').val();
                
        $.ajax({
            type: "POST",
            url: apppath+'/user/delete',
            data: '_sn='+id,
            success: function(data) {
                if(data==1){
                    $('#row_'+id).remove();
                    $('#remove_modal').modal('hide');
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });
    });
});