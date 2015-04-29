require(['order!jquery','order!apppath','order!posios','order!spin','order!json2'], function($,apppath,posios,Spinner){

    var opts = {lines: 13,length: 20,width: 10,radius: 30,corners: 1,rotate: 0,direction: 1,  color: '#000',speed: 1,trail: 60,shadow: false,hwaccel: false,className: 'spinner',zIndex: 2e9,top: 'auto',left:'auto'};
    var target = document.getElementById('searching_spinner_center');
    var spinner = new Spinner(opts).spin(target);
    //List Payment Info in on page load
    posios.getPaymentTypesForConfig();



    var _ajax_result='init';


    //STORE POSiOS data
    $('#pos_payments').on('click','.pos_payment_item',function(){
            //console.log(this);
            var _id=this.id.substring(7);

            $('#selected_pos').text(this.text);
            $('#pos_oid').val(_id);
            $('#pos_sec').val($('#pos_sec'+_id+'').val());
            $('#pos_type_id').val($('#pos_type_id_'+_id+'').val());

            return false;
        });
        
        
    $('#pos_payments').on('click','.list-group-item',function(e){
            
            clear_pos_payments_types(e);
            
          });        
        
    var clear_pos_payments_types=function(e){
            
            var previous = $("#payment_types").children(".active");                        
            previous.removeClass('active'); // previous list-item
            $(e.target).addClass('active'); // activated list-item
            activate_create_btn();
                                 
        }//end function                  
        
        
    //SET XERO ACCOUNT DETAILS
    $('#xero_accounts').on('click','.account',function(){
            
            //console.log(this);
            var _id=this.id;                
            
            $('#selected_xero').text(this.text);
            $('#xero_code_id').val($('#xero_code_'+_id+'').val());
            $('#xero_acc_id').val(this.id);                        
            return false;
        });
        
    $('#xero_accounts .list-group-item').on('click',function(e){
            
                clear_xero_accounts(e);
            
          });

    $('#create_inventory_item').on('click',function(e){

        //CALL
        createLinkedInventoryItem();

    }); // END FUNCTION


    var createLinkedInventoryItem= function (e) {


        var _url=apppath+'/customer/addAccountConfigAjax';

        var _mrcnt_sn = $('#mrcnt_pos_company').val();
        var _pos_name = $('#selected_pos').text();
        var _pos_sec  = $('#pos_sec').val();
        var _pos_oid  = $('#pos_oid').val();
        var _pos_typeId  = $('#pos_type_id').val();

        var _xero_name = $('#selected_xero').text();
        var _xero_acc_id  = $('#xero_acc_id').val();
        var _xero_code_id = $('#xero_code_id').val();

        var _acc_link_type = 2;     //2 is inventory item

        var   _data='_mrcnt_sn='+_mrcnt_sn+'&_pos_name='+_pos_name+'&_pos_sec='+_pos_sec+'&_pos_oid='+_pos_oid+'&_pos_type_id='+_pos_typeId;
        _data+='&_xero_name='+_xero_name+'&_xero_acc_id='+_xero_acc_id+'&_xero_code_id='+_xero_code_id+'&_acc_link_type='+_acc_link_type;

        ajax_call(_url,_data,_acc_link_type);

        //console.log(_ajax_result);


    }// END FUNCTION
        
    var clear_xero_accounts=function(e){
         
         var previous = $("#xero_accounts").children(".active");            
            previous.removeClass('active'); // previous list-item
            $(e.target).addClass('active'); // activated list-item
            activate_create_btn();         
            
        }//end funciton
                   

    var activate_create_btn=function(){
              
              var _pos_sec=$('#pos_sec').val();
              var _pos_oid=$('#pos_oid').val();
              
              var _xero_acc_id=$('#xero_acc_id').val();
              var _xero_code_id=$('#xero_code_id').val();
              
              if(_pos_sec!='' &&
                  _pos_oid!='' &&
                  _xero_acc_id!='' &&
                  _xero_code_id!=''){
                  //ACTIVATE
                    //$('#create_payment_account').removeClass('btn-default');
                    //$('#create_payment_account').addClass('btn-primary');
                    $('#create_inventory_item').removeAttr('disabled');
                    $('#create_payment_account').removeAttr('disabled');
                  }else{
                  //inactivate
                  //$('#create_payment_account').removeClass('btn-primary');
                    //$('#create_payment_account').addClass('btn-default');
                    $('#create_inventory_item').attr('disabled');
                    $('#create_payment_account').attr('disabled');
                  }
              
          }//end functioin

//    LINKED ACCOUNT PAYMENT CREATE BUTTON
    $('#create_payment_account').click(function(){
              
              var _url=apppath+'/customer/addAccountConfigAjax';
              
              var _mrcnt_sn = $('#mrcnt_pos_company').val();
              var _pos_name = $('#selected_pos').text();
              var _pos_sec  = $('#pos_sec').val();
              var _pos_oid  = $('#pos_oid').val();
              var _pos_typeId  = $('#pos_type_id').val();

              var _xero_name = $('#selected_xero').text();
              var _xero_acc_id  = $('#xero_acc_id').val();
              var _xero_code_id = $('#xero_code_id').val();

              var _acc_link_type = 1;     //1 is payment type

              var   _data='_mrcnt_sn='+_mrcnt_sn+'&_pos_name='+_pos_name+'&_pos_sec='+_pos_sec+'&_pos_oid='+_pos_oid+'&_pos_type_id='+_pos_typeId;
                _data+='&_xero_name='+_xero_name+'&_xero_acc_id='+_xero_acc_id+'&_xero_code_id='+_xero_code_id+'&_acc_link_type='+_acc_link_type;

              ajax_call(_url,_data,_acc_link_type);
              
              //console.log(_ajax_result);
              
          });

//    TRACKING CATEGORY
    $('#btnTrackingCategory').click(function(){
        var tc_id=$('#tracking_cat option:selected').val();
        var group_name =$('#tracking_cat :selected').parent().attr('label');
        var tc_opt_name=$('#tracking_cat option:selected').text();
        var _mrcnt_sn = $('#mrcnt_pos_company').val();

        $.ajax({
            type: "POST",
            url:apppath+'/customer/setTC',
            processData:false,
            data:'mrcnt_sn='+_mrcnt_sn+'&_tc='+tc_id+'&_op_name='+tc_opt_name+'&_group_name='+group_name,
            success:function(result){
                if(result==1){
                    alert('Tracking Category been Set');
                }
                console.log(result);
            },
            error:function(error){
                alert('Couldn\'t perform the database operation.');
                console.log('ERROR: '+error);
            }
        });

    });

//    ADD ACCOUNT CONFIG VIA AJAX
    var ajax_call=function(_url,_data,_type){
                            
              
              $.ajax({
                    type: "POST",                    
                    url:_url,                       
                    processData:false,                    
                    data:_data,    
                    success:function(_result){
//                        console.log('RESULT: '+_result);
                        if($.isNumeric(_result)){

                            var _acc_link_type='';
                            if(_type==1){
                                _acc_link_type='Payment';
                            }else if(_type==2){
                                _acc_link_type='Invoice';
                            }

                            //ADD RECORD IN TABLE
                            var _row='<tr id="row'+_result+'">';// _result = new id
                                _row+='<td>'+$('#selected_pos').text()+'</td>';
                                _row+='<td>'+$('#selected_xero').text()+'</td>';
                                _row+='<td>'+_acc_link_type+'</td>';
                                _row+='<td><button class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></button></td>';
                            $('#app_account_records').append(_row);
                            
                            
                            //clear_xero_accounts(
                            var previous = $("#xero_accounts").children(".active");                        
                            previous.removeClass('active');
                                                        
                            //clear_pos_payments_types();
                            var previous = $("#payment_types").children(".active");                        
                            previous.removeClass('active'); // previous list-item
                            
                            $('#create_inventory_item').attr('disabled');
                            $('#create_payment_account').attr('disabled');
                            
                            
                        }else if(_result==false ){                            
                            alert('Database Operation was not Successful!');
                        }else{
                            //error message
                            //validation error;
                            alert('VALIDATION ERROR');
                            console.log('ERROR: '+_result);
                        }            
                        
                    },
                    error:function(_error){
                        console.log('Error: '+_error);                                                
                        
                    }//error
              });                            
              
          };//END FUNCTION

    $('.btn-remove-acc').click(function(){
          
          var accsn=$(this).val();
          
          $.ajax({
                 type: "POST",                    
                    url:apppath+'/customer/removeaccajax',                       
                    processData:false,                    
                    data:'accsn='+accsn,    
                    success:function(_result){
                        if(_result==1){
                         $('#acc_'+accsn+'').remove();
                        }                        
                    },
                    error:function(_error){
                        console.log(_error);
                    }
          });
      });


    //REVENUE SET BUTTON
   $('#btnrevenue').click(function(){

       var _mrcnt_sn = $('#mrcnt_pos_company').val();
       var xero_acc_id     = $('#xero_acc_id').val();
       var xero_code_id    = $('#xero_code_id').val();
       var xero_acc_name     = $('#selected_xero').text();

//       console.log('acc id: '+xero_acc_id+" | code id: "+xero_code_id);

       if(xero_acc_id!='' && xero_code_id!=''){
           //SAVE
           $.ajax({
               type: "POST",
               url:apppath+'/customer/set_xero_revenue_code',
               processData:false,
               data:'x_account_id='+xero_acc_id+'&x_code_id='+xero_code_id+'&x_account_name='+xero_acc_name+'&mrcnt_sn='+_mrcnt_sn,
               success:function(_result){
;
                   if(_result==1){
                       $('#xero_revenew_account_name').text(xero_acc_name+' | '+xero_code_id);
                       alert("Revenue Account Updated!");
                   }
               },
               error:function(_error){
                   console.log(_error);
               }
           });

       }else{
//           console.log('choose reveneue account');
            alert('Plase chooose a Xero Account to set as Revenue Account');
       }

   });

});