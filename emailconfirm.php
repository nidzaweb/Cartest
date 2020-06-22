<!doctype html>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php
		include "database/dbconn.php";
		$servername = "localhost";
		$username = "";
		$username_database = "root";
		$password = "";
		$db_name = "Automobili";
		$conn = dbConnection($servername, $username_database, $password, $db_name);

		$username = $_GET['username'];
		$code = $_GET['code'];

		 // $query = mysqli_query("SELECT * FROM 'registracija' WHERE 'username' = '$username' ");
			$query = mysqli_query($conn, "select * from registracija where username = '$username'");

		 while($row = mysqli_fetch_assoc($query)){
		 	$db_code = $row['confirm-code'];
		 }

		 if($code == $db_code){
		 	mysqli_query($conn, "UPDATE `registracija` SET `confirmed`='1' WHERE username = '$username' ");
		 	mysqli_query($conn, "UPDATE `registracija` SET `confirm-code`='0' WHERE username = '$username'");
		 }
		 else{
		 	echo "Username i kod se ne poklapaju!";
		 }

	?>	

	<h1>Potvrdili ste vasu registraciju.</h1>
	<a href="index.php"><input type="button" class="potvrda" value="Ok"></a>

</body>
</html>