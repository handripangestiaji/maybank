<div class="row-fluid" style="width: 100%; margin: 0px auto;">
    
    <?php
	$msg = $this->session->flashdata('succes');
	if($msg!=NULL){ ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>New Country</strong> has been created.
        </div>
    <?php }?>
    
    <?php
	$msg = $this->session->flashdata('info');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Country</strong> has been edited.
        </div>
    <?php }?>
    
    <?php
	$msg = $this->session->flashdata('info_delete');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Country </strong> has been deleted.
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
	    <?php for($i=0; $i < count($this->user_role ); $i++):?>
		<?php if($this->user_role[$i]->role_friendly_name == 'User Management_User_View'):?>
		    <input class="btn " onclick="menu_user()" type="button" name="btn_user" value="User" /> <br />
		<?php endif;?>
		<?php if($this->user_role[$i]->role_friendly_name == 'User Management_Role_View'):?>
		    <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
		<?php endif;?>
		<?php if($this->user_role[$i]->role_friendly_name == 'User Management_Group_View'):?>
		    <input class="btn" type="button" onclick="menu_group()" name="btn_group" value="Group" />
		<?php endif;?>
                <?php if($this->user_role[$i]->role_friendly_name == 'Regional_User'):?>
                    <input class="btn btn-primary" type="button" onclick="window.location='<?=base_url('users/country')?>'" name="btn_group" value="Country" />
                <?php endif;?>
	    <?php endfor?>
        </div>
        
        <div class="cms-table pull-right">
            <div style="float: left;">
                <h4>Country List</h4>
            </div>
            <?php for($i=0;$i<count($this->user_role);$i++)
                {
                    if($this->user_role[$i]->role_friendly_name=='User Management_User_Create_Delete'){
                ?>
            <div style="float: right;">
                <input class="btn btn-primary" onclick="btn_add()" type="button" name="btn_new" value="+ New Country" />
            </div>
            <?php }}?>
            
            <div style="clear: both;"></div>
            <hr style="margin-top: 0px;">
            <div style="float: left; margin-top: -10px;">
          
            </div>
           
           
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Country Code</th>
                        <th>Country Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><a href="#" class="btn btn-danger btn-delete-country">Delete</a></td>
                    </tr>
                </tbody>
                
            </table>
            
            
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
    
$(function(){
    alert("bro!");

})
    
    
    
    
    
    
</script>