<?php
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
?>