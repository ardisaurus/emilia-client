<!DOCTYPE html>
<html>
<head>
	<title>Member List</title>
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
	<h3>Member List</h3>
	<table border="1">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th>DOB</th>
				<th>Device</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>My Name</td>
				<td>email@user.com</td>
				<td>12-12-1999</td>
				<td><a href="<?php echo site_url('login/device_list');?>">View list</a></td>
			</tr>
		</tbody>
	</table>
</body>
</html>