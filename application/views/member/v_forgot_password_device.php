<!DOCTYPE html>
<html>
<head>
	<title>Forgot Device Password</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Forgot Password Device <?php echo $device[0]->dvc_id ?></h3>	
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
				Password
			</td>
		</tr>
		<tr>
			<td>
				<?php echo form_open('member/device/process_forgot_password');?>
					<input type="hidden" name="dvc_id" value="<?php echo $device[0]->dvc_id ?>" />
					<label for="password">Account Password</label>
					<input type="password" name="password"/>
					<label for="dvc_password">New Password</label>
					<input type="password" name="dvc_password"/>
					<label for="dvc_password2">Confirm New Password</label>
					<input type="password" name="dvc_password2"/>
					<input type="submit" name="change" value="Change"/>
				</form>
			</td>
		</tr>
	</table>		
	<br>
	<a href="<?php echo site_url('member/device');?>">Device List</a>
</body>
</html>