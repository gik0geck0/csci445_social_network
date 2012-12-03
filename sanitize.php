<?php
	function sanitize($string) {
		mysql_set_charset("utf8");
		$sanitized = mysql_real_escape_string($string);
	}
?>
