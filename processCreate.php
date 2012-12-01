<!DOCTYPE HTML>
<html>
    <head>
        <title>Processing...</title>
		<meta name="generator" content="Gedit" />
		<meta content="text/html; charset=iso-8859-1" http-equiv="content-type" />
    </head>
    <body>
        <!-- Process the received request, and create user in db -->
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
            
            // Verify the passwords match
            if($pass != $vpass){
                $Success = false;
            }            
            
            // Grab the database connection
            @ $db = new mysqli('localhost', 
                               'team10', 
                               'tangerine', 
                               'team10_social');
                               
            // TODO: Make this more robustly visible to the user
			if ( mysqli_connect_errno( ) )  {
				$Success = false;
			}
			
        ?>
        <h1>User
