<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$error = 0;
	$email = $_POST['Email'];
	$fname = $_POST['Fname'];
	$lname = $_POST['Lname'];
	
	$sql = "SELECT * 
	        FROM `Customers` 
			WHERE `Email` = '".$email."'";
	$lokaldb->select_db('lokal');
	$result = $lokaldb->query($sql);
	$numrows = $result->num_rows;
	
	if($numrows > 0){
		$error = 1;
	}
	
	/*$sql = "SELECT *   // Uncomment this for name checking
	        FROM `Customers`
			WHERE `FirstName` = '".$fname."'
			AND `LastName` = '".$lname."'";
	$lokaldb->select_db('lokal');
	$result = $lokaldb->query($sql);
	$numrows = $result->num_rows;
	
	if($numrows > 0){
		$error = 2;
	}*/
	
	$array = [
		"email"  => $email,
		"fname"  => $fname,
		"lname"  => $lname,
		"error"  => $error
	];
	$data = json_encode($array);
	
	echo $data;
?>