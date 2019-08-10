	function sendEmail(counter,loop,fromloop){
		var obj = document.getElementById('fromemail');
		var url,data,name;
		counter = counter * 1;
		loop = loop * 1;
		var tagetemailids = $('#tagetemails').val().split(";");
		if(tagetemailids[loop]){
			$.ajax({
				url:window.location.href,
				data:{
					autoloader:true,
					action:'sendEmail',
					tagetemails:$.trim(tagetemailids[loop]),
					subject:$.trim($('#subject').val()),
					message:$.trim($('#message').val())},
				type:'POST',
				success:function(data){
					window.console.log(data);
					$('#Televeision').append('<br/>'+loop+' =>'+data);
				}
			});
			if(loop < tagetemailids.length){
				loop++;
				counter++;
				setTimeout('sendEmail('+counter+','+loop+',0);',2000);
			}
			else
				throw new Error('Mails have been sent successfullly!!!!!!!');
			var heg = $(document).innerHeight() + counter;
			$('html, body').animate({scrollTop:heg}, 'slow');
		}
	}
	/*
	function sendEmail()
	{
		var url,data,name;
		var formValues = {
							tagetemails:$('#tagetemails').val(),
							subject:$('#subject').val(),
							message:$('#message').val()
						};
		$.ajax({
			url:window.location.href,
			data:{autoloader:true,action:'sendEmail',
					tagetemails:formValues.tagetemails.split(";\n"),
					subject:formValues.subject,
					message:formValues.message},
			type:'POST',
			success:function(data){
				window.console.log(data);
				$('#Televeision').append('<br/>'+data);
				var heg = $(document).innerHeight() * Number(Math.random(99));
				$('html, body').animate({scrollTop:heg}, 'slow');
			}
		});
	}
	*/
	function validateForm()
	{
		var formValues = {
							tagetemails:$('#tagetemails').val(),
							subject:$('#subjecst').val(),
							message:$('#message').val()
						};
		if(formValues.tagetemails != '' && formValues.subject != '' && formValues. message!= '')
			return true;
		else
			return false;
	}
	function ProcessEmails()
	{
		$('#Televeision').html('');
		if(validateForm())
			sendEmail(1,0,0);
		else
			alert('Fill the form properly!!!');
		return;
	}
	$(document).ready(function(){
		$('#submit').attr('onClick','javascript:ProcessEmails();');
	});
