require(['order!jquery','order!apppath','order!json2'], function($,apppath){

/*    var posAPI = "http://dev.posios.com:8080/PosServer/JSON-RPC";
    
    var api_token='';
    
    $(document).ready(function(){
        //INITIATE POS API
       //initPOSApi();
       //alert('test');
       invokeMethod(1,'posiosApi.getApiToken',["eric@thelaunchstars.com","launchstars",2,"","","","",false,"",""]);        
    });
    
    
  
        
    $('#getPaymentTypes').click(function(){
        
        //company id =32
        getPaymentTypes(32);
        
    });
    
    
    var getPaymentTypes=function(companyId){
        
        //var _apitoken=$('#apitoken').val();
        invokeMethod(3,'posiosApi.getPaymentTypes',[api_token,companyId]);
    };
    
    
    var initPOSApi=function(){
        // partner account: eric@thelaunchstars.com
        // test account: hello@thelaunchstars.com
        invokeMethod(1,'posiosApi.getApiToken',["eric@thelaunchstars.com","launchstars",2,"","","","",false,"",""]);        
               
    };
    
    
	
    function invokeMethod(id, method, params){
        console.log('INVOKE METHOD ['+method+']...');
        console.log(params);
	$.ajax({
            type: "POST",
            crossDomain: true,         
            url:posAPI,   
            dataType:'json',
            processData:false,
            contentType:'text/plain; charset=UTF-8',
            data:JSON.stringify({'id':id,'method':method,'params':params}),                                               
            success: function(data) {
                var _id='';
                var array = $.map(data, function(value, index) {
                   // console.log('Index:'+index+', Value: '+value);
                    
                    if(index=='id'){                        
                        _id=value;                        
                    }
                    if(index=='result' && _id==1){
                        
                        //INITIALIZE API TOKEN
                        api_token=value;
                        
                        if(api_token!=''){
                            $('#getPaymentTypes').removeClass('btn-default');
                            $('#getPaymentTypes').addClass('btn-info');
                        }
                        
                    }
                    if(index=='result' && _id==3){
                        var arr = [];
                        for (var i = 0; i < value.length; i++) {
                            console.log(value[i]);
                            arr.push(value[i].name);
                        }
                        console.log('Payment Types: '+arr);
                    }
                    
                    //return value;
                });                
              //console.log('---------------- END INVOKE -----------------');
                
            },
            error:function(error){
                console.log('ERROR: '+error);
            },
            done:function(data){
                var record = JSON.parse(data);                                              
                console.log('done: '+record);
                    },
            complete:function(jqXHR, status){
               // console.log('complete: '+jqXHR+' : '+status);
            }
        });
            var MyCallback=function(data){
                console.log('myCallback: '+data);
            }
	}// end function invoke*/
});