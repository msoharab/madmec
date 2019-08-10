var loader = '#loader';
var OUTPUT = '#allOutput';
var email_reg_new = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var cell_reg_new = /[0-9]{10,20}$/;
;
/*document ready*/
$(document).ready(function () {
    fetchuserrequest();
    fetchcustrequest();
    var menubut = '.navbar-toggle';
    var mainPage = {
        navigation: '.menuAL',
        prefiex: '#ctrl',
        defaultView: '#ctrlDash',
        outDiv: '#output',
    };
    var navigation = {
        DASH: '#Dash',
        owneruser: '#owneruser',
        TPF: '#profile',
        EONE: '#EnquiryAdd',
        ETWO: '#EnquiryFollow',
        ETHR: '#EnquiryListAll',
        CONE: '#CustomerAdd',
        CTWO: '#CustomerEdit',
        CTHR: '#CustomerDel',
        CFOR: '#CustomerList',
        CFIVE: '#CGroupAdd',
        CSIX: '#CGroupEdit',
        CSVN: '#CGroupDel',
        CEGT: '#CGList',
        CNINE: '#CustomerImport',
        TONE: '#TrainerAdd',
        TTWO: '#TrainerList',
        TTHR: '#TrainerPay',
        TFOR: '#TrainerImport',
        MTWO: '#AddFacility',
        MTHR: '#AddOffer',
        MSIX: '#ListOffer',
        MSVN: '#AddPackage',
        MTEN: '#ListPackage',
        ATTONE: '#MarkCustAtt',
        ATTTWO: '#MarkTrinAtt',
        ACCONE: '#Fee',
        ACCTWO: '#PackageFee',
        ACCTHR: '#StaffPay',
        ACCFIVE: '#DueBalance',
        ACCFOR: '#ClubExpenses',
        STONE: '#StAccount',
        STTWO: '#StRegistrations',
        STTHR: '#StCustomers',
        STFOR: '#StEmployee',
        RONE: '#RClub',
        RTWO: '#RPackage',
        RTHR: '#RRegistrations',
        RFOR: '#RPayments',
        RFIVE: '#RExpenses',
        RSIX: '#RBalanceSheet',
        RSVN: '#RCustomers',
        REGT: '#REmployee',
        RNINE: '#RReceipts',
        CRMONE: '#CRMAPP',
        CRMTWO: '#CRMEmail',
        CRMTHR: '#CRMsms',
        CRMFOR: '#CRMFeedback',
        CRMFIVE: '#CRMExpiry',
        AddGym: '#AddGym',
        userrequestfrmmmadmin: '#userrequestfrmmmadmin',
        custrequestt: '#custrequestt',
    };
    loadJavaScript = function (src) {
        var jsSRC = $('<script type="text/javascript" src="' + src + '">');
        $(OUTPUT).append(jsSRC);
    };
    triggerToggle = function () {
        if ($(menubut).css('display') !== 'none')
            if ($(menubut).css('display') !== 'none')
                $(menubut).trigger('click');
    };
    $(navigation.userrequestfrmmmadmin).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.userrequest));
        var attr = {
            displaydetailsreq: '#displaydetailsreq',
            myModal_enqaddbtn: '#myModal_enqaddbtn',
            myModal_enqaddbody: '#myModal_enqaddbody',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'userrequest.js');
        var obj = new userRequest();
        obj.__construct(attr);
    });
    $(navigation.custrequestt).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.custrequest));
        var attr = {
            displaydetailsreq: '#displaydetailsreq',
            myModal_enqaddbtn: '#myModal_enqaddbtn',
            myModal_enqaddbody: '#myModal_enqaddbody',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'custrequest.js');
        var obj = new customerRequest();
        obj.__construct(attr);
    });
    $(navigation.DASH).click(function () {
        //triggerToggle();
        //$(OUTPUT).html($.trim(MODULES.clubSelect));
        var dashboard = {
            suboutdiv: '#list-gyms',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'dashboard.js');
        var obj = new load_dashboard();
        obj.__construct(dashboard);
    });
    $(navigation.owneruser).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.owneruser));
        var user_addAddress = {
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
        var adduser = {
            u_user_name: '#u_user_name',
            u_user_gender: '#u_user_gender',
            addusertype: '#addusertype',
            user_email: '#user_email',
            mobile: '#mobile',
            u_doc_type: '#u_doc_type',
            u_doc_number: '#u_doc_number',
            user_dob: '#user_dob',
            address: user_addAddress,
            but: '#addusrBut'
        };
        var assignuser = {
            form: '#assignuserform',
            asignuser: '#asignuser',
            asigngym: '#asigngym',
            adminid: 0,
            gymid: 0,
        };
        var attr = {
            adduser: adduser,
            assignuser: assignuser,
            displayowneruser: '#displayowneruser',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'owneruser.js');
        var obj = new ownerusers();
        obj.__construct(attr);
        var addres = new Address();
        addres.__construct({
            url: adduser.address.url,
            outputDiv: attr.outputDiv
        });
        obj.countries = addres.getCountry();
        obj.bindAddressFields(addres);
    });
    $(navigation.TPF).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.aprofile));
        var emailids = {
            parentDiv: '#pfmultiple_email',
            num: -1,
            form: '#pfemail_id_',
            email: '#pfemail_',
            msgDiv: '#pfemail_msg_',
            plus: '#pfplus_email_',
            minus: '#pfminus_email_'
        };
        var cnumbers = {
            parentDiv: '#pfmultiple_cnumber',
            num: -1,
            form: '#pfcnumber_',
            codep: '#pfccode_',
            nump: '#pfcnum_',
            msgDiv: '#pfcnum_msg_',
            plus: '#pfplus_cnumber_',
            minus: '#pfminus_cnumber_'
        };
        var user_addAddress = {
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
            form: '#addgymForm',
            name: '#gym_name',
            fee: '#gym_fee',
            tax: '#gym_tax',
            but: '#addgymBut',
            acs_id: '#acs_id',
            ac_msg: '#ac_msg',
            em: emailids,
            cn: cnumbers,
            address: user_addAddress
        };
        var profileDivs = {
            pfoutDiv: '#admin_profile',
            gymoutDiv: '#gym_profile',
            apfoutDiv: '#add_profile',
            pftab: '#profile',
            url: window.location.href,
            addgym: add_gym,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'profile.js');
        var obj = new controlProfile();
        obj.__construct(profileDivs);
    });
    /*---------------------------------ENQ-------------------------------*/
    /* Add enq*/
    $(navigation.EONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.enqadd));
        var enqadd = {
            form: 'enquiry_form',
            refer: 'ref_box',
            lrefer: 'list_ref',
            handel: 'handel_box',
            lhandel: 'list_handel',
            vname: 'eq_name',
            vnmsg: 'eq_name_msg',
            email: 'enq_email',
            emsg: 'enq_em_msgDiv',
            ccode: 'enq_codep',
            cdmsg: 'cdmsg',
            cell: 'enq_cnumber',
            cmsg: 'cmsg',
            fgoal: 'ft_goal',
            cmt: 'comments',
            f1: 'followup1',
            f2: 'followup2',
            f3: 'followup3',
            knwabt: 'knowabout',
            instin: 'interested',
            jop: 'jop',
            but: 'enquiry_save',
            msg: 'enq_add_msg',
            titleimg: 'enqaddimg',
        }
        var enqDivs = {
            url: window.location.href,
            add: enqadd,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'enquiry_add.js');
        var obj = new controlEnquiry();
        obj.__construct(enqDivs);
    });
    /*followups*/
    $(navigation.ETWO).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.enqflw));
        var follow1 = {
            tab: 'tFollowTab',
        };
        var follow2 = {
            tab: 'pFollowTab',
        };
        var follow3 = {
            tab: 'exFollowTab',
        };
        var listenq = {
            output: '#followOutput',
            url: window.location.href,
            tflw: follow1,
            pflw: follow2,
            exflw: follow3,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'enquiry_follow.js');
        loadJavaScript(URL + ASSET_JSF + MOD + 'enquiry_list.js');
        var obj = new controlEnquiryFollow();
        obj.__construct(listenq);
    });
    /*List All*/
    $(navigation.ETHR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.enqlist));
        var list = {
            menuDiv: '#menuHtml',
            htmlDiv: '#searhHtml',
            outputDiv: '#output',
            OptionsSearch: {
                "Enquiry": true,
                "Group": false,
                "Personal": false,
                "Offer": false,
                "Package": false,
                "Date": false,
                "All": false
            },
            SearchAllHide: {
                "Enquiry_ser_all": false,
                "Group_ser_all": true,
                "Personal_ser_all": true,
                "Offer_ser_all": true,
                "Package_ser_all": true,
                "Date_ser_all": true
            },
            output: '#ctEnquiryAllOutput',
        }
        var enq = {
            loader: '#center_loader',
            url: window.location.href,
            list: list,
        }
        loadJavaScript(URL + ASSET_JSF + MOD + 'enquiry_list.js');
        var obj = new controlEnquiryListAll();
        obj.__construct(enq);
    });
    /*--------------------------- customer-------------------------------*/
    /*Add Customer*/
    $(navigation.CONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.custadd));
        var emailids = {
            parentDiv: '#cadmultiple_email',
            num: -1,
            form: '#cademail_id_',
            email: '#cademail_',
            msgDiv: '#cademail_msg_',
            plus: '#cadplus_email_',
            minus: '#cadminus_email_'
        };
        var cnumbers = {
            parentDiv: '#cadmultiple_cnumber',
            num: -1,
            form: '#cadcnumber_',
            codep: '#cadccode_',
            nump: '#cadcnum_',
            msgDiv: '#cadcnum_msg_',
            plus: '#cadplus_cnumber_',
            minus: '#cadminus_cnumber_',
            /*gpAddBtn		: '#custg_savebtn',*/
            selectBox: '#cust_mod_pay_1',
            selectBoxMsg: '#mod_msg_1',
            textBox: '#alltextgrp_1',
            mopAdd: '#cust_addmop_1',
            amtText: '#cust_fee_mop_1',
        };
        var feerow = {
            plus: '#addfee_plus_',
            minus: '#addfee_minus_',
            num: 1,
            parentdiv: '#usr_fee_row_temp_',
            addfeeform: '#newaddpaymentbox_',
        };
        var custdata = {
            refername: '#ref_boxadd',
            saveBtn: '#cust_savebtn',
            name: '#cust_name',
            dob: '#dateofbirth',
            acsid: '#cust_acs',
            url: URL + 'address.php',
            country: '#gym_country',
            state: '#gym_province',
            district: '#gym_district',
            city_town: '#gym_city_town',
            street: '#gym_st_loc',
            address: '#gym_addrs',
            zipcode: '#gym_zipcode',
            website: '#gym_website',
            doj: '#dateofjoin',
            company: '#comp_name',
            occupation: '#cust_occ',
            occupationmsg: '#cust_ocmsg',
            ename: '#emer_name',
            enumber: '#emer_num',
            cemail: '#emer_email',
            ccellcode: '#cell_id',
            ccellnum: '#emer_cellnum',
            nmsg: '#cust_nmmsg',
            smsg: '#smsg',
            dobmsg: '#gym_dobmsg',
            mcountry: '#gym_comsg',
            mstate: '#gym_prmsg',
            mdistrict: '#gym_dimsg',
            mcity_town: '#gym_citmsg',
            mstreet: 'gym_stlmsg',
            maddress: '#gym_admsg',
            mzipcode: '#gym_zimsg',
            mwebsite: '#gym_wemsg',
            mrefer: '#cust_rfmsg',
            mdoj: '#gym_dojmsg',
            mcomp: '#customer_cpmsg',
            memnm: '#emnmmsg',
            memnum: '#emnummsg',
            memail: '#emmsg',
            mcellcd: '#cellmsg',
            mcell: '#cnummsg',
            custfact: '#cust_facility',
            msg: '#cust_add_msg',
            form: '#userdetails',
            phupload: '#photo_Cbut_edit',
            phbody: 'myModal_CPhoto',
            addplus: '#addr_show_but',
        };
        var custDivs = {
            em: emailids,
            cn: cnumbers,
            outDiv: '#refergynname',
            mofpayment: '#mod_pay_temp_01',
            modselect: '#mod_pay_select_01',
            feetemp_input: '#user_fee_temp_01',
            number_box: 'add_numerbox_',
            mofpaymentd: '#mod_pay_temp_',
            fee_input: '#user_fee_temp_',
            paymentrow: feerow,
            referBox: '#ref_boxadd',
            reciept: '#displayreciept',
            serach1: 'temp_serach',
            custsexParent: '#cust_sexParent',
            custsexMsg: '#cust_sexParentmsg',
            custinfo: custdata,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'customer_add.js');
        var obj = new controlCustomerAdd();
        obj.__construct(custDivs);
        var addres = new Address();
        addres.__construct({
            url: custdata.url,
            outputDiv: custDivs.outDiv
        });
        obj.countries = addres.getCountry();
        obj.bindAddressFields(addres, custdata);
    });
    /*list customer*/
    $(navigation.CFOR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.custlist));
        var listcustomer = {
            panelheading: '#cpanelheading',
            st_panel: '#cdympanel',
            pillpanel_div: '#cpanel_div',
            pillpanel_li: '#panel_li',
            allattTab: '#attcTab',
            listpackdiv: '#listcustdiv',
            editlistcustdiv: '#listcEditpack',
            listeditdis: '#listcustdata',
            editcustomerdiv: '#edit_customer',
            referPage: navigation.CFOR,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'customer_list.js');
        var obj = new controlCustomeList();
        obj.__construct(listcustomer);
    });
    /*Add Group*/
    $(navigation.CFIVE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.grpadd));
        var group = {
            id: '#Outbox',
            parent_div: '#ctrlCGroupAdd',
            action: 'groupAdd',
            autoloader: true,
            feerow: {
                plus: 'addfee_plus',
                minus: 'addfee_minus',
                num: -1,
                parentdiv: '#custmodeofpament',
                selectBox: 'cust_mod_pay',
                selectBoxMsg: 'mod_msg',
                amt: 'user_fee',
                amtmsg: 'user_fee_msg',
                mopnum: 'mopnum',
                textboxGrp: 'alltextgrp',
                keycodes: '#keycodes',
                row: 'usr_fee_row',
                addfeeform: 'newaddpaymentbox',
                mop: {
                    autoloader: true,
                    action: 'ModeOfPaymentselect',
                    gymid: -1,
                    type: 'slave',
                    url: window.location.href
                }
            },
            gname: '#groupmainname',
            gnamemag: '#custg_nmsg',
            gdescp: '#custg_descp',
            gdescpmsg: '#custg_descpmsg',
            memberlist: {
                outputDiv: '#createGroup',
                autoloader: true,
                action: 'listGroupMembers',
                type: 'slave',
                url: window.location.href,
                list: {}
            },
            type: 'slave',
            outputDiv: '#addGroupOutput',
            but: '#custg_savebtn',
            url: window.location.href
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'add_group.js');
        var obj = new controlCustomerAddGroup();
        obj.__construct(group);
    });
    /*edit grp*/
    $(navigation.CSIX).click(function () {
        triggerToggle();
        hideMajorDivs();
    });
    /*del grp*/
    $(navigation.CSVN).click(function () {
        triggerToggle();
        hideMajorDivs();
    });
    /*list grp*/
    $(navigation.CEGT).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.grplist));
        var listginfo = {
            panelheading: '#gpanelheading',
            st_panel: '#gdympanel',
            pillpanel_div: '#gpanel_div',
            pillpanel_li: '#panel_li',
            allattTab: '#attgTab',
            listgpdiv: '#listcgp',
            gropudis: '#listcustgp',
            editlistdiv: '#edit_listgp',
            editltctgrp: '#edit_listcustgp',
            referPage: navigation.CGET,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'list_grp.js');
        var obj = new controlCustomerListGroup();
        obj.__construct(listginfo);
    });
    /*import customer*/
    $(navigation.CNINE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.custimpt));
        $('#dissamplefileformat').html('<a href="' + URL + DOWNLOADS + 'dummy_users.xls" ><button type="button" class="btn btn-lg btn-success">DOWNLOAD</button></a>');
        var importcust = {
            ftype: 'import_cust_facility',
            fmsg: 'fctype_import_msg',
            fdata: '#cust_facility1',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'customer_import.js');
        var obj = new controlCustomerImport();
        obj.__construct(importcust);
    });
    /*---------------------------------Trainer------------------------------*/
    /* Add Trainer*/
    $(navigation.TONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.traadd));
        var trainerAdd = {
            form: 'trainerdetails',
            name: 'trainer_name',
            nmsg: 'name_msg',
            sex: 'trainer_sex',
            smsg: 'sex_msg',
            email: 'trainer_email',
            emsg: 'email_msg',
            mobile: 'trainer_mobile',
            mmsg: 'mobile_msg',
            ccode: 'cell_code',
            cmsg: 'cell_msg',
            ftype: 'trainer_facility',
            fmsg: 'ftype_msg',
            ttype: 'trainer_gym',
            tmsg: 'ttype_msg',
            but: 'trainerAdd',
            dob: 'dob',
            doj: 'doj',
            dob_msg: 'dob_msg',
            doj_msg: 'doj_msg',
            msg: 'trainer_add_msg',
            phupload: 'photo_but_edit',
            phclose: 'close_photo',
            phbody: 'myModal_Photo',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'trainer.js');
        var obj = new controlTrainer();
        obj.__construct(trainerAdd);
    });
    /* List Trainer*/
    $(navigation.TTWO).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.tralist));
        loadJavaScript(URL + ASSET_JSF + MOD + 'trainer_list.js');
        var obj = new controlListTrainer();
        obj.__construct();
    });
    /* Pay Trainer*/
    $(navigation.TTHR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.trapay));
        var trapay = {
            output: '#trainerPayoutput',
            url: window.location.href,
            paydate: '#tra_pay_date',
            payname: 'trainer_payname',
            nmmsg: '#names_msg',
            amt: 'amount',
            amtmsg: '#amts_msg',
            dec: 'trainer_description',
            alertbody: '#myModal_paybody',
            alert: '#myModal_paybtn',
            form: '#trainer_payform',
            btn: '#trainer_paySave',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'trainer_pay.js');
        var obj = new controlTrainerPay();
        obj.__construct(trapay);
    });
    /* Import Trainer*/
    $(navigation.TFOR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.traimpt));
        $('#dissamplefileformat').html('<a href="' + URL + DOWNLOADS + 'dummy_trainers2.xlsx" ><button type="button" class="btn btn-lg btn-success">DOWNLOAD</button></a>');
        var trainerImport = {
            ftype: 'import_facility',
            fmsg: 'ftype_import_msg',
            ttype: 'import_gym',
            tmsg: 'ttype_import_msg',
        }
        loadJavaScript(URL + ASSET_JSF + MOD + 'trainer_import.js');
        var obj = new controlTrainerImport();
        obj.__construct(trainerImport);
    });
    /*=========================================Manage==================*/
    $(navigation.MTWO).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.mngfacility));
        var addFact = {
            Addfacility: '#Addfacility',
            factname: '#factname',
            factstvalue: 'factstvalue',
            showstatus: '#showstatus',
            dupmsg: '#dupmsg',
            facilitysave: '#facilitysave',
            Showfacility: '#Showfacility',
            ctctShowFacility1: '#ctctShowFacility1',
            Reactivatefacility: '#Reactivatefacility',
            ctctShowFacility2: '#ctctShowFacility2'
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'manage_add_facility.js');
        var obj = new controlManageTwo();
        obj.__construct(addFact);
    });
    $(navigation.MTHR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.mngaddofr));
        var offeradd = {
            of_fact: '#of_facility',
            of_duration: '#of_duration',
            offerADbtn: '#offersave',
            of_day: '#of_no_days',
            valid_num: '#valid_num',
            of_price: '#of_prize',
            valid_price: '#valid_price',
            valid_nm: '#valid_nm',
            valid_duration: '#valid_duration',
            valid_fact: '#valid_fact',
            valid_member: '#valid_member',
            of_name: '#of_name',
            of_desc: '#of_des',
            of_mem: '#of_member',
            form: '#offer_form',
            of_descmsg: '#valid_desc',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'manage_add_offer.js');
        var obj = new controlManageThr();
        obj.__construct(offeradd);
    });
    $(navigation.MSIX).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.mnglistofr));
        var listoffer = {
            panelheading: '#opanelheading',
            st_panel: '#odympanel',
            pillpanel_div: '#opanel_div',
            pillpanel_li: '#panel_li',
            allattTab: '#attoTab',
            offpackdiv: '#offermpack',
            editoffdiv: '#offermEditpack',
            offdis: '#listofferdata',
            editofferdiv: '#edit_offer',
            referPage: navigation.MSIX,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'manage_list_offer.js');
        var obj = new controlManageSix();
        obj.__construct(listoffer);
    });
    $(navigation.MSVN).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.mngaddpack));
        var packageadd = {
            pack_type: '#pack_type',
            packsaveBtn: '#addpackageBtn',
            numofsession: '#pack_session',
            prize: '#pack_prize',
            form: '#addpackageform',
            typemsg: '#pack_tymsg',
            nfsmsg: '#pack_nsmsg',
            prizemsg: '#pack_rsmsg',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'manage_add_package.js');
        var obj = new controlManageSvn();
        obj.__construct(packageadd);
    });
    $(navigation.MTEN).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.mnglistpack));
        var listpack = {
            panelheading: '#ppanelheading',
            st_panel: '#pdympanel',
            pillpanel_div: '#ppanel_div',
            pillpanel_li: '#panel_li',
            allattTab: '#attTab',
            referPage: navigation.MTEN,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'manage_list_package.js');
        var obj = new controlManageTen();
        obj.__construct(listpack);
    });
    /*=========================================Attendance==================*/
    $(navigation.ATTONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.mngatten));
        var attend = {
            user: 'customer',
            header: '#pageheader',
            parent_div: '#mark_att',
            output: '#attOutput',
            st_panel: '#dympanel',
            allattTab: 'attTab',
            pillpanel_div: '#panel_div0',
            referPage: navigation.ATTONE,
            defalt: {
                id: '#Default',
                parent_div: '#default_att',
                pillpanel_div: '#panel_div0',
                action: 'default',
                fid: null,
                fname: '',
                sindex: null
            },
            mark: {
                id: '#Mark',
                parent_div: '#mark_att',
                pillpanel_div: '#panel_div1',
                action: 'markCustAtt',
                fid: null,
                fname: '',
                sindex: null
            },
            unmark: {
                id: '#UnMark',
                parent_div: '#unmark_att',
                pillpanel_div: '#panel_div2',
                action: 'unmarkCustAtt',
                fid: null,
                fname: '',
                sindex: null
            },
            action: 'default'
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'attendence.js');
        $(attend.header).html('Customer Attendance');
        var obj = new controlManage();
        obj.__construct(attend);
    });
    $(navigation.ATTTWO).click(function () {
        triggerToggle();
        $(OUTPUT).html('');
        $(OUTPUT).html($.trim(MODULES.mngatten));
        var attend = {
            user: 'employee',
            header: '#pageheader',
            parent_div: '#mark_att',
            output: '#attOutput',
            st_panel: '#dympanel',
            allattTab: 'attTab',
            pillpanel_div: '#panel_div0',
            referPage: navigation.ATTONE,
            defalt: {
                id: '#Default',
                parent_div: '#default_att',
                pillpanel_div: '#panel_div0',
                action: 'default',
                fid: null,
                fname: '',
                sindex: null
            },
            mark: {
                id: '#Mark',
                parent_div: '#mark_att',
                pillpanel_div: '#panel_div1',
                action: 'markCustAtt',
                fid: null,
                fname: '',
                sindex: null
            },
            unmark: {
                id: '#UnMark',
                parent_div: '#unmark_att',
                pillpanel_div: '#panel_div2',
                action: 'unmarkCustAtt',
                fid: null,
                fname: '',
                sindex: null
            },
            action: 'default',
            url: window.location.href
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'attendence.js');
        $(attend.header).html('Employee Attendance');
        var obj = new controlManage();
        obj.__construct(attend);
    });
    /*---------------------------------Account------------------------------*/
    /* Facility Fee*/
    $(navigation.ACCONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.accfctfee));
        var account = {
            output: '#outputfee',
            grpoutput: '#outputGroup',
            url: window.location.href,
            feeTab: '#dynamicFee',
            ftitle: '#feeName',
            smenu: '#feeSubMenu',
            list_type: 'offer',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'account_fee.js');
        var obj = new controlAccountFee();
        obj.__construct(account);
    });
    /*package fee*/
    $(navigation.ACCTWO).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.accpackfee));
        var package = {
            output: '#listUserPackage',
            grpoutput: '#outputGroupPackage',
            url: window.location.href,
            smenu: '#btnListPackage',
            list_type: 'package',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'account_fee.js');
        var obj = new controlAccountFee();
        obj.__construct(package);
    });
    /*balance due fee*/
    $(navigation.ACCFIVE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.accduebal));
        var due = {
            output: '#outputDueBalance',
            url: window.location.href,
            feeTab: '#dynamicDueBalance',
            ftitle: '#DueBalanceName',
            smenu: '#DueBalanceSubMenu',
            list_type: 'due',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'account_fee.js');
        var obj = new controlAccountFee();
        obj.__construct(due);
    });
    /*staff payment*/
    $(navigation.ACCTHR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.accstfpay));
        var stfpay = {
            output: '#StaffPayoutput',
            url: window.location.href,
            paydate: '#st_pay_date',
            payname: 'payname',
            nmmsg: '#name_msg',
            amt: 'amount',
            amtmsg: '#amt_msg',
            dec: 'description',
            alertbody: '#myModal_paybody',
            alert: '#myModal_paybtn',
            form: '#payform',
            btn: '#paySave',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'acc_staff_pay.js');
        var obj = new controlStaffPay();
        obj.__construct(stfpay);
    });
    /*staff payment*/
    $(navigation.ACCFOR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.accexp));
        var exp = {
            url: window.location.href,
            form: '#frmexp',
            name: 'expname',
            nmmsg: '#expnm_msg',
            amtmsg: '#expamt_msg',
            amt: 'expamount',
            rptmsg: '#exprpt_msg',
            rpt: 'exprpt_no',
            dt: '#exppay_date',
            dec: 'expdescription',
            alertbody: '#myModal_expbody',
            alert: '#myModal_expbtn',
            btn: '#expsave',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'acc_club_expense.js');
        var obj = new controlClubExpenses();
        obj.__construct(exp);
    });
    /*---------------------------------Stats------------------------------*/
    /*Stats for account*/
    $(navigation.STONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.stsacc));
        var sacc = {
            url: window.location.href,
            output: '#ctStAccount',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'stat_account.js');
        var obj = new controlStatAccount();
        obj.__construct(sacc);
    });
    /*Stats for registration*/
    $(navigation.STTWO).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.stsreg));
        var reg = {
            url: window.location.href,
            output: '#ctStRegistrations',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'stat_registration.js');
        var obj = new controlStatRegistration();
        obj.__construct(reg);
    });
    /*Stats for customer*/
    $(navigation.STTHR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.stscust));
        var cust = {
            url: window.location.href,
            output: '#StCustomersoutput',
            alertbody: '#myModal_custbody',
            alert: '#myModal_custbtn',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'stat_customer.js');
        var obj = new controlStatCustomer();
        obj.__construct(cust);
    });
    /*Stats for employee*/
    $(navigation.STFOR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.ststra));
        var emp = {
            url: window.location.href,
            output: '#stEmpoutput',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'stat_employee.js');
        var obj = new controlStatEmployee();
        obj.__construct(emp);
    });
    /*---------------------------------Reports------------------------------*/
    /*Club report*/
    $(navigation.RONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.repclub));
        var club = {
            url: window.location.href,
            output: '#outputClub',
            feeTab: '#dynamicFees',
            ftitle: '#ClubName',
            smenu: '#ClubSubMenu',
            list_type: 'offer',
            form: '#reportform',
            butrep: 'genrep',
            formdata: '#outputreport',
            labeltitle: '#fromToTitle',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_club.js');
        var obj = new controlClubReport();
        obj.__construct(club);
    });
    /*Package Report*/
    $(navigation.RTWO).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.reppack));
        var arg = {
            url: window.location.href,
            form: '#pacform',
            dt1: '#pacdate1',
            dt2: '#pacdate2',
            btn: '#pacbutton',
            output: '#pacOutput',
            type_reports: 'PackageReport',
            key: 'pr',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_registration.js');
        var obj = new controlRegistrationReport();
        obj.__construct(arg);
    });
    /*Registration Report*/
    $(navigation.RTHR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.repreg));
        var arg = {
            url: window.location.href,
            form: '#regform',
            dt1: '#regdate1',
            dt2: '#regdate2',
            btn: '#regbutton',
            output: '#regOutput',
            type_reports: 'RegistrationReport',
            key: 'rg',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_registration.js');
        var obj = new controlRegistrationReport();
        obj.__construct(arg);
    });
    /*Payments Report*/
    $(navigation.RFOR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.reppay));
        var arg = {
            url: window.location.href,
            form: '#payform',
            dt1: '#paydate1',
            dt2: '#paydate2',
            btn: '#paybutton',
            output: '#payOutput',
            type_reports: 'PaymentsReport',
            key: 'py',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_registration.js');
        var obj = new controlRegistrationReport();
        obj.__construct(arg);
    });
    /*Expences Report*/
    $(navigation.RFIVE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.repexp));
        var arg = {
            url: window.location.href,
            form: '#expform',
            dt1: '#expdate1',
            dt2: '#expdate2',
            btn: '#expbutton',
            output: '#expOutput',
            type_reports: 'ExpensesReport',
            key: 'ex',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_registration.js');
        var obj = new controlRegistrationReport();
        obj.__construct(arg);
    });
    /*Balance Sheet Report*/
    $(navigation.RSIX).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.repbal));
        var arg = {
            url: window.location.href,
            form: '#balform',
            dt1: '#baldate1',
            dt2: '#baldate2',
            btn: '#balbutton',
            output: '#balOutput',
            type_reports: 'BalanceSheet',
            key: 'bs',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_registration.js');
        var obj = new controlRegistrationReport();
        obj.__construct(arg);
    });
    /*Customer Report*/
    $(navigation.RSVN).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.repcust));
        var arg = {
            url: window.location.href,
            form: '#custform',
            dt1: '#custdate1',
            dt2: '#custdate2',
            btn: '#custbutton',
            output: '#custOutput',
            type_reports: 'CustomerAttendanceReport',
            key: 'ca',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_registration.js');
        var obj = new controlRegistrationReport();
        obj.__construct(arg);
    });
    /*Employee Report*/
    $(navigation.REGT).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.repemp));
        var arg = {
            url: window.location.href,
            form: '#empform',
            dt1: '#empdate1',
            dt2: '#empdate2',
            btn: '#empbutton',
            output: '#empOutput',
            type_reports: 'TrainerAttendanceReport',
            key: 'ta',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_registration.js');
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_club.js');
        var obj = new controlRegistrationReport();
        obj.__construct(arg);
    });
    /*Receipt Report*/
    $(navigation.RNINE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.reprec));
        var receipt = {
            url: window.location.href,
            outputDivRec: '#rec_output_display',
            outputrec: '#rec_output',
            receiptbut: '#receiptButton',
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'report_receipt.js');
        var obj = new controlReceiptReport();
        obj.__construct(receipt);
    });
    /*---------------------------------CRM------------------------------*/
    /* Mobile app manager*/
    $(navigation.CRMONE).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.crmmob));
        var app = {
            user: 'customer',
            header: '#pageheader',
            parent_div: '#ctrlCRMMobileApp',
            target_div: '#listMessage',
            referPage: navigation.CRMONE,
            tbl: 'crm_messages',
            defalt: {
                id: '#Outbox',
                parent_div: '#CRMAPPParentTarget',
                target_div: '#listMessage',
                action: 'loadAllMsg'
            },
            compose: {
                id: '#Compose',
                parent_div: '#CRMAPPParentTarget',
                target_div: '#createMessage',
                action: 'createMessage'
            },
            outbbox: {
                id: '#Outbox',
                parent_div: '#CRMAPPParentTarget',
                target_div: '#listMessage',
                action: 'loadAllMsg'
            },
            expired: {
                id: '#Expired',
                parent_div: '#CRMAPPParentTarget',
                target_div: '#exp_cust',
                action: 'exp_cust'
            },
            showups: {
                id: '#Noshow-ups',
                parent_div: '#CRMAPPParentTarget',
                target_div: '#tracker_cust',
                action: 'showups'
            },
            followups: {
                id: '#Follow-ups',
                parent_div: '#CRMAPPParentTarget',
                target_div: '#follow_cust',
                action: 'follow_cust'
            },
            stats: {
                id: '#Statistics',
                parent_div: '#CRMAPPParentTarget',
                target_div: '#crm_statistics',
                action: 'tracker_cust'
            },
            action: 'loadAllMsg',
            url: window.location.href
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'crm_app.js');
        var obj = new controlCRMApp();
        obj.__construct(app);
    });
    /*Email manager*/
    $(navigation.CRMTWO).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.crmmob));
        $('#output_new_load').attr('name', 'crm_email');
        var links = {
            one: '#MCompose',
            two: '#MOutbox',
            thr: '#MExpired',
            four: '#MNoshow',
            five: '#MFollow',
            six: '#MStatistics',
        };
        var app = {
            cout: '#listMessage',
            showmsg: '#show_messages',
            output: '#crmapp',
            tbl: 'crm_email',
            hding: '#crmtitle',
            hdtext: 'Email Manager',
            link: '#MSGmenu',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'crm_app.js');
        var obj = new controlCRMApp();
        obj.__construct(app);
    });
    /* SMS manager*/
    $(navigation.CRMTHR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.crmmob));
        $('#output_new_load').attr('name', 'crm_sms');
        var links = {
            one: '#MCompose',
            two: '#MOutbox',
            thr: '#MExpired',
            four: '#MNoshow',
            five: '#MFollow',
            six: '#MStatistics',
        }
        var app = {
            cout: '#listMessage',
            showmsg: '#show_messages',
            output: '#crmapp',
            tbl: 'crm_sms',
            hding: '#crmtitle',
            hdtext: 'SMS Manager',
            link: '#MSGmenu',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'crm_app.js');
        var obj = new controlCRMApp();
        obj.__construct(app);
    });
    /*Feedback*/
    $(navigation.CRMFOR).click(function () {
        triggerToggle();
        $(OUTPUT).html($.trim(MODULES.crmfeed));
        var feed = {
            fout: '#output_load1',
            showmsg: '#app_msg_history',
            feedout: '#output_load2',
            loadf: '#LoadFeedbackForm',
            tabf: '#feedback_form',
            tab_tot: '#total_msg',
            tblist: '#listTab',
            save_msg: '#msgdiv',
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'crm_feedback.js');
        var obj = new controlCRMFeedBack();
        obj.__construct(feed);
    });
    /*Expiry intimation*/
    $(navigation.CRMFIVE).click(function () {
        triggerToggle();
        $(OUTPUT).html('Coming Soon...');
    });
    /* Add Gym */
    $(navigation.AddGym).click(function () {
        //triggerToggle();
        $(OUTPUT).html($.trim(MODULES.addgym));
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
        var attr = {
            addgym: add_gym,
            url: window.location.href,
        };
        loadJavaScript(URL + ASSET_JSF + MOD + 'add_gym.js');
        var obj = new addGym();
        obj.__construct(attr);
        var addres = new Address();
        addres.__construct({
            url: add_gym.address.url,
            outputDiv: attr.outputDiv
        });
        obj.countries = addres.getCountry();
        obj.bindAddressFields(addres);
    })
});
function fetchuserrequest() {
    $.ajax({
        url: 'control.php',
        type: 'POST',
        data: {
            autoloader: 'true',
            action: 'fetchuserrequest',
            type: 'master',
        },
        success: function (data) {
            data = $.trim(data);
            switch (data) {
                case 'logout':
                    logoutAdmin({});
                    break;
                case 'login':
                    loginAdmin({});
                    break;
                default:
                    $('#displayreqts').html(data + ' Requests');
                    break;
            }
        },
        error: function () {
            $(OUTPUT).html(INET_ERROR);
        },
        complete: function (xhr, textStatus) {
            /*console.log(xhr.status);*/
        }
    });
}
;
function fetchcustrequest() {
    $.ajax({
        url: 'control.php',
        type: 'POST',
        data: {
            autoloader: 'true',
            action: 'fetchcustrequest',
            type: 'master',
        },
        success: function (data) {
            data = $.trim(data);
            switch (data) {
                case 'logout':
                    logoutAdmin({});
                    break;
                case 'login':
                    loginAdmin({});
                    break;
                default:
                    $('#custrequest').html(data + ' Requests');
                    break;
            }
        },
        error: function () {
            $(OUTPUT).html(INET_ERROR);
        },
        complete: function (xhr, textStatus) {
            /*console.log(xhr.status);*/
        }
    });
}
