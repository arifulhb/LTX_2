define(['jquery','order!spin'], function($,Spinner){

    function View(){

        //called in customer_daily_report.js->posios.js->getDailyReport
        this.cb_daily_report=function(response){

            var array = $.map(response, function(value, index) {
                console.log('Index:'+index+', Value: '+value);
                if(index=='result'){
                    var _total=0;
                    for (var i = 0; i < value.length; i++) {
                            var rec=value[i];
                            _total=_total+rec['total'];
                    }//end for loop
                    $('#totalPayment').text(_total);
                }//end result index
            });
            //return myarray;
        },
        this.cb_daily_report_by_Date=function(response){
//          @TODO after update, update the paymentgroup table only, dont need to process the full receipt list
//            var opts = {lines: 13,length: 20,width: 10,radius: 30,corners: 1,rotate: 0,direction: 1,  color: '#000',speed: 1,trail: 60,shadow: false,hwaccel: false,className: 'spinner',zIndex: 2e9,top: 'auto',left:'auto'};
//            var target = document.getElementById('searching_spinner_center');
//            var spinner = new Spinner(opts).spin(target);
//            console.log('start...');

            //Daily Report By Date
//            console.log('daily_report_by_date: '+response);
            response= $.parseJSON(response);
//            return 0;
             var array = $.map(response, function(value, index) {



                if(index=='result'){

                    var _total=0;
                    var _status = new Array();

//                    console.log('Index:'+index+', Value: '+value+' | LENGTH: '+value.length);
                    for (var i = 0; i < value.length; i++) {;
                        var res=value[i];

                        if(res['status']=='payed'){

                            var payments=res['payments'];

                            for(var j=0;j<payments.length;j++){
                                    //paymentTypeId
                                    _status.push(Array(payments[j]['paymentTypeId'],payments[j]['type'],payments[j]['amount']));
                            }// payments for
                        }//end if is paid
                    }//end for

                     //console.log('lenght: '+_status.length);
                     if(_status.length>0){


                            var hist = {};
                            _status.map( function (a) {
                               //console.log(hist);

                                var id=a[1]+' ('+a[0]+')';

                                    //console.log(a[1]+" - "+a[0]);

                                if (id.toString() in hist){
                                    hist[id.toString()] =hist[id.toString()]+parseFloat(a[2]);
                                }
                                else {
                                    hist[id.toString()] = parseFloat(a[2]);
                                }
                                _total=_total+a[2];
                                }//END A
                            );

                        $('#receiptPayments').empty();
                        //console.log(hist);
                        for(var key in hist) {

                                var id = key.split( "(" ) ;
                                //console.log('KEY 1: '+id[1].substr(0,id[1].length-1));

                              var row='<tr id="'+id[1].substr(0,id[1].length-1)+'" class="pos_data">';
                               row+='<td>'+key+'</td>';
                               row+='<td class="amount">'+hist[key].toFixed(2)+'</td>';
                               //row+='<td></td>';
                               row+='</tr>';

                               $('#receiptPayments').append(row);
                       }//end for


                        var row='<tr class="info">';
                            row+='<td colspan="1">Total</td>';
                            row+='<td>'+_total.toFixed(2)+'</td>';
                            row+='<tr>';
                         $('#receiptPayments').append(row);
                         $('#submit_to_xero').removeAttr('DISABLED');

                         $('#result').empty();
                         $('#search_daily_report').removeAttr('DISABLED');

                     }else{
                         console.log('not found');
                         var msg='<div class="alert alert-warning alert-dismissable">';
                            msg+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                            msg+='<p><strong>Sorry<i class="fa fa-exclamation"></i></strong>... No Post found in POSiOS.</p></div>';
                            $('#result').append(msg);
                     }

                }//if index==result
                else{
                    console.log("index: "+index);
                }


            });
            $('#search_daily_report').removeAttr('DISABLED');
            $('#searching_spinner_center').empty();
        },
        this.cb_GroupPaymentTypesByDate=function(response){

            //console.log(response);

            if(response.length <= 0){

                var msg='<div class="alert alert-warning alert-dismissable">';
                msg+='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                msg+='<p><strong>Sorry<i class="fa fa-exclamation"></i></strong>... No Post found in POSiOS.</p></div>';
                $('#result').append(msg);

                $('#search_daily_report').removeAttr('DISABLED');
                $('#searching_spinner_center').empty();

                return 0;
            }


            var _total=0;
            //response= $.parseJSON(response);


            $('#receiptPayments').empty();

                var array = $.map(response, function(value, index) {

                    //console.log("index: "+ index +" Value: "+value.type);

                    var row='<tr id="'+value.paymentTypeId+'" class="pos_data" date-typeId="'+value.paymentTypeId+'">';
                    row+='<td>'+value.type+' ('+value.paymentTypeId+')</td>';
                    row+='<td class="amount">'+value.amount.toFixed(2)+'</td>';
                    row+='</tr>';

                    _total += value.amount;

                    $('#receiptPayments').append(row);

                });//end array

                var row='<tr class="info">';
                    row+='<td colspan="1">Total</td>';
                    row+='<td>'+_total.toFixed(2)+'</td>';
                    row+='<tr>';

                $('#receiptPayments').append(row);


            $('#search_daily_report').removeAttr('DISABLED');
            $('#searching_spinner_center').empty();
            $('#submit_to_xero').removeAttr('DISABLED');

        },
        this.cb_payment_types_for_config=function(response){

            //console.log('view.cb_payment_types_for_config() '+response);

            response= $.parseJSON(response);

            var array = $.map(response, function(value, index) {
//                console.log('Index:'+index+', Value: '+value+' | LENGTH: '+value.length);
                if(index=='result'){
//                    console.log('Payment types: '+value);

                    var arr = [];
                    $('#pos_payments').append('<div id="payment_types" class="llist-group"></div>');
                    for (var i = 0; i < value.length; i++) {
                        //console.log(value[i]);
                        arr.push(value[i].name);
                        $('#payment_types').append('<a href="#" id="pos_oid'+value[i].oid+'" class="pos_payment_item list-group-item">'+value[i].name+'</a>');
                        $('#payment_types').append('<input type="hidden" id="pos_sec'+value[i].oid+'" value="'+value[i].sequence+'">');
                        $('#payment_types').append('<input type="hidden" id="pos_type_id_'+value[i].oid+'" value="'+value[i].typeId+'">');

                        /*$('#payment_types').append('<a href="#" id="pos_oid'+value[i].oid+'" class="pos_payment_item list-group-item">'+value[i].name+'</a>');
                        $('#payment_types').append('<input type="hidden" id="pos_sec'+value[i].oid+'" value="'+value[i].sequence+'">');*/
                    }//end for loop


                    //console.log('Payment Types: '+arr);
                    $('#payment_types').append('<a href="#" id="pos_oid000" class="pos_payment_item list-group-item">Other</a>');
                    $('#payment_types').append('<input type="hidden" id="pos_sec000" value="999">');
                    $('#payment_types').append('<input type="hidden" id="pos_type_id_0000" value="0000">');

                    $('#searching_spinner_center').empty();
                    //console.log('Index:'+index+', Value: '+value+' | LENGTH: '+value.length);
                }else if(index=='error'){
                    console.log('ERROR: '+value);
                    for (var i = 0; i < value.length; i++) {
                        console.log(value[i]);
                    }
                }
            });
            $('#searching_spinner_center').empty();
        },
        this.cb_get_companies = function(_response){

            console.log('COMPANIES: '+_response);

            var array = $.map(_response, function(value, index) {
                if(index=='result'){
                    console.log(':'+value);
                    console.log('Index:'+index+', Value: '+value);
                }
            });
        } ,
        this.cb_get_api_version= function (response) {

            var array = $.map(response, function(value, index) {
                if(index=='result'){
                    console.log('POSiOS Api Version: '+value);
                    //console.log('Index:'+index+', Value: '+value+' | LENGTH: '+value.length);
                }
            });
        }

    }//end class

    view=new View();

    return view;
});