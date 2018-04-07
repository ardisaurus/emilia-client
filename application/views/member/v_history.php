<!DOCTYPE html>
<html>
<head>
	<title>Access History</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>
				Menu :
			</td>
			<td>
				<a href="<?php echo site_url('member/device/');?>">Primary Access</a>
			</td>
			<td>
				<a href="<?php echo site_url('member/device/secondary');?>">Secondary Access</a>
			</td>
			<td>
				<a href="<?php echo site_url('member/setting/');?>">Setting</a>
			</td>
			<td>
				<a href="<?php echo site_url('member/setting/logout');?>">Log Out</a>
			</td>
		</tr>
	</table>
	<h3>Access History</h3>
	<a href="<?php echo site_url('member/device/');?>">Device List</a>
	<table border="1">
		<thead>
			<tr>
				<th>Date</th>
				<th>Time</th>
				<th>Email</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($history as $devicedata) {  ?>
			<tr>
				<td><?php echo $devicedata->hst_date; ?></td>
				<td><?php echo $devicedata->hst_time; ?></td>
				<td><?php echo $devicedata->hst_email; ?></td>
				<td><?php echo $devicedata->hst_user_name; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
</html>