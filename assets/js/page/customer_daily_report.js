require(['order!jquery','order!apppath','order!posios','order!spin','order!inputmask'], function($,apppath,pos,Spinner){

    //console.log('welcome');
    var opts = {lines: 13,length: 20,width: 10,radius: 30,corners: 1,rotate: 0,direction: 1,  color: '#000',speed: 1,trail: 60,shadow: false,hwaccel: false,className: 'spinner',zIndex: 2e9,top: 'auto',left:'auto'};

    $(document).ajaxStart(function(){

        $('#submit_to_xero').attr('DISABLED',true);
        var target = document.getElementById('searching_spinner_center');
        var spinner = new Spinner(opts).spin(target);

    });
    $(document).ajaxComplete(function(){
//        $('#searching_spinner_center').empty();
    });


    //INITIALIZATION
    $('#search_daily_report').attr('DISABLED','DISABLED');


    $('#search_daily_report').click(function(){

        $('#result').empty();
        $(this).attr('DISABLED','DISABLED');
        var _rdate = $('#report_date').val();


        //GET THE MERCHANT ID FROM URL
        var segment_str = window.location.pathname; // return segment1/segment2/segment3/segment4
        var segment_array = segment_str.split( '/' );
        var msn = segment_array[segment_array.length - 1];

        var _data='_date='+_rdate+'&_msn='+msn;
        $.ajax({
               type: "POST",
                url:apppath+'/transaction/checkTransaction/',
                data:_data,
                //data:_data+'&_date='+$('#report_date').val(),
                success:function(_response){
                    var data=JSON.parse(_response);
                    //console.log('response: '+data);
                    var count=data.count;
                    if(count>0){
                        //ALREADY POSTED IN XERO
                        $('#receiptPayments').empty();
                        $('#result').empty();
                        $('#submit_to_xero').attr('DISABLED',true);
                        var invoices = $.map(data, function(value, index) {
                            var msg='';
                            if(index=='invoices'){
                                for(var j=0;j<value.length;j++){
                                    //console.log('VALUE: '+value[j].invoice_number);
                                    msg+='<div class="alert alert-warning  alert-dismissable">';
                                    msg+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                                    msg+='<strong>Hey!</strong><p>Payment Receipts for '+_rdate+' is already posted '+value[j].tran_mode+' in<br> Invoice: <Strong>'+value[j].invoice_number+'</strong>.</p>';
                                    msg+='<p>Details:<br> '+value[j].details+'</p>';
                                    msg+='</div>';
                                    $('#result').append(msg);
                                }
                                //stop spinning here
                                $('#searching_spinner_center').empty();
                            }

                            return [value];
                        });
                    }
                    else{
                        //GET DATA FROM POSIOS

                        $('#receiptPayments').empty();


                        var _start_time = "";
                        var _end_time   = "";
                        var _is_same_date = null;

                        $.ajax({
                            type:"POST",
                            url:apppath+"/transaction/getTransactionTime",
                            data:"_mrcnt_sn="+msn,
                            success:function(_time){

                                var times=JSON.parse(_time);

                                var tran_times = $.map(times, function(value, index) {

                                    if(index=='times'){
                                        for(var j=0;j<value.length;j++){

                                            _start_time = value[j].mrcnt_start_time;
                                            _end_time   = value[j].mrcnt_end_time;
                                            _is_same_date = value[j].mrcnt_end_time_is_same_date;

                                        }//end for
                                    }
                                    //return [value];
                                });

                                //console.log("date "+_rdate);
                                //console.log("start time "+_start_time);
                                //console.log("end time "+_end_time);

                                var _from   = getTargetDate_first(_rdate, _start_time)+'000';
                                var _to     = getTargetDate_last(_rdate, _end_time.substr(0,8), _is_same_date)+'000';

                                //var _from   = getTargetDate_first(_rdate, _start_time);
                                //var _to     = getTargetDate_last(_rdate, _end_time.substr(0,8), _is_same_date);



                                $("#date_from").val(_from);
                                $("#date_to").val(_to);

                                //console.log("from: "+_from);
                                //console.log("to: "+_to);


                                //GET DAILY REPORT FROM POSiOS
                                //pos.getDailyReportByDate(_from,_to);

                                //return 0;
                                //Update at 02 March 2015
                                pos.getGroupPaymentTypesByDate(_from,_to);

                            },//END SUCCESS FUNCTION
                            error:function(_error){
                                console.log("ERROR: "+_error);
                            }
                        });

//                        console.log("Start time: "+_start_time);
//                        console.log("End time: "+_end_time);
//
//                        var _from = getTargetDate_first(_rdate,_start_time)+'000';
//                        var _to = getTargetDate_last(_rdate)+'000';
//
////                        STOP WORKIN HERE
////                        return 0;
//
//                        //GET DAILY REPORT FROM POSiOS
//                        pos.getDailyReportByDate(_from,_to);
                    }
                },
                error:function(_error){
                    console.log('ERROR: '+_error);
                    var _from = getTargetDate_first(_rdate)+'000';
                    var _to = getTargetDate_last(_rdate)+'000';

                    pos.getDailyReportByDate(_from,_to);
                    $('#search_daily_report').removeAttr('DISABLED');
                }
        });

    });


    $("#report_date").inputmask("dd/mm/yyyy",{
        "placeholder": "dd/mm/yyyy" ,
        "oncomplete": function(){
            $('#search_daily_report').removeAttr('DISABLED');
        } ,
        "onincomplete": function(){} ,
        "oncleared": function(){
            $('#search_daily_report').attr('DISABLED','DISABLED');
        }
        });

   $('#submit_to_xero').click(function(){

       var receipts=Array();
       //READ DATA FROM TABLE
       $('.pos_data').each(function(){
           var amount=$(this).children('.amount').text();
           receipts.push({'id':$(this).attr('id'),'amount':amount});

       });

        var segment_str = window.location.pathname; // return segment1/segment2/segment3/segment4
        var segment_array = segment_str.split( '/' );
        var last_segment = segment_array[segment_array.length - 1];

//         var _data={receipts:JSON.stringify(receipts)};
//         var _data=JSON.stringify({receipts:receipts,_date:$('#report_date').val()});

         //var _data={receipts:JSON.stringify(receipts),_date:JSON.stringify($('#report_date').val())};

        var _date_from  = $("#date_from").val().substr(0,10);
        var _date_to    = $("#date_to").val().substr(0,10);

         var _data = "startFrom="+_date_from+"&startTo="+_date_to;
        // console.log(_data);
        //return 0;

           $.ajax({
                type: "POST",
                url:apppath+'/customer/post_to_xero/'+last_segment,
                data:_data,
                //data:_data+'&_date='+$('#report_date').val(),
                success:function(_response){

                    var data = JSON.parse(_response);

                    //console.log('response: '+_data);
                    //console.log('INVOICE STATUS: '+data.Invoice_status+ ' INVOICE ID: '+data.InvoicdId);
                    //console.log('PAYMENT STATUS : '+data.payment_status );

                    if(data.Invoice_status=='ok' && data.payment_status=='ok'){

                    var alert='<div class="alert alert-success">';
                        alert+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        alert+='<h4>Great!</h4><p>New Invoice ('+data.InvoicdId+') is created in XERO.</p>';
                        alert+='<p>Also New Payment is created in for the Invoice.</p>';
                        alert+='</div>';
                        $('#submit_to_xero').attr('DISABLED',true);
                        $('#receipts > table').removeClass('table-hover');
                        $('#result').append(alert);
                        $('#report_date').focus();

//                        console.log('ajax stop');
                        $('#searching_spinner_center').empty();
                    }
                    else if(data.Invoice_status=='ok' && data.payment_status=='failed'){

                        var error_message       = '';
                        var error_type          = ''
                        var error_type_message  = '';

                        var errors = $.map(data, function(value, index) {
                            //console.log('VALUE: '+value + ' | INDEX: '+index);
                            if(index=='error_type'){
                                error_type = value[0];
                            }
                            else if(index=='error_type_message'){
                                error_type_message=value[0];
                            }
                            else if(index=='paymentError'){

                                var error_dcb = $.map(value,function(dcb_v,dcb_i){

                                    if(dcb_i == 'DataContractBase'){
                                        var error_ve = $.map(dcb_v,function(ve_value,ve_index){

                                            if(ve_index=='ValidationErrors'){

                                                var error_msg= $.map(ve_value,function(msg_value,msg_index){
                                                    var msg = $.map(msg_value,function(message,ind){

                                                        error_message += '<li style="list-style-type: disc">'+message+'</li>';

                                                    });
                                                });
                                            }
                                        });
                                    }
                                });

                            }

                        });


                        var alert='<div class="alert alert-danger">';
                        alert+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        alert+='<h4>Incomplete Invoice!</h4><p> New Invoice (<strong>'+data.InvoiceId+'</strong>) is created in XERO.</p>';

                        alert+='<p>However failed to complete the Payment Processing. Please look at XERO for manual update.</p><br>';

                        alert+='<h5>'+error_type+'! <em>'+error_type_message+'</em></h5>';
                        alert+='<p><ul style="margin-left: 20px;">'+error_message+'</ul></p>';
                        alert+='</div>';
                        $('#submit_to_xero').attr('DISABLED',true);
                        $('#receipts > table').removeClass('table-hover');
                        $('#result').append(alert);
                        $('#report_date').focus();
                        $('#searching_spinner_center').empty();

                    }
                    else if(data.Invoice_status=='failed'){
                        //ERROR MESSAGE
                        //console.log('ERROR RESPONSE: '+_response);

                        var error_message       = '';
                        var error_type          = ''
                        var error_type_message  = '';

                        var errors = $.map(data, function(value, index) {

                            if(index=='Invoice_status'){
                                console.log('INDEX: '+index+' | VALUE: '+value);
                            }else{

                                if(index=='message'){
                                    //READ OBJECT

                                    var error_dcb = $.map(value,function(dcb_v,dcb_i){

                                        if(dcb_i == 'DataContractBase'){
                                            //console.log('DataControlBase');

                                            var error_ve = $.map(dcb_v,function(ve_value,ve_index){

                                                if(ve_index=='ValidationErrors'){

                                                    var error_msg= $.map(ve_value,function(msg_value,msg_index){

                                                            var msg = $.map(msg_value,function(message,ind){

                                                                //console.log('ERROR MESSAGE: '+ind+' - '+message.Message);
                                                                error_message += '<li style="list-style-type: disc">'+message.Message+'</li>';

                                                            });

                                                    });

                                                }

                                            });

                                        }


                                    });

                                }//message
                                else{
                                    //console.log('INDEX: '+index+' | VALUE: '+value[0]);
                                    if(index=='error_type'){
                                        error_type =value[0];
                                    }
                                    else if(index=='error_type_message'){
                                        error_type_message = value[0];
                                    }
                                }

                                //error_message+='</ul>';

                                var alert='<div class="alert alert-danger">';
                                alert+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                                alert+='<h4>'+error_type+'</h4><p>'+error_type_message +'</p>';
                                alert+='<p><ul style="margin-left: 20px;">'+error_message+'</ul></p>';
                                alert+='</div>';

                                $('#result').text('');
                                $('#result').html(alert);
                                $('#searching_spinner_center').empty();

                            }

                                //return [value];
                        });


                    }

                },
                error:function(_error){
                    console.log('ERROR: '+_error);


                    //for(var key in _error){
                    //    console.log('KEY: '+key+' IN '+_error[key]);
                    //}
                }
           });

   });

    function getTargetDate_first(_date,_time){

        //console.log("start time: "+_time);

        var day = _date.substr(0,2);
        var month = _date.substr(3,2);
        var year = _date.substr(6,4);

        //var _td_from = new Date(month+'/'+day+'/'+year+' 06:00:00 am');
        var _td_from = new Date(month+'/'+day+'/'+year+' '+_time);

        return new Date(_td_from)/1000;

    }//end function


    function getTargetDate_last(_date,_time,_is_same_date){

        var day = _date.substr(0,2);
        var month = _date.substr(3,2);
        var year = _date.substr(6,4);

        var _td_to = new Date(month+'/'+day+'/'+year+' '+_time);   //TODAY


        if(_is_same_date==0){
            // IF THIS TIME IS NOT FOR SAME DATE AS START TIME

            var tomorrow = new Date(_td_to.getTime() + (24 * 60 * 60 * 1000)); //TOMORROW
            var _next_day = new Date((tomorrow.getMonth()+1)+'/'+tomorrow.getDate()+'/'+tomorrow.getFullYear()+' ' +_time);

            //return new Date(_next_day)/1000;
            return _next_day/1000;

        }else{
            // IF THEIS TIME IS FOR SAME DATE AS START TIME

            //return new Date(_td_to)/1000;
            return _td_to/1000;

        }//end else

    }//end function
});//end file