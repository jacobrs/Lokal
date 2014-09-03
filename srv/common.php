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
		refresh($dbid);
	}
	return $valid;
}

function refresh($dbid){
	global $lokaldb;
	$prep = $lokaldb->prepare('SELECT r.`RestID`, `RestName` FROM `Restaurants` r JOIN `Privileges` p ON r.`RestID` = p.`RestID` WHERE p.`AdminID` = ?');
	$prep->bind_param('i', $dbid);
	$prep->execute();
	$prep->bind_result($restaurantid, $namerest);
	$_SESSION["LinkedRestaurants"] = array();
	while($prep->fetch()){
		array_push($_SESSION["LinkedRestaurants"], serialize(new restaurant($namerest, $restaurantid)));
		//var_dump($_SESSION["LinkedRestaurants"]);
	}
	$prep->close();
	$_SESSION["LinkedRestaurants"] = $_SESSION["LinkedRestaurants"];
}

function switchrest($restid){
	global $lokaldb;
	$prep = $lokaldb->prepare('SELECT * FROM `Privileges` WHERE `AdminID` = ? AND `RestID` = ?');
	$id = unserialize($_SESSION['user'])->getUid();
	$prep->bind_param('ii', $id, $restid);
	$prep->execute();
	$prep->store_result();
	if($prep->num_rows > 0){
		$prep->close();
		$prep = $lokaldb->prepare('SELECT `RestName` FROM `Restaurants` WHERE `RestID` = ?');
		$prep->bind_param('i', $restid);
		$prep->execute();
		$prep->bind_result($restname);
		while($prep->fetch()){
			$_SESSION["Restaurant"] = new restaurant($restname, $restid);
			$_SESSION["Restaurant"] = serialize($_SESSION["Restaurant"]);
			$prep->close();
			return true;
		}
		return false;
	}
	return false;
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
	return $ret;
}

function add_admin($uname, $fname, $lname, $password, $email){
	global $lokaldb;
	$inst = $lokaldb->prepare("INSERT INTO `Admins` (`Username`, `Email`, `Fname`, `Lname`, `Password`) VALUES (?, ?, ?, ?, ?)");
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$inst->bind_param('sssss', $uname, $email, $fname, $lname, $hash);
	$inst->execute();
	return $lokaldb->insert_id;
}

function link_to_restaurant($restid, $id){
	global $lokaldb;
	$inst = $lokaldb->prepare("INSERT INTO `Privileges` (`AdminID`, `RestId`) VALUES (?, ?)");
	$inst->bind_param('ii', $id, $restid);
	$inst->execute();
	$inst->close();
	return $inst;
}

function user_exists($uname){
	global $lokaldb;
	$stmt = $lokaldb->prepare("SELECT * FROM `Admins` WHERE `Username` = ?");
	$stmt->bind_param('s', $uname);
	$res = $stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0){
		$stmt->close();
		return true;
	}
	$stmt->close();
	return false;
}

function email_exists($email){
	global $lokaldb;
	$stmt = $lokaldb->prepare("SELECT * FROM `Admins` WHERE `Email` = ?");
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0){
		$stmt->close();
		return true;
		exit();
	}
	$stmt->close();
	return false;
}

function get_id_by_email($email){
	global $lokaldb;
	$stmt = $lokaldb->prepare("SELECT `AdminID` FROM `Admins` WHERE `Email` = ?");
	$stmt->bind_param('s', $email);
	$res = $stmt->execute();
	$stmt->bind_result($out);
	$stmt->store_result();
	if($stmt->num_rows > 0){
		$stmt->fetch();
		$stmt->close();
		return $out;
	}
	$stmt->close();
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

function genRestList($rests){
	global $pathToSite;
	foreach ($rests as $rest) {
		echo '<li><a href="'.$pathToSite.'srv/switch.php?target='.urlencode(redneckSalt(base64_encode(unserialize($rest)->getId()))).'">'.unserialize($rest)->getName().'</a></li>';
	}
}

function generateDropDownRest($rests){
	foreach ($rests as $rest) {
		echo '<option value="'.redneckSalt(base64_encode(unserialize($rest)->getId())).'">'.unserialize($rest)->getName().'</option>';
	}
}

function redneckSalt($input){
	return 'RkL'.$input.'ARFs==';
}

function redneckUnsalt($input){
	return preg_replace('/ARFs==$/', '', preg_replace('/RkL/', '', $input, 1), 1); 
}

// --------------------------------- WRITE ALL CODE ABOVE THIS ----------------------------------------------

global $defaultMessage;
$defaultMessage = "";

?>