<?php 
	@ session_start();
	if (!isset($_SESSION['user'])) {
		echo "You need to login!"
		?>
		<a href="index.php">Login here</a>
		<?php
		exit();
	}
?>
