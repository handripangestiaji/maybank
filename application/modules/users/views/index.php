<div class="row-fluid" style="width: 80%; margin: 0px auto;">
    
    <?php
	$msg = $this->session->flashdata('succes');
	if($msg!=NULL){ ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>New User</strong> has been created.
        </div>
    <?php }?>
    
    <?php
	$msg = $this->session->flashdata('info');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>User</strong> has been edited.
        </div>
    <?php }?>
    
    <?php
	$msg = $this->session->flashdata('info_delete');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>User</strong> has been deleted.
        </div>
    <?php }?>
    
    <div id="confirm_user" class="alert alert-error">
	    Confirm delete <b>"User"</b> ?
            <div style="float: right;">
                <button id="user_id_delete" class="btn btn-mini btn-danger" onclick="yes_delete_user();">Yes</button>
                <button class="btn btn-mini btn-danger" onclick="hide_confirm();return false;">Cancel</button>
            </div>
            <div style="clear: both;"></div>
    </div>
    
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn btn-primary" type="button" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" onclick="menu_group()" name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <div style="float: left;">
                <h5>User List</h5>
            </div>
            <div style="float: right;">
                <input class="btn btn-primary" onclick="btn_add()" type="button" name="btn_new" value="+ New User" />
            </div>
            
            <div style="clear: both;"></div>
            <hr style="margin-top: 0px;">
            <div style="float: left; margin-top: -10px;">
                <table>
                    <tr>
                        <td>Show :</td>
                        <td>&nbsp;</td>
                        <td>
                            <select>
                                <option>All User Role</option>
                                <?php foreach($role->result() as $rol){?>
                                    <option><?php echo $rol->role_name;?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="float: right; margin-top: -10px;">
                <input type="text" placeholder="Search User name, Email or ID" />
            </div>
            <div style="clear: both"></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
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
                
                <tbody>
                    <?php foreach($show as $row){?>
                    <tr>
                        <td><?php echo $row->user_id;?></td>
                        <td><?php echo $row->display_name;?></td>
                        <td><?php echo $row->email;?></td>
                        <td><?php echo $row->role_name;?></td>
                        <td><?php echo $row->group_name;?></td>
                        <?php if($row->is_active==1){?>
                            <td><?php echo 'Active';?></td>
                        <?php }else{?>
                            <td><?php echo 'Not Active';?></td>
                        <?php }?>
                        <td><?php echo $row->created_at;?></td>
                        <td><?php echo $row->created_by;?></td>
                        <td><a href="<?php echo site_url();?>/users/edit/<?php echo $row->user_id;?>"><span><i class="icon-pencil"></i></span></a></td>
                        <td>
                            <a href="" onclick="show_confirm('<?php echo $row->user_id;?>');return false;"><span><i class="icon-remove"></i></span></a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                
            </table>
            
            <?php if($count>10){?>
            <div class="page pull-right" style="margin-top: 30px; margin-left:10px; margin-right:10px;">
               <?php echo $links; ?>
            </div>
            <?php }?>
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
    function yes_delete_user()
    {
        var usr_id = document.getElementById("user_id_delete").value;
        window.location = "<?php echo site_url();?>/users/delete/"+usr_id;
    }
    
    function btn_add()
    {
        window.location.href = "<?php echo site_url();?>/users/create";
    }
    
    function menu_role()
    {
        window.location.href = "<?php echo site_url();?>/users/menu_role";
    }
    
    function menu_group()
    {
        window.location.href = "<?php echo site_url();?>/users/menu_group";
    }
    
    function show_confirm(tes)
    {
        document.getElementById('user_id_delete').value = tes;
        document.getElementById('confirm_user').style.display = 'block';
    }
    
    function hide_confirm()
    {
        document.getElementById('confirm_user').style.display = 'none';
    }
</script>