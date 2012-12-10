<?php include("headerLoggedin.php"); ?>

<?php 
	#echo "<p>logged in user UID: ".$_SESSION['user']."</p>";
?>

<form action="postStatus.php" method="post">
	Post new status: <input type="text" name="Content" />
	<input type="hidden" name="UID" value="<?= $_SESSION['user'] ?>" />
	<input type="hidden" name="Privacy" value="3" />
	<input type="submit" value="Post" />
	<?php
	if (isset($_GET['error'])) {
		if ($_GET['error'] == 0) {
			?> Status has been posted! <?
		}
	} ?>
</form>

<div id="statuses">
<?
	# list all the 20 most recent status updates by the current user, or friends
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

	$friendsQuery = "SELECT DISTINCT friendships.Target FROM friendships WHERE friendships.User = ".$_SESSION['user']." AND friendships.Status = 2";
	$friendResult = $db->query($friendsQuery);
	if (!$friendResult) {
		echo "Cannot search for statuses right now. Please try again later <br/>";
		echo "Error: ".$db->error;
		exit();
	}
	#echo "Successfully queried for friends.";
	$statusQuery = "SELECT users.FirstName, users.LastName, statuses.* FROM statuses INNER JOIN users ON statuses.UID = users.UID WHERE statuses.UID IN (".$_SESSION['user'];
	$tgts = array();
	while ($row = $friendResult->fetch_assoc()) {
		$tgts[] = $row['Target'];
	}
	#echo "Friends are: $tgts";
	$index = 0;
	while ($index < count($tgts)) {
		if ($index == 0) {
			$statusQuery .= ", ";
		}
		$statusQuery .= $tgts[$index];
		if ($index < count($tgts)-1) {
			$statusQuery .= ", ";
		}
		$index = $index + 1;
	}
	$statusQuery .= ") AND statuses.Parent IS NULL ORDER BY statuses.Post_time DESC LIMIT 20";
	#echo "Status query: ".$statusQuery;

	$statuses = $db->query($statusQuery);
	if (!$statuses) {
		echo "Full query: ".$statusQuery;
		echo "Error executing query: ".$db->error;
	}
	
	while ($row = $statuses->fetch_assoc()) {
		?>
		<div class="status">
			<p id="name"><?= $row['FirstName']." ".$row['LastName'] ?>:</p>
			<p id="content"><?= $row['Content'] ?></p>
			<div class="faded">
				<?= $row['Post_time'] ?>
			</div>
	
			<?
			$childCommentsQuery = "SELECT users.FirstName, users.LastName, statuses.* FROM statuses INNER JOIN users ON statuses.UID = users.UID WHERE Parent = ".$row['SID']." ORDER BY Post_time";

			$comments = $db->query($childCommentsQuery);
			if (!$comments) {
				echo "Error looking for comments: ".$db->error;
			}
			while ($comment = $comments->fetch_assoc()) {
				?>
				<div class="comment">
					<p id="name"><?= $comment['FirstName']." ".$comment['LastName'] ?>:</p>
					<p id="content"><?= $comment['Content'] ?></p>
					<div class="faded">
						<?= $comment['Post_time'] ?>
					</div>
				</div>
			<?
			}
			?>

			<form action="postStatus.php" method="post">
				Comment on status:
				<input type="text" name="Content" />
				<input type="hidden" name="UID" value="<?= $_SESSION['user'] ?>" />
				<input type="hidden" name="Privacy" value="3" />
				<input type="hidden" name="Parent" value="<?= $row['SID'] ?>" />
				<input type="submit" value="Comment"/>
			</form>
		</div>
		<?
	}

?>
</div>
<?php include("footer.php"); ?>
