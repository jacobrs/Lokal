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
	$password = preg_match_all($passRegEx, $_POST['pass']);
	$fname = preg_match_all($nameregex, $_POST['fname']);
	$lname = preg_match_all($nameregex, $_POST['lname']);
	$uname = preg_match_all($unameRegEx, $_POST['usern']);
	$rname = preg_match_all($nameregex, $_POST['restn']);
	$rpassword = preg_match_all($passRegEx, $_POST['rpass']);
	$email = preg_match_all($emailregex, $_POST['email']);
	$type = preg_match_all($unameRegEx, $_POST['addtype']);
	/*
		Validations to insert
		x user exists if (if based on existing)
		x valid name
		x passwords match
		x regular expression on email all names
		x username is not taken
		x password regular expression
	*/ 
	if($type){
		$type = $_POST['addtype'];
	}
	if($type == "new"){
		if(!$password){
			$errormsg = "Invalid Password"; getout();}
		if(strlen($_POST['pass']) > 20 || strlen($_POST['pass']) < 6){
			$errormsg = "The password should be 6-20 characters"; getout();}
		if($_POST['pass'] != $_POST['rpass']){
			$errormsg = "Passwords entered do not match"; getout();}
		if(!$fname || strlen($_POST['fname']) < 1 || strlen($_POST['fname']) > 20){
			$errormsg = "First Name is Invalid"; getout();}
		if(!$lname || strlen($_POST['lname']) < 1 || strlen($_POST['lname']) > 20){
			$errormsg = "Last Name is Invalid"; getout();}
		if(!$uname || strlen($_POST['usern']) < 3 || strlen($_POST['usern']) > 15){
			$errormsg = "Username is invalid [3-15]";getout();}
		if(!$rname || strlen($_POST['restn']) < 3 || strlen($_POST['restn']) > 30){
			$errormsg = "Restaurant Name is Invalid [3-20]"; getout();}
		if(!$email || strlen($_POST['email']) < 6 || strlen($_POST['email']) > 100){
			$errormsg = "Email is Invalid [6-100]";getout();}
		if(user_exists($_POST['usern'])){
			$errormsg = "Username is taken"; getout();}
		if(email_exists($_POST['email'])){
			$errormsg = "Email already in use"; getout();}
		else{
			// add admin to the database and add a restaurant with proper linking
			$admid  = add_admin(strtolower($_POST['usern']), $_POST['fname'], $_POST['lname'], $_POST['pass'], strtolower($_POST['email']));
			$restid = add_restaurant($_POST['restn']);
			link_to_restaurant($restid, $admid);
			header('location: '.$pathToRoot.'settings.php?success=1');
			die();
		}
	}
	else if ($type == "old"){
		if(!$email || strlen($_POST['email']) < 6 || strlen($_POST['email']) > 100){
			$errormsg = "Email is Invalid [6-100]";getout();}
		if(!$rname || strlen($_POST['restn']) < 3){
			$errormsg = "Restaurant Name is Invalid [3-20]";getout();}
		if(!email_exists($_POST['email'])){
			$errormsg = "No user with that email";getout();}
		else{
			$admid  = get_id_by_email($_POST['email']);
			$restid = add_restaurant($_POST['restn']);
			if($admid != 1)
				link_to_restaurant($restid, $admid);
			header('location: '.$pathToRoot.'settings.php?success=1');
			die();
		}
	}
	else if ($type == "this"){
		if(!$rname || strlen($_POST['restn']) < 3){
			$errormsg = "Restaurant Name is Invalid [3-20]";getout();}
		else{
			$admid  = unserialize($_SESSION['user'])->getUid();
			$restid = add_restaurant($_POST['restn']);
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