
<?php if(IsRoleFriendlyNameExist($this->user_role, array('User Management_User_Own_Country_View',
                                                         'User Management_User_All_Country_View'))):?>
    <a href="<?php echo base_url(); ?>users"><button class="btn <?php if($this->uri->segment(2) == ''){echo 'btn-primary'; } ?>" type="button"/>User</button></a> <br />
<?php endif; ?>
<?php if(IsRoleFriendlyNameExist($this->user_role,array('User Management_Role_Own_Country_View',
                                                         'User Management_Role_All_Country_View'))):?>
    <a href="<?php echo base_url(); ?>users/menu_role"><button class="btn <?php if(strpos($this->uri->segment(2),'role')){echo 'btn-primary'; } ?>" type="button"/>Role</button></a><br />
<?php endif;?>
<?php if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Group_Own_Country_View',
                                                         'User Management_Group_All_Country_View'))):?>
    <a href="<?php echo base_url() ?>users/menu_group"><button class="btn <?php if(strpos($this->uri->segment(2),'group')){echo 'btn-primary'; } ?>" type="button"/>Group</button></a>
<?php endif;?>
<?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Channel Management_Country',
                                                         'Social Channel Management_Country_Add',
                                                         'Social Channel Management_Country_Delete'))):?>
    <a href="<?php echo base_url() ?>users/country"><button class="btn <?php if((strpos($this->uri->segment(2),'country')) || ($this->uri->segment(2) == 'country')){echo 'btn-primary'; } ?>" type="button">Country</button></a>
<?php endif;?>
