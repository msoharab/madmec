function controlClubExpenses() {
	var gymid = $(DGYM_ID).attr("name");
	pay = {};
	this.__construct = function (payment) {
		pay = payment;
		$(pay.dt).datepicker({
			dateFormat : 'dd-M-yy',
			changeYear : true,
			changeMonth : true,
			yearRange : 'date("Y"):(date("Y")+2)'
		});
		$(pay.dt).datepicker("setDate", 'date("Y-m-d")');
		$(pay.btn).bind('click', function (evt) {
			validateExpensesDetails();
		});
	}
	function validateExpensesDetails() {
		var amount = $('#' + pay.amt);
		var name = $('#' + pay.name);
		var receiptno = $('#' + pay.rpt);
		var pay_date = convertDateFormat($(pay.dt).val());
		var description = $('#' + pay.dec).val();
		description = description.replace(/\n/g, "<br />").replace(/\r\n/g, "<br />").replace(/\r/g, "<br />");
		var amount_reg = /[0-9]+(?:\.[0-9]*)?/;
		var zero_reg = /[0]*/;
		var flag = true;
		if (name.val() != "") {
			flag = true;
			$("#enm_msg").html(VALIDNOT);
		} else {
			flag = false;
			$("#enm_msg").html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($("#enm_msg").offset().top) - 95
			}, "slow");
			name.focus();
			return;
		}
		if (amount.val().match(amount_reg)) {
			flag = true;
			$("#eamt_msg").html(VALIDNOT);
		} else {
			flag = false;
			$("#eamt_msg").html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($("#eamt_msg").offset().top) - 95
			}, "slow");
			amount.focus();
			return;
		}
		if (description != "") {
			flag = true;
			$("#edec_msg").html(VALIDNOT);
		} else {
			flag = false;
			$("#edec_msg").html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($("#edec_msg").offset().top) - 95
			}, "slow");
			$('#' + pay.dec).focus();
			return;
		}
		if (flag) {
			var exp = {
				name : name.val(),
				amount : amount.val(),
				receiptno : receiptno.val(),
				pay_date : pay_date,
				description : description,
			}
			console.log(exp);
			$(loader).html(LOADER_SIX);
			$.ajax({
				url : pay.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'AddExpenses',
					type : 'slave',
					gymid : gymid,
					exp : exp
				},
				success : function (data, textStatus, xhr) {
					console.log(data);
					switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					case 'login':
						loginAdmin({});
						break;
					default:
						data = $.parseJSON($.trim(data));
						$(pay.alertbody).html(data.msg);
						$(pay.alert).trigger('click');
						$(pay.form).get(0).reset();
						$(loader).html('');
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
	}
};
