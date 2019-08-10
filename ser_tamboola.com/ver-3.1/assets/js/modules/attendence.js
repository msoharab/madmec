function controlManage() {
	var mngat = {};
	var li_html = '';
	var div_html = '';
	var id = $(DGYM_ID).attr('name');
	var fee = {};
	this.__construct = function (manage) {
		mngat = manage;
		initializepanel();
	};
	function initializeMark() {
		mngat.action = mngat.mark.action;
		mngat.parent_div = mngat.mark.parent_div;
		mngat.pillpanel_div = mngat.mark.pillpanel_div;
		$(mngat.unmark.pillpanel_div).html('');
		$(mngat.defalt.pillpanel_div).html('');
		initializecustomerAtt();
	};
	function initializeUnMark() {
		mngat.action = mngat.unmark.action;
		mngat.parent_div = mngat.unmark.parent_div;
		mngat.pillpanel_div = mngat.unmark.pillpanel_div;
		$(mngat.mark.pillpanel_div).html('');
		$(mngat.defalt.pillpanel_div).html('');
		initializecustomerAtt();
	};
	function initializeDefault() {
		mngat.action = mngat.defalt.action;
		mngat.parent_div = mngat.defalt.parent_div;
		mngat.pillpanel_div = mngat.defalt.pillpanel_div;
		$(mngat.unmark.pillpanel_div).html('');
		$(mngat.mark.pillpanel_div).html('');
		initializecustomerAtt();
	};
	function initializepanel() {
		var rad = '';
		$.ajax({
			type : 'POST',
			url : window.location.href,
			async : false,
			data : {
				autoloader : true,
				action : 'fetchInterestedIn',
				type : 'slave',
				gymid : id
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
					fee = $.parseJSON($.trim(data));
					if (fee.length > 2) {
						for (i = 0; i < fee.length; i++) {
							rad += '<li><a href="' + mngat.pillpanel_div + '" id="' + mngat.allattTab + i + '" data-toggle="tab"><div>' + fee[i]["html"] + '</div></a></li>';
						}
					}
					$(mngat.st_panel).html(rad);
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
				bindFacility();
			}
		});
	};
	function bindFacility() {
		for (i = 0; i < fee.length; i++) {
			$('#' + mngat.allattTab + i).bind('click', {
				fid : fee[i]["id"],
				name : fee[i]["html"],
				sindex : i
			}, function (evt) {
				mngat.fid = evt.data.fid;
				mngat.fname = evt.data.name;
				mngat.sindex = evt.data.sindex;
				initializecustomerAtt();
			});
			if (i == 0) {
				$(mngat.mark.id).click(function () {
					initializeMark();
				});
				$(mngat.unmark.id).click(function () {
					initializeUnMark();
				});
				$(mngat.defalt.id).click(function () {
					initializeDefault();
				});
				mngat.fid = fee[i]["id"];
				mngat.fname = fee[i]["html"];
				mngat.sindex = i;
				initializecustomerAtt();
			}
		}
	};
	function initializecustomerAtt() {
		$(mngat.pillpanel_div).html(LOADER_SIX);
		$.ajax({
			url : window.location.href,
			type : 'POST',
			async : false,
			data : {
				autoloader : 'true',
				action : 'list_att',
				gymid : id,
				att : mngat,
				type : 'slave'
			},
			success : function (data) {
				data = $.parseJSON($.trim(data));
				if (data == 'logout')
					window.location.href = URL;
				else {
					$(mngat.pillpanel_div).html('<div class="col-lg-12 text-center"><h3>' + mngat.fname + '</h3></div>' + data.html);
					window.setTimeout(function () {
						$('#' + data.id).dataTable();
					}, 500);
					$(mngat.pillpanel_div).show();
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				/*console.log(xhr.status);*/
			}
		});
	}
	this.update_attendance = function (attdata) {
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'update_atd',
				gymid : id,
				type : 'slave',
				attdata : attdata
			},
			success : function (data) {
				data = $.trim(data);
				var date = new Date();
				var result = new Array();
				result[0] = '';
				result[1] = ' ';
				if (date.getHours() > 12) {
					result[2] = date.getHours() - 12;
				} else if (date.getHours() == 0) {
					result[2] = "12";
				} else {
					result[2] = date.getHours();
				}
				result[3] = ":"
					result[4] = date.getMinutes();
				if (date.getHours() > 12) {
					result[5] = " PM";
				} else {
					result[5] = " AM";
				}
				if (data == 'logout')
					window.location.href = URL;
				if (data == '0') {
					$(attdata.symbol).html('<span class="text-danger"><i class="fa  fa-circle fa-3x fa-fw"></i></span>');
					$(attdata.resout).html(result.join(''));
				}
				if (data == '1') {
					$(attdata.symbol).html('<span class="text-success"><i class="fa fa-check-circle fa-3x fa-fw"></i></span>');
					$(attdata.resin).html(result.join(''));
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				/*console.log(xhr.status);*/
			}
		});
	}
};
