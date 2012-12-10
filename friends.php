<?php include("headerLoggedin.php"); ?>
<div class="column">
	<?php
		$message = $_GET['message'];
		if($message){?>
			<div id="message" class="windows">
				<div class="windowHeader">
					<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
					<p class="windowHeaderText">Post new status:</p>
				</div> 
		<?
			if($message == 1) {
				echo "That friendship already exists and is confirmed";
			}elseif($message == 2) {
				echo "You have already requested that user as a friend, and they haven't replied yet";
			}elseif($message == 3) {
				echo "Friendship has been confirmed/denied";
			}elseif($message == 4) {
				echo "Friend request has been sent";
			}	
			?>
			</div>
			<?
		}
	?>
<?php
	$db = new mysqli('localhost', 
					   'team10', 
					   'tangerine', 
					   'team10_social');
	$db->select_db('team10_social');
					   
	// TODO: Make this more robustly visible to the user
	if ( mysqli_connect_errno( ) )  {
		echo 'db connect error on connect';
		$Success = false;
		$Errors[] = "Error connecting to server (database).";
		exit();
	}
	
   $prepQuery = $db->prepare("SELECT users.UID, users.FirstName, users.LastName, users.ImageID, users.Gender "
							."FROM users JOIN friendships "
							."WHERE friendships.user=? "
							."AND users.UID=friendships.target "
							."AND friendships.Status=2");
   $prepQuery->bind_param("i", $_SESSION['user']);
   $prepQuery->bind_result($UID, $FirstName, $LastName, $ImageID, $Gender);
   $prepQuery->execute();
?>	    
<div id="friends" class="windows">
	<div class="windowHeader">
		<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
		<p class="windowHeaderText">People You Are Friends With</p>
	</div> 
	<div class="windowBody">
	<?php
		while($prepQuery->fetch()){?>
			<div id="friend<?=$FirstName?>" class="friend">
				<a href="profile.php?target=<?= $UID ?>" ><?=$FirstName.' '.$LastName?></a>
				<p><img src="image_file.php?image_id=<?= $ImageID ?>"></p>
				<p><?=$Gender?></p>
			   <form action="processFriend.php" method="POST" >
					<input type="submit" value="Destroy Friendship" />
					<input type="hidden" name="action" value="0" />
					<input type="hidden" name="<? $_SESSION['user'] ?>" value="<?=$user ?>" />
					<input type="hidden" name="target" value="<?=$UID ?>" />
				</form>
			</div>
		<?php
		}
	$prepQuery->close();
	?>
	</div>
</div>

<?php
   $prepQuery = $db->prepare("SELECT users.UID, users.FirstName, users.LastName, users.ImageID, users.Gender "
							."FROM users JOIN friendships "
							."WHERE friendships.user=? "
							."AND users.UID=friendships.target "
							."AND friendships.Status=1");
   $prepQuery->bind_param("i", $_SESSION['user']);
   $prepQuery->bind_result($UID, $FirstName, $LastName, $ImageID, $Gender);
   $prepQuery->execute();
?>	    
<div id="wants" class="windows">
	<div class="windowHeader">
		<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
		<p class="windowHeaderText">People You Want To Be Friends With</p>
	</div> 
	<div class="windowBody">
	<?php
		while($prepQuery->fetch()){?>
			<div id="pending<?=$FirstName?>" class="friend">
				<a href="profile.php?target=<?= $UID ?>" ><?=$FirstName.' '.$LastName?></a>
				<p><img src="image_file.php?image_id=<?= $ImageID ?>"></p>
				<p><?=$Gender?></p>
			</div>
		<?php
		}
	$prepQuery->close();
	?>
	</div>
</div>

<?php
   $prepQuery = $db->prepare("SELECT users.UID, users.FirstName, users.LastName, users.ImageID, users.Gender, users.UID "
							."FROM users JOIN friendships "
							."WHERE friendships.target=? "
							."AND users.UID=friendships.user "
							."AND friendships.Status=1");
   $prepQuery->bind_param("i", $_SESSION['user']);
   $prepQuery->bind_result($UID, $FirstName, $LastName, $ImageID, $Gender, $target_UID);
   $prepQuery->execute();
?>	    
<div id="requests" class="windows">
	<div class="windowHeader">
		<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
		<p class="windowHeaderText">People Who Want To Be Friends With You</p>
	</div> 
	<div class="windowBody">
	<?php
		while($prepQuery->fetch()){?>
			<div id="pending<?=$FirstName?>" class="friend">
				<a href="profile.php?target=<?= $UID ?>" ><?=$FirstName.' '.$LastName?></a>
				<p><img src="image_file.php?image_id=<?= $ImageID ?>"></p>
				<p><?=$Gender?></p>
				<form action="processFriend.php" method="POST">
					Accept:
					<input type="radio" name="action" value="2">
					Decline:
					<input type="radio" name="action" value="0">
					<input type="submit" value="Send Response">
					<input type="hidden" name="target" value="<?=$target_UID ?>" />
				</form>
			</div>
		<?php
		}
	$prepQuery->close();
	?>
	</div>
</div>
</div>
<?php include("footer.php"); ?>
