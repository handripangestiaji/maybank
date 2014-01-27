<div class="navbar-inner">
    <div class="container-fluid">
         <a class="brand" href="#" style="margin: 7.5px 0px; padding: 0px;">
	    <img src="<?php echo base_url() ?>media/img/DCMS-Logo.png" />
	 </a>
	<div class="nav pull-right">
		<form class="navbar-form">
			<div class="input-append">
				<div class="collapsibleContent">
				    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Stream_All_Take Action')):?>
					<a href="#tasksContent" class="sidebar">
					    <span class="add-on add-on-middle add-on-mini add-on-dark" id="tasks">
						<i class="icon-tasks"></i>
						<?php if(isset($case)){echo '<span class="notifyCircle cyan">'.(count($case) + count($reply_pending) + $count_assign).'</span>';}?>
					    </span>
					</a>
				    <?php endif?>
					<a href="#profileContent" class="sidebar"><span class="add-on add-on-mini add-on-dark" id="profile"><i class="icon-user"></i><span class="username"><?php echo $this->session->userdata('display_name'); ?></span></span></a>
				</div>
				<a href="#collapsedSidebarContent" class="collapseHolder sidebar"><span class="add-on add-on-mini add-on-dark"><i class="icon-sort-down"></i></span></a>
			</div>
		</form>
	</div><!--/.nav-collapse -->
    </div>
</div>