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
	<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/normalize.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/login.css">
	<script src="<?php echo $pathToRoot ?>js/jquery.js" type="text/javascript" language="javascript"></script>
	<script src="<?php echo $pathToRoot ?>js/foundation.min.js" type="text/javascript" language="javascript"></script>
	<script src="<?php echo $pathToRoot ?>js/modernizr.js" type="text/javascript" language="javascript"></script>
</head>
<body>
	<div class="small-12 columns" id="full">
		<form>
			<fieldset>
				<legend>Log-in</legend>
				<div class="row">
					<div class="small-6 columns">
						<label> Username
							<input type="text" placeholder="Username">
						</label>
					</div>
					<div class="small-6 columns">
						<label> Password
							<input type="password" placeholder="Password">
						</label>
					</div>
					<div class="small-2 columns">
						<a href="#" class="button tiny" id="loginBtn"> Login </a>
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