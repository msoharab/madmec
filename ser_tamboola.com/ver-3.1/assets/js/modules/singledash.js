function loadSingleDash() {
	var ds = '';
	var gymid = $(DGYM_ID).attr("name");
	this.__construct = function (dash) {
		ds = dash;
		loadSinglePageDash();
	}
	function loadSinglePageDash() {
		$(ds.nm).html(LOADER_SIX);
		$.ajax({
			url : ds.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'loadSingleDash',
				type : 'slave',
				gymid : gymid
			},
			success : function (data) {
				data = $.parseJSON($.trim(data));
				switch (data) {
				case "logout":
					logoutAdmin();
					break;
				default:
					$(ds.nm).html($(DGYM_ID).text());
					$(ds.outdiv).html(data.one);
					$(ds.outdiv).append(data.two);
					$(ds.outdiv).append(data.thr);
					$(loader).hide();
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
