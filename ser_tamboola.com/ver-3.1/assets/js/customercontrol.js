var loader = "#centerLoad";
var email_reg_new = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var cell_reg_new = /[0-9]{10,20}$/;
/* Binding the Menu Links  */
$(document).ready(function () {
    loadJavaScript = function (src) {
        var jsSRC = $("<script type='text/javascript' src='" + src + "'>");
        $(OUTPUT).append(jsSRC);
    };
    var mainpage = {
        leftbuttons: '.atleftmenu',
        prefiex: '#p',
        defaultView: '#pgym',
        outputDiv: '#output',
    };
    var navigation = {
        serach: "#custsearch",
    };
    $(navigation.serach).click(function () {
        $(OUTPUT).html($.trim(MODULES.custsearchgym));
        var attr = {
            searchgym: '#searchgym',
            gymid : 0,
            displaygymdetails : '#displaygymdetails',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + CUST + "customerApp.js");
        var obj = new customerApp();
        obj.__construct(attr);
    });
});