<?php
	$pathToRoot = './../';
	session_start();
	require($pathToRoot.'srv/connect.php');
	require($pathToRoot.'srv/common.php');
	global $lokaldb;
	
	if(isset($_POST['Email']) && isset($_POST['Restaurant']) && alive()){
		$error = 0;
		$email = $_POST['Email'];
		$emailRegEx   = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/";
		$term = preg_replace($emailRegEx, "", $email);
		$term = preg_replace("/[".$term."-]/", "", $_POST['Email']);
		$email = $term;
		
		$restaurant = base64_decode(redneckUnsalt($_POST['Restaurant']));
		
		$restaurantMatch = false;
		$restaurants = $_SESSION["LinkedRestaurants"];
		
		foreach($restaurants as $rests){
			$tmpRest = unserialize($rests)->getId();
			if($tmpRest == $restaurant){
				$restaurantMatch = true;
			}
		}
		
		if(!$restaurantMatch){
			echo 'error2';
			$lokaldb->close();
			exit;
		}
		
		$sql = "SELECT * 
				FROM `Customers` 
				WHERE `Email` = '".$email."'";
		$lokaldb->select_db('lokal');
		$result = $lokaldb->query($sql);
		if(!$result){
			echo 'error1';
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
	}else{
		echo 'error1';
		exit;
	}
?>