<script src="<?php echo base_url();?>media/js/jquery-1.7.2.min.js" type="text/javascript" > </script>

<div class="row-fluid" style="width: 80%; margin: 0px auto;">
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn" onclick='menu_user()' type="button" name="btn_user" value="User" /> <br />
            <input class="btn btn-primary" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" onclick='menu_group()' name="btn_group" value="Group" />
        </div>
        <div class="cms-table pull-right">
        <form id="roleform" method='post' action='<?php echo site_url("users/update_role");?>' >
            <h5>Edit Role</h5>
            <hr style="margin-top: 0px;">
            Role Name <input type='text' name='role_name' value='<?php echo $role->row()->role_name;?>' />
	    <span style='color:red;'><?php echo form_error('role_name'); ?></span>
            <input type='hidden' name='role_id' value='<?php echo $role->row()->role_collection_id;?>' />
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
		    <input type='button' id='save' value='Save' />
                    </form>
                </div>
                </div>
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