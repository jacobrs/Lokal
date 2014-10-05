<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
	$pathToRoot = './../';
	require($pathToRoot.'srv/connect.php');
	global $lokaldb;
	$lokaldb->select_db("lokal");

	$mydate = new DateTime();
	if($mydate->format('d') == '29' && $mydate->format('m') == '02' || $mydate->format('m') == '2'){
		$mydate->sub(new DateInterval('P1D'));
	}
	$currdate = $mydate->format("Y-m-d");
	$tmpDate = new DateTime($currdate);
	$expDate = $tmpDate->add(new DateInterval('P70D'));
	$expDate = $expDate->format('Y-m-d');

	$alreadyAdded = "SELECT *
					 FROM `Codes` c
					 INNER JOIN `Customers` r
					 ON r.`ID` = c.`CustID`
					 WHERE DATEDIFF(c.`Exp`, ?) > 11";
	$alreadyAddedStat = $lokaldb->prepare($alreadyAdded);
	$alreadyAddedStat->bind_param('s', $expDate);
	if($alreadyAddedStat->execute()){
		$alreadyAddedStat->store_result();
		if($alreadyAddedStat->num_rows > 0){
			die();
		}
	}


	$sql = "SELECT r.`RestName`, c.`ID`
			FROM `Customers` c
			INNER JOIN `Restaurants` r
			ON r.`RestID` = c.`RestID`
			WHERE ABS(DAYOFYEAR(c.`DOB`) - DAYOFYEAR(?)) < 7";
	$birthday = $lokaldb->prepare($sql);
	$birthday->bind_param('s', $currdate);
	if($birthday->execute()){
		$birthday->store_result();
		$birthday->bind_result($restName, $CustID);
		while($birthday->fetch()){
			// **** generate random alphanumeric code ****
			do{
				$genCode="";
				$codeRange = array_merge(range('A', 'Z'),range(0,9));
				for($i = 0; $i < 16; $i++){
					$genCode .= $codeRange[array_rand($codeRange, 1)];
					shuffle($codeRange);
				}
				$sql = "SELECT * FROM `Codes` WHERE `Code` = '".$genCode."'";
				$result = $lokaldb->query($sql);
				$numrows = $result->num_rows;
			}while($numrows > 0);	// validate UNIQUE codes
			$sql = "INSERT INTO `Codes`(`Code`, `CustID`, `Exp`) 
					VALUES(?, ?, date_add('$currdate', INTERVAL 90 DAY))";
			$lokaldb->select_db('lokal');
			$result = $lokaldb->prepare($sql);
			$result->bind_param('si', $genCode, $CustID);
			if($result->execute()){
			}else{
				// this shouldn't happen
			}
		}
	}else{
		// this shouldn't happen
	}
	
	$lokaldb->close();
?>