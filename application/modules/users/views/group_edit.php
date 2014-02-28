<div class="row-fluid" style="width: 100%; margin: 0px auto;">
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <?php
	//$msge = $this->session->flashdata('double');
	if($msge!=NULL){ ?>
        <div class="alert alert-info" style='background: #ffe4e4; color: #b94a48; border-color: #eed3d7;'>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Group Name already registered.</strong>
        </div>
    <?php }?>
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn" onclick='menu_user()' type="button" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn btn-primary" type="button" onclick='menu_group()' name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <h5>Edit Group</h5>
            <hr style="margin-top: 0px;">
            <form method='post' action='<?php echo site_url('users/update_group');?>'>
                
            <hr style="margin-top: 0px;">
            <table style='margin-bottom: 10px;'>
                    <tr>
                        <td>Name Group</td>
                        <td>
                            <input type='text' name='group_name' value='<?php echo $group->row()->group_name;?>' />
                            <span style='color:red;'><?php echo form_error('group_name'); ?></span>
                            <input type='hidden' name='group_id' value='<?php echo $group->row()->group_id;?>' />
                            <input type='hidden' name='g_name' value='<?php echo $group->row()->group_name;?>' />
                        </td>
                    </tr>
		    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Regional_User')):?>
		    <tr>
			<td>Country</td>
			
			<td>
			    <select id="countrySelect" name="country">
				<?php foreach($country_list as $country):?>
				<option value="<?=$country->code?>"><?=$country->name?></option>
				<?php endforeach?>
			    </select>
			</td>
		    </tr>
		    <?php endif;?>
                    <tr>
                        <td>Assign Channel</td>
                        <td>
                            <div class="control-group">
                                <div class="controls">
                                    <select id="multipleSelect" multiple="multiple" name='channel[]'>
                                        <?php    
                                                foreach($channel->result() as $ch){
                                                    $selected = '';
                                                    foreach($group_detail->result() as $gd){
                                                        if($gd->allowed_channel == $ch->channel_id)
                                                        {
                                                            $selected = 'selected';
                                                        }
                                                    }
                                        ?>            
                                            <option <?php echo $selected ?> value="<?php echo $ch->channel_id; ?>"><?php echo $ch->name;?></option>
                                         <?php
                                                }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            <hr style="margin-top: 0px;">
                <div style='float: right'>
                    <input type='submit' class="btn" value='Save' />
                    <input type='button' class='btn' value='Cancel' onclick='menu_group()' /> 
                </div>
            </from>
        </div>
    </div>
</div>
<script type="text/javascript">
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