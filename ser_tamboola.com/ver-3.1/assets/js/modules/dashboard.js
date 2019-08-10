function load_dashboard() {
	var outdiv = '';
	this.__construct = function (mainPage) {
		outdiv = mainPage.suboutdiv;
		$(loader).html(LOADER_SIX);
		$.ajax({
			url : mainPage.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'load_dashboard',
				type : 'master'
			},
			success : function (data) {
				console.log(data);
				data = $.parseJSON($.trim(data));
				switch (data) {
				case "logout":
					logoutAdmin();
					break;
				default:
					$(outdiv).html(data.htm);
					$(loader).hide();
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {}
		});
	}
	this.selectGYM = function (gymdata) {
		$(gymdata.nav).each(function () {
			$(this).click(function (evt) {
				var id = $(this).attr('id');
				setGym(id);
			});
		});
		function setGym(id) {
			$(loader).html(LOADER_SIX);
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'setGYM',
					type : 'master',
					id : id
				},
				success : function (data) {
					console.log(data);
					switch (data) {
					case "logout":
						logoutAdmin();
						break;
					default:
						$(DGYM_ID).attr('name', id);
						$(DGYM_ID).html(data);
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
