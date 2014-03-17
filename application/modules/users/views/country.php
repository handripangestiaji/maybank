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
    
    <div id="confirm_country" class="alert alert-error">
	    Confirm delete <b>"Country"</b> ?
            <div style="float: right;">
                <button id="country_code" class="btn btn-mini btn-danger" onclick="yes_delete();">Yes</button>
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
                <h4>Country List</h4>
            </div>
            <div style="float: right;">
                <input class="btn btn-primary" onclick="btn_add()" type="button" name="btn_new" value="+ New Country" />
            </div>
            <div style="clear: both;"></div>
            <hr style="margin-top: 0px;">
            <div style="float: left; margin-top: -10px;">
          
            </div>
           
           
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Country Code</th>
                        <th>Country Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    foreach($countries->result() as $row){ ?>
                    <tr>
                        <td><?php echo $row->code;?></td>
                        <td><?php echo $row->name;?></td>
                        <td><a href='<?php echo site_url("users/edit_country/".$row->code);?>'><span><i class="icon-pencil"></i></span></a></td>
                        <td><a href="" onclick="show_confirm('<?php echo $row->code;?>');return false;"><span><i class="icon-remove redText"></i></span></a></td>
                    </tr>
                    <?php } ?>
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
    
    function yes_delete()
    {
        var id = document.getElementById("country_code").value;
        window.location = "<?php echo site_url('users/delete_country');?>/"+id;
    }
    
    function btn_add()
    {
        window.location.href = "<?php echo site_url('users/create_country');?>";
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
        document.getElementById('country_code').value = tes;
        document.getElementById('confirm_country').style.display = 'block';
    }
    
    function menu_user()
    {
        window.location.href = "<?php echo site_url('users');?>";
    }
    
    function hide_confirm()
    {
        document.getElementById('confirm_country').style.display = 'none';
    }
    
$(function(){
    alert("bro!");

})
    
    
    
    
    
    
</script>