$(document).ready(function (){
	$('#lginBanner').hide();
	$('#clogo').hide();
	$('#lginBanner').fadeIn('slow', function (){
		$('#clogo').fadeIn('slow');
	});
	return true;
});