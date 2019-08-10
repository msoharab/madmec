function controlTrainerImport() {
	var traImp = {};
	var gymid = $(DGYM_ID).attr("name");
	this.__construct = function (trainerImport) {
		traImp = trainerImport;
		var bar = $('.bar');
		var percent = $('.percent');
		var status = $('#status');
		$('#gym_id').val(gymid);
		$('#trainerdetailsxls').ajaxForm({
			beforeSend : function () {
				status.empty();
				var percentVal = '0%';
				bar.width(percentVal)
				percent.html(percentVal);
				if (($('#import_facility').selected().val()) === 'NULL') {
					flag = false;
					$("#import_facility").focus();
					$("#ftype_import_msg").html('<strong class="text-danger">Select Trainer type.</strong>');
					$('html, body').animate({
						scrollTop : Number($("#ftype_import_msg").offset().top) - 95
					}, "slow");
					return;
				} else {
					flag = true;
					$("#ftype_import_msg").html(VALIDNOT);
				}
				if (($('#import_gym').selected().val()) === 'NULL') {
					flag = false;
					$("#import_gym").focus();
					$('#ttype_import_msg').html('<strong class="text-danger">Select Trainer type.</strong>');
					$('html, body').animate({
						scrollTop : Number($('#ttype_import_msg').offset().top) - 95
					}, "slow");
					return;
				} else {
					flag = true;
					$('#ttype_import_msg').html(VALIDNOT);
				}
			},
			uploadProgress : function (event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			success : function () {
				var percentVal = '100%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			complete : function (xhr) {
				var percentVal = '0%';
				if (xhr.responseText.length == 0) {
					bar.width(percentVal);
					percent.html(percentVal);
				}
				status.html(xhr.responseText);
			}
		});
		fetchTrainerType();
		fetchInterestedIn();
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
						rad += '<option  value="' + type[i]["id"] + '">' + type[i]["html"] + '</option>';
					}
					$("#" + traImp.ftype).html('<option value="NULL" selected>Select facility Type</option>' + rad);
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
					$("#" + traImp.ttype).html('<option value="NULL" selected>Select Trainer Type</option>' + rad);
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
};
