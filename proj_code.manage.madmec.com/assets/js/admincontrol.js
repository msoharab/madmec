$(document).ready(function () {
    var leftbuttons = {
        one: '#dashboard',
        two: '#activity',
        two1: '#activity1',
        two2: '#activity2',
        two3: '#activity3',
        two4: '#activity4',
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
    var contrl = {
        dash: {
            traffic: '#displaytraffic1',
            tab1: 'tab1traffic1',
            url1: URL + AJAXURL,
            logs: '#displaytraffic2',
            tab2: 'tab1traffic2',
            url2: URL + AJAXURL,
        },
        users: {
            list: '#Usersl1',
            tab1: 'tab1Usersl1',
            url1: URL + AJAXURL,
            url2: URL + AJAXURL,
        },
        post: {
            list: '#Postsel1',
            tab1: 'tab1Postsel1',
            url1: URL + AJAXURL,
            url2: URL + AJAXURL,
        },
        sections: {
            indexlist: '#Showdonormenubut1231',
            indexout: '#selectcontinent1',
            walllist: '#Addfacility222',
            wallout: '#selectcontinent2',
            chlist: '#Addfacility333',
            chout: '#selectcontinent3',
            url1: URL + AJAXURL,
            url2: URL + AJAXURL,
            url3: URL + AJAXURL,

            indexform: '#indexsecaddform',
            indexadd: '#indexsecadd',
            indexbut: '#secsave',
            url4: URL + AJAXURL,

            wallform: '#indexsecaddform2',
            walladd: '#indexsecadd2',
            wallbut: '#secsave2',
            url5: URL + AJAXURL,

            chform: '#indexsecaddform3',
            chadd: '#indexsecadd3',
            chbut: '#secsave3',
            url6: URL + AJAXURL,

            url7: URL + AJAXURL,
            url8: URL + AJAXURL,
            url9: URL + AJAXURL,

        },
        channels: {
            list: '#selectchannel1',
            tab1: 'tab1selectchannel1',
            url1: URL + AJAXURL,
            url2: URL + AJAXURL,
        },
    }
    $(leftbuttons.one).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_DASH);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees1.js");
        var obj = new controlWebsit();
        obj.__construct(contrl);
        obj.__constructDash();
    });
    $(leftbuttons.two).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_EMPS);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees.js");
        var obj = new user();
        obj.__construct(employees);
    });
    $(leftbuttons.two1).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_PROF4);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees1.js");
        var obj = new controlWebsit();
        obj.__construct(contrl);
        obj.__constructUsers();
    });
    $(leftbuttons.two2).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_PROF1);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees1.js");
        var obj = new controlWebsit();
        obj.__construct(contrl);
        obj.__constructChannels();
    });
    $(leftbuttons.two3).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_PROF3);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees1.js");
        var obj = new controlWebsit();
        obj.__construct(contrl);
        obj.__constructSections();
    });
    $(leftbuttons.two4).click(function (evt) {
        evt.preventDefault();
        setActive(this);
        $(OUTPUT).html(MODULES.ADM_PROF2);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees1.js");
        var obj = new controlWebsit();
        obj.__construct(contrl);
        obj.__constructPosts();
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
