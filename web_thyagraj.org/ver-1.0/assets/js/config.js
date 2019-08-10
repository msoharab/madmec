var INC = 'inc/';
var ADMIN = 'admin/';
var EMPLY = 'employee/';
var INC_ADM = INC + ADMIN;
var INC_EMP = INC + EMPLY;
var CLASSES = 'classes/';
var DOWNLOADS = 'downloads/';
var UPLOADS = 'uploads/';
var ASSET_DIR = 'assets/';
var ASSET_JSF = 'assets/js/';
var ASSET_CSS = 'assets/css/';
var ASSET_IMG = 'assets/images/';
var ASSET_JQF = 'jQuery/';
var ASSET_BSF = 'bootstrap/';
var ASSET_PLG = 'plugins/';
var ADM_JS = 'admin/';
var EMP_JS = 'employee/';
var FONT_1 = 'font-awesome-4.1.0/';
var FONT_2 = 'font-awesome-4.2.0/';
var FONT_3 = 'font-awesome-4.4.0/';
var FONT_4 = 'fonts-ionicons-1.4.0/';
var ASSET_THM = 'AdminLTHEME/';
var LOAD_MODULE = URL + "inc/modules.php";
var LOADER_ONE = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader1.gif" border="0" width="60" height="60" />';
var LOADER_TWO = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader2.gif" border="0" width="25" height="25" />';
var LOADER_THR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader3.gif" border="0" width="25" height="25" />';
var LOADER_FUR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader4.gif" border="0" />';
var LOADER_FIV = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader5.gif" border="0" width="60" height="60" />';
var LOADER_SIX = '<i class="fa fa-spinner fa-fw fa-4x fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
var LOGO = URL + ASSET_IMG + 'logo.png';
var VALIDNOT = '<strong class="text-success"><i class="fa fa-check-circle fa-fw"></i></strong>';
var INVALIDNOT = '<strong class="text-danger"><i class="fa fa-times-circle-o fa-fw"></i></strong>';
var MODULES = {};
var OUTPUT = "#allOutput";
var nm_reg = /^[A-Z_a-z\.\'\- ]{3,100}$/;
var cell_reg_new = /[0-9]{10,20}$/;
var email_reg_new = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var number_reg = /[0-9]{1,20}$/;
var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
var numbs = /^[0-9]+$/;
var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var pass_reg = /.{3,100}$/;
var cell_reg = /[7-9][0-9]{9}$/;
var ccod_reg = /[0-9]{2,15}$/;
var tele_reg = /[0-9]{4,20}$/;
var id_reg = /[1-9]{1,20}$/;
var ind_reg = /[0-9]{1,20}$/;
var addline_reg = /.{3,200}$/;
var st_city_dist_cont_reg = /.{3,100}$/;
var prov_reg = /.{3,150}$/;
var url_reg = '^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?';
var START_DATE = "2014-02-03";
function loginAdmin(para) {
    location.replace(LAND_PAGE);
}
function logoutAdmin(para) {
    location.replace(URL);
}
function convertDateFormat(val) {
    return moment(val, "DD-MMM-YYYY").format("YYYY-MM-DD")
}
var loadJavaScript = function (src) {
    var jsSRC = $("<script type='text/javascript' src='" + src + "'>");
    $(OUTPUT).append(jsSRC);
};
var setActive = function (obj, set) {
    $(obj).parent().siblings().each(function () {
        $(this).removeClass('active');
    });
    if($(obj).parent().prop("tagName") === 'DIV'){
        $($(obj).prop("id")).parent().siblings().each(function () {
            $(this).removeClass('active');
        });
        $($(obj).prop("id")).parent().attr('class', 'active');
    }
    else{
        $(obj).parent().attr('class', 'active');
    }
};
$(document).ready(function () {
    $("html, body").animate({
        scrollTop: 0
    }, "slow");
    $.ajax({
        type: 'POST',
        url: LOAD_MODULE,
        async: false,
        data: {},
        success: function (data) {
            if (data) {
                MODULES = $.parseJSON(data);
                $(OUTPUT).append(MODULES.dash);
            }
            $('#page-loader').hide();
            $('#showme').show();
        }
    });
});
