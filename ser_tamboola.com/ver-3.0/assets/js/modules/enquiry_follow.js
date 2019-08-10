function controlEnquiryFollow() {
	enq = {};
	tf = {};
	pf = {};
	exf = {};
	var gymid = $(DGYM_ID).attr("name");
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
		$(enq.output).html(LOADER_SIX);
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'DisplayEnquiryAll',
				type : 'slave',
				gymid : gymid,
				list_type : 'today'
			},
			success : function (data) {
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
		$(enq.output).html(LOADER_SIX);
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'DisplayEnquiryAll',
				type : 'slave',
				gymid : gymid,
				list_type : 'pending'
			},
			success : function (data) {
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
	function DisplayEnquiryTodayExpired() {
		$(enq.output).html(LOADER_SIX);
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'DisplayEnquiryAll',
				type : 'slave',
				gymid : gymid,
				list_type : 'expired'
			},
			success : function (data) {
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
		$(loader).html(LOADER_SIX);
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'UpdateListEnquiry',
				type : 'slave',
				gymid : gymid
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
