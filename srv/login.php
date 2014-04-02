<?php
	$user_in 	= $_POST["username"];
	$pass_in 	= $_POST["password"];
	$user 		= "Password";
	$valid   	= preg_match('/([A-Z][a-z][0-9]){6,}$/', $user);
	echo json_encode($valid);
	echo "<br>v10";
	//if($valid) $valid = preg_match("//");
?>