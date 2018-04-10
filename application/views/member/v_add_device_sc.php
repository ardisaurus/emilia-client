<!DOCTYPE html>
<html>
<head>
	<title>Add Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Add Device : Secondary Access</h3>
	<?php 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  		if ($this->session->flashdata('hasil')) { 
  			echo $this->session->flashdata('hasil');
  		}
  	?>
	<?php echo form_open('member/device/process_add_device_sc');?>
		<label for="dvc_id">Id Device</label>
		<input type="text" name="dvc_id"/>
		<label for="dvc_password">Password</label>
		<input type="password" name="dvc_password"/>
		<input type="submit" name="add" value="Add"/>
	</form>
	<a href="<?php echo site_url('member/device');?>">Device List</a>
</body>
</html>