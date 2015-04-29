require(['order!jquery','order!apppath','order!jquery-ui','order!dtpicker','order!inputmask'], function($,apppath){ 
      
    //date picker          
    var dob=$('#inputBirthday').val();
    
    if(dob!=''){
        var year=dob.substring(6,10);
        var month=dob.substring(3,5);
        var day=dob.substring(0,2);    
        //$('#inputBirthday').datepicker("setValue", new Date(year,month,day));               
    }else{
        //$('#inputBirthday').datepicker();       
    }
    
    $('#inputBirthday').inputmask('dd/mm/yyyy',
        {"placeholder": "dd/mm/yyyy",
        "oncomplete": function(){                                         
                        
        }});
    
        //CONVERT DATE TO SAVE DATE
    function convertDate(_date){
         
         if(_date.length>0){                        
            var day = _date.substr(0,2);
            var month = _date.substr(3,2);
            var year = _date.substr(6,4);
            //var _td = new Date(month+'/'+day+'/'+year);        
            return month+'/'+day+'/'+year;
         }else{            
             return '';
         }
    }//end function
    
});