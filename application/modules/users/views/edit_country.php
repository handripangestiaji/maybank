<div class="row-fluid" style="width: 100%; margin: 0px auto;">    
<!--<span style="font-size: 14pt; color: black; margin: 5px 0;">USER MANAGEMENT</span>-->
    <div class="cms-content row-fluid">
         <div class="cms-filter pull-left users-menu">
	    <?php $this->load->view('users/user_menu')?>
        </div>
        
               
        <div class="cms-table pull-right">
            <div>
                <h5>Edit Country</h5>
            </div>
            <hr style="margin-top: 0px;">
            
            <form method='post' action='<?php echo site_url('users/update_country');?>' enctype="multipart/form-data">
    <table cellspacing=5px>
        <?php foreach($country->result() as $row){ ?>
        <tr>
            <td>Code</td>
            <td><input name='code' type="hidden" value='<?php echo $row->code?>' />
            <input type="text" value='<?php echo $row->code?>' readonly /></td>
        </tr>
        
        <tr>
            <td>Name <span style='color: red;'>*</span></td>
            <td><input name='name' type="text" value="<?php echo set_value('name',isset($row->name) ? $row->name : '')?>" />
            <span style='color:red;'><?php echo form_error('name'); ?></span></td>
        </tr>
        
        <tr>
            <td>&nbsp;</td>
            <td><span style='color: red;'>* required field</span></td>
        </tr>
        
        <tr>
            <td>
                <input type="submit" value="Save" name='Save' />
                <input type="button" value="Cancel" onclick="btn_cancel()" />
            </td>
        </tr>
        <?php }?>
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