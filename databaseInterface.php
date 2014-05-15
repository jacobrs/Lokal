<?php
	session_start();
	$pathToRoot = './';
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	if(!alive())
	  header("location: ".$pathToRoot."srv/logout.php");
	$title = 'Search Code';
?>

<html>
	<?php require_once($pathToRoot.'includes/header.php');?>
		<script> window.pathToRoot = "<?php echo $pathToRoot;?>"; </script>
		<br><br>
		<div class = "row" id = "searches">
			<div class="row collapse">
				<!--<div class="small-3 columns" style="min-width: 205px;">
				  <input type="text" id="name" name="name" placeholder="Search by name">
				</div>
				<div class="small-1 columns" style="margin-right:20px;">
				  <a class="button postfix">Go</a>
				</div>!-->
				<div class="large-3 large-push-3 medium-3 medium-push-2 small-3 small-push-2 columns" style="width: 50%;">
				  <input type="text" id="code" name="code" placeholder="Search by code">
				</div>
				<div id="srchCodeBtn" class="large-2 large-pull-3 medium-3 medium-pull-4 small-3 small-pull-3 columns" style="width:20%;">
				  <a onclick="searchByCode();" class="button postfix">Go</a>
				</div>
				<!--<div class="small-3 columns" style="min-width: 205px;">
				  <input type="text" id="email" name="email" placeholder="Search by email">
				</div>
				<div class="small-1 columns" style="float:left;">
				  <a class="button postfix">Go</a>
				</div>-->
			</div>
		</div>
		<div class = "row" id = "results">
		</div>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>