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
				if (isset($_GET['query'])) {
					echo 'Search results: ';


					$db = new mysqli('localhost',
										'team10',
										'tangerine',
										'team10_social');
					$db->select_db('team10_social');
					if ( mysqli_connect_errno() ) {
						echo 'db connect error on connect';
						$Success = false;
						$Errors[] = "Error connecting to server (database).";
					}
					echo 'Connected to DB just fine';

					$sQ = "SELECT DISTINCT * FROM users ";
					$num = 0;

					$sanitizedQuery = sanitize($_GET['query'], $db);
					echo 'Sanitized: '.$sanitizedQuery;
					$spaceSplit = explode(" ", $sanitizedQuery);

					if ($_GET['searchFor'] == "user") {
						foreach($spaceSplit as $word) {
							if (strlen($word) >= 1) {
								if ($num == 0) {
									$sQ .= "WHERE ";
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
									$sQ .= "WHERE ";
									$sQ .= "users.Email like '%".$word."%' ";
								} else {
									$sQ .= "OR users.Email like '%".$word."%' ";
								}
								$num = $num + 1;
							}
						}
					}
					echo "Querying: ".$sQ;
					$result = $db->query($sQ);

					if (!$result) {
						echo "Query failed!!!<br/>";
						echo "Error: ".$db->error;
						exit();
					}
					echo "Yay, we got results!";
					while ($row = $result->fetch_assoc()) {
						echo "Result: ".$row['FirstName']."<br/>";

					}
					# Display the results


				}
			?>
		</div>
	</body>
</html>
