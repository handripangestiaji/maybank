<div class="row-fluid" style="width: 100%; margin: 0px auto;">    
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
<?php
	$msg = $this->session->flashdata('failed');
	if($msg!=NULL){ ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?=$msg?></strong>
        </div>
<?php }?>

<?php
	if($doubleUser!=NULL){ ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>User ID already registered</strong>
        </div>
<?php }?>

<?php
	if($double!=NULL){ ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Your email already registered</strong>
        </div>
<?php }?>
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn btn-primary" onclick="menu_user()" type="button" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" onclick="menu_group()" name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <div>
                <h5>Add New User</h5>
            </div>
            <hr style="margin-top: 0px;">
            
            <form method="post" action="<?php echo site_url('users/insert_user');?>" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>User ID <span style='color: red;'>*</span></td>
                        <td><input type='text' name='username' value="<?php echo set_value('username');?>" />
                        <span style='color:red;'><?php echo form_error('username'); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Full Name <span style='color: red;'>*</span></td>
                        <td><input type="text" name="fullName" value="<?php echo set_value('fullName');?>" />
                        <span style='color:red;'><?php echo form_error('fullName'); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Display Name <span style='color: red;'>*</span></td>
                        <td><input type="text" name="displayName" value="<?php echo set_value('displayName');?>" />
                        <span style='color:red;'><?php echo form_error('displayName'); ?></span></td>
                    </tr>
                        
                    <tr>
                        <td>Email <span style='color: red;'>*</span></td>
                        <td><input type="text" name="email" value="<?php echo set_value('email');?>" />
                        <span style='color:red;'><?php echo form_error('email'); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Role</td>
                        <td>
                            <select name="optRole">
                                <?php foreach($role->result() as $r){?>
                                <option value='<?php echo $r->role_collection_id;?>'><?php echo $r->role_name;?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Group</td>
                        <td>
                            <select name="optGroup">
                                <?php foreach($group->result() as $g){ ?>
                                    <option value='<?php echo $g->group_id;?>'><?php echo $g->group_name;?></option>
                                <?php }?>
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
					?>
						<option value='<?php echo $k;?>'><?php echo $timezone[$k];?></option>
					<?php }?>
				</select>
			</td>
		    </tr>
                    
                    <tr>
                        <td>Image <span style='color: red;'></span></td>
                        <td>
                            <input type='file' name='userfile' id='userfile' accept='image/*' />
                            <span style='color:red;'><?php echo form_error('userfile'); ?>
                        </td>
                    </tr>
                  <?php
                    if(IsRoleFriendlyNameExist($this->user_role, 'Regional_User')):
                    ?>
                    <tr>
                        <td>Country </td>
                        <td>
                            <select name="country">
                            <?php
                                foreach($this->country_list as $country):
                            ?>
                                <option value="<?=$country->code?>"><?=$country->name?></option>
                            <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <?php else:?>
                        <input type="hidden" name="country" value="<?=$this->session->userdata('country');?>" />
                    <?php endif;?>
                    <tr>
                        <td>Description</td>
                        <td><textarea class="about-me" name='description'><?php echo set_value('description');?></textarea></td>
                    </tr>
                    
                    <tr>
                        <td>Location</td>
                        <td><input type='text' name='location' value="<?php echo set_value('location');?>" /></td>
                    </tr>
                    
                    <tr>
                        <td>Web Addres</td>
                        <td><input type='text' name='web_address' value="<?php echo set_value('web_address');?>" /></td>
                    </tr>
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td><span style='color: red;'>* required field</span></td>
                    </tr>
                    
                    <tr>
                        <td><input type="submit" value="Create" name='Create' />
                        <input type="button" value="Cancel" onclick="btn_cancel()" /></td>
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