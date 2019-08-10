function controlStatCustomer() {
	var gymid = $(DGYM_ID).attr("name");
	cus = {};
	this.__construct = function (cust) {
		cus = cust;
		listRegistrationStats();
	}
	function listRegistrationStats() {
		$(loader).html(LOADER_SIX);
		$.ajax({
			url : cus.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'listCustomerStats',
				type : 'slave',
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
					data = $.parseJSON($.trim(data));
					console.log(data);
					$(cus.output).html(data.html);
					var para1 = {
						data1 : data,
						cust : cus,
					};
					$(data.btnmsg).bind('click', {}, function (evt) {
						sendMSG(evt.data.para1);
					});
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
	function sendMSG(para1) {
		paraData = para1.data1;
		cus = para1.cust;
		$(paraData.loader).html(LOADER_SIX);
		$.ajax({
			url : cus.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'sendMsg',
				type : 'slave',
				gymid : gymid
			},
			success : function (data, textStatus, xhr) {
				$(paraData.loader).html('');
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					$(cus.alertbody).html('Messages and Emails sent successfully.');
					$(cus.alert).trigger('click');
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
};
