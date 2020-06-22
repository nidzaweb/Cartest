<?php

	function setComments($conn){
			$sql = "INSERT INTO registracija(Id, Komentar, datum_komentarisanja) VALUES ('$uid', '$message', '$date',)";
			$result = mysqli_guery($conn, $sql);
		}

?>