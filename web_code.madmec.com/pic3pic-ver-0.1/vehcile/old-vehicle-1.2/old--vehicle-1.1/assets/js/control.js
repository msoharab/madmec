
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
        one: '#vehicletype',
        two: '#vehiclemodel',
        thr: '#vehiclemake',
        four: '#vendor',
        fiv: '#users',
        six: '#complaints',
        seven: '#Report',
        eight: "#ChangePassword"
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
});
