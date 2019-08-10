
var LAND_PAGE = URL + "app.php";
var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
var pass_reg = /.{6,100}$/;
var accn_reg = /[0-9]{5,100}$/;
var cell_reg = /^[1-9]+[0-9]{9,20}$/;
var numbs = /^[0-9]+$/;
var amount_reg = /^[1-9]+[0-9]*$/;
var ccod_reg = /[0-9]{1,15}$/;
var tele_reg = /^[1-9]+[0-9]{5,20}$/;
var id_reg = /^[1-9]+[0-9]{1,20}$/;
var ind_reg = /[0-9]{1,20}$/;
var namee_reg = /^[a-zA-Z]+(\s[a-zA-Z]+)*$/;
// var deci_reg=/^[0-9]+(?:\.[0-9])?$/;
var deci_reg = /^(-?)[0-9]+\.[0-9]$/;

var ASSET_DIR = "assets/";
var ASSET_JSF = "assets/js/";
var JSF_jQUERY = "jquery/";
var ASSET_CSS = "assets/css/";
var ASSET_IMG = "assets/img/";

var LOADER_ONE = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader1.gif" border="0" width="60" height="60" />';
var LOADER_TWO = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader2.gif" border="0" width="25" height="25" />';
var LOADER_THR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader3.gif" border="0" width="25" height="25" />';
var LOADER_FUR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader4.gif" border="0" />';
var LOADER_FIV = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader5.gif" border="0" width="60" height="60" />';
var LOADER_SIX = '<i class="fa fa-spinner fa-fw fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
var VALIDNOT = '<strong class="text-success">Valid</strong>';
var INVALIDNOT = '<strong class="text-danger">Not Valid</strong>';
var ALREADYEXIST = '<strong class="text-danger">ALREADYEXIST</strong>';

function loginAdmin(para) {
    window.location.href = LAND_PAGE;
}
function logoutAdmin(para) {
    window.location.href = URL;
}
