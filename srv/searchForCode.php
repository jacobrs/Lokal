<?php
	$pathToRoot = './../';
	session_start();
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	$lokaldb->select_db('lokal');
	$result = array();
	
	if(isset($_POST['code']) && alive()){
		$searchCode = $_POST['code'];
		$sql = 'SELECT `CustID`, `Exp` FROM `Codes` WHERE upper(`Code`) = upper(?)';
		
		$code = $lokaldb->prepare($sql);
		$code->bind_param('s', $searchCode);
		
		if($code->execute()){
			$code->store_result();
			$code->bind_result($custID, $Exp);
			if($code->fetch()){
				$custId = $custID;
				$expDate = $Exp;

				$sql = "SELECT `FirstName`, `LastName`
						FROM `Customers`
						WHERE `ID` = ?";
				$customer = $lokaldb->query($sql);
				$customer = $lokaldb->prepare($sql);
				$customer->prepare($sql);
				$customer->bind_param('i', $custID);

				if($customer->execute()){
					
					$customer->store_result();
					$customer->bind_result($firstName, $lastName);
					if($customer->fetch()){
						$result['firstName'] = $firstName;
						$result['lastName'] = $lastName;
						$result['expDate'] = $expDate;
						$result['codeUsed'] = $searchCode;
					}else{
						$result['error'] = "Not found";
					}
				}else{
					$result['error'] = "Customer does not exist with matching code, someone probably deleted him/her";
				}
			}else{
				$result['error'] = "Nobody with this code exists";
			}
		}else{
			$result['error'] = "Something went wrong";
		}
	}else{
		$result['error'] = "This shouldn't happen";
		exit;
	}
	echo json_encode($result);
	die();
?>