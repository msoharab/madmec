function controlManageTen() {
	var mgten = {};
	var li_html = '';
	var div_html = '';
	var pa_id = {};
	var i = 1;
	var gymid = $(DGYM_ID).attr('name');
	this.__construct = function (manage) {
		mgten = manage;
		var gymid = $(DGYM_ID).attr('name');
		initializepanel();
	};
	this.packagetable = function (attdata) {
		$(attdata.detBtn).bind('click', {
			pid : attdata.p_id,
			tid : attdata.tabId
		}, function (evt) {
			var para = {
				pid : evt.data.pid,
				tabid : evt.data.tid,
			};
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'deletelistpackage',
					type : 'slave',
					gymid : gymid,
					ppid : para
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(attdata.tabId).click();
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		});
		window.setTimeout(function () {
			var table = $(attdata.tableid).DataTable({
					"aoColumns" : [
						null,
						null,
						null,
						null,
						null,
						null,
						null,
					],
					"columns" : [{
							"className" : 'details-control',
							"orderable" : false,
							"data" : null,
							"defaultContent" : ''
						}, {
							"data" : "index",
							"data" : "packagename",
							"data" : "num",
							"data" : "prize",
						},
					],
					"order" : [[2, 'asc']]
				});
			$(attdata.tableid + ' tbody').on('click', 'td.details-control', function () {
				var tr = $(this).closest('tr');
				var row = table.row(tr);
				if (row.child.isShown()) {
					/* This row is already open - close it*/
					row.child.hide();
					tr.removeClass('shown');
				} else {
					/* Open this row*/
					row.child(format(row.data())).show();
					tr.addClass('shown');
					$("#data1").bind('click', function () {
						var rad = '<select name="packagedata" id="pack_type1">';
						$.ajax({
							type : 'POST',
							url : window.location.href,
							data : {
								autoloader : true,
								action : 'packname_wise',
								type : 'slave',
								async:false,
								gymid : gymid
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
									var pdata = $.parseJSON($.trim(data));
									for (i = 0; i < pdata.length; i++) {
										rad += '<option value="' + pdata[i]["id"] + '" id="pack_type">' + pdata[i]["html"] + '</option>';
									}
									rad += '</select>';
									var r = confirm("Do You Want to Edit??");
									if (r == true) {
										row.child(editFormat(row.data(), rad)).show();
										$('#deleteGYMDELOk').bind('click', function () {
											var pid = $("#pcid").val();
											alert(pid);
										});
										$('#packedit_but').bind('click', function () {
											var para = {
												pkid : $("#pack_type1 option:selected").val(),
												nums : $("#chnum").val(),
												priz : $("#chprize").val(),
												uppcidpk : $("#uppcid").val(),
												tabID : attdata.tabId,
											}
											updateNewPackage(para);
										});
									}
								}
							},
							error : function () {
								$(OUTPUT).html(INET_ERROR);
							},
							complete : function (xhr, textStatus) {
								/*console.log(xhr.status);*/
							}
						});
					});
				}
			});
		}, 200);
	}
	function updateNewPackage(para) {
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'packname_updates',
				type : 'slave',
				gymid : gymid,
				updata : para
			},
			success : function (data, textStatus, xhr) {
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					data = $.trim(data);
					if (data === 'success') {
						$(para.tabID).click();
					} else if (data === 'duplicate') {
						alert("duplicate");
					}
					break;
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
	function editFormat(d, rad) {
		return '<table cellpadding="5" cellspacing="5" border="0" style="padding:50px 50px 50px 50px;" class="table table-border">' +
		'<tr class="info">' +
		'<td>Package Name:</td>' +
		'<td colspan="2">' + rad + '</td>' +
		'</tr>' +
		'<tr style="display:none" class="info">' +
		'<td>Package:</td>' +
		'<td><input type="text" class="form-control" name="uppcid" value="' + d[1] + '" id="uppcid"/></td>' +
		'</tr>' +
		'<tr class="info">' +
		'<td>Number Of Session:</td>' +
		'<td><input type="text" class="form-control" name="chnum" value="' + d[4] + '" id="chnum"/></td>' +
		'</tr>' +
		'<tr class="info">' +
		'<td>Price:</td>' +
		'<td><input type="text" class="form-control" name="chprize" id="chprize" value="' + d[5] + '"/></td>' +
		'</tr>' +
		'<tr class="info">' +
		'<td class="text-center"><button type="button" class="btn btn-info btn-md" id="packedit_but" title="Update" ><i class="fa fa-edit fa-fw"></i>Update</button></td>' +
		'<td class="text-center"><button type="button" class="btn btn-danger btn-md" id="packdelete_but" title="Delete" data-toggle="modal" data-target="#myUSRDELModal"><i class="fa fa-trash-o fa-fw"></i>Delete</button></td>' +
		'</tr>' +
		'<div class="modal fade" id="myUSRDELModal" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModal" aria-hidden="true" style="display: none;">' +
		'<div class="modal-dialog">' +
		'<div class="modal-content" style="color:#000;">' +
		'<div class="modal-header">' +
		'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
		'<h4 class="modal-title" id="myUSRDELModalLabel">Are you really want to delete</h4>' +
		'</div>' +
		'<div class="modal-body" id="myUSRDEL">' +
		'Do you really want to delete <br />' +
		'Press OK to delete ??' +
		'</div>' +
		'<div class="modal-footer">' +
		'<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteGYMDELOk">Ok</button>' +
		'<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteUSRDELCancel">Cancel</button>' +
		'</div>' +
		'</div>' +
		'</div>' +
		'</div>' +
		'</table>';
	}
	function format(d) {
		return '<table cellpadding="5" cellspacing="5" border="0" style="padding:50px 50px 50px 50px;" class="table table-border">' +
		'<tr class="info">' +
		'<td>Package Name:</td>' +
		'<td>' + d[3] + '</td>' +
		'</tr>' +
		'<tr class="info">' +
		'<td>Number Of Session:</td>' +
		'<td>' + d[4] + '</td>' +
		'</tr>' +
		'<tr class="info">' +
		'<td>Price:</td>' +
		'<td>' + d[5] + '</td>' +
		'</tr>' +
		'<tr class="info">' +
		'<td>Edit</td>' +
		'<td><button type="button" class="btn btn-info" name="Edit" id="data1">Edit</button></td>' +
		'</tr>' +
		'</table>';
	}
	function initializepanel() {
		var rad = '<ul class="nav nav-tabs" id="dynamicFee">';
		$(loader).html(LOADER_SIX);
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'packname_wise',
				type : 'slave',
				gymid : gymid
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
					var fee = $.parseJSON($.trim(data));
					$(mgten.panelheading).html(fee[0]["html"] + " Package");
					for (i = 0; i < fee.length; i++) {
						if (i == 0)
							rad += '<li class="active"><a href="' + mgten.pillpanel_div + '" id="attTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
						else
							rad += '<li><a href="' + mgten.pillpanel_div + '" id="attTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
					}
					rad += "</ul>";
					$(mgten.st_panel).html(rad);
					$(loader).html('');
					for (i = 0; i < fee.length; i++) {
						$(mgten.allattTab + i).bind('click', {
							fid : fee[i]["id"],
							name : fee[i]["html"],
							sindex : i
						}, function (evt) {
							$(mgten.pillpanel_div).show();
							$(mgten.panelheading).html(evt.data.name + " Package");
							var para1 = {
								fid : evt.data.fid,
								fname : evt.data.name,
								sindex : evt.data.sindex,
								tabId : mgten.allattTab + evt.data.sindex,
							}
							initializepackages(para1);
						});
						if (i == 0) {
							var para1 = {
								fid : fee[i]["id"],
								fname : fee[i]["html"],
								sindex : i,
								tabId : mgten.allattTab + i,
							}
							$(mgten.pillpanel_div).show();
							$(mgten.panelheading).html(para1.fname + " Package");
							initializepackages(para1);
						}
					}
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	}
	function initializepackages(para1) {
		/*alert(para1.fid);*/
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'packagesdata',
				gymid : gymid,
				type : 'slave',
				fid : para1.fid,
				tabId : para1.tabId
			},
			success : function (data) {
				if (data == 'logout')
					window.location.href = URL;
				else {
					$(mgten.pillpanel_div).html(data);
					/*$(mgten.pillpanel_div).html("hello");*/
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
