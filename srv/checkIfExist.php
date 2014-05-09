<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$error = 0;
	$email = $_POST['Email'];
	
	$sql = "SELECT * 
	        FROM `Customers` 
			WHERE `Email` = '".$email."'";
	$lokaldb->select_db('lokal');
	$result = $lokaldb->query($sql);
	if(!$result){
		echo 'error';
		$lokaldb->close();
		exit;
	}
	$numrows = $result->num_rows;
	
	if($numrows > 0){
		$error = 1;
	}
	
	$array = [
		"email"  => $email,
		"error"  => $error
	];
	$data = json_encode($array);
	
	echo $data;
	$lokaldb->close();
?>