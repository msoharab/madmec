function stockController() {
    var stock = {};
    var itmelist = {};
    var orderlist = {};
    this.__construct = function (stockctrl) {
        stock = stockctrl;
        $(stock.add.menuBut).click(function () {
            $(stock.msgDiv).html('');
            $(stock.add.nmsg).html('');
            $(stock.add.citmsg).html('');
        })
        $(stock.add.but).click(function () {
            itemAdd();
            $(stock.msgDiv).html('');
        });
        $(stock.update.menuBut).click(function () {
            stock.update.iid = 'NULL';
            $(stock.msgDiv).html('');
            fetchItems();
        });
        $(stock.supply.menuBut).click(function () {
            stock.order.vid = stock.order.iid = stock.update.iid = 'NULL';
            $(stock.msgDiv).html('');
            fetchOrders();
        });
        $(stock.update.but).click(function () {
            updateStock();
        });
        $(stock.viewstock.menuBut).click(function () {
            fetchavailablestock();
        });
        initializeItemAddForm();
    };

    function initializeItemAddForm() {
        /* Item type / name */
        $(stock.add.name).change(function () {
            if ($(stock.add.name).val().match(name_reg)) {
                $(stock.add.nmsg).html(VALIDNOT);
                checkitemname = $(stock.add.name).val();
                $.ajax({
                    type: 'POST',
                    url: stock.add.url,
                    data: {
                        autoloader: true,
                        action: 'checkitem',
                        type: 'slave',
                        checkitemnamee: checkitemname
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
                                if (type != "NotExist") {
                                    $(stock.add.hiditemname).val("ALREADYEXIST");
                                    $(stock.add.nmsg).html(ALREADYEXIST);
                                } else {
                                    $(stock.add.hiditemname).val("");
                                    $(stock.add.nmsg).html(VALIDNOT);
                                }
                                break;
                        }
                    },
                    error: function () {
                        $(stock.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            } else {
                $(stock.add.nmsg).html(INVALIDNOT);
            }
        });
        /* Minimum criteria */
        $(stock.add.cirt).change(function () {
            if ($(stock.add.cirt).val().match(id_reg)) {
                $(stock.add.citmsg).html(VALIDNOT);
            } else {
                $(stock.add.citmsg).html(INVALIDNOT);
            }
        });
    }
    ;

    function fetchItems() {
        var htm = '';
        $(stock.update.TVUtype).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: stock.update.url,
            data: {
                autoloader: true,
                action: 'fetchItems'
            },
            success: function (data, textStatus, xhr) {
//                        console.log(data);
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
                        if (type != null) {
                            itmelist = type;
                            for (i = 0; i < type.length; i++) {
                                htm += type[i]["html"];
                            }
                            $(stock.update.TVUtype).html('<select class="form-control" id="' + stock.update.item_id + '"><option value="NULL" selected>Select item</option>' + htm + '</select><p class="help-block" id="' + stock.update.it_msg + '">Enter / Select</p>');
                            window.setTimeout(function () {
                                $('#' + stock.update.item_id).change(function () {
                                    var id = $(this).select().val();
                                    if (id != 'NULL') {
                                        stock.update.iid = id;
                                        return true;
                                    } else
                                        stock.update.iid = 'NULL';
                                });
                            }, 300);
                        }
                        break;
                }
            },
            error: function () {
                $(stock.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function fetchOrders() {
        var htm = '';
        $(stock.add.basicinfo.TVUtype).html('');
        $(stock.add.basicinfo.TVUtype).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: stock.add.url,
            data: {
                autoloader: true,
                action: 'fetchUserTypes'
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
                        if (type != null) {
                            usertypes = type;
                            for (i = 0; i < type.length; i++) {
                                htm += type[i]["html"];
                            }
                            $(stock.add.basicinfo.TVUtype).html('<select class="form-control" id="' + stock.add.basicinfo.user_type + '"><option value="NULL" selected>Select user type</option>' + htm + '</select><p class="help-block" id="' + stock.add.basicinfo.ut_msg + '">Enter / Select</p>');
                        }
                        break;
                }
            },
            error: function () {
                $(stock.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function fetchavailablestock() {
        var htm = '';
        $(stock.msgDiv).html('');
        $(stock.viewstock.vslist).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: stock.viewstock.url,
            data: {
                autoloader: true,
                action: 'fetchAvaliableStock'
            },
            success: function (data, textStatus, xhr) {
//                        console.log(data);
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
                        if (type != null) {
                            for (i = 0; i < type.length; i++) {
                                htm += type[i]["html"];
                            }
                            $(stock.viewstock.vslist).html('<table class="table table-striped table-bordered table-hover" id="avaliablestock-data"><thead><tr><th class="text-right">ID</th><th>Item Name</th><th>Minimum Criteria</th><th>Avalaible</th></tr></thead><tbody>' + htm + '</tbody></table>');
                            window.setTimeout(function () {
                                $('#avaliablestock-data').dataTable();
                            });
                        }
                        break;
                }
            },
            error: function () {
                $(stock.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function itemAdd() {
        var flag = false;
        /* Item type / name */
        if ($(stock.add.name).val().match(name_reg)) {
            flag = true;
            $(stock.add.nmsg).html('');
        } else {
            flag = false;
            $(stock.add.nmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(stock.add.nmsg).offset().top) - 95
            }, 'slow');
            $(stock.add.name).focus();
            return;
        }
        if ($(stock.add.hiditemname).val() == "") {
            flag = true;
            $(stock.add.nmsg).html('');
        } else {
            flag = false;
            $(stock.add.nmsg).html(ALREADYEXIST);
            $('html, body').animate({
                scrollTop: Number($(stock.add.nmsg).offset().top) - 95
            }, 'slow');
            $(stock.add.name).focus();
            return;
        }
        /* Minimum criteria */
        if ($(stock.add.cirt).val().match(id_reg)) {
            flag = true;
            $(stock.add.citmsg).html('');
        } else {
            flag = false;
            $(stock.add.citmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(stock.add.citmsg).offset().top) - 95
            }, 'slow');
            $(stock.add.cirt).focus();
        }
        var attr = {
            name: $(stock.add.name).val(),
            min: $(stock.add.cirt).val()
        };
        if (flag) {
            $(stock.add.but).prop('disabled', 'disabled');
            $(stock.msgDiv).html('');
            console.log(attr);
            $.ajax({
                url: stock.add.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: stock.add.action,
                    itmemadd: attr
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
                            $(stock.msgDiv).html('<h2>Item added to database</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(stock.msgDiv).offset().top) - 95
                            }, 'slow');
                            $(stock.add.form).get(0).reset();
                            break;
                    }
                },
                error: function () {
                    $(stock.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(stock.add.but).removeAttr('disabled');
                }
            });
        } else {
            $(stock.add.but).removeAttr('disabled');
        }
    }
    ;

    function updateStock() {
        var flag = false;
        /* Item Id */
        if (stock.update.iid != 'NULL') {
            flag = true;
            $('#' + stock.update.it_msg).html('');
        } else {
            flag = false;
            $('#' + stock.update.it_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#' + stock.update.it_msg).offset().top) - 95
            }, 'slow');
            $('#' + stock.update.iid).focus();
            return;
        }
        /* Quantity */
        if ($(stock.update.qty).val().match(id_reg)) {
            flag = true;
            $(stock.update.qtymsg).html('');
        } else {
            flag = false;
            $(stock.update.qtymsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(stock.update.qtymsg).offset().top) - 95
            }, 'slow');
            $(stock.update.qty).focus();
            return;
        }
        var attr = {
            qty: $(stock.update.qty).val(),
            iid: Number(stock.update.iid)
        };
        if (flag) {
            $(stock.update.but).prop('disabled', 'disabled');
            $(stock.msgDiv).html('');
            $.ajax({
                url: stock.update.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: stock.update.action,
                    stockupdate: attr
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
                            $(stock.msgDiv).html('<h2>Item added to available stock</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(stock.msgDiv).offset().top) - 95
                            }, 'slow');
                            $(stock.update.form).get(0).reset();
                            break;
                    }
                },
                error: function () {
                    $(stock.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(stock.update.but).removeAttr('disabled');
                }
            });
        } else {
            $(stock.update.but).removeAttr('disabled');
        }
    }
    ;

    function DisplayUpdatedStockList() {
        // listDiv		: '#accorlistuser',
        // listLoad	: '#lstloader',
        $(stock.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: window.location.href,
            type: 'post',
            data: {
                autoloader: true,
                action: 'DisplayUpdatedUserList'
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
                        $(stock.list.listDiv).append(data);
                        $(stock.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(stock.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function DisplayStockList() {
        $(stock.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: window.location.href,
            type: 'post',
            data: {
                autoloader: true,
                action: 'DisplayUserList'
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
                        $(stock.list.listDiv).html(data);
                        $(stock.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(stock.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        $(window).scroll(function (event) {
            if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
                DisplayUpdatedUserList();
            else
                $(stock.list.listLoad).html('');
        });
    }

    function DisplayUpdatedOrderList() {
        // listDiv		: '#accorlistuser',
        // listLoad	: '#lstloader',
        $(stock.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: window.location.href,
            type: 'post',
            data: {
                autoloader: true,
                action: 'DisplayUpdatedUserList'
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
                        $(stock.list.listDiv).append(data);
                        $(stock.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(stock.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function DisplayOrderList() {
        $(stock.list.listLoad).html(LOADER_ONE);
        $.ajax({
            url: window.location.href,
            type: 'post',
            data: {
                autoloader: true,
                action: 'DisplayUserList'
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
                        $(stock.list.listDiv).html(data);
                        $(stock.list.listLoad).html('');
                        break;
                }
            },
            error: function () {
                $(stock.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        $(window).scroll(function (event) {
            if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
                DisplayUpdatedUserList();
            else
                $(stock.list.listLoad).html('');
        });
    }
}