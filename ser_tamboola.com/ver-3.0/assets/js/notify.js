function notifyController() {
	var ntfy = {};
	this.__construct = function (notify_list) {
		ntfy = notify_list;
		console.log("am in display notification");
		/*	DisplayNotificationList()*/
		fetchNotifications();
	}
	function DisplayNotificationList() {
		var htm = '';
		$(ntfy.listDiv).html(LOADER_FUR);
		$.ajax({
			url : ntfy.url,
			type : 'post',
			data : {
				autoloader : true,
				action : 'DisplayNotificationList',
				type : 'master'
			},
			success : function (data, textStatus, xhr) {
				console.log(data);
				alert(data);
				data = $.trim(data);
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				default:
					var listusers = $.parseJSON($.trim(data));
					for (i = 0; i < listusers.length; i++) {
						htm += listusers[i]["html"];
					}
					$(ntfy.listDiv).html(htm);
					for (i = 0; i < listusers.length; i++) {
						$(listusers[i].usrdelOk).bind('click', {
							uid : listusers[i].uid,
							sr : listusers[i].sr
						}, function (evt) {
							$($(this).prop('name')).hide(400);
							var hid = deleteUser(evt.data.uid);
							if (hid) {
								$(evt.data.sr).remove();
								/* DisplayUserList();*/
							}
						});
					}
					$(ntfy.listLoad).html('');
					window.setTimeout(function () {
						/*	InstallSerachHtml();*/
					}, 300);
					break;
				}
			},
			error : function () {
				$(ntfy.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	};
	function deleteUser(uid) {
		var flag = false;
		var attr = {
			entid : uid
		};
		$.ajax({
			url : ntfy.url,
			type : 'POST',
			async : false,
			data : {
				autoloader : true,
				action : 'deletentfyUser',
				ptydeletesale : attr,
				type : 'master'
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
					flag = data;
					break;
				}
			},
			error : function () {
				$(usr.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
		return flag;
	}
	function fetchNotifications() {
		$(ntfy.displaynotifications).html(LOADER_FIV);
		$.ajax({
			type : 'POST',
			url : ntfy.url,
			data : {
				autoloader : true,
				action : 'fetchadminnotify',
				type : 'master'
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
					var res = $.parseJSON($.trim(data));
					if (res.status == "success") {
						$(ntfy.displaynotifications).html(res.data);
						window.setTimeout(function () {
							$('#listnotifycations-example').dataTable();
						});
					} else {
						$(ntfy.displaynotifications).html('<span class="text-danger"><strong>no Notification .....!!!!!!</strong>');
					}
					break;
				}
			},
			error : function () {
				$(ntfy.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	}
};
