<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$email = $_POST['Email'];
	$fname = $_POST['Fname'];
	$lname = $_POST['Lname'];
	
	$info = array();
	
	$code = "";
	$codeChars = array_merge(range('A','Z'), range('a', 'z'), range(0,9));
	shuffle($codeChars);
	
	$sql = "SELECT * FROM `Code` WHERE `Code` = '".$code."'";
	$lokaldb->select_db('lokal');
	$result = $datenbank->query($sql);
	$numrows = $result->num_rows;
	
	
	
	$array = [
		"email" => $email,
		"fname" => $fname,
		"lname" => $lname,
	];
	$data = json_encode($array);
	
	$lokaldb -> close();
	echo $data;
?>