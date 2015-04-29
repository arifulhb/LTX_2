        <!--footer start-->
        <footer class="site-footer">

            <div class="text-center">
                <p><?php echo date("Y"); ?> &copy; <?php echo $_site_title.' - '.$_site_description;?></p>

                <?php
                if(ENVIRONMENT=="testing"){
                    $label = "label-warning";

                } else if(ENVIRONMENT=="production"){
                    $label = "label-success";

                } else if(ENVIRONMENT=="development"){
                    $label = "label-danger";
                }

                ?>
                <p class="">Environment: <label class="label <?php echo $label;?>"><?php echo ENVIRONMENT;?></label></p>

                <a href="#" class="go-top">
                    <i class="fa fa-angle-up"></i>
                </a>

            </div>

        </footer>

        <!--footer end-->
    </section>