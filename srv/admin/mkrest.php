<?php
	session_start();
	error_reporting(E_ALL);
    ini_set("display_errors", 1);
	$pathToRoot = './../../';
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	if(!alive() || !is_admin())
	  header("location: ".$pathToRoot."srv/logout.php");
	$title = 'Add Restaurant';
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
			<p class="emailInfo" style="rgba(0, 0, 0, 0); color:#333333; margin-top:2em;">Make A New Restaurant</p>
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
				<div class = "large-7 medium-15 small-15 columns">
					<label style="color:#ffffff" id=  "type-drop"> Add Restaurant to:
					<select name = "addtype" id="typeselection" onchange = "changetype();">
						<option value="new" selected>New Account</option>
						<option value="old">Existing Account</option>
						<option value="this">This Account</option>
					</select> 
				</label>
				</div>
				<div class = "large-8 medium-15 small-15 columns" id = "emailDiv">
					<label style="color:#FFFFFF" id = "EmailLabel">E-mail
					<input id="email" autocomplete="off"
						name="email" type="text" placeholder="E-mail"/>
					</label>
				</div>
			</div>
			<div class = "row">
			</div>
			<div class = "row">
				<div class = "large-5 medium-7 small-15 columns" id = "fnameDiv">
					<label style="color:#FFFFFF" id = "FnameLabel">First name
					<input id="fname" autocomplete="off"
						name="fname" type="text" placeholder="First name"/>
					</label>
				</div>
				<div class = "large-5 medium-8 small-15 columns" id = "lnameDiv">
					<label style="color:#FFFFFF" id = "LnameLabel">Last name
					<input id="lname" autocomplete="off"
						name="lname" type="text" placeholder="Last name"/>
					</label>
				</div>
				<div class = "large-5 medium-15 small-15 columns" id = "usern">
					<label style="color:#FFFFFF" id = "FnameLabel">Username
					<input id="userni" autocomplete="off"
						name="usern" type="text" placeholder="Username"/>
					</label>
				</div>
			</div>
			<div class = "row">
				<div class = "large-5 medium-7 small-15 columns" id = "passwd">
					<label style="color:#FFFFFF" id = "FnameLabel">Password
					<input id="pass" autocomplete="off"
						name="pass" type="password" placeholder="Password"/>
					</label>
				</div>
				<div class = "large-5 medium-8 small-15 columns" id = "rpasswd">
					<label style="color:#FFFFFF" id = "LnameLabel">Re-type Password
					<input id="rpass" autocomplete="off"
						name="rpass" type="password" placeholder="Re-type"/>
					</label>
				</div>
				<div class = "large-5 medium-15 small-15 columns" id = "restn">
					<label style="color:#FFFFFF" id = "LnameLabel">Restaurant Name
					<input id="restni" autocomplete="off"
						name="restn" type="text" placeholder="Restaurant Name"/>
					</label>
				</div>
			</div>
			<div class = "row">
			</div>
			<div class = "large-15 medium-15 small-15 columns" id = "addbtnd">
				 <a onclick="document.getElementById('addfrm').submit();" style="margin-top:12px; text-align:center;"
					class="button small expand" id="emailBtn">Make New Restaurant</a>
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
		</script>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>