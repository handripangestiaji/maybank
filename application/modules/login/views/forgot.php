 <form class="form-signin" method='post' action='<?php echo site_url();?>/login/reset_pass'>
    <h2 class="form-signin-heading">Forgot Password</h2>
    <div class="input-prepend">
      <span class="add-on"><i class="icon-user"></i></span>
      <input type="text" name="username" placeholder="Enter your Email">
    </div>
    <div class="input-prepend">
        <p>
        <button class="btn btn-mini btn-danger" type="button" onClick="window.location.href='reset-sukses.html'">
        <i class="icon-ok"></i> 
        Reset
        </button>
        <button class="btn btn-mini" type="button" onClick="window.location.href='login.html'">
        <i class="icon-remove"></i> 
        Cancel
        </button>
        </p>
    </div>
</form>

<div class="signInRow">
    <div><a href="<?php echo base_url('login'); ?>">Login</a></div>
</div>