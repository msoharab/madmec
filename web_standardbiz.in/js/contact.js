// JavaScript Document
var url='http://www.standardbiz.in/contactus.html';

if(window.location.href == 'http://standardbiz.in/contactus.html')
{
	window.location.href = url;
}
function clos()
{
	$("#eq_box").slideDown( 1000) .delay( 200 ).fadeOut( 400 );
}
function send_mail()
{
	var mob = $("#mob").val();
	var email = $("#email").val();
	if(mob && email)
	{
		$("#eq_box").html('<strong style="color:#000000;padding 10px 10px 10px 10px;" >Processing</strong>');
		$.ajax({
				type: "POST",
				url:'http://www.standardbiz.in/sendmail.php',
				data: {sender:email,cellno:mob},
				success: function(data)
				{
					$("#eq_box").html('<strong style="color:#000000; padding 10px 10px 10px 10px;" >'+data+'</strong>');
				}
			});
	}
	else
		alert("Enter correct information!!!");
}
$(document).ready(function(e) {
	$("#eq_box").slideUp( 1000 ).delay( 2000 ).fadeIn( 400 );
    $("#contact").css({backgroundColor:'#FFFFFF',color:'#009900'});
});