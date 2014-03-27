<?php
	$username 	= 'lokal';
	$password 	= 'Airborne#82';
	$hostname 	= 'lokal.db.12509733.hostedresource.com';
	
	global $lokaldb;
	$lokaldb	= new mysqli($hostname, $username, $password, $username);// or die ('could not connect');
	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
	//else
	//	echo 'connected';
?>