<div class="navbar-inner">
    <div class="container-fluid">
        <a class="brand" href="#" style="float:left;"><img src="<?php echo base_url('media/img/maybank_logo.jpg')?>" style="max-height:95%;"/></a>
		<div style="width:1px; height:30px; margin: 7.5px 0px 0px -18px; background-color:white; float:left;"></div>
		<p style="font-size:15px;font-family:'Trebuchet MS';font-weight:bold;vertical-align:bottom;padding-top:14px;margin-left:-10px;float:left">DCMS</p>
		<?php
			if(session_id() == NULL)
			{
				echo 
				'<div class="nav pull-right">
					<form class="navbar-form">
						<div class="input-append">
							<div class="collapsibleContent">
								<a href="#tasksContent" class="sidebar"><span class="add-on add-on-middle add-on-mini add-on-dark" id="tasks"><i class="icon-tasks"></i><span class="notifyCircle cyan">3</span></span></a>
								<a href="#profileContent" class="sidebar"><span class="add-on add-on-mini add-on-dark" id="profile"><i class="icon-user"></i><span class="username">Adrian Lee</span></span></a>
							</div>
							<a href="#collapsedSidebarContent" class="collapseHolder sidebar"><span class="add-on add-on-mini add-on-dark"><i class="icon-sort-down"></i></span></a>
						</div>
					</form>
				</div><!--/.nav-collapse -->
				';
				}
				?>
    </div>
</div>