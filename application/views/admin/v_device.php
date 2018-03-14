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
	<h3>Device List</h3>
	<a href="<?php echo site_url('admin/device/add_device');?>">Add device</a>
	<table border="1">
		<thead>
			<tr>
				<th>Id Device</th>
				<th>Ownership Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($device as $devicedata) {  ?>
			<tr>
				<td><?php echo $devicedata->dvc_id; ?></td>
				<td><?php echo $devicedata->dvc_status; ?></td>
				<td><a href="<?php echo site_url('admin/device/detail_device');?>">Detail</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
</html>