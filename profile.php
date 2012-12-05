<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<?php include("checkLogin.php"); ?>
<?php include("menu.php"); ?>
<div id="statuses">
</div>
<div id="info">
<?php
/*TODO: make it so if the logged in user is the target user, they can edit their information
add an add friend button if the logged in user is not the target user
display the last 5 status updates of the target user
*/

$user = $_SESSION['user'];
$db = new mysqli('localhost', 'team10', 'tangerine', 'team10_social');
if (mysqli_connect_errno()) {
	echo 'Error: could not connect to database. Better luck next time, punk!';
	exit;
}

if(isset($_POST['target'])) {
	$target_user = $_POST['target'];
} elseif(isset($_GET['target'])) {
	$target_user = $_GET['target'];
} else {
	echo 'error: no user requested ';
	exit;
}

$info_query = "select FirstName, LastName, Email, Gender, Age, Location from users where UID = ".$target_user;
$info = $db->query($info_query);
if($info->num_rows != 0) {
	$user_info = $info->fetch_assoc();
	echo "<p>First Name: ".$user_info['FirstName']."</p>";
	echo "<p>Last Name: ".$user_info['LastName']."</p>";
	echo "<p>Gender: ".$user_info['Gender']."</p>";
	echo "<p>Email: ".$user_info['Email']."</p>";
	echo "<p>Age: ".$user_info['Age']."</p>";
	echo "<p>Location: ".$user_info['Location']."</p>";
} else {
	echo "invalid user requested";
}
/*
<form action="processFriend.php" method="POST" >
<tr>
<td>
<a href="profile.php?target=<?= $row['UID'] ?>" ><?= $row['FirstName']." ".$row['LastName']?></a>
</td>
<td>
Email: <?= $row['Email'] ?>
</td>
<td>
Gender: <?= $row['Gender'] ?>
</td>
<td>
Age: <?= $row['Age'] ?>
</td>
<td> <?
if (!$row['user0'] && !$row['user1']) {
# no friendship at all.
	?>
	<input type="submit" value="Send friendship request" />
	<?
} elseif ($row['user0'] && $row['user1']) {
# you already have a mutual friendship
	?>
	You are already friends!
	<?
} elseif ($row['user0']) {
# you have already sent out a pending request
	?>
	Waiting for acceptance
	<?
} else {
# they are awaiting a response
	?>
	Would you like to be his/her friend?
	<table>
	<tr>
	<td>Accept</td>
	<td>Decline</td>
	</tr>
	<tr>
	<td><input type="radio" name="acceptDeny" value="2"></td>
	<td><input type="radio" name="acceptDeny" value="0"></td>
	<td><input type="submit" value="Send Response"></td>
	</tr>
	</table>
	<?
}

if ($usr && $tgt) {
	?>
	<input type="hidden" name="user" value="<?=$row['user0'] ?>" />
	<input type="hidden" name="target" value="<?=$row['tgt0'] ?>" />
	<? } ?>
	</td>
	</tr>
	</form>
	*/
	?>
	</div>
	</body>
	</html>
