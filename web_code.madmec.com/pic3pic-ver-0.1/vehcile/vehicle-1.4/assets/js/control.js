
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
        one: '#vehicletype',
        two: '#vehiclemodel',
        thr: '#vehiclemake',
        four: '#vendor',
        fiv: '#users',
        six: '#complaints',
        seven: '#Report',
        eight: "#Profile"
    };

    /* client */
    loadJavaScript = function (src) {
        var jsSRC = $("<script type='text/javascript' src='" + src + "'>");
        $(OUTPUT).append(jsSRC);
    };
    $(leftbuttons.one).click(function (evt) {
        $(OUTPUT).html(MODULES.VEHICLETYPE);
        var add = {
            form : '#vehicletypeform',
            but : '#formsubmit',
            vehicletype : '#vehicletypee',
            err_email : '#err_email',
            emailcheck : 0,
            eerr_email : '#eerr_email',
            evehicletype : '#evehicletypee',
            eemailcheck : 2,
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
        loadJavaScript(URL + ASSET_JSF + SUMOD + "vehicletype.js")
        var obj = new vehicletype();
        obj.__construct(attr)
    });
    $(leftbuttons.two).click(function (evt) {
        $(OUTPUT).html(MODULES.VEHICLEMODEL);
        var add = {
            form : '#vehicletypeform',
            but : '#formsubmit',
            displayvtype : '#displayvtype',
            displayvmake : '#displayvmake',
            vehicletype : '#vehicletypee',
            vehiclemake : '#vehiclemakee',
            vehiclemodel : '#vehiclemodell',
            err_email : '#err_email',
            emailcheck : 0,
            eerr_email : '#eerr_email',
            evehicletype : '#evehicletypee',
            eemailcheck : 2,
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
        loadJavaScript(URL + ASSET_JSF + SUMOD + "vehiclemodel.js")
        var obj = new vehiclemodel();
        obj.__construct(attr)
    });
    $(leftbuttons.thr).click(function (evt) {
        $(OUTPUT).html(MODULES.VEHICLEMAKE);
        var add = {
            form : '#vehicletypeform',
            but : '#formsubmit',
            displayvtype : '#displayvtype',
            vehicletype : '#vehicletypee',
            vehiclemake : '#vehiclemakee',
            err_email : '#err_email',
            emailcheck : 0,
            eerr_email : '#eerr_email',
            evehicletype : '#evehicletypee',
            eemailcheck : 2,
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
        loadJavaScript(URL + ASSET_JSF + SUMOD + "vehiclemake.js")
        var obj = new vehiclemake();
        obj.__construct(attr)

    });
    $(leftbuttons.four).click(function (evt) {
        $(OUTPUT).html(MODULES.VENDOR);

        var add = {
            form: '#addIndiDonorForm',
            email: '#email',
            emailcheck: 0,
            eemailcheck: 2,
            err_email: '#err_email',
            discorptype: '#discorptype',
            but: '#formsubmit',
        };
        var list = {
            menubut: '#Showdonormenubut',
            disdonors: '#disdonors',
        };
        var custdata = {
            url: URL + 'address.php',
            country: "#country",
            state: "#province",
            district: "#district",
            city_town: "#city_town",
            street: "#st_loc",
            address: "#addrs",
            zipcode: "#zipcode",
            website: "#website",
        };
        var attr = {
            add: add,
            list: list,
            url: AJAXURL
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "vendor.js")
        var obj = new vendor();
        obj.__construct(attr);
        addres = new Address();
        addres.__construct({
            url: custdata.url,
        });
        obj.countries = addres.getCountry();
        obj.bindAddressFields(addres, custdata);
    });
    $(leftbuttons.fiv).click(function (evt) {
        $(OUTPUT).html(MODULES.USERS);

        var add = {
            form: '#addIndiDonorForm',
            email: '#email',
            emailcheck: 0,
            eemailcheck: 2,
            err_email: '#err_email',
            disgender: '#disgender',
            disoccup: '#disoccup',
            but: '#formsubmit',
        };
        var list = {
            menubut: '#Showdonormenubut',
            disdonors: '#disdonors',
        };
        var custdata = {
            url: URL + 'address.php',
            country: "#country",
            state: "#province",
            district: "#district",
            city_town: "#city_town",
            street: "#st_loc",
            address: "#addrs",
            zipcode: "#zipcode",
            website: "#website",
        };
        var attr = {
            add: add,
            list: list,
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "user.js")
        var obj = new user();
        obj.__construct(attr)
    });
    $(leftbuttons.six).click(function (evt) {
        $(OUTPUT).html(MODULES.COMPLAINTS);
        var add = {
            form : '#vehicletypeform',
            but : '#formsubmit',
            vehicletype : '#vehicletypee',
            err_email : '#err_email',
            emailcheck : 0,
            eerr_email : '#eerr_email',
            evehicletype : '#evehicletypee',
            eemailcheck : 0,
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
        loadJavaScript(URL + ASSET_JSF + SUMOD + "complaints.js")
        var obj = new complaints();
        obj.__construct(attr)
    });
    $(leftbuttons.seven).click(function (evt) {
        $(OUTPUT).html(MODULES.REPORT);
        var attr = {
            form: '#reportform',
            fromdate: '#fromdate',
            todate: '#todate',
            displayreports: '#displayreports',
            but: '#generatereport',
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "report.js")
        var obj = new report();
        obj.__construct(attr)
    });
    $(leftbuttons.eight).click(function (evt) {
        $(OUTPUT).html(MODULES.CHANGEPASSWORD);

        var attr = {
            form: '#changePasswordForm',
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "changepassword.js")
        var obj = new changePassword();
        obj.__construct(attr)
    });
    $(leftbuttons.home).click(function (evt) {
        $(OUTPUT).html(MODULES.dashAdmin);
        var attr = {
            autoloader: true,
            noOfCustomers: {
                htmlid: '#htmlid1',
                loader: '#loader1',
                action: 'dashboardAdmin/getNoCustomers',
                but: '#but1',
            },
            upComming: {
                htmlid: '#htmlid2',
                loader: '#loader2',
                action: 'dashboardAdmin/getUpcomming',
                but: '#but2',
            },
            inLine: {
                htmlid: '#htmlid3',
                loader: '#loader3',
                action: 'dashboardAdmin/getInline',
                but: '#but3',
            },
            Completed: {
                htmlid: '#htmlid4',
                loader: '#loader4',
                action: 'dashboardAdmin/getCompleted',
                but: '#but4',
            },
            Slots: {
                htmlid: '#htmlid5',
                loader: '#loader5',
                action: 'dashboardAdmin/getTodaysSolts',
            },
            dashMe: {
                action: 'dashboardAdmin/dashMe',
            },
            defaulthtmlid: '',
            defaultloader: '',
            defaultaction: 'dashboardAdmin/dashMe',
            defaultbut: '',
            def: '<i class="fa fa-rotate-right fa-fw"></i>',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "dashboard.js");
        var obj = new dashboardAdmin();
        obj.__construct(attr);
    });
    $(OUTPUT).html(MODULES.dashAdmin);
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
