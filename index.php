<?php
	$pathToRoot = './';
	error_reporting(E_ALL);
 	ini_set("display_errors", 1);
	session_start();
	require('./srv/connect.php');
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Log-in Page</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/foundation.min.css">
	<!--<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/normalize.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/login.css">
	<script src="<?php echo $pathToRoot ?>js/jquery.js" type="text/javascript" language="javascript"></script>
	<script src="<?php echo $pathToRoot ?>js/foundation.min.js" type="text/javascript" language="javascript"></script>
	<!--<script src="<?php echo $pathToRoot ?>js/modernizr.js" type="text/javascript" language="javascript"></script>-->
</head>
<body>
	<div class="full width">
		<form>
			<fieldset>
				<legend>Log-in</legend>
				<div class="row">
					<div class="small-8 columns" id="user">
						<label> Username
							<input type="text" placeholder="Username">
						</label>
					</div>
					<div class="small-7 columns" id="pass">
						<label> Password
							<input type="password" placeholder="Password">
						</label>
					</div>
				</div>
				<div class="row">
					<div class="large-6 columns" id="lginBtn">
						<a href="#" class="button medium" id="loginBtn"> Login </a>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</body>
</html>
<?php
	global $lokaldb;
	$lokaldb -> close();
?>