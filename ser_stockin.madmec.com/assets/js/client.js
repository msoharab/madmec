var loader="#centerLoad";
function clientController(){
		var pf={};
		var add={};
		var em={};
		var cn={};
		var address={};
		var listofvaliditytypes = {};
		var dccode = '91';
		var dpcode = '080';
		this.countries = {};
		this.__construct = function(client){
			pf=client;
			add=client.addclient;
			em=client.addclient.em;
			cn=client.addclient.cn;
			address=client.addclient.address;
		/*pic edit*/
		$(add.picbox).picEdit({
			imageUpdated: function(img){
				
			},
                        _formsubmit: function() {
                         $(pf.addusrBut).hide();
                        },
                                
			formSubmitted: function(data){
				$(pf.msgDiv).html('<h2>Record success fully added</h2>');
				window.setTimeout(function(){
							$(pf.msgDiv).html('');
						},2000);
				console.log(data.response);
				switch(data.response){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(pf.addclient.form).get(0).reset();
                                                $(pf.addusrBut).show();
					break;
				}
				
			},
			redirectUrl: false,
            defaultImage: URL+ASSET_IMG+'No_image.png',
		});
		$(add.but).click(function(){
			clientAdd(); 
		});
		$(add.list.menuBut).click(function(){
				DisplayUserList();
		});
		$( "#payment_date,#subscribe_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			yearRange:'2014:'+Number(new Date().getFullYear())+2,
		});
		initializeProfileAddForm();
		fetchValidityTypes();
                $('#usernameclient').on('change',function (){
                   checkUserName(); 
                });
	};
        function  checkUserName()
        {
           $.ajax({
				url:window.location.href,
				type:'POST',
				async:false,
				data:{autoloader: true,action:'checkclientusername',type:'master',chkusername:$('#usernameclient').val()},
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
							var flag=Number($.parseJSON(data));
                                                        if(flag)
                                                        {
                                                          $('#checkunameclient').val('');
                                                          $('#usernameclient_msg').html(ALREADYEXIST);
                                                        }
                                                        else
                                                        {
                                                          $('#checkunameclient').val(flag); 
                                                          $('#usernameclient_msg').html('');
                                                        }
						break;
					}
				},
				error:function(){
					$(usr.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			}); 
        }
	this.editUserEmailIds = function(email){
			var em = email;
			var min = em.num;
			$(em.but).click(function(){
				
				em.num = min;
				loadEmailIdForm();
			});
			function loadEmailIdForm(){
				em.num = min;
				// console.log(em.num);
				$(em.parentDiv).html(LOADER_TWO);
				$.ajax({
					url:em.url,
					type:'POST',
					data:{autoloader:true,action:'loadEmailIdForm',type:'master',det:em},
					success: function(data, textStatus, xhr){
						console.log("i clicked email");
						data = $.parseJSON($.trim(data));
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							default:
								$(em.parentDiv).html(data.html);
								$(document).ready(function(){
									$('#'+em.plus).click(function(){
										addMultipleEmailIds();
									});
									$('#'+em.saveBut).click(function(){
										editEmailId();
									});
										$('#'+em.minus).bind('click', function() {
										minusMultipleEmailIds();										
										return false;
  									});
									$('#'+em.closeBut).click(function(){
										listEmailIds();
									});
									window.setTimeout(function(){
										if(data.oldemail){
											for(i=0;i<data.oldemail.length;i++){
												var id = Number(data.oldemail[i].id);
												$('#'+data.oldemail[i].deleteOk).click({param1:id},function(event){
													$($(this).prop('name')).hide(400);
													if(deleteEmailId(event.data.param1)){
														loadEmailIdForm();
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
			function addMultipleEmailIds(){
				// console.log(em.num);
				em.num++;
				for(i=min;i<em.num;i++){
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
						'</div><div class="col-lg-16"><p class="help-block" id="'+oldemail.msgid+'">Enter/ Select.</p></div></div>';
				$(em.parentDiv).append(html);
				window.setTimeout(function(){
					$(document.getElementById(oldemail.deleteid)).click(function(){
						if(em.num >= min)
							em.num--;
						$(this).parent().parent().parent().remove();
						$(document.getElementById(em.minus+em.num+'_delete')).show();
					});
				},200);
			};
			function minusMultipleEmailIds(){
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
			function editEmailId(){
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
				// min
				/* Email ids */
				// console.log(em.num);
				if(em.num > -1){
					j=0;
					k=0;
					for(i=0;i<=em.num;i++){
						// console.log($(document.getElementById(em.email+i)).val());
						// console.log(em.email+i);
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
					$('#'+em.saveBut).unbind();
					// console.log(emailids);
					$.ajax({
						url:em.url,
						type:'POST',
						data:{autoloader:true,action:'editEmailId',type:'master',emailids:emailids},
						success: function(data, textStatus, xhr){
							data = $.parseJSON($.trim(data));
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								default:
								min++;
								loadEmailIdForm();
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
			function deleteEmailId(id){
				// console.log(id);
				var flag = false;
				$.ajax({
					url:em.url,
					type:'POST',
					async:false,
					data:{autoloader: true,action:'deleteEmailId',type:'master',eid:id},
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
						$(em.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
					}
				});
				return flag;
			};
			function listEmailIds(){
				var para = {
					uid 		: em.uid,
					index 		: em.index,
					listindex 	: em.listindex
				};
				var flag = false;
				$.ajax({
					url:em.url,
					type:'POST',
					data:{autoloader: true,action:'listEmailIds',type:'master',para:para},
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
	this.editUserCellNumbers = function(cnumber){
			var cn = cnumber;
			var min = cn.num;
			$(cn.but).click(function(){
				cn.num = min;
				loadCellNumForm();
			});
			function loadCellNumForm(){
				cn.num = min;
				// console.log(cn.num);
				$(cn.parentDiv).html(LOADER_TWO);
				$.ajax({
					url:cn.url,
					type:'POST',
					data:{autoloader:true,action:'loadCellNumForm',type:'master',det:cn},
					success: function(data, textStatus, xhr){
                                                console.log(data);
						data = $.parseJSON($.trim(data));
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							default:
								$(cn.parentDiv).html(data.html);
								$(document).ready(function(){
									$('#'+cn.plus).click(function(){
										addMultipleCellNums();
									});
									$('#'+cn.minus).bind('click', function() {
										minusMultipleCellNums();										
										return false;
  									});
									$('#'+cn.saveBut).click(function(){
										editCellNum();
									});
									$('#'+cn.closeBut).click(function(){
										listCellNums();
									});
									window.setTimeout(function(){
										if(data.oldcnum){
											for(i=0;i<data.oldcnum.length;i++){
												var id = Number(data.oldcnum[i].id);
												$('#'+data.oldcnum[i].deleteOk).click({param1:id},function(event){
													$($(this).prop('name')).hide(400);
													if(deleteCellNum(event.data.param1)){
														loadCellNumForm();
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
			function addMultipleCellNums(){
				// console.log(cn.num);
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
				var html = '<div><div class="form-group input-group" id="'+oldcnum.formid+'">'+
						'<input class="form-control" placeholder="Cell number" name="cnumber" type="text" id="'+oldcnum.textid+'" maxlength="10"/>'+
						'<span class="input-group-addon"></span>'+
						'</div><div class="col-lg-16"><p class="help-block" id="'+oldcnum.msgid+'">Enter/ Select.</p></div></div>';
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
			function minusMultipleCellNums(){
				// console.log(cn.num);
				cn.num--;
			    //for(i=min;i<cn.num;i++){
					$(document.getElementById(cn.minus+i+'_delete')).hide();
				//}
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
				//$(cn.parentDiv).append(html);
				window.setTimeout(function(){
					$(document.getElementById(oldcnum.deleteid)).click(function(){
						if(cn.num >= min)
							cn.num--;
						$(this).parent().parent().parent().remove();
						$(document.getElementById(cn.minus+cn.num+'_delete')).show();
					});
				},200);
			};
			function editCellNum(){
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
				// min
				/* Cell numbers */
				// console.log(cn.num);
				if(cn.num > -1){
					j=0;
					k=0;
					for(i=0;i<=cn.num;i++){
						// console.log($(document.getElementById(cn.cnumber+i)).val());
						// console.log(cn.cnumber+i);
						var ems = $(document.getElementById(cn.cnumber+i)).val();
						var id = $(document.getElementById(cn.cnumber+i)).prop('name');
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
					$('#'+cn.saveBut).unbind();
					// console.log(CellNums);
					$.ajax({
						url:cn.url,
						type:'POST',
						data:{autoloader:true,action:'editCellNum',type:'master',CellNums:CellNums},
						success: function(data, textStatus, xhr){
							data = $.parseJSON($.trim(data));
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								default:
								min++;
								loadCellNumForm();
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
			function deleteCellNum(id){
				// console.log(id);
				var flag = false;
				$.ajax({
					url:cn.url,
					type:'POST',
					async:false,
					data:{autoloader: true,action:'deleteCellNum',type:'master',eid:id},
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
			function listCellNums(){
				var para = {
					uid 		: cn.uid,
					index 		: cn.index,
					listindex 	: cn.listindex
				};
				var flag = false;
				$.ajax({
					url:cn.url,
					type:'POST',
					data:{autoloader: true,action:'listCellNums',type:'master',para:para},
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
					// addres.fillAddressFields(address);
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
				// /* ZipCode*/
				// console.log(address.PCR_reg);
				// var PCR_reg = '/'+address.PCR_reg+'/';
				// if($(address.zipcode).val().match(PCR_reg)){
					// flag = true;
					// $(address.zimsg).html(VALIDNOT);
				// }
				// else{
					// flag = false;
					// $(address.zimsg).html(INVALIDNOT);
					// $('html, body').animate({scrollTop: Number($(address.zimsg).offset().top)-95}, "slow");
					// $(address.zipcode).focus();
					// return;
				// }
				// /* Website */
				// var url_reg = '/'+url_reg+'/';
				// if($(address.website).val().match(url_reg)){
					// flag = true;
					// $(address.wemsg).html(VALIDNOT);
				// }
				// else{
					// flag = false;
					// $(address.wemsg).html(INVALIDNOT);
					// $('html, body').animate({scrollTop: Number($(address.wemsg).offset().top)-95}, "slow");
					// $(address.website).focus();
					// return;
				// }
				// /* GMAP */
				// if($(address.gmaphtml).val().match(url_reg)){
					// flag = true;
					// $(address.gmmsg).html(VALIDNOT);
				// }
				// else{
					// flag = false;
					// $(address.gmmsg).html(INVALIDNOT);
					// $('html, body').animate({scrollTop: Number($(address.gmmsg).offset().top)-95}, "slow");
					// $(address.gmaphtml).focus();
					// return;
				// }
				var attr = {
					uid 		: address.uid,
					index 		: address.index,
					listindex 	: address.listindex,
					country		: $(address.country).val(),
					countryCode	: address.countryCode,
					province	: $(address.province).val(),
					provinceCode    : address.provinceCode,
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
						data:{autoloader:true,action:'editAddress',type:'master',address:attr},
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
					data:{autoloader: true,action:'listAddress',type:'master',para:para},
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
	this.close	=	function(clid){
		var cl = clid;
		$(cl.closeDiv).click(function(){
				$(cl.clisttab).click();
		});
	}
	this.bindAddressFields = function(addres){
			var list = this.countries;
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
						dccode = ui.item.Phone;
						$(cn.codep+'0').val(ui.item.Phone);
						for(i=0;i<=cn.num;i++){
							$(document.getElementById(cn.codep+i)).val(ui.item.Phone);
						}
						addres.setCountry(ui.item);
						$(address.province).val('');
						$(address.province).focus();
					},50);
					$(address.province).focus(function(){
						this.states = addres.getState();
						var list = this.states;
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
						this.districts = addres.getDistrict();
						var list = this.districts;
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
						this.cities = addres.getCity();
						var list = this.cities;
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
						this.localities = addres.getLocality();
						var list = this.localities;
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
	function clientAdd(){
		var attr = validateUserFields();
		console.log(attr);
			if(attr){
				$(add.but).prop('disabled','disabled');
				$(pf.msgDiv).html('');
				$(loader).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
				$.ajax({
					url:pf.url,
					type:'POST',
					data:{autoloader: true,action: 'clientAdd',type:'master',add:attr},
					success:function(data, textStatus, xhr){
						//console.log(data);
						data = $.trim(data);
						console.log(xhr.status);
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							case 'login':
								loginAdmin({});
							break;
							default:
								$(add.form).get(0).reset();
								$('#address_body').hide(300);
								$(loader).html('');
							break;
						}
					},
					error:function(){
						$(usr.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
						$(add.but).removeAttr('disabled');
					}
				});
			}
			else{
				$(add.but).removeAttr('disabled');
			}
	};
	function DisplayUpdatedUserList(){
			var htm='';
			$(add.list.listLoad).html(LOADER_FUR);
			$.ajax({
				url:add.list.url,
				type:'post',
				data:{autoloader:true,action:'DisplayUpdatedUserList',type:'master'},
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
							var listusers = $.parseJSON(data);
							for(i=0;i<listusers.length;i++){
								htm += listusers[i]["html"];
							}
							$(add.list.listDiv).append(htm);
							$(add.list.listLoad).html('');
						break;
					}
				},
				error:function(){
					$(add.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
	function DisplayUserList(){
			var header='<table class="table table-striped table-bordered table-hover" id="list_user_table"><thead><tr><th colspan="7">Lists</th></tr><tr>\n\
                        <th>#</th><th>User Name</th><th>Name</th><th>Mobile</th><th>Email</th><th class="text-right">User Type</th><th class="text-left"></th></tr></thead>';
			var footer='</table>';
			var htm = '';
			$(add.list.listDiv).html(LOADER_FUR);
			$.ajax({
				url:add.list.url,
				type:'post',
				data:{autoloader:true,action:'DisplayUserList',type:'master'},
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
							var listusers = $.parseJSON(data);
							for(i=0;i<listusers.length;i++){
								htm += listusers[i]["html"];
							}
							$(add.list.listDiv).html(header+htm+footer);
							for(i=0;i<listusers.length;i++){
								$(listusers[i].usrdelOk).bind('click',{uid:listusers[i].uid,sr:listusers[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									console.log(evt.data.uid);
									var hid = deleteUser(evt.data.uid);
									if(hid){
										$(evt.data.sr).remove();
										DisplayUserList();
									}
								});
								$(listusers[i].usrflgOk).bind('click',{uid:listusers[i].uid,sr:listusers[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									var hid = flagUser(evt.data.uid);
									DisplayUserList();
								});
								$(listusers[i].usruflgOk).bind('click',{uid:listusers[i].uid,sr:listusers[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									var hid = unflagUser(evt.data.uid);
									DisplayUserList();
								});
								$(listusers[i].usredit).bind('click',{uid:listusers[i].uid,sr:listusers[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									var hid = edituser(evt.data.uid);
									//DisplayUserList();
								});
							}
							window.setTimeout(function(){
								$('#list_user_table').dataTable();
							},600)
							$(add.list.listLoad).html('');
						break;
					}
				},
				error:function(){
					$(add.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			//$(window).scroll(function(event){
				//if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
					//DisplayUpdatedUserList();
				//else
					//$(add.list.listLoad).html('');
			//});
		};
	function edituser(id){
		var	usrid = id;
		var htm='';
//		console.log("i clicked edit"+usrid);
		$.ajax({
				url:window.location.href,
				type:'POST',
				async:false,
				data:{autoloader: true,action:'edituser',type:'master',usrid:usrid},
				success:function(data, textStatus, xhr){
//					console.log("status"+data);
					//data = $.trim(data);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
						$(add.list.listDiv).html(data);
							//flag = data;
						break;
					}
				},
				error:function(){
					$(usr.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			//return flag;
	}
	function deleteUser(uid){
			var flag = false;
	        var	entid = uid;
			console.log(entid);
			$.ajax({
				url:window.location.href,
				type:'POST',
				async:false,
				data:{autoloader: true,action:'deleteUser',type:'master',ptydeletesale:entid},
				success:function(data, textStatus, xhr){
					console.log("delete status"+data);
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
				error:function(){
					$(usr.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			return flag;
		}
	function flagUser(id) {
			var uid = id;
			var flag = false;
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{autoloader:true,action:'flagUser',type:'master',fuser:uid},
				success: function (data, textStatus, xhr) {
					data = $.trim(data);
					//console.log(data);
					 if(!data){
						flag=false;
					}
					 else
					    flag=true;
				  }							
				});
			return flag;			
		}
	function unflagUser(id) {
			var uid = id;
			var flag = false;
			$.ajax({
				url:window.location.href,
				type:'POST',
				data:{autoloader:true,action:'unflagUser',type:'master',ufuser:uid},
				success: function (data, textStatus, xhr) {
					console.log(data);
					data = $.trim(data);
					if(data){
						flag=true;
					}				  
				  }							
				});
			return flag;					
		}
	function validateUserFields(){
			var flag = false;
			var email = [];
			var cellnumbers = [];
			/* User name */
			if($(add.name).val().match(name_reg)){
				flag = true;
				$(add.name_msg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(add.name_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(add.name_msg).offset().top)-95}, "slow");
				$(add.name).focus();
				return;
			}
			/*validity type*/
			if(add.type != 'NULL' && add.type != ''){
				flag = true;
			}
			else{
				flag = false;
				$(add.type).html('<strong class="text-danger">Select user type.</strong>');
				$('html, body').animate({scrollTop: Number($(add.type).offset().top)-95}, "slow");
				return;
			}
			/* owner name */
			if($(add.owner).val().match(name_reg)){
				flag = true;
				$(add.owner_msg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(add.owner_msg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(add.owner_msg).offset().top)-95}, "slow");
				$(add.owner).focus();
				return;
			}
			/* Email ids */
			if(em.num > -1){
				j=0;
				for(i=0;i<=em.num;i++){
					if($(document.getElementById(em.email+i)).val().match(email_reg)){
						flag = true;
						$(document.getElementById(em.msgDiv+i)).html(VALIDNOT);
						email[j] = $(document.getElementById(em.email+i)).val();
						j++;
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
			/* Cell numbers */
			if(cn.num > -1){
				j=0;
				for(i=0;i<=cn.num;i++){
					if($(document.getElementById(cn.codep+i)).val().match(ccod_reg)){
						flag = true;
						$(document.getElementById(cn.msgDiv+i)).html(VALIDNOT);
					}else{
						flag = false;
						$(document.getElementById(cn.msgDiv+i)).html('<strong class="text-danger">Not Valid Cell prefiex</strong>');
						$('html, body').animate({scrollTop: Number($(document.getElementById(cn.msgDiv+i)).offset().top)-95}, "slow");
						$(document.getElementById(cn.codep+i)).focus();
						return;
					}
					if($(document.getElementById(cn.nump+i)).val().match(cell_reg)){
						flag = true;
						$(document.getElementById(cn.msgDiv+i)).html(VALIDNOT);
					}else{
						flag = false;
						$(document.getElementById(cn.msgDiv+i)).html(INVALIDNOT);
						$('html, body').animate({scrollTop: Number($(document.getElementById(cn.msgDiv+i)).offset().top)-95}, "slow");
						$(document.getElementById(cn.nump+i)).focus();
						return;
					}
					if(flag){
						cellnumbers[j] = {
							codep:$(document.getElementById(cn.codep+i)).val(),
							nump:$(document.getElementById(cn.nump+i)).val()
						};
						j++;
					}
				}
			}
			var attr = {
				type		: $(add.type).val(),
				name		: $(add.name).val(),
				acs			: $(add.acs_id).val(),
				email		: email,
				cellnumbers	: cellnumbers,
				owner		: $(add.owner).val(),
				sms			: $(add.sms).val(),
				paydate		: $(add.paydate).val(),
				subdate		: $(add.subdate).val(),
				country		: $(add.address.country).val(),
				countryCode	: add.address.countryCode,
				province	: $(add.address.province).val(),
				provinceCode: add.address.provinceCode,
				district	: $(add.address.district).val(),
				city_town	: $(add.address.city_town).val(),
				st_loc		: $(add.address.st_loc).val(),
				addrsline	: $(add.address.addrs).val(),
				tphone		: $(add.address.tphone).val(),
				pcode		: $(add.address.pcode).val(),
				zipcode		: $(add.address.zipcode).val(),
				website		: $(add.address.website).val(),
				gmaphtml	: $(add.address.gmaphtml).val(),
				timezone	: add.address.timezone,
				lat			: add.address.lat,
				lon			: add.address.lon
			};
			if(flag){
				return attr;
			}
			else
				return false;
	};
	function initializeProfileAddForm(){
			$(cn.plus +','+ em.plus).unbind();
			$(cn.plus).click(function(){
				$(cn.plus).hide();
				bulitMultipleCellNumbers();
			});
			$(em.plus).click(function(){
				$(em.plus).hide();
				bulitMultipleEmailIds();
			});

	};
	function fetchValidityTypes(){
			var rad = '';
			$.ajax({
				type:'POST',
				url:window.location.href,
				data:{autoloader:true,action:'fetchValidityTypes',type:'master'},
				success:function(data, textStatus, xhr){
					data = $.trim(data);
					//console.log(data);
					console.log(xhr.status);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							var type = $.parseJSON(data);
							listofvaliditytypes = type;
							for(i=0;i<type.length;i++){
								rad += type[i]["html"];
							}
							$(add.type).html('<option value="NULL" selected>Select Mode of payment</option>'+rad);
							
						break;
					}
				},
				error:function(){
					$(payms.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
	function bulitMultipleEmailIds(){
			if(em.num == -1)
				$(em.parentDiv).html('');
			em.num++;
			var html = '<div id="'+em.form+em.num+'">'+
				'<div class="col-lg-8">'+
					'<input class="form-control" pattern="^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$" placeholder="Email ID" required name="email[]" type="text" id="'+em.email+em.num+'" maxlength="100"/>'+
					'<p class="help-block" id="'+em.msgDiv+em.num+'">Press enter or go button to move to next field.</p>'+
				'</div>'+
				'<div class="col-lg-4">'+
					'<button type="button" class="btn btn-danger  btn-md" id="'+em.minus+em.num+'"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;'+
					'<button type="button" class="btn btn-success  btn-md" id="'+em.plus+em.num+'"><i class="fa fa-plus fa-fw fa-x2"></i></button>'+
				'</div>'+
			'</div>';
			$(em.parentDiv).append(html);
			window.setTimeout(function(){
				$(document.getElementById(em.minus+em.num)).click(function(){
					$(document.getElementById(em.form+em.num)).remove();
					$(document.getElementById(em.msgDiv+em.num)).remove();
					em.num--;
					if(em.num == -1){
						$(em.plus).show();
						$(em.parentDiv).html('');
					}
					else{
						$(document.getElementById(em.plus+em.num)).show();
						$(document.getElementById(em.minus+em.num)).show();
					}
					if(em.count && em.count == em.num){
						$(em.plus).show();
					}
				});
				$(document.getElementById(em.plus+em.num)).click(function(){
					$(document.getElementById(em.plus+em.num)).hide();
					$(document.getElementById(em.minus+em.num)).hide();
					bulitMultipleEmailIds();
				});
			},200);
		};
	function bulitMultipleCellNumbers(){
			if(cn.num == -1)
				$(cn.parentDiv).html('');
			cn.num++;
			var html = '<div class="row show-grid" id="'+cn.form+cn.num+'">'+
						'<div class="col-xs-6 col-md-4">'+
							'<input class="form-control" value="'+dccode+'" pattern="[0-9]{2,15}$" name="cellnumbers['+cn.num+'][codep]" required type="text" id="'+cn.codep+cn.num+'" maxlength="15" />'+
						'</div>'+
						'<div class="col-xs-6 col-md-4">'+
							'<input class="form-control" placeholder="Cell Number" pattern="[0-9]{10,20}$" required name="cellnumbers['+cn.num+'][nump]" type="text" id="'+cn.nump+cn.num+'" maxlength="20" />'+
						'</div>'+
						'<div class="col-xs-6 col-md-4" id="btn'+cn.num+'">'+
							'<button type="button" class="btn btn-danger  btn-md" id="'+cn.minus+cn.num+'"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;'+
							'<button type="button" class="btn btn-success  btn-md" id="'+cn.plus+cn.num+'"><i class="fa fa-plus fa-fw fa-x2"></i></button>'+
						'</div>'+
					'</div>'+
					'<div class="col-lg-12"><p class="help-block" id="'+cn.msgDiv+cn.num+'">Press enter or go button to move to next field.</p></div>';
			$(cn.parentDiv).append(html);
			window.setTimeout(function(){
				$(function() {
					$(document.getElementById(cn.minus+cn.num)).click(function(){
						$(document.getElementById(cn.form+cn.num)).remove();
						$(document.getElementById(cn.msgDiv+cn.num)).remove();
						cn.num--;
						if(cn.num == -1){
							$(cn.plus).show();
						}
						else if(cn.count && cn.count == cn.num){
							$(cn.plus).show();
						}
						else{
							$(document.getElementById(cn.plus+cn.num)).show();
							$(document.getElementById(cn.minus+cn.num)).show();
							btdiv="btn"+cn.num;
							document.getElementById(btdiv).style.visibility = "visible";
						}
					});
					$(document.getElementById(cn.plus+cn.num)).click(function(){
						$(document.getElementById(cn.plus+cn.num)).hide();
						$(document.getElementById(cn.minus+cn.num)).hide();
						btdiv="btn"+cn.num;
						document.getElementById(btdiv).style.visibility = "hidden";
						
						bulitMultipleCellNumbers();
					});
				});
			},200);
		};
}
