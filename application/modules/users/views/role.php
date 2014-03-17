<script src="<?php echo base_url();?>media/js/jquery-1.7.2.min.js" type="text/javascript" > </script>

<div class="row-fluid" style="width: 100%; margin: 0px auto;">
    <?php
		//$msge = $this->session->flashdata('double');
		if($role_check!=NULL){ ?>
		<div class="alert alert-info" style='background: #ffe4e4; color: #b94a48; border-color: #eed3d7;'>
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Role Permission cannot empty.</strong>
		</div>
	    <?php }?>
    <?php
	//$msge = $this->session->flashdata('double');
	if($msg_role!=NULL){ ?>
        <div class="alert alert-info" style='background: #ffe4e4; color: #b94a48; border-color: #eed3d7;'>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Role Name already registered.</strong>
        </div>
    <?php }?>
    <?php
	$msg = $this->session->flashdata('succes');
	if($msg!=NULL){ ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>New Role</strong> has been created.
        </div>
    <?php }?>
    <?php
	$msg = $this->session->flashdata('info');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Role</strong> has been edited.
        </div>
    <?php }?>
    
    <?php
	$msg = $this->session->flashdata('info_delete');
	if($msg!=NULL){ ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Role</strong> has been deleted.
        </div>
    <?php }?>
    
    <?php
	$msge = $this->session->flashdata('info_delete_failed');
	if($msge!=NULL){ ?>
        <div class="alert alert-info" style='background: #ffe4e4; color: #b94a48; border-color: #eed3d7;'>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Role</strong> cannot be deleted.
        </div>
    <?php }?>
    
    <div id="confirm_role" class="alert alert-error">
	    Confirm delete <b>"Role"</b> ?
            <div style="float: right;">
                <button id="role_id_delete" class="btn btn-mini btn-danger" onclick="yes_delete_role();">Yes</button>
                <button class="btn btn-mini btn-danger" onclick="hide_confirm();return false;">Cancel</button>
            </div>
            <div style="clear: both;"></div>
    </div>
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left users-menu">
	    <?php $this->load->view('user_menu')?>
        </div>
        
        <div class="cms-table pull-right">
            <?php
                for($i=0;$i<count($this->user_role);$i++){
                    if($this->user_role[$i]->role_friendly_name=='User Management_Role_Create_Delete'){
            ?>
            <form id="roleform" method='post' action="<?php echo site_url('users/insert_role');?>" >
            <h4>New User Role</h4>
            <hr style="margin-top: 0px;">
            New Role <input type='text' name='new_role' value="<?php set_value('new_role');?>"/>
            <span style='color:red;'><?php echo form_error('new_role'); ?></span></td>
            
            <hr>
            <div style='float: right;'>
                <input type='button' class='btn' id="next" value='Next' onclick="showHide();return false;" />
            </div>
            <div>
                <div style='clear: both;'></div>
                <div class="tree_tree" id="tree_tree">
                    Role Permission
                    
		    <div id='jqxWidget'>
			<div>
		             <div id='jqxTree'>
				
			    </div>
			</div>
		    </div>
		    <input type='hidden' id="role_id" name="role[]" value='' />    
		    <input type='button' id="save" value='Save' />
                    </form>
                </div>
                </div>
        <hr />
        <?php }}?>
            <!--<input type='button' value='Create Role Permission' onclick='btn_createRole()' />
            --><h4>Current User Role</h4>
            <table class="table table-striped table-role">
                <thead>
                    <tr>
                        <th>User Role</th>
                        <th>Users</th>
                        <th>Creator</th>
                        <?php for($i=0;$i<count($this->user_role);$i++){?>
                            <?php if($this->user_role[$i]->role_friendly_name=='User Management_User_Edit'){?>
                            <th>&nbsp;</th>
                            <?php }if($this->user_role[$i]->role_friendly_name=='User Management_User_Create_Delete'){?>
                            <th>&nbsp;</th>
                        <?php }}?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0; foreach($show as $row){ ?>
                    <tr>
                        <td><?php echo $row->role_name;?></td>
                        <td><?php echo $count_role[$i+$plus];?></td>
                        <td><?php echo $row->display_name;?></td>
                        <?php for($x=0;$x<count($this->user_role);$x++){
                                if($this->user_role[$x]->role_friendly_name=='User Management_Role_Edit'){
                        ?>
                            <td><a href='<?php echo site_url("users/edit_role/".$row->role_collection_id);?>'><span><i class="icon-pencil"></i></span></a></td>
                        <?php   }}
                            for($y=0;$y<count($this->user_role);$y++){
                            if($this->user_role[$y]->role_friendly_name=='User Management_Role_Create_Delete'){
                        ?>
                        <td><a href="" onclick="show_confirm('<?php echo $row->role_collection_id;?>');return false;"><span><i class="icon-remove"></i></span></a></td>
                        <?php }}?>
                    </tr>
                    <?php $i++;}?>
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
</div>
<style type="text/css">
   .tree_tree {
      display: none;
      margin-bottom: 15px;
      }
    .alert-error
    {
        display: none;
    }
</style>
<script type="text/javascript">
    function yes_delete_role()
    {
        var role_id = document.getElementById("role_id_delete").value;
        window.location = '<?php echo site_url("users/delete_role");?>/'+role_id;;
    }
    function btn_createRole()
    {
        window.location = '<?php echo site_url("users/create_appRole");?>';
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
    function showHide(sh) {
                document.getElementById('tree_tree').style.display = 'block';
                document.getElementById('next').type = 'hidden';
    }
    function show_confirm(tes)
    {
        document.getElementById('role_id_delete').value = tes;
        document.getElementById('confirm_role').style.display = 'block';
    }
    
    function hide_confirm()
    {
        document.getElementById('confirm_role').style.display = 'none';
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
		// Create jqxTree 
		var theme = "";
		// create jqxTree
                var source = jQuery.parseJSON('<?php echo $json?>');
                
		$('#jqxTree').jqxTree({ height: 'auto', hasThreeStates: true, checkboxes: true, width: '500px', source: source });
                
                $("#save").click(function(){
                    var items = $('#jqxTree').jqxTree('getCheckedItems');
                    
                    var array = new Array();
                    
                    for(i=0;i<items.length;i++)
                    {
                        array[i] = items[i].value;
                    }
                    
                    $("#role_id").val(array);
                    
                    $("#roleform").submit();
                    
                    console.log(array);
                });
	    });
	
</script>