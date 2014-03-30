<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$error = 0;
	$email = $_POST['Email'];
	$fname = $_POST['Fname'];
	$lname = $_POST['Lname'];
	$year = $_POST['Year'];
	$month = $_POST['Month'];
	$day = $_POST['Day'];
	$gender = $_POST['Gender'];
	
	$date = $year."-".$month."-".$day;
	
	$sql = "SELECT * 
	        FROM `Customers` 
			WHERE `Email` = '".$email."'";
	$lokaldb->select_db('lokal');
	$result = $lokaldb->query($sql);
	$numrows = $result->num_rows;
	
	if($numrows > 0){
		$error = 1;
	}
	
	$sql = "SELECT *
	        FROM `Customers`
			WHERE `FirstName` = '".$fname."'
			AND `LastName` = '".$lname."'";
	$lokaldb->select_db('lokal');
	$result = $lokaldb->query($sql);
	$numrows = $result->num_rows;
	
	if($numrows > 0){
		$error = 2;
	}
	
	if($error === 0){
		$sql = "INSERT INTO `Customers`(`Email`, `DOB`, `FirstName`, `LastName`, `RestID`, `Gender`)
				VALUES ('".$email."', '".$date."', '".$fname."', '".$lname."', 1, '".$gender."')";
		$lokaldb->select_db('lokal');
		$result = $lokaldb->query($sql);
	}
	
	$array = [
		"email"  => $email,
		"fname"  => $fname,
		"lname"  => $lname,
		"DOB"    => $date,
		"gender" => $gender,
		"error"  => $error
	];
	$data = json_encode($array);
	
	echo $data;
?>