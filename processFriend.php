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
    if(isset($_POST['action'])) {
        $action = $_POST['action'];
    } else {
        $action = -1;
    }

    $validate_query = "select UID from users where UID = $target_user";
    $validate = $db->query($validate_query);
    if($validate->num_rows != 0) { 

		/*
        //check if a confirmed friendship exists

		$user_target_exists_query = "SELECT * from friendships where User = ".$user." AND Target = ".$target_user;
		$target_user_exists_query = "SELECT * from friendships where User = ".$target_user." AND Target = ".$user;
		$userONtarget = $db->query($user_target_exists_query);
		$targetONuser = $db->query($target_user_exists_query);

		if ($userONtarget->num_rows == 0) {
			# add user on target row
			$addUserONtarget_query = "
		}
		
		echo "Making friendship!";
		if ($userONtarget->num_rows != 0) {
			$updateUserTarget = "UPDATE friendships SET Status = 1 WHERE User = ".$user." AND Target = ".$target_user;
			$db->query($updateUserTarget);
		} else {
			$friend_query = "insert into friendships values (null, ".$user.", ".$target_user.", 1)";
			$create_frienship = $db->query($friend_query);
		}
























		*/
        $check_confirmed_query = "select FID from friendships where user = ".$user." and target = ".$target_user." and Status = 2";
        $confirmed = $db->query($check_confirmed_query);
        if($confirmed->num_rows != 0) {
			if ($action == -1 || $action == 1) {
				# user and target are already friends, and they would like to stay that way.
				header("Location: friends.php?message=1");
				exit();
			} else {
				# if action = 0, remove friendship.
				$changeFriendship = "UPDATE friendships SET Status = ".$action." WHERE (User = ".$user." AND Target = ".$target_user.") OR (User = ".$target_user." AND Target = ".$user.")";
				$db->query($changeFriendship);
				header("Location: friends.php?message=4");
				exit();
			}
            //header("Location: search.php?message=1");
            //echo "that friendship already exists and is confirmed";
            //exit;
        }

        //check if you already have requested such a friendship
        $check_unconfirmed_query = "select FID from friendships where user = ".$user." and target = ".$target_user." and Status = 1";
        $unconfirmed = $db->query($check_unconfirmed_query);
        if($unconfirmed->num_rows != 0) {
			if ($action == 1 || $action == 2) {
				header("Location: friends.php?message=2");
				exit();
			} elseif($action == 0) {
				# cancel friendship request
				$changeFriendship = "UPDATE friendships SET Status = 0 WHERE (User = ".$user." AND Target = ".$target_user.") OR (User = ".$target_user." AND Target = ".$user.")";
				$db->query($changeFriendship);
				header("Location: friends.php?message=4");
				exit();
			}
            //header("Location: search.php?message=2");
            //echo "you have already requested that user as a friend, and they haven't replied yet";
            //exit;
        }

        //check if they have requested you
        //the POST key 'action' will deterine whether it is a friendship confirmation or denyal
        $check_pending_query = "select FID from friendships where target = ".$user." and user = ".$target_user." and Status = 1";
        $pending = $db->query($check_pending_query);
        if($pending->num_rows != 0) {
            if($action != -1) {
                //elevate that row to two and insert a new row of the reciprocal
                $elevate_query = "update friendships set Status = ".$action." where user = ".$target_user." and target = ".$user;
                $elevate = $db->query($elevate_query);
				$user_target_exists_query = "SELECT FID from friendships where User = ".$user." AND Target = ".$target_user;
				$target_user_exists_query = "SELECT FID from friendships where User = ".$target_user." AND Target = ".$user;
				$userONtarget = $db->query($user_target_exists_query);
				$targetONuser = $db->query($target_user_exists_query);

				echo "Making friendship!";
				if ($userONtarget->num_rows != 0) {
					$updateUserTarget = "UPDATE friendships SET Status = 1 WHERE User = ".$user." AND Target = ".$target_user;
					$db->query($updateUserTarget);
				} else {
					$friend_query = "insert into friendships values (null, ".$user.", ".$target_user.", 1)";
					$create_frienship = $db->query($friend_query);
				}
                $create_confirmed_query = "insert into friendships values (null, ".$user.", ".$target_user.", ".$action.")";
                $create_confirmed = $db->query($create_confirmed_query);
                #header("Location: friends.php?message=3");
				echo "elevated reciprocal"
				exit();
                //header("Location: search.php?message=3");
            } else {
                echo "friendship already exists but action was unset. action must be 0-deny or 2-confirm";
				exit();
            }
        } elseif ($pending->num_rows == 0 && $unconfirmed->num_rows == 0 && $confirmed->num_rows == 0) {
			$user_target_exists_query = "SELECT FID from friendships where User = ".$user." AND Target = ".$target_user;
			$target_user_exists_query = "SELECT FID from friendships where User = ".$target_user." AND Target = ".$user;
			$userONtarget = $db->query($user_target_exists_query);
			$targetONuser = $db->query($target_user_exists_query);

			echo "Making friendship!";
			if ($userONtarget->num_rows != 0) {
				$updateUserTarget = "UPDATE friendships SET Status = 1 WHERE User = ".$user." AND Target = ".$target_user;
				$db->query($updateUserTarget);
			} else {
				$friend_query = "insert into friendships values (null, ".$user.", ".$target_user.", 1)";
				$create_frienship = $db->query($friend_query);
			}
			
			if($targetONuser->num_rows != 0) {
				$updateTargetUser = "UPDATE friendships SET Status = 0 WHERE User=".$target_user." AND Target=".$target_user;
				$db->query($updateTargetUser);
			}
            #header("Location: friends.php?message=4");
			exit();
        }

    } else { 
        echo "error: could not find target user with UID: $target_user";
    } 

?> 
