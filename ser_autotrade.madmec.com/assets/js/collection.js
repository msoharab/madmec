function collectionController() {
    var colls = {};
    var listColletrs = {};
    var listdistrs = {};
    var listofUsers = {};
    var listofProducts = {};
    var listofPattys = {};
    var listofcolls = {};
    var listofMOPtypes = {};
    var listofBankAC = {};
    this.__construct = function (cctrl) {
        colls = cctrl;
        $(colls.add.but).click(function () {
            addPayments();
        });
        $(colls.add.pamt).keyup(function () {
            var amountt = Number($(colls.add.pamt).val()) < 0 ? 0 : Number($(colls.add.pamt).val());
            $(colls.add.pamt).val(amountt);
        });
        $(colls.list.menuBut).click(function () {
            $(colls.msgDiv).html('');
            DisplayCollsList();
        });
        $(colls.add.cdate).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(colls.add.pamt).change(function () {
            if ($(colls.add.pamt).val().match(ind_reg)) {
                $(colls.add.pamsg).html(VALIDNOT);
            }
            else {
                $(colls.add.pamsg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($(colls.add.pamsg).offset().top) - 95}, "slow");
                $(colls.add.pamt).show().focus();
                return;
            }
            var amtpaid = $(colls.add.pamt).val();
            if (amtpaid < 0) {
                $(colls.add.pamt).val(0);
            }
        });
        clearCollectionForm();
        window.setTimeout(function () {
            fetchUsers('collector');
        }, 400);
        window.setTimeout(function () {
            fetchUsers('retailer / customer');
        }, 800);
        window.setTimeout(function () {
            fetchUsers('distributor');
        }, 1200);
        fetchMOPTypes();
    };
    function fetchUsers(utype) {
        var rad = '';
        $.ajax({
            type: 'POST',
            url: colls.url,
            data: {autoloader: true, action: 'fetchUsers', utype: utype},
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
                        switch (utype) {
                            case 'retailer / customer':
                                listofUsers = $.parseJSON(data);
                                for (i = 0; i < listofUsers.length; i++) {
                                    rad += listofUsers[i]["html"];
                                }
                                var name = colls.add.user.slice(1, colls.add.user.length);
                                var nmsg = colls.add.usr_msg.slice(1, colls.add.usr_msg.length);
                                $(colls.add.user).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Retailer</option>' + rad + '</select>');
                                $(colls.add.user).change(function () {
                                    var type = $.trim($('#' + name + ' option:selected').text());
                                    if (type != 'Select Retailer' && $(this).val() != 'Null') {
                                        for (i = 0; i < listofUsers.length; i++) {
                                            if (Number(listofUsers[i]["id"]) == Number($(this).val())) {
                                                colls.add.label = listofUsers[i]["label"];
                                                colls.add.uid = Number(listofUsers[i]["id"]);
                                                colls.add.uind = Number(listofUsers[i]["value"]);
                                                colls.add.img = listofUsers[i]["img"];
                                                colls.add.select.pid = Number(listofUsers[i]["id"]);
                                                colls.add.select.pindex = Number(listofUsers[i]["value"]);
                                                break;
                                            }
                                            else {
                                                colls.add.label = '';
                                                colls.add.uid = 0;
                                                colls.add.uind = 0;
                                                colls.add.img = '';
                                                colls.add.select.pid = 0;
                                                colls.add.select.pindex = 0;
                                            }
                                        }
                                    }
                                });
                                break;
                            case 'collector':
                                listColletrs = $.parseJSON(data);
                                for (i = 0; i < listColletrs.length; i++) {
                                    rad += listColletrs[i]["html"];
                                }
                                var name = colls.add.coltr.slice(1, colls.add.coltr.length);
                                var nmsg = colls.add.coltr_msg.slice(1, colls.add.coltr_msg.length);
                                $(colls.add.coltr).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Collector</option>' + rad + '</select>');
                                console.log(colls.add.coltr);
                                $(colls.add.coltr).change(function () {
                                    var type = $.trim($('#' + name + ' option:selected').text());
                                    if (type != 'Select Collector' && $(this).val() != 'Null') {
                                        for (i = 0; i < listColletrs.length; i++) {
                                            if (Number(listColletrs[i]["id"]) == Number($(this).select().val())) {
                                                colls.add.select.coltrid = Number(listColletrs[i]["id"]);
                                                colls.add.select.coltrind = Number(listColletrs[i]["value"]);
                                                break;
                                            }
                                            else {
                                                colls.add.select.coltrid = 0;
                                                colls.add.select.coltrind = 0;
                                            }
                                        }
                                    }
                                });
                                break;
                            case 'distributor':
                                listdistrs = $.parseJSON(data);
                                for (i = 0; i < listdistrs.length; i++) {
                                    rad += listdistrs[i]["html"];
                                }
                                var name = colls.add.pay_ac.slice(1, colls.add.pay_ac.length);
                                var nmsg = colls.add.payac_msg.slice(1, colls.add.payac_msg.length);
                                $('#' + colls.add.pay_ac).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Collector</option>' + rad + '</select>');
                                console.log('#' + colls.add.pay_ac);
                                $('#' + colls.add.pay_ac).change(function () {
                                    console.log("hiiii");
                                    var type = $.trim($('#' + name + ' option:selected').text());
                                    if (type != 'Select distributor' && $(this).val() != 'Null') {
                                        for (i = 0; i < listdistrs.length; i++) {
                                            console.log("array = " + listdistrs[i]["id"]);
                                            console.log("option = " + $(this).select().val());
                                            if (Number(listdistrs[i]["id"]) == Number($(this).select().val())) {
                                                colls.add.select.dstid = Number(listdistrs[i]["id"]);
                                                colls.add.select.dstind = Number(listdistrs[i]["value"]);
                                                break;
                                            }
                                            else {
                                                colls.add.select.dstrid = 0;
                                                colls.add.select.dstind = 0;
                                            }
                                        }
                                    }
                                });
                                break
                        }
                        break;
                }
            },
            error: function () {
                $(colls.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchMOPTypes() {
        var rad = '';
        $(colls.add.acdiv).hide();
        $.ajax({
            type: 'POST',
            url: colls.url,
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
                        $(colls.add.mopdiv).html('<select class="form-control" id="' + colls.add.mop + '"><option value="NULL" selected>Select Mode of payment</option>' + rad + '</select><p class="help-block" id="' + colls.add.mopmsg + '">Enter/ Select.</p>');
                        $(document.getElementById(colls.add.mop)).change(function () {
                            fetchBankAccount(colls.add);
                            $(colls.add.acdiv).hide();
                        });
                        break;
                }
            },
            error: function () {
                $(colls.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchBankAccount(payments) {
        var type = $.trim($('#' + payments.mop + ' option:selected').text());
        var flag = false;
        var rad = '';
        /* Retailer */
        if (payments.uid > 0 && payments.uind > -1) {
            flag = true;
            $(payments.usr_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(payments.usr_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(payments.usr_msg).offset().top) - 95}, "slow");
            $(payments.user).focus();
            return;
        }
        if (payments.select.pid > 0 && payments.select.pindex > -1) {
            flag = true;
            $(payments.usr_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(payments.usr_msg).append(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(payments.usr_msg).offset().top) - 95}, "slow");
            $(payments.user).focus();
            return;
        }
        if (type != 'Select Mode of payment' && type != 'Cash') {
            $(payments.acdivtit).show();
            $(payments.acdiv).show();
            if (flag) {
                $.ajax({
                    type: 'POST',
                    url: colls.url,
                    data: {autoloader: true, action: 'fetchBankAccount', soruce: payments},
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
                                $(payments.acdivtit).show();
                                $(payments.acdiv).show();
                                listofBankAC = $.parseJSON(data);
                                for (i = 0; i < listofBankAC.length; i++) {
                                    rad += listofBankAC[i]["html"];
                                }
                                $(payments.acdiv).html('<select class="form-control" id="' + payments.pay_ac + '"><option value="NULL" selected>Select Distributors Bank Account</option>' + rad + '</select><p class="help-block" id="' + payments.payac_msg + '">Enter/ Select.</p>');
                                $(document.getElementById(payments.pay_ac)).change(function () {
                                    var type = $.trim($('#' + payments.pay_ac + ' option:selected').text());
                                    var val = $.trim($('#' + payments.pay_ac).val());
                                    if (val == 'Add' && type == 'Add') {
                                        AddBankAccount(payments);
                                    }
                                    else if (val == 'NULL') {
                                        payments.ac_id = '';
                                        $('#' + payments.ac.parentDiv).html('');
                                    }
                                    else {
                                        payments.ac_id = Number(val);
                                        $('#' + payments.ac.parentDiv).html('');
                                    }
                                });
                                break;
                        }
                    },
                    error: function () {
                        $(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        else {
            $('#' + payments.ac.parentDiv).html('');
            $(payments.acdiv + ',' + payments.acdivtit).hide();
        }
    }
    ;
    function AddBankAccount(payments) {
        var html = '<div id="' + payments.ac.form + '">' +
                '<div class="panel panel-warning">' +
                '<div class="panel-heading">' +
                '<strong>Add Bank Account</strong>&nbsp;' +
                '</div>' +
                '<div class="panel-body">' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Bank Name <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Bank Name" name="bankname" type="text" id="' + payments.ac.bankname + '" maxlength="100"/>' +
                '<p class="help-block" id="' + payments.ac.nmsg + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Account Number <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Account Number" name="accno" type="text" id="' + payments.ac.accno + '" maxlength="100"/>' +
                '<p class="help-block" id="' + payments.ac.nomsg + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Name <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Branch Name" name="braname" type="text" id="' + payments.ac.braname + '" maxlength="100"/>' +
                '<p class="help-block" id="' + payments.ac.bnmsg + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Code <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Branch Code" name="bracode" type="text" id="' + payments.ac.bracode + '" maxlength="100"/>' +
                '<p class="help-block" id="' + payments.ac.bcmsg + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> IFSC <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="IFSC" name="IFSC" type="text" id="' + payments.ac.IFSC + '" maxlength="100"/>' +
                '<p class="help-block" id="' + payments.ac.IFSCmsg + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        $('#' + payments.ac.parentDiv).html(html);
    }
    ;
    function addPayments() {
        $(colls.msgDiv).html('');
        var account = {};
        /* Collector */
        if (colls.add.select.coltrid > 0 && colls.add.select.coltrind > -1) {
            flag = true;
            $(colls.add.coltr_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(colls.add.coltr_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(colls.add.coltr_msg).offset().top) - 95}, "slow");
            $(colls.add.coltr).focus();
            return;
        }
        /* Payer */
        if (colls.add.select.pid > 0 && colls.add.select.pindex > -1) {
            flag = true;
            $(colls.add.usr_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(colls.add.usr_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(colls.add.usr_msg).offset().top) - 95}, "slow");
            $(colls.add.user).focus();
            return;
        }
        /* Payer */
        if (colls.add.uid > 0 && colls.add.uind > -1) {
            flag = true;
            $(colls.add.usr_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(colls.add.usr_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(colls.add.usr_msg).offset().top) - 95}, "slow");
            $(colls.add.user).focus();
            return;
        }
        /* Date of payment */
        if ($(colls.add.cdate).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(colls.add.cdmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(colls.add.cdmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(colls.add.cdmsg).offset().top) - 95}, "slow");
            $(colls.add.cdate).focus();
            return;
        }
        /* Mode of payment */
        var mop = $('#' + colls.add.mop).val();
        var moptype = $.trim($('#' + colls.add.mop + ' option:selected').text());
        if (mop != 'NULL') {
            flag = true;
            $('#' + colls.add.mopmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $('#' + colls.add.mopmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($('#' + colls.add.mopmsg).offset().top) - 95}, "slow");
            $(colls.add.mop).show().focus();
            return;
        }
        /* Bank Account */
        var ac_id = 0;
        var acc = $('#' + colls.add.pay_ac).val();
        if (moptype != 'Cash') {
            if (acc == 'Add') {
                flag = true;
                $('#' + colls.add.payac_msg).html(VALIDNOT);
                if ($(document.getElementById(colls.add.ac.bankname)).val().match(name_reg)) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.nmsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.nmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(colls.add.ac.nmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(colls.add.ac.bankname)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.accno)).val().match(accn_reg)) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.nomsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.nomsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(colls.add.ac.nomsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(colls.add.ac.accno)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.braname)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.bnmsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.bnmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(colls.add.ac.bnmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(colls.add.ac.braname)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.bracode)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.bcmsg)).html(VALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(colls.add.ac.bcmsg)).offset().top) - 95}, "slow");
                }
                else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.bcmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(colls.add.ac.bcmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(colls.add.ac.bracode)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.IFSC)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.IFSCmsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.IFSCmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(colls.add.ac.IFSCmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(colls.add.ac.IFSC)).focus();
                    return;
                }
                account = {
                    bankname: $(document.getElementById(colls.add.ac.bankname)).val(),
                    accno: $(document.getElementById(colls.add.ac.accno)).val(),
                    braname: $(document.getElementById(colls.add.ac.braname)).val(),
                    bracode: $(document.getElementById(colls.add.ac.bracode)).val(),
                    IFSC: $(document.getElementById(colls.add.ac.IFSC)).val()
                };
            }
            else if (acc == 'NULL') {
                flag = false;
                $('#' + colls.add.payac_msg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($('#' + colls.add.payac_msg).offset().top) - 95}, "slow");
                $('#' + colls.add.pay_ac).show().focus();
                return;
            }
            else {
                flag = true;
                $('#' + colls.add.payac_msg).html(VALIDNOT);
                ac_id = acc;
            }
        }
        /* Amount */
        if ($(colls.add.pamt).val().match(ind_reg)) {
            flag = true;
            $(colls.add.pamsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(colls.add.pamsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(colls.add.pamsg).offset().top) - 95}, "slow");
            $(colls.add.pamt).show().focus();
            return;
        }
        /* Remark */
        if ($(colls.add.rmk).val().length < 101) {
            flag = true;
            $(colls.add.rmkmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(colls.add.rmkmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(colls.add.rmkmsg).offset().top) - 95}, "slow");
            $(colls.add.rmk).show().focus();
            return;
        }
        var attr = {
            uid: Number($.trim(colls.add.uid)),
            uind: Number($.trim(colls.add.uind)),
            coltrid: Number($.trim(colls.add.select.coltrid)),
            coltrind: Number($.trim(colls.add.select.coltrind)),
            pid: Number($.trim(colls.add.select.pid)),
            pindex: Number($.trim(colls.add.select.pindex)),
            pdate: $(colls.add.cdate).val(),
            pay_ac: $.trim(acc),
            mop: Number($.trim(mop)),
            ac_id: Number($.trim(ac_id)),
            account: account,
            pamt: Number($.trim($(colls.add.pamt).val())),
            rmk: $.trim($(colls.add.rmk).val())
        };
        if (flag) {
            $(colls.add.but).prop('disabled', 'disabled');
            $.ajax({
                url: colls.add.url,
                type: 'POST',
                data: {autoloader: true, action: 'addCollection', colls: attr},
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
                            $(colls.msgDiv).html('<h2>Collection added to database</h2>');
                            $('html, body').animate({scrollTop: Number($(colls.msgDiv).offset().top) - 95}, "slow");
                            $(colls.add.form).get(0).reset();

                            break;
                    }
                },
                error: function () {
                    $(colls.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(colls.add.but).removeAttr('disabled');
                }
            });
        }
    }
    ;
    function clearCollectionForm() {
    }
    ;
    function DisplayUpdatedCollsList() {
        $(colls.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: colls.list.url,
            type: 'post',
            data: {autoloader: true, action: 'DisplayUpdatedCollsList'},
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
                        $(colls.list.listDiv).append(data);
                        $(colls.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(colls.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function DisplayCollsList() {
        var header = '<table class="table table-striped table-bordered table-hover" id="list_col_table"><thead><tr><th colspan="7">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th>Collector</th><th>Payee</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>';
        var footer = '</table>';
        $(colls.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: colls.list.url,
            type: 'post',
            data: {autoloader: true, action: 'DisplayCollsList'},
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
                        $(colls.list.listDiv).html(header + data + footer);
                        window.setTimeout(function () {
                            $('#list_col_table').dataTable();
                        }, 600)
                        $(colls.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(colls.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });

    }
}
