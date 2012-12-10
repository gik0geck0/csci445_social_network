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
			<!-- Fancy looking home buttom -->
			Welcome, <?= $firstRow[0] ?>
			<div id="links">
				Links <br/>
				<a class="menulink" href="home.php" >Home</a> <br/>
				<?php
					$user = $_SESSION['user'];
					echo '<a class="menulink" href="profile.php?target='.$user.'" >Profile</a> <br/>';
					echo '<a class="menulink" href="friends.php?user='.$user.'" >Friends</a> <br/>';
				?>
					<a class="menulink" href="search.php" >Find Users</a> <br/>
					<a class="menulink" href="logout.php" >Logout</a> <br/>

			</div>
		</div>
	<?
?>
