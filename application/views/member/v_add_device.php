<!DOCTYPE html>
<html>
<head>
	<title>Add Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
<h3>Add Device</h3>
	<form action="#" method="post">
		<label for="id_device">Id Device</label>
		<input type="text" name="id_device"/>
		<label for="password">Password</label>
		<input type="password" name="password"/>
		<input type="submit" name="add" value="Add"/>
	</form>
	<a href="<?php echo site_url('member/welcome');?>">Device List</a>
</body>
</html>