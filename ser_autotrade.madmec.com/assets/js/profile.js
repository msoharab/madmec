function profileController(){
		var loader	= '#loader';
		var pfview	=	{};
		this.__construct = function(pfctrl){
			pfview	=	pfctrl.pf.pfoutdiv;
			initializeViewProfile();
		};
		this.editProfileEmailIds = function(email){
			var em = email;
			var min = em.num;

			$('#'+em.saveBut).hide();
			$(em.but).click(function(){
				$('#'+em.saveBut).show();
				$(em.but).hide();
				em.num = min;		
				profileEmailIdForm();
			});
			function profileEmailIdForm(){
				em.num = min;
				$(em.parentDiv).html('<i class="fa fa-spinner fa-3x fa-spin"></i>');
				console.log(em);
				$.ajax({
					url:em.url,
					type:'POST',
					data:{autoloader:true,action:'profileEmailIdForm',det:em},
					success: function(data, textStatus, xhr){
						console.log(data);
						data = $.parseJSON($.trim(data));
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							default:
								$(em.parentDiv).html(data.html);
								$(document).ready(function(){
									$('#'+em.plus).click(function(){
										addMultipleProfileEmailIds();	
									});
									$('#'+em.minus).bind('click', function() {
										minusMultipleProfileEmailIds();										
										return false;
  									});
									$('#'+em.saveBut).click(function(){
										editProfileEmailId();
									});
									$('#'+em.closeBut).click(function(){
										$(em.but).show();
										$('#'+em.saveBut).hide();
										listProfileEmailIds();
									});
									window.setTimeout(function(){
										if(data.oldemail){
											for(i=0;i<data.oldemail.length;i++){

												var id = Number(data.oldemail[i].id);
												$('#'+data.oldemail[i].deleteOk).click({param1:id},function(event){
													$($(this).prop('name')).hide(400);
													if(deleteProfileEmailId(event.data.param1)){
														profileEmailIdForm();
													}
												});
											}
										}
									},300);
								});
							break;
						}
					},
					error: function(xhr, textStatus){
						$(em.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
			};
			function editProfileEmailId(){
				var insert = [];
				var update = [];
				var emailids = {
					insert 		: insert,
					update 		: update,
					uid 		: em.uid,
					index 		: em.index,
					listindex 	: em.listindex
				};
				var flag = false;
					if(em.num > -1){
						j=0;
						k=0;
						for(i=0;i<=em.num;i++){
							var ems = $(document.getElementById(em.email+i)).val();
							var id = $(document.getElementById(em.email+i)).prop('name');
							if(ems.match(email_reg)){
								flag = true;
								$(document.getElementById(em.msgDiv+i)).html(VALIDNOT);			
								if(id != 'email'){
									update[j] = {email:ems,id:id};
									j++;
								}
								else if(id == 'email'){
									insert[k] = ems;
							      	k++;
							    }
							}
							else{
								flag = false;
								$(document.getElementById(em.msgDiv+i)).html(INVALIDNOT);
								$('html, body').animate({scrollTop: Number($(document.getElementById(em.msgDiv+i)).offset().top)-95}, "slow");
								$(document.getElementById(em.email+i)).focus();
								return;
							}
						}
				}
				if(flag){
					emailids.insert = insert;
					emailids.update = update;
					console.log(emailids.insert);
					$('#'+em.saveBut).unbind();
					$.ajax({
						url:em.url,
						type:'POST',
						data:{autoloader:true,action:'editProfileEmailId',emailids:emailids},
						success: function(data, textStatus, xhr){
							console.log(data);
							data = $.parseJSON($.trim(data));
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								default:
									min++;
									profileEmailIdForm();
								break;
							}
						},
						error: function(xhr, textStatus){
							$(em.outputDiv).html(INET_ERROR);
						},
						complete: function(xhr, textStatus) {
							console.log(xhr.status);
						}
					});
				}
			};
			function addMultipleProfileEmailIds(){
				console.log(em.num);
				em.num++;
				for(i=min;i<=em.num;i++){
					$(document.getElementById(em.minus+i+'_delete')).hide();
				}
				var oldemail = {
					formid: em.form+em.num,
					textid: em.email+em.num,
					msgid: em.msgDiv+em.num,
					deleteid: em.minus+em.num+'_delete'
				};
				var html = '<div><div class="form-group input-group" id="'+oldemail.formid+'">'+
						'<input class="form-control" placeholder="Email ID" name="email" type="text" id="'+oldemail.textid+'" maxlength="100"/>'+
						'<span class="input-group-addon"></span>'+
						'</div><div class="col-lg-16"><p class="help-block" id="'+oldemail.msgid+'">Press enter or go button to move to next field.</p></div></div>';
				$(em.parentDiv).append(html);
				window.setTimeout(function(){
					$(document.getElementById(oldemail.deleteid)).click(function(){
						$(this).parent().parent().parent().remove();
						$(document.getElementById(em.minus+em.num+'_delete')).show();
					});
				},200);
			};
			function minusMultipleProfileEmailIds(){
				var oldemail = {
					formid: em.form+em.num,
					textid: em.email+em.num,
					msgid: em.msgDiv+em.num,
					deleteid: em.minus+em.num+'_delete'
				};
				$(document.getElementById(oldemail.textid)).remove();
				$(document.getElementById(oldemail.msgid)).remove();
				$(document.getElementById(oldemail.formid)).remove();
				em.num--;
				window.setTimeout(function(){
					$(document.getElementById(oldemail.deleteid)).click(function(){					
					if(em.num >= min) {
							em.num--;
					}
					$(this).parent().parent().parent().remove();
					$(document.getElementById(em.minus+em.num+'_delete')).hide();
				});
				},200);
			};
			function deleteProfileEmailId(id){
				console.log(id);
				var flag = false;
				$.ajax({
					url:em.url,
					type:'POST',
					async:false,
					data:{autoloader: true,action:'deleteProfileEmailId',eid:id},
					success:function(data, textStatus, xhr){
						console.log(data);
						data = $.trim(data);
						switch(data){
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
					error: function(xhr, textStatus){
						$(em.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
				return flag;
			};
			function listProfileEmailIds(){
				var para = {
					uid 		: em.uid,
					index 		: em.index,
					listindex 	: em.listindex
				};
				var flag = false;
				$.ajax({
					url:em.url,
					type:'POST',
					data:{autoloader: true,action:'listProfileEmailIds',para:para},
					success:function(data, textStatus, xhr){

						data = $.trim(data);
						switch(data){
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
					error: function(xhr, textStatus){
						$(em.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
				return flag;
			};
		};
		this.editChangePassword = function(password){
			var pwd	=	password;
			$(pwd.saveBut).hide();
			$(pwd.but).click(function(){
				$(pwd.saveBut).show();
				$(pwd.but).hide();
				$(pwd.saveBut).click(function(){
					editChangePwd();	
				});
				$(pwd.closeBut).click(function(){
					$(pwd.but).show();
					$(pwd.saveBut).hide();
				});
			});
			function editChangePwd(){
				console.log("im here to change pwd");
				var changepwd = {
					oldpwd 		: $(pwd.oldpwd).val(),
					newpwd		: $(pwd.newpwd).val(),
					confirmpwd 	: $(pwd.confirmpwd).val(),
					msgdiv		: pwd.msgdiv
				};
				$(pwd.oldpwd).attr('disabled','disabled');
				$(pwd.newpwd).attr('disabled','disabled');
				$(pwd.confirmpwd).attr('disabled','disabled');			
				$.ajax({
					url:pwd.url,
					type:'POST',
					data:{autoloader: true,action:'editChangePwd',type:'master',det:changepwd},
					success:function(data, textStatus, xhr){
						data = $.trim(data);
						console.log(data);
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							case 'login':
								loginAdmin({});
							break;
							default:
								flag = data;
								if(flag){
									$(pwd.msgdiv).html('<strong class="text-success">Your password has been changed successfully!!!!</strong>');
									$(pwd.msgdiv).append('<br /><strong class="text-danger">You will redierct to login page shortly!!!!</strong>');
									$(pwd.divtoggle).hide(300);
									$(pwd.but).show();
									$(pwd.saveBut).hide();
									window.setTimeout(function(){
										logoutAdmin({});
									},5000);
								}
								else
								{
									$(pwd.msgdiv).html('<strong class="text-danger">Please enter the correct password!!!!</strong>');
									$(pwd.oldpwd).removeAttr('disabled').val('');
									$(pwd.newpwd).removeAttr('disabled').val('');
									$(pwd.confirmpwd).removeAttr('disabled').val('');
								}
							break;
						}
					},
					error: function(xhr, textStatus){
						$(pwd.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
			};
		};
		this.editProfileCellNumbers = function(cellno){
			var cn = cellno;
			var min = cn.num;

			$('#'+cn.saveBut).hide();
			$(cn.but).click(function(){
				$('#'+cn.saveBut).show();
				$(cn.but).hide();
				cn.num = min;
				loadProfileCellNumForm();
			});
			function loadProfileCellNumForm(){
				cn.num = min;
				console.log(cn.num);
				$(cn.parentDiv).html('<i class="fa fa-spinner fa-3x fa-spin"></i>');
				$.ajax({
					url:cn.url,
					type:'POST',
					data:{autoloader:true,action:'loadProfileCellNumForm',det:cn},
					success: function(data, textStatus, xhr){

						data = $.parseJSON($.trim(data));
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							default:
								$(cn.parentDiv).html(data.html);
								$(document).ready(function(){
									$('#'+cn.plus).click(function(){
										addMultipleProfileCellNums();
									});
									$('#'+cn.saveBut).click(function(){
										editProfileCellNum();
									});
									$('#'+cn.minus).click(function(){
										minusMultipleProfileCellNums();
									});
									$('#'+cn.closeBut).click(function(){
										$(cn.but).show();
										$('#'+cn.saveBut).hide();
										listProfileCellNums();
									});
									window.setTimeout(function(){
										if(data.oldcnums){
											for(i=0;i<data.oldcnums.length;i++){

												var id = Number(data.oldcnums[i].id);
												$('#'+data.oldcnums[i].deleteOk).click({param1:id},function(event){
													$($(this).prop('name')).hide(400);
													if(deleteProfileCellNum(event.data.param1)){
														loadProfileCellNumForm();
													}
												});
											}
										}
									},300);
								});
							break;
						}
					},
					error: function(xhr, textStatus){
						$(cn.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
			};
			function editProfileCellNum(){
				var insert = [];
				var update = [];
				var CellNums = {
					insert 		: insert,
					update 		: update,
					uid 		: cn.uid,
					index 		: cn.index,
					listindex 	: cn.listindex
				};
				var flag = false;

				/* Cell numbers */
				if(cn.num > -1){
					j=0;
					k=0;
					for(i=0;i<=cn.num;i++){

						var ems = $(document.getElementById(cn.cnumber+i)).val();
						var id = $(document.getElementById(cn.cnumber+i)).prop('name');
						console.log(id);
						if(ems.match(cell_reg)){
							flag = true;
							$(document.getElementById(cn.msgDiv+i)).html(VALIDNOT);
							if(id != 'cnumber'){
								update[j] = {cnumber:ems,id:id};
								j++;
							}
							else if(id == 'cnumber'){
								insert[k] = ems;
								k++;
							}
					   }
						else{
							flag = false;
							$(document.getElementById(cn.msgDiv+i)).html(INVALIDNOT);
							$('html, body').animate({scrollTop: Number($(document.getElementById(cn.msgDiv+i)).offset().top)-95}, "slow");
							$(document.getElementById(cn.cnumber+i)).focus();
							return;
						}
					}
				}
				if(flag){
					CellNums.insert = insert;
					CellNums.update = update;
					console.log(CellNums.insert);
					$('#'+cn.saveBut).unbind();
					$.ajax({
						url:cn.url,
						type:'POST',
						data:{autoloader:true,action:'editProfileCellNum',CellNums:CellNums},
						success: function(data, textStatus, xhr){
							var CellNums = {
								insert 		: '',
								update 		: '',
								uid 		: '',
								index 		: '',
								listindex 	: ''
							};
							console.log(data);
							data = $.parseJSON($.trim(data));
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								default:
									min++;
									loadProfileCellNumForm();
								break;
							}
						},
						error: function(xhr, textStatus){
							$(cn.outputDiv).html(INET_ERROR);
						},
						complete: function(xhr, textStatus) {
							console.log(xhr.status);

						}
					});
				}
			};
			function addMultipleProfileCellNums(){
				 console.log(cn.num);
				cn.num++;
				for(i=min;i<cn.num;i++){
					$(document.getElementById(cn.minus+i+'_delete')).hide();
				}
				var oldcnum = {
					formid: cn.form+cn.num,
					textid: cn.cnumber+cn.num,
					msgid: cn.msgDiv+cn.num,
					deleteid: cn.minus+cn.num+'_delete'
				};
				console.log(oldcnum);
				var html = '<div><div class="form-group input-group" id="'+oldcnum.formid+'">'+
						'<input class="form-control" placeholder="Cell number" name="cnumber" type="text" id="'+oldcnum.textid+'" maxlength="10"/>'+
						'<span class="input-group-addon"></span>'+
						'</div><div class="col-lg-16"><p class="help-block" id="'+oldcnum.msgid+'">Press enter or go button to move to next field.</p></div></div>';
				$(cn.parentDiv).append(html);
				window.setTimeout(function(){
					$(document.getElementById(oldcnum.deleteid)).click(function(){
						if(cn.num >= min)
							cn.num--;
						$(this).parent().parent().parent().remove();
						$(document.getElementById(cn.minus+cn.num+'_delete')).show();
					});
				},200);
			};
			function minusMultipleProfileCellNums(){

				cn.num--;

					$(document.getElementById(cn.minus+i+'_delete')).hide();

				var oldcnum = {
					formid: cn.form+cn.num,
					textid: cn.cnumber+cn.num,
					msgid: cn.msgDiv+cn.num,
					deleteid: cn.minus+cn.num+'_delete'
				};
					$(document.getElementById(cn.form+cn.num)).hide();
					$(document.getElementById(cn.cnumber+cn.num)).hide();
					$(document.getElementById(cn.msgDiv+cn.num)).hide();				
				var html = '<div><div class="form-group input-group" id="'+oldcnum.formid+'"></div></div>';

				window.setTimeout(function(){
					$(document.getElementById(oldcnum.deleteid)).click(function(){
						if(cn.num >= min)
							cn.num--;
						$(this).parent().parent().parent().remove();
						$(document.getElementById(cn.minus+cn.num+'_delete')).show();
					});
				},200);
			};
			function listProfileCellNums(){
				var para = {
					uid 		: cn.uid,
					index 		: cn.index,
					listindex 	: cn.listindex
				};
				var flag = false;
				$.ajax({
					url:cn.url,
					type:'POST',
					data:{autoloader: true,action:'listProfileCellNums',para:para},
					success:function(data, textStatus, xhr){

						data = $.trim(data);
						switch(data){
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
					error: function(xhr, textStatus){
						$(cn.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
				return flag;
			};
			function deleteProfileCellNum(id){
				console.log(id);
				var flag = false;
				$.ajax({
					url:cn.url,
					type:'POST',
					async:false,
					data:{autoloader: true,action:'deleteProfileCellNum',eid:id},
					success:function(data, textStatus, xhr){

						data = $.trim(data);
						switch(data){
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
					error: function(xhr, textStatus){
						$(cn.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
				return flag;
			};
		};
		this.editUserAddress = function(addr){
			var address = addr;
			var addres;
			var PCR_reg = '';
			var countries = {};
			var states = {};
			var districts = {};
			var cities = {};
			var localities = {};
			$(address.but).click(function(){
				$(address.showDiv).toggle();
				$(address.updateDiv).toggle();
				if($(address.updateDiv).css('display') == 'block'){
					addres = new Address();
					addres.__construct({url : address.url,outputDiv:address.outputDiv});
					addres.getIPData({});

					countries = addres.getCountry();
					attachAddressFields();
				}
			});
			$(address.saveBut).click(function(){
				editAddress();
			});
			$(address.closeBut).click(function(){
				listAddress();
			});
			function attachAddressFields(){
				var list = countries;
				$(address.country).autocomplete({
					minLength: 2,
					source:list,
					autoFocus: true,
					select: function( event, ui ) {
						window.setTimeout(function(){
							$(address.country).val(ui.item.label);
							$(address.country).attr('name',ui.item.value);
							address.countryCode = ui.item.countryCode;
							address.PCR_reg = ui.item.PCR;
							addres.setCountry(ui.item);
							$(address.province).val('');
							$(address.province).focus();
						},50);
						$(address.province).focus(function(){
							states = addres.getState();
							var list = states;
							$(address.province).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.province).val(ui.item.label);
										$(address.province).attr('name',ui.item.value);
										address.provinceCode = ui.item.provinceCode;
										address.lat = ui.item.lat;
										address.lon = ui.item.lon;
										address.timezone = ui.item.timezone;
										addres.setState(ui.item);
										$(address.district).val('');
										$(address.district).focus();
									},50);
								}
							});
						});
						$(address.district).focus(function(){
							districts = addres.getDistrict();
							var list = districts;
							$(address.district).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.district).val(ui.item.label);
										$(address.district).attr('name',ui.item.value);
										address.districtCode = ui.item.districtCode;
										address.lat = ui.item.lat;
										address.lon = ui.item.lon;
										address.timezone = ui.item.timezone;
										addres.setDistrict(ui.item);
										$(address.city_town).val('');
										$(address.city_town).focus();
									},50);
								}
							});
						});
						$(address.city_town).focus(function(){
							cities = addres.getCity();
							var list = cities;
							$(address.city_town).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.city_town).val(ui.item.label);
										$(address.city_town).attr('name',ui.item.value);
										address.city_townCode = ui.item.city_townCode;
										address.lat = ui.item.lat;
										address.lon = ui.item.lon;
										address.timezone = ui.item.timezone;
										addres.setCity(ui.item);
										$(address.st_loc).val('');
										$(address.st_loc).focus();
									},50);
								}
							});
						});
						$(address.st_loc).focus(function(){
							localities = addres.getLocality();
							var list = localities;
							$(address.st_loc).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.st_loc).val(ui.item.label);
										$(address.st_loc).attr('name',ui.item.value);
										address.st_locCode = ui.item.st_locCode;
										address.lat = ui.item.lat;
										address.lon = ui.item.lon;
										address.timezone = ui.item.timezone;
										addres.setLocality(ui.item);
									},200);
								}
							});
						});
					}
				});
			};
			function editAddress(){
				/* Address */
				var flag = false;
				/* Country */
				if($(address.country).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.comsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.comsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.comsg).offset().top)-95}, "slow");
					$(address.country).focus();
					return;
				}
				/* Province */
				if($(address.province).val().match(prov_reg)){
					flag = true;
					$(address.prmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.prmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.prmsg).offset().top)-95}, "slow");
					$(address.province).focus();
					return;
				}
				/* District */
				if($(address.district).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.dimsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.dimsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.dimsg).offset().top)-95}, "slow");
					$(address.district).focus();
					return;
				}
				/* City */
				if($(address.city_town).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.citmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.citmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.citmsg).offset().top)-95}, "slow");
					$(address.city_town).focus();
					return;
				}
				/* Street / Locality */
				if($(address.st_loc).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.stlmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.stlmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.stlmsg).offset().top)-95}, "slow");
					$(address.st_loc).focus();
					return;
				}
				/* Address Line */
				if($(address.addrs).val().match(addline_reg)){
					flag = true;
					$(address.admsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.admsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.admsg).offset().top)-95}, "slow");
					$(address.addrs).focus();
					return;
				}
				var attr = {
					uid 		: address.uid,
					index 		: address.index,
					listindex 	: address.listindex,
					country		: $(address.country).val(),
					countryCode	: address.countryCode,
					province	: $(address.province).val(),
					provinceCode: address.provinceCode,
					district	: $(address.district).val(),
					city_town	: $(address.city_town).val(),
					st_loc		: $(address.st_loc).val(),
					addrsline	: $(address.addrs).val(),
					zipcode		: $(address.zipcode).val(),
					website		: $(address.website).val(),
					gmaphtml	: $(address.gmaphtml).val(),
					timezone	: address.timezone,
					lat			: address.lat,
					lon			: address.lon
				};
				if(flag){
					$.ajax({
						url:address.Updateurl,
						type:'POST',
						data:{autoloader:true,action:'editProfileAddress',address:attr},
						success: function(data, textStatus, xhr){

							data = $.parseJSON($.trim(data));
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								default:
									$(address.closeBut).trigger('click');
								break;
							}
						},
						error: function(xhr, textStatus){
							$(address.outputDiv).html(INET_ERROR);
						},
						complete: function(xhr, textStatus) {
							console.log(xhr.status);
						}
					});
				}
			};
			function listAddress(){
				var para = {
					uid 		: address.uid,
					index 		: address.index,
					listindex 	: address.listindex
				};				
				var flag = false;
				$.ajax({
					url:window.location.href,
					type:'POST',
					data:{autoloader: true,action:'listProfileAddress',para:para},
					success:function(data, textStatus, xhr){

						data = $.trim(data);
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							case 'login':
								loginAdmin({});
							break;
							default:
								$(address.showDiv).html(data);
								$(address.showDiv).toggle();
								$(address.updateDiv).toggle();
							break;
						}
					},
					error: function(xhr, textStatus){
						$(address.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
				return flag;
			};
		};
		this.expiryCountDown = function(expr){
			var exp	=	expr;
			console.log(exp.expiryDate);

			$("#expiry_date").countdown(exp.expiryDate, function(event) {
				$(this).text(
					event.strftime("%D days %H:%M:%S")
				);
			});

		}
		function initializeViewProfile(){
			console.log("im in view profile");
			$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{autoloader:'true',action:'load_ViewProfile',type:'master'},
				success: function(data){
					switch(data){
						case "logout":
							logoutAdmin();
							break;
						default:
							$(pfview).html(data);
							/*pic edit*/
						$(".picedit_box").picEdit({
							imageUpdated: function(img){
							},
							formSubmitted: function(data){
							window.setTimeout(function(){
								$('#myModal_Photo').modal('toggle');
									initializeViewProfile();
								},500);
							},
							redirectUrl: false,
							defaultImage: URL+ASSET_IMG+'No_image.png',
						});
							$(loader).hide();						
						break;
					}
				}
			});
		}
	}
