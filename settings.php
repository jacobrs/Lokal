<?php
	session_start();
	error_reporting(E_ALL);
    ini_set("display_errors", 1);
	$pathToRoot = './';
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	if(!alive())
	  header("location: ".$pathToRoot."srv/logout.php");
	$title = 'Manage';
?>
<html>
	<head>
		<script>
			window.pathToRoot = "<?php echo $pathToRoot;?>";
		</script>
		<?php require_once($pathToRoot.'includes/header.php');?>
		<link rel="stylesheet" type="text/css" href="<?php echo $pathToRoot ?>css/admin.css">
		<form 	name = "addfrm" action = "<?php echo $pathToRoot;?>srv/admin/addrest.php" method = "POST"
				style="padding-top:20px;padding-bottom:15px;" 
				class="addfrm" id="addfrm">
			<p class="emailInfo" style="rgba(0, 0, 0, 0); color:#333333; margin-top:2em;">Manage <?php echo unserialize($_SESSION['Restaurant'])->getName();?></p>
			<fieldset id = "infoField">
			<?php 
				if(isset($_GET['err']))
				echo '
					<div class = "row">
						<h6 class = "error"><span class="error-s">*</span> '.addslashes(strip_tags($_GET['err'])).' <span class="error-s">*</span></h6>
					</div>
				';
			?>
			</fieldset>
		</form>
		<script>
			$('select').keypress(function(e) {
				e.preventDefault();
				if(e.which == 13) {
					jQuery(this).blur();
					jQuery('#addbtn').focus().click();
				}
			});

			$('input').keypress(function(e) {
				if(e.which == 13) {
					jQuery(this).blur();
					jQuery('#addbtn').focus().click();
				}
			});
		</script>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>