<?php 
	session_start();
	if ($_SESSION['loggedin'] !== TRUE) {
		echo "You need to login!"
		?>
		<a href="index.php">Login here</a>
		<?php
		
	}
	
?>
