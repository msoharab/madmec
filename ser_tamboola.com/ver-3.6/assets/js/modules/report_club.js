function controlClubReport() {
    var gymid = $(DGYM_ID).attr("name");
    cb = {};
    rbtn = {};
    repfrom = {};
    repto = {};
    this.__construct = function (club) {
        cb = club;
        rbtn = club.butrep;
        repfrom = club.from;
        repto = club.to;
        $("html , body").animate({
            scrollTop: 0
        }, "fast");
        $(cb.formdata).hide();
        $(cb.labeltitle).show();
        $("#rptdatefrom").datepicker({
            dateFormat: 'dd-M-yy',
            changeMonth: true,
            changeYear: true,
            altField: '#alternate_1',
            altFormat: 'DD, d MM, yy',
            maxDate: 0,
            yearRange: '2014:' + (new Date).getFullYear() + '',
            onSelect: function () {
                jQuery(this).datepicker('option', 'maxDate', $("#rptdateto").val());
            }
        });
        $("#rptdateto").datepicker({
            dateFormat: 'dd-M-yy',
            changeMonth: true,
            changeYear: true,
            altField: '#alternate_2',
            altFormat: 'DD, d MM, yy',
            maxDate: 0,
            yearRange: '2014:' + (new Date).getFullYear() + '',
            beforeShow: function () {
                jQuery(this).datepicker('option', 'minDate', $("#rptdatefrom").val());
            }
        });
        loadClubTab();
    }
    function loadClubTab() {
        var rad = '<ul class="nav nav-tabs" id="dynamicFees">';
        $(loader).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: cb.url,
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
                        var fee = $.parseJSON($.trim(data));
                        if (fee.length > 7) {
                            var max = 7;
                            for (i = 0; i < max; i++) {
                                if (i == 0)
                                    rad += '<li class="active"><a href="' + cb.output + '" id="FeeTabsClub' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                                else
                                    rad += '<li><a href="cregpanel_div" id="FeeTabsClub' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                            }
                            rad += ' <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">More..<span class="caret"></span></a><ul class="dropdown-menu">';
                            for (i = max; i < fee.length; i++) {
                                rad += '<li><a href="cregpanel_div" id="FeeTabsClub' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                            }
                            rad += ' </li></ul>';
                        } else {
                            for (i = 0; i < fee.length; i++) {
                                if (i == 0)
                                    rad += '<li class="active"><a href="' + cb.output + '" id="FeeTabsClub' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                                else
                                    rad += '<li><a href="cregpanel_div" id="FeeTabsClub' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                            }
                        }
                        /* for(i=0;i<fee.length;i++){*/
                        /* if(i==0)*/
                        /* rad += '<li class="active"><a href="'+cb.output+'" id="FeeTabsClub'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';*/
                        /* else*/
                        /* rad += '<li><a href="'+cb.output+'" id="FeeTabsClub'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';*/
                        /* }*/
                        rad += "</ul>";
                        $(cb.feeTab).html(rad);
                        $(loader).html('');
                        var para1 = {};
                        for (i = 0; i < fee.length; i++) {
                            $("#FeeTabsClub" + i).bind('click', {
                                fid: fee[i]["id"],
                                name: fee[i]["name"],
                                sindex: i,
                                cb: cb
                            }, function (evt) {
                                $('#Television').html('');
                                $("#" + cb.butrep).unbind();
                                $(cb.formdata).show();
                                $(cb.labeltitle).hide();
                                $(cb.ftitle).html(evt.data.name);
                                cb = evt.data.cb;
                                var para1 = {
                                    fid: evt.data.fid,
                                    fname: evt.data.name,
                                    sindex: evt.data.sindex,
                                    list_type: cb.list_type,
                                    cb: evt.data.cb,
                                }
                                $("#" + cb.butrep).bind("click", {
                                    para1: para1
                                }, function () {
                                    GenerateReport(para1);
                                });
                            });
                            if (i == 0) {
                                var para1 = {
                                    fid: fee[i]["id"],
                                    fname: fee[i]["name"],
                                    sindex: i,
                                    list_type: cb.list_type,
                                    cb: cb,
                                }
                                $("#" + cb.butrep).unbind();
                                $(cb.formdata).show();
                                $(cb.labeltitle).hide();
                                $(cb.ftitle).html(para1.fname);
                                $("#" + cb.butrep).bind("click", {
                                    para1: para1
                                }, function () {
                                    GenerateReport(para1);
                                });
                            }
                        }
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
    function GenerateReport(para) {
        var attrName = '';
        var flag = false;
        var date1 = convertDateFormat($('#rptdatefrom').val()) ? convertDateFormat($('#rptdatefrom').val()) : null;
        var date2 = convertDateFormat($('#rptdateto').val()) ? convertDateFormat($('#rptdateto').val()) : null;
        if ($('#rptdatefrom').val() == "") {
            $('#rptdatefrom').focus();
            return
            flag = false;
        } else {
            flag = true;
        }
        if (date1 || date2) {
            $('#date_rpt_msg').hide();
        } else {
            $('#date_rpt_msg').show();
            flag = false;
        }
        if (flag) {
            $('#Television').html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
            $.ajax({
                url: cb.url,
                data: {
                    autoloader: 'true',
                    action: 'reportClub',
                    type: 'slave',
                    gymid: gymid,
                    attrName: para.fid,
                    attrValue: para.fid,
                    date1: date1,
                    date2: date2,
                    fname: para.fname,
                    fid: para.fid
                },
                type: 'POST'
            }).done(function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                $('#Television').html(data);
                $(para.cb.form).get(0).reset();
                $('#printButGen').on("click", function () {
                    $('#Television').html('');
                });
                /*console.log(data);*/
            });
        }
    }
    ;
    function reportAdd() {
        var attr = validateEnqFields();
        if (attr) {
            $("#" + ead1.repbut).prop('disabled', 'disabled');
            $(loader).html(LOADER_SIX);
            $.ajax({
                url: rep.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'reportClub',
                    type: 'slave',
                    gymid: gymid,
                    eadd: attr
                },
                success: function (data, textStatus, xhr) {
                    data = $.trim(data);
                    /*console.log(data);*/
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(loader).hide();
                            $("#" + ead1.msg).html('<h2>Record success fully added</h2>');
                            $("#" + ead1.form).get(0).reset();
                            break;
                    }
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                    window.setTimeout(function () {
                        $("#" + ead1.msg).html('');
                    }, 2000);
                    $("#" + ead1.repbut).removeAttr('disabled');
                }
            });
        } else {
            $("#" + ead.but).removeAttr('disabled');
        }
    }
    ;
}
;
