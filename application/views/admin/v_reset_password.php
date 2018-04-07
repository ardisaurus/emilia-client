<!DOCTYPE html>
<html>
<head>
	<title>Detail Unregistered Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<a href="<?php echo site_url('admin/device');?>">Device List</a>
<h3>Detail Unegistered Device</h3>	
	<?php 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  		if ($this->session->flashdata('hasil')) { 
  			echo $this->session->flashdata('hasil');
  		}
  	?>
  	<br>
  	Id = <?php echo $dvc_id; ?>
	<?php echo form_open('admin/device/process_reset_password');?>
		<label for="dvc_password">Reset Password</label>
		<input type="hidden" name="dvc_id" readonly="true" value="<?php echo $dvc_id; ?>" />
		<label for="dvc_password">Password</label>
		<input type="password" autofocus="true" name="dvc_password"/>
		<label for="dvc_password2">Konfirmasi Password</label>
		<input type="password" name="dvc_password2"/>
		<input type="submit" name="add" value="Add"/>
	</form>
</body>
</html>