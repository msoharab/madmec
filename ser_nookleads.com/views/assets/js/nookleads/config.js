//var URL = 'http://nookleads.localmm.com/';
var URL = 'http://www.nookleads.com/';
//var URL = 'http://local.nookleads.com/';
var GPAPI = {};
var gdata = {
    clientId: '44963497708-gpdf4er8498qlpsas10bhncdmuul949a.apps.googleusercontent.com',
    apiKey: 'AIzaSyCfjvo36GuGZ6LMosKQMRTYvWRTc_ZIyq0',
    scopes: 'https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
    id: '',
    name: '',
    email: '',
};
var FBAPI = {};
var fbdata = {
    appId: '457732571094681', // App ID
    apiKey: '2256860e872c127f4767d72139ddf17d', // App Secret
    businessURL: '', // Business File, not required so leave empty
    status: true, // check login status
    cookie: true, // enable cookies to allow the server to access the session
    oauth: true, // enable OAuth 2.0
    xfbml: false, // parse XFBML
    id: '',
    name: '',
    email: '',
};
var LAND_PAGE = 'Deal/';
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
var LOADER_ONE = '<i class="fa fa-spinner fa-fw fa-2x fa-spin"></i>';
var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-2x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-2x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
var VALIDNOT = '<strong class="text-success"><i class="fa fa-check-circle fa-fw"></i></strong>';
var INVALIDNOT = '<strong class="text-danger"><i class="fa fa-times-circle-o fa-fw"></i></strong>';
var DIRS = 'appDirectories/';
var LIBS = 'libs/';
var CONTROLLERS = 'controllers/';
var JSONS = 'jsons/';
var MODELS = 'models/';
var VIEWS = 'views/';
var ASSSET = 'assets/';
var ASSSET_JSF = 'assets/js/';
var ASSSET_PIC = 'assets/js/nookleads/';
var INC = 'inc/';
var OUTPUT = '';
var nookleads = {
    Geography: {},
    Languages: {},
    Sections: {},
    Index: {},
    Deal: {},
    Business: {},
    Lead: {},
    Quotations: {},
    Wos: {},
    Profile: {},
    imgTypes: 'image/png, image/gif, image/jpeg, image/pjpeg',
};
function loadJavaScript(src) {
    var jsSRC = $('<script type="text/javascript" src="' + src + '">');
    $('body').append(jsSRC);
}
function loginAdmin(para) {
    console.log('I am in loginAdmin' + para);
    location.replace(URL);
}
function logoutAdmin(para) {
    console.log('I am in logoutAdmin' + para);
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
            console.log(xhr.responseText);
            console.log(textStatus);
        },
        complete: function (xhr, textStatus) {
            console.log(xhr.status);
        }
    });
    return target;
}
function generateRandomString(length) {
    if (length == null || !length || length == 'undefined')
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
function buildHTML() {
    var mem = {};
    var select = {};
    var checkbox = {};
    var radio = {};
    this.__constructor = function (para) {
        console.log(para);
        mem = para;
    };
    this.publicSelect = function () {
        return buildSelect();
    };
    this.publicCheckBox = function () {
        return buildCheckBox();
    };
    this.publicRadio = function () {
        return buildRadio();
    };
    function buildSelect() {
        $('#' + mem.id).remove();
        if (mem.multiple)
            return '<div class="col-lg-12">&nbsp;</div><div class="col-lg-12"><div class="input-group">' +
                    '<span class="input-group-addon" id="basic-addon1">' + mem.label + '</span>' +
                    '<select class="form-control" id="' + mem.id + '" name="' + mem.name + '" required="" multiple="multiple"><option value="">' + mem.label + '</option>' + mem.html +
                    '</select>' +
                    '</div>' +
                    '</div>';
        else
            return '<div class="col-lg-12">&nbsp;</div><div class="col-lg-12"><div class="input-group">' +
                    '<span class="input-group-addon" id="basic-addon1">' + mem.label + '</span>' +
                    '<select class="form-control" id="' + mem.id + '" name="' + mem.name + '" required=""><option value="">' + mem.label + '</option>' + mem.html +
                    '</select>' +
                    '</div>' +
                    '</div>';
    }
    ;
    function buildCheckBox() {
    }
    ;
    function buildRadio() {
    }
    ;
}
function walk(obj) {
    var flag = true;
    for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
            var val = obj[key];
            console.log(val);
            walk(val);
            flag = true;
        }
        else {
            flag = false;
            break;
        }
    }
    return flag;
}
$(document).ready(function () {
    $('#logoutPic3pic').click(function () {
        sessionStorage.clear();
        FBAPI = {};
        GPAPI = {};
        window.location.href = URL + 'Logout';
    });
});
