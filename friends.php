<!DOCTYPE HTML>
<html>
	<head>
	    <link href="friends.css" rel="stylesheet">
	</head>
	<body>
		<?php include("checkLogin.php"); ?>
		<?php include("menu.php"); ?>
		<div id="message">
			<?php
				$message = $_GET['message'];
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
	        }
	        
	       $prepQuery = $db->prepare("SELECT users.FirstName, users.LastName, users.ImageID, users.Gender "
	                                ."FROM users JOIN friendships "
	                                ."WHERE friendships.user=? "
	                                ."AND users.UID=friendships.target "
	                                ."AND friendships.Status=2");
           $prepQuery->bind_param("i", $_SESSION['user']);
           $prepQuery->bind_result($FirstName, $LastName, $ImageID, $Gender);
           $prepQuery->execute();
	    ?>	    
	    <h4>People You Are Friends With</h4>
		<div id="friends">
		    <?php
		        while($prepQuery->fetch()){?>
		            <div id="friend<?=$FirstName?>" class="friend">
		                <p><?=$FirstName?> <?=$LastName?></p>
		                <p>Avatar: <?=$ImageID?></p>
		                <p><?=$Gender?></p>
	                </div>
		        <?php
		        }
	        $prepQuery->close();
	        ?>
		</div>
		
		<?php
		   $prepQuery = $db->prepare("SELECT users.FirstName, users.LastName, users.ImageID, users.Gender "
	                                ."FROM users JOIN friendships "
	                                ."WHERE friendships.user=? "
	                                ."AND users.UID=friendships.target "
	                                ."AND friendships.Status=1");
           $prepQuery->bind_param("i", $_SESSION['user']);
           $prepQuery->bind_result($FirstName, $LastName, $ImageID, $Gender);
           $prepQuery->execute();
	    ?>	    
	    <h4>People You Want To Be Friends With</h4>
		<div id="wants">
		    <?php
		        while($prepQuery->fetch()){?>
		            <div id="pending<?=$FirstName?>" class="friend">
		                <p><?=$FirstName?> <?=$LastName?></p>
		                <p>Avatar: <?=$ImageID?></p>
		                <p><?=$Gender?></p>
	                </div>
		        <?php
		        }
	        $prepQuery->close();
	        ?>
		</div>
		
		<?php
		   $prepQuery = $db->prepare("SELECT users.FirstName, users.LastName, users.ImageID, users.Gender, users.UID "
	                                ."FROM users JOIN friendships "
	                                ."WHERE friendships.target=? "
	                                ."AND users.UID=friendships.user "
	                                ."AND friendships.Status=1");
           $prepQuery->bind_param("i", $_SESSION['user']);
           $prepQuery->bind_result($FirstName, $LastName, $ImageID, $Gender, $target_UID);
           $prepQuery->execute();
	    ?>	    
	    <h4>People Who Want To Be Friends With You</h4>
		<div id="requests">
		    <?php
		        while($prepQuery->fetch()){?>
		            <div id="pending<?=$FirstName?>" class="friend">
		                <p><?=$FirstName?> <?=$LastName?></p>
		                <p>Avatar: <?=$ImageID?></p>
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
	</body>
</html>
