require(['order!jquery','order!apppath'], function($,apppath){ 
    
    ///////////////////////////////////////////////////////////////
    //REMOVE CUSTOMER
    ///////////////////////////////////////////////////////////////
    $('.remove_cust').click(function(){
        var id=$(this).val();
        
        var _name=$('#row_'+id).find('.name').text();
        $('#remove_name').text(_name);
        $('#remove_id').val(id);
        $('#remove_customer_modal').modal('show');        
        
    });// row delete button click
    
    $('#btn_delete').click(function(){
        var id=$('#remove_id').val();
                
        $.ajax({
            type: "POST",
            url: apppath+'/customer/delete',
            data: '_sn='+id,
            success: function(data) {
                if(data==1){
                    $('#row_'+id).remove();
                    $('#remove_customer_modal').modal('hide');
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });
    });
    
});