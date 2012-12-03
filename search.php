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

					$sQ = "SELECT * FROM users";
					$num = 0;

					$sanitizedQuery = sanitize($_GET['query']);
					$spaceSplit = explode(" ", $sanitizedQuery);

					if ($_GET['searchFor'] == "user") {
						foreach($spaceSplit as $word) {
							$sQ .= "LEFT OUTER JOIN users users".$num." ON users".$num.".first ilike %".$spaceSplit."% "
							$sQ .= "LEFT OUTER JOIN users users".$num." ON users".$num.".first ilike %".$spaceSplit."% "
							$num = $num + 1;
						}
					} elseif () {
						foreach($spaceSplit as $word) {
							$sQ .= "LEFT OUTER JOIN users users".$num." ON users".$num.".first ilike %".$spaceSplit."% "
							$sQ .= "LEFT OUTER JOIN users users".$num." ON users".$num.".first ilike %".$spaceSplit."% "
							$num = $num + 1;
						}
					}
				}
			?>
		</div>
	</body>
</html>
