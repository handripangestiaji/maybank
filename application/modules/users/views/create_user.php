<div class="row-fluid" style="width: 80%; margin: 0px auto;">    
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
<?php
	$msg = $this->session->flashdata('failed');
	if($msg!=NULL){ ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Create User</strong> failed.
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
            
            <form method="post" action="<?php echo site_url();?>/users/insert_user" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>User ID *</td>
                        <td><input type="text" name="userID" /></td>
                    </tr>
                    
                    <tr>
                        <td>Full Name *</td>
                        <td><input type="text" name="fullName" /></td>
                    </tr>
                    
                    <tr>
                        <td>Display Name</td>
                        <td><input type="text" name="displayName" /></td>
                    </tr>
                        
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email"</td>
                    </tr>
                    
                    <tr>
                        <td>Role</td>
                        <td>
                            <select name="optRole">
                                <option>Select Role</option>
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
                                <option>Select Group</option>
                                <?php foreach($group->result() as $g){ ?>
                                    <option value='<?php echo $g->group_id;?>'><?php echo $g->group_name;?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Image</td>
                        <td>
                            <input type='file' name='userfile' id='userfile' />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description'></textarea></td>
                    </tr>
                    
                    <tr>
                        <td>Location</td>
                        <td><input type='text' name='location' /></td>
                    </tr>
                    
                    <tr>
                        <td>Web Addres</td>
                        <td><input type='text' name='web_addres' /></td>
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
        window.location = "<?php echo site_url();?>/users";
    }
    function menu_role()
    {
        window.location.href = "<?php echo site_url();?>/users/menu_role";
    }
    
    function menu_user()
    {
        window.location.href = "<?php echo site_url();?>/users";
    }
    
    function menu_group()
    {
        window.location.href = "<?php echo site_url();?>/users/menu_group";
    }
</script>