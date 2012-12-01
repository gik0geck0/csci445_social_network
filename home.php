<!DOCTYPE HTML>

<?php include("checkLogin.php"); ?>

<html>
	<head>
	</head>
	<body>
		<?php include("menu.php"); ?>

		<?php 
			echo "<p>logged in user UID: ".$_SESSION['user']."</p>";
		?>
	</body>
<html>
