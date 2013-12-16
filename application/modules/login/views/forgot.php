<form id="reset_form" class="form-signin" method='post' action='<?php echo site_url('login/reset_pass');?>'>
<?php
 if($success!=NULL)
 {
?>
    <div class="alert alert-success">
       Your Password has been reset, please check your email. 
   </div>
<?php
 }
?>

<?php
 if($failed!=NULL)
 {
?>
    <div class="alert alert-error">
       Email is not valid. 
   </div>
<?php
 }
?>
    <h2 class="form-signin-heading">Forgot Password</h2>
    <div class="input-prepend">
      <span class="add-on"><i class="icon-user"></i></span>
      <input type="text" name="username" placeholder="Enter your Email" value="<?php set_value('username');?>" />
    </div>
    <span style='color:red;display: '><?php echo form_error('username'); ?></span>
    <div style="margin-bottom: 10px;">
   <a id="submit" href="javascript:void(0);"><button class="btn btn-mini btn-danger" type="button"><i class="icon-ok"></i> Reset</button></a>
   <button class="btn btn-mini" type="button" onClick="window.location.href='<?php echo site_url('login');?>'"><i class="icon-remove"></i> Cancel</button>
   </div>
</form>

<div class="signInRow">
    <div class="term"><a href="<?php echo site_url('login');?>"><i class="icon-arrow-left"></i> Back</a></div>
    <div></div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#submit').click(function(){
			$('#reset_form').submit();
		});
		
		$('#reset_form').bind('keypress', function(e){
			if(e.which == 13)
			{
				$('#reset_form').submit();
			}
		})
	});
</script>