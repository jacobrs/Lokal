<?php
	session_start();
	$pathToRoot = './';
	require($pathToRoot.'srv/fpdf.php');
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	
	global $lokaldb;
	$code = $_GET['identifier'];
	$sql = "SELECT r.`Message`, r.`RestName`, c.`FirstName`, c.`LastName`, co.`Exp` 
			FROM (`Codes` co JOIN `Customers` c ON co.`CustID` = c.`ID`) 
			JOIN `Restaurants` r ON r.`RestID` = c.`RestID` 
			WHERE co.`Code` = ?";
	$prep = $lokaldb->prepare($sql);
	$prep->bind_result($msg, $rName, $fName, $lName, $exp);
	$prep->bind_param('s', $code);
	$prep->execute();
	$prep->fetch();
	$prep->close();
	
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','','12');
	$pdf->Cell($pdf->GetStringWidth($fName)+3,10,$fName,0,0,'L');
	$pdf->Cell($pdf->GetStringWidth($lName),10,$lName,0,0,'L');
	$pdf->Cell(0,10,date('Y-m-d',strtotime($exp)),0,0,'R');
	$pdf->Ln();
	$pdf->MultiCell($pdf->w-20,10,$msg);
	$pdf->Output();
?>