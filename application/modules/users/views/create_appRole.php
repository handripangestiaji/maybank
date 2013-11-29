<form method='post' action='<?php echo site_url();?>/users/insert_appRole'>
    <table>
        <tr>
            <td>Role Group</td>
            <td><input type='text' name='role_group' /></td>
        </tr>
        <tr>
            <td>Role Name</td>
            <td><input type='text' name='role_name' /></td>
        </tr>
        <tr>
            <td>Role Friendly Name</td>
            <td><input type='text' name='role_friend' /></td>
        </tr>
        <tr>
            <td>Parent</td>
            <td>
                <select name='parent_id'>
                        <option>Parent</option>
                    <?php foreach($parent->result() as $p){
                        if($p->parent_id == NULL)
                        {
                    ?>
                            <option value='<?php echo $p->app_role_id;?>'><?php echo $p->role_name;?></option>
                            <?php foreach($parent->result() as $child)
                                    {
                                        if($p->app_role_id == $child->parent_id)
                                        {
                            ?>
                                            <option value='<?php echo $child->app_role_id;?>'><?php echo '&nbsp;&nbsp;-'.$child->role_name;?></option>
                                            <?php foreach($parent->result() as $child_child)
                                                    {
                                                        if($child->app_role_id == $child_child->parent_id)
                                                        {
                                            ?>
                                                            <option value='<?php echo $child_child->app_role_id;?>'><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-'.$child_child->role_name;?></option>
                                                            <?php foreach($parent->result() as $child_child_child)
                                                                    {
                                                                        if($child_child->app_role_id == $child_child_child->parent_id)
                                                                        {
                                                            ?>
                                                                            <option value='<?php echo $child_child_child->app_role_id;?>'><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-'.$child_child_child->role_name;?></option>
                    <?php
                                                                        }
                                                                    }
                                                        }
                                                    }
                                        }
                                    }
                        }
                    }?>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type='submit' class='btn' value='Save' />
                <input type='button' class='btn' value='Cancel' onclick='cancel()' />
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    function cancel()
    {
        window.location = "<?php echo site_url();?>/users/menu_role";
    }
</script>