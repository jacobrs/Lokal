<?php
	$pathToRoot = './';
	require($pathToRoot.'srv/connect.php');
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Input Info</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/foundation.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/main.css">
		<script src="<?php echo $pathToRoot ?>js/jquery.js" type="text/javascript" language="javascript"></script>
		<script src="<?php echo $pathToRoot ?>js/foundation.min.js" type="text/javascript" language="javascript"></script>
		<script src="<?php echo $pathToRoot ?>js/jsLibrary.js" type="text/javascript" language="javascript"></script>
	</head>
	<body>
		<form 	name = "input-form" 
				style="padding-top:20px;padding-bottom:15px;" 
				id="inputForm">
			<fieldset id = "infoField">
			<legend style="background-color:#000000; color:#FFFFFF">E-mail Info</legend>
			<div class = "row">
				<div class = "large-5 columns" id = "emailDiv">
					<label style="color:#FFFFFF" id = "EmailLabel">E-mail
					<input id="email" autocomplete="off"
						name="email" type="text" placeholder="E-mail"/>
					</label>
				</div>
				<div class = "large-5 columns" id = "fnameDiv">
					<label style="color:#FFFFFF" id = "FnameLabel">First name
					<input id="fname" autocomplete="off"
						name="fname" type="text" placeholder="First name"/>
					</label>
				</div>
				<div class = "large-5 columns" id = "lnameDiv">
					<label style="color:#FFFFFF" id = "LnameLabel">Last name
					<input id="lname" autocomplete="off"
						name="lname" type="text" placeholder="Last name"/>
					</label>
				</div>
			</div>
			<div class = "row">
				<div class = "large-4 large-offset-6 columns">
					 <a onclick="createCode();" style="margin-top:15px; text-align:center;"
						class="button medium" id="emailBtn">Create Code</a>
				</div>
			</div>
			</fieldset>
		</form>
	</body>
</html>