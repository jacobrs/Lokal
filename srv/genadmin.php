<?php

	//Insert super admin script

	session_start();
	$user = "Cartman";
	$pass = "MatrixPod#43_doggyDentures";

	$hash = password_hash($pass, PASSWORD_DEFAULT);

	require('./connect.php');
	global $lokaldb;

	$sql = "INSERT INTO Admins (Username, Password)
			VALUES  ('".$user."', '".$hash."');";
	var_dump($lokaldb->query($sql));

	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>