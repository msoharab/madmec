
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
        one: '#Individual',
        two: '#Corporate',
        thr: '#Donation',
        four: '#Referral',
        fiv: '#Rewarding',
        six: '#Email',
        seven: '#SMS',
        eight: "#ChangePassword",
        nine: '#Report',
        last: '#SignOut',
    };

    /* client */
    loadJavaScript = function (src) {
        var jsSRC = $("<script type='text/javascript' src='" + src + "'>");
        $(OUTPUT).append(jsSRC);
    };
    $(leftbuttons.one).click(function (evt) {
        $(OUTPUT).html(MODULES.INDIVIDUAL);
        $('#dissamplefileformat').html('<a href="' + URL + DOWNLOADS + 'dummy_users.xls" ><button type="button" class="btn btn-lg btn-success">DOWNLOAD</button></a>');
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
            url: AJAXURL
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "user_individual.js")
        var obj = new individual();
        obj.__construct(attr);
        addres = new Address();
        addres.__construct({
            url: custdata.url,
        });
        obj.countries = addres.getCountry();
        obj.bindAddressFields(addres, custdata);
    });
    $(leftbuttons.two).click(function (evt) {
        $(OUTPUT).html(MODULES.CORPORATE);
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
        loadJavaScript(URL + ASSET_JSF + SUMOD + "user_corporate.js")
        var obj = new corporate();
        obj.__construct(attr);
        addres = new Address();
        addres.__construct({
            url: custdata.url,
        });
        obj.countries = addres.getCountry();
        obj.bindAddressFields(addres, custdata);
    });
    $(leftbuttons.thr).click(function (evt) {
        $(OUTPUT).html(MODULES.DONATION);

        var attr = {};
        loadJavaScript(URL + ASSET_JSF + SUMOD + "donation.js")
        var obj = new donation();
        obj.__construct(attr)

    });
    $(leftbuttons.four).click(function (evt) {
        $(OUTPUT).html(MODULES.REFERRAL);

        var attr = {};
        loadJavaScript(URL + ASSET_JSF + SUMOD + "referral.js")
        var obj = new referral();
        obj.__construct(attr)
    });
    $(leftbuttons.fiv).click(function (evt) {
        $(OUTPUT).html(MODULES.REWARDING);

        var attr = {};
        loadJavaScript(URL + ASSET_JSF + SUMOD + "rewarding.js")
        var obj = new rewarding();
        obj.__construct(attr)
    });
    $(leftbuttons.six).click(function (evt) {
        $(OUTPUT).html(MODULES.EMAIL);
        var attr = {
            selectdonor: '#selectdonor',
            selectedbody: '#selectedbody',
            message: '#message',
            chatrefresh: '#chatrefresh',
            chatall: '#chatall',
            clearall: '#clearall',
            but: '#btnchat',
            outputmsg: '#outputmsg',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "email.js")
        var obj = new email();
        obj.__construct(attr)
    });
    $(leftbuttons.seven).click(function (evt) {
        $(OUTPUT).html(MODULES.SMS);

        var attr = {
            selectdonor: '#selectdonor',
            selectedbody: '#selectedbody',
            message: '#message',
            chatrefresh: '#chatrefresh',
            chatall: '#chatall',
            clearall: '#clearall',
            but: '#btnchat',
            outputmsg: '#outputmsg',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + SUMOD + "sms.js")
        var obj = new sms();
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
    $(leftbuttons.nine).click(function (evt) {
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
    /* SIGNOUT */
    $(leftbuttons.last).click(function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
        console.log('I am in signout');
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                autoloader: true,
                action: 'logout',
                type: 'master'
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        $(OUTPUT).html("Log out......");
                        loginAdmin({});
                        break;
                }
            },
            error: function () {
                $(sales.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    });
});
