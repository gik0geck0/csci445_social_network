<?php 

	@ $db = new mysqli('localhost', 'team10', 'tangerine', 'team10_social');
	if (mysqli_connect_errno()) {
		echo 'Error: could not connect to database. Better luck next time, punk!';
		exit;
	}

	// Normal user section - Not logged ------ 
    if(isset($_POST['username']) && isset($_POST['password'])) { 
        // Section for logging process ----------- 
        $user = trim($_POST['username']); 
        $pass = trim($_POST['password']); 

        //I NEED TO PUT MORE STERALIZATION IN HERE!!!

        $encrypted_pass = sha1($pass);

		$login_query = "select UID from users where Email = \"$user\" and Password = \"$pass\"";
		$login = $db->query($login_query);
        if($login->num_rows != 0) { 
            $UID = $login->fetch_assoc(); 
            $_SESSION['user'] = $UID['UID']; 
            
            // Redirect to the home page. 
            header("Location: home.php"); 
        } else { 
        	header("Location: index.php?error=1");
        } 
            
    } 
?> 