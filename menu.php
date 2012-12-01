<?php
	?>
		<div id="menu">
			<!-- Fancy looking home buttom -->
			Welcome, <? echo $_SESSION['user']; ?>
			<div id="links">
				Links <br/>
				<a href="profile.php" >Profile</a> <br/>
				<a href="friends.php?user=<?php echo $_SESSION['user']; ?>" >Friends</a> <br/>
				<a href="search.php" >Find Users</a> <br/>
				<a href="logout.php" >Logout</a> <br/>
			</div>
				
	<?
?>
