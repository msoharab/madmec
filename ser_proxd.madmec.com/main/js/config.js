// global variables //

//URL = 'http://local.prox.dental.madmec.com/';
URL = 'http://local.proxtest.com/';

Loader = URL+'assets/img/loader.gif';

$(document).ready(function(){
	if($(document).width() <= 750 )
		$('#nav_div').addClass('collapse');
	else
		$('#nav_div').removeClass('collapse');
	$(window).resize(function(){
		if($(document).width() <= 750 )
		$('#nav_div').addClass('collapse');
	else
		$('#nav_div').removeClass('collapse');
	});
});