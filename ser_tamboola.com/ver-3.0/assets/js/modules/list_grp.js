function controlCustomerListGroup() {
	var lgp = {};
	var gymid = $(DGYM_ID).attr("name");
	this.__construct = function (imp) {
		lgp = imp;
		initializelistpanel();
	};
	this.listeditcustgrponfo = function (editdata) {
		$(editdata.custdob).datepicker({
			dateFormat : 'dd-M-yy',
			yearRange : '2014:' + Number(new Date().getFullYear()) + 2,
			/*minDate: '0',*/
		});
		$(editdata.custdoj).datepicker({
			dateFormat : 'dd-M-yy',
			yearRange : '2014:' + Number(new Date().getFullYear()) + 2,
			/*minDate: '0',*/
		});
		$(editdata.infoCloseBtn).bind('click', {
			cid : editdata.cust_id
		}, function (evt) {
			$(editdata.infoEditPanel).hide();
			$(editdata.infoEditBtn).show();
			$(editdata.infobody).show();
		});
		$(editdata.infoUpdateBtn).bind('click', {
			cid : editdata.cust_id,
			master_pk : editdata.master_pk,
			cunm : editdata.cname,
			cem : editdata.cemail,
			cce : editdata.ccell,
			cdb : editdata.cdob,
			cdj : editdata.cdoj,
			coc : editdata.cocc
		}, function (evt) {
			var custdata = {
				cname : $(evt.data.cunm).val(),
				cemail : $(evt.data.cem).val(),
				ccell : $(evt.data.cce).val(),
				cdob : convertDateFormat($(evt.data.cdb).val()),
				cdoj : convertDateFormat($(evt.data.cdj).val()),
				cocc : $(evt.data.coc).val(),
				cId : evt.data.cid,
				master_pk : evt.data.master_pk,
			};
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'editlistcustdata',
					type : 'slave',
					attr : custdata,
					gymid : gymid
				},
				success : function (data, textStatus, xhr) {
					data = $.parseJSON($.trim(data));
					/*console.log(data);*/
					switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					case 'login':
						loginAdmin({});
						break;
					default:
						$(editdata.infoform).get(0).reset();
						$(editdata.infoEditPanel).hide();
						if (data.status)
							$(editdata.infobody).html(data.htm);
						$(editdata.infobody).show();
						$(editdata.infoEditBtn).show();
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
		});
		$(editdata.backBtn).bind('click', {
			cid : editdata.cust_id,
			tabidd : editdata.tabId
		}, function (evt) {
			$(evt.data.tabidd).click();
		});
		$(editdata.infoEditBtn).bind('click', {
			cid : editdata.cust_id
		}, function (evt) {
			$(editdata.infobody).hide();
			$(editdata.infoEditBtn).hide();
			$(editdata.infoEditPanel).show();
		});
		var maintag = '<div class="col-lg-12">&nbsp;</div>';
		var oheader = '<table  class="table table-striped table-bordered table-hover" id="list_cust_offer_table">' +
			'<thead>' +
			'<tr>' +
			'<th colspan="6" class="text-center"><font color="red">Offer Lists</font></th>' +
			'</tr>' +
			'<tr>' +
			'<th>#</th>' +
			'<th>Offer Name</th>' +
			'<th class="text-center">Duration</th>' +
			'<th class="text-center">Payment Date</th>' +
			'<th class="text-center">Subscribe Date</th>' +
			'<th class="text-center">Expriy Date</th>' +
			'</tr>' +
			'</thead>';
		var ofooter = '</table>';
		$(editdata.offerTab).html(maintag + oheader + editdata.offerData + ofooter);
		var pheader = '<table  class="table table-striped table-bordered table-hover" id="list_cust_Package_table">' +
			'<thead>' +
			'<tr>' +
			'<th colspan="4" class="text-center"><font color="red">Package Lists</font></th>' +
			'</tr>' +
			'<tr>' +
			'<th>#</th>' +
			'<th>Package Name</th>' +
			'<th class="text-center">Number Of Session</th>' +
			'<th class="text-center">Payment Date</th>' +
			'</tr>' +
			'</thead>';
		var pfooter = '</table>';
		$(editdata.packageTab).html(maintag + pheader + editdata.packageData + pfooter);
		var theader = '<table  class="table table-striped table-bordered table-hover" id="list_cust_transaction_table">' +
			'<thead>' +
			'<tr>' +
			'<th colspan="8" class="text-center"><font color="red">Transaction Lists</font></th>' +
			'</tr>' +
			'<tr>' +
			'<th>#</th>' +
			'<th>Name</th>' +
			'<th class="text-center">Invoice</th>' +
			'<th class="text-center">Payment Date</th>' +
			'<th class="text-center">Payment Mode</th>' +
			'<th class="text-center">Due Amount</th>' +
			'<th class="text-center">Due Date</th>' +
			'<th class="text-center">Due Status</th>' +
			'</tr>' +
			'</thead>';
		var tfooter = '</table>';
		$(editdata.transactionTab).html(maintag + theader + editdata.accountData + tfooter);
		window.setTimeout(function () {
			$('#list_cust_offer_table').dataTable({
				retrieve : true,
				destroy : true,
				"aoColumns" : [
					null,
					null,
					null,
					null,
					null,
					null,
				],
				"autoWidth" : true
			});
			$('#list_cust_Package_table').dataTable({
				retrieve : true,
				destroy : true,
				"aoColumns" : [
					null,
					null,
					null,
					null,
				],
				"autoWidth" : true
			});
			$('#list_cust_transaction_table').dataTable({
				retrieve : true,
				destroy : true,
				"aoColumns" : [
					null,
					null,
					null,
					null,
					null,
					null,
					null,
					null,
				],
				"autoWidth" : true
			});
		}, 300);
	}
	/* list the group*/
	this.listgrptabledata = function (lg) {
		$("#edit_listgp").hide();
		$("#edit_listcustgp").hide();
		$(lg.listBtn).bind('click', {
			group_id : lg.group_id
		}, function (evt) {
			$("#gpanel_div").hide();
			$("#edit_listgp").show();
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'list_groupmem',
					gymid : gymid,
					type : 'slave',
					fid : lg.factid,
					tid : lg.tabId,
					gid : lg.group_id
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						var gcheader = '<table class="table table-striped table-bordered table-hover" id="list_groupmem_table">' +
							'<thead>' +
							'<tr>' +
							'<th colspan="10" class="text-center">Member Lists' +
							'&nbsp;&nbsp;&nbsp;<button class="text-center btn btn-danger btn-md" id="grplist_Back_But"><i class="fa fa-reply fa-fw "></i>Back</button>' +
							'</th>' +
							'</tr>' +
							'<tr>' +
							'<th>No</th>' +
							'<th>Customer Name</th>' +
							'<th>Email Id</th>' +
							'<th>Cell Number</th>' +
							'<th>Occupation</th>' +
							'<th>DOB</th>' +
							'<th>DOJ</th>' +
							'<th>Edit</th>' +
							'<th>Delete</th>' +
							'<th>Flag/Unflag</th>' +
							'</tr>' +
							'</thead>';
						var gcfooter = '</table>';
						$("#edit_listgp").html(gcheader + data + gcfooter);
						$("#grplist_Back_But").bind('click', function () {
							$(lg.tabId).click();
							/*$("#edit_listgp").hide();*/
							/*$("#gpanel_div").show();*/
						});
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
			window.setTimeout(function () {
				$('#list_groupmem_table').dataTable({
					retrieve : true,
					destroy : true,
					"aoColumns" : [
						null,
						null,
						null,
						null,
						null,
						null,
						null,
						null,
						null,
						null,
					],
					"autoWidth" : true
				});
			}, 300);
		});
		$(lg.delOkBtn).bind('click', {
			group_id : lg.group_id
		}, function (evt) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'GRPdel',
					type : 'slave',
					gymid : gymid,
					fid : lg.factid,
					tid : lg.tabId,
					gid : lg.group_id
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(lg.tabId).click();
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
		$(lg.flagokBtn).bind('click', {
			group_id : lg.group_id
		}, function (evt) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'GRPflag',
					type : 'slave',
					gymid : gymid,
					fid : lg.factid,
					tid : lg.tabId,
					gid : lg.group_id
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(lg.tabId).click();
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
		$(lg.unflagokBtn).bind('click', {
			group_id : lg.group_id
		}, function (evt) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'GRPUnflag',
					type : 'slave',
					gymid : gymid,
					fid : lg.factid,
					tid : lg.tabId,
					gid : lg.group_id
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(lg.tabId).click();
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
	this.listcustgpdata = function (custgp) {
		$(custgp.delOkBtn).bind('click', {
			cid : custgp.cust_id
		}, function (evt) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'custGRPdel',
					type : 'slave',
					gymid : gymid,
					cid : evt.data.cid
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(custgp.tabId).click();
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
		$(custgp.flagokBtn).bind('click', {
			cid : custgp.cust_id
		}, function (evt) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'ListGRPflag',
					type : 'slave',
					gymid : gymid,
					cid : evt.data.cid
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(custgp.tabId).click();
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
		$(custgp.unflagokBtn).bind('click', {
			cid : custgp.cust_id
		}, function (evt) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'ListGRPUnflag',
					type : 'slave',
					gymid : gymid,
					cid : evt.data.cid
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(custgp.tabId).click();
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
		$(custgp.editBtn).bind('click', {
			cid : custgp.cust_id,
			master_pk : custgp.master_pk,
			fid : custgp.factid,
			tabid : custgp.tabId,
			editpanel : custgp.editpanel,
			index1 : custgp.index1,
			index2 : custgp.index2
		}, function (evt) {
			$("#edit_listgp").hide();
			$("#edit_listcustgp").show();
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'editcustlistgrp',
					gymid : gymid,
					type : 'slave',
					master_pk : evt.data.master_pk,
					cid : evt.data.cid,
					fid : evt.data.fid,
					tabId : evt.data.tabid,
					index1 : evt.data.index1,
					index2 : evt.data.index2
				},
				success : function (data) {
					/*var editcust = $.parseJSON($.trim(data));*/
					if (data == 'logout')
						window.location.href = URL;
					else {
						console.log(data);
						$("#edit_listcustgp").html(data);
						/*$("#edit_customer").html(data);*/
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
	function initializelistpanel() {
		var rad = '<ul class="nav nav-tabs" id="dynamicFee">';
		$(loader).html(LOADER_SIX);
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'fetchInterestedIn',
				type : 'slave',
				gymid : gymid
			},
			success : function (data, textStatus, xhr) {
				console.log(data);
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
					$(lgp.panelheading).html(fee[0]["html"] + " Group");
					if (fee.length > 7) {
						var max = 7;
						for (i = 0; i < max; i++) {
							if (i == 0)
								rad += '<li class="active"><a href="' + lgp.pillpanel_div + '" id="attgTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
							else
								rad += '<li><a href="cregpanel_div" id="attgTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
						}
						rad += ' <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">More..<span class="caret"></span></a><ul class="dropdown-menu">';
						for (i = max; i < fee.length; i++) {
							rad += '<li><a href="cregpanel_div" id="attgTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
						}
						rad += ' </li></ul>';
					} else {
						for (i = 0; i < fee.length; i++) {
							if (i == 0)
								rad += '<li class="active"><a href="' + lgp.pillpanel_div + '" id="attgTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
							else
								rad += '<li><a href="cregpanel_div" id="attgTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
						}
					}
					/* for(i=0;i<fee.length;i++){*/
					/* if(i==0)*/
					/* rad += '<li class="active" ><a href="'+lgp.pillpanel_div+'" id="attgTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';*/
					/* else*/
					/* rad += '<li><a href="'+lgp.pillpanel_div+'" id="attgTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';*/
					/* }*/
					rad += '<li><a href="' + lgp.pillpanel_div + '" id="regType" data-toggle="tab">Registration</a></li>';
					rad += "</ul>";
					$(lgp.st_panel).html(rad);
					$(loader).html('');
					$("#regType").bind('click', {
						fid : false,
						name : false,
						sindex : "#regType"
					}, function (evt) {
						$(lgp.editlistdiv).hide();
						$("#edit_listcustgp").hide();
						$(lgp.pillpanel_div).show();
						$(lgp.panelheading).html(evt.data.name + " Group");
						var para1 = {
							fid : evt.data.fid,
							fname : evt.data.name,
							sindex : evt.data.sindex,
							tabId : lgp.allattTab + evt.data.sindex,
						}
						initializeLISTGPdata(para1);
					});
					for (i = 0; i < fee.length; i++) {
						$(lgp.allattTab + i).bind('click', {
							fid : fee[i]["id"],
							name : fee[i]["html"],
							sindex : i
						}, function (evt) {
							$(lgp.editlistdiv).hide();
							$("#edit_listcustgp").hide();
							$(lgp.pillpanel_div).show();
							$(lgp.panelheading).html(evt.data.name + " Group");
							var para1 = {
								fid : evt.data.fid,
								fname : evt.data.name,
								sindex : evt.data.sindex,
								tabId : lgp.allattTab + evt.data.sindex,
							}
							initializeLISTGPdata(para1);
						});
						if (i == 0) {
							var para1 = {
								fid : fee[i]["id"],
								fname : fee[i]["html"],
								sindex : i,
								tabId : lgp.allattTab + i,
							}
							$(lgp.editlistdiv).hide();
							$("#edit_listcustgp").hide();
							$(lgp.pillpanel_div).show();
							$(lgp.panelheading).html(para1.fname + " Group");
							initializeLISTGPdata(para1);
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
	function initializeLISTGPdata(para1) {
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'list_group',
				gymid : gymid,
				type : 'slave',
				fid : para1.fid,
				tid : para1.tabId
			},
			success : function (data) {
				if (data == 'logout')
					window.location.href = URL;
				else {
					var gheader = '<table class="table table-striped table-bordered table-hover" id="list_group_table">' +
						'<thead>' +
						'<tr>' +
						'<th colspan="10" class="text-center">Group Lists</th>' +
						'</tr>' +
						'<tr>' +
						'<th>#</th>' +
						'<th>Name</th>' +
						'<th class="text-center">Own Name</th>' +
						'<th class="text-center">No Of Member</th>' +
						'<th class="text-center">Group Type</th>' +
						'<th class="text-center">Group Fees</th>' +
						'<th class="text-center">Receipt No</th>' +
						'<th class="text-center">List Member</th>' +
						'<th>Delete</th>' +
						'<th>Flag/Unflag</th>' +
						'</tr>' +
						'</thead>';
					var gfooter = '</table>';
					$(lgp.pillpanel_div).html(gheader + data + gfooter);
					window.setTimeout(function () {
						$('#list_group_table').dataTable({
							retrieve : true,
							destroy : true,
							"aoColumns" : [
								null,
								null,
								null,
								null,
								null,
								null,
								null,
								null,
								null,
								null,
							],
							"autoWidth" : true
						});
					}, 300);
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
