var pathToRoot = "http://localhost/lokal/";

/*
	Ajax code for creating a code
	Last editted by: Benjamin Barault
	On: March 30th, 2014
*/

var uniqueIdentifier = 0;
var badHappened = false;
var superBadHappened = false;
var goodHappened = false;

function createUser(){
	var email = $('#email').val();
	var fname = $('#fname').val();
	var lname = $('#lname').val();
	var day = $('#day').val();
	var month = $('#month').val();
	var year = $('#year').val();
	var gender = $('#gender').val();
	var isValid = true;
	
	uniqueIdentifier++;
	isValid = validateInfo(email, fname, lname, day, month, gender); // Validate year on a later date
	var start_time = new Date().getTime();
	
	if(isValid){
		document.body.style.cursor = 'wait';
		$.ajax({
			type: "POST",
			cache: "false",
			url:  pathToRoot+"srv/createUser.php",
			data:{
				Email: email,
				Fname: fname,
				Lname: lname,
				Year: year,
				Month: month,
				Day: day,
				Gender: gender
			},
			success: function(data){
				data = JSON.parse(data);
				console.log(data);
				notifyUser(true, data);
			},
			error: function(data){
				notifyUser(false, "none");
			},
			complete: function(){		
				document.body.style.cursor = 'default';
				console.log(new Date().getTime() - start_time);
			}
		});
	}
}

function validateInfo(email, fname, lname, day, month, gender){
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
	
	if(!pattEmail.test(email)){
		$('#EmailLabel').contents().first().replaceWith("Error");
		$("#EmailLabel").attr('class', 'error');
		$("#EmailLabel").css('color', 'red');
		$("#email").attr('class', 'error');
		if(!$("#emailDiv").find("small").length){
			$("#emailDiv").append('<small class = "error">Invalid E-mail</small>');
		}
		bool = false;
	}
	if(!pattName.test(fname)){
		$('#FnameLabel').contents().first().replaceWith("Error");
		$("#FnameLabel").attr('class', 'error');
		$("#FnameLabel").css('color', 'red');
	    $("#fname").attr('class', 'error');
		if(!$("#fnameDiv").find("small").length){
			$("#fnameDiv").append('<small class = "error">Invalid First Name</small>');
		}
		bool = false;
	}
	if(!pattName.test(lname)){
		$('#LnameLabel').contents().first().replaceWith("Error");
		$("#LnameLabel").attr('class', 'error');
		$("#LnameLabel").css('color', 'red');
		$("#lname").attr('class', 'error');
		if(!$("#lnameDiv").find("small").length){
			$("#lnameDiv").append('<small class = "error">Invalid Last Name</small>');
		}
		bool = false;
	}
	
	if(typeof(month) != 'NULL'){
		if(day > map[month] || typeof(day) == 'NULL'){
			$("#day option:first").text("Error");
			$("#day").val("32");
			bool = false;
		}else{
			$("#day option:first").text("Day");
		}
	}
	
	if(!bool){
		$("#infoField").after('<p style="color:red; text-align:center">Code was not sent, make sure the e-mail is valid and that first/last name are not empty('+uniqueIdentifier+')</p>');
		badHappened = true;
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
		$("html").find("p").remove();
		goodHappened = false;
		badHappened = false;
		superBadHappened = false;
	}
}

function notifyUser(worked, data){
	if(worked){
		if(data['error'] == 0){
			$("#infoField").after('<p style="color:#7CFC00; text-align:center">Successfully added user('+uniqueIdentifier+')</p><br>'+
			'<p style="color:#7CFC00; text-align:center">Name: '+ data['fname']+" "+data['lname']+'</p><br><p style="color:#7CFC00;'+ 
			'text-align:center">E-mail: '+data['email']+'</p>');
		}else if(data['error'] == 1){
			$("#infoField").after('<p style="color:red; text-align:center">Email is already in use ('+uniqueIdentifier+')</p><br>');
		}else if(data['error'] == 2){
			$("#infoField").after('<p style="color:red; text-align:center">Someone with the same name already exists ('+uniqueIdentifier+')</p><br>');
		}
	}else{
		superBadHappened = true;
		$("#infoField").after('<p style="color:red; text-align:center">Something went wrong while try to create the user ('+uniqueIdentifier+')</p><br>');
	}
}