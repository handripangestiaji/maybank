Add New User
<form method="post" action="<?php echo site_url();?>/users/insert_user">
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
            <td><input type="submit" value="Create" />
            <input type="button" value="Cancel" onclick="btn_cancel()" /></td>
        </tr>
    </table>
</form>
<script type='text/javascript'>
    function btn_cancel()
    {
        window.location = "<?php echo site_url();?>/users";
    }
</script>