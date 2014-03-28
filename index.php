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
<<<<<<< HEAD
	<div class="full width">
		<br><br><br><br><br><br>
		<form 	name = "login-form" 
				style="padding-top:20px;padding-bottom:15px;background-color:#333333;" 
				method="POST" action ="<?php echo $pathToRoot;?>srv/login.php">
			<div class="row">
			    <div class="large-5 columns">
			     	<label style="color:#CCCCCC;">Username
			        	<input id="username" autocomplete="off"
			        	name="username" type="text" placeholder="Username"/>
			      	</label>
			    </div>
			    <div class="large-5 columns">
			      	<label style="color:#CCCCCC;">Password
			        	<input id="password" autocomplete="off"
			        	name="psswd" type="password" placeholder="Password"/>
			      	</label>
			    </div>
				<div class="large-2 columns" style="margin-top:22px; text-align:center;">
					<a href="#" onclick="document.forms['login-form'].submit();" style="width:15em;"
						class="button tiny" id="loginBtn">Login</a>
				</div>
			</div>
		</form>
			<!--
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
			-->
	</div>
=======
	<br><br><br><br><br><br><br>
	<form name="login-form" style="padding-top:20px;padding-bottom:15px;background-color:#333333;">
		<div class="row">
		    <div class="large-6 columns" style = "max-width:62.5em;">
		     	<label style="color:#CCCCCC;">Username / Email
		        	<input id="username" autocomplete="off"
		        	name="username" type="text" placeholder="Username"/>
		      	</label>
		    </div>
		    <div class="large-5 columns">
		      	<label style="color:#CCCCCC;">Password
		        	<input id="password" autocomplete="off"
		        	name="password" type="password" placeholder="Password"/>
		      	</label>
		    </div>
			<div class="large-2 columns" style="margin-top:15px; text-align:center;" id = "loginBtn">
				<a href="#" onclick="document.forms['login-form'].submit();"
					class="button tiny" id="loginBtn">Login</a>
			</div>
		</div>
		<!--
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
		</fieldset>-->
	</form>
>>>>>>> 18c682411f6e756c1a656c674533e14dfca7d9cb
</body>
</html>
<?php
	global $lokaldb;
	$lokaldb -> close();
?>