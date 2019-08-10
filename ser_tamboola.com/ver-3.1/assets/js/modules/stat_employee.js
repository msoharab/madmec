function controlStatEmployee() {
	var gymid = $(DGYM_ID).attr("name");
	emp = {};
	this.__construct = function (employe) {
		emp = employe;
		listEmpStats();
	}
	function listEmpStats() {
		$(loader).html(LOADER_SIX);
		$.ajax({
			url : emp.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'listEmpStats',
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
					$(emp.output).html(data);
					window.setTimeout(function () {
						$('#listempattn').dataTable();
					}, 300);
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
