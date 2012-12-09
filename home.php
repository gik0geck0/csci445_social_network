<?php include("headerLoggedin.php"); ?>

<?php 
	#echo "<p>logged in user UID: ".$_SESSION['user']."</p>";
?>

<form action="postStatus.php" method="post">
	Post new status: <input type="text" name="" />
</form>

<?
	# list all the 20 most recent status updates by the current user, or friends

	$statusQuery = "SELECT * FROM statuses WHERE statuses.UID IN (";
?>
<?php include("footer.php"); ?>
