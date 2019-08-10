	function sendEmail(counter,loop,fromloop){
		var fromArray = new Array();
		var obj = document.getElementById('fromemail');
		var url,data,name;
		for(k=0;k<obj.length;k++)
				fromArray[k] = obj.options[k].text;
		counter = counter * 1;
		loop = loop * 1;
		var formValues = {
							fromemail:fromArray[fromloop],
							tagetemails:$('#tagetemails').val(),
							subject:$('#subject').val(),
							message:$('#message').val()
						};
		var tagetemailids = formValues.tagetemails.split(";");
		// console.log(tagetemailids);
		if(tagetemailids[loop] && fromArray[fromloop]){
			// $('#Televeision').append('<br/><center>'+fromArray[fromloop]+' => '+tagetemailids[loop]+'</center>');
			// $('#Televeision').append('<br/>Pass :: '+fromArray[fromloop]);
			// window.console.log(fromArray[fromloop]);
			// var heg = $(document).height() + counter;
			if ($('#automate_reg').is(':checked') == true) {
				name = tagetemailids[loop].split("@");
				url = 'http://www.madmec.com/ajax/registration/AutomateRegistration.php';
				data = {
					  fromemail:$.trim(fromArray[fromloop]),
					  email:tagetemailids[loop],
					  signin:'true',
					  eid:tagetemailids[loop],
					  uname:name[0],
					  pass:'temptemp',
					  gen:'unknown',
					  subject:encodeURIComponent(formValues.subject),
					  message:encodeURIComponent(formValues.message)
					};
			} 
			else if ($('#apology').is(':checked') == true){
				name = tagetemailids[loop].split("@");
				url = 'http://www.madmec.com/ajax/registration/ApologyMessage.php';
				data = {
					  fromemail:$.trim(fromArray[fromloop]),
					  action:'apology',
					  subject:encodeURIComponent(formValues.subject),
					  message:encodeURIComponent(formValues.message)
					};
			} 
			else {
				url = 'mail.php';
				data = {
					  submit:'submit',
					  fromemail:$.trim(fromArray[fromloop]),
					  tagetemailid:encodeURIComponent(tagetemailids[loop]),
					  subject:encodeURIComponent(formValues.subject),
					  message:encodeURIComponent(formValues.message)
					};
			}
			// $('#Televeision').append('<br/>'+ data.fromemail +' --- '+url);
			$.ajax({
				url:url,
				data:data,
				type:'POST',
				success:function(data)
				{
					window.console.log(data);
					$('#Televeision').append('<br/>'+data);
				}
			});
			if(fromloop < obj.length)
			{
				fromloop++;
			}
			else
			fromloop = 0;
			if(loop < tagetemailids.length){
				loop++;
				counter++;
				setTimeout('sendEmail('+counter+','+loop+','+fromloop+');',8300);
			}
			else
				throw new Error('Mails have been sent successfullly!!!!!!!');
			// window.console.log(tagetemailids[loop]);
			// $('#Televeision').append('<br/>Pass :: '+tagetemailids[loop]);
			var heg = $(document).innerHeight() + counter;
			$('html, body').animate({scrollTop:heg}, 'slow');
		}
	}
	function validateForm(){
		var formValues = {
							fromemail:returnFromemail('fromemail'),
							tagetemails:$('#tagetemails').val(),
							subject:$('#subjecst').val(),
							message:$('#message').val()
						};
		if(formValues.fromemail != '' && formValues.tagetemails != '' && formValues.subject != '' && formValues. message!= '')
			return true;
		else
			return false;
	}
	function ProcessEmails(){
		$('#submit').val('Restart');
		//string processing
		$('#Televeision').html('');
		if(validateForm())
			sendEmail(1,0,0);
		else
			alert('Fill the form properly!!!');
		return;
	}
	function returnFromemail(id){
		var obj = document.getElementById(id);
		if(obj.options[obj.selectedIndex].value != '')
			return obj.options[obj.selectedIndex].text;
		else 
			return '';
	}
	$(document).ready(function(){
		$('#submit').attr('onClick','javascript:ProcessEmails();');
		$('#stop').attr('onClick',function(){
			$(document).ajaxStop(function(){
				$('#submit').val('Continue');
			});
		});
	});