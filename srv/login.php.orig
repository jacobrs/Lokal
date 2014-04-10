<?php
<<<<<<< HEAD
	$user_in 	= $_POST["username"];
	$pass_in 	= $_POST["password"];
	$user 		= "Password";
	$valid   	= preg_match('/([A-Z][a-z][0-9]){6,}$/', $user);
	echo json_encode($valid);
	echo "<br>v10";
	//if($valid) $valid = preg_match("//");
=======
	session_start();
	error_reporting(E_ALL);
 	ini_set("display_errors", 1);
	$pathToRoot = "./../";
	require_once($pathToRoot.'srv/connect.php');
	require_once($pathToRoot.'srv/common.php');
	
	$password = $_POST["psswd"];
	$username = $_POST["usrnm"];

	if(validate_user($username, $password)){
		header('location: '.$pathToRoot.'');
		die();
	}
	header('location: '.$pathToRoot.'?er=1');
	die();

	require_once($pathToRoot."includes/footer.php");
>>>>>>> devjg
?>