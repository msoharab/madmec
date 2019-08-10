var loader = "#centerLoad";
var email_reg_new = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var cell_reg_new = /[0-9]{10,20}$/;
$(document).ready(function() {
	var menubut = '.navbar-toggle';
	var mainpage = {
		leftbuttons: '.atleftmenu',
		prefiex: '#p',
		defaultView: '#menu1',
		outputDiv: '#output',
	};
	var leftbuttons = {
		menu1: '#menu1',
		menu2: '#menu2',
		menu3: '#menu3',
		menu4: '#menu4',
		menu5: '#menu5',
	};

	function hideMajorDivs() {
		$(mainpage.leftbuttons).each(function() {
			$(mainpage.prefiex + $(this).attr('id')).hide();
		});
		$(mainpage.leftbuttons).each(function() {
			$(this).click(function(evt) {
				$(mainpage.prefiex + evt.target.id).show();
				return;
			});
		});
	};
	/*  Menu 1 */
	$(leftbuttons.menu1).click(function(evt) {
		/*Users*/
		evt.preventDefault();
		evt.stopPropagation();
		/*user*/
		if ($(menubut).css('display') !== 'none')
			$(menubut).trigger('click');
		var usremailids = {
			parentDiv: "#usrmultiple_email",
			num: -1,
			form: "#usremail_id_",
			email: "#usremail_",
			msgDiv: "#usremail_msg_",
			plus: "#usrplus_email_",
			minus: "#usrminus_email_"
		};
		var usrcnumbers = {
			parentDiv: "#usrmultiple_cnumber",
			num: -1,
			form: "#usrcnumber_",
			codep: "#usrccode_",
			nump: "#usrcnum_",
			msgDiv: "#usrcnum_msg_",
			plus: "#usrplus_cnumber_",
			minus: "#usrminus_cnumber_"
		};
		var list_user = {
			gnt_pnlist: "#output",
			panel_pnlist: "#accorlistuser_",
			userdata_list: "#user_list_",
			gt_sublist: "#accorlistsub_",
			subur_infolist: "#subur_info_list_",
			listuserBtn: "#listgymsbut",
			gnt_gymlist: "#generate_mmgymlist",
			gymedit_div: "#edit_mmgymlist"
		};
		var clnt = {
			autoloader: true,
			msgDiv: "#client_message",
			msgFocus: "#msg_focus",
			outputDiv: '#output',
			url: window.location.href,
			listuser: list_user
		};
		var obj = new menu1();
		obj.__construct(clnt);
	});
	/*  Menu 2 */
	$(leftbuttons.menu2).click(function(evt) {
		/*Gym*/
		evt.preventDefault();
		evt.stopPropagation();
		hideMajorDivs();
		if ($(menubut).css('display') !== 'none')
			$(menubut).trigger('click');
		var usremailids = {
			parentDiv: "#usrmultiple_email",
			num: -1,
			form: "#usremail_id_",
			email: "#usremail_",
			msgDiv: "#usremail_msg_",
			plus: "#usrplus_email_",
			minus: "#usrminus_email_"
		};
		var usrcnumbers = {
			parentDiv: "#usrmultiple_cnumber",
			num: -1,
			form: "#usrcnumber_",
			codep: "#usrccode_",
			nump: "#usrcnum_",
			msgDiv: "#usrcnum_msg_",
			plus: "#usrplus_cnumber_",
			minus: "#usrminus_cnumber_"
		};
		var add_usr = {
			form: "#addusrForm",
			name: "#user_name",
			umsg: "#user_comsg",
			dob: "#user_dob",
			dmsg: "#user_dob_msg",
			gender: "#user_gender",
			gmsg: "#usr_dimsg",
			dtype: "#doc_type",
			dnum: "#doc_number",
			docform: "#upload_doc",
			file: "#doc_file",
			but: "#addusrBut",
			picbox: ".picedit_box",
			canvas: ".picedit_canvas_box",
			em: usremailids,
			cn: usrcnumbers,
		};
		var emailids = {
			parentDiv: "#pfmultiple_email",
			num: -1,
			form: "#pfemail_id_",
			email: "#pfemail_",
			msgDiv: "#pfemail_msg_",
			plus: "#pfplus_email_",
			minus: "#pfminus_email_"
		};
		var cnumbers = {
			parentDiv: "#pfmultiple_cnumber",
			num: -1,
			form: "#pfcnumber_",
			codep: "#pfccode_",
			nump: "#pfcnum_",
			msgDiv: "#pfcnum_msg_",
			plus: "#pfplus_cnumber_",
			minus: "#pfminus_cnumber_"
		};
		var gym_addAddress = {
			showbut: "#addr_show_but",
			hidebut: "#addr_hide_but",
			addbody: "#gym_address_body",
			country: '#gym_country',
			countryCode: null,
			countryId: null,
			comsg: '#gym_comsg',
			province: '#gym_province',
			provinceCode: null,
			provinceId: null,
			prmsg: '#gym_prmsg',
			district: '#gym_district',
			districtCode: null,
			districtId: null,
			dimsg: '#gym_dimsg',
			city_town: '#gym_city_town',
			city_townCode: null,
			city_townId: null,
			citmsg: '#gym_citmsg',
			st_loc: '#gym_st_loc',
			st_locCode: null,
			st_locId: null,
			stlmsg: '#gym_stlmsg',
			addrs: '#gym_addrs',
			admsg: '#gym_admsg',
			cnumber: cnumbers,
			telenumber: '#gym_telenumber',
			telemsg: '#gym_telenumber_msg',
			zipcode: '#gym_zipcode',
			zimsg: '#gym_zimsg',
			website: '#gym_website',
			wemsg: '#gym_wemsg',
			tphone: '#gym_telephone',
			pcode: '#gym_pcode',
			tpmsg: '#gym_tp_msg',
			gmaphtml: '#gym_gmaphtml',
			gmmsg: '#gym_gmmsg',
			lat: null,
			lon: null,
			timezone: null,
			PCR_reg: null,
			url: URL + 'address.php'
		};
		var add_gym = {
			tab: "#addgymtab",
			form: "#addgymForm",
			type: "#gym_type",
			tmsg: "#gym_type_msg",
			mgym: "#usr_gym_name",
			mgmsg: "#usr_gym_msg",
			name: "#gym_name",
			nmsg: "#gym_name_msg",
			fee: "#gym_fee",
			fmsg: "#gym_fee_msg",
			tax: "#gym_tax",
			txmsg: "#gym_tax_msg",
			but: "#addgymBut",
			acs_id: '#acs_id',
			ac_msg: '#ac_msg',
			em: emailids,
			cn: cnumbers,
			address: gym_addAddress
		};
		var list_user = {
			gnt_pnlist: "#generate_mmlist",
			panel_pnlist: "#accorlistuser_",
			userdata_list: "#user_list_",
			gt_sublist: "#accorlistsub_",
			subur_infolist: "#subur_info_list_",
			listuserBtn: "#listgymsbut",
			gnt_gymlist: "#generate_mmgymlist",
			gymedit_div: "#edit_mmgymlist"
		};
		var clnt = {
			autoloader: true,
			msgDiv: "#client_message",
			msgFocus: "#msg_focus",
			outputDiv: '#output',
			url: window.location.href,
			addgym: add_gym,
			addusr: add_usr,
			listgyms: listgyms,
			listuser: list_user
		};
		var listgyms = {
			listgymsmenubut: '#listgymsmenubut',
			dislistofgyms: '#dislistofgyms'
		};
		var attr = {
			autoloader: true,
			msgDiv: "#client_message",
			msgFocus: "#msg_focus",
			outputDiv: '#output',
			url: window.location.href,
			addgym: add_gym,
			listgyms: listgyms
		};
		$('#output').load(MENU2, function() {
			var obj1 = new menu2();
			obj1.__construct(attr);
			addres = new Address();
			addres.__construct({
				url: add_gym.address.url,
				outputDiv: attr.outputDiv
			});
			obj1.countries = addres.getCountry();
			obj1.bindAddressFields(addres);
		});
	});
	/*  Menu 3 */
	$(leftbuttons.menu3).click(function(evt) {
		evt.preventDefault();
		evt.stopPropagation();
		hideMajorDivs();
		if ($(menubut).css('display') !== 'none')
			$(menubut).trigger('click');
		$('#output').load(MENU3);
		var addoffer = {
			displaygyms: '#displaygyms',
			disdura: '#disdura',
			disfac: '#disfac',
			offersave: '#offersave',
			name: '#of_name',
			duration: '#duration',
			days: '#of_no_days',
			faciltiy: '#faciltiy',
			prize: '#of_prize',
			member: '#of_member',
			gymname: '#gymname',
			descb: '#of_des',
			form: '#addofferform'
		}
		var listoffer = {
			menubut: '#listoffersmenubut',
			disoffes: '#disoffes',
		};
		var attr = {
			add: addoffer,
			list: listoffer,
			url: window.location.href,
		};
		var obj = new menu3();
		obj.__construct(attr);
	});
	/*  Menu 4 */
	$(leftbuttons.menu4).click(function(evt) {
		evt.preventDefault();
		evt.stopPropagation();
		hideMajorDivs();
		if ($(menubut).css('display') !== 'none')
			$(menubut).trigger('click');
		$('#output').load(MENU4);
		var addpack = {
			displaygyms: '#displaygyms',
			form: '#packageform',
			packagename: '#packagename',
			sessions: '#sessions',
			distypeofpack: '#distypeofpack',
			packtype: '#packtype',
			offersave: '#offersave',
			amount: '#amount',
			gymname: '#gymname',
			savepack: '#savepack',
		}
		var listpack = {
			menubut: '#listpackmenubut',
			dispacks: '#dispackages',
		};
		var attr = {
			add: addpack,
			list: listpack,
			url: window.location.href,
		};
		var obj = new menu4();
		obj.__construct(attr);
	});
	/* SIGNOUT */
	$(leftbuttons.menu5).click(function(evt) {
		evt.preventDefault();
		evt.stopPropagation();
		hideMajorDivs();
		if ($(menubut).css('display') !== 'none')
			$(menubut).trigger('click');
		$.ajax({
			type: 'POST',
			url: window.location.href,
			data: {
				autoloader: true,
				action: 'logout',
				type: 'master'
			},
			success: function(data, textStatus, xhr) {
				data = $.trim(data);
				console.log(xhr.status);
				localStorage.removeItem("validate");
				switch (data) {
					case 'logout':
						logoutAdmin({});
						break;
					case 'login':
						loginAdmin({});
						break;
				}
			},
			error: function() {
				$(sales.outputDiv).html(INET_ERROR);
			},
			complete: function(xhr, textStatus) {
				console.log(xhr.status);
			}
		});
	});
});