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
					$_GET['searchFor'] = "Nothing";
				}

				$sQ = "SELECT DISTINCT * FROM users ";
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
										<td>
										</td>
									</tr>
								</form>
							<?
						}
						?>
					</table>
				</div>
		</div>
	</body>
</html>
