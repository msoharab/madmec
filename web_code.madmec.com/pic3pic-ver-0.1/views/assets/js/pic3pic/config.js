// var URL = 'http://pic3pic.localmm.com/';
var URL = 'http://code.madmec.com/';
var LAND_PAGE = 'Wall';
var nm_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
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
var LOADER_ONE = '<i class:"fa fa-spinner fa-fw fa-2x fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-2x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-2x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
var VALIDNOT = '<strong class="text-success"><i class="fa fa-check-circle fa-fw"></i></strong>';
var INVALIDNOT = '<strong class="text-danger"><i class="fa fa-times-circle-o fa-fw"></i></strong>';
function loginAdmin(para) {
    console.log("I am in loginAdmin" + para);
    location.replace(URL);
}
function logoutAdmin(para) {
    console.log("I am in logoutAdmin" + para);
    location.replace(URL);
}
