<?php
	function sanitize($string, $dblinkid) {
		$sanitized = mysqli_real_escape_string($dblinkid, $string);
		return $sanitized;
	}
?>
