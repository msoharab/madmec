var loader="#loader";
// Dashboard Home Page
function load_dashboard(){
	var outdiv='';
	this.__construct = function(mainPage){
		outdiv=mainPage.suboutdiv;
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url:mainPage.url,
			type:'POST',
			data:{autoloader:'true',action:'load_dashboard',type:'master'},
			success: function(data){
			data = $.parseJSON(data);
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$(outdiv).html(data.htm);
						$(loader).hide();						
					break;
				}
			}
		});
	}
	this.selectGYM = function(gymdata){
		$(gymdata.nav).each(function(){
			$(this).click(function(evt){
				var id=$(this).attr('id');
				setGym(id);
			});
		});
		function setGym(id){
			$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
			$.ajax({
			url:window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'setGYM',type:'master',id:id},
			success:function(data){
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$(DGYM_ID).attr('name',id);
						$(DGYM_ID).html(data);				
					break;
				}
			}
		});
		}
	}
}
// Single Dashboard 
function loadSingleDash(){
	var ds='';
	var gymid = $(DGYM_ID).attr( "name" );
	this.__construct = function(dash){
		ds=dash;
		loadSinglePageDash();
	}
	function loadSinglePageDash(){
		$(ds.nm).html('<i class="fa fa-spinner fa-x fa-spin">');
		$.ajax({
			url:ds.url,
			type:'POST',
			data:{autoloader:'true',action:'loadSingleDash',type:'slave',gymid:gymid},
			success: function(data){
			data = $.parseJSON(data);
				switch(data){
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
			}
		});
	}
}
//Profile Page
function controlProfile(){
	var pf={};
	var add={};
	var em={};
	var cn={};
	var dccode = '91';
	var dpcode = '080';
	this.__construct = function(profile){
		pf=profile;
		add=profile.addgym;
		em=profile.addgym.em;
		cn=profile.addgym.cn;
		
	$(add.but).click(function(){
		gymAdd(); 
	});
	load_admin_details();
	LoadGymDetails();
	initializeProfileAddForm();
	};
	this.editProfileEmailIds = function(email){
			var em = email;
			var min = em.num;
			//console.log(min);
			$('#'+em.saveBut).hide();
			$(em.but).bind('click', function() {
				$('#'+em.saveBut).show();
				$(em.but).hide();
				em.num = min;		
				profileEmailIdForm();
			});
			function profileEmailIdForm(){
				em.num = min;
				$(em.parentDiv).html('<i class="fa fa-spinner fa-3x fa-spin"></i>');
				//console.log(em);
				$.ajax({
					url:em.url,
					type:'POST',
					data:{autoloader:true,action:'profileEmailIdForm',type:'master',det:em},
					success: function(data, textStatus, xhr){
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
									$('#'+em.saveBut).bind('click', function() {
										editProfileEmailId();
									});
									$('#'+em.closeBut).bind('click', function() {
										$(em.but).show();
										$('#'+em.saveBut).hide();
										listProfileEmailIds();
									});
									window.setTimeout(function(){
										if(data.oldemail){
											for(i=0;i<data.oldemail.length;i++){
												 //console.log(data.oldemail[i].deleteOk);
												 //console.log(data.oldemail[i].id);
												var id = Number(data.oldemail[i].id);
												$('#'+data.oldemail[i].deleteOk).bind('click',{param1:id},function(event){
													//console.log(event.data.param1);
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
						//console.log(xhr.status);
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
					//console.log("insert data="+emailids.insert);
					$('#'+em.saveBut).unbind();
					$.ajax({
						url:em.url,
						type:'POST',
						data:{autoloader:true,action:'editProfileEmailId',type:'master',emailids:emailids},
						success: function(data, textStatus, xhr){
							flag = false;
							data = $.parseJSON($.trim(data));
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								default:
									min++;
									$(em.but).show();
									$('#'+em.saveBut).hide();
									listProfileEmailIds();
								break;
							}
						},
						error: function(xhr, textStatus){
							$(em.outputDiv).html(INET_ERROR);
						},
						complete: function(xhr, textStatus) {
							//console.log(xhr.status);
						}
					});
				
				}
			};
			function addMultipleProfileEmailIds(){
				//console.log(em.num);
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
				//console.log(id);
				var flag = false;
				$.ajax({
					url:em.url,
					type:'POST',
					async:false,
					data:{autoloader: true,action:'deleteProfileEmailId',type:'master',eid:id},
					success:function(data, textStatus, xhr){
						//console.log(data);
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
						//console.log(xhr.status);
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
					data:{autoloader: true,action:'listProfileEmailIds',type:'master',para:para},
					success:function(data, textStatus, xhr){
						// //console.log(data);
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
						//console.log(xhr.status);
					}
				});
				return flag;
			};
		};
	this.editProfileCellNumbers = function(cellno){
			var cn = cellno;
			var min = cn.num;
			//console.log(cn.num);
			$('#'+cn.saveBut).hide();
			$(cn.but).click(function(){
				$('#'+cn.saveBut).show();
				$(cn.but).hide();
				cn.num = min;
				loadProfileCellNumForm();
			});
			function loadProfileCellNumForm(){
				cn.num = min;
				//console.log(cn.num);
				$(cn.parentDiv).html('<i class="fa fa-spinner fa-3x fa-spin"></i>');
				$.ajax({
					url:cn.url,
					type:'POST',
					data:{autoloader:true,action:'loadProfileCellNumForm',type:'master',det:cn},
					success: function(data, textStatus, xhr){
						//console.log(data);
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
												 //console.log(data.oldcnums[i].deleteOk);
												 //console.log(data.oldcnums[i].id);
												var id = Number(data.oldcnums[i].id);
												$('#'+data.oldcnums[i].deleteOk).bind('click',{param1:id},function(event){
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
						//console.log(xhr.status);
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
				// min
				/* Cell numbers */
				if(cn.num > -1){
					j=0;
					k=0;
					for(i=0;i<=cn.num;i++){
						// //console.log($(document.getElementById(cn.cnumber+i)).val());
						// //console.log(cn.cnumber+i);
						var ems = $(document.getElementById(cn.cnumber+i)).val();
						var id = $(document.getElementById(cn.cnumber+i)).prop('name');
						//console.log(id);
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
					//console.log(CellNums.insert);
					$('#'+cn.saveBut).unbind();
					$.ajax({
						url:cn.url,
						type:'POST',
						data:{autoloader:true,action:'editProfileCellNum',type:'master',CellNums:CellNums},
						success: function(data, textStatus, xhr){
							var CellNums = {
								insert 		: '',
								update 		: '',
								uid 		: '',
								index 		: '',
								listindex 	: ''
							};
							//console.log(data);
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
							//console.log(xhr.status);
							//cn.num++;
						}
					});
				}
			};
			function addMultipleProfileCellNums(){
				// //console.log(cn.num);
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
				//console.log(oldcnum);
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
				// //console.log(cn.num);
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
					data:{autoloader: true,action:'listProfileCellNums',type:'master',para:para},
					success:function(data, textStatus, xhr){
						// //console.log(data);
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
						//console.log(xhr.status);
					}
				});
				return flag;
			};
			function deleteProfileCellNum(id){
				//console.log(id);
				var flag = false;
				$.ajax({
					url:cn.url,
					type:'POST',
					async:false,
					data:{autoloader: true,action:'deleteProfileCellNum',type:'master',eid:id},
					success:function(data, textStatus, xhr){
						// //console.log(data);
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
						//console.log(xhr.status);
					}
				});
				return flag;
			};
		};
	this.editChangePassword = function(password){
			var pwd	=	password;
			$(pwd.saveBut).hide();
			$(pwd.canBut).hide();
			$(pwd.but).click(function(){
				$(pwd.saveBut).show();
				$(pwd.canBut).show();
				$(pwd.but).hide();
				$(pwd.saveBut).click(function(){
					editChangePwd();	
				});

				
			});
			function editChangePwd(){
				//console.log("im here to change pwd");
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
						//console.log(data);
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
									/*window.setTimeout(function(){
										logoutAdmin({});
									},5000);*/
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
						//console.log(xhr.status);
					}
				});
			};
		};
	this.editGYMAddress = function(addr){
			var address = addr;
			var addres;
			var PCR_reg = '';
			var countries = {};
			var states = {};
			var districts = {};
			var cities = {};
			var localities = {};
			$(address.pfbut).click(function(){
				$(address.pfshowDiv).toggle();
				$(address.pfupdateDiv).toggle();
				if($(address.pfupdateDiv).css('display') == 'block'){
					addres = new Address();
					addres.__construct({url : address.pfurl,outputDiv:address.pfoutputDiv});
					//addres.getIPData({});
					// addres.fillAddressFields(address);
					countries = addres.getCountry();
					attachAddressFields();
				}
			});
			$(address.pfsaveBut).click(function(){
				editAddress();
			});
			$(address.pfcloseBut).click(function(){
				listAddress();
			});
			function attachAddressFields(){
				var list = countries;
				$(address.pfcountry).autocomplete({
					minLength: 2,
					source:list,
					autoFocus: true,
					select: function( event, ui ) {
						window.setTimeout(function(){
							$(address.pfcountry).val(ui.item.label);
							$(address.pfcountry).attr('name',ui.item.value);
							address.pfcountryCode = ui.item.countryCode;
							address.pfPCR_reg = ui.item.PCR;
							addres.setCountry(ui.item);
							$(address.pfprovince).val('');
							$(address.pfprovince).focus();
						},50);
						$(address.pfprovince).focus(function(){
							states = addres.getState();
							var list = states;
							$(address.pfprovince).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.pfprovince).val(ui.item.label);
										$(address.pfprovince).attr('name',ui.item.value);
										address.pfprovinceCode = ui.item.provinceCode;
										address.pflat = ui.item.lat;
										address.pflon = ui.item.lon;
										address.pftimezone = ui.item.timezone;
										addres.setState(ui.item);
										$(address.pfdistrict).val('');
										$(address.pfdistrict).focus();
									},50);
								}
							});
						});
						$(address.pfdistrict).focus(function(){
							districts = addres.getDistrict();
							var list = districts;
							$(address.pfdistrict).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.pfdistrict).val(ui.item.label);
										$(address.pfdistrict).attr('name',ui.item.value);
										address.pfdistrictCode = ui.item.districtCode;
										address.pflat = ui.item.lat;
										address.pflon = ui.item.lon;
										address.pftimezone = ui.item.timezone;
										addres.setDistrict(ui.item);
										$(address.pfcity_town).val('');
										$(address.pfcity_town).focus();
									},50);
								}
							});
						});
						$(address.pfcity_town).focus(function(){
							cities = addres.getCity();
							var list = cities;
							$(address.pfcity_town).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.pfcity_town).val(ui.item.label);
										$(address.pfcity_town).attr('name',ui.item.value);
										address.pfcity_townCode = ui.item.city_townCode;
										address.pflat = ui.item.lat;
										address.pflon = ui.item.lon;
										address.pftimezone = ui.item.timezone;
										addres.setCity(ui.item);
										$(address.pfst_loc).val('');
										$(address.pfst_loc).focus();
									},50);
								}
							});
						});
						$(address.pfst_loc).focus(function(){
							localities = addres.getLocality();
							var list = localities;
							$(address.pfst_loc).autocomplete({
								minLength: 2,
								source:list,
								autoFocus: true,
								select: function( event, ui ) {
									window.setTimeout(function(){
										$(address.pfst_loc).val(ui.item.label);
										$(address.pfst_loc).attr('name',ui.item.value);
										address.pfst_locCode = ui.item.st_locCode;
										address.pflat = ui.item.lat;
										address.pflon = ui.item.lon;
										address.pftimezone = ui.item.timezone;
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
				if($(address.pfcountry).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.pfcomsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.pfcomsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.pfcomsg).offset().top)-95}, "slow");
					$(address.pfcountry).focus();
					return;
				}
				/* Province */
				if($(address.pfprovince).val().match(prov_reg)){
					flag = true;
					$(address.pfprmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.pfprmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.pfprmsg).offset().top)-95}, "slow");
					$(address.pfprovince).focus();
					return;
				}
				/* District */
				if($(address.pfdistrict).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.pfdimsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.pfdimsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.pfdimsg).offset().top)-95}, "slow");
					$(address.pfdistrict).focus();
					return;
				}
				/* City */
				if($(address.pfcity_town).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.pfcitmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.pfcitmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.pfcitmsg).offset().top)-95}, "slow");
					$(address.pfcity_town).focus();
					return;
				}
				/* Street / Locality */
				if($(address.pfst_loc).val().match(st_city_dist_cont_reg)){
					flag = true;
					$(address.pfstlmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.pfstlmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.pfstlmsg).offset().top)-95}, "slow");
					$(address.pfst_loc).focus();
					return;
				}
				/* Address Line */
				if($(address.pfaddrs).val().match(addline_reg)){
					flag = true;
					$(address.pfadmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(address.pfadmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(address.pfadmsg).offset().top)-95}, "slow");
					$(address.pfaddrs).focus();
					return;
				}
				var attr = {
					uid 		: address.pfuid,
					gymid		: $(address.pfgymid).val(),
					index 		: address.pfindex,
					listindex 	: address.pflistindex,
					country		: $(address.pfcountry).val(),
					countryCode	: address.pfcountryCode,
					province	: $(address.pfprovince).val(),
					provinceCode: address.pfprovinceCode,
					district	: $(address.pfdistrict).val(),
					city_town	: $(address.pfcity_town).val(),
					st_loc		: $(address.pfst_loc).val(),
					addrsline	: $(address.pfaddrs).val(),
					zipcode		: $(address.pfzipcode).val(),
					website		: $(address.pfwebsite).val(),
					gmaphtml	: $(address.pfgmaphtml).val(),
					timezone	: address.pftimezone,
					lat			: address.pflat,
					lon			: address.pflon
				};
				if(flag){
					$.ajax({
						url:address.pfUpdateurl,
						type:'POST',
						data:{autoloader:true,action:'editProfileAddress',type:'master',address:attr},
						success: function(data, textStatus, xhr){
							// //console.log(data);
							data = $.parseJSON($.trim(data));
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								default:
									$(address.pfcloseBut).trigger('click');
								break;
							}
						},
						error: function(xhr, textStatus){
							$(address.pfoutputDiv).html(INET_ERROR);
						},
						complete: function(xhr, textStatus) {
							//console.log(xhr.status);
						}
					});
				}
			};
			function listAddress(){
				var para = {
					uid 		: address.pfuid,
					index 		: address.pfindex,
					listindex 	: address.pflistindex,
					gymid		: $(address.pfgymid).val(),
				};
				var flag = false;
				$.ajax({
					url:window.location.href,
					type:'POST',
					data:{autoloader: true,action:'listProfileAddress',type:'master',para:para},
					success:function(data, textStatus, xhr){
						// //console.log(data);
						data = $.trim(data);
						switch(data){
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
					error: function(xhr, textStatus){
						$(address.pfoutputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						//console.log(xhr.status);
					}
				});
				return flag;
			};
		
		};
	//first load admin profile
	function load_admin_details(){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: pf.url,
			type:'POST',
			data:{autoloader:'true',action:'load_admin_details',type:'master'},
			success: function(data){
				data = $.parseJSON(data);
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$(pf.pfoutDiv).html(data.htm);
						$(loader).hide();
						$(".picedit_box").picEdit({
							imageUpdated: function(img){
							},
							formSubmitted: function(data){
								window.setTimeout(function(){
									$('#myModal_pf').modal('toggle');
									load_admin_details();
								},500);
							},
							redirectUrl: false,
							defaultImage: URL+ASSET_IMG+'No_image.png',
						});		
					break;
				}
			},
			error:function(){
				alert("there was an error");
			}
		});	
	}
	// load gym details master
	function LoadGymDetails(){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		var id = $(DGYM_ID).attr( "name" );
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'load_gym_details',type:'master',id:id},
			success: function(data){
				data = $.parseJSON(data);
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$(pf.gymoutDiv).html(data.htm);
						$(loader).hide();
						$(".picedit_box").picEdit({
							imageUpdated: function(img){
							},
							formSubmitted: function(data){
								window.setTimeout(function(){
									$('#myModal_Photo').modal('toggle');
									LoadGymDetails();
								},500);
							},
							redirectUrl: false,
							defaultImage: URL+ASSET_IMG+'No_image.png',
						});
				
					break;
				}
			},
			error:function(){
				alert("there was an error");
			}
		});	
	}
	//gym branch New Adding
	function gymAdd(){
			var attr = validateUserFields();
			if(attr){
				$(add.but).prop('disabled','disabled');
				$(pf.msgDiv).html('');
				$.ajax({
					url:pf.url,
					type:'POST',
					data:{autoloader: true,action: 'gymAdd',type:'master',gymadd:attr},
					success:function(data, textStatus, xhr){
						//console.log(data);
						data = $.trim(data);
						//console.log(xhr.status);
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
							break;
						}
					},
					error:function(){
						$(usr.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						//console.log(xhr.status);
						$(add.but).removeAttr('disabled');
					}
				});
			}
			else{
				$(add.but).removeAttr('disabled');
			}
	};
	function validateUserFields(){
			var flag = false;
			var email = [];
			var cellnumbers = [];

			/* User name */
		/*	if($(add.name).val().match(name_reg)){
				flag = true;
				$(add.nmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(add.nmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(add.nmsg).offset().top)-95}, "slow");
				$(add.name).focus();
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
				name		: $(add.name).val(),
				acs			: $(add.acs_id).val(),
				email		: email,
				cellnumbers	: cellnumbers,
				fee			: $(add.fee).val(),
				tax			: $(add.tax).val(),
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
	// gym branch Add
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
	// gym branch email
	function bulitMultipleEmailIds(){
			if(em.num == -1)
				$(em.parentDiv).html('');
			em.num++;
			var html = '<div id="'+em.form+em.num+'">'+
				'<div class="col-lg-8">'+
					'<input class="form-control" placeholder="Email ID" name="email" type="text" id="'+em.email+em.num+'" maxlength="100"/>'+
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
		// gym branch cell number
	function bulitMultipleCellNumbers(){
			if(cn.num == -1)
				$(cn.parentDiv).html('');
			cn.num++;
			var html = '<div class="row show-grid" id="'+cn.form+cn.num+'">'+
						'<div class="col-xs-6 col-md-4">'+
							'<input class="form-control" value="'+dccode+'" name="ccode" type="text" id="'+cn.codep+cn.num+'" maxlength="15" />'+
						'</div>'+
						'<div class="col-xs-6 col-md-4">'+
							'<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="'+cn.nump+cn.num+'" maxlength="20" />'+
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
//Enquiry Add
function controlEnquiry(){
	var enq={};
	var ead={};
	var em={};
	var cn={};
	var dccode = '91';
	var dpcode = '080';
	var gymid = $(DGYM_ID).attr( "name" );
	this.__construct = function(enquiry){
		enq=enquiry;
		ead=enquiry.add;
		em=enquiry.em;
		cn=enquiry.cn;
	$("#"+ead.f1).datepicker({
		dateFormat: 'yy-mm-dd',
		yearRange:'2014:'+Number(new Date().getFullYear())+2,
	});
	$("#"+ead.f2).datepicker({
		dateFormat: 'yy-mm-dd',
		yearRange:'2014:'+Number(new Date().getFullYear())+2,
	});
	$("#"+ead.f3).datepicker({
		dateFormat: 'yy-mm-dd',
		yearRange:'2014:'+Number(new Date().getFullYear())+2,
	});
	$("#"+ead.but).bind("click",function(){
		enquiryAdd();
	});
	fetchKnowAboutUS();
	fetchInterestedIn();
	addEnqAutoComplete();
	};
	function fetchKnowAboutUS(){
			var rad = '';
			$.ajax({
				type:'POST',
				url:window.location.href,
				data:{autoloader:true,action:'fetchKnowAboutUS',type:'slave',gymid:gymid},
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
							var type = $.parseJSON(data);
							listofvaliditytypes = type;
							for(i=0;i<type.length;i++){
								rad += type[i]["html"];
							}
							$("#"+ead.knwabt).html('<option value="NULL" selected>Select know about us</option>'+rad);
							
						break;
					}
				},
				error:function(){
					$(payms.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
				}
			});
		};
	function fetchInterestedIn(){
			var rad = '';
			$.ajax({
				type:'POST',
				url:window.location.href,
				data:{autoloader:true,action:'fetchInterestedIn',type:'slave',gymid:gymid},
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
							var type = $.parseJSON(data);
							listofvaliditytypes = type;
							for(i=0;i<type.length;i++){
								rad += '<option  value="'+type[i]["id"]+'">'+type[i]["html"]+'</option>';
							}
							$("#"+ead.instin).html('<option value="NULL" selected>Select facility</option>'+rad);
						break;
					}
				},
				error:function(){
					$(loader).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
				}
			});
		};
	function addEnqAutoComplete(){
		$.ajax({
			url:enq.url,
			type:'POST',
			data:{autoloader: true,action: 'autoCompleteEnq',type:'slave',gymid:gymid},
			success:function(data, textStatus, xhr){
				data = $.parseJSON(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					
					default:
					listofPeoples=data.listofPeoples;
					$referred=$("#"+ead.refer);
					$referred.autocomplete({
						minLength: 0,
						source: listofPeoples,
						focus: function( event, ui ) {
						  $referred.val( ui.item.label );
						  return false;
						},
						 select: function( event, ui ) {
							 $referred.val(ui.item.label);
							 $referred.attr('name', ui.item.id);
							return false;
						   },
					});
					$referred.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
						var $li = $('<li>'),
							$img = $('<img>');
						$img.attr({
						  src: item.icon,
						  alt: item.label,
						  width:"30px",
						  height:"30px"
						});

						$li.attr('data-value', item.label);
						$li.append('<a href="#">');
						$li.find('a').append($img).append(item.label);    

						return $li.appendTo(ul);
					};
					
					$handel=$("#"+ead.handel);
					$handel.autocomplete({
						minLength: 0,
						source: listofPeoples,
						focus: function( event, ui ) {
						  $handel.val( ui.item.label );
						  return false;
						},
						 select: function( event, ui ) {
							 $handel.val(ui.item.label);
							 $handel.attr('name', ui.item.id);
							return false;
						   },
					});
					$handel.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
						var $li = $('<li>'),
							$img = $('<img>');
						$img.attr({
						  src: item.icon,
						  alt: item.label,
						  width:"30px",
						  height:"30px"
						});

						$li.attr('data-value', item.label);
						$li.append('<a href="#">');
						$li.find('a').append($img).append(item.label);    

						return $li.appendTo(ul);
					};
					
													 
					
					break;
				}
			},
			error:function(){
				$(usr.outputDiv).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
	function enquiryAdd(){
			var attr = validateEnqFields();
			if(attr){
				$("#"+ead.but).prop('disabled','disabled');
				$(loader).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
				$.ajax({
					url:enq.url,
					type:'POST',
					data:{autoloader: true,action:'enqAdd',type:'slave',gymid:gymid,eadd:attr},
					success:function(data, textStatus, xhr){
						data = $.trim(data);
						//console.log(data);
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							case 'login':
								loginAdmin({});
							break;
							default:
								$(loader).hide();
								$("#"+ead.msg).html('<h2>Record success fully added</h2>');
								$("#"+ead.form).get(0).reset();
							break;
						}
					},
					error:function(){
						$("#"+ead.msg).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						//console.log(xhr.status);
						window.setTimeout(function(){
							$("#"+ead.msg).html('');
						},2000);
						$("#"+ead.but).removeAttr('disabled');
					}
				});
			}
			else{
				$("#"+ead.but).removeAttr('disabled');
			}
	};
	function validateEnqFields(){
			var flag = false;
			var email = [];
			var cellnumbers = [];
			var intin = $("#"+ead.instin).val() || [];
			
			 // visitor name
			if($("#"+ead.vname).val().match(name_reg)){
				flag = true;
				$("#"+ead.vnmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$("#"+ead.vnmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($("#"+ead.vnmsg).offset().top)-95}, "slow");
				$("#"+ead.vname).focus();
				return;
			}
			//email
			if($("#"+ead.email).val().match(email_reg)){
				flag = true;
				$("#"+ead.emsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$("#"+ead.emsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($("#"+ead.emsg).offset().top)-95}, "slow");
				$("#"+ead.email).focus();
				return;
			}
			
			//cell number cell	cmsg
			if($("#"+ead.cell).val().match(cell_reg)){
				flag = true;
				$("#"+ead.cmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$("#"+ead.cmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($("#"+ead.cmsg).offset().top)-95}, "slow");
				$("#"+ead.cell).focus();
				return;
			}
			var attr = {
				referpk		: $("#"+ead.refer).attr('name'),
				handelpk	: $("#"+ead.handel).attr('name'),
				vname		: $("#"+ead.vname).val(),
				email		: $("#"+ead.email).val(),
				cell		: $("#"+ead.cell).val(),
				f1			: $("#"+ead.f1).val(),
				f2			: $("#"+ead.f2).val(),
				f3			: $("#"+ead.f3).val(),
				knwabt		: $("#"+ead.knwabt).val(),
				instin		: intin,
				jop			: $("#"+ead.jop).val(),
				fgoal		: $("#"+ead.fgoal).val(),
				cmt			: $("#"+ead.cmt).val(),
			};
			if(flag){
				return attr;
			}
			else
				return false;
	};
}
//ENQ Follow ups
function controlEnquiryFollow(){
	enq = {};
	tf = {};
	pf = {};
	exf = {};
	var gymid = $(DGYM_ID).attr( "name" );
	this.__construct = function(enquiry){
		enq = enquiry;
		tf  = enquiry.tflw;
		pf  = enquiry.pflw;
		exf = enquiry.exflw;
				
		$("#"+tf.tab).click(function(){
			DisplayEnquiryToday();
		});
		$("#"+pf.tab).click(function(){
			DisplayEnquiryTodayPending();
		});
		$("#"+exf.tab).click(function(){
			DisplayEnquiryTodayExpired();
		});
		DisplayEnquiryToday();
	};
	function DisplayEnquiryToday(){
		$(enq.output).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: enq.url,
			type:'POST',
			data:{autoloader:'true',action:'DisplayEnquiryAll',type:'slave',gymid:gymid,list_type:'today'},
			success: function(data){
				data = $.parseJSON(data);
				console.dir(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(enq.output).html(data.htm);
						$(loader).hide();
					break;
				}
			}
		});
		$(window).scroll(function(event){
			if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10){
				UpdateListEnquiry();
			}else{
				$(loader).html('');
			}
		});
	}
	function DisplayEnquiryTodayPending(){
		$(enq.output).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: enq.url,
			type:'POST',
			data:{autoloader:'true',action:'DisplayEnquiryAll',type:'slave',gymid:gymid,list_type:'pending'},
			success: function(data){
				data = $.parseJSON(data);
				console.dir(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(enq.output).html(data.htm);
						$(loader).hide();
					break;
				}
			}
		});
		$(window).scroll(function(event){
			if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10){
				UpdateListEnquiry();
			}else{
				$(loader).html('');
			}
		});
	}
	function DisplayEnquiryTodayExpired(){
		$(enq.output).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: enq.url,
			type:'POST',
			data:{autoloader:'true',action:'DisplayEnquiryAll',type:'slave',gymid:gymid,list_type:'expired'},
			success: function(data){
				data = $.parseJSON(data);
				console.dir(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(enq.output).html(data.htm);
						$(loader).hide();
					break;
				}
			}
		});
		$(window).scroll(function(event){
			if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10){
				UpdateListEnquiry();
			}else{
				$(loader).html('');
			}
		});
	}
	function UpdateListEnquiry(){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: enq.url,
			type:'POST',
			data:{autoloader:'true',action:'UpdateListEnquiry',type:'slave',gymid:gymid},
			success: function(data){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(enq.output).append(data);
						$(loader).hide();
					break;
				}
			}
		});
	}
}
//ENQ List All
function controlEnquiryListAll(){
	var enq={};
	var list={};
	var menuDiv = "";
	var htmlDiv = "";
	var outputDiv = "";
	var OptionsSearch = new Object();
	var SearchAllHide = new Object();
	var gymid = $(DGYM_ID).attr( "name" );
	//console.log(gymid);
	this.__construct = function(enquiry){
		enq=enquiry;
		list=enquiry.list;
		menuDiv = list.menuDiv;
		htmlDiv = list.htmlDiv;
		outputDiv = list.outputDiv;
		OptionsSearch = list.OptionsSearch;
		SearchAllHide = list.SearchAllHide;
		DisplayEnquiry();
	};
	this.delete_enqiry = function (del){
		id=del.id;
		index=del.index;
		$(enq.loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: enq.url,
			type:'POST',
			data:{autoloader:'true',action:'deleteEnquiry',type:'slave',gymid:gymid,'id':id},
			async:false,
			success: function(data){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(del.delenq).html(data);
						var num = Number($(del.numenq).text());
						if(num > 0){
							num -= 1;
							$(del.numenq).text(num);
						}
						if(num == 0)
							$('#accordion_'+index).remove();
						//console.log(num);
						
						$(del.delenq).hide(500);
						window.setTimeout(function(){
							$(del.enqrow).remove();
							DisplayEnquiry();
						},200);
					break;
				}
			}
		});
	};
	this.update_follow_up = function (ufollow){
		id = ufollow.id;
		var flw = {
				id 		: 	ufollow.id,
				com 	: 	$(ufollow.cmt).val(),
				body	:	ufollow.bfollow,
				btn		:	ufollow.btn,
		}
		if(flw.com.length){
			$(flw.dt).css({display:'block'});
			$.ajax({
				url: window.location.href,
				type:'POST',
				data:{autoloader:'true',action:'UpdateFollowUp',type:'slave',gymid:gymid,follow:flw},
				success: function(data){
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							if(!data)
								$(flw.body).html('Can\'t updated follow up.');
							else
								$(flw.body).html('Follow up updated successfully.');
							$(flw.btn).trigger('click');
							$(flw.dt).css({display:'none'});
						break;
					}
				}
			});
		}
		else
			alert('Type the result of follow up !!!');
	}
	this.update_final_status = function (fstats){
		var stats = {
				id 		: 	fstats.id,
				com 	: 	$(fstats.cmt).val(),
				body	:	fstats.body,
				sbtn	:	fstats.sbtn,
				fldr	:	fstats.floader,
		}
		if(stats.com.length){
			$(stats.fldr).css({display:'block'});
			$.ajax({
				url: window.location.href,
				type:'POST',
				data:{autoloader:'true',action:'UpdateFinalStatus',type:'slave',gymid:gymid,stats:stats},
				success: function(data){
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							if(!data)
								$(stats.body).html('Can\'t updated follow up.');
							else
								$(stats.body).html('Final status updated successfully.');
							$(stats.sbtn).trigger('click');
							$(stats.fldr).css({display:'none'});
						break;
					}
				}
			});
		}
		else
			alert('Type the result of your effort finally what happened !!!');
	}
	function DisplayEnquiry(){
		$(list.output).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: enq.url,
			type:'POST',
			data:{autoloader:'true',action:'DisplayEnquiryAll',type:'slave',gymid:gymid,list_type:'all'},
			success: function(data){
				data = $.parseJSON(data);
				console.dir(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(list.output).html(data.htm);
						$(enq.loader).hide();
						$("#output_load").html('');
						InstallSerachHtml();
					break;
				}
			}
		});
		$(window).scroll(function(event){
			if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10){
				UpdateListEnquiry();
			}else{
				$(enq.loader).html('');
			}
		});
	}
	function UpdateListEnquiry(){
		$(enq.loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			url: enq.url,
			type:'POST',
			data:{autoloader:'true',action:'UpdateListEnquiry',type:'slave',gymid:gymid},
			success: function(data){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(list.output).append(data);
						$(enq.loader).hide();
					break;
				}
			}
		});
	}
	//search functions
	function InstallSerachHtml(){
		$.ajax({
			url:enq.url,
			type:'post',
			datatype:'JSON',
			async: false,
			data:{autoloader:'true',action:'LoadSearchHTML',type:'slave',gymid:gymid,ser:OptionsSearch},
			success:function(data){
				data = $.parseJSON(data);
				
				$(menuDiv).html(data.menuDiv);
				$(htmlDiv).html(data.htmlDiv);
				window.setTimeout(function(){
					$( "#follow_up,#enq_day,#follow_up_all,#enq_day_all,#jnd,#exd,#jnd_all,#exd_all" ).datepicker({
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
						yearRange:'2014:'+Number(new Date().getFullYear())+2,
					});
					$(".srch_type").each(function(){
						var txt = $(this).text();
						if(txt === 'Hide'){
							$(this).bind('click',function(){
								$(".ser_crit").each(function(){
									$(this).hide();
								});
							});
						}
						else{
							$(this).bind('click',function(){
								ShowSearchType(txt+'_ser');
							});
						}
					});
					$("#Enquiry_ser_but").bind('click',function(){
						searchEnqList();
					});
					$("#Group_ser_but").bind('click',function(){
						searchGroup();
					});
					$("#Personal_ser_but").bind('click',function(){
						searchPerUser();
					});
					$("#Offer_ser_but").bind('click',function(){
						searchOffUser();
					});
					$("#package_ser_but").bind('click',function(){
						searchPackUser();
					});
					$("#Date_ser_but").bind('click',function(){
						searchDateUser();
					});
					$("#All_ser_but").bind('click',function(){
						searchAllUser();
					});
					$.each(SearchAllHide, function(key,value) {
						(value) ?  $("#"+key).remove() : false;
					});
				},1500);
			}
		});
	};
	function ShowSearchType(id){
		$('.ser_crit').each(function(){
			if($(this).attr('id') == id)
				$(this).show();
			else
				$(this).hide();
		});
	};
	function searchEnqList(){
		var cust_email = ($('#cust_email').val().length) ? $('#cust_email').val() : "";
		var cust_name = ($('#cust_name').val().length) ? $('#cust_name').val() : "";
		var cust_no = ($('#cust_no').val().length) ? $('#cust_no').val() : "";
		var enq_day = ($('#enq_day').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#enq_day').val() : "";
		var follow_up = ($('#follow_up').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#follow_up').val() : "";
		if(cust_email.length > 0 || cust_name.length > 0 || cust_no.length > 0 || enq_day.length > 0 || follow_up.length > 0 ){
			var spara = {
				cust_email	:	cust_email,
				cust_name	:	cust_name,
				cust_no		:	cust_no,
				enq_day		:	enq_day,
				follow_up	:	follow_up
				
			};
			$(enq.loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
			$.ajax({
				url: enq.url,
				type:'POST',
				data:{autoloader:'true',action:'search_enq_list',type:'slave',gymid:gymid,spara:spara},
				success: function(data){
					data = $.parseJSON(data);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							$(list.output).html(data.htm);
							$(enq.loader).hide();
						break;
					}
				}
			});
		}
	};
	function searchGroup(){
		var group_name = ($('#group_name').val() == "") ? "" : $('#group_name').val();
		var owner = ($('#owner').val() == "") ? "" : $('#owner').val();
		var min_mem = ($('#min_mem').val() == "") ? "" : $('#min_mem').val();
		if(group_name.length > 0 || owner.length > 0 || min_mem > 1){
			$(outputDiv).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				  url:window.location.href,
				  type:'post',
				  data:{autoloader:'true',action:'searchGroup',type:'slave',gymid:gymid,group_name:group_name,owner:owner,min_mem:min_mem}
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
					$(outputDiv).html(data);
			});
		}
	};	
	function searchPerUser(){
		var user_name = ($('#user_name').val() == "") ? "" : $('#user_name').val();
		var user_mobile = ($('#user_mobile').val() == "") ? "" : $('#user_mobile').val();
		var user_email = ($('#user_email').val() == "") ? "" : $('#user_email').val();
		if(user_name.length > 1 || user_mobile.length > 1 || user_email.length > 1){
			$(outputDiv).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				  url:window.location.href,
				  type:'post',
				  data:{autoloader:'true',action:'searchPerUser',type:'slave',gymid:gymid,user_name:user_name,user_mobile:user_mobile,user_email:user_email}
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
					$(outputDiv).html(data);
			});
		}
	};
	function searchOffUser(){
		var offer_opt = ($('#offer_opt').select().val() == "NULL") ? "" : $('#offer_opt').select().val();
		var fct_opt = ($('#fct_opt').select().val() == "NULL") ? "" : $('#fct_opt').select().val();
		var offer_dur = ($('#offer_dur').select().val() == "NULL") ? "" : $('#offer_dur').select().val();
		var offer_min_mem = ($('#offer_min_mem').select().val() == "NULL") ? "" : $('#offer_min_mem').select().val();
		if(offer_opt.length > 0 || fct_opt.length > 0 || offer_dur.length > 0 || offer_min_mem.length > 0){
			$(outputDiv).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				  url:window.location.href,
				  type:'post',
				  data:{autoloader:'true',action:'searchOffUser',type:'slave',gymid:gymid,offer_opt:offer_opt,fct_opt:fct_opt,offer_dur:offer_dur,offer_min_mem:offer_min_mem}
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
					$(outputDiv).html(data);
			});
		}
	};
	function searchPackUser(){
		var pack_opt = ($('#pack_opt').select().val() == "NULL") ? "" : $('#pack_opt').select().val();
		var pack_ses_opt = ($('#pack_ses_opt').select().val() == "NULL") ? "" : $('#pack_ses_opt').select().val();
		if(pack_opt.length > 0 || pack_ses_opt.length > 0){
			$(outputDiv).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				  url:window.location.href,
				  type:'post',
				  data:{autoloader:'true',action:'searchPackUser',type:'slave',gymid:gymid,pack_opt:pack_opt,pack_ses_opt:pack_ses_opt}
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
					$(outputDiv).html(data);
			});
		}
	};
	function searchDateUser(){
		var jnd = ($('#jnd').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#jnd').val() : "";
		var exd = ($('#exd').val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $('#exd').val() : "";
		if(jnd.length > 1 || exd.length > 1){
			$(outputDiv).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				  url:window.location.href,
				  type:'post',
				  data:{autoloader:'true',action:'searchDateUser',type:'slave',gymid:gymid,jnd:jnd,exd:exd}
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
					$(outputDiv).html(data);
			});
		}
	};
	function searchAllUser(){
		var fields = {
			autoloader		:'true',
			action			:'searchAllUser',
			enq_ser_fup 	: $('#enq_ser_fup_all').val() ? $('#enq_ser_fup_all').val() : "",
			enq_ser_date 	: $('#enq_ser_date_all').val() ? $('#enq_ser_date_all').val() : "",
			enq_ser_nam_mob : $('#enq_ser_nam_mob_all').val() ? $('#enq_ser_nam_mob_all').val() : "",
			group_name 		: $('#group_name_all').val() ? $('#group_name_all').val() : "",
			owner 			: $('#owner_all').val() ? $('#owner_all').val() : "",
			min_mem 		: $('#min_mem_all').val() ? $('#min_mem_all').val() : "",
			user_name 		: $('#user_name_all').val() ? $('#user_name_all').val() : "",
			user_mobile 	: $('#user_mobile_all').val() ? $('#user_mobile_all').val() : "",
			user_email 		: $('#user_email_all').val() ? $('#user_email_all').val() : "",
			offer_opt 		: ($('#offer_opt_all').select().val() != "NULL") ? $('#offer_opt_all').select().val() : "",
			fct_opt 		: ($('#fct_opt_all').select().val() != "NULL") ? $('#fct_opt_all').select().val() : "",
			offer_dur 		: ($('#offer_dur_all').select().val() != "NULL") ? $('#offer_dur_all').select().val() : "",
			offer_min_mem 	: ($('#offer_min_mem_all').select().val() != "NULL") ? $('#offer_min_mem_all').select().val() : "",
			pack_opt 		: ($('#pack_opt_all').select().val() != "NULL") ? $('#pack_opt_all').select().val() : "",
			pack_ses_opt 	: ($('#pack_ses_opt_all').select().val() != "NULL") ? $('#pack_ses_opt_all').select().val() : "",
			jnd 			: $('#jnd_all').val() ? $('#jnd_all').val() : "",
			exd 			: $('#exd_all').val() ? $('#exd_all').val() : ""
		};
		if(fields.enq_ser_fup || fields.enq_ser_date || fields.enq_ser_nam_mob){
			fields.enq_ser_fup = (fields.enq_ser_fup.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.enq_ser_fup : "";
			fields.enq_ser_date = (fields.enq_ser_date.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.enq_ser_date : "";
			fields.enq_ser_nam_mob = (fields.enq_ser_nam_mob == "") ? "" : fields.enq_ser_nam_mob;
		}
		if(fields.group_name || fields.owner || fields.min_mem){
			fields.group_name = (fields.group_name == "") ? "" : fields.group_name;
			fields.owner = (fields.owner == "") ? "" : fields.owner;
			fields.min_mem = (fields.min_mem == "") ? "" : fields.min_mem;
		}
		if(fields.user_name || fields.user_mobile || fields.user_email){
			fields.user_name = (fields.user_name  == "") ? "" : fields.user_name ;
			fields.user_mobile = (fields.user_mobile == "") ? "" : fields.user_mobile;
			fields.user_email = (fields.user_email == "") ? "" : fields.user_email;
		}
		if(fields.offer_opt || fields.fct_opt || fields.offer_dur || fields.offer_min_mem){
			fields.offer_opt = (fields.offer_opt == "NULL") ? "" : fields.offer_opt;
			fields.fct_opt = (fields.fct_opt == "NULL") ? "" : fields.fct_opt;
			fields.offer_dur = (fields.offer_dur == "NULL") ? "" : fields.offer_dur;
			fields.offer_min_mem = (fields.offer_min_mem == "NULL") ? "" : fields.offer_min_mem;
		}
		if(fields.pack_opt || fields.pack_ses_opt){
			fields.pack_opt = (fields.pack_opt == "NULL") ? "" : fields.pack_opt;
			fields.pack_ses_opt = (fields.pack_ses_opt == "NULL") ? "" : fields.pack_ses_opt;
		}
		if(fields.jnd || fields.exd){
			fields.jnd = (fields.jnd.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.jnd : "";
			fields.exd = (fields.exd.match(/(\d{4})-(\d{2})-(\d{2})/)) ? fields.exd : "";
		}
		if(fields.enq_ser_fup.length > 0 || fields.enq_ser_date.length > 0 || fields.enq_ser_nam_mob.length > 0 ||
			fields.group_name.length > 0 || fields.owner.length > 0 || fields.min_mem > 1 || 
			fields.user_name.length > 1 || fields.user_mobile.length > 1 || fields.user_email.length > 1 ||
			fields.offer_opt.length > 0 || fields.fct_opt.length > 0 || fields.offer_dur.length > 0 || fields.offer_min_mem.length > 0 ||
			fields.pack_opt.length > 0 || fields.pack_ses_opt.length > 0 ||
			fields.jnd.length > 1 || fields.exd.length > 1){
			$(outputDiv).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				  url:window.location.href,
				  type:'post',
				  data:fields
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
					$(outputDiv).html(data);
			});
		}
	}
}
//customer
function controlCustomer(){
	var cust={};
	var em={};
	var cn={};
	var fp={};
	var dccode = '91';
	var dpcode = '080';
	this.__construct = function(customer){
		cust=customer;
		em=customer.em;
		cn=customer.cn;
		fp=customer.paymentrow;
		var id = $(DGYM_ID).attr('name');
		
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'addlistuser',id:id,type:'master',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
            else{
                //alert(data);
            	 }				
				},			
			error:function(){
				alert("there was an error");
			 }
		  });
			   
      
       $(cust.mofpayment).on('change',function(){
          var html='<input name="mod_number_temp_1" type="text" placeholder="Enter the  number" id="mode_payment_" class="form-control" width="30" />';
          $(cust.number_box).html(html);		  
	    });
	    
	   $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'setGYM',id:id,type:'master',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
				else{
				   var htmll='<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Person who referred the customer to join '+ data +'<i class="fa fa-caret-down fa-fw"></i></strong>';
				   $(cust.outDiv).html(htmll);
				  } 
			},
			error:function(){
				alert("there was an error");
			 }
		  });
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'modeofPayment',id:id,type:'slave',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
				else{
					$(cust.mofpayment).html(data);
				  } 
			},
			error:function(){
				alert("there was an error");
			 }
		  });	
		  $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'cust_sex',id:id,type:'master',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
				else{
					$(cust.custsexParent).html(data);
				  } 
			},
			error:function(){
				alert("there was an error");
			 }
		  });	
	initializefeerow();	  	
	initializeProfileAddForm();
	
	};
	function initializeProfileAddForm(){
			
			$(cn.plus +','+ em.plus).unbind();
			$(cn.plus).click(function(evt){
				evt.preventDefault();
			evt.stopPropagation();
				$(cn.plus).hide();
				bulitMultipleCellNumbers();
			});
			$(em.plus).click(function(evt){
				evt.preventDefault();
			evt.stopPropagation();
				$(em.plus).hide();
				bulitMultipleEmailIds();
			});
	};
	function initializefeerow(){
		    $(fp.plus).click(function(evt){
				evt.preventDefault();
			evt.stopPropagation();
				$(fp.plus).hide();
			bulitMultiplefeeForm();
	  });
   };
   function bulitMultiplefeeForm() {
     var id = $(DGYM_ID).attr('name');     
     if(fp.num == 1){
				$(fp.parentdiv).html('');
		}	
		
		fp.num++;
		var html= '<div class="col-lg-12" id="'+fp.addfeeform+fp.num+fp.num+'">'+
		            '<div class="col-lg-12" id="'+fp.addfeeform+fp.num +'">'+
						   '<strong><span id="user_fee_msg_temp_'+ fp.num +'">*</span>Fee <i class="fa fa-caret-down"></i></strong>'+
					   '</div><div class="col-lg-12">&nbsp;</div>'+
					   '<div class="col-lg-12">'+
										'<div class="form-group">'+
											'<div class="col-md-4" id="mod_pay_temp_'+fp.num+'">'+
											    
	   									'</div>'+
											'<div class="col-md-4">'+
												'<input name="user_fee_" type="text" id="'+fp.fee_input+fp.num+'" class="form-control"/>'+
	                                	'<div class="col-md-12" id="'+fp.number_box+fp.num+'"></div>'+									
											'</div>'+
										'</div>'+
									'</div>'+
					   '<div class="col-lg-4">'+
					     '<button type="button" class="btn btn-danger  btn-md" id="'+fp.minus+fp.num+'"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;'+
					     '<button type="button" class="btn btn-success  btn-md" id="'+fp.plus+fp.num+'"><i class="fa fa-plus fa-fw fa-x2"></i></button>'+
				      '</div>'+'</div>'+
				     '</div>';
		 $(fp.parentdiv).append(html);
		 $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'modeofPayment',id:id,type:'slave',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
				else{           
               $('#mod_pay_temp_'+fp.num).html(data);
               var v1=$('#mod_pay_temp_'+fp.num+' :selected').text();
               alert(v1);                             
              } 
			},
			error:function(){
				alert("there was an error");
			 }
		  });
		  $('#mod_pay_temp_'+fp.num).on('change',function(){
          //var html='<input name="mod_number_temp_1" type="text" placeholder="Enter the  number" id="mode_payment_" class="form-control" width="30" />';
          //$(cust.number_box).html(html);
          var v1=$('#mod_pay_temp_'+fp.num+' :selected').val();
          alert(v1);     		  
	    });
		 
	    window.setTimeout(function(){
				$(document.getElementById(fp.minus+fp.num)).click(function(){
               
               $(document.getElementById(fp.plus+fp.num)).hide();
					$(document.getElementById(fp.minus+fp.num)).hide();
					$(document.getElementById(fp.addfeeform+fp.num)).hide();
					$(document.getElementById(fp.addfeeform+fp.num+fp.num)).hide();
					fp.num--;
					if(fp.num == 1){
						$(fp.plus).show();
						$(fp.parentdiv).html('');
				   }
					else{
						$(document.getElementById(fp.plus+fp.num)).show();
						$(document.getElementById(fp.minus+fp.num)).show();
					}
				 });
				$(document.getElementById(fp.plus+fp.num)).click(function(){
					$(document.getElementById(fp.plus+fp.num)).hide();
					$(document.getElementById(fp.minus+fp.num)).hide();
					bulitMultiplefeeForm();
				});
			},200);
					 
   };
   
	function bulitMultipleEmailIds(){
			if(em.num == -1)
				$(em.parentDiv).html('');
			em.num++;
			var html = '<div id="'+em.form+em.num+'">'+
				'<div class="col-lg-8">'+
					'<input class="form-control" placeholder="Email ID" name="email" type="text" id="'+em.email+em.num+'" maxlength="100"/>'+
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
							'<input class="form-control" value="'+dccode+'" name="ccode" type="text" id="'+cn.codep+cn.num+'" maxlength="15" />'+
						'</div>'+
						'<div class="col-xs-6 col-md-4">'+
							'<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="'+cn.nump+cn.num+'" maxlength="20" />'+
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
						console.log(cn.num);
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
//Add Group
function controlCustomerFIVE(){
	var ag={};
	this.__construct = function(addgm){
		ag=addgm.agu;
		var id = $(DGYM_ID).attr("name");
	    $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'setGYM',id:id,type:'master'},
			success: function(data){
				if(data == 'logout')
					//window.location.href = URL;
				    alert("logout");
				else{
					var htmll='&nbsp;&nbsp;&nbsp;&nbsp;<strong>Person who referred the customer to join '+ data +'<i class="fa fa-caret-down"></i></strong>';
				    $(ag.outDiv).html(htmll);				  
			    } 
			},
			error:function(){
				alert("there was an error");
			}
		  });	
		initializcGroupAddForm();
	};
	function initializcGroupAddForm(){
			//$(ag.plus).unbind();
		    $(ag.plus).click(function(){
				$(ag.plus).hide();
				bulitMultipleMemberForm();
			});
			
		function bulitMultipleMemberForm(){
			if(ag.num == 2){
				$(ag.parentDiv).html('');
				$(ag.membership).html('');
			}	
			ag.num++;
			var html = '<div class="panel panel-info" id="'+ag.parentpanelid+ag.num+'">'+
            				'<div class="panel-heading">'+
                				'<h4 class="panel-title">'+
                    				'<a data-toggle="collapse" data-parent="#accordion" href="'+ag.panelid+ag.num+'"><label>Customer '+ag.num+':</label></a>'+
                				     '<button type="button" class="btn btn-danger  btn-md" id="'+ag.minus+ag.num+'"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;'+
									 '<button type="button" class="btn btn-success  btn-md" id="'+ag.plus+ag.num+'"><i class="fa fa-plus fa-fw fa-x2"></i></button>'+
                				 '</h4>'+
            				 '</div>'+
            				 '<div id="'+ag.prefix+ag.num+'" class="panel-collapse collapse">'+
                				'<div class="panel-body" id="addgpmem_panel_'+ag.num+'">'+
                    			     '<div class="col-lg-12" id="addgpmem_cols_'+ag.num+'>'+
               '<form role="form" method="POST" name="addgp_memfm_'+ag.num+'" id="addgp_memfm_'+ag.num+'">'+
				            '<fieldset>'+
 				           	'<div class="row">'+
								 '<div class="col-lg-12">'+
							       '<div id="add_mop_temp">'+
								     '<div class="row" id="usr_fee_row_temp_1">'+
								  	   '<div class="col-lg-12">'+
										   '<strong><span id="user_fee_msg_temp_1" style="display:none; color:#FF0000; font-size:25px;">*</span>Fee <i class="fa fa-caret-down"></i></strong>'+
									   '</div>'+
									   '<div class="col-lg-12">'+
										 '<div class="form-group">'+
											'<div class="col-md-4">'+
												'<select name="mod_pay" id="mod_pay_temp_1" onChange="javascript:ShowTextBox(1,\'temp\');" class="form-control">'+
												'<option value="NULL">Select mode of payment</option>'+
												'<option value="Cash" selected>Cash</option>'+
												'<option value="Card">Card</option>'+
												'<option value="Cheque">Cheque</option>'+
												'<option value="PDC">PDC</option>'+
												'</select>'+
											'</div>'+
											'<div class="col-md-4">'+
											
											//add registration fee 
												'<input name="user_fee"   type="text" value="500"     id="user_fee_temp_" class="form-control"/>'+
												'<input name="mod_number_temp_1" type="text" placeholder="PDC number"    id="pdc_no_temp_1"    class="form-control" style="display:none;"/>'+
												'<input name="mod_number_temp_1" type="text" placeholder="Cheque number" id="cheque_no_temp_1" class="form-control" style="display:none;"/>'+
												'<input name="mod_number_temp_1" type="text" placeholder="Card number"   id="card_no_temp_1"   class="form-control" style="display:none;"/>'+
											'</div>'+
											'<div class="col-md-4">'+
												'<a id="addmop_temp_1" class="btn btn-primary  btn-xs" href="javascript:void(0);"  onClick="javascript:AddModeOfPayment(\'temp\',1);$(this).hide();">Add</a>'+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div class="col-lg-12">&nbsp;</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>'+
				   '<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong><span id="un_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Name <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
								'.$cust_name.'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong>Sex <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
								'<select name="sex" class="form-control" id="user_sex_'+ag.num+'">'+
									'<option value="male">male</option>'+
									'<option value="female">female</option>'+
								'</select>'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong><span id="dob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Date of birth <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
								'<input name="dob" type="text" class="form-control" id="dateofbirth_'+ag.num+'" placeholder="DOB" readonly="readonly" />'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">&nbsp;</div>'+
						'<div class="col-lg-12">'+
							'<div class="panel panel-primary">'+
								'<div class="panel-heading">'+
									'<h4>Email IDs, Cell Numbers</h4>'+
								'</div>'+
								'<div class="panel-body">'+
									'<ul class="nav nav-pills">'+
										'<li class="active"><a href="#cademails-pills" data-toggle="tab">Email IDs</a>'+
										'</li>'+
										'<li><a href="#cadcnums-pills" data-toggle="tab">Cell Numbers</a>'+
										'</li>'+
									'</ul>'+
									'<div class="tab-content">'+
										'<div class="tab-pane fade in active" id="cademails-pills">'+
											//<!-- Email ID -->
											'<div class="row">'+
												'<div class="col-lg-12">'+
													'<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Email ID <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;'+
													'<button type="button" class="text-primary btn btn-success  btn-md" id="cadplus_email_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;'+
												'</div>'+
												'<div class="col-lg-12" id="cadgpmultiple_email_'+ag.num+'">'+
												'</div>'+
												'<div class="col-lg-12">&nbsp;</div>'+
											'</div>'+
										'</div>'+
										'<div class="tab-pane fade" id="cadcnums-pills">'+
											//Cell Number
											'<div class="row">'+
												'<div class="col-lg-12">'+
													'<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Cell Number <i class="fa fa-caret-down fa-fw"></i></strong>&nbsp;'+
													'<button  type="button" class="text-primary btn btn-success  btn-md" id="cadplus_cnumber_"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp;'+
												
												'</div>'+
												'<div class="col-lg-12" id="cadgpmultiple_cnumber_'+ag.num+'">'+
												'</div>'+
												'<div class="col-lg-12">&nbsp;</div>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<div class="col-lg-12">&nbsp;</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong><span id="user_acs_msg" style="display:none; color:#FF0000; font-size:25px;" >*</span> Access ID <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
							
							
							///////add accessids
								'<input name="user_acs" type="text" class="form-control" value="dfsdfsdfdf" id="group_acs_'+ag.num+'"/>'+
								'<span id="acsgp_id_exist_msg"></span>'+
								'<input id="acsgp_id_check_'+ag.num+'" type="checkbox" checked="checked" style="display:none;"/>'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong>Company <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
								'<input name="comp_name" type="text" class="form-control" placeholder="MadMec" id="comp_gpname_'+ag.num+'"/>'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong>Occupation <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
							'<select name="group_occ" id="group_occ_'+ag.num+'" type="text" class="form-control" >'+
								'<option value="student">student</option>'+
								'<option value="professional">professional</option>'+
								'<option value="other">other</option>'+
							'</select>'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong>Emergency name <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
								'<input name="emer_name" type="text" class="form-control" placeholder="Your family member" id="emergp_name_'+ag.num+'"/>'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong><span id="emr_mob_msg" style="display:none; color:#FF0000; font-size:25px;">*</span> Emergency number <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
								'<input name="emer_num" type="text" class="form-control"  placeholder="9999999999" maxlength="10" id="emergp_num_'+ag.num+'"/>'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
					'<div class="row">'+
						'<div class="col-lg-12">'+
							'<strong>Address <i class="fa fa-caret-down"></i></strong>'+
						'</div>'+
						'<div class="col-lg-12">'+
							'<span>'+
								'take add profile wise'+
							'</span>'+
							'<p class="help-block">Press enter or go button to move to next field.</p>'+
						'</div>'+
					'</div>'+
				   '</fieldset>'+
				'</form>'+   
				'</div>'+
                				'</div>'+
            				 '</div>'+
        				  '</div>';
        
        	var htmll='<span id="'+ag.memradiospan+ag.num+'"">&nbsp;&nbsp;&nbsp;<input id="'+ag.memradioid+ag.num+'" type="radio" value="'+ag.memradioid+ag.num+'" name="'+ag.memradioid+ag.num+'"/>: Customer '+ag.num+'<span><br/>';
			
			$(ag.parentDiv).append(html);
			$(ag.membership).append(htmll);
			window.setTimeout(function(){
				$(document.getElementById(ag.minus+ag.num)).click(function(){
					
					$(document.getElementById(ag.plus+ag.num)).hide();
					$(document.getElementById(ag.minus+ag.num)).hide();
					$(document.getElementById(ag.parentpanelid+ag.num)).hide();
					$(document.getElementById(ag.memradiospan+ag.num)).hide();
					ag.num--;
					if(ag.num == 2){
						$(document.getElementById(ag.coupletypeId)).attr('checked', true);
					    $(document.getElementById(ag.grouptypeId)).attr('checked', false);
						$(ag.plus).show();
						$(ag.parentDiv).html('');
					}
					else{
						$(document.getElementById(ag.plus+ag.num)).show();
						$(document.getElementById(ag.minus+ag.num)).show();
					}
					//if(ag.count && ag.count == ag.num){
					//	$(ag.plus).show();
					//}
				});
				$(document.getElementById(ag.plus+ag.num)).click(function(){
					
					$(document.getElementById(ag.coupletypeId)).attr('checked',false);
					$(document.getElementById(ag.grouptypeId)).attr('checked', true);
					$(document.getElementById(ag.plus+ag.num)).hide();
					$(document.getElementById(ag.minus+ag.num)).hide();
					bulitMultipleMemberForm();
				});
			},200);
		};
	  }	
	}			
//Trainer
function controlTrainer(){
	var tn={};
	var dccode = '91';
	var gymid = $(DGYM_ID).attr( "name" );
	this.__construct = function(trainer){
		tn=trainer;
		$("#"+tn.dob).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			altField: '#alternate_1',
			altFormat: 'DD, d MM, yy',
			maxDate: 0,
			yearRange:'1960:'+(new Date).getFullYear()+''
		});
		$("#"+tn.doj).datepicker({
			dateFormat: 'yy-mm-dd',
			yearRange:'2014:'+Number(new Date().getFullYear())+2,
		});
		$("#"+tn.but).bind("click",function(){
			trainerAdd();
		});
		/*pic edit*/
		$(".picedit_box").picEdit({
			imageUpdated: function(img){
			},
			formSubmitted: function(data){
			},
			redirectUrl: false,
			defaultImage: URL+ASSET_IMG+'No_image.png',
		});
		AddDummyEmail();
		fetchTrainerType();
		fetchInterestedIn();
		fetchGenderType();
	};
	function fetchGenderType(){
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'cust_sex',type:'master',gymid:gymid},
			success: function(data){
				//console.log(data);
				if(data == 'logout')
					window.location.href = URL;
				else{
					$("#"+tn.sex).html(data);
				  } 
			},
		 });
	}	
	function AddDummyEmail(){
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'AddDummyEmail',type:'master',gymid:gymid},
			success: function(data){
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
						$("#"+tn.email).val(data);
						$("#"+tn.emsg).html(VALIDNOT);	
					break;
				}
			}
		});
	}
	function fetchInterestedIn(){
			var rad = '';
			$.ajax({
				type:'POST',
				url:window.location.href,
				data:{autoloader:true,action:'fetchInterestedIn',type:'slave',gymid:gymid},
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
							var type = $.parseJSON(data);
							listofvaliditytypes = type;
							for(i=0;i<type.length;i++){
								rad += '<option  value="'+type[i]["id"]+'">'+type[i]["html"]+'</option>';
							}
							$("#"+tn.ftype).html('<option value="NULL" selected>Select facility Type</option>'+rad);
						break;
					}
				},
				error:function(){
					$(loader).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
				}
			});
		};
	function fetchTrainerType(){
		var rad = '';
		$.ajax({
			type:'POST',
			url:window.location.href,
			data:{autoloader:true,action:'fetchTrainerType',type:'master',gymid:gymid},
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
						var type = $.parseJSON(data);
						listofvaliditytypes = type;
						for(i=0;i<type.length;i++){
							rad += '<option  value="'+type[i]["id"]+'">'+type[i]["html"]+'</option>';
						}
						$("#"+tn.ttype).html('<option value="NULL" selected>Select Trainer Type</option>'+rad);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	};
	function trainerAdd(){
		console.log("im here to add trainer");
		var attr = validateTrainerFields();
		console.log(attr);
		if(attr){
				$("#"+tn.but).prop('disabled','disabled');
				$(loader).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
				$.ajax({
					url:tn.url,
					type:'POST',
					data:{autoloader: true,action:'trainerAdd',type:'slave',gymid:gymid,eadd:attr},
					success:function(data, textStatus, xhr){
						data = $.parseJSON(data);
						//console.log(data);
						//console.log(data.photo_id);
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							case 'login':
								loginAdmin({});
							break;
							default:
								$(loader).hide();
								$("#"+tn.msg).html('<h2>Record success fully added</h2>');
								$("#"+tn.form).get(0).reset();
								$("#photo_id").val(data.user_id);
								window.setTimeout(function(){
									 $("#"+tn.phupload).trigger('click');
									//var photo = photoUpload(data.photo_id);
								},2000);
								
							break;
						}
					},
					error:function(){
						$("#"+tn.msg).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						//console.log(xhr.status);
						window.setTimeout(function(){
							$("#"+tn.msg).html('');
						},2000);
						$("#"+tn.but).removeAttr('disabled');
					}
				});
			}
			else{
				$("#"+tn.but).removeAttr('disabled');
			}
	}
	function validateTrainerFields(){
			var flag = false;
			var sex = $("#"+tn.sex).val();
			var ftype= $("#"+tn.ftype).val();
			var ttype = $("#"+tn.ttype).val();
			/* name */
			if($('#'+tn.name).val().match(name_reg)){
				flag = true;
				$("#"+tn.nmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+tn.nmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+tn.nmsg).offset().top)-95}, "slow");
				$('#'+tn.nmsg).focus();
				return;
			}
			/* sex type*/
			if(sex != 'NULL' && sex != ''){
				flag = true;
				$('#'+tn.smsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+tn.smsg).html('<strong class="text-danger">Select sex type.</strong>');
				$('html, body').animate({scrollTop: Number($('#'+tn.smsg).offset().top)-95}, "slow");
				return;
			}
			/* facility type*/
			if(ftype != 'NULL' && ftype != ''){
				flag = true;
				$('#'+tn.fmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+tn.fmsg).html('<strong class="text-danger">Select facility type.</strong>');
				$('html, body').animate({scrollTop: Number($('#'+tn.fmsg).offset().top)-95}, "slow");
				return;
			}
			/* trainer type*/
			if(ttype != 'NULL' && ttype != ''){
				flag = true;
				$('#'+tn.tmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+tn.tmsg).html('<strong class="text-danger">Select Trainer type.</strong>');
				$('html, body').animate({scrollTop: Number($('#'+tn.tmsg).offset().top)-95}, "slow");
				return;
			}
			/* email */
			if($('#'+tn.email).val().match(email_reg)){
				flag = true;
				$("#"+tn.emsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+tn.emsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+tn.emsg).offset().top)-95}, "slow");
				$('#'+tn.emsg).focus();
				return;
			}
			/* cellcode */
			if($('#'+tn.ccode).val().match(ccod_reg)){
				flag = true;
				$("#"+tn.cmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+tn.cmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+tn.cmsg).offset().top)-95}, "slow");
				$('#'+tn.cmsg).focus();
				return;
			}
			/* cellnumber */
			if($('#'+tn.mobile).val().match(cell_reg)){
				flag = true;
				$("#"+tn.mmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+tn.mmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+tn.mmsg).offset().top)-95}, "slow");
				$('#'+tn.mmsg).focus();
				return;
			}
			var attr = {
				name		: $('#'+tn.name).val(),
				sex_type	: sex,
				facility_type: ftype,
				trainer_type : ttype,
				email		: $('#'+tn.email).val(),
				cellcode		: $('#'+tn.ccode).val(),
				cellnum		: $('#'+tn.mobile).val(),
				dob		: $('#'+tn.dob).val(),
				doj		: $('#'+tn.doj).val(),
			};
			if(flag){
				return attr;
			}
			else
				return false;
		};
	}
function controlListTrainer(){
	var gymid = $(DGYM_ID).attr( "name" );
	this.__construct = function(){
		displayListTrainer();
	};
	this.close	=	function(clid){
		var cl = clid;
		$(cl.closeDiv).click(function(){
				$(cl.clisttab).click();
		});
		
	}
	this.editTrainer = function(trainer){
		var tra = trainer;
		$(tra.but).click(function(){
			$(tra.showDiv).toggle();
			$(tra.updateDiv).toggle();
			$(tra.but).hide();
		});
		$(tra.saveBut).click(function(){
			updateTrainer();
		});
		$(tra.closeBut).click(function(){
			edittrainer(tra.uid);
		});
		$(tra.dob).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			altField: '#alternate_1',
			altFormat: 'DD, d MM, yy',
			maxDate: 0,
			yearRange:'1960:'+(new Date).getFullYear()+''
		});
		$(tra.doj).datepicker({
			dateFormat: 'yy-mm-dd',
			yearRange:'2014:'+Number(new Date().getFullYear())+2,
		});
		/*pic edit*/
		$(".picedit_box").picEdit({
			imageUpdated: function(img){
			},
			formSubmitted: function(data){
				$("#photoCancel_"+tra.uid).click();
				edittrainer(tra.uid);
			},
			redirectUrl: false,
			defaultImage: URL+ASSET_IMG+'No_image.png',
		});
		
		function updateTrainer(){
			var uid = tra.uid;
			console.log(uid);
			var attr = validateUpdateTrainer();
			console.log(attr);
			if(attr){
					$(tra.but).prop('disabled','disabled');
					$(loader).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
					$.ajax({
						url:tra.Updateurl,
						type:'POST',
						data:{autoloader: true,action:'trainerUpdate',type:'slave',gymid:gymid,eadd:attr,uid:uid},
						success:function(data, textStatus, xhr){
							
							//console.log(data);
							//console.log(data.photo_id);
							switch(data){
								case 'logout':
									logoutAdmin({});
								break;
								case 'login':
									loginAdmin({});
								break;
								default:
								break;
							}
						},
						error:function(){
							$(tra.msg).html(INET_ERROR);
						},
						complete: function(xhr, textStatus) {
							$(tra.but).removeAttr('disabled');
						}
					});
				}
				else{
					$(tra.but).removeAttr('disabled');
				}
			}
		function validateUpdateTrainer(){
			var flag = false;
			/* name */
			if($(tra.name).val().match(name_reg)){
				flag = true;
				$(tra.nmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(tra.nmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(tra.nmsg).offset().top)-95}, "slow");
				$(tra.nmsg).focus();
				return;
			}
			/* email */
			if($(tra.email).val().match(email_reg)){
				flag = true;
				$(tra.emsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(tra.emsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(tra.emsg).offset().top)-95}, "slow");
				$(tra.emsg).focus();
				return;
			}
			/* cellcode */
			if($(tra.ccode).val().match(ccod_reg)){
				flag = true;
				$(tra.cmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(tra.cmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(tra.cmsg).offset().top)-95}, "slow");
				$(tra.cmsg).focus();
				return;
			}
			/* cellnumber */
			if($(tra.mobile).val().match(cell_reg)){
				flag = true;
				$(tra.mmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(tra.mmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(tra.mmsg).offset().top)-95}, "slow");
				$(tra.mmsg).focus();
				return;
			}
			var attr = {
				name		: $(tra.name).val(),
				email		: $(tra.email).val(),
				cellcode		: $(tra.ccode).val(),
				cellnum		: $(tra.mobile).val(),
				dob		: $(tra.dob).val(),
				doj		: $(tra.doj).val(),
			};
			if(flag){
				return attr;
			}
			else
				return false;
		};
	}
	function displayListTrainer(){
			var header='<table class="table table-striped table-bordered table-hover" id="list_trainer_table"><thead><tr><th></th><th>#</th><th>Employee Name</th><th class="text-right">Email</th><th class="text-right">Cell Number</th><th class="text-right">Delete</th><th class="text-right">Flag/Unflag</th><th class="text-right">Edit</th></tr></thead>';
			var footer='</table>';
			var htm = '';
			$(loader).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
			$.ajax({
				url:window.location.href,
				type:'post',
				data:{autoloader:true,action:'displayListTrainer',type:'slave',gymid:gymid},
				success:function(data, textStatus, xhr){
					data =$.trim(data);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							var listtrainer = $.parseJSON(data);
							//console.log(listtrainer["0"]["name"]);
							for(i=0;i<listtrainer.length;i++){
								htm += listtrainer[i]["html"];
							}
							$("#listTrainer").html(header+htm+footer);
							for(i=0;i<listtrainer.length;i++){
								$(listtrainer[i].usrdelOk).bind('click',{uid:listtrainer[i].uid,sr:listtrainer[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									//console.log(evt.data.uid);
									var hid = deleteTrainer(evt.data.uid);
									if(hid){
										$(evt.data.sr).remove();
										displayListTrainer();
									}
								});
								$(listtrainer[i].usrflgOk).bind('click',{uid:listtrainer[i].uid,sr:listtrainer[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									var hid = flagTrainer(evt.data.uid);
									displayListTrainer();
								});
								$(listtrainer[i].usruflgOk).bind('click',{uid:listtrainer[i].uid,sr:listtrainer[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									var hid = unflagTrainer(evt.data.uid);
									displayListTrainer();
								});
								$(listtrainer[i].usredit).bind('click',{uid:listtrainer[i].uid,sr:listtrainer[i].sr},function(evt){
									$($(this).prop('name')).hide(400);
									var hid = edittrainer(evt.data.uid);
									//DisplayUserList();
								});
							}
							window.setTimeout(function(){
								var table=$('#list_trainer_table').DataTable({
									"aoColumns": [
										null,
                                        null,
                                        null,
                                        null,
                                        null,
                                        null,
                                        null,
                                        null,
                                      ],
                                      	"columns": [ 
											{ "className": 'details-control',
											  "orderable": false,
											  "data": null,
											  "defaultContent": '' 
											 },
											 { "data": "name"
												  },
										 ],
										 "order": [[1, 'asc']] 
								});
								$('#list_trainer_table tbody').on('click', 'td.details-control', function () {
							        var tr = $(this).closest('tr');
							        console.log(tr);
							        var row = table.row( tr );
									console.log(row.data());
							        if ( row.child.isShown() ) {
							            // This row is already open - close it
							            row.child.hide();
							            tr.removeClass('shown');
							        }
							        else {
							            // Open this row
							            row.child( format(row.data()) ).show();
							            tr.addClass('shown');
							        }
							    });
							    
							},600)
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
	function format ( d ) {
		console.log(d);
	    // `d` is the original data object for the row
	    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
	        '<tr>'+
				'<td>Full name:</td>'+
				'<td>'+d[2]+'</td>'+
			'</tr>'+
			'<tr>'+
				'<td>Email:</td>'+
				'<td>'+d[3]+'</td>'+
			'</tr>'+
			'<tr>'+
				'<td>Cell Number:</td>'+
				'<td>'+d[4]+'</td>'+
			'</tr>'+
	        
	    '</table>';
	}
	function deleteTrainer(uid){
		var flag = false;
		var	entid = uid;
		//console.log(entid);
		$.ajax({
			url:window.location.href,
			type:'POST',
			async:false,
			data:{autoloader: true,action:'deleteTrainer',type:'slave',gymid:gymid,traDEL:entid},
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
	function flagTrainer(id) {
		var uid = id;
		console.log(uid);
		var flag = false;
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{autoloader:true,action:'flagTrainer',type:'slave',gymid:gymid,fuser:uid},
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
	function unflagTrainer(id) {
		var uid = id;
		var flag = false;
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{autoloader:true,action:'unflagTrainer',type:'slave',gymid:gymid,ufuser:uid},
			success: function (data, textStatus, xhr) {
				//console.log(data);
				data = $.trim(data);
				if(data){
					flag=true;
				}				  
			  }							
			});
		return flag;					
	}
	function edittrainer(id){
		var	usrid = id;
		var htm='';
		$.ajax({
				url:window.location.href,
				type:'POST',
				async:false,
				data:{autoloader: true,action:'edittrainer',type:'slave',gymid:gymid,usrid:usrid},
				success:function(data, textStatus, xhr){
					console.log("status"+data);
					//data = $.trim(data);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
						$("#listTrainer").html(data);
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
}
function controlTrainerPay(){
	var gymid = $(DGYM_ID).attr( "name" );
	this.__construct = function(trapay){
		pay = trapay;
		console.dir(pay);
	};
}
function controlTrainerImport(){
	var traImp={};
	var gymid = $(DGYM_ID).attr( "name" );
	this.__construct = function(trainerImport){
		 traImp = trainerImport;
		var bar = $('.bar');
		var percent = $('.percent');
		var status = $('#status');
		$('#trainerdetailsxls').ajaxForm({
			beforeSend: function() {
				status.empty();
				var percentVal = '0%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			success: function() {
				var percentVal = '100%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			complete: function(xhr) {
				var percentVal = '0%';
				if(xhr.responseText.length == 0){
					bar.width(percentVal);
					percent.html(percentVal);
				}
				status.html(xhr.responseText);
			}
		});
		fetchTrainerType();
		fetchInterestedIn();
	};
	function fetchInterestedIn(){
		var rad = '';
		$.ajax({
			type:'POST',
			url:window.location.href,
			data:{autoloader:true,action:'fetchInterestedIn',type:'slave',gymid:gymid},
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
						var type = $.parseJSON(data);
						listofvaliditytypes = type;
						for(i=0;i<type.length;i++){
							rad += '<option  value="'+type[i]["id"]+'">'+type[i]["html"]+'</option>';
						}
						$("#"+traImp.ftype).html('<option value="NULL" selected>Select facility Type</option>'+rad);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	};
	function fetchTrainerType(){
		var rad = '';
		$.ajax({
			type:'POST',
			url:window.location.href,
			data:{autoloader:true,action:'fetchTrainerType',type:'master',gymid:gymid},
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
						var type = $.parseJSON(data);
						listofvaliditytypes = type;
						for(i=0;i<type.length;i++){
							rad += '<option  value="'+type[i]["id"]+'">'+type[i]["html"]+'</option>';
						}
						$("#"+traImp.ttype).html('<option value="NULL" selected>Select Trainer Type</option>'+rad);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	};
}
//Manage
function controlManage(){
	var mngat={};
	var li_html= '';
	var div_html='';
	var id = $(DGYM_ID).attr('name');
	this.__construct = function(manage){
		mngat=manage;
		var id = $(DGYM_ID).attr('name');
		//initializecustomerAtt();
		initializepanel();
	};
	this.attadancetable = function(attdata){
		$(attdata.btn).bind("click",function(){
		     alert("att id"+attdata.att_id);
		     update_attendance(attdata);	
		});
		window.setTimeout(function(){
								$(attdata.tableid).dataTable({
								"aoColumns": [
										null,
                                        null,
                                        null,
                                        null,
                                        null,
                                        null,
                                        ],
                                 "autoWidth": true
								});
							},200);
	}
	function initializepanel(){
		var rad = '<ul class="nav nav-tabs" id="dynamicFee">';
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			type:'POST',
			url:window.location.href,
			data:{autoloader:true,action:'fetchInterestedIn',type:'slave',gymid:id},
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
						var fee = $.parseJSON(data);
						$(mngat.panelheading).html(fee[0]["html"]+" Attendance");
						for(i=0;i<fee.length;i++){
							//$(mngat.panelheading).html(fee[i]["html"]+" Attendance");
							if(i==0)
								rad += '<li><a href="'+mngat.pillpanel_div+'" id="attTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';
							else
								rad += '<li><a href="'+mngat.pillpanel_div+'" id="attTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';
						}
						rad += "</ul>";
						$(mngat.st_panel).html(rad);
						$(loader).html('');
						
						for(i=0;i<fee.length;i++){
							$(mngat.allattTab+i).bind('click',{fid:fee[i]["id"],name:fee[i]["html"],sindex:i},function(evt){
							    $(mngat.pillpanel_div).show();
							    $(mngat.panelheading).html(evt.data.name+" Attendance");
								var para1 = {
								  fid		: 	evt.data.fid,
								  fname		:	evt.data.name,
								  sindex	:	evt.data.sindex,
								  tabId		:	mngat.allattTab+i,
								}
								//displayFeeUserList(para1);
								initializecustomerAtt(para1);
							});
						}
						
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	}
	function initializecustomerAtt(para1){
		//alert(para1.fid);
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'list_att',gymid:id,att:para1,type:'slave',fid:para1.fid},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
					$(mngat.pillpanel_div).html(data);
				    
			}
		});
	}
    function update_attendance(attdata){
		
		//$('#center_loader').html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
		//$('#center_loader').center();
		//$('#center_loader').show();
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'update_atd',p_id:attdata.cust_pk,aid:attdata.att_id,ftype:attdata.facility,gymid:id,type:'slave'},
			success: function(data){
				//$('#center_loader').hide();
				var date = new Date();
				var result = new Array();
				// result[0] = $.datepicker.formatDate('DD, M, d, yy', date);
				result[0] = '';
				result[1] = ' ';
				if (date.getHours() > 12) {
					result[2] = date.getHours() - 12;
				} else if (date.getHours() == 0 ) {
					result[2] = "12";
				} else {
					result[2] = date.getHours();
				}
				result[3] = ":"
				result[4] = date.getMinutes();
				if (date.getHours() > 12) {
					result[5] = " PM";
				} else {
					result[5] = " AM";
				}
				if(data == 'logout')
					window.location.href = URL;
				if(data == '0'){
					$(attdata.btn).html('<span class="text-danger"><i class="fa  fa-circle fa-3x fa-fw"></i></span>');
					$(attdata.out_time).html(result.join(''));
				}
				if(data == '1'){
					$(attdata.btn).html('<span class="text-success"><i class="fa fa-check-circle fa-3x fa-fw"></i></span>');
					$(attdata.in_time).html(result.join(''));
				}
				
				// list_atd();
				$.ajax({
				url: window.location.href,
				type:'POST',
				data:{autoloader:'true',action:'list_att',gymid:id,type:'slave',fid:attdata.facility},
				success: function(data){
				if(data == 'logout')
					window.location.href = URL;
				else
				//alert(data);
					$(mngat.pillpanel_div).html(data);
				}
				 });
			}
		});
	}
}
function controlManageTwo(){
	var mng={};
	var id = $(DGYM_ID).attr('name');
	this.__construct = function(managetwo){
		mg=managetwo;
		var id = $(DGYM_ID).attr('name');
		$(mg.minusfact).hide();
		$(mg.allfact).hide();
		$(mg.hidefact).show();
	   initializeaddfact();
	   
//// -----------------------get available facility ---------------------- 		
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'showfact',id:id,type:'slave',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
            else{
                 $(mg.showfacti).html(data);
            	}				
				},			
			error:function(){
				alert("there was an error");
			 }
		  });
    $(mg.factBtn).click(function () {
      console.log("btn click");
    	var factName = $(mg.factName).val();
    	var factStatus=$(mg.showstatus+' :selected').val();
        $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'addfact',id:id,type:'slave',gymid:id,factNm:factName,factST:factStatus},
			success: function(data){
            console.log(data); 				
				if(data == 'logout')
					window.location.href = URL;
            else if(data === 'success'){
                 console.log("inserted");
            	}
            	$(mg.referpage).click();
				},			
			error:function(){
				alert("there was an error");
			 }
		  });  
     
    });	
    $(mg.hidefact).bind("click",function () {
       $(mg.allfact).show();
       $(mg.hidefact).hide();
       $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'showhidefact',id:id,type:'slave',gymid:id},
			success: function(data){
				
				if(data == 'logout')
					window.location.href = URL;
            else if(data == false) {
               $(mg.showfacti).html("<center><h2>No One Facility is DeActive</h2></center>");
            }            
            else{
				
            	  $(mg.showfacti).html(data);
            	}				
				},			
			error:function(){
				alert("there was an error");
			 }
		  });
              
    });
    $(mg.allfact).click(function () {
       $(mg.hidefact).show();
       $(mg.allfact).hide();
       $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'showfact',id:id,type:'slave',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
            else{
				
                 $(mg.showfacti).html(data);
            	}				
				},			
			error:function(){
				alert("there was an error");
			 }
		  });
              
    });
	}
	this.hideshow = function(gym){
		//$(gym.nav).each(function(){
			
			$(gym.outdiv2).click(function(evt){
			 var chid=gym.outdiv1;
			 console.log("id="+id);
			 console.log("gymid="+id);
			 console.log("chid="+chid);
			 var r=confirm("Do you want to Active Facility?");
         	if(r==true)
             {
               $.ajax({
						url: window.location.href,
						type:'POST',
						data:{autoloader:'true',action:'showhide',id:id,type:'slave',gymid:id,chid:chid},
						success: function(data){
						 if(data == 'logout')
							window.location.href = URL;
            		 else{
                 			$(mg.referpage).click();
            			}				
						},			
						error:function(){
							alert("there was an error");
			 			}
		  			});                        
          	 }
          	
		});
	}
	
	this.dectivefacility = function(gym1){
		
			$(gym1.outdiv2).bind("click",function(evt){
				
			 var chid=gym1.outdiv1;
			 //
			 var r=confirm('Do you want to Really DeActive "'+gym1.factNm+'" Facility?');
         	if(r==true)
             {
               $.ajax({
						url: window.location.href,
						type:'POST',
						data:{autoloader:'true',action:'deactiveFact',id:id,type:'slave',gymid:id,chid:chid},
						success: function(data){
						 if(data == 'logout')
							window.location.href = URL;
            		    else {
                 			$(mg.referpage).click();
            			 }
            			             			 				
						},			
						error:function(){
							alert("there was an error");
			 			}
		  			});                        
          	 }
          	
		});
	}
	
	
	function initializeaddfact() {		
       window.setTimeout(function(){
				$(function() {
					
					$(mg.plusfact).click(function(){
                    $(mg.addnewFact).show();
                    $(mg.minusfact).show();
                 $.ajax({
						url: window.location.href,
						type:'POST',
						data:{autoloader:'true',action:'showhidestatus',id:id,type:'slave',gymid:id},
						success: function(data){
						 if(data == 'logout')
							window.location.href = URL;
            		 else{
                 			var html='<label>Status</label><select id="factstvalue" class="form-control">';
                 		$(mg.showstatus).html(html+data);
            			 }				
						},			
						error:function(){
							alert("there was an error");
			 			}
		  			}); 
                    
		         });
		         $(mg.minusfact).click(function () {
                    $(mg.addnewFact).hide();
                    $(mg.minusfact).hide();
		         });
	        });
	  },200);	
	}		  
}
function controlManageThr() {
 var mgthr={};
 var v1 =1;
 var v2 =1;
 var id = $(DGYM_ID).attr("name");
	this.__construct = function(manage){
		mgthr=manage;
		initializefacility();
		initializeduration();
	
	$(mgthr.of_fact).on('change',function(){
          v1=$(mgthr.of_fact+' :selected').val();
        });	
	 $(mgthr.of_duration).on('change',function(){
           v2=$(mgthr.of_duration+' :selected').val();
      });
	 $(mgthr.offerADbtn).click(function () {
		 var flag=false;
			var num_reg = /^[0-9]{1,3}$/;
			var of_num=$(mgthr.of_day).val();
			var price_reg=/^[0-9]{1,}$/;
			var of_prize=$(mgthr.of_price).val();
			
         if($(mgthr.of_name).val())
          { 
           var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'true.png" border="0" width="25" height="25" />&nbsp;valid ';
             $(mgthr.valid_nm).html(html);
          	
          	if ($(mgthr.of_duration).val() === 'NULL'){
                  //flag=true;
                  var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'false.png" border="0" width="25" height="25" />&nbsp;Invalid ';
              		$(mgthr.valid_duration).html(html);       	
          	}else {          		
          		var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'true.png" border="0" width="25" height="25" />&nbsp;valid ';
             	 $(mgthr.valid_duration).html(html);
             	 
          		 if(of_num.match(num_reg)){
					  var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'true.png" border="0" width="25" height="25" />&nbsp;valid ';
             	  $(mgthr.valid_num).html(html);
             	     if ($(mgthr.of_fact).val() === 'NULL') {
                         flag=true;
                        alert("select facility");             	     
             	     }else{
             	       var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'true.png" border="0" width="25" height="25" />&nbsp;valid ';
             	  		 $(mgthr.valid_fact).html(html);
             	  		//============add for price 
             	  		 if(of_prize.match(price_reg)){
								var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'true.png" border="0" width="25" height="25" />&nbsp;valid ';
               			$(mgthr.valid_price).html(html);
               			
               			 //=========== add for member
               			 if($(mgthr.of_member).val()){
               			   var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'true.png" border="0" width="25" height="25" />&nbsp;valid ';
               			   $(mgthr.valid_member).html(html);
               			 }
				          }
				 			else if (!of_prize) {
								flag=true;
				  				var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'empty.png" border="0" width="25" height="25" />&nbsp;Empty ';
               			$(mgthr.valid_price).html(html);
				 			}
				 			else {
								flag=true;
				  				var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'false.png" border="0" width="25" height="25" />&nbsp;Invalid ';
              				$(mgthr.valid_price).html(html);  				
				 			 }
             	  		                	     
             	     }
			       }
			      else if (!of_num) {
					  flag=true;
			   	  var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'empty.png" border="0" width="25" height="25" />&nbsp;Empty ';
                  $(mgthr.valid_num).html(html);
			      }
			     else {
					 flag=true;
					var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'false.png" border="0" width="25" height="25" />&nbsp;Invalid ';
					$(mgthr.valid_num).html(html);			
			      }        		
          	}
          	 
          }
          else{
			  flag=true;
            var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'false.png" border="0" width="25" height="25" />&nbsp;valid ';
             $(mgthr.valid_nm).html(html);          
          } 
          
          //========================= price
          if(flag)
           {
			 alert("Fill all field");   
			}
		else{
			var html='<img class="img-circle" src="'+URL+ASSET_IMG+ICON_THEME+'true.png" border="0" width="25" height="25" />&nbsp;valid ';
			$(mgthr.valid_member).html(html);
			$(mgthr.of_desc).html(html);
			$(loader).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
		    //alert("name="+$(mgthr.of_name).val()+"duration="+$(mgthr.of_duration).val()+"days="+$(mgthr.of_day).val()+"facility="+$(mgthr.of_fact).val()+"prizing="+$(mgthr.of_price).val()+"minimum member="+$(mgthr.of_mem).val()+"description"+$(mgthr.of_desc).val());
		    var attr = {
			  name 			: 	$(mgthr.of_name).val(),
			  duration 		: 	$(mgthr.of_duration).val(),
			  days 			: 	$(mgthr.of_day).val(),
			  facility 		: 	$(mgthr.of_fact).val(),
			  prizing 		: 	$(mgthr.of_price).val(),
			  member 		: 	$(mgthr.of_mem).val(),
			  description 	: 	$(mgthr.of_desc).val(),
			  
		    };
		    $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'addnewoffer',id:id,type:'slave',gymid:id,ofdata:attr},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
            else{	
				   $(mgthr.valid_nm).hide();
				   $(mgthr.valid_duration).hide();
				   $(mgthr.valid_num).hide();
				   $(mgthr.valid_fact).hide();
				   $(mgthr.valid_price).hide();
				   $(mgthr.valid_member).hide();
				   $(mgthr.valid_member).hide();
				   
				}				
			},			
			error:function(){
				alert("there was an error");
			 }
		  });
		  $(loader).hide();   
		}		
          			
			
	 });   	
  };	
  function initializeduration() {
     $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'getallduration',id:id,type:'slave',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
            else{
                $(mgthr.of_duration).html(data);
            	}				
				},			
			error:function(){
				alert("there was an error");
			 }
		  });
  }
  function initializefacility(){
     $.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:'true',action:'getallfact',id:id,type:'slave',gymid:id},
			success: function(data){
				if(data == 'logout')
					window.location.href = URL;
				else{
					$(mgthr.of_fact).html(data);
            	}				
			},			
			error:function(){
				alert("there was an error");
			 }
		  });
  }
  
}
// Account module
function controlAccountFee() {
	var gymid = $(DGYM_ID).attr("name");
	ac = {};
	this.__construct = function(account){
		if("htm" in account)
			ac = account.ac;
		else
			ac = account;
		if(ac.list_type=="offer" && !("htm" in account))
			loadFeeTab();
		if(ac.list_type=="package" && !("htm" in account))
			loadFeeTab();
		if(ac.list_type=="due" && !("htm" in account))
			loadFeeTab();
	}
	this.addModeOfPayment = function(id,num,mop){
        var new_num = num+1;
        $texbox = '';
		for($p=0;$p<=mop.textbox.length;$p++){
				$texbox += '<input name="mod_number_'+id+'_'+new_num+'" type="text" placeholder="'+mop.textbox[$p]+' Number"    id="mop'+mop.id[$p]+'_'+id+'_'+new_num+'"    class="form-control" style="display:none;"/>';
		}
        $('#add_mop_'+id).append(
        '<div class="row" id="usr_fee_row_'+id+'_'+new_num+'">'+
        '<div class="col-lg-12">'+
            '<strong><span id="user_fee_msg_'+id+'_'+new_num+'" style="display:none; color:#FF0000; font-size:25px;">*</span>Fee <i class="fa fa-caret-down"></i></strong>'+
        '</div>'+
        '<div class="col-lg-12">'+
            '<div class="form-group">'+
                '<div class="col-md-4">'+
                    '<select name="mod_pay" id="mod_pay_'+id+'_'+new_num+'" class="form-control">'+
                        '<option value="NULL" selected>Select mode of payment</option>'+mop.htm+'</select>'+
                '</div>'+
                '<div class="col-md-4">'+
                    '<input name="user_fee"   type="text" value="0" id="user_fee_'+id+'_'+new_num+'" class="form-control"/>'+$texbox+'</div>'+
                '<div class="col-md-4">'+
                    '<a id="addmop_'+id+'_'+new_num+'" class="btn btn-primary btn-xs" href="javascript:void(0);">Add</a> '+
                    '<a id="remmop_'+id+'_'+new_num+'" class="btn btn-primary btn-xs" href="javascript:void(0);">Remove</a>'+
                '</div>'+
            '</div>'+
        '</div><div class="col-lg-12">&nbsp;</div>'+
        '</div>');
        
		$("#remmop_"+id+"_"+new_num).on("click",function(){
			var tot = Number($("#keycodes_"+id).text());
			tot -= 1;
			if(tot < 1){
				$("#keycodes_"+id).text(1);
			}
			else{
				$("#keycodes_"+id).text(tot);
			}
			$("#remmop_"+id+"_"+num).show();
			$("#addmop_"+id+"_"+num).show();
			$("#usr_fee_row_"+id+"_"+new_num).remove();
		});
		$("#addmop_"+id+"_"+new_num).on("click",function(evt){
			$("#remmop_"+id+"_"+new_num).hide();
			$(this).hide();
			var obj = new controlAccountFee();
			obj.addModeOfPayment(id,new_num,mop);
		});
		$("#mod_pay_"+id+"_"+new_num).on("change",function(){
			var obj = new controlAccountFee();
			obj.ShowTextBox(new_num,id);
		});
        $('#keycodes_'+id).text(new_num);
    }
	this.ShowTextBox = function(num,id){
        $("input[name='mod_number_"+id+"_"+num+"']").each(function(){
            $(this).hide();
        });
        var mopval = $('#mod_pay_'+id+'_'+num).select().val();
        $('#mop'+mopval+'_'+id+'_'+num).show();
        
    }
    this.AddIndividualFee = function (id,num){
		$(window).unbind();
		$(window).scroll(function(event){
			event.preventDefault();
		});
		var joining_date = $('#joindate_'+id).val();
		var total = $('#amount_'+id).val();
		var email = $('#email_'+id).val();
		var offer = $('#offer_'+id).select().val();
		var max_mop = Number($('#keycodes_'+id).text());
		var amount = new Array();
		var sum_amount = 0;
		var mod_pay = new Array();
		var transaction_type = '';
		/* cheque number, PDC number, Card number */
		var transaction_number = new Array();
		var due_amt = Number($('#bal_amount_'+id).val());
		var due_date = $('#duedate_'+id).val();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var amount_reg = /^[0-9]{0,10}$/;
		var flag = true;
		 //~ console.log("joining_date = "+joining_date);
		 //~ console.log("main total = "+total);
		 //~ console.log("email = "+email);
		 //~ console.log("offer = "+offer);
		 //~ console.log("max_mop = "+max_mop);
		 //~ console.log("due_amt = "+due_amt);
		//~ console.log("due_date = "+due_date);
		 //~ console.log(transaction_type);
		for(i=1;i<=max_mop;i++){
			if($('#user_fee_'+id+'_'+i).length){
				amount[i] = $('#user_fee_'+id+'_'+i).val();
				if(amount[i].match(amount_reg)){
					$('#user_fee_msg_'+id+'_'+i).hide();
					sum_amount += Number(amount[i]);
				}
				else{
					$('#user_fee_msg_'+id+'_'+i).show();
					flag = false;
				}
				mod_pay[i] = $('#mod_pay_'+id+'_'+i).select().val();
				if(mod_pay[i] != 'NULL'){
					$('#user_fee_msg_'+id+'_'+i).hide();
				}
				else{
					$('#user_fee_msg_'+id+'_'+i).show();
					flag = false;
				}
				/* cheque number, PDC number, Card number */
				if(mod_pay[i] != 'NULL'){
					transaction_number[i] = $('#mop'+mod_pay[i]+'_'+id+'_'+i).val();
				}
			}
		}
		if(total.match(amount_reg)){
			$('#amt_msg'+id).hide();
		}
		else{
			$('#amt_msg'+id).show();
			flag = false;
		}
		if(email.match(email_reg)){
			$('#eml_msg'+id).hide();
		}
		else{
			$('#eml_msg'+id).show();
			flag = false;
		}
		if($('#joindate_'+id).val().match(/(\d{4})-(\d{2})-(\d{2})/)){
			$('#joindate_msg'+id).hide();
		}
		else{
			$('#joindate_msg'+id).show();
			flag = false;
		}
		if(offer != 'NULL'){
			$('#offer_msg'+id).hide();
			transaction_type = (offer) ? $('#offer_'+id+' option:selected').html() : 'Gym fee'
		}
		else{
			$('#offer_msg'+id).show();
			flag = false;
		}
		total = Number($('#amount_'+id).val()) +due_amt;
		total1 = Number($('#amount_'+id).val());
		amount.shift();
		transaction_number.shift();
		mod_pay.shift();
		 //~ console.log("main total = "+total);
		 //~ console.log("deducted total = "+total1);
		 //~ console.log("sum total = "+sum_amount);
		 //~ console.log("amount = ");
		 //~ console.log(amount);
		 //~ console.log("mod_pay = ");
		 //~ console.log(mod_pay);
		 //~ console.log("transaction_type = ");
		 //~ console.log(transaction_type);
		 //~ console.log("transaction_number = ");
		 //~ console.log(transaction_number);
		if(sum_amount != total1){
			alert("Total amount does not match with the individual amount !!!");
			flag = false;
		}
		if(due_amt){
			if($('#duedate_'+id).val().match(/(\d{4})-(\d{2})-(\d{2})/)){
				$('#duedate_msg_'+id).hide();
			}
			else{
				$('#duedate_msg_'+id).show();
				flag = false;
			}
		}
		$('#output_load').hide();
		if(flag){
			var payfee = {
				id				:	id,
				num				:	num,
				email			:	email,
				offer			:	offer,
				total			:	total,
				joining_date	:	joining_date,
				amount			:		amount,
				transaction_number	:	transaction_number,
				transaction_type	:	transaction_type,
				mod_pay			:	mod_pay,
				due_amt			:	due_amt,
				due_date		:	due_date,
				fname			:	$("#feeName").text(),
				list_type 		:	$("#list_type").val(),
				fct_type		:	$("#fact_type").val(),
			};
			$('#collapse_'+id).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
			$.ajax({
				type:'POST',
				url:ac.url,
				data:{autoloader:true,action:'AddIndividualFee',type:'slave',gymid:gymid,indfee:payfee},
				success:function(data, textStatus, xhr){
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							data = $.parseJSON($.trim(data));
							//console.log("Data"+data);
							$('#output_load').show();
							console.log('#collapse_'+id+'_'+payfee.list_type);
							$('#collapse_'+id+'_'+payfee.list_type).html(data.msg);
							window.setTimeout(function(){
								$("#print_invoice_"+id).bind("click",function(){
									PayIndividualUserForm(id,num);
									window.open(data.rcpturl);
								});
							},300);
						break;
					}
				},
				error:function(){
					$(loader).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
				}
			});
		}
	}
	this.AddIndividualFeeDue = function (id,num){
		var joining_date = $('#joindate_'+id).val();
		var total = $('#amount_'+id).val();
		var email = $('#email_'+id).val();
		var max_mop = Number($('#keycodes_'+id).text());
		var amount = new Array();
		var sum_amount = 0;
		var mod_pay = new Array();
		var transaction_type = 'Due payment';
		/* cheque number, PDC number, Card number */
		var transaction_number = new Array();
		var due_amt = Number($('#bal_amount_'+id).val());
		var due_date = $('#duedate_'+id).val();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var amount_reg = /^[0-9]{0,10}$/;
		var flag = true;
		 console.log("joining_date = "+joining_date);
		 console.log("main total = "+total);
		 console.log("email = "+email);
		 console.log("max_mop = "+max_mop);
		 console.log("due_amt = "+due_amt);
		 console.log("due_date = "+due_date);
		 console.log(transaction_type);
		for(i=1;i<=max_mop;i++){
			if($('#user_fee_'+id+'_'+i).length){
				amount[i] = $('#user_fee_'+id+'_'+i).val();
				console.log(i+'='+amount[i]);
				if(amount[i].match(amount_reg)){
					$('#user_fee_msg_'+id+'_'+i).hide();
					sum_amount += Number(amount[i]);
				}
				else{
					$('#user_fee_msg_'+id+'_'+i).show();
					flag = false;
				}
				mod_pay[i] = $('#mod_pay_'+id+'_'+i).select().val();
				if(mod_pay[i] != 'NULL'){
					$('#user_fee_msg_'+id+'_'+i).hide();
				}
				else{
					$('#user_fee_msg_'+id+'_'+i).show();
					flag = false;
				}
				/* cheque number, PDC number, Card number */
				if(mod_pay[i] != 'NULL'){
					transaction_number[i] = $('#mop'+mod_pay[i]+'_'+id+'_'+i).val();
				}
			}
		}
		if(total.match(amount_reg)){
			$('#amt_msg'+id).hide();
		}
		else{
			$('#amt_msg'+id).show();
			flag = false;
		}
		if(email.match(email_reg)){
			$('#eml_msg'+id).hide();
		}
		else{
			$('#eml_msg'+id).show();
			flag = false;
		}
		total1 = Number($('#amount_'+id).val());
		amount.shift();
		transaction_number.shift();
		mod_pay.shift();
		 console.log("main total = "+total);
		 console.log("deducted total = "+total1);
		 console.log("sum total = "+sum_amount);
		 console.log(transaction_type);
		if(sum_amount != total1){
			alert("Total amount does not match with the individual amount !!!");
			flag = false;
		}
		if(flag){
			var payfee = {
				id				:	id,
				email			:	email,
				num				:	num,
				total			:	total,
				amount			:	amount,
				transaction_number	:	transaction_number,
				transaction_type	:	transaction_type,
				mod_pay			:	mod_pay,
				fname			:	$("#feeName").text(),
				list_type 		:	$("#list_type").val(),
				fct_type		:	$("#fact_type").val(),
			};
			console.log("due");
			console.log(payfee);
			$('#collapse_'+id).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
			$.ajax({
				type:'POST',
				url:ac.url,
				data:{autoloader:true,action:'AddIndividualFee',type:'slave',gymid:gymid,indfee:payfee},
				success:function(data, textStatus, xhr){
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							data = $.parseJSON($.trim(data));
							//console.log("Data"+data);
							$('#output_load').show();
							$('#userdetails_'+id).html(data.msg);
							window.setTimeout(function(){
								$("#print_invoice_"+id).bind("click",function(){
									$('#userdetails_'+id).html('');
									window.open(data.rcpturl);
								});
							},300);
						break;
					}
				},
				error:function(){
					$(loader).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
				}
			});
		}
	}
	this.SetIndivisualAmt = function (obj,id,num){
        var textofopt = new String();
        var offer_id = $(obj).select().val();
        var max_mop = Number($('#keycodes_'+id).text());
        if(offer_id != 'NULL'){
            textofopt = obj.options[obj.selectedIndex].text;
            textofopt = textofopt.split("-");
            var amt = textofopt[textofopt.length-1];
            var bal_amount = Number($( '#bal_amount_'+id).val());
            amt = Number(amt.replace(" ","")) - bal_amount;
            $('#amount_'+id).val(amt);
            if(amt == 0){
                $('#joindate_'+id).datepicker( "option", "minDate", null);
                $('#bal_amount_'+id).attr('readonly','readonly');
                for(i=1;i<=max_mop;i++){
                    $('#user_fee_'+id+'_'+i).val('0');
                }
            }
            else{
                $('#joindate_'+id).datepicker( "option", "minDate", '0');
                $('#bal_amount_'+id).removeAttr('readonly');
                for(i=1;i<=max_mop;i++){
                    $('#user_fee_'+id+'_'+i).val(amt);
                }
            }
            $('#bal_amount_'+id).bind('keyup',function(e){
                max_mop = Number($('#keycodes_'+id).text());
                var temp = Number($(this).val());
                if(temp >= 0 && temp <= amt){
                    var balance = amt - temp;
                    if(temp == 0){
                        $( '#amount_'+id ).val(amt);
                        for(i=1;i<=max_mop;i++){
                            $('#user_fee_'+id+'_'+i).val(amt);
                        }
                    }
                    else if(balance >= amt || amt < 0){
                        $( '#amount_'+id ).val('0');
                        for(i=1;i<=max_mop;i++){
                            $('#user_fee_'+id+'_'+i).val('0');
                        }
                        $(this).val('0');
                    }
                    else{
                        $('#amount_'+id).val(balance);
                        for(i=1;i<=max_mop;i++){
                            $('#user_fee_'+id+'_'+i).val(balance);
                        }
                    }
                }
                else{
                    $('#amount_'+id ).val(amt);
                    $('#bal_amount_'+id ).val('0');
                    for(i=1;i<=max_mop;i++){
                        $('#user_fee_'+id+'_'+i).val('0');
                    }
                }
            });
        }
        else{
            max_mop = Number($('#keycodes_'+id).text());
            $('#bal_amount_'+id ).val('0');
            $('#amount_'+id ).val('0');
            for(i=1;i<=max_mop;i++){
                $('#user_fee_'+id+'_'+i).val('0');
            }
        }
    }
	function loadFeeTab(){
		var rad = '<ul class="nav nav-tabs" id="dynamicFee">';
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			type:'POST',
			url:ac.url,
			data:{autoloader:true,action:'fetchInterestedIn',type:'slave',gymid:gymid},
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
						var fee = $.parseJSON(data);
						for(i=0;i<fee.length;i++){
							if(i==0)
								rad += '<li class="active"><a href="'+ac.output+'" id="FeeTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';
							else
								rad += '<li><a href="'+ac.output+'" id="FeeTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';
						}
						rad += "</ul>";
						$(ac.feeTab).html(rad);
						$(loader).html('');
						for(i=0;i<fee.length;i++){
							$("#FeeTab"+i).bind('click',{fid:fee[i]["id"],name:fee[i]["name"],sindex:i,ac:ac},function(evt){
								$(ac.ftitle).html(evt.data.name);
								ac = evt.data.ac;
								var para1 = {
									fid			: 	evt.data.fid,
									fname		:	evt.data.name,
									sindex		:	evt.data.sindex,
									list_type 	:	ac.list_type,
									ac 			: 	evt.data.ac,
								}
								console.log(para1);
								displayFeeUserList(para1);
							});
							if(i==0){
								var para1 = {fid:fee[0]["id"],fname:fee[0]["name"],list_type:ac.list_type,sindex:0,ac:ac}
								$(ac.ftitle).html(para1.fname);
								displayFeeUserList(para1);
								
							}
						}
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	}
	function displayFeeUserList(para){
		$(ac.output).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:ac.url,
			type:'POST',
			data:{autoloader:'true',action:'feeUserList',type:'slave',gymid:gymid,fee:para},
			success: function(data){
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$s1 = '<span class="pull-left" id="listUser"><a href="javascript:void(0);" class="btn btn-primary btn-xs" id="list_customer_fee">List Customers</a>'+
								'<input type="hidden" id="fact_type" value="'+para.fid+'">'+
								'<input type="hidden" id="list_type" value="'+para.list_type+'"></span>';
						if(para.list_type=="offer")
							$s1 += '<span class="pull-right" id="listGroup"><a href="javascript:void(0);" class="btn btn-primary btn-xs">List Groups</a></span>';
						$(ac.smenu).html($s1);
						$(ac.output).html(data);
						$(loader).html('');	
						$("#list_customer_fee").bind('click',function(evt){
								displayFeeUserList(para);
						});
						$(window).scroll(function(event){
						if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
								displayFeeUpdateList(para);
							else
								$(loader).html('');
						});					
					break;
				}
			}
		});
	}
	function displayFeeUpdateList(para){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:ac.url,
			type:'POST',
			data:{autoloader:'true',action:'feeUpdateUserList',type:'slave',gymid:gymid,fee:para},
			success: function(data){
			
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$(ac.output).append(data);
						$(loader).html('');	
					break;
				}
			}
		});
	}
	function PayIndividualUserForm(uid,num){
		console.log("Called");
		$(window).unbind();
		$(window).scroll(function(event){
			event.preventDefault();
		});
		var payform = {
				uid				:	uid,
				num				:	num,
				fname			:	$("#feeName").text(),
				fct_type		:	$("#fact_type").val(),
				list_type 		:	$("#list_type").val(),
				ac		:		ac,
		};
		$('#collapse_'+uid).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			type:'POST',
			url:ac.url,
			data:{autoloader:true,action:'PayIndividualUserForm',type:'slave',gymid:gymid,payform:payform},
			success:function(data, textStatus, xhr){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$('#collapse_'+uid+'_'+payform.list_type).html(data);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	}
	function displayPackageUserList(){
		$(ac.output).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		var para = {
			 list_type 	:	ac.list_type,
			 ac			:	ac,
		}
		$.ajax({
			url:ac.url,
			type:'POST',
			data:{autoloader:'true',action:'feeUserList',type:'slave',gymid:gymid,fee:para},
			success: function(data){
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$s1 = '<span class="pull-left" id="listUser"><a href="javascript:void(0);" class="btn btn-primary btn-xs" id="list_customer_fee">List Customers</a>';
						$(ac.smenu).html($s1);
						$(ac.output).html(data);
						$(loader).html('');	
						$("#list_customer_fee").bind('click',function(evt){
								displayPackageUserList();
						});
						$(window).scroll(function(event){
						if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
								 displayPackageUpdateList(para);
							else
								$(loader).html('');
						});					
					break;
				}
			}
		});
	}
	function displayPackageUpdateList(para){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:ac.url,
			type:'POST',
			data:{autoloader:'true',action:'feeUpdateUserList',type:'slave',gymid:gymid,fee:para},
			success: function(data){
				switch(data){
					case "logout":
						logoutAdmin();
						break;
					default:
						$(ac.output).append(data);
						$(loader).html('');	
					break;
				}
			}
		});
	}
	function PayPackageUserForm(uid,num){
		$(window).unbind();
		$(window).scroll(function(event){
			event.preventDefault();
		});
		var payform = {
				uid				:	uid,
				num				:	num,
				fname			:	$("#feeName").text(),
				fct_type		:	$("#fact_type").val(),
				list_type 		:	$("#list_type").val(),
		};
		$('#collapse_'+uid).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			type:'POST',
			url:ac.url,
			data:{autoloader:true,action:'PayPackageUserForm',type:'slave',gymid:gymid,payform:payform},
			success:function(data, textStatus, xhr){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$('#collapse_'+uid).html(data);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	}
}
function controlStaffPay(){
	var gymid = $(DGYM_ID).attr("name");
	pay = {};
	this.__construct = function(payment){
		pay = payment;
		$(pay.paydate).datepicker({
			dateFormat:"yy-mm-dd",
			changeYear: true,
			changeMonth: true,
			yearRange:"date('Y'):(date('Y')+2)"
		});
		$(pay.paydate).datepicker("setDate","date('Y-m-d')");
		addEnqAutoComplete();
		
		$(pay.btn).bind('click',function(evt){
				validatePaymentDetails();
		});
	}
	function addEnqAutoComplete(){
		$.ajax({
			url:pay.url,
			type:'POST',
			data:{autoloader: true,action: 'autoCompletePay',type:'slave',gymid:gymid},
			success:function(data, textStatus, xhr){
				data = $.parseJSON(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					
					default:
						listofPeoples=data.listofPeoples;
						$referred=$("#"+pay.payname);
						$referred.autocomplete({
							minLength: 0,
							source: listofPeoples,
							focus: function( event, ui ) {
							  $referred.val( ui.item.label );
							  return false;
							},
							 select: function( event, ui ) {
								 $referred.val(ui.item.label);
								 $referred.attr('name', ui.item.id);
								return false;
							   },
						});
						$referred.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
							var $li = $('<li>'),
								$img = $('<img>');
							$img.attr({
							  src: item.icon,
							  alt: item.label,
							  width:"30px",
							  height:"30px"
							});

							$li.attr('data-value', item.label);
							$li.append('<a href="#">');
							$li.find('a').append($img).append(item.label);    

							return $li.appendTo(ul);
						};
					break;
				}
			},
			error:function(){
				$(usr.outputDiv).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
	function validatePaymentDetails(){
		var amount = $("#"+pay.amt).val();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var name = $("#"+pay.payname).val();
		var usr_id = $("#"+pay.payname).attr('name');
		var pay_date = ($(pay.paydate).val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $(pay.paydate).val() : "";
		var description = $('#'+pay.dec).val();
		description = description.replace(/\n/g,"<br />").replace(/\r\n/g,"<br />").replace(/\r/g,"<br />");
		var amount_reg = /^[0-9]{1,10}$/;
		var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
		var flag = true;
		
		if(flag){
			var stfpay = {
				name		:	name,
				usr_id		:	usr_id,
				amount		:	amount,
				pay_date	:	pay_date,
				description	:	description,
			};
			console.log(stfpay);
			$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
			$.ajax({
				url:pay.url,
				type:'POST',
				data:{autoloader: true,action: 'AddPayments',type:'slave',gymid:gymid,stfpay:stfpay},
				success:function(data, textStatus, xhr){
					console.log(data);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
						data = $.parseJSON($.trim(data));
						$(pay.alertbody).html(data.msg);
						$(pay.alert).trigger('click');
						$(pay.form).get(0).reset();
						$(loader).html('');
						break;
					}
				},
				error:function(){
					$(loader).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
					
				}
			});
		}
	}
}
function controlClubExpenses(){
	var gymid = $(DGYM_ID).attr("name");
	pay = {};
	this.__construct = function(payment){
		pay = payment;
		$(pay.dt).datepicker({
			dateFormat:'yy-mm-dd',
			changeYear: true,
			changeMonth: true,
			yearRange:'date("Y"):(date("Y")+2)'
		});
		$(pay.dt).datepicker("setDate",'date("Y-m-d")');
		$(pay.btn).bind('click',function(evt){
				validateExpensesDetails();
		});
	
		
	}
	function validateExpensesDetails(){
		var amount = $('#'+pay.amt).val();
		var name = $('#'+pay.name).val();
		var receiptno = $('#'+pay.rpt).val();
		var pay_date = ($(pay.dt).val().match(/(\d{4})-(\d{2})-(\d{2})/)) ? $(pay.dt).val() : "";
		var description = $('#'+pay.dec).val();
		description = description.replace(/\n/g,"<br />").replace(/\r\n/g,"<br />").replace(/\r/g,"<br />");
		var amount_reg = /^[0-9]{1,10}$/;
		var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
		var flag = true;
		if(amount.match(amount_reg)){
			$(pay.amtmsg).hide();
		}
		else{
			$(pay.amtmsg).show();
			flag = false;
		}
		if(name.match(name_reg)){
			$(pay.nmmsg).hide();
		}
		else{
			$(pay.nmmsg).show();
			flag = false;
		}
		if(receiptno.length > 0){
			$(pay.rptmsg).hide();
		}
		else{
			$(pay.rptmsg).show();
			flag = false;
		}
		if(flag){
			
			var exp = {
				name		:	name,
				amount		:	amount,
				receiptno	:	receiptno,
				pay_date	:	pay_date,
				description	:	description,
			}
			console.log(exp);
			$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
			$.ajax({
				url:pay.url,
				type:'POST',
				data:{autoloader: true,action: 'AddExpenses',type:'slave',gymid:gymid,exp:exp},
				success:function(data, textStatus, xhr){
					console.log(data);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
						data = $.parseJSON($.trim(data));
						$(pay.alertbody).html(data.msg);
						$(pay.alert).trigger('click');
						$(pay.form).get(0).reset();
						$(loader).html('');
						break;
					}
				},
				error:function(){
					$(loader).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
					
				}
			});
		}
	}
}
// Stats Module
function controlStatAccount(){
	var gymid = $(DGYM_ID).attr("name");
	sac = {};
	this.__construct = function(stats){
		sac = stats;
		listAccountStats();
	}
	function listAccountStats(){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:sac.url,
			type:'POST',
			data:{autoloader: true,action: 'listAccountStats',type:'slave',gymid:gymid},
			success:function(data, textStatus, xhr){
				console.log(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
					$(sac.output).html(data);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
	
}
function controlStatRegistration(){
	var gymid = $(DGYM_ID).attr("name");
	sac = {};
	this.__construct = function(stats){
		sac = stats;
		listRegistrationStats();
	}
	function listRegistrationStats(){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:sac.url,
			type:'POST',
			data:{autoloader: true,action: 'listRegistrationStats',type:'slave',gymid:gymid},
			success:function(data, textStatus, xhr){
				console.log(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
					$(sac.output).html(data);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
	
}
function controlStatCustomer(){
	var gymid = $(DGYM_ID).attr("name");
	cus = {};
	this.__construct = function(cust){
		cus = cust;
		listRegistrationStats();
	}
	function listRegistrationStats(){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:cus.url,
			type:'POST',
			data:{autoloader: true,action: 'listCustomerStats',type:'slave',gymid:gymid},
			success:function(data, textStatus, xhr){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						data = $.parseJSON($.trim(data));
						console.log(data);
						$(cus.output).html(data.att);
						$(cus.output).append(data.exp);
						var para1 = {
							data1 : data,
							cust : cus,
						}
						$(data.btnmsg).bind('click',{para1},function(evt){
							sendMSG(evt.data.para1);
						});
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
	function sendMSG(para1){
		paraData = para1.data1;
		cus = para1.cust;
		$(paraData.loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:cus.url,
			type:'POST',
			data:{autoloader: true,action: 'sendMsg',type:'slave',gymid:gymid},
			success:function(data, textStatus, xhr){
				$(paraData.loader).html('');
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(cus.alertbody).html('Messages and Emails sent successfully.');
						$(cus.alert).trigger('click');
					break;
				}
			},
			error:function(){
				$(data.loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
}
function controlStatEmployee(){
	var gymid = $(DGYM_ID).attr("name");
	emp = {};
	this.__construct = function(employe){
		emp = employe;
		listEmpStats();
	}
	function listEmpStats(){
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:emp.url,
			type:'POST',
			data:{autoloader: true,action: 'listEmpStats',type:'slave',gymid:gymid},
			success:function(data, textStatus, xhr){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(emp.output).html(data);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
}
//Report module
function controlClubReport() {
	var gymid = $(DGYM_ID).attr("name");
	cb={};
	rbtn={};
	repfrom={};
	repto={};
	this.__construct = function(club){
		cb=club;
		rbtn=club.butrep;
		repfrom=club.from;
		repto=club.to;
		$("html , body").animate({ scrollTop: 0},"fast");
		$(cb.formdata).hide();
		$(cb.labeltitle).show();
		  $( "#rptdatefrom" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			altField: '#alternate_1',
			altFormat: 'DD, d MM, yy',
			maxDate: 0,
			yearRange:'2014:'+(new Date).getFullYear()+''
		});
		
       $( "#rptdateto" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			altField: '#alternate_2',
			altFormat: 'DD, d MM, yy',
			maxDate: 0,
			yearRange:'2014:'+(new Date).getFullYear()+''
		});
		loadClubTab();
	}
	function loadClubTab(){
		var rad = '<ul class="nav nav-tabs" id="dynamicFees">';
		$(loader).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$.ajax({
			type:'POST',
			url:cb.url,
			data:{autoloader:true,action:'fetchInterestedIn',type:'slave',gymid:gymid},
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
						var fee = $.parseJSON(data);
						for(i=0;i<fee.length;i++){
							rad += '<li><a href="'+cb.output+'" id="FeeTabsClub'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';
						}
						rad += "</ul>";
						$(cb.feeTab).html(rad);
						$(loader).html('');
						var para1 = {};
						for(i=0;i<fee.length;i++){
							$("#FeeTabsClub"+i).bind('click',{fid:fee[i]["id"],name:fee[i]["name"],sindex:i,cb:cb},function(evt){
								$("#"+cb.butrep).unbind();
								$(cb.formdata).show();
								$(cb.labeltitle).hide();
								$(cb.ftitle).html(evt.data.name);
								cb = evt.data.cb;
								var para1 = {
									fid			: 	evt.data.fid,
									fname		:	evt.data.name,
									sindex		:	evt.data.sindex,
									list_type 	:	cb.list_type,
									cb 			: 	evt.data.cb,
								}
								console.log(para1);
								$("#"+cb.butrep).bind("click",{para1:para1},function(){
									GenerateReport(para1);
								});
							});
						}
						
						
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	}
	function GenerateReport(para){
		var attrName = '';
		var flag = true;
		var date1 = $('#rptdatefrom').val() ? $('#rptdatefrom').val() : null;
		var date2 = $('#rptdateto').val() ? $('#rptdateto').val() : null;
		if(date1 || date2){
			$('#date_rpt_msg').hide();
		}
		else{
			$('#date_rpt_msg').show();
			flag = false;
		}
		if(flag){
		$('#Television').html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				url:cb.url,
				data:{autoloader:'true',action:'reportClub',type:'slave',gymid:gymid,attrName:para.fid,attrValue:para.fid,date1:date1,date2:date2,fname:para.fname,fid:para.fid},
				type:'POST'
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				$('#Television').html(data);
				$(para.cb.form).get(0).reset();
				$('#printButGen').on("click",function(){
					$('#Television').html('');
				});
				//console.log(data);
			});
			
			
		}
	};
	function reportAdd(){
			var attr = validateEnqFields();
			if(attr){
				$("#"+ead1.repbut).prop('disabled','disabled');
				$(loader).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
				$.ajax({
					url:rep.url,
					type:'POST',
					data:{autoloader: true,action:'reportClub',type:'slave',gymid:gymid,eadd:attr},
					success:function(data, textStatus, xhr){
						data = $.trim(data);
						//console.log(data);
						switch(data){
							case 'logout':
								logoutAdmin({});
							break;
							case 'login':
								loginAdmin({});
							break;
							default:
								$(loader).hide();
								$("#"+ead1.msg).html('<h2>Record success fully added</h2>');
								$("#"+ead1.form).get(0).reset();
							break;
						}
					},
					error:function(){
						$("#"+ead1.msg).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						//console.log(xhr.status);
						window.setTimeout(function(){
							$("#"+ead1.msg).html('');
						},2000);
						$("#"+ead1.repbut).removeAttr('disabled');
					}
				});
			}
			else{
				$("#"+ead.but).removeAttr('disabled');
			}
	};


}
//Receipt report
function controlReceiptReport(){
		receipt={};
		var outputDivRec= " ";
		var gymid = $(DGYM_ID).attr( "name" );
		this.__construct = function(receipt){
		receipt=receipt;
		outputDivRec=receipt.outputDivRec;
		htmlDiv = receipt.htmlDiv;
		$("html , body").animate({ scrollTop: 0}, "fast");
		DisplayReceipt();
		$(receipt.receiptbut).bind('click',function(){
				SearchReceiptReport();
		});
		$( "#by_date" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			altField: '#alternate_1',
			altFormat: 'DD, d MM, yy',
			maxDate: 0,
			yearRange:'2014:'+(new Date).getFullYear()+''
		});
	};

	function SearchReceiptReport(){
		var by_name_o_email = $('#by_name_o_email').val() ? $('#by_name_o_email').val() : "";
		var by_date = $('#by_date').val() ? $('#by_date').val() : "";
		if(by_name_o_email.length > 0 || by_date.length > 0 ){
			$.ajax({
				url: receipt.url,
				type:'POST',
				data:{autoloader:'true',action:'search_rec_list',type:'slave',gymid:gymid,by_name_o_email:by_name_o_email,by_date:by_date},
				success: function(data){
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
								$('#rec_output_load').html("");	
								$("#rec_output").html(data);
						break;
					}
				}
			});
		}
	};
	
	
	
	function DisplayReceipt(){
		$(receipt.outputrec).html('<i class="fa fa-spinner fa-4x fa-spin">');
		$('#output_load').html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
		$.ajax({
			url: receipt.url,
			type:'POST',
			data:{autoloader:'true',action:'DisplayReceipt',type:'slave',gymid:gymid,list_type:'all'},
			success: function(data){
				//console.log(data);
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$('#rec_output_load').html("");	
						$("#rec_output").html(data);
					break;
				}
			}
			});
					
	}

}
//Registration Report
function controlRegistrationReport() {
	var gymid = $(DGYM_ID).attr("name");
	reg={};
	this.__construct = function(para1){
		reg=para1;
		console.log(reg);
		$("html , body").animate({ scrollTop: 0}, "fast");
	 $(reg.dt1).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			altField: '#alternate_1',
			altFormat: 'DD, d MM, yy',
			maxDate: 0,
			yearRange:'2014:'+(new Date).getFullYear()+''
		});
		
       $(reg.dt2).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			altField: '#alternate_2',
			altFormat: 'DD, d MM, yy',
			maxDate: 0,
			yearRange:'2014:'+(new Date).getFullYear()+''
		});
		$(reg.btn).bind('click',function(){
				GenerateRegistrationReport();
		});
		
	}
	function GenerateRegistrationReport(){
		var flag = true;
		var reptype = '';
		var attrName = '';
		var attrValue = '';
		var date1 = $(reg.dt1).val() ? $(reg.dt1).val() : null;
		var date2 = $(reg.dt2).val() ? $(reg.dt2).val() : null;;
		var attrName = reg.type_reports;
		var attrValue = $(DGYM_ID).text();
		if(date1 || date2){
			$('#date_rpt_msg').hide();
		}
		else{
			$('#date_rpt_msg').show();
			flag = false;
		}
		if(flag){
			console.log(attrName);
		$(reg.output).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
			$.ajax({
				url:window.location.href,
				data:{autoloader:'true',action:'reportRegistration',type:'slave',gymid:gymid,attrName:attrName,attrValue:reptype,date1:date1,date2:date2},
				type:'POST'
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				$(reg.output).html(data);
			});
		}
	}
}
//CRM APP
function controlCRMApp(){
	var gymid = $(DGYM_ID).attr("name");
	var ap = {};
	var tbl = $("#output_new_load").attr("name");
	var menudata = '<li id="MCompose"><a href="javascript:void(0);">Compose</a></li><li id="MOutbox"><a href="javascript:void(0);">Outbox</a></li><li id="MExpired"><a href="javascript:void(0);">Expired</a></li><li id="MNoshow"><a href="javascript:void(0);">No show-ups</a></li><li id="MFollow"><a href="javascript:void(0);">Follow-ups</a></li><li id="MStatistics"><a href="javascript:void(0);">Statistics</a></li>';
	this.__construct = function(crmapp){
		ap = crmapp;		 		
		$(ap.hding).text(ap.hdtext);
		listMessage(ap);
		//style="background-color: rgb(192, 192, 192);"
	}
	this.displayMsg = function (ap,index){
		console.log("this disp");
		console.log(ap);
		$(ap.link).html('');
		$(ap.link).html(menudata);
		$(ap.showmsg).siblings().each(function(){
			$(this).html('');
		});
		$(document).ajaxStop();
		$(ap.cout).hide();
		$(ap.showmsg).show();
		$(document).ajaxStop();
		$(ap.showmsg).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$(window).unbind();
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader: true,action:'displayMsg',type:'slave',gymid:gymid,ap:ap,index:index},
			success:function(data, textStatus, xhr){
				$(ap.showmsg).show();
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(ap.showmsg).html(data);
						messageMenu(ap);
						//$("#msg_list").animate({ scrollTop: $("#msg_list")[0].scrollHeight}, 1500);
						$("#close_but").bind("click",function(){
							console.log(ap);
							listMessage(ap);
						});
						
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	}
	this.send_app_msg = function(ap,single,arr_type){
		console.log("this send app");
		console.log(ap);
		$(ap.link).html('');
		$(ap.link).html(menudata);
		var msg_to = new Array();
		var i = 1;
		$("[id='prod_promoter']").each(function(){
			msg_to[i] = $(this).val();
			i++;
		});
		var msg_sub =  $("#msg_sub").val();
		var msg_content =  $("#msg_content").val();
		if(msg_to.length > 0  && msg_content){
			if(single){
				$('#send_but').html('<center><i class="fa fa-spinner fa-4x fa-spin"></i></center>')
			}
			else
				$("#selectedusers_prod").html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
			$.ajax({
				url: window.location.href,
				type:'POST',
				data:{autoloader: true,action:'send_app_msg',type:'slave',gymid:gymid,msg_to:msg_to,msg_sub:msg_sub,msg_content:msg_content,arr_type:arr_type,ap:ap},
				success: function(data){
					$('#output_load').html("");	
					$("#mem_remaining").html(Number($("#mem_remaining").html()) - Number($("#mem_counter").html()));
					$("#mem_sent").html(Number($("#mem_counter").html()) + Number($("#mem_sent").html()));
					$("#mem_counter").html(0);
					$("#selectedusers_prod").html(data);
					if(single){
						var today = new Date();
						var msg = $('#msg_content').val().replace("\n","<br />").replace("\r","<br />").replace("\r\n","<br />").replace("\n\r","<br />");
						$('#msg_list').prepend('<table class="table" cellpadding="8"><tr><td style="position:relative;"><div class="msg_det"><label><strong>sent @ '+today+'</strong></label></div></td></tr><tr><td><div class="bubble">'+msg+'</div></td></tr></table>');
						//$("#msg_list").animate({ scrollTop: $("#msg_list")[0].scrollHeight}, 2500);
						$('#send_but').html('SEND');
					}
					messageMenu(ap);
				}
			});
		}
		else{
			if(msg_to.length == 0)
				alert("Please enter the recipient!!!");
			else if(msg_content.length == 0)
				alert("Please enter the message content!!!");
		}
	}
	function listMessage(ap){
		console.log("list message");
		console.log(ap);
		$(ap.link).html('');
		$(ap.link).html(menudata);
		$(ap.cout).siblings().each(function(){
			$(this).html('');
			$(this).hide();
		});
		$(ap.cout).show();
		$(ap.showmsg).hide();
		$(ap.cout).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');		
		$.ajax({
			url:ap.url,
			type:'POST',
			data:{autoloader: true,action:'loadAllMsg',type:'slave',gymid:gymid,ap:ap},
			success:function(data, textStatus, xhr){
				$(ap.cout).show();
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(ap.cout).html(data);
						messageMenu(ap);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
	function createMessage(id){
		console.log("create message");
		console.log(ap);
		$(ap.link).html('');
		$(ap.link).html(menudata);
		$(window).unbind();
		$('#'+id).siblings().each(function(){
			$(this).html('');
		});
		$('#'+id).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader: true,action:'createMessage',type:'slave',gymid:gymid,ap:ap,id:id},
			success:function(data, textStatus, xhr){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$('#'+id).html(data);
						messageMenu(ap);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	}
	function showGrid(ap,obj,id){
		console.log("list message");
		console.log(ap);
		console.log(obj);
		delete window.listofPeoples;
		delete window.listofimages;
		$(obj).parent().siblings().each(function(){
			$(this).css({backgroundColor:'#FFFFFF'});
		});
		$(obj).parent().css({backgroundColor:'#C0C0C0'});
		$("#message_reslut").hide();
		$('#output_load').html("");	
		$("[class='crm_butt']").each(function(){
			$(this).hide(300);
			if($(this).attr('id') == id)
				$(this).show(600);
		});
		switch(id){
			case 'listMessage':
			console.log('calleds');
				listMessage(ap);
			break;
			case 'crm_statistics':
				load_stats(id);
			break;
			default:
				createMessage(id);
			break;
		}
	}
	function load_stats(id){
		$(ap.link).html('');
		$(ap.link).html(menudata);
		$(window).unbind();
		$('#'+id).siblings().each(function(){
			$(this).html('');
		});
		$('#'+id).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader: true,action:'statistics',type:'slave',gymid:gymid,ap:ap,id:tbl},
			success:function(data, textStatus, xhr){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$('#'+id).html(data);
						messageMenu(ap);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
			}
		});
	}
	function messageMenu(ap){
		var i = 0;
		$("#MCompose").on("click",function(){
			showGrid(ap,this,'createMessage');
		});
		$("#MOutbox").bind("click",function(){
			showGrid(ap,this,'listMessage');
		});
		$("#MExpired").bind("click",function(){
			showGrid(ap,this,'exp_cust');
		});
		$("#MNoshow").bind("click",function(){
			showGrid(ap,this,'tracker_cust');
		});
		$("#MFollow").bind("click",function(){
			showGrid(ap,this,'follow_cust');
		});
		$("#MStatistics").bind("click",function(){
			showGrid(ap,this,'crm_statistics');
		});
	}
}
function controlCRMFeedBack(){
	var gymid = $(DGYM_ID).attr("name");
	var fb = {};
	this.__construct = function(feed){
		fb = feed;
		listFeedback(fb);
		$(fb.tabf).click(function(){
			LoadFeedbackForm();	
		});
		$(fb.tab_tot).click(function(){
			load_total_feedback();	
		});
	}
	this.entryfeedback = function (feedback){
		var FB = feedback;
		var temp={};
		$(FB.save).click(function(){
			entryfeedback();
		});
		function entryfeedback(){
			for(i=0;i<=7;i++){
				temp[i] = $('input[name=feedback_'+i+']:checked').val();
			}
			var feed_values = {
				name			: $(FB.name).val(),
				complent		: $(FB.comp_sugg).val(),
				msg_to			: $(FB.msg_to).val(),
			};
			console.log(temp);
			$.ajax({
				url:FB.url,
				type:'POST',
				data:{autoloader: true,action:'save_feedback',type:'slave',gymid:gymid,fb:feed_values,temp:temp},
				success:function(data, textStatus, xhr){
					console.log(data);
					switch(data){
						case 'logout':
							logoutAdmin({});
						break;
						case 'login':
							loginAdmin({});
						break;
						default:
							if(data){
								$(FB.feedout).html("<h1>successfully Updated</h1>");
							}
							else{
								$(FB.feedout).html('<strong class="text-danger">ERROR!!! The recipient you have entered is not registered customer of GYM</strong>');
							}
						break;
					}
				},
				error:function(){
					$(loader).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					//console.log(xhr.status);
					
				}
			});
		}
	}
	this.displayFeedBack = function (fb,index){
		var fb = fb;
		console.log(fb);
		console.log(index);
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader: true,action:'displayFeedBack',type:'slave',gymid:gymid,fb:fb,index:index},
			success: function(data){
					$(fb.showmsg).html(data);
					$("#back_link").click(function(){
						$(fb.showmsg).html("");
						listFeedback(fb);
					});
			}
		});
	}
	function listFeedback(fb){
		$(fb.fout).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');		
		$.ajax({
			url:fb.url,
			type:'POST',
			data:{autoloader: true,action:'loadAllFeedback',type:'slave',gymid:gymid,fb:fb},
			success:function(data, textStatus, xhr){
				
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(fb.fout).html("");
						$(fb.showmsg).html(data);
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				//console.log(xhr.status);
				
			}
		});
	}
	function LoadFeedbackForm(){
		$(fb.feedout).html('<i class="fa fa-spinner fa-4x fa-spin"></i>');
		$.ajax({
			url:fb.url,
			type:'POST',
			data:{autoloader: true,action:'LoadFeedbackForm',type:'slave',gymid:gymid,fb:fb},
			success:function(data, textStatus, xhr){
				switch(data){
					case 'logout':
						logoutAdmin({});
					break;
					case 'login':
						loginAdmin({});
					break;
					default:
						$(fb.feedout).html("");
						$(fb.loadf).html(data);
						
					break;
				}
			},
			error:function(){
				$(loader).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	}
	function load_total_feedback(){
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{autoloader:true,action:'load_total_feedback',type:'slave',gymid:gymid},
			success: function(data){
				$("#output_total").html(data);
			}
		});
	}
}
//document ready
$(document).ready(function(){
       
		var mainPage	=	{
			navigation	:	".menuAL",
			prefiex		:	"#ctrl",
			defaultView	:	"#ctrlDash",
			outDiv		:	"#output",
		};
		var navigation = {
			DASH		:	"#Dash",
			SDASH		:	"#SingleDash",
			TPF		:	"#profile",		
			
			EONE		:	"#EnquiryAdd",
			ETWO		:	"#EnquiryFollow",
			ETHR		:	"#EnquiryListAll",
			
			CONE		:	"#CustomerAdd",
			CTWO		:	"#CustomerEdit",
			CTHR		:	"#CustomerDel",
			CFOR		:	"#CustomerList",
			CFIVE		:	"#CGroupAdd",
			CSIX		:	"#CGroupEdit",
			CSVN		:	"#CGroupDel",
			CEGT		:	"#CGList",
			CNINE		:	"#CustomerImport",			
			
			TONE		:	"#TrainerAdd",
			TTWO		:	"#TrainerEdit",
			TTHR		:	"#TrainerDel",
			TFOR		:	"#TrainerList",
			TFIVE		:	"#TrainerPay",
			TSIX		:	"#TrainerImport",
			
			MONE		:	"#MarkAtt",
			MTWO		:	"#AddFacility",
			MTHR		:	"#AddOffer",
			MSIX		:	"#ListOffer",
			MSVN		:	"#AddPackage",
			MTEN		:	"#ListPackage",
			
			ACCONE		:	"#Fee",
			ACCTWO		:	"#PackageFee",
			ACCTHR		:	"#StaffPay",
			ACCFIVE		:	"#DueBalance",
			ACCFOR		:	"#ClubExpenses",
			
			STONE		:	"#StAccount",
			STTWO		:	"#StRegistrations",
			STTHR		:	"#StCustomers",
			STFOR		:	"#StEmployee",
			
			RONE		:	"#RClub",
			RTWO		:	"#RPackage",
			RTHR		:	"#RRegistrations",
			RFOR		:	"#RPayments",
			RFIVE		:	"#RExpenses",
			RSIX		:	"#RBalanceSheet",
			RSVN		:	"#RCustomers",
			REGT		:	"#REmployee",
			RNINE		:	"#RReceipts",
			
			CRMONE		:	"#CRMAPP",
			CRMTWO		:	"#CRMEmail",
			CRMTHR		:	"#CRMsms",
			CRMFOR		:	"#CRMFeedback",
			CRMFIVE		:	"#CRMExpiry",
		};
		function hideMajorDivs(){
			$(mainPage.navigation).each(function(){
				$(mainPage.prefiex+$(this).attr('id')).hide();
			});
			$(mainPage.navigation).each(function(){
				$(this).click(function(evt){
					$(mainPage.prefiex+evt.target.id).show();
					return;
				});
			});
		};
		$(navigation.DASH).click(function(){
//			//console.log('I am in DASHBOARD');
			var dashboard={
				suboutdiv	:"#dashboardcontent",
				url 		: window.location.href,
			};
			hideMajorDivs();
			var obj = new load_dashboard();
			obj.__construct(dashboard);
		});
		$(navigation.SDASH).click(function(){
//			//console.log('I am in DASHBOARD');
			var dashboard={
				outdiv	:	"#singledashOutput",
				nm			:	"#dashname",
				url 		: window.location.href,
			};
			hideMajorDivs();
			var obj = new loadSingleDash();
			obj.__construct(dashboard);
		});
		
		$(navigation.TPF).click(function(){
			//console.log('I am in PRFILE');
			var emailids = {
				parentDiv : "#pfmultiple_email",
				num   	  : -1,
				form 	  : "#pfemail_id_",
				email 	  : "#pfemail_",
				msgDiv 	  : "#pfemail_msg_",
				plus 	  : "#pfplus_email_",
				minus 	  : "#pfminus_email_"
			};
			var cnumbers = {
				parentDiv : "#pfmultiple_cnumber",
				num   	  : -1,
				form 	  : "#pfcnumber_",
				codep 	  : "#pfccode_",
				nump 	  : "#pfcnum_",
				msgDiv 	  : "#pfcnum_msg_",
				plus 	  : "#pfplus_cnumber_",
				minus 	  : "#pfminus_cnumber_"
			};
			var user_addAddress = {
				country 		: '#gym_country',
				countryCode 	: null,
				countryId 		: null,
				comsg 			: '#gym_comsg',
				province 		: '#gym_province',
				provinceCode	: null,
				provinceId 		: null,
				prmsg 			: '#gym_prmsg',
				district 		: '#gym_district',
				districtCode	: null,
				districtId 		: null,
				dimsg 			: '#gym_dimsg',
				city_town 		: '#gym_city_town',
				city_townCode	: null,
				city_townId 	: null,
				citmsg 			: '#gym_citmsg',
				st_loc 			: '#gym_st_loc',
				st_locCode 		: null,
				st_locId 		: null,
				stlmsg 			: '#gym_stlmsg',
				addrs 			: '#gym_addrs',
				admsg 			: '#gym_admsg',
				cnumber 		: cnumbers,
				telenumber 		: '#gym_telenumber',
				telemsg 		: '#gym_telenumber_msg',
				zipcode 		: '#gym_zipcode',
				zimsg 			: '#gym_zimsg',
				website 		: '#gym_website',
				wemsg 			: '#gym_wemsg',
				tphone 			: '#gym_telephone',
				pcode 			: '#gym_pcode',
				tpmsg 			: '#gym_tp_msg',
				gmaphtml 		: '#gym_gmaphtml',
				gmmsg 			: '#gym_gmmsg',
				lat 			: null,
				lon 			: null,
				timezone 		: null,
				PCR_reg 		: null,
				url				: URL+'address.php'
			};
			var add_gym	=	{
				form		:	"#addgymForm",
				name		:	"#gym_name",
				fee		:	"#gym_fee",
				tax		:	"#gym_tax",
				but		:	"#addgymBut",
				acs_id 		: 	'#acs_id',
				ac_msg 		: 	'#ac_msg',
				em		:	emailids,
				cn		:	cnumbers,
				address		:	user_addAddress
			};
			var profileDivs = {
				pfoutDiv		:	"#admin_profile",
				gymoutDiv		:	"#gym_profile",
				apfoutDiv		:	"#add_profile",
				pftab			:	"#profile",
				url 			: 	window.location.href,
				addgym			:	add_gym,
				
			};
			hideMajorDivs();
			var obj = new controlProfile();
			obj.__construct(profileDivs);
		});
		//---------------------------------ENQ-------------------------------
		// Add enq
		$(navigation.EONE).click(function(){
			//console.log('I am in ADD ENQ');
			var enqadd = {
				form			: "enquiry_form",
				refer			: "ref_box",
				lrefer			: "list_ref",
				handel			: "handel_box",
				lhandel			: "list_handel",
				vname			: "eq_name",
				vnmsg			: "eq_name_msg",
				email			: "enq_email",
				emsg			: "enq_em_msgDiv",
				ccode			: "enq_codep",
				cdmsg			: "cdmsg",
				cell			: "enq_cnumber",
				cmsg			: "cmsg",
				fgoal			: "ft_goal",
				cmt				: "comments",
				f1				: "followup1",
				f2				: "followup2",
				f3				: "followup3",
				knwabt			: "knowabout",
				instin			: "interested",
				jop				: "jop",
				but				: "enquiry_save",
				msg				: "enq_add_msg",
				
			}
			var enqDivs = {
				url 			: 	window.location.href,
				add				:	enqadd,
			};
			hideMajorDivs();
			var obj = new controlEnquiry();
			obj.__construct(enqDivs);
		});
		//today followups
		$(navigation.ETWO).click(function(){
			var follow1 = {
				tab		:	"tFollowTab",
			}
			var follow2 = {
				tab		:	"pFollowTab",
			}
			var follow3 = {
				tab		:	"exFollowTab",
			}
			var listenq = {
				output		:	"#followOutput",
				url 		: 	window.location.href,
				tflw		:	follow1,	
				pflw		:	follow2,
				exflw		:	follow3,
			}
			hideMajorDivs();
			var obj = new controlEnquiryFollow();
			obj.__construct(listenq);
		});
		//List All
		$(navigation.ETHR).click(function(){
			//console.log('I am in Enq All');
			
		
			var list = {
				menuDiv:'#menuHtml',
				htmlDiv:'#searhHtml',
				outputDiv:'#output',
				OptionsSearch:{
					"Enquiry":true,
					"Group":false,
					"Personal":false,
					"Offer":false,
					"Package":false,
					"Date":false,
					"All":false
				},
				SearchAllHide:{
					"Enquiry_ser_all":false,
					"Group_ser_all":true,
					"Personal_ser_all":true,
					"Offer_ser_all":true,
					"Package_ser_all":true,
					"Date_ser_all":true
				},
				output	:	"#ctEnquiryAllOutput",
			}
			var enq = {
				loader	:	"#center_loader",
				url		: window.location.href,
				list	:	list,
			}
			hideMajorDivs();
			var obj = new controlEnquiryListAll();
			obj.__construct(enq);
		});
		//--------------------------- customer-------------------------------
		//Add customer
		$(navigation.CONE).click(function(){
			console.log('I am in ADD Customer');
			var emailids = {
				parentDiv	: "#cadmultiple_email",
				num   	   : -1,
				form 	  		: "#cademail_id_",
				email 	   : "#cademail_",
				msgDiv 	   : "#cademail_msg_",
				plus 	  		: "#cadplus_email_",
				minus 	   : "#cadminus_email_"
			};
			var cnumbers = {
				parentDiv : "#cadmultiple_cnumber",
				num   	  : -1,
				form 	  : "#cadcnumber_",
				codep 	  : "#cadccode_",
				nump 	  : "#cadcnum_",
				msgDiv 	  : "#cadcnum_msg_",
				plus 	  : "#cadplus_cnumber_",
				minus 	  : "#cadminus_cnumber_"
			};
			var feerow = {
            plus				:	"#addfee_plus_",
            minus				:	"#addfee_minus_",
            num				:	1,
            parentdiv		:	"#usr_fee_row_temp_",
            addfeeform		:	"#newaddpaymentbox_",
            			
			};
			var custDivs = {
				em					:	emailids,
				cn					:	cnumbers,
				outDiv			:  "#refergynname",
				mofpayment		:	"#mod_pay_temp_01",
				modselect		:	"#mod_pay_select_01",
				feetemp_input	:	"#user_fee_temp_01",
				number_box		:	"#add_numerbox_",
				mofpaymentd		:	"#mod_pay_temp_",
				fee_input		:	"#user_fee_temp_",
				paymentrow		:	feerow,
				referBox			:	"#ref_boxadd",
				serach1			:	"temp_serach",
				custsexParent	:	"#cust_sexParent",
			};
			hideMajorDivs();
			var obj = new controlCustomer();
			obj.__construct(custDivs);
		});
		//edit customer
		$(navigation.CTWO).click(function(){
			console.log('I am in EDIT Customer');
			hideMajorDivs();
		});
		//del customer
		$(navigation.CTHR).click(function(){
			console.log('I am in DEL Customer');
			hideMajorDivs();
		});
		//list customer
		$(navigation.CFOR).click(function(){
			console.log('I am in List Customer');
			hideMajorDivs();
		});
		//add group
		$(navigation.CFIVE).click(function(){
			console.log('I am in ADD GRP');
			var addgroupmember = {
				parentDiv    	: "#accordion1",
				parentpanelid	: "#parentpanelid_",
				num   	  		:  2,
				panelid   		: "#cadplus_member_",
				prefix	  		: "cadplus_member_",
				plus 	  	  		: "#cadplus_groupmember_",
				minus 	  		: "#cadminus_groupmember_",
				membership		: "#group_membership",
				memradioid		: "#group_type_",
				memradiospan	: "#memradiospan_",
				outDiv			: "#refergymname",
				coupletypeId	: "#group_type_1",
				grouptypeId 	: "#group_type_2",				
			}; 
			var customerDivs = {
				agu				:	addgroupmember,
    		};
			hideMajorDivs();
			var obj = new controlCustomerFIVE();
			obj.__construct(customerDivs);
		});
		//edit grp
		$(navigation.CSIX).click(function(){
			console.log('I am in edit grp');
			hideMajorDivs();
		});
		//del grp
		$(navigation.CSVN).click(function(){
			console.log('I am in del grp');
			hideMajorDivs();
		});
		//list grp
		$(navigation.CEGT).click(function(){
			console.log('I am in list grp');
			hideMajorDivs();
		});
		//import customer
		$(navigation.CNINE).click(function(){
			console.log('I am in import customer');
			hideMajorDivs();
		});
		//---------------------------------Trainer------------------------------
		// Add Trainer
		$(navigation.TONE).click(function(){
		//	console.log('I am in ADD Trainer');
			var trainerAdd = {
				form	: "trainerdetails",
				name	: "trainer_name",
				nmsg	: "name_msg",
				sex		: "trainer_sex",
				smsg	: "sex_msg",
				email	: "trainer_email",
				emsg	: "email_msg",
				mobile	: "trainer_mobile",
				mmsg	: "mobile_msg",
				ccode	: "cell_code",
				cmsg	: "cell_msg",
				ftype	: "trainer_facility",
				fmsg	: "ftype_msg",
				ttype	: "trainer_gym",
				tmsg	: "ttype_msg",
				but		: "trainerAdd",
				dob		: "dob",
				doj		: "doj",
				msg		: "trainer_add_msg",
				phupload: "photo_but_edit",
				phbody	: "myModal_Photo",
			}
			
			hideMajorDivs();
			var obj = new controlTrainer();
			obj.__construct(trainerAdd);
		});
		// List Trainer
		$(navigation.TTWO).click(function(){
			console.log('i m here to list trainer');
			hideMajorDivs();
			var obj = new controlListTrainer();
			obj.__construct();
		});
		// Pay Trainer
		$(navigation.TTHR).click(function(){
			//console.log('I am in pay Trainer');
		 var trapay = {
			 output		:	"#trainerPayoutput",
			 url 		: 	window.location.href,
			 paydate	:	"#tra_pay_date",
			 payname	:	"trainer_payname",
			 nmmsg		:	"#names_msg",
			 amt		:	"amount",
			 amtmsg		:	"#amts_msg",
			 dec		:	"trainer_description",
			 alertbody  :	"#myModal_paybody",
			 alert		:	"#myModal_paybtn",
			 form		:	"#trainer_payform",
			 btn		:	"#trainer_paySave",
		 };         				
			hideMajorDivs();	
			 var obj = new controlTrainerPay();
			 obj.__construct(trapay);
		});
		// Import Trainer
		$(navigation.TFOR).click(function(){
			//console.log('I am in Expried');
			var trainerImport = {
				ftype	: "import_facility",
				fmsg	: "ftype_import_msg",
				ttype	: "import_gym",
				tmsg	: "ttype_import_msg",
			}
			hideMajorDivs();
			 var obj = new controlTrainerImport();
			 obj.__construct(trainerImport);
		});
		//List All
		$(navigation.TFIVE).click(function(){
			//console.log('I am in List All');
			hideMajorDivs();
		});
		//List All
		$(navigation.TSIX).click(function(){
			//console.log('I am in List All');
			hideMajorDivs();
		});
		//=========================================Manage==================
		$(navigation.MONE).click(function(){
			var attend = {
			   customer_att			:	"#customer_att",
			   employee_att			:	"#employee_att",
			   pillpanel_li			:	"#panel_li",
			   pillpanel_div		:	"#panel_div",
			   output				:	"#attOutput",
			   panelheading			:	"#panelheading",
			   st_panel				:	"#dympanel",
			   allattTab			:	"#attTab",
			   referPage			:	navigation.MONE,
			};
			hideMajorDivs();
			var obj	= new controlManage();
			obj.__construct(attend);			
		});
		$(navigation.MTWO).click(function(){
			var addFact = {
            showfacti		:	"#ctctShowFacility",
            addnewFact		:	"#addnewfacility",
            plusfact			:	"#addfactPLUS",
            minusfact		:	"#addfactMINUS",
            factBtn			:	"#facilitysave",
            factName			:	"#factname",
            factstVal		:	"#factstvalue",
            referpage		:	navigation.MTWO,
            hidefact		   :	"#hiddenfact",
            allfact			:	"#showallfact",
            showstatus		:	"#showstatus",		
			};		
			hideMajorDivs();
			var obj = new controlManageTwo();
			obj.__construct(addFact);			
		});
		
		$(navigation.MTHR).click(function(){
			 var offeradd = {
			   of_fact			:	"#of_facility",
			   of_duration		:	"#of_duration",
			   offerADbtn		:	"#offersave",
			   of_day			:	"#of_no_days",
			   valid_num		:	"#valid_num",
			   of_price			:	"#of_prize",
			   valid_price		:	"#valid_price",
			   valid_nm			:	"#valid_nm",
			   valid_duration	:	"#valid_duration",
			   valid_fact		:	"#valid_fact",
			   valid_member		:	"#valid_member",
			   of_name			:	"#of_name",
			   of_desc			:	"#of_des",
			   of_mem			:	"#of_member",			 
			 };         				
				hideMajorDivs();	
				var obj = new controlManageThr();
				obj.__construct(offeradd);
		});
		
		$(navigation.MSIX).click(function(){
			console.log('I am in list offer');
			hideMajorDivs();
	    });
	    $(navigation.MSVN).click(function(){
			console.log('I am in add package');
			hideMajorDivs();
	    });
	    $(navigation.MTEN).click(function(){
			console.log('I am in list package');
			hideMajorDivs();
	    });
		//---------------------------------Account------------------------------
		// Facility Fee
		$(navigation.ACCONE).click(function(){
			
			 var account = {
				 output		:	"#outputfee",
				 url 		: 	window.location.href,
				 feeTab		:	"#dynamicFee",
				 ftitle		:	"#feeName",
				 smenu		:	"#feeSubMenu",
				 list_type 	:	"offer",	 
			 };         				
				hideMajorDivs();	
				var obj = new controlAccountFee();
				obj.__construct(account);
		});
		//package fee
		$(navigation.ACCTWO).click(function(){
			 var package = {
				 output		:	"#listUserPackage",
				 url 		: 	window.location.href,
				 smenu		:	"#btnListPackage",
				list_type 	:	"package",
			 };         				
				hideMajorDivs();	
				 var obj = new controlAccountFee();
				 obj.__construct(package);
		});
		//balance due fee
		$(navigation.ACCFIVE).click(function(){
			 var due = {
				 output		:	"#outputDueBalance",
				 url 		: 	window.location.href,
				 feeTab		:	"#dynamicDueBalance",
				 ftitle		:	"#DueBalanceName",
				 smenu		:	"#DueBalanceSubMenu",
				 list_type 	:	"due",
			 };         				
				hideMajorDivs();	
				 var obj = new controlAccountFee();
				 obj.__construct(due);
		});
		//staff payment
		$(navigation.ACCTHR).click(function(){
			 var stfpay = {
				 output		:	"#StaffPayoutput",
				 url 		: 	window.location.href,
				 paydate	:	"#st_pay_date",
				 payname	:	"payname",
				 nmmsg		:	"#name_msg",
				 amt		:	"amount",
				 amtmsg		:	"#amt_msg",
				 dec		:	"description",
				 alertbody  :	"#myModal_paybody",
				 alert		:	"#myModal_paybtn",
				 form		:	"#payform",
				 btn		:	"#paySave",
			 };         				
				hideMajorDivs();	
				 var obj = new controlStaffPay();
				 obj.__construct(stfpay);
		});
		//staff payment
		$(navigation.ACCFOR).click(function(){
			 var exp = {
				 url 		: 	window.location.href,
				 form		:	"#frmexp",
				 name		:	"expname",
				 nmmsg		:	"#expnm_msg",
				 amtmsg		:	"#expamt_msg",
				 amt		:	"expamount",
				 rptmsg		:	"#exprpt_msg",
				 rpt		:	"exprpt_no",
				 dt			:	"#exppay_date",
				 dec		:	"expdescription",
				 alertbody  :	"#myModal_expbody",
				 alert		:	"#myModal_expbtn",
				 btn		:	"#expsave",
			 };         				
				hideMajorDivs();	
				 var obj = new controlClubExpenses();
				 obj.__construct(exp);
		});
		
		//---------------------------------Stats------------------------------
		//
		$(navigation.STONE).click(function(){
			var sacc = {
				 url 		: 	window.location.href,
				 output		:	"#ctStAccount",
			};         				
			hideMajorDivs();	
			
			var obj = new controlStatAccount();
			obj.__construct(sacc);
		});
		//
		$(navigation.STTWO).click(function(){
			var reg = {
				 url 		: 	window.location.href,
				 output		:	"#ctStRegistrations",
			};         				
			hideMajorDivs();	
			
			var obj = new controlStatRegistration();
			obj.__construct(reg);
		});
		//
		$(navigation.STTHR).click(function(){
			var cust = {
				 url 		: 	window.location.href,
				 output		:	"#StCustomersoutput",
				 alertbody  :	"#myModal_custbody",
				 alert		:	"#myModal_custbtn",
			};         				
			hideMajorDivs();	
			var obj = new controlStatCustomer();
			obj.__construct(cust);
		});
		//
		$(navigation.STFOR).click(function(){
			var emp = {
				 url 		: 	window.location.href,
				 output		:	"#stEmpoutput",
			};         				
			hideMajorDivs();	
			var obj = new controlStatEmployee();
			obj.__construct(emp);	
		});
		//---------------------------------Reports------------------------------
		//Club report
		$(navigation.RONE).click(function(){
				 var club = {
						 url 		: 	window.location.href,
						 output		:	"#outputClub",
						 feeTab		:	"#dynamicFees",
						 ftitle		:	"#ClubName",
						 smenu		:	"#ClubSubMenu",
						 list_type 	:	"offer",	 
						 form		:	"#reportform",
						 butrep		: 	"genrep",
						 formdata	:	"#outputreport",
						 labeltitle	:	"#fromToTitle",	
				 };
				hideMajorDivs();	
				var obj = new controlClubReport();
				obj.__construct(club);
		});
		//Package Report
		$(navigation.RTWO).click(function(){
				  var arg = {
						 url 		: 	window.location.href,
						 form		:	"#pacform",
						 dt1		:	"#pacdate1",
						 dt2		:	"#pacdate2",
						 btn 		: 	"#pacbutton",
						 output		:	"#pacOutput",
						 type_reports	: "PackageReport",
						 key		:	"pr",

						 
				 };
				hideMajorDivs();	
				var obj = new controlRegistrationReport();
				obj.__construct(arg);
		    				
					
				
		});
		//Registration Report
		$(navigation.RTHR).click(function(){
			 var arg = {
						 url 		: 	window.location.href,
						 form		:	"#regform",
						 dt1		:	"#regdate1",
						 dt2		:	"#regdate2",
						 btn 		: 	"#regbutton",
						 output		:	"#regOutput",
						 type_reports	: "RegistrationReport",
						 key		:	"rg",

						 
				 };
				hideMajorDivs();	
				var obj = new controlRegistrationReport();
				obj.__construct(arg);
				
		});
		//Payments Report
		$(navigation.RFOR).click(function(){
				var arg = {
						  url 		: 	window.location.href,
						 form		:	"#payform",
						 dt1		:	"#paydate1",
						 dt2		:	"#paydate2",
						 btn 		: 	"#paybutton",
						 output		:	"#payOutput",
						 type_reports	: "PaymentsReport",
						 key		:"py",
				 };
				hideMajorDivs();	
				var obj = new controlRegistrationReport();
				obj.__construct(arg);
		});
		//Expences Report
		$(navigation.RFIVE).click(function(){
				var arg = {
						url 		: 	window.location.href,
						 form		:	"#expform",
						 dt1		:	"#expdate1",
						 dt2		:	"#expdate2",
						 btn 		: 	"#expbutton",
						 output		:	"#expOutput",
						 type_reports	: "ExpensesReport",
						 key		:"ex",
				 };
				hideMajorDivs();	
				var obj = new controlRegistrationReport();
				obj.__construct(arg);	
		});
		//Balance Sheet Report
		$(navigation.RSIX).click(function(){
				var arg = {
							url 		: 	window.location.href,
						 form		:	"#balform",
						 dt1		:	"#baldate1",
						 dt2		:	"#baldate2",
						 btn 		: 	"#balbutton",
						 output		:	"#balOutput",
						 type_reports	: "BalanceSheet",
						 key		:	"bs",
				 };
				hideMajorDivs();	
				var obj = new controlRegistrationReport();
				obj.__construct(arg);	
		});
		//Customer Report
		$(navigation.RSVN).click(function(){
				 var arg = {
						 url 		: 	window.location.href,
						 form		:	"#custform",
						 dt1		:	"#custdate1",
						 dt2		:	"#custdate2",
						 btn 		: 	"#custbutton",
						 output		:	"#custOutput",
						 type_reports	: "CustomerAttendanceReport",
						 key		:	"ca",

						 
				 };
				hideMajorDivs();	
				var obj = new controlRegistrationReport();
				obj.__construct(arg);
		});
		//Employee Report
		$(navigation.REGT).click(function(){
				 var arg = {
						 url 		: 	window.location.href,
						 form		:	"#empform",
						 dt1		:	"#empdate1",
						 dt2		:	"#empdate2",
						 btn 		: 	"#empbutton",
						 output		:	"#empOutput",
						 type_reports	: "TrainerAttendanceReport",
						 key		:	"ta",

						 
				 };
				hideMajorDivs();	
				var obj = new controlRegistrationReport();
				obj.__construct(arg);
		});
		//Receipt Report
		$(navigation.RNINE).click(function(){
			var receipt = {
                                url 		    : 	window.location.href,
                                outputDivRec	:	'#rec_output_display',
                                outputrec		:	"#rec_output",
                                receiptbut		:	"#receiptButton"
				};
				hideMajorDivs();	
				var obj = new controlReceiptReport();
				obj.__construct(receipt);
		});
		//---------------------------------CRM------------------------------
		//
		$(navigation.CRMONE).click(function(){
			$("#output_new_load").attr("name","crm_messages");
			var app = {
				 cout		:	"#listMessage",
				 showmsg	:	"#show_messages",
				 output		:	"#crmapp",
				 tbl		:	"crm_messages",
				 hding		:	"#crmtitle",
				 hdtext		:	"Mobile App Manager",
				 link		: 	"#MSGmenu", 
				 url 		: 	window.location.href,
			 };         				
				hideMajorDivs();	
				var obj = new controlCRMApp();
				obj.__construct(app);	
		});
		//
		$(navigation.CRMTWO).click(function(){
			$("#output_new_load").attr("name","crm_email");
			var links = {
				one		:"#MCompose",
				two		:"#MOutbox",
				thr		:"#MExpired",
				four	:"#MNoshow",
				five	:"#MFollow",
				six		:"#MStatistics",
			}
			var app = {
				 cout		:	"#listMessage",
				 showmsg	:	"#show_messages",
				 output		:	"#crmapp",
				 tbl		:	"crm_email",
				 hding		:	"#crmtitle",
				 hdtext		:	"Email Manager",
				 link		: 	links,
				 url 		: 	window.location.href,
			 };         				
				hideMajorDivs();
				$('#ctrlCRMAPP').show();
				var obj = new controlCRMApp();
				obj.__construct(app);	
		});
		//
		$(navigation.CRMTHR).click(function(){
			$("#output_new_load").attr("name","crm_sms");
			var links = {
				one		:"#MCompose",
				two		:"#MOutbox",
				thr		:"#MExpired",
				four	:"#MNoshow",
				five	:"#MFollow",
				six		:"#MStatistics",
			}
			var app = {
				 cout		:	"#listMessage",
				 showmsg	:	"#show_messages",
				 output		:	"#crmapp",
				 tbl		:	"crm_sms",
				 hding		:	"#crmtitle",
				 hdtext		:	"SMS Manager",
				 link		: 	links,
				 url 		: 	window.location.href,
			 };         				
				hideMajorDivs();
				$('#ctrlCRMAPP').show();
				var obj = new controlCRMApp();
				obj.__construct(app);	
		});
		//
		$(navigation.CRMFOR).click(function(){
			var feed = {
				 fout 	 : "#output_load1",
				 showmsg : "#app_msg_history",
				 feedout : "#output_load2",
				 loadf	 : "#LoadFeedbackForm",
				 tabf	 : "#feedback_form",
				 tab_tot : "#total_msg",
				 save_msg: "#msgdiv",
				 url   	 : 	window.location.href,
			};
			hideMajorDivs();
			var obj = new controlCRMFeedBack();
			obj.__construct(feed);
		});
		//
		$(navigation.CRMFIVE).click(function(){
				hideMajorDivs();	
		});
		
		$(navigation.DASH).trigger('click');
		$(mainPage.defaultView).show();
});
