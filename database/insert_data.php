<?php 

	function insertData($conn, $table_name, $username_form, $email_form, $password_form, $confirmed, $confirmCode) {
		/**$sql = "INSERT INTO " . $table_name 
		. "(`name`, `lastname`, `numind`) " 
		. "VALUES ($name, $lastname, $numind)";**/
		// echo $username_form; 
		// echo $email_form; 
		// echo $password_form; 
		// echo $conn;
		$sql = "INSERT INTO registracija ( `username`, `email`, `password`, `confirmed`, `confirm-code`) VALUES ('$username_form', '$email_form', '$password_form', '$confirmed', '$confirmCode')";
		// echo $sql; 
		return $conn->query($sql);
	}

?>