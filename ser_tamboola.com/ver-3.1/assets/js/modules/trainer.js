function controlTrainer() {
	var tn = {};
	var dccode = '91';
	var gymid = $(DGYM_ID).attr("name");
	this.__construct = function (trainer) {
		tn = trainer;
		$("#" + tn.dob).datepicker({
			dateFormat : 'dd-M-yy',
			changeMonth : true,
			changeYear : true,
			yearRange : '1950:-10',
			defaultDate : new Date(1950, 00, 01),
			showButtonPanel : true,
		});
		$("#" + tn.doj).datepicker({
			dateFormat : 'dd-M-yy',
			changeMonth : true,
			changeYear : true,
			yearRange : '1950:+0',
			showButtonPanel : true,
		});
		$("#" + tn.but).bind("click", function () {
			trainerAdd();
		});
		/*pic edit*/
		$(".picedit_box").picEdit({
			imageUpdated : function (img) {},
			formSubmitted : function (data) {},
			redirectUrl : false,
			defaultImage : URL + ASSET_IMG + 'No_image.png',
		});
		AddDummyEmail();
		fetchTrainerType();
		fetchInterestedIn();
		fetchGenderType();
		$("#" + tn.email).on('blur', function () {
			checkValidValue();
		});
	};
	function checkValidValue() {
		var flag = false;
		em = $('#' + tn.email).val();
		console.log(em);
		$("#" + tn.emsg).html("Checking...");
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'checkEmailEmp',
				type : 'master',
				gymid : gymid,
				email : em
			},
			success : function (data) {
				data = $.parseJSON($.trim(data));
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					if (data.flag) {
						flag = true;
						$("#" + tn.emsg).html(VALIDNOT);
					} else {
						flag = false;
						$("#" + tn.emsg).html("<strong class='text-danger'>Email Already Taken</strong>");
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
		return flag;
	}
	function fetchGenderType() {
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'cust_sex',
				type : 'master',
				gymid : gymid
			},
			success : function (data) {
				/*console.log(data);*/
				if (data == 'logout')
					window.location.href = URL;
				else {
					$("#" + tn.sex).html(data);
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
	function AddDummyEmail() {
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'AddDummyEmail',
				type : 'master',
				gymid : gymid
			},
			success : function (data) {
				data = $.trim(data);
				console.log(data);
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$("#" + tn.email).val(data);
					$("#" + tn.emsg).html(VALIDNOT);
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
						rad += '<option  value="' + type[i]["id"] + '">' + type[i]["html"] + '</option>';
					}
					$("#" + tn.ftype).html('<option value="NULL" selected>Select facility Type</option>' + rad);
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
	function fetchTrainerType() {
		var rad = '';
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'fetchTrainerType',
				type : 'master',
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
						rad += '<option  value="' + type[i]["id"] + '">' + type[i]["html"] + '</option>';
					}
					$("#" + tn.ttype).html('<option value="NULL" selected>Select Employee Type</option>' + rad);
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
	function trainerAdd() {
		console.log("im here to add trainer");
		var attr = validateTrainerFields();
		console.log(attr);
		if (attr) {
			$("#" + tn.but).prop('disabled', 'disabled');
			$(loader).html(LOADER_SIX);
			$.ajax({
				url : tn.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'trainerAdd',
					type : 'slave',
					gymid : gymid,
					eadd : attr
				},
				success : function (data, textStatus, xhr) {
					data = $.parseJSON($.trim(data));
					/*~ //console.log(data.photo_id);*/
					switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					case 'login':
						loginAdmin({});
						break;
					default:
						$(loader).hide();
						$("#myModal_body").html('<h4>Record success fully added</h4>');
						$("#myModal_btn").trigger('click');
						$("#" + tn.form).get(0).reset();
						$("#photo_id").val(data.semp_pk);
						$("#user_id").val(data.user_id);
						$("#okayModal").on('click', function () {
							window.setTimeout(function () {
								$("#" + tn.phupload).trigger('click');
							}, 1000);
						});
						$("#close_photo").trigger('click');
						break;
					}
				},
				error : function () {
					$("#" + tn.msg).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
					window.setTimeout(function () {
						$("#" + tn.msg).html('');
					}, 2000);
					$("#" + tn.but).removeAttr('disabled');
				}
			});
		} else {
			$("#" + tn.but).removeAttr('disabled');
		}
	}
	function validateTrainerFields() {
		var flag = false;
		var sex = $("#" + tn.sex).val();
		var ftype = $("#" + tn.ftype).val();
		var ttype = $("#" + tn.ttype).val();
		/* name */
		if ($('#' + tn.name).val().replace(/  +/g, ' ').match(nm_reg)) {
			flag = true;
			$("#" + tn.nmsg).html(VALIDNOT);
		} else {
			flag = false;
			$('#' + tn.nmsg).html(INVALIDNOT);
			$('#' + tn.name).focus();
			$('html, body').animate({
				scrollTop : Number($('#' + tn.nmsg).offset().top) - 95
			}, "slow");
			$('#' + tn.nmsg).focus();
			return;
		}
		/* sex type*/
		if (sex != 'NULL' && sex != '') {
			flag = true;
			$('#' + tn.smsg).html(VALIDNOT);
		} else {
			flag = false;
			$("#" + tn.sex).focus();
			$('#' + tn.smsg).html('<strong class="text-danger">Select sex type.</strong>');
			$('html, body').animate({
				scrollTop : Number($('#' + tn.smsg).offset().top) - 95
			}, "slow");
			return;
		}
		/* facility type*/
		if (ftype != 'NULL' && ftype != '') {
			flag = true;
			$('#' + tn.fmsg).html(VALIDNOT);
		} else {
			flag = false;
			$("#" + tn.ftype).focus();
			$('#' + tn.fmsg).html('<strong class="text-danger">Select facility type.</strong>');
			$('html, body').animate({
				scrollTop : Number($('#' + tn.fmsg).offset().top) - 95
			}, "slow");
			return;
		}
		/* trainer type*/
		if (ttype != 'NULL' && ttype != '') {
			flag = true;
			$('#' + tn.tmsg).html(VALIDNOT);
		} else {
			flag = false;
			$("#" + tn.ttype).focus();
			$('#' + tn.tmsg).html('<strong class="text-danger">Select Trainer type.</strong>');
			$('html, body').animate({
				scrollTop : Number($('#' + tn.tmsg).offset().top) - 95
			}, "slow");
			return;
		}
		/* email */
		if (($('#' + tn.email).val().match(email_reg))) {
			flag = true;
			$("#" + tn.emsg).html(VALIDNOT);
		} else {
			flag = false;
			$('#' + tn.emsg).html(INVALIDNOT);
			$('#' + tn.email).focus();
			$('html, body').animate({
				scrollTop : Number($('#' + tn.emsg).offset().top) - 95
			}, "slow");
			$('#' + tn.emsg).focus();
			return;
		}
		/*~ var temp = checkValidValue();*/
		/*~ console.log(temp);*/
		/*~ if(temp){*/
		/*~ if(($('#'+tn.email).val().match(email_reg))){*/
		/*~ flag = true;*/
		/*~ //$("#"+tn.emsg).html(VALIDNOT);*/
		/*~ }*/
		/*~ else{*/
		/*~ flag = false;*/
		/*~ $('#'+tn.emsg).html(INVALIDNOT);*/
		/*~ $('#'+tn.email).focus();*/
		/*~ $('html, body').animate({scrollTop: Number($('#'+tn.emsg).offset().top)-95}, "slow");*/
		/*~ $('#'+tn.emsg).focus();*/
		/*~ return;*/
		/*~ }*/
		/*~ }*/
		/*~ else{*/
		/*~ flag = false;*/
		/*~ $('#'+tn.email).focus();*/
		/*~ $('html, body').animate({scrollTop: Number($('#'+tn.emsg).offset().top)-95}, "slow");*/
		/*~ $('#'+tn.emsg).focus();*/
		/*~ return;*/
		/*~ }*/
		/* cellcode */
		if ($('#' + tn.ccode).val().match(ccod_reg)) {
			flag = true;
			$("#" + tn.cmsg).html(VALIDNOT);
		} else {
			flag = false;
			$('#' + tn.cmsg).html(INVALIDNOT);
			$('#' + tn.ccode).focus();
			$('html, body').animate({
				scrollTop : Number($('#' + tn.cmsg).offset().top) - 95
			}, "slow");
			$('#' + tn.cmsg).focus();
			return;
		}
		/* cellnumber */
		if ($('#' + tn.mobile).val().match(cell_reg)) {
			flag = true;
			$("#" + tn.mmsg).html(VALIDNOT);
		} else {
			flag = false;
			$('#' + tn.mmsg).html(INVALIDNOT);
			$('#' + tn.mobile).focus();
			$('html, body').animate({
				scrollTop : Number($('#' + tn.mmsg).offset().top) - 95
			}, "slow");
			$('#' + tn.mmsg).focus();
			return;
		}
		var dateofbirth = convertDateFormat($('#' + tn.dob).val());
		var dateofjoin = convertDateFormat($('#' + tn.doj).val());
		var dob = new Date(dateofbirth);
		var doj = new Date(dateofjoin);
                if($('#' + tn.dob).val() != "")
                {
		if (dob < doj) {
			flag = true;
			$("#" + tn.dob_msg).html(VALIDNOT);
			$("#" + tn.doj_msg).html(VALIDNOT);
		} else {
			flag = false;
			$("#" + tn.doj_msg).html(INVALIDNOT);
			$('#' + tn.doj).focus();
		}
                }
		var attr = {
			name : $('#' + tn.name).val().replace(/  +/g, ' '),
			sex_type : sex,
			facility_type : ftype,
			trainer_type : ttype,
			email : $('#' + tn.email).val(),
			cellcode : $('#' + tn.ccode).val(),
			cellnum : $('#' + tn.mobile).val(),
			dob : convertDateFormat($('#' + tn.dob).val()),
			doj : convertDateFormat($('#' + tn.doj).val()),
		};
		if (flag) {
			return attr;
		} else
			return false;
	};
};
