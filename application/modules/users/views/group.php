<div class="row-fluid" style="width: 80%; margin: 0px auto;">
    <?php
	$msg = $this->session->flashdata('succes');
	if($msg!=NULL){ ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>New Group</strong> has been created.
        </div>
    <?php }?>
    
    <?php
	$msg = $this->session->flashdata('info');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Group</strong> has been edited.
        </div>
    <?php }?>
    
    <?php
	$msg = $this->session->flashdata('info_delete');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Group</strong> has been deleted.
        </div>
    <?php }?>
    
    <?php
	$msge = $this->session->flashdata('info_delete_failed');
	if($msge!=NULL){ ?>
        <div class="alert alert-info" style='background: #ffe4e4; color: #b94a48; border-color: #eed3d7;'>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Group</strong> cannot be deleted.
        </div>
    <?php }?>
    
    <div id="confirm_group" class="alert alert-error">
	    Confirm delete <b>"Group"</b> ?
            <div style="float: right;">
                <button id="group_id_delete" class="btn btn-mini btn-danger" onclick="yes_delete_group();">Yes</button>
                <button class="btn btn-mini btn-danger" onclick="hide_confirm();return false;">Cancel</button>
            </div>
            <div style="clear: both;"></div>
    </div>
    
    
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn" onclick='menu_user()' type="button" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn btn-primary" type="button" name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <h5>New Group</h5>
            <hr style="margin-top: 0px;">
            <form method='post' action='<?php echo site_url('users/insert_group');?>'>
                <table style='margin-bottom: 10px;'>
                    <tr>
                        <td>New Group</td>
                        <td>&nbsp;</td>
                        <td><input type='text' name='group_name' value="<?php set_value('group_name');?>" />
                        <span style='color: red;'><?php echo form_error('group_name');?></span></td>
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
                    <?php $i=0; foreach($group as $gr){?>
                    <tr>
                        <td><?php echo $gr->group_name;?></td>
                        <td><?php echo $count_group[$i]?></td>
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
                        <td><?php echo $gr->name;?></td>
                        <td><a href="<?php echo site_url('users/edit_group/'.$gr->group_id);?>"><span><i class="icon-pencil"></i></span></a></td>
                        <td><a href="" onclick="show_confirm('<?php echo $gr->group_id;?>');return false;"><span><i class="icon-remove"></i></span></a></td>
                    </tr>
                    <?php $i++;}?>
                </tbody>
                
            </table>
            <!--<?php //if($count>10){?>
            <div class="page pull-right" style="margin-top: 30px;">
                <?php //echo $links; ?>
            </div>
            <?php //}?>
            -->
        </div>
    </div>
</div>
<style type='text/css'>
    .alert-error
    {
        display: none;
    }
</style>
<script type="text/javascript">
    function yes_delete_group()
    {
        var grp_id = document.getElementById("group_id_delete").value;
        window.location = "<?php echo site_url('users/delete_group');?>/"+grp_id;
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
    
    function show_confirm(tes)
    {
        document.getElementById('group_id_delete').value = tes;
        document.getElementById('confirm_group').style.display = 'block';
    }
    
    function hide_confirm()
    {
        document.getElementById('confirm_group').style.display = 'none';
    }
</script>