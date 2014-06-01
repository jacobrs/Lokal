<?php
// common library

global $emailregex;
$emailregex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/";
global $nameregex;
$nameregex = "~[a-zA-Z0-9àáâäãåaceèéêëìíîïlnòóôöõøùúûüÿýzzñçcšžÀÁÂÄÃÅACEÈÉÊËÌÍÎÏLNÒÓÔÖÕØÙÚÛÜŸÝZZÑßÇŒÆCŠŽ?ð ,.\-/]+~";

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
	public function getUid(){
		return $this->uid;
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

function alive(){
	if(isset($_SESSION['user'])){
		global $lokaldb;
		$uid = unserialize($_SESSION['user'])->getUid();
		$stmt = $lokaldb->prepare("SELECT `AdminID` FROM `Admins` WHERE `AdminID` = ?");
		$stmt->bind_param('i', $int);
		$res = $stmt->execute();
		$stmt->bind_result($res);
		//die($res);
		if($res > 0)
			return true;
	}
	return false;
}

function add_restaurant($name){
	global $lokaldb;
	$inst = $lokaldb->prepare("INSERT INTO `Restaurants` (`RestName`) VALUES (?)");
	$inst->bind_param('s', $name);
	$inst->execute();
	$ret = $lokaldb->insert_id;
	link_to_restaurant($ret, 1);
	return $ret();
}

function add_admin($uname, $fname, $lname, $password, $email){
	global $lokaldb;
	$inst = $lokaldb->prepare("INSERT INTO `Admins` (`Username`, `Email`, `Fname`, `Lname`, `Password`) VALUES (?, ?, ?, ?, ?)");
	$inst->bind_param('ssss', $uname, $email, $fname, $lname, password_hash($password, PASSWORD_DEFAULT));
	$inst->execute();
	return $lokaldb->insert_id;
}

function link_to_restaurant($restid, $id){
	global $lokaldb;
	$inst = $lokaldb->prepare("INSERT INTO `Privileges` (`AdminID`, `RestId`) VALUES (?, ?)");
	$inst->bind_param('ii', $id, $restid);
	$inst->execute();
	return $inst;
}

function user_exists($uname){
	global $lokaldb;
	$stmt = $lokaldb->prepare("SELECT * FROM `Admins` WHERE `Username` = ?");
	$stmt->bind_param('s', $uname);
	$res = $stmt->execute();
	$stmt->bind_result($out);
	if($stmt > 0)
		return true;
	return false;
}

function email_exists($email){
	global $lokaldb;
	$stmt = $lokaldb->prepare("SELECT * FROM `Admins` WHERE `Email` = ?");
	$stmt->bind_param('s', $email);
	$res = $stmt->execute();
	$stmt->bind_result($out);
	if($stmt > 0)
		return true;
	return false;
}

function get_id_by_email($email){
	global $lokaldb;
	$stmt = $lokaldb->prepare("SELECT `AdminID` FROM `Admins` WHERE `Email` = ?");
	$stmt->bind_param('s', $email);
	$res = $stmt->execute();
	$stmt->bind_result($out);
	if($stmt > 0){
		$stmt->fetch();
		return $out;
	}
	return false;
}

function is_admin(){
	if(isset($_SESSION['user'])){
		global $lokaldb;
		$uid = unserialize($_SESSION['user'])->getUid();
		if($uid == 1)
			return true;
	}
	return false;
}

?>