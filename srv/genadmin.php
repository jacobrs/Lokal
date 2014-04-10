<?php

	//Insert super admin script

	session_start();
	$user 	= "Erix";
	$pass 	= "karlmarx123";
	//$pass 	= "MatrixPod#43_doggyDentures";
	$lname 	= "Eric";
	$fname 	= "Cartman";
	$email  = "eric.cartman@lokal.com";

	$hash = password_hash($pass, PASSWORD_DEFAULT);

	require('./connect.php');
	global $lokaldb;

	$sql = "INSERT INTO Admins (Username, Password, Email, Fname, Lname)
			VALUES  ('".$user."', '".$hash."', '".$email."', '".$fname."', '".$lname."');";
	var_dump($lokaldb->query($sql));

	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>