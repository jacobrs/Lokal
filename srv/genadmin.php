<?php

	// Insert super admin script
	// PS HAS TO BE RUN ON CLEAN DATABASE

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
		$sql = "INSERT INTO Restaurants (RestName) VALUES  ('".$restn."');";
		$res = $lokaldb->query($sql);
		$sql = "INSERT INTO Privileges (AdminID, RestID) VALUES (1,1)";
		$res = $lokaldb->query($sql);
	}

	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>