<?php
	session_start();
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	require($pathToRoot.'srv/common.php');
	$temp = base64_decode(redneckUnsalt(urldecode($_GET['target'])));
	$validtarget = preg_match('/^[0-9]*$/', $temp);
	if($validtarget){
		$target = $temp;
		if(alive()){
			switchrest($target);
		}
	}
	header('location: '.$pathToRoot);
?>