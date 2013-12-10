 <form id="reset_form" class="form-signin" method='post' action='<?php echo site_url('login/reset_pass');?>'>
    <h2 class="form-signin-heading">Forgot Password</h2>
    <div class="input-prepend">
      <span class="add-on"><i class="icon-user"></i></span>
      <input type="text" name="username" placeholder="Enter your Email">
    </div>
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