$(document).ready(function () {
    var mainpage = {
        leftbuttons: '.atleftmenu',
        prefiex: '#p',
        defaultView: '#pUsers',
        outputDiv: '#output',
        sidebar: '#sidebar',
        sidemenu: '#side-menu'
    };
    var leftbuttons = {
        one: '#Users',
        two: '#Product',
        thr: '#Sales',
        fur: '#Purchase',
        fiv: '#Collection',
        six: '#Payments',
        dues : '#duesMenu',
        svn: '#SignOutss',
        eig: '#buttoggle',
        PF: '#Profile',
        Setting: '#Setting',
        LG: '#loggouts',
        EXPIRED: '#expired',
        nin: '#billsinvoice',
        sale: '#Sale'
    };
    $.ajax({
        url: window.location.href,
        type: 'POST',
        async: false,
        data: {autoloader: true, action: 'pageLoad'},
        success: function (data, textStatus, xhr) {
            data = $.trim(data);
            console.log(xhr.status);
            switch (data) {
                case 'logout':
                    logoutAdmin({});
                    break;
            }
        },
        error: function (xhr, textStatus) {
            $(mainpage.outputDiv).html(INET_ERROR);
        },
        complete: function (xhr, textStatus) {
            console.log(xhr.status);
        }
    });
    function hideMajorDivs() {
        $(mainpage.leftbuttons).each(function () {
            $(mainpage.prefiex + $(this).text()).hide();
        });
        $(mainpage.leftbuttons).each(function () {
            $(this).click(function (evt) {
                $(mainpage.prefiex + evt.target.id).show();
                return;
            });
        });
    }
    ;
    /*   EXPIRED */
    $(leftbuttons.EXPIRED).click(function () {
        console.log("im in Expired");
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        hideMajorDivs();
    });
    /*MENU BUTTON*/
    $(leftbuttons.eig).click(function () {
        $("#page-wrapper").css({"margin-left": "250px"});
        $('#sidebar').show();
        $('#buttoggle').hide();
    });
    /* USER */
    $(leftbuttons.one).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.user));
        var emailids = {
            parentDiv: '#multiple_email',
            menuDiv: '#emlpills',
            num: -1,
            form: '#email_id_',
            email: '#email_',
            msgDiv: '#email_msg_',
            plus: '#plus_email_',
            minus: '#minus_email_'
        };
        var cnumbers = {
            parentDiv: '#multiple_cnumber',
            menuDiv: '#cnmpills',
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
            menuDiv: '#bacpills',
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
            menuDiv: '#prdpills',
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
            otamt: '#ot_amt',
            otamtmsg: '#ot_amt_msg',
            email: emailids,
            account: accounts,
            product: products,
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
            menuDiv: '#menuHtml',
            htmlDiv: '#searhHtml',
            outputDiv: '#output',
            listall: '#listalluser',
            OptionsSearch: {
                "UserName": true,
                "Products": true,
                "ViewAllUser": true,
                "Due": true,
                "Date": false,
                "All": true
            },
            SearchAllHide: {
                "UserName_ser_all": false,
                "UserType_ser_all": true,
                "Products_ser_all": true,
                "CellNo_ser_all": true,
                "Due_ser_all": true,
                "Date_ser_all": true
            },
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
            usr: user,
            cn: cnumbers,
            em: emailids,
            ac: accounts,
            pd: products
        };
        $(emailids.parentDiv + ',' +
                cnumbers.parentDiv + ',' +
                accounts.parentDiv + ',' +
                products.parentDiv).html('');
        $(emailids.plus + ',' + cnumbers.plus + ',' + accounts.plus + ',' + products.plus).show();
        hideMajorDivs();
        var obj = new userController();
        obj.__construct(usrctrl);
    });
    /* PRODUCT */
    $(leftbuttons.two).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.product));
        hideMajorDivs();
        console.log('I am in products');
    });
    /* BILLS */
    $(leftbuttons.nin).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.billlist));
        var patty_addBasicInfo = {
            autoloader: true,
            action: 'addPattyBasicInfo',
            menuBut: '#addpattybut',
            parentDiv: '#pattyBasicInfo',
            form: '#addpattyForm',
            TVPtype: '#TVPtype',
            pack_type: 'pack_type',
            pt_msg: 'pack_type_msg',
            name: '#supp_name',
            label: '',
            img: '',
            sid: 0,
            sind: '',
            nmsg: '#supp_name_msg',
            product: '#prduct_name',
            prodmsg: '#prduct_name_msg',
            packs: '#num_packs',
            packsmsg: '#num_packs_msg',
            pid: 0,
            pind: 0,
            pdn_msg: '#prduct_name_msg',
            vehicle: '#vehicle_no',
            vh_msg: '#vd_msg',
            date: '#patty_date',
            pd_msg: '#pd_msg',
            but: '#inipattyBut'
        };
        var patty_select = {
            autoloader: true,
            action: 'selectPatty',
            parentDiv: '#selectsalespatty',
            pname: '#patty_sale_name',
            pnmsg: '#patty_sale_name_msg',
            listDiv: '#ps_list',
            ldLoader: '#psl_loader',
            deleteOk: '#deleteOk',
            deleteCancel: '#deleteCancel',
            sid: 0,
            pid: 0,
            pindex: 0,
            prdname: '',
            prdphoto: '',
            packtype: ''
        };
        var patty_sales = {
            autoloader: true,
            action: 'addPattySaleEntry',
            parentDiv: '#multiple_sales',
            menuBut: '#entrypattysbut',
            form: '#addsaleform',
            retailer: '#pd_customer',
            ret_msg: '#pd_customer_msg',
            rid: '',
            rind: '',
            img: '',
            label: '',
            pds: '#patty_date_sales',
            pds_msg: '#pds_msg',
            num_packs: '#num_packs',
            npmsg: '#edit_num_packs_msg',
            kg_packs: '#kg_packs',
            kpmsg: '#kg_packs_msg',
            rp: '#rate_packs',
            rpmsg: '#rate_packs_msg',
            rpa: '#calc_amt',
            rpamsg: '#calc_amt_msg',
            amtpd: '#amt_paid',
            amtpdmsg: '#amt_paid_msg',
            damtpd: '#due_pay',
            damtpdmsg: '#due_pay_msg',
            dd: '#due_date',
            ddmsg: '#due_date_msg',
            select: patty_select,
            but: '#addpattysalesBut'
        };
        var patpay_select = {
            autoloader: true,
            action: 'selectPatty',
            parentDiv: '#selectpaypatty',
            pname: '#patty_pay_name',
            pnmsg: '#patty_pay_name_msg',
            listDiv: '#pps_list',
            ldLoader: '#ppsl_loader',
            sid: 0,
            pid: 0,
            pindex: 0,
            prdname: '',
            prdphoto: '',
            packtype: '',
            sessind: 'list_of_pattys'
        };
        var accounts = {
            parentDiv: 'addPayBAC',
            num: 1,
            form: 'account_pay',
            bankname: 'bankname_pay',
            nmsg: 'banknamemsg_pay',
            accno: 'accno_pay',
            nomsg: 'accnomsg_pay',
            braname: 'braname_pay',
            bnmsg: 'branamemsg_pay',
            bracode: 'bracode_pay',
            bcmsg: 'bracodemsg_pay',
            IFSC: 'IFSC_pay',
            IFSCmsg: 'IFSCmsg_pay'
        };
        var patty_payemts = {
            parentDiv: '#multiple_payments',
            action: 'addPattyPay',
            form: '#salepayform',
            menuBut: '#paypattysbut',
            mopdiv: '#TvMopType',
            payee_id: '',
            sale_id: '',
            con_id: '',
            payee: '#pay_payee',
            payeemsg: '#pay_payee_msg',
            pdate: '#pay_date',
            pdmsg: '#pay_date_msg',
            ac_id: '',
            acdiv: '#TvMopAc',
            acdivtit: '#TvMopAcTit',
            pay_ac: 'pay_ac',
            payac_msg: 'pay_ac_msg',
            mop: 'mop_pay',
            mopmsg: 'mop_pay_msg',
            pamt: '#pay_amt',
            pamsg: '#pay_amt_msg',
            rmk: '#pay_rmk',
            rmkmsg: '#pay_rmk_msg',
            select: patpay_select,
            ac: accounts,
            but: '#addpattypayBut'
        };
        var patbill_select = {
            autoloader: true,
            action: 'selectPatty',
            parentDiv: '#selectbillpatty',
            pname: '#patty_bill_name',
            pnmsg: '#patty_bill_name_msg',
            listDiv: '#pps_bill_list',
            ldLoader: '#ppsl_bill_oader',
            sid: 0,
            pid: 0,
            pindex: 0,
            prdname: '',
            prdphoto: '',
            packtype: ''
        };
        var sales_summary = {
            parentDiv: '#bill_summary',
            supplier: '#bill_to',
            suppmsg: '#bill_to_msg',
            receivedon: '#rev_date',
            rnmsg: '#rev_date_msg',
            bdate: '#bill_date',
            bdatemsg: '#bill_date_msg',
            bqty: '#bill_qty',
            bqtymsg: '#bill_qty_msg',
            bprt: '#bill_prt',
            bprtmsg: '#bill_prt_msg',
            totwt: '#bill_kg_packs',
            totwtmsg: '#bill_kg_packs_msg',
            avgrt: '#bill_rate_packs',
            avgrtmsg: '#bill_rate_packs_msg',
            netsal: '#bill_calc_amt',
            netsalmsg: '#bill_calc_amt_msg'
        };
        var expenses = {
            parentDiv: '#bill_exp',
            hire: '#bill_lhir',
            hiremsg: '#bill_lhir_msg',
            comm: '#bill_comm',
            commmsg: '#bill_comm_msg',
            cash: '#bill_Cash',
            cashmsg: '#bill_Cash_msg',
            labr: '#bill_labr',
            labrmsg: '#bill_labr_msg',
            assnfee: '#bill_assnfee',
            assnfeemsg: '#bill_assnfee_msg',
            telefee: '#bill_telefee',
            telefeemsg: '#bill_telefee_msg',
            rmc: '#bill_rmc',
            rmcmsg: '#bill_rmc_msg',
            totexp: '#bill_tot_exp',
            totexpmsg: '#bill_tot_exp_msg'
        };
        var rotten = {
            parentDiv: '#bill_rotten',
            rotqt: '#bill_rotqt',
            rotqtmsg: '#bill_rotqt_msg',
            rotwt: '#bill_rotwt',
            rotwtmsg: '#bill_rotwt_msg',
            rot: '#bill_rot',
            rotmsg: '#bill_rot_msg',
            rotamt: '#rot_amt',
            rotamtmsg: '#rot_amt_msg'
        };
        var hunda = {
            parentDiv: '#bill_hunda',
            hunqt: '#bill_hunqt',
            hunqtmsg: '#bill_hunqt_msg',
            hunwt: '#bill_hunwt',
            hunwtmsg: '#bill_hunwt_msg',
            hun: '#bill_hun',
            hunmsg: '#bill_hun_msg',
            hunamt: '#hun_amt',
            hunamtmsg: '#hun_amt_msg'
        };
        var patty_bill = {
            parentDiv: '#multiple_billments',
            action: 'generatePattybill',
            form: '#salebillform',
            menuBut: '#billpattysbut',
            sale_id: '',
            con_id: '',
            select: patbill_select,
            summary: sales_summary,
            expenses: expenses,
            rotten: rotten,
            hunda: hunda,
            nsales: '#net_sales',
            nsalesmsg: '#net_sales_msg',
            but: '#addpattybillBut'
        };
        var patty_add = {
            action: 'addPatty',
            parentDiv: '#addpattyForm',
            form: '#adduserForm',
            menuBut: '#sales_menu',
            basicinfo: patty_addBasicInfo,
            sales: patty_sales,
            payments: patty_payemts,
            bill: patty_bill,
            url: window.location.href,
            display: false
        };
        var patty_list = {
            autoloader: true,
            action: 'listPatty',
            parentDiv: '#list_user',
            menuBut: '#listpattysbut',
            listDiv: '#lstpattys',
            listLoad: '#lstpattysloader',
            url: window.location.href,
            display: false
        };
        var sales = {
            autoloader: true,
            outputDiv: '#output',
            parentDiv: '#pSales',
            menuDiv: '#sales_menu',
            menuBut: '#addpattybut',
            msgDiv: '#patty_message',
            userType: 'supplier',
            supplierlist: {},
            add: patty_add,
            list: patty_list,
            display: false
        };
        hideMajorDivs();
        var obj = new billlistController();
        obj.__construct(sales);
    });
    /* PURCHASE */
    $(leftbuttons.fur).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.purchase));
        var purchase = {
            autoloader: true,
            action: 'addPattyBasicInfo',
            menuBut: '#addpattybut',
            parentDiv: '#pattyBasicInfo',
            outputDiv: '#output',
            form: '#addpattyForm',
            TVPtype: '#TVPtype',
            pack_type: 'pack_type',
            pt_msg: 'pack_type_msg',
            name: '#supp_name',
            label: '',
            img: '',
            sid: 0,
            sind: '',
            nmsg: '#supp_name_msg',
            product: '#prduct_name',
            prodmsg: '#prduct_name_msg',
            packs: '#num_packs',
            packsmsg: '#num_packs_msg',
            pid: 0,
            pind: 0,
            pdn_msg: '#prduct_name_msg',
            vehicle: '#vehicle_no',
            vh_msg: '#vd_msg',
            date: '#patty_date',
            pd_msg: '#pd_msg',
            msgDiv: '#purchase_message',
            but: '#inipattyBut',
            listLoad: '#lstloader',
            listDiv: '#lstpurchase',
            listpur: '#list_purchase'
        };
        hideMajorDivs();
        var obj = new purchaseController();
        obj.__construct(purchase);
    });
    /* COLLECTION */
    $(leftbuttons.fiv).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.collection));
        var user_select = {
            pid: 0,
            pindex: 0,
            coltrid: 0,
            coltrind: 0,
            dstid: 0,
            dstind: 0,
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
            coltr: '#colls_coltr',
            coltr_msg: '#colls_coltr_msg',
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
            parentDiv: '#pCollection',
            menuDiv: '#colls_menu',
            msgDiv: '#colls_message',
            add: user_colls,
            list: list_colls,
            url: URL + 'control.php',
            display: false
        };
        hideMajorDivs();
        var obj = new collectionController();
        obj.__construct(colls);
    });
    /* PAYMENTS */
    $(leftbuttons.six).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.payment));
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
            acdiv: '#PTvMopAc',
            acdivtit: '#PTvMopAcTit',
            pay_ac: 'payms_ac',
            payac_msg: 'payms_ac_msg',
            mop: 'mop_payms',
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
            parentDiv: '#pPayments',
            menuDiv: '#paym_menu',
            msgDiv: '#payms_message',
            add: user_payms,
            list: list_payms,
            url: URL + 'control.php',
            display: false
        };
        hideMajorDivs();
        var obj = new paymentController();
        obj.__construct(payms);
    });
    
    $(leftbuttons.dues).click(function (){
         $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.dues));
        var due = {
           displaydues  : '#displaydues', 
            url: window.location.href,
        };
        hideMajorDivs();
        var ob = new dueController();
        ob.__construct(due);
    });
    /*Profile*/
    $(leftbuttons.PF).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.profile));
        var profile = {
            pfoutdiv: '#admin_profile',
            pdoutdiv: '#distributor_profile'
        };
        var pfctrl = {
            pf: profile,
        };
        hideMajorDivs();
        var ob = new profileController();
        ob.__construct(pfctrl);
    });
    /* SIGNOUT */
    $(leftbuttons.LG).click(function () {
        $(OUTPUT).html($.trim(MODULES.signout));
        hideMajorDivs();
        console.log('I am in signout');
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {autoloader: true, action: 'logout', type: 'slave'},
            success: function (data, textStatus, xhr) {
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
            error: function () {
                $(sales.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    });
    $(leftbuttons.svn).click(function () {
        $(OUTPUT).html($.trim(MODULES.signout));
        hideMajorDivs();
        console.log('I am in signout');
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {autoloader: true, action: 'logout', type: 'slave'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(data);
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
            error: function () {
                $(sales.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    });
    /*new sale*/
    $(leftbuttons.sale).click(function () {
        $(OUTPUT).html($.trim(MODULES.sale));
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        var patty_addBasicInfo = {
            autoloader: true,
            action: 'addPattyBasicInfo',
            menuBut: '#addpattybut',
            parentDiv: '#pattyBasicInfo',
            form: '#addpattyForm',
            TVPtype: '#TVPtype',
            pack_type: 'pack_type',
            pt_msg: 'pack_type_msg',
            name: '#supp_name',
            label: '',
            img: '',
            sid: 0,
            sind: '',
            nmsg: '#supp_name_msg',
            product: '#prduct_name',
            prodmsg: '#prduct_name_msg',
            packs: '#num_packs',
            packsmsg: '#num_packs_msg',
            pid: 0,
            pind: 0,
            pdn_msg: '#prduct_name_msg',
            vehicle: '#vehicle_no',
            vh_msg: '#vd_msg',
            date: '#patty_date',
            pd_msg: '#pd_msg',
            but: '#inipattyBut'
        };
        var patty_select = {
            autoloader: true,
            action: 'selectPatty',
            parentDiv: '#selectsalespatty',
            pname: '#patty_sale_name',
            pnmsg: '#patty_sale_name_msg',
            listDiv: '#ps_list',
            ldLoader: '#psl_loader',
            deleteOk: '#deleteOk',
            deleteCancel: '#deleteCancel',
            sid: 0,
            pid: 0,
            pindex: 0,
            prdname: '',
            prdphoto: '',
            packtype: ''
        };
        var patty_sales = {
            autoloader: true,
            action: 'addPattySaleEntry',
            parentDiv: '#multiple_sales',
            menuBut: '#entrypattysbut',
            form: '#addsaleform',
            retailer: '#pd_customer',
            ret_msg: '#pd_customer_msg',
            rid: '',
            rind: '',
            img: '',
            label: '',
            pds: '#patty_date_sales',
            pds_msg: '#pds_msg',
            num_packs: '#num_packs',
            npmsg: '#edit_num_packs_msg',
            kg_packs: '#kg_packs',
            kpmsg: '#kg_packs_msg',
            rp: '#rate_packs',
            rpmsg: '#rate_packs_msg',
            rpa: '#calc_amt',
            rpamsg: '#calc_amt_msg',
            amtpd: '#amt_paid',
            amtpdmsg: '#amt_paid_msg',
            damtpd: '#due_pay',
            damtpdmsg: '#due_pay_msg',
            dd: '#due_date',
            ddmsg: '#due_date_msg',
            select: patty_select,
            but: '#addpattysalesBut'
        };
        var patpay_select = {
            autoloader: true,
            action: 'selectPatty',
            parentDiv: '#selectpaypatty',
            pname: '#patty_pay_name',
            pnmsg: '#patty_pay_name_msg',
            listDiv: '#pps_list',
            ldLoader: '#ppsl_loader',
            sid: 0,
            pid: 0,
            pindex: 0,
            prdname: '',
            prdphoto: '',
            packtype: '',
            sessind: 'list_of_pattys'
        };
        var accounts = {
            parentDiv: 'addPayBAC',
            num: 1,
            form: 'account_pay',
            bankname: 'bankname_pay',
            nmsg: 'banknamemsg_pay',
            accno: 'accno_pay',
            nomsg: 'accnomsg_pay',
            braname: 'braname_pay',
            bnmsg: 'branamemsg_pay',
            bracode: 'bracode_pay',
            bcmsg: 'bracodemsg_pay',
            IFSC: 'IFSC_pay',
            IFSCmsg: 'IFSCmsg_pay'
        };
        var patty_payemts = {
            parentDiv: '#multiple_payments',
            action: 'addPattyPay',
            form: '#salepayform',
            menuBut: '#paypattysbut',
            mopdiv: '#TvMopType',
            payee_id: '',
            sale_id: '',
            con_id: '',
            payee: '#pay_payee',
            payeemsg: '#pay_payee_msg',
            pdate: '#pay_date',
            pdmsg: '#pay_date_msg',
            ac_id: '',
            acdiv: '#TvMopAc',
            acdivtit: '#TvMopAcTit',
            pay_ac: 'pay_ac',
            payac_msg: 'pay_ac_msg',
            mop: 'mop_pay',
            mopmsg: 'mop_pay_msg',
            pamt: '#pay_amt',
            pamsg: '#pay_amt_msg',
            rmk: '#pay_rmk',
            rmkmsg: '#pay_rmk_msg',
            select: patpay_select,
            ac: accounts,
            but: '#addpattypayBut'
        };
        var patbill_select = {
            autoloader: true,
            action: 'selectPatty',
            parentDiv: '#selectbillpatty',
            pname: '#patty_bill_name',
            pnmsg: '#patty_bill_name_msg',
            listDiv: '#pps_bill_list',
            ldLoader: '#ppsl_bill_oader',
            sid: 0,
            pid: 0,
            pindex: 0,
            prdname: '',
            prdphoto: '',
            packtype: ''
        };
        var sales_summary = {
            parentDiv: '#bill_summary',
            supplier: '#bill_to',
            suppmsg: '#bill_to_msg',
            receivedon: '#rev_date',
            rnmsg: '#rev_date_msg',
            bdate: '#bill_date',
            bdatemsg: '#bill_date_msg',
            bqty: '#bill_qty',
            bqtymsg: '#bill_qty_msg',
            bprt: '#bill_prt',
            bprtmsg: '#bill_prt_msg',
            totwt: '#bill_kg_packs',
            totwtmsg: '#bill_kg_packs_msg',
            avgrt: '#bill_rate_packs',
            avgrtmsg: '#bill_rate_packs_msg',
            netsal: '#bill_calc_amt',
            netsalmsg: '#bill_calc_amt_msg'
        };
        var expenses = {
            parentDiv: '#bill_exp',
            hire: '#bill_lhir',
            hiremsg: '#bill_lhir_msg',
            comm: '#bill_comm',
            commmsg: '#bill_comm_msg',
            cash: '#bill_Cash',
            cashmsg: '#bill_Cash_msg',
            labr: '#bill_labr',
            labrmsg: '#bill_labr_msg',
            assnfee: '#bill_assnfee',
            assnfeemsg: '#bill_assnfee_msg',
            telefee: '#bill_telefee',
            telefeemsg: '#bill_telefee_msg',
            rmc: '#bill_rmc',
            rmcmsg: '#bill_rmc_msg',
            totexp: '#bill_tot_exp',
            totexpmsg: '#bill_tot_exp_msg'
        };
        var rotten = {
            parentDiv: '#bill_rotten',
            rotqt: '#bill_rotqt',
            rotqtmsg: '#bill_rotqt_msg',
            rotwt: '#bill_rotwt',
            rotwtmsg: '#bill_rotwt_msg',
            rot: '#bill_rot',
            rotmsg: '#bill_rot_msg',
            rotamt: '#rot_amt',
            rotamtmsg: '#rot_amt_msg'
        };
        var hunda = {
            parentDiv: '#bill_hunda',
            hunqt: '#bill_hunqt',
            hunqtmsg: '#bill_hunqt_msg',
            hunwt: '#bill_hunwt',
            hunwtmsg: '#bill_hunwt_msg',
            hun: '#bill_hun',
            hunmsg: '#bill_hun_msg',
            hunamt: '#hun_amt',
            hunamtmsg: '#hun_amt_msg'
        };
        var patty_bill = {
            parentDiv: '#multiple_billments',
            action: 'generatePattybill',
            form: '#salebillform',
            menuBut: '#billpattysbut',
            sale_id: '',
            con_id: '',
            select: patbill_select,
            summary: sales_summary,
            expenses: expenses,
            rotten: rotten,
            hunda: hunda,
            nsales: '#net_sales',
            nsalesmsg: '#net_sales_msg',
            but: '#addpattybillBut'
        };
        var patty_add = {
            action: 'addPatty',
            parentDiv: '#addpattyForm',
            form: '#adduserForm',
            menuBut: '#sales_menu',
            basicinfo: patty_addBasicInfo,
            sales: patty_sales,
            payments: patty_payemts,
            bill: patty_bill,
            url: window.location.href,
            display: false
        };
        var patty_list = {
            autoloader: true,
            action: 'listPatty',
            parentDiv: '#list_user',
            menuBut: '#listsale',
            listDiv: '#lstpattys',
            listLoad: '#lstpattysloader',
            url: window.location.href,
            display: false
        };
        var sales = {
            autoloader: true,
            outputDiv: '#output',
            parentDiv: '#pSales',
            menuDiv: '#sales_menu',
            menuBut: '#addpattybut',
            msgDiv: '#patty_message',
            userType: 'supplier',
            supplierlist: {},
            add: patty_add,
            list: patty_list,
            display: false
        };
        hideMajorDivs();
        var obj = new saleController();
        obj.__construct(sales);
    });
    $(leftbuttons.Setting).click(function () {
        $(mainpage.sidebar).hide();
        $('#buttoggle').show();
        $("#page-wrapper").css({"margin-left": "0"});
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.Setting));
        var adddetails = {
            menuBut: '#Setting',
            adddetailsform: '#adddetailsform',
            displaybilllogo: '#displaybilllogo',
            companyname: '#companyname',
            companyaddress: '#companyaddress',
            companylandline: '#companylandline',
            companyemail: '#companyemail',
            companymobile1: '#companymobile1',
            companymobile2: '#companymobile2',
            termsncondition: '#termsncondition',
            footermsg: '#footermsg',
            savesettingbut: '#upload_savesettingbut',
            check: 0,
            photo: '.picedit_box'
        };
        var seting = {
            adddetails: adddetails,
            url: window.location.href,
        };
        hideMajorDivs();
        var ob = new Setting();
        ob.__construct(seting);
    });
    $(leftbuttons.one).trigger('click');
    $("#page-wrapper").css({"margin-left": "250px"});
    $('#buttoggle').hide();
    $(mainpage.defaultView).show();
    $(mainpage.sidebar).show();
});
