var INC = "inc/";
var MOD = "modules/";
var SUMOD = "superadmin/";
var CUST = "customer/";
// module wise
var INC_MOD = INC + "modules/";
var LOAD_MODULE = URL + INC + "modules.php";
// -----
var ADMIN = "admin/";
var USER = "user/";
var TRAINER = "trainer/";
var DOWNLOADS = "downloads/";
var UPLOADS = "uploads/";
var ASSET_DIR = "assets/";
var ASSET_JSF = "assets/js/";
var ASSET_TAM = "tamboola/";
var ASSET_JS_USER = "a.user/";
var ASSET_JS_TRAINER = "a.trainer/";
var ASSET_JS_MANAGE = "a.manage/";
var ASSET_JS_REPORT = "a.reports/";
var ASSET_JS_STATS = "a.stats/";
var ASSET_JS_ACCOUNTS = "a.accounts/";
var ASSET_CSS = "assets/css/";
var ASSET_IMG = "assets/images/";
var ICON_THEME = "set1/";
var ICON_THEME2 = "set2/";
var LOADER_ONE = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader1.gif" border="0" width="60" height="60" />';
var LOADER_TWO = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader2.gif" border="0" width="25" height="25" />';
var LOADER_THR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader3.gif" border="0" width="25" height="25" />';
var LOADER_FUR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader4.gif" border="0" />';
var LOADER_FIV = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader5.gif" border="0" width="60" height="60" />';
var LOADER_SIX = '<i class="fa fa-spinner fa-fw fa-4x fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
var LOGO_1 = URL + ASSET_IMG + ASSET_TAM + 'logo-1.png';
// var VALIDNOT = '<strong class="text-success">Valid</strong>';
var VALIDNOT = '<strong class="text-success"><i class="fa fa-check-circle fa-fw"></i></strong>';
// var INVALIDNOT = '<strong class="text-danger">Not Valid</strong>';
var INVALIDNOT = '<strong class="text-danger"><i class="fa fa-times-circle-o fa-fw"></i></strong>';
// module wise
var MODULES = {};
var OUTPUT = "#allOutput";
var MOD_CLIENT = URL + INC_MOD + 'client.html';
var MOD_CLUBSELECT = URL + INC_MOD + 'club_select.html';
var MOD_DASHBOARD = URL + INC_MOD + 'club_dashboard.html';
var MOD_APROFILE = URL + INC_MOD + 'admin_profile.html';
//ENQUIRY
var MOD_ENQADD = URL + INC_MOD + 'enquiry_add.html';
var MOD_ENQFLW = URL + INC_MOD + 'enquiry_follow.html';
var MOD_ENQLIST = URL + INC_MOD + 'enquiry_listall.html';
//CUSTOMER
var MOD_CUSTADD = URL + INC_MOD + 'customer_add.html';
var MOD_CUSTLIST = URL + INC_MOD + 'customer_list.html';
var MOD_CUSTIMPT = URL + INC_MOD + 'customer_import.html';
var MOD_GRPADD = URL + INC_MOD + 'group_add.html';
var MOD_GRPLIST = URL + INC_MOD + 'group_list.html';
//trainer
var MOD_TRAADD = URL + INC_MOD + 'trainers_add.html';
var MOD_TRALIST = URL + INC_MOD + 'trainers_list.html';
var MOD_TRAPAY = URL + INC_MOD + 'trainer_pay.html';
var MOD_TRAIMPT = URL + INC_MOD + 'trainers_import.html';
//manage
var MOD_MNGFACILITY = URL + INC_MOD + 'manage_add_facility.html';
var MOD_MNGADDOFR = URL + INC_MOD + 'manage_add_offer.html';
var MOD_MNGLISTOFR = URL + INC_MOD + 'manage_list_offer.html';
var MOD_MNGADDPACK = URL + INC_MOD + 'manage_add_package.html';
var MOD_MNGLISTPACK = URL + INC_MOD + 'manage_list_package.html';
//attendance
var MOD_MNGATTEN = URL + INC_MOD + 'attendance.html';
//account
var MOD_ACCPACKFEE = URL + INC_MOD + 'acc_package_fee.html';
var MOD_ACCFCTFEE = URL + INC_MOD + 'acc_facility_fee.html';
var MOD_ACCDUEBAL = URL + INC_MOD + 'acc_due_balance.html';
var MOD_ACCSTFPAY = URL + INC_MOD + 'acc_staff_payment.html';
var MOD_ACCEXP = URL + INC_MOD + 'acc_expenses.html';
//stats
var MOD_STSACC = URL + INC_MOD + 'stats_accounts.html';
var MOD_STSREG = URL + INC_MOD + 'stats_registrations.html';
var MOD_STSTRA = URL + INC_MOD + 'stats_trainers.html';
var MOD_STSCUST = URL + INC_MOD + 'stats_customers.html';
//reprort
var MOD_REPCLUB = URL + INC_MOD + 'report_club.html';
var MOD_REPPACK = URL + INC_MOD + 'report_package.html';
var MOD_REPREG = URL + INC_MOD + 'report_registrations.html';
var MOD_REPPAY = URL + INC_MOD + 'report_payments.html';
var MOD_REPEXP = URL + INC_MOD + 'report_expenses.html';
var MOD_REPBAL = URL + INC_MOD + 'report_balancesheet.html';
var MOD_REPCUST = URL + INC_MOD + 'report_customers.html';
var MOD_REPEMP = URL + INC_MOD + 'report_employee.html';
var MOD_REPREC = URL + INC_MOD + 'report_receipts.html';
//CRM
var MOD_CRMMOB = URL + INC_MOD + 'crm_mobileapp.html';
var MOD_CRMFEED = URL + INC_MOD + 'crm_feedbacks.html';
// -----
var nm_reg = /^[A-Z_a-z\.\'\- ]{3,100}$/;
var number_reg = /[0-9]{1,20}$/;
var number_reg = /[0-9]{1,20}$/;
var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
var numbs = /^[0-9]+$/;
var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var pass_reg = /.{6,100}$/;
var cell_reg = /[7-9][0-9]{9}$/;
var ccod_reg = /[0-9]{2,15}$/;
var tele_reg = /[0-9]{4,20}$/;
var id_reg = /[1-9]{1,20}$/;
var ind_reg = /[0-9]{1,20}$/;
var addline_reg = /.{3,200}$/;
var st_city_dist_cont_reg = /.{3,100}$/;
var prov_reg = /.{3,150}$/;
var url_reg = '^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?';
var DGYM_ID = "#printrs";
var GYMNAME = "Tamboola";
var REG_FEE = 500;
var START_DATE = "2014-02-03";
var ST_PER = 0.1400;
var CURRENCY_SYM_2X = "<i class='fa fa-inr fa-2x'></i>";
var CURRENCY_SYM_3X = "<i class='fa fa-inr fa-3x'></i>";
var CURRENCY_SYM_4X = "<i class='fa fa-inr fa-4x'></i>";
var CURRENCY_SYM_5X = "<i class='fa fa-inr fa-5x'></i>";
var GYM_LOGO = URL.ASSET_IMG + "short-logo.jpg";
/* Customer constraints */
var Customer = URL + ASSET_IMG + ICON_THEME2 + "anonymous.png";
/* Admin constraints */
var Administrator = URL + ASSET_IMG + ICON_THEME2 + "administrator.png";
/* Trainer constraints */
var Trainer = URL + ASSET_IMG + ICON_THEME2 + "trainer.png";
$.fn.center = function () {
	this.css("position", "absolute");
	this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
			$(window).scrollTop()) + "px");
	this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
			$(window).scrollLeft()) + "px");
	return this;
}
function BindScrollEvents() {
	//Make button appear only when scrolled below 100px
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.toTopNav').show(300);
		}
		if ($(this).scrollTop() < 100) {
			$('.toTopNav').hide(400);
		}
		var scrollbartop = $(window).scrollTop();
		// var sidebartop = $('#sidebar').css('top');
		if (scrollbartop == 0) {
			$('#sidebar').css('top', '0px');
		} else if (scrollbartop > 52) {
			$('#sidebar').css('top', Number(scrollbartop * 0.010) + 'px')
		}
	});
}
function loginAdmin(para) {
	console.log("I am here");
	location.replace(LAND_PAGE);
}
function logoutAdmin(para) {
	console.log("called function");
	location.replace(URL);
}
function auto_fit_screen() {
	// $("#nav-top").css("position","fixed");
	// $("#nav-top").css("width",$(window).width());
	// $(".container").css({top:Number($("#nav-top").innerHeight()),position:"relative",width:$(window).width()});
	// console.log(Number($("#wrapper").innerHeight()));
	// $('#wrapper').css("height",(Number($("#wrapper").innerHeight()) - Number($("#nav-top").innerHeight())));
	// console.log(Number($("#wrapper").innerHeight()));
	// $(".container").css({top:nav_hegit,position:"relative",width:win_width});
	// width:Number(win_width) - (Number(win_width) * 0.2),
	// height:Number(win_heigt) - (Number(win_heigt) * 0.35),
	var nav_hegit = $("#nav-top").innerHeight();
	var win_width = $(window).width();
	var win_heigt = $(window).height();
	if ($(window).width() < 750) {
		// console.log(' style is removed '+$(window).width());
		$("#nav-top").removeAttr("style");
		$(".container").removeAttr("style");
		$("#prep").remove();
	} else {
		$('#nav-top').css({
			position : "fixed",
			width : $(window).width()
		});
		$(".container").css({
			top : nav_hegit,
			position : "relative",
			width : win_width,
			marginLeft : '0px',
			paddingLeft : '0px',
			marginRight : '0px'
		});
		$(".container").prepend('<div id="prep" class="row"><div class="col-lg-12">&nbsp;</div></div>');
	}
	if ($("#light_box").length) {
		$("#light_box").css({
			top : '5px',
			position : "fixed",
			width : Number(win_width),
			height : Number(win_heigt),
			paddingLeft : '10px',
			paddingRight : '10px'
		});
		$(document).bind('keydown', function (event) {
			if (event.keyCode === 13) {
				$('#light_box').remove();
			}
		});
		$('#light_box').find('div').each(function () {
			if ($(this).hasClass("col-lg-8")) {
				$(this).css({
					width : Number(win_width) - (Number(win_width) * 0.1)
				});
			}
		})
	}
}
/*search all module*/
function ShowSearchType(id) {
	$('.ser_crit').each(function () {
		if ($(this).attr('id') == id)
			$(this).show();
		else
			$(this).hide();
	});
};
function searchEnqList() {
	var gymid = $(DGYM_ID).attr("name");
	var cust_email = ($('#cust_email').val().length) ? $('#cust_email').val() : "";
	var cust_name = ($('#cust_name').val().length) ? $('#cust_name').val() : "";
	var cust_no = ($('#cust_no').val().length) ? $('#cust_no').val() : "";
	var enq_day = ($('#enq_day').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#enq_day').val() : "";
	var follow_up = ($('#follow_up').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#follow_up').val() : "";
	if (cust_email.length > 0 || cust_name.length > 0 || cust_no.length > 0 || enq_day.length > 0 || follow_up.length > 0) {
		var spara = {
			cust_email : cust_email,
			cust_name : cust_name,
			cust_no : cust_no,
			enq_day : enq_day,
			follow_up : follow_up
		};
		$("#center_loader").html(LOADER_SIX);
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'search_enq_list',
				type : 'slave',
				gymid : gymid,
				spara : spara
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
					$("#ctEnquiryAllOutput").html(data.htm);
					$("#center_loader").hide();
					break;
				}
			}
		});
	}
};
function searchGroup() {
	var gymid = $(DGYM_ID).attr("name");
	var group_name = ($('#group_name').val() == "") ? "" : $('#group_name').val();
	var owner = ($('#owner').val() == "") ? "" : $('#owner').val();
	var min_mem = ($('#min_mem').val() == "") ? "" : $('#min_mem').val();
	if (group_name.length > 0 || owner.length > 0 || min_mem > 1) {
		$(outputDiv).html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
		$.ajax({
			url : window.location.href,
			type : 'post',
			data : {
				autoloader : 'true',
				action : 'searchGroup',
				type : 'slave',
				gymid : gymid,
				group_name : group_name,
				owner : owner,
				min_mem : min_mem
			}
		}).done(function (data) {
			if (data == 'logout')
				window.location.href = URL;
			else
				$(outputDiv).html(data);
		});
	}
};
function searchPerUser(ap) {
	var gymid = $(DGYM_ID).attr("name");
	$(ap.showmsg).siblings().each(function () {
		$(this).html('');
		$(this).hide();
	});
	var user_name = ($('#user_name').val() == "") ? "" : $('#user_name').val();
	var user_mobile = ($('#user_mobile').val() == "") ? "" : $('#user_mobile').val();
	var user_email = ($('#user_email').val() == "") ? "" : $('#user_email').val();
	if (user_name.length > 1 || user_mobile.length > 1 || user_email.length > 1) {
		$('#output_load').html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
		$.ajax({
			url : window.location.href,
			type : 'post',
			data : {
				autoloader : 'true',
				action : 'searchPerUser',
				type : 'slave',
				gymid : gymid,
				user_name : user_name,
				user_mobile : user_mobile,
				user_email : user_email,
				ap : ap
			}
		}).done(function (data) {
			if (data == 'logout')
				window.location.href = URL;
			else {
				$('#output_load').show();
				$('#output_load').html(data);
			}
		});
	}
};
function searchOffUser(ap) {
	var gymid = $(DGYM_ID).attr("name");
	$(ap.showmsg).siblings().each(function () {
		$(this).html('');
		$(this).hide();
	});
	var offer_opt = ($('#offer_opt').select().val() == "NULL") ? "" : $('#offer_opt').select().val();
	var fct_opt = ($('#fct_opt').select().val() == "NULL") ? "" : $('#fct_opt').select().val();
	var offer_dur = ($('#offer_dur').select().val() == "NULL") ? "" : $('#offer_dur').select().val();
	var offer_min_mem = ($('#offer_min_mem').select().val() == "NULL") ? "" : $('#offer_min_mem').select().val();
	if (offer_opt.length > 0 || fct_opt.length > 0 || offer_dur.length > 0 || offer_min_mem.length > 0) {
		$(outputDiv).html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
		$.ajax({
			url : window.location.href,
			type : 'post',
			data : {
				autoloader : 'true',
				action : 'searchOffUser',
				type : 'slave',
				gymid : gymid,
				offer_opt : offer_opt,
				fct_opt : fct_opt,
				offer_dur : offer_dur,
				offer_min_mem : offer_min_mem,
				ap : ap
			}
		}).done(function (data) {
			if (data == 'logout')
				window.location.href = URL;
			else {
				$('#output_load').show();
				$('#output_load').html(data);
			}
		});
	}
};
function searchPackUser(ap) {
	var gymid = $(DGYM_ID).attr("name");
	var pack_opt = ($('#pack_opt').select().val() == "NULL") ? "" : $('#pack_opt').select().val();
	var pack_ses_opt = ($('#pack_ses_opt').select().val() == "NULL") ? "" : $('#pack_ses_opt').select().val();
	if (pack_opt.length > 0 || pack_ses_opt.length > 0) {
		$(outputDiv).html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
		$.ajax({
			url : window.location.href,
			type : 'post',
			data : {
				autoloader : 'true',
				action : 'searchPackUser',
				type : 'slave',
				gymid : gymid,
				pack_opt : pack_opt,
				pack_ses_opt : pack_ses_opt
			}
		}).done(function (data) {
			if (data == 'logout')
				window.location.href = URL;
			else
				$(outputDiv).html(data);
		});
	}
};
function searchDateUser(ap) {
	var gymid = $(DGYM_ID).attr("name");
	$(ap.showmsg).siblings().each(function () {
		$(this).html('');
		$(this).hide();
	});
	var jnd = ($('#jnd').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#jnd').val() : "";
	//var exd = ($('#exd').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#exd').val() : "";
	if (jnd.length > 1 || exd.length > 1) {
		$('#output_load').html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
		$.ajax({
			url : window.location.href,
			type : 'post',
			data : {
				autoloader : 'true',
				action : 'searchPerUser',
				type : 'slave',
				gymid : gymid,
				jnd : jnd,
				ap : ap
			}
		}).done(function (data) {
			if (data == 'logout')
				window.location.href = URL;
			else {
				$('#output_load').show();
				$('#output_load').html(data);
			}
		});
	}
};
/* Convert Date Format */
function convertDateFormat(val) {
	return moment(val, "DD-MMM-YYYY").format("YYYY-MM-DD")
}
function searchAllUser() {
	var gymid = $(DGYM_ID).attr("name");
	var fields = {
		autoloader : 'true',
		action : 'searchAllUser',
		enq_ser_fup : $('#enq_ser_fup_all').val() ? $('#enq_ser_fup_all').val() : "",
		enq_ser_date : $('#enq_ser_date_all').val() ? $('#enq_ser_date_all').val() : "",
		enq_ser_nam_mob : $('#enq_ser_nam_mob_all').val() ? $('#enq_ser_nam_mob_all').val() : "",
		group_name : $('#group_name_all').val() ? $('#group_name_all').val() : "",
		owner : $('#owner_all').val() ? $('#owner_all').val() : "",
		min_mem : $('#min_mem_all').val() ? $('#min_mem_all').val() : "",
		user_name : $('#user_name_all').val() ? $('#user_name_all').val() : "",
		user_mobile : $('#user_mobile_all').val() ? $('#user_mobile_all').val() : "",
		user_email : $('#user_email_all').val() ? $('#user_email_all').val() : "",
		offer_opt : ($('#offer_opt_all').select().val() != "NULL") ? $('#offer_opt_all').select().val() : "",
		fct_opt : ($('#fct_opt_all').select().val() != "NULL") ? $('#fct_opt_all').select().val() : "",
		offer_dur : ($('#offer_dur_all').select().val() != "NULL") ? $('#offer_dur_all').select().val() : "",
		offer_min_mem : ($('#offer_min_mem_all').select().val() != "NULL") ? $('#offer_min_mem_all').select().val() : "",
		pack_opt : ($('#pack_opt_all').select().val() != "NULL") ? $('#pack_opt_all').select().val() : "",
		pack_ses_opt : ($('#pack_ses_opt_all').select().val() != "NULL") ? $('#pack_ses_opt_all').select().val() : "",
		jnd : $('#jnd_all').val() ? $('#jnd_all').val() : "",
		exd : $('#exd_all').val() ? $('#exd_all').val() : ""
	};
	if (fields.enq_ser_fup || fields.enq_ser_date || fields.enq_ser_nam_mob) {
		fields.enq_ser_fup = (fields.enq_ser_fup.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.enq_ser_fup : "";
		fields.enq_ser_date = (fields.enq_ser_date.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.enq_ser_date : "";
		fields.enq_ser_nam_mob = (fields.enq_ser_nam_mob == "") ? "" : fields.enq_ser_nam_mob;
	}
	if (fields.group_name || fields.owner || fields.min_mem) {
		fields.group_name = (fields.group_name == "") ? "" : fields.group_name;
		fields.owner = (fields.owner == "") ? "" : fields.owner;
		fields.min_mem = (fields.min_mem == "") ? "" : fields.min_mem;
	}
	if (fields.user_name || fields.user_mobile || fields.user_email) {
		fields.user_name = (fields.user_name == "") ? "" : fields.user_name;
		fields.user_mobile = (fields.user_mobile == "") ? "" : fields.user_mobile;
		fields.user_email = (fields.user_email == "") ? "" : fields.user_email;
	}
	if (fields.offer_opt || fields.fct_opt || fields.offer_dur || fields.offer_min_mem) {
		fields.offer_opt = (fields.offer_opt == "NULL") ? "" : fields.offer_opt;
		fields.fct_opt = (fields.fct_opt == "NULL") ? "" : fields.fct_opt;
		fields.offer_dur = (fields.offer_dur == "NULL") ? "" : fields.offer_dur;
		fields.offer_min_mem = (fields.offer_min_mem == "NULL") ? "" : fields.offer_min_mem;
	}
	if (fields.pack_opt || fields.pack_ses_opt) {
		fields.pack_opt = (fields.pack_opt == "NULL") ? "" : fields.pack_opt;
		fields.pack_ses_opt = (fields.pack_ses_opt == "NULL") ? "" : fields.pack_ses_opt;
	}
	if (fields.jnd || fields.exd) {
		fields.jnd = (fields.jnd.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.jnd : "";
		fields.exd = (fields.exd.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.exd : "";
	}
	if (fields.enq_ser_fup.length > 0 || fields.enq_ser_date.length > 0 || fields.enq_ser_nam_mob.length > 0 ||
		fields.group_name.length > 0 || fields.owner.length > 0 || fields.min_mem > 1 ||
		fields.user_name.length > 1 || fields.user_mobile.length > 1 || fields.user_email.length > 1 ||
		fields.offer_opt.length > 0 || fields.fct_opt.length > 0 || fields.offer_dur.length > 0 || fields.offer_min_mem.length > 0 ||
		fields.pack_opt.length > 0 || fields.pack_ses_opt.length > 0 ||
		fields.jnd.length > 1 || fields.exd.length > 1) {
		$(outputDiv).html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
		$.ajax({
			url : window.location.href,
			type : 'post',
			data : fields
		}).done(function (data) {
			if (data == 'logout')
				window.location.href = URL;
			else
				$(outputDiv).html(data);
		});
	}
}
$(document).ready(function () {
	$('#page-loader').hide();
	$('#showMe').show();
	console.log($('#page-loader').attr('display'));
	$("html, body").animate({
		scrollTop : 0
	}, "slow");
	$.ajax({
		type : 'POST',
		url : LOAD_MODULE,
		data : {},
		success : function (data) {
			MODULES = $.parseJSON(data);
			var htm = [
					'<h2>Tamboola</h2><ul class="timeline"><li><div class="timeline-badge primary"><img src="' + LOGO_1 + '" class="img-circle" width="50"/>',
					'</div><div class="timeline-panel"><div class="timeline-heading"><h4 class="timeline-title">What is Tamboola?</h4></div>',
					'<div class="timeline-body text-justify"><p>Tamboola is a Club / Gym management system with sophisticated features which provides ease of use to the customer and the administrator of Clubs / Gym.</p>',
					'<p>This system includes three mobile applications for our clients.<br />Admin / Owner application.<br />Trainer application. <br />Customer application. <br />',
					'All these three applications are inter-connected via cloud.<br /></p></div></div></li><li class="timeline-inverted"><div class="timeline-badge info">',
					'<img src="' + LOGO_1 + '"  class="img-circle" width="50"/></div><div class="timeline-panel"><div class="timeline-heading"><h4 class="timeline-title">',
					'Is it useful to your business?</h4></div><div class="timeline-body text-justify"><p>Tamboola is profit maximization of your business through effective management, flawless ',
					'relation building, advertisement and much more. This is a first of a kind Gym management  system introduced in India.</p></div></div></li></ul>'
			];
			$(OUTPUT).html(htm.join(''));
		}
	});
	BindScrollEvents();
	if (window.location.href == 'http://tamboola.com/')
		window.location.href = 'http://www.tamboola.com/';
});
