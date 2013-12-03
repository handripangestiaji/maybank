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
            <form method='post' action='<?php echo site_url();?>/users/insert_role' >
            <h5>New User Role</h5>
            <hr style="margin-top: 0px;">
            New Role <input type='text' name='new_role' /><br />
            <hr>
            <!--<div style='float: right;'>
                <input type='button' class='btn' id="next" value='Next' onclick="showHide();return false;" />
            </div>-->
            <div>
                <div style='clear: both;'></div>
                <div class="tree_tree" id="tree_tree">
                    Role Permission
                    
		    <div id='jqxWidget'>
			<div>
		             <div id='jqxTree'>
				<ul>
                                    <?php foreach($app_show->result() as $parent)
                                            {
                                                if($parent->parent_id == NULL){
                                    ?>
				    
                                    <li><?php echo $parent->role_name;?>
					<ul>
                                            <?php foreach($app_show->result() as $child)
                                            {
                                                if($parent->app_role_id == $child->parent_id)
                                                {
                                            ?>
					    <li><?php echo $child->role_name;?><!--<input type='hidden' name="role[]" value='<?php echo $child->app_role_id;?>' />-->
                                                <ul>
                                                    <?php
                                                            foreach($app_show->result() as $child_child)
                                                            {
                                                                if($child->app_role_id == $child_child->parent_id)
                                                                {
                                                    ?>
                                                                <li><?php echo $child_child->role_name;?><!--<input type='hidden' name="role[]" value='<?php echo $child_child->app_role_id;?>' />-->
                                                                    <ul>
                                                                        <?php
                                                                            foreach($app_show->result() as $child_child_child)
                                                                            {
                                                                                if($child_child->app_role_id == $child_child_child->parent_id)
                                                                                {
                                                                        ?>
                                                                        <li item-checked='true'><?php echo $child_child_child->role_name;?><!--<input type='hidden' name="role[]" value='<?php echo $child_child_child->app_role_id;?>' />--></li>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>  
                                                                    </ul>
                                                                </li>
                                                            <?php
                                                                }
                                                            }
                                                            ?>    
                                                </ul>
                                            </li>
                                            <?php
                                                }
                                            }
                                            ?>
					</ul>
				    </li>
                                    <?php
                                            }
                                        }
                                    ?>
				</ul>
			    </div>
			</div>
		    </div>
			    
		    <input type='submit' value='Save' />
                    </form>
                </div>
                </div>
                
            <input type='button' value='Create Role Permission' onclick='btn_createRole()' />
            <h5>Current User Role</h5>
            <table class="table table-striped table-role">
                <thead>
                    <tr>
                        <td>User Role</td>
                        <td>Users</td>
                        <td>Creator</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($show->result() as $row){?>
                    <tr>
                        <td><?php echo $row->role_name;?></td>
                        <td>0</td>
                        <td>kosong</td>
                        <td><a href='<?php echo site_url();?>/users/edit_role/<?php echo $row->role_collection_id;?>'><span><i class="icon-pencil"></i></span></a></td>
                        <td><button class="btn-role-delete" id="delete_<?PHP echo $row->role_collection_id; ?>"><span><i class="icon-remove"></i></span></button></td>
                        
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            </div>
           
    </div>
    </div>
</div>
<style type="text/css">
   .tree_tree {
      display: block;
      margin-bottom: 15px;
      }
</style>
<script type="text/javascript">
    function btn_createRole()
    {
        window.location = '<?php echo site_url();?>/users/create_appRole';
    }
    function menu_role()
    {
        window.location.href = "<?php echo site_url();?>/users/menu_role";
    }
    
    function menu_user()
    {
        window.location.href = "<?php echo site_url();?>/users";
    }
    
    function menu_group()
    {
        window.location.href = "<?php echo site_url();?>/users/menu_group";
    }
    function showHide(sh) {
                document.getElementById('tree_tree').style.display = 'block';
                document.getElementById('next').type = 'hidden';
    }
</script>
<script type="text/javascript">
	$(document).ready(function(e){
			$('.btn-role-delete').click(function(e) {
		            if(confirm('Are you want delete this data ?'))
			    {
				var id = $(this).attr('id').substr(7);
                                
				window.location = '<?php echo site_url();?>/users/delete_role/'+id;
			    }
		        });
		});

	$(document).ready(function () {
		// Create jqxTree 
		var theme = "";
		// create jqxTree
		$('#jqxTree').jqxTree({ height: 'auto', hasThreeStates: true, checkboxes: true, width: '500px' });
                var item = $('#jqxTree').jqxTree('getSelectedItem');
                console.log(item);
	    });
	
</script>