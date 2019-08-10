function userController() {
    var usr = {};
    var ipdata = {};
    var em = {};
    var cn = {};
    var ac = {};
    var pd = {};
    var usertypes = {};
    var listusers = {};
    var PCR_reg = '';
    var dccode = '91';
    var dpcode = '080';
    var keyupregex = new RegExp("^[a-zA-Z0-9]+$");
    /*Search variable decalerd*/
    var menuDiv = "";
    var htmlDiv = "";
    var outputDiv = "";
    var OptionsSearch = {};
    var SearchAllHide = {};
    var countries = {};
    var states = {};
    var districts = {};
    var cities = {};
    var localities = {};
    var addres = {};
    this.__construct = function (usrctrl) {
        usr = usrctrl.usr;
        cn = usrctrl.cn;
        em = usrctrl.em;
        ac = usrctrl.ac;
        pd = usrctrl.pd;
        /*Search*/
        menuDiv = usr.list.menuDiv;
        htmlDiv = usr.list.htmlDiv;
        outputDiv = usr.list.outputDiv;
        OptionsSearch = usr.list.OptionsSearch;
        SearchAllHide = usr.list.SearchAllHide;
        if (usr.list) {
            $(usr.list.menuBut).click(function () {
                DisplayUserList();
            });
        }
        if (usr.add.action == 'addUser') {
            $(usr.add.menuBut).click(function () {
                clearuserAddForm();
            });
            $(usr.add.but).click(function () {
                userAdd();
            });
            fetchUserTypes();
        } else if (usr.add.action == 'editUser') {
        } else {
        }
        initializeUserAddForm();
        addres = new Address();
        addres.__construct({url: usr.add.address.url, outputDiv: usr.outputDiv});
        addres.getIPData();
        countries = addres.getCountry();
        bindAddressFields(usr.add.address);
    };
    this.close = function (clid) {
        var cl = clid;
        $(cl.closeDiv).click(function () {
            $(cl.listtab).click();
        });
    };
    this.editUserBasicInfo = function (binfo) {
        var basicinfo = binfo;
        $(basicinfo.name).change(function () {
            if ($(basicinfo.name).val().match(name_reg)) {
                flag = true;
                $(basicinfo.nmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(basicinfo.nmsg).html(INVALIDNOT);
            }
        });
        fetchUserTypes();
        $(basicinfo.but).click(function (evt) {
            evt.preventDefault();
            editBasicInfo();
        });
        function fetchUserTypes() {
            var htm = '';
            $(basicinfo.TVUtype).html('');
            $.ajax({
                type: 'POST',
                url: basicinfo.url,
                data: {
                    autoloader: true,
                    action: 'fetchUserTypes'
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
                            var type = $.parseJSON(data);
                            usertypes = type;
                            for (i = 0; i < type.length; i++) {
                                htm += type[i]["html"];
                            }
                            $(basicinfo.TVUtype).html('<select class="form-control" id="' + basicinfo.user_type + '"><option value="NULL" selected>Select user type</option>' + htm + '</select><p class="help-block" id="' + basicinfo.ut_msg + '">Enter/ Select.</p>');
                            break;
                    }
                },
                error: function () {
                    $(basicinfo.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        function editBasicInfo() {
            var flag = false;
            var type = $('#' + basicinfo.user_type).val();
            /* ACS ID */
            if ($(basicinfo.acs_id).val().length < 21) {
                flag = true;
                $(basicinfo.ac_msg).html(VALIDNOT);
            } else {
                flag = false;
                $(basicinfo.ac_msg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(basicinfo.ac_msg).offset().top) - 95
                }, "slow");
                $(basicinfo.acs_id).focus();
                return;
            }
            if (type != 'NULL' && type != '') {
                flag = true;
            } else {
                flag = false;
                $('#' + basicinfo.ut_msg).html('<strong class="text-danger">Select user type.</strong>');
                $('html, body').animate({
                    scrollTop: Number($('#' + basicinfo.ut_msg).offset().top) - 95
                }, "slow");
                return;
            }
            /* User name */
            if ($(basicinfo.name).val().match(name_reg)) {
                flag = true;
                $(basicinfo.nmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(basicinfo.nmsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(basicinfo.nmsg).offset().top) - 95
                }, "slow");
                $(basicinfo.name).focus();
                return;
            }
            /* Outstanding balance */
            if ($(basicinfo.otamt).val().match(deci_reg)) {
                flag = true;
                $(basicinfo.otamtmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(basicinfo.otamtmsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(basicinfo.otamtmsg).offset().top) - 95
                }, "slow");
                $(basicinfo.otamt).focus();
                return;
            }
            /* Postal Code */
            if ($(basicinfo.pcode).val().length > 0) {
                if ($(basicinfo.pcode).val().match(ccod_reg)) {
                    flag = true;
                    $(basicinfo.tpmsg).html(VALIDNOT);
                } else {
                    flag = false;
                    $(basicinfo.tpmsg).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(basicinfo.tpmsg).offset().top) - 95
                    }, "slow");
                    $(basicinfo.pcode).focus();
                    return;
                }
            }
            /* Telephone Number */
            if ($(basicinfo.tphone).val().length > 0) {
                if ($(basicinfo.tphone).val().match(tele_reg)) {
                    flag = true;
                    $(basicinfo.tpmsg).html(VALIDNOT);
                } else {
                    flag = false;
                    $(basicinfo.tpmsg).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(basicinfo.tpmsg).offset().top) - 95
                    }, "slow");
                    $(basicinfo.tele_reg).focus();
                    return;
                }
            }
            if (flag) {
                var attr = {
                    uid: basicinfo.uid,
                    index: basicinfo.index,
                    listindex: basicinfo.listindex,
                    user_type: type,
                    name: $(basicinfo.name).val(),
                    otamt: $(basicinfo.otamt).val(),
                    acs_id: $(basicinfo.acs_id).val(),
                    tphone: $(basicinfo.tphone).val(),
                    pcode: $(basicinfo.pcode).val()
                };
                $.ajax({
                    url: basicinfo.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editBasicInfo',
                        binfo: attr
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                $(basicinfo.reloadBut).trigger('click');
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(basicinfo.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
    };
    this.alterClientEmailIds = function (email) {
        var em = email;
        $(em.addd).bind("click", function () {
            em.num = 0;
            $(em.parentDiv).html('<div class="col-lg-12">' +
                    '<div class="col-lg-4">Add extra Email ids : </div><div class="col-lg-8 text-right"><button type="button" class="btn btn-success btn-circle" id="' + em.plus + '"><i class="fa fa-plus fa-fw "></i></button>' +
                    '&nbsp;<button  type="button" class="btn btn-success btn-circle" id="' + em.minus + '"><i class="fa fa-minus fa-fw "></i></button>' +
                    '&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' + em.closeBut + '"><i class="fa fa-close fa-fw "></i></button>' +
                    '</div>');
            $('#' + em.plus).click(function () {
                addMultipleEmailIds();
                return false;
            });
            $('#' + em.minus).bind('click', function () {
                if (em.num >= 0) {
                    minusMultipleEmailIds();
                    return false;
                }
            });
            $('#' + em.saveBut).unbind();
            $('#' + em.saveBut).click(function () {
                adddClientEmailId();
            });
            $('#' + em.closeBut).click(function () {
                listEmailIds();
            });
            $('#' + em.saveBut).show();
            $(em.addd).hide();
            $(em.edit).hide();
            $(em.delt).hide();
        });
        $(em.edit).bind("click", function () {
            $('#' + em.saveBut).hide();
            $(em.addd).hide();
            $(em.edit).hide();
            $(em.delt).hide();
            loadClientEmailIdEditForm();
        });
        $(em.delt).bind("click", function () {
            $('#' + em.saveBut).hide();
            $(em.addd).hide();
            $(em.edit).hide();
            $(em.delt).hide();
            loadClientEmailIdDeltForm();
        });
        function addMultipleEmailIds() {
            var oldemail = {
                formid: em.form + em.num,
                textid: em.email + em.num,
                msgid: em.msgDiv + em.num,
                num: em.num
            };
            em.num++;
            var html = '<div class="col-lg-12"><div class="form-group" id="' + oldemail.formid + '">' + '<input class="form-control" required placeholder="Email ID" name="email" type="text" id="' + oldemail.textid + '" maxlength="100"/>' + '<p class="help-block" id="' + oldemail.msgid + '">Enter/ Select.</p>' + '</div></div>';
            $(em.parentDiv).append(html);
        }
        ;
        function minusMultipleEmailIds() {
            var oldemail = {
                formid: em.form + em.num,
                textid: em.email + em.num,
                msgid: em.msgDiv + em.num,
                num: em.num
            };
            $(document.getElementById(oldemail.textid)).remove();
            $(document.getElementById(oldemail.msgid)).remove();
            $(document.getElementById(oldemail.formid)).remove();
            em.num--;
            if (em.num == -1)
                em.num = 0;
        }
        ;
        function loadClientEmailIdEditForm() {
            $(em.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientEmailIdEditForm',
                    det: em
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data.html);
                            em.num = data.num;
                            $('#' + em.saveBut).show();
                            $(document).ready(function () {
                                $('#' + em.saveBut).unbind();
                                $('#' + em.saveBut).click(function () {
                                    editClientEmailId();
                                });
                                $('#' + em.closeBut).click(function () {
                                    $(em.edit).toggle();
                                    $('#' + em.saveBut).toggle();
                                    listEmailIds();
                                });
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function loadClientEmailIdDeltForm() {
            $(em.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientEmailIdDeltForm',
                    det: em
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data.html);
                            em.num = data.num;
                            $(document).ready(function () {
                                $('#' + em.closeBut).click(function () {
                                    $(em.edit).toggle();
                                    $('#' + em.saveBut).toggle();
                                    listEmailIds();
                                });
                                window.setTimeout(function () {
                                    if (data.oldemail) {
                                        for (i = 0; i < data.oldemail.length; i++) {
                                            var cid = Number(data.oldemail[i].id);
                                            $('#' + data.oldemail[i].deleteOk).bind("click", {
                                                param1: cid
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteEmailId(event.data.param1)) {
                                                    loadClientEmailIdDeltForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function adddClientEmailId() {
            var insert = [];
            var emailids = {
                insert: insert,
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            // min
            /* Email ids */
            if (em.num > -1) {
                k = 0;
                for (i = 0; i < em.num; i++) {
                    var ems = $(document.getElementById(em.email + i)).val();
                    if (ems.match(email_reg)) {
                        flag = true;
                        insert[k] = ems;
                        k++;
                    } else {
                        flag = false;
                        $(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(em.email + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                $(em.parentDiv).html(LOADER_TWO);
                emailids.insert = insert;
                $('#' + em.saveBut).unbind();
                $('#' + em.saveBut).toggle();
                $.ajax({
                    url: em.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'adddClientEmailId',
                        emailids: emailids
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                listEmailIds();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(em.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function editClientEmailId() {
            var update = [];
            var emailids = {
                update: update,
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            // min
            /* Email ids */
            if (em.num > -1) {
                j = 0;
                for (i = 0; i < em.num; i++) {
                    var ems = $(document.getElementById(em.email + i)).val();
                    var id = $(document.getElementById(em.email + i)).prop('name');
                    if (ems.match(email_reg)) {
                        flag = true;
                        $(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
                        update[j] = {
                            email: ems,
                            id: id
                        };
                        j++;
                    } else {
                        flag = false;
                        $(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(em.email + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                $(em.parentDiv).html(LOADER_TWO);
                emailids.update = update;
                $('#' + em.saveBut).unbind();
                $('#' + em.saveBut).toggle();
                $.ajax({
                    url: em.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editClientEmailId',
                        emailids: emailids
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                listEmailIds();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(em.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteEmailId(id) {
            var flag = false;
            console.log(id);
            $.ajax({
                url: em.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteClientEmailId',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listEmailIds() {
            $('#' + em.saveBut).hide();
            $(em.parentDiv).html(LOADER_TWO);
            var para = {
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listClientEmailIds',
                    para: para
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
                            $(em.parentDiv).html(data);
                            $(em.addd).show();
                            $(em.edit).show();
                            $(em.delt).show();
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    this.alterClientCellNumbers = function (cnumber) {
        var cn = cnumber;
        $(cn.addd).bind("click", function () {
            cn.num = 0;
            $(cn.parentDiv).html('<div class="col-lg-12">' +
                    '<div class="col-lg-4">Add extra Cell NO : </div><div class="col-lg-8 text-right"><button type="button" class="btn btn-success btn-circle" id="' + cn.plus + '"><i class="fa fa-plus fa-fw "></i></button>' +
                    '&nbsp;<button  type="button" class="btn btn-success btn-circle" id="' + cn.minus + '"><i class="fa fa-minus fa-fw "></i></button>' +
                    '&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' + cn.closeBut + '"><i class="fa fa-close fa-fw "></i></button></div>' +
                    '</div>');
            $('#' + cn.plus).click(function () {
                addMultipleCellNums();
                return false;
            });
            $('#' + cn.minus).bind('click', function () {
                if (cn.num >= 0) {
                    minusMultipleCellNums();
                    return false;
                }
            });
            $('#' + cn.saveBut).unbind();
            $('#' + cn.saveBut).click(function () {
                adddClientCellNum();
            });
            $('#' + cn.closeBut).click(function () {
                listClientCellNums();
            });
            $('#' + cn.saveBut).show();
            $(cn.addd).hide();
            $(cn.edit).hide();
            $(cn.delt).hide();
        });
        $(cn.edit).bind("click", function () {
            $('#' + cn.saveBut).hide();
            $(cn.addd).hide();
            $(cn.edit).hide();
            $(cn.delt).hide();
            loadClientCellNumEditForm();
        });
        $(cn.delt).bind("click", function () {
            $('#' + cn.saveBut).hide();
            $(cn.addd).hide();
            $(cn.edit).hide();
            $(cn.delt).hide();
            loadClientCellNumDeltForm();
        });
        function loadClientCellNumEditForm() {
            $(cn.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientCellNumEditForm',
                    det: cn
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(cn.parentDiv).html(data.html);
                            cn.num = data.num;
                            $('#' + cn.saveBut).show();
                            $(document).ready(function () {
                                $('#' + cn.plus).click(function () {
                                    addMultipleCellNums();
                                });
                                $('#' + cn.minus).bind('click', function () {
                                    minusMultipleCellNums();
                                    return false;
                                });
                                $('#' + cn.saveBut).click(function () {
                                    editClientCellNum();
                                });
                                $('#' + cn.closeBut).click(function () {
                                    $(cn.but).toggle();
                                    $('#' + cn.saveBut).toggle();
                                    listClientCellNums();
                                });
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function loadClientCellNumDeltForm() {
            $(cn.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientCellNumDeltForm',
                    det: cn
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(cn.parentDiv).html(data.html);
                            cn.num = data.num;
                            $('#' + cn.saveBut).show();
                            $(document).ready(function () {
                                $('#' + cn.closeBut).click(function () {
                                    $(cn.but).toggle();
                                    $('#' + cn.saveBut).toggle();
                                    listClientCellNums();
                                });
                                window.setTimeout(function () {
                                    if (data.oldcnum) {
                                        for (i = 0; i < data.oldcnum.length; i++) {
                                            var id = Number(data.oldcnum[i].id);
                                            $('#' + data.oldcnum[i].deleteOk).bind("click", {
                                                param1: id
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteClientCellNum(event.data.param1)) {
                                                    loadClientCellNumDeltForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function addMultipleCellNums() {
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                num: cn.num
            };
            cn.num++;
            var html = '<div class="col-lg-12"><div class="form-group" id="' + oldcnum.formid + '">' + '<input class="form-control" placeholder="Cell number" name="cnumber" type="text" id="' + oldcnum.textid + '" maxlength="10"/>' + '<p class="help-block" id="' + oldcnum.msgid + '">Enter/ Select.</p>' + '</div></div>';
            $(cn.parentDiv).append(html);
        }
        ;
        function minusMultipleCellNums() {
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                num: cn.num
            };
            $(document.getElementById(cn.form + cn.num)).remove();
            $(document.getElementById(cn.cnumber + cn.num)).remove();
            $(document.getElementById(cn.msgDiv + cn.num)).remove();
            cn.num--;
            if (cn.num == -1)
                cn.num = 0;
        }
        ;
        function adddClientCellNum() {
            var insert = [];
            var CellNums = {
                insert: insert,
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            /* Cell numbers */
            if (cn.num > -1) {
                k = 0;
                for (i = 0; i < cn.num; i++) {
                    var ems = $(document.getElementById(cn.cnumber + i)).val();
                    var id = $(document.getElementById(cn.cnumber + i)).prop('name');
                    if (ems.match(cell_reg)) {
                        flag = true;
                        $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                        insert[k] = ems;
                        k++;
                    } else {
                        flag = false;
                        $(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(cn.cnumber + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                $(cn.parentDiv).html(LOADER_TWO);
                CellNums.insert = insert;
                $('#' + cn.saveBut).unbind();
                $.ajax({
                    url: cn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'adddClientCellNum',
                        CellNums: CellNums
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                listClientCellNums();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(cn.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function editClientCellNum() {
            var update = [];
            var CellNums = {
                update: update,
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            // min
            /* Cell numbers */
            if (cn.num > -1) {
                j = 0;
                for (i = 0; i < cn.num; i++) {
                    var ems = $(document.getElementById(cn.cnumber + i)).val();
                    var id = $(document.getElementById(cn.cnumber + i)).prop('name');
                    if (ems.match(cell_reg)) {
                        flag = true;
                        $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                        update[j] = {
                            cnumber: ems,
                            id: id
                        };
                        j++
                    } else {
                        flag = false;
                        $(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(cn.cnumber + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                $(cn.parentDiv).html(LOADER_TWO);
                CellNums.update = update;
                $('#' + cn.saveBut).unbind();
                $.ajax({
                    url: cn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editClientCellNum',
                        CellNums: CellNums
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                listClientCellNums();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(cn.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteClientCellNum(id) {
            var flag = false;
            $.ajax({
                url: cn.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteClientCellNum',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listClientCellNums() {
            $('#' + cn.saveBut).hide();
            var para = {
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listClientCellNums',
                    para: para
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
                            $(cn.addd).show();
                            $(cn.edit).show();
                            $(cn.delt).show();
                            $(cn.parentDiv).html(data);
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    this.alterClientProducts = function (prdname) {
        var pd = prdname;
        var min = pd.num;
        $(pd.but).click(function () {
            pd.num = min;
            loadPrdNameForm();
        });
        $(pd.addd).bind("click", function () {
            pd.num = 0;
            $(pd.parentDiv).html('<div class="col-lg-12">' +
                    '<div class="col-lg-4">Add extra Product : </div><div class="col-lg-8 text-right"><button type="button" class="btn btn-success btn-circle" id="' + pd.plus + '"><i class="fa fa-plus fa-fw "></i></button>' +
                    '&nbsp;<button  type="button" class="btn btn-success btn-circle" id="' + pd.minus + '"><i class="fa fa-minus fa-fw "></i></button>' +
                    '&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' + pd.closeBut + '"><i class="fa fa-close fa-fw "></i></button>' +
                    '</div>');
            $('#' + pd.plus).click(function () {
                addMultiplePrdNames();
                return false;
            });
            $('#' + pd.minus).bind('click', function () {
                if (pd.num >= 0) {
                    minusMultiplePrdNames();
                    return false;
                }
            });
            $('#' + pd.saveBut).unbind();
            $('#' + pd.saveBut).click(function () {
                adddClientProducts();
            });
            $('#' + pd.closeBut).click(function () {
                listProducts();
            });
            $('#' + pd.saveBut).show();
            $(pd.addd).hide();
            $(pd.edit).hide();
            $(pd.delt).hide();
        });
        $(pd.edit).bind("click", function () {
            $('#' + pd.saveBut).hide();
            $(pd.addd).hide();
            $(pd.edit).hide();
            $(pd.delt).hide();
            loadClientProductEditForm();
        });
        $(pd.delt).bind("click", function () {
            $('#' + pd.saveBut).hide();
            $(pd.addd).hide();
            $(pd.edit).hide();
            $(pd.delt).hide();
            loadClientProductDeltForm();
        });
        function addMultiplePrdNames() {
            var oldemail = {
                formid: pd.form + pd.num,
                textid: pd.prdname + pd.num,
                msgid: pd.msgDiv + pd.num,
                num: pd.num
            };
            pd.num++;
            var html = '<div class="col-lg-12"><div class="form-group" id="' + oldemail.formid + '">' + '<input class="form-control" required placeholder="Product" name="Product" type="text" id="' + oldemail.textid + '" maxlength="100"/>' + '<p class="help-block" id="' + oldemail.msgid + '">Enter/ Select.</p>' + '</div></div>';
            $(pd.parentDiv).append(html);
        }
        ;
        function minusMultiplePrdNames() {
            var oldemail = {
                formid: pd.form + pd.num,
                textid: pd.prdname + pd.num,
                msgid: pd.msgDiv + pd.num,
                num: pd.num
            };
            $(document.getElementById(oldemail.textid)).remove();
            $(document.getElementById(oldemail.msgid)).remove();
            $(document.getElementById(oldemail.formid)).remove();
            pd.num--;
            if (pd.num == -1)
                pd.num = 0;
        }
        ;
        function loadClientProductEditForm() {
            $(pd.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: pd.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientProductEditForm',
                    det: pd
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(pd.parentDiv).html(data.html);
                            pd.num = data.num;
                            $('#' + pd.saveBut).show();
                            $(document).ready(function () {
                                $('#' + pd.saveBut).unbind();
                                $('#' + pd.saveBut).click(function () {
                                    editClientProduct();
                                });
                                $('#' + pd.closeBut).click(function () {
                                    $(pd.edit).toggle();
                                    $('#' + pd.saveBut).toggle();
                                    listProducts();
                                });
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(pd.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function loadClientProductDeltForm() {
            $(pd.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: pd.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientProductDeltForm',
                    det: pd
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(pd.parentDiv).html(data.html);
                            pd.num = data.num;
                            $(document).ready(function () {
                                $('#' + pd.closeBut).click(function () {
                                    $(pd.edit).toggle();
                                    $('#' + pd.saveBut).toggle();
                                    listProducts();
                                });
                                window.setTimeout(function () {
                                    if (data.oldemail) {
                                        for (i = 0; i < data.oldemail.length; i++) {
                                            var cid = Number(data.oldemail[i].id);
                                            $('#' + data.oldemail[i].deleteOk).bind("click", {
                                                param1: cid
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteProduct(event.data.param1)) {
                                                    loadClientProductDeltForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(pd.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function adddClientProducts() {
            var insert = [];
            var emailids = {
                insert: insert,
                uid: pd.uid,
                index: pd.index,
                listindex: pd.listindex
            };
            var flag = false;
            // min
            /* Email ids */
            if (pd.num > -1) {
                k = 0;
                for (i = 0; i < pd.num; i++) {
                    var ems = $(document.getElementById(pd.prdname + i)).val();
                    if (ems.match(name_reg)) {
                        flag = true;
                        insert[k] = ems;
                        k++;
                    } else {
                        flag = false;
                        $(document.getElementById(pd.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(pd.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(pd.prdname + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                $(pd.parentDiv).html(LOADER_TWO);
                emailids.insert = insert;
                $('#' + pd.saveBut).unbind();
                $('#' + pd.saveBut).toggle();
                $.ajax({
                    url: pd.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'adddClientProduct',
                        emailids: emailids
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                listProducts();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(pd.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function editClientProduct() {
            console.log(pd);
            var update = [];
            var emailids = {
                update: update,
                uid: pd.uid,
                index: pd.index,
                listindex: pd.listindex
            };
            var flag = false;
            // min
            /* Email ids */
            if (pd.num > -1) {
                j = 0;
                for (i = 0; i < pd.num; i++) {
                    var ems = $(document.getElementById(pd.prdname + i)).val();
                    var id = $(document.getElementById(pd.prdname + i)).prop('name');
                    if (ems.match(name_reg)) {
                        flag = true;
                        $(document.getElementById(pd.msgDiv + i)).html(VALIDNOT);
                        update[j] = {
                            email: ems,
                            id: id
                        };
                        j++;
                    } else {
                        flag = false;
                        $(document.getElementById(pd.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(pd.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(pd.prdname + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                $(pd.parentDiv).html(LOADER_TWO);
                emailids.update = update;
                $('#' + pd.saveBut).unbind();
                $('#' + pd.saveBut).toggle();
                $.ajax({
                    url: pd.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editClientProduct',
                        emailids: emailids
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                listProducts();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(pd.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteProduct(id) {
            var flag = false;
            console.log(id);
            $.ajax({
                url: pd.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteClientProduct',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(pd.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listProducts() {
            $('#' + pd.saveBut).hide();
            $(pd.parentDiv).html(LOADER_TWO);
            var para = {
                uid: pd.uid,
                index: pd.index,
                listindex: pd.listindex
            };
            var flag = false;
            $.ajax({
                url: pd.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listClientProducts',
                    para: para
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
                            $(pd.parentDiv).html(data);
                            $(pd.addd).show();
                            $(pd.edit).show();
                            $(pd.delt).show();
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(pd.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    this.editUserBankAccounts = function (acc) {
        var ac = acc;
        var min = Number(ac.num);
        ac.num = Number(ac.num);
        $(ac.but).click(function () {
            ac.num = min;
            loadBankAcForm();
        });
        function loadBankAcForm() {
            ac.num = min;
            $(ac.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: ac.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadBankAcForm',
                    det: ac
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(ac.parentDiv).html(data.html);
                            $(document).ready(function () {
                                $('#' + ac.plus).click(function () {
                                    addMultipleBankAcs();
                                });
                                $('#' + ac.saveBut).click(function () {
                                    editBankAc();
                                });
                                $('#' + ac.closeBut).click(function () {
                                    listBankAcs();
                                });
                                window.setTimeout(function () {
                                    if (data.oldbank) {
                                        for (i = 0; i < data.oldbank.length; i++) {
                                            var id = Number(data.oldbank[i].id);
                                            $('#' + data.oldbank[i].deleteOk).click({
                                                param1: id
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteBankAc(event.data.param1)) {
                                                    loadBankAcForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(ac.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function addMultipleBankAcs() {
            ac.num++;
            for (i = min; i < ac.num; i++) {
                $(document.getElementById(ac.minus + i + '_delete')).hide();
            }
            var oldbank = {
                form: ac.form + ac.num,
                bankname: ac.bankname + ac.num,
                nmsg: ac.nmsg + ac.num,
                accno: ac.accno + ac.num,
                nomsg: ac.nomsg + ac.num,
                braname: ac.braname + ac.num,
                bnmsg: ac.bnmsg + ac.num,
                bracode: ac.bracode + ac.num,
                bcmsg: ac.bcmsg + ac.num,
                IFSC: ac.IFSC + ac.num,
                IFSCmsg: ac.IFSCmsg + ac.num,
                deleteid: ac.minus + ac.num + '_delete'
            };
            var html = '<div id="' + oldbank.form + '">' +
                    '<div class="col-lg-12">' +
                    '<div class="panel panel-warning">' +
                    '<div class="panel-heading">' +
                    '<strong>Bank account ' + (ac.num + 1) + '</strong>' +
                    '&nbsp;<button class="btn btn-danger btn-circle" id="' + oldbank.deleteid + '"><i class="fa fa-trash fa-fw"></i></button>' +
                    '</div>' +
                    '<div class="panel-body">' +
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<input class="form-control" placeholder="Bank Name" name="bankname" type="text" id="' + oldbank.bankname + '" maxlength="100"/>' +
                    '<p class="help-block" id="' + oldbank.nmsg + '">Valid.</p>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<input class="form-control" placeholder="Account Number" name="accno" type="text" id="' + oldbank.accno + '" maxlength="100"/>' +
                    '<p class="help-block" id="' + oldbank.nomsg + '">Valid.</p>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<input class="form-control" placeholder="Branch Name" name="braname" type="text" id="' + oldbank.braname + '" maxlength="100" />' +
                    '<p class="help-block" id="' + oldbank.bnmsg + '">Valid.</p>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<input class="form-control" placeholder="Branch Code" name="bracode" type="text" id="' + oldbank.bracode + '" maxlength="100"/>' +
                    '<p class="help-block" id="' + oldbank.bcmsg + '">Valid.</p>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<input class="form-control" placeholder="IFSC" name="IFSC" type="text" id="' + oldbank.IFSC + '" maxlength="100"/>' +
                    '<p class="help-block" id="' + oldbank.IFSCmsg + '">Valid.</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            $(ac.parentDiv).append(html);
            window.setTimeout(function () {
                $(document.getElementById(oldbank.deleteid)).click(function () {
                    $(document.getElementById(ac.form + ac.num)).remove();
                    if (ac.num >= min)
                        ac.num--;
                    $(document.getElementById(ac.minus + ac.num + '_delete')).show();
                });
            }, 200);
        }
        ;
        function editBankAc() {
            var insert = [];
            var update = [];
            var BankAcs = {
                insert: insert,
                update: update,
                uid: ac.uid,
                index: ac.index,
                listindex: ac.listindex
            };
            var flag = false;
            /* Bank Account */
            if (ac.num > -1) {
                j = 0;
                k = 0;
                for (i = 0; i <= ac.num; i++) {
                    var bankname = $(document.getElementById(ac.bankname + i)).val();
                    var accno = $(document.getElementById(ac.accno + i)).val();
                    var braname = $(document.getElementById(ac.braname + i)).val();
                    var bracode = $(document.getElementById(ac.bracode + i)).val();
                    var IFSC = $(document.getElementById(ac.IFSC + i)).val();
                    var id = $(document.getElementById(ac.bankname + i)).prop('name');
                    if ($(document.getElementById(ac.bankname + i)).val().match(name_reg)) {
                        flag = true;
                        $(document.getElementById(ac.nmsg + i)).html(VALIDNOT);
                    } else {
                        flag = false;
                        $(document.getElementById(ac.nmsg + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(ac.nmsg + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(ac.bankname + i)).focus();
                        return;
                    }
                    if ($(document.getElementById(ac.accno + i)).val().match(accn_reg)) {
                        flag = true;
                        $(document.getElementById(ac.nomsg + i)).html(VALIDNOT);
                    } else {
                        flag = false;
                        $(document.getElementById(ac.nomsg + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(ac.nomsg + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(ac.accno + i)).focus();
                        return;
                    }
                    if ($(document.getElementById(ac.braname + i)).val().length < 101) {
                        flag = true;
                        $(document.getElementById(ac.bnmsg + i)).html(VALIDNOT);
                    } else {
                        flag = false;
                        $(document.getElementById(ac.bnmsg + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(ac.bnmsg + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(ac.braname + i)).focus();
                        return;
                    }
                    if ($(document.getElementById(ac.bracode + i)).val().length < 101) {
                        flag = true;
                        $(document.getElementById(ac.bcmsg + i)).html(VALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
                        }, "slow");
                    } else {
                        flag = false;
                        $(document.getElementById(ac.bcmsg + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(ac.bracode + i)).focus();
                        return;
                    }
                    if ($(document.getElementById(ac.IFSC + i)).val().length < 101) {
                        flag = true;
                        $(document.getElementById(ac.IFSCmsg + i)).html(VALIDNOT);
                    } else {
                        flag = false;
                        $(document.getElementById(ac.IFSCmsg + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(ac.IFSCmsg + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(ac.IFSC + i)).focus();
                        return;
                    }
                    if (flag) {
                        if (id != 'bankname') {
                            update[j] = {
                                bankname: bankname,
                                accno: accno,
                                braname: braname,
                                bracode: bracode,
                                IFSC: IFSC,
                                id: id
                            };
                            j++;
                        } else if (id == 'bankname') {
                            insert[k] = {
                                bankname: bankname,
                                accno: accno,
                                braname: braname,
                                bracode: bracode,
                                IFSC: IFSC
                            };
                            k++;
                        }
                    }
                }
            }
            if (flag) {
                BankAcs.insert = insert;
                BankAcs.update = update;
                $.ajax({
                    url: ac.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editBankAc',
                        BankAcs: BankAcs
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                loadBankAcForm();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(ac.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteBankAc(id) {
            var flag = false;
            $.ajax({
                url: ac.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteBankAc',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(ac.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listBankAcs() {
            var flag = false;
            var para = {
                uid: ac.uid,
                index: ac.index,
                listindex: ac.listindex
            };
            var flag = false;
            $.ajax({
                url: ac.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listBankAcs',
                    para: para
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
                            $(ac.parentDiv).html(data);
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(ac.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        $(ac.but).trigger('click');
    };
    this.editUserAddress = function (addr) {
        var address = addr;
        addres = new Address();
        addres.__construct({url: address.url, outputDiv: address.outputDiv});
        addres.getIPData();
        countries = addres.getCountry();
        bindAddressFields(address);
        $(address.but).show();
        $(address.showDiv).hide();
        $(address.updateDiv).show();
        $(address.saveBut).click(function () {
            $(address.but).hide();
            editAddress();
        });
        $(address.closeBut).click(function () {
            listAddress();
        });
        function editAddress() {
            /* Address */
            var flag = false;
            /* Country */
            if ($(address.country).val().match(st_city_dist_cont_reg)) {
                flag = true;
                $(address.comsg).html(VALIDNOT);
            } else {
                flag = false;
                $(address.comsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(address.comsg).offset().top) - 95
                }, "slow");
                $(address.country).focus();
                return;
            }
            /* Province */
            if ($(address.province).val().match(prov_reg)) {
                flag = true;
                $(address.prmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(address.prmsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(address.prmsg).offset().top) - 95
                }, "slow");
                $(address.province).focus();
                return;
            }
            /* District */
            if ($(address.district).val().match(st_city_dist_cont_reg)) {
                flag = true;
                $(address.dimsg).html(VALIDNOT);
            } else {
                flag = false;
                $(address.dimsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(address.dimsg).offset().top) - 95
                }, "slow");
                $(address.district).focus();
                return;
            }
            /* City */
            if ($(address.city_town).val().match(st_city_dist_cont_reg)) {
                flag = true;
                $(address.citmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(address.citmsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(address.citmsg).offset().top) - 95
                }, "slow");
                $(address.city_town).focus();
                return;
            }
            /* Street / Locality */
            if ($(address.st_loc).val().match(st_city_dist_cont_reg)) {
                flag = true;
                $(address.stlmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(address.stlmsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(address.stlmsg).offset().top) - 95
                }, "slow");
                $(address.st_loc).focus();
                return;
            }
            /* Address Line */
            if ($(address.addrs).val().match(addline_reg)) {
                flag = true;
                $(address.admsg).html(VALIDNOT);
            } else {
                flag = false;
                $(address.admsg).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(address.admsg).offset().top) - 95
                }, "slow");
                $(address.addrs).focus();
                return;
            }
            var attr = {
                uid: address.uid,
                index: address.index,
                listindex: address.listindex,
                country: $(address.country).val(),
                countryCode: address.countryCode,
                province: $(address.province).val(),
                provinceCode: address.provinceCode,
                district: $(address.district).val(),
                city_town: $(address.city_town).val(),
                st_loc: $(address.st_loc).val(),
                addrsline: $(address.addrs).val(),
                zipcode: $(address.zipcode).val(),
                website: $(address.website).val(),
                gmaphtml: $(address.gmaphtml).val(),
                timezone: address.timezone,
                lat: address.lat,
                lon: address.lon
            };
            if (flag) {
                $.ajax({
                    url: address.Updateurl,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editAddress',
                        address: attr
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                $(address.closeBut).trigger('click');
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(address.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function listAddress() {
            var para = {
                uid: address.uid,
                index: address.index,
                listindex: address.listindex
            };
            var flag = false;
            $.ajax({
                url: pd.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listAddress',
                    para: para
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
                            $(address.showDiv).html(data);
                            $(address.showDiv).show();
                            $(address.updateDiv).hide();
                            $(address.but).show();
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(address.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    function bindAddressFields(fields) {
        var list = countries;
        $(fields.country).focus();
        $(fields.country).val('');
        $(fields.province).val('');
        $(fields.district).val('');
        $(fields.city_town).val('');
        $(fields.st_loc).val('');
        var htm1 = $(fields.prmsg).html();
        var htm2 = $(fields.dimsg).html();
        var htm3 = $(fields.citmsg).html();
        var htm4 = $(fields.stlmsg).html();
        $(fields.country).autocomplete({
            minLength: 2,
            source: list,
            autoFocus: true,
            select: function (event, ui) {
                window.setTimeout(function () {
                    $(fields.country).val(ui.item.label);
                    $(fields.country).attr('name', ui.item.value);
                    fields.countryCode = ui.item.countryCode;
                    fields.PCR_reg = ui.item.PCR;
                    dccode = ui.item.Phone;
                    $(cn.codep + '0').val(ui.item.Phone);
                    for (i = 0; i <= cn.num; i++) {
                        $(document.getElementById(cn.codep + i)).val(ui.item.Phone);
                    }
                    addres.setCountry(ui.item);
                    $(fields.province).val('');
                    $(fields.province).focus();
                }, 50);
                $(fields.province).autocomplete({
                    source: function (request, response) {
                        $(fields.prmsg).html(LOADER_THR);
                        response(addres.getState($(fields.province).val()));
                        $(fields.prmsg).html(htm1);
                    },
                    minLength: 3,
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.province).val(ui.item.label);
                            $(fields.province).attr('name', ui.item.value);
                            fields.provinceCode = ui.item.provinceCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            $(fields.district).val('');
                            $(fields.district).focus();
                            addres.setState(ui.item);
                        }, 50);
                    }
                });
                $(fields.district).autocomplete({
                    minLength: 3,
                    source: function (request, response) {
                        $(fields.dimsg).html(LOADER_THR);
                        response(addres.getDistrict($(fields.district).val()));
                        $(fields.dimsg).html(htm2);
                    },
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.district).val(ui.item.label);
                            $(fields.district).attr('name', ui.item.value);
                            fields.districtCode = ui.item.districtCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            $(fields.city_town).val('');
                            $(fields.city_town).focus();
                            addres.setDistrict(ui.item);
                        }, 50);
                    }
                });
                $(fields.city_town).autocomplete({
                    minLength: 3,
                    source: function (request, response) {
                        $(fields.citmsg).html(LOADER_THR);
                        response(addres.getCity($(fields.city_town).val()));
                        $(fields.citmsg).html(htm3);
                    },
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.city_town).val(ui.item.label);
                            $(fields.city_town).attr('name', ui.item.value);
                            fields.city_townCode = ui.item.city_townCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            $(fields.st_loc).val('');
                            $(fields.st_loc).focus();
                            $(fields.citmsg).html(htm3);
                            addres.setCity(ui.item);
                        }, 50);
                    }
                });
                $(fields.st_loc).autocomplete({
                    minLength: 3,
                    source: function (request, response) {
                        $(fields.stlmsg).html(LOADER_THR);
                        response(addres.getLocality($(fields.st_loc).val()));
                        $(fields.stlmsg).html(htm4);
                    },
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.st_loc).val(ui.item.label);
                            $(fields.st_loc).attr('name', ui.item.value);
                            fields.st_locCode = ui.item.st_locCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            addres.setLocality(ui.item);
                        }, 200);
                    }
                });
            }
        });
    }
    ;
    function initializeUserAddForm() {
        var flag = false;
        $(usr.add.basicinfo.name).change(function () {
            if ($(usr.add.basicinfo.name).val().match(name_reg)) {
                flag = true;
                $(usr.add.basicinfo.nmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(usr.add.basicinfo.nmsg).html(INVALIDNOT);
            }
        });
        $(cn.plus).click(function () {
            $(cn.plus).hide();
            bulitMultipleCellNumbers();
        });
        $(em.plus).click(function () {
            $(em.plus).hide();
            bulitMultipleEmailIds();
        });
        $(ac.plus).click(function () {
            $(ac.plus).hide();
            bulitMultipleAccounts();
        });
        $(pd.plus).click(function () {
            $(pd.plus).hide();
            bulitMultipleProducts();
        });
    }
    ;
    function fetchUserTypes() {
        var htm = '';
        $(usr.add.basicinfo.TVUtype).html('');
        $.ajax({
            type: 'POST',
            url: usr.add.url,
            data: {
                autoloader: true,
                action: 'fetchUserTypes'
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
                        var type = $.parseJSON(data);
                        usertypes = type;
                        for (i = 0; i < type.length; i++) {
                            htm += type[i]["html"];
                        }
                        $(usr.add.basicinfo.TVUtype).html('<select class="form-control" id="' + usr.add.basicinfo.user_type + '"><option value="NULL" selected>Select user type</option>' + htm + '</select><p class="help-block" id="' + usr.add.basicinfo.ut_msg + '">Enter/ Select.</p>');
                        break;
                }
            },
            error: function () {
                $(usr.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function userAdd() {
        var attr = validateUserFields();
        if (attr) {
            $(usr.add.but).prop('disabled', 'disabled');
            $(usr.msgDiv).html('');
            $.ajax({
                url: usr.add.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'userAdd',
                    usradd: attr
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
                            $(usr.msgDiv).html('<h2>User added to database</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(usr.msgDiv).offset().top) - 95
                            }, "slow");
                            $(usr.add.form).get(0).reset();
                            break;
                    }
                },
                error: function () {
                    $(usr.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(usr.add.but).removeAttr('disabled');
                }
            });
        } else {
            $(usr.add.but).removeAttr('disabled');
        }
    }
    ;
    function bulitMultipleEmailIds() {
        if (em.num == -1)
            $(em.parentDiv).html('');
        em.num++;
        var html = '<div id="' + em.form + em.num + '">' +
                '<div class="col-lg-8">' +
                '<input class="form-control" placeholder="Email ID" name="email" type="text" id="' + em.email + em.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + em.msgDiv + em.num + '">Enter/ Select.</p>' +
                '</div>' +
                '<div class="col-lg-4">' +
                '<button type="button" class="btn btn-danger  btn-md" id="' + em.minus + em.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-success  btn-md" id="' + em.plus + em.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '</div>';
        $(em.parentDiv).append(html);
        $(document.getElementById(em.minus + em.num)).click(function () {
            $(document.getElementById(em.form + em.num)).remove();
            $(document.getElementById(em.msgDiv + em.num)).remove();
            em.num--;
            if (em.num == -1) {
                $(em.plus).show();
                $(em.parentDiv).html('');
            } else {
                $(document.getElementById(em.plus + em.num)).show();
                $(document.getElementById(em.minus + em.num)).show();
            }
            if (em.count && em.count == em.num) {
                $(em.plus).show();
            }
        });
        $(document.getElementById(em.plus + em.num)).click(function () {
            $(document.getElementById(em.plus + em.num)).hide();
            $(document.getElementById(em.minus + em.num)).hide();
            bulitMultipleEmailIds();
        });
    }
    ;
    function bulitMultipleProducts() {
        if (pd.num == -1)
            $(pd.parentDiv).html('');
        pd.num++;
        var html = '<div id="' + pd.form + pd.num + '">' +
                '<div class="col-lg-8">' +
                '<input class="form-control" placeholder="Product Name" name="product" type="text" id="' + pd.product + pd.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + pd.msgDiv + pd.num + '">Enter/ Select.</p>' +
                '</div>' +
                '<div class="col-lg-4">' +
                '<button type="button" class="btn btn-danger  btn-md" id="' + pd.minus + pd.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-success  btn-md" id="' + pd.plus + pd.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '</div>';
        $(pd.parentDiv).append(html);
        $(function () {
            $(document.getElementById(pd.minus + pd.num)).click(function () {
                $(document.getElementById(pd.form + pd.num)).remove();
                $(document.getElementById(pd.msgDiv + pd.num)).remove();
                pd.num--;
                if (pd.num == -1) {
                    $(pd.plus).show();
                } else {
                    $(document.getElementById(pd.plus + pd.num)).show();
                    $(document.getElementById(pd.minus + pd.num)).show();
                }
                if (pd.count) {
                    console.log(pd.count)
                }
                if (pd.count && pd.count == pd.num) {
                    $(pd.plus).show();
                }
            });
            $(document.getElementById(pd.plus + pd.num)).click(function () {
                $(document.getElementById(pd.plus + pd.num)).hide();
                $(document.getElementById(pd.minus + pd.num)).hide();
                bulitMultipleProducts();
            });
        });
    }
    ;
    function bulitMultipleAccounts() {
        if (ac.num == -1)
            $(ac.parentDiv).html('');
        ac.num++;
        var html = '<div id="' + ac.form + ac.num + '">' +
                '<div class="col-lg-6">' +
                '<div class="panel panel-warning">' +
                '<div class="panel-heading">' +
                '<strong>Bank account ' + Number(ac.num + 1) + '</strong>&nbsp;' +
                '<button type="button" class="btn btn-danger  btn-md" id="' + ac.minus + ac.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-success  btn-md" id="' + ac.plus + ac.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '<div class="panel-body">' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Bank Name <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Bank Name" name="bankname" type="text" id="' + ac.bankname + ac.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + ac.nmsg + ac.num + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Account Number <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Account Number" name="accno" type="text" id="' + ac.accno + ac.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + ac.nomsg + ac.num + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Name <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Branch Name" name="braname" type="text" id="' + ac.braname + ac.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + ac.bnmsg + ac.num + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Code <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Branch Code" name="bracode" type="text" id="' + ac.bracode + ac.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + ac.bcmsg + ac.num + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> IFSC <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="IFSC" name="IFSC" type="text" id="' + ac.IFSC + ac.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + ac.IFSCmsg + ac.num + '">Enter/ Select.</p>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        $(ac.parentDiv).append(html);
        $(function () {
            $(document.getElementById(ac.minus + ac.num)).click(function () {
                $(document.getElementById(ac.form + ac.num)).remove();
                $(document.getElementById(ac.msgDiv + ac.num)).remove();
                ac.num--;
                if (ac.num == -1) {
                    $(ac.plus).show();
                } else if (ac.count && ac.count == ac.num) {
                    $(ac.plus).show();
                } else {
                    $(document.getElementById(ac.plus + ac.num)).show();
                    $(document.getElementById(ac.minus + ac.num)).show();
                }
            });
            $(document.getElementById(ac.plus + ac.num)).click(function () {
                $(document.getElementById(ac.plus + ac.num)).hide();
                $(document.getElementById(ac.minus + ac.num)).hide();
                bulitMultipleAccounts();
            });
        });
    }
    ;
    function bulitMultipleCellNumbers() {
        if (cn.num == -1)
            $(cn.parentDiv).html('');
        cn.num++;
        var html = '<div class="row show-grid" id="' + cn.form + cn.num + '">' +
                '<div class="col-xs-6 col-md-4">' +
                '<input class="form-control" value="' + dccode + '" name="ccode" type="text" id="' + cn.codep + cn.num + '" maxlength="15" />' +
                '</div>' +
                '<div class="col-xs-6 col-md-4">' +
                '<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="' + cn.nump + cn.num + '" maxlength="20" />' +
                '</div>' +
                '<div class="col-xs-6 col-md-4">' +
                '<button type="button" class="btn btn-danger  btn-md" id="' + cn.minus + cn.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-success  btn-md" id="' + cn.plus + cn.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-12"><p class="help-block" id="' + cn.msgDiv + cn.num + '">Enter/ Select.</p></div>';
        $(cn.parentDiv).append(html);
        $(function () {
            $(document.getElementById(cn.minus + cn.num)).click(function () {
                $(document.getElementById(cn.form + cn.num)).remove();
                $(document.getElementById(cn.msgDiv + cn.num)).remove();
                cn.num--;
                if (cn.num == -1) {
                    $(cn.plus).show();
                } else if (cn.count && cn.count == cn.num) {
                    $(cn.plus).show();
                } else {
                    $(document.getElementById(cn.plus + cn.num)).show();
                    $(document.getElementById(cn.minus + cn.num)).show();
                }
            });
            $(document.getElementById(cn.plus + cn.num)).click(function () {
                $(document.getElementById(cn.plus + cn.num)).hide();
                $(document.getElementById(cn.minus + cn.num)).hide();
                bulitMultipleCellNumbers();
            });
        });
    }
    ;
    function clearuserAddForm() {
        cn.num = -1;
        em.num = -1;
        ac.num = -1;
    }
    ;
    function DisplayUserList() {
        $(usr.msgDiv).html('');
        var header = '<table class="table table-striped table-bordered table-hover display" id="list_user_table">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="9">Lists</th>' +
                '</tr>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>User Name</th>' +
                '<th class="text-right">User Type</th>' +
                '<th class="text-right">Email</th>' +
                '<th class="text-right">Cell No</th>' +
                '<th class="text-right">OutStanding Amt</th>' +
                '<th class="text-right">Delete</th>' +
                '<th class="text-right">Flag/Unflag</th>' +
                '<th class="text-right">Edit</th>' +
                '</tr></thead>';
        var footer = '</table>';
        $(usr.list.listDiv).html(header + footer);
        $('#list_user_table').DataTable({
            processing: true,
            serverSide: true,
            //dom: '<"top"i>rt<"bottom"flp><"clear">',
            //dom: '<lf<t>ip>',
            dom: 'Bfliprt',
            buttons: [
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            columnDefs: [{
                    targets: 0,
                    visible: false
                }
            ],
            ajax: {
                url: usr.list.url,
                type: 'POST',
				async:false,
                data: function (d) {
                    d.autoloader = true;
                    d.action = "DisplayUserList";
                },
            },
            createdRow: function (row, data, dataIndex) {
                if (data) {
                    var listusers = data;
                    window.setTimeout(function () {
                        $(listusers.usrdelOk).bind('click', {
                            uid: listusers.uid,
                            sr: listusers.sr
                        }, function (evt) {
                            $($(this).prop('name')).hide(400);
                            var hid = deleteUser(evt.data.uid);
                            if (hid) {
                                $(evt.data.sr).remove();
                                DisplayUserList();
                            }
                        });
                        $(listusers.usrflgOk).bind('click', {
                            uid: listusers.uid,
                            sr: listusers.sr
                        }, function (evt) {
                            $($(this).prop('name')).hide(400);
                            var hid = flagUser(evt.data.uid);
                            DisplayUserList();
                        });
                        $(listusers.usruflgOk).bind('click', {
                            uid: listusers.uid,
                            sr: listusers.sr
                        }, function (evt) {
                            $($(this).prop('name')).hide(400);
                            var hid = unflagUser(evt.data.uid);
                            DisplayUserList();
                        });
                        $(listusers.usredit).bind('click', {
                            uid: listusers.uid,
                            sr: listusers.sr
                        }, function (evt) {
                            $($(this).prop('name')).hide(400);
                            var hid = edituser(evt.data.uid);
                        });
                    }, 800);
                }
            },
            initComplete: function (settings, json) {
                var data = json.data;
                if (data) {
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(usr.list.listLoad).html('');
                            $('#list_user_table').css('width','100%');
                            break;
                    }
                }
                else {
                    alert('Unable to list users.');
                }
            },
            preDrawCallback: function (settings) {
                $(usr.list.listLoad).html(LOADER_TWO);
                $('#list_user_table').css('width','100%');
            },
            drawCallback: function (settings) {
                $(usr.list.listLoad).html('');
                $('#list_user_table').css('width','100%');
            },
            columns: [
                {data: '#'},
                {data: 'User Name'},
                {data: 'User Type'},
                {data: 'Email'},
                {data: 'Cell No'},
                {data: 'OutStanding'},
                {data: 'Delete', searchable: false, orderable: false},
                {data: 'Flag/Unflag', searchable: false, orderable: false},
                {data: 'Edit', searchable: false, orderable: false}
            ]
        });
        var dtable = $("#list_user_table").dataTable().api();
        $(".dataTables_filter input").unbind().bind("input", function (e) {
            if (this.value.length >= 3 || e.keyCode == 13) {
                dtable.search(this.value).draw();
            }
            if (this.value == "") {
                dtable.search("").draw();
            }
            return;
        });
    }
    ;
    function deleteUser(uid) {
        var flag = false;
        var attr = {
            entid: uid
        };
        $.ajax({
            url: usr.add.url,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'deleteUser',
                ptydeletesale: attr
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
                        flag = data;
                        break;
                }
            },
            error: function () {
                $(usr.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        return flag;
    }
    function flagUser(id) {
        var uid = id;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'flagUser',
                fuser: uid
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                if (!data) {
                    flag = false;
                } else
                    flag = true;
            }
        });
        return flag;
    }
    function unflagUser(id) {
        var uid = id;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'unflagUser',
                ufuser: uid
            },
            success: function (data, textStatus, xhr) {
                console.log(data);
                data = $.trim(data);
                if (data) {
                    flag = true;
                }
            }
        });
        return flag;
    }
    function edituser(id) {
        var usrid = id;
        var htm = '';
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'edituser',
                usrid: usrid
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
                        var details = $.parseJSON(data)
                        $(usr.list.listDiv).html(details.html);
                        break;
                }
            },
            error: function () {
                $(usr.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function validateUserFields() {
        var flag = false;
        var email = [];
        var cellnumbers = [];
        var accounts = [];
        var products = [];
        var type = $('#' + usr.add.basicinfo.user_type).val();
        /* ACS ID */
        if ($(usr.add.basicinfo.acs_id).val().length < 21) {
            flag = true;
            $(usr.add.basicinfo.ac_msg).html(VALIDNOT);
        } else {
            flag = false;
            $(usr.add.basicinfo.ac_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(usr.add.basicinfo.ac_msg).offset().top) - 95
            }, "slow");
            $(usr.add.basicinfo.acs_id).focus();
            return;
        }
        if (type != 'NULL' && type != '') {
            flag = true;
        } else {
            flag = false;
            $('#' + usr.add.basicinfo.ut_msg).html('<strong class="text-danger">Select user type.</strong>');
            $('html, body').animate({
                scrollTop: Number($('#' + usr.add.basicinfo.ut_msg).offset().top) - 95
            }, "slow");
            return;
        }
        /* User name */
        if ($(usr.add.basicinfo.name).val().match(name_reg)) {
            flag = true;
        } else {
            flag = false;
            $(usr.add.basicinfo.nmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(usr.add.basicinfo.nmsg).offset().top) - 95
            }, "slow");
            $(usr.add.basicinfo.name).focus();
            return;
        }
        /* Outstanding amount */
        if ($(usr.add.basicinfo.otamt).val().match(ind_reg)) {
            flag = true;
            $(usr.add.basicinfo.otamtmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(usr.add.basicinfo.otamtmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(usr.add.basicinfo.otamtmsg).offset().top) - 95
            }, "slow");
            $(usr.add.basicinfo.otamt).focus();
            return;
        }
        /* Email ids */
        if (em.num > -1) {
            j = 0;
            for (i = 0; i <= em.num; i++) {
                if ($(document.getElementById(em.email + i)).val().match(email_reg)) {
                    flag = true;
                    $(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
                    email[j] = $(document.getElementById(em.email + i)).val();
                    j++;
                } else {
                    flag = false;
                    $(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(em.email + i)).focus();
                    return;
                }
            }
        }
        /* Cell numbers */
        if (cn.num > -1) {
            j = 0;
            for (i = 0; i <= cn.num; i++) {
                if ($(document.getElementById(cn.codep + i)).val().match(ccod_reg)) {
                    flag = true;
                    $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(cn.msgDiv + i)).html('<strong class="text-danger">Not Valid Cell prefiex</strong>');
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(cn.codep + i)).focus();
                    return;
                }
                if ($(document.getElementById(cn.nump + i)).val().match(cell_reg)) {
                    flag = true;
                    $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(cn.nump + i)).focus();
                    return;
                }
                if (flag) {
                    cellnumbers[j] = {
                        codep: $(document.getElementById(cn.codep + i)).val(),
                        nump: $(document.getElementById(cn.nump + i)).val()
                    };
                    j++;
                }
            }
        }
        /* Bank Account */
        if (ac.num > -1) {
            j = 0;
            for (i = 0; i <= ac.num; i++) {
                if ($(document.getElementById(ac.bankname + i)).val().match(name_reg)) {
                    flag = true;
                    $(document.getElementById(ac.nmsg + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(ac.nmsg + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(ac.nmsg + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(ac.bankname + i)).focus();
                    return;
                }
                if ($(document.getElementById(ac.accno + i)).val().match(accn_reg)) {
                    flag = true;
                    $(document.getElementById(ac.nomsg + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(ac.nomsg + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(ac.nomsg + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(ac.accno + i)).focus();
                    return;
                }
                if ($(document.getElementById(ac.braname + i)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(ac.bnmsg + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(ac.bnmsg + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(ac.bnmsg + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(ac.braname + i)).focus();
                    return;
                }
                if ($(document.getElementById(ac.bracode + i)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(ac.bcmsg + i)).html(VALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
                    }, "slow");
                } else {
                    flag = false;
                    $(document.getElementById(ac.bcmsg + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(ac.bracode + i)).focus();
                    return;
                }
                if ($(document.getElementById(ac.IFSC + i)).val().length < 101) {
                    flag = true;
                    $(document.getElementById(ac.IFSCmsg + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(ac.IFSCmsg + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(ac.IFSCmsg + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(ac.IFSC + i)).focus();
                    return;
                }
                if (flag) {
                    accounts[j] = {
                        bankname: $(document.getElementById(ac.bankname + i)).val(),
                        accno: $(document.getElementById(ac.accno + i)).val(),
                        braname: $(document.getElementById(ac.braname + i)).val(),
                        bracode: $(document.getElementById(ac.bracode + i)).val(),
                        IFSC: $(document.getElementById(ac.IFSC + i)).val()
                    };
                    j++;
                }
            }
        }
        /* Products */
        if (pd.num > -1) {
            j = 0;
            for (i = 0; i <= pd.num; i++) {
                if ($(document.getElementById(pd.product + i)).val().match(name_reg)) {
                    flag = true;
                    $(document.getElementById(pd.msgDiv + i)).html(VALIDNOT);
                    products[j] = $(document.getElementById(pd.product + i)).val();
                    j++;
                } else {
                    flag = false;
                    $(document.getElementById(pd.msgDiv + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(pd.msgDiv + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(pd.product + i)).focus();
                    return;
                }
            }
        } else if (pd.num == -1) {
            $(pd.plus).trigger('click');
            flag = false;
            return;
        }
        var attr = {
            user_type: type,
            name: $(usr.add.basicinfo.name).val(),
            otamt: $(usr.add.basicinfo.otamt).val(),
            acs: $(usr.add.basicinfo.acs_id).val(),
            email: email,
            cellnumbers: cellnumbers,
            accounts: accounts,
            products: products,
            country: $(usr.add.address.country).val(),
            countryCode: usr.add.address.countryCode,
            province: $(usr.add.address.province).val(),
            provinceCode: usr.add.address.provinceCode,
            district: $(usr.add.address.district).val(),
            city_town: $(usr.add.address.city_town).val(),
            st_loc: $(usr.add.address.st_loc).val(),
            addrsline: $(usr.add.address.addrs).val(),
            tphone: $(usr.add.address.tphone).val(),
            pcode: $(usr.add.address.pcode).val(),
            zipcode: $(usr.add.address.zipcode).val(),
            website: $(usr.add.address.website).val(),
            gmaphtml: $(usr.add.address.gmaphtml).val(),
            timezone: usr.add.address.timezone,
            lat: usr.add.address.lat,
            lon: usr.add.address.lon
        };
        if (flag) {
            return attr;
        } else
            return false;
    }
    ;
}
