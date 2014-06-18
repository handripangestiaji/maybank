<table>
    <thead>
        <tr>
            <td>Time</td>
            <td>User</td>
            <td>Role</td>
            <td>Action</td>
            <td>Status</td>
        </tr>
    </thead>
    <?php
    if($result){
        foreach($result as $val){ ?>
            <tr>
                <td><?php echo $val->time ?></td>
                <td><?php echo $val->username ?></td>
                <td><?php echo $val->rolename ?></td>
                <td><?php echo $val->action ?></td>
                <td><?php echo $val->status ?></td>
            </tr>
        <?php }
    } else {
        echo '123';
    }
    ?>
</table>