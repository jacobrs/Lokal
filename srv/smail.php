<?php
	$pathToRoot = './../';
	session_start();
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	$return["error"] = "Error";

	if(isset($_POST['msg']) && alive()){	
		$messageRegEx = "/[^\w\d\ ,:,.\&\#\$\%\;\:\<\>\'-\/]/ui";
		$_POST['msg'] = nl2br($_POST['msg']);
		$message = addslashes(preg_replace($messageRegEx, '', $_POST['msg']));
		$rid = unserialize($_SESSION['Restaurant'])->getId();
		if($message == getMessage($rid)){
			$return["error"] = "";
			$return["mesg"] = "Saved";
			$return["stored"] = stripcslashes($message);
			echo json_encode($return);
			die();
		}
		$stat = $lokaldb->prepare("SELECT `AdminID` FROM `Privileges` WHERE `RestID` = ?");
		$stat->bind_param('i', $rid);
		$stat->execute();
		$stat->bind_result($adminId);
		$stat->store_result();
		if($stat->num_rows > 0){
			$stat->fetch();
			if($adminId == unserialize($_SESSION['user'])->getUid()){
				$insert = $lokaldb->prepare("UPDATE `Restaurants` SET `Message` = ? WHERE `RestID` = ?");
				$insert->bind_param('si', $message, $rid);
				$insert->execute();
				$insert->store_result();
				//var_dump($message." RID:".$rid);
				if($insert->affected_rows > 0){
					$return["error"] = "";
					$return["mesg"] = "Saved";
					$return["stored"] = stripcslashes($message);
				}else{
					$return["error"] = "Insertion Error";
				}
				$insert->close();
			}else{
				$return["error"] = "Timeout Error";
			}
		}else{
			$return["error"] = "Privilege issue";
		}
		$stat->close();
		echo json_encode($return);
		die();
	}
	header('location: '.$pathToRoot);
	die();
?>