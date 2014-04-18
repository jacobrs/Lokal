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
		<script>
			var nextYear = new Date().getFullYear() + 1;
			var uniqueIdentifier = 0;
			var badHappened = false;
			var superBadHappened = false;
			var goodHappened = false;
			var errorDiv = "";
			var email = "";
			var fname = "";
			var lname = "";
			var day = "";
			var month = "";
			var year = "";
			var gender = "";
			var DOB = "";
			var errorboxmargin = 7;
		</script>
		<script src="<?php echo $pathToRoot ?>js/jsLibrary.js" type="text/javascript" language="javascript"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	</head>
	<body>
		<form 	name = "input-form" 
				style="padding-top:20px;padding-bottom:15px;" 
				id="inputForm">
			<p class="emailInfo" style="background-color:#000000; color:#FFFFFF">E-mail Info</p>
			<fieldset id = "infoField">
			<div class = "row">
				<div class = "large-7 medium-7 columns" id = "fnameDiv">
					<label style="color:#FFFFFF" id = "FnameLabel">First name
					<input id="fname" autocomplete="off"
						name="fname" type="text" placeholder="First name"/>
					</label>
				</div>
				<div class = "large-7 medium-7 columns" id = "lnameDiv">
					<label style="color:#FFFFFF" id = "LnameLabel">Last name
					<input id="lname" autocomplete="off"
						name="lname" type="text" placeholder="Last name"/>
					</label>
				</div>
			</div>
			<div class = "row">
				<div class = "large-7 columns" id = "emailDiv">
					<label style="color:#FFFFFF" id = "EmailLabel">E-mail
					<input id="email" autocomplete="off"
						name="email" type="text" placeholder="E-mail"/>
					</label>
				</div>
				<div class = "large-2 medium-5 small-5 large-push-1 columns" style="margin-top:12px;">
					<select name="day" id="day" class = "dobDivs">
					  <option selected disabled value="32">Day</option>
					  <?php
						  for($i = 1; $i <= 31; $i++){
							echo "<option value='".$i."'>".$i."</option>";
						  }
					  ?>
					</select>
				</div>
				<div class = "large-2 medium-5 small-5 large-push-1 columns" style="margin-top:12px;">
					<select name="month" id="month" class = "dobDivs">
					  <option selected disabled value = "13">Month</option>
					  <?php
						$months = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
						foreach($months as $month){
							echo "<option value='".$month."'>".$month."</option>";
						}
					  ?>
					</select>
				</div>
				<div class = "large-3 medium-5 small-5 columns">
					 <a onclick="createUser();" style="margin-top:12px; text-align:center;"
						class="button small expand" id="emailBtn">Add User</a>
				</div>
			</div>
			</fieldset>
		</form>
	</body>
</html>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>