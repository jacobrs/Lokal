var pathToRoot = "http://localhost/lokal/";

/*
	Ajax code for creating a user
	Last editted by: Benjamin Barault
	On: March 30th, 2014
	
	To-do: Comment all later on and make it bullet-proof
*/

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


function createUser(){
	email = $('#email').val();
	fname = $('#fname').val();
	lname = $('#lname').val();
	day = $('#day').val();
	month = $('#month').val();
	year = $('#year').val();
	gender = $('#gender').val();
	var isValid = true;
	
	$("html").find("#userResult").remove();
	uniqueIdentifier++;
	isValid = validateInfo(email, fname, lname, day, month, gender, year);
	var start_time = new Date().getTime();
	
	if(isValid){
		document.body.style.cursor = 'wait';
		$.ajax({
			type: "POST",
			cache: "false",
			url:  pathToRoot+"srv/checkIfExist.php",
			data:{
				Email: email,
				Fname: fname,
				Lname: lname
			},
			success: function(data){
				data = JSON.parse(data);
				$('#infoField').after('<div class = "row"><fieldset id = "userResult"><legend style="background-color:#000000; color:#FFFFFF">User Info'+
				'</legend><div class = "resultContainer"></div></fieldset></div>');
				notifyUser(true, data);
			},
			error: function(data){
			    $('#infoField').after('<div class = "row"><fieldset id = "userResult"><legend style="background-color:#000000; color:#FFFFFF">Errors</legend>'+
			     '<div class = "resultContainer"></div></fieldset></div>');
				notifyUser(false, "none");
			},
			complete: function(){		
				document.body.style.cursor = 'default';
				console.log(new Date().getTime() - start_time);
			}
		});
	}
}

function validateInfo(email, fname, lname, day, month, gender, year){
	var pattEmail = new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
	var pattName = new RegExp('[a-zA-Z0-9‡·‚‰„ÂaceËÈÍÎÏÌÓÔlnÚÛÙˆı¯˘˙˚¸ˇ˝zzÒÁcöû¿¡¬ƒ√≈ACE»… ÀÃÕŒœLN“”‘÷’ÿŸ⁄€‹ü›ZZ—ﬂ«å∆Cäé? ,.\'-/]+');
	var bool = true;
	var map = {
		1: 31,
		2: 29,
		3: 31,
		4: 30,
		5: 31,
		6: 30,
		7: 31,
		8: 31,
		9: 30,
		10: 31,
		11: 30,
		12: 31
	};
	
	setEverythingToDefault();
	$("#errorBox").remove();
	
	if(!pattEmail.test(email) || email == ''){
	    errorDiv += '<p class = "errors">E-mail is invalid</p>';
		$('#EmailLabel').contents().first().replaceWith("Error");
		$("#EmailLabel").attr('class', 'error');
		$("#EmailLabel").css('color', 'red');
		$("#email").attr('class', 'error');
		if(!$("#emailDiv").find("small").length){
			$("#emailDiv").append('<small class = "error">Invalid E-mail</small>');
		}
		bool = false;
	}
	if(!pattName.test(fname) || fname == ''){
		errorDiv += '<p class = "errors">First name invalid</p>';
		$('#FnameLabel').contents().first().replaceWith("Error");
		$("#FnameLabel").attr('class', 'error');
		$("#FnameLabel").css('color', 'red');
	    $("#fname").attr('class', 'error');
		if(!$("#fnameDiv").find("small").length){
			$("#fnameDiv").append('<small class = "error">Invalid First Name</small>');
		}
		bool = false;
	}
	if(!pattName.test(lname) || lname == ''){
		errorDiv += '<p class = "errors">Last name invalid</p>';
		$('#LnameLabel').contents().first().replaceWith("Error");
		$("#LnameLabel").attr('class', 'error');
		$("#LnameLabel").css('color', 'red');
		$("#lname").attr('class', 'error');
		if(!$("#lnameDiv").find("small").length){
			$("#lnameDiv").append('<small class = "error">Invalid Last Name</small>');
		}
		bool = false;
	}
	
	if(typeof(day) === 'object' || day == 32){
		errorDiv += '<p class = "errors">Select a day</p>';
		$("#day option:first").text("Error");
		$("#day").val("32");
		bool = false;
	}else{
		$("#day option:first").text("Day");
	}
	
	if(typeof(month) !== 'object' && month != 13){
		if(day > map[month]){
			errorDiv += '<p class = "errors">Day is too high for the month</p>';
			$("#day option:first").text("Error");
			$("#day").val("32");
			bool = false;
		}else{
			$("#day option:first").text("Day");
		}
		$("#month option:first").text("Month");
	}else{
		errorDiv += '<p class = "errors">Select a month</p>';
		$("#month option:first").text("Error");
		$("#month").val("13");
		bool = false;
	}
	
	if(!(gender == 'M' || gender == 'F')){
		errorDiv += '<p class = "errors">Select a gender</p>';
		$("#gender option:first").text("Error");
		$("#gender").val("G");
		bool = false;
	}else{
		$("#gender option:first").text("Gender");
	}
	
	if(typeof(year) === 'object' || year == nextYear){
		errorDiv += '<p class = "errors">Select a year</p>';
	 	var myYear = nextYear;
		$("#year option:first").text("Error");
		$("#year").val(myYear);
		bool = false;
	}else{
		$("#year option:first").text("Year");
	}
	
	if(!bool){
		$("#inputForm").after('<fieldset id = "errorBox" style = "width: 20%; margin-left:40%; min-width: 200px"><legend style="background-color:#000000; color:#FFFFFF">Errors</legend></fieldset>');
		$("#errorBox").append(errorDiv);
		badHappened = true;
		resetVariables();
	}else{
		goodHappened = true;
	}
	
	return bool;
}

function setEverythingToDefault(){
	$('#EmailLabel').contents().first().replaceWith("E-mail");
	$("#EmailLabel").attr('class', '');
	$("#EmailLabel").css('color', 'white');
	$("#email").attr('class', '');
	$("#emailDiv").find("small").remove();
	
	$('#FnameLabel').contents().first().replaceWith("First Name");
	$("#FnameLabel").attr('class', '');
	$("#FnameLabel").css('color', 'white');
	$("#fname").attr('class', '');
	$("#fnameDiv").find("small").remove();
	
	$('#LnameLabel').contents().first().replaceWith("Last Name");
	$("#LnameLabel").attr('class', '');
	$("#LnameLabel").css('color', 'white');
	$("#lname").attr('class', '');
	$("#lnameDiv").find("small").remove();
	
	if(goodHappened || badHappened || superBadHappened){
		$("html").find("#userResult").remove();
		goodHappened = false;
		badHappened = false;
		superBadHappened = false;
	}
}


var appentToThis = ".resultContainer";
var hexColorP = "#000033";
function notifyUser(worked, data){
	var genderMap = {
		"M":"Male",
		"F":"Female"
	};
	if(worked){
		if(data['error'] == 0){
			$('#emailBtn').remove();
			$(appentToThis).append('<p style="color:'+hexColorP+'; text-decoration: underline; font-weight: bold; text-align:center">User Details</p>'+
			'<p style="color:'+hexColorP+';">Name:</p><p style="margin-top: -50px;text-align:center; width:100%">'+ data['fname']+" "+data['lname']+'</p><p style="'+
			'color:'+hexColorP+';">E-mail:</p><p style="margin-top: -50px;text-align:center; width:100%">'+data['email']+'</p><p style="color:'+hexColorP+';">Gender:</p><p'+
			' style="margin-top: -50px;text-align:center; width:100%">'+genderMap[gender]+'</p><p style="color:'+hexColorP+';">Date of Birth:</p><p style="text'+
			'-align:center; margin-top: -50px; width:100%">'+year+'-'+month+'-'+day+'</p><div id = "centerChoice"><div class = "row" style="margin-top: 50px"><div class = "large-7 '+
			'columns"><a class = "button medium" onclick = "removeEntry()" id="btnDelete">Delete entry</a></div><div class = "large-7 columns"><a class = "button medium"'+
			' onclick = "enterEntry()" id = "btnEnter">Enter entry</div></div></div>');
		}else if(data['error'] == 1){
			$(appentToThis).append('<p class = "errors" style="text-align:center">Email is already in use</p>');
		}else if(data['error'] == 2){
			$(appentToThis).append('<p class = "errors" style="text-align:center">Someone with the same name already exists</p>');
		}
	}else{
		superBadHappened = true;
		$(appentToThis).append('<p class = "errors" style="text-align:center">Something went wrong while try to create the user</p><br>');
	}
}

function removeEntry(){
	resetVariables();
	$('#userResult').parent().remove();
	$('#gender').parent().parent().after('<div class = "row"><div class = "large-4 large-offset-6 columns"><a onclick = "createUser();" style = "margin-top:15px;'+
	' text-align:center;" class = "button medium" id = "emailBtn">Add User</div>');
}

function enterEntry(){
	document.body.style.cursor = 'wait';
		$.ajax({
			type: "POST",
			cache: "false",
			url:  pathToRoot+"srv/createUser.php",
			data:{
				Email: email,
				Fname: fname,
				Lname: lname,
				Day: day,
				Month: month,
				Year: year,
				Gender: gender
			},
			success: function(data){
				$("html").find("#userResult").parent().remove();
				$("#inputForm").after('<div class = "row"><fieldset id = "userResult"><legend style="background-color:#000000; color:#FFFFFF">Result'+
				'</legend><p style="color:#FFFFFF; text-decoration: underline; font-weight: bold; text-align:center">Twas Successful</p></fieldset></div>');
				$('#gender').parent().parent().after('<div class = "row"><div class = "large-4 large-offset-6 columns"><a onclick = "createUser();" style = "margin-top:15px;'+
				' text-align:center;" class = "button medium" id = "emailBtn">Add User</div>');
			},
			error: function(data){
				$("html").find("#userResult").parent().remove();
				$("#inputForm").after('<div class = "row"><fieldset id = "userResult"><legend style="background-color:#000000; color:#FFFFFF">Results'+
				'</legend><p class = "errors" style="text-decoration: underline; font-weight: bold; text-align:center">Twas A Failure ):</p></fieldset></div>');
				$('#gender').parent().parent().after('<div class = "row"><div class = "large-4 large-offset-6 columns"><a onclick = "createUser();" style = "margin-top:15px;'+
				' text-align:center;" class = "button medium" id = "emailBtn">Add User</div>');
			},
			complete: function(){		
				document.body.style.cursor = 'default';
				console.log(new Date().getTime() - start_time);
			}
		});
		resetVariables();
}

function resetVariables(){
	errorDiv = "";
	email = "";
	fname = "";
	lname = "";
	day = "";
	month = "";
	year = "";
	gender = "";
	DOB = "";
}