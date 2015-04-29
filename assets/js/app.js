requirejs.config({
    //By default load any module IDs from js/lib
    //baseUrl: 'assets/js',
    urlArgs:'v=140814.002.06',
    paths: {
        'apppath'   :'page/apppath',
        'posios'    :'app/posios',
        'invoke'    :'app/invoke',
        'pos_server':'app/pos_server',        
        'jquery'    :'//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min',        
        'jquery-ui' :'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min',
        'bootstrap' :'../plugins/bootstrap/js/bootstrap',
        'inputmask'  :'../plugins/jquery-inputmask/dist/jquery.inputmask.bundle.min',
        'nprogress'  :'../plugins/nprogress/nprogress',
        'spin'      :'../plugins/spin/spin.min',     
        'order'     :'lib/order',
        'json2'     :'lib/json2'
    },
    shim: {
        "bootstrap" : {deps: ["jquery"]},
        "invoke"    : {deps: ["jquery"]},
        "inputmask" : {deps: ["jquery"]},
        //"spin"      : {deps: ["jquery"]},
        "nprogress" : {deps:['jquery']}        
    }
});


require(['order!jquery','order!bootstrap','order!nprogress'],function($){
    console.log('LOADED require.js');
    //alert('HOST: '+window.location.origin);
});