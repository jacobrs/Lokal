<?php
	session_start();
	$pathToRoot = './';
	require($pathToRoot.'srv/connect.php');
	require($pathToRoot.'srv/common.php');
	if(!alive())
	  header("location: ".$pathToRoot."srv/logout.php");
	$title = 'Search Code';
?>

<html>
	<?php require_once($pathToRoot.'includes/header.php');?>
		<script> window.pathToRoot = "<?php echo $pathToRoot;?>"; </script>
		<div id="search-header">
			<br><br>
			<div class = "row restricted-banner" id = "searches">
				<div class="row collapse">
					<div class="large-10 large-push-1 medium-10 medium-push-1  small-6 small-push-3 columns">
					  <input type="text" id="code" name="code" placeholder="Search by code" autocomplete="off">
					</div>
					<div id="srchCodeBtn" class="large-2 large-pull-2 medium-2 medium-pull-2 small-2 small-pull-4 columns">
					  <a onclick="searchByCode();" class="button postfix">Go</a>
					</div>
				</div>
			</div>
			<br>
		</div>
		<div class = "row" id = "results">
		</div>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>