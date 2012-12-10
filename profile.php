<?php include("headerLoggedin.php"); ?>
<div id="profileContainer">
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

	$info_query = "select FirstName, LastName, Email, Gender, Age, Location, ImageID from users where UID = ".$target_user;
	$info = $db->query($info_query);
	if($info->num_rows != 0) {
		$user_info = $info->fetch_assoc();
		echo "<div class='windows'>";
		echo 	"<div class='windowHeader'>"
				.'<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">'
				.'<p class="windowHeaderText">'
				.'Profile Information:'
				.'</p></div>';
		echo	"<div class='statusBody'>";
		echo 		'<p><img src="image_file.php?image_id='.$user_info['ImageID'].'"></p>';
		echo 		"<p>First Name: ".$user_info['FirstName']."</p>";
		echo 		"<p>Last Name: ".$user_info['LastName']."</p>";
		echo 		"<p>Gender: ".$user_info['Gender']."</p>";
		echo 		"<p>Email: ".$user_info['Email']."</p>";
		echo 		"<p>Age: ".$user_info['Age']."</p>";
		echo 		"<p>Location: ".$user_info['Location']."</p>";
		echo	"</div>";
		echo "</div>";
	} else {
		echo "invalid user requested";
	}

	if ($user <> $target_user) {
		$friendshipQuery = "SELECT * FROM friendships WHERE (User = ".$user." AND Target = ".$target_user.") OR ( User = ".$target_user." AND Target = ".$user.") ";
		$friendshipResult = $db->query($friendshipQuery);
		if (!$friendshipResult) {
			echo "Cannot search for your friendship status right now. Please try again later.<br/>";
			echo "Error: ".$db->error;
			exit();
		}
		
		$userOnTarget = -1;
		$targetOnUser = -1;
		while ($row = $friendshipResult->fetch_assoc()) {
			# for each row...
			if ($row['User'] == $user) {
				# set user on target
				$userOnTarget = $row['Status'];
			} elseif ($row['User'] == $target_user) {
				$targetOnUser = $row['Status'];
			}
		}
		?>
		<div class="windows">
			<form action="processFriend.php" method="POST" ><?
						if ($targetOnUser == 1) {
							# they are awaiting a response
							?>
							Would you like to be his/her friend?
							<table>
								<tr>
									<td>Accept</td>
									<td>Decline</td>
								</tr>
								<tr>
									<td><input type="radio" name="action" value="2"></td>
									<td><input type="radio" name="action" value="0"></td>
									<td><input type="submit" value="Send Response"></td>
								</tr>
							</table>
							<?
						} elseif ($userOnTarget == 2 and $targetOnUser == 2) {
							# you already have a mutual friendship
							?>
							You are already friends!
							<input type="submit" value="Destroy Friendship" />
							<input type="hidden" name="action" value="0" />
							<?
						} elseif ($userOnTarget == 1) {
							# you have already sent out a pending request
							?>
							Waiting for acceptance
							<input type="submit" value="Cancel Request" />
							<input type="hidden" name="action" value="0" />
							<?
						} elseif ($userOnTarget <= 0 and $targetOnUser <= 0) {
							# no friendship at all.
							?>
							<input type="submit" value="Send friendship request" />
							<?
						}
						# else does nothing.. makes a problem more visible
						?>
						<input type="hidden" name="user" value="<?=$user ?>" />
						<input type="hidden" name="target" value="<?=$target_user ?>" />
		</form>
		</div>
	<?
	}	// end if user <> target_user
	else {
	?>
		<div class="windows">
			<div class="windowHeader">
				<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
				<p class="windowHeaderText">Update Your Profile:</p>
			</div> 
			<form enctype="multipart/form-data" name="updateUser" action="processUpdate.php" method="POST">
				<table>
					<tr>
						<td>
							First Name: 
						</td>
						<td>
							<input type="text" name="firstName">
						</td>
						<td>
							<div id="firstNameError"></div>
						</td>
					</tr>
					<tr>
						<td>
							Last Name:
						</td>
						<td>
							<input type="text" name="lastName">
						</td>
						<td>
							<div id="lastNameError"></div>
						</td>
					</tr>
					<tr>
						<td>
							Email:
						</td>
						<td>
							<input type="text" name="email">
						</td>
						<td>
							<div id="emailError"></div>
						</td>
					</tr>
					<tr>
						<td>
							Avatar:
						</td>
						<td>
							<input type="file" name="avatar">
							<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
						</td>
						<td>
							<div id="avatarError"></div>
						</td>
					</tr>
					<tr>
						<td>
							Gender:
						</td>
						<td>
							Male: <input type="radio" name="gender" value="Male" checked = "true"> 
							Female: <input type="radio" name="gender" value="Female">
							Other: <input type="radio" name="gender" value="Other">
						</td>
						<td>
							<div id="genderError"></div>
						</td>
					</tr>
					<tr>
						<td>
							Age:
						</td>
						<td>
							<input type="text" name="age" width="3">
						</td>
						<td>
							<div id="ageError"></div>
						</td>
					</tr>
					<tr>
						<td>
							Location:
						</td>
						<td>
							<input type="text" name="location">
						</td>
						<td>
							<div id="locationError"></div>
						</td>
					</tr>
				</table>
				<input type="button" value="Update Profile" id="submitButton" />
			</form>
		</div>
	<?
	} // end else
	?>
</div>
</div>
<div id="statuses">
<?
	# list all the 5 most recent status updates by this user
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
	#echo "Successfully queried for friends.";
	$statusQuery = "SELECT users.FirstName, users.LastName, statuses.* FROM statuses INNER JOIN users ON statuses.UID = users.UID WHERE statuses.UID = ".$target_user." AND statuses.Parent IS NULL ORDER BY statuses.Post_time DESC LIMIT 5";
	#echo "Status query: ".$statusQuery;

	$statuses = $db->query($statusQuery);
	if (!$statuses) {
		echo "Full query: ".$statusQuery;
		echo "Error executing query: ".$db->error;
	}
	
	while ($row = $statuses->fetch_assoc()) {
		?>
		<div class="windows">
			<div class="windowHeader">
				<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
				<p class="windowHeaderText">
					<?= $row['FirstName']." ".$row['LastName'] ?> wrote:
				</p>
			</div>
			<div class="statusBody">
				<p class="statusContent"><?= $row['Content'] ?></p>
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
		</div>
		<?
	}

?>
</div>
<script src="profile.js" type="text/javascript"></script>
<script src="validate.js" type="text/javascript"></script>
<?php include("footer.php"); ?>
