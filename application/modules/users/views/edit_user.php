Edit User
<form method='post' action='<?php echo site_url();?>/users/update_user'>
    <table cellspacing=5px>
        <?php foreach($id->result() as $row){ ?>
        <tr>
            <td>User ID*</td>
            <td><input name='userID' type="text" value='<?php echo $row->user_id?>' /></td>
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
            <td><input name='email' type="text"</td>
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
            <td>
                <input type="submit" value="Save" />
            </td>
        </tr>
        <?php }?>
    </table>
</form>