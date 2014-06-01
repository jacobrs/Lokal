<?php
	error_reporting(E_ALL);
  	ini_set("display_errors", 1);
	session_start();
	global $pathToRoot;
	$pathToRoot = "./../../";
	require($pathToRoot.'srv/connect.php');
	require($pathToRoot.'srv/common.php');
	if(!alive() || !is_admin())
	  header("location: ".$pathToRoot."srv/logout.php");
	global $errormsg;
	$errormsg = 'Something Went Wrong';
	$passRegEx   = "/^[a-zA-Z0-9:.?!@#$^]{3,20}?$/";
	$unameRegEx  = "/^[a-zA-Z0-9]{3,15}?$/";
	global $emailregex;
	global $nameregex;
	$password = preg_replace($passRegEx, "", $_POST['pass']);
	$fname = preg_replace($nameregex, "", $_POST['fname']);
	$lname = preg_replace($nameregex, "", $_POST['lname']);
	$uname = preg_replace($unameRegEx, "", $_POST['usern']);
	$rname = preg_replace($nameregex, "", $_POST['restn']);
	$rpassword = preg_replace($passRegEx, "", $_POST['rpass']);
	$email = preg_replace($emailregex, "", $_POST['email']);
	$type = preg_replace($unameRegEx, "", $_POST['addtype']);
	var_dump($type);
	/*
		Validations to insert
		x user exists if (if based on existing)
		x valid name
		x passwords match
		x regular expression on email all names
		x username is not taken
		x password regular expression
	*/ 

	if($type == "new"){
		if($password != $_POST['pass']){
			$errormsg = "Invalid Password"; getout();}
		if(strlen($password) > 20 || strlen($password) < 6){
			$errormsg = "The password should be 6-20 characters"; getout();}
		if(strlen($password) != strlen($rpassword)){
			$errormsg = "Passwords entered do not match"; getout();}
		if($fname != $_POST['fname'] || strlen($fname) < 1 || strlen($lname) > 20){
			$errormsg = "First Name is Invalid"; getout();}
		if($lname != $_POST['lname'] || strlen($lname) < 1 || strlen($lname) > 20){
			$errormsg = "Last Name is Invalid"; getout();}
		if($uname != $_POST['usern'] || strlen($uname) < 3 || strlen($uname) > 15){
			$errormsg = "Username is invalid [3-15]";getout();}
		if($rname != $_POST['restn'] || strlen($rname) < 3 || strlen($rname) > 30){
			$errormsg = "Restaurant Name is Invalid [3-20]"; getout();}
		if($email != $_POST['email'] || strlen($email) < 6 || strlen($email) > 100){
			$errormsg = "Email is Invalid [6-100]";getout();}
		if(user_exists($uname)){
			$errormsg = "Username is taken"; getout();}
		if(email_exists($email)){
			$errormsg = "Email already in use"; getout();}
		else{
			// add admin to the database and add a restaurant with proper linking
			$admid  = add_admin(strtolower($uname), $fname, $lname, $password, strtolower($email));
			$restid = add_restaurant($rname);
			link_to_restaurant($restid, $admid);
			header('location: '.$pathToRoot.'settings.php?success=1');
			die();
		}
	}
	else if ($type == "old"){
		if($email != $_POST['email'] || strlen($email) < 6 || strlen($email) > 100){
			$errormsg = "Email is Invalid [6-100]";getout();}
		if($rname != $_POST['restn'] || strlen($rname) < 3){
			$errormsg = "Restaurant Name is Invalid [3-20]";getout();}
		if(!email_exists($email)){
			$errormsg = "No user with that email";getout();}
		else{
			$admid  = get_id_by_email($email);
			$restid = add_restaurant($rname);
			if($admid != 1)
				link_to_restaurant($restid, $admid);
			header('location: '.$pathToRoot.'settings.php?success=1');
			die();
		}
	}
	else if ($type == "old"){
		if($rname != $_POST['restn'] || strlen($rname) < 3){
			$errormsg = "Restaurant Name is Invalid [3-20]";getout();}
		else{
			$admid  = unserialize($_SESSION['user'])->getUid();
			$restid = add_restaurant($rname);
			if($admid != 1)
				link_to_restaurant($restid, $admid);
			header('location: '.$pathToRoot.'settings.php?success=1');
			die();
		}
	}
	else
		getout();

	function getout(){
		global $errormsg;
		global $pathToRoot;
		$errormsg = htmlentities($errormsg);
		header('location: '.$pathToRoot.'srv/admin/mkrest.php?err='.$errormsg); 
		die();
	}
?>