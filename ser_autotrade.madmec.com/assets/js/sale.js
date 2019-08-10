function saleController() {
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
        fetchPatty({main: sales.add.sales});
        $(sales.add.sales.but).click(function () {
            addPattySaleEntry();
        });
        $(sales.list.menuBut).click(function () {
            $(sales.msgDiv).html('');
            DisplaySaleList();
        });
        $(sales.add.sales.pds + ' , ' + sales.add.basicinfo.date + ' , ' + sales.add.sales.dd + ' , ' + sales.add.payments.pdate + ' , ' + sales.add.bill.summary.bdate).datepicker({
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
        clearSaleEntryForm();
    };
    function fetchRetailers() {
        var rad = '';
        $(sales.add.sales.ret_msg).html(LOADER_TWO);
        $.ajax({
            type: 'POST',
            url: sales.add.url,
            data: {autoloader: true, action: 'fetchUsers', utype: 'retailer'},
            success: function (data, textStatus, xhr) {
                console.log(data);
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        listofRetailers = $.parseJSON(data);
                        for (i = 0; i < listofRetailers.length; i++) {
                            rad += listofRetailers[i]["html"];
                        }
                        var name = sales.add.sales.retailer.slice(1, sales.add.sales.retailer.length);
                        var nmsg = sales.add.sales.ret_msg.slice(1, sales.add.sales.ret_msg.length);
                        $(sales.add.sales.retailer).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Retailer</option>' + rad + '</select>');
                        $(sales.add.sales.ret_msg).html('Enter / Select');
                        $(sales.add.sales.retailer).change(function () {
                            var type = $.trim($('#' + name + ' option:selected').text());
                            if (type != 'Select Retailer' && $(this).val() != 'Null') {
                                for (i = 0; i < listofRetailers.length; i++) {
                                    if (Number(listofRetailers[i]["id"]) == Number($(this).val())) {
                                        sales.add.sales.label = listofRetailers[i]["label"];
                                        sales.add.sales.rid = Number(listofRetailers[i]["id"]);
                                        sales.add.sales.rind = Number(listofRetailers[i]["value"]);
                                        sales.add.sales.img = listofRetailers[i]["img"];
                                        break;
                                    }
                                    else {
                                        sales.add.sales.label = '';
                                        sales.add.sales.rid = 0;
                                        sales.add.sales.rind = 0;
                                        sales.add.sales.img = '';
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
            async:false,
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
                        fetchRetailers();
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
    function addPattySaleEntry() {
        var attr = validateSaleEntry();
        if (attr) {
            $(sales.add.sales.but).attr('disabled', 'disabled');
            $(sales.msgDiv).html('');
            $.ajax({
                url: sales.add.url,
                async:false,
                type: 'POST',
                data: {autoloader: true, action: 'addPattySaleEntry', ptyaddsale: attr},
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
                            $(sales.add.sales.form).get(0).reset();
                            $('html, body').animate({scrollTop: Number($(sales.add.sales.select.listDiv).offset().top) - 95}, "slow");
                            populateSalesList({
                                ptid: sales.add.sales.select.pid,
                                listDiv: sales.add.sales.select.listDiv,
                                todo: 'edit'
                            });
                            break;
                    }
                },
                error: function () {
                    $(sales.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(sales.add.sales.but).removeAttr('disabled');
                    window.setTimeout(function () {
                        $(sales.msgDiv).html('');
                    }, 600);
                }
            });
        }
        else {
            $(sales.add.sales.but).removeAttr('disabled');
        }
    }
    ;
    function validateSaleEntry() {
        var flag = false;
        /* Patty */
        if (sales.add.sales.select.pid > 0 && sales.add.sales.select.pindex > -1) {
            flag = true;
            $(sales.add.sales.pnmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.select.pnmsg).append(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.select.pnmsg).offset().top) - 95}, "slow");
            $(sales.add.sales.pname).focus();
            return;
        }
        /* Retailer */
        if (sales.add.sales.rid > 0 && sales.add.sales.rind > -1) {
            flag = true;
            $(sales.add.sales.ret_msg).append(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.ret_msg).append(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.ret_msg).offset().top) - 95}, "slow");
            $(sales.add.sales.retailer).show().focus();
            return;
        }
        /* Date of payment */
        if ($(sales.add.sales.pds).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(sales.add.sales.pds_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.pds_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.pds_msg).offset().top) - 95}, "slow");
            $(sales.add.sales.pds).focus();
            return;
        }
        /* Quantity in numbers */
        if (($(sales.add.sales.num_packs).val().match(ind_reg))) {
            flag = true;
            $(sales.add.sales.npmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.npmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.npmsg).offset().top) - 95}, "slow");
            $(sales.add.sales.num_packs).show().focus();
            return;
        }
        /* Quantity in weight */
        if ($(sales.add.sales.kg_packs).val().match(ind_reg)) {
            flag = true;
            $(sales.add.sales.kpmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.kpmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.kpmsg).offset().top) - 95}, "slow");
            $(sales.add.sales.kg_packs).show().focus();
            return;
        }
        /* Rate per kilo */
        if ($(sales.add.sales.rp).val().match(ind_reg)) {
            flag = true;
            $(sales.add.sales.rpmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.rpmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.rpmsg).offset().top) - 95}, "slow");
            $(sales.add.sales.rp).show().focus();
            return;
        }
        var kg = Number($(sales.add.sales.kg_packs).val());
        var rp = Number($(sales.add.sales.rp).val());
        var pad = Number($(sales.add.sales.amtpd).val());
        var tot = Math.floor(Number(kg * rp));
        var due = 0;
        if (tot > pad)
            due = Number(tot - pad);
        /* Total amount */
        if (tot == Number($(sales.add.sales.rpa).val())) {
            flag = true;
            $(sales.add.sales.rpamsg).append(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.rpamsg).append(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.rpamsg).offset().top) - 95}, "slow");
            $(sales.add.sales.rpa).show().focus();
            return;
        }
        /* Amount paid */
        if (pad == Number($(sales.add.sales.amtpd).val()) && pad <= tot) {
            flag = true;
            $(sales.add.sales.amtpdmsg).append(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.amtpdmsg).append(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.amtpdmsg).offset().top) - 95}, "slow");
            $(sales.add.sales.amtpd).show().focus();
            return;
        }
        /* Due amount */
        if (due == Number($(sales.add.sales.damtpd).val()) && due <= tot) {
            flag = true;
            $(sales.add.sales.damtpdmsg).append(VALIDNOT);
        }
        else {
            flag = false;
            $(sales.add.sales.damtpdmsg).append(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(sales.add.sales.damtpdmsg).offset().top) - 95}, "slow");
            $(sales.add.sales.damtpd).show().focus();
            return;
        }
        /* Due date */
        if (due) {
            if ($(sales.add.sales.dd).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
                flag = true;
                $(sales.add.sales.ddmsg).html(VALIDNOT);
            }
            else {
                flag = false;
                $(sales.add.sales.ddmsg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($(sales.add.sales.ddmsg).offset().top) - 95}, "slow");
                $(sales.add.sales.dd).focus();
                return;
            }
        }
        var attr = {
            pid: Number($.trim(sales.add.sales.select.pid)),
            pindex: Number($.trim(sales.add.sales.select.pindex)),
            rid: Number($.trim(sales.add.sales.rid)),
            rind: Number($.trim(sales.add.sales.rind)),
            pds: $(sales.add.sales.pds).val(),
            num_packs: Number($.trim($(sales.add.sales.num_packs).val())),
            kg_packs: Number($.trim($(sales.add.sales.kg_packs).val())),
            rp: Number($.trim($(sales.add.sales.rp).val())),
            rpa: Number($.trim($(sales.add.sales.rpa).val())),
            amtpd: Number($.trim($(sales.add.sales.amtpd).val())),
            damtpd: Number($.trim($(sales.add.sales.damtpd).val())),
            dd: $(sales.add.sales.dd).val(),
            pname: sales.add.sales.select.prdname,
            prdphoto: sales.add.sales.select.prdphoto,
            packtype: sales.add.sales.select.packtype
        };
        if (flag) {
            return attr;
        }
        else
            return false;
    }
    ;
    function populateSalesList(para) {
        if (para.ptid != 'undefined' && para.ptid) {
            $.ajax({
                type: 'POST',
                url: sales.add.url,
                async:false,
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
    function fetchSingleSaleEntry(pid) {
        var saleEntry = {};
        $.ajax({
            type: 'POST',
            async: false,
            url: sales.add.url,
            async:false,
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
    function editSaleEntry(pid) {
        saleEntry = fetchSingleSaleEntry(pid);
        $('html, body').animate({scrollTop: Number($(sales.add.sales.form).offset().top) - 95}, "slow");
        $(sales.add.sales.pds).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(sales.add.sales.pds).datepicker('setDate', saleEntry.pds);
        $(sales.add.sales.pds).prop('disabled', 'disabled');
        $(sales.add.sales.dd).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(sales.add.sales.dd).datepicker('setDate', saleEntry.dd);

        sales.add.sales.select.pid = Number(saleEntry.pid);
        sales.add.sales.select.pindex = Number(saleEntry.pindex);
        sales.add.sales.rid = Number(saleEntry.rid);
        sales.add.sales.rind = Number(saleEntry.rind);
        $(sales.add.sales.retailer + ' option[value="' + Number(saleEntry.rid) + '"]').prop('selected', 'selected');
        $(sales.add.sales.retailer).prop('disabled', 'disabled');
        $(sales.add.sales.num_packs).val(Number(saleEntry.num_packs));
        $(sales.add.sales.kg_packs).val(Number(saleEntry.kg_packs));
        $(sales.add.sales.rp).val(Number(saleEntry.rp));
        $(sales.add.sales.rpa).val(Number(saleEntry.rpa));
        $(sales.add.sales.amtpd).val(Number(saleEntry.amtpd));
        $(sales.add.sales.damtpd).val(Number(saleEntry.damtpd));
        sales.add.sales.select.pname = saleEntry.prdname;
        sales.add.sales.select.prdphoto = saleEntry.prdphoto;
        sales.add.sales.select.packtype = saleEntry.packtype;
        $(sales.add.sales.but).unbind();
        $(sales.add.sales.but).click(function () {
            var attr = validateSaleEntry();
            attr.entid = Number(saleEntry.entid);
            attr.entidindex = Number(saleEntry.entidindex);
            attr.due_id = Number(saleEntry.due_id);
            attr.dueid = Number(saleEntry.dueid);
            if (attr) {

                $(sales.msgDiv).html('');
                $.ajax({
                    url: sales.add.url,
                    async:false,
                    type: 'POST',
                    data: {autoloader: true, action: 'editPattySaleEntry', ptyeditsale: attr},
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
                                $('html, body').animate({scrollTop: Number($(sales.add.sales.select.listDiv).offset().top) - 95}, "slow");
                                populateSalesList({
                                    ptid: sales.add.sales.select.pid,
                                    listDiv: sales.add.sales.select.listDiv,
                                    todo: 'edit'
                                });
                                clearSaleEntryForm();
                                break;
                        }
                    },
                    error: function () {
                        $(sales.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                        $(sales.add.sales.but).removeAttr('disabled');
                    }
                });
                $(sales.add.sales.but).unbind();
                $(sales.add.sales.but).click(function () {
                    addPattySaleEntry();
                });
                $(sales.add.sales.pds).removeAttr('disabled');
            }
            else {
                $(sales.add.sales.but).removeAttr('disabled');
            }
        });
    }
    ;
    function deleteSaleEntry(entryid) {
        var flag = false;
        var attr = {
            entid: entryid
        };
        $.ajax({
            url: sales.add.url,
            async:false,
            type: 'POST',
            async: false,
            data: {autoloader: true, action: 'deleteSaleEntry', ptydeletesale: attr},
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
                        flag = data;
                        break;
                }
            },
            error: function () {
                $(sales.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
                $(sales.add.sales.but).removeAttr('disabled');
            }
        });
        return flag;
    }
    ;
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
                async:false,
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
    function clearSaleEntryForm() {
        /*  Sale entry */
        $(sales.add.sales.pds + ',' + sales.add.sales.dd).val('');
        $(sales.add.sales.num_packs + ',' + sales.add.sales.kg_packs
                + ',' + sales.add.sales.rp + ',' + sales.add.sales.rpa + ',' + sales.add.sales.amtpd + ',' + sales.add.sales.damtpd).val(0);
        $(sales.add.sales.listDiv).html('');

        sales.add.sales.prdname = sales.add.sales.prdphoto = sales.add.sales.packtype = '';
        //fetchRetailers();
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
    function DisplaySaleList() {
        $(sales.list.listLoad).html(LOADER_ONE);
        var header = '<table class="table table-striped table-bordered table-hover" id="list_sale_table"><thead><tr><th colspan="7">Lists</th></tr><tr><th>SaleId</th><th>Retailer</th><th>Date</th><th>Product</th><th class="text-right">Number</th><th class="text-right">Weight</th><th class="text-right">Rate</th><th class="text-right">Due Amount</th><th>Due Date</th><th class="text-right">Amount</th><th class="text-right">Invoice</th></tr></thead>';
        var footer = '</table>';
        $.ajax({
            url: sales.list.url,
            type: 'post',
            data: {autoloader: true, action: 'DisplaySaleList'},
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
                        $(sales.list.listDiv).html(header + data + footer);
                        window.setTimeout(function () {
                            $('#list_sale_table').dataTable();
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
