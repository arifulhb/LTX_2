define(['order!jquery','order!apppath','order!pos_server'],function($,apppath,pos_server){

    var PosInvoke={

        init:function(){},
        //DO THE ACTUAL WORK
        connect:function(method,params,callback,showMethos){
            
            if(showMethos===true){console.log('ID: '+id+' | METHOD: '+method+' | PARAMS: '+params);}

//            var _data={mydata:JSON.stringify(mydata)};
//            console.log('params '+params);
            $.ajax({
                type: "POST",
//                crossDomain: true,
                url:apppath+'/wrapper/process',
//                dataType:'json',
//                processData:false,
//                contentType:'text/plain; charset=UTF-8',
//                data:JSON.stringify({'id':id,'method':method,'params':params}),
//                data:_data,
                data:'method='+method+'&params='+params,
                success:callback,
                error:callback
            });//end ajax   

        }//end connect
    };
    return PosInvoke;

});//end invoke.js