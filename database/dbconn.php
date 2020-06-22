<?php 
	
	function dbConnection($servername, $username, $password, $db_name) {
		$conn = mysqli_connect($servername, $username, $password, $db_name);
		return $conn;
	}

?>