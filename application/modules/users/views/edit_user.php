<div class="row-fluid" style="width: 80%; margin: 0px auto;">    
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn btn-primary" type="button" onclick="menu_user()" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" onclick="menu_group()" name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <div>
                <h5>Edit user</h5>
            </div>
            <hr style="margin-top: 0px;">
            
            <form method='post' action='<?php echo site_url('users/update_user');?>' enctype="multipart/form-data">
    <table cellspacing=5px>
        <?php foreach($id->result() as $row){ ?>
        <tr>
            <td>User ID*</td>
            <td><input name='userID' type="text" value='<?php echo $row->user_id?>' readonly /></td>
        </tr>
        
        <tr>
            <td>Full Name</td>
            <td><input name='fullName' type="text" value='<?php echo $row->full_name;?>' /></td>
        </tr>
        
        <tr>
            <td>Display Name</td>
            <td><input name='displayName' type="text" value='<?php echo $row->display_name;?>' /></td>
        </tr>
        
        <tr>
            <td>Email</td>
            <td><input name='email' type="text" value='<?php echo $row->email;?>' /></td>
        </tr>
        
        <tr>
            <td>Role</td>
            <td>
                <select name="optRole">
                    <?php foreach($role->result() as $r){
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
                    }?>
                </select>
            </td>
        </tr>
        
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
            <td>Image</td>
            <td>
                <img src="<?php echo base_url();echo $row->image_url;?>" style='width: auto; height: 105px;' />
                <input type='file' name='userfile' id='userfile' accept='image/*' />
            </td>
            
        </tr>
        
        <tr>
            <td>Description</td>
            <td><textarea name='description' type='text'><?php echo $row->description;?></textarea></td>
        </tr>
        
        <tr>
            <td>Location</td>
            <td><input name='location' type='text' value="<?php echo $row->location;?>"</td>
        </tr>
        
        <tr>
            <td>Web Address</td>
            <td><input name='web_address' type='text' value="<?php echo $row->web_address;?>" /></td>
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
            <td>
                <input type="submit" value="Save" name='Save' />
                <input type="button" value="Cancel" onclick="btn_cancel()" />
            </td>
        </tr>
        <?php }?>
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