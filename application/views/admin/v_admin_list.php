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
	<a href="<?php echo site_url('admin/admin/add_admin');?>">Add admin</a>
	<table border="1">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>DOB</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($user as $userdata) { 
			if ($userdata->level == 1) { ?>
			<tr>
				<td><?php echo $userdata->name; ?></td>
				<td><?php echo $userdata->email; ?></td>
				<td><?php echo $userdata->dob; ?></td>
			</tr>
		<?php	
			}
		} ?>			
		</tbody>
	</table>
</body>
</html>