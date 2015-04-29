require(['order!jquery','order!apppath','order!jquery-ui'], function($,apppath){ 
    
     $('#change_password').click(function(){
         
        var cust_sn=$('#_sn').val();        
        var pass=$('#up_new_password').val();
        var repass=$('#up_re_new_password').val();
        
        if(pass!='' && repass!=''){
            changePassword(cust_sn,pass,repass);
        }else{
            $('.error').css('display','block');
            $('#error_message_password').html('Please Add Password & Confirm Password');
        }
    });
               
    var changePassword=function(user_sn,pass,repass){
        
        
         $.ajax({
            type: "POST",
            url: apppath+'/user/updatepassword',
            data: '_pass='+pass+'&_repass='+repass+'&_user_sn='+user_sn,
            success: function(data) {
                console.log(data);
                if(data==true){                    
                    $('#up_new_password').val('');
                    $('#up_re_new_password').val('');
                    $('.success').css('display','block')
                    
                }else if(data==false){                   
                    alert('Password was not updated');
                }else{
                    $('.error').css('display','block');
                    $('#error_message_password').html(data);
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });       
        
    }//end function
           
});