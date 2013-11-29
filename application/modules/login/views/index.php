<form id="login_form" class="form-signin" action='<?php echo site_url();?>/login/auth' method="post">
    <h2 class="form-signin-heading">Digital Channel Management System</h2>
    <div class="input-prepend">
      <span class="add-on"><i class="icon-user"></i></span>
      <input type="text" name="username" placeholder="Username">
    </div>
    <div class="input-prepend">
      <span class="add-on"><i class="icon-lock"></i></span>
      <input type="password" name="password" placeholder="Password">
      <a id="submit" href="javascript:void(0);"><span class="add-on" id="login"><i class="icon-arrow-right"></i></span></a>
    </div>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Login Failed!</strong> Username and password are incorrect.
     </div>
</form>

<div class="signInRow">
    <div class="term"><a href="<?php echo site_url();?>/login/terms">Terms of Use</a></div>
    <div><a href="<?php echo site_url();?>/login/forgot">Lost your password?</a></div>
</div>
     
<script type="text/javascript">
	$(document).ready(function(){
		$('#submit').click(function(){
			$('#login_form').submit();
		});
		
		$('#login_form').bind('keypress', function(e){
			if(e.which == 13)
			{
				$('#login_form').submit();
			}
		})
                                
                $(this).on('click', '.alert > .close', function() {
                    $(this).parent().hide();
                });
	});
</script>