
<div style="float: left;">
    <h5><?=$title?> Channel List</h5>
</div>
<?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Add')):?>
<div style="float: right;">
    <?php if(IsRoleFriendlyNameExist($this->user_role, 'Regional_User') && ($title == 'Twitter' || $title == 'Youtube')):?>
        
        <select class='country-select' name="country" style="margin-top: 10px">
            <?php
            $country_list = $this->users_model->get_country_list();
                foreach($country_list as $country):
            ?>
                <option value="<?=$country->code?>"><?=$country->name?></option>
            <?php endforeach;?>
        </select>
        
    <?php endif;?>
    <a class="btn btn-primary new-channel" href="<?=base_url('channels/channelmg/Add'.$title)?>" type="button" name="btn_new" value="" >+ New <?=$title?> Channel</a>
    
</div>
<?php endif;?>

<div style="clear: both"></div>
<hr style="margin-top: 0px;">
<!--div style="float: left; margin-top: -10px;">
    <table>
        <tr>
            <td>Show :</td>
            <td>&nbsp;</td>
            <td>
                <select>
                    <option>All User Role</option>
                    <option>Super Admin</option>
                    <option>Administrator</option>
                    <option>Manager</option>
                    <option>Author</option>
                    <option>Viewer</option>
                </select>
            </td>
        </tr>
    </table>
</div>
<div style="float: right; margin-top: -10px;">
    <input type="text" placeholder="Search User name, Email or ID" />
</div-->
<div style="clear: both"></div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Channel ID</th>
            <th>Name</th>
            <th>Token</th>
            <th>Active</th>
            <th>Connection Type</th>
            <th>Social ID</th>
            <th>Country</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($channel_list as $channel):?>
        <tr>
            <td><?=$channel->channel_id?></td>
            <td><?=$channel->name?></td>
            <td><?=substr($channel->oauth_token, 0, 10).'....'?></td>
            <td><?=$channel->is_active == 1 ? "Active" : "No Active"?></td>
            <td><?=$channel->connection_type.' '.($channel->is_fb_page == 1? " Page" : "") ?></td>
            <td><?=$channel->social_id?></td>
            <td><?=$channel->country_code?></td>
            <?php if(IsRoleFriendlyNameExist($this->user_role, 'Social Channel Management_Remove')):?>
            <td>
                <button value="<?=base_url('channels/channelmg/DeleteChannel?channel_id='.$channel->channel_id."&token=".$this->session->userdata('channel_token_delete'))?>" class="btn btn-danger delete" type="button" id="channel_<?=$channel->channel_id?>"><i class="icon-trash"></i> Delete</button>
            </td>
            <?php else:?>
            <td></td>
            <?php endif;?>
        </tr>
        <?php endforeach;?>
    </tbody>
  
</table>
<?php
    if($total_row > 15):
?>
<div class="page pull-right" style="margin-top: 30px;">
    <a href="#">First</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">Last</a>
</div>
<?php endif?>
