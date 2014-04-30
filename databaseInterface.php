<?php
	session_start();
	$pathToRoot = './';
	require($pathToRoot.'srv/connect.php');
	require($pathToRoot.'srv/connect.php');
	$title = 'Search Code';
?>

<html>
	<?php require_once($pathToRoot.'includes/header.php');?>
		<br><br>
		<div class = "row" id = "searches">
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
<?php require_once($pathToRoot.'includes/footer.php');?>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>