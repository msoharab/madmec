function collectionController() {
    var colls = {};
    var listofUsers = {};
    var listofProducts = {};
    var listofPattys = {};
    var listofcolls = {};
    var listofMOPtypes = {};
    var listofBankAC = {};
    var follw = {};
    this.__construct = function (cctrl) {
        colls = cctrl;
        follw = cctrl.follup;
        $(colls.add.menuBut).click(function () {
            $(colls.msgDiv).html('');
        });
        $(colls.add.but).click(function () {
            addPayments();
        });
        $(colls.list.menuBut).click(function () {
            $(colls.msgDiv).html('');
            DisplayCollsList();
        });
        $(colls.add.pamt).keyup(function () {
            var amountt = Number($(colls.add.pamt).val()) < 0 ? 0 : Number($(colls.add.pamt).val());
            $(colls.add.pamt).val(amountt);
        });
        $(colls.projincom.amount).keyup(function () {
            var amountt = Number($(colls.projincom.amount).val()) < 0 ? 0 : Number($(colls.projincom.amount).val());
            $(colls.projincom.amount).val(amountt);
        })
        $(colls.projincom.menuBut).click(function () {
            fetchprojincomclient()
        });
        $(colls.projincom.amount).keyup(function () {
            var cdue = Number($(colls.projincom.currentdue).val());
            var amount = Number($(colls.projincom.amount).val());
            $(colls.projincom.dueamount).val(cdue - amount);
        });
        $(colls.projincom.amount).change(function () {
            var cdue = Number($(colls.projincom.currentdue).val());
            var amount = Number($(colls.projincom.amount).val());
            $(colls.projincom.dueamount).val(cdue - amount);
            if (Number($(colls.projincom.amount).val()) > Number($(colls.projincom.currentdue).val())) {
                $(colls.projincom.amount_msg).html(INVALIDNOT)
            }
            if (Number($(colls.projincom.dueamount).val()) == 0) {
                $(colls.projincom.duedate).hide();
            } else {
                $(colls.projincom.duedate).show();
            }
        });
        $(follw.plus).unbind();
        $(follw.plus).click(function () {
            $(follw.plus).hide();
            bulitMultipleFollowups();
        });
        $(colls.projincom.but).click(function () {
            addprojpayment();
        });
        $(colls.add.cdate).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(colls.projincom.dateofpay).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(colls.projincom.duedate).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(colls.add.pamt).change(function () {
            if ($(colls.add.pamt).val().match(ind_reg)) {
                $(colls.add.pamsg).html(VALIDNOT);
            } else {
                $(colls.add.pamsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(colls.add.pamsg).offset().top) - 95
                }, 'slow');
                $(colls.add.pamt).show().focus();
                return;
            }
            var amtpaid = $(colls.add.pamt).val();
            if (amtpaid < 0) {
                $(colls.add.pamt).val(0);
            }
        });
        clearCollectionForm();
        fetchUsers();
        fetchMOPTypes();
    };

    function bulitMultipleFollowups() {
        if (follw.num == -1)
            $(follw.parentDiv).html('');
        follw.num++;
        var html = '<div id="' + follw.form + follw.num + '">' +
                '<div class="col-lg-4">' + '<input class="form-control" placeholder="Follow up dates" name="followupdate" type="text" id="' + follw.followupdate + follw.num + '" maxlength="100" readonly=""/>' + '<p class="help-block" id="' + follw.msgDiv + follw.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-2">' + '<button type="button" class="btn btn-danger  btn-md" id="' + follw.minus + follw.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button type="button" class="btn btn-success  btn-md" id="' + follw.plus + follw.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
        binddakepickertofallow(follw.num)
        $(follw.parentDiv).append(html);
        window.setTimeout(function () {
            binddakepickertofallow(follw.num);
            $(document.getElementById(follw.minus + follw.num)).click(function () {
                $(document.getElementById(follw.form + follw.num)).remove();
                $(document.getElementById(follw.msgDiv + follw.num)).remove();
                follw.num--;
                if (follw.num == -1) {
                    $(follw.plus).show();
                    $(follw.parentDiv).html('');
                } else {
                    $(document.getElementById(follw.plus + follw.num)).show();
                    $(document.getElementById(follw.minus + follw.num)).show();
                }
            });
            $(document.getElementById(follw.plus + follw.num)).click(function () {
                $(document.getElementById(follw.plus + follw.num)).hide();
                $(document.getElementById(follw.minus + follw.num)).hide();
                bulitMultipleFollowups();
            });
        }, 200);
    }

    function binddakepickertofallow(num) {
        for (i = 0; i <= num; i++) {
            console.log(follw.followupdate + i);
            $(document.getElementById(follw.followupdate + i)).datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true
            });
        }
    }

    function fetchUsers() {
        var rad = '';
        $.ajax({
            type: 'POST',
            url: colls.url,
            data: {
                autoloader: true,
                action: 'fetchUsers',
                utype: 'Client'
            },
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
                        listofUsers = $.parseJSON(data);
                        if (listofUsers != null) {
                            for (i = 0; i < listofUsers.length; i++) {
                                rad += listofUsers[i]["html"];
                            }
                            var name = colls.add.user.slice(1, colls.add.user.length);
                            var nmsg = colls.add.usr_msg.slice(1, colls.add.usr_msg.length);
                            $(colls.add.user).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Client</option>' + rad + '</select>');
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
                                        } else {
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

    function fetchprojincomclient() {
        $(colls.msgDiv).html('');
        $(colls.projincom.disclient).html(LOADER_ONE);
        var rad = '';
        $.ajax({
            type: 'POST',
            url: colls.url,
            data: {
                autoloader: true,
                action: 'projincomclient',
            },
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
                        listofUsers = $.parseJSON(data);
                        $(colls.projincom.disclient).html('<select class="form-control" id="client_proj_incom"><option value="NULL" selected>Select Client</option>' + listofUsers + '</select>');
                        $(colls.projincom.disproj).html('<select class="form-control" id="client_proj_list"><option value="NULL" selected>Select Project</option></select>');
                        $('#' + colls.projincom.client).change(function () {
                            var cid = $('#' + colls.projincom.client).val();
                            $(colls.projincom.totalamount).val('');
                            $(colls.projincom.currentdue).val('');
                            $(colls.projincom.dueamount).val('');
                            $(colls.projincom.amount).val('');
                            fetchprojectsofclient(cid);
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

    function fetchprojectsofclient(cid) {
        var rad = '';
        $.ajax({
            type: 'POST',
            url: colls.url,
            data: {
                autoloader: true,
                action: 'fetchclientprojects',
                clientid: cid
            },
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
                        listofUsers = $.parseJSON(data);
                        $(colls.projincom.disproj).html('<select class="form-control" id="client_proj_list"><option value="NULL" selected>Select Project</option>' + listofUsers + '</select>');
                        $('#' + colls.projincom.projlist).change(function () {
                            var pid = $('#' + colls.projincom.projlist).val();
                            $(colls.projincom.dueamount).val('');
                            $(colls.projincom.amount).val('');
                            fetchdueamountofclientprojects(pid);
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

    function fetchdueamountofclientprojects(pid) {
        $.ajax({
            type: 'POST',
            url: colls.url,
            data: {
                autoloader: true,
                action: 'fetchdueamountofclientprojects',
                projid: pid
            },
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
                        listofUsers = $.parseJSON(data);
                        tempdata = listofUsers.split("-");
                        $(colls.projincom.totalamount).val(tempdata[0]);
                        $(colls.projincom.currentdue).val(tempdata[1]);
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
            data: {
                autoloader: true,
                action: 'fetchMOPTypes',
                incoming: 'incoming',
            },
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
                        console.log(type);
                        if (type != null) {
                            listofMOPtypes = type;
                            for (i = 0; i < (type.length); i++) {
                                rad += type[i]["html"];
                            }
                            $(colls.add.mopdiv).html('<select class="form-control" id="' + colls.add.mop + '"><option value="NULL" selected>Select Mode of payment</option>' + rad + '</select><p class="help-block" id="' + colls.add.mopmsg + '">Enter / Select</p>');
                            $(document.getElementById(colls.add.mop)).change(function () {
                                fetchBankAccount(colls.add);
                                $(colls.add.acdiv).hide();
                            });
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

    function fetchBankAccount(payments) {
        var type = $.trim($('#' + payments.mop + ' option:selected').text());
        var flag = false;
        var rad = '';
        /* Retailer */
        if (payments.uid > 0 && payments.uind > -1) {
            flag = true;
            $(payments.usr_msg).html(VALIDNOT);
        } else {
            flag = false;
            $(payments.usr_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(payments.usr_msg).offset().top) - 95
            }, 'slow');
            $(payments.user).focus();
            return;
        }
        if (payments.select.pid > 0 && payments.select.pindex > -1) {
            flag = true;
            $(payments.usr_msg).html(VALIDNOT);
        } else {
            flag = false;
            $(payments.usr_msg).append(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(payments.usr_msg).offset().top) - 95
            }, 'slow');
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
                    data: {
                        autoloader: true,
                        action: 'fetchBankAccount',
                        soruce: payments
                    },
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
                                if (listofBankAC != null) {
                                    for (i = 0; i < listofBankAC.length; i++) {
                                        rad += listofBankAC[i]["html"];
                                    }
                                    $(payments.acdiv).html('<select class="form-control" id="' + payments.pay_ac + '"><option value="NULL" selected>Select Bank Account</option>' + rad + '</select><p class="help-block" id="' + payments.payac_msg + '">Enter / Select</p>');
                                    $(document.getElementById(payments.pay_ac)).change(function () {
                                        var type = $.trim($('#' + payments.pay_ac + ' option:selected').text());
                                        var val = $.trim($('#' + payments.pay_ac).val());
                                        if (val == 'Add' && type == 'Add') {
                                            AddBankAccount(payments);
                                        } else if (val == 'NULL') {
                                            payments.ac_id = '';
                                            $('#' + payments.ac.parentDiv).html('');
                                        } else {
                                            payments.ac_id = Number(val);
                                            $('#' + payments.ac.parentDiv).html('');
                                        }
                                    });
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
        } else {
            $('#' + payments.ac.parentDiv).html('');
            $(payments.acdiv + ',' + payments.acdivtit).hide();
        }
    }
    ;

    function AddBankAccount(payments) {
        var html = '<div id="' + payments.ac.form + '">' + '<div class="panel panel-warning">' + '<div class="panel-heading">' + '<strong>Add Bank Account</strong>&nbsp;' + '</div>' + '<div class="panel-body">' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Bank Name </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Bank Name" name="bankname" type="text" id="' + payments.ac.bankname + '" maxlength="100"/>' + '<p class="help-block" id="' + payments.ac.nmsg + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Account Number </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Account Number" name="accno" type="text" id="' + payments.ac.accno + '" maxlength="100"/>' + '<p class="help-block" id="' + payments.ac.nomsg + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Name </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Branch Name" name="braname" type="text" id="' + payments.ac.braname + '" maxlength="100"/>' + '<p class="help-block" id="' + payments.ac.bnmsg + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Code </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Branch Code" name="bracode" type="text" id="' + payments.ac.bracode + '" maxlength="100"/>' + '<p class="help-block" id="' + payments.ac.bcmsg + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> IFSC </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="IFSC" name="IFSC" type="text" id="' + payments.ac.IFSC + '" maxlength="100"/>' + '<p class="help-block" id="' + payments.ac.IFSCmsg + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '</div>' + '</div>' + '</div>';
        $('#' + payments.ac.parentDiv).html(html);
    }
    ;

    function addPayments() {
        $(colls.msgDiv).html('');
        var account = {};
        /* Payer */
        if (colls.add.select.pid > 0 && colls.add.select.pindex > -1) {
            flag = true;
            $(colls.add.usr_msg).html('');
        } else {
            flag = false;
            $(colls.add.usr_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(colls.add.usr_msg).offset().top) - 95
            }, 'slow');
            $(colls.add.user).focus();
            return;
        }
        /* Payer */
        if (colls.add.uid > 0 && colls.add.uind > -1) {
            flag = true;
            $(colls.add.usr_msg).html('');
        } else {
            flag = false;
            $(colls.add.usr_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(colls.add.usr_msg).offset().top) - 95
            }, 'slow');
            $(colls.add.user).focus();
            return;
        }
        /* Date of payment */
        if ($(colls.add.cdate).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(colls.add.cdmsg).html('');
        } else {
            flag = false;
            $(colls.add.cdmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(colls.add.cdmsg).offset().top) - 95
            }, 'slow');
            $(colls.add.cdate).focus();
            return;
        }
        /* Mode of payment */
        var mop = $('#' + colls.add.mop).val();
        var moptype = $.trim($('#' + colls.add.mop + ' option:selected').text());
        console.log(mop);
        if (mop != 'NULL') {
            flag = true;
            $('#' + colls.add.mopmsg).html('');
        } else {
            flag = false;
            $('#' + colls.add.mopmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#' + colls.add.mopmsg).offset().top) - 95
            }, 'slow');
            $(colls.add.mop).show().focus();
            return;
        }
        /* Bank Account */
        var ac_id = 0;
        var acc = $('#' + colls.add.pay_ac).val();
        if (moptype != 'Cash') {
            if (acc == 'Add') {
                flag = true;
                $('#' + colls.add.payac_msg).html('');
                if ($(document.getElementById(colls.add.ac.bankname)).val().match(name_reg)) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.nmsg)).html('');
                } else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.nmsg)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(colls.add.ac.nmsg)).offset().top) - 95
                    }, 'slow');
                    $(document.getElementById(colls.add.ac.bankname)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.accno)).val().match(accn_reg)) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.nomsg)).html('');
                } else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.nomsg)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(colls.add.ac.nomsg)).offset().top) - 95
                    }, 'slow');
                    $(document.getElementById(colls.add.ac.accno)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.braname)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.bnmsg)).html('');
                } else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.bnmsg)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(colls.add.ac.bnmsg)).offset().top) - 95
                    }, 'slow');
                    $(document.getElementById(colls.add.ac.braname)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.bracode)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.bcmsg)).html('');
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(colls.add.ac.bcmsg)).offset().top) - 95
                    }, 'slow');
                } else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.bcmsg)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(colls.add.ac.bcmsg)).offset().top) - 95
                    }, 'slow');
                    $(document.getElementById(colls.add.ac.bracode)).focus();
                    return;
                }
                if ($(document.getElementById(colls.add.ac.IFSC)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(colls.add.ac.IFSCmsg)).html('');
                } else {
                    flag = false;
                    $(document.getElementById(colls.add.ac.IFSCmsg)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(colls.add.ac.IFSCmsg)).offset().top) - 95
                    }, 'slow');
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
            } else if (acc == 'NULL') {
                flag = false;
                $('#' + colls.add.payac_msg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($('#' + colls.add.payac_msg).offset().top) - 95
                }, 'slow');
                $('#' + colls.add.pay_ac).show().focus();
                return;
            } else {
                flag = true;
                $('#' + colls.add.payac_msg).html('');
                ac_id = acc;
            }
        }
        /* Amount */
        if (Number($(colls.add.pamt).val()) == 0) {
            flag = false;
            $(colls.add.pamsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(colls.add.pamsg).offset().top) - 95
            }, 'slow');
            $(colls.add.pamt).show().focus();
            return;
        } else {
            flag = true;
            $(colls.add.pamsg).html('');
        }
        if ($(colls.add.pamt).val().match(ind_reg)) {
            flag = true;
            $(colls.add.pamsg).html('');
        } else {
            flag = false;
            $(colls.add.pamsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(colls.add.pamsg).offset().top) - 95
            }, 'slow');
            $(colls.add.pamt).show().focus();
            return;
        }
        /* Remark */
        if ($(colls.add.rmk).val().length < 101) {
            flag = true;
            $(colls.add.rmkmsg).html('');
        } else {
            flag = false;
            $(colls.add.rmkmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(colls.add.rmkmsg).offset().top) - 95
            }, 'slow');
            $(colls.add.rmk).show().focus();
            return;
        }
        var attr = {
            uid: Number($.trim(colls.add.uid)),
            uind: Number($.trim(colls.add.uind)),
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
                data: {
                    autoloader: true,
                    action: 'addCollection',
                    colls: attr
                },
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
                            var loc = $.parseJSON(data);
                            window.open(loc);
                            $(colls.msgDiv).html('<h2>Collection added to database</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(colls.msgDiv).offset().top) - 95
                            }, 'slow');
                            $(colls.add.form).get(0).reset();
                            // fetchUsers();
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
            data: {
                autoloader: true,
                action: 'DisplayUpdatedCollsList'
            },
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
        $(colls.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: colls.list.url,
            type: 'post',
            data: {
                autoloader: true,
                action: 'DisplayCollsList'
            },
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
                        $(colls.list.listDiv).html(data);
                        $(colls.list.listLoad).html('');
                        window.setTimeout(function () {
                            $('#displaycollet-datatable').dataTable();
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
        $(window).scroll(function (event) {
            if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
                DisplayUpdatedCollsList();
            else
                $(colls.list.listLoad).html('');
        });
    }

    function addprojpayment() {
        var flag = false;
        var followupdates = [];
        if ($('#' + colls.projincom.client).val() == 'NULL') {
            flag = false;
            $(colls.projincom.client_msg).html(INVALIDNOT);
            $('#' + colls.projincom.client).focus();
            return
        } else {
            flag = true;
            $(colls.projincom.client_msg).html(VALIDNOT);
        }
        if ($('#' + colls.projincom.projlist).val() == 'NULL') {
            flag = false;
            $(colls.projincom.disproj_msg).html(INVALIDNOT);
            $('#' + colls.projincom.projlist).focus();
            return
        } else {
            flag = true;
            $(colls.projincom.disproj_msg).html(VALIDNOT);
        }
        if ($(colls.projincom.amount).val() == '') {
            flag = false;
            $(colls.projincom.amount_msg).html(INVALIDNOT);
            $(colls.projincom.amount).focus();
            return
        } else {
            flag = true;
            $(colls.projincom.amount_msg).html(VALIDNOT);
        }
        if ($(colls.projincom.amount).val().match(numbs)) {
            flag = true;
            $(colls.projincom.amount_msg).html(VALIDNOT);
        } else {
            flag = false;
            $(colls.projincom.amount_msg).html(INVALIDNOT);
            $(colls.projincom.amount).focus();
            return
        }
        if (Number($(colls.projincom.amount).val()) == 0) {
            flag = false;
            $(colls.projincom.amount_msg).html(INVALIDNOT);
            $(colls.projincom.amount).focus();
            return
        } else {
            flag = true;
            $(colls.projincom.disproj_msg).html(VALIDNOT);
        }
        if (Number($(colls.projincom.amount).val()) > Number($(colls.projincom.currentdue).val())) {
            flag = false;
            $(colls.projincom.amount_msg).html(INVALIDNOT);
            $(colls.projincom.amount).focus();
            return
        } else {
            flag = true;
            $(colls.projincom.disproj_msg).html(VALIDNOT);
        }
        if ($(colls.projincom.dateofpay).val() == '') {
            flag = false;
            $(colls.projincom.dateofpay_msg).html(INVALIDNOT);
            $(colls.projincom.dateofpay).focus();
            return
        } else {
            flag = true;
            $(colls.projincom.dateofpay_msg).html(VALIDNOT);
        }
        if (follw.num > -1) {
            j = 0;
            for (i = 0; i <= follw.num; i++) {
                followupdates[j] = $(document.getElementById(follw.followupdate + i)).val();
                j++;
            }
        }
        var attr = {
            clientid: Number($('#' + colls.projincom.client).val()),
            projid: Number($('#' + colls.projincom.projlist).val()),
            amount: Number($(colls.projincom.amount).val()),
            dateofpay: $(colls.projincom.dateofpay).val(),
            remark: $(colls.projincom.remark).val(),
            cdue: Number($(colls.projincom.currentdue).val()),
            totalamountt: $(colls.projincom.totalamount).val(),
            duedate: $(colls.projincom.duedate).val(),
            dueamount: $(colls.projincom.dueamount).val(),
            folldates: followupdates
        };
        console.log(attr)
        if (flag) {
            $(colls.projincom.but).prop('disabled', 'disabled');
            $.ajax({
                url: colls.projincom.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'addProjCollection',
                    projcolls: attr
                },
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
                            var loc = $.parseJSON(data);
                            window.open(loc);
                            $(colls.msgDiv).html('<h2>Collection added to database</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(colls.msgDiv).offset().top) - 95
                            }, 'slow');
                            $(colls.projincom.form).get(0).reset();
                            // fetchUsers();
                            break;
                    }
                },
                error: function () {
                    $(colls.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(colls.projincom.but).removeAttr('disabled');
                }
            });
        }
    }
}