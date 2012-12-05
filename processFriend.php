<?php 
	@ session_start();
    if(!isset($_SESSION['user'])) {
        echo "must be logged in to send friend request";
        exit;
    }
    $user = $_SESSION['user'];
	$db = new mysqli('localhost', 'team10', 'tangerine', 'team10_social');
	if (mysqli_connect_errno()) {
		echo 'Error: could not connect to database. Better luck next time, punk!';
		exit;
	}

    if(isset($_POST['target'])) {
        $target_user = $_POST['target'];
    } else {
        echo 'error: target user to friend not found';
        exit;
    }

    $validate_query = "select UID from users where UID = $target_user";
        $friend = $db->query($validate_query);
        if($login->num_rows != 0) { 
            //check if a confirmed friendship exists
            $check_confirmed_query = "select FID from friendships where user = ".$user." and Status = 2";
            $confirmed = $db->query($check_confirmed_query);
            if($confirmed->num_rows != 0) {
                echo "that friendship already exists and is confirmed";
                exit;
            }

            //check if you already have requested such a friendship
            $check_unconfirmed_query = "select FID from friendships where user = ".$user." and Status = 1";
            $unconfirmed = $db->query($check_unconfirmed_query);
            if($unconfirmed->num_rows != 0) {
                echo "you have already requested that user as a friend, and they haven't replied yet";
                exit;
            }

            //check if they have requested you
            $check_pending_query = "select FID from friendships where target = ".$user." and Status = 1";
            $pending = $db->query($check_pending_query);
            if($pending->num_rows != 0) {
                //elevate that row to two and insert a new row of the reciprocal
                $elevate_query = "update friendships set Status = 2 where user = ".$target." and target = ".$user;
                $elevate = $db->query($elevate_query);
                $create_confirmed_query = "insert into friendships values (null, ".$user.", ".$target_user.", 2)";
                $create_confirmed = $db->query($create_confirmed_query);
            }

            $friend_query = "insert into friendships values (null, ".$user.", ".$target_user.", 1)";
            $create_frienship = $db->query($friend_query);

        } else { 
            echo "error: could not find target user with UID: $target_user"
        } 

?> 