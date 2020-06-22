<?php 

	function selectData($conn) {
		$sql = "SELECT * FROM registracija";
		
		return $conn->query($sql);
	}

?>