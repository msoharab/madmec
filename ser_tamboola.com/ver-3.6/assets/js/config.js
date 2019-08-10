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
var DIRS = "appDirectories/";
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
var LOADER_SIX = '<i class="fa fa-spinner fa-fw fa-2x fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
var LOGN_PENDING = '<span class="text-warning"><i class="fa fa-hourglass-1 fa-5x"/></i></span>&nbsp;<strong class="text-info">Your Request is Under Process!!!</strong>';
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
function loginAdmin(para) {
    console.log("I am here");
    location.replace(LAND_PAGE);
}
function logoutAdmin(para) {
    console.log("called function");
    location.replace(URL);
}
/* Convert Date Format */
function convertDateFormat(val) {
    return moment(val, "DD-MMM-YYYY").format("YYYY-MM-DD")
}
$(document).ready(function () {
    $('#page-loader').hide();
    $('#showMe').show();
    $("html, body").animate({
        scrollTop: 0
    }, "slow");
    $(OUTPUT).html('<h1>Tamboola ver 3.0 ..' + LOADER_SIX + '</h1>');
    $.ajax({
        type: 'POST',
        url: LOAD_MODULE,
        async: false,
        data: {},
        success: function (data) {
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
    if (window.location.href == 'http://tamboola.com/')
        window.location.href = 'http://www.tamboola.com/';
    //resizeSideBar();
    //$(window).resize(resizeSideBar);
    function resizeSideBar() {
        var hg = $('#nav-top').height();
        if (Number(hg) != 77)
            $('#sidebar').css({top: hg + 'px'});
        else
            $('#sidebar').css({top: '10px'});
        //$('#allOutput').css({top: hg + 'px'});
    }
});
