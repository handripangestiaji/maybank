<h5>New User Role</h5>
New Role <input type='text' /><br />
<hr>
<div style='float: left;'>
    Role Permission 
    <table>
        <thead>
            <tr>
                <th>+Social Stream</th>
            </tr>
            <tr>
                <th>Channel</th>
            </tr>
            <tr>
                <th>Current Channel</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach($app_show->result() as $app) { ?>
                <td><input type='checkbox' value='<?php echo $app->role_name;?>' /><?php echo $app->role_name;?></td>
                <?php }?>
            </tr>

            <tr>
                <td><input type='button' value='Create Role' onclick='btn_createRole()' /></td>
            </tr>
        </tbody>
    </table>
</div>

<div style='clear: both;'></div>
<h5>Current User Role</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <td>User Role</td>
            <td>Users</td>
            <td>Creator</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($show->result() as $row){?>
        <tr>
            <td><?php echo $row->role_name;?></td>
            <td>0</td>
            <td>kosong</td>
            <td><a href=''><span><i class="icon-pencil"></i></span></a></td>
            <td><a href=''><span><i class="icon-remove"></i></span></a></td>
        </tr>
        <?php }?>
    </tbody>
</table>

<script type='text/javascript'>
    function btn_createRole()
    {
        window.location = '<?php echo site_url();?>/users/create_appRole';
    }
</script>