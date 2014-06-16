var pathToRoot = window.pathToRoot;

/*
	Ajax code for creating a user
	Last editted by: Benjamin Barault
	On: March 30th, 2014
	
	To-do: Comment all later on and make it bullet-proof
*/
function createUser(){
	email = $('#email').val();
	fname = $('#fname').val();
	lname = $('#lname').val();
	day = $('#day').val();
	month = $('#month').val();
	var isValid = true;
	
	isValid = validateInfo(email, fname, lname, day, month);
	var start_time = new Date().getTime();
	
	if(isValid){
		document.body.style.cursor = 'wait';
		$.ajax({
			type: "POST",
			cache: "false",
			url:  pathToRoot+"srv/checkIfExist.php",
			data:{
				Email: email,
			},
			success: function(data){
				if(data != 'error'){
					data = JSON.parse(data);
					validEntry = true;
					notifyUser(true, data);
				}else{
					$('#errorModal').empty();
					$('#errorModal').append('<h2 style="text-align: center;">Something went wrong with the operation, make sure you have an internet connection</h2>'+
					'<div style="text-align: center;">'+
					'<a onclick="removeModal(\'errorModal\');" style="text-align:center; margin: 0px auto; width: 200px;"'+
					'class="button small expand" id="errorBtn">Ok</a>'+
					'</div>');
					$('#errorModal').foundation('reveal', 'open');
				}
			},
			error: function(data){
				notifyUser(false, "none");
				validEntry = false;
			},
			complete: function(){		
				document.body.style.cursor = 'default';
				//console.log(new Date().getTime() - start_time);
			}
		});
	}
}

function validateInfo(email, fname, lname, day, month){
	var pattEmail = new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$');
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

	if(!pattEmail.test(email) || email == ''){
		$("#EmailLabel").removeClass().addClass('error');
		$("#EmailLabel").css('color', 'red');
		$("#email").removeClass().addClass('error');
		if(!$("#emailDiv").find("small").length){
			$("#emailDiv").append('<small class = "error" style="margin-top:-'+errorboxmargin+'px">Invalid E-mail</small>');
		}
		bool = false;
	}
	if(!pattName.test(fname) || fname == ''){
		$("#FnameLabel").removeClass().addClass('error');
		$("#FnameLabel").css('color', 'red');
	    $("#fname").removeClass().addClass('error');
		if(!$("#fnameDiv").find("small").length){
			$("#fnameDiv").append('<small class = "error" style="margin-top:-'+errorboxmargin+'px">Invalid First Name</small>');
		}
		bool = false;
	}
	if(!pattName.test(lname) || lname == ''){
		$("#LnameLabel").removeClass().addClass('error');
		$("#LnameLabel").css('color', 'red');
		$("#lname").removeClass().addClass('error');
		if(!$("#lnameDiv").find("small").length){
			$("#lnameDiv").append('<small class = "error" style="margin-top:-'+errorboxmargin+'px">Invalid Last Name</small>');
		}
		bool = false;
	}
	
	if(typeof(day) === 'object' || day == 32){
		$("#day").val("32");
		if(!$("#day").find("small").length){
			$("#day").after('<small class = "error" style="width:100%; margin-top:-'+errorboxmargin*2.2+'px">Invalid Day</small>');
		}
		bool = false;
	}
	
	if(typeof(month) !== 'object' && month != 13){
		if(day > map[month]){
			$("#day").val("32");
			if(!$("#day").find("small").length){
				$("#day").after('<small class = "error" style="width:100%; margin-top:-'+errorboxmargin*2.2+'px">Invalid Day</small>');
			}
			bool = false;
		}
	}else{
		if(!$("#month").find("small").length){
				$("#month").after('<small class = "error" style="width:100%; margin-top:-'+errorboxmargin*2.2+'px">Invalid Month</small>');
		}
		$("#month").val("13");
		bool = false;
	}
	
	if(!bool){
		badHappened = true;
		resetVariables();
	}else{
		goodHappened = true;
	}
	
	return bool;
}

function setEverythingToDefault(){
	$("#EmailLabel").removeClass();
	$("#EmailLabel").css('color', 'white');
	$("#email").removeClass();
	
	$("#FnameLabel").removeClass();
	$("#FnameLabel").css('color', 'white');
	$("#fname").removeClass();
	
	$("#LnameLabel").removeClass();
	$("#LnameLabel").css('color', 'white');
	$("#lname").removeClass();
	
	$("html").find("small").remove();
	
	if(goodHappened || badHappened || superBadHappened){
		goodHappened = false;
		badHappened = false;
		superBadHappened = false;
	}
}

var hexColorP = "#000033";
function notifyUser(worked, data){
    //console.log(data);
	if(worked){
		if(data['error'] == 0){
			month = '0'+month;
			month = month.slice(-2);
			day = '0'+day;
			day = day.slice(-2);
	
			$('#emailBtn').parent().remove();
			$('#month').parent().removeClass().addClass("large-3 medium-7 small-7 columns");
			$('#day').parent().removeClass().addClass("large-3 medium-7 small-7 large-push-1 columns columns");
			$('#dynamicModal').append('<p class="confirmHeader" style="rgba(0, 0, 0, 0); color:#FFFFFF; text-align:center">Confirm Insert</p>');
			$('#dynamicModal').append('<p class="validateInfo" style="float: left">'+fname+' '+lname+'</p><p class="validateInfo" style="float:right">'+month+
			'/'+day+' (MM/DD)</p><p class="validateInfo" style="text-align:center; clear:both">'+data['email']+'</p>');
			$('#dynamicModal').append('<ul class="button-group acptDeny"><li class="confirmBtns"><a class = "button medium" onclick = "removeEntry()" id="btnDelete">Cancel</a></li></div>'+
			'<li class="confirmBtns"><a class = "button medium" onclick = "enterEntry()" id = "btnEnter">Confirm</a></li></ul>');
			$('#dynamicModal').foundation('reveal', 'open');
		}else if(data['error'] == 1){
			// EMAIL ALREADY IN USE
			$('#e-mailModal').foundation('reveal', 'open');
		}
	}else{
		superBadHappened = true;
		// SOMETHING BAD HAPPENED WHILE INPUTTING USER
		$('#errorModal').empty();
		$('#errorModal').append('<h2 style="text-align: center;">Something went wrong with the operation, make sure you have an internet connection</h2>'+
		'<div style="text-align: center;">'+
		'<a onclick="removeModal(\'errorModal\');" style="text-align:center; margin: 0px auto; width: 200px;"'+
		'class="button small expand" id="errorBtn">Ok</a>'+
		'</div>');
		$('#errorModal').foundation('reveal', 'open');
	}
}

function removeEntry(){
	$('#dynamicModal').foundation('reveal', 'close');
}

function enterEntry(){
	if(validEntry){
		document.body.style.cursor = 'wait';
		if(day == 29 && month == 2){
			day = 28;
		}
		var start_time = new Date().getTime();
		$.ajax({
			type: "POST",
			cache: "false",
			url:  pathToRoot+"srv/createUser.php",
			data:{
				Email: email,
				Fname: fname,
				Lname: lname,
				Day: day,
				Month: month
			},
			success: function(data){
				if(data != 'error'){
					$('#dynamicModal').empty();
					$('#dynamicModal').append('<h2 style="text-align: center;">Successfully entered user</h2>'+
					'<div style="text-align: center;">'+
					'<a onclick="removeModal(\'dynamicModal\');" style="text-align:center; margin: 0px auto; width: 200px;"'+
					'class="button small expand" id="successBtn">Ok</a>'+
					'</div>');
				}else{
					$('#dynamicModal').empty();
					$('#dynamicModal').append('<h2 style="text-align: center;">Something went wrong with the operation, make sure you have an internet connection</h2>'+
					'<div style="text-align: center;">'+
					'<a onclick="removeModal(\'dynamicModal\');" style="text-align:center; margin: 0px auto; width: 200px;"'+
					'class="button small expand" id="errorBtn">Ok</a>'+
					'</div>');
				}
			},
			error: function(data){
				$('#dynamicModal').empty();
				$('#dynamicModal').append('<h2 style="text-align: center;">Something went wrong with the operation, make sure you have an internet connection</h2>'+
				'<div style="text-align: center;">'+
				'<a onclick="removeModal(\'dynamicModal\');" style="text-align:center; margin: 0px auto; width: 200px;"'+
				'class="button small expand" id="errorBtn">Ok</a>'+
				'</div>');
			},
			complete: function(){		
				document.body.style.cursor = 'default';
				//console.log(new Date().getTime() - start_time);
			}
		});
	}
	
	validEntry = false;
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

$(document).on('close', '[data-reveal]', function (e) {
	if(e.target.id == "dynamicModal"){
		resetVariables();
		$('#month').parent().removeClass().addClass("large-2 medium-5 small-5 large-push-1 columns");
		$('#day').parent().removeClass().addClass("large-2 medium-5 small-5 large-push-1 columns");
		$('#month').parent().after('<div class = "large-3 medium-5 small-5 columns"><a onclick = "createUser();" style = "margin-top:12px;'+
		' text-align:center;" class = "button small expand" id = "emailBtn">Add User</a></div>');
		$('#dynamicModal').empty();
	}
});

function removeModal(modal){
	$('#'+modal).foundation('reveal', 'close');
}

// Function that dictates what to show when the user is trying to add a new restaurant
// Last Editor: Jacob Gagne
function changetype(){
	var sel = document.getElementById('typeselection').value;
	if(sel == 'old'){
		$('#newinfo').hide();
		$('#usern').hide();
		$('#emailDiv').show();
		document.getElementById("restn").className = "large-15 medium-15 columns";
	}
	else if(sel == 'new'){
		$('#newinfo').show();
		$('#usern').show();
		$('#emailDiv').show();
		document.getElementById("restn").className = "large-7 medium-7 columns";
		//$(document).foundation();
	}
	else{
		$('#newinfo').hide();
		$('#usern').hide();
		$('#emailDiv').hide();
		document.getElementById("restn").className = "large-15 medium-15 columns";
	}
function searchByCode(){
	var searchValue = $('#code').val();
	$('#SearchResult').remove();
	
	document.body.style.cursor = 'wait';
	$.ajax({
		type: "POST",
		cache: "false",
		url:  pathToRoot+"srv/searchForCode.php",
		data:{
			code: searchValue
		},
		success: function(data){
			$('#searches').after(data);
		},
		error: function(data){
		},
		complete: function(){		
			document.body.style.cursor = 'default';
		}
	});
}