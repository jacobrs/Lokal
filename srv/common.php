<?php
// common library
class user{
	private $username;
	private $fname;
	private $email;
	private $lname;
	function __construct($uid){
		global $lokaldb;
		$sql = "SELECT * FROM Admins WHERE `AdminID` = '$uid'";
		$res = $lokaldb->query($sql);
		while(($row = $res->fetch_assoc()) !== null){
			$this->username = $row["Username"];
			$this->fname    = $row["Fname"];
			$this->lname    = $row["Lname"];
			$this->email    = $row["Email"];
		}
	}
	public function get_fname(){
		return $this->fname;
	}
}

function validate_user($uname, $psswd){
	global $lokaldb;
	$sql = "SELECT * FROM Admins WHERE `Username` = '".$uname."'";
	// var_dump($sql);
	$res = $lokaldb->query($sql);
	$valid = false;
	$rws = $res->num_rows;
	if($rws > 0){
		while(($row = $res->fetch_assoc()) !== null){
			$dbid   = $row["AdminID"];
			$dbhash = $row["Password"];
			$valid  = password_verify($psswd, $dbhash);
		}
	}
	if($valid){
		$_SESSION["user"] = new user($uname);
		$_SESSION["user"] = serialize($_SESSION["user"]);
	}
	return $valid;
}

?>