function indexPage() {
	/* Constructor */
	var members = {
		signIn: '',
		singUp: '',
		list: '',
		outputDiv: '',
		className: '',
		currDiv: '',
		response: '',
	};
	var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
	var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
	var pass_reg = /.{6,100}$/;
	this.__constructor = function(para) {
		members.signIn = para.signIn;
		members.singUp = para.singUp;
		members.list = para.list;
		members.outputDiv = para.outputDiv;
		members.className = para.className;
		window.setTimeout(function(){
			loadGymList();
			initializePage();
			fetchListofGyms();
		},3000);
	};
	function scrollTOP(pos){
		$("html, body").animate({
			scrollTop: pos
		}, "slow");
	}
	function initializePage() {
		$(members.className).each(function() {
			var temp = $(this).text();
			members.currDiv = temp;
			switch (temp) {
				case 'List':
					$('#a_' + temp).on('click', function() {
						$(members.outputDiv).html('');
						scrollTOP(0);
						loadGymList();
					});
					break;
				case 'SignUp':
					$('#a_' + temp).on('click', function() {
						$(members.outputDiv).html('');
						scrollTOP(0);
						clearSingUpForm();
						initializeSingUp();
					});
					break;
				case 'SignIn':
					$('#a_' + temp).on('click', function() {
						$(members.outputDiv).html('');
						scrollTOP(0);
						clearSingInForm();
						initializeSingIn();
					});
					break;
				case 'Facebook':
					$('#a_' + temp).on('click', function() {
						$(members.outputDiv).html('');
						initializeSingUp();
						var obj = new faceBook();
						obj.__constructor(members);
						statusChange();
					});
					break;
				case 'Google':
					break;
				case 'Linkedin':
					break;
				case 'Yahoo':
					break;
				case 'Pinterest':
					break;
				case 'Twitter':
					break;
			}
		});
	};
	function hideDivs() {
		for (i in members) {
			if (typeof members[i] == 'object') {
				members[i].display = false;
				$(members[i].parentDiv).css({
					display: 'none'
				});
			}
		}
	};
	function clearSingInForm() {
		var signIn = members.signIn;
		$(signIn.email).removeAttr('disabled').val('');
		$(signIn.password).removeAttr('disabled').val('');
		$(signIn.botton).removeAttr('disabled');
	};
	function clearSingUpForm() {
		var singUp = members.singUp;
		$(singUp.name).removeAttr('disabled').val('');
		$(singUp.email).removeAttr('disabled').val('');
		$(singUp.password1).removeAttr('disabled').val('');
		$(singUp.password2).removeAttr('disabled').val('');
		$(singUp.botton).removeAttr('disabled');
	};
	function initializeSingIn() {
		$('.navbar-toggle' + ',' + '.collapse').trigger('click');
		var flag = false;
		var signIn = members.signIn;
		signIn.display = true;
		hideDivs();
		signIn.display = true;
		$(signIn.parentDiv).css({
			display: 'block'
		});
		$(signIn.email).change(function() {
			if ($(signIn.email).val().match(email_reg)) {
				var fields = {
					autoloader: true,
					action: 'checkExistence',
					email: $.trim($(signIn.email).val()),
					msgDiv: signIn.emsg,
					errDiv: members.outputDiv,
					url: signIn.url,
					status: '0'
				};
				checkExistence(fields);
				if (fields.status == '1') {
					flag = true;
					$(signIn.emsg).html('<strong class="text-success">User Exist !!!</strong>');
				} else {
					flag = false;
					$(signIn.emsg).html('<strong class="text-danger">User Does Not Exist !!!</strong>');
				}
			} else {
				flag = false;
				$(signIn.emsg).html('<strong class="text-danger">Not Valid</strong>');
			}
		});
		$(signIn.password).change(function() {
			if ($(signIn.password).val().match(pass_reg)) {
				$(signIn.pmsg).html('<strong class="text-success">Valid</strong>');
				flag = true;
			} else {
				flag = false;
				$(signIn.pmsg).html('<strong class="text-danger">Not Valid</strong>');
			}
		});
		$(signIn.password).on('keyup', function(evt) {
			if (evt.keyCode == 13) {
				$(signIn.botton).trigger('click');
			}
		});
		$(signIn.botton).on('click', function() {
			if (flag) {
				scrollToOutput();
				$(members.outputDiv).html(LOADER_ONE);
				$(signIn.email).attr('disabled', 'disabled');
				$(signIn.password).attr('disabled', 'disabled');
				$(signIn.botton).attr('disabled', 'disabled');
				$.ajax({
					url: signIn.url,
					type: 'POST',
					data: {
						autoloader: true,
						action: 'signIn',
						email: $.trim($(signIn.email).val()),
						password: $(signIn.password).val(),
						browser: navigator.userAgent
					},
					success: function(data) {
						$(members.outputDiv).html(data);
						switch (data) {
							case 'logout':
								logoutAdmin({});
								break;
							case 'login':
								loginAdmin({});
								break;
							case 'success':
								$(members.outputDiv).html('<strong class="text-success">Login successfull !!!</strong>');
								localStorage.setItem("validate", "validate");
								window.setTimeout(function() {
									location.replace(URL + LAND_PAGE);
								}, 800);
								break;
							case 'password':
								$(signIn.pmsg).html('<strong class="text-danger">Password is incorrect !!!</strong>');
								$(signIn.password).removeAttr('disabled', 'disabled');
								break;
							case 'error':
								$(signIn.emsg).html('<strong class="text-danger">Email is incorrect !!!</strong>');
								$(signIn.pmsg).html('<strong class="text-danger">Password is incorrect !!!</strong>');
								$(members.outputDiv).html(LOGN_ERROR);
								clearSingInForm();
								break;
						}
					},
					error: function(data) {
						hideDivs();
						$(members.outputDiv).html(INET_ERROR);
					}
				});
			}
		});
	};
	function initializeSingUp() {
		$('.navbar-toggle' + ',' + '.collapse').trigger('click');
		var singUp = members.singUp;
		var flag = false;
		hideDivs();
		singUp.display = true;
		$(singUp.parentDiv).css({
			display: 'block'
		});
		$(singUp.name).change(function() {
			if ($(singUp.name).val().match(name_reg)) {
				$(singUp.nmsg).html('<strong class="text-success">Valid</strong>');
				flag = true;
			} else {
				flag = false;
				$(singUp.nmsg).html('<strong class="text-danger">Not Valid</strong>');
			}
		});
		$(singUp.email).change(function() {
			if ($(singUp.email).val().match(email_reg)) {
				var fields = {
					autoloader: true,
					action: 'checkExistence',
					email: $(singUp.email).val(),
					msgDiv: singUp.emsg,
					errDiv: members.outputDiv,
					url: singUp.url,
					status: '1'
				};
				checkExistence(fields);
				if (fields.status == '0') {
					flag = true;
					$(singUp.emsg).html('<strong class="text-success">Available</strong>');
				} else {
					$(singUp.emsg).html('<strong class="text-danger">Not Available</strong>');
				}
			} else {
				flag = false;
				$(singUp.emsg).html('<strong class="text-danger">Not Valid</strong>');
			}
		});
		$(singUp.password1).change(function() {
			if ($(singUp.password1).val().match(pass_reg)) {
				$(singUp.p1msg).html('<strong class="text-success">Valid</strong>');
				flag = true;
			} else {
				flag = false;
				$(singUp.p1msg).html('<strong class="text-danger">Not Valid</strong>');
			}
		});
		$(singUp.password2).change(function() {
			if ($(singUp.password2).val().match(pass_reg) && $(singUp.password2).val() === $(singUp.password1).val()) {
				flag = true;
				$(singUp.p2msg).html('<strong class="text-success">Valid</strong>');
			} else {
				flag = false;
				$(singUp.p2msg).html('<strong class="text-danger">Not Valid</strong>');
			}
		});
		$(singUp.botton).on('click', function() {
			if (flag) {
				scrollToOutput();
				$(members.outputDiv).html(LOADER_ONE);
				$(singUp.name).attr('disabled', 'disabled');
				$(singUp.email).attr('disabled', 'disabled');
				$(singUp.password1).attr('disabled', 'disabled');
				$(singUp.password2).attr('disabled', 'disabled');
				$(singUp.botton).attr('disabled', 'disabled');
				$.ajax({
					url: singUp.url,
					type: 'POST',
					data: {
						autoloader: true,
						action: 'signUp',
						name: $(singUp.name).val(),
						email: $(singUp.email).val(),
						password1: $(singUp.password1).val(),
						password2: $(singUp.password2).val()
					},
					success: function(data) {
						console.log(data);
						clearSingUpForm();
						$(members.outputDiv).html(data);
					},
					error: function(data) {
						hideDivs();
						$(members.outputDiv).html(INET_ERROR);
					}
				});
			}
		});
	};
	function loadGymList() {
		$('.navbar-toggle' + ',' + '.collapse').trigger('click');
		var list = members.list;
		hideDivs();
		list.display = true;
		$(list.parentDiv).css({
			display: 'block'
		});
	};
	function fetchListofGyms() {
		var list = members.list;
		$(list.listgyms).html(LOADER_ONE);
		$.ajax({
			url: list.url,
			type: 'POST',
			data: {
				autoloader: true,
				action: 'fetctlistofgyms'
			},
			success: function(data) {
				data = $.trim(data);
				var det = $.parseJSON(data);
				if (det.status == "success") {
					$(list.listgyms).html('<table  class="table table-striped table-bordered table-hover" id="listofgyms-datable"><thead><th>#</th><th>GYM Details</th></thead><tbody>' + det.data + '</tbody></table>');
					window.setTimeout(function() {
						$('#listofgyms-datable').DataTable()
					}, 500);
				} else {
					$(list.listgyms).html('<span class="text-danger"><strong>no record found</strong></span>')
				}
			},
			error: function(data) {
				$(members.outputDiv).html(INET_ERROR);
			}
		});
	};
	function loadNextGymList() {
		var list = members.list;
		$(list.parentDiv).html('<div class="col-lg-8 col-md-offset-2">List the gyms</div>');
	};
	function checkResopnseStatus() {
		statusChange();
	};
	function statusChange() {
		if (members.response) {
			singUp();
		} else {
			window.setTimeout(function() {
				console.log('Not yet received.');
				checkResopnseStatus();
			}, 500);
		}
	};
	function scrollToOutput() {
		var eleoffset = Number($(members.outputDiv).offset().top);
		$("html, body").animate({
			scrollTop: eleoffset
		}, "slow");
	};
}
$(document).ready(function() {
	var signIn = {
		autoloader: true,
		action: 'signIn',
		parentDiv: '#signin',
		form: '#signinform',
		email: '#email',
		emsg: '#email_msg',
		password: '#password',
		pmsg: '#pass_msg',
		botton: '#sigininbut',
		url: URL + 'singin.php',
		display: false
	};
	var singUp = {
		autoloader: true,
		action: 'singUp',
		parentDiv: '#signup',
		form: '#signupform',
		name: '#user_name',
		nmsg: '#name_msg',
		email: '#email_id',
		emsg: '#email_id_msg',
		password1: '#password1',
		p1msg: '#pass1_msg',
		password2: '#password2',
		p2msg: '#pass2_msg',
		botton: '#siginupbut',
		url: URL + 'singup.php',
		display: false
	};
	var list = {
		parentDiv: '#listgym',
		listgyms: '#displaylistofgyms',
		url: URL + 'list.php',
		display: false
	};
	var members = {
		signIn: signIn,
		singUp: singUp,
		list: list,
		outputDiv: '#output',
		className: '.navlink',
		iconBar: '.navbar-toggle',
	};
	var obj = new indexPage();
	obj.__constructor(members);
	$.ajax({
		url: window.location.href,
		type: 'POST',
		data: {
			autoloader: true,
			action: 'updateTraffic'
		},
		success: function(data) {
			$(members.outputDiv).html('Traffic updated');
		},
		error: function(data) {
			$(members.outputDiv).html(INET_ERROR);
		}
	});
	if (localStorage.getItem("validate") == "validate") {
		location.replace(URL + LAND_PAGE);
	}
});