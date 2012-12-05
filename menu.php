<?php
	?>
		<div id="menu">
			<!-- Fancy looking home buttom -->
			Welcome, <? echo $_SESSION['user']; ?>
			<div id="links">
				Links <br/>
				<a href="home.php" >Home</a> <br/>
				<?php
					$user = $_SESSION['user'];
					echo '<a href="profile.php?target='.$user.'" >Profile</a> <br/>';
					echo '<a href="friends.php?user='.$user.'" >Friends</a> <br/>';
				?>
					<a href="search.php" >Find Users</a> <br/>
					<a href="logout.php" >Logout</a> <br/>

			</div>
				
	<?
?>
