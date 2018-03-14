<!DOCTYPE html>
<html>
<head>
	<title>Add Admin</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
	<h3>Add Admin</h3>
	<?php 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  		if ($this->session->flashdata('hasil')) { 
  			echo $this->session->flashdata('hasil');
  		}
  	?>
	<?php echo form_open('admin/admin/proses_tambah');?>
		<label for="email">Email</label>
		<input type="email" name="email"/>
		<label for="password">Password</label>
		<input type="password" name="password"/>
		<label for="password2">Comfirm Password</label>
		<input type="password" name="password2"/>
		<label for="name">Name</label>
		<input type="text" name="name"/>
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
		<input type="submit" name="submit" value="Submit"/>
	</form>
	<a href="<?php echo site_url('admin/admin');?>">Back to admin list</a>
</body>
</html>