<?php
	include("sanitize.php");
	include("upload.php");
	
	@ session_start();
    
    $Success = true;
    $Errors = array();  
    
    // Grab the database connection
    $db = new mysqli('localhost', 
                       'team10', 
                       'tangerine', 
                       'team10_social');
	$db->select_db('team10_social');

	$newVals = array();
    $newVals['FirstName']  = sanitize($_POST['firstName'], $db);
    $newVals['LastName']  = sanitize($_POST['lastName'], $db);
    $newVals['Email']  = sanitize($_POST['email'], $db);
    //if(!isset($_FILES['avatar'])) {
	if(!$_FILES['avatar']['size']) {
		$newVals['ImageID'] = 0;
    } else {
		$newVals['ImageID'] = upload('avatar');
	}
    $newVals['Gender'] = sanitize($_POST['gender'], $db); // Verify this
    $newVals['Age']    = sanitize($_POST['age'], $db);
    $newVals['Location']    = sanitize($_POST['location'], $db);          
                       
	$userData = $db->query("SELECT * FROM users WHERE UID={$_SESSION['user']}")->fetch_assoc();
    foreach($newVals as $column => $value){
		if($column == "ImageID" && $value){
			//$db->query("DELETE FROM images WHERE IID={$value}");
		}
		if(!$value){
			$newVals[$column] = $userData[$column];
		}
	}
                       
    // TODO: Make this more robustly visible to the user
	if ( mysqli_connect_errno( ) )  {
		echo 'db connect error on connect';
		$Success = false;
		$Errors[] = "Error connecting to server (databse).";
	}
	
	// See if email is already in use
	$preparedQuery = $db->prepare("SELECT UID FROM users WHERE email = ?");
	$preparedQuery->bind_param('s', $newVals['Email']);
	$preparedQuery->bind_result($UID_result);
	$preparedQuery->execute();
	$preparedQuery->fetch();
	if ($UID_result && $UID_result != $_SESSION['user']){
	    $Success = false;
	    $Error[] = "E-Mail already in use.";
	    // TODO: This ought to happen on the page
	}
	$preparedQuery->close();
	
	// Verify gender
	if (!in_array($newVals['Gender'], array("Male", "Female", "Other"))){
	    $Success = false;
	    $Error[] = "Invalid gender specified.";
	}
	
	// Verify age is numeric
	if (!is_numeric($newVals['Age']) || (age < -2147483648) || (age > 2147483647)){
	    $Success = false;
	    $Error[] = "Invalid age specified.";
	}
	
	//TODO: Verify email format
	
	//TODO: Process and store image, get an imageID from DB
	
	if ($Success){
	    $query = "UPDATE users SET ";
	    foreach ($newVals as $column => $value){
			$query .= "$column=\"$value\", ";
		}
		$query[strrpos($query, ',')] = ' ';
		$query .= "WHERE UID={$_SESSION['user']}";
		$result = $db->query($query);
	    if ( $db->connect_errno )  {
			echo 'db connect error when executing';
		    echo $db->connect_error;
	    }
	    else {
	        // Redirect to profile page
	        header("Location: profile.php?target={$_SESSION['user']}");
	    }
	 }
	 else{
	    echo "Errors:";
	    print_r($Error);
	 }
?>
