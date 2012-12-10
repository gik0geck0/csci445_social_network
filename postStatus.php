<?php
	include("sanitize.php");
	# given a post, will post a new status for a user
	$db = new mysqli('localhost',
					'team10',
					'tangerine',
					'team10_social');
	$db->select_db('team10_social');
	if ( mysqli_connect_errno() ) {
			echo 'Could not connect to database. Please try again later.<br/>';
			$Success = false;
			$Errors[] = "Error connecting to server (database).";
			exit();
	}
	$sUID = sanitize($_POST['UID'], $db);
	$scontent = sanitize($_POST['Content'], $db);
	$sprivacy = sanitize($_POST['Privacy'], $db);
	if ($_POST['Parent']) {
		$sParent = sanitize($_POST['Parent'], $db);
	} else {
		$sParent = NULL;
	}

	$addStatusQuery = "INSERT INTO statuses VALUES (NULL, $sUID, '$scontent', $sprivacy, $sParent, now())";
	$result = $db->query($addStatusQuery);

	if (!$result) {
		echo "Error: ".$db->error;
	} else {
		echo "Status has been posted";
		header("home.php?error=0");
	}
?>
