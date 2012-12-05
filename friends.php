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
	                                ."AND users.UID=friendships.target");
           $prepQuery->bind_param("i", $_SESSION['user']);
           $prepQuery->bind_result($FirstName, $LastName, $ImageID, $Gender);
           $prepQuery->execute();
	    ?>
		<div id="friends">
		    <?php
		        while($prepQuery->fetch()){?>
		            <div id="div<?=$FirstName?>" class="friend">
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
