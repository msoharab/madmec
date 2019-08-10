	function ProjectPlan(){
		var PP = {};
		var listofrequi = [];
		var requi = {};
		var prjstats = {};
		var prjtasks = {};
		this.__construct = function(cpoctrl) {
			PP = cpoctrl;
			requi = PP.plan.require;
			$(PP.msgDiv).html('');
			/* Requirement */
			fetchRequirement();
			PP.plan.require.prjmid = 0;
			PP.plan.require.requi_id = 0;
			PP.plan.require.ref_no = '';
			PP.plan.require.quot_id = 0;
			PP.plan.require.po_id = 0;
			PP.plan.require.inv_id = 0;
			PP.plan.require.client_id = 0;
			PP.plan.require.ethno_id = 0;
			PP.plan.require.rep_id = 0;
			PP.plan.require.ethno = '';
			PP.plan.require.rep = '';
			PP.plan.require.doethno = '';
			PP.plan.require.ind = 0;
			PP.plan.require.artype = '';
			$(PP.plan.assntask.parentDiv).html('');
			$(PP.plan.but).click(function(evt){
				evt.stopPropagation();
				evt.preventDefault();
				createProjectPlan();
			});
			// $('#name').prop('selectedIndex',0);
			$(PP.plan.pcd+','+ PP.plan.psd).datepicker({
				dateFormat: 'yy-mm-dd',
				changeYear: true,
				changeMonth: true
			});
			$(PP.plan.pcd +','+ PP.plan.psd).val('');
			/* MD */
			fetchUsers({type:[7],
				para1:{
					ob:PP.plan,
					parentDiv:PP.plan.md,
					id:PP.plan.md_type,
					msg:PP.plan.md_msg,
					text:'Select MD'
				}
			});
			/* Project Manager */
			fetchUsers({type:[4],
				para1:{
					ob:PP.plan,
					parentDiv:PP.plan.mng,
					id:PP.plan.mng_type,
					msg:PP.plan.mng_msg,
					text:'Select Project Manager'
				}
			});
			/* Project Engineer */
			fetchUsers({type:[5],
				para1:{
					ob:PP.plan,
					parentDiv:PP.plan.eng,
					id:PP.plan.eng_type,
					msg:PP.plan.eng_msg,
					text:'Select Project Engineer'
				}
			});
			/* Holder */
			fetchUsers({type:[6],
				para1:{
					ob:PP.plan,
					parentDiv:PP.plan.hld,
					id:PP.plan.hld_type,
					msg:PP.plan.hld_msg,
					text:'Select Project Holder'
				}
			});
		};
		function fetchRequirement(){
			var htm = '';
			$.ajax({
				type: 'POST',
				url: requi.url,
				data: {
					autoloader: true,
					action: 'fetchRequirement'
				},
				success: function(data, extStatus, xhr) {
					data = $.trim(data);
					switch (data) {
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							listofrequi = $.parseJSON($.trim(data));
							if(listofrequi != null){
								for (i = 0; i < listofrequi.length; i++) {
									htm += listofrequi[i]["html"];
								}
								$(requi.TVQtype).html('<select class="form-control" id="' + requi.Qrequi_type + '"><option value="NULL" selected>Select Project</option>' + htm + '</select><p class="help-block" id="' + requi.QRT_msg + '">Enter / Select</p>');
								$('#'+requi.Qrequi_type).change({para:PP.plan,
									requi:listofrequi,
									len:listofrequi.length
								},function(evt){
									var para = evt.data.para;
									var requi = evt.data.requi;
									var len = evt.data.len;
									var prdheader ='<tr><td colspan="4"><h4>Production</h4><td></tr>';
									var pntheader ='<tr><td colspan="4"><h4>Painting</h4><td></tr>';
									var tableheader ='<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>#</th><th>Task</th><th>Production</th><th>Assignee</th><th>SMS / Feedback</th></tr></thead><tbody>'+prdheader;
									var tablefooter ='</tbody></table></div>';
									var task_descp = tableheader;
									var si_no = 0;
									for (i = 0; i < len; i++) {
										if(requi[i]["req_id"] == $(this).select().val()){
											para.require.pname = requi[i]["pname"];
											para.require.prjmid = requi[i]["id"];
											para.require.requi_id = requi[i]["req_id"];
											para.require.ref_no = requi[i]["ref_no"];
											para.require.quot_id = requi[i]["quot_id"];
											para.require.po_id = requi[i]["po_id"];
											para.require.inv_id = requi[i]["inv_id"];
											para.require.client_id = requi[i]["client_id"];
											para.require.ethno_id = requi[i]["ethno_id"];
											para.require.rep_id = requi[i]["rep_id"];
											para.require.ethno = requi[i]["ethno"];
											para.require.rep = requi[i]["rep"];
											para.require.doethno = requi[i]["doethno"];
											para.require.ind = i;
											para.require.artype = requi[i]["artype"];
											// "id" => $tsak_id,
											// "tablerow" => $tablerow,
											// "prrd_DOM" => '#prrd_ptask_'.$tsak_id,
											// "prrd_msg_DOM" => '#prrd_ptask_msg_'.$tsak_id,
											// "assn_DOM" => '#assn_ptask_'.$tsak_id,
											// "assn_msg_DOM" => '#assn_ptask_msg_'.$tsak_id
											// assntask:{
												// parentDiv:'#multiple_projtmem',
												// task_desc:[]
											// },
												// task_id:0,
												// production:'Yes',
												// assn_id:0
											prjtasks = requi[i]["req_descp"];
											for (j = 0; j < requi[i]["req_descp"]["Production"].length; j++,si_no++) {
												task_descp += requi[i]["req_descp"]["Production"][j]["tablerow"];
												para.assntask.task_desc[si_no] = {
													task_id:requi[i]["req_descp"]["Production"][j]["id"],
													production:'NULL',
													assn_id:0
												};
											}
											task_descp += pntheader;
											for (j = 0; j < requi[i]["req_descp"]["Painting"].length; j++,si_no++) {
												task_descp += requi[i]["req_descp"]["Painting"][j]["tablerow"];
												para.assntask.task_desc[si_no] = {
													task_id:requi[i]["req_descp"]["Painting"][j]["id"],
													production:'NULL',
													assn_id:0
												};
											}
											$(para.assntask.parentDiv).html(task_descp+tablefooter);
											break;
										}
									}
								});
							}
						break;
					}
				},
				error: function() {
					$(PP.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
		function fetchUsers(obj){
			var htm = '';
			var htm1 = '';
			var list = {};
			$(obj.para1.parentDiv).html('');
			$.ajax({
				type: 'POST',
				url:obj.para1.ob.url,
				data: {
					autoloader: true,
					action: 'fetchUsers',
					utyp: obj.type
				},
				success: function(data, textStatus, xhr) {
					switch (data) {
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							list = $.parseJSON($.trim(data));
							if(list != null){
								for (i = 0; i < list.length; i++) {
									htm += list[i]["html"];
								}
								$(obj.para1.parentDiv).html('<select class="form-control" id="' + obj.para1.id + '"><option value="NULL" selected>'+obj.para1.text+'</option>' + htm + '</select><p class="help-block" id="' + obj.para1.msg + '">Enter / Select</p>');
								window.setTimeout(function() {
									$('#' + obj.para1.id).change(function() {
										var id = $(this).select().val();
										if (id != 'NULL') {
											switch(obj.para1.text){
												case 'Select MD':
													obj.para1.ob.mdid = id;
												break;
												case 'Select Project Manager':
													obj.para1.ob.mngid = id;
												break;
												case 'Select Project Engineer':
													obj.para1.ob.engid = id;
												break;
												case 'Select Project Holder':
													obj.para1.ob.hldid = id;
												break;
											}
										}
									});
								}, 300);
							}
						break;
					}
				},
				error: function() {
					$(obj.para1.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
		function fetchPrjStatus() {
			var htm = '';
			$(usr.add.basicinfo.TVUtype).html('');
			$.ajax({
				type: 'POST',
				url: obj.para1.ob.url,
				data: {
					autoloader: true,
					action: 'fetchPrjStatus'
				},
				success: function(data, textStatus, xhr) {
					data = $.trim(data);
					switch (data) {
						case 'logout':
							logoutAdmin({});
							break;
						case 'login':
							loginAdmin({});
							break;
						default:
							var stts = $.parseJSON(data);
							if(stts != null){
								prjstats = stts;
								for (i = 0; i < stts.length; i++) {
									htm += stts[i]["html"];
								}
								$(obj.para1.ob.prjsts).html('<select class="form-control" id="' + obj.para1.ob.prjstts + '"><option value="NULL" selected>Select Project Status</option>' + htm + '</select><p class="help-block" id="' + obj.para1.ob.prjsttsmsg + '">Enter / Select</p>');
							}
							break;
					}
				},
				error: function() {
					$(usr.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
		function fetchProjectStatus(){
		};
		function createProjectPlan(){
			var flag = false;
			var prod = [];
			var assn = [];
			/* Requirement */
			if (PP.plan.require.prjmid != 0) {
				flag = true;
				$('#'+PP.plan.require.QRT_msg).html(VALIDNOT);
			} else {
				flag = false;
				$('#'+PP.plan.require.QRT_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+PP.plan.require.QRT_msg).offset().top) - 95}, 'slow');
				$('#'+PP.plan.require.Qrequi_type).focus();
				return;
			}
			if (PP.plan.require.ref_no != '' || PP.plan.require.ethno != '' || PP.plan.require.rep != '' ||
				!$(PP.plan.require.doethno).val().match(/(\d{4})-(\d{2})-(\d{2})/) || PP.plan.require.artype != '') {
				flag = true;
				$('#'+PP.plan.QRT_msg).html(VALIDNOT);
			} else {
				flag = false;
				$('#'+PP.plan.QRT_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+PP.plan.QRT_msg).offset().top) - 95}, 'slow');
				$('#'+PP.plan.Qrequi_type).focus();
				return;
			}
			/* Project MD */
			if (PP.plan.mdid != 0) {
				flag = true;
				$('#'+PP.plan.md_msg).html(VALIDNOT);
			} else {
				flag = false;
				$('#'+PP.plan.md_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+PP.plan.md_msg).offset().top) - 95}, 'slow');
				$('#'+PP.plan.md_type).focus();
				return;
			}
			/* Project Manager */
			if (PP.plan.mngid != 0) {
				flag = true;
				$('#'+PP.plan.mng_msg).html(VALIDNOT);
			} else {
				flag = false;
				$('#'+PP.plan.mng_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+PP.plan.mng_msg).offset().top) - 95}, 'slow');
				$('#'+PP.plan.mng_type).focus();
				return;
			}
			/* Project Engineer */
			if (PP.plan.engid != 0) {
				flag = true;
				$('#'+PP.plan.eng_msg).html(VALIDNOT);
			} else {
				flag = false;
				$('#'+PP.plan.eng_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+PP.plan.eng_msg).offset().top) - 95}, 'slow');
				$('#'+PP.plan.eng_type).focus();
				return;
			}
			/* Project Holder */
			if (PP.plan.hldid != 0) {
				flag = true;
				$('#'+PP.plan.hld_msg).html(VALIDNOT);
			} else {
				flag = false;
				$('#'+PP.plan.hld_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+PP.plan.hld_msg).offset().top) - 95}, 'slow');
				$('#'+PP.plan.hld_type).focus();
				return;
			}
			/* Project Start Date */
			if ($(PP.plan.psd).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
				flag = true;
				$(PP.plan.psdmsg).html(VALIDNOT);
			} else {
				flag = false;
				$(PP.plan.psdmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(PP.plan.psdmsg).offset().top) - 95}, 'slow');
				$(PP.plan.psd).focus();
				return;
			}
			/* Project Committed Date */
			if ($(PP.plan.pcd).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
				flag = true;
				$(PP.plan.pcdmsg).html(VALIDNOT);
			} else {
				flag = false;
				$(PP.plan.pcdmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(PP.plan.pcdmsg).offset().top) - 95}, 'slow');
				$(PP.plan.pcd).focus();
				return;
			}
			/* Seen / Discussed */
			var seen = $(PP.plan.seen).val();
			if (seen != 'NULL') {
				flag = true;
			} else {
				flag = false;
				$(PP.plan.seenmsg).html('<strong class="text-danger">Seen / Discussed.</strong>');
				$('html, body').animate({
					scrollTop: Number($(PP.plan.seenmsg).offset().top) - 95
				}, 'slow');
				$(PP.plan.seen).focus();
				return;
			}
			/* Details / Obstacles / Progress / Remarks */
			var prjstts = $('#' + PP.plan.prjstts).val();
			if (prjstts != 'NULL') {
				flag = true;
			} else {
				flag = false;
				$('#' + PP.plan.prjsttsmsg).html('<strong class="text-danger">Details / Obstacles / Progress / Remarks.</strong>');
				$('html, body').animate({
					scrollTop: Number($('#' + PP.plan.prjsttsmsg).offset().top) - 95
				}, 'slow');
				$('#' + PP.plan.prjstts).focus();
				return;
			}
			/* Met time line / Status */
			var tm = $(PP.plan.tm).val();
			if (tm != 'NULL') {
				flag = true;
			} else {
				flag = false;
				$(PP.plan.tmmsg).html('<strong class="text-danger">Met timeline / Status.</strong>');
				$('html, body').animate({
					scrollTop: Number($(PP.plan.tmmsg).offset().top) - 95
				}, 'slow');
				$(PP.plan.tm).focus();
				return;
			}
			/* Task to production */
			for(i=0;i<prjtasks.Painting.length;i++){
				var prd = $(prjtasks.Painting[i].prrd_DOM).val();
				var id = prjtasks.Painting[i].id;
				prod.push({
					taskid:id,
					production: (prd != 'NULL') ? prd : 'No'
				});
			}
			for(i=0;i<prjtasks.Production.length;i++){
				var prd = $(prjtasks.Production[i].prrd_DOM).val();
				var id = prjtasks.Production[i].id;
				prod.push({
					taskid:id,
					production: (prd != 'NULL') ? prd : 'No'
				});
			}
			/* Assignee */
			for(i=0;i<prjtasks.Painting.length;i++){
				var asn = $(prjtasks.Painting[i].assn_DOM).val();
				var id = prjtasks.Painting[i].id;
				var sms = $(prjtasks.Painting[i].sms_DOM).val();
				assn.push({
					taskid:id,
					assnid: (asn != 'NULL') ? asn : 0,
					sms:sms
				});
			}
			for(i=0;i<prjtasks.Production.length;i++){
				var asn = $(prjtasks.Production[i].assn_DOM).val();
				var id = prjtasks.Production[i].id;
				var sms = $(prjtasks.Production[i].sms_DOM).val();
				assn.push({
					taskid:id,
					assnid: (asn != 'NULL') ? asn : 0,
					sms:sms
				});
			}
			if(flag){
				var attr = {
					pname:$.trim(PP.plan.require.pname),
					prjname:$.trim($('#'+PP.plan.require.Qrequi_type+' option:selected').text()),
					prjmid:PP.plan.require.prjmid,
					requi_id:PP.plan.require.requi_id,
					quot_id:PP.plan.require.quot_id,
					po_id:PP.plan.require.po_id,
					inv_id:PP.plan.require.inv_id,
					client_id:PP.plan.require.client_id,
					ethno_id:PP.plan.require.ethno_id,
					ind:PP.plan.require.ind,
					rep_id:PP.plan.require.rep_id,
					ref_no:PP.plan.require.ref_no,
					ethno:PP.plan.require.ethno,
					rep:PP.plan.require.rep,
					doethn:$(PP.plan.require.doethno).val(),
					artype:PP.plan.require.artype,
					mdid:PP.plan.mdid,
					mngid:PP.plan.mngid,
					engid:PP.plan.engid,
					hldid:PP.plan.hldid,
					sd:$(PP.plan.psd).val(),
					cd:$(PP.plan.pcd).val(),
					sn:seen,
					st:prjstts,
					mt:tm,
					prod:prod,
					assn:assn
				};
				$(PP.plan.but).prop('disabled', 'disabled');
				$(PP.msgDiv).html('');
				$.ajax({
					url: PP.plan.url,
					type: 'POST',
					data: {
						autoloader: true,
						action: 'createProjectPlan',
						pp: attr
					},
					success: function(data, textStatus, xhr) {
						data = $.trim(data);
						switch (data) {
							case 'logout':
								logoutAdmin({});
								break;
							case 'login':
								loginAdmin({});
								break;
							default:
								$(PP.msgDiv).html('<h2>Project Plan created</h2>');
								$('html, body').animate({
									scrollTop: Number($(PP.msgDiv).offset().top) - 95
								}, 'slow');
								break;
						}
					},
					error: function() {
						$(PP.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
						$(PP.plan.but).removeAttr('disabled');
					}
				});
			}
		};
	}