function controlProfile() {
	var pf = {};
	var add = {};
	var em = {};
	var cn = {};
	var dccode = '91';
	var dpcode = '080';
	this.__construct = function (profile) {
		pf = profile;
		add = profile.addgym;
		em = profile.addgym.em;
		cn = profile.addgym.cn;
		$(add.but).click(function () {
			gymAdd();
		});
		load_admin_details();
		LoadGymDetails();
		initializeProfileAddForm();
	};
	this.editProfileEmailIds = function (email) {
		var em = email;
		var min = em.num;
		$('#' + em.saveBut).hide();
		$(em.but).bind('click', function () {
			$('#' + em.saveBut).show();
			$(em.but).hide();
			em.num = min;
			profileEmailIdForm();
		});
		function profileEmailIdForm() {
			em.num = min;
			$(em.parentDiv).html(LOADER_SIX);
			$.ajax({
				url : em.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'profileEmailIdForm',
					type : 'master',
					det : em
				},
				success : function (data, textStatus, xhr) {
					data = $.parseJSON($.trim(data));
					switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					default:
						$(em.parentDiv).html(data.html);
						$(document).ready(function () {
							$('#' + em.plus).click(function () {
								addMultipleProfileEmailIds();
							});
							$('#' + em.minus).bind('click', function () {
								minusMultipleProfileEmailIds();
								return false;
							});
							$('#' + em.saveBut).bind('click', function () {
								editProfileEmailId();
							});
							$('#' + em.closeBut).bind('click', function () {
								$(em.but).show();
								$('#' + em.saveBut).hide();
								listProfileEmailIds();
							});
							window.setTimeout(function () {
								if (data.oldemail) {
									for (i = 0; i < data.oldemail.length; i++) {
										var id = Number(data.oldemail[i].id);
										$('#' + data.oldemail[i].deleteOk).bind('click', {
											param1 : id
										}, function (event) {
											$($(this).prop('name')).hide(400);
											if (deleteProfileEmailId(event.data.param1)) {
												profileEmailIdForm();
											}
										});
									}
								}
							}, 300);
						});
						break;
					}
				},
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		};
		function editProfileEmailId() {
			var insert = [];
			var update = [];
			var emailids = {
				insert : insert,
				update : update,
				uid : em.uid,
				index : em.index,
				listindex : em.listindex
			};
			var flag = false;
			if (em.num > -1) {
				j = 0;
				k = 0;
				for (i = 0; i <= em.num; i++) {
					var ems = $(document.getElementById(em.email + i)).val();
					var id = $(document.getElementById(em.email + i)).prop('name');
					if (ems.match(email_reg)) {
						flag = true;
						$(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
						if (id != 'email') {
							update[j] = {
								email : ems,
								id : id
							};
							j++;
						} else if (id == 'email') {
							insert[k] = ems;
							k++;
						}
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
			if (flag) {
				emailids.insert = insert;
				emailids.update = update;
				$('#' + em.saveBut).unbind();
				$.ajax({
					url : em.url,
					type : 'POST',
					data : {
						autoloader : true,
						action : 'editProfileEmailId',
						type : 'master',
						emailids : emailids
					},
					success : function (data, textStatus, xhr) {
						flag = false;
						data = $.parseJSON($.trim(data));
						switch (data) {
						case 'logout':
							logoutAdmin({});
							break;
						default:
							min++;
							$(em.but).show();
							$('#' + em.saveBut).hide();
							listProfileEmailIds();
							break;
						}
					},
					error : function (xhr, textStatus) {
						$(OUTPUT).html(INET_ERROR);
					},
					complete : function (xhr, textStatus) {
						/*console.log(xhr.status);*/
					}
				});
			}
		};
		function addMultipleProfileEmailIds() {
			em.num++;
			for (i = min; i <= em.num; i++) {
				$(document.getElementById(em.minus + i + '_delete')).hide();
			}
			var oldemail = {
				formid : em.form + em.num,
				textid : em.email + em.num,
				msgid : em.msgDiv + em.num,
				deleteid : em.minus + em.num + '_delete'
			};
			var html = '<div><div class="form-group input-group" id="' + oldemail.formid + '">' +
				'<input class="form-control" placeholder="Email Id" name="email" type="text" id="' + oldemail.textid + '" maxlength="100"/>' +
				'<span class="input-group-addon"></span>' +
				'</div><div class="col-lg-16"><p class="help-block" id="' + oldemail.msgid + '">&nbsp;</p></div></div>';
			$(em.parentDiv).append(html);
			window.setTimeout(function () {
				$(document.getElementById(oldemail.deleteid)).click(function () {
					$(this).parent().parent().parent().remove();
					$(document.getElementById(em.minus + em.num + '_delete')).show();
				});
			}, 200);
		};
		function minusMultipleProfileEmailIds() {
			var oldemail = {
				formid : em.form + em.num,
				textid : em.email + em.num,
				msgid : em.msgDiv + em.num,
				deleteid : em.minus + em.num + '_delete'
			};
			$(document.getElementById(oldemail.textid)).remove();
			$(document.getElementById(oldemail.msgid)).remove();
			$(document.getElementById(oldemail.formid)).remove();
			em.num--;
			window.setTimeout(function () {
				$(document.getElementById(oldemail.deleteid)).click(function () {
					if (em.num >= min) {
						em.num--;
					}
					$(this).parent().parent().parent().remove();
					$(document.getElementById(em.minus + em.num + '_delete')).hide();
				});
			}, 200);
		};
		function deleteProfileEmailId(id) {
			var flag = false;
			$.ajax({
				url : em.url,
				type : 'POST',
				async : false,
				data : {
					autoloader : true,
					action : 'deleteProfileEmailId',
					type : 'master',
					eid : id
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
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
			return flag;
		};
		function listProfileEmailIds() {
			var para = {
				uid : em.uid,
				index : em.index,
				listindex : em.listindex
			};
			var flag = false;
			$.ajax({
				url : em.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'listProfileEmailIds',
					type : 'master',
					para : para
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
						$(em.parentDiv).html(data);
						break;
					}
				},
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
			return flag;
		};
	};
	this.editProfileCellNumbers = function (cellno) {
		var cn = cellno;
		var min = cn.num;
		$('#' + cn.saveBut).hide();
		$(cn.but).click(function () {
			$('#' + cn.saveBut).show();
			$(cn.but).hide();
			cn.num = min;
			loadProfileCellNumForm();
		});
		function loadProfileCellNumForm() {
			cn.num = min;
			$(cn.parentDiv).html(LOADER_SIX);
			$.ajax({
				url : cn.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'loadProfileCellNumForm',
					type : 'master',
					det : cn
				},
				success : function (data, textStatus, xhr) {
					data = $.parseJSON($.trim(data));
					switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					default:
						$(cn.parentDiv).html(data.html);
						$(document).ready(function () {
							$('#' + cn.plus).click(function () {
								addMultipleProfileCellNums();
							});
							$('#' + cn.saveBut).click(function () {
								editProfileCellNum();
							});
							$('#' + cn.minus).click(function () {
								minusMultipleProfileCellNums();
							});
							$('#' + cn.closeBut).click(function () {
								$(cn.but).show();
								$('#' + cn.saveBut).hide();
								listProfileCellNums();
							});
							window.setTimeout(function () {
								if (data.oldcnums) {
									for (i = 0; i < data.oldcnums.length; i++) {
										var id = Number(data.oldcnums[i].id);
										$('#' + data.oldcnums[i].deleteOk).bind('click', {
											param1 : id
										}, function (event) {
											$($(this).prop('name')).hide(400);
											if (deleteProfileCellNum(event.data.param1)) {
												loadProfileCellNumForm();
											}
										});
									}
								}
							}, 300);
						});
						break;
					}
				},
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		};
		function editProfileCellNum() {
			var insert = [];
			var update = [];
			var CellNums = {
				insert : insert,
				update : update,
				uid : cn.uid,
				index : cn.index,
				listindex : cn.listindex
			};
			var flag = false;
			/* min*/
			/* Cell Numbers */
			if (cn.num > -1) {
				j = 0;
				k = 0;
				for (i = 0; i <= cn.num; i++) {
					var ems = $(document.getElementById(cn.cnumber + i)).val();
					var id = $(document.getElementById(cn.cnumber + i)).prop('name');
					if (ems.match(cell_reg)) {
						flag = true;
						$(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
						if (id != 'cnumber') {
							update[j] = {
								cnumber : ems,
								id : id
							};
							j++;
						} else if (id == 'cnumber') {
							insert[k] = ems;
							k++;
						}
					} else {
						flag = false;
						$(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
						$('html, body').animate({
							scrollTop : Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
						}, "slow");
						$(document.getElementById(cn.cnumber + i)).focus();
						return;
					}
				}
			}
			if (flag) {
				CellNums.insert = insert;
				CellNums.update = update;
				$('#' + cn.saveBut).unbind();
				$.ajax({
					url : cn.url,
					type : 'POST',
					data : {
						autoloader : true,
						action : 'editProfileCellNum',
						type : 'master',
						CellNums : CellNums
					},
					success : function (data, textStatus, xhr) {
						var CellNums = {
							insert : '',
							update : '',
							uid : '',
							index : '',
							listindex : ''
						};
						data = $.parseJSON($.trim(data));
						switch (data) {
						case 'logout':
							logoutAdmin({});
							break;
						default:
							min++;
							loadProfileCellNumForm();
							break;
						}
					},
					error : function (xhr, textStatus) {
						$(OUTPUT).html(INET_ERROR);
					},
					complete : function (xhr, textStatus) {
						/*console.log(xhr.status);*/
					}
				});
			}
		};
		function addMultipleProfileCellNums() {
			cn.num++;
			for (i = min; i < cn.num; i++) {
				$(document.getElementById(cn.minus + i + '_delete')).hide();
			}
			var oldcnum = {
				formid : cn.form + cn.num,
				textid : cn.cnumber + cn.num,
				msgid : cn.msgDiv + cn.num,
				deleteid : cn.minus + cn.num + '_delete'
			};
			var html = '<div><div class="form-group input-group" id="' + oldcnum.formid + '">' +
				'<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="' + oldcnum.textid + '" maxlength="10"/>' +
				'<span class="input-group-addon"></span>' +
				'</div><div class="col-lg-16"><p class="help-block" id="' + oldcnum.msgid + '">&nbsp;</p></div></div>';
			$(cn.parentDiv).append(html);
			window.setTimeout(function () {
				$(document.getElementById(oldcnum.deleteid)).click(function () {
					if (cn.num >= min)
						cn.num--;
					$(this).parent().parent().parent().remove();
					$(document.getElementById(cn.minus + cn.num + '_delete')).show();
				});
			}, 200);
		};
		function minusMultipleProfileCellNums() {
			cn.num--;
			$(document.getElementById(cn.minus + i + '_delete')).hide();
			var oldcnum = {
				formid : cn.form + cn.num,
				textid : cn.cnumber + cn.num,
				msgid : cn.msgDiv + cn.num,
				deleteid : cn.minus + cn.num + '_delete'
			};
			$(document.getElementById(cn.form + cn.num)).hide();
			$(document.getElementById(cn.cnumber + cn.num)).hide();
			$(document.getElementById(cn.msgDiv + cn.num)).hide();
			var html = '<div><div class="form-group input-group" id="' + oldcnum.formid + '"></div></div>';
			window.setTimeout(function () {
				$(document.getElementById(oldcnum.deleteid)).click(function () {
					if (cn.num >= min)
						cn.num--;
					$(this).parent().parent().parent().remove();
					$(document.getElementById(cn.minus + cn.num + '_delete')).show();
				});
			}, 200);
		};
		function listProfileCellNums() {
			var para = {
				uid : cn.uid,
				index : cn.index,
				listindex : cn.listindex
			};
			var flag = false;
			$.ajax({
				url : cn.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'listProfileCellNums',
					type : 'master',
					para : para
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
						$(cn.parentDiv).html(data);
						break;
					}
				},
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
			return flag;
		};
		function deleteProfileCellNum(id) {
			var flag = false;
			$.ajax({
				url : cn.url,
				type : 'POST',
				async : false,
				data : {
					autoloader : true,
					action : 'deleteProfileCellNum',
					type : 'master',
					eid : id
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
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
			return flag;
		};
	};
	this.editChangePassword = function (password) {
		var pwd = password;
		$(pwd.saveBut).hide();
		$(pwd.canBut).hide();
		$(pwd.but).click(function () {
			$(pwd.saveBut).show();
			$(pwd.canBut).show();
			$(pwd.but).hide();
			$(pwd.saveBut).click(function () {
				if (($(pwd.newpwd).val() === $(pwd.confirmpwd).val())) {
					if ($(pwd.newpwd).val() != "")
						editChangePwd();
				} else {
					$(pwd.msgdiv).html('<strong class="text-danger">Password does not match</strong>');
				}
			});
		});
		function editChangePwd() {
			var changepwd = {
				oldpwd : $(pwd.oldpwd).val(),
				newpwd : $(pwd.newpwd).val(),
				confirmpwd : $(pwd.confirmpwd).val(),
				msgdiv : pwd.msgdiv
			};
			$(pwd.oldpwd).attr('disabled', 'disabled');
			$(pwd.newpwd).attr('disabled', 'disabled');
			$(pwd.confirmpwd).attr('disabled', 'disabled');
			$.ajax({
				url : pwd.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'editChangePwd',
					type : 'master',
					det : changepwd
				},
				success : function (data, textStatus, xhr) {
					data = $.trim(data);
					/*console.log(data);*/
					switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					case 'login':
						loginAdmin({});
						break;
					default:
						flag = data;
						if (flag) {
							$(pwd.msgdiv).html('<strong class="text-success">Your password has been changed successfully!!!!</strong>');
							$(pwd.msgdiv).append('<br /><strong class="text-danger">You will redierct to login page shortly!!!!</strong>');
							$(pwd.divtoggle).hide(300);
							$(pwd.but).show();
							$(pwd.saveBut).hide();
							window.setTimeout(function () {
								logoutAdmin({});
							}, 5000);
						} else {
							$(pwd.msgdiv).html('<strong class="text-danger">Please enter the correct password!!!!</strong>');
							$(pwd.oldpwd).removeAttr('disabled');
							$(pwd.newpwd).removeAttr('disabled');
							$(pwd.confirmpwd).removeAttr('disabled');
						}
						break;
					}
				},
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
		};
	};
	this.editGYMAddress = function (addr) {
		var address = addr;
		var addres;
		var PCR_reg = '';
		var countries = {};
		var states = {};
		var districts = {};
		var cities = {};
		var localities = {};
		$(address.pfbut).click(function () {
			$(address.pfshowDiv).toggle();
			$(address.pfupdateDiv).toggle();
			if ($(address.pfupdateDiv).css('display') == 'block') {
				addres = new Address();
				addres.__construct({
					url : address.pfurl,
					outputDiv : address.pfoutputDiv
				});
				countries = addres.getCountry();
				attachAddressFields();
			}
		});
		$(address.pfsaveBut).click(function () {
			editAddress();
		});
		$(address.pfcloseBut).click(function () {
			listAddress();
		});
		function attachAddressFields() {
			var list = countries;
			$(address.pfcountry).autocomplete({
				minLength : 2,
				source : list,
				autoFocus : true,
				select : function (event, ui) {
					window.setTimeout(function () {
						$(address.pfcountry).val(ui.item.label);
						$(address.pfcountry).attr('name', ui.item.value);
						address.pfcountryCode = ui.item.countryCode;
						address.pfPCR_reg = ui.item.PCR;
						addres.setCountry(ui.item);
						$(address.pfprovince).val('');
						$(address.pfprovince).focus();
					}, 50);
					$(address.pfprovince).focus(function () {
						states = addres.getState();
						var list = states;
						$(address.pfprovince).autocomplete({
							minLength : 2,
							source : list,
							autoFocus : true,
							select : function (event, ui) {
								window.setTimeout(function () {
									$(address.pfprovince).val(ui.item.label);
									$(address.pfprovince).attr('name', ui.item.value);
									address.pfprovinceCode = ui.item.provinceCode;
									address.pflat = ui.item.lat;
									address.pflon = ui.item.lon;
									address.pftimezone = ui.item.timezone;
									addres.setState(ui.item);
									$(address.pfdistrict).val('');
									$(address.pfdistrict).focus();
								}, 50);
							}
						});
					});
					$(address.pfdistrict).focus(function () {
						districts = addres.getDistrict();
						var list = districts;
						$(address.pfdistrict).autocomplete({
							minLength : 2,
							source : list,
							autoFocus : true,
							select : function (event, ui) {
								window.setTimeout(function () {
									$(address.pfdistrict).val(ui.item.label);
									$(address.pfdistrict).attr('name', ui.item.value);
									address.pfdistrictCode = ui.item.districtCode;
									address.pflat = ui.item.lat;
									address.pflon = ui.item.lon;
									address.pftimezone = ui.item.timezone;
									addres.setDistrict(ui.item);
									$(address.pfcity_town).val('');
									$(address.pfcity_town).focus();
								}, 50);
							}
						});
					});
					$(address.pfcity_town).focus(function () {
						cities = addres.getCity();
						var list = cities;
						$(address.pfcity_town).autocomplete({
							minLength : 2,
							source : list,
							autoFocus : true,
							select : function (event, ui) {
								window.setTimeout(function () {
									$(address.pfcity_town).val(ui.item.label);
									$(address.pfcity_town).attr('name', ui.item.value);
									address.pfcity_townCode = ui.item.city_townCode;
									address.pflat = ui.item.lat;
									address.pflon = ui.item.lon;
									address.pftimezone = ui.item.timezone;
									addres.setCity(ui.item);
									$(address.pfst_loc).val('');
									$(address.pfst_loc).focus();
								}, 50);
							}
						});
					});
					$(address.pfst_loc).focus(function () {
						localities = addres.getLocality();
						var list = localities;
						$(address.pfst_loc).autocomplete({
							minLength : 2,
							source : list,
							autoFocus : true,
							select : function (event, ui) {
								window.setTimeout(function () {
									$(address.pfst_loc).val(ui.item.label);
									$(address.pfst_loc).attr('name', ui.item.value);
									address.pfst_locCode = ui.item.st_locCode;
									address.pflat = ui.item.lat;
									address.pflon = ui.item.lon;
									address.pftimezone = ui.item.timezone;
									addres.setLocality(ui.item);
								}, 200);
							}
						});
					});
				}
			});
		};
		function editAddress() {
			/* Address */
			var flag = false;
			/* Country */
			if ($(address.pfcountry).val().match(st_city_dist_cont_reg)) {
				flag = true;
				$(address.pfcomsg).html(VALIDNOT);
			} else {
				flag = false;
				$(address.pfcomsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(address.pfcomsg).offset().top) - 95
				}, "slow");
				$(address.pfcountry).focus();
				return;
			}
			/* Province */
			if ($(address.pfprovince).val().match(prov_reg)) {
				flag = true;
				$(address.pfprmsg).html(VALIDNOT);
			} else {
				flag = false;
				$(address.pfprmsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(address.pfprmsg).offset().top) - 95
				}, "slow");
				$(address.pfprovince).focus();
				return;
			}
			/* District */
			if ($(address.pfdistrict).val().match(st_city_dist_cont_reg)) {
				flag = true;
				$(address.pfdimsg).html(VALIDNOT);
			} else {
				flag = false;
				$(address.pfdimsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(address.pfdimsg).offset().top) - 95
				}, "slow");
				$(address.pfdistrict).focus();
				return;
			}
			/* City */
			if ($(address.pfcity_town).val().match(st_city_dist_cont_reg)) {
				flag = true;
				$(address.pfcitmsg).html(VALIDNOT);
			} else {
				flag = false;
				$(address.pfcitmsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(address.pfcitmsg).offset().top) - 95
				}, "slow");
				$(address.pfcity_town).focus();
				return;
			}
			/* Street / Locality */
			if ($(address.pfst_loc).val().match(st_city_dist_cont_reg)) {
				flag = true;
				$(address.pfstlmsg).html(VALIDNOT);
			} else {
				flag = false;
				$(address.pfstlmsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(address.pfstlmsg).offset().top) - 95
				}, "slow");
				$(address.pfst_loc).focus();
				return;
			}
			/* Address Line */
			if ($(address.pfaddrs).val().match(addline_reg)) {
				flag = true;
				$(address.pfadmsg).html(VALIDNOT);
			} else {
				flag = false;
				$(address.pfadmsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop : Number($(address.pfadmsg).offset().top) - 95
				}, "slow");
				$(address.pfaddrs).focus();
				return;
			}
			var attr = {
				uid : address.pfuid,
				gymid : $(address.pfgymid).val(),
				index : address.pfindex,
				listindex : address.pflistindex,
				country : $(address.pfcountry).val(),
				countryCode : address.pfcountryCode,
				province : $(address.pfprovince).val(),
				provinceCode : address.pfprovinceCode,
				district : $(address.pfdistrict).val(),
				city_town : $(address.pfcity_town).val(),
				st_loc : $(address.pfst_loc).val(),
				addrsline : $(address.pfaddrs).val(),
				zipcode : $(address.pfzipcode).val(),
				website : $(address.pfwebsite).val(),
				gmaphtml : $(address.pfgmaphtml).val(),
				timezone : address.pftimezone,
				lat : address.pflat,
				lon : address.pflon
			};
			if (flag) {
				$.ajax({
					url : address.pfUpdateurl,
					type : 'POST',
					data : {
						autoloader : true,
						action : 'editProfileAddress',
						type : 'master',
						address : attr
					},
					success : function (data, textStatus, xhr) {
						data = $.parseJSON($.trim(data));
						switch (data) {
						case 'logout':
							logoutAdmin({});
							break;
						default:
							$(address.pfcloseBut).trigger('click');
							break;
						}
					},
					error : function (xhr, textStatus) {
						$(OUTPUT).html(INET_ERROR);
					},
					complete : function (xhr, textStatus) {
						/*console.log(xhr.status);*/
					}
				});
			}
		};
		function listAddress() {
			var para = {
				uid : address.pfuid,
				index : address.pfindex,
				listindex : address.pflistindex,
				gymid : $(address.pfgymid).val(),
			};
			var flag = false;
			$.ajax({
				url : window.location.href,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'listProfileAddress',
					type : 'master',
					para : para
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
						$(address.pfshowDiv).html(data);
						$(address.pfshowDiv).toggle();
						$(address.pfupdateDiv).toggle();
						break;
					}
				},
				error : function (xhr, textStatus) {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					/*console.log(xhr.status);*/
				}
			});
			return flag;
		};
	};
	/*first load admin profile*/
	function load_admin_details() {
		$(loader).html(LOADER_SIX);
		$.ajax({
			url : pf.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'load_admin_details',
				type : 'master'
			},
			success : function (data) {
				data = $.parseJSON($.trim(data));
				switch (data) {
				case "logout":
					logoutAdmin();
					break;
				default:
					$(pf.pfoutDiv).html(data.htm);
					$(loader).hide();
					$(".picedit_box").picEdit({
						imageUpdated : function (img) {},
						formSubmitted : function (data) {
							window.setTimeout(function () {
								$('#myModal_pf').modal('toggle');
								load_admin_details();
							}, 500);
						},
						redirectUrl : false,
						defaultImage : URL + ASSET_IMG + 'No_image.png',
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
	/* load gym details master*/
	function LoadGymDetails() {
		$(loader).html(LOADER_SIX);
		var id = $(DGYM_ID).attr("name");
		$.ajax({
			url : window.location.href,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'load_gym_details',
				type : 'master',
				id : id
			},
			success : function (data) {
				data = $.parseJSON($.trim(data));
				switch (data) {
				case "logout":
					logoutAdmin();
					break;
				default:
					$(pf.gymoutDiv).html(data.htm);
					$(loader).hide();
					$(".picedit_box").picEdit({
						imageUpdated : function (img) {},
						formSubmitted : function (data) {
							window.setTimeout(function () {
								$('#myModal_Photo').modal('toggle');
								LoadGymDetails();
							}, 500);
						},
						redirectUrl : false,
						defaultImage : URL + ASSET_IMG + 'No_image.png',
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
	/*gym branch New Adding*/
	function gymAdd() {
		var attr = validateUserFields();
		if (attr) {
			$(add.but).prop('disabled', 'disabled');
			$(pf.msgDiv).html('');
			$.ajax({
				url : pf.url,
				type : 'POST',
				data : {
					autoloader : true,
					action : 'gymAdd',
					type : 'master',
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
						$(add.form).get(0).reset();
						$('#address_body').hide(300);
						break;
					}
				},
				error : function () {
					$(OUTPUT).html(INET_ERROR);
				},
				complete : function (xhr, textStatus) {
					$(add.but).removeAttr('disabled');
				}
			});
		} else {
			$(add.but).removeAttr('disabled');
		}
	};
	function validateUserFields() {
		var flag = false;
		var email = [];
		var cellnumbers = [];
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
	/* gym branch Add*/
	function initializeProfileAddForm() {
		$(cn.plus + ',' + em.plus).unbind();
		$(cn.plus).click(function () {
			$(cn.plus).hide();
			bulitMultipleCellNumbers();
		});
		$(em.plus).click(function () {
			$(em.plus).hide();
			bulitMultipleEmailIds();
		});
	};
	/* gym branch email*/
	function bulitMultipleEmailIds() {
		if (em.num == -1)
			$(em.parentDiv).html('');
		em.num++;
		var html = '<div id="' + em.form + em.num + '">' +
			'<div class="col-lg-8">' +
			'<input class="form-control" placeholder="Email Id" name="email" type="text" id="' + em.email + em.num + '" maxlength="100"/>' +
			'<p class="help-block" id="' + em.msgDiv + em.num + '">&nbsp;</p>' +
			'</div>' +
			'<div class="col-lg-4">' +
			'<button type="button" class="btn btn-danger  btn-md" id="' + em.minus + em.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
			'<button type="button" class="btn btn-success  btn-md" id="' + em.plus + em.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
			'</div>' +
			'</div>';
		$(em.parentDiv).append(html);
		window.setTimeout(function () {
			$(document.getElementById(em.minus + em.num)).click(function () {
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
			$(document.getElementById(em.plus + em.num)).click(function () {
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
			'<input class="form-control" value="' + dccode + '" name="ccode" type="text" id="' + cn.codep + cn.num + '" maxlength="15" />' +
			'</div>' +
			'<div class="col-xs-6 col-md-4">' +
			'<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="' + cn.nump + cn.num + '" maxlength="20" />' +
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
				$(document.getElementById(cn.minus + cn.num)).click(function () {
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
				$(document.getElementById(cn.plus + cn.num)).click(function () {
					$(document.getElementById(cn.plus + cn.num)).hide();
					$(document.getElementById(cn.minus + cn.num)).hide();
					btdiv = "btn" + cn.num;
					document.getElementById(btdiv).style.visibility = "hidden";
					bulitMultipleCellNumbers();
				});
			});
		}, 200);
	};
};
