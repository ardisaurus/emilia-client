<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Login</h3>
  <?php if (validation_errors()) {
  			echo validation_errors();
  		} 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  	?>
  <?php echo form_open('login/proses', 'class="form-horizontal"');?>
		<label for="email">Email</label>
		<input type="email" name="email"/>
		<label for="password">Password</label>
		<input type="password" name="password"/>
		<input type="submit" name="login" value="Log In"/>
	</form>
	<a href="<?php echo site_url('login/forgotpassword');?>">Forgot Password</a>
	<p>
		<a href="<?php echo site_url('signup');?>">Sign Up</a>		
	</p>
</body>
</html>