function controlCRMFeedBack() {
	var gymid = $(DGYM_ID).attr("name");
	var fb = {};
	this.__construct = function (feed) {
		fb = feed;
		$(fb.tabf).click(function () {
			LoadFeedbackForm();
		});
		$(fb.tab_tot).click(function () {
			load_total_feedback();
		});
		$(fb.tblist).click(function () {
			listFeedback(fb);
		});
		LoadFeedbackForm();
	}
	this.entryfeedback = function (feedback) {
		var FB = feedback;
		var temp = {};
		$(FB.save).click(function () {
			entryfeedback();
		});
		function entryfeedback() {
			for (i = 0; i <= 7; i++) {
				temp[i] = $('input[name=feedback_' + i + ']:checked').val();
			}
			var feed_values = {
				name : $(FB.name).val(),
				complent : $(FB.comp_sugg).val(),
				msg_to : $(FB.msg_to).val(),
			};
			console.log(temp);
			$.ajax({
				url : FB.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'save_feedback',
					type : 'slave',
					gymid : gymid,
					fb : feed_values,
					temp : temp
				},
				success : function (data, textStatus, xhr) {
					console.log(data);
					switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					case 'login':
						loginAdmin({});
						break;
					default:
						if (data) {
							$(FB.feedout).html("<h1>successfully Updated</h1>");
						} else {
							$(FB.feedout).html('<strong class="text-danger">ERROR!!! The recipient you have entered is not registered customer of GYM</strong>');
						}
						break;
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		}
	}
	this.displayFeedBack = function (fb, index) {
		var fb = fb;
		console.log(fb);
		console.log(index);
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'displayFeedBack',
				type : 'slave',
				gymid : gymid,
				fb : fb,
				index : index
			},
			success : function (data) {
				$(fb.showmsg).html(data);
				$("#back_link").click(function () {
					$(fb.showmsg).html("");
					listFeedback(fb);
				});
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				/*console.log(xhr.status);*/
			}
		});
	}
	function listFeedback(fb) {
		$(fb.fout).html(LOADER_SIX);
		$.ajax({
			url : fb.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'loadAllFeedback',
				type : 'slave',
				gymid : gymid,
				fb : fb
			},
			success : function (data, textStatus, xhr) {
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$(fb.fout).html("");
					$(fb.showmsg).html(data);
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				/*console.log(xhr.status);*/
			}
		});
	}
	function LoadFeedbackForm() {
		$(fb.feedout).html(LOADER_SIX);
		$.ajax({
			url : fb.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'LoadFeedbackForm',
				type : 'slave',
				gymid : gymid,
				fb : fb
			},
			success : function (data, textStatus, xhr) {
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$(fb.feedout).html("");
					$(fb.loadf).html(data);
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	}
	function load_total_feedback() {
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'load_total_feedback',
				type : 'slave',
				gymid : gymid
			},
			success : function (data) {
				$("#output_total").html(data);
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				/*console.log(xhr.status);*/
			}
		});
	}
};
