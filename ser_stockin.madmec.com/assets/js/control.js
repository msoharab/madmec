$(document).ready(function() {
	    var mainpage = {
	        leftbuttons: '.atleftmenu',
	        prefiex: '#p',
	        defaultView: '#pUsers',
	        outputDiv: '#output',
	    };
	    var leftbuttons = {
	        one: '#Users',
	        two: '#Stock',
	        thr: '#Requirements',
	        fur: '#Quotation',
	        fiv: '#PurchaseOrder',
	        six: '#ProjectPlan',
	        svn: '#PCC',
	        egt: '#Invoice',
	        nin: '#Incomming',
	        ten: '#Outgoing',
	        ele: '#PettyCash',
	        twe: '#Due',
	        tir: '#Followups',
	        frt: '#Reports',
	        fit: '#SignOut',
	        sit: '#MaterialOrder',
	        svt: '#Drawing',
                etn: '#UserProfile',
                ntn: '#Setting',
	    };
	    /* USER */
	    $(leftbuttons.one).click(function() {
			$(OUTPUT).html($.trim(MODULES.user));
			var emailids = {
				parentDiv: '#multiple_email',
				num: -1,
				form: '#email_id_',
				email: '#email_',
				msgDiv: '#email_msg_',
				plus: '#plus_email_',
				minus: '#minus_email_'
			};
			var crnames = {
				parentDiv: '#multiple_crname',
				num: -1,
				form: '#crname_id_',
				crname: '#crname_',
				msgDiv: '#crname_msg_',
				plus: '#plus_crname_',
				minus: '#minus_crname_'
			};
                        var pans = {
				parentDiv: '#multiple_pan',
				num: -1,
				form: '#pan_id_',
				pan: '#pan_',
				msgDiv: '#pan_msg_',
				plus: '#plus_pan_',
				minus: '#minus_pan_'
			};
                        var tins = {
				parentDiv: '#multiple_tin',
				num: -1,
				form: '#tin_id_',
				tin: '#tin_',
				msgDiv: '#tin_msg_',
				plus: '#plus_tin_',
				minus: '#minus_tin_'
			}; 
                        var svts = {
				parentDiv: '#multiple_svt',
				num: -1,
				form: '#svt_id_',
				svt: '#svt_',
				msgDiv: '#svt_msg_',
				plus: '#plus_svt_',
				minus: '#minus_svt_'
			};
			var cnumbers = {
				parentDiv: '#multiple_cnumber',
				num: -1,
				form: '#cnumber_',
				codep: '#ccode_',
				nump: '#cnum_',
				msgDiv: '#cnum_msg_',
				plus: '#plus_cnumber_',
				minus: '#minus_cnumber_'
			};
			var accounts = {
				parentDiv: '#multiple_accounts',
				num: -1,
				form: '#account_',
				bankname: '#bankname_',
				nmsg: '#banknamemsg_',
				accno: '#accno_',
				nomsg: '#accnomsg_',
				braname: '#braname_',
				bnmsg: '#branamemsg_',
				bracode: '#bracode_',
				bcmsg: '#bracodemsg_',
				IFSC: '#IFSC_',
				IFSCmsg: '#IFSCmsg_',
				plus: '#plus_account_',
				minus: '#minus_account_'
			};
			var products = {
				parentDiv: '#multiple_product',
				num: -1,
				form: '#product_id_',
				product: '#product_',
				msgDiv: '#product_msg_',
				plus: '#plus_product_',
				minus: '#minus_product_'
			};
			var user_addBasicInfo = {
				TVUtype: '#TVUtype',
				user_type: 'user_type',
				ut_msg: 'user_type_msg',
				name: '#user_name',
				nmsg: '#user_name_msg',
				email: emailids,
				account: accounts,
				product: products,
				crname: crnames,
				acs_id: '#acs_id',
				ac_msg: '#ac_msg'
			};
			var user_addAddress = {
				country: '#country',
				countryCode: null,
				countryId: null,
				comsg: '#comsg',
				province: '#province',
				provinceCode: null,
				provinceId: null,
				prmsg: '#prmsg',
				district: '#district',
				districtCode: null,
				districtId: null,
				dimsg: '#dimsg',
				city_town: '#city_town',
				city_townCode: null,
				city_townId: null,
				citmsg: '#citmsg',
				st_loc: '#st_loc',
				st_locCode: null,
				st_locId: null,
				stlmsg: '#stlmsg',
				addrs: '#addrs',
				admsg: '#admsg',
				cnumber: cnumbers,
				telenumber: '#telenumber',
				telemsg: '#telenumber_msg',
				zipcode: '#zipcode',
				zimsg: '#zimsg',
				website: '#website',
				wemsg: '#wemsg',
				tphone: '#telephone',
				pcode: '#pcode',
				tpmsg: '#tp_msg',
				gmaphtml: '#gmaphtml',
				gmmsg: '#gmmsg',
				lat: null,
				lon: null,
				timezone: null,
				PCR_reg: null,
				url: URL + 'address.php'
			};
			var user_add = {
				action: 'addUser',
				parentDiv: '#accordionadduser',
				form: '#adduserForm',
				menuBut: '#addusersbut',
				addshow: '#address_but_show',
				addhide: '#address_but_hide',
				addbody: '#address_body',
				basicinfo: user_addBasicInfo,
				address: user_addAddress,
				url: window.location.href,
				but: '#adduserBut',
				display: false
			};
			var user_list = {
				autoloader: true,
				action: 'listUsers',
				parentDiv: '#list_user',
				menuBut: '#listusersbut',
				listDiv: '#accorlistuser',
				listLoad: '#lstusrloader',
				url: window.location.href,
				display: false
			};
			var user = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: mainpage.defaultview,
				menuDiv: '#user_menu',
				msgDiv: '#user_message',
				add: user_add,
				list: user_list,
				display: false
			};
			var usrctrl = {
				crn: crnames,
                                svt : svts,
                                pan : pans,
                                tin :tins,
				usr: user,
				cn: cnumbers,
				em: emailids,
				ac: accounts,
				pd: products
			};
			$(crnames.parentDiv + ',' + emailids.parentDiv + ',' + cnumbers.parentDiv + ',' + accounts.parentDiv + ',' + products.parentDiv).html('');
			$(crnames.plus + ',' + emailids.plus + ',' + cnumbers.plus + ',' + accounts.plus + ',' + products.plus).show();
			var obj = new userController();
			obj.__construct(usrctrl);
			addres = new Address();
			addres.__construct({
				url: user.add.address.url,
				outputDiv: user.outputDiv
			});
			addres.getIPData(user);
			addres.fillAddressFields(user);
			obj.countries = addres.getCountry();
			obj.bindAddressFields(addres);
	    });
	    /* STOCK */
	    $(leftbuttons.two).click(function() {
			$(OUTPUT).html($.trim(MODULES.stock));
			var item_type = {
				action: 'itemAdd',
				parentDiv: '#accordionadditem',
				form: '#additemForm',
				name: '#item_name12',
				hiditemname: '#hiditemname',
				nmsg: '#item_name_msg',
				cirt: '#min_crit',
				citmsg: '#min_crit_msg',
				menuBut: '#additmesbut',
				url: window.location.href,
				but: '#additemBut',
				display: false
			};
			var update_stock = {
				action: 'updateStock',
				TVUtype: '#TVStocktype',
				parentDiv: '#accordionaddstock',
				form: '#addstockForm',
				item_id: 'uitem',
				it_msg: 'uitem_msg',
				iid: 0,
				qty: '#itm_qty',
				qtymsg: '#itm_qty_msg',
				url: window.location.href,
				menuBut: '#stockbut',
				but: '#addstockBut',
				display: false
			};
			var view_stock = {
				vslist: '#view_stock_list',
				url: window.location.href,
				menuBut: '#viewstockbut',
				display: false
			};
			var stock_supplied = {};
			var issue_item = {};
			var display_stock = {};
			var display_order = {};
			var stock = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pStock',
				menuDiv: '#stock_menu',
				msgDiv: '#stock_message',
				add: item_type,
				update: update_stock,
				viewstock: view_stock,
				supply: stock_supplied,
				issue: issue_item,
				dstock: display_stock,
				display: false
			};
			var obj = new stockController();
			obj.__construct(stock);
	    });
	    /* REQUIREMENTS */
	    $(leftbuttons.thr).click(function() {
			$(OUTPUT).html($.trim(MODULES.req));
			var deliinst = {
				parentDiv: 'multiple_requi_delinst',
				num: -1,
				pind: -1,
				form: 'delivery_',
				bankname: 'requi_supp_',
				nmsg: 'requi_supp_msg_',
				accno: 'requi_inst_',
				nomsg: 'requi_inst_msg_',
				plus: 'plus_delins_',
				minus: 'minus_delins_'
			};
			var particulars = {
				parentDiv: '#multiple_requi_part',
				num: -1,
				form: '#requipt_',
				bankname: '#requi_part_',
				nmsg: '#requi_part_msg_',
				accno: '#requi_qty_',
				nomsg: '#requi_qty_msg_',
				braname: '#requi_unt_',
				bnmsg: '#requi_unt_msg_',
				deliinstarr: [],
				plus: '#plus_requipt_',
				minus: '#minus_requipt_'
			};
			var requi_add_proj = {
				action: 'addRequirement',
				parentDiv: '#accordionaddrequi',
				form: '#addrequiForm',
				menuBut: '#addrequisbut',
				pname: '#requi_proj_name',
				pnmsg: '#requi_proj_name_msg',
				ethno: '#UEthnoList',
				client: '#UClientList',
				cperson: '#UCompRepList',
				ethid: 0,
				ethno_type: 'ethno_type',
				ethno_msg: 'ethno_type_msg',
				cliid: 0,
				client_type: 'client_type',
				client_msg: 'client_type_msg',
				cpnid: 0,
				cperson_type: 'cperson_type',
				cperson_msg: 'cperson_type_msg',
				doe: '#requi_doeth',
				doemsg: '#requi_doeth_msg',
				part: particulars,
				dein: deliinst,
				url: window.location.href,
				but: '#addrequiationBut',
				display: false
			};
			var padesc = {
				parentDiv: 'multiple_rppbf_det_',
				num: -1,
				ppind: -1,
				pind: -1,
				form: '#requiptpfd_',
				bankname: '#requi_partpfd_',
				nmsg: '#requi_part_msgpfd_',
				accno: '#requi_qtypfd_',
				nomsg: '#requi_qty_msgpfd_',
				braname: '#requi_untpfd_',
				bnmsg: '#requi_unt_msgpfd_',
				bracode: '#bracodepfd_',
				bcmsg: '#bracodemsgpfd_',
				IFSC: '#IFSCpfd_',
				IFSCmsg: '#IFSCmsgpfd_',
				IFSC1: '#IFSC1pfd_',
				IFSC1msg: '#IFSCmsg1pfd_',
				plus: '#plus_requiptpfd_',
				minus: '#minus_requiptpfd_'
			};
			var floor = {
				parentDiv: '#multiple_rpp_floor_',
				num: -1,
				pind: -1,
				form: '#requiptfloor_',
				bankname: '#requi_partfloor_',
				nmsg: '#requi_part_msgfloor_',
				descarr: [],
				plus: '#plus_requiptfloor_',
				minus: '#minus_requiptfloor_'
			};
			var block = {
				parentDiv: '#multiple_rpp_block',
				num: -1,
				form: '#requiptpaint_',
				bankname: '#requi_partpaint_',
				nmsg: '#requi_part_msgpaint_',
				floorarr: [],
				plus: '#plus_requiptpaint_',
				minus: '#minus_requiptpaint_',
			};
			var requi_add_paint = {
				action: 'addPaintRequirement',
				block: block,
				floor: floor,
				desc: padesc,
				url: window.location.href,
				but: '#addrequiationPaintBut',
				display: false
			};
			var requi_list = {
				autoloader: true,
				action: 'listDOCS',
				parentDiv: '#list_requi',
				menuBut: '#listrequibut',
				listDiv: '#listSRS',
				listLoad: '#listSRS',
				url: window.location.href,
				what: 'requirements',
				display: false
			};
			var requi = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pRequirements',
				menuDiv: '#requi_menu',
				msgDiv: '#requi_message',
				add: requi_add_proj,
				paint: requi_add_paint,
				list: requi_list,
				display: false
			};
			$(particulars.parentDiv + ',' + deliinst.parentDiv).html('');
			$(particulars.plus + ',' + deliinst.plus).show();
			var obj = new requirementController();
			obj.__construct(requi);
	    });
	    /* QUOTATION */
	    $(leftbuttons.fur).click(function(evt) {
			$(OUTPUT).html($.trim(MODULES.quot));
			var requi_select = {
				TVQtype: '#URequiQuotList',
				Qrequi_type: 'Qrequi_type',
				QRT_msg: 'Qrequi_type_msg',
				Rdoc: '#requi_doc',
				prjmid: 0,
				requi_id: 0,
				ref_no: 0,
				quot_id: 0,
				po_id: 0,
				inv_id: 0,
				client_id: 0,
				ethno_id: 0,
				ethno: 0,
				rep_id: 0,
				rep: 0,
				doethno: '',
				ind: 0,
				artype: 0,
				url: window.location.href
			};
			var quot_info = {
				action: 'addQuotation',
				parentDiv: '#accordionaddquot',
				form: '#addquotForm',
				menuBut: '#addquotsbut',
				require: requi_select,
				sub: '#quot_subject',
				submsg: '#quot_subject_msg',
				qdesc: '#quot_desc',
				qdescmsg: '#quot_desc_msg',
				ptotal: '#quot_paint',
				ptotalmsg: '#quot_paint_msg',
				stc1: '#quot_paint_stc',
				stc1msg: '#quot_paint_stc_msg',
				ecess1: '#quot_paint_ecess',
				ecess1msg: '#quot_paint_ecess_msg',
				hecess1: '#quot_paint_hecess',
				hecess1msg: '#quot_paint_hecess_msg',
				nptot: '#pntotins',
				nptotmsg: '#pntotins_msg',
				totins: '#quot_totins',
				totinsmsg: '#quot_totins_msg',
				stc2: '#quot_totins_stc',
				stc2msg: '#quot_totins_stc_msg',
				ecess2: '#quot_totins_ecess',
				ecess2msg: '#quot_totins_ecess_msg',
				hecess2: '#quot_totins_hecess',
				hecess2msg: '#quot_totins_hecess_msg',
				ninstot: '#qntotins',
				ninstotmsg: '#qntotins_msg',
				totsup: '#quot_totsup',
				totsupmsg: '#quot_totsup_msg',
				vat: '#quot_totsup_vat',
				vatmsg: '#quot_totsup_vat_msg',
				nsuptot: '#supntotins',
				nsuptotmsg: '#supntotins_msg',
				qgtot: '#quot_gtotal',
				qgtotmsg: '#quot_gtotal_msg',
				pdfbut: '#addquotationPDFBut',
				xlsbut: '#addquotationXLSXBut',
				url: window.location.href,
				display: false
			};
			var qout_list = {
				autoloader: true,
				action: 'listDOCS',
				parentDiv: '#list_quot',
				menuBut: '#listquotbut',
				listDiv: '#listQUOT',
				listLoad: '#listQUOT',
				url: window.location.href,
				what: 'quotation',
				display: false
			};
			var qout_track = {
				autoloader: true,
				action: 'trackQuotations',
				parentDiv: '#list_user',
				menuBut: '#listusersbut',
				listDiv: '#accorlistuser',
				listLoad: '#lstusrloader',
				url: window.location.href,
				display: false
			};
			var quotation = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pQuotation',
				menuDiv: '#quot_menu',
				msgDiv: '#quot_message',
				add: quot_info,
				list: qout_list,
				track: qout_track,
				url: window.location.href,
				display: false
			};
			var obj = new quotationController();
			obj.__construct(quotation);
		});
	    /* PURCHASEORDER */
	    $(leftbuttons.fiv).click(function() {
			$(OUTPUT).html($.trim(MODULES.cpo));
			var requi_select = {
				TVQtype: '#URequiCPOList',
				Qrequi_type: 'cpo_type',
				QRT_msg: 'cpo_type_msg',
				Rdoc: '#requiCPO_doc',
				prjmid: 0,
				requi_id: 0,
				ref_no: 0,
				quot_id: 0,
				po_id: 0,
				inv_id: 0,
				client_id: 0,
				ethno_id: 0,
				ethno: 0,
				rep_id: 0,
				rep: 0,
				doethno: '',
				ind: 0,
				artype: 0,
				url: window.location.href
			};
			var uploadCPO = {
				action: 'uploadCPO',
				parentDiv: '#upload_po',
				menuBut: '#addcpobut',
				formid: '#uploadcpo',
				formname: 'uploadcpo',
				refno: '#clientpo_refno',
				refnomsg: '#clientpo_refno_msg',
				doi: '#clientpo_doi',
				doimsg: '#clientpo_doi_msg',
				file: '#cpo_file_upload',
				filemsg: '#cpo_file_upload_msg',
				submit: '#upload_poBut',
				progress: '#cpo_progress',
				bar: '#cpo_bar',
				percent: '#cpo_percent',
				percentVal: '0%',
				status: '#cpo_status',
				require: requi_select,
				url: window.location.href,
				display: false
			};
			var cpo_list = {
				autoloader: true,
				action: 'listDOCS',
				parentDiv: '#list_cpo',
				menuBut: '#listcpobut',
				listDiv: '#listCPO',
				listLoad: '#listCPO',
				url: window.location.href,
				what: 'client_po',
				display: false
			};
			var cpo_track = {};
			var cpo = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pPurchaseOrder',
				menuDiv: '#clientpo_menu',
				msgDiv: '#cpo_message',
				cpo: uploadCPO,
				list: cpo_list,
				track: cpo_track,
				url: window.location.href,
				display: false
			};
			var obj = new ClientPurchaseOrder();
			obj.__construct(cpo);
		});
	    /* PROJECTPLAN */
	    $(leftbuttons.six).click(function() {
			$(OUTPUT).html($.trim(MODULES.pp));
			var requi_select = {
				TVQtype: '#URequiProjList',
				Qrequi_type: 'proj_req_type',
				QRT_msg: 'proj_req_type_msg',
				Rdoc: '#pp_doc',
				pname: '',
				prjmid: 0,
				requi_id: 0,
				ref_no: 0,
				quot_id: 0,
				po_id: 0,
				inv_id: 0,
				client_id: 0,
				ethno_id: 0,
				ethno: 0,
				rep_id: 0,
				rep: 0,
				doethno: '',
				ind: 0,
				artype: 0,
				url: window.location.href
			};
			var plan = {
				action: 'createPlan',
				parentDiv: '#accordionaddproj',
				menuBut: '#addprojbut',
				formid: '#addprojForm',
				formname: 'addprojForm',
				md: '#UProjMDList',
				mng: '#UProjMNGList',
				eng: '#UProjENGList',
				hld: '#UProjHLDList',
				mdid: 0,
				md_type: 'md_type',
				md_msg: 'md_type_msg',
				mngid: 0,
				mng_type: 'mng_type',
				mng_msg: 'mng_type_msg',
				engid: 0,
				eng_type: 'eng_type',
				eng_msg: 'eng_type_msg',
				hldid: 0,
				hld_type: 'hld_type',
				hld_msg: 'hld_type_msg',
				psd: '#proj_psd',
				psdmsg: '#proj_psd_msg',
				pcd: '#proj_pcd',
				pcdmsg: '#proj_pcd_msg',
				seen: '#proj_sndd',
				seenmsg: '#proj_sndd_msg',
				prjsts: '#UProjsttsList',
				prjstts: 'proj_stts',
				prjsttsmsg: 'proj_stts_msg',
				tm: '#proj_tm',
				tmmsg: '#proj_tm_msg',
				assntask:{
					parentDiv:'#multiple_projtmem',
					task_desc:[]
				},
				require: requi_select,
				url: window.location.href,
				but:'#addpplanBut',
				display: false
			};
			var proj_list = {};
			var proj = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pProjectPlan',
				menuDiv: '#proj_menu',
				msgDiv: '#proj_message',
				plan: plan,
				list: proj_list,
				url: window.location.href,
				display: false
			};
			var obj = new ProjectPlan();
			obj.__construct(proj);	  
		});
	    /* PCC */
	    $(leftbuttons.svn).click(function() {
			$(OUTPUT).html($.trim(MODULES.pcc));
			var pcctask = {
				parentDiv: 'multiple_pcctthreads_',
				num: -1,
				pind: -1,
				form: 'pcctthread_',
				bankname: 'pcc_th_size_',
				nmsg: 'pcc_th_size_msg_',
				accno: 'pcc_th_clr_',
				nomsg: 'pcc_th_clr_msg_',
				braname: 'pcc_th_qty_',
				bnmsg: 'pcc_th_qty_msg_',
				bracode: 'pcc_th_rmk_',
				bcmsg: 'pcc_th_rmk_msg_',
				plus: 'plus_pcctthr_',
				minus: 'minus_pcctthr_'
			};
			var particulars = {
				parentDiv: '#multiple_pccthreads',
				num: -1,
				form: '#pccthread_',
				bankname: '#pcc_mat_name_',
				nmsg: '#pcc_mat_name_msg_',
				deliinstarr: [],
				plus: '#plus_pccthr_',
				minus: '#minus_pccthr_'
			};
			var prd_select = {
				TVQtype: '#UProdTaskList',
				Qrequi_type: 'prd_tsk_type',
				QRT_msg: 'prd_tsk_type_msg',
				Rdoc: '#show_task_descp',
				pname: '',
				prjmid: 0,
				prjid: 0,
				task_id: 0,
				requi_id: 0,
				ref_no: 0,
				quot_id: 0,
				po_id: 0,
				ind: 0,
				artype: 0,
				url: window.location.href
			};
			var pcc_add = {
				action: 'createPCC',
				parentDiv: '#accordionaddpcc',
				menuBut: '#addpccbut',
				formid: '#addpccForm',
				formname: 'addpccForm',
				pccn: '#pcc_name',
				pccnmsg: '#pcc_name_msg',
				pccl: '#pcc_loc',
				pcclmsg: '#pcc_loc_msg',
				pccc: '#pcc_code',
				pcccmsg: '#pcc_code_msg',
				pccfc: '#pcc_fr_con',
				pccfcmsg: '#pcc_fr_con_msg',
				pccwh: '#pcc_ws_hg',
				pccwhmsg: '#pcc_fr_con_msg',
				pccrv: '#pcc_rev',
				pccrvmsg: '#pcc_rev_msg',
				pcctw: '#pcc_tws',
				pcctwmsg: '#pcc_tws_msg',
				pccsdw: '#pcc_sd_ww',
				pccsdwmsg: '#pcc_sd_ww_msg',
				pccsdm: '#pcc_sd_mw',
				pccsdmmsg: '#pcc_sd_mw_msg',
				pccdd: '#pcc_dd',
				pccddmsg: '#pcc_dd_msg',
				part: particulars,
				pcctask: pcctask,
				prdtask: prd_select,
				url: window.location.href,
				but:'#addpccBut',
				display: false
			};
			var pcc_list = {
				autoloader: true,
				action: 'listDOCS',
				parentDiv: '#list_prtaskpcc',
				menuBut: '#listpccbut',
				listDiv: '#listPCC',
				listLoad: '#listPCC',
				url: window.location.href,
				what: 'project_description',
				display: false
			};
			var pcc = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pPCC',
				menuDiv: '#pcc_menu',
				msgDiv: '#pcc_message',
				add: pcc_add,
				list: pcc_list,
				url: window.location.href,
				display: false
			};
			var obj = new PCC();
			obj.__construct(pcc);	  
	    });
	    /* INVOICE */
	    $(leftbuttons.egt).click(function() {
			$(OUTPUT).html($.trim(MODULES.invoice));
			var requi_select = {
				TVQtype: '#URequiInvList',
				Qrequi_type: 'Inrequi_type',
				QRT_msg: 'Inrequi_type_msg',
				Rdoc: '#requi_doc',
				prjmid: 0,
				requi_id: 0,
				ref_no: 0,
				inv_id: 0,
				po_id: 0,
				inv_id: 0,
				client_id: 0,
				ethno_id: 0,
				ethno: 0,
				rep_id: 0,
				rep: 0,
				doethno: '',
				ind: 0,
				artype: 0,
				url: window.location.href
			};
			var inv_info = {
				action: 'addInvation',
				parentDiv: '#accordionaddinv',
				form: '#addinvForm',
				menuBut: '#addinvsbut',
				require: requi_select,
				
				vhno: '#inv_vhno',
				vhnomsg: '#inv_vhno_msg',
				
				lrno: '#inv_lrno',
				lrnomsg: '#inv_lrno_msg',
				
				mot: '#UMOTInvList',
				motid: 0,
				mot_type: 'inv_mot_type',
				mot_msg: 'inv_mot_type_msg',
				
				dlepla: '#inv_dlepla',
				dleplamsg: '#inv_dlepla_msg',
				
				sub: '#inv_subject',
				submsg: '#inv_subject_msg',
				
				qdesc: '#inv_desc',
				qdescmsg: '#inv_desc_msg',
				
				trans: '#UTransInvList',
				transid: 0,
				trans_type: 'trans_type',
				trans_msg: 'trans_type_msg',
				
				driv: '#UDrivInvList',
				drivid: 0,
				driv_type: 'driv_type',
				driv_msg: 'driv_type_msg',
				
				totins: '#inv_totins',
				totinsmsg: '#inv_totins_msg',
				stc2: '#inv_totins_stc',
				stc2msg: '#inv_totins_stc_msg',
				ecess2: '#inv_totins_ecess',
				ecess2msg: '#inv_totins_ecess_msg',
				hecess2: '#inv_totins_hecess',
				hecess2msg: '#inv_totins_hecess_msg',
				ninstot: '#invtotins',
				ninstotmsg: '#invtotins_msg',
				
				ptotal: '#inv_paint',
				ptotalmsg: '#inv_paint_msg',
				stc1: '#inv_paint_stc',
				stc1msg: '#inv_paint_stc_msg',
				ecess1: '#inv_paint_ecess',
				ecess1msg: '#inv_paint_ecess_msg',
				hecess1: '#inv_paint_hecess',
				hecess1msg: '#inv_paint_hecess_msg',
				nptot: '#invtotpaint',
				nptotmsg: '#invtotpaint_msg',
				
				
				totsup: '#inv_totsup',
				totsupmsg: '#inv_totsup_msg',
				vat: '#inv_totsup_vat',
				vatmsg: '#inv_totsup_vat_msg',
				nsuptot: '#supinvntotins',
				nsuptotmsg: '#supinvntotins_msg',
				
				qgtot: '#inv_gtotal',
				qgtotmsg: '#inv_gtotal_msg',
				
				pdfbut: '#addinvoicePDFBut',
				xlsbut: '#addinvoiceXLSXBut',
				
				url: window.location.href,
				display: false
			};
			var inv_list = {
				autoloader: true,
				action: 'listDOCS',
				parentDiv: '#list_inv',
				menuBut: '#listinvbut',
				listDiv: '#listINV',
				listLoad: '#listINV',
				url: window.location.href,
				what: 'invoice',
				display: false
			};
			var inv_track = {
				autoloader: true,
				action: 'trackInvations',
				parentDiv: '#list_user',
				menuBut: '#listusersbut',
				listDiv: '#accorlistuser',
				listLoad: '#lstusrloader',
				url: window.location.href,
				display: false
			};
			var invoice = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pInvation',
				menuDiv: '#inv_menu',
				msgDiv: '#inv_message',
				add: inv_info,
				list: inv_list,
				track: inv_track,
				url: window.location.href,
				display: false
			};
			var obj = new invoiceController();
			obj.__construct(invoice);
	    });
	    /* INCOMMING */
	    $(leftbuttons.nin).click(function() {
			$(OUTPUT).html($.trim(MODULES.incomming));
			var user_select = {
				pid: 0,
				pindex: 0,
				sessind: 'list_of_users'
			};
			var accounts = {
				parentDiv: 'CaddColBAC',
				num: 1,
				form: 'account_colls',
				bankname: 'bankname_colls',
				nmsg: 'banknamemsg_colls',
				accno: 'accno_colls',
				nomsg: 'accnomsg_colls',
				braname: 'braname_colls',
				bnmsg: 'branamemsg_colls',
				bracode: 'bracode_colls',
				bcmsg: 'bracodemsg_colls',
				IFSC: 'IFSC_colls',
				IFSCmsg: 'IFSCmsg_colls'
			};
			var user_colls = {
				parentDiv: '#multiple_collections',
				action: 'addUserColls',
				form: '#collsform',
				menuBut: '#addcollection',
				user: '#colls_payer',
				usr_msg: '#colls_payer_msg',
				label: '',
				uid: 0,
				uind: 0,
				img: '',
				cdate: '#colls_date',
				cdmsg: '#colls_date_msg',
				mopdiv: '#CTvMopType',
				ac_id: '',
				acdiv: '#CTvMopAc',
				acdivtit: '#CTvMopAcTit',
				pay_ac: 'colls_ac',
				payac_msg: 'colls_ac_msg',
				mop: 'mop_colls',
				mopmsg: 'mop_colls_msg',
				pamt: '#colls_amt',
				pamsg: '#colls_amt_msg',
				rmk: '#colls_rmk',
				rmkmsg: '#colls_rmk_msg',
				ac: accounts,
				select: user_select,
				but: '#addcollsBut'
			};
			var proj_colls = {
				parentDiv: '#multiple_Proj_collections',
				action: 'addprojincomColls',
				form: '#projincomeform',
				menuBut: '#projectpaymenubut',
				disclient: '#proj_client',
				client: 'client_proj_incom',
				client_msg: '#Proj_client_msg',
				disproj: '#Proj_names',
				projlist: 'client_proj_list',
				disproj_msg: '#Proj_names_msg',
				totalamount: '#Proj_totalamount',
				currentdue: '#Proj_currentdue',
				amount: '#Proj_amount_pay',
				amount_msg: '#Proj_amount_pay_msg',
				dateofpay: '#Proj_dateofpay',
				dateofpay_msg: '#Proj_dateofpay_msg',
				remark: '#Proj_incom_remark',
				remark_msg: '#Proj_incom_remark_msg',
				dueamount: '#Proj_dueamount',
				duedate: '#Proj_amount_due_date',
				duedate_msg: '#Proj_amount_due_date_msg',
				but: '#addprojimcomBut'
			};
			var followups = {
				parentDiv: '#multiple_followups',
				num: -1,
				form: '#followup_id_',
				followupdate: '#followupdate_',
				msgDiv: '#followupdate_msg_',
				plus: '#plus_followups_',
				minus: '#minus_followups_'
			};
			var list_colls = {
				autoloader: true,
				action: 'listColls',
				parentDiv: '#list_colls',
				menuBut: '#listcollsbut',
				listDiv: '#lstcollections',
				listLoad: '#lstloader',
				url: window.location.href,
				display: false
			};
			var colls = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pIncomming',
				menuDiv: '#colls_menu',
				msgDiv: '#colls_message',
				add: user_colls,
				list: list_colls,
				follup: followups,
				projincom: proj_colls,
				url: URL + 'control.php',
				display: false
			};
			var obj = new collectionController();
			obj.__construct(colls);
	    });
	    /* OUTGOING */
	    $(leftbuttons.ten).click(function() {
			$(OUTPUT).html($.trim(MODULES.outgoing));
			var user_select = {
				pid: 0,
				pindex: 0,
				sessind: 'list_of_users'
			};
			var accounts = {
				parentDiv: 'PaddPayBAC',
				num: 1,
				form: 'account_payms',
				bankname: 'bankname_payms',
				nmsg: 'banknamemsg_payms',
				accno: 'accno_payms',
				nomsg: 'accnomsg_payms',
				braname: 'braname_payms',
				bnmsg: 'branamemsg_payms',
				bracode: 'bracode_payms',
				bcmsg: 'bracodemsg_payms',
				IFSC: 'IFSC_payms',
				IFSCmsg: 'IFSCmsg_payms'
			};
			var user_payms = {
				parentDiv: '#multiple_payms',
				action: 'addUserPayms',
				form: '#paymsform',
				menuBut: '#addpayments',
				user: '#payms_payer',
				usr_msg: '#payms_payer_msg',
				label: '',
				uid: 0,
				uind: 0,
				img: '',
				cdate: '#payms_date',
				cdmsg: '#payms_date_msg',
				mopdiv: '#PTvMopType',
				ac_id: '',
				petycashdis: '#petycashh',
				acdiv: '#PTvMopAc',
				acdivtit: '#PTvMopAcTit',
				pay_ac: 'payms_ac',
				payac_msg: 'payms_ac_msg',
				mop: 'mop_payms',
				availpettycash: 'availpettycash',
				mopmsg: 'mop_payms_msg',
				pamt: '#payms_amt',
				pamsg: '#payms_amt_msg',
				rmk: '#payms_rmk',
				rmkmsg: '#payms_rmk_msg',
				ac: accounts,
				select: user_select,
				but: '#addpaymsBut'
			};
			var list_payms = {
				autoloader: true,
				action: 'listPayms',
				parentDiv: '#list_payms',
				menuBut: '#listpaymsbut',
				listDiv: '#lstpayments',
				listLoad: '#lstpaymsloader',
				url: window.location.href,
				display: false
			};
			var payms = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pOutgoing',
				menuDiv: '#paym_menu',
				msgDiv: '#payms_message',
				add: user_payms,
				list: list_payms,
				url: URL + 'control.php',
				display: false
			};
			var obj = new paymentController();
			obj.__construct(payms);
	    });
	    /* PETTYCASH */
	    $(leftbuttons.ele).click(function() {
			$(OUTPUT).html($.trim(MODULES.pcash));
			var add_pattycash = {
				parentDiv: '#multiple_pattyadd',
				action: 'pettycashadd',
				form: '#addpettycashform',
				pamount: '#pettyamount',
				pamountmsg: '#pettyamount_msg',
				remark: '#pettyamountremark',
				remarkmsg: '#pettyamountremark_msg',
				url: window.location.href,
				but: '#addpattycashBut',
				display: false
			}
			var list_pattycash = {
				menubut: '#listpattycashbut',
				displayhistory: '#pettycashhistory',
				display: false
			}
			var pattycash = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pPettyCash',
				menuDiv: '#patty_menu',
				msgDiv: '#patty_msg',
				add: add_pattycash,
				list: list_pattycash,
				url: URL + 'control.php',
				display: false
			}
			var obj = new pattycashController();
			obj.__construct(pattycash);
	    });
	    /* DUE */
	    $(leftbuttons.twe).click(function() {
			$(OUTPUT).html($.trim(MODULES.due));
			var proj_due_list = {
				displayhistory: '#projdue',
				display: false
			}
			var duelist = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pDue',
				list: proj_due_list,
				url: URL + 'control.php',
				display: false
			}
			obj = new projDue();
			obj.__construct(duelist);
	    });
	    /* FOLLOWUPS */
	    $(leftbuttons.tir).click(function() {
			$(OUTPUT).html($.trim(MODULES.followup));
			var followuplist = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pFollowups',
				currentfollowup: '#current_follow_data',
				pendingfollowup: '#pending_follow_data',
				expiredfollowup: '#expired_follow_data',
				url: URL + 'control.php',
				display: false
			}
			obj = new followup();
			obj.__construct(followuplist);
	    });
	    /* REPORTS */
	    $(leftbuttons.frt).click(function() {
			$(OUTPUT).html($.trim(MODULES.rep));
			var gen_report = {
				action: 'addRequirement',
				parentDiv: '#accordionaddrep',
				form: '#addrepForm',
				dfrom: '#rep_date_from',
				dfrommsg: '#rep_date_from_msg',
				dto: '#rep_date_to',
				dtomsg: '#rep_date_to_msg',
				url: window.location.href,
				pdfbut: '#addreportPDFBut',
				xlsbut: '#addreportXLSXBut',
				display: false
			};
			var reports = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pReports',
				msgDiv: '#rep_msg',
				add: gen_report,
				display: false
			};
			var obj = new repController();
			obj.__construct(reports);
	    });
	    /* SIGNOUT */
	    $(leftbuttons.fit).click(function() {
                    $(OUTPUT).html($.trim(MODULES.sout));
                    $.ajax({
                            type: 'POST',
                            url: window.location.href,
                            data: {
                                    autoloader: true,
                                    action: 'logout'
                            },
                            success: function(data, textStatus, xhr) {
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
                            error: function() {
                                    $(sales.outputDiv).html(INET_ERROR);
                            },
                            complete: function(xhr, textStatus) {
                                    console.log(xhr.status);
                            }
                    });
	    });
	    /* MATERIALORDER */
	    $(leftbuttons.sit).click(function() {
			$(OUTPUT).html($.trim(MODULES.mo));
			var material_order = {
				action: 'creat_material_Order',
				TVVendortype: '#TVVendortype',
				TVSOtype: '#TVStockOrdertype',
				parentDiv: '#accordionmatorder',
				form: '#matorderForm',
				item_id: 'oitem',
				it_msg: 'oitem_msg',
				iid: 0,
				ven_id: 'vendor',
				ven_msg: 'vendor_msg',
				vid: 0,
				doo: '#item_doo',
				doo_msg: '#item_doo_msg',
				edod: '#item_edod',
				edod_msg: '#item_edod_msg',
				qty: '#matorder_qty',
				qtymsg: '#matorder_qty_msg',
				url: window.location.href,
				menuBut: '#creatorderbut',
				but: '#matorderBut',
				display: false
			};
			var add_item_MOrder = {
				action: 'add_item_material_Order',
				TVSOtype: '#mTVStockOrdertype',
				OVentype: '#order_vendor_name',
				MOhideitem: '#MOhideitem',
				listDiv: '#ps_list',
				parentDiv: '#multiple_items',
				form: '#MOadditemform',
				mo_descb: '#mo_descb',
				item_id: 'moitem',
				it_msg: 'moitem_msg',
				iid: 0,
				ord_id: 'morderd',
				ord_msg: 'morderd_msg',
				oid: 0,
				doo: '#mitem_doo',
				doo_msg: '#mitem_doo_msg',
				edod: '#mitem_edod',
				edod_msg: '#mitem_edod_msg',
				qty: '#mmatorder_qty',
				qtymsg: '#mmatorder_qty_msg',
				url: window.location.href,
				menuBut: '#addMOItemBut',
				but: '#addmaterialsBut',
                               
				display: false
			};
			var Morder = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pMaterialOrder',
				menuDiv: '#Morder_menu',
				msgDiv: '#MOrder_message',
				order: material_order,
				add_item: add_item_MOrder,
				display: false
			};
			var add_item_MOrder = {
				action: 'add_item_material_Order',
				TVSOtype: '#mTVStockOrdertype',
				OVentype: '#order_vendor_name',
				MOhideitem: '#MOhideitem',
				listDiv: '#ps_list',
				parentDiv: '#multiple_items',
				form: '#MOadditemform',
				mo_descb: '#mo_descb',
				item_id: 'moitem',
				it_msg: 'moitem_msg',
				iid: 0,
				ord_id: 'morderd',
				ord_msg: 'morderd_msg',
				oid: 0,
				doo: '#mitem_doo',
				doo_msg: '#mitem_doo_msg',
				edod: '#mitem_edod',
				edod_msg: '#mitem_edod_msg',
				qty: '#mmatorder_qty',
				qtymsg: '#mmatorder_qty_msg',
				url: window.location.href,
				menuBut: '#addMOItemBut',
				but: '#addmaterialsBut',
                                addnewitemss : '#addnewitemss',
                                updatequantity : '#updatequantity',
                                upmmatorder_qty : '#upmmatorder_qty',
                                upmmatorder_qtymsg : '#upmmatorder_qtymsg',
                                updatequantityMSGdiv  : '#updatequantityMSGdiv',
                                addnewitemssMSGdiv  : '#addnewitemssMSGdiv',
                                upaddmaterialsBut   : '#upaddmaterialsBut',
                                mopdfgen        : '#mopdfgen',
                                moexcelgen      : '#moexcelgen',
				display: false
			}
			Material_view_order = {
				displayorded: '#displaymaterialordereddetails',
				menuBut: '#viewMOrderbut',
				but: '#viewmaterialsBut',
				url: window.location.href,
				display: false
			}
			Material_supplied_order = {
				displayorded: '#displaysuppliedordereddetails',
				menuBut: '#ItemSuppliedbut',
				but: '#suppliedmaterialsBut',
				url: window.location.href,
				display: false
			}
			var Morder = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pMaterialOrder',
				menuDiv: '#Morder_menu',
				msgDiv: '#MOrder_message',
				order: material_order,
				add_item: add_item_MOrder,
				view_order: Material_view_order,
				order_supplied: Material_supplied_order,
				display: false
			};
			var obj = new materialController();
			obj.__construct(Morder);
	    });
	    /* DRAWING */
	    $(leftbuttons.svt).click(function() {
			$(OUTPUT).html($.trim(MODULES.draw));
			var prd_select = {
				TVQtype: '#UDrawPccList',
				Qrequi_type: 'UDrawPcc',
				QRT_msg: 'UDrawPcc_msg',
				Rdoc: '#stdraw_descp',
				prjmid: 0,
				requi_id: 0,
				ref_no: 0,
				quot_id: 0,
				po_id: 0,
				inv_id: 0,
				client_id: 0,
				ethno_id: 0,
				ethno: 0,
				rep_id: 0,
				rep: 0,
				doethno: '',
				ind: 0,
				artype: 0,
                                prjdesc_id : 0,
				url: window.location.href
			};
			var uploadDraw = {
				action: 'uploadDRAW',
				parentDiv: '#accordionupdraw',
				menuBut: '#adddrawbut',
				formid: '#adddrawForm',
				formname: 'adddrawForm',
				desin: '#UDrawDesinList',
				desid: 0,
				des_type: 'UDrawDesin',
				des_msg: 'UDrawDesin_msg',
				refno: '#draw_name',
				refnomsg: '#draw_name_msg',
				doi: '#draw_dou',
				doimsg: '#draw_dou_msg',
				file: '#draw_file_upload',
				filemsg: '#draw_file_upload_msg',
				submit: '#upload_draw_But',
				progress: '#draw_progress',
				bar: '#draw_bar',
				percent: '#draw_percent',
				percentVal: '0%',
				status: '#draw_status',
				require: prd_select,
				url: window.location.href,
				display: false
			};
			var draw_list = {
				autoloader: true,
				action: 'listDOCS',
				parentDiv: '#list_draw',
				menuBut: '#listdrawbut',
				listDiv: '#listDRAW',
				listLoad: '#listDRAW',
				url: window.location.href,
				what: 'drawing',
				display: false
			};
			var draw = {
				autoloader: true,
				outputDiv: '#output',
				parentDiv: '#pDrawing',
				menuDiv: '#draw_menu',
				msgDiv: '#draw_message',
				cpo: uploadDraw,
				list: draw_list,
				url: window.location.href,
				display: false
			};
			var obj = new DrawingCtrl();
			obj.__construct(draw);
		});
            /* User Profile*/ 
           $(leftbuttons.etn).click(function (){
              $(OUTPUT).html($.trim(MODULES.userprofile)); 
              var changepass={
                currentpassword     : '#currentpassword',
                newpassword         : '#newpassword',
                changepasswordform  : '#changepasswordform',
                confirmpassword     : '#confirmpassword',
                currentpassworderr  : '#currentpassworderr',
                newpassworderr      : '#newpassworderr',
                confirmpassworderr  : '#confirmpassworderr',
                changepasswordBut   : '#changepasswordBut',
              };
              var personaldet=
              {
                  
              };
              var userprof={
                changepass          : changepass,
                personaldet         : personaldet,
                url                 : window.location.href,  
              };
              var usprflobj=new userprofile()
              usprflobj.__construct(userprof);
           });
           /* Setting*/ 
           $(leftbuttons.ntn).click(function (){
              $(OUTPUT).html($.trim(MODULES.setting)); 
              adddetails ={
                  menuBut           : '#Setting', 
                  adddetailsform    : '#adddetailsform',
                  displaybilllogo   : '#displaybilllogo',
                  companyname       : '#companyname',
                  companyaddress    : '#companyaddress',
                  companylandline   : '#companylandline',
                  companyemail      : '#companyemail',
                  companymobile     : '#companymobile',
                  termsncondition   : '#termsncondition',
                  footermsg         : '#footermsg',
                  savesettingbut    : '#upload_savesettingbut',
                  check             : 0,
                  photo : '.picedit_box'
              };
              var setting ={
                 adddetails : adddetails,
                 url        : window.location.href,
                
              };
               var obj = new Setting();
               obj.__construct(setting);
           })
	});

