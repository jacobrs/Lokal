<?php
// common library
class user{
	private $username;
	private $fname;
	private $email;
	private $lname;
	private $uid;
	function __construct($uid){
		global $lokaldb;
		$sql = "SELECT * FROM Admins WHERE `AdminID` = '$uid'";
		$res = $lokaldb->query($sql);
		while(($row = $res->fetch_assoc()) !== null){
			$this->username = $row["Username"];
			$this->fname    = $row["Fname"];
			$this->lname    = $row["Lname"];
			$this->email    = $row["Email"];
			$this->uid 		= $uid;
		}
	}
	public function getName(){
		return $this->fname." ".$this->lname;
	}
	public function getRestaurants(){
		return $this->username;
	}
}

class restaurant{
	private $name;
	private $id;
	function __construct($name, $id){
		$this->name = $name;
		$this->id   = $id;
	}
	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
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
		$_SESSION["user"] = new user($dbid);
		$_SESSION["user"] = serialize($_SESSION["user"]);
		$sql = "SELECT r.`RestID`, `RestName` FROM `Restaurants` r JOIN `Privileges` p ON r.`RestID` = p.`RestID` WHERE p.`AdminID` = '".$dbid."'";
		$res = $lokaldb->query($sql);
		while(($row = $res->fetch_assoc()) !== null){
			$restid = $row["RestID"];
			$restname = $row["RestName"];
		}
		$_SESSION["Restaurant"] = new restaurant($restname, $restid);
		$_SESSION["Restaurant"] = serialize($_SESSION["Restaurant"]);
	}
	return $valid;
}

?>