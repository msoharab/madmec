$(document).ready(function () {
	var leftbuttons = {
		one : '#dahboard',
		two : '#employees',
		thr : '#projects',
		oneC : '.extra-menu1',
		twoC : '.extra-menu2',
		thrC : '.extra-menu3',
		four : '#import',
		fiv : '#reports',
		six : '#profile'
	};
	var dashboard = {
		autoloader : true,
		noOfCustomers : {
			htmlid : '#htmlid1',
			loader : '#loader1',
			action : 'dashboardAdmin/getNoCustomers',
			but : '#but1',
		},
		upComming : {
			htmlid : '#htmlid2',
			loader : '#loader2',
			action : 'dashboardAdmin/getUpcomming',
			but : '#but2',
		},
		inLine : {
			htmlid : '#htmlid3',
			loader : '#loader3',
			action : 'dashboardAdmin/getInline',
			but : '#but3',
		},
		Completed : {
			htmlid : '#htmlid4',
			loader : '#loader4',
			action : 'dashboardAdmin/getCompleted',
			but : '#but4',
		},
		Slots : {
			htmlid : '#htmlid5',
			loader : '#loader5',
			action : 'dashboardAdmin/getTodaysSolts',
		},
		Graph : {
			htmlid : 'htmlid6',
			loader : '#loader6',
			action : 'dashboardAdmin/getLastWeekProjects',
		},
		dashMe : {
			action : 'dashboardAdmin/dashMe',
		},
		defaulthtmlid : '',
		defaultloader : '',
		defaultaction : 'dashboardAdmin/dashMe',
		defaultbut : '',
		def : '<i class="fa fa-rotate-right fa-fw"></i>',
		url : window.location.href,
	};
	var employees = {
		add : {
			form : '#addIndiDonorForm',
			email : '#email',
			emailcheck : 0,
			eempidcheck : 2,
			eemailcheck : 2,
			err_email : '#err_email',
			empid : '#empid',
			empidcheck : 0,
			err_empid : '#err_empid',
			discorptype : '#discorptype',
			disgender : '#disgender',
			but : '#formsubmit',
		},
		list : {
			menubut : '#Showdonormenubut',
			disdonors : '#disdonors',
		},
		url : AJAXURL
	};
	var project = {
		add : {
			form : '#projectaddform',
			but : '#formsubmit',
			projectdate : '#projectdate',
			projectname : '#projectname',
			err_email : '#err_email',
			emailcheck : 0,
			eerr_email : '#eerr_email',
			evehicletype : '#evehicletypee',
			eemailcheck : 2,
			pscenter : '#pscenter',
		},
		list : {
			menubut : '#Showdonormenubut',
			disvehicletype : '#disvehicletype',
		},
		url : window.location.href,
	};
	var importXLSParam = {
		form : '#customerdetailsxls',
		status : '#status1',
		bar : '.bar',
		percent : '.percent',
		url : window.location.href,
	};
	var reportsparam = {
		selectproj : '#selectproj',
		form : '#reportform',
		fromdate : '#fromdate',
		todate : '#todate',
		displayreports : '#displayreports',
		but : '#generatereport',
	};
	var password = {
		form : '#changePasswordForm',
	};
	$(leftbuttons.oneC).each(function () {
		$(this).click(function (evt) {
			setActive(this);
			$(OUTPUT).html(MODULES.ADM_DASH);
			loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "dashboard.js");
			var obj = new dashboardAdmin();
			obj.__construct(dashboard);
		});
	});
	$(leftbuttons.twoC).each(function () {
		$(this).click(function (evt) {
			setActive(this);
			$(OUTPUT).html(MODULES.ADM_EMPS);
			loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "employees.js");
			var obj = new user();
			obj.__construct(employees);
		});
	});
	$(leftbuttons.thrC).each(function () {
		$(this).click(function (evt) {
			setActive(this);
			$(OUTPUT).html(MODULES.ADM_PROJ);
			loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "projects.js");
			var obj = new projects();
			obj.__construct(project)
		});
	});
	$(leftbuttons.four).click(function (evt) {
		setActive(this);
		$(OUTPUT).html(MODULES.ADM_IMPT);
		$('#dissamplefileformat').html('<a href="' + URL + DOWNLOADS + 'dummy_employee.xls" ><button type="button" class="btn btn-lg btn-success">DOWNLOAD</button></a>');
		loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "import.js");
		var obj = new importXLS();
		obj.__construct(importXLSParam)
	});
	$(leftbuttons.fiv).click(function (evt) {
		setActive(this);
		$(OUTPUT).html(MODULES.ADM_REPT);
		loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "reports.js");
		var obj = new reports();
		obj.__construct(reportsparam)
	});
	$(leftbuttons.six).click(function (evt) {
		setActive($(leftbuttons.fiv), true);
		$(OUTPUT).html(MODULES.ADM_PROF);
		loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "profile.js");
		var obj = new changePassword();
		obj.__construct(password)
	});
	$(OUTPUT).html(MODULES.ADM_DASH);
	window.setTimeout(function () {
		setActive($(leftbuttons.one));
		$(OUTPUT).html(MODULES.ADM_DASH);
		loadJavaScript(URL + ASSET_JSF + CLASSES + ADM_JS + "dashboard.js");
		var obj = new dashboardAdmin();
		obj.__construct(dashboard);
	}, 600);
});
