<?php

	session_start();
	unset($_SESSION['username']);
	session_destroy();
	$_SESSION['message'] = "Odjavili ste se uspesno";
	// $message_one = "";
 	// header("location : index.php" );
 	echo $_SESSION['message'];
?>