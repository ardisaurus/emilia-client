<!DOCTYPE html>
<html>
<head>
	<title>Add Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Add Device</h3>
	<?php 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  		if ($this->session->flashdata('hasil')) { 
  			echo $this->session->flashdata('hasil');
  		}
  	?>
	<?php echo form_open('admin/device/process_add');?>
		<label for="dvc_id">Id Device</label>
		<input type="text" name="dvc_id" readonly="true" value="<?php echo $dvc_id; ?>"/>
		<label for="dvc_password">Password</label>
		<input type="password" autofocus="true" name="dvc_password"/>
		<label for="dvc_password2">Konfirmasi Password</label>
		<input type="password" name="dvc_password2"/>
		<input type="submit" name="add" value="Add"/>
	</form>
	<a href="<?php echo site_url('admin/device');?>">Device List</a>
</body>
</html>