$(document).ready(function () {
    var leftbuttons = {
        one: '#dashboard',
        two: '#activity',
        three: '#engage',
        four: '#import',
        sev: '#profile'
    };
    var dashboard = {
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
        Graph: {
            htmlid: 'htmlid6',
            loader: '#loader6',
            action: 'dashboardAdmin/getLastWeekProjects',
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
    var employees = {
        add: {
            form: '#addIndiDonorForm',
            email: '#name',
            emailcheck: 0,
            eempidcheck: 2,
            eemailcheck: 2,
            err_email: '#err_email',
            but: '#formsubmit',
        },
        list: {
            menubut: '#Showdonormenubut',
            disdonors: '#disdonors',
        },
        url: AJAXURL
    };
    var project = {
        add: {
            form: '#projectaddform',
            but: '#formsubmit',
            projectname: '#projectname',
            projectdate: '#projectdate',
            countryname: '#countryname',
            err_email: '#err_email',
            ISO: '#ISO',
            ISO3: '#ISO3',
            ISON: '#ISO-Numeric',
            Capital: '#Capital',
            tld: '#tld',
            ccode: '#ccode',
            emailcheck: 0,
            eerr_email: '#eerr_email',
            evehicletype: '#evehicletypee',
            eemailcheck: 2,
        },
        list: {
            menubut: '#Showdonormenubut',
            disvehicletype: '#disvehicletype',
        },
        url: window.location.href,
    };
    var importXLSParam = {
        add: {
            form: '#projectaddform',
            but: '#formsubmit',
            countryname: '#countryname',
            languagename: '#languagename',
            err_email: '#err_email',
            ISO: '#ISO',
            ISO3: '#ISO3',
            ISON: '#ISO-Numeric',
            Capital: '#Capital',
            tld: '#tld',
            ccode: '#ccode',
            emailcheck: 0,
            eerr_email: '#eerr_email',
            evehicletype: '#evehicletypee',
            eemailcheck: 2,
        },
        list: {
            menubut: '#Showdonormenubut',
            disvehicletype: '#disvehicletype',
        },
        url: window.location.href,
    };
    var reports = {
        form: '#reportform',
        fromdate: '#fromdate',
        todate: '#todate',
        displayreports: '#displayreports',
        but: '#generatereport',
    };
    var password = {
        form: '#changePasswordForm',
    };
    $(leftbuttons.one).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_DASH);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "dashboard.js");
        //var obj = new dashboardAdmin();
        //obj.__construct(dashboard);
    });
    $(leftbuttons.two).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_EMPS);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees.js");
        var obj = new user();
        obj.__construct(employees);
    });
    $(leftbuttons.three).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_PROJ);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "projects.js");
        var obj = new projects();
        obj.__construct(project)
    });
    $(leftbuttons.four).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_IMPT);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "import.js");
        var obj = new importXLS();
        obj.__construct(importXLSParam)
    });
    $(leftbuttons.sev).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_PROF);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "profile.js");
        var obj = new changePassword();
        obj.__construct(password);
    });
    $(OUTPUT).html(MODULES.ADM_DASH);
    window.setTimeout(function () {
        $(leftbuttons.one).trigger('click');
    }, 600);
});
