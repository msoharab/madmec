function controlCustomerAddGroup() {
	var ag = {};
	var list = {};
	var mopname = {
		options : '',
		textboxes : [],
		num : 0
	};
	var jsonmop = {};
	var gymid = $(DGYM_ID).attr("name");
	var listofusers = new Array();
	this.__construct = function (addgm) {
		ag = addgm;
		ag.feerow.mop.gymid = gymid;
		fetchmodeofpayment();
		fetchMemberList();
		$(ag.but).click(function (evt) {
			evt.preventDefault();
			addGroup();
		});
	};
	function fetchmodeofpayment() {
		var mop = ag.feerow.mop;
		$.ajax({
			url : mop.url,
			type : 'POST',
			async : false,
			data : {
				autoloader : mop.autoloader,
				action : mop.action,
				id : mop.gymid,
				gymid : mop.gymid,
				type : mop.type
			},
			success : function (data) {
				jsonmop = $.parseJSON($.trim(data));
				if (data == 'logout') {
					logoutAdmin({});
				} else {
					addModeOfPayment();
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {}
		});
	};
	function addModeOfPayment() {
		var feerow = ag.feerow;
		var mop = ag.feerow.mop;
		if (ag.feerow.num === -1) {
			$(feerow.parentdiv).html('');
		}
		ag.feerow.num++;
		var feerow = ag.feerow;
		var mop = ag.feerow.mop;
		var new_num = ag.feerow.num;
		var textboxhtml = prepareMOPHTML();
		$(feerow.parentdiv).append(
			'<div class="row" id="' + feerow.row + '_' + new_num + '">' +
			'<fieldset id="' + feerow.addfeeform + '_' + new_num + '">' +
			'<div class="col-lg-12">' +
			'<div class="col-md-3">' +
			'<select name="' + feerow.selectBox + '_' + new_num + '" id="' + feerow.selectBox + '_' + new_num + '" class="form-control">' +
			'<option value="NULL" selected>Select Mode Of Payment</option>' + mopname.options + '</select><p class="help-block" id="' + feerow.selectBoxMsg + '_' + new_num + '">&nbsp;</p>' +
			'</div>' +
			'<div class="col-md-3">' +
			'<input name="user_fee"   type="number" value="0" id="' + feerow.amt + '_' + new_num + '" class="form-control" required="required" pattern="[0-9]{1,10}$" maxlength="10"/>' +
			'<p class="help-block" id="' + feerow.amtmsg + '_' + new_num + '">&nbsp;</p></div>' +
			'<div class="col-md-3" id="' + feerow.textboxGrp + '_' + new_num + '">' + textboxhtml + '</div>' +
			'<div class="col-md-3">' +
			'<a id="' + feerow.plus + '_' + new_num + '" class="btn btn-success " href="javascript:void(0);"><i class="fa fa-plus"></i></a>&nbsp;' +
			'<a id="' + feerow.minus + '_' + new_num + '" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-minus"></i></a>' +
			'</div></div></fieldset></div>');
		bindModeOfPayments({
			plus : '#' + feerow.plus + '_' + new_num,
			minus : '#' + feerow.minus + '_' + new_num,
			selectBox : '#' + feerow.selectBox + '_' + new_num,
			keycodes : feerow.keycodes,
			nnum : new_num
		});
	};
	function prepareMOPHTML() {
		var feerow = ag.feerow;
		var mop = ag.feerow.mop;
		var textboxhtml = '';
		mopname.options = '';
		if (jsonmop.length > 0) {
			mopname.textboxes[feerow.num] = [];
			for (p = 0; p < jsonmop.length; p++) {
				mopname.options += jsonmop[p]["html"];
				if ((jsonmop[p]["mopname"].toLowerCase()) != "cash") {
					var temp = '<input name="' + feerow.mopnum + '_' + jsonmop[p]["id"] + '_' + feerow.num +
						'" type="text" placeholder="' + jsonmop[p]["mopname"] + ' Number" id="' + feerow.mopnum + '_' + jsonmop[p]["id"] + '_' + feerow.num +
						'" class="form-control" style="display:none;"/>';
					textboxhtml += temp;
					mopname.textboxes[feerow.num].push({
						htm : temp,
						name : $.trim(jsonmop[p]["mopname"]),
						idVal : '#' + feerow.mopnum + '_' + jsonmop[p]["id"] + '_' + feerow.num,
						id : $.trim(jsonmop[p]["id"])
					});
				}
			}
		}
		return textboxhtml;
	};
	function bindModeOfPayments(para) {
		var feerow = ag.feerow;
		var mop = ag.feerow.mop;
		$(para.minus).on("click", {
			para : para
		}, function (evt) {
			var para = evt.data.para;
			if (para.nnum > -1) {
				var tot = Number($.trim($(para.keycodes).text()));
				if (tot > 0) {
					tot -= 1;
					$(para.keycodes).text(tot);
					$('#' + feerow.plus + '_' + tot).show();
					$('#' + feerow.minus + '_' + tot).show();
					$('#' + feerow.row + '_' + para.nnum).remove();
					ag.feerow.num--;
				}
			}
		});
		$(para.plus).on("click", {
			para : para
		}, function (evt) {
			var para = evt.data.para;
			$(para.plus).hide();
			$(para.minus).hide();
			addModeOfPayment();
		});
		$(para.selectBox).on("change", {
			para : para
		}, function (evt) {
			var para = evt.data.para;
			ShowTextBox({
				num : para.nnum,
				id : this.value
			});
		});
		$(para.keycodes).text(para.nnum);
		bindKeyupFee(para.nnum);
	};
	function bindKeyupFee(new_num) {
		var feerow = ag.feerow;
		for (i = 0; i <= new_num; i++) {
			$('#' + feerow.amt + '_' + i).on("keyup", function () {
				$(this).val(Number($(this).val()));
				var amt = Number($(this).val());
				$(this).val(Number(amt));
				if (amt < 0) {
					$(this).val(0);
				}
			});
		}
	}
	function ShowTextBox(para) {
		for (p = 0; p < mopname.textboxes[para.num].length; p++) {
			$(mopname.textboxes[para.num][p].idVal).hide();
		}
		for (p = 0; p < mopname.textboxes[para.num].length; p++) {
			if (mopname.textboxes[para.num][p].id == para.id) {
				$(mopname.textboxes[para.num][p].idVal).show();
				break;
			}
		}
	};
	function fetchMemberList() {
		var memberlist = ag.memberlist;
		$.ajax({
			url : memberlist.url,
			type : 'POST',
			async : false,
			data : {
				autoloader : memberlist.autoloader,
				action : memberlist.action,
				type : memberlist.type
			},
			success : function (data) {
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					list = $.parseJSON($.trim(data));
					$(memberlist.outputDiv).html(list.html);
					if (list.status === true) {
						bindAutoCompleteMemList();
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
	function bindAutoCompleteMemList() {
		var listofPeoples = list.listofPeoples;
		var listofimages = list.listofimages;
		$(list.msg_to).autocomplete({
			source : listofPeoples,
			autoFocus : true,
			minLength : 1,
			delay : 0,
			select : function (event, ui) {
				listofusers.push({
					index : ui.item.value,
					id : ui.item.id
				});
				$(list.mem_counter).html(Number($(list.mem_counter).html()) + 1);
				$(list.msg_to).val("");
				var i = 0;
				for (var key in listofimages) {
					if (ui.item.value == listofimages[key].value && listofimages[key].value == i) {
						var htm = '<li class="left clearfix" id="item_' + ui.item.value + '" style="cursor:pointer;"><span class="chat-img pull-left">'
							 + listofimages[key].label + '</span><div class="chat-body clearfix"><div class="header"><strong class="primary-font img-circle">'
							 + ui.item.value + '</strong><small class="pull-right"><a href="javascript:void(0);" class="btn btn-sm btn-danger" id="removeme_'
							 + ui.item.value + '""><i class="fa fa-close fa-fw"></i></a>&nbsp;<input type="hidden" id="prod_promoter" value="'
							 + ui.item.value + '" /></small></div><p>' + ui.item.label + '</p></div></li>';
						$(list.listdiv).append(htm);
						$(list.listdiv).parent().animate({
							scrollTop : $(list.listdiv)[0].scrollHeight
						}, 500);
						$("#removeme_" + ui.item.value).click(function () {
							$(list.mem_counter).html(Number($(list.mem_counter).html()) - 1);
							listofPeoples.push({
								label : ui.item.label,
								value : ui.item.value,
								id : ui.item.id
							});
							$(list.msg_to).autocomplete("option", "source", listofPeoples);
							$("#item_" + ui.item.value).remove();
							listofusers = listofusers.filter(function (el) {
									return el.id != ui.item.id;
								});
						});
						break;
					}
					i++;
				}
				listofPeoples = listofPeoples.filter(function (el) {
						return el.label != ui.item.label;
					});
				$(this).autocomplete("option", "source", listofPeoples);
				$(this).val("");
				return false;
			}
		}).focus(function () {
			$(this).find("input").select();
			$(this).select();
		}).data("ui-autocomplete")._renderItem = function (ul, item) {
			var i = 0;
			for (var key in listofimages) {
				if (item.value == listofimages[key].value && listofimages[key].value == i) {
					return $("<li></li>").data("item.autocomplete", item).append("<a>" + listofimages[key].label + "&nbsp;" + item.label + "</a>").appendTo(ul);
				}
				i++;
			}
		};
		$(list.clear).on("click", function (evt) {
			evt.preventDefault();
			$(list.msg_to).val("");
			$(list.listdiv).html("");
			$(list.msg_to).removeAttr("readonly");
		});
		$(list.reset).on("click", function (evt) {
			evt.preventDefault();
			$(list.msg_to).val("");
			$(list.mem_counter).html("0");
			$(list.listdiv).html("");
			$(list.msg_to).autocomplete("option", "source", list.listofPeoples);
			$(list.msg_to).removeAttr("readonly");
		});
	};
	function validateGCustomerFields() {
		var max_mop = Number($('#keycodes').text());
		var amount = new Array();
		var sum_amount = 0;
		var mod_pay = new Array();
		var transaction_type = '';
		var transaction_number = new Array();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var amount_reg = /^[0-9]{0,10}$/;
		for (i = 1; i <= max_mop; i++) {
			amount[i] = $('#grp_fee_mop_' + i).val();
			if (amount[i].match(amount_reg)) {
				$('#user_fee_msg_' + i).hide();
				sum_amount += Number(amount[i]);
			} else {
				$('#user_fee_msg_' + i).show();
				flag = false;
			}
			mod_pay[i] = $('#grp_mod_pay_' + i).select().val();
			if (mod_pay[i] != 'NULL') {
				$('#user_fee_msg_' + i).hide();
			} else {
				$('#user_fee_msg_' + i).show();
				flag = false;
			}
			/* cheque number, PDC number, Card number */
			/*if(i>1){*/
			if (mod_pay[i] != 'NULL') {
				transaction_number[i] = $('#moptext_' + mod_pay[i + 1] + '_' + i).val();
			} else {
				transaction_number[i] = "Cash";
			}
			/*}  */
		}
		/*console.log(max_mop);*/
		/*console.log(amount);*/
		/*console.log(sum_amount);*/
		/*console.log(mod_pay);*/
		/*console.log(transaction_number);*/
		/*alert("sex value=");*/
		/*alert($(agd.sex+i+' :selected').val());*/
		if (ag.num > 2) {
			gtype = "Group";
		} else {
			gtype = "Couple";
		}
		/*Group Name*/
		if ($(agd.groupname).val().match(name_reg)) {
			flag = true;
			$(agd.gnamemsg).html(VALIDNOT);
		} else {
			gcount++;
			$(agd.gnamemsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($(agd.gnamemsg).offset().top) - 55
			}, "slow");
			$(agd.groupname).focus();
			return;
		}
		for (i = 1; i <= ag.num; i++) {
			if ($(agd.name + i).val().match(name_reg)) {
				flag = true;
				$(agd.nmsg + i).html(VALIDNOT);
			} else {
				gcount++;
				flag = false;
				$(agd.nmsg + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.name + i).offset().top) - 55
				}, "slow");
				$(agd.name + i).focus();
				return;
			}
			/* country */
			if ($(agd.country + i).val().replace(/  +/g, ' ').match(nm_reg)) {
				flag = true;
				$(agd.mcountry + i).html(VALIDNOT);
			} else {
				flag = false;
				$(agd.mcountry + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.mcountry + i).offset().top) - 95
				}, "slow");
				$(agd.country + i).focus();
				return;
			}
			/* provice */
			if ($(agd.state + i).val().replace(/  +/g, ' ').match(nm_reg)) {
				flag = true;
				$(agd.mstate + i).html(VALIDNOT);
			} else {
				flag = false;
				$(agd.mstate + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.mstate + i).offset().top) - 95
				}, "slow");
				$(agd.mstate + i).focus();
				return;
			}
			/* distrinct */
			if ($(agd.district + i).val().replace(/  +/g, ' ').match(nm_reg)) {
				flag = true;
				$(agd.mdistrict + i).html(VALIDNOT);
			} else {
				flag = false;
				$(agd.mdistrict + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.mdistrict + i).offset().top) - 95
				}, "slow");
				$(agd.mdistrict + i).focus();
				return;
			}
			/* sex type*/
			if (($(agd.sex + i + ' :selected').val()) != 'NULL' && ($(agd.sex + i + ' :selected').val()) != '') {
				flag = true;
				$(agd.smsg + i).html(VALIDNOT);
			} else {
				flag = false;
				gcount++;
				$(agd.smsg + i).html('<strong class="text-danger">Select sex type.</strong>');
				$('html, body').animate({
					scrollTop : Number($(agd.sex + i).offset().top) - 55
				}, "slow");
				$(agd.sex + i).focus();
				return;
			}
			/* refer mname */
			if (($(agd.referBox + i).val()) != '' && ($(agd.referBox + i).val()) != 'NULL') {
				flag = true;
				$(agd.mrefer + i).html(VALIDNOT);
			} else {
				flag = false;
				gcount++;
				$(agd.mrefer + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.referBox + i).offset().top) - 95
				}, "slow");
				$(agd.referBox + i).focus();
				return;
			}
			/* Email */
			if (($(agd.cemail + i).val()) != '' && ($(agd.cemail + i).val()) != 'NULL') {
				flag = true;
				$(agd.memail + i).html(VALIDNOT);
			} else {
				flag = false;
				gcount++;
				$(agd.memail + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.cemail + i).offset().top) - 95
				}, "slow");
				$(agd.cemail + i).focus();
				return;
			}
			/* cell code */
			if (($(agd.ccellcode + i).val()) != '' && ($(agd.ccellcode + i).val()) != 'NULL') {
				flag = true;
				$(agd.mcellcd + i).html(VALIDNOT);
			} else {
				flag = false;
				gcount++;
				$(agd.mcellcd + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.ccellcode + i).offset().top) - 95
				}, "slow");
				$(agd.ccellcode + i).focus();
				return;
			}
			/* Cell Number */
			if (($(agd.ccellnum + i).val()) != '' && ($(agd.ccellnum + i).val()) != 'NULL') {
				flag = true;
				$(agd.mcell + i).html(VALIDNOT);
			} else {
				flag = false;
				gcount++;
				$(agd.mcell + i).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(agd.ccellnum + i).offset().top) - 95
				}, "slow");
				$(agd.ccellnum + i).focus();
				return;
			}
			/* company */
			/*if(($(agd.company+i).val().match(name_reg)) && ($(agd.company+i).val()) != '' && ($(agd.company+i).val()) != 'NULL' ){*/
			/*flag = true;*/
			/*$(agd.mcomp+i).html(VALIDNOT);*/
			/*}*/
			/*else{*/
			/*flag = false;*/
			/*gcount++;*/
			/*$(agd.mcomp+i).html(INVALIDNOT);*/
			/*$('html, body').animate({scrollTop: Number($(agd.company+i).offset().top)-95}, "slow");*/
			/*$(agd.company+i).focus();*/
			/*return;*/
			/*}*/
		}
		if (gcount == 0) {
			for (i = 1; i <= ag.num; i++) {
				var occup = ($('#custg_occ_' + i + ' :selected').val());
				/*alert("i="+i);*/
				/*var occup = "student";*/
				info[i] = {
					max_mop : max_mop,
					amount : amount,
					sum_amount : sum_amount,
					mod_pay : mod_pay,
					transaction_number : transaction_number,
					groupname : $(agd.groupname).val(),
					groupemail : $("#groupmainemail").val(),
					gtype : gtype,
					name : $(agd.name + i).val(),
					email : $(agd.cemail + i).val(),
					cellcode : $(agd.ccellcode + i).val(),
					cellnum : $(agd.ccellnum + i).val(),
					occu : occup,
					dob : convertDateFormat($(agd.dob + i).val()),
					sex_type : $(agd.sex + i + ' :selected').val(),
					doj : convertDateFormat($(agd.doj + i).val()),
					emnm : $(agd.ename + i).val(),
					emnum : $(agd.enumber + i).val(),
					addr : $(agd.address + i).val(),
					town : $("#gymg_city_town_" + i).val(),
					city : $("#gymg_city_town_" + i).val(),
					district : $(agd.district + i).val(),
					province : $(agd.state + i).val(),
					country : $(agd.country + i).val(),
					company : $(agd.company + i).val(),
				};
				console.log("info=");
				console.log(info[i]);
			}
			return info;
		} else {
			console.log("count=" + gcount);
			return false;
		}
	};
	function addGroup(){
		var attr = validateGCustomerFields();
		if (attr) {
			$(ag.but).prop('disabled', 'disabled');
			$(loader).html(LOADER_SIX);
			$.ajax({
				url : ag.url,
				type : 'POST',
				data : {
					autoloader : ag.autoloader,
					action : ag.action,
					type : ag.type,
					gadd : attr,
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
						console.log(data);
						$(ag.outputDiv).html(data);
						break;
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					$(ag.but).removeAttr('disabled');
				}
			});
		} else {
			$(ag.but).removeAttr('disabled');
		}
	};
};
