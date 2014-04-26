<?php

	//Insert super admin script

	session_start();
	$user 	= "Emilia";
	$pass 	= "gotdr4gons123";
	//$pass 	= "MatrixPod#43_doggyDentures";
	$lname 	= "Targaryen";
	$fname 	= "Daenerys";
	$email  = "dragonmother@lokal.com";
	$restn  = "Hooters";

	$hash = password_hash($pass, PASSWORD_DEFAULT);

	require('./connect.php');
	global $lokaldb;

	$sql = "INSERT INTO Admins (Username, Password, Email, Fname, Lname)
			VALUES  ('".$user."', '".$hash."', '".$email."', '".$fname."', '".$lname."');";
	var_dump($lokaldb->query($sql));
	$sql = "SELECT AdminID FROM Admins WHERE `Username` = $user";
	$res = $lokaldb->query($sql);
	$id = 1;
	if($id != 0){
		$sql = "INSERT INTO Restaurants (RestName)
			VALUES  ('".$restn."');";
	}

	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>