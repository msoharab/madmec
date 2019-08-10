function PCC() {
    var PCC = {};
    var units = '';
    var ethno = {};
    var client = {};
    var cperson = {};
    var particulars = [];
    var listofrequi = [];
    var par = {};
    var del = {};
    var requi = {};
    var list = {};
    this.__construct = function (reqctrl) {
        PCC = reqctrl;
        par = PCC.add.part;
        del = PCC.add.pcctask;
        requi = PCC.add.prdtask;
        list = PCC.list;
        $(PCC.msgDiv).html('');

        $(list.menuBut).click(function () {
            listDoc();
        });
        $(par.plus).click(function (evt) {
            evt.stopPropagation();
            evt.preventDefault();
            $(this).hide();
            addMultiplePart();
        });
        $(PCC.add.pccsdw + ',' + PCC.add.pccsdm + ',' + PCC.add.pccdd).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(PCC.add.but).click(function (evt) {
            evt.stopPropagation();
            evt.preventDefault();
            addPCCrements();
        });
        fetchPCCrement();
    };

    function fetchPCCrement() {
        var htm = '';
        $.ajax({
            type: 'POST',
            url: requi.url,
            data: {
                autoloader: true,
                action: 'fetchRequirement'
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
                        listofrequi = $.parseJSON($.trim(data));
                        if (listofrequi != null && listofrequi.length > 0) {
                            var tableheader = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>Project Details</th><th>Task Details</th><th>Feedback / SMS</th></tr></thead><tbody>';
                            var tablefooter = '</tbody></table></div>';
                            var task_descp = tableheader;
                            var lastind = Number(listofrequi.length) - 1;
                            for (j = 0; j < listofrequi[lastind]["task_descp"].length; j++) {
                                htm += listofrequi[lastind]["task_descp"][j]["html"];
                            }
                            $(requi.TVQtype).html('<select class="form-control" id="' + requi.Qrequi_type + '"><option value="NULL" selected>Select Production Task</option>' + htm + '</select><p class="help-block" id="' + requi.QRT_msg + '">Enter / Select</p>');
                            $('#' + requi.Qrequi_type).change({
                                para: PCC.add,
                                requi: listofrequi,
                                len: listofrequi.length,
                                self: '#' + requi.Qrequi_type
                            }, function (evt) {
                                var para = evt.data.para;
                                var requi = evt.data.requi;
                                var len = evt.data.len;
                                var self = evt.data.self;
                                for (i = 0; i < len; i++) {
                                    for (j = 0; j < requi[i]["task_descp"].length; j++) {
                                        if (requi[i]["task_descp"][j]["id"] == $(this).select().val()) {
                                            para.prdtask.pname = requi[i]["pname"];
                                            para.prdtask.prjmid = requi[i]["id"];
                                            para.prdtask.prjid = requi[i]["prjid"];
                                            para.prdtask.requi_id = requi[i]["req_id"];
                                            para.prdtask.ref_no = requi[i]["ref_no"];
                                            para.prdtask.quot_id = requi[i]["quot_id"];
                                            para.prdtask.po_id = requi[i]["po_id"];
                                            para.prdtask.inv_id = requi[i]["inv_id"];
                                            para.prdtask.client_id = requi[i]["client_id"];
                                            para.prdtask.ethno_id = requi[i]["ethno_id"];
                                            para.prdtask.rep_id = requi[i]["rep_id"];
                                            para.prdtask.ethno = requi[i]["ethno"];
                                            para.prdtask.rep = requi[i]["rep"];
                                            para.prdtask.doethno = requi[i]["doethno"];
                                            para.prdtask.ind = i;
                                            para.prdtask.artype = requi[i]["artype"];
                                            $(para.pccn).val('PCC -- ' + $(self + ' option:selected').text());
                                            $(para.prdtask.Rdoc).html(tableheader + requi[i]["task_descp"][j]["tablerow"] + tablefooter);
                                            return;
                                        }
                                    }
                                }
                            });
                        }
                        break;
                }
            },
            error: function () {
                $(PCC.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function addMultiplePart() {
        if (par.num == -1)
            $(par.parentDiv).html('');
        par.num++;
        particulars.push({
            num: par.num,
            form: par.form + par.num,
            bankname: par.bankname + par.num,
            nmsg: par.nmsg + par.num,
            deliinstarr: [],
            plus: par.plus + par.num,
            minus: par.minus + par.num
        });
        var html = '<div id="' + par.form + par.num + '">' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<div class="panel panel-warning">' +
                '<div class="panel-heading">' +
                '<strong>PCC Task ' + Number(par.num + 1) + '</strong>&nbsp;' +
                '<button class="btn btn-danger  btn-md" id="' + par.minus + par.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button class="btn btn-success  btn-md" id="' + par.plus + par.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '<div class="panel-body">' +
                '<div class="row">' +
                '<div class="col-lg-12">' +
                '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Materials Description </strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '<input type="text" class="form-control" placeholder="Materials Description" name="' + par.bankname + par.num + '" id="' + par.bankname + par.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + par.nmsg + par.num + '">Enter / Select</p>' +
                '</div>' +
                '</div>' +
                '<!-- row -->' +
                '<div class="row">' +
                '<!-- PCC Task -->' +
                '<div class="col-lg-12">' +
                '<div class="row">' +
                '<div class="col-lg-12"> <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> PCC Task Description </strong>&nbsp;' +
                '<button class="text-primary btn btn-success  btn-md" name="' + par.num + '" id="' + del.plus + par.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>&nbsp; ' +
                '</div>' +
                '<div class="col-lg-12" id="' + del.parentDiv + par.num + '">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<!-- PCC Task -->' +
                '</div>' +
                '<!-- panel-body -->' +
                '</div>' +
                '<!-- panel-warning -->' +
                '</div>' +
                '<!-- col-lg-12 -->' +
                '</div>' +
                '<!-- row -->' +
                '</div>' +
                '<!-- parentDiv -->' +
                '</div>';
        $(html).appendTo($(par.parentDiv));
        $(document.getElementById(par.minus + par.num)).click(function (evt) {
            evt.stopPropagation();
            evt.preventDefault();
            $(document.getElementById(par.form + par.num)).remove();
            par.num--;
            if (par.num == -1) {
                $(par.plus).show();
                $(par.parentDiv).html('');
                particulars = [];
            } else {
                $(document.getElementById(par.plus + par.num)).show();
                $(document.getElementById(par.minus + par.num)).show();
                particulars.pop();
            }
        });
        $(document.getElementById(par.plus + par.num)).click(function (evt) {
            evt.stopPropagation();
            evt.preventDefault();
            $(document.getElementById(par.plus + par.num)).hide();
            $(document.getElementById(par.minus + par.num)).hide();
            addMultiplePart();
        });
        window.setTimeout(function () {
            $(document.getElementById(del.plus + par.num)).click(function (evt) {
                evt.stopPropagation();
                evt.preventDefault();
                $(this).hide();
                addMultipleDelivi({
                    pind: $(this).prop('name'),
                    index: -1
                });
            });
            // $(document.getElementById(del.plus+par.num)).hide();
            // addMultipleDelivi({pind:$(document.getElementById(del.plus+par.num)).prop('name'),index:-1});
        }, 400);
    }
    ;

    function addMultipleDelivi(ind) {
        var index = ind.index;
        var pind = ind.pind;
        if (index == -1) {
            index = 0;
            $(document.getElementById(del.parentDiv + pind)).html('');
        } else {
            index = Number(index + 1);
        }
        particulars[pind].deliinstarr[index] = {
            parentDiv: del.parentDiv + pind + '_' + index,
            num: index,
            pind: pind,
            form: del.form + pind + '_' + index,
            bankname: del.bankname + pind + '_' + index,
            nmsg: del.nmsg + pind + '_' + index,
            accno: del.accno + pind + '_' + index,
            nomsg: del.nomsg + pind + '_' + index,
            braname: del.braname + pind + '_' + index,
            bnmsg: del.bnmsg + pind + '_' + index,
            bracode: del.bracode + pind + '_' + index,
            bcmsg: del.bcmsg + pind + '_' + index,
            plus: del.plus + pind + '_' + index,
            minus: del.minus + pind + '_' + index
        };
        var tableheader = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>Size</th><th>Colour</th><th>Quantity</th><th>Remark</th></tr></thead><tbody>';
        var tablefooter = '</tbody></table></div>';
        var html = '<div id="' + del.form + pind + '_' + index + '">' +
                '<div class="col-lg-12">' +
                '<div class="panel panel-info">' +
                '<div class="panel-heading">' +
                '<strong>PCC Task Description ' + Number(index + 1) + '</strong>&nbsp;' +
                '<button class="btn btn-danger btn-md" id="' + del.minus + pind + '_' + index + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button class="btn btn-success btn-md" name="' + pind + '" id="' + del.plus + pind + '_' + index + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '<div class="panel-body">' + tableheader +
                '<tr>' +
                '<td>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Size" name="' + del.bankname + pind + '_' + index + '" type="text" id="' + del.bankname + pind + '_' + index + '" maxlength="100" value="0" />' +
                '<p class="help-block" id="' + del.nmsg + pind + '_' + index + '">Enter / Select</p>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Colour" name="' + del.accno + pind + '_' + index + '" type="text" id="' + del.accno + pind + '_' + index + '" maxlength="100" value="0"/>' +
                '<p class="help-block" id="' + del.nomsg + pind + '_' + index + '">Enter / Select</p>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Quantity" name="' + del.braname + pind + '_' + index + '" type="text" id="' + del.braname + pind + '_' + index + '" maxlength="100" value="0" />' +
                '<p class="help-block" id="' + del.bnmsg + pind + '_' + index + '">Enter / Select</p>' +
                '</div>' +
                '</td>' +
                '<td>' +
                '<div class="col-lg-12">' +
                '<input class="form-control" placeholder="Remark" name="' + del.bracode + pind + '_' + index + '" type="text" id="' + del.bracode + pind + '_' + index + '" maxlength="100" value="0"/>' +
                '<p class="help-block" id="' + del.bcmsg + pind + '_' + index + '">Enter / Select</p>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>' + tablefooter +
                '</div>' +
                '</div>' +
                '</div>';
        $(html).appendTo($(document.getElementById(del.parentDiv + pind)));
        $(document.getElementById(del.minus + pind + '_' + index)).click(function (evt) {
            evt.stopPropagation();
            evt.preventDefault();
            $(document.getElementById(del.form + pind + '_' + index)).remove();
            particulars[pind].deliinstarr[index].num--;
            var num = particulars[pind].deliinstarr[index].num;
            if (num == -1) {
                $(document.getElementById(del.plus + pind)).show();
                $(document.getElementById(del.parentDiv)).html('');
                particulars[pind].deliinstarr = [];
            } else {
                $(document.getElementById(del.plus + pind + '_' + num)).show();
                $(document.getElementById(del.minus + pind + '_' + num)).show();
                particulars[pind].deliinstarr.pop();
            }
        });
        $(document.getElementById(del.plus + pind + '_' + index)).click(function (evt) {
            evt.stopPropagation();
            evt.preventDefault();
            // var pind = $(this).prop('name');
            $(document.getElementById(del.plus + pind + '_' + index)).hide();
            $(document.getElementById(del.minus + pind + '_' + index)).hide();
            addMultipleDelivi({
                pind: pind,
                index: index
            });
        });
    }
    ;

    function addPCCrements() {
        var flag = false;
        var part = [];
        /* Project Task Name */
        if (PCC.add.prdtask.prjmid != 0) {
            flag = true;
            $('#' + PCC.add.prdtask.QRT_msg).html(VALIDNOT);
        } else {
            flag = false;
            $('#' + PCC.add.prdtask.QRT_msg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#' + PCC.add.prdtask.QRT_msg).offset().top) - 95
            }, 'slow');
            $('#' + PCC.add.prdtask.Qrequi_type).focus();
            return;
        }
        /* PCC Name */
        if ($(PCC.add.pccn).val().match(name_reg)) {
            flag = true;
            $(PCC.add.pccnmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pccnmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pccnmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccn).focus();
            return;
        }
        /* Location */
        if ($(PCC.add.pccl).val().match(name_reg)) {
            flag = true;
            $(PCC.add.pcclmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pcclmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pcclmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccl).focus();
            return;
        }
        /* Code */
        if ($(PCC.add.pccc).val().match(name_reg)) {
            flag = true;
            $(PCC.add.pcccmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pcccmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pcccmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccl).focus();
            return;
        }
        /* Frame configuration */
        if ($(PCC.add.pccfc).val().match(name_reg)) {
            flag = true;
            $(PCC.add.pccfcmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pccfcmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pccfcmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccfc).focus();
            return;
        }
        /* Work station height */
        if ($(PCC.add.pccwh).val().match(ind_reg)) {
            flag = true;
            $(PCC.add.pccwhmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pccwhmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pccwhmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccwh).focus();
            return;
        }
        /* Total Work stations */
        if ($(PCC.add.pcctw).val().match(ind_reg)) {
            flag = true;
            $(PCC.add.pcctwmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pcctwmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pcctwmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pcctw).focus();
            return;
        }
        /* Revision */
        if ($(PCC.add.pccrv).val().match(ind_reg)) {
            flag = true;
            $(PCC.add.pccrvmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pccrvmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pccrvmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccrv).focus();
            return;
        }
        /* Wood start date */
        if ($(PCC.add.pccsdw).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(PCC.add.pccsdwmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pccsdwmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pccsdwmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccsdw).focus();
            return;
        }
        /* Metal start date */
        if ($(PCC.add.pccsdm).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(PCC.add.pccsdmmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pccsdmmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pccsdmmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccsdm).focus();
            return;
        }
        /* Dispatch date */
        if ($(PCC.add.pccdd).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(PCC.add.pccddmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(PCC.add.pccddmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(PCC.add.pccddmsg).offset().top) - 95
            }, 'slow');
            $(PCC.add.pccdd).focus();
            return;
        }
        /* PCC Task Descp */
        if (particulars.length > 0) {
            for (i = 0; i < particulars.length; i++) {
                var par = particulars[i];
                if ($(document.getElementById(par.bankname)).val().length > 0) {
                    flag = true;
                    $(document.getElementById(par.nmsg)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(par.nmsg)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(par.nmsg)).offset().top) - 95
                    }, 'slow');
                    $(document.getElementById(par.bankname)).focus();
                    return;
                }
                if (flag) {
                    part.push({
                        parti: $(document.getElementById(par.bankname)).val(),
                        deliinst: []
                    });
                }
                /* Supply / Installation */
                if (par.deliinstarr.length > -1) {
                    for (j = 0; j < par.deliinstarr.length; j++) {
                        var del = par.deliinstarr[j];
                        if ($(document.getElementById(del.bankname)).val().match(ind_reg)) {
                            flag = true;
                            $(document.getElementById(del.nmsg)).html(VALIDNOT);
                        } else {
                            flag = false;
                            $(document.getElementById(del.nmsg)).html(INVALIDNOT);
                            $('html, body').animate({
                                scrollTop: Number($(document.getElementById(del.nmsg)).offset().top) - 95
                            }, 'slow');
                            $(document.getElementById(del.bankname)).focus();
                            return;
                        }
                        if ($(document.getElementById(del.accno)).val().match(name_reg)) {
                            flag = true;
                            $(document.getElementById(del.nomsg)).html(VALIDNOT);
                        } else {
                            flag = false;
                            $(document.getElementById(del.nomsg)).html(INVALIDNOT);
                            $('html, body').animate({
                                scrollTop: Number($(document.getElementById(del.nomsg)).offset().top) - 95
                            }, 'slow');
                            $(document.getElementById(del.accno)).focus();
                            return;
                        }
                        if ($(document.getElementById(del.braname)).val().match(ind_reg)) {
                            flag = true;
                            $(document.getElementById(del.bnmsg)).html(VALIDNOT);
                        } else {
                            flag = false;
                            $(document.getElementById(del.bnmsg)).html(INVALIDNOT);
                            $('html, body').animate({
                                scrollTop: Number($(document.getElementById(del.bnmsg)).offset().top) - 95
                            }, 'slow');
                            $(document.getElementById(del.braname)).focus();
                            return;
                        }
                        if ($(document.getElementById(del.bracode)).val().match(name_reg)) {
                            flag = true;
                            $(document.getElementById(del.bcmsg)).html(VALIDNOT);
                        } else {
                            flag = false;
                            $(document.getElementById(del.bcmsg)).html(INVALIDNOT);
                            $('html, body').animate({
                                scrollTop: Number($(document.getElementById(del.bcmsg)).offset().top) - 95
                            }, 'slow');
                            $(document.getElementById(del.bracode)).focus();
                            return;
                        }
                        if (flag) {
                            part[i].deliinst.push({
                                size: $(document.getElementById(del.bankname)).val(),
                                colour: $(document.getElementById(del.accno)).val(),
                                qty: $(document.getElementById(del.braname)).val(),
                                remark: $(document.getElementById(del.bracode)).val()
                            });
                        }
                    }
                }
            }
        }
        var attr = {
            pname: $.trim(PCC.add.prdtask.pname),
            prjname: $.trim($('#' + PCC.add.prdtask.Qrequi_type + ' option:selected').text()),
            prjmid: PCC.add.prdtask.prjmid,
            prjid: PCC.add.prdtask.prjid,
            requi_id: PCC.add.prdtask.requi_id,
            quot_id: PCC.add.prdtask.quot_id,
            po_id: PCC.add.prdtask.po_id,
            inv_id: PCC.add.prdtask.inv_id,
            client_id: PCC.add.prdtask.client_id,
            ethno_id: PCC.add.prdtask.ethno_id,
            ind: PCC.add.prdtask.ind,
            rep_id: PCC.add.prdtask.rep_id,
            ref_no: PCC.add.prdtask.ref_no,
            ethno: PCC.add.prdtask.ethno,
            rep: PCC.add.prdtask.rep,
            doethn: $(PCC.add.prdtask.doethno).val(),
            artype: PCC.add.prdtask.artype,
            taskid: $('#' + PCC.add.prdtask.Qrequi_type).val(),
            pccn: $(PCC.add.pccn).val(),
            pccl: $(PCC.add.pccl).val(),
            pccc: $(PCC.add.pccc).val(),
            pccfc: $(PCC.add.pccfc).val(),
            pccwh: $(PCC.add.pccwh).val(),
            pcctw: $(PCC.add.pcctw).val(),
            pccrv: $(PCC.add.pccrv).val(),
            pccsdw: $(PCC.add.pccsdw).val(),
            pccsdm: $(PCC.add.pccsdm).val(),
            pccdd: $(PCC.add.pccdd).val(),
            taskdescp: part
        };
        console.log(attr);
        if (flag) {
            $(PCC.add.but).prop('disabled', 'disabled');
            $(PCC.msgDiv).html('');
            $.ajax({
                url: PCC.add.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'addPCC',
                    pcc: attr
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
                            $(PCC.msgDiv).html('<h2>PCC added to database</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(PCC.msgDiv).offset().top) - 95
                            }, 'slow');
                            break;
                    }
                },
                error: function () {
                    $(PCC.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $(PCC.add.but).removeAttr('disabled');
                }
            });
        } else {
            $(PCC.add.but).removeAttr('disabled');
        }
    }
    ;

    function listDoc() {
        $(list.listDiv).html(LOADER_FIV);
        var htm = '';
        $.ajax({
            url: list.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: list.action,
                display: list.display,
                what: list.what
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
                        var lists = $.parseJSON(data);
                        if (lists != null) {
                            for (i = 0; i < lists.length; i++) {
                                htm += lists[i].html;
                            }
                        }
                        var header = '<div class="col-md-12">' +
                                '<div class="panel panel-default">' +
                                '<div class="panel-heading">  List of Production Control Chart </div>' +
                                '<div class="panel-body">' +
                                '<table class="table table-striped table-bordered table-hover dataTable no-footer" id="list_what_' + list.what + '">' +
                                '<thead><tr><th>#</th><th>Name</th><th>Date</th><th>Location</th></tr></thead>' +
                                '<tbody>';
                        var footer = '</tbody></table></div></div></div>';
                        $(list.listDiv).html(header + htm + footer);
                        window.setTimeout(function () {
                            $('#list_what_' + list.what).dataTable();
                        }, 300);
                        break;
                }
            },
            error: function () {
                $(PCC.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
}