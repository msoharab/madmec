function controlCustomeList() {
    var ltct = {};
    var gymid = $(DGYM_ID).attr("name");
    this.__construct = function (list) {
        ltct = list;
        initializcList();
    };
    this.listeditcust = function (editdata) {
        window.setTimeout(function () {
            $(".picedit_box").picEdit({
                imageUpdated: function (img) {
                },
                formSubmitted: function (data) {
                    var para = {
                        m_uid: editdata.master_pk,
                        uid: editdata.cust_id,
                    };
                    alert("Pic has been Successfully Changed");
                    $("#photoCancel_" + editdata.cust_id).click();
                    initializcList();
                },
                redirectUrl: false,
                defaultImage: URL + ASSET_IMG + 'No_image.png',
            });
        }, 1500);
        $(editdata.custdob).datepicker({
            dateFormat: 'dd-M-yy',
            yearRange: '-100 : +100',
            maxDate: 0,
            changeYear: true,
            changeMonth: true
        });
        $(editdata.custdoj).datepicker({
            dateFormat: 'dd-M-yy',
            yearRange: '-100 : +100',
            changeYear: true,
            changeMonth: true
        });
        $(editdata.custdoj).datepicker("setDate", new Date());
        $(editdata.custdob).datepicker("setDate", new Date());
        $(editdata.infoCloseBtn).bind('click', {
            cid: editdata.cust_id
        }, function (evt) {
            $(editdata.infoEditPanel).hide();
            $(editdata.infoEditBtn).show();
            $(editdata.infobody).show();
        });
        $(editdata.infoUpdateBtn).bind('click', {
            cid: editdata.cust_id,
            master_pk: editdata.master_pk,
            cunm: editdata.cname,
            cem: editdata.cemail,
            cce: editdata.ccell,
            cdb: editdata.cdob,
            cdj: editdata.cdoj,
            coc: editdata.cocc
        }, function (evt) {
            var custdata = {
                cname: $(evt.data.cunm).val(),
                cemail: $(evt.data.cem).val(),
                ccell: $(evt.data.cce).val(),
                cdob: convertDateFormat($(evt.data.cdb).val()),
                cdoj: convertDateFormat($(evt.data.cdj).val()),
                cocc: $(evt.data.coc).val(),
                cId: evt.data.cid,
                master_pk: evt.data.master_pk,
            };
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'editlistcustdata',
                    type: 'slave',
                    attr: custdata,
                    gymid: gymid
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(editdata.infoform).get(0).reset();
                            $(editdata.infoEditPanel).hide();
                            if (data.status)
                                $(editdata.infobody).html(data.htm);
                            $(editdata.infobody).show();
                            $(editdata.infoEditBtn).show();
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
        });
        $(editdata.backBtn).bind('click', {
            cid: editdata.cust_id,
            tabidd: editdata.tabId
        }, function (evt) {
            $(evt.data.tabidd).click();
        });
        $(editdata.infoEditBtn).bind('click', {
            cid: editdata.cust_id,
            master_pk: editdata.master_pk
        }, function (evt) {
            $(editdata.infobody).hide();
            $(editdata.infoEditBtn).hide();
            $(editdata.infoEditPanel).show();
        });
        var maintag = '<div class="col-lg-12">&nbsp;</div>';
        var oheader = '<table  class="table table-striped table-bordered table-hover" id="list_cust_offer_table">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="6" class="text-center"><font color="red">Offer Lists</font></th>' +
                '</tr>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Offer Name</th>' +
                '<th class="text-center">Duration</th>' +
                '<th class="text-center">Payment Date</th>' +
                '<th class="text-center">Starting Date</th>' +
                '<th class="text-center">Expriy Date</th>' +
                '</tr>' +
                '</thead>';
        var ofooter = '</table>';
        $(editdata.offerTab).html(maintag + oheader + editdata.offerData + ofooter);
        /*$(editdata.attendanceTab).html("hello");*/
        var pheader = '<table  class="table table-striped table-bordered table-hover" id="list_cust_Package_table">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="4" class="text-center"><font color="red">Package Lists</font></th>' +
                '</tr>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Package Name</th>' +
                '<th class="text-center">Number Of Session</th>' +
                '<th class="text-center">Payment Date</th>' +
                '</tr>' +
                '</thead>';
        var pfooter = '</table>';
        $(editdata.packageTab).html(maintag + pheader + editdata.packageData + pfooter);
        var theader = '<table  class="table table-striped table-bordered table-hover" id="list_cust_transaction_table">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="8" class="text-center"><font color="red">Transaction Lists</font></th>' +
                '</tr>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Name</th>' +
                '<th class="text-center">Invoice</th>' +
                '<th class="text-center">Payment Date</th>' +
                '<th class="text-center">Payment Mode</th>' +
                '<th class="text-center">Due Amount</th>' +
                '<th class="text-center">Due Date</th>' +
                '<th class="text-center">Due Status</th>' +
                '</tr>' +
                '</thead>';
        var tfooter = '</table>';
        $(editdata.transactionTab).html(maintag + theader + editdata.transnctionData + tfooter);
        window.setTimeout(function () {
            $('#list_cust_offer_table').dataTable({
                retrieve: true,
                destroy: true,
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                ],
                "autoWidth": true
            });
            $('#list_cust_Package_table').dataTable({
                retrieve: true,
                destroy: true,
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                ],
                "autoWidth": true
            });
            $('#list_cust_transaction_table').dataTable({
                retrieve: true,
                destroy: true,
                "aoColumns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                ],
                "autoWidth": true
            });
        }, 300);
    };
    this.listcusttabledata = function (listdata) {
        bindActions(listdata);
    };
    function bindActions(listdata) {
        if (typeof listdata.tableid != 'undefined') {
            window.setTimeout(function () {
                $(listdata.tableid).dataTable({
                    retrieve: true,
                    destroy: true,
                });
            }, 200);
        } else {
            $(listdata.delOkBtn).bind('click', {
                cid: listdata.cust_id,
                master_pk: listdata.master_pk
            }, function (evt) {
                var para = {
                    cid: evt.data.cid,
                    master_pk: evt.data.master_pk,
                };
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        autoloader: 'true',
                        action: 'custdel',
                        type: 'slave',
                        gymid: gymid,
                        cid: para
                    },
                    success: function (data) {
                        if (data == 'logout')
                            window.location.href = URL;
                        else {
                            $(listdata.tabId).click();
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        /*console.log(xhr.status);*/
                    }
                });
            });
            $(listdata.flagokBtn).bind('click', {
                cid: listdata.cust_id,
                stid: listdata.statusId,
                master_pk: listdata.master_pk
            }, function (evt) {
                var para = {
                    cid: evt.data.cid,
                    master_pk: evt.data.master_pk,
                    stId: evt.data.stid,
                };
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        autoloader: 'true',
                        action: 'Listflag',
                        type: 'slave',
                        gymid: gymid,
                        cid: para
                    },
                    success: function (data) {
                        if (data == 'logout')
                            window.location.href = URL;
                        else {
                            $(listdata.tabId).click();
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        /*console.log(xhr.status);*/
                    }
                });
            });
            $(listdata.unflagokBtn).bind('click', {
                cid: listdata.cust_id,
                stid: listdata.statusId,
                master_pk: listdata.master_pk
            }, function (evt) {
                var para = {
                    cid: evt.data.cid,
                    master_pk: evt.data.master_pk,
                    stId: evt.data.stid,
                };
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        autoloader: 'true',
                        action: 'ListUnflag',
                        type: 'slave',
                        gymid: gymid,
                        cid: para
                    },
                    success: function (data) {
                        if (data == 'logout')
                            window.location.href = URL;
                        else {
                            $(listdata.tabId).click();
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        /*console.log(xhr.status);*/
                    }
                });
            });
            $(listdata.editBtn).bind('click', {
                cid: listdata.cust_id,
                fid: listdata.factid,
                tabid: listdata.tabId,
                master_pk: listdata.master_pk,
                index: listdata.index,
                listdata: listdata
            }, function (evt) {
                var listdata = evt.data.listdata;
                $(listdata.pillpanel_div).hide();
                $(listdata.editcustomerdiv).show();
                var para = {
                    cid: evt.data.cid,
                    master_pk: evt.data.master_pk,
                    fid: evt.data.fid,
                    tabId: evt.data.tabid,
                    index: evt.data.index
                };
                console.log(para);
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        autoloader: 'true',
                        action: 'editcust',
                        gymid: gymid,
                        type: 'slave',
                        cid: para
                    },
                    success: function (data) {
                        console.log(data);
                        if (data == 'logout')
                            window.location.href = URL;
                        else {
                            $(listdata.editcustomerdiv).html(data);
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        /*console.log(xhr.status);*/
                    }
                });
            });
        }
    }
    ;
    function initializcList() {
        $(ltct.editcustomerdiv).hide();
        var rad = '<ul class="nav nav-tabs" id="dynamiclistCUst">';
        $(loader).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                autoloader: true,
                action: 'fetchInterestedIn',
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
                        var lcust = $.parseJSON($.trim(data));
                        $(ltct.editcustomerdiv).hide();
                        $(ltct.panelheading).html(lcust[0]["html"] + " customer");
                        if (lcust.length > 7) {
                            var max = 7;
                            for (i = 0; i < max; i++) {
                                if (i == 0)
                                    rad += '<li class="active"><a href="' + ltct.pillpanel_div + '" id="attcTab' + i + '" data-toggle="tab">' + lcust[i]["html"] + '</a></li>';
                                else
                                    rad += '<li><a href="' + ltct.pillpanel_div + '" id="attcTab' + i + '" data-toggle="tab">' + lcust[i]["html"] + '</a></li>';
                            }
                            rad += ' <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">More..<span class="caret"></span></a><ul class="dropdown-menu">';
                            for (i = max; i < lcust.length; i++) {
                                rad += '<li><a href="' + ltct.pillpanel_div + '" id="attcTab' + i + '" data-toggle="tab">' + lcust[i]["html"] + '</a></li>';
                            }
                            rad += ' </li></ul>';
                        } else {
                            for (i = 0; i < lcust.length; i++) {
                                if (i == 0)
                                    rad += '<li class="active"><a href="' + ltct.pillpanel_div + '" id="attcTab' + i + '" data-toggle="tab">' + lcust[i]["html"] + '</a></li>';
                                else
                                    rad += '<li><a href="' + ltct.pillpanel_div + '" id="attcTab' + i + '" data-toggle="tab">' + lcust[i]["html"] + '</a></li>';
                            }
                        }
                        var regTab = '#attcTab' + i;
                        var regi = i;
                        rad += '<li><a href="' + ltct.pillpanel_div + '" id="attcTab' + i + '" data-toggle="tab">Registration</a></li>';
                        rad += "</ul>";
                        $(ltct.st_panel).html(rad);
                        $(loader).html('');
                        $(regTab).bind('click', {
                            rindex: regi,
                        }, function (evt) {
                            $(ltct.editcustomerdiv).hide();
                            $(ltct.panelheading).html("Registered Customer");
                            var para1 = {
                                fid: null,
                                fname: null,
                                sindex: null,
                                tabId: regTab,
                                action: 'listRegCust',
                            };
                            initializecustlistdata(para1);
                        });
                        for (i = 0; i < lcust.length; i++) {
                            var para1 = {
                                fid: lcust[i]["id"],
                                fname: lcust[i]["html"],
                                sindex: i,
                                tabId: ltct.allattTab + i,
                                action: 'list_cust',
                            };
                            $(ltct.allattTab + i).bind('click', {
                                par: para1
                            }, function (evt) {
                                var para = evt.data.par;
                                $(ltct.editcustomerdiv).hide();
                                $(ltct.panelheading).html(para.fname + "'s Customers");
                                initializecustlistdata(para);
                            });
                            if (i == 0) {
                                $(ltct.editcustomerdiv).hide();
                                $(ltct.pillpanel_div).show();
                                $(ltct.panelheading).html(para1.fname + "'s Customer");
                                initializecustlistdata(para1);
                            }
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function initializecustlistdata(para1) {
        $(loader).html(LOADER_SIX);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: para1.action,
                gymid: gymid,
                type: 'slave',
                fid: para1.fid,
                tabid: para1.tabId
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else
                    $(ltct.pillpanel_div).html(data);
                $(ltct.pillpanel_div).show();
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
}
;
