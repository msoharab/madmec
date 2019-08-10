function controlCustomerAddGroup() {
	var ag = {};
	var list = {};
	var mopname = {
		options : '',
		textboxes : [],
		num : -1
	};
	var jsonmop = {};
	var gymid = $(DGYM_ID).attr("name");
	var listofusers = {
		array : '',
		list : new Array()
	};
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
					mopname.num++;
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
					mopname.textboxes.pop();
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
						listofusers.array = list.array;
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
				listofusers.list.push({
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
							listofusers.list = listofusers.list.filter(function (el) {
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
		var feerow = ag.feerow;
		var mop = ag.feerow.mop;
		var max_mop = Number($(feerow.keycodes).text());
		var amount = new Array();
		var sum_amount = 0;
		var mod_pay = new Array();
		var transaction_type = '';
		var transaction_number = new Array();
		var flag = false;
		var attr = {
			name:'',
			descp:'',
			members:'',
			array:'',
			max_mop : '',
			amount : '',
			sum_amount : 0,
			mod_pay : '',
			transaction_number : 0,
			status:flag
		};
		for (i = 0; i <= max_mop; i++) {
			var temp = {
				selectBox : '#' + feerow.selectBox + '_' + i,
				selectBoxMsg : '#' + feerow.selectBoxMsg + '_' + i,
				amt : '#' + feerow.amt + '_' + i,
				amtmsg : '#' + feerow.amtmsg + '_' + i
			};
			amount[i] = $(temp.amt).val();
			if (amount[i].match(number_reg)) {
				$(temp.amtmsg).html(VALIDNOT);
				sum_amount += Number(amount[i]);
				flag = true;
			} else {
				$(temp.amtmsg).html(INVALIDNOT);
				flag = false;
			}
			mod_pay[i] = $(temp.selectBox).val();
			if (mod_pay[i] != 'NULL') {
				$(temp.selectBoxMsg).html(VALIDNOT);
				flag = true;
			} else {
				$(temp.selectBoxMsg).html(INVALIDNOT);
				flag = false;
			}
			for(j=0;j<mopname.textboxes[i].length;j++){
				if(mod_pay[i] != 'NULL' && Number(mopname.textboxes[i][j].id) === Number(mod_pay[i])){
					transaction_number[i] = $(mopname.textboxes[i][j].idVal).val();
					break;
				}
				else {
					transaction_number[i] = 'Cash';
				}
			}
		}
		if($(ag.gname).val().match(name_reg)){
			$(ag.gnamemag).html(VALIDNOT);
			flag = true;
		} else{
			$(ag.gnamemag).html(INVALIDNOT);
			flag = false;
		}
		if(listofusers.list.length > 1){
			flag = true;
		} else{
			alert('Minimum two customers have to be added in group');
			flag = false;
		}
		if(flag){
			attr = {
				name:$(ag.gname).val(),
				descp:$(ag.gdescp).val(),
				members:listofusers.list,
				array:listofusers.array,
				max_mop : mod_pay.length,
				amount : amount,
				sum_amount : sum_amount,
				mod_pay : mod_pay,
				transaction_number : transaction_number,
				status:flag
			};
		}
		return attr;
	};
	function addGroup(){
		var attr = validateGCustomerFields();
		console.log(attr);
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
					gymid : gymid
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
