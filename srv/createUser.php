<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$email = $_POST['Email'];
	$fname = $_POST['Fname'];
	$lname = $_POST['Lname'];
	$month = $_POST['Month'];
	$day = $_POST['Day'];
	
	$date = $month."-".$day;
	
	$sql = "INSERT INTO `Customers`(`Email`, `DOB`, `FirstName`, `LastName`, `RestID`)
			VALUES ('".$email."', '".$date."', '".$fname."', '".$lname."', 1)";
	$lokaldb->select_db('lokal');
	$result = $lokaldb->query($sql);
	
	if(!$result){
		echo 'error';
	}
	
	$lokaldb->close();
?>