<?php
	$pathToRoot = './../';
	session_start();
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	if(isset($_POST['Email']) && isset($_POST['Fname']) && isset($_POST['Lname']) && isset($_POST['Month']) && isset($_POST['Day']) && alive()){
		$email = $_POST['Email'];
		$emailRegEx   = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/";
		$term = preg_replace($emailRegEx, "", $email);
		$term = preg_replace("/[".$term."-]/", "", $_POST['Email']);
		$email = $term;
		
		$fname = $_POST['Fname'];
		$fnameRegEx = "/[a-zA-Z0-9àáâäãåaceèéêëìíîïlnòóôöõøùúûüÿýzzñçcšžÀÁÂÄÃÅACEÈÉÊËÌÍÎÏLNÒÓÔÖÕØÙÚÛÜŸÝZZÑßÇŒÆCŠŽ?ð ,.\'-/]+/";
		$term = preg_replace($fnameRegEx, "", $fname);
		$term = preg_replace("/[".$term."-]/", "", $_POST['Fname']);
		$fname = $term;
		
		$lname = $_POST['Lname'];
		$lnameRegEx = "/[a-zA-Z0-9àáâäãåaceèéêëìíîïlnòóôöõøùúûüÿýzzñçcšžÀÁÂÄÃÅACEÈÉÊËÌÍÎÏLNÒÓÔÖÕØÙÚÛÜŸÝZZÑßÇŒÆCŠŽ?ð ,.\'-/]+/";
		$term = preg_replace($lnameRegEx, "", $lname);
		$term = preg_replace("/[".$term."-]/", "", $_POST['Lname']);
		$lname = $term;
		
		$month = $_POST['Month'];
		$monthRegEx = "/[a-zA-Z0-9àáâäãåaceèéêëìíîïlnòóôöõøùúûüÿýzzñçcšžÀÁÂÄÃÅACEÈÉÊËÌÍÎÏLNÒÓÔÖÕØÙÚÛÜŸÝZZÑßÇŒÆCŠŽ?ð ,.\'-/]+/";
		$term = preg_replace($monthRegEx, "", $month);
		$term = preg_replace("/[".$term."-]/", "", $_POST['Month']);
		$month = $term;
		
		$day = $_POST['Day'];
		$dayRegEx = "/[0-9]+/";
		$term = preg_replace($monthRegEx, "", $day);
		$term = preg_replace("/[".$term."-]/", "", $_POST['Day']);
		$day = $term;
		
		$restaurant = base64_decode(redneckUnsalt($_POST['Restaurant']));
		
		$date = "2014-".$month."-".$day;
		
		$sql = "INSERT INTO `Customers`(`Email`, `DOB`, `FirstName`, `LastName`, `RestID`)
				VALUES ('".$email."', '".$date."', '".$fname."', '".$lname."', '".$restaurant."')";
		$lokaldb->select_db('lokal');
		$result = $lokaldb->query($sql);
		
		if(!$result){
			echo 'error';
		}
		
		$lokaldb->close();
	}else{
		echo 'error';
		exit;
	}
?>