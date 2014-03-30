<script src="<?php echo base_url();?>media/js/jquery-1.7.2.min.js" type="text/javascript" > </script>

<div class="row-fluid" style="width: 100%; margin: 0px auto;">
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
	<?php
		//$msge = $this->session->flashdata('double');
		if($msg_role!=NULL){ ?>
		<div class="alert alert-info" style='background: #ffe4e4; color: #b94a48; border-color: #eed3d7;'>
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Role Name already registered.</strong>
		</div>
	    <?php }?>
	<?php
		//$msge = $this->session->flashdata('double');
		if($role_check!=NULL){ ?>
		<div class="alert alert-info" style='background: #ffe4e4; color: #b94a48; border-color: #eed3d7;'>
		    <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <strong>Role Permission cannot empty.</strong>
		</div>
	    <?php }?>
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
	    <?php $this->load->view('users/user_menu')?>
        </div>
	<form id="roleform" method='post' action='<?php echo site_url("users/update_role");?>' >
        <div class="cms-table pull-right">
            <h5>Edit Role</h5>
            <hr style="margin-top: 0px;">
            Role Name <input type='text' name='role_name' value='<?php echo $role->row()->role_name;?>' /> <br />
	    
	    <?php if(IsRoleFriendlyNameExist($this->user_role, array('User Management_Role_All_Country_Edit'))):?>
	    Country &nbsp;&nbsp;
            <select name="country_code">
                <?php
                    foreach($this->country_list as $country):
                ?>
                    <option value="<?=$country->code?>" <?=$country->code == $role->row()->country_code ? "selected='selected'" : ""?> >
		    <?=$country->name?></option>
                <?php endforeach;?>
            </select>
	    <?php else:?>
	    <select name="country_code" class="hide">
		<option value="<?=$this->session->userdata('country')?>"><?=$this->session->userdata('country')?></option>
	    </select>
	    <?php endif;?>
        
	    <span style='color:red;'><?php echo form_error('role_name'); ?></span>
            <input type='hidden' name='role_id' value='<?php echo $role->row()->role_collection_id;?>' />
	    <input type='hidden' name='role_name1' value='<?php echo $role->row()->role_name;?>' />
            <hr>
            <div>
                <div class="tree" id="tree">
                    Role Permission<br />
                    <div id='jqxWidget'>
			<div>
		             <div id='jqxTree'>
				
			    </div>
			</div>
		    </div>
                    <input type='hidden' id='role_id' name='role[]' value='' />
		    <input type='submit' id='save' value='Save' />
		    <input type='button' onclick="menu_role()" value='Cancel' />
                    
                </div>
                </div>
	    <span style='color:red;'><?php echo form_error('role'); ?></span>
            </div>
	</form>
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
                var items = $('#jqxTree').jqxTree('getCheckedItems');
                for(i=0;i<items.length;i++){
                    console.log(items[i]);    
                }
                //alert(items);
	    });
	
</script>