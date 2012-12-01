<?php
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $email = $_POST['email'];
    $pass  = $_POST['password']; // HASH THIS
    $vpass = $_POST['veriPassword']; // AND THIS?
    $avatar= $_POST['avatar']; // Careful with this one
    $gender= $_POST['gender']; // Verify this
    $age   = $_POST['age'];
    $loc   = $_POST['location'];
    
    $Success = true;
    $Errors = array();
    
    // Verify the passwords match
    if($pass != $vpass){
        $Success = false;
        $Errors[] = "Passwords do not match.";
    }            
    
    // Grab the database connection
    @ $db = new mysqli('localhost', 
                       'team10', 
                       'tangerine', 
                       'team10_social');
	$db->select_db('team10_social');
                       
    // TODO: Make this more robustly visible to the user
	if ( mysqli_connect_errno( ) )  {
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
	    $prepQuery = $db->prepare("INSERT INTO users VALUES (0, ?, ?, ?, ?, 0, ?, ?);");
	    $SHApass = SHA1($pass);
	    $prepQuery->bind_param('sssssi', $fname, $lname, $email, $SHApass, $gender, $age);
	    $prepQuery->execute();
	    if ( $db->connect_errno )  {
		    echo $db->connect_error;
		    $prepQuery->close();
	    }
	    else {
		    $prepQuery->close();
	        // Redirect to login validation page
	        header("Location: validateLogin.php?username=$email&password=$SHApass");
	    }
	 }
	 else{
	    echo "Errors:";
	    print_r($Error);
	 }
?>
