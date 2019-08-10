function controlManageTwo() {
	var mg = {};
	var id = $(DGYM_ID).attr('name');
	this.__construct = function (managetwo) {
		mg = managetwo;
		window.setTimeout(function () {
			fetchFacilityStatus();
		}, 300);
		$(mg.Addfacility).click(function () {
			$(mg.dupmsg).html('');
			fetchFacilityStatus();
		});
		$(mg.Showfacility).click(function () {
			getallFacility();
		});
		$(mg.Reactivatefacility).click(function () {
			getallDeactiveFacility();
		});
	};
	this.handlefacility = function (gym1) {
		$(gym1.outdiv2).css("opacity", "0.5");
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : gym1.action,
				type : 'slave',
				gymid : id,
				chid : gym1.outdiv1
			},
			success : function (data) {
				if (data == 'logout')
					window.location.href = URL;
				else {
					$(gym1.outdiv2).remove();
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
	function fetchFacilityStatus() {
		$(mg.showstatus).html(LOADER_SIX);
		window.setTimeout(function () {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				async : false,
				data : {
					autoloader : 'true',
					action : 'showhidestatus',
					id : id,
					type : 'slave',
					gymid : id
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						var html = '<label>Status :<i class="fa fa-caret-down fa-fw"></i></label><select id="' + mg.factstvalue + '" class="form-control">';
						$(mg.showstatus).html(html + data);
						$(mg.facilitysave).click(function () {
							saveFacility();
						});
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		}, 800);
	};
	function getallFacility() {
		/* ---------------------- - get available facility---------------------- */
		$(mg.ctctShowFacility1).html(LOADER_SIX);
		window.setTimeout(function () {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'showfact',
					id : id,
					type : 'slave',
					gymid : id
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else {
						$(mg.ctctShowFacility1).html(data);
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		}, 800);
	};
	function getallDeactiveFacility() {
		$(mg.ctctShowFacility2).html(LOADER_SIX);
		/* ---------------------- - get available facility---------------------- */
		window.setTimeout(function () {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : 'true',
					action : 'showhidefact',
					id : id,
					type : 'slave',
					gymid : id
				},
				success : function (data) {
					if (data == 'logout')
						window.location.href = URL;
					else if (data == false) {
						$(mg.ctctShowFacility2).html("<center><h2>There are no deactivated facilities</h2></center>");
					} else {
						$(mg.ctctShowFacility2).html(data);
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		}, 800);
	};
	function saveFacility() {
		/* ---------------------- - Add facility---------------------- */
		var factname = $(mg.factname).val();
		var factstvalue = $('#' + mg.factstvalue + ' :selected').val();
		console.log(factname);
		console.log(factstvalue);
		/* name */
		if (factname.match(name_reg) && factstvalue.match(numbs)) {
			$.ajax({
				url : window.location.href,
				type : 'POST',
				async : false,
				data : {
					autoloader : 'true',
					action : 'addfact',
					id : id,
					type : 'slave',
					gymid : id,
					factNm : factname,
					factST : factstvalue
				},
				success : function (data) {
					console.log(data);
					data = $.trim(data);
					if (data == 'logout')
						window.location.href = URL;
					else if (data === 'success') {
						$(mg.dupmsg).html('<h3 class="text-danger">Successfully added facility.</h3>');
					}
					if (data === 'duplicate') {
						$(mg.dupmsg).html('<h3 class="text-danger">Facility already exists</h3>');
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		} else {
			$(mg.dupmsg).html('<h3 class="text-danger">Please enter the facility name.</h3>');
		}
	};
};
