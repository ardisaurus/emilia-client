<!DOCTYPE html>
<html>
<head>
	<title>Edit Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Edit Device</h3>
	<form action="#" method="post">
		<label for="id_device">Id Device</label>
		<input type="hidden" name="id_device"/>
		SL-44233144
		<label for="id_device">Device Name</label>
		<input type="text" name="device_name"/>
		<input type="submit" name="edit" value="Edit"/>
	</form>
	<a href="<?php echo site_url('member/welcome');?>">Device List</a>
</body>
</html>