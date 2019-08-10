
var loader = "#centerLoad";
var email_reg_new = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var cell_reg_new = /[0-9]{10,20}$/;

/* Binding the Menu Links  */
$(document).ready(function () {
    var mainpage = {
        leftbuttons: '.atleftmenu',
        prefiex: '#p',
        defaultView: '#pgym',
        outputDiv: '#output',
    };
    var leftbuttons = {
        home: '#home',
        one: '#Vehicle',
        two: '#Appointments',
        thr: '#History',
        Profile: '#Profile',
    };

    /* client */
    loadJavaScript = function (src) {
        var jsSRC = $("<script type='text/javascript' src='" + src + "'>");
        $(OUTPUT).append(jsSRC);
    };
    $(leftbuttons.one).click(function (evt) {
        $(OUTPUT).html(MODULES.USER_VEHICLE);
        var add = {
            form : '#vehicletypeform',
            but : '#formsubmit',
            displayvtype : '#displayvtype',
            vehicletype : '#vehicletypee',
            vehiclemake : '#vehiclemakee',
            displayvmake : '#displayvmake',
            displayvmodel : '#displayvmodel',
            err_email : '#err_email',
            pscenterid : 0,
            eerr_email : '#eerr_email',
            evehicletype : '#evehicletypee',
            eemailcheck : 2,
            pscenter : '#pscenter',
        };
        var list = {
            menubut: '#Showdonormenubut',
            disvehicletype : '#disvehicletype',
        };
        var attr = {
            add: add,
            list: list,
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + USRMOD + "vehicle.js")
        var obj = new vehicle();
        obj.__construct(attr)
    });
    $(leftbuttons.two).click(function (evt) {
        $(OUTPUT).html(MODULES.USER_APPOINTMENT);
        var add = {
           form      :  '#vehicletypeform',
           displayvendordet : '#displayvendordet',
           displayuvehicles : '#displayuvehicles',
           displayvendorapp : '#displayvendorapp',
           pscenter : '#pscenter',
           discomplainttype : '#discomplainttype',
           bookingdate :  '#bookingdate',
           pscenterid : 0,
        };
        var list = {
            menubut: '#Showdonormenubut',
            disvehicletype : '#disvehicletype'
        };
        var attr = {
            add : add,
            list : list,
            url : window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + USRMOD + "appointment.js")
        var obj = new appointment();
        obj.__construct(attr)
    });
    $(leftbuttons.thr).click(function (evt) {
        $(OUTPUT).html(MODULES.USER_HISTORY);
        var add = {

        };
        var list = {

        };
        var attr = {
            add: add,
            list: list,
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + USRMOD + "history.js")
        var obj = new history();
        obj.__construct(attr)

    });
    $(leftbuttons.Profile).click(function (evt) {
       $(OUTPUT).html(MODULES.USER_PROFILE);
        var attr = {
            disdonors : '#disdonors',
            form: '#changePasswordForm',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + USRMOD + "userprofile.js")
        var obj = new profile();
        obj.__construct(attr)

    });
    $(leftbuttons.home).click(function (evt) {
        $(OUTPUT).html(MODULES.dashUser);
        var attr = {
            autoloader: true,
            noOfCustomers: {
                htmlid: '#htmlid1',
                loader: '#loader1',
                action: 'dashboardUser/getNoCustomers',
                but: '#but1',
            },
            upComming: {
                htmlid: '#htmlid2',
                loader: '#loader2',
                action: 'dashboardUser/getUpcomming',
                but: '#but2',
            },
            inLine: {
                htmlid: '#htmlid3',
                loader: '#loader3',
                action: 'dashboardUser/getInline',
                but: '#but3',
            },
            Completed: {
                htmlid: '#htmlid4',
                loader: '#loader4',
                action: 'dashboardUser/getCompleted',
                but: '#but4',
            },
            Slots: {
                htmlid: '#htmlid5',
                loader: '#loader5',
                action: 'dashboardUser/getTodaysSolts',
            },
            dashMe: {
                action: 'dashboardUser/dashMe',
            },
            defaulthtmlid: '',
            defaultloader: '',
            defaultaction: 'dashboardUser/dashMe',
            defaultbut: '',
            def: '<i class="fa fa-rotate-right fa-fw"></i>',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + USRMOD + "dashboard.js");
        var obj = new dashboardUser();
        obj.__construct(attr);
    });
    $(OUTPUT).html(MODULES.dashUser);
    window.setTimeout(function () {
        $(leftbuttons.home).trigger('click');
    }, 600);
});
$(document).ready(function () {
     $.ajax({
            type: 'POST',
            url: 'control.php',
            data: {
                autoloader: true,
                action: 'checkAuthentication',
            },
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
});