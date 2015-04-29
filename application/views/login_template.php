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
            array('name'=>'viewport','content'=>'width=device-width, initial-scale=1.0'));

        //add noindex nofollow if $_noindex_meta is set
        $_noindex_meta=array('name'=>'robots','content'=>'noindex,nofollow');
        if(isset($_noindex)){
            array_push($meta,$_noindex_meta);
        }

        echo meta($meta);

        //Bootstrap
        echo link_tag('assets/plugins/bootstrap/css/bootstrap.css');
        //Loading Font-Awesome

        echo link_tag('assets/plugins/font-awesome/css/font-awesome.min.css');

         //LinkTag -> add CSS
        echo link_tag('assets/css/app.css');
        echo link_tag('assets/css/animate.css');
        echo link_tag('assets/css/landing.css');        
        //echo link_tag('assets/css/plugin.css');
        
        //Google Font
        $open_sans=array('href'=>'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,700,600',
                    'rel' => 'stylesheet',
                    'type' => 'text/css');
        echo link_tag($open_sans);
        
        //Favicon
        /*$ficon=array('href'=>'assets/images/dog1_16.png',
                    'rel' => 'icon',
                    'type' => 'image/png');
        echo link_tag($ficon);

    ?>
    <!--favicon-->
    <link rel="icon" type="image/x-icon" sizes="32x32"
          href="<?php echo base_url(); ?>assets/img/favicon/favicon.png" />
          */
        ?>
    
    <!--requirejs-->
    <script type="application/javascript"
            src="<?php echo base_url();?>assets/js/require.js"
            data-main="<?php echo base_url();?>assets/js/app"></script>
</head>
<body class="<?php echo isset($_page_class)?$_page_class:'';?>">
    <?php
    //echo $_site_title;
    echo $_content;
    ?>
</body>
</html>