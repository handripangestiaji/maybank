<form id="login_form" class="form-signin" action="login" method="post">
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
</form>

<div class="signInRow">
    <div class="term"><a href="login/terms">Terms of Use</a></div>
    <div><a href="login/forgot">Lost your password?</a></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#submit').click(function(){
			$('#login_form').submit();
		});
	});
</script>