	function SearchUsers(){
		var menuDiv = "";
		var htmlDiv = "";
		var outputDiv = "";
		var OptionsSearch = new Object();
		var SearchAllHide = new Object();
		/* Constructor */
		this.__constructor = function (jsonserObj){
			menuDiv = jsonserObj.menuDiv;
			htmlDiv = jsonserObj.htmlDiv;
			outputDiv = jsonserObj.outputDiv;
			OptionsSearch = jsonserObj.OptionsSearch;
			SearchAllHide = jsonserObj.SearchAllHide;
			InstallSerachHtml();
		};
		function InstallSerachHtml(){
			$.ajax({
				url:URL+ADMIN+'search.php',
				type:'post',
				datatype:'JSON',
				async: false,
				data:{autoloader:'true',action:'LoadSearchHTML',ser:OptionsSearch},
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
				$(outputDiv).html('<img class="img-circle" src="'+URL+ASSET_IMG+'spinner_grey_120.gif" border="0" width="60" height="60" />');
				$.ajax({
					url: window.location.href,
					type:'POST',
					data:{autoloader:'true',
						action:'search_enq_list',
						cust_email:cust_email,
						cust_name:cust_name,
						cust_no:cust_no,
						enq_day:enq_day,
						follow_up:follow_up},
					success: function(data){
						if(data == 'logout')
							window.location.href = URL;
						else
							$(outputDiv).html(data);
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
					  data:{autoloader:'true',action:'searchGroup',group_name:group_name,owner:owner,min_mem:min_mem}
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
					  data:{autoloader:'true',action:'searchPerUser',user_name:user_name,user_mobile:user_mobile,user_email:user_email}
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
					  data:{autoloader:'true',action:'searchOffUser',offer_opt:offer_opt,fct_opt:fct_opt,offer_dur:offer_dur,offer_min_mem:offer_min_mem}
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
					  data:{autoloader:'true',action:'searchPackUser',pack_opt:pack_opt,pack_ses_opt:pack_ses_opt}
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
					  data:{autoloader:'true',action:'searchDateUser',jnd:jnd,exd:exd}
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