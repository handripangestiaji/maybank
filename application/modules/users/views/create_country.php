<div class="row-fluid" style="width: 100%; margin: 0px auto;">    
<?php
	$msg = $this->session->flashdata('failed');
	if($msg!=NULL){ ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?=$msg?></strong>
        </div>
<?php }?>
    <div class="cms-content row-fluid">
        <div class="cms-filter pull-left">
            <input class="btn btn-primary" onclick="menu_user()" type="button" name="btn_user" value="User" /> <br />
            <input class="btn" type="button" onclick="menu_role()" name="btn_role" value="Role"  />   <br />
            <input class="btn" type="button" onclick="menu_group()" name="btn_group" value="Group" />
        </div>
        
        <div class="cms-table pull-right">
            <div>
                <h5>Add New Country</h5>
            </div>
            <hr style="margin-top: 0px;">
            
            <form method="post" action="<?php echo site_url('users/insert_country');?>" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Country Code <span style='color: red;'>*</span></td>
                        <td><input type='text' name='code' value="<?php echo set_value('code');?>" />
                        <span style='color:red;'><?php echo form_error('username'); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Country Name <span style='color: red;'>*</span></td>
                        <td><input type="text" name="name" value="<?php echo set_value('name');?>" />
                        <span style='color:red;'><?php echo form_error('fullName'); ?></span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><span style='color: red;'>* required field</span></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Create" name='Create' />
                        <input type="button" value="Cancel" onclick="btn_cancel()" /></td>
                    </tr>
                </table>
            </form>          
        </div>
    </div>
</div>

<script type='text/javascript'>
    function btn_cancel()
    {
        window.location = "<?php echo site_url('users/country');?>";
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
</script>