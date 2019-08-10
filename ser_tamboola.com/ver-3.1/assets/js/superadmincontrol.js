var loader = "#centerLoad";
var email_reg_new = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var cell_reg_new = /[0-9]{10,20}$/; ;
/* Binding the Menu Links  */
$(document).ready(function () {
	var mainpage = {
		leftbuttons : '.atleftmenu',
		prefiex : '#p',
		defaultView : '#pgym',
		outputDiv : '#output',
	};
	var leftbuttons = {
		one : '#gym',
		two : '#Order_follow-Ups',
		thr : '#client_collection',
		four : '#logouts',
		fiv : '#admin_dues',
		six : '#admin_duefollowup',
		NOTIFY : '#notification',
		EONE : "#EnquiryAdd",
		ETWO : "#EnquiryFollow",
		ETHR : "#EnquiryListAll",
		EFOUR : '#SentCredentials',
		sms : '#admin_sms',
		last : '#SignOut',
	};
	$.ajax({
		url : window.location.href,
		type : 'POST',
		async : false,
		data : {
			autoloader : true,
			action : 'pageLoad',
			type : 'master'
		},
		success : function (data, textStatus, xhr) {
			data = $.trim(data);
			switch (data) {
			case 'logout':
				logoutAdmin({});
				break;
			}
		},
		error : function (xhr, textStatus) {
			$(mainpage.outputDiv).html(INET_ERROR);
		},
		complete : function (xhr, textStatus) {}
	});
	/* client */
	loadJavaScript = function (src) {
		var jsSRC = $("<script type='text/javascript' src='" + src + "'>");
		$(OUTPUT).append(jsSRC);
	};
	$(leftbuttons.one).click(function (evt) {
		//user
		$(OUTPUT).html($.trim(MODULES.client));
		var usremailids = {
			parentDiv : "#usrmultiple_email",
			num : -1,
			form : "#usremail_id_",
			email : "#usremail_",
			msgDiv : "#usremail_msg_",
			plus : "#usrplus_email_",
			minus : "#usrminus_email_"
		};
		var usrcnumbers = {
			parentDiv : "#usrmultiple_cnumber",
			num : -1,
			form : "#usrcnumber_",
			codep : "#usrccode_",
			nump : "#usrcnum_",
			msgDiv : "#usrcnum_msg_",
			plus : "#usrplus_cnumber_",
			minus : "#usrminus_cnumber_"
		};
		var add_usr = {
			form : "#addusrForm",
			name : "#user_name",
			umsg : "#user_comsg",
			dob : "#user_dob",
			dmsg : "#user_dob_msg",
			gender : "#user_gender",
			gmsg : "#usr_dimsg",
			dtype : "#doc_type",
			dnum : "#doc_number",
			docform : "#upload_doc",
			file : "#doc_file",
			but : "#addusrBut",
			picbox : ".picedit_box",
			canvas : ".picedit_canvas_box",
			em : usremailids,
			cn : usrcnumbers,
		};
		//gym
		var emailids = {
			parentDiv : "#pfmultiple_email",
			num : -1,
			form : "#pfemail_id_",
			email : "#pfemail_",
			msgDiv : "#pfemail_msg_",
			plus : "#pfplus_email_",
			minus : "#pfminus_email_"
		};
		var cnumbers = {
			parentDiv : "#pfmultiple_cnumber",
			num : -1,
			form : "#pfcnumber_",
			codep : "#pfccode_",
			nump : "#pfcnum_",
			msgDiv : "#pfcnum_msg_",
			plus : "#pfplus_cnumber_",
			minus : "#pfminus_cnumber_"
		};
		var gym_addAddress = {
			showbut : "#addr_show_but",
			hidebut : "#addr_hide_but",
			addbody : "#gym_address_body",
			country : '#gym_country',
			countryCode : null,
			countryId : null,
			comsg : '#gym_comsg',
			province : '#gym_province',
			provinceCode : null,
			provinceId : null,
			prmsg : '#gym_prmsg',
			district : '#gym_district',
			districtCode : null,
			districtId : null,
			dimsg : '#gym_dimsg',
			city_town : '#gym_city_town',
			city_townCode : null,
			city_townId : null,
			citmsg : '#gym_citmsg',
			st_loc : '#gym_st_loc',
			st_locCode : null,
			st_locId : null,
			stlmsg : '#gym_stlmsg',
			addrs : '#gym_addrs',
			admsg : '#gym_admsg',
			cnumber : cnumbers,
			telenumber : '#gym_telenumber',
			telemsg : '#gym_telenumber_msg',
			zipcode : '#gym_zipcode',
			zimsg : '#gym_zimsg',
			website : '#gym_website',
			wemsg : '#gym_wemsg',
			tphone : '#gym_telephone',
			pcode : '#gym_pcode',
			tpmsg : '#gym_tp_msg',
			gmaphtml : '#gym_gmaphtml',
			gmmsg : '#gym_gmmsg',
			lat : null,
			lon : null,
			timezone : null,
			PCR_reg : null,
			url : URL + 'address.php'
		};
		var add_gym = {
			tab : "#addgymtab",
			form : "#addgymForm",
			type : "#gym_type",
			tmsg : "#gym_type_msg",
			mgym : "#usr_gym_name",
			mgmsg : "#usr_gym_msg",
			name : "#gym_name",
			nmsg : "#gym_name_msg",
			fee : "#gym_fee",
			fmsg : "#gym_fee_msg",
			tax : "#gym_tax",
			txmsg : "#gym_tax_msg",
			but : "#addgymBut",
			acs_id : '#acs_id',
			ac_msg : '#ac_msg',
			em : emailids,
			cn : cnumbers,
			address : gym_addAddress
		};
		var list_user = {
			gnt_pnlist : "#generate_mmlist",
			panel_pnlist : "#accorlistuser_",
			userdata_list : "#user_list_",
			gt_sublist : "#accorlistsub_",
			subur_infolist : "#subur_info_list_",
			listuserBtn : "#listgymsbut",
			gnt_gymlist : "#generate_mmgymlist",
			gymedit_div : "#edit_mmgymlist",
		};
		var assignuser = {
			form : '#assignuserform',
			asignowner : '#asignowner',
			asignuser : '#asignuser',
			asigngym : '#asigngym',
			userid : 0,
			gymid : 0,
			ownerid : 0,
			but : '#addusrBut',
		};
		var clnt = {
			autoloader : true,
			msgDiv : "#client_message",
			msgFocus : "#msg_focus",
			outputDiv : '#output',
			url : window.location.href,
			addusr : add_usr,
			addgym : add_gym,
			listuser : list_user,
			assignuser : assignuser,
                        oreqmenuBut: '#oreqmenuBut',
                        gymreqmenuBut : '#gymreqmenuBut',
		};
		evt.preventDefault();
		evt.stopPropagation();
		loadJavaScript(URL + ASSET_JSF + SUMOD + "client.js");
		var obj = new clientController();
		obj.__construct(clnt);
		addres = new Address();
		addres.__construct({
			url : add_gym.address.url,
			outputDiv : clnt.outputDiv
		});
		obj.countries = addres.getCountry();
		obj.bindAddressFields(addres);
	});
	/* order Follow-ups */
	$(leftbuttons.two).click(function () {
		$(OUTPUT).html($.trim(MODULES.orderfollowups));
		var order_BasicInfo = {
			name : '#client_name',
			nmsg : '#client_name_msg',
			num : '#client_number',
			nummsg : '#client_number_msg',
			otamt : '#ot_amt',
			otamtmsg : '#ot_amt_msg',
			email : '#client_email',
			emailmsg : '#client_email_msg',
			handledby : '#client_handby',
			handlebymsg : '#client_handby_msg',
			refby : '#client_refby',
			refbymsg : '#client_refby_msg',
			ord_prb : '#client_order_prob',
			ord_prbmsg : '#client_order_prob_msg',
			comment : '#client_comments',
			commentmsg : '#client_comment_msg',
			cdate : '#client_date',
			cdate_msg : '#client_date_msg',
			but : '#addclientBut',
			butmsg : '#client_add_msg',
			url : window.location.href,
			form : '#addfupsForm',
			outputDiv : '#output',
			listLoad : '#lstloader',
			listDiv : '#lstclients',
			listclient : '#list_order_follow_ups',
			handelpk : 0,
			referpk : 0,
		};
		var obj = new orderController();
		obj.__construct(order_BasicInfo);
		//        var obj = new orderFollow();
		//        obj.__construct(listenq);
	});
	/*collection*/
	$(leftbuttons.thr).click(function () {
		$(OUTPUT).html($.trim(MODULES.admincollection));
		var user_select = {
			pid : 0,
			pindex : 0,
			coltrid : 0,
			coltrind : 0,
			sessind : 'list_of_distributor'
		};
		var accounts = {
			parentDiv : 'CaddColBAC',
			num : 1,
			form : 'account_colls',
			bankname : 'bankname_colls',
			nmsg : 'banknamemsg_colls',
			accno : 'accno_colls',
			nomsg : 'accnomsg_colls',
			braname : 'braname_colls',
			bnmsg : 'branamemsg_colls',
			bracode : 'bracode_colls',
			bcmsg : 'bracodemsg_colls',
			IFSC : 'IFSC_colls',
			IFSCmsg : 'IFSCmsg_colls'
		};
		var user_colls = {
			parentDiv : '#multiple_collections',
			action : 'addUserColls',
			form : '#collsform',
			menuBut : '#addcollection',
			user : '#colls_payer',
			usr_msg : '#colls_payer_msg',
			coltr : '#colls_coltr',
			coltr_msg : '#colls_coltr_msg',
			clientid : 0,
			label : '',
			uid : 0,
			uind : 0,
			img : '',
			cdate : '#colls_date',
			cdmsg : '#colls_date_msg',
			mopdiv : '#CTvMopType',
			ac_id : '',
			acdiv : '#CTvMopAc',
			acdivtit : '#CTvMopAcTit',
			pay_ac : 'colls_ac',
			payac_msg : 'colls_ac_msg',
			mop : 'mop_colls',
			mopmsg : 'mop_colls_msg',
			pamt : '#colls_amt',
			pamsg : '#colls_amt_msg',
			amtpaid : '#colls_amt_paid',
			apmsg : '#colls_amt_paid_msg',
			amtdue : '#colls_amt_due',
			payment : '#payment_date',
			payment_msg : '#payment_date_msg',
			subsdate : '#subscribe_date',
			subsdatemsg : '#subscribe_date_msg',
			admsg : '#colls_amt_due_msg',
			duedate : '#colls_due_date',
			ddmsg : '#colls_due_date_msg',
			rmk : '#colls_rmk',
			rmkmsg : '#colls_rmk_msg',
			validity : '#validity_type',
			validity_msg : '#validity_type_msg',
			ac : accounts,
			select : user_select,
			but : '#addcollsBut'
		};
		var list_colls = {
			autoloader : true,
			action : 'listColls',
			parentDiv : '#list_colls',
			menuBut : '#listcollsbut',
			listDiv : '#lstcollections',
			listLoad : '#lstloader',
			url : window.location.href,
			display : false
		};
		var followups = {
			parentDiv : '#multiple_followups',
			num : -1,
			form : '#followup_id_',
			followupdate : '#followupdate_',
			msgDiv : '#followupdate_msg_',
			plus : '#plus_followups_',
			minus : '#minus_followups_',
			displayfollowups : '#displayfollowups',
		};
		var colls = {
			autoloader : true,
			outputDiv : '#output',
			followups : followups,
			parentDiv : '#pCollection',
			menuDiv : '#colls_menu',
			msgDiv : '#colls_message',
			add : user_colls,
			list : list_colls,
			url : URL + 'control.php',
			display : false
		};
		var obj = new admincollectionctrl();
		obj.__construct(colls);
	});
	$(leftbuttons.four).click(function () {
		$(OUTPUT).html($.trim(MODULES.sout));
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'logout',
				type : 'master',
			},
			success : function (data, textStatus, xhr) {
				console.log(data);
				data = $.trim(data);
				console.log(xhr.status);
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					loginAdmin({});
					break;
				}
			},
			error : function () {
				$(sales.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	});
	$(leftbuttons.fiv).on('click', function () {
		$(OUTPUT).html($.trim(MODULES.dueadmin));
		var addue = {
			disdues : '#disdues',
			url : URL + 'control.php',
			display : false
		};
		var obj = new admindue();
		obj.__construct(addue);
	});
	$(leftbuttons.six).on('click', function () {
		$(OUTPUT).html($.trim(MODULES.duefollowups));
		var adfollows = {
			current_followmenubut : '#current_followmenubut',
			pending_followmenubut : '#pending_followmenubut',
			expired_followmenubut : '#expired_followmenubut',
			current_follow_data : '#current_follow_data',
			pending_follow_data : '#pending_follow_data',
			expired_follow_data : '#expired_follow_data'
		};
		var obj = new adminfollowup();
		obj.__construct(adfollows);
	});
	//---------------------------------ENQ-------------------------------
	// Add enq
	$(leftbuttons.EONE).click(function () {
		$(OUTPUT).html('');
		$(OUTPUT).html($.trim(MODULES.saenqadd));
		var enqadd = {
			form : "enquiry_form",
			refer : "ref_box",
			lrefer : "list_ref",
			handel : "handel_box",
			lhandel : "list_handel",
			vname : "eq_name",
			vnmsg : "eq_name_msg",
			email : "enq_email",
			emsg : "enq_em_msgDiv",
			ccode : "enq_codep",
			cdmsg : "cdmsg",
			cell : "enq_cnumber",
			cmsg : "cmsg",
			fgoal : "ft_goal",
			cmt : "comments",
			f1 : "followup1",
			f2 : "followup2",
			f3 : "followup3",
			knwabt : "knowabout",
			instin : "interested",
			jop : "jop",
			but : "enquiry_save",
			msg : "enq_add_msg",
			titleimg : "enqaddimg",
		}
		var enqDivs = {
			url : window.location.href,
			add : enqadd,
		};
		loadJavaScript(URL + ASSET_JSF + SUMOD + "enquiry_add.js");
		var obj = new controlEnquiry();
		obj.__construct(enqDivs);
	});
	/*followups*/
	$(leftbuttons.ETWO).click(function () {
		$(OUTPUT).html('');
		$(OUTPUT).html($.trim(MODULES.saenqflw));
		var follow1 = {
			tab : "tFollowTab",
		};
		var follow2 = {
			tab : "pFollowTab",
		};
		var follow3 = {
			tab : "exFollowTab",
		};
		var listenq = {
			output : "#followOutput",
			url : window.location.href,
			tflw : follow1,
			pflw : follow2,
			exflw : follow3,
		};
		loadJavaScript(URL + ASSET_JSF + SUMOD + "enquiry_follow.js");
		loadJavaScript(URL + ASSET_JSF + SUMOD + "enquiry_list.js");
		var obj = new controlEnquiryFollow();
		obj.__construct(listenq);
	});
	/*List All*/
	$(leftbuttons.ETHR).click(function () {
		/*console.log('I am in Enq All');*/
		$(OUTPUT).html('');
		$(OUTPUT).html($.trim(MODULES.saenqlist));
		var list = {
			menuDiv : '#menuHtml',
			htmlDiv : '#searhHtml',
			outputDiv : '#output',
			OptionsSearch : {
				"Enquiry" : true,
				"Group" : false,
				"Personal" : false,
				"Offer" : false,
				"Package" : false,
				"Date" : false,
				"All" : false
			},
			SearchAllHide : {
				"Enquiry_ser_all" : false,
				"Group_ser_all" : true,
				"Personal_ser_all" : true,
				"Offer_ser_all" : true,
				"Package_ser_all" : true,
				"Date_ser_all" : true
			},
			output : "#ctEnquiryAllOutput",
		}
		var enq = {
			loader : "#center_loader",
			url : window.location.href,
			list : list,
		}
		loadJavaScript(URL + ASSET_JSF + SUMOD + "enquiry_list.js");
		var obj = new controlEnquiryListAll();
		obj.__construct(enq);
	});
	//Display Sent Credentials List
	$(leftbuttons.EFOUR).click(function () {
		$(OUTPUT).html('');
		$(OUTPUT).html($.trim(MODULES.sentcredentail));
		var attr = {
			displaycredentials : '#displaycredentials',
			url : window.location.href,
		};
		loadJavaScript(URL + ASSET_JSF + SUMOD + "sentcredential.js");
		var obj = new sentCredentials();
		obj.__construct(attr);
	});
	/*  SMS  */
	$(leftbuttons.sms).click(function () {
		$(OUTPUT).html('');
		$(OUTPUT).html($.trim(MODULES.sasms));
		var smssnd = {
			sendmsgform : '#sendmsgform',
			msglength : '#msglength',
			smssendbtn : '#smssendbtn',
			gym_searchh : '#gym_searchh',
			message : '#message',
			gymsearch : '#gymsearch',
			listofgyms : '#listofgyms',
			url : window.location.href,
		};
		loadJavaScript(URL + ASSET_JSF + SUMOD + "sms.js");
		var obj = new sms();
		obj.__construct(smssnd);
	});
	/* SIGNOUT */
	$(leftbuttons.last).click(function (evt) {
		evt.preventDefault();
		evt.stopPropagation();
		console.log('I am in signout');
		$.ajax({
			type : 'POST',
			url : window.location.href,
			data : {
				autoloader : true,
				action : 'logout',
				type : 'master'
			},
			success : function (data, textStatus, xhr) {
				data = $.trim(data);
				console.log(xhr.status);
				switch (data) {
				case 'logout':
					logoutAdmin({});
					break;
				case 'login':
					$(OUTPUT).html("Log out......");
					loginAdmin({});
					break;
				}
			},
			error : function () {
				$(sales.outputDiv).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	});
	$(leftbuttons.one).trigger('click');
	$(mainpage.defaultView).show();
	/*~ $(document).click( function(evt) {*/
	/*~ evt.preventDefault();*/
	/*~ evt.stopPropagation();*/
	/*~ });*/
});