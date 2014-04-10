<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$sql = "SELECT `DOB` 
			FROM `Customers`";
	$birthday = $lokaldb->query($sql);
	$today = date("y-m-d");
	
	while (($row = $birthday->fetch_assoc()) !== NULL) {
		$diff = date_diff($today, $row['DOB']);
		if ($diff <= 7) {   // TODO: send email
		}
	}
	// $lokaldb->select_db('lokal');
?>