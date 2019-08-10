var INC = "inc/";
var MOD = "html/";
// -----
var ASSET_DIR = "assets/";
var ASSET_JSF = "assets/js/";
var ASSET_CSS = "assets/css/";
var ASSET_PLG = "assets/js/plugins/";
var ASSET_IMG = "assets/images/site/";
var IMG = URL + "assets/img/logo.jpg";
var LOADER_ONE = '<i class="fa fa-spinner fa-fw fa-2x fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
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

$(document).ready(function () {
    $(window).load(function () {
        $('#loader').fadeOut('slow', function () {
            $(this).remove();
        });
    });

    $('html, body').css('overflow-x', 'hidden');
});

