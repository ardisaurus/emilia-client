<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Forgot Password</h3>
<?php if (validation_errors()) {
  			echo validation_errors();
  		} 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  	?>
  <?php echo form_open('login/forgotpasswordproses', 'class="form-horizontal"');?>
		<label for="email">Email</label>
		<input type="email" name="email"/>
		<input type="submit" name="submit" value="Submit"/>
	</form>
	<p>
		<a href="<?php echo site_url('login');?>">Log In</a>		
	</p>
</body>
</html>