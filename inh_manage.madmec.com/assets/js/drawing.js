function DrawingCtrl() {
    var CPO = {};
    var listofrequi = {};
    var listofdesin = {};
    var requi = {};
    this.__construct = function (cpoctrl) {
        CPO = cpoctrl;
        requi = CPO.cpo.require;
        list = CPO.list;
        $(CPO.msgDiv).html('');
        /* Requirement */
//			fetchRequirement();
        fetchDesigner();
        CPO.cpo.require.prjmid = 0;
        CPO.cpo.require.requi_id = 0;
        CPO.cpo.require.prjdesc_id = 0;
        CPO.cpo.require.ref_no = '';
        CPO.cpo.require.quot_id = 0;
        CPO.cpo.require.po_id = 0;
        CPO.cpo.require.inv_id = 0;
        CPO.cpo.require.client_id = 0;
        CPO.cpo.require.ethno_id = 0;
        CPO.cpo.require.rep_id = 0;
        CPO.cpo.require.ethno = '';
        CPO.cpo.require.rep = '';
        CPO.cpo.require.doethno = '';
        CPO.cpo.require.ind = 0;
        CPO.cpo.require.artype = '';
        $(CPO.cpo.submit).click(function (evt) {
            evt.stopPropagation();
            evt.preventDefault();
            uploadCPO();
        });
        $(CPO.list.menuBut).click(function () {
            listDoc();
        });
        $(CPO.cpo.doi).datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true
        });
        $(CPO.cpo.refno + ',' + CPO.cpo.doi + ',' + CPO.cpo.file).val('');
        fetchPCCrement();
    };
    function fetchDesigner()
    {
        $(CPO.cpo.desin).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: CPO.url,
            data: {
                autoloader: true,
                action: 'fetchDesigner'
            },
            success: function (data, extStatus, xhr) {
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
                        listofdesig = $.parseJSON($.trim(data));
                        $(CPO.cpo.desin).html('<select class="form-control" id="' + CPO.cpo.des_type + '"><option value="">Select Designer/Employee</option>' + listofdesig + '</select><p class="help-block" id="' + CPO.cpo.des_msg + '">Enter / Select</p>');
                        break;
                }
            },
            error: function () {
                $(CPO.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function fetchPCCrement() {
        var htm = '';
        $.ajax({
            type: 'POST',
            url: requi.url,
            data: {
                autoloader: true,
                action: 'fetchRequirement'
            },
            success: function (data, extStatus, xhr) {
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
                        if (listofrequi != null) {
                            for (i = 0; i < listofrequi.length; i++) {
                                htm += listofrequi[i]["html"];
                            }
                            $(requi.TVQtype).html('<select class="form-control" id="' + requi.Qrequi_type + '"><option value="NULL" selected>Select Project</option>' + htm + '</select><p class="help-block" id="' + requi.QRT_msg + '">Enter / Select</p>');
                            $('#' + requi.Qrequi_type).change({para: CPO.cpo,
                                requi: listofrequi,
                                len: listofrequi.length
                            }, function (evt) {
                                var para = evt.data.para;
                                var requi = evt.data.requi;
                                var len = evt.data.len;
                                for (i = 0; i < len; i++) {
                                    if (requi[i]["req_id"] == $(this).select().val()) {
                                        para.require.prjmid = requi[i]["id"];
                                        para.require.requi_id = requi[i]["req_id"];
                                        para.require.ref_no = requi[i]["ref_no"];
                                        para.require.quot_id = requi[i]["quot_id"];
                                        para.require.po_id = requi[i]["po_id"];
                                        para.require.inv_id = requi[i]["inv_id"];
                                        para.require.client_id = requi[i]["client_id"];
                                        para.require.ethno_id = requi[i]["ethno_id"];
                                        para.require.rep_id = requi[i]["rep_id"];
                                        para.require.ethno = requi[i]["ethno"];
                                        para.require.rep = requi[i]["rep"];
                                        para.require.doethno = requi[i]["doethno"];
                                        para.require.ind = i;
                                        para.require.artype = requi[i]["artype"];
                                        para.require.prjdesc_id = requi[i]["task_descp"]["id"];
                                        break;
                                    }
                                }
                            });
                        }
                        break;
                }
            },
            error: function () {
                $(CPO.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function uploadCPO() {
        var flag = false;
        /* Requirement */
        if ($('#' + CPO.cpo.des_type).val() == "")
        {
            flag = false;
            $('#' + CPO.cpo.des_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($('#' + CPO.cpo.des_msg).offset().top) - 95}, 'slow');
            $('#' + CPO.cpo.des_type).focus();
            return;
        }
        else
        {
            flag = true;
            $('#' + CPO.cpo.des_msg).html(VALIDNOT);
        }
        if (CPO.cpo.require.prjmid != 0) {
            flag = true;
            $('#' + CPO.cpo.require.QRT_msg).html(VALIDNOT);
        } else {
            flag = false;
            $('#' + CPO.cpo.require.QRT_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($('#' + CPO.cpo.require.QRT_msg).offset().top) - 95}, 'slow');
            $('#' + CPO.cpo.require.Qrequi_type).focus();
            return;
        }
        if (CPO.cpo.require.ref_no != '' || CPO.cpo.require.ethno != '' || CPO.cpo.require.rep != '' ||
                !$(CPO.cpo.require.doethno).val().match(/(\d{4})-(\d{2})-(\d{2})/) || CPO.cpo.require.artype != '') {
            flag = true;
            $('#' + CPO.cpo.require.QRT_msg).html(VALIDNOT);
        } else {
            flag = false;
            $('#' + CPO.cpo.require.QRT_msg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($('#' + CPO.cpo.require.QRT_msg).offset().top) - 95}, 'slow');
            $('#' + CPO.cpo.require.Qrequi_type).focus();
            return;
        }
        /*  Drawing Name  */
        var draname = $.trim($(CPO.cpo.refno).val());
        if (!draname == "")
        {
            flag = true;
            $(CPO.cpo.refnomsg).html(VALIDNOT);
        } else {
            flag = false;
            $(CPO.cpo.refnomsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(CPO.cpo.refnomsg).offset().top) - 95}, 'slow');
            $(CPO.cpo.refno).focus();
            return;
        }
        /* Date of Issue */
        if ($(CPO.cpo.doi).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
            flag = true;
            $(CPO.cpo.doimsg).html(VALIDNOT);
        } else {
            flag = false;
            $(CPO.cpo.doimsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(CPO.cpo.doimsg).offset().top) - 95}, 'slow');
            $(CPO.cpo.doi).focus();
            return;
        }

        /* File selected */
        if ($(CPO.cpo.file).val().length) {
            flag = true;
            $(CPO.cpo.filemsg).html(VALIDNOT);
        } else {
            flag = false;
            $(CPO.cpo.filemsg).html(INVALIDNOT);
            $('html, body').animate({scrollTop: Number($(CPO.cpo.filemsg).offset().top) - 95}, 'slow');
            $(CPO.cpo.file).focus();
            return;
        }
        if (flag) {
            var options = {
                url: CPO.cpo.url,
                type: 'POST',
                dataType: 'json',
                clearForm: true,
                resetForm: true,
                target: CPO.cpo.status,
                data: {autoloader: true,
                    action: 'uploadDrawing',
                    prjname: $.trim($('#' + CPO.cpo.require.Qrequi_type + ' option:selected').text()),
                    prjmid: CPO.cpo.require.prjmid,
                    requi_id: CPO.cpo.require.requi_id,
                    designerid: $('#' + CPO.cpo.des_type).val(),
                    quot_id: CPO.cpo.require.quot_id,
                    po_id: CPO.cpo.require.po_id,
                    inv_id: CPO.cpo.require.inv_id,
                    client_id: CPO.cpo.require.client_id,
                    ethno_id: CPO.cpo.require.ethno_id,
                    ind: CPO.cpo.require.ind,
                    rep_id: CPO.cpo.require.rep_id,
                    ref_no: CPO.cpo.require.ref_no,
                    ethno: CPO.cpo.require.ethno,
                    rep: CPO.cpo.require.rep,
                    doethn: $(CPO.cpo.require.doethno).val(),
                    artype: CPO.cpo.require.artype,
                    refno: $(CPO.cpo.refno).val(),
                    doi: $(CPO.cpo.doi).val(),
                    projdescid: CPO.cpo.require.prjdesc_id

                },
                beforeSubmit: function () {
                    $(CPO.cpo.status).empty();
                    $(CPO.cpo.bar).width(CPO.cpo.percentVal)
                    $(CPO.cpo.percent).html(CPO.cpo.percentVal)
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    CPO.cpo.percentVal = percentComplete + '%';
                    $(CPO.cpo.bar).width(CPO.cpo.percentVal)
                    $(CPO.cpo.percent).html(CPO.cpo.percentVal);
                },
                success: function (json, statusText, xhr, $form) {
                    CPO.cpo.percentVal = '100%';
                    $(CPO.cpo.bar).width(CPO.cpo.percentVal)
                    $(CPO.cpo.percent).html(CPO.cpo.percentVal);
                    $(CPO.cpo.status).html(json.msg);
                },
                complete: function (xhr) {
                    var percentVal = '0%';
                    if (xhr.responseText.length == 0) {
                        $(CPO.cpo.bar).width(percentVal);
                        $(CPO.cpo.percent).html(percentVal);
                    }
                },
                error: function (xhr) {
                    $(CPO.cpo.status).html(xhr.responseText);
                    $(CPO.cpo.status).append('<br />Some thing went wrong');
                }
            };
            $(CPO.cpo.formid).ajaxSubmit(options);
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
                                '<div class="panel-heading">  List of Drawings </div>' +
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
                $(CPO.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

}
