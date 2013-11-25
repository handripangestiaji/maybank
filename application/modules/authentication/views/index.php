<h1>Login</h1>
<p>Please login with your User ID and password below.</p>
	
<form method='post' action='<?php echo site_url();?>/authentication/check_user'>
  <table>
    <thead>
      <tr>
	<td>User Name</td>
	<td><input type='text' name='username' /></td>
      </tr>
      <tr>
	<td>Password</td>
	<td><input type='password' name='password' /></td>
      </tr>
      <tr>
	<td><input type='submit' value='Login' /></td>
      </tr>
    </thead>
  </table>
</form>