<?php
    $value = array(1 => 'dashboard',2 => 'channels',3 => 'cms',4 => 'manage_users', 5 => 'users', 6 => 'reports', 7 => 'publisher', 8 => 'manage_channel');
    for($i=1;$i<9;$i++){
	if($this->uri->segment(1) == $value[$i]){
	    $active[$i] = 'active';
	}
	else{
	    $active[$i] = '';
	}
    }
?>

<div class="container-fluid">
    <ul class="nav">
        <li class="collapseMenu"><a href="#"><i class="icon-double-angle-left"></i>hide menu<i class="icon-double-angle-right deCollapse"></i></a></li>
        <li class="divider-vertical firstDivider"></li>
        <li class="left-side <?php echo $active[1]; ?>" id="dashboard"><a href="<?php echo base_url('dashboard'); ?>"><i class="icon-dashboard"></i> DASHBOARD</a></li>
        <li class="divider-vertical"></li>
        <li class="dropdown <?php echo $active[2]; ?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="formElements"><i class="icon-list"></i> CHANNELS <span class="label label-pressed">4</span></a>
            <ul class="dropdown-menu">
                <li><a tabindex="-1" href="common-form.html">FACEBOOK</a></li>
                <li><a tabindex="-1" href="validation-form.html">YOUTUBE</a></li>
                <li><a tabindex="-1" href="form-wizard.html">TWITTER</a></li>
            </ul>
        </li>
        <li class="divider-vertical"></li>
        <li class="dropdown <?php echo $active[3]; ?>">
            <a href="<?php echo base_url('cms'); ?>" id="interface"><i class="icon-file-alt"></i> CONTENT MANAGEMENT</a>
        </li>
        <?php if($this->_access_level == 1) { ?>
        <li class="divider-vertical"></li>
        <li class="dropdown <?php echo $active[4]; ?>">
            <a href="#" id="interface"><i class="icon-user"></i> MANAGE USERS</a>
        </li>
        <?php } ?>
        <li class="divider-vertical"></li>
        <li class="dropdown <?php echo $active[5]; ?>">
            <a href="#" id="interface"><i class="icon-user"></i> USER MANAGEMENT</a>
        </li>
	<li class="divider-vertical"></li>
        <li class="dropdown <?php echo $active[6]; ?>">
            <a href="#" id="interface"><i class="icon-bar-chart"></i> REPORTS</a>
        </li>
	<li class="divider-vertical"></li>
        <li class="dropdown <?php echo $active[7]; ?>">
            <a href="#" id="interface"><i class="icon-calendar"></i> PUBLISHER</a>
        </li>
	<li class="divider-vertical"></li>
        <li class="dropdown <?php echo $active[8]; ?>">
            <a href="#" id="interface"><i class="icon-building"></i> CHANNEL MANAGEMENT</a>
        </li>
    </ul>
</div>