<!DOCTYPE HTML>
<html>
	<head>
	</head>
	<body>
		<?php include("checkLogin.php"); ?>
		<?php include("menu.php"); ?>

		<?php 
			echo "logged in user UID: ".$_SESSION['user'];
		?>
	</body>
<html>
