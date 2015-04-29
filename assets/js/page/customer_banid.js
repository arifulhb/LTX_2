require(['order!jquery','order!apppath'], function($,apppath){
    
    //CALL FUNCTION
    $('#btn-add-block-code').click(function(){
        addBlockCardID();
    });
    
    $('.btn-remove-block-id').click(function(){
        
        var q=confirm('Are you sure to Un Ban this Card ID?');
        if(q==true){
            removeBlockID($(this).val());
        }
    });
    
    //
    // FUNCTIONS
    //
    var addBlockCardID =function(){
        
        $.ajax({
            type: "POST",
            url: apppath+'/customer/addidinblocklist',
            data: '_card_id='+$('#newCardID').val(),
            success: function(data) {
                console.log(data);
                if(data==true){                    
                    //Success                     
                    $('.block_list').append('<li>'+$('#newCardID').val()+'</li>');
                    $('#newCardID').val('');
                    $('#newCardID').focus()
                }else if(data==false){                   
                    alert('Card ID was not added');
                }else{
                    $('.error').css('display','block');
                    $('#error_message').html(data);
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });
        
    };//end function
    
    var removeBlockID =function(id){
        
        $.ajax({
            type: "POST",
            url: apppath+'/customer/unbancardid',
            data: '_card_id='+id,
            success: function(data) {
                //console.log(data);
                if(data==true){                    
                    $('#id_'+id).remove();                    
                }else if(data==false){                   
                    alert('Card ID was not Unban');
                }else{
                    $('.error').css('display','block');
                    $('#error_message').html(data);
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });
        
    };
    
}); 