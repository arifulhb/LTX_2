require(['order!jquery','order!apppath','order!jquery-ui','order!inputmask'], function($,apppath){ 

  $('#from,#to').inputmask('dd/mm/yyyy',
        {"placeholder": "dd/mm/yyyy",
        "oncomplete": function(){                                         
                        
        }});
    
});