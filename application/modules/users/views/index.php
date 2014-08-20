<?php
    //echo '<pre>'; print_r($this->user_role);echo'</pre>';
?>


<div class="row-fluid" style="width: 100%; margin: 0px auto;">
    
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
        <div class="cms-filter pull-left users-menu">
	    <?php $this->load->view('users/user_menu')?>
        </div>
        
        <div class="cms-table pull-right">
            <div style="float: left;">
                <h4>User List</h4>
            </div>
            <?php if(IsRoleFriendlyNameExist($this->user_role, array('User Management_User_Own_Country_Create',
                                                         'User Management_User_All_Country_Create'))):?>
                <div style="float: right;">
                    <input class="btn btn-primary" onclick="btn_add()" type="button" name="btn_new" value="+ New User" />
                </div>
            <?php endif;?>
            <div style="clear: both;"></div>
            <hr style="margin-top: 0px;">
            <div style="float: left; margin-top: -10px;">
                <table>
                    <tr>
                        <td>Show :</td>
                        <td>&nbsp;</td>
                        <td>
                            <select id="filterRole" onchange="window.location = window.location.origin + window.location.pathname + '?role_collection_id=' + this.value">
                                <option value="0">All User Role</option>
                                <?php foreach($role->result() as $rol){?>
                                    <option value="<?=$rol->role_collection_id?>"
                                    <?=$rol->role_collection_id == $this->input->get('role_collection_id') ? "selected='selected'" : ""?>
                                    ><?php echo $rol->role_name;?></option>
                                <?php }?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="float: right; margin-top: -10px;">
                <form id="search_form" method="get" action="<?php echo site_url('users');?>">
                <table>
                    <tr>
                        <td><input type="text" id="search_user" name="q" placeholder="Search Name, Email or User ID" /></td>
                        <td style='padding-bottom: 10px;'>
                            <button class="btn-primary" type="submit"><span class="add-on" id="login"><i class="icon-search"></i></span>
                            </button>
                        </td>
                    </tr>
                </table>
                </form>
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
                        <th>Country</th>
                        <th>Creator</th>
                        <?php if(IsRoleFriendlyNameExist($this->user_role, array('User Management_User_Own_Country_Edit',
                                                         'User Management_User_All_Country_Edit'))):?>
                        <th colspan="2">Action</th>
                        
                        <?php endif;?>
                        
                    </tr>
                </thead>
                
                <tbody>
                    <?php if($show != null)
                    {
                        foreach($show as $row){
                            $is_same_country = $row->country_code == $this->session->userdata('country');
			    if($row->is_hidden == 1 && !IsRoleFriendlyNameExist($this->user_role, 'User Management_User_All_Country_Edit')) continue;
                            ?>
                    <tr <?php echo $row->is_hidden == 1 ? 'class="hidden-data"' : '' ?>>
                        <td><?php echo $row->username;?></td>
                        <td><?php echo $row->display_name;?></td>
                        <td><?php echo $row->email;?></td>
                        <td><?php echo $row->role_name;?></td>
                        <td><?php echo $row->group_name;?></td>
                        <?php if($row->is_active==1){?>
                            <td><?php echo 'Active';?></td>
                        <?php }else{?>
                            <td><?php echo 'Deactived';?></td>
                        <?php }?>
                        <td><?php echo $row->created_at;?></td>
                        <td><?php echo $row->country_code?></td>
                        <td><?php echo $row->created_by_name;?></td>
                        <?php
                        $edit_permission = $is_same_country ? array('User Management_User_All_Country_Edit', 'User Management_User_Own_Country_Edit') :
                                'User Management_User_All_Country_Edit';
                        if(IsRoleFriendlyNameExist($this->user_role, $edit_permission)):?>
                        <td><a href="<?php echo site_url('users/edit/'.$row->user_id);?>"><span><i class="icon-pencil"></i></span></a></td>
                        <?php endif;?>
                        <?php
                            $delete_permission = $is_same_country ? array('User Management_User_All_Country_Delete', 'User Management_User_Own_Country_Delete') :
                                'User Management_User_All_Country_Delete';
                            if(IsRoleFriendlyNameExist($this->user_role, $delete_permission)):
                        ?>
                        <td>
                            <a href="" onclick="show_confirm('<?php echo $row->user_id;?>');return false;"><span><i class="icon-remove redText"></i></span></a>
                        </td>
                        <?php else :?>
                        <td></td>
                        <?php endif;?>
                    </tr>
                    <?php }
                    }?>
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
    function search_user()
    {
        document.getElementById("search_form").submit();
    }
    
    function yes_delete_user()
    {
        var usr_id = document.getElementById("user_id_delete").value;
        window.location = "<?php echo site_url('users/delete');?>/"+usr_id;
    }
    
    function btn_add()
    {
        window.location.href = "<?php echo site_url('users/create');?>";
    }
    
    function menu_role()
    {
        window.location.href = "<?php echo site_url('users/menu_role');?>";
    }
    
    function menu_group()
    {
        window.location.href = "<?php echo site_url('users/menu_group');?>";
    }
    
    function show_confirm(tes)
    {
        document.getElementById('user_id_delete').value = tes;
        document.getElementById('confirm_user').style.display = 'block';
    }
    
    function menu_user()
    {
        window.location.href = "<?php echo site_url('users');?>";
    }
    
    function hide_confirm()
    {
        document.getElementById('confirm_user').style.display = 'none';
    }
</script>