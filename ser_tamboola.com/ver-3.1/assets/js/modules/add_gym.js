function addGym()
{
    var ct={};
    var add = {};
    var em = {};
    var cn = {};
    var dccode = '91';
    var dpcode = '080';
    this.__construct = function (addgymctrl) {
        ct = addgymctrl;
        add = ct.addgym;
        em = ct.addgym.em;
        cn = ct.addgym.cn;
        $(add.but).click(function (evt) {
			evt.preventDefault();
			evt.stopPropagation();
			gymAdd();
		});
        initializeProfileAddForm()
    };
    
    function initializeProfileAddForm() {
		$(cn.plus + ',' + em.plus).unbind();
		$(cn.plus).click(function (evt) {
			$(cn.plus).hide();
			evt.preventDefault();
			evt.stopPropagation();
			bulitMultipleCellNumbers();
		});
		$(em.plus).click(function (evt) {
			$(em.plus).hide();
			evt.preventDefault();
			evt.stopPropagation();
			bulitMultipleEmailIds();
		});
	};
        
    function bulitMultipleEmailIds() {
		if (em.num == -1)
			$(em.parentDiv).html('');
		em.num++;
		var html = '<div id="' + em.form + em.num + '">' +
			'<div class="col-lg-8">' +
			'<input class="form-control" required="required" placeholder="Email Id" name="email" type="text" id="' + em.email + em.num + '" maxlength="100"/>' +
			'<p class="help-block" id="' + em.msgDiv + em.num + '">&nbsp;</p>' +
			'</div>' +
			'<div class="col-lg-4">' +
			'<button  type="button" class="btn btn-danger  btn-md" id="' + em.minus + em.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
			'<button type="button" class="btn btn-success  btn-md" id="' + em.plus + em.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
			'</div>' +
			'</div>';
		$(em.parentDiv).append(html);
		window.setTimeout(function () {
			$(document.getElementById(em.minus + em.num)).click(function (evt) {
				evt.preventDefault();
				evt.stopPropagation();
				$(document.getElementById(em.form + em.num)).remove();
				$(document.getElementById(em.msgDiv + em.num)).remove();
				em.num--;
				if (em.num == -1) {
					$(em.plus).show();
					$(em.parentDiv).html('');
				} else {
					$(document.getElementById(em.plus + em.num)).show();
					$(document.getElementById(em.minus + em.num)).show();
				}
				if (em.count && em.count == em.num) {
					$(em.plus).show();
				}
			});
			$(document.getElementById(em.plus + em.num)).click(function (evt) {
				evt.preventDefault();
				evt.stopPropagation();
				$(document.getElementById(em.plus + em.num)).hide();
				$(document.getElementById(em.minus + em.num)).hide();
				bulitMultipleEmailIds();
			});
		}, 200);
	};
	/* gym branch Cell Number*/
    function bulitMultipleCellNumbers() {
		if (cn.num == -1)
			$(cn.parentDiv).html('');
		cn.num++;
		var html = '<div class="row show-grid" id="' + cn.form + cn.num + '">' +
			'<div class="col-xs-6 col-md-4">' +
			'<input class="form-control" required="required" value="' + dccode + '" name="ccode" type="text" id="' + cn.codep + cn.num + '" maxlength="15" readonly="" />' +
			'</div>' +
			'<div class="col-xs-6 col-md-4">' +
			'<input class="form-control" required="required" placeholder="Cell Number" name="cnumber" type="text" id="' + cn.nump + cn.num + '" maxlength="10" />' +
			'</div>' +
			'<div class="col-xs-6 col-md-4" id="btn' + cn.num + '">' +
			'<button type="button" class="btn btn-danger  btn-md" id="' + cn.minus + cn.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
			'<button type="button" class="btn btn-success  btn-md" id="' + cn.plus + cn.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
			'</div>' +
			'</div>' +
			'<div class="col-lg-12"><p class="help-block" id="' + cn.msgDiv + cn.num + '">&nbsp;</p></div>';
		$(cn.parentDiv).append(html);
		window.setTimeout(function () {
			$(function () {
				$(document.getElementById(cn.minus + cn.num)).click(function (evt) {
					evt.preventDefault();
					evt.stopPropagation();
					$(document.getElementById(cn.form + cn.num)).remove();
					$(document.getElementById(cn.msgDiv + cn.num)).remove();
					cn.num--;
					if (cn.num == -1) {
						$(cn.plus).show();
					} else if (cn.count && cn.count == cn.num) {
						$(cn.plus).show();
					} else {
						$(document.getElementById(cn.plus + cn.num)).show();
						$(document.getElementById(cn.minus + cn.num)).show();
						btdiv = "btn" + cn.num;
						document.getElementById(btdiv).style.visibility = "visible";
					}
				});
				$(document.getElementById(cn.plus + cn.num)).click(function (evt) {
					evt.preventDefault();
					evt.stopPropagation();
					$(document.getElementById(cn.plus + cn.num)).hide();
					$(document.getElementById(cn.minus + cn.num)).hide();
					btdiv = "btn" + cn.num;
					document.getElementById(btdiv).style.visibility = "hidden";
					bulitMultipleCellNumbers();
				});
			});
		}, 200);
	};  
        
    function gymAdd() {
		var attr = validateGYMFields();
		if (attr) {
			$(add.but).prop('disabled', 'disabled');
			$(ct.msgDiv).html('');
			$(ct.msgDiv).html(LOADER_SIX);
			$.ajax({
				url : ct.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'gymAdd',
					type : 'master',
                                        clientreq  : 'clientreq',
					gymadd : attr
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
						$(loader).hide();
						$(ct.msgDiv).html('<h2>Record success fully added</h2>');
                                                alert("Your Request has been success fully added")
						$(add.form).get(0).reset();
                                                window.location.href="Tamboola";
						$('#address_body').hide(300);
						break;
					}
				},
				error : function () {
					$(usr.outputDiv).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					console.log(xhr.status);
					window.setTimeout(function () {
						$(ct.msgDiv).html('');
					}, 2000);
					$(add.but).removeAttr('disabled');
				}
			});
		} else {
			$(add.but).removeAttr('disabled');
		}
	};  
        
    function validateGYMFields() {
		var flag = false;
		var email = [];
		var cellnumbers = [];
		/* user name mgym*mgmsg*/
//		if ($(add.mgym).val().length > 0) {
//			flag = true;
//			$(add.mgmsg).html(VALIDNOT);
//		} else {
//			flag = false;
//			$(add.mgmsg).html(INVALIDNOT);
//			$('html, body').animate({
//				scrollTop : Number($(add.mgmsg).offset().top) - 95
//			}, "slow");
//			$(add.mgym).focus();
//			return;
//		}
		/* gym name name*nmsg*/
		if ($(add.name).val().match(name_reg)) {
			flag = true;
			$(add.nmsg).html(VALIDNOT);
		} else {
			flag = false;
			$(add.nmsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($(add.nmsg).offset().top) - 95
			}, "slow");
			$(add.name).focus();
			return;
		}
		/* gym fee fee*fmsg*/
		if ($(add.fee).val().match(number_reg)) {
			flag = true;
			$(add.fmsg).html(VALIDNOT);
		} else {
			flag = false;
			$(add.fmsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($(add.fmsg).offset().top) - 95
			}, "slow");
			$(add.fee).focus();
			return;
		}
		/* gym country*comsg $('#address_body').show(300);*/
		if ($(add.address.country).val()) {
			flag = true;
			$(add.address.comsg).html(VALIDNOT);
		} else {
			flag = false;
			$(add.address.comsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($(add.address.comsg).offset().top) - 95
			}, "slow");
			$(add.address.addbody).show();
			$(add.address.country).focus();
			return;
		}
		/*~ // gym province-prmsg*/
		if ($(add.address.province).val()) {
			flag = true;
			$(add.address.prmsg).html(VALIDNOT);
		} else {
			flag = false;
			$(add.address.prmsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($(add.address.prmsg).offset().top) - 95
			}, "slow");
			$(add.address.addbody).show();
			$(add.address.province).focus();
			return;
		}
		/* gym district-dimsg*/
		if ($(add.address.district).val()) {
			flag = true;
			$(add.address.dimsg).html(VALIDNOT);
		} else {
			flag = false;
			$(add.address.dimsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($(add.address.dimsg).offset().top) - 95
			}, "slow");
			$(add.address.addbody).show();
			$(add.address.district).focus();
			return;
		}
		/* gym zipcode-zimsg*/
		if ($(add.address.zipcode).val()) {
			flag = true;
			$(add.address.zimsg).html(VALIDNOT);
		} else {
			flag = false;
			$(add.address.zimsg).html(INVALIDNOT);
			$('html, body').animate({
				scrollTop : Number($(add.address.zimsg).offset().top) - 95
			}, "slow");
			$(add.address.addbody).show();
			$(add.address.zipcode).focus();
			return;
		}
		/* Email Ids */
		if (em.num > -1) {
			j = 0;
			for (i = 0; i <= em.num; i++) {
				if ($(document.getElementById(em.email + i)).val().match(email_reg)) {
					flag = true;
					$(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
					email[j] = $(document.getElementById(em.email + i)).val();
					j++;
				} else {
					flag = false;
					$(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
					$('html, body').animate({
						scrollTop : Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
					}, "slow");
					$(document.getElementById(em.email + i)).focus();
					return;
				}
			}
		}
		/* Cell Numbers */
		if (cn.num > -1) {
			j = 0;
			for (i = 0; i <= cn.num; i++) {
				if ($(document.getElementById(cn.codep + i)).val().match(ccod_reg)) {
					flag = true;
					$(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
				} else {
					flag = false;
					$(document.getElementById(cn.msgDiv + i)).html('<strong class="text-danger">Not Valid Cell prefiex</strong>');
					$('html, body').animate({
						scrollTop : Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
					}, "slow");
					$(document.getElementById(cn.codep + i)).focus();
					return;
				}
				if ($(document.getElementById(cn.nump + i)).val().match(cell_reg)) {
					flag = true;
					$(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
				} else {
					flag = false;
					$(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
					$('html, body').animate({
						scrollTop : Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
					}, "slow");
					$(document.getElementById(cn.nump + i)).focus();
					return;
				}
				if (flag) {
					cellnumbers[j] = {
						codep : $(document.getElementById(cn.codep + i)).val(),
						nump : $(document.getElementById(cn.nump + i)).val()
					};
					j++;
				}
			}
		}
		var attr = {
			type : $(add.type).val(),
			mgym : $(add.mgym).val(),
			userpk : $(add.mgmsg).attr('name'),
			name : $(add.name).val(),
			acs : $(add.acs_id).val(),
			email : email,
			cellnumbers : cellnumbers,
			fee : $(add.fee).val(),
			tax : $(add.tax).val(),
			country : $(add.address.country).val(),
			countryCode : add.address.countryCode,
			province : $(add.address.province).val(),
			provinceCode : add.address.provinceCode,
			district : $(add.address.district).val(),
			city_town : $(add.address.city_town).val(),
			st_loc : $(add.address.st_loc).val(),
			addrsline : $(add.address.addrs).val(),
			tphone : $(add.address.tphone).val(),
			pcode : $(add.address.pcode).val(),
			zipcode : $(add.address.zipcode).val(),
			website : $(add.address.website).val(),
			gmaphtml : $(add.address.gmaphtml).val(),
			timezone : add.address.timezone,
			lat : add.address.lat,
			lon : add.address.lon
		};
		if (flag) {
			return attr;
		} else
			return false;
	};   
        
    this.bindAddressFields = function (addres) {
		var list = this.countries;
		$(add.address.country).autocomplete({
			minLength : 2,
			source : list,
			autoFocus : true,
			select : function (event, ui) {
				window.setTimeout(function () {
					$(add.address.country).val(ui.item.label);
					$(add.address.country).attr('name', ui.item.value);
					add.address.countryCode = ui.item.countryCode;
					add.address.PCR_reg = ui.item.PCR;
					dccode = ui.item.Phone;
					$(cn.codep + '0').val(ui.item.Phone);
					for (i = 0; i <= cn.num; i++) {
						$(document.getElementById(cn.codep + i)).val(ui.item.Phone);
					}
					addres.setCountry(ui.item);
					$(add.address.province).val('');
					$(add.address.province).focus();
				}, 50);
				$(add.address.province).focus(function () {
					this.states = addres.getState();
					var list = this.states;
					$(add.address.province).autocomplete({
						minLength : 2,
						source : list,
						autoFocus : true,
						select : function (event, ui) {
							window.setTimeout(function () {
								$(add.address.province).val(ui.item.label);
								$(add.address.province).attr('name', ui.item.value);
								add.address.provinceCode = ui.item.provinceCode;
								add.address.lat = ui.item.lat;
								add.address.lon = ui.item.lon;
								add.address.timezone = ui.item.timezone;
								addres.setState(ui.item);
								$(add.address.district).val('');
								$(add.address.district).focus();
							}, 50);
						}
					});
				});
				$(add.address.district).focus(function () {
					this.districts = addres.getDistrict();
					var list = this.districts;
					$(add.address.district).autocomplete({
						minLength : 2,
						source : list,
						autoFocus : true,
						select : function (event, ui) {
							window.setTimeout(function () {
								$(add.address.district).val(ui.item.label);
								$(add.address.district).attr('name', ui.item.value);
								add.address.districtCode = ui.item.districtCode;
								add.address.lat = ui.item.lat;
								add.address.lon = ui.item.lon;
								add.address.timezone = ui.item.timezone;
								addres.setDistrict(ui.item);
								$(add.address.city_town).val('');
								$(add.address.city_town).focus();
							}, 50);
						}
					});
				});
				$(add.address.city_town).focus(function () {
					this.cities = addres.getCity();
					var list = this.cities;
					$(add.address.city_town).autocomplete({
						minLength : 2,
						source : list,
						autoFocus : true,
						select : function (event, ui) {
							window.setTimeout(function () {
								$(add.address.city_town).val(ui.item.label);
								$(add.address.city_town).attr('name', ui.item.value);
								add.address.city_townCode = ui.item.city_townCode;
								add.address.lat = ui.item.lat;
								add.address.lon = ui.item.lon;
								add.address.timezone = ui.item.timezone;
								addres.setCity(ui.item);
								$(add.address.st_loc).val('');
								$(add.address.st_loc).focus();
							}, 50);
						}
					});
				});
				$(add.address.st_loc).focus(function () {
					this.localities = addres.getLocality();
					var list = this.localities;
					$(add.address.st_loc).autocomplete({
						minLength : 2,
						source : list,
						autoFocus : true,
						select : function (event, ui) {
							window.setTimeout(function () {
								$(add.address.st_loc).val(ui.item.label);
								$(add.address.st_loc).attr('name', ui.item.value);
								add.address.st_locCode = ui.item.st_locCode;
								add.address.lat = ui.item.lat;
								add.address.lon = ui.item.lon;
								add.address.timezone = ui.item.timezone;
								addres.setLocality(ui.item);
							}, 200);
						}
					});
				});
			}
		});
	};    
}

