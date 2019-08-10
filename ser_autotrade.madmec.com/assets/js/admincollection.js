function admincollectionctrl(){
	var colls = {};
        var follw={};
	var listColletrs = {};
	var listofUsers = {};
	var listofProducts = {};
	var listofPattys = {};
	var listofcolls = {};
	var listofMOPtypes = {};
	var listofBankAC = {};
	this.__construct = function(cctrl){
		colls = cctrl;
                follw=cctrl.followups;
                fetchValidityTypes();
		$(colls.add.cdate+' , '+colls.add.duedate+' , '+colls.add.payment+' , '+colls.add.subsdate).datepicker({
			dateFormat: 'yy-mm-dd',
			yearRange:'2014:'+Number(new Date().getFullYear())+2,
		}); 
		$(colls.add.but).click(function(){
				addPayments();
		});
                $(follw.displayfollowups).hide();
	        $(follw.plus).click(function() {
	            $(follw.plus).hide();
	            bulitMultipleFollowups();
	        })
		$(colls.list.menuBut).click(function(){
				$(colls.msgDiv).html('');
				DisplayCollsList();
			});
                $(colls.add.amtpaid).keyup(function (){
                   $(colls.add.amtdue).val(Number($(colls.add.pamt).val()) - Number($(colls.add.amtpaid).val())) 
                   if(Number($(colls.add.amtpaid).val())>Number($(colls.add.pamt).val()))
                   {
                    $(colls.add.amtpaid).val(Number($(colls.add.pamt).val()))  
                    $(colls.add.amtdue).val('0') ;
                    }
                    if($(colls.add.amtdue).val()==0)
                    {
                     $(follw.displayfollowups).hide();
                     $(follw.plus).unbind();
                    }
                    else
                    {
                     $(follw.displayfollowups).show();   
                    }
                }) ;
                $(colls.add.amtpaid).keypress(function(key) {
                       if((key.charCode < 48 || key.charCode > 57) && key.charCode != 0 && key.charCode != 8 && key.charCode != 9 && key.charCode != 46) return false;
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

		fetchDistributor();
		fetchMOPTypes();
	};
        function bulitMultipleFollowups() {
	        if (follw.num == -1) $(follw.parentDiv).html('');
	        follw.num++;
	        var html = '<div id="' + follw.form + follw.num + '">' +
	            '<div class="col-lg-4">' + '<input class="form-control" placeholder="Follow up dates" name="followupdate" type="text" id="' + follw.followupdate + follw.num + '" maxlength="100" readonly=""/>' + '<p class="help-block" id="' + follw.msgDiv + follw.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-2">' + '<button type="button" class="btn btn-danger  btn-md" id="' + follw.minus + follw.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button type="button" class="btn btn-success  btn-md" id="' + follw.plus + follw.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
	        $(follw.parentDiv).append(html);
	        window.setTimeout(function() {
                    $(document.getElementById(follw.followupdate + follw.num)).datepicker({
                            dateFormat: 'yy-mm-dd',
                            changeYear: true,
                            changeMonth: true
                        });
	            $(document.getElementById(follw.minus + follw.num)).click(function() {
	                $(document.getElementById(follw.form + follw.num)).remove();
	                $(document.getElementById(follw.msgDiv + follw.num)).remove();
	                follw.num--;
	                if (follw.num == -1) {
	                    $(follw.plus).show();
	                    $(follw.parentDiv).html('');
	                } else {
	                    $(document.getElementById(follw.plus + follw.num)).show();
	                    $(document.getElementById(follw.minus + follw.num)).show();
	                }
	            });
	            $(document.getElementById(follw.plus + follw.num)).click(function() {
	                $(document.getElementById(follw.plus + follw.num)).hide();
	                $(document.getElementById(follw.minus + follw.num)).hide();
	                bulitMultipleFollowups();
	            });
	        }, 600);
	    }
	function fetchDistributor(){
		var rad = '';
			$.ajax({
				type:'POST',
				url:window.location.href,
				data:{autoloader:true,action:'fetchDistributor',type:'master'},
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
							var type = $.parseJSON(data);
							listofcolls = type;
                                                        var rad=new Array();	
                                                            for(i=0;i<type.length;i++){
								rad.push({
                                                                 label:$.trim(listofcolls[i]["html"]),
								 value:$.trim(listofcolls[i]["html"]),
                                                                  name   : $.trim(listofcolls[i]["html"]),
                                                                  clientid : $.trim(listofcolls[i]["id"])
                                                                });
							}
							$(colls.add.user).autocomplete({
                                                            source : rad,
                                                            select: function( event, ui ) {
                                                                    colls.add.clientid=ui.item.clientid;
                                                                  }
                                                                    });
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
                            var followupdates=new Array();
                            if (follw.num > -1) {
                        j = 0;
                        for (i = 0; i <= follw.num; i++) {
                            followupdates[j++] = $(document.getElementById(follw.followupdate + i)).val();
                        }
                    }
			$(colls.msgDiv).html('');
                        var flag = false;
			if($(colls.add.user).val()=="")
                        {
                        $(colls.add.usr_msg).html(INVALIDNOT);
                         $(colls.add.user).focus();
                         flag = false;
                         return 
                        }
                        else
                        {
                            $(colls.add.usr_msg).html(VALIDNOT);
                            flag = true;
                        }
                        if($(colls.add.validity).val()=="")
                        {
                        $(colls.add.validity_msg).html(INVALIDNOT);
                         $(colls.add.validity).focus();
                         flag = false;
                         return 
                        }
                        else
                        {
                            $(colls.add.validity_msg).html(VALIDNOT);
                            flag = true;
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
			if($(colls.add.payment).val()=="")
                        {
                        $(colls.add.payment_msg).html(INVALIDNOT);
                         $(colls.add.payment).focus();
                         flag = false;
                         return 
                        }
                        else
                        {
                            $(colls.add.payment_msg).html(VALIDNOT);
                            flag = true;
                        }
                        if($(colls.add.subsdate).val()=="")
                        {
                        $(colls.add.subsdatemsg).html(INVALIDNOT);
                         $(colls.add.subsdate).focus();
                         flag = false;
                         return 
                        }
                        else
                        {
                            $(colls.add.subsdatemsg).html(VALIDNOT);
                            flag = true;
                        } 
                        if($(colls.add.cdate).val()=="")
                        {
                        $(colls.add.cdmsg).html(INVALIDNOT);
                         $(colls.add.cdate).focus();
                         flag = false;
                         return 
                        }
                        else
                        {
                            $(colls.add.cdmsg).html(VALIDNOT);
                            flag = true;
                        }
                        if($(colls.add.amtpaid).val().match(numbs) ||  !$(colls.add.amtpaid).val()=="")
                        {
                          $(colls.add.apmsg).html(VALIDNOT);
                            flag = true;  
                        }
                        else
                        {
                          $(colls.add.apmsg).html(INVALIDNOT);
                         $(colls.add.amtpaid).focus();
                         flag = false;
                         return   
                        }
                        if(Number($(colls.add.amtdue).val())>0)
                        {
                            if($(colls.add.duedate).val()=="")
                            {
                            $(colls.add.ddmsg).html(INVALIDNOT);
                             $(colls.add.duedate).focus();
                             flag = false;
                             return 
                        }
                        else
                        {
                            $(colls.add.ddmsg).html(VALIDNOT);
                            flag = true;
                        }
                     }
                        if($(colls.add.rmk).val()=="")
                        {
                        $(colls.add.rmkmsg).html(INVALIDNOT);
                         $(colls.add.rmk).focus();
                         flag = false;
                         return 
                        }
                        else
                        {
                            $(colls.add.rmkmsg).html(VALIDNOT);
                            flag = true;
                        }
			if(flag){
                            var attr = {
				uid         : Number($.trim(colls.add.uid)),
				uind        : Number($.trim(colls.add.uind)),
				coltrid     : Number($.trim(colls.add.select.coltrid)),
				coltrind    : Number($.trim(colls.add.select.coltrind)),
				pid         : Number($.trim(colls.add.select.pid)),
				pindex      : Number($.trim(colls.add.select.pindex)),
				pdate       : $(colls.add.cdate).val(),
				mop         : Number($.trim(mop)),
				pamt        : Number($.trim($(colls.add.pamt).val())),
				amtpaid     : Number($.trim($(colls.add.amtpaid).val())),
				amtdue      : Number($.trim($(colls.add.amtdue).val())),
				duedate     : $(colls.add.duedate).val(),
				rmk         : $.trim($(colls.add.rmk).val()),
				user        : $(colls.add.user).val(),
                                clientid    : colls.add.clientid,
                                subsdate    : $(colls.add.subsdate).val(),
                                type        : $(colls.add.validity).val(),
                                folldates: followupdates
                                    };
				$(colls.add.but).prop('disabled','disabled');
				$.ajax({
					url:colls.add.url,
					type:'POST',
					data:{autoloader: true,action:'addCollection',type:'master',colls:attr},
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
                                                                var res=$.parseJSON(data);
                                                                if(res)
                                                                {
								$(colls.msgDiv).html('<h2>Collection added to database</h2>');
								$('html, body').animate({scrollTop: Number($(colls.msgDiv).offset().top)-95}, "slow");
								$(colls.add.form).get(0).reset();
                                                                }

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
                                                        var details=$.parseJSON(data);
                                                        if(details.status=="success")
							$(colls.list.listDiv).html(header+details.data+footer);
						else
                                                        $(colls.list.listDiv).html(details.data);
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

		};
        function fetchValidityTypes(){
			var rad = '';
			$.ajax({
				type:'POST',
				url:window.location.href,
				data:{autoloader:true,action:'fetchValidityTypes',type:'master'},
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
							$(colls.add.validity).html('<option value="" selected>Select Validity Type</option>'+rad);
							window.setTimeout(function (){
                                                           $(colls.add.validity).change(function (){
                                                               var vid=this.value;
                                                               for(i=0;i<type.length;i++)
                                                               {
                                                                   if(type[i]["id"]==vid)
                                                                   $(colls.add.pamt).val(type[i]["amount"]);    
                                                               }
                                                            }); 
                                                        },300);
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
}
