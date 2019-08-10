function controlEnquiry() {
	var enq = {};
	var ead = {};
	var em = {};
	var cn = {};
	var dccode = '+91';
	var dpcode = '080';
	var gymid = $(DGYM_ID).attr("name");
	this.__construct = function (enquiry) {
		enq = enquiry;
		ead = enquiry.add;
		em = enquiry.em;
		cn = enquiry.cn;
		$("#" + ead.f1).datepicker({
			dateFormat : 'dd-M-yy',
			setDate : new Date(),
			minDate : new Date(),
		});
		$("#" + ead.f2).datepicker({
			dateFormat : 'dd-M-yy',
			beforeShow : function () {
				jQuery(this).datepicker('option', 'minDate', $("#" + ead.f1).val());
			}
		});
		$("#" + ead.f3).datepicker({
			dateFormat : 'dd-M-yy',
			beforeShow : function () {
				jQuery(this).datepicker('option', 'minDate', $("#" + ead.f1).val());
			}
		});
		$("#" + ead.f1).val($.datepicker.formatDate('dd-M-yy', new Date()));
		$(document).keypress(function (e) {
			if (e.keyCode == 13) {
				enquiryAdd();
			}
		});
		$("#" + ead.but).bind("click", function () {
			enquiryAdd();
		});
		fetchKnowAboutUS();
		fetchInterestedIn();
		addEnqAutoComplete();
	};
	function fetchKnowAboutUS() {
		var rad = '';
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'fetchKnowAboutUS',
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
					var type = $.parseJSON($.trim(data));
					listofvaliditytypes = type;
					for (i = 0; i < type.length; i++) {
						rad += type[i]["html"];
					}
					$("#" + ead.knwabt).html('<option value="NULL" selected>Select know about us</option>' + rad);
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
	};
	function fetchInterestedIn() {
		var rad = '';
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
				data = $.trim(data);
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					var type = $.parseJSON($.trim(data));
					listofvaliditytypes = type;
					for (i = 0; i < type.length; i++) {
						if (i == 0)
							rad += '<option selected  value="' + type[i]["id"] + '">' + type[i]["html"] + '</option>';
						else
							rad += '<option  value="' + type[i]["id"] + '">' + type[i]["html"] + '</option>';
					}
					$("#" + ead.instin).html(rad);
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
	};
	function addEnqAutoComplete() {
		$.ajax({
			url : enq.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'autoCompleteEnq',
				type : 'slave',
				gymid : gymid
			},
			success : function (data, textStatus, xhr) {
				data = $.parseJSON($.trim(data));
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					listofPeoples = data.listofPeoples;
					listofEmp = data.listofEmp;
					$referred = $("#" + ead.refer);
					$referred.autocomplete({
						minLength : 0,
						source : listofPeoples,
						focus : function (event, ui) {
							$referred.val(ui.item.label);
							return false;
						},
						select : function (event, ui) {
							$referred.val(ui.item.label);
							$referred.attr('name', ui.item.label);
							console.log($("#" + ead.refer).attr('name'));
							return false;
						},
					});
					$referred.data("ui-autocomplete")._renderItem = function (ul, item) {
						var $li = $('<li>'),
						$img = $('<img>');
						$img.attr({
							src : item.icon,
							alt : item.label,
							width : "30px",
							height : "30px"
						});
						$li.attr('data-value', item.label);
						$li.append('<a href="#">');
						$li.find('a').append($img).append(item.label);
						return $li.appendTo(ul);
					};
					$handel = $("#" + ead.handel);
					$handel.autocomplete({
						minLength : 0,
						source : listofEmp,
						focus : function (event, ui) {
							$handel.val(ui.item.label);
							return false;
						},
						select : function (event, ui) {
							$handel.val(ui.item.label);
							$handel.attr('name', ui.item.label);
							console.log($("#" + ead.handel).attr('name'));
							return false;
						},
					});
					$handel.data("ui-autocomplete")._renderItem = function (ul, item) {
						var $li = $('<li>'),
						$img = $('<img>');
						$img.attr({
							src : item.icon,
							alt : item.label,
							width : "30px",
							height : "30px"
						});
						$li.attr('data-value', item.label);
						$li.append('<a href="#">');
						$li.find('a').append($img).append(item.label);
						return $li.appendTo(ul);
					};
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
	function enquiryAdd() {
		var attr = validateEnqFields();
		if (attr) {
			$("#" + ead.but).prop('disabled', 'disabled');
			$(loader).html(LOADER_SIX);
			$.ajax({
				url : enq.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'enqAdd',
					type : 'slave',
					gymid : gymid,
					eadd : attr
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
						$(loader).hide();
						$("#myModal_enqaddbody").html('<h4>Record success fully added</h4>');
						$("#myModal_enqaddbtn").trigger('click');
						$("#" + ead.form).get(0).reset();
						break;
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					window.setTimeout(function () {
						$("#" + ead.msg).html('');
					}, 2000);
					$("#" + ead.but).removeAttr('disabled');
				}
			});
		} else {
			$("#" + ead.but).removeAttr('disabled');
		}
	};
	function validateEnqFields() {
		var flag = false;
		var email = [];
		var cellnumbers = [];
		var intin = $("#" + ead.instin).val() || [];
		var fol1 = '';
		var fol2 = '';
		var fol3 = '';
		/* Visitor Name*/
		if ($("#" + ead.vname).val().replace(/  +/g, ' ').match(nm_reg)) {
			flag = true;
			$("#" + ead.vnmsg).html(VALIDNOT);
		} else {
			flag = false;
			$("#" + ead.vnmsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($("#" + ead.vnmsg).offset().top) - 95
			}, "slow");
			$("#" + ead.vname).focus();
			return;
		}
		/*email*/
		if ($("#" + ead.email).val().match(email_reg)) {
			flag = true;
			$("#" + ead.emsg).html(VALIDNOT);
		} else {
			flag = false;
			$("#" + ead.emsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($("#" + ead.emsg).offset().top) - 95
			}, "slow");
			$("#" + ead.email).focus();
			return;
		}
		/*Cell Number cell	cmsg*/
		if ($("#" + ead.cell).val().match(cell_reg)) {
			flag = true;
			$("#" + ead.cmsg).html(VALIDNOT);
		} else {
			flag = false;
			$("#" + ead.cmsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($("#" + ead.cmsg).offset().top) - 95
			}, "slow");
			$("#" + ead.cell).focus();
			return;
		}
		/*followupds*/
		if ($("#" + ead.f1).val() != "") {
			if (convertDateFormat($("#" + ead.f1).val()).match(/(\d{4})-(\d{2})-(\d{2})/)) {
				fol1 = convertDateFormat($("#" + ead.f1).val());
			} else {
				fol1 = null;
				$("#" + ead.f1).focus();
				return;
			}
		}
		if ($("#" + ead.f2).val() != "") {
			if (convertDateFormat($("#" + ead.f2).val()).match(/(\d{4})-(\d{2})-(\d{2})/)) {
				fol2 = convertDateFormat($("#" + ead.f2).val());
			} else {
				fol2 = null;
				$("#" + ead.f2).focus();
				return;
			}
		}
		if ($("#" + ead.f3).val() != "") {
			if (convertDateFormat($("#" + ead.f3).val()).match(/(\d{4})-(\d{2})-(\d{2})/)) {
				fol3 = convertDateFormat($("#" + ead.f3).val());
			} else {
				fol3 = null;
				$("#" + ead.f3).focus();
				return;
			}
		}
		/*joining probality*/
		if ($("#" + ead.jop).val() != "selectVal") {
			flag = true;
			$("#jopmsg").html(VALIDNOT);
		} else {
			flag = false;
			$("#jopmsg").html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($("#" + ead.cmsg).offset().top) - 95
			}, "slow");
			$("#" + ead.jop).focus();
			return;
		}
		var attr = {
			referpk : $("#" + ead.refer).val(),
			handelpk : $("#" + ead.handel).val(),
			vname : $("#" + ead.vname).val().replace(/  +/g, ' '),
			email : $("#" + ead.email).val(),
			cell : $("#" + ead.cell).val(),
			f1 : fol1,
			f2 : fol2,
			f3 : fol3,
			knwabt : $("#" + ead.knwabt).val(),
			instin : intin,
			jop : $("#" + ead.jop).val(),
			fgoal : $("#" + ead.fgoal).val(),
			cmt : $("#" + ead.cmt).val(),
		};
		if (flag) {
			return attr;
		} else
			return false;
	};
};
