<?php 

	function createdb($conn, $db_name) {
		$sql = "CREATE DATABASE " . $db_name;
		return $conn->query($sql);
	}

?>