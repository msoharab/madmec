$(document).ready(function () {
    var leftbuttons = {
        one: '#dashboard',
        two: '#activity',
        three: '#engage',
        four: '#import',
        oneC: '.extra-menu1',
        threeC: '.extra-menu2',
        fourC: '.extra-menu3',
        fiv: '#profile',
    };
    var dashboard = {
        autoloader: true,
        noOfCustomers: {
            htmlid: '#htmlid1',
            loader: '#loader1',
            action: 'empDashboard/getNoCustomers',
            but: '#but1',
        },
        upComming: {
            htmlid: '#htmlid2',
            loader: '#loader2',
            action: 'empDashboard/getUpcomming',
            but: '#but2',
        },
        inLine: {
            htmlid: '#htmlid3',
            loader: '#loader3',
            action: 'empDashboard/getInline',
            but: '#but3',
        },
        Completed: {
            htmlid: '#htmlid4',
            loader: '#loader4',
            action: 'empDashboard/getCompleted',
            but: '#but4',
        },
        Slots: {
            htmlid: '#htmlid5',
            loader: '#loader5',
            action: 'empDashboard/getTodaysSolts',
        },
        Graph: {
            htmlid: 'htmlid6',
            loader: '#loader6',
            action: 'empDashboard/getLastWeekProjects',
        },
        dashMe: {
            action: 'empDashboard/dashMe',
        },
        defaulthtmlid: '',
        defaultloader: '',
        defaultaction: 'empDashboard/dashMe',
        defaultbut: '',
        def: '<i class="fa fa-rotate-right fa-fw"></i>',
        url: window.location.href,
    };
    var activitys = {
        add: {
            form: '#activityaddform',
            but: '#activityaddform',
            selectproject: '#selectproject',
        },
        list: {
            menuBut: '#Showdonormenubut',
            displayactivities: '#displayactivities',
        },
        url: window.location.href,
    };
    var engages = {
        add: {
            form: '#engageaddform',
            but: '#formsubmit',
            selectproject: '#selectproject',
            selectactivity: '#selectactivity',
        },
        list: {
            menuBut: '#Showdonormenubut',
            displayactivities: '#displayactivities',
        },
        disnewengageform: '#disnewengageform',
        url: window.location.href,
    };
    var importt={
       url: window.location.href,
    };
    $(leftbuttons.oneC).each(function () {
        $(this).click(function (evt) {
            setActive(this);
            $(OUTPUT).html(MODULES.EMP_DASH);
            loadJavaScript(URL + ASSET_JSF + CLASSES + EMP_JS + "dashboard.js");
            var obj = new empDashboard();
            obj.__construct(dashboard);
        });
    });
    $(leftbuttons.threeC).each(function () {
        $(this).click(function (evt) {
            setActive(this);
            $(OUTPUT).html(MODULES.EMP_ENGE);
            loadJavaScript(URL + ASSET_JSF + CLASSES + EMP_JS + "engage.js");
            var obj = new engage();
            obj.__construct(engages);
        });
    });
    $(leftbuttons.fourC).each(function () {
        $(this).click(function (evt) {
            $(OUTPUT).html(MODULES.EMP_IMPT);
            setActive(this);
            $('#dissamplefileformat').html('<a href="' + URL + DOWNLOADS + 'dummy_project_timelogger.xls" ><button type="button" class="btn btn-lg btn-success">DOWNLOAD</button></a>');
            loadJavaScript(URL + ASSET_JSF + CLASSES + EMP_JS + "import.js");
            var obj = new imports();
            obj.__construct(importt);
        });
    });
    $(leftbuttons.two).click(function (evt) {
         setActive($(leftbuttons.two), true);
        $(OUTPUT).html(MODULES.EMP_ACTIVITY);
        loadJavaScript(URL + ASSET_JSF + CLASSES + EMP_JS + "activity.js");
        var obj = new activity();
        obj.__construct(activitys);
    });
    $(leftbuttons.fiv).click(function (evt) {
        setActive($(leftbuttons.fiv), true);
        $(OUTPUT).html(MODULES.EMP_PROF);
        loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "profile.js");
        //var obj = new changePassword();
        //obj.__construct(password)
    });
    $(OUTPUT).html(MODULES.EMP_DASH);
    window.setTimeout(function () {
		setActive($(leftbuttons.one));
		$(OUTPUT).html(MODULES.EMP_DASH);
		loadJavaScript(URL + ASSET_JSF + CLASSES + EMP_JS + "dashboard.js");
		var obj = new empDashboard();
		obj.__construct(dashboard);
    }, 600);
});
