<?php
	session_start();
	$pathToRoot = './'
	require($pathToRoot.'srv/fpdf.php');
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	
	global $lokaldb;
	$codeID = $_GET['identifier'];
	$prep = $lokaldb->prepare('SELECT `Code`, `CustID`, `Exp` FROM `Codes` WHERE `CustID` = ?');
	$prep->bind_param('i', $codeID);
	$prep->execute();
	$prep->store_result();
	
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B','16');
	$pdf->Cell(40,10,'Hello World!');
	$pdf->Output();
?>