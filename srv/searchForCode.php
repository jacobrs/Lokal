<?php
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	
	$searchCode = $_POST['code'];
	$sql = 'SELECT * FROM `Codes` WHERE `Code` = upper(\''.$searchCode.'\')';
	$lokaldb->select_db('lokal');
	
	$result = $lokaldb->query($sql);
	$numrows = $result->num_rows;
	if($numrows > 0){
		if(($person = $result->fetch_assoc()) !== NULL){
			$custId = $person['CustID'];
			$expDate = $person['Exp'];
			$sql = "SELECT `FirstName`, `LastName`
					FROM `Customers`
					WHERE `ID` = '".$custId."'";
			$customer = $lokaldb->query($sql);
			if(($row = $customer->fetch_assoc()) !== NULL){
				$data="<div id='SearchResult' class='row' style='text-align:center;'><div id='found' class='large-14 medium-14 small-14'><p>".$row['FirstName']." ".$row['LastName']." ".$expDate." </p></div></div>";
			}else{
				$data="<div id='SearchResult' class='row' style='text-align:center;'><div id='notFound' class='large-14 medium-14 small-14'><p>Error 1</p></div></div>";
			}
		}else{
			$data="<div id='SearchResult' class='row' style='text-align:center;'><div id='notFound' class='large-14 medium-14 small-14'><p>Error 2</p></div></div>";
		}
	}else{
		$data="<div id='SearchResult' class='row' style='text-align:center;'><div id='notFound' class='large-14 medium-14 small-14'><p>Nobody exists with this code</p></div></div>";
	}
	echo $data;
?>