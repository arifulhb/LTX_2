<?php echo doctype('html5'); ?>
<html lang="en">
<head>
     <title><?php
         if(isset($_page_title)){ echo $_page_title.' - '.$_site_title;}
         else{ echo $_site_title;}
         ?></title>
    <?php
        //Meta
        $meta=array(
            array('name' =>'description',   'content' => $_site_description),
            array('name' =>'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' =>'author','content'=>$_author),
            array('name'=>'viewport','content'=>'width=device-width, initial-scale=1.0,maximum-scale=1'));

        $_noindex_meta=array('name'=>'robots','content'=>'noindex,follow');
        if(isset($_noindex)){
            array_push($meta,$_noindex_meta);
        }
        //Cache control
        $_pragma=array('type' => 'equiv','name'=>'Pragma','content'=>'no-cache');
        $_expire=array('type' => 'equiv','name'=>'Expires','content'=>'-1');
        
        array_push($meta, $_pragma);
        array_push($meta, $_expire);
        
        echo meta($meta);

        //Bootstrap
        echo link_tag('assets/plugins/bootstrap/css/bootstrap.css');
        echo link_tag('assets/plugins/bootstrap/css/bootstrap-reset.css');
                        
        //Loading Font-Awesome
        echo link_tag('assets/plugins/font-awesome/css/font-awesome.css');        
        
        //nprogress        
        echo link_tag('assets/plugins/nprogress/nprogress.css');
         
        //datepicker
        echo link_tag('assets/plugins/bootstrap-datepicker/css/datepicker.css');
        
        //
        echo link_tag('assets/css/frontend/style.css?v=140428');
        echo link_tag('assets/css/style-responsive.css');
        echo link_tag('assets/css/table-responsive.css');
        echo link_tag('assets/css/frontend/custom.css');
                
        
        if(isset($_print_css)){
            $print_css_attr = array(
          'href' => 'assets/css/print.css',
          'rel' => 'stylesheet',
          'type' => 'text/css',
          'media' => 'print');
            
            echo link_tag($print_css_attr);    
        }//end css
        
        //JQUERY
        echo link_tag('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
        
        //Google Font
       $open_sans=array('href'=>'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,700,600',
                    'rel' => 'stylesheet',
                    'type' => 'text/css');
        //echo link_tag($open_sans);
        
        /*
        //Favicon
        $ficon=array('href'=>'assets/images/dog1_16.png',
                    'rel' => 'icon',
                    'type' => 'image/png');
        echo link_tag($ficon);

    ?>
    <!--favicon-->
    <link rel="icon" type="image/x-icon" sizes="32x32"
          href="<?php echo base_url(); ?>assets/img/favicon/favicon.png" />
    */?>

    <!--requirejs-->
    <script type="application/javascript"
            src="<?php echo base_url();?>assets/js/require.js"
            data-main="<?php echo base_url();?>assets/js/app"></script>    
</head>
<body class="<?php echo isset($_page_class)?$_page_class:'';?> full-width">
    
    <?php
    //HEADER
    $this->load->view('inc/front_header');
    //SIDE
    //$this->load->view('inc/left_side');
    ?>
    
        <?php 
        echo $_content;
        ?>
        
     <?php    
    //FOOTER
    $this->load->view('inc/front_footer');
    ?>
  
    
    <script>require(['page/page_template']);</script>
    
</body>
</html>