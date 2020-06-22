<?php

	function getComments($conn){
		$sql = "SELECT * FROM komentar";
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc()){
			echo "<div class='komentari' style='background-color:#fff;'>";
				echo "<p class='korisnik' >";
				echo $row['uid']."<br>";
				echo "</p>";
				echo "<p class='datum' >";
				echo $row['date']."<br>";
				echo "</p>";
				echo "<p class='komentar' >";
				echo $row['kom']."<br><br>";
				echo "</p>";
			echo "</div>";
			}
	}

?>
