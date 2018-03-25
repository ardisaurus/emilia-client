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
				<a href="<?php echo site_url('member/device/');?>">Device</a>
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
	<a href="<?php echo site_url('member/device/add_device');?>">Add device</a>
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
			<?php foreach ($device as $devicedata) {  ?>
			<tr>
				<td><?php echo $devicedata->dvc_id; ?></td>
				<td><?php echo $devicedata->dvc_name; ?></td>
				<?php if ($devicedata->dvc_status==1) { ?>
					<td bgcolor="green">Open</td>
				<?php }else{ ?>
					<td bgcolor="red">Closed</td>
				<?php } ?>
				<td><a href="<?php echo site_url('member/device/edit_device/'.$devicedata->dvc_id);?>">Edit device</a></td>
				<td>
					<?php if ($devicedata->dvc_status!=1) { ?>
						<a href="<?php echo site_url('member/device/open_device/'.$devicedata->dvc_id);?>">Open</a>
					<?php }else{ ?>
						<a href="<?php echo site_url('member/device/close_device/'.$devicedata->dvc_id);?>">Close</a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
</html>