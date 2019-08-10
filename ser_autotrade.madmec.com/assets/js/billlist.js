function billlistController() {
    var sales = {};
    var listofSuppliers = {};
    var listofRetailers = {};
    var listofProducts = {};
    var listofPattys = {};
    var listofSales = {};
    var listofPackTypes = {};
    var listofMOPtypes = {};
    var listofBankAC = {};
    var listofCommisions = {};
    var saleEntry = {};
    this.__construct = function (pctrl) {
        sales = pctrl;
        fetchCommisions();

        fetchPatty({main: sales.add.bill});
        $(sales.add.bill.but).click(function () {
            generateBill();
        });
        $(sales.list.menuBut).click(function () {
            $(sales.msgDiv).html('');
            DisplayPattyList();
        });
        $(sales.add.sales.pds + ' , ' + sales.add.sales.dd + ' , ' + sales.add.payments.pdate + ' , ' + sales.add.bill.summary.bdate).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(sales.add.sales.select.pname + ' , ' + sales.add.sales.retailer + ' , ' + sales.add.basicinfo.product + ' , ' + sales.add.basicinfo.name).bind('focus', function () {
            $(this).val('');
        });
        $(sales.add.sales.kg_packs + ' , ' + sales.add.sales.rp + ' , ' + sales.add.sales.amtpd).change(function () {
            if ($(sales.add.sales.kg_packs).val().match(ind_reg)) {
                $(sales.add.sales.kpmsg).html(VALIDNOT);
            }
            else {
                $(sales.add.sales.kpmsg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($(sales.add.sales.kpmsg).offset().top) - 95}, "slow");
                $(sales.add.sales.kg_packs).show().focus();
                return;
            }
            if ($(sales.add.sales.rp).val().match(ind_reg)) {
                $(sales.add.sales.rpmsg).html(VALIDNOT);
            }
            else {
                $(sales.add.sales.rpmsg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($(sales.add.sales.rpmsg).offset().top) - 95}, "slow");
                $(sales.add.sales.rp).show().focus();
                return;
            }
            if ($(sales.add.sales.amtpd).val().match(ind_reg)) {
                $(sales.add.sales.amtpdmsg).html(VALIDNOT);
            }
            else {
                $(sales.add.sales.amtpdmsg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($(sales.add.sales.amtpdmsg).offset().top) - 95}, "slow");
                $(sales.add.sales.amtpd).show().focus();
                return;
            }
            var kg = Number($(sales.add.sales.kg_packs).val());
            var rp = Number($(sales.add.sales.rp).val());
            var tot = Math.floor(Number(kg * rp));
            var pad = Number($(sales.add.sales.amtpd).val());
            var due = 0;
            $(sales.add.sales.rpa).val(tot);
            $(sales.add.sales.rpamsg).html(ntow(tot));
            if (tot > pad)
                due = Number(tot - pad);
            $(sales.add.sales.damtpd).val(due);
            $(sales.add.sales.damtpdmsg).html(ntow(due));
            if (kg < 0 || rp < 0 || pad < 0 || due < 0) {
                $(sales.add.sales.kg_packs + ',' + sales.add.sales.rp + ',' + sales.add.sales.damtpd + ',' + sales.add.sales.amtpd).val(0);
            }
        });
        $(sales.add.bill.summary.avgrt + ' , ' + sales.add.bill.expenses.hire + ' , ' + sales.add.bill.expenses.labr + ' , ' +
                sales.add.bill.expenses.assnfee + ' , ' + sales.add.bill.expenses.telefee + ' , ' + sales.add.bill.expenses.rmc + ' , ' +
                sales.add.bill.rotten.rotamt + ' , ' + sales.add.bill.hunda.hunamt).change(function () {
            calculateNetSales();
        });

        clearPattyPayForm();
        clearPattyBillForm();

        $(sales.add.sales.menuBut).click(function () {
            fetchPatty({main: sales.add.sales});
            fetchRetailers();
            $(sales.add.sales.menuBut).unbind();
        });
        $(sales.add.payments.menuBut).click(function () {
            fetchPatty({main: sales.add.payments});
            fetchMOPTypes();
            $(sales.add.payments.menuBut).unbind();
        });
        $(sales.add.bill.menuBut).click(function () {
            fetchPatty({main: sales.add.bill});
            $(sales.add.bill.menuBut).unbind();
        });
    };

    function fetchPatty(para) {
        var rad = '';
        var todo = 'edit';
        if (para.main.action && para.main.action == 'generatePattybill') {
            todo = para.main.action;
        }
        else if (para.main.payee) {
            todo = 'pay';
        }
        var action = '';
        $(para.main.select.pnmsg).html(LOADER_TWO);
        $.ajax({
            type: 'POST',
            url: sales.add.url,
            data: {autoloader: true, action: 'fetchPatty'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        listofPattys = $.parseJSON(data);
                        for (i = 0; i < listofPattys.length; i++) {
                            rad += listofPattys[i]["html"];
                        }
                        var name = para.main.select.pname.slice(1, para.main.select.pname.length);
                        var nmsg = para.main.select.pnmsg.slice(1, para.main.select.pnmsg.length);
                        $(para.main.select.pname).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Patty</option>' + rad + '</select>');
                        $(para.main.select.listDiv).html('');
                        $(para.main.select.pnmsg).html('Enter / Select');
                        $(para.main.select.pname).change(function () {
                            var type = $.trim($('#' + name + ' option:selected').text());
                            if (type != 'Select Patty' && $(this).val() != 'Null') {
                                for (i = 0; i < listofPattys.length; i++) {
                                    if (Number(listofPattys[i]["id"]) == Number($(this).val())) {
                                        para.main.select.sid = Number(listofPattys[i]["uid"]);
                                        para.main.select.pid = Number(listofPattys[i]["id"]);
                                        para.main.select.pindex = Number(listofPattys[i]["value"]);
                                        para.main.select.prdname = listofPattys[i]["pname"];
                                        para.main.select.prdphoto = listofPattys[i]["prdphoto"];
                                        para.main.select.packtype = listofPattys[i]["packtype"];
                                        if (para.main.payee) {
                                            $(para.main.payee).val(listofPattys[i]["label"]);
                                            $(para.main.payee).prop('disabled', 'disabled');
                                            $(para.main.payeemsg).html(VALIDNOT);
                                            fetchBankAccount(para.main);
                                        }
                                        if (para.main.action && para.main.action == 'generatePattybill') {
                                            var det = listofPattys[i]["label"].split('♥');
                                            $(para.main.summary.supplier).val($.trim(det[0]));
                                            $(para.main.summary.receivedon).val($.trim(det[1]));
                                            $(para.main.summary.bprt).val($.trim(det[2]) + '-' + $.trim(det[4]));
                                            action = 'generatePattybill';
                                        }
                                        populateSalesList({
                                            ptid: para.main.select.pid,
                                            listDiv: para.main.select.listDiv,
                                            todo: todo,
                                            action: action,
                                            main: para.main
                                        });
                                        break;
                                    }
                                    else {
                                        para.main.select.sid = 0;
                                        para.main.select.pid = 0;
                                        para.main.select.pindex = 0;
                                        sales.add.sales.rind = 0;
                                        para.main.select.prdname = '';
                                        para.main.select.prdphoto = '';
                                        para.main.select.packtype = '';
                                        if (para.main.payee != 'undefined') {
                                            $(para.main.payee).val('');
                                            $(para.main.payee).removeAttr('disabled');
                                            $(para.main.payeemsg).html("Select patty");
                                        }
                                    }
                                }
                            }
                        });
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
    }
    ;
    function fetchMOPTypes() {
        var rad = '';
        $(sales.add.acdiv).hide();
        $.ajax({
            type: 'POST',
            url: sales.add.url,
            data: {autoloader: true, action: 'fetchMOPTypes'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var type = $.parseJSON(data);
                        listofMOPtypes = type;
                        for (i = 0; i < type.length; i++) {
                            rad += type[i]["html"];
                        }
                        $(sales.add.payments.mopdiv).html('<select class="form-control" id="' + sales.add.payments.mop + '"><option value="NULL" selected>Select Mode of payment</option>' + rad + '</select><p class="help-block" id="' + sales.add.payments.mopmsg + '">Enter/ Select.</p>');
                        $(document.getElementById(sales.add.payments.mop)).change(function () {
                            fetchBankAccount(sales.add.payments);
                            $(sales.add.acdiv).hide();
                        });
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
    }
    ;
    function fetchCommisions() {
        var rad = '';
        $.ajax({
            type: 'POST',
            url: sales.add.url,
            data: {autoloader: true, action: 'fetchCommisions'},
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
                    default:
                        var type = $.parseJSON(data);
                        listofCommisions = type;
                        for (i = 0; i < type.length; i++) {
                            rad += type[i]["html"];
                        }
                        console.log(rad);
                        var name = sales.add.bill.expenses.comm.slice(1, sales.add.bill.expenses.comm.length);
                        var nmsg = sales.add.bill.expenses.commmsg.slice(1, sales.add.bill.expenses.commmsg.length);
                        $(sales.add.bill.expenses.comm).replaceWith('<select class="form-control" id="' + name + '">' + rad + '</select>');
                        $(document.getElementById(name)).change(function () {
                            calculateNetSales();
                        });
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
    }
    ;

    function fetchSingleSaleEntry(pid) {
        var saleEntry = {};
        $.ajax({
            type: 'POST',
            async: false,
            url: sales.add.url,
            data: {autoloader: true, action: 'fetchSingleSaleEntry', pid: pid},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        saleEntry = $.parseJSON(data);
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
        return saleEntry;
    }
    ;

    function populateSalesList(para) {
        if (para.ptid != 'undefined' && para.ptid) {
            $.ajax({
                type: 'POST',
                url: sales.add.url,
                data: {autoloader: true, action: 'populateSalesList', pid: para.ptid, todo: para.todo},
                success: function (data, textStatus, xhr) {
                    data = $.trim(data);
                    console.log(xhr.status);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            listofSales = $.parseJSON(data);
                            var total = Number(listofSales.tse);
                            switch (total) {
                                case 0:
                                    $(para.listDiv).html('<h3 class="text-danger">There are no sale entries</h3>');
                                    if (para.action && para.action == 'generatePattybill') {
                                        para.main.select.sid = '';
                                        para.main.select.pid = '';
                                    }
                                    break;
                                default:
                                    $(para.listDiv).html(listofSales.moodal + listofSales.header_html);
                                    for (i = 0; i < total; i++) {
                                        var pid = listofSales.pid[i];
                                        $(para.listDiv).append(listofSales.html[i]);
                                        switch (para.todo) {
                                            case 'edit':
                                                $(listofSales.es + pid).click(function () {
                                                    editSaleEntry($(this).prop('name'));
                                                });
                                                $(listofSales.deleteOk + pid).bind('click', function () {
                                                    $($(this).prop('name')).hide(400);
                                                    var hid = deleteSaleEntry($(listofSales.es + pid).prop('name'));
                                                    if (hid) {
                                                        $(listofSales.sr + pid).remove();
                                                        populateSalesList(para);
                                                    }
                                                });
                                                break;
                                            case 'pay':
                                                break;
                                            default:
                                                break;
                                        }
                                        $(listofSales.ps + pid).click(function () {
                                            window.open(decodeURIComponent($.trim($(this).prop('name'))), 'MadMec_Window', 800, 600);
                                        });
                                        $(listofSales.ss + pid).click(function () {
                                            var attr = {
                                            };
                                            $('.' + listofSales.num_class).each(function () {
                                                $(this).click(function (event) {
                                                    var attr = {
                                                        num: $(this).prop('name'),
                                                        pid: pid,
                                                        msgType: 'saleentry',
                                                        menuBut: listofSales.ss + pid,
                                                        parentDiv: listofSales.parentDiv + pid,
                                                        form: listofSales.form + pid,
                                                        num_id: listofSales.num_id + pid,
                                                        num_class: listofSales.num_class,
                                                        ssloader: listofSales.ssloader + pid,
                                                        modalDiv: listofSales.alertSMS + pid,
                                                        okBut: listofSales.deletesmsOk + pid,
                                                        closeBut: listofSales.deletesmsCancel + pid
                                                    };
                                                    smsSaleEntry(attr);
                                                    $(this).text('Sent');
                                                });
                                            });
                                        });
                                    }
                                    $(para.listDiv).append(listofSales.footer_html);
                                    if (para.action && para.action == 'generatePattybill') {
                                        $(para.main.summary.bqty).val($.trim(Number(listofSales.tot_packs)));
                                        $(para.main.summary.totwt).val($.trim(Number(listofSales.tot_weight)));
                                        $(para.main.summary.avgrt).val($.trim(Number(listofSales.avg_rate)));
                                        $(para.main.summary.netsal).val($.trim(Number(listofSales.tot_amt)));
                                        $(para.main.summary.avgrt).trigger('change');
                                    }
                                    $(para.listDiv).dataTable();
                                    break;
                            }
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
        }
    }
    ;

    /* Patty */

    /* Payee */

    /* Date of payment */

    /* Mode of payment */

    /* Bank Account */

    /* Amount */

    /* Remark */

    function smsSaleEntry(attr) {
        var para = attr;
        var numb = 0;
        var flag = false;
        $(para.ssloader).attr('');
        if (attr.num.match(cell_reg)) {
            flag = true;
            $(para.ssloader).attr(VALIDNOT);
        } else {
            flag = false;
            $(para.ssloader).attr(INVALIDNOT);
            return;
        }
        if (flag) {
            $(para.ssloader).attr(LOADER_THR);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                async: false,
                data: {autoloader: true, action: 'smsSaleEntry', sms: attr},
                success: function (data, textStatus, xhr) {
                    data = $.trim(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(para.ssloader).html(data);
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
        }
    }
    ;
    function calculateNetSales() {
        if ($(sales.add.bill.summary.avgrt).val().match(ind_reg)) {
            $(sales.add.bill.summary.avgrtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.summary.avgrtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.summary.avgrtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.kg_packs).show().focus();
            return;
        }
        if ($(sales.add.bill.expenses.hire).val().match(ind_reg)) {
            $(sales.add.bill.expenses.hiremsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.hiremsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.hiremsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.hire).show().focus();
            return;
        }
        if ($(sales.add.bill.expenses.labr).val().match(ind_reg)) {
            $(sales.add.bill.expenses.labrmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.labrmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.labrmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.labr).show().focus();
            return;
        }
        if ($(sales.add.bill.expenses.assnfee).val().match(ind_reg)) {
            $(sales.add.bill.expenses.assnfeemsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.assnfeemsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.assnfeemsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.assnfee).show().focus();
            return;
        }
        if ($(sales.add.bill.expenses.telefee).val().match(ind_reg)) {
            $(sales.add.bill.expenses.telefeemsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.telefeemsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.telefeemsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.telefee).show().focus();
            return;
        }
        if ($(sales.add.bill.rotten.rotamt).val().match(ind_reg)) {
            $(sales.add.bill.rotten.rotamtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.rotten.rotamtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.rotten.rotamtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.rotten.rotamt).show().focus();
            return;
        }
        if ($(sales.add.bill.hunda.hunamt).val().match(ind_reg)) {
            $(sales.add.bill.hunda.hunamtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.hunda.hunamtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.hunda.hunamtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.hunda.hunamt).show().focus();
            return;
        }
        /* Summary */
        var kg = Number($(sales.add.bill.summary.totwt).val());
        var avgrt = Number($(sales.add.bill.summary.avgrt).val());
        /* Rotten */
        var rotten = Number($(sales.add.bill.rotten.rotamt).val());
        $(sales.add.bill.rotten.rotamtmsg).html(ntow(rotten));
        /* Hunda */
        var hunda = Number($(sales.add.bill.hunda.hunamt).val());
        $(sales.add.bill.hunda.hunamtmsg).html(ntow(hunda));
        /* totsal */
        var totsal = Math.floor(Number(kg * avgrt)) + Number(rotten) + Number(hunda);
        $(sales.add.bill.summary.netsal).val(totsal);
        $(sales.add.bill.summary.netsalmsg).html(ntow(totsal));
        /* hire */
        var hire = Number($(sales.add.bill.expenses.hire).val());
        $(sales.add.bill.expenses.hiremsg).html(ntow(hire));
        /* labour */
        var labour = Number($(sales.add.bill.expenses.labr).val());
        $(sales.add.bill.expenses.labrmsg).html(ntow(labour));
        /* assnfee */
        var assnfee = Number($(sales.add.bill.expenses.assnfee).val());
        $(sales.add.bill.expenses.assnfeemsg).html(ntow(assnfee));
        /* telefee */
        var telefee = Number($(sales.add.bill.expenses.telefee).val());
        $(sales.add.bill.expenses.telefeemsg).html(ntow(telefee));
        /* rmc */
        var rmc = Number($(sales.add.bill.expenses.rmc).val());
        $(sales.add.bill.expenses.rmcmsg).html(ntow(rmc));
        /* commision */
        var commision = Number($(sales.add.bill.expenses.comm).val());
        var cash = 0;
        if (commision != 'NULL') {
            cash = Math.floor(Number(totsal) * (Number($.trim($(sales.add.bill.expenses.comm + ' option:selected').text())) / 100));
            $(sales.add.bill.expenses.cash).val(cash);
            $(sales.add.bill.expenses.cashmsg).html(ntow(cash));
        }
        else {
            $(sales.add.bill.expenses.cashmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.cashmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.comm).show().focus();
            return;
        }
        var totexp = Math.floor(Number(hire) + +Number(labour) + Number(assnfee) + Number(telefee) + Number(rmc) + Number(cash));
        $(sales.add.bill.expenses.totexp).val(Number(totexp));
        $(sales.add.bill.expenses.totexpmsg).html(ntow(totexp));
        var nsales = Number(totsal) + Number(totexp);
        $(sales.add.bill.nsales).val(Number(nsales));
        $(sales.add.bill.nsalesmsg).html(ntow(nsales));
    }
    ;
    function generateBill() {
        var flag = false;
        /* Patty */
        if (sales.add.bill.select.pid > 0 && sales.add.bill.select.pindex > -1) {
            flag = true;

        }
        else {
            flag = false;
            $(sales.add.bill.select.pnmsg).append(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.select.pnmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.pname).focus();
            return;
        }
        /* Supplier */
        if ($(sales.add.bill.summary.supplier).val().match(name_reg)) {
            flag = true;
            $(sales.add.bill.summary.suppmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.summary.suppmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.summary.suppmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.summary.supplier).show().focus();
            flag = false;
            return;
        }
        /* Received on */
        if ($(sales.add.bill.summary.receivedon).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(sales.add.bill.summary.rnmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.bill.summary.rnmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.rnmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.summary.receivedon).focus();
            return;
        }
        /* Bill date */
        if ($(sales.add.bill.summary.bdate).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(sales.add.bill.summary.bdatemsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.bill.summary.bdatemsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.summary.bdatemsg).offset().top) - 95}, "slow");
            $(sales.add.bill.summary.bdate).focus();
            return;
        }
        /* Total number of bags / box / krates */
        if ($(sales.add.bill.summary.bqty).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.summary.bqtymsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.summary.bqtymsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.summary.bqtymsg).offset().top) - 95}, "slow");
            $(sales.add.bill.totwt).show().focus();
            flag = false;
            return;
        }
        /* Particulars */
        if ($(sales.add.bill.summary.bprt).val().match(name_reg)) {
            flag = true;
            $(sales.add.bill.summary.bqtymsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.summary.bqtymsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.bqtymsg).offset().top) - 95}, "slow");
            $(sales.add.bill.summary.bprt).show().focus();
            flag = false;
            return;
        }
        /* Total weight */
        if ($(sales.add.bill.summary.totwt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.summary.totwtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.summary.totwtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.summary.totwtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.totwt).show().focus();
            flag = false;
            return;
        }
        /* Avg rate */
        if ($(sales.add.bill.summary.avgrt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.summary.avgrtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.summary.avgrtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.summary.avgrtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.summary.avgrt).show().focus();
            flag = false;
            return;
        }
        /* Total sales */
        if ($(sales.add.bill.summary.netsal).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.summary.netsalmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.summary.netsalmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.summary.netsalmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.summary.netsal).show().focus();
            flag = false;
            return;
        }
        /* Lorry hire */
        if ($(sales.add.bill.expenses.hire).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.expenses.hiremsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.hiremsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.hiremsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.hire).show().focus();
            flag = false;
            return;
        }
        /* Commission */
        if ($(sales.add.bill.expenses.comm).val().match(id_reg)) {
            flag = true;
            $(sales.add.bill.expenses.commmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.commmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.commmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.comm).show().focus();
            flag = false;
            return;
        }
        /* Cash */
        if ($(sales.add.bill.expenses.cash).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.expenses.cashmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.cashmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.cashmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.cash).show().focus();
            flag = false;
            return;
        }
        /* Labour  */
        if ($(sales.add.bill.expenses.labr).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.expenses.labrmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.labrmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.labrmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.labr).show().focus();
            flag = false;
            return;
        }
        /* Association Fee  */
        if ($(sales.add.bill.expenses.assnfee).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.expenses.assnfeemsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.assnfeemsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.assnfeemsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.assnfee).show().focus();
            flag = false;
            return;
        }
        /* Tele & Post Fee  */
        if ($(sales.add.bill.expenses.telefee).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.expenses.telefeemsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.telefeemsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.telefeemsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.telefee).show().focus();
            flag = false;
            return;
        }
        /* RMC */
        if ($(sales.add.bill.expenses.rmc).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.expenses.rmcmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.rmcmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.rmcmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.rmc).show().focus();
            flag = false;
            return;
        }
        /* Total Expense */
        if ($(sales.add.bill.expenses.totexp).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.expenses.totexpmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.expenses.totexpmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.expenses.totexpmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.expenses.totexp).show().focus();
            flag = false;
            return;
        }
        /* Rotten Quantity*/
        if ($(sales.add.bill.rotten.rotqt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.rotten.rotqtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.rotten.rotqtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.rotten.rotqtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.rotten.rotqt).show().focus();
            flag = false;
            return;
        }
        /* Rotten Weight */
        if ($(sales.add.bill.rotten.rotwt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.rotten.rotwtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.rotten.rotwtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.rotten.rotwtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.rotten.rotwt).show().focus();
            flag = false;
            return;
        }
        /* Rotten Amount*/
        if ($(sales.add.bill.rotten.rotamt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.rotten.rotamtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.rotten.rotamtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.rotten.rotamtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.rotten.rotamt).show().focus();
            flag = false;
            return;
        }
        /* Hunda Quantity */
        if ($(sales.add.bill.hunda.hunqt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.hunda.hunqtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.hunda.hunqtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.hunda.hunqtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.hunda.hunqt).show().focus();
            flag = false;
            return;
        }
        /* Hunda Weight */
        if ($(sales.add.bill.hunda.hunwt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.hunda.hunwtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.hunda.hunwtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.hunda.hunwtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.hunda.hunwt).show().focus();
            flag = false;
            return;
        }
        /* Hunda Amount */
        if ($(sales.add.bill.hunda.hunamt).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.hunda.hunamtmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.hunda.hunamtmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.hunda.hunamtmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.hunda.hunamt).show().focus();
            flag = false;
            return;
        }
        /* Total Net sales */
        if ($(sales.add.bill.nsales).val().match(ind_reg)) {
            flag = true;
            $(sales.add.bill.nsalesmsg).html(VALIDNOT);
        }
        else {
            $(sales.add.bill.nsalesmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.bill.nsalesmsg).offset().top) - 95}, "slow");
            $(sales.add.bill.nsales).show().focus();
            flag = false;
            return;
        }
        var attr = {
            sales_id: sales.add.bill.select.pid,
            bdate: $(sales.add.bill.summary.bdate).val(),
            prtlr: $(sales.add.bill.summary.bprt).val(),
            tot_packs: Number($(sales.add.bill.summary.bqty).val()),
            tot_wt: Number($(sales.add.bill.summary.totwt).val()),
            avgrt: Number($(sales.add.bill.summary.avgrt).val()),
            totsal: Number($(sales.add.bill.summary.netsal).val()),
            hire: Number($(sales.add.bill.expenses.hire).val()),
            comm: Number($(sales.add.bill.expenses.comm).val()),
            cash: Number($(sales.add.bill.expenses.cash).val()),
            labour: Number($(sales.add.bill.expenses.labr).val()),
            assnfee: Number($(sales.add.bill.expenses.assnfee).val()),
            telefee: Number($(sales.add.bill.expenses.telefee).val()),
            rmc: Number($(sales.add.bill.expenses.rmc).val()),
            rot: $(sales.add.bill.rotten.rot).val(),
            rotqt: Number($(sales.add.bill.rotten.rotqt).val()),
            rotwt: Number($(sales.add.bill.rotten.rotwt).val()),
            rotamt: Number($(sales.add.bill.rotten.rotamt).val()),
            hun: $(sales.add.bill.hunda.hun).val(),
            hunqt: Number($(sales.add.bill.hunda.hunqt).val()),
            hunwt: Number($(sales.add.bill.hunda.hunwt).val()),
            hunamt: Number($(sales.add.bill.hunda.hunamt).val()),
            totexp: $(sales.add.bill.expenses.totexp).val(),
            nsales: $(sales.add.bill.nsales).val()
        };
        if (flag) {
            $(sales.add.bill.but).attr('disabled', 'disabled');
            $.ajax({
                url: sales.add.url,
                type: 'POST',
                data: {autoloader: true, action: 'generateBill', ptybill: attr},
                success: function (data, textStatus, xhr) {
                    data = $.trim(data);
                    console.log(xhr.status);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(sales.add.bill.form).get(0).reset();
                            $(sales.add.bill.select.listDiv).html(data);
                            $('html, body').animate({scrollTop: Number($(sales.add.bill.select.listDiv).offset().top) - 95}, "slow");
                            window.open(decodeURIComponent(data), 'MadMec_Window', 800, 600);
                            fetchPatty({main: sales.add.bill});
                            break;
                    }
                },
                error: function () {
                    $(sales.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(sales.add.bill.but).removeAttr('disabled');
                }
            });
        }
        else {
            $(sales.add.bill.but).removeAttr('disabled');
        }
    }
    ;
    function clearPattyAddForm() {
        /*  Patty Add */
        $(sales.add.basicinfo.name + ',' + sales.add.basicinfo.product + ',' + sales.add.basicinfo.vehicle + ',' + sales.add.basicinfo.date).val('');
        sales.add.basicinfo.sid = sales.add.basicinfo.sind = sales.add.basicinfo.pid = sales.add.basicinfo.pind = 0;
    }
    ;
    function clearSaleEntryForm() {
        /*  Sale entry */
        $(sales.add.sales.pds + ',' + sales.add.sales.dd).val('');
        $(sales.add.sales.num_packs + ',' + sales.add.sales.kg_packs
                + ',' + sales.add.sales.rp + ',' + sales.add.sales.rpa + ',' + sales.add.sales.amtpd + ',' + sales.add.sales.damtpd).val(0);
        $(sales.add.sales.listDiv).html('');

        sales.add.sales.prdname = sales.add.sales.prdphoto = sales.add.sales.packtype = '';
        fetchRetailers();
    }
    ;
    function clearPattyPayForm() {
    }
    ;
    function clearPattyBillForm() {
    }
    ;
    function DisplayUpdatedPattyList() {
        $(sales.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: sales.list.url,
            type: 'post',
            data: {autoloader: true, action: 'DisplayUpdatedPattyList'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(sales.list.listDiv).append(data);
                        $(sales.list.listLoad).html('');
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
    }
    ;
    function DisplayPattyList() {
        $(sales.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: sales.list.url,
            type: 'post',
            data: {autoloader: true, action: 'DisplayPattyList'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(sales.list.listDiv).html(data);
                        window.setTimeout(function () {
                            $('#consignment_table').dataTable();
                        }, 600)
                        $(sales.list.listLoad).html('');
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

    }
}
