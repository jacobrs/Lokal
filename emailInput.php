<?php
	session_start();
	error_reporting(E_ALL);
    ini_set("display_errors", 1);
	$pathToRoot = './';
	require($pathToRoot.'srv/common.php');
	require($pathToRoot.'srv/connect.php');
	if(!alive())
	  header("location: ".$pathToRoot."srv/logout.php");
	$title = 'Input Info';
?>
<html>
	<head>
		<script>
			window.pathToRoot = "<?php echo $pathToRoot;?>";
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
			var validEntry = false;
		</script>
		<?php require_once($pathToRoot.'includes/header.php');?>
		<form 	name = "input-form" 
				style="padding-top:20px;padding-bottom:15px;" 
				id="inputForm">
			<p class="emailInfo" style="rgba(0, 0, 0, 0); color:#333333; margin-top:2em">Insert Customer</p>
			<fieldset id = "infoField">
			<div class = "row">
				<div class = "large-5 medium-7 columns" id = "fnameDiv">
					<label style="color:#FFFFFF" id = "FnameLabel">First name
					<input id="fname" autocomplete="off"
						name="fname" type="text" placeholder="First name"/>
					</label>
				</div>
				<div class = "large-5 medium-8 columns" id = "lnameDiv">
					<label style="color:#FFFFFF" id = "LnameLabel">Last name
					<input id="lname" autocomplete="off"
						name="lname" type="text" placeholder="Last name"/>
					</label>
				</div>
				<div class = "large-5 columns" id = "emailDiv">
					<label style="color:#FFFFFF" id = "EmailLabel">E-mail
					<input id="email" autocomplete="off"
						name="email" type="text" placeholder="E-mail"/>
					</label>
				</div>
				<div class = "large-5 medium-15 small-15 columns" style="margin-top:12px;">
					<select name="restaurant" id="restid">
						<?php echo generateDropDownRest($_SESSION["LinkedRestaurants"]); ?>
					</select>
				</div>
				<div class = "large-2 medium-5 small-7 large-push-1 columns" style="margin-top:12px;">
					<select name="day" id="day" class = "dobDivs">
					  <option selected disabled value="32">Day</option>
					  <?php
						  for($i = 1; $i <= 31; $i++){
							echo "<option value='".$i."'>".$i."</option>";
						  }
					  ?>
					</select>
				</div>
				<div class = "large-2 medium-5 small-8 large-push-1 columns" style="margin-top:12px;">
					<select name="month" id="month" class = "dobDivs">
					  <option selected disabled value = "13">Month</option>
					  <?php
						$months = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
						foreach($months as $month){
							echo "<option value='".$month."'>".date('F', mktime(0,0,0,$month,1,2014))."</option>";
						}
					  ?>
					</select>
				</div>
				<div class = "large-2 medium-5 small-15 large-push-1 columns">
					 <a onclick="clearInfo();" style="margin-top:12px; text-align:center;"
						class="button small expand" id="clearBtn">Clear</a>
				</div>
				<div class = "large-3 medium-15 small-15 columns">
					 <a onclick="createUser();" style="margin-top:12px; text-align:center;"
						class="button small expand" id="emailBtn">Add User</a>
				</div>
			</div>
			</fieldset>
		</form>
		<div id="dynamicModal" class="reveal-modal medium" data-reveal style="color:#FFFFFF; background-color:#333; top: 6em">
			<!-- JAVASCRIPT will fill this div -->
		</div>
		<div id="e-mailModal" class="reveal-modal medium" data-reveal style="color:#FFFFFF; background-color:#333; top: 6em">
			<h2 style="text-align: center;">E-mail is already in use</h2>
			<div style="text-align: center;">
				<a onclick="removeModal('e-mailModal');" style="color:#FFFFFF; text-align:center; margin: 0px auto; width: 200px;"
				class="button small expand" id="successBtn">Ok</a>
			</div>
		</div>
		<div id="errorModal" class="reveal-modal medium" data-reveal style="background-color:#333; top: 6em">
			<!-- JAVASCRIPT will fill this div -->
		</div>
		<script>
			$('select').keypress(function(e) {
				e.preventDefault();
				if(e.which == 13) {
					jQuery(this).blur();
					jQuery('#emailBtn').focus().click();
				}
			});

			$('input').keypress(function(e) {
				if(e.which == 13) {
					jQuery(this).blur();
					jQuery('#emailBtn').focus().click();
				}
			});
		</script>
<?php
	// footer includes the database close
	require($pathToRoot.'includes/footer.php');
?>