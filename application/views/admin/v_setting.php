<!DOCTYPE html>
<html>
<head>
	<title>Setting</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Setting</h3>
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
			Email : <?php echo $this->session->userdata('email'); ?>
		</td>
	</tr>
	<tr>
		<td>			
  			<?php echo form_open('admin/setting/edit_email');?>
				<label for="email">New email :</label>
				<input type="email" name="email"/>
				<input type="submit" name="change" value="Change"/>
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
  			<?php echo form_open('admin/setting/edit_password');?>
				<label for="password">Old Password</label>
				<input type="password" name="old_password"/>
				<label for="password">New Password</label>
				<input type="password" name="password"/>
				<label for="password2">Confirm New Password</label>
				<input type="password" name="password2"/>
				<input type="submit" name="change" value="Change"/>
			</form>
		</td>
	</tr>
</table>
<table border="1">
	<tr>
		<td>
			Name : <?php echo $user[0]->name; ?>
		</td>
	</tr>
	<tr>
		<td>
  			<?php echo form_open('admin/setting/edit_name');?>
				<label for="name">New name</label>
				<input type="text" name="name"/>
				<input type="submit" name="change" value="Change"/>
			</form>
		</td>
	</tr>
</table>
<table border="1">
	<tr>
		<td>
			DOB : <?php echo $user[0]->dob; ?>
		</td>
	</tr>
	<tr>
		<td>
  			<?php echo form_open('admin/setting/edit_dob');?>
				<label>DOB</label>
				<select name="dob_day">
					<?php for ($i=1; $i <= 31; $i++) { ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>				
					<?php } ?>
				</select>
				<select name="dob_month">
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>
				<select name="dob_year">
					<?php 
					$cur_year = date("Y");
					for ($i=1970; $i < $cur_year; $i++) { ?>				
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
					<option value="<?php echo $cur_year; ?>" selected="true"><?php echo $cur_year; ?></option>
				</select>
				<input type="submit" name="change" value="Change"/>
			</form>
		</td>
	</tr>
</table>
<table border="1">
	<tr>
		<td>
			Delete account
		</td>
	</tr>
	<tr>
		<td>
  			<?php echo form_open('admin/setting/delete');?>
				<label for="password">Password</label>
				<input type="password" name="password"/>
				<input type="submit" name="Delete" value="Delete"/>
			</form>
		</td>
	</tr>
</table>
<a href="<?php echo site_url('admin/welcome');?>">Back to home</a>
</body>
</html>