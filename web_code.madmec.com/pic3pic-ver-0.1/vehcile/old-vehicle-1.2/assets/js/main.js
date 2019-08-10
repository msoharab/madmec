$(document).ready(function () {
	/* Menu settings*/
	$('#menuToggle, .menu-close').on('click', function () {
		$('#menuToggle').toggleClass('active');
		$('body').toggleClass('body-push-toleft');
		$('#theMenu').toggleClass('menu-open');
	});
	$('.index-menu').click(function () {
		$('html,body').animate({
			scrollTop : $('#' + $.trim($(this).text())).offset().top
		}, 2500);
	});
});
