<div class="row-fluid" style="width: 80%; margin: 0px auto;">
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn btn-primary" onclick='menu_user()' type="button" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <h5>New Group</h5>
            <hr style="margin-top: 0px;">
            <form method='post' action='<?php echo site_url();?>/users/insert_group'>
                <table style='margin-bottom: 10px;'>
                    <tr>
                        <td>New Group</td>
                        <td>&nbsp;</td>
                        <td><input type='text' name='group_name' /></td>
                    </tr>
                </table>
            <hr style="margin-top: 0px;">
            <table style='margin-bottom: 10px;'>
                    <tr>
                        <td>Assign Channel</td>
                        <td>&nbsp;</td>
                        <td>
                            <div class="control-group">
                                <div class="controls">
                                    <select id="multipleSelect" multiple="multiple" name='channel[]'>
                                        <?php foreach($channel->result() as $ch){?>
                                           <option value="<?php echo $ch->channel_id; ?>"><?php echo $ch->name;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            <hr style="margin-top: 0px;">
                <div style='float: right'>
                    <input type='submit' class="btn" value='Create' ?>
                </div>
            </from>
                <div style='clear: both'></div><br />
            <hr style="margin-top: 0px;">
            <h5>Current Group</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Users</th>
                        <th>Channel</th>
                        <th>Creator</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php foreach($group->result() as $gr){?>
                    <tr>
                        <td><?php echo $gr->group_name;?></td>
                        <td>10</td>
                        <td>
                            <?php
                                foreach($group_detail->result() as $gd)
                                {
                                    if($gr->group_id == $gd->user_group_id)
                                    {
                                        foreach($channel->result() as $cha)
                                        {
                                            if($gd->allowed_channel==$cha->channel_id)
                                            {
                                                echo $cha->name.', ';
                                            }
                                        }
                                    }
                                }
                            ?>
                        </td>
                        <td>Nicole Lee</td>
                        <td><a href="<?php echo site_url();?>/users/edit_group/<?php echo $gr->group_id;?>"><span><i class="icon-pencil"></i></span></a></td>
                        <td><a href="<?php echo site_url();?>/users/delete_group/<?php echo $gr->group_id;?>"><span><i class="icon-remove"></i></span></a></td>
                    </tr>
                    <?php }?>
                </tbody>
                
            </table>
            <?php if($count>=10){?>
            <div class="page pull-right" style="margin-top: 30px;">
                <a href="#">First</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">Last</a>
            </div>
            <?php }?>
            
        </div>
    </div>
</div>
<script type="text/javascript">
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