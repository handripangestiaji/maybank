
<div class="row-fluid" style="width: 100%; margin: 0px auto;">    

    <?php
    
        if($double!=NULL){ ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Your email already registered</strong>
        </div>
    <?php }?>
    <div class="cms-content row-fluid">
         <div class="cms-filter pull-left users-menu">
	    <?php $this->load->view('users/user_menu')?>
        </div>
        
               
        <div class="cms-table pull-right">
            <div>
                <h5>Edit user</h5>
            </div>
            <hr style="margin-top: 0px;">
            
            <form method='post' action='<?php echo site_url('users/update_user');?>' enctype="multipart/form-data">
    <table cellspacing=5px>
        <?php $row = $id->row();
            if($row == null) exit();
            ?>
        
        <tr>
            <td>User ID</td>
            <td><input name='userID' type="hidden" value='<?php echo $row->user_id?>' />
            <input type="text" value='<?php echo $row->username?>' readonly /></td>
        </tr>
        
        <tr>
            <td>Full Name <span style='color: red;'>*</span></td>
            <td><input name='fullName' type="text" value="<?php echo set_value('fullName',isset($row->full_name) ? $row->full_name : '')?>" />
            <span style='color:red;'><?php echo form_error('fullName'); ?></span></td>
        </tr>
        
        <tr>
            <td>Display Name <span style='color: red;'>*</span></td>
            <td><input name='displayName' type="text" value="<?php echo set_value('displayName',isset($row->display_name) ? $row->display_name : '')?>" />
            <span style='color:red;'><?php echo form_error('displayName'); ?></span></td>
        </tr>
        
        <tr>
            <td>Email <span style='color: red;'>*</span></td>
            <td><input name='email' type="text" value="<?php echo set_value('email',isset($row->email) ? $row->email : '')?>" />
            <span style='color:red;'><?php echo form_error('email'); ?></span></td></td>
            <input name='email1' type="hidden" value="<?php echo $row->email;?>" />
        </tr>
        <?php
        $current_user_role = $this->users_model->get_collection_detail(
		array('role_collection_id' => $row->role_id));
        $is_same_country = $this->session->userdata('country') == $row->country_code;
        
        $role_check = ($is_same_country && $this->session->userdata('user_id') != $row->user_id && IsRoleFriendlyNameExist($this->user_role, 'User Management_User_Own_Country_Edit')) ||
        IsRoleFriendlyNameExist($this->user_role, 'User Management_User_All_Country_Edit');
        if($role_check):
        ?>
        <tr>
            <td>Role</td>
            <td>
                <select name="optRole">
                    <?php foreach($role->result() as $r){
                        if($r->role_collection_id != $this->session->userdata('role_id') || (IsRoleFriendlyNameExist($this->user, 'User Management_User_All_Country_Edit'))) {
                            if($row->role_id == $r->role_collection_id)
                            {
                        ?>
                                <option value='<?php echo $r->role_collection_id;?>' selected='selected'><?php echo $r->role_name;?></option>
                        <?php
                            }
                            else
                            {
                        ?>
                            <option value='<?php echo $r->role_collection_id;?>'><?php echo $r->role_name;?></option>
                        <?php
                            }
                        }
                    }?>
                </select>
            </td>
        </tr>
        <?php endif;?>
        <tr>
            <td>Group</td>
            <td>
                <select name="optGroup">
                    <?php foreach($group->result() as $g)
                    {
                        if($row->group_id == $g->group_id)
                        {
                    ?>
                        <option value='<?php echo $g->group_id;?>' selected='selected'><?php echo $g->group_name;?></option>
                    <?php
                        }
                        else{
                    ?>
                        <option value='<?php echo $g->group_id;?>'><?php echo $g->group_name;?></option>
                    <?php }
                    }
                    ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Timezone</td>
            <td>
                <select name='timezone'>
                    <?php
                        $timezone = get_timezone_list();
                        $keys = array_keys($timezone);
                        foreach($keys as $k)
                        {
                            if($row->timezone==$k)
                            {
                    ?>
                                <option selected='selected' value='<?php echo $k?>'><?php echo $timezone[$k];?></option>
                    <?php
                            }
                            else
                            {
                    ?>
                                <option value='<?php echo $k?>'><?php echo $timezone[$k];?></option>
                    <?php            
                            }
                        }
                    ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>Image</td>
            <td>
                <?php if($row->image_url!=NULL){?>
                <img src="<?php echo base_url();echo $row->image_url;?>" style='width: auto; height: 105px;' />
                <?php }?>
                <input type='file' name='userfile' id='userfile' accept='image/*' />
            </td>
            
        </tr>
          <?php
        if(IsRoleFriendlyNameExist($this->user_role, 'User Management_User_All_Country_Edit')):
        ?>
        <tr>
            <td>Country </td>
            <td>
                <select name="country">
                <?php
                    foreach($this->country_list as $country):
                ?>
                    <option value="<?=$country->code?>" <?php echo trim($country->code) == trim($row->country_code) ?  "selected='selected'" : ''?>><?=$country->name?></option>
                <?php endforeach;?>
                </select>
            </td>
        </tr>
        <?php else:?>
        <input type="hidden" name="country" value="<?=$row->country_code?>" />
        <?php endif;?>
        
        <tr>
            <td>Description</td>
            <td><textarea name='description' type='text'><?php echo set_value('description',isset($row->description) ? $row->description : '')?></textarea></td>
        </tr>
        
        <tr>
            <td>Location</td>
            <td><input name='location' type='text' value="<?php echo set_value('location',isset($row->location) ? $row->location : '')?>"</td>
        </tr>
        
        <tr>
            <td>Web Address</td>
            <td><input name='web_address' type='text' value="<?php echo set_value('web_address',isset($row->web_address) ? $row->web_address : '')?>" /></td>
        </tr>
        
        <tr>
            <td>Status</td>
            <td>
                <select name="is_active">
                    <?php
                        $status = $row->is_active;
                        if($status==1)
                        {
                    ?>
                        <option selected='selected' value=1>Active</option>
                        <option value=0>Deactived</option>
                    <?php
                        }
                        else
                        {
                    ?>
                        <option value=1>Active</option>
                        <option selected='selected' value=0>Deactived</option>
                    <?php
                        }
                    ?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><span style='color: red;'>* required field</span></td>
        </tr>
        
        <tr>
            <td>
                <input type="submit" value="Save" name='Save' />
                <input type="button" value="Cancel" onclick="btn_cancel()" />
            </td>
        </tr>
    </table>
</form>
            
            
        </div>
    </div>
</div>

<script type='text/javascript'>
    function btn_cancel()
    {
        window.location = "<?php echo site_url('users');?>";
    }
    function menu_role()
    {
        window.location.href = "<?php echo site_url('users/menu_role');?>";
    }
    
    function menu_user()
    {
        window.location.href = "<?php echo site_url('users');?>";
    }
    
    function menu_group()
    {
        window.location.href = "<?php echo site_url('users/menu_group');?>";
    }
</script>