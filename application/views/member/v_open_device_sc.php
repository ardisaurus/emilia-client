<!DOCTYPE html>
<html>
<head>
	<title>Add Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
	<h3>Open/Close Device : Secondary Access</h3>
	<?php 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  		if ($this->session->flashdata('hasil')) { 
  			echo $this->session->flashdata('hasil');
  		}
  	?>
  	<br>
		<?php if ($device[0]->dvc_name=='') {
				echo "Unamed";
			}else{ 
				echo $device[0]->dvc_name;
			}
			echo " - ".$device[0]->dvc_id; ?>
	<?php echo form_open('member/device/process_open_device_sc');?>
		<input type="hidden" name="dvc_id" readonly="true" value="<?php echo $device[0]->dvc_id; ?>" />
		<label for="dvc_password">Password</label>
		<input type="password" name="dvc_password"/>
		<input type="submit" name="open" value="Open"/>
	</form>
	<a href="#">Forgot password</a>
	<br>
	<a href="<?php echo site_url('member/device');?>">Device List</a>
</body>
</html>