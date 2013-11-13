<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<?php $this->load->view('metadata') ?>
		<script>window.jQuery || document.write('<script src="<?php echo base_url('media/js/vendor/jquery-1.9.1.min.js')?>"><\/script>')</script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <!-- ==================== TOP MENU ==================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-inner-yellow">
                    <div class="container-fluid">
                        <a class="brand" href="#" style="margin: 10px 0px; padding: 0px;"><img src="<?php echo base_url() ?>media/img/logo-may.png" /></a>
                    </div>
                </div>
            </div>
        <!-- ==================== END OF TOP MENU ==================== -->
        <div class="container-fluid">

            <?php echo $content ?>

        </div>    


        <script src="js/vendor/bootstrap.min.js"></script>
    </body>
</html>
