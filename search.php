<!DOCTYPE>
<html>
	<head>
	</head>
	<body>
		<?php include("checkLogin.php") ?>
		<?php include("menu.php") ?>
		<?php include("sanitize.php") ?>
		<div id="searchBar">
			<form action="search.php" method="get">
				<!-- TODO: fill in the search box with the previous search -->
				Search for <select name="searchFor">
					<option value="user">Friend's Name</option>
					<option value="email">Friend's Email</option>
				</select>
				<input type="text" name="query" />
				<input type="submit" value="Find my friends!" />
			</form>
		</div>
		<div id="searchResults">
			<?php
				echo 'Search results: ';


				$db = new mysqli('localhost',
									'team10',
									'tangerine',
									'team10_social');
				$db->select_db('team10_social');
				if ( mysqli_connect_errno() ) {
					echo 'Could not connect to database. Please try again later.<br/>';
					$Success = false;
					$Errors[] = "Error connecting to server (database).";
					exit();
				}
				if (!isset($_GET['query'])) {
					$_GET['query'] = "";
				}

				$sQ = "SELECT DISTINCT f_as_user.User AS user0, f_as_user.Target AS target0, f_as_tgt.User as user1, f_as_tgt.Target as target1, users.* FROM users ";
				$sQ .= "LEFT OUTER JOIN friendships f_as_user ON f_as_user.User = ".$_SESSION['user']." ";
				$sQ .= "LEFT OUTER JOIN friendships f_as_tgt ON f_as_tgt.Target = ".$_SESSION['user']." ";
				$sQ .= "WHERE ";
				$num = 0;

				$sanitizedQuery = sanitize($_GET['query'], $db);
				$spaceSplit = explode(" ", $sanitizedQuery);

				if ($_GET['searchFor'] == "user") {
					foreach($spaceSplit as $word) {
						if (strlen($word) >= 1) {
							if ($num == 0) {
								$sQ .= "users.FirstName like '%".$word."%' ";
							} else {
								$sQ .= "OR users.FirstName like '%".$word."%' ";
							}
							$num = $num + 1;
							$sQ .= "OR users.LastName like '%".$word."%' ";
							$num = $num + 1;
						}
					}
				} elseif ($_GET['searchFor'] == "email") {
					foreach($spaceSplit as $word) {
						if (strlen($word) >= 1) {
							if ($num == 0) {
								$sQ .= "users.Email like '%".$word."%' ";
							} else {
								$sQ .= "OR users.Email like '%".$word."%' ";
							}
							$num = $num + 1;
						}
					}
				}
				if ($num > 0) {
					$sQ .= "AND ";
				}
				$sQ .= "users.UID <> ".$_SESSION['user']." ";
				# add the friendship status query
				$result = $db->query($sQ);

				if (!$result) {
					echo "Cannot search for users right now. Please try again later.<br/>";
					echo "Error: ".$db->error;
					exit();
				}
				?>
				<div>
					<table>
				<?
				while ($row = $result->fetch_assoc()) {
					# for each result.....
					?>
						<form action="processFriend.php" method="POST" >
							<tr>
								<td>
									<a href="profile.php?target=<?= $row['UID'] ?>" ><?= $row['FirstName']." ".$row['LastName']?></a>
								</td>
								<td>
									Email: <?= $row['Email'] ?>
								</td>
								<td>
									Gender: <?= $row['Gender'] ?>
								</td>
								<td>
									Age: <?= $row['Age'] ?>
								</td>
								<td> <? 
									$usr = $_SESSION[''];
									$tgt = $row['UID'];
									if (!$row['user0'] && !$row['user1']) {
										# no friendship at all.
										$usr = $_SESSION['user'];
										$tgt = $row['UID'];
										?>
										<input type="submit" value="Send friendship request" />
										<? 
									} elseif (($row['user0'] && $row['user1']) || $_GET['message'] == 1) {
										# you already have a mutual friendship
											?>
												<div>That friendship already exists and is confirmed</div>
											<?
									} elseif ($row['user1']) {
										# you have already sent out a pending request
										?>
											Waiting for acceptance
										<?
									} elseif ($_GET['message'] == 4) {
											?>
												<div>Friend request sent</div>
											<?
									} else {
										# they are awaiting a response
										?>	
											Would you like to be his/her friend?
											<table>
												<tr>
													<td>Accept</td>
													<td>Decline</td>
												</tr>
												<tr>
													<td><input type="radio" name="action" value="2"></td>
													<td><input type="radio" name="action" value="0"></td>
													<td><input type="submit" value="Send Response"></td>
												</tr>
											</table>
										<?
									}

									?>
									<input type="hidden" name="user" value="<?=$usr ?>" />
									<input type="hidden" name="target" value="<?=$tgt ?>" />
									<?
										#} elseif ($_GET['message'] == 2) {
										#	?>
												<!--<div>You have already requested that user as a friend, and they haven't replied yet</div> -->
											<?
										#} elseif ($_GET['message'] == 3) {
										#	?>
												<!--<div>Friendship has been confirmed/denied</div>-->
											<?
										#}
									?>

								</td>
							</tr>
						</form>
					<?
				}
				?>
					</table>
				</div>
				<?
			?>
		</div>
	</body>
</html>
