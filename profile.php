<!DOCTYPE HTML>
<html>
	<head>
	</head>
	<body>
		<?php include("validateLogin.php"); ?>
		<?php include("menu.php"); ?>
		<div id="statuses">
		</div>
		<div id="info">
			<?php
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

			    $info_query = "select FirstName, LastName, Email, Gender, Age from users where UID = ".$target_user;
			    $info = $db->query($info_query);
			    if($info->num_rows != 0) {
			    	$user_info = $info->fetch_assoc();
			    	echo "<p>First Name: ".$user_info['FirstName']."</p>";
			    	echo "<p>Last Name: ".$user_info['LastName']."</p>";
			    	echo "<p>Gender: ".$user_info['Gender']."</p>";
			    	echo "<p>Email: ".$user_info['Email']."</p>";
			    	echo "<p>Age: ".$user_info['Age']."</p>";
			    } else {
			    	echo "invalid user requested";
			    }


			?>
		</div>

	</body>
</html>
