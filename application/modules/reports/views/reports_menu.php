<?php //if(IsRoleFriendlyNameExist($this->user_role, array ('Reporting_User_Performance'))){ ?>
    <a href="<?php echo site_url('reports') ?>"><button style="width:100%; margin:3px 0;" class="btn <?php if($this->uri->segment(2) == ''){echo 'btn-primary'; } ?>" type="button">User Performance</button></a>
<?php //} if(IsRoleFriendlyNameExist($this->user_role, array ('Reporting_User_Activity'))){ ?>
    <a href="<?php echo site_url('reports/activity') ?>"><button style="width:100%; margin:3px 0;" class="btn <?php if((strpos($this->uri->segment(2),'activity')) || ($this->uri->segment(2) == 'activity')){echo 'btn-primary'; } ?>" type="button">User Activity</button></a>
<?php //} ?>