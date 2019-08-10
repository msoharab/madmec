function purchaseController() {
    purchase_Info = {};

    this.__construct = function (purchase) {
        purchase_Info = purchase;
        $(purchase.but).click(function () {
            pattyAdd();
        });
        $(purchase.listpur).click(function () {
            DisplayPurchaseList();
        });
        $(purchase_Info.date).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        fetchPackTypes();
        fetchSuppliers();
    };
    function pattyAdd() {
        var flag = false;
        var type = $('#' + purchase_Info.pack_type).val();
        /* Vehicle Number */
        if ($(purchase_Info.vehicle).val().length < 101) {
            flag = true;
            $(purchase_Info.vh_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(purchase_Info.vh_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(purchase_Info.vh_msg).offset().top) - 95}, "slow");
            $(purchase_Info.vehicle).focus();
            return;
        }
        if (type != 'NULL' && type != '') {
            flag = true;
        }
        else {
            flag = false;
            $('#' + purchase_Info.pt_msg).html('<strong class="text-danger">Select packing type.</strong>');
            $('html, body').animate({scrollTop: Number($('#' + purchase_Info.pt_msg).offset().top) - 95}, "slow");
        }
        /* Supplier name */
        if (purchase_Info.sid > 0 && purchase_Info.sind > -1) {
            flag = true;
            $(purchase_Info.nmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(purchase_Info.nmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(purchase_Info.nmsg).offset().top) - 95}, "slow");
            $(purchase_Info.name).show().focus();
            return;
        }
        /* Number of packs */
        if ($(purchase_Info.packs).val().match(ind_reg)) {
            flag = true;
            $(purchase_Info.packsmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(purchase_Info.packsmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(purchase_Info.packsmsg).offset().top) - 95}, "slow");
            $(purchase_Info.packs).focus();
            return;
        }
        /* Product name */
        if (purchase_Info.pid > 0 && purchase_Info.pind > -1) {
            flag = true;
            $(purchase_Info.prodmsg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(purchase_Info.prodmsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(purchase_Info.prodmsg).offset().top) - 95}, "slow");
            $(purchase_Info.product).show().focus();
            return;
        }
        /* Consignment arrival */
        if ($(purchase_Info.date).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(purchase_Info.pd_msg).html(VALIDNOT);
        }
        else {
            flag = false;
            $(purchase_Info.pd_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(purchase_Info.pd_msg).offset().top) - 95}, "slow");
            $(purchase_Info.date).focus();
            return;
        }
        var attr = {
            pack_type: type,
            packs: $(purchase_Info.packs).val(),
            name: $(purchase_Info.name).val(),
            sid: purchase_Info.sid,
            sind: purchase_Info.sind,
            product: $(purchase_Info.product).val(),
            pid: purchase_Info.pid,
            pind: purchase_Info.pind,
            vehicle: $(purchase_Info.vehicle).val(),
            date: $(purchase_Info.date).val()
        };
        if (flag) {
            $(purchase_Info.but).attr('disabled', 'disabled');
            $(purchase_Info.msgDiv).html('');
            $.ajax({
                url: purchase_Info.url,
                async: false,
                type: 'POST',
                data: {autoloader: true, action: 'pattyAdd', ptyadd: attr},
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

                            $(purchase_Info.msgDiv).html('<h2>Patty added to database</h2>');
                            $('html, body').animate({scrollTop: Number($(purchase_Info.msgDiv).offset().top) - 95}, "slow");
                            $(purchase_Info.form).get(0).reset();
                            break;
                    }
                },
                error: function () {
                    $(purchase_Info.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(purchase_Info.but).removeAttr('disabled');
                }
            });
        }
        else {
            $(purchase_Info.but).removeAttr('disabled');
        }
    }
    ;
    function fetchPackTypes() {
        var rad = '';
        $(purchase_Info.pt_msg).html(LOADER_TWO);
        $.ajax({
            type: 'POST',
            url: purchase_Info.url,
            async: false,
            data: {autoloader: true, action: 'fetchPackTypes'},
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
                        listofPackTypes = type;
                        for (i = 0; i < type.length; i++) {
                            rad += type[i]["html"];
                        }
                        $(purchase_Info.TVPtype).html('<select class="form-control" id="' + purchase_Info.pack_type + '"><option value="NULL" selected>Select package type</option>' + rad + '</select><p class="help-block" id="' + purchase_Info.pt_msg + '">Enter/ Select.</p>');
                        $(purchase_Info.pt_msg).html('Enter / Select');
                        break;
                }
            },
            error: function () {
                $(purchase_Info.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchSuppliers() {
        var rad = '';
        $(purchase_Info.nmsg).html(LOADER_TWO);
        $.ajax({
            type: 'POST',
            url: purchase_Info.url,
            async: false,
            data: {autoloader: true, action: 'fetchUsers', utype: 'supplier'},
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
                        listofSuppliers = $.parseJSON(data);
                        if (listofSuppliers) {
                            for (i = 0; i < listofSuppliers.length; i++) {
                                rad += listofSuppliers[i]["html"];
                            }
                            var name = purchase_Info.name.slice(1, purchase_Info.name.length);
                            var nmsg = purchase_Info.nmsg.slice(1, purchase_Info.nmsg.length);
                            $(purchase_Info.name).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Supplier</option>' + rad + '</select>');
                            $(purchase_Info.nmsg).html('Enter / Select');
                            $(purchase_Info.name).change(function () {
                                var type = $.trim($('#' + name + ' option:selected').text());
                                if (type != 'Select Supplier' && $(this).val() != 'Null') {
                                    for (i = 0; i < listofSuppliers.length; i++) {
                                        if (Number(listofSuppliers[i]["id"]) == Number($(this).val())) {
                                            purchase_Info.label = listofSuppliers[i]["label"];
                                            purchase_Info.sid = Number(listofSuppliers[i]["id"]);
                                            purchase_Info.sind = Number(listofSuppliers[i]["value"]);
                                            purchase_Info.img = listofSuppliers[i]["img"];
                                            break;
                                        }
                                    }
                                    fetchUserProduct(Number($(this).val()));
                                    /*
                                     for (i = 0; i < listofSuppliers.length; i++) {
                                     if (Number(listofSuppliers[i]["id"]) == Number($(this).val())) {
                                     purchase_Info.label = listofSuppliers[i]["label"];
                                     purchase_Info.sid = Number(listofSuppliers[i]["id"]);
                                     purchase_Info.sind = Number(listofSuppliers[i]["value"]);
                                     purchase_Info.img = listofSuppliers[i]["img"];
                                     listofProducts = listofSuppliers[i]["prdhtml"];
                                     rad = '';
                                     for (j = 0; j < listofProducts.length; j++) {
                                     rad += listofProducts[j]["html"];
                                     }
                                     name = purchase_Info.product.slice(1, purchase_Info.product.length);
                                     nmsg = purchase_Info.prodmsg.slice(1, purchase_Info.prodmsg.length);
                                     $(purchase_Info.product).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Product</option>' + rad + '</select>');
                                     $(purchase_Info.product).change(function () {
                                     type = $.trim($('#' + name + ' option:selected').text());
                                     if (type != 'Select Product' && $(this).val() != 'Null') {
                                     for (j = 0; j < listofProducts.length; j++) {
                                     if (Number(listofProducts[j]["id"]) == Number($(this).val())) {
                                     purchase_Info.label = listofProducts[j]["label"];
                                     purchase_Info.pid = Number(listofProducts[j]["id"]);
                                     purchase_Info.pind = Number(listofProducts[j]["value"]);
                                     break;
                                     }
                                     else {
                                     purchase_Info.label = '';
                                     purchase_Info.pid = 0;
                                     purchase_Info.pind = 0;
                                     }
                                     }
                                     }
                                     });
                                     break;
                                     }
                                     else {
                                     purchase_Info.label = '';
                                     purchase_Info.sid = 0;
                                     purchase_Info.sind = 0;
                                     purchase_Info.img = '';
                                     }
                                     }
                                     */
                                }
                            });
                        }
                        else {
                            $(purchase_Info.name).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Supplier</option></select>');
                            $(purchase_Info.nmsg).html('Enter / Select');
                            purchase_Info.label = '';
                            purchase_Info.sid = 0;
                            purchase_Info.sind = 0;
                            purchase_Info.img = '';
                        }
                        break;
                }
            },
            error: function () {
                $(purchase_Info.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchUserProduct(uid) {
        var rad = '';
        $(purchase_Info.prodmsg).html(LOADER_TWO);
        $.ajax({
            type: 'POST',
            url: purchase_Info.url,
            async: false,
            data: {autoloader: true, action: 'fetchUserProduct', uid: Number(uid)},
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
                        listofProducts = $.parseJSON(data);
                        if (listofProducts) {
                            rad = '';
                            for (j = 0; j < listofProducts.length; j++) {
                                rad += listofProducts[j]["html"];
                            }
                            var name = purchase_Info.product.slice(1, purchase_Info.product.length);
                            var nmsg = purchase_Info.prodmsg.slice(1, purchase_Info.prodmsg.length);
                            $(purchase_Info.product).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Product</option>' + rad + '</select>');
                            $(purchase_Info.prodmsg).html('Enter / Select');
                            $(purchase_Info.product).change(function () {
                                type = $.trim($('#' + name + ' option:selected').text());
                                if (type != 'Select Product' && $(this).val() != 'Null') {
                                    for (j = 0; j < listofProducts.length; j++) {
                                        if (Number(listofProducts[j]["id"]) == Number($(this).val())) {
                                            purchase_Info.label = listofProducts[j]["label"];
                                            purchase_Info.pid = Number(listofProducts[j]["id"]);
                                            purchase_Info.pind = Number(listofProducts[j]["value"]);
                                            break;
                                        }
                                        else {
                                            purchase_Info.label = '';
                                            purchase_Info.pid = 0;
                                            purchase_Info.pind = 0;
                                        }
                                    }
                                }
                            });
                        }
                        else {
                            $(purchase_Info.product).replaceWith('<select class="form-control" id="' + name + '"><option value="NULL" selected>Select Product</option></select>');
                            $(purchase_Info.prodmsg).html('Enter / Select');
                            purchase_Info.label = '';
                            purchase_Info.pid = 0;
                            purchase_Info.pind = 0;
                        }
                        break;
                }
            },
            error: function () {
                $(purchase_Info.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function DisplayPurchaseList() {
        $(purchase_Info.listDiv).html(LOADER_ONE);
        $(purchase_Info.msgDiv).html('');
        $.ajax({
            url: purchase_Info.url,
            async: false,
            type: 'post',
            data: {autoloader: true, action: 'DisplayPurchasetList'},
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
                        $(purchase_Info.listDiv).html(data);
                        window.setTimeout(function () {
                            $('#consignment_table').dataTable();
                        }, 600)
                        $(purchase_Info.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(purchase_Info.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
}
