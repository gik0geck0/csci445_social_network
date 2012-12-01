<!DOCTYPE>
<html>
	<head>
	</head>
	<body>
		<?php include("checkLogin.php") ?>
		<?php include("menu.php") ?>
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
				}
			?>
		</div>
	</body>
</html>
