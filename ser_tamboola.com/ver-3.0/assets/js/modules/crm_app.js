function controlCRMApp() {
	var gymid = $(DGYM_ID).attr("name");
	var ap = {};
	this.__construct = function (crmapp) {
		ap = crmapp;
		initializeDefault();
		$(ap.compose.id).click(function () {
			initializeCompose();
		});
		$(ap.outbbox.id).click(function () {
			initializeOutbox();
		});
		$(ap.expired.id).click(function () {
			initializeExpired();
		});
		$(ap.showups.id).click(function () {
			initializeNoShow();
		});
		$(ap.followups.id).click(function () {
			initializeFollowUps();
		});
		$(ap.stats.id).click(function () {
			initializeStats();
		});
	};
	function initializeCompose() {
		ap.action = ap.compose.action;
		ap.parent_div = ap.compose.parent_div;
		ap.target_div = ap.compose.target_div;
		createMessage();
	};
	function initializeOutbox() {
		ap.action = ap.outbbox.action;
		ap.parent_div = ap.outbbox.parent_div;
		ap.target_div = ap.outbbox.target_div;
		listMessage();
	};
	function initializeExpired() {
		ap.action = ap.expired.action;
		ap.parent_div = ap.expired.parent_div;
		ap.target_div = ap.expired.target_div;
		createMessage();
	};
	function initializeNoShow() {
		ap.action = ap.showups.action;
		ap.parent_div = ap.showups.parent_div;
		ap.target_div = ap.showups.target_div;
		createMessage();
	};
	function initializeFollowUps() {
		ap.action = ap.followups.action;
		ap.parent_div = ap.followups.parent_div;
		ap.target_div = ap.followups.target_div;
		createMessage();
	};
	function initializeStats() {
		ap.action = ap.stats.action;
		ap.parent_div = ap.stats.parent_div;
		ap.target_div = ap.stats.target_div;
		load_stats();
	};
	function initializeDefault() {
		ap.action = ap.outbbox.action;
		ap.parent_div = ap.outbbox.parent_div;
		ap.target_div = ap.outbbox.target_div;
		listMessage();
	};
	function listMessage() {
		$(ap.target_div).html(LOADER_SIX);
		$.ajax({
			url : ap.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : ap.action,
				type : 'slave',
				gymid : gymid,
				ap : ap
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
					$(ap.target_div).html(data);
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
	this.displayMsg = function (obj) {
		$(obj.target_div).html(LOADER_SIX);
		$.ajax({
			url : ap.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'displayMsg',
				type : 'slave',
				gymid : gymid,
				ap : obj.obj,
				index : obj.sindex
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
					$(obj.target_div).html(data);
					$(obj.target_div).parent().scrollTop(Number($(obj.target_div).html().length) + Number(data.length));
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
	this.send_app_msg = function (obj) {
		var msg_to = obj.msg_to;
		var msg_sub = $(obj.msg_sub).val();
		var msg_content = $(obj.msg_content).val();
		if (msg_to.length > 0 && msg_content.length > 0) {
			$(obj.msg_content).val('');
			$.ajax({
				url : ap.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'send_app_msg',
					type : 'slave',
					gymid : gymid,
					msg_to : msg_to,
					msg_sub : msg_sub,
					msg_content : msg_content,
					arr_type : obj.arr_type,
					ap : obj.ap
				},
				success : function (data) {
					var msg = data.replace("\n", "<br />").replace("\r", "<br />").replace("\r\n", "<br />").replace("\n\r", "<br />");
					$(obj.target_div).html($(obj.target_div).html() + msg);
					$(obj.target_div).parent().scrollTop(Number($(obj.target_div).html().length) + Number(data.length));
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
	function createMessage() {
		$(ap.target_div).html(LOADER_SIX);
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'createMessage',
				type : 'slave',
				gymid : gymid,
				ap : ap,
				id : ap.action
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
					$(ap.target_div).html(data);
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
	function load_stats() {
		$(ap.target_div).html(LOADER_SIX);
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'statistics',
				type : 'slave',
				gymid : gymid,
				ap : ap,
				id : ap.action
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
					$(ap.target_div).html(data);
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
