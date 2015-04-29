require(['order!jquery','order!apppath','order!jquery-ui','order!inputmask'], function($,apppath){
      
    //date picker          
//    var dob=$('#inputBirthday').val();
//    
//    if(dob!=''){
//        var year=dob.substring(6,10);
//        var month=dob.substring(3,5);
//        var day=dob.substring(0,2);    
//        $('#inputBirthday').datepicker("setValue", new Date(year,month,day));               
//    }else{
//        $('#inputBirthday').datepicker();       
//    }
     $('#inputBirthday').inputmask('dd/mm/yyyy',
        {"placeholder": "dd/mm/yyyy",
        "oncomplete": function(){                                         
                        
        }});
     ///////////////////////////////////////////////////////////////
    //Unsubscribe
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
            url: apppath+'/customer/unsubs',
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
    
    /*
     * CHANGE CARD 
     */
    $('#change_card').click(function(){        
        $('.modal_card_id').modal('show');
    });//end change_card.click
    
    
    $('#btnSaveNewCard').click(function(){
        var cust_sn=$('#_sn').val();
        var old_card_id=$('#active_card_id').text();
        var new_card_id=$('#newCardID').val();
        
        //alert('cust sn: '+cust_sn+ ' old card id: '+old_card_id+' new id: '+new_card_id);
        
        $.ajax({
            type: "POST",
            url: apppath+'/customer/changecardid',
            data: '_cust_sn='+cust_sn+'&_old_card_id='+old_card_id+'&_new_card_id='+new_card_id,
            success: function(data) {
                console.log(data);
                if(data==1){                    
                    //console.log('Success');
                    //Success
                    $('#active_card_id').text('');
                    $('#active_card_id').text(new_card_id);
                    $('.modal_card_id').modal('hide');
                    $('.card_id_list').append('<li class="" style=style="height: 22px;border-bottom: #eee dotted 1px;" id="card_'+old_card_id+'">'+old_card_id+'</li>');

                }else if(data=='blocked'){
                    //Blocked
                    //console.log('show blockd');
                    $('.error').css('display','block');
                    $('#error_message').html('<strong>Sorry!</strong><br>This Card ID is blocked!');
                }else{
                    $('.error').css('display','block');
                    $('#error_message').html('<strong>Sorry!</strong><br>'+data);
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });
        
        
    });//end function
    
    $('.btn-card-remove').click(function(){
       var cust_sn= $('#_sn').val();
       var card_id= $(this).val();
        //alert(card_id);
       var r=confirm("Are you sure to remove?");
        if (r==true)
          {
            
              $.ajax({
                type: "POST",
                url: apppath+'/customer/removecardid',
                data: '_cust_sn='+cust_sn+'&_card_id='+card_id,
                success: function(data) {
                    //console.log(data);
                    if(data==true){                    
                        //Success                        
                        $('#card_'+card_id).remove();
                    }else{
                        //
                        console.log(data);
                        alert('Card ID was not removed');
                    }
                },
                error:function(error){
                    console.log('ERROR: '+error);
                }
            });
          
          }//end if          
    });
    
    $('#change_id').click(function(){                
        $('.modal_id_number').modal('show');                
    });
    
    $('#btnSaveNewID').click(function(){
        
        var cust_sn=$('#_sn').val();
        var id=$('#newIDNumber').val();
        changeIdNumber(cust_sn,id);
    });
    
    //
    //FUNCTION
    //
    
    var changeIdNumber=function(cust_sn,id){
        
        
         $.ajax({
            type: "POST",
            url: apppath+'/customer/changeIdNumber',
            data: '_id_number='+id+'&_cust_sn='+cust_sn,
            success: function(data) {
                console.log(data);
                if(data==true){                    
                    $('#cust_id_number').text('');           
                    $('#cust_id_number').text(id);  
                    $('.modal_id_number').modal('hide'); 
                    
                }else if(data==false){                   
                    alert('ID Number was not Updated');
                }else{
                    $('.error').css('display','block');
                    $('#error_message_id_number').html(data);
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });                
        
    };
    
    
    $('#inputAdditionalInfo').bind('change keypress focusout',function(){
        $('#inputAdditionalInfo_hide').val($(this).text());
    });
    
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
           
    var changePassword=function(cust_sn,pass,repass){
        
        
         $.ajax({
            type: "POST",
            url: apppath+'/customer/changepassword',
            data: '_pass='+pass+'&_repass='+repass+'&_cust_sn='+cust_sn,
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