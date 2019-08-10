function sentCredentials() {
	var ctrl = {};
	this.__construct = function (clnt) {
		ctrl = clnt;
		fetchSentCredentials();
	};
	function fetchSentCredentials() {
		$(ctrl.displaycredentials).html(LOADER_ONE)
		$.ajax({
			url : ctrl.url,
			type : 'POST',
			data : {
				autoloader : true,
				action : 'sentCredentials',
				type : 'master',
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
					var res = $.parseJSON(data);
					if (res.status == "success") {
						var details = new Array();
						if (res.details.length) {
							for (i = 0; i < res.details.length; i++) {
								details.push({
									enqid : res.details[i]['enqid'],
									cellnum : res.details[i]['cell_number'],
								})
							}
						}
						var header = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="list_col_table1"><thead><tr><th>#</th><th>Name</th><th>Cell Number</th>\n\
							                                <th>Email</th><th>Date</th><th>Option</th></tr></thead><tbody>';
						var footer = '</tbody></table></div>';
						$(ctrl.displaycredentials).html(header + res.data + footer);
						window.setTimeout(function () {
							$('#list_col_table1').dataTable();
						/*
							for (i = 0; i < details.length; i++) {
								$('#sendcrden' + details[i].enqid).bind('click', {
									enqid : details[i].enqid,
									cellnumm : details[i].cellnum,
								}, function (evt) {
									sendCredential(evt.data.cellnumm);
								});
							}
						*/
						}, 500)
					} else {
						$(ctrl.displaycredentials).html("<strong class='text-center text-danger'>no records..</strog>")
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
	this.sendCredential = function(cellnumber){
	// function sendCredential {
		console.log(cellnumber);
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'sendCredential',
				cellnumber : cellnumber,
				type : 'master',
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
					if (data) {
						alert("Credentails has been Successfully Changed");
					} else {
						alert("Credentails hasn't Changed");
					}
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {}
		});
	}
}