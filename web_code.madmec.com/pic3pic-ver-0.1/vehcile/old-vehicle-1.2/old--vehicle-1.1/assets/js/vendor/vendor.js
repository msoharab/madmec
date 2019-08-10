function doctorcontroller() {
	var doctor = {};
	this.__construct = function (ctrl) {
		doctor = ctrl;
		$(doctor.appointment.appointconfigBut).click(function () {
			fetchconfiguredappointment();
			var numbb = $(doctor.appointment.num)
				for (i = 0; i <= numbb; i++) {
					$('#' + doctor.appointment.form + i).remove();
					doctor.appointment.j--;
					doctor.appointment.num--;
				}
				$(doctor.appointment.plus).show();
			$(doctor.appointment.appointconfgmsg).html('');
		});
		$(doctor.appointment.appointviewBut).click(function () {
			showAppointmentDetails();
			$(doctor.appointment.appointconfgmsg).html('');
		});
		$(doctor.appointment.plus).click(function () {
			buildMultipleSlots();
		})
		$(doctor.appointment.appointsubmitBut).click(function () {
			configureappointment();
		});
	};
	this.referpage1 = function (ctrl) {
		fetchconfiguredappointment();
	};
	this.referpage2 = function (ctrl) {
		showAppointmentEditDetails();
	};
	function fetchconfiguredappointment() {
		$(doctor.appointment.displayconfigslot).html(LOADER_SIX);
		$.ajax({
			url : doctor.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'doctor/fetchconfiguredappointment',
			},
			success : function (data, textStatus, xhr) {
				console.log(data);
				data = $.trim(data);
				switch (data) {
				default:
					var ppdetails = $.parseJSON(data);
					if (ppdetails.num != 7) {
						$(doctor.appointment.displayconfigslot).html(ppdetails.data);
					} else {
						$(doctor.appointment.displayconfigslot).html('<h4>Already Configured, please goto Edit</h4>');
					}
					if (ppdetails.num == 0) {
						$(doctor.appointment.displayconfigslot).html(ppdetails.data);
					}
					window.setTimeout(function () {
						$(doctor.appointment.appointbutton).hide();
						$(doctor.appointment.plus).click(function () {
							$(doctor.appointment.plus).hide();
							$(doctor.appointment.appointbutton).show();
							buildMultipleSlots();
						});
					}, 300);
					break;
				}
			},
			error : function () {},
			complete : function (xhr, textStatus) {}
		});
	};
	function showAppointmentDetails() {
		$(doctor.appointment.appointview).html(LOADER_SIX);
		var htm = '';
		$.ajax({
			url : doctor.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'doctor/fetchappointmentdetails',
			},
			success : function (data, textStatus, xhr) {
				console.log(data);
				data = $.trim(data);
				switch (data) {
				default:
					var ppdetails = $.parseJSON(data);
					for (i = 0; i < ppdetails.pdata.length; i++) {
						htm += ppdetails.pdata[i];
					}
					$(doctor.appointment.appointview).html(ppdetails.divheader + htm + ppdetails.divfooter);
					break;
				}
				window.setTimeout(function () {
					for (i = 0; i < ppdetails.appids.length; i++) {
						$('#' + doctor.appointment.viewappointee + ppdetails.appids[i]).bind('click', {
							id : ppdetails.appids[i],
							datee : ppdetails.dates[i]
						}, function (event) {
							var apptid = event.data.id;
							var date = event.data.datee;
							fetchAppointeeDetails(apptid, date);
						})
					}
				}, 300);
			},
			error : function () {},
			complete : function (xhr, textStatus) {}
		});
	};
	function showAppointmentEditDetails() {
		$(doctor.appointment.appointedit).html(LOADER_SIX);
		var htm = '';
		$.ajax({
			url : doctor.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'doctor/fetchappointmentdetails',
			},
			success : function (data, textStatus, xhr) {
				console.log(data);
				data = $.trim(data);
				switch (data) {
				default:
					var ppdetails = $.parseJSON(data);
					for (i = 0; i < ppdetails.pdata1.length; i++) {
						htm += ppdetails.pdata1[i];
					}
					$(doctor.appointment.appointedit).html(ppdetails.divheader1 + htm + ppdetails.divfooter);
					break;
				}
				window.setTimeout(function () {
					var fromtime = [];
					var totime = [];
					for (i = 0; i < ppdetails.appids.length; i++) {
						$('#' + doctor.appointment.edit_app + ppdetails.appids[i]).bind('click', {
							id : ppdetails.appids[i],
							ft : ppdetails.fromtime[i],
							tt : ppdetails.totime[i],
							loc : ppdetails.location[i],
							freq : ppdetails.frequency[i]
						}, function (event) {
							var apptid = event.data.id;
							fromtime = (event.data.ft).split('-');
							totime = (event.data.tt).split('-');
							var location = event.data.loc;
							var frequency = event.data.freq;
							editappointmentdetails(apptid, fromtime, totime, location, frequency)
						})
						$('#' + doctor.appointment.deleteOk_ + ppdetails.appids[i]).bind('click', {
							id : ppdetails.appids[i]
						}, function (event) {
							var apptid = event.data.id;
							DeleteAppointment(apptid);
						});
					}
					for (k = 0; k < ppdetails.weekofdays.length; k++) {
						$(doctor.appointment.eaddappointSubmit + ppdetails.weekofdays[k]).hide();
						$('#' + doctor.appointment.eplus + ppdetails.weekofdays[k]).bind('click', {
							id : ppdetails.weekofdays[k]
						}, function (event) {
							var apptid = event.data.id;
							ebuildMultipleSlots(apptid);
						});
						$(doctor.appointment.eaddappointSubmit + ppdetails.weekofdays[k]).bind('click', {
							id : ppdetails.weekofdays[k],
							weekid : ppdetails.weekofdayid[k]
						}, function (event) {
							var apptid = event.data.id;
							var weekidd = event.data.weekid;
							econfigAppointments(apptid, weekidd);
						});
					}
				}, 300)
			},
			error : function () {},
			complete : function (xhr, textStatus) {}
		});
	};
	function econfigAppointments(idd, weekidd) {
		var flag = false;
		var da = doctor.appointment;
		var fromtime = [];
		var totime = [];
		var location = [];
		var frequency = [];
		var j = 0;
		for (i = 0; i <= da.enum; i++) {
			fromtime[i] = ($('#' + da.efromhour + i).val()) + '-' + ($('#' + da.efromminute + i).val()) + '-' + ($('#' + da.efromampm + i).val());
			totime[i] = ($('#' + da.etohour + i).val()) + '-' + ($('#' + da.etominute + i).val()) + '-' + ($('#' + da.etoampm + i).val());
			if (fromtime[i] == totime[i]) {
				alert("To Time is incorrect");
				flag = false;
				return
			} else {
				flag = true;
			}
			if (((Number($('#' + da.efromhour + i).val()) >= 10 && $('#' + da.efromampm + i).val() == 'PM') || (Number($('#' + da.efromhour + i).val()) < 6 && $('#' + da.efromampm + i).val() == 'AM')) && (Number($('#' + da.efromhour + i).val()) != 12)) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if (((Number($('#' + da.etohour + i).val()) > 10 && $('#' + da.etoampm + i).val() == 'PM') || (Number($('#' + da.etohour + i).val()) <= 6 && $('#' + da.etoampm + i).val() == 'AM')) && (Number($('#' + da.etohour + i).val()) != 12)) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ((Number($('#' + da.efromhour + i).val()) < 10 && $('#' + da.efromampm + i).val() == 'PM') && (Number($('#' + da.etohour + i).val()) < 12 && $('#' + da.etoampm + i).val() == 'AM')) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if (((Number($('#' + da.efromhour + i).val()) > Number($('#' + da.etohour + i).val())) && ($('#' + da.efromampm + i).val() == $('#' + da.etoampm + i).val())) && (Number($('#' + da.efromhour + i).val()) != 12)) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ((Number($('#' + da.efromhour + i).val()) == Number($('#' + da.etohour + i).val())) && (Number($('#' + da.efromminute + i).val()) > Number($('#' + da.etominute + i).val())) && ($('#' + da.efromampm + i).val() == $('#' + da.etoampm + i).val())) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ((Number($('#' + da.efromhour + i).val()) == 12) && ($('#' + da.efromampm + i).val() == 'AM')) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ($('#' + da.elocationappoint + i).val() == "") {
				$('#' + da.elocationappoint + i).focus();
				flag = false;
				return;
			} else {
				flag = true;
				location[i] = $('#' + da.elocationappoint + i).val();
			}
			if ($('#' + da.elocationappoint + i).val() == "") {
				$('#' + da.elocationappoint + i).focus();
				flag = false;
				return;
			} else {
				flag = true;
				location[i] = $('#' + da.elocationappoint + i).val();
			}
			if ($('#' + da.efrequencyappoint + i).val() == "" || (!$('#' + da.efrequencyappoint + i).val().match(numbs))) {
				$('#' + da.efrequencyappoint + i).focus();
				flag = false;
				return;
			} else {
				flag = true;
				frequency[i] = $('#' + da.efrequencyappoint + i).val();
			}
		}
		var attr = {
			fromtime : fromtime,
			totime : totime,
			location : location,
			frequency : frequency,
			weekidd : weekidd,
			day : idd,
		}
		if (flag) {
			//            $(doctor.appointment.appointsubmitBut) .prop('disabled', 'disabled');
			$(doctor.appointment.eappointconfgmsg).html(LOADER_SIX);
			$.ajax({
				url : doctor.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'doctor/econfigureappointment',
					configureappt : attr
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
						alert("Appointment has been successfully Configured");
						$(doctor.appointment.eappointconfgmsg).html('');
						showAppointmentEditDetails()
						break;
					}
				},
				error : function () {
					//						$(colls.outputDiv).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					console.log(xhr.status);
					//                                $(doctor.appointment.appointsubmitBut) .removeAttr('disabled');
					var numbb = doctor.appointment.enum
						for (i = 0; i <= numbb; i++) {
							$('#' + doctor.appointment.eform + i).remove();
							doctor.appointment.ej--;
							doctor.appointment.enum--;
						}
						$(doctor.appointment.eplus).show();
				}
			});
		}
	};
	function DeleteAppointment(apptid) {
		$.ajax({
			url : doctor.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'doctor/deleteappointment',
				apptid : apptid
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
					$('#' + doctor.appointment.row_id + apptid).remove();
					$('.modal-backdrop').remove();
				}
			},
			error : function () {
				//						$(colls.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	};
	function editappointmentdetails(apptid, fromtime, totime, location, frequency) {
		var editslott = '<div class="form-group">' +
			'<div class="col-md-12"><label>Edit Slot </label>' +
			'</div>' +
			'<br/><div class="col-md-3">' +
			'<label>From Time</label><br/>' +
			'<select id="editfromhour" class="form-group" name="editfromhour">' +
			'<option value="' + fromtime[0] + '">' + fromtime[0] + '</option>' +
			'<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>' +
			'<option value="4">4</option> <option value="5">5</option> <option value="6">6</option>' +
			'<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>' +
			'<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>' +
			'</select>' +
			'<select id="editfromminute" class="form-group" name="editfromminute">' +
			'<option value="' + fromtime[1] + '">' + fromtime[1] + '</option><option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>' +
			'</select>' +
			'<select id="editfromampm" class="form-group" name="editfromampm">' +
			'<option value="' + fromtime[2] + '">' + fromtime[2] + '</option> <option value="AM">AM</option> <option value="PM">PM</option>' +
			'</select>' +
			'</div>' +
			'<div class="col-lg-3">' +
			'<label>To Time</label>' +
			'<br/>' +
			'<select id="edittohour" class="form-group" name="edittohour">' +
			'<option value="' + totime[0] + '">' + totime[0] + '</option>' +
			'<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>' +
			'<option value="4">4</option> <option value="5">5</option> <option value="6">6</option>' +
			'<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>' +
			'<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>' +
			'</select>' +
			'<select id="edittominute" class="form-group" name="edittominute">' +
			'<option value="' + totime[1] + '">' + totime[1] + '</option>' +
			'<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>' +
			'</select>' +
			'<select id="edittoampm" class="form-group" name="edittoampm">' +
			'<option value="' + totime[2] + '">' + totime[2] + '</option>' +
			'<option value="AM">AM</option> <option value="PM">PM</option>' +
			'</select>' +
			'<p class="help-block"></p>' +
			'</div>' +
			'<div class="col-md-3" style="display:none;">' +
			'<label>Location</label>' +
			'<input type="text" name="editlocationappoint" id="editlocationappoint" value="' + location + '" class="form-control"/>' +
			'</div>' +
			'<div class="col-md-3">' +
			'<label>No of vehicle</label>' +
			'<input type="number" name="editfrequencyappoint" id="editfrequencyappoint" value="' + frequency + '" class="form-control"/>' +
			'</div></div>' +
			'</div><div class="col-md-12"><button class="btn btn-success" id="editApptDetailsSubmit" type="button">Save</button></div><input type="text" id="editapptidd" value="' + apptid + '" hidden="">';
		$('#' + doctor.appointment.edit_details + apptid).html(editslott);
		window.setTimeout(function () {
			$('#' + doctor.editappointment.editApptDetailsSubmit).click(function () {
				var da = doctor.editappointment;
				var fromtime = $('#' + doctor.editappointment.editfromhour).val() + '-' + $('#' + doctor.editappointment.editfromminute).val() + '-' + $('#' + doctor.editappointment.editfromampm).val();
				var totime = $('#' + doctor.editappointment.edittohour).val() + '-' + $('#' + doctor.editappointment.edittominute).val() + '-' + $('#' + doctor.editappointment.edittoampm).val();
				if (fromtime == totime) {
					alert("To Time is incorrect");
					flag = false;
					return
				} else {
					flag = true;
				}
				if (((Number($('#' + da.editfromhour).val()) >= 10 && $('#' + da.editfromampm).val() == 'PM') || (Number($('#' + da.editfromhour).val()) < 6 && $('#' + da.editfromampm).val() == 'AM')) && (Number($('#' + da.editfromhour).val()) != 12)) {
					alert("Invalid Time");
					flag = false;
					return
				} else {
					flag = true;
				}
				if (((Number($('#' + da.edittohour).val()) > 10 && $('#' + da.edittoampm).val() == 'PM') || (Number($('#' + da.edittohour).val()) <= 6 && $('#' + da.edittoampm).val() == 'AM')) && (Number($('#' + da.edittohour).val()) != 12)) {
					alert("Invalid Time");
					flag = false;
					return
				} else {
					flag = true;
				}
				if ((Number($('#' + da.editfromhour).val()) < 10 && $('#' + da.editfromampm).val() == 'PM') && (Number($('#' + da.edittohour).val()) < 12 && $('#' + da.edittoampm).val() == 'AM')) {
					alert("Invalid Time");
					flag = false;
					return
				} else {
					flag = true;
				}
				if (((Number($('#' + da.editfromhour).val()) > Number($('#' + da.edittohour).val())) && ($('#' + da.editfromampm).val() == $('#' + da.edittoampm).val())) && (Number($('#' + da.editfromhour).val()) != 12)) {
					alert("Invalid Time");
					flag = false;
					return
				} else {
					flag = true;
				}
				if ((Number($('#' + da.editfromhour).val()) == Number($('#' + da.edittohour).val())) && (Number($('#' + da.editfromminute).val()) > Number($('#' + da.edittominute).val())) && ($('#' + da.editfromampm).val() == $('#' + da.edittoampm).val())) {
					alert("Invalid Time");
					flag = false;
					return
				} else {
					flag = true;
				}
				if ((Number($('#' + da.editfromhour).val()) == 12) && ($('#' + da.editfromampm).val() == 'AM')) {
					alert("Invalid Time");
					flag = false;
					return
				} else {
					flag = true;
				}
				if ($('#' + da.editlocationappoint).val() == "") {
					$('#' + da.editlocationappoint).focus();
					flag = false;
					return;
				} else {
					flag = true;
				}
				if ($('#' + da.editlocationappoint).val() == "") {
					$('#' + da.editlocationappoint).focus();
					flag = false;
					return;
				} else {
					flag = true;
				}
				if ($('#' + da.editfrequencyappoint).val() == "" || (!$('#' + da.editfrequencyappoint).val().match(numbs))) {
					$('#' + da.editfrequencyappoint).focus();
					flag = false;
					return;
				} else {
					flag = true;
				}
				if (flag) {
					var attr = {
						fromtime : $('#' + doctor.editappointment.editfromhour).val() + '-' + $('#' + doctor.editappointment.editfromminute).val() + '-' + $('#' + doctor.editappointment.editfromampm).val(),
						totime : $('#' + doctor.editappointment.edittohour).val() + '-' + $('#' + doctor.editappointment.edittominute).val() + '-' + $('#' + doctor.editappointment.edittoampm).val(),
						location : $('#' + doctor.editappointment.editlocationappoint).val(),
						frequency : $('#' + doctor.editappointment.editfrequencyappoint).val(),
						apptid : $('#' + doctor.editappointment.editapptidd).val(),
					}
					$.ajax({
						url : doctor.url,
						type : 'POST',
						data : {
							autoloader : true,
							action : 'doctor/editappointment',
							editappt : attr
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
								alert("Appointment has been Successfully Altered");
								showAppointmentEditDetails();
							}
						},
						error : function () {
							//						$(colls.outputDiv).html(INET_ERROR);
						},
						complete : function (xhr, textStatus) {
							console.log(xhr.status);
						}
					});
				}
			});
		}, 300)
	};
	function configureappointment() {
		var flag = false;
		var da = doctor.appointment;
		var Days = [];
		var fromtime = [];
		var totime = [];
		var location = [];
		var frequency = [];
		var j = 0;
		for (i = 1; i <= 7; i++) {
			if ($('input[name=day' + i + ']').prop('checked')) {
				Days[j++] = $('input[name="day' + i + '"]:checked').val();
			}
		}
		if (Days.length == 0) {
			alert("please select the day/days");
			flag = false;
			return
		} else {
			flag = true;
		}
		for (i = 0; i <= da.num; i++) {
			fromtime[i] = ($('#' + da.fromhour + i).val()) + '-' + ($('#' + da.fromminute + i).val()) + '-' + ($('#' + da.fromampm + i).val());
			totime[i] = ($('#' + da.tohour + i).val()) + '-' + ($('#' + da.tominute + i).val()) + '-' + ($('#' + da.toampm + i).val());
			if (fromtime[i] == totime[i]) {
				alert("To Time is incorrect");
				flag = false;
				return
			} else {
				flag = true;
			}
			if (((Number($('#' + da.fromhour + i).val()) >= 10 && $('#' + da.fromampm + i).val() == 'PM') || (Number($('#' + da.fromhour + i).val()) < 6 && $('#' + da.fromampm + i).val() == 'AM')) && (Number($('#' + da.fromhour + i).val()) != 12)) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if (((Number($('#' + da.tohour + i).val()) > 10 && $('#' + da.toampm + i).val() == 'PM') || (Number($('#' + da.tohour + i).val()) <= 6 && $('#' + da.toampm + i).val() == 'AM')) && (Number($('#' + da.tohour + i).val()) != 12)) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ((Number($('#' + da.fromhour + i).val()) < 10 && $('#' + da.fromampm + i).val() == 'PM') && (Number($('#' + da.tohour + i).val()) < 12 && $('#' + da.toampm + i).val() == 'AM')) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if (((Number($('#' + da.fromhour + i).val()) > Number($('#' + da.tohour + i).val())) && ($('#' + da.fromampm + i).val() == $('#' + da.toampm + i).val())) && (Number($('#' + da.fromhour + i).val()) != 12)) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ((Number($('#' + da.fromhour + i).val()) == Number($('#' + da.tohour + i).val())) && (Number($('#' + da.fromminute + i).val()) > Number($('#' + da.tominute + i).val())) && ($('#' + da.fromampm + i).val() == $('#' + da.toampm + i).val())) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ((Number($('#' + da.fromhour + i).val()) == 12) && ($('#' + da.fromampm + i).val() == 'AM')) {
				alert("Invalid Time");
				flag = false;
				return
			} else {
				flag = true;
			}
			if ($('#' + da.locationappoint + i).val() == "") {
				$('#' + da.locationappoint + i).focus();
				flag = false;
				return;
			} else {
				flag = true;
				location[i] = $('#' + da.locationappoint + i).val();
			}
			if ($('#' + da.locationappoint + i).val() == "") {
				$('#' + da.locationappoint + i).focus();
				flag = false;
				return;
			} else {
				flag = true;
				location[i] = $('#' + da.locationappoint + i).val();
			}
			if ($('#' + da.frequencyappoint + i).val() == "" || (!$('#' + da.frequencyappoint + i).val().match(numbs))) {
				$('#' + da.frequencyappoint + i).focus();
				flag = false;
				return;
			} else {
				flag = true;
				frequency[i] = $('#' + da.frequencyappoint + i).val();
			}
		}
		var attr = {
			days : Days,
			fromtime : fromtime,
			totime : totime,
			location : location,
			frequency : frequency,
		}
		console.log(attr);
		$(doctor.appointment.appointconfgmsg).html('');
		if (flag) {
			$(doctor.appointment.appointsubmitBut).prop('disabled', 'disabled');
			$(doctor.appointment.appointconfgmsg).html(LOADER_SIX);
			$.ajax({
				url : doctor.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'doctor/configureappointment',
					configureappt : attr
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
						alert("Appointment has been successfully Configured");
						$(doctor.appointment.appointconfgmsg).html('');
						$('html, body').animate({
							scrollTop : Number($(doctor.appointment.appointconfgmsg).offset().top) - 95
						}, 'slow');
						fetchconfiguredappointment();
						break;
					}
				},
				error : function () {
					//						$(colls.outputDiv).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					$(doctor.appointment.appointsubmitBut).removeAttr('disabled');
					var numbb = doctor.appointment.num
						for (i = 0; i <= numbb; i++) {
							$('#' + doctor.appointment.form + i).remove();
							doctor.appointment.j--;
							doctor.appointment.num--;
						}
						$(doctor.appointment.plus).show();
				}
			});
		}
	};
	function buildMultipleSlots() {
		if (doctor.appointment.num == -1)
			$(doctor.appointment.multiple_slots).html('');
		doctor.appointment.num++;
		doctor.appointment.j++;
		var htm = '<div id="' + doctor.appointment.form + doctor.appointment.num + '">' +
			'<div class="form-group">' +
			'<div class="col-md-12"><label> Slot </label>' +
			' &nbsp;&nbsp;&nbsp;<button  id="plus_slots_' + doctor.appointment.num + '" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw fa-x2"></i> </button><button  id="minus_slots_' + doctor.appointment.num + '" type="button" class="text-primary btn btn-danger  btn-md"> <i class="fa fa-minus fa-fw fa-x2"></i></button></div>' +
			'<br/><div class="col-md-3">' +
			'<label>From Time</label><br/>' +
			'<select id="fromhour' + doctor.appointment.num + '" class="form-group" name="fromhour">' +
			'<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>' +
			'<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>' +
			'<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>' +
			'<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>' +
			'</select>' +
			'<select id="fromminute' + doctor.appointment.num + '" class="form-group" name="fromminute">' +
			'<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>' +
			'</select>' +
			'<select id="fromampm' + doctor.appointment.num + '" class="form-group" name="fromampm">' +
			'<option value="AM">AM</option> <option value="PM">PM</option>' +
			'</select>' +
			'</div>' +
			'<div class="col-lg-3">' +
			'<label>To Time</label>' +
			'<br/>' +
			'<select id="tohour' + doctor.appointment.num + '" class="form-group" name="tohour">' +
			'<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>' +
			'<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>' +
			'<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>' +
			'<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>' +
			'</select>' +
			'<select id="tominute' + doctor.appointment.num + '" class="form-group" name="tominute">' +
			'<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>' +
			'</select>' +
			'<select id="toampm' + doctor.appointment.num + '" class="form-group" name="toampm">' +
			'<option value="AM">AM</option> <option value="PM">PM</option>' +
			'</select>' +
			'<p class="help-block"></p>' +
			'</div>' +
			'<div class="col-md-3" style="display:none;">' +
			'<label>Location</label>' +
			'<input type="text" name="locationappoint' + doctor.appointment.num + '" id="locationappoint' + doctor.appointment.num + '" placeholder="Location" required="required" class="form-control" value="NULL" />' +
			'</div>' +
			'<div class="col-md-3">' +
			'<label>no of vehicle</label>' +
			'<input type="number" name="frequencyappoint' + doctor.appointment.num + '" id="frequencyappoint' + doctor.appointment.num + '" placeholder="no of vehicle" class="form-control"/>' +
			'</div></div>' +
			'</div>';
		$(doctor.appointment.multiple_slots).append(htm);
		window.setTimeout(function () {
			$(doctor.appointment.minus + doctor.appointment.num).click(function () {
				console.log(doctor.appointment.form + doctor.appointment.num);
				$('#' + doctor.appointment.form + doctor.appointment.num).remove();
				doctor.appointment.num--;
				doctor.appointment.j--;
				if (doctor.appointment.num == -1) {
					$(doctor.appointment.plus).show();
					$(doctor.appointment.appointbutton).hide();
					$(doctor.appointment.multiple_slots).html('');
				} else {
					$(doctor.appointment.plus + doctor.appointment.num).show();
					$(doctor.appointment.minus + doctor.appointment.num).show();
				}
			});
			$(doctor.appointment.plus + doctor.appointment.num).click(function () {
				$(doctor.appointment.plus + doctor.appointment.num).hide();
				$(doctor.appointment.minus + doctor.appointment.num).hide();
				buildMultipleSlots();
			});
			$(doctor.appointment.appointbutton).click(function () {
				configureappointment();
			})
		}, 500);
	};
	function ebuildMultipleSlots(apptid) {
		if (doctor.appointment.enum == -1)
			$(doctor.appointment.emultiple_slots + apptid).html('');
		doctor.appointment.enum++;
		doctor.appointment.ej++;
		var htm = '<div id="' + doctor.appointment.eform + doctor.appointment.enum + '">' +
			'<div class="form-group">' +
			'<div class="col-md-12"><label> Slot ' + '' + '</label>' +
			' &nbsp;&nbsp;&nbsp;<button  id="eplus_slots_' + apptid + doctor.appointment.enum + '" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw fa-x2"></i> </button><button  id="eminus_slots_' + apptid + doctor.appointment.enum + '" type="button" class="text-primary btn btn-danger  btn-md"> <i class="fa fa-minus fa-fw fa-x2"></i></button></div>' +
			'<br/><div class="col-md-3">' +
			'<label>From Time</label><br/>' +
			'<select id="efromhour' + doctor.appointment.enum + '" class="form-group" name="fromhour">' +
			'<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>' +
			'<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>' +
			'<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>' +
			'<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>' +
			'</select>' +
			'<select id="efromminute' + doctor.appointment.enum + '" class="form-group" name="fromminute">' +
			'<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>' +
			'</select>' +
			'<select id="efromampm' + doctor.appointment.enum + '" class="form-group" name="fromampm">' +
			'<option value="AM">AM</option> <option value="PM">PM</option>' +
			'</select>' +
			'</div>' +
			'<div class="col-lg-3">' +
			'<label>To Time</label>' +
			'<br/>' +
			'<select id="etohour' + doctor.appointment.enum + '" class="form-group" name="tohour">' +
			'<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>' +
			'<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>' +
			'<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>' +
			'<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>' +
			'</select>' +
			'<select id="etominute' + doctor.appointment.enum + '" class="form-group" name="tominute">' +
			'<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>' +
			'</select>' +
			'<select id="etoampm' + doctor.appointment.enum + '" class="form-group" name="toampm">' +
			'<option value="AM">AM</option> <option value="PM">PM</option>' +
			'</select>' +
			'<p class="help-block"></p>' +
			'</div>' +
			'<div class="col-md-3" style="display:none;">' +
			'<label>Location</label>' +
			'<input type="text" name="elocationappoint' + doctor.appointment.enum + '" id="elocationappoint' + doctor.appointment.enum + '" placeholder="Location" required="required" class="form-control" value="NULL"/>' +
			'</div>' +
			'<div class="col-md-3">' +
			'<label>no of vehicle</label>' +
			'<input type="number" name="efrequencyappoint' + doctor.appointment.enum + '" id="efrequencyappoint' + doctor.appointment.enum + '" placeholder="no of vehicle" class="form-control"/>' +
			'</div></div>' +
			'</div>';
		$(doctor.appointment.emultiple_slots + apptid).append(htm);
		$(doctor.appointment.eaddappointSubmit + apptid).show();
		window.setTimeout(function () {
			$(doctor.appointment.eminus + apptid + doctor.appointment.enum).click(function () {
				console.log(doctor.appointment.eform + doctor.appointment.enum);
				$('#' + doctor.appointment.eform + doctor.appointment.enum).remove();
				doctor.appointment.enum--;
				doctor.appointment.ej--;
				if (doctor.appointment.enum == -1) {
					$(doctor.appointment.eplus + apptid).show();
					$(doctor.appointment.eaddappointSubmit + apptid).hide();
					$(doctor.appointment.emultiple_slots + apptid).html('');
				} else {
					$('#' + doctor.appointment.eplus + apptid + doctor.appointment.enum).show();
					$(doctor.appointment.eminus + apptid + doctor.appointment.enum).show();
				}
			});
			$('#' + doctor.appointment.eplus + apptid + doctor.appointment.enum).click(function () {
				$('#' + doctor.appointment.eplus + apptid + doctor.appointment.enum).hide();
				$(doctor.appointment.eminus + apptid + doctor.appointment.enum).hide();
				ebuildMultipleSlots(apptid);
			});
		}, 400);
	};
	function fetchAppointeeDetails(appid, date) {
		var attr = {
			appid : appid,
			date : date,
		}
		$.ajax({
			url : doctor.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'doctor/fetchAppointeeDetails',
				inputinfo : attr
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
					var appointeedel = $.parseJSON(data);
					$('#' + doctor.appointment.viewappointeedis + appid).html(appointeedel);
				}
			},
			error : function () {
				//						$(colls.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);

			}
		});
	};
}
