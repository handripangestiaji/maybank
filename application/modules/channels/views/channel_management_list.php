
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
            <th>User ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Group</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Creator</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
  
</table>
<div class="page pull-right" style="margin-top: 30px;">
    <a href="#">First</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">Last</a>
</div>
