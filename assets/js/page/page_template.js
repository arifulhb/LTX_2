require(['order!jquery','order!nprogress','order!common_scripts'], function($,NProgress){            
    
        NProgress.start();

        var _keypad=$('.keypad').length;
        //alert(_keypad);
        if(_keypad> 0){
            $('.key_display').focus();
            
            $('.keypad .key').click(function(){                
                var _val=$('.key_display').val();                
                $('.key_display').val(_val+$(this).text());                
            });//end keypress
            
            $('.keypad .key-back').click(function(){                
                var _val=$('.key_display').val();                
                $('.key_display').val(_val.substr(0,_val.length - 1));            
            });//end keypress
            $('.keypad .key-clear').click(function(){
                $('.key_display').val('');
                $('.key_display').focus();
            });
        }
        
        NProgress.done();
    
});