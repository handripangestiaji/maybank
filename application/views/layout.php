<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->

<!--[if gt IE 8]>
<!--> 
<html class="no-js"> <!--<![endif]-->
    
    <head>
    	<?php echo $this->load->view('metadata') ?>
    </head>
	
	<body class="dashboard">
		<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
        <!-- ==================== TOP MENU ==================== -->
        <div class="navbar navbar-inverse navbar-fixed-top">
        	<?php echo $this->load->view('top_menu') ?>
        </div>
        <!-- ==================== END OF TOP MENU ==================== -->
        
		<!-- ==================== SIDEBAR ==================== -->
        <div class="hiddenContent">
            <?php echo $this->load->view('sidebar')?>
        </div>
        <!-- ==================== END OF SIDEBAR ==================== -->
        
        <!-- ==================== MAIN MENU ==================== -->
        <div class="mainmenu">
            <?php 
				if(session_id() == NULL){
					echo $this->load->view('menu');
				}
			?>
        </div>
        <!-- ==================== END OF MAIN MENU ==================== -->
        
        <!-- ==================== DROPDOWN MENU FOR MOREOPTIONS ICON (hidden state) ==================== -->
        <ul class="dropdown-menu" id="moreOptionsMenu">
            <li class="dropdown-submenu">
                <a href="#">More options</a>
                <ul class="dropdown-menu">
                    <li><a href="#">Second level link</a></li>
                    <li><a href="#">Second level link</a></li>
                    <li><a href="#">Second level link</a></li>
                    <li><a href="#">Second level link</a></li>
                    <li><a href="#">Second level link</a></li>
                </ul>
            </li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
        </ul>
        <!-- ==================== END OF DROPDOWN MENU ==================== -->
        
        <!-- ==================== PAGE CONTENT ==================== -->
        <div class="content">

            <!-- ==================== BREADCRUMBS / DATETIME ==================== -->
            <ul class="breadcrumb">
		<li><i class="icon-home"></i><a href="<?php echo base_url('dashboard'); ?>"> Home</a> <span class="divider"><i class="icon-angle-right"></i></span></li>
		<li class="active">
		    <?php
			$value = array(1 => 'dashboard',2 => 'channels',3 => 'cms',4 => 'manage_users', 5 => 'users', 6 => 'reports', 7 => 'publisher', 8 => 'manage_channel');
			$value = array('dashboard' => 'Dashboard','channels' => 'Channels', 'cms' => 'Content Management','manage_users' => 'Manage Users','users' => 'User Management',
				       'reports' => 'Reports','publisher' => 'Publisher','manage_channel' => 'Manage Channel');
			echo $value[$this->uri->segment(1)];
		    ?>
		</li>
		<li class="moveDown pull-right">
			<span class="date"></span>
			<span class="time"></span>
		</li>    
	    </ul>
	    <!-- ==================== END OF BREADCRUMBS / DATETIME ==================== -->
                
                <!-- ==================== CONTAINER ==================== -->
                <div class="container-fluid"> 
                
	                <!-- ==================== ROW ==================== -->
	                	<?php echo $content ?>  
	                <!-- ==================== END OF ROW ==================== -->
	                
                </div>
                <!-- ==================== END OF CONTAINER ==================== -->
                
        </div>
        <!-- ==================== END OF PAGE CONTENT ==================== -->
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url('media/js/vendor/jquery-1.9.1.min.js')?>"><\/script>')</script>
        <script src="<?php echo base_url('media/js/vendor/bootstrap-slider.js')?>"></script>                   <!-- bootstrap slider plugin -->
        <script src="<?php echo base_url('media/js/vendor/jquery.sparkline.min.js')?>"></script>               <!-- small charts plugin -->
        <script src="<?php echo base_url('media/js/vendor/jquery.flot.min.js')?>"></script>                    <!-- charts plugin -->
        <script src="<?php echo base_url('media/js/vendor/jquery.flot.resize.min.js')?>"></script>             <!-- charts plugin / resizing extension -->
        <script src="<?php echo base_url('media/js/vendor/jquery.flot.pie.min.js')?>"></script>                <!-- charts plugin / pie chart extension -->
        <script src="<?php echo base_url('media/js/vendor/wysihtml5-0.3.0_rc2.min.js')?>"></script>            <!-- wysiwyg plugin -->
        <script src="<?php echo base_url('media/js/vendor/bootstrap-wysihtml5-0.0.2.min.js')?>"></script>      <!-- wysiwyg plugin / bootstrap extension -->
        <script src="<?php echo base_url('media/js/vendor/bootstrap-tags.js')?>"></script>                     <!-- multivalue input tags -->
        <script src="<?php echo base_url('media/js/vendor/jquery.tablesorter.min.js')?>"></script>             <!-- tablesorter plugin -->
        <script src="<?php echo base_url('media/js/vendor/jquery.tablesorter.widgets.min.js')?>"></script>     <!-- tablesorter plugin / widgets extension -->
        <script src="<?php echo base_url('media/js/vendor/jquery.tablesorter.pager.min.js')?>"></script>       <!-- tablesorter plugin / pager extension -->
        <script src="<?php echo base_url('media/js/vendor/raphael.2.1.0.min.js')?>"></script>                  <!-- vector graphic plugin / for justgage.js -->
        <script src="<?php echo base_url('media/js/vendor/justgage.js')?>"></script>                           <!-- justgage plugin -->
        <script src="<?php echo base_url('media/js/vendor/bootstrap-multiselect.js')?>"></script>              <!-- multiselect plugin -->
        <script src="<?php echo base_url('media/js/vendor/bootstrap-datepicker.js')?>"></script>               <!-- datepicker plugin -->
        <script src="<?php echo base_url('media/js/vendor/bootstrap-colorpicker.js')?>"></script>              <!-- colorpicker plugin -->
        <script src="<?php echo base_url('media/js/vendor/parsley.min.js')?>"></script>                        <!-- parsley validator plugin -->
        <script src="<?php echo base_url('media/js/vendor/formToWizard.js')?>"></script>                       <!-- form wizard plugin -->
	<!-- <script src="<?php //echo base_url('media/js/vendor/fullcalendar.min.js')?>"</script>        		<!-- fullcalendar plugin -->
        <script src="<?php echo base_url('media/js/vendor/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('media/js/vendor/bootstrap-editable.min.js')?>"></script>             <!-- editable fields plugin -->
	
	<!-- <script src="<?php //echo base_url('media/js/vendor/jquery-ui-1.10.2.custom.min.js')?>"</script>        	<!-- jquery ui dragging -->    
		
	<!-- <script type="text/javascript" src="<?php //echo base_url(); ?>media/js/jquery-1.7.2.min.js"></script> --> <!-- jquery widget tree -->
	<script src="<?php echo base_url(); ?>media/js/vendor/jqwidgets/jqxcore.js"></script> <!-- jquery widget tree -->
	<script src="<?php echo base_url(); ?>media/js/vendor/jqwidgets/jqxtree.js"></script> <!-- jquery widget tree -->
	<script src="<?php echo base_url(); ?>media/js/vendor/jqwidgets/jqxcheckbox.js"></script> <!-- jquery widget tree -->

        <script src="<?php echo base_url(); ?>media/js/vendor/bootstrap-linkpreview.js"></script> <!-- jquery linkpreview -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script> <!-- jquery tag-it -->
	<script src="<?php echo base_url(); ?>media/js/vendor/tag-it.js"></script> <!-- jquery tag-it -->

        <script src="<?php echo base_url('media/js/thekamarel.min.js')?>"></script>                            <!-- main project js file -->
        <script src="<?php echo base_url('media/js/thekamarel.js')?>"></script>                            <!-- main project js file -->
	
	<script src="<?php echo base_url('media/js/kamarelimprove.js')?>"></script>                            <!-- main project js file -->
    </body>
</html>