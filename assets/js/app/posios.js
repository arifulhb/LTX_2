define(['order!jquery','order!invoke','order!apppath','app/pos_view'],function($,inv,apppath,view){

    function Posios(){

        this.getPaymentTypes=function(){
        //METHOD NUMBER: 
        
            //var obj=inv.call(2,'',['','','']);
            //return obj;
        },
        this.getDailyReportByDate=function(_from,_to){
            //METHOD NUMBER: 5
            var _company_id=$('#company_id').val();
            
            inv.connect('getReceiptsByDate',[_company_id,_from,_to],view.cb_daily_report_by_Date);
        },
        this.getGroupPaymentTypesByDate=function(_from,_to){
            //METHOD NUMBER: 5

            var _company_id=$('#company_id').val();
            inv.connect('getGroupPaymentTypesByDate',[_company_id,_from,_to],view.cb_GroupPaymentTypesByDate);
        },
        this.getDailyReportByStatus=function(_status){
            //METHOD NUMBER: 4
        
            var _token=this.getToken();
            var _company_id=$('#company_id').val();
            
            inv.connect(4,'posiosApi.getReceiptsByStatus',[_token,_company_id,_status],view.cb_daily_report);
                       
        },
        this.setToken=function(){      
        //METHOD NUMBER: 
            //CALL INVOKE TO GET TOKEN AND & SET TO pos_api_token AND return
            var _email=$('#pos_api_partner').val();
            var _pass=$('#pos_api_partner_pass').val();
            var _app_id=$('#pos_api_partner_appid').val();;;

            inv.connect(1,'posiosApi.getApiToken',[_email,_pass,_app_id,"","","","",false,"",""],cb_getToken,false);                
            
        },//end token
        this.getToken=function(){            
            return $('#pos_api_token').val();
        },
        this.getPaymentTypesForConfig=function(){

            //var _token=this.getToken();
            var _company_id=$('#mrcnt_company_id').val();
//            console.log('calling mrcnt_company_id: '+_company_id);

            inv.connect('getPaymentTypes',[_company_id],view.cb_payment_types_for_config,false);
        },
        this.getApiVersion=function(){
            inv.connect('posiosApi.getVersion',[],view.cb_get_api_version);
        },
        this.getCompanies=function(_start,_amount){

           console.log('start: '+_start+ ' AMOUNT: '+_amount);
            inv.connect('posiosApi.getCompanies',[_start,_amount],view.cb_get_companies,false)
        }
        
        //callback function to receive data from invoke
        var cb_getToken=function(response){        
            
           //SET API Token to DATABASE
            $.ajax({
                type: "POST",
                crossDomain: false,
                url:apppath+'/customer/setApiTokenAjax',                
                data:'_api_token='+response.result,
                success: function(data) {
                    console.log('POSiOS API Token set success: '+data);
                },
                error:function(error){
                    console.log('ERROR: '+error);
                }
            });

        }//end my_callback

    }//end function posios
    //initialization
    posios=new Posios();
    
    return posios;
    
});//end posios.js