function admincollectionctrl(){
	var colls = {};
	var listColletrs = {};
	var listofUsers = {};
	var listofProducts = {};
	var listofPattys = {};
	var listofcolls = {};
	var listofMOPtypes = {};
	var listofBankAC = {};
	this.__construct = function(cctrl){
		colls = cctrl;
		$(colls.add.cdate+' , '+colls.add.duedate).datepicker({
			dateFormat: 'yy-mm-dd',
			yearRange:'2014:'+Number(new Date().getFullYear())+2,
		});
		$(colls.add.but).click(function(){
				addPayments();
		});
		$(colls.list.menuBut).click(function(){
				$(colls.msgDiv).html('');
				DisplayCollsList();
			});
		$(colls.add.pamt).change(function(){
			if($(colls.add.pamt).val().match(ind_reg)){
				$(colls.add.pamsg).html(VALIDNOT);
			}
			else{
				$(colls.add.pamsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(colls.add.pamsg).offset().top)-95}, "slow");
				$(colls.add.pamt).show().focus();
				return;
			}
			var amtpaid = $(colls.add.pamt).val();
			if(amtpaid < 0){
				$(colls.add.pamt).val(0);
			}
		});
		$(colls.add.amtpaid+' , '+colls.add.pamt).change(function(){
			console.log("changed");
			var totamt = Number($(colls.add.pamt).val());
			var pad = Number($(colls.add.amtpaid).val());
			var due = 0;
			if(totamt > pad)
				due = Number(totamt-pad);
			console.log(due);
			$(colls.add.amtdue).val(due);
			$(colls.add.admsg).html(ntow(due));
		});
		fetchDistributor();
		fetchMOPTypes();
	};
	function fetchDistributor(){
		var rad = '';
			$.ajax({
				type:'POST',
				url:window.location.href,
				data:{autoloader:true,action:'fetchDistributor',type:'master'},
				success:function(data, textStatus, xhr){
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
							var type = $.parseJSON(data);
							listofcolls = type;
							for(i=0;i<type.length;i++){
								rad += type[i]["html"];
							}
							$(colls.add.user).html('<option value="NULL" selected>Select Payeer</option>'+rad);
							
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
	}
	function fetchMOPTypes(){
			var rad = '';
			$(colls.add.acdiv).hide();
			$.ajax({
				type:'POST',
				url:colls.url,
				data:{autoloader:true,action:'fetchMOPTypes',type:'master'},
				success:function(data, textStatus, xhr){
					console.log(data);
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
							var type = $.parseJSON(data);
							listofMOPtypes = type;
							for(i=0;i<type.length;i++){
								rad += type[i]["html"];
							}
							$(colls.add.mopdiv).html('<select class="form-control" id="'+ colls.add.mop +'"><option value="NULL" selected>Select Mode of payment</option>'+rad+'</select><p class="help-block" id="'+colls.add.mopmsg+'">Enter/ Select.</p>');
							$(document.getElementById(colls.add.mop)).change(function(){
								//fetchBankAccount(colls.add);
								$(colls.add.acdiv).hide();
							});
						break;
					}
				},
				error:function(){
					$(colls.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
		};
	function addPayments(){
			$(colls.msgDiv).html('');
			var account = {};
			console.log(colls.add.select);
			var totamt = Number($(colls.add.pamt).val());
			var pad = Number($(colls.add.amtpaid).val());
			var due = 0;
			if(totamt > pad)
				due = Number(totamt-pad);
			///* Payer */
			//if(colls.add.select.pid  > 0 && colls.add.select.pindex > -1){
				//flag = true;
				//$(colls.add.usr_msg).html(VALIDNOT);
			//}
			//else{
				//flag = false;
				//$(colls.add.usr_msg).html(INVALIDNOT);
				//$('html, body').animate({scrollTop: Number($(colls.add.usr_msg).offset().top)-95}, "slow");
				//$(colls.add.user).focus();
				//return;
			//}
			///* Payer */
			//if(colls.add.uid  > 0 && colls.add.uind  > -1){
				//flag = true;
				//$(colls.add.usr_msg).html(VALIDNOT);
			//}
			//else{
				//flag = false;
				//$(colls.add.usr_msg).html(INVALIDNOT);
				//$('html, body').animate({scrollTop: Number($(colls.add.usr_msg).offset().top)-95}, "slow");
				//$(colls.add.user).focus();
				//return;
			//}
			/* Date of payment */
			if($(colls.add.cdate).val().match(/(\d{4})-(\d{2})-(\d{2})/)){
				flag = true;
				$(colls.add.cdmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(colls.add.cdmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(colls.add.cdmsg).offset().top)-95}, "slow");
				$(colls.add.cdate).focus();
				return;
			}
			/* Mode of payment */
			var mop = $('#'+colls.add.mop).val();
			var moptype = $.trim($('#'+colls.add.mop+' option:selected').text());
			console.log(mop);
			if(mop != 'NULL'){
				flag = true;
				$('#'+colls.add.mopmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$('#'+colls.add.mopmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($('#'+colls.add.mopmsg).offset().top)-95}, "slow");
				$(colls.add.mop).show().focus();
				return;
			}
			
			/* Amount */
			if($(colls.add.pamt).val().match(ind_reg)){
				flag = true;
				$(colls.add.pamsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(colls.add.pamsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(colls.add.pamsg).offset().top)-95}, "slow");
				$(colls.add.pamt).show().focus();
				return;
			}
			/* Amount paid */
			if(pad == Number($(colls.add.amtpaid).val()) && pad <= totamt){
				flag = true;
				$(colls.add.apmsg).append(VALIDNOT);
			}
			else{
				flag = false;
				$(colls.add.apmsg).append(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(sales.add.sales.amtpdmsg).offset().top)-95}, "slow");
				$(colls.add.amtpaid).show().focus();
				return;
			}
			/* Due amount */
			if(due == Number($(colls.add.amtdue).val()) && due <= totamt ){
				flag = true;
				$(colls.add.admsg).append(VALIDNOT);
			}
			else{
				flag = false;
				$(colls.add.admsg).append(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(sales.add.sales.damtpdmsg).offset().top)-95}, "slow");
				$(colls.add.amtdue).show().focus();
				return;
			}
			/* Due date */
			if(due){
				if($(colls.add.duedate).val().match(/(\d{4})-(\d{2})-(\d{2})/)){
					flag = true;
					$(colls.add.ddmsg).html(VALIDNOT);
				}
				else{
					flag = false;
					$(colls.add.ddmsg).html(INVALIDNOT);
					$('html, body').animate({scrollTop: Number($(colls.add.ddmsg).offset().top)-95}, "slow");
					$(colls.add.duedate).focus();
					return;
				}
			}
			/* Remark */
			if($(colls.add.rmk).val().length < 101){
				flag = true;
				$(colls.add.rmkmsg).html(VALIDNOT);
			}
			else{
				flag = false;
				$(colls.add.rmkmsg).html(INVALIDNOT);
				$('html, body').animate({scrollTop: Number($(colls.add.rmkmsg).offset().top)-95}, "slow");
				$(colls.add.rmk).show().focus();
				return;
			}
			var attr = {
				uid			: Number($.trim(colls.add.uid)),
				uind		: Number($.trim(colls.add.uind)),
				coltrid		: Number($.trim(colls.add.select.coltrid)),
				coltrind	: Number($.trim(colls.add.select.coltrind)),
				pid			: Number($.trim(colls.add.select.pid)),
				pindex 		: Number($.trim(colls.add.select.pindex)),
				pdate 		: $(colls.add.cdate).val(),
				mop			: Number($.trim(mop)),
				pamt 		: Number($.trim($(colls.add.pamt).val())),
				amtpaid		: Number($.trim($(colls.add.amtpaid).val())),
				amtdue		: Number($.trim($(colls.add.amtdue).val())),
				duedate     : $(colls.add.duedate).val(),
				rmk			: $.trim($(colls.add.rmk).val()),
				user		: $(colls.add.user).val(),
			};
			if(flag){
				$(colls.add.but).prop('disabled','disabled');
				$.ajax({
					url:colls.add.url,
					type:'POST',
					data:{autoloader: true,action:'addCollection',type:'master',colls:attr},
					success:function(data, textStatus, xhr){
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
								$(colls.msgDiv).html('<h2>Collection added to database</h2>');
								$('html, body').animate({scrollTop: Number($(colls.msgDiv).offset().top)-95}, "slow");
								$(colls.add.form).get(0).reset();
								// fetchUsers();
							break;
						}
					},
					error:function(){
						$(colls.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
						$(colls.add.but).removeAttr('disabled');
					}
				});
			}
		};
		function DisplayCollsList(){
			var header='<table class="table table-striped table-bordered table-hover" id="list_col_table"><thead><tr><th colspan="7">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th>Payee</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th></tr></thead>';
			var footer='</table>';
			$(colls.list.listLoad).html(LOADER_ONE);
			$.ajax({
				url:colls.list.url,
				type:'post',
				data:{autoloader:true,action:'DisplayCollsList',type:'master'},
				success:function(data, textStatus, xhr){
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
							$(colls.list.listDiv).html(header+data+footer);
							window.setTimeout(function(){
								$('#list_col_table').dataTable();
							},600)
							$(colls.list.listLoad).html('');
						break;
					}
				},
				error:function(){
					$(colls.outputDiv).html(INET_ERROR);
				},
				complete: function(xhr, textStatus) {
					console.log(xhr.status);
				}
			});
			//$(window).scroll(function(event){
			//	if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
				//	DisplayUpdatedCollsList();
				//else
			//		$(colls.list.listLoad).html('');
			//});
		}
		
}
