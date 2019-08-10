function materialController() {
    var Morder = {};
    this.__construct = function (morderctrl) {
        Morder = morderctrl;
        Morder.order.iid = Morder.order.vid = 'NULL';
        Morder.add_item.oid = Morder.add_item.iid = 'NULL';
        fetchVendors();
        fetchOrderItems();
        $(Morder.order.qty).keyup(function () {
            var numm = Number($(Morder.order.qty).val()) < 0 ? 0 : Number($(Morder.order.qty).val());
            $(Morder.order.qty).val(numm);
        })
        $(Morder.add_item.qty).keyup(function () {
            var numm = Number($(Morder.add_item.qty).val()) < 0 ? 0 : Number($(Morder.add_item.qty).val());
            $(Morder.add_item.qty).val(numm);
        });
        $(Morder.add_item.upmmatorder_qty).keyup(function () {
            var numm = Number($(Morder.add_item.upmmatorder_qty).val()) < 0 ? 0 : Number($(Morder.add_item.upmmatorder_qty).val());
            $(Morder.add_item.upmmatorder_qty).val(numm);
        });
        $(Morder.msgDiv).html('');
        $(Morder.add_item.doo + ',' + Morder.add_item.edod + ',' + Morder.order.doo + ',' + Morder.order.edod).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(Morder.order.but).click(function () {
            addMaterialOrder();
        });
        $(Morder.add_item.upaddmaterialsBut).click(function () {
            updateExistingQuantity();
        })

        $(Morder.add_item.menuBut).click(function () {
            $(Morder.msgDiv).html('');
            $(Morder.add_item.mo_descb).val();
            $(Morder.add_item.listDiv).html('');
            fetechmaterialordered();
            mfetchOrderItems();
        });
        $(Morder.view_order.menuBut).click(function () {
            fetchmaterialordereddetails();
        });
        $(Morder.order_supplied.menuBut).click(function () {
            fetchmaterialorderedsupplieddetails();
        });
        $(Morder.add_item.but).click(function () {
            $(Morder.msgDiv).html('');
            additemtoexistingorder();
        });
    };

    function GenerateMOPDF(oidd) {
        $.ajax({
            type: 'POST',
            url: Morder.add_item.url,
            data: {
                autoloader: true,
                action: 'mopdfgen',
                attr: oidd
            },
            success: function (data, textStatus, xhr) {
                alert("Materail Order has been Sucessesfully Generated");
                window.open($.trim(data))
                $(Morder.msgDiv).html('');
                $(Morder.add_item.mo_descb).val();
                $(Morder.add_item.listDiv).html('');
                fetechmaterialordered();
                mfetchOrderItems();

            }
        });
    }

    function updateExistingQuantity() {
        var flag = false;
        if (($(Morder.add_item.upmmatorder_qty).val() == "") || (Number($(Morder.add_item.upmmatorder_qty).val() == 0)) || (!$(Morder.add_item.upmmatorder_qty).val().match(numbs))) {
            flag = false;
            $(Morder.add_item.upmmatorder_qtymsg).html(INVALIDNOT)
            $(Morder.add_item.upmmatorder_qty).focus();
            return;
        } else {
            flag = true;
            $(Morder.add_item.upmmatorder_qtymsg).html('')
        }
        var attr = {
            qty: $(Morder.add_item.upmmatorder_qty).val(),
            iid: Number(Morder.add_item.iid),
            oid: Number(Morder.add_item.oid),
            doo: $(Morder.add_item.doo).val(),
            edod: $(Morder.add_item.edod).val(),
            mo_descb_id: $(Morder.add_item.mo_descb).val()
        };
        if (flag) {
            $.ajax({
                url: Morder.add_item.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'additemtoexistingorder',
                    materialOrder: attr
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
                            // $(Morder.msgDiv).html('<h2>Item has been Successfully added to Existing Order</h2>');
                            fetchvendorOrderedDeails(attr.oid);
                            $(Morder.add_item.addnewitemss).show();
                            $(Morder.add_item.updatequantity).hide();
                            $('html, body').animate({
                                scrollTop: Number($(Morder.add_item.ord_id).offset().top) - 95
                            }, 'slow');
                            break;
                    }
                },
                error: function () {
                    $(Morder.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(Morder.add_item.but).removeAttr('disabled');
                }
            });

        }
    }

    function fetchmaterialorderedsupplieddetails() {
        $(Morder.msgDiv).html('');
        $(Morder.order_supplied.displayorded).html(LOADER_ONE);
        var htm = '';
        $.ajax({
            url: Morder.order_supplied.url,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'mosdetails'
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
                        var itemlist = $.parseJSON(data);
                        if (itemlist.html.length) {
                            for (i = 0; i < itemlist.html.length; i++) {
                                htm += itemlist.html[i] + itemlist.tgtitle[i];
                            }
                            var header = '<div class="col-md-12"><div class="panel panel-primary"><div class="panel-heading">  Item Supplied Details </div><div class="panel-body"><div class="panel-group" id="view_itemsupplied">';
                            var footer = '</div></div></div></div>';
                            $(Morder.order_supplied.displayorded).html(header + htm + footer);
                        }
                        else
                        {
                            $(Morder.order_supplied.displayorded).html('<div class="col-lg-12">&nbsp;</div><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">&nbsp;</div><div class="text-center"><strong class="text-danger">no data found</strong></div>');
                        }
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function fetchmaterialordereddetails() {
        $(Morder.msgDiv).html('');
        $(Morder.view_order.displayorded).html(LOADER_ONE);
        var htm = '';
        $.ajax({
            url: Morder.add_item.url,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'modetails'
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
                        var itemlist = $.parseJSON(data);
                        if (itemlist.status == "success")
                        {
                            for (i = 0; i < itemlist.html.length; i++) {
                                htm += itemlist.html[i] + itemlist.tgtitle[i];
                            }
                            var header = '<div class="col-md-12"><div class="panel panel-primary"><div class="panel-heading">  Material Order Details </div><div class="panel-body"><div class="panel-group" id="view_materialordered">';
                            var footer = '</div></div></div></div>';
                            $(Morder.view_order.displayorded).html(header + htm + footer);
                            window.setTimeout(function () {
                                for (i = 0; i < itemlist.mo_orders_id.length; i++) {
                                    $(itemlist.moupdate + itemlist.mo_orders_id[i]).bind('click', {
                                        id: itemlist.mo_orders_id[i],
                                        qtyorder: itemlist.allqty[i]
                                    }, function (event) {
                                        //                                                         console.log();
                                        var qtyinn = 0;
                                        var modescb_id = event.data.id;
                                        var oqtyn = Number(event.data.qtyorder);
                                        for (i = 0; i < itemlist.mo_orders_id.length; i++) {
                                            if (Number(itemlist.mo_orders_id[i]) == Number(modescb_id)) {
                                                qtyinn = Number($(itemlist.stockin + modescb_id).val());
                                                break;
                                            }
                                        }
                                        if (qtyinn <= oqtyn && qtyinn != 0) {
                                            updatestockindetails(modescb_id, qtyinn);
                                        }
                                        fetchmaterialordereddetails();
                                    });
                                }
                            }, 600);
                        }
                        else
                        {
                            $(Morder.view_order.displayorded).html('<div class="col-lg-12">&nbsp;</div><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">&nbsp;</div><div class="text-center"><strong class="text-danger">no data found</strong></div>');
                        }
//                        if (itemlist != null) {

//                        }
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function updatestockindetails(mo_id, qtyin) {
        var attr = {
            moid: mo_id,
            qtyyin: qtyin
        }
        $.ajax({
            url: Morder.view_order.url,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'updatestockin',
                stockindetails: attr
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
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function fetchvendorOrderedDeails(oidd) {
        var htm = '';
        $(Morder.add_item.mo_descb).val();
        $(Morder.msgDiv).html('');
        $(Morder.add_item.listDiv).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: Morder.add_item.url,
            data: {
                autoloader: true,
                action: 'fetchvendorOrderedDeails',
                attr: oidd
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
                        var itmelist = $.parseJSON(data);
                        if (itmelist != null) {
                            for (i = 0; i < itmelist.html.length; i++) {
                                htm += itmelist.html[i];
                            }
                            if (itmelist.html.length == 0) {
                                $(Morder.add_item.listDiv).html('');
                            } else {
                                $(Morder.add_item.listDiv).html(itmelist.header_html + htm + itmelist.footer_html + itmelist.generate);
                            }
                            window.setTimeout(function () {
                                for (i = 0; i < itmelist.html.length; i++) {
                                    $(itmelist.es + itmelist.item_id[i]).bind('click', {
                                        id: itmelist.item_id[i],
                                        qty: itmelist.quantity[i]
                                    }, function (event) {
                                        var item_id = event.data.id;
                                        var qnty = event.data.qty;
                                        console.log(item_id);
                                        var chk = editmaterialorderitem(item_id, qnty);
                                    });
                                    $(itmelist.deleteOk + itmelist.item_id[i]).bind('click', {
                                        id: itmelist.item_id[i]
                                    }, function (event) {
                                        $($(this).prop('name')).hide(400);
                                        var item_id = event.data.id;
                                        console.log(item_id);
                                        var chk = materialorderitemdelete(item_id);
                                        if (chk == '1') {
                                            $(itmelist.itemrow + itmelist.order_id + '_' + item_id).remove();
                                            fetchvendorOrderedDeails(itmelist.order_id);
                                        }
                                    });
                                }
                                $(Morder.add_item.moexcelgen).click(function () {
                                    GenerateMOPDF(oidd);
                                });
                                $(Morder.add_item.mopdfgen).click(function () {
                                    GenerateMOPDF(oidd);
                                });
                            }, 200);
                        }
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function materialorderitemdelete(mo_desc_id) {
        var flag = false;
        $.ajax({
            url: Morder.add_item.url,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'moentrydelete',
                attr: mo_desc_id
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
                        flag = data;
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        return flag;
    }
    ;

    function editmaterialorderitem(mo_desc_id, qty) {
        $(Morder.add_item.addnewitemss).hide();
        $(Morder.add_item.updatequantity).show();
        $(Morder.add_item.upmmatorder_qty).val(qty);
        $(Morder.add_item.mo_descb).val(mo_desc_id);
        $('html, body').animate({
            scrollTop: Number($(Morder.add_item.upmmatorder_qty).offset().top) - 95
        }, 'slow');
    }
    ;

    function fetchOrderItems() {
        var htm = '';
        $(Morder.order.TVSOtype).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: Morder.order.url,
            data: {
                autoloader: true,
                action: 'fetchorderItems'
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
                        var itmelist = $.parseJSON(data);
                        if (itmelist != null) {
                            for (i = 0; i < itmelist.length; i++) {
                                htm += itmelist[i]["html"];
                            }
                            $(Morder.order.TVSOtype).html('<select class="form-control" id="' + Morder.order.item_id + '"><option value="NULL" selected>Select item</option>' + htm + '</select><p class="help-block" id="' + Morder.order.it_msg + '">Enter / Select</p>');
                            window.setTimeout(function () {
                                $('#' + Morder.order.item_id).change(function () {
                                    var id = $(this).select().val();
                                    if (id != 'NULL') {
                                        Morder.order.iid = id;
                                        return true;
                                    } else
                                        Morder.order.iid = 'NULL';
                                });
                            }, 300);
                        }
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function fetchVendors() {
        var htm = '';
        $(Morder.order.TVVendortype).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: Morder.order.url,
            data: {
                autoloader: true,
                action: 'fetchVendor'
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
                        var vendorlist = $.parseJSON(data);
                        if (vendorlist != null) {
                            for (i = 0; i < vendorlist.length; i++) {
                                htm += vendorlist[i]["html"];
                            }
                            $(Morder.order.TVVendortype).html('<select class="form-control" id="' + Morder.order.ven_id + '"><option value="" selected>Select Vedor</option>' + htm + '</select><p class="help-block" id="' + Morder.order.ven_msg + '">Enter / Select</p>');
                            window.setTimeout(function () {
                                $('#' + Morder.order.ven_id).change(function () {
                                    var id = $(this).select().val();
                                    if (id != 'NULL')
                                        Morder.order.vid = id;
                                });
                            }, 300);
                        }
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function fetechmaterialordered() {
        $(Morder.msgDiv).html('');
        $(Morder.add_item.addnewitemss).show();
        $(Morder.add_item.updatequantity).hide();
        var htm = '';
        $(Morder.add_item.OVentype).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: Morder.add_item.url,
            data: {
                autoloader: true,
                action: 'fetchmaterialordered'
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
                        var itmelist = $.parseJSON(data);
                        if (itmelist != null) {
                            for (i = 0; i < itmelist.length; i++) {
                                htm += itmelist[i]["html"];
                            }
                            $(Morder.add_item.OVentype).html('<select class="form-control" id="' + Morder.add_item.ord_id + '"><option value="NULL" selected>Select item</option>' + htm + '</select><p class="help-block" id="' + Morder.add_item.ord_msg + '">Select a Ordered Vendor to generate Material order.</p>');
                            window.setTimeout(function () {
                                $('#' + Morder.add_item.ord_id).change(function () {
                                    var id = $(this).select().val();
                                    $('#' + Morder.add_item.ord_msg).html('');
                                    fetchvendorOrderedDeails(id);
                                    if (id != 'NULL') {
                                        Morder.add_item.oid = id;
                                        return true;
                                    } else {
                                        Morder.add_item.oid = 'NULL';
                                    }
                                });
                            }, 300);
                        }
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function mfetchOrderItems() {
        var htm = '';
        $(Morder.add_item.TVSOtype).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: Morder.add_item.url,
            data: {
                autoloader: true,
                action: 'fetchorderItems'
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
                        var itmelist = $.parseJSON(data);
                        if (itmelist != null) {
                            for (i = 0; i < itmelist.length; i++) {
                                htm += itmelist[i]["html"];
                            }
                            $(Morder.add_item.TVSOtype).html('<select class="form-control" id="' + Morder.add_item.item_id + '"><option value="NULL" selected>Select item</option>' + htm + '</select><p class="help-block" id="' + Morder.add_item.it_msg + '">Enter / Select</p>');
                            $(Morder.add_item.MOhideitem).show();
                            window.setTimeout(function () {
                                $('#' + Morder.add_item.item_id).change(function () {
                                    var id = $(this).select().val();

                                    if (id != 'NULL') {
                                        Morder.add_item.iid = id;
                                        return true;
                                    } else
                                        Morder.add_item.iid = 'NULL';
                                });
                            }, 300);
                        }
                        break;
                }
            },
            error: function () {
                $(Morder.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function addMaterialOrder() {
        var flag = false;
        if ($('#' + Morder.order.ven_id).val() != '') {
            flag = true;
            $('#' + Morder.order.ven_msg).html('');
        } else {
            flag = false;
            $('#' + Morder.order.ven_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#' + Morder.order.ven_msg).offset().top) - 95
            }, 'slow');
            $('#' + Morder.order.ven_id).focus();
            return;
        }
        if ($('#' + Morder.order.item_id).val() != 'NULL') {
            flag = true;
            $('#' + Morder.order.it_msg).html('');
        } else {
            flag = false;
            $('#' + Morder.order.it_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#' + Morder.order.it_msg).offset().top) - 95
            }, 'slow');
            $('#' + Morder.order.item_id).focus();
            return;
        }
        if ($(Morder.order.doo).val() != "") {
            flag = true;
            $(Morder.order.doo_msg).html('');
        } else {
            flag: true;
            $(Morder.order.doo_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(Morder.order.doo_msg).offset().top) - 95
            }, 'slow');
            $(Morder.order.doo).focus();
            return;
        }
        if ($(Morder.order.edod).val() != "") {
            flag = true;
            $(Morder.order.edod_msg).html('');
        } else {
            flag: true;
            $(Morder.order.edod_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(Morder.order.edod_msg).offset().top) - 95
            }, 'slow');
            $(Morder.order.edod).focus();
            return;
        }
        /* Quantity */
        if ($(Morder.order.qty).val().match(id_reg)) {
            flag = true;
            $(Morder.order.qtymsg).html('');
        } else {
            flag = false;
            $(Morder.order.qtymsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(Morder.order.qtymsg).offset().top) - 95
            }, 'slow');
            $(Morder.order.qty).focus();
            return;
        }
        var attr = {
            qty: $(Morder.order.qty).val(),
            iid: Number(Morder.order.iid),
            venid: Number(Morder.order.vid),
            doo: $(Morder.order.doo).val(),
            edod: $(Morder.order.edod).val()
        };
        if (flag) {
            $(Morder.order.but).prop('disabled', 'disabled');
            $(Morder.msgDiv).html('');
            $.ajax({
                url: Morder.order.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: Morder.order.action,
                    materialOrder: attr
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
                            $(Morder.msgDiv).html('<h2>Material Order has been Successfully added</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(Morder.msgDiv).offset().top) - 95
                            }, 'slow');
                            $(Morder.order.form).get(0).reset();
                            break;
                    }
                },
                error: function () {
                    $(Morder.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(Morder.order.but).removeAttr('disabled');
                }
            });
        } else {
            $(Morder.order.but).removeAttr('disabled');
        }
    }
    ;

    function additemtoexistingorder() {
        var flag = false;
        if ($('#' + Morder.add_item.ord_id).val() != 'NULL') {
            flag = true;
            $('#' + Morder.add_item.ord_msg).html('');
        } else {
            flag = false;
            $('#' + Morder.add_item.ord_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#' + Morder.add_item.ord_msg).offset().top) - 95
            }, 'slow');
            $('#' + Morder.add_item.ord_id).focus();
            return;
        }
        if ($('#' + Morder.add_item.item_id).val() != 'NULL') {
            flag = true;
            $('#' + Morder.add_item.it_msg).html('');
        } else {
            flag = false;
            $('#' + Morder.add_item.it_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#' + Morder.add_item.it_msg).offset().top) - 95
            }, 'slow');
            $('#' + Morder.add_item.item_id).focus();
            return;
        }
        if ($(Morder.add_item.doo).val() != "") {
            flag = true;
            $(Morder.add_item.doo_msg).html('');
        } else {
            flag: true;
            $(Morder.add_item.doo_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(Morder.add_item.doo_msg).offset().top) - 95
            }, 'slow');
            $(Morder.add_item.doo).focus();
            return;
        }
        if ($(Morder.add_item.edod).val() != "") {
            flag = true;
            $(Morder.add_item.edod_msg).html('');
        } else {
            flag: true;
            $(Morder.add_item.edod_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(Morder.add_item.edod_msg).offset().top) - 95
            }, 'slow');
            $(Morder.add_item.edod).focus();
            return;
        }
        /* Quantity */
        if ($(Morder.add_item.qty).val().match(id_reg)) {
            flag = true;
            $(Morder.add_item.qtymsg).html('');
        } else {
            flag = false;
            $(Morder.add_item.qtymsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(Morder.add_item.qtymsg).offset().top) - 95
            }, 'slow');
            $(Morder.add_item.qty).focus();
            return;
        }
        var attr = {
            qty: $(Morder.add_item.qty).val(),
            iid: Number(Morder.add_item.iid),
            oid: Number(Morder.add_item.oid),
            doo: $(Morder.add_item.doo).val(),
            edod: $(Morder.add_item.edod).val(),
            mo_descb_id: $(Morder.add_item.mo_descb).val()
        };
        if (flag) {
            $(Morder.msgDiv).html('');
            $(Morder.add_item.but).prop('disabled', 'disabled');
            //				console.log(attr);
            // $(Morder.add_item.but).unbind();
            $.ajax({
                url: Morder.add_item.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'additemtoexistingorder',
                    materialOrder: attr
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
                            // $(Morder.msgDiv).html('<h2>Item has been Successfully added to Existing Order</h2>');
                            fetchvendorOrderedDeails(attr.oid);
                            $(Morder.add_item.MOhideitem).show();
                            $('html, body').animate({
                                scrollTop: Number($('#' + Morder.add_item.ord_id).offset().top) - 95
                            }, 'slow');
                            break;
                    }
                },
                error: function () {
                    $(Morder.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    $(Morder.add_item.but).removeAttr('disabled');
                }
            });
        } else {
            $(Morder.add_item.but).removeAttr('disabled');
        }
    }
    ;
}