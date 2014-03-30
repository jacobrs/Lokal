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

function createCode(){
	var email = $('#email').val();
	var fname = $('#fname').val();
	var lname = $('#lname').val();
	var isValid = true;
	
	uniqueIdentifier++;
	isValid = validateInfo(email, fname, lname);
	var start_time = new Date().getTime();
	
	if(isValid){
		document.body.style.cursor = 'wait';
		$.ajax({
			type: "POST",
			cache: "false",
			url:  pathToRoot+"srv/createCode.php",
			data:{
				Email: email,
				Fname: fname,
				Lname: lname
			},
			success: function(data){
				data = JSON.parse(data);
				notifyUser(true, data);
				console.log(data);
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

function validateInfo(email, fname, lname){
	var pattEmail = new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
	var pattName = new RegExp('[a-zA-Z0-9àáâäãåaceèéêëìíîïlnòóôöõøùúûüÿızzñçcšÀÁÂÄÃÅACEÈÉÊËÌÍÎÏLNÒÓÔÖÕØÙÚÛÜŸİZZÑßÇŒÆCŠ?ğ ,.\'-/]+');
	var bool = true;
	
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

function notifyUser(worked, code){
	if(worked){
		$("#infoField").after('<p style="color:#7CFC00; text-align:center">Successfully sent code('+uniqueIdentifier+')</p><br>'+
		'<p style="color:#7CFC00; text-align:center">Code sent was: '+code['code']+'<br><p style="color:#7CFC00; text-align:center">To: '+
		code['fname']+" "+code['lname']+'</p><br><p style="color:#7CFC00; text-align:center">E-mail: '+code['email']+'</p>');
	}else{
		superBadHappened = true;
		$("#infoField").after('<p style="color:red; text-align:center">Something went wrong while try to create a code ('+uniqueIdentifier+')</p><br>'+
		'<p style="color:red; text-align:center">Code sent was: '+code['code']);
	}
}