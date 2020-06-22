<?php

	function setComments($conn, $table_name,$uid, $message, $date) {
		echo $message;
			$sql = "INSERT INTO komentar(`uid`, `kom`, `date`) VALUES ( '$uid', '$message', '$date');";
			return $conn->query($sql);		
			
		}

?>