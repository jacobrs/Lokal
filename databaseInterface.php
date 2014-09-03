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
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	</head>
	<body>
		<br><br>
		<div class = "row" id = "searches">
			<!-- Only allow admins/managers to search by name/email -->
			<div class="row collapse">
				<div class="small-3 columns" style="min-width: 205px;">
				  <input type="text" id="name" name="name" placeholder="Search by name">
				</div>
				<div class="small-1 columns" style="margin-right:20px;">
				  <a class="button postfix">Go</a>
				</div>
				<div class="small-3 columns" style="min-width: 205px;">
				  <input type="text" id="code" name="code" placeholder="Search by code">
				</div>
				<div class="small-1 columns" style="margin-right:20px;">
				  <a class="button postfix">Go</a>
				</div>
				<div class="small-3 columns" style="min-width: 205px;">
				  <input type="text" id="email" name="email" placeholder="Search by email">
				</div>
				<div class="small-1 columns" style="float:left;">
				  <a class="button postfix">Go</a>
				</div>
			</div>
		</div>
		<div class = "row" id = "results">
			<fieldset>
				<legend style="background-color:#000000; color:#FFFFFF">Results</legend>
				<div class = "row" id = "resultsList">
					<div class="small-3 columns">
						<label>Name</label>
					</div>
					<div class="small-3 columns">
						<label>Code</label>
					</div>
					<div class="small-3 columns">
						<label>E-mail</label>
					</div>
					<div class="small-3 columns">
						<label>DOB</label>
					</div>
					<div class="small-3 columns">
						<label>Gender</label>
					</div>
				</div>
			</fieldset>
		</div>
	</body>
</html>