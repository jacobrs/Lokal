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
	for($i = 0; $i < 15; $i++){
		$code .= $codeChars[array_rand($codeChars)];
	}
	
	$array = [
		"email" => $email,
		"fname" => $fname,
		"lname" => $lname,
		"code"  => $code
	];
	$data = json_encode($array);
	
	echo $data;
?>