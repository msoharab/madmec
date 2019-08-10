function dashboardAdmin() {
	var DashData = {};
	var jsondata = {};
	this.__construct = function (para) {
		DashData = para;
		$(DashData.noOfCustomers.but).click(function () {
			DashData.defaulthtmlid = DashData.noOfCustomers.htmlid;
			DashData.defaultloader = DashData.noOfCustomers.loader;
			DashData.defaultbut = DashData.noOfCustomers.but;
			DashData.defaultaction = DashData.noOfCustomers.action;
			loadData();
		});
		$(DashData.upComming.but).click(function () {
			DashData.defaulthtmlid = DashData.upComming.htmlid;
			DashData.defaultloader = DashData.upComming.loader;
			DashData.defaultbut = DashData.upComming.but;
			DashData.defaultaction = DashData.upComming.action;
			loadData();
		});
		$(DashData.inLine.but).click(function () {
			DashData.defaulthtmlid = DashData.inLine.htmlid;
			DashData.defaultloader = DashData.inLine.loader;
			DashData.defaultbut = DashData.inLine.but;
			DashData.defaultaction = DashData.inLine.action;
			loadData();
		});
		$(DashData.Completed.but).click(function () {
			DashData.defaulthtmlid = DashData.Completed.htmlid;
			DashData.defaultloader = DashData.Completed.loader;
			DashData.defaultbut = DashData.Completed.but;
			DashData.defaultaction = DashData.Completed.action;
			loadData();
		});
		loadData();
	};
	function loadData() {
		var action = DashData.defaultaction.split("/")[1];
		switch (action) {
		case "getNoCustomers": {
				$(DashData.defaultloader).html(LOADER_TWO);
				break;
			}
		case "getUpcomming": {
				$(DashData.defaultloader).html(LOADER_TWO);
				break;
			}
		case "getInline": {
				$(DashData.defaultloader).html(LOADER_TWO);
				break;
			}
		case "getCompleted": {
				$(DashData.defaultloader).html(LOADER_TWO);
				break;
			}
		case "getTodaysSolts": {
				$(DashData.Slots.loader).html(LOADER_FIV);
				break;
			}
		case "getLastWeekProjects": {
				$(DashData.Slots.loader).html(LOADER_FIV);
				break;
			}
		case "dashMe": {
				$(DashData.noOfCustomers.loader).html(LOADER_TWO);
				$(DashData.upComming.loader).html(LOADER_TWO);
				$(DashData.inLine.loader).html(LOADER_TWO);
				$(DashData.Completed.loader).html(LOADER_TWO);
				$(DashData.Slots.loader).html(LOADER_FIV);
				break;
			}
		}
		var slotsheader = '<table id="slotslist" class="table table-striped table-bordered table-hover">' +
			'<thead><tr>' +
			'<th>#</th>' +
			'<th>Employee ID</th>' +
			'<th>Employee Name</th>' +
			'<th>Productive Hours</th>' +
			'</tr></thead>' +
			'<tbody>';
		var slotsfooter = '</tbody></table>';
		$.ajax({
			type : 'POST',
			url : DashData.url,
			data : {
				autoloader : DashData.autoloader,
				action : DashData.defaultaction,
			},
			success : function (data, textStatus, xhr) {
				data = $.trim(data);
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					jsondata = $.parseJSON(data);
					switch (action) {
					case "getNoCustomers": {
							$(DashData.defaulthtmlid).html(jsondata.count);
							$(DashData.defaultloader).html(DashData.def);
							break;
						}
					case "getUpcomming": {
							$(DashData.defaulthtmlid).html(jsondata.count);
							$(DashData.defaultloader).html(DashData.def);
							break;
						}
					case "getInline": {
							$(DashData.defaulthtmlid).html(jsondata.count);
							$(DashData.defaultloader).html(DashData.def);
							break;
						}
					case "getCompleted": {
							$(DashData.defaulthtmlid).html(jsondata.count);
							$(DashData.defaultloader).html(DashData.def);
							break;
						}
					case "getTodaysSolts": {
							$(DashData.Slots.htmid).html(slotsheader + jsondata.html + slotsfooter);
							$(DashData.Slots.loader).html(DashData.def);
							window.setTimeout(function () {
								$('#slotslist').dataTable();
							}, 2000);
							break;
						}
					case "getLastWeekProjects": {
							$(DashData.Graph.loader).html(DashData.def);
							if (typeof jsondata.gdata === 'object'  && jsondata.gdata.length > 0) {
								var bar = new Morris.Bar({
										element : DashData.Graph.htmlid,
										resize : true,
										data : jsondata.gdata,
										barColors : ['#00a65a', '#f56954'],
										xkey : 'y',
										ykeys : ['a'],
										labels : ['Hours'],
										hideHover : 'auto'
									});
							}
							break;
						}
					case "dashMe": {
							$(DashData.noOfCustomers.loader).html(DashData.def);
							$(DashData.upComming.loader).html(DashData.def);
							$(DashData.inLine.loader).html(DashData.def);
							$(DashData.Completed.loader).html(DashData.def);
							$(DashData.Slots.loader).html(DashData.def);
							$(DashData.Graph.loader).html(DashData.def);
							$(DashData.noOfCustomers.htmlid).html(jsondata.ccount);
							$(DashData.upComming.htmlid).html(jsondata.ucount);
							$(DashData.inLine.htmlid).html(jsondata.icount);
							$(DashData.Completed.htmlid).html(jsondata.comcount);
							$(DashData.Slots.htmlid).html(slotsheader + jsondata.shtml + slotsfooter);
							window.setTimeout(function () {
								$('#slotslist').dataTable();
							}, 2000);
							if (typeof jsondata.gdata === 'object'  && jsondata.gdata.length > 0) {
								var bar = new Morris.Bar({
										element : DashData.Graph.htmlid,
										resize : true,
										data : jsondata.gdata,
										barColors : ['#00a65a', '#f56954'],
										xkey : 'y',
										ykeys : ['a'],
										labels : ['Hours'],
										hideHover : 'auto'
									});
							}
							break;
						}
					}
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {}
		});
	};
}
