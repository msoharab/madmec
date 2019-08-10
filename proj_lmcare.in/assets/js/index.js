$(document).ready(function (){
    if(localStorage.getItem("doctor")=="doctor")
    window.location.href="doctor.html";
    if(localStorage.getItem("patient")=="patient")
    window.location.href="patient.html";
    if(localStorage.getItem("pharmacy")=="pharmacy")
    window.location.href="pharmacy.html";
    if(localStorage.getItem("diagnostics")=="diagnostics")
    window.location.href="diagnostic.html";
    if(localStorage.getItem("superadmin")=="superadmin")
    window.location.href="superadmin.html";
    $('#sigInSubmit').click(function (){
        if($('#emalid').val()=="")
        {
           $('#emalid').focus() ;
           return;
        }
        if($('#password').val()=="")
        {
           $('#password').focus() ;
           return;
        }
         var attr={
        username : $('#emalid').val(),
        password : $('#password').val()
    }
        $('#errormsg').html(LOADER);
        $.ajax({
                url: AJAX,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'verifyuser',
                singindata  : attr
		},
		success: function(data, textStatus, xhr) {
               console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var details=$.parseJSON(data);
                    if(details.aunth){
                    if(details.status_id== '12' )
                    {
                    $('#errormsg').html('<strong class="text-danger">Your Account is Inactive Kindly Please contact Service Provider</strong>') ;
                    break;
                    }
                    if(Number(details.status_id)== 19 )
                    {
                    $('#errormsg').html('<strong class="text-danger">Your Account Avtivation Request is under Process</strong>') ;
                    break;
                    }
                    if(Number(details.userdata.user_type) == 1)
                    {
                    $('#agreement').html(docaggrement);
                    $('#lmcarelogin').hide();
                    $('html, body').animate({
					scrollTop: Number($('#confirmagreedoc').offset().top) - 95
				}, 'slow');
                    window.setTimeout(function (){
                        $('#docagreeyes').click(function (){
                            localStorage.setItem("doctor","doctor");    
                            window.location.href="doctor.html";
                        });
                        $('#docagreeno').click(function (){
                            window.location.href="index.html";
                        });
                    });
                    }
                    else if(Number(details.userdata.user_type) == 2)
                    { 
                   $('#agreement').html(patientaggre);
                    $('#lmcarelogin').hide();
                    $('html, body').animate({
					scrollTop: Number($('#confirmagreepat').offset().top) - 95
				}, 'slow');
                    window.setTimeout(function (){
                        $('#patientagreeyes').click(function (){
                            localStorage.setItem("patient","patient");    
                            window.location.href="patient.html";
                        });
                        $('#patientagreeno').click(function (){
                            window.location.href="index.html";
                        });
                    });
                    }
                    else if(Number(details.userdata.user_type) == 3)
                    {
                    $('#agreement').html(pharmacyaggre);
                    $('#lmcarelogin').hide();
                    $('html, body').animate({
					scrollTop: Number($('#confirmagreephar').offset().top) - 95
				}, 'slow');
                    window.setTimeout(function (){
                        $('#pharmacyagreeyes').click(function (){
                            localStorage.setItem("pharmacy","pharmacy");    
                             window.location.href="pharmacy.html";
                        });
                        $('#pharmacyagreeno').click(function (){
                            window.location.href="index.html";
                        });
                    });
                    
                    }
                    else if(Number(details.userdata.user_type) == 4)
                    {
                    $('#agreement').html(diagnosticaggre);
                    $('#lmcarelogin').hide();
                    $('html, body').animate({
					scrollTop: Number($('#confirmagreediag').offset().top) - 95
				}, 'slow');
                    window.setTimeout(function (){
                        $('#diagnosticagreeyes').click(function (){
                        localStorage.setItem("diagnostics","diagnostics");    
                        window.location.href="diagnostic.html";
                        });
                        $('#diagnosticagreeno').click(function (){
                            window.location.href="index.html";
                        });
                    });
                     
                    }
                    else
                    {
                    localStorage.setItem("superadmin","superadmin");    
                    window.location.href="superadmin.html";    
                    }
                    localStorage.setItem("name",details.userdata.name);
//                    document.getElementById("displaydocname").innerHTML='Dr. '+localStorage.getItem("name");
                }
                else
                {
                   $('#errormsg').html('<strong class="text-danger">Username or Password incorrect</strong>')
                }
		break;
			}
                    },
                error: function() {
//		$(colls.outputDiv).html(INET_ERROR);
			},
		complete: function(xhr, textStatus) {
			}
				});
    })
	$('#reset_from_a').click(function (){
		$("#reset_form").css("display","block");
	})
	$('#close_form').click(function (){
		$("#reset_form").css("display","none");
	})
	$('#send_email').click(function (){
		var email = $("#re_email").val();
		$.ajax({
            url: AJAX,
            type: 'POST',
			data:{action : 'send_email','email':email},
			success: function(data) {
				//alert(data);
				$("#reset_src").html(data);
			}
		});
	})
});


