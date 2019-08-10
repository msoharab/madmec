$(document).ready(function () {
    var mainpage = {
        leftbuttons: '.atleftmenu',
        prefiex: '#p',
        defaultView: '#pClients',
        outputDiv: '#output',
        sidebar: '#sidebar',
        sidemenu: '#side-menu'
    };
    var leftbuttons = {
        one: '#Clients',
        two: '#Order_follow-Ups',
        thr: '#client_collection',
        four: '#logouts',
        fiv: '#admin_dues',
        six: '#admin_duefollowup',
        NOTIFY: '#notification',
        lg: '#alogouts'
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
            $(mainpage.prefiex + $(this).attr('id')).hide();
        });
        $(mainpage.leftbuttons).each(function () {
            $(this).click(function (evt) {
                $(mainpage.prefiex + evt.target.id).show();
                return;
            });
        });
    }
    ;
    /* clients*/
    $(leftbuttons.one).click(function () {
        $(OUTPUT).html($.trim(MODULES.client));
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
        var user_list = {
            autoloader: true,
            action: 'listUsers',
            parentDiv: '#list_client',
            menuBut: '#listbut',
            listDiv: '#accorlist',
            listLoad: '#lstusrloader',
            url: window.location.href,
            display: false
        };
        var add_client = {
            form: "#addusrForm",
            type: "#validity_type",
            typediv: "#validitytype",
            name: "#distributer_name",
            owner: "#owners_name",
            sms: "#sms_cost",
            but: "#addClientBut",
            acs_id: '#acs_id',
            ac_msg: '#ac_msg',
            paydate: '#payment_date',
            paydate_msg: '#payment_date_msg',
            subdate: '#subscribe_date',
            subdate_msg: '#subscribe_date_msg',
            name_msg: '#Distributer_name_msg',
            owner_msg: '#owners_name_msg',
            type_msg: '#validate_type_msg',
            picbox: '.picedit_box',
            doctype: '#doc_type',
            dtmsg: '#doc_type_msg',
            docno: '#doc_number',
            dnmsg: '#doc_num_msg',
            em: emailids,
            cn: cnumbers,
            list: user_list,
            address: user_addAddress
        };
        var client = {
            url: window.location.href,
            outputDiv: '#output',
            menuDiv: '#user_menu',
            msgDiv: '#usr_message',
            addclient: add_client,
            addusrBut: '#addusrBut',
        };
        hideMajorDivs();
        var obj = new clientController();
        obj.__construct(client);
        addres = new Address();
        addres.__construct({url: client.addclient.address.url, outputDiv: client.outputDiv});
        addres.getIPData(client);
        //addres.fillAddressFields(user);
        obj.countries = addres.getCountry();
        obj.bindAddressFields(addres);

    });
    /* order follow ups */
    $(leftbuttons.two).click(function () {
        $(OUTPUT).html($.trim(MODULES.orderfollowups));
        var order_BasicInfo = {
            name: '#client_name',
            nmsg: '#client_name_msg',
            num: '#client_number',
            nummsg: '#client_number_msg',
            otamt: '#ot_amt',
            otamtmsg: '#ot_amt_msg',
            email: '#client_email',
            emailmsg: '#client_email_msg',
            handledby: '#client_handby',
            handlebymsg: '#client_handby_msg',
            refby: '#client_refby',
            refbymsg: '#client_refby_msg',
            ord_prb: '#client_order_prob',
            ord_prbmsg: '#client_order_prob_msg',
            comment: '#client_comments',
            commentmsg: '#client_comment_msg',
            cdate: '#client_date',
            cdate_msg: '#client_date_msg',
            but: '#addclientBut',
            butmsg: '#client_add_msg',
            url: window.location.href,
            form: '#addfupsForm',
            outputDiv: '#output',
            listLoad: '#lstloader',
            listDiv: '#lstclients',
            listclient: '#list_order_follow_ups'
        };
        window.setTimeout(function () {
            $(order_BasicInfo.cdate).datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
            });
        });
        hideMajorDivs();
        var obj = new orderController();
        obj.__construct(order_BasicInfo);
    });
    /*collection*/
    $(leftbuttons.thr).click(function () {
        $(OUTPUT).html($.trim(MODULES.admincollection));
        var user_select = {
            pid: 0,
            pindex: 0,
            coltrid: 0,
            coltrind: 0,
            sessind: 'list_of_distributor'
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
            clientid: 0,
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
            amtpaid: '#colls_amt_paid',
            apmsg: '#colls_amt_paid_msg',
            amtdue: '#colls_amt_due',
            payment: '#payment_date',
            payment_msg: '#payment_date_msg',
            subsdate: '#subscribe_date',
            subsdatemsg: '#subscribe_date_msg',
            admsg: '#colls_amt_due_msg',
            duedate: '#colls_due_date',
            ddmsg: '#colls_due_date_msg',
            rmk: '#colls_rmk',
            rmkmsg: '#colls_rmk_msg',
            validity: '#validity_type',
            validity_msg: '#validity_type_msg',
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
        var followups = {
            parentDiv: '#multiple_followups',
            num: -1,
            form: '#followup_id_',
            followupdate: '#followupdate_',
            msgDiv: '#followupdate_msg_',
            plus: '#plus_followups_',
            minus: '#minus_followups_',
            displayfollowups: '#displayfollowups',
        };
        var colls = {
            autoloader: true,
            outputDiv: '#output',
            followups: followups,
            parentDiv: '#pCollection',
            menuDiv: '#colls_menu',
            msgDiv: '#colls_message',
            add: user_colls,
            list: list_colls,
            url: URL + 'control.php',
            display: false
        };
        hideMajorDivs();
        var obj = new admincollectionctrl();
        obj.__construct(colls);
    });
    $(leftbuttons.four).click(function () {
        $(OUTPUT).html($.trim(MODULES.sout));
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                autoloader: true,
                action: 'logout',
                type: 'master',
            },
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
    $(leftbuttons.fiv).on('click', function () {
        $(OUTPUT).html($.trim(MODULES.dueadmin));

        var addue = {
            disdues: '#disdues',
            url: URL + 'control.php',
            display: false
        };
        hideMajorDivs();
        var obj = new admindue();
        obj.__construct(addue);
    });
    $(leftbuttons.six).on('click', function () {
        $(OUTPUT).html($.trim(MODULES.duefollowups));
        var adfollows = {
            current_followmenubut: '#current_followmenubut',
            pending_followmenubut: '#pending_followmenubut',
            expired_followmenubut: '#expired_followmenubut',
            current_follow_data: '#current_follow_data',
            pending_follow_data: '#pending_follow_data',
            expired_follow_data: '#expired_follow_data'

        };
        hideMajorDivs();
        var obj = new adminfollowup();
        obj.__construct(adfollows);
    });
    /*   NOTIFICATION */
    $(leftbuttons.NOTIFY).click(function () {
        //$(mainpage.sidebar).hide();
        $('#buttoggle').show();
        //$("#page-wrapper").css( { "margin-left" : "0" } );
        $(mainpage.outputDiv).show();
        $(OUTPUT).html($.trim(MODULES.notify));
        var notify_list = {
            displaynotifications: '#displaynotifications',
            url: window.location.href,
            display: false
        };
        hideMajorDivs();
        var obj = new notifyController();
        obj.__construct(notify_list);
    });
    $(leftbuttons.one).trigger('click');
    $(mainpage.defaultView).show();
    $(document).click(function (evt) {
        //evt.preventDefault();
        //evt.stopPropagation();
    });
    $(leftbuttons.one).trigger('click');
    $(mainpage.defaultView).show();
    $(document).click(function (evt) {
        //evt.preventDefault();
        //evt.stopPropagation();
    });
});

