<?php
	session_start();
	$pathToRoot = './';
	require($pathToRoot.'srv/connect.php');
	if(isset($_SESSION["user"])){
		header("location: ".$pathToRoot."emailInput.php");
		exit();
	}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Log-in Page</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/foundation.min.css">
	<!--<link rel="stylesheet" type="text/css" href="<?php //echo $pathToRoot ?>css/normalize.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/main.css">
	<script src="<?php echo $pathToRoot ?>js/jquery.js" type="text/javascript" language="javascript"></script>
	<script src="<?php echo $pathToRoot ?>js/foundation.min.js" type="text/javascript" language="javascript"></script>
	<script src="<?php echo $pathToRoot ?>js/homejs/load.js" type="text/javascript" language="javascript"></script>
	<!--<script src="<?php //echo $pathToRoot ?>js/modernizr.js" type="text/javascript" language="javascript"></script>-->
</head>
<body><br><br>
	<div class="full" style="text-align:center;" id="ccontainer">
		<h2 class="welcome-page-header" id="titleheader">JAGB Technologies</h2>
		<h3 class="welcome-page-header" id="subheader">Restaurant Management System</h3>
	</div>
	<br><br>
	<div class="full width" id="lginBanner">
		<form 	name = "login-form" 
				style="padding-top:20px;padding-bottom:15px;background-color:#333333;" 
				method="POST" action ="<?php echo $pathToRoot;?>srv/login.php"
				id="lginForm">
			<div class="row">
			    <div class="large-6 medium-6 small-14 columns">
			     	<label style="color:#CCCCCC;">Username
			        	<input id="username" autocomplete="off"
			        	name="usrnm" type="text" placeholder="Username"/>
			      	</label>
			    </div>
			    <div class="large-6 medium-6 small-14 columns">
			      	<label style="color:#CCCCCC;">Password
			        	<input id="password" autocomplete="off"
			        	name="psswd" type="password" placeholder="Password"/>
			      	</label>
			    </div>
				<div class="large-3 medium-2 small-14 columns" style="text-align:center; float:left;">
					<a href="#" onclick="document.forms['login-form'].submit();" 
						class="button small" style="height:38px; width:100%; margin-top:13px" id="loginBtn">Login</a>
				</div>
			</div>
		</form>
	</div>
	<script type="text/JavaScript" language="JavaScript">
			$('input').keypress(function(e) {
		        if(e.which == 13) {
		            jQuery(this).blur();
		            jQuery('#loginBtn').focus().click();
		        }
		    });
		</script>
</body>
</html>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>