<?php
	session_start();
	$pathToRoot = './';
	require($pathToRoot.'srv/connect.php');
	require($pathToRoot.'srv/common.php');
	if(!alive())
	  header("location: ".$pathToRoot."srv/logout.php");
	$title = 'Manage';
	refresh(unserialize($_SESSION['user'])->getUid());
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
				<div class = "row">
					<div class = "large-15 small-15 medium-15 column">
						<label style="color:#FFFFFF;">Email Message
			        		<textarea id="message" autocomplete="off"
			        		name="mesg" placeholder="Enter a message for your customers..."></textarea>
			      		</label>
					</div>
				</div>
				<div class = "row restricted-with-area">
					<div class = "large-5 small-15 column">
						<a href="javascript:void(0);" style = "width:100%" onclick="saveEmailText();" 
							class="button small" id="savebtn">Save</a>
					</div>
					<div class = "large-4 small-15 column">
						<p id = "counter">0&nbsp;Characters</p>
					</div>
				</div>
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

			$(document).ready(function(){			
				$('#message').on("keyup", function(e){
					document.getElementById('counter').innerHTML = document.getElementById('message').value.length + "&nbsp;Characters";
				});
			});
		</script>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>