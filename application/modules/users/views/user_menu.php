<?php for($i=0; $i < count($this->user_role ); $i++):?>
    <?php if($this->user_role[$i]->role_friendly_name == 'User Management_User_View'):?>
        <input class="btn" onclick="menu_user()" type="button" name="btn_user" value="User" /> <br />
    <?php endif;?>
    <?php if($this->user_role[$i]->role_friendly_name == 'User Management_Role_View'):?>
        <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
    <?php endif;?>
    <?php if($this->user_role[$i]->role_friendly_name == 'User Management_Group_View'):?>
        <input class="btn" type="button" onclick="menu_group()" name="btn_group" value="Group" />
    <?php endif;?>
    <?php if($this->user_role[$i]->role_friendly_name == 'Regional_User'):?>
        <input class="btn" type="button" onclick="window.location='<?=base_url('users/country')?>'" name="btn_group" value="Country" />
    <?php endif;?>
<?php endfor?>