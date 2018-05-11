<!DOCTYPE html>
<html>
<head>
	<title>Admin List</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>
				Menu :
			</td>
			<td>
				<a href="<?php echo site_url('admin/admin');?>">Admin List</a>
			</td>
			<td>
				<a href="<?php echo site_url('admin/device');?>">Device List</a>
			</td>
			<td>
				<a href="<?php echo site_url('admin/setting');?>">Setting</a>
			</td>
			<td>
				<a href="<?php echo site_url('admin/setting/logout');?>">Log Out</a>
			</td>
		</tr>
	</table>
	<h3>Admin List</h3>
	<?php 
  		if ($this->session->flashdata('peringatan')) { 
  			echo $this->session->flashdata('peringatan');
  		}
  		if ($this->session->flashdata('hasil')) { 
  			echo $this->session->flashdata('hasil');
  		}
  	?>
	<a href="<?php echo site_url('admin/admin/add_admin');?>">Add admin</a>
	<table border="1">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>DOB</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($user as $userdata) { 
			if ($userdata->level == 1) { ?>
			<tr>
				<td><?php echo $userdata->name; ?></td>
				<td><?php echo $userdata->email; ?></td>
				<td><?php echo $userdata->dob; ?> </td>
				<td><?php 
				if ($userdata->active==0) { 
					echo form_open('admin/admin/proses_delete');?>
						<input type="hidden" name="email" value="<?php echo $userdata->email; ?>" />
						<input type="submit" name="submit" value="Hapus"/>
					</form>
				<?php 	
				}else{
					echo "-";
				}
				?></td>				
			</tr>
		<?php	
			}
		} ?>			
		</tbody>
	</table>
</body>
</html>