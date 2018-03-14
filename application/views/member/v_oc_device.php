<!DOCTYPE html>
<html>
<head>
	<title>Add Device</title>
	<style type="text/css" media="screen">label {display: block;}</style>
</head>
<body>
	<h3>Open/Close Device</h3>
	<form action="#" method="post">
		<label for="email">Device Name</label>
		Front Door
		<label for="email">Id Device</label>
		<input type="hidden" name="id_device"/>
		SL-87266355
		<label for="password">Password</label>
		<input type="password" name="password"/>
		<input type="submit" name="open" value="Open"/>
	</form>
	<a href="<?php echo site_url('member/welcome');?>">Device List</a>
</body>
</html>