function orderFollow() {
	var enq = {};
	var tf = {};
	var pf = {};
	var exf = {};
	this.__construct = function (enquiry) {
		enq = enquiry;
		tf = enquiry.tflw;
		pf = enquiry.pflw;
		exf = enquiry.exflw;
		$("#" + tf.tab).click(function () {
			DisplayEnquiryToday();
		});
		$("#" + pf.tab).click(function () {
			DisplayEnquiryTodayPending();
		});
		$("#" + exf.tab).click(function () {
			DisplayEnquiryTodayExpired();
		});
		DisplayEnquiryToday();
	};
	function DisplayEnquiryToday() {
		alert("am at Todays Fullowup");
		$(enq.output).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'DisplayOrderFallowUpAll',
				type : 'master',
				list_type : 'today'
			},
			success : function (data) {
				console.dir(data);
				data = $.parseJSON($.trim(data));
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$(enq.output).html(data.htm);
					$(loader).hide();
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
		$(window).scroll(function (event) {
			if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10) {
				UpdateListEnquiry();
			} else {
				$(loader).html('');
			}
		});
	}
	function DisplayEnquiryTodayPending() {
		alert("am at Pending Fullowup");
		$(enq.output).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'DisplayEnquiryAll',
				type : 'master',
				list_type : 'pending'
			},
			success : function (data) {
				data = $.parseJSON($.trim(data));
				console.dir(data);
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$(enq.output).html(data.htm);
					$(loader).hide();
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
		$(window).scroll(function (event) {
			if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10) {
				UpdateListEnquiry();
			} else {
				$(loader).html('');
			}
		});
	}
	function DisplayEnquiryTodayExpired() {
		alert("am at Expired Fullowup");
		$(enq.output).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'DisplayEnquiryAll',
				type : 'master',
				list_type : 'expired'
			},
			success : function (data) {
				console.dir(data);
				data = $.parseJSON($.trim(data));
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$(enq.output).html(data.htm);
					$(loader).hide();
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
		$(window).scroll(function (event) {
			if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10) {
				UpdateListEnquiry();
			} else {
				$(loader).html('');
			}
		});
	}
	function UpdateListEnquiry() {
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'UpdateListFollowup',
				type : 'master'
			},
			success : function (data) {
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$(enq.output).append(data);
					$(loader).hide();
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
};
