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

         //LinkTag -> add CSS
        echo link_tag('assets/css/app.css');        
        echo link_tag('assets/css/style.css');

        ?>
    
</head>
<body class="<?php echo isset($_page_class)?$_page_class:'';?>">
    <?php
    echo $_content;
    ?>
</body>
</html>