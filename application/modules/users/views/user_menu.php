
<?php if(IsRoleFriendlyNameExist($this->user_role, 'User Management_User_View')):?>
    <input class="btn" onclick="menu_user()" type="button" name="btn_user" value="User" href="index," /> <br />
<?php endif;?>
<?php if(IsRoleFriendlyNameExist($this->user_role,'User Management_Role_View')):?>
    <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  href="menu_role,edit_role" />   <br />
<?php endif;?>
<?php if(IsRoleFriendlyNameExist($this->user_role, 'User Management_Group_View')):?>
    <input class="btn" type="button" onclick="menu_group()" name="btn_group" value="Group" href="menu_group,edit_group"/>
<?php endif;?>
<?php if(IsRoleFriendlyNameExist($this->user_role, array('Social Channel Management_Country',
                                                         'Social Channel Management_Country_Add',
                                                         'Social Channel Management_Country_Delete'))):?>
    <input class="btn" type="button" onclick="window.location='<?=base_url('users/country')?>'" name="btn_group" value="Country"  href="country,create_country"/>
<?php endif;?>
