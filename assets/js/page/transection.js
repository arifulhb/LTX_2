require(['order!jquery','order!moment','order!apppath','order!jquery-ui','order!dtpicker'], function($,moment,apppath){ 
   
    //ADD
   $('#btn-add').click(function(){
       
       var id=$(this).val();
       
       var add= $('#add_value').val();
       
       if(add!=''){             //ADD NOT EQUAL NULL
           var subs_sn=$('#subs_sn').val();
                     
           
       $.ajax({
                type: "POST",
                url: apppath+'/customer/addTransection',
                data: '_subs_sn='+subs_sn+'&_value='+add+'&_tran_type=add',
                success: function(data) {
                    console.log(data);
                    if(data!=false){                                                
                        $('#current_balance').text('');
                        $('#current_balance').text(data);
                        var m=moment();
                        var row='<tr>';
                            row+='<td></td><td></td>';
                            row+='<td>'+m.format('D MMM YYYY hh:mma')+'</td>';
                            row+='<td>Check In</td>';
                            row+='<td>'+add+'</td>';
                            row+='<td></td><td></td>';
                            row+='</tr>';
                            
                        $('#transections').append(row);
                        $('#add_value').val('');
                    }//end if
                    else{
                        alert('Sorry! Coudn\'t save into Database.');
                    }
                },
                error:function(error){
                    console.log('ERROR: '+error);
                }
            });//end ajax
           
       }//end chk true
       else{
           alert('Please add some value!');
           $('#add_value').focus();
       }
       
   });//end function
      
      //DEDUCT
   $('#btn-deduct').click(function(){
       
       var id=$(this).val();
       
       var add= $('#deduct_value').val();
       
       if(add!=''){             //ADD NOT EQUAL NULL
           var subs_sn=$('#subs_sn').val();
                     
           
       $.ajax({
                type: "POST",
                url: apppath+'/customer/addTransection',
                data: '_subs_sn='+subs_sn+'&_value='+add+'&_tran_type=deduct',
                success: function(data) {
                    console.log(data);
                    if(data!=false){                                                
                        $('#current_balance').text('');
                        $('#current_balance').text(data);
                        var m=moment();
                        var row='<tr>';
                            row+='<td></td><td></td>';
                            //row+='<td>'+m.format('D MMM YYYY')+'</td>';
                            row+='<td>'+m.format('D MMM YYYY hh:mma')+'</td>';
                            row+='<td>Check In</td>';
                            row+='<td>'+add+'</td>';
                            row+='<td></td><td></td>';
                            row+='</tr>';
                            
                        $('#transections').append(row);
                        $('#deduct_value').val('');
                    }//end if
                    else{
                        alert('Sorry! Coudn\'t save into Database.');
                    }
                },
                error:function(error){
                    console.log('ERROR: '+error);
                }
            });//end ajax
           
       }//end chk true
       else{
           alert('Please add some value!');
           $('#deduct_value').focus();
       }
       
   });//end function
        
   $('.remove-transection').click(function(){
        var id=$(this).val();
        
        //var _name=$('#row_'+id).find('.ol_name').text();
        $('#remove_name').text(id);
        $('#remove_id').val(id);
        $('#remove_customer_modal').modal('show');        
        
    });// row delete button click
    
    $('#btn_delete').click(function(){
        var id=$('#remove_id').val();
                
        //console.log(apppath+'/customer/deleteTransection');
        //return 0;        
        $.ajax({
            type: "POST",
            url: apppath+'/customer/deletetransection',
            data: '_sn='+id,
            success: function(data) {
                //data=10;
                console.log('data: '+data);
                
                if(data!=false){
                    $('#current_balance').text('');
                    $('#current_balance').text(data);
                        
                    $('#row_'+id).remove();
                    $('#remove_customer_modal').modal('hide');
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });
    });//DELETE TRANSECTION
    
    $('.change_expire_date').datepicker().on('changeDate', function(ev){
        var d = new Date(ev.date);
        var curr_date = d.getDate();
        var curr_month = d.getMonth()+1;
        var curr_year = d.getFullYear();
         //console.log(curr_date+'/'+curr_month+'/'+curr_year);
         console.log('moment: '+moment(curr_year+'-'+curr_month+'-'+curr_date).format('D MMM, YYYY'));
                 
        $('#newExpireDate').val(curr_year+'-'+curr_month+'-'+curr_date);
        $('#expire_date').text('');
        $('#expire_date').text(moment(curr_year+'-'+curr_month+'-'+curr_date).format('D MMM, YYYY'));
        $('#update_expire_date').show();
        
    });
    
    //Update the new date
    $('#update_expire_date').click(function(){
        var newDate=$('#newExpireDate').val();
        var subs_sn=$(this).val();
        
        
        $.ajax({
            type: "POST",
            url: apppath+'/campaign/updateExpireDate',
            data: '_subs_sn='+subs_sn+'&_newDate='+newDate,
            success: function(data) {
                console.log(data);
                if(data==1){                                         
                    $('#update_expire_date').hide();
                    $('#updateSuccess').show();
                    setTimeout(function() {
                        $('#updateSuccess').hide();
                    }, 4000);
                          
                          
                }//end if
                else{
                    alert('Sorry! Coudn\'t save into Database.');
                }
            },
            error:function(error){
                console.log('ERROR: '+error);
            }
        });//end ajax
        
    });//end update 
    
});