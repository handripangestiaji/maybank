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
				
				$( '#all' ).click( function() {
					
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
            <form method='post' action='<?php echo site_url();?>/users/insert_role' >
            <h5>New User Role</h5>
            <hr style="margin-top: 0px;">
            New Role <input type='text' name='new_role' /><br />
            <hr>
            <div style='float: right;'>
                <input type='button' class='btn' id="next" value='Next' onclick="showHide();return false;" />
            </div>
            <div style='clear: both;'></div>
            <div>
                <div class="tree" id="tree">
                    Role Permission
                    <ul>
                        <?php foreach($app_show->result() as $parent)
                        {
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
                            ?>
                                <li><a><input type='checkbox' name="role[]" value='<?php echo $child->app_role_id;?>' /><?php echo $child->role_name;?></a>
                            
                            <?php
                                    foreach($app_show->result() as $child_child)
                                    {
                                        if($child->app_role_id == $child_child->parent_id)
                                        {
                            ?><ul>
                                        <li><a><input type='checkbox' name="role[]" value='<?php echo $child_child->app_role_id;?>' /><?php echo $child_child->role_name;?></a>
                                        <?php
                                            foreach($app_show->result() as $child_child_child)
                                            {
                                                if($child_child->app_role_id == $child_child_child->parent_id)
                                                {
                                        ?>
                                                <ul>
                                                    <li><input type='checkbox' name="role[]" value='<?php echo $child_child_child->app_role_id;?>' /><?php echo $child_child_child->role_name;?></li>
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
		    <div id='jqxWidget'>
			<div style='float: left;'>
		             <div id='jqxTree'>
				<ul>
				    <li id='home'>Home</li>
				    <li >Solutions
					<ul>
					    <li>Education</li>
					    <li>Financial services</li>
					    <li>Government</li>
					    <li item-checked='false'>Manufacturing</li>
					    <li>Solutions
						<ul>
						    <li>Consumer photo and video</li>
						    <li>Mobile</li>
						    <li>Rich Internet applications</li>
						    <li>Technical communication</li>
						    <li>Training and eLearning</li>
						    <li>Web conferencing</li>
						</ul>
					    </li>
					    <li>All industries and solutions</li>
					</ul>
				    </li>
				    <li>Products
					<ul>
					    <li>PC products</li>
					    <li>Mobile products</li>
					    <li>All products</li>
					</ul>
				    </li>
				    <li>Support
					<ul>
					    <li>Support home</li>
					    <li>Customer Service</li>
					    <li>Knowledge base</li>
					    <li>Books</li>
					    <li>Training and certification</li>
					    <li>Support programs</li>
					    <li>Forums</li>
					    <li>Documentation</li>
					    <li>Updates</li>
					</ul>
				    </li>
				    <li>Communities
					<ul>
					    <li>Designers</li>
					    <li>Developers</li>
					    <li>Educators and students</li>
					    <li>Partners</li>
					    <li>By resource
						<ul>
						    <li>Labs</li>
						    <li>TV</li>
						    <li>Forums</li>
						    <li>Exchange</li>
						    <li>Blogs</li>
						    <li>Experience Design</li>
						</ul>
					    </li>
					</ul>
				    </li>
				    <li>Company
					<ul>
					    <li>About Us</li>
					    <li>Press</li>
					    <li>Investor Relations</li>
					    <li>Corporate Affairs</li>
					    <li>Careers</li>
					    <li>Showcase</li>
					    <li>Events</li>
					    <li>Contact Us</li>
					    <li>Become an affiliate</li>
					</ul>
				    </li>
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
   .tree {
      display: none;
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
                document.getElementById('tree').style.display = 'block';
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
		$('#jqxTree').jqxTree({ height: 'auto', hasThreeStates: true, checkboxes: true, width: '500px', theme: theme });
		$('#jqxCheckBox').jqxCheckBox({ width: '500px', height: '25px', checked: true, theme: theme });
		$('#jqxCheckBox').on('change', function (event) {
		    var checked = event.args.checked;
		    $('#jqxTree').jqxTree({ hasThreeStates: checked });
		});
		$("#jqxTree").jqxTree('selectItem', $("#home")[0]);
	    });
	
</script>