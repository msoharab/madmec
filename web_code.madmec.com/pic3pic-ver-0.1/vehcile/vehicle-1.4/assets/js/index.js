function indexPage() {
	/* Constructor */
	var members = {
		signIn : '',
		singUp : '',
		list : '',
		outputDiv : '',
		className : '',
		currDiv : '',
		response : ''
	};
	this.__constructor = function (para) {
		members.signIn = para.signIn;
		members.outputDiv = para.outputDiv;
		initializePage();
	};
	function initializePage() {
		clearSingInForm();
		initializeSingIn();
	};
	function clearSingInForm() {
		var signIn = members.signIn;
		$(signIn.uname).removeAttr('disabled').val('');
		$(signIn.password).removeAttr('disabled').val('');
		$(signIn.botton).removeAttr('disabled');
	};
	function initializeSingIn() {
		var flag = false;
		var signIn = members.signIn;
		signIn.display = true;
		$(signIn.parentDiv).css({
			display : 'block'
		});
		$(signIn.uname).change(function () {
			if ($(signIn.uname).val().match(email_reg)) {
				flag = true;
				$(signIn.unmsg).html(VALIDNOT);
			} else {
				flag = false;
				$(signIn.unmsg).html(INVALIDNOT);
			}
		});
		$(signIn.password).change(function () {
			if ($(signIn.password).val().match(pass_reg)) {
				$(signIn.pmsg).html(VALIDNOT);
				flag = true;
			} else {
				flag = false;
				$(signIn.pmsg).html(INVALIDNOT);
			}
		});
		$(document).keypress(function (e) {
			if (e.keyCode == 13) {
				$(signIn.botton).click();
			}
		});
		$(signIn.botton).on('click', function () {
			if (flag) {
				scrollToOutput();
				$(members.outputDiv).html(LOADER_ONE);
				$(signIn.uname).attr('disabled', 'disabled');
				$(signIn.password).attr('disabled', 'disabled');
				$(signIn.botton).attr('disabled', 'disabled');
				$.ajax({
					url : signIn.url,
					type : 'POST',
					data : {
						autoloader : true,
						action : 'signIn',
						user_name : $(signIn.uname).val(),
						password : $(signIn.password).val(),
						browser : navigator.userAgent
					},
					success : function (data, textStatus, xhr) {
						console.log(data);
						data = $.trim(data);
						switch (data) {
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						case 'success':
							$(signIn.pmsg).html(VALIDNOT);
							$("#lock-unlock").addClass('text-success');
							$("#lock-unlock").html('<i class="fa fa-unlock fa-x2 fa-fw"></i>&nbsp;SignIn');
							$(members.outputDiv).html('<strong class="text-success">Login successfull !!!</strong>');
							window.setTimeout(function () {
								location.replace('Vehicle');
								/*                                                                        window.location.href="control.php";*/
							}, 800);
							break;
						case 'password':
							$(signIn.pmsg).html('<strong class="text-danger">Password is incorrect !!!</strong>');
							$(signIn.password).removeAttr('disabled', 'disabled');
							$(members.outputDiv).html(LOGN_ERROR);
							$(signIn.botton).removeAttr('disabled');
							break;
						case 'error':
							$(signIn.unmsg).html('<i class="fa fa-envelope fa-fw"></i>');
							$(signIn.pmsg).html('<i class="fa fa-key fa-fw"></i>');
							$(members.outputDiv).html(LOGN_ERROR);
							clearSingInForm();
							break;
						}
					},
					error : function (data) {
						$(members.outputDiv).html(INET_ERROR);
					},
					complete : function (xhr, textStatus) {
						console.log(xhr.status);
					}
				});
			}
		});
	};
	function scrollToOutput() {
		var eleoffset = Number($(members.outputDiv).offset().top);
		$("html, body").animate({
			scrollTop : eleoffset
		}, "slow");
	};
};
$(document).ready(function () {
	$('#regformm').hide();
	$('#email').change(function () {
		checkEmail(this.value);
	});
	$('#email').mouseup(function () {
		checkEmail(this.value);
	});
	$('#cpassword').change(function () {
		if ($('#regpassword').val() != $('#cpassword').val()) {
			$('#cpassmsgmsg').html('<span class="text-danger"><strong>Password not Matches</strong></span>');
		} else {
			$('#cpassmsgmsg').html('');
		}
	})
	var checkusr = 0;
	var signIn = {
		autoloader : true,
		action : 'signIn',
		parentDiv : '#signin',
		form : '#signinform',
		uname : '#user_name',
		unmsg : '#user_name_msg',
		password : '#password',
		pmsg : '#pass_msg',
		botton : '#sigininbut',
		url : URL + 'singin.php',
		display : false
	};
	var members = {
		signIn : signIn,
		outputDiv : '#output'
	};
	var obj = new indexPage();
	obj.__constructor(members);
	$.ajax({
		url : window.location.href,
		type : 'POST',
		data : {
			autoloader : true,
			action : 'updateTraffic'
		},
		success : function (data, textStatus, xhr) {
			data = $.trim(data);
			switch (data) {
			case 'logout':
				logoutAdmin({});
				break;
			case 'login':
				loginAdmin({});
				break;
			default:
				$(members.outputDiv).html('<center><h1>Welcome To Vehicle</h1></center>');
				break;
			}
		},
		error : function (xhr, textStatus) {
			$(members.outputDiv).html(INET_ERROR);
		},
		complete : function (xhr, textStatus) {
			console.log(xhr.status);
		}
	});
	$('#custreg').click(function () {
		$('#listofgyms').hide();
		$('#regformm').show();
		$('#emmsg').html('');
	});
	function checkEmail(email) {
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'checkemail',
				email : email
			},
			success : function (data, textStatus, xhr) {
				data = $.trim(data);
				if (Number(data)) {
					checkusr = 0;
					$('#emmsg').html('<span class="text-danger"><strong>Email Already Exist</strong></span>');
				} else {
					checkusr = 1;
					$('#emmsg').html('');
				}
			},
			error : function (xhr, textStatus) {
				$(members.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {}
		});
	}

	$('#custregform').submit(function (evt) {
		evt.preventDefault();
		var attr = {
			name : $('#cust_name').val(),
			email : $('#email').val(),
			mobile : $('#cell_numbeb').val(),
			gender : $('#gender').val(),
			pass : $('#cpassword').val(),
		};
		if (!checkusr) {
			$('#email').focus();
			return;
		}
		if ($('#regpassword').val() != $('#cpassword').val()) {
			$('#cpassmsgmsg').html('<span class="text-danger"><strong>Password not Matches</strong></span>');
			return;
		} else {
			$('#cpassmsgmsg').html('');
		}
		if (checkusr) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'custreg',
					details : attr,
				},
				success : function (data, textStatus, xhr) {
					data = $.trim(data);
					if (data == "alreadyexist") {
						$('#emmsg').html('<span class="text-danger"><strong>Email Already Exist</strong></span>');
					} else if (data) {
						$('#custregform').get(0).reset();
						$('#emmsg').html('');
						alert("Registration has been Successfully Completed");
						$('#listofgyms').show();
						$('#regformm').hide();
						$(signIn.uname).focus();
					} else {
						$('#custregform').get(0).reset();
						$('#emmsg').html('');
						alert("Registration hasn't been Completed, Please try After Sometime");
						$('#listofgyms').show();
						$('#regformm').hide();
					}
				},
				error : function (xhr, textStatus) {
					$(members.outputDiv).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {}
			});
		}
	})
});
