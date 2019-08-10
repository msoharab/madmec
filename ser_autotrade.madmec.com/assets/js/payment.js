function paymentController() {
    var payms = {};
    var listofUsers = {};
    var listofProducts = {};
    var listofPattys = {};
    var listofpayms = {};
    var listofMOPtypes = {};
    var listofBankAC = {};
    this.__construct = function (cctrl) {
        payms = cctrl;
        $(payms.add.but).click(function () {
            addPayments();
        });
        $(payms.add.pamt).keyup(function () {
            var amountt = Number($(payms.add.pamt).val()) < 0 ? 0 : Number($(payms.add.pamt).val());
            $(payms.add.pamt).val(amountt);
        });
        $(payms.list.menuBut).click(function () {
            $(payms.msgDiv).html('');
            DisplayPaymsList();
        });
        $(payms.add.cdate).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(payms.add.pamt).change(function () {
            if ($(payms.add.pamt).val().match(ind_reg)) {
                $(payms.add.pamsg).html(VALIDNOT);
            }
            else {
                $(payms.add.pamsg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($(payms.add.pamsg).offset().top) - 95}, "slow");
                $(payms.add.pamt).show().focus();
                return;
            }
            var amtpaid = $(payms.add.pamt).val();
            if (amtpaid < 0) {
                $(payms.add.pamt).val(0);
            }
        });
        clearCollectionForm();
        fetchMOPTypes();
        window.setTimeout(function () {
            fetchUsers('supplier');
        }, 100);
        window.setTimeout(function () {
            fetchUsers('distributor');
        }, 1200);
    };
    function fetchUsers(utype) {
        var rad = '';
        console.log(utype);
        $.ajax({
            type: 'POST',
            url: payms.url,
            data: {autoloader: true, action: 'fetchUsers', utype: utype},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                console.log(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        switch (utype) {
                            case 'supplier' :
                                listofUsers = $.parseJSON(data);
                                for (i = 0; i < listofUsers.length; i++) {
                                    rad += listofUsers[i]["html"];
                                }
                                console.log(listofUsers);
                                var name = payms.add.user.slice(1, payms.add.user.length);
                                var nmsg = payms.add.usr_msg.slice(1, payms.add.usr_msg.length);
                                $(payms.add.user).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Supplier</option>' + rad + '</select>');
                                $(payms.add.user).change(function () {
                                    var type = $.trim($('#' + name + ' option:selected').text());
                                    if (type != 'Select Supplier' && $(this).val() != 'Null') {
                                        for (i = 0; i < listofUsers.length; i++) {
                                            if (Number(listofUsers[i]["id"]) == Number($(this).val())) {
                                                payms.add.label = listofUsers[i]["label"];
                                                payms.add.uid = Number(listofUsers[i]["id"]);
                                                payms.add.uind = Number(listofUsers[i]["value"]);
                                                payms.add.img = listofUsers[i]["img"];
                                                payms.add.select.pid = Number(listofUsers[i]["id"]);
                                                payms.add.select.pindex = Number(listofUsers[i]["value"]);
                                                break;
                                            }
                                            else {
                                                payms.add.label = '';
                                                payms.add.uid = 0;
                                                payms.add.uind = 0;
                                                payms.add.img = '';
                                                payms.add.select.pid = 0;
                                                payms.add.select.pindex = 0;
                                            }
                                        }
                                    }
                                });
                                break;
                            case 'distributor' :
                                listColletrs = $.parseJSON(data);
                                for (i = 0; i < listColletrs.length; i++) {
                                    rad += listColletrs[i]["html"];
                                }
                                var name = payms.add.pay_ac.slice(1, payms.add.pay_ac.length);
                                var nmsg = payms.add.payac_msg.slice(1, payms.add.payac_msg.length);
                                $(payms.add.pay_ac).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Collector</option>' + rad + '</select>');
                                $(payms.add.pay_ac).change(function () {
                                    var type = $.trim($('#' + name + ' option:selected').text());
                                    if (type != 'Select distributor' && $(this).val() != 'Null') {
                                        for (i = 0; i < listColletrs.length; i++) {
                                            console.log("array = " + listColletrs[i]["id"]);
                                            console.log("option = " + $(this).select().val());
                                            if (Number(listColletrs[i]["id"]) == Number($(this).select().val())) {
                                                payms.add.select.pindex = Number(listColletrs[i]["id"]);
                                                payms.add.select.coltrind = Number(listColletrs[i]["value"]);
                                                break;
                                            }
                                            else {
                                                payms.add.select.pindex = 0;
                                                payms.add.select.coltrind = 0;
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
                $(payms.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchMOPTypes() {
        var rad = '';
        $(payms.add.acdiv).hide();
        $.ajax({
            type: 'POST',
            url: payms.url,
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
                        $(payms.add.mopdiv).html('<select class="form-control" id="' + payms.add.mop + '"><option value="NULL" selected>Select Mode of payment</option>' + rad + '</select><p class="help-block" id="' + payms.add.mopmsg + '">Enter/ Select.</p>');
                        $(document.getElementById(payms.add.mop)).change(function () {
                            fetchBankAccount(payms.add);
                            $(payms.add.acdiv).hide();
                        });
                        break;
                }
            },
            error: function () {
                $(payms.outputDiv).html(INET_ERROR);
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
                    url: payms.url,
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
                                $(payments.acdiv).html('<select class="form-control" id="' + payments.pay_ac + '"><option value="NULL" selected>Select Bank Account</option>' + rad + '</select><p class="help-block" id="' + payments.payac_msg + '">Enter/ Select.</p>');
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
                        $(payms.outputDiv).html(INET_ERROR);
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
        $(payms.msgDiv).html('');
        var account = {};
        /* Payer */
        if (payms.add.select.pid > 0 && payms.add.select.pindex > -1) {
            flag = true;
            $(payms.add.usr_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(payms.add.usr_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(payms.add.usr_msg).offset().top) - 95}, "slow");
            $(payms.add.user).focus();
            return;
        }
        /* Payer */
        if (payms.add.uid > 0 && payms.add.uind > -1) {
            flag = true;
            $(payms.add.usr_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(payms.add.usr_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(payms.add.usr_msg).offset().top) - 95}, "slow");
            $(payms.add.user).focus();
            return;
        }
        /* Date of payment */
        if ($(payms.add.cdate).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(payms.add.cdmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(payms.add.cdmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(payms.add.cdmsg).offset().top) - 95}, "slow");
            $(payms.add.cdate).focus();
            return;
        }
        /* Mode of payment */
        var mop = $('#' + payms.add.mop).val();
        var moptype = $.trim($('#' + payms.add.mop + ' option:selected').text());
        console.log(mop);
        if (mop != 'NULL') {
            flag = true;
            $('#' + payms.add.mopmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $('#' + payms.add.mopmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($('#' + payms.add.mopmsg).offset().top) - 95}, "slow");
            $(payms.add.mop).show().focus();
            return;
        }
        /* Bank Account */
        var ac_id = 0;
        var acc = $('#' + payms.add.pay_ac).val();
        if (moptype != 'Cash') {
            if (acc == 'Add') {
                flag = true;
                $('#' + payms.add.payac_msg).html(VALIDNOT);
                if ($(document.getElementById(payms.add.ac.bankname)).val().match(name_reg)) {
                    flag = true;
                    $(document.getElementById(payms.add.ac.nmsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(payms.add.ac.nmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(payms.add.ac.nmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(payms.add.ac.bankname)).focus();
                    return;
                }
                if ($(document.getElementById(payms.add.ac.accno)).val().match(accn_reg)) {
                    flag = true;
                    $(document.getElementById(payms.add.ac.nomsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(payms.add.ac.nomsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(payms.add.ac.nomsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(payms.add.ac.accno)).focus();
                    return;
                }
                if ($(document.getElementById(payms.add.ac.braname)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(payms.add.ac.bnmsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(payms.add.ac.bnmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(payms.add.ac.bnmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(payms.add.ac.braname)).focus();
                    return;
                }
                if ($(document.getElementById(payms.add.ac.bracode)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(payms.add.ac.bcmsg)).html(VALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(payms.add.ac.bcmsg)).offset().top) - 95}, "slow");
                }
                else {
                    flag = false;
                    $(document.getElementById(payms.add.ac.bcmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(payms.add.ac.bcmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(payms.add.ac.bracode)).focus();
                    return;
                }
                if ($(document.getElementById(payms.add.ac.IFSC)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(payms.add.ac.IFSCmsg)).html(VALIDNOT);
                }
                else {
                    flag = false;
                    $(document.getElementById(payms.add.ac.IFSCmsg)).html(INVALIDNOT);
                    $('html, body').animate({scrollTop: Number($(document.getElementById(payms.add.ac.IFSCmsg)).offset().top) - 95}, "slow");
                    $(document.getElementById(payms.add.ac.IFSC)).focus();
                    return;
                }
                account = {
                    bankname: $(document.getElementById(payms.add.ac.bankname)).val(),
                    accno: $(document.getElementById(payms.add.ac.accno)).val(),
                    braname: $(document.getElementById(payms.add.ac.braname)).val(),
                    bracode: $(document.getElementById(payms.add.ac.bracode)).val(),
                    IFSC: $(document.getElementById(payms.add.ac.IFSC)).val()
                };
            }
            else if (acc == 'NULL') {
                flag = false;
                $('#' + payms.add.payac_msg).html(INVALIDNOT);
                $('html, body').animate({scrollTop: Number($('#' + payms.add.payac_msg).offset().top) - 95}, "slow");
                $('#' + payms.add.pay_ac).show().focus();
                return;
            }
            else {
                flag = true;
                $('#' + payms.add.payac_msg).html(VALIDNOT);
                ac_id = acc;
            }
        }
        /* Amount */
        if ($(payms.add.pamt).val().match(ind_reg)) {
            flag = true;
            $(payms.add.pamsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(payms.add.pamsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(payms.add.pamsg).offset().top) - 95}, "slow");
            $(payms.add.pamt).show().focus();
            return;
        }
        /* Remark */
        if ($(payms.add.rmk).val().length < 101) {
            flag = true;
            $(payms.add.rmkmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(payms.add.rmkmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(payms.add.rmkmsg).offset().top) - 95}, "slow");
            $(payms.add.rmk).show().focus();
            return;
        }
        var attr = {
            uid: Number($.trim(payms.add.uid)),
            uindex: Number($.trim(payms.add.uind)),
            pid: Number($.trim(payms.add.select.pid)),
            pindex: Number($.trim(payms.add.select.pindex)),
            pdate: $(payms.add.cdate).val(),
            pay_ac: $.trim(acc),
            mop: Number($.trim(mop)),
            ac_id: Number($.trim(ac_id)),
            account: account,
            pamt: Number($.trim($(payms.add.pamt).val())),
            rmk: $.trim($(payms.add.rmk).val())
        };
        if (flag) {
            $(payms.add.but).prop('disabled', 'disabled');
            $.ajax({
                url: payms.add.url,
                type: 'POST',
                data: {autoloader: true, action: 'addPayment', payms: attr},
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
                            $(payms.msgDiv).html('<h2>Payment added to database</h2>');
                            $('html, body').animate({scrollTop: Number($(payms.msgDiv).offset().top) - 95}, "slow");
                            $(payms.add.form).get(0).reset();

                            break;
                    }
                },
                error: function () {
                    $(payms.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(payms.add.but).removeAttr('disabled');
                }
            });
        }
    }
    ;
    function clearCollectionForm() {
    }
    ;
    function DisplayUpdatedPaymsList() {
        $(payms.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: payms.list.url,
            type: 'post',
            data: {autoloader: true, action: 'DisplayUpdatedPaymsList'},
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
                        $(payms.list.listDiv).append(data);
                        $(payms.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(payms.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function DisplayPaymsList() {
        var header = '<table class="table table-striped table-bordered table-hover" id="list_pay_table"><thead><tr><th colspan="7">Outgoing Transactions</th></tr><tr><th>#</th><th>Date</th><th>Name</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>';
        var footer = '</table>';
        $(payms.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: payms.list.url,
            type: 'post',
            data: {autoloader: true, action: 'DisplayPaymsList'},
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
                        $(payms.list.listDiv).html(header + data + footer);
                        window.setTimeout(function () {
                            $('#list_pay_table').dataTable();
                        }, 600)
                        $(payms.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(payms.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });

    }
}
