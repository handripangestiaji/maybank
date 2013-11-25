
<div style="float: left;">
    <h5><?=$title?> Channel List</h5>
</div>
<div style="float: right;">
    <input class="btn btn-primary" onclick="window.location='<?=base_url('channels/channelmg/Add'.$title)?>'" type="button" name="btn_new" value="+ New <?=$title?> Channel" />
</div>

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
            <td>
                <button class="btn btn-info edit" type="button" id="channel_<?=$channel->channel_id?>"><i class="icon-pencil"></i> Edit</button>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
  
</table>
<div class="page pull-right" style="margin-top: 30px;">
    <a href="#">First</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">Last</a>
</div>
