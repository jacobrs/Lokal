<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;

	$currdate = date('d');
	$currmont = date('m');
	if($currdate == '29' && $currmont = '02'){
		$currdate = '28';
	}
	$currdate = '2014-'.$currmont.'-'.$currdate;

	$sql = "SELECT `RestName`, c.*
			FROM `Customers` c
			INNER JOIN `Restaurants` r
			ON r.`RestID` = c.`RestID`
			WHERE DAYOFYEAR(c.`DOB`) - DAYOFYEAR('".$currdate."') = 7 
			AND ABS(datediff('".$currdate."' , c.`RegDate`)) > 7";
	//var_dump($sql);
	$birthday = $lokaldb->query($sql);	//get all customers with restaurant name
	while(($row = $birthday->fetch_assoc()) !== NULL){
		echo $row['FirstName'].' '.$row['LastName'].' '.$row['DOB'].'<br>';
	}
	/*
	$today = date("y-m-d");				//get today's date
	
	while (($row = $birthday->fetch_assoc()) !== NULL) {
		$diff = date_diff($today, $row['DOB']);		//find the difference between today and customer's birthday
		if ($diff <= 7) {   			// within 7 days? send email!	
			$to = $row['Email'];
			$subject = "'".$row['RestName']."' wishes you a happy birthday!"
			$header = "From: '".$row['RestName']."'"
			$message = "Bonjour '".$row['FirstName']."' '".$row['LastName']."',\r\n
						Pour votre fête, nous vous offrons un repas gratuit comme cadeau!\r\n
						S'il vous plaît imprimer et apporter le fichier PDF ci-joint pour votre prochaine sortie à '".$row['RestName']."''s.\r\n\r\n\r\n"
						
					   "Hello '".$row['FirstName']."' '".$row['LastName']."',\r\n					
						For your birthday, we would like you to have a free meal on us!\r\n
						Please print and bring the attached PDF to your next outing at '".$row['RestName']."''s.\r\n\r\n\r\n"
			$sent = mail($to, $subject, $message, $header);
			if($sent){
				print "Your mail was sent successfully";
			}
			else{
				print "ERROR: Couldn't send email.";
			}
		}
	}*/
	
	$lokaldb->close();
	
	// $lokaldb->select_db('lokal');
?>