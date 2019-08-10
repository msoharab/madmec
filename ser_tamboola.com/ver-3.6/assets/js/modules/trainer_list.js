function controlListTrainer() {
    var gymid = $(DGYM_ID).attr("name");
    this.__construct = function () {
        displayListTrainer();
    };
    this.close = function (clid) {
        var cl = clid;
        $(cl.closeDiv).click(function () {
            $(cl.clisttab).click();
        });
    }
    this.editTrainer = function (trainer) {
        var tra = trainer;
        $(tra.but).click(function () {
            $(tra.showDiv).toggle();
            $(tra.updateDiv).toggle();
            $(tra.but).hide();
        });
        $(tra.saveBut).click(function () {
            updateTrainer();
        });
        $(tra.closeBut).click(function () {
            var para = {
                m_uid: tra.m_uid,
                uid: tra.uid,
            };
            edittrainer(para);
        });
        $(tra.dob).datepicker({
            dateFormat: 'dd-M-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1950:-10',
            showButtonPanel: true,
        });
        $(tra.doj).datepicker({
            dateFormat: 'dd-M-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: '1950:+0',
            showButtonPanel: true,
        });
        /*pic edit*/
        $(".picedit_box").picEdit({
            imageUpdated: function (img) {
            },
            formSubmitted: function (data) {
                var para = {
                    m_uid: tra.m_uid,
                    uid: tra.uid,
                };
                $("#photoCancel_" + tra.uid).click();
                edittrainer(para);
            },
            redirectUrl: false,
            defaultImage: URL + ASSET_IMG + 'No_image.png',
        });
        function updateTrainer() {
            var para = {
                m_uid: tra.m_uid,
                uid: tra.uid,
            };
            /*console.log(uid);*/
            var attr = validateUpdateTrainer();
            /*console.log(attr);*/
            if (attr) {
                $(tra.but).prop('disabled', 'disabled');
                $(loader).html(LOADER_SIX);
                $.ajax({
                    url: tra.Updateurl,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'trainerUpdate',
                        type: 'slave',
                        gymid: gymid,
                        eadd: attr,
                        uid: para
                    },
                    success: function (data, textStatus, xhr) {
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                edittrainer(para);
                                break;
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        $(tra.but).removeAttr('disabled');
                    }
                });
            } else {
                $(tra.but).removeAttr('disabled');
            }
        }
        function validateUpdateTrainer() {
            var flag = false;
            /* name */
            if ($(tra.name).val().replace(/  +/g, ' ').match(nm_reg)) {
                flag = true;
                $(tra.nmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(tra.nmsg).html(INVALIDNOT);
                $(tra.name).focus();
                $('html, body').animate({
                    scrollTop: Number($(tra.nmsg).offset().top) - 95
                }, "slow");
                $(tra.nmsg).focus();
                return;
            }
            /* email */
            if (tra.email_val != $(tra.email).val()) {
                var temp1 = checkValidValue();
                console.log(temp1);
                if (temp1 === 'true') {
                    if ($(tra.email).val().match(email_reg)) {
                        flag = true;
                        $(tra.emsg).html(VALIDNOT);
                    } else {
                        flag = false;
                        $(tra.emsg).html(INVALIDNOT);
                        $(tra.email).focus();
                        $('html, body').animate({
                            scrollTop: Number($(tra.emsg).offset().top) - 95
                        }, "slow");
                        $(tra.emsg).focus();
                        return;
                    }
                } else if (temp1 === 'false') {
                    flag = false;
                    $(tra.emsg).html("<strong class='text-danger'>Email Already Taken</strong>");
                    $('html, body').animate({
                        scrollTop: Number($(tra.emsg).offset().top) - 95
                    }, "slow");
                    $(tra.emsg).focus();
                    return;
                }
            } else
            /* cellcode */
            if ($(tra.ccode).val().match(ccod_reg)) {
                flag = true;
                $(tra.cmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(tra.cmsg).html(INVALIDNOT);
                $(tra.ccode).focus();
                $('html, body').animate({
                    scrollTop: Number($(tra.cmsg).offset().top) - 95
                }, "slow");
                $(tra.cmsg).focus();
                return;
            }
            /* cellnumber */
            if ($(tra.mobile).val().match(cell_reg)) {
                flag = true;
                $(tra.mmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(tra.mmsg).html(INVALIDNOT);
                $(tra.mobile).focus();
                $('html, body').animate({
                    scrollTop: Number($(tra.mmsg).offset().top) - 95
                }, "slow");
                $(tra.mmsg).focus();
                return;
            }
            /* dob and dob join */
            var dateofbirth = convertDateFormat($(tra.dob).val());
            var dateofjoin = convertDateFormat($(tra.doj).val());
            var dob = new Date(dateofbirth);
            var doj = new Date(dateofjoin);
            if (dob < doj) {
                flag = true;
                $("#" + tra.doj_msg).html(VALIDNOT);
                $("#" + tra.dob_msg).html(VALIDNOT);
            } else {
                flag = false;
                $("#" + tra.doj_msg).html(INVALIDNOT);
                $(tra.doj).val().focus();
            }
            var attr = {
                name: $(tra.name).val().replace(/  +/g, ' '),
                email: $(tra.email).val(),
                cellcode: $(tra.ccode).val(),
                cellnum: $(tra.mobile).val(),
                dob: convertDateFormat($(tra.dob).val()),
                doj: convertDateFormat($(tra.doj).val()),
            };
            if (flag) {
                return attr;
            } else
                return false;
        }
        ;
        function checkValidValue() {
            var em = $(tra.email).val();
            var valid_scc = $.ajax({
                url: window.location.href,
                type: 'POST',
                async: false,
                data: {
                    autoloader: 'true',
                    action: 'checkEmailEmp',
                    type: 'master',
                    gymid: gymid,
                    email: em,
                    empid: tra.m_uid
                },
                success: function (data) {
                    data = $.parseJSON($.trim(data));
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
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
            console.log("ajax comp");
            console.log($.trim(valid_scc.responseText));
            var valid_scc = $.trim(valid_scc.responseText);
            return valid_scc;
        }
    }
    function displayListTrainer() {
        var header = '<table class="table table-striped table-bordered table-hover" id="list_trainer_table"><thead><tr><th></th><th>#</th><th>Employee Name</th><th class="text-right">Email Id</th><th class="text-right">Cell Number</th><th>Facility</th><th>Employee Type</th><th class="text-right">Option</th><th class="text-right" style="display:none";>Facility Type</th><th class="text-right" style="display:none";>DOB</th><th class="text-right" style="display:none";>DOJ</th></tr></thead>';
        var footer = '</table>';
        var htm = '';
        $(loader).html(LOADER_SIX);
        $.ajax({
            url: window.location.href,
            type: 'post',
            data: {
                autoloader: true,
                action: 'displayListTrainer',
                type: 'slave',
                gymid: gymid
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
                        var listtrainer = $.parseJSON($.trim(data));
                        /*
                         / console.log(listtrainer["0"]["name"]);
                         */
                        for (i = 0; i < listtrainer.length; i++) {
                            htm += listtrainer[i]["html"];
                        }
                        $("#listTrainer").html(header + htm + footer);
                        for (i = 0; i < listtrainer.length; i++) {
                            $(listtrainer[i].usrdelOk).bind('click', {
                                uid: listtrainer[i].uid,
                                m_uid: listtrainer[i].m_uid,
                                sr: listtrainer[i].sr
                            }, function (evt) {
                                $($(this).prop('name')).hide(400);
                                /*
                                 / console.log(evt.data.uid);
                                 */
                                var para = {
                                    uid: evt.data.uid,
                                    m_uid: evt.data.m_uid,
                                };
                                var hid = deleteTrainer(para);
                                if (hid) {
                                    $(evt.data.sr).remove();
                                    displayListTrainer();
                                }
                            });
                            $(listtrainer[i].usrflgOk).bind('click', {
                                uid: listtrainer[i].uid,
                                m_uid: listtrainer[i].m_uid,
                                sr: listtrainer[i].sr
                            }, function (evt) {
                                var para = {
                                    uid: evt.data.uid,
                                    m_uid: evt.data.m_uid,
                                };
                                $($(this).prop('name')).hide(400);
                                var hid = flagTrainer(para);
                                displayListTrainer();
                            });
                            $(listtrainer[i].usruflgOk).bind('click', {
                                uid: listtrainer[i].uid,
                                m_uid: listtrainer[i].m_uid,
                                sr: listtrainer[i].sr
                            }, function (evt) {
                                var para = {
                                    uid: evt.data.uid,
                                    m_uid: evt.data.m_uid,
                                };
                                $($(this).prop('name')).hide(400);
                                var hid = unflagTrainer(para);
                                displayListTrainer();
                            });
                            $(listtrainer[i].usredit).bind('click', {
                                uid: listtrainer[i].uid,
                                m_uid: listtrainer[i].m_uid,
                                sr: listtrainer[i].sr
                            }, function (evt) {
                                var para = {
                                    uid: evt.data.uid,
                                    m_uid: evt.data.m_uid,
                                };
                                $($(this).prop('name')).hide(400);
                                var hid = edittrainer(para);
                                /*DisplayUserList();*/
                            });
                        }
                        window.setTimeout(function () {
                            var table = $('#list_trainer_table').DataTable({
                                "aoColumns": [
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                ],
                                "columns": [{
                                        "className": 'details-control',
                                        "orderable": false,
                                        "data": null,
                                        "defaultContent": ''
                                    }, {
                                        "data": "name"
                                    },
                                ],
                                "order": [[1, 'asc']]
                            });
                            $('#list_trainer_table tbody').on('click', 'td.details-control', function () {
                                var tr = $(this).closest('tr');
                                /*console.log(tr);*/
                                var row = table.row(tr);
                                /*console.log(row.data());*/
                                if (row.child.isShown()) {
                                    /* This row is already open - close it*/
                                    row.child.hide();
                                    tr.removeClass('shown');
                                } else {
                                    /* Open this row*/
                                    row.child(format(row.data())).show();
                                    tr.addClass('shown');
                                }
                            });
                        }, 600)
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
    function format(d) {
        /*console.log(d);*/
        /* `d` is the original data object for the row*/
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Facility:</td>' +
                '<td>' + d[8] + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Date Of Birth:</td>' +
                '<td>' + d[9] + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Date Of Join:</td>' +
                '<td>' + d[10] + '</td>' +
                '</tr>' +
                '</table>';
    }
    function deleteTrainer(para) {
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'deleteTrainer',
                type: 'slave',
                gymid: gymid,
                traDEL: para
            },
            success: function (data, textStatus, xhr) {
                /*console.log("delete status"+data);*/
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
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
    function flagTrainer(para) {
        /*console.log(uid);*/
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'flagTrainer',
                type: 'slave',
                gymid: gymid,
                fuser: para
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                /*
                 / console.log(data);
                 */
                if (!data) {
                    flag = false;
                } else
                    flag = true;
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
    function unflagTrainer(para) {
        var uid = para;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'unflagTrainer',
                type: 'slave',
                gymid: gymid,
                ufuser: uid
            },
            success: function (data, textStatus, xhr) {
                /*
                 / console.log(data);
                 */
                data = $.trim(data);
                if (data) {
                    flag = true;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
    function edittrainer(para) {
        /*console.log("trainer edit")*/
        console.log(para);
        var htm = '';
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'edittrainer',
                type: 'slave',
                gymid: gymid,
                usrid: para
            },
            success: function (data, textStatus, xhr) {
                /*console.log("status"+data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $("#listTrainer").html(data);
                        /*flag = data;*/
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
        /*return flag;*/
    }
}
;
