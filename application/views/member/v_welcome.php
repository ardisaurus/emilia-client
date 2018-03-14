<!DOCTYPE html>
<html>
<head>
	<title>Device list</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>
				Menu :
			</td>
			<td>
				<a href="<?php echo site_url('member/setting/');?>">Setting</a>
			</td>
			<td>
				<a href="<?php echo site_url('member/setting/logout');?>">Log Out</a>
			</td>
		</tr>
	</table>
	<h3>Device List</h3>
	<a href="<?php echo site_url('member/welcome/add_device');?>">Add device</a>
	<table border="1">
		<thead>
			<tr>
				<th>Id Device</th>
				<th>Device Name</th>
				<th>Status</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>SL-191928</td>
				<td>Front Door</td>
				<td>Closed</td>
				<td><a href="<?php echo site_url('member/welcome/edit_device');?>">Edit device</a></td>
				<td><a href="<?php echo site_url('member/welcome/add_device');?>">Open/Close</a></td>
			</tr>
		</tbody>
	</table>
</body>
</html>