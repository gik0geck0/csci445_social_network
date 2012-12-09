<?php
	include("sanitize.php");
    
    $Success = true;
    $Errors = array();          
    
    // Grab the database connection
    $db = new mysqli('localhost', 
                       'team10', 
                       'tangerine', 
                       'team10_social');
	$db->select_db('team10_social');

    $fname = sanitize($_POST['firstName'], $db);
    $lname = sanitize($_POST['lastName'], $db);
    $email = sanitize($_POST['email'], $db);
    $pass  = sanitize($_POST['password'], $db); // HASH THIS
    $vpass = sanitize($_POST['veriPassword'], $db); // AND THIS?
    $avatar= sanitize($_POST['avatar'], $db); // Careful with this one
    $gender= sanitize($_POST['gender'], $db); // Verify this
    $age   = sanitize($_POST['age'], $db);
    $loc   = sanitize($_POST['location'], $db);
    
    // Verify the passwords match
    if($pass != $vpass){
        $Success = false;
        $Errors[] = "Passwords do not match.";
    }  
                       
    // TODO: Make this more robustly visible to the user
	if ( mysqli_connect_errno( ) )  {
		echo 'db connect error on connect';
		$Success = false;
		$Errors[] = "Error connecting to server (databse).";
	}
	
	// See if email is already in use
	$preparedQuery = $db->prepare("SELECT UID FROM users WHERE email = ?");
	$preparedQuery->bind_param('s', $email);
	$preparedQuery->bind_result($UID_result);
	$preparedQuery->execute();
	$preparedQuery->fetch();
	if ($UID_result){
	    $Success = false;
	    $Error[] = "E-Mail already in use.";
	}
	$preparedQuery->close();
	
	// Verify gender
	if (!in_array($gender, array("Male", "Female", "Other"))){
	    $Success = false;
	    $Error[] = "Invalid gender specified.";
	}
	
	// Verify age is numeric
	if (!is_numeric($age) || (age < -2147483648) || (age > 2147483647)){
	    $Success = false;
	    $Error[] = "Invalid age specified.";
	}
	
	//TODO: Verify email
	
	//TODO: Process and store image, get an imageID from DB
	
	if ($Success){
	    $prepQuery = $db->prepare("INSERT INTO users VALUES (null, ?, ?, ?, ?, 0, ?, ?, ?)");
	    $SHApass = sha1($pass);
	    $prepQuery->bind_param('sssssis', $fname, $lname, $email, $SHApass, $gender, $age, $loc);
	    $prepQuery->execute();
	    if ( $db->connect_errno )  {
			echo 'db connect error when executing';
		    echo $db->connect_error;
		    $prepQuery->close();
	    }
	    else {
			//echo 'done executing query';
		    $prepQuery->close();
	        // Redirect to index page
	        // This is bad, since the hash is theoretically visible
	        header("Location: validateLogin.php?username=$email&password=$SHApass");
	    }
	 }
	 else{
	    echo "Errors:";
	    print_r($Error);
	 }
?>
