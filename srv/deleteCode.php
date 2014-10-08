<?php
	$pathToRoot = './../';
	session_start();
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	$lokaldb->select_db('lokal');
	$result = array();
	global $codeRegex;
	if(isset($_POST['code']) && alive()){
		$searchCode = preg_replace($codeRegex, '', $_POST['code']);
		$sql = 'DELETE FROM `Codes` WHERE upper(`Code`) = upper(?)';
		
		$code = $lokaldb->prepare($sql);
		$code->bind_param('s', $searchCode);
		
		if($code->execute()){
			$result['success'] = true;
		}else{
			$result['error'] = "Nobody with this code exists";
		}
	}else{
		$result['error'] = "This shouldn't happen";
		exit;
	}
	echo json_encode($result);
	die();
?>