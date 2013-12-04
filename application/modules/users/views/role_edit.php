<link rel="stylesheet" href="<?php echo base_url();?>media/css/style1.css">
<script src="<?php echo base_url();?>media/js/jquery-1.7.2.min.js" type="text/javascript" > </script>
        <script type="text/javascript">
		$( document ).ready( function( ) {
				$( '.tree li' ).each( function() {
						if( $( this ).children( 'ul' ).length > 0 ) {
								$( this ).addClass( 'parent' );     
						}
				});
				
				$( '.tree li.parent > a' ).click( function( ) {
						$( this ).parent().toggleClass( 'active' );
						$( this ).parent().children( 'ul' ).slideToggle( 'fast' );
				});
				
				$( '#all-toogle' ).click( function() {
					
					$( '.tree li' ).each( function() {
						$( this ).toggleClass( 'active' );
						$( this ).children( 'ul' ).slideToggle( 'fast' );
					});
				});
				
		});
	</script>

<div class="row-fluid" style="width: 80%; margin: 0px auto;">
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn" onclick='menu_user()' type="button" name="btn_user" value="User" /> <br />
            <input class="btn btn-primary" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" onclick='menu_group()' name="btn_group" value="Group" />
        </div>
        <div class="cms-table pull-right">
        <form method='post' action='<?php echo site_url();?>/users/update_role' >
            <h5>Edit Role</h5>
            <hr style="margin-top: 0px;">
            Role Name <input type='text' name='role_name' value='<?php echo $role->row()->role_name;?>' />
            <input type='hidden' name='role_id' value='<?php echo $role->row()->role_collection_id;?>' />
            <br />
            <hr>
            <div>
                <div class="tree" id="tree">
                    Role Permission<br />
                    <ul>
                        <?php foreach($app_show->result() as $parent)
                        {
                            $checked = '';
                            if($parent->parent_id == NULL)
                            {
                        ?>
                        <li>
                            <a><?php echo $parent->role_name;?></a>
                            <ul>
                            <?php foreach($app_show->result() as $child)
                            {
                                if($parent->app_role_id == $child->parent_id)
                                {
                                    foreach($role_detail->result() as $role_d3)
                                            {
                                                if($child->app_role_id == $role_d3->app_role_id)
                                                {
                                                    $checked='checked';
                                                }
                                            }
                            ?>
                                <li><a><input <?php echo $checked;?> type='checkbox' name="role[]" value='<?php echo $child->app_role_id;?>' /><?php echo $child->role_name;?></a>
                            
                            <?php
                                    foreach($app_show->result() as $child_child)
                                    {
                                        if($child->app_role_id == $child_child->parent_id)
                                        {
                                            foreach($role_detail->result() as $role_d2)
                                            {
                                                if($child_child->app_role_id == $role_d2->app_role_id)
                                                {
                                                    $checked='checked';
                                                }
                                            }
                            ?><ul>
                                        <li><a><input <?php echo $checked;?> type='checkbox' name="role[]" value='<?php echo $child_child->app_role_id;?>' /><?php echo $child_child->role_name;?></a>
                                        <?php
                                            foreach($app_show->result() as $child_child_child)
                                            {
                                                if($child_child->app_role_id == $child_child_child->parent_id)
                                                {
                                                    foreach($role_detail->result() as $role_d){
                                                        if($role_d->app_role_id == $child_child_child->app_role_id)
                                                        {
                                                            $checked='checked';
                                                        }
                                                    }
                                        ?>
                                                <ul>
                                                    <li><input <?php echo $checked;?> type='checkbox' name="role[]" value='<?php echo $child_child_child->app_role_id;?>' /><?php echo $child_child_child->role_name;?></li>
                                                </ul>
                                        <?php           
                                                }
                                            }
                                        ?>
                                        </li>
                                </ul>
                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                            
                                </li>
                            </ul>
                        </li>
                        <?php
                            }
                        }
                    
                        ?>
                    </ul>
                    <input type='submit' value='Save' />
                    </form>
                </div>
                </div>
            </div>
           
    </div>
</div>
<script type="text/javascript">
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
</script>