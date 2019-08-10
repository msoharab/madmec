	function invoiceController() {
	    var Quot = {};
	    var listofrequi = [];
	    var requi = {};
	    var list = {};
	    this.__construct = function(qutctrl) {
	        Quot = qutctrl;
	        requi = Quot.add.require;
	        $(Quot.msgDiv).html('');
	        $(Quot.add.ptotal + ',' + Quot.add.stc1 + ',' + Quot.add.ecess1 + ',' + Quot.add.hecess1 + ',' + Quot.add.nptot + ',' + Quot.add.totins + ',' + Quot.add.stc2 + ',' + Quot.add.ecess2 + ',' + Quot.add.hecess2 + ',' + Quot.add.ninstot + ',' + Quot.add.totsup + ',' + Quot.add.totsup + ',' + Quot.add.vat + ',' + Quot.add.nsuptot).val(0);
	        Quot.add.require.prjmid = 0;
	        Quot.add.require.requi_id = 0;
	        Quot.add.require.ref_no = '';
	        Quot.add.require.quot_id = 0;
	        Quot.add.require.po_id = 0;
	        Quot.add.require.inv_id = 0;
	        Quot.add.require.client_id = 0;
	        Quot.add.require.ethno_id = 0;
	        Quot.add.require.rep_id = 0;
	        Quot.add.require.ethno = '';
	        Quot.add.require.rep = '';
	        Quot.add.require.doethno = '';
	        Quot.add.require.ind = 0;
	        Quot.add.require.artype = '';
	        list = Quot.list;
	        $(Quot.add.xlsbut).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            generateInvoice();
	        });
	        $(Quot.add.stc1 + ',' + Quot.add.ecess1 + ',' + Quot.add.hecess1 + ',' +
	            Quot.add.stc2 + ',' + Quot.add.ecess2 + ',' + Quot.add.hecess2 + ',' +
	            Quot.add.vat).on('keyup', function() {
	            calcQout();
	        });
	        $(list.menuBut).click(function() {
	            listDoc();
	        });
	        /* Requirement */
	        fetchRequirement();
	        /* Transporter */
	        fetchUsers({
	            type: [10],
	            para1: {
	                ob: Quot.add,
	                parentDiv: Quot.add.trans,
	                id: Quot.add.trans_type,
	                msg: Quot.add.trans_msg,
	                text: 'Select Transporter'
	            }
	        });
	        /* Driver */
	        fetchUsers({
	            type: [11],
	            para1: {
	                ob: Quot.add,
	                parentDiv: Quot.add.driv,
	                id: Quot.add.driv_type,
	                msg: Quot.add.driv_msg,
	                text: 'Select Driver'
	            }
	        });
	        fetchModeOfTransport();
	    };

	    function fetchModeOfTransport() {
	        var htm = '';
	        $(Quot.add.mot).html('');
	        $.ajax({
	            type: 'POST',
	            url: Quot.add.url,
	            data: {
	                autoloader: true,
	                action: 'fetchModeOfTransport'
	            },
	            success: function(data, textStatus, xhr) {
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
	                        if (type != null) {
	                            usertypes = type;
	                            for (i = 0; i < type.length; i++) {
	                                htm += type[i]["html"];
	                            }
	                            $(Quot.add.mot).html('<select class="form-control" id="' + Quot.add.mot_type + '"><option value="NULL" selected>Select Mode Transport</option>' + htm + '</select><p class="help-block" id="' + Quot.add.mot_msg + '">Enter / Select</p>');
	                            window.setTimeout(function() {
	                                $('#' + Quot.add.mot_type).change(function() {
	                                    var id = $(this).select().val();
	                                    if (id != 'NULL') {
	                                        Quot.add.motid = id;
	                                        return;
	                                    }
	                                });
	                            }, 300);
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(Quot.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    };

	    function fetchUsers(obj) {
	        var htm = '';
	        var htm1 = '';
	        var list = {};
	        $(obj.para1.parentDiv).html('');
	        $.ajax({
	            type: 'POST',
	            url: obj.para1.ob.url,
	            data: {
	                autoloader: true,
	                action: 'fetchUsers',
	                utyp: obj.type
	            },
	            success: function(data, textStatus, xhr) {
	                switch (data) {
	                    case 'logout':
	                        logoutAdmin({});
	                        break;
	                    case 'login':
	                        loginAdmin({});
	                        break;
	                    default:
	                        list = $.parseJSON($.trim(data));
	                        if (list != null) {
	                            for (i = 0; i < list.length; i++) {
	                                htm += list[i]["html"];
	                            }
	                            $(obj.para1.parentDiv).html('<select class="form-control" id="' + obj.para1.id + '"><option value="NULL" selected>' + obj.para1.text + '</option>' + htm + '</select><p class="help-block" id="' + obj.para1.msg + '">Enter / Select</p>');
	                            window.setTimeout(function() {
	                                $('#' + obj.para1.id).change(function() {
	                                    var id = $(this).select().val();
	                                    if (id != 'NULL') {
	                                        switch (obj.para1.text) {
	                                            case 'Select Transporter':
	                                                obj.para1.ob.transid = id;
	                                                break;
	                                            case 'Select Driver':
	                                                obj.para1.ob.drivid = id;
	                                                break;
	                                        }
	                                    }
	                                });
	                            }, 300);
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(obj.para1.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    };

	    function calcQout() {
	        /* Paint */
	        var stc1 = Number($(Quot.add.stc1).val()) < 0 ? 0 : Number($(Quot.add.stc1).val());
	        var ecess1 = Number($(Quot.add.ecess1).val()) < 0 ? 0 : Number($(Quot.add.ecess1).val());
	        var hecess1 = Number($(Quot.add.hecess1).val()) < 0 ? 0 : Number($(Quot.add.hecess1).val());
	        /* Installation */
	        var stc2 = Number($(Quot.add.stc2).val()) < 0 ? 0 : Number($(Quot.add.stc2).val());
	        var ecess2 = Number($(Quot.add.ecess2).val()) < 0 ? 0 : Number($(Quot.add.ecess2).val());
	        var hecess2 = Number($(Quot.add.hecess2).val()) < 0 ? 0 : Number($(Quot.add.hecess2).val());
	        /* Supply */
	        var vat = Number($(Quot.add.vat).val()) < 0 ? 0 : Number($(Quot.add.vat).val());
	        /* Paint */
	        var ptotal = Number($(Quot.add.ptotal).val()) < 0 ? 0 : Number($(Quot.add.ptotal).val());
	        /* Installation */
	        var totins = Number($(Quot.add.totins).val()) < 0 ? 0 : Number($(Quot.add.totins).val());
	        /* Supply */
	        var totsup = Number($(Quot.add.totsup).val()) < 0 ? 0 : Number($(Quot.add.totsup).val());
	        /* Paint */
	        var nptot = Number($(Quot.add.nptot).val()) < 0 ? 0 : Number($(Quot.add.nptot).val());
	        /* Installation */
	        var ninstot = Number($(Quot.add.ninstot).val()) < 0 ? 0 : Number($(Quot.add.ninstot).val());
	        /* Supply */
	        var nsuptot = Number($(Quot.add.nsuptot).val()) < 0 ? 0 : Number($(Quot.add.nsuptot).val());
	        /* Grand total */
	        var qgtot = Number($(Quot.add.qgtot).val()) < 0 ? 0 : Number($(Quot.add.qgtot).val());
	        /* Paint */
	        nptot = Number(ptotal + stc1 + ecess1 + hecess1);
	        /* Installation */
	        ninstot = Number(totins + stc2 + ecess2 + hecess2);
	        /* Supply */
	        nsuptot = Number(totsup + vat);
	        $(Quot.add.stc1).val(stc1);
	        $(Quot.add.ecess1).val(ecess1);
	        $(Quot.add.hecess1).val(hecess1);
	        $(Quot.add.stc2).val(stc2);
	        $(Quot.add.ecess2).val(ecess2);
	        $(Quot.add.hecess2).val(hecess2);
	        $(Quot.add.vat).val(vat);
	        /* Paint */
	        $(Quot.add.nptot).val(nptot);
	        /* Installation */
	        $(Quot.add.ninstot).val(ninstot);
	        /* Supply */
	        $(Quot.add.nsuptot).val(nsuptot);
	        /* Grand total */
	        $(Quot.add.qgtot).val(Number(nptot + ninstot + nsuptot));
	    };

	    function fetchRequirement() {
	        var htm = '';
	        $.ajax({
	            type: 'POST',
	            url: requi.url,
	            data: {
	                autoloader: true,
	                action: 'fetchRequirement'
	            },
	            success: function(data, textStatus, xhr) {
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
	                            $('#' + requi.Qrequi_type).change({
	                                para: Quot.add,
	                                requi: listofrequi,
	                                len: listofrequi.length
	                            }, function(evt) {
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
	                                        $(para.ptotal).val(Number(requi[i]["ptotal"]));
	                                        $(para.stc1).val(Number(requi[i]["stc1"]));
	                                        $(para.ecess1).val(Number(requi[i]["stc1_50_1236_2"]));
	                                        $(para.hecess1).val(Number(requi[i]["stc1_50_1236_1"]));
	                                        $(para.nptot).val(Number(requi[i]["pntotal"]));
	                                        $(para.totins).val(Number(requi[i]["totinst"]));
	                                        $(para.stc2).val(Number(requi[i]["stc2"]));
	                                        $(para.ecess2).val(Number(requi[i]["stc2_50_1236_2"]));
	                                        $(para.hecess2).val(Number(requi[i]["stc2_50_1236_1"]));
	                                        $(para.ninstot).val(Number(requi[i]["ntotinst"]));
	                                        $(para.totsup).val(Number(requi[i]["totsup"]));
	                                        $(para.vat).val(Number(requi[i]["vat"]));
	                                        $(para.nsuptot).val(Number(requi[i]["ntotsup"]));
	                                        $(para.qgtot).val(Number(requi[i]["nettotal"]));
	                                        break;
	                                    }
	                                }
	                            });
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(Quot.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    };

	    function generateInvoice() {
	        var flag = false;
	        /* Requirement */
	        if (Quot.add.require.prjmid != 0) {
	            flag = true;
	            $('#' + Quot.add.require.QRT_msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $('#' + Quot.add.require.QRT_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($('#' + Quot.add.require.QRT_msg).offset().top) - 95
	            }, 'slow');
	            $('#' + Quot.add.require.Qrequi_type).focus();
	            return;
	        }
	        if (Quot.add.require.ref_no != '' || Quot.add.require.ethno != '' || Quot.add.require.rep != '' ||
	            !$(Quot.add.require.doethno).val().match(/(\d{4})-(\d{2})-(\d{2})/) || Quot.add.require.artype != '') {
	            flag = true;
	            $('#' + Quot.add.require.QRT_msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $('#' + Quot.add.require.QRT_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($('#' + Quot.add.require.QRT_msg).offset().top) - 95
	            }, 'slow');
	            $('#' + Quot.add.require.Qrequi_type).focus();
	            return;
	        }
	        /* Transporter */
	        if (Quot.add.transid != 0) {
	            flag = true;
	            $('#' + Quot.add.trans_msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $('#' + Quot.add.trans_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($('#' + Quot.add.trans_msg).offset().top) - 95
	            }, 'slow');
	            $('#' + Quot.add.trans_type).focus();
	            return;
	        }
	        /* Driver */
	        if (Quot.add.drivid != 0) {
	            flag = true;
	            $('#' + Quot.add.driv_msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $('#' + Quot.add.driv_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($('#' + Quot.add.driv_msg).offset().top) - 95
	            }, 'slow');
	            $('#' + Quot.add.driv_type).focus();
	            return;
	        }
	        /* Vehicle No */
	        if ($(Quot.add.vhno).val().length < 101) {
	            flag = true;
	            $(Quot.add.vhnomsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.vhnomsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.vhnomsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.vhno).focus();
	            return;
	        }
	        /* LR No */
	        if ($(Quot.add.lrno).val().length < 101) {
	            flag = true;
	            $(Quot.add.lrnomsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.lrnomsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.lrnomsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.lrno).focus();
	            return;
	        }
	        /* Mode Of Transport */
	        if (Quot.add.motid != 0) {
	            flag = true;
	            $('#' + Quot.add.mot_msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $('#' + Quot.add.mot_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($('#' + Quot.add.mot_msg).offset().top) - 95
	            }, 'slow');
	            $('#' + Quot.add.mot_type).focus();
	            return;
	        }
	        /* Place */
	        if ($(Quot.add.dlepla).val().length < 101) {
	            flag = true;
	            $(Quot.add.dleplamsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.dleplamsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.dleplamsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.dlepla).focus();
	            return;
	        }
	        /* Subject */
	        if ($(Quot.add.sub).val().length < 501) {
	            flag = true;
	            $(Quot.add.submsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.submsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.submsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.sub).focus();
	            return;
	        }
	        /* Description */
	        if ($(Quot.add.qdesc).val().length < 1001) {
	            flag = true;
	            $(Quot.add.qdescmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.qdescmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.qdescmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.qdesc).focus();
	            return;
	        }
	        /* Painting total */
	        if ($(Quot.add.ptotal).val().length > -1) {
	            flag = true;
	            $(Quot.add.ptotalmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.ptotalmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.ptotalmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.ptotal).focus();
	            return;
	        }
	        /* Painting stc */
	        if ($(Quot.add.stc1).val().length > -1) {
	            flag = true;
	            $(Quot.add.stc1msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.stc1msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.stc1msg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.stc1).focus();
	            return;
	        }
	        /* Painting ecess */
	        if ($(Quot.add.ecess1).val().length > -1) {
	            flag = true;
	            $(Quot.add.ecess1msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.ecess1msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.ecess1msg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.ecess1).focus();
	            return;
	        }
	        /* Painting hecess */
	        if ($(Quot.add.hecess1).val().length > -1) {
	            flag = true;
	            $(Quot.add.hecess1msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.hecess1msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.hecess1msg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.hecess1).focus();
	            return;
	        }
	        /* Painting ntotal */
	        if ($(Quot.add.nptot).val().length > -1) {
	            flag = true;
	            $(Quot.add.nptotmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.nptotmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.nptotmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.nptot).focus();
	            return;
	        }
	        /* Installation total */
	        if ($(Quot.add.totins).val().length > -1) {
	            flag = true;
	            $(Quot.add.totinsmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.totinsmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.totinsmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.totins).focus();
	            return;
	        }
	        /* Installation stc */
	        if ($(Quot.add.stc2).val().length > -1) {
	            flag = true;
	            $(Quot.add.stc2msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.stc2msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.stc2msg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.stc2).focus();
	            return;
	        }
	        /* Installation ecess */
	        if ($(Quot.add.ecess2).val().length > -1) {
	            flag = true;
	            $(Quot.add.ecess2msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.ecess2msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.ecess2msg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.ecess2).focus();
	            return;
	        }
	        /* Installation hecess */
	        if ($(Quot.add.hecess2).val().length > -1) {
	            flag = true;
	            $(Quot.add.hecess2msg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.hecess2msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.hecess2msg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.hecess2).focus();
	            return;
	        }
	        /* Installation ntotal */
	        if ($(Quot.add.ninstot).val().length > -1) {
	            flag = true;
	            $(Quot.add.ninstotmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.ninstotmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.ninstotmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.ninstot).focus();
	            return;
	        }
	        /* Supply total */
	        if ($(Quot.add.totsup).val().length > -1) {
	            flag = true;
	            $(Quot.add.totsupmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.totsupmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.totsupmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.totsup).focus();
	            return;
	        }
	        /* Supply vat */
	        if ($(Quot.add.vat).val().length > -1) {
	            flag = true;
	            $(Quot.add.vatmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.vatmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.vatmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.vat).focus();
	            return;
	        }
	        /* Supply ntotal */
	        if ($(Quot.add.nsuptot).val().length > -1) {
	            flag = true;
	            $(Quot.add.nsuptotmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.nsuptotmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.nsuptotmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.nsuptot).focus();
	            return;
	        }
	        /* Grand total */
	        if ($(Quot.add.qgtot).val().length > -1) {
	            flag = true;
	            $(Quot.add.qgtotmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(Quot.add.qgtotmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(Quot.add.qgtotmsg).offset().top) - 95
	            }, 'slow');
	            $(Quot.add.qgtot).focus();
	            return;
	        }
	        if (flag) {
	            var attr = {
	                prjname: $.trim($('#' + Quot.add.require.Qrequi_type + ' option:selected').text()),
	                prjmid: Quot.add.require.prjmid,
	                requi_id: Quot.add.require.requi_id,
	                quot_id: Quot.add.require.quot_id,
	                po_id: Quot.add.require.po_id,
	                inv_id: Quot.add.require.inv_id,
	                client_id: Quot.add.require.client_id,
	                ethno_id: Quot.add.require.ethno_id,
	                ind: Quot.add.require.ind,
	                rep_id: Quot.add.require.rep_id,
	                ref_no: Quot.add.require.ref_no,
	                ethno: Quot.add.require.ethno,
	                rep: Quot.add.require.rep,
	                doethn: Quot.add.require.doethn,
	                artype: Quot.add.require.artype,
	                transid: Quot.add.transid,
	                drivid: Quot.add.drivid,
	                vhno: $(Quot.add.vhno).val(),
	                lrno: $(Quot.add.lrno).val(),
	                motid: Quot.add.motid,
	                dlepla: $(Quot.add.dlepla).val(),
	                sub: $(Quot.add.sub).val(),
	                qdesc: $(Quot.add.qdesc).val(),
	                ptotal: $(Quot.add.ptotal).val(),
	                stc1: $(Quot.add.stc1).val(),
	                ecess1: $(Quot.add.ecess1).val(),
	                hecess1: $(Quot.add.hecess1).val(),
	                nptot: $(Quot.add.nptot).val(),
	                totins: $(Quot.add.totins).val(),
	                stc2: $(Quot.add.stc2).val(),
	                ecess2: $(Quot.add.ecess2).val(),
	                hecess2: $(Quot.add.hecess2).val(),
	                ninstot: $(Quot.add.ninstot).val(),
	                totsup: $(Quot.add.totsup).val(),
	                vat: $(Quot.add.vat).val(),
	                nsuptot: $(Quot.add.nsuptot).val(),
	                qgtot: $(Quot.add.qgtot).val()
	            };
	            $.ajax({
	                type: 'POST',
	                url: Quot.add.url,
	                data: {
	                    autoloader: true,
	                    action: 'generateInvoice',
	                    inv: attr
	                },
	                success: function(data, textStatus, xhr) {
	                    requi = $.trim(data);
	                    console.log(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                         $(Quot.msgDiv).html('<h2>Invoice generated successfully</h2>');
	                            $('html, body').animate({
	                                scrollTop: Number($(Quot.msgDiv).offset().top) - 95
	                            }, 'slow');
	                            break;
	                    }
	                },
	                error: function() {
	                    $(Requi.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        }
	    };

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
	            success: function(data, textStatus, xhr) {
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
	                            '<div class="panel panel-primary">' +
	                            '<div class="panel-heading">  List of ' + list.what + ' </div>' +
	                            '<div class="panel-body">' +
	                            '<table class="table table-striped table-bordered table-hover dataTable no-footer" id="list_what_' + list.what + '">' +
	                            '<thead><tr><th>#</th><th>Name</th><th>Date</th><th>Location</th></tr></thead>' +
	                            '<tbody>';
	                        var footer = '</tbody></table></div></div></div>';
	                        $(list.listDiv).html(header + htm + footer);
	                        window.setTimeout(function() {
	                            $('#list_what_' + list.what).dataTable();
	                        }, 300);
	                        break;
	                }
	            },
	            error: function() {
	                $(Quot.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    }
	}
