<!DOCTYPE HTML>
<html>
	<head>
	    <link href="friends.css" rel="stylesheet">
	</head>
	<body>
		<?php include("checkLogin.php"); ?>
		<?php include("menu.php"); ?>
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
		        $Errors[] = "Error connecting to server (databse).";
	        }
	        
	       $prepQuery = $db->prepare("SELECT users.FirstName, users.LastName, users.ImageID, users.Gender "
	                                ."FROM users JOIN friendships "
	                                ."WHERE friendships.user=? "
	                                ."AND users.UID=friendships.target"
	                                ."AND friendships.Status=2");
           $prepQuery->bind_param("i", $_SESSION['user']);
           $prepQuery->bind_result($FirstName, $LastName, $ImageID, $Gender);
           $prepQuery->execute();
	    ?>
	    <h4>Friends</h4>
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
	                                ."AND users.UID=friendships.user"
	                                ."AND friendships.Status=1");
           $prepQuery->bind_param("i", $_SESSION['user']);
           $prepQuery->bind_result($FirstName, $LastName, $ImageID, $Gender);
           $prepQuery->execute();
	    ?>
	    <h4>Pending Friendships</h4>
		<div id="pending">
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
	</body>
</html>
