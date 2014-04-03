<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$email = $_POST['Email'];
	$fname = $_POST['Fname'];
	$lname = $_POST['Lname'];
	$year = $_POST['Year'];
	$month = $_POST['Month'];
	$day = $_POST['Day'];
	$gender = $_POST['Gender'];
	
	$date = $year."-".$month."-".$day;
	
	$sql = "INSERT INTO `Customers`(`Email`, `DOB`, `FirstName`, `LastName`, `RestID`, `Gender`)
			VALUES ('".$email."', '".$date."', '".$fname."', '".$lname."', 1, '".$gender."')";
	$lokaldb->select_db('lokal');
	$result = $lokaldb->query($sql);
	
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>