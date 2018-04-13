<!DOCTYPE html>
<html>
<head>
	<title>Edit Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Edit Device <?php echo $device[0]->dvc_id ?></h3>	
	<?php 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  		if ($this->session->flashdata('hasil')) { 
  			echo $this->session->flashdata('hasil');
  		}
  	?>
  	<table border="1">
  		<tr>
  			<td>
  				Name
  			</td>
  		</tr>
  		<tr>
  			<td>
  				<?php echo form_open('member/device/process_edit_name');?>
					<input type="hidden" name="dvc_id" value="<?php echo $device[0]->dvc_id ?>" />
					<label for="dvc_name">Device Name</label>
					<input type="text" name="dvc_name"/>
					<input type="submit" name="edit" value="Edit"/>
				</form>
  			</td>
  		</tr>
  	</table>
	<table border="1">
		<tr>
			<td>
				Password
			</td>
		</tr>
		<tr>
			<td>
				<?php echo form_open('member/device/process_edit_password');?>
					<input type="hidden" name="dvc_id" value="<?php echo $device[0]->dvc_id ?>" />
					<label for="password">Old Password</label>
					<input type="password" name="old_password"/>
					<label for="password">New Password</label>
					<input type="password" name="dvc_password"/>
					<label for="dvc_password2">Confirm New Password</label>
					<input type="password" name="dvc_password2"/>
					<input type="submit" name="change" value="Change"/>
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<a href="<?php echo site_url('member/device/forgot_password/'.$device[0]->dvc_id);?>">Forgot Password</a>
			</td>
		</tr>
	</table>
	<?php
	if ($sckey[0]->status=='success') {
	?>
	<table border="1">
		<tr>
			<td>
				Secondary Access Password
			</td>
		</tr>
		<tr>
			<td>
				<?php echo form_open('member/device/process_edit_password_sc');?>
					<input type="hidden" name="dvc_id" value="<?php echo $device[0]->dvc_id ?>" />
					<label for="password">Old Password</label>
					<input type="password" name="old_password"/>
					<label for="password">New Password</label>
					<input type="password" name="dvc_password"/>
					<label for="dvc_password2">Confirm New Password</label>
					<input type="password" name="dvc_password2"/>
					<input type="submit" name="change" value="Change"/>
				</form>
			</td>
		</tr>	
		<tr>
			<td>
				<a href="<?php echo site_url('member/device/remove_sckey/'.$device[0]->dvc_id);?>">Remove Secondary Key</a>
			</td>
		</tr>
	</table>
	<?php
	}else{
	?>
	<a href="<?php echo site_url('member/device/add_sckey/'.$device[0]->dvc_id);?>">Add Secondary Password</a>
	<?php
	}
	?>
	<table  border="1">
		<tr>
			<td>
				Delete Device
			</td>
		</tr>
		<tr>
			<td>
				<?php echo form_open('member/device/process_delete/'.$device[0]->dvc_id);?>
					<label for="dvc_name">Device ID</label>
					<input type="text" name="dvc_id"/>
					<input type="submit" name="delete" value="delete"/>
				</form>	
			</td>
		</tr>
	</table>	
	<br>
	<a href="<?php echo site_url('member/device');?>">Device List</a>
</body>
</html>