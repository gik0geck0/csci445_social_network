<?php
	?>
		<div id="menu">
			<?
				$db = new mysqli('localhost', 'team10', 'tangerine', 'team10_social');
				if (mysqli_connect_errno()) {
					echo 'Error: could not connect to database. Please try again later.';
					exit;
				}

				$getFullName = "SELECT CONCAT(CONCAT(FirstName, ' '), LastName) AS displayName FROM users WHERE UID=".$_SESSION['user']." LIMIT 1;";
				$firstRow = $db->query($getFullName)->fetch_row();
			?>
			<div class="windowHeader">
				<img class="FlairClose" src="Flair_Close.png" alt="Close (not clickable" height="20" width="20">
				<p class="windowHeaderText">Welcome, <? echo $firstRow[0]; ?></p>
			</div>
			<div id="links">
				<div class="menulink">
					<a href="home.php" >Home</a>
				</div>
				<?php
					$user = $_SESSION['user'];
					echo '<div class="menulink">';
					echo '	<a href="profile.php?target='.$user.'">View Profile</a>';
					echo '</div>';
					echo '<div class="menulink">';
					echo '	<a href="friends.php?user='.$user.'">See Friends</a>';
					echo '</div>';
				?>
				<div class="menulink">
					<a href='search.php' >Find Users</a> <br/>
				</div>
				<div class="menulink">
					<a href='logout.php' >Log Out</a> <br/>
				</div>

			</div>
		</div>
	<?
?>
