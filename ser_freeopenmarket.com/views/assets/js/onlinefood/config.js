//var URL = 'http://onlinefood.localmm.com/';
var URL = 'http://freeopenmarket.madmec.com/';
var gogobj = {};
var gdata = {
    clientId: '179415883276-p1okccrd6namf73lvdgg9nbeh0r4a9pm.apps.googleusercontent.com',
    apiKey: 'AIzaSyD4GDVJY0WraYQsiDugmPcOgkEDK2FqFIM',
    scopes: 'https://www.googleapis.com/auth/plus.me',
    id: '',
    name: '',
    email: '',
};
var FBAPI = {};
var fbdata = {
    appId: '1513194189001559', // App ID
    apiKey: '4b6afdd51ac409e9a9dba7832494f2ab', // App Secret
    channelURL: '', // Channel File, not required so leave empty
    status: true, // check login status
    cookie: true, // enable cookies to allow the server to access the session
    oauth: true, // enable OAuth 2.0
    xfbml: false, // parse XFBML
    id: '',
    name: '',
    email: '',
};
var LAND_PAGE = 'Wall/';
var nm_reg = /^[A-Z_a-z\.\'\- 0-9]{4,100}$/;
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
var LOADER_ONE = '<i class="fa fa-spinner fa-fw fa-2x fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-2x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-2x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
var VALIDNOT = '<strong class="text-success"><i class="fa fa-check-circle fa-fw"></i></strong>';
var INVALIDNOT = '<strong class="text-danger"><i class="fa fa-times-circle-o fa-fw"></i></strong>';
var DIRS = 'appDirectories/';
var LIBS = 'libs/';
var CONTROLLERS = 'controllers/';
var MODELS = 'models/';
var VIEWS = 'views/';
var ASSSET = 'assets/';
var ASSSET_JSF = 'assets/js/';
var ASSSET_REG = 'assets/js/recharge/';
var ASSSET_PLG = 'assets/plugins/';
var INC = 'inc/';
var OUTPUT = '';
var PLG_01 = "bootstrap-slider/";
var PLG_02 = "bootstrap-wysihtml5/";
var PLG_03 = "chartjs/";
var PLG_04 = "ckeditor/";
var PLG_05 = "colorpicker/";
var PLG_06 = "datatables/";
var PLG_07 = "datepicker/";
var PLG_08 = "daterangepicker/";
var PLG_09 = "fancybox/";
var PLG_10 = "fastclick/";
var PLG_11 = "flot/";
var PLG_12 = "fullcalendar/";
var PLG_13 = "iCheck/";
var PLG_14 = "input-mask/";
var PLG_15 = "ionslider/";
var PLG_16 = "jQuery/";
var PLG_17 = "jQuery-File-Upload-9.10.4/";
var PLG_18 = "jQueryUI/";
var PLG_19 = "jvectormap/";
var PLG_20 = "knob/";
var PLG_21 = "morris/";
var PLG_22 = "pace/";
var PLG_23 = "picedit/";
var PLG_24 = "select2/";
var PLG_25 = "slimScroll/";
var PLG_26 = "sparkline/";
var PLG_27 = "timepicker/";
var PLG_28 = "facebook/";
var PLG_29 = "googleplus/";

function loadJavaScript(src) {
    var jsSRC = $('<script type="text/javascript" src="' + src + '">');
    $('body').append(jsSRC);
}
function loginAdmin(para) {
    LogMessages('I am in loginAdmin' + para);
    location.replace(URL);
}
function logoutAdmin(para) {
    LogMessages('I am in logoutAdmin' + para);
    location.replace(URL);
}
function getJSONIds(mem) {
    var target = false;
    var obj = {};
    $.ajax({
        url: mem.url,
        type: mem.type,
        dataType: mem.dataType,
        async: false,
        data: {
            autoloader: mem.autoloader,
            action: mem.action,
            details: mem
        },
        success: function (data, textStatus, xhr) {
            if (typeof data === 'object') {
                obj = data;
            }
            else {
                obj = $.parseJSON($.trim(data));
            }
            if (obj.status === "success") {
                target = obj.JSON;
            }
            else {
                target = obj;
            }
        },
        error: function (xhr, textStatus) {
            LogMessages(xhr.responseText);
            LogMessages(textStatus);
        },
        complete: function (xhr, textStatus) {
            LogMessages(xhr.status);
        }
    });
    return target;
}
function generateRandomString(length) {
    if (length === null || !length || length === 'undefined')
        length = 6;
    var i = 0;
    //var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
    var chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    //var chars = '0123456789madmec';
    var result = '';
    for (var i = length; i > 0; --i)
        result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}
function LogMessages(msg) {
    if (console) {
        //LogMessages(msg);
    }
}
function formatRepo(repo) {
    if (repo.loading)
        return repo.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__avatar'><img src='" + repo.avatar_url + "' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + repo.name + "</div>";
    if (repo.description) {
        markup += "<div class='select2-result-repository__description'>" + repo.email + ", " + repo.cell + "</div>";
    }
    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks' style='color:#000000;'> " + repo.ch_count + " Outstating,&nbsp;</div>" +
            "<div class='select2-result-repository__stargazers' style='color:#000000;'> " + repo.p_count + " Orders,&nbsp;</div>" +
            "<div class='select2-result-repository__watchers' style='color:#000000;'> " + repo.pc_count + " Purchase,&nbsp;</div>" +
            "<div class='select2-result-repository__watchers' style='color:#000000;'> " + repo.pcr_count + " Sales,&nbsp;</div>" +
            "</div>" +
            "</div></div>";
    return markup;
}
function formatRepoSelection(repo) {
    return repo.full_name || repo.text;
}
