function controlEnquiryListAll() {
    var enq = {};
    var list = {};
    var menuDiv = "";
    var htmlDiv = "";
    var outputDiv = "";
    var OptionsSearch = new Object();
    var SearchAllHide = new Object();
    var gymid = $(DGYM_ID).attr("name");
    this.__construct = function (enquiry) {
        enq = enquiry;
        list = enquiry.list;
        menuDiv = list.menuDiv;
        htmlDiv = list.htmlDiv;
        outputDiv = list.outputDiv;
        OptionsSearch = list.OptionsSearch;
        SearchAllHide = list.SearchAllHide;
        DisplayEnquiry();
    };
    this.delete_enqiry = function (del) {
        id = del.id;
        index = del.index;
        $(enq.loader).html(LOADER_SIX);
        $.ajax({
            url: enq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'deleteEnquiry',
                type: 'slave',
                gymid: gymid,
                'id': id
            },
            async: false,
            success: function (data) {
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $('#delete_enq_' + id).modal('toggle')
                        $(del.delenq).html(data);
                        var num = Number($(del.numenq).text());
                        if (num > 0) {
                            num -= 1;
                            $(del.numenq).text(num);
                        }
                        if (num == 0)
                            $('#accordion_' + index).remove();
                        $(del.delenq).hide(500);
                        window.setTimeout(function () {
                            $(del.enqrow).remove();
                            DisplayEnquiry();
                        }, 200);
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
    };
    this.update_follow_up = function (ufollow) {
        id = ufollow.id;
        var flw = {
            id: ufollow.id,
            com: $(ufollow.cmt).val(),
            body: ufollow.bfollow,
            btn: ufollow.btn,
        }
        if (flw.com.length) {
            $(flw.dt).css({
                display: 'block'
            });
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'UpdateFollowUp',
                    type: 'slave',
                    gymid: gymid,
                    follow: flw
                },
                success: function (data) {
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            if (!data)
                                $(flw.body).html('Can\'t updated Follow-up.');
                            else
                                $(flw.body).html('Follow-up updated successfully.');
                            $(flw.btn).trigger('click');
                            $(flw.dt).css({
                                display: 'none'
                            });
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
        } else
            alert('Type the result of Follow-up !!!');
    }
    this.update_final_status = function (fstats) {
        var stats = {
            id: fstats.id,
            com: $(fstats.cmt).val(),
            body: fstats.body,
            sbtn: fstats.sbtn,
            fldr: fstats.floader,
        }
        if (stats.com.length) {
            $(stats.fldr).css({
                display: 'block'
            });
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'UpdateFinalStatus',
                    type: 'slave',
                    gymid: gymid,
                    stats: stats
                },
                success: function (data) {
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            if (!data)
                                $(stats.body).html('Can\'t updated Follow-up.');
                            else
                                $(stats.body).html('Final status updated successfully.');
                            $(stats.sbtn).trigger('click');
                            $(stats.fldr).css({
                                display: 'none'
                            });
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
        } else
            alert('Type the result of your effort finally what happened !!!');
    }
    function DisplayEnquiry() {
        $(list.output).html(LOADER_SIX);
        $.ajax({
            url: enq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'DisplayEnquiryAll',
                type: 'slave',
                gymid: gymid,
                list_type: 'all'
            },
            success: function (data) {
                console.log(data);
                data = $.parseJSON($.trim(data));
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(list.output).html(data.htm);
                        $(enq.loader).hide();
                        $("#output_load").html('');
                        InstallSerachHtml();
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
        $(window).scroll(function (event) {
            if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10) {
                UpdateListEnquiry();
            } else {
                $(enq.loader).html('');
            }
        });
    }
    function UpdateListEnquiry() {
        $(enq.loader).html(LOADER_SIX);
        $.ajax({
            url: enq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'UpdateListEnquiry',
                type: 'slave',
                gymid: gymid
            },
            success: function (data) {
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(list.output).append(data);
                        $(enq.loader).hide();
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
    /*search functions*/
    function InstallSerachHtml() {
        $.ajax({
            url: enq.url,
            type: 'post',
            datatype: 'JSON',
            async: false,
            data: {
                autoloader: 'true',
                action: 'LoadSearchHTML',
                type: 'slave',
                gymid: gymid,
                ser: OptionsSearch
            },
            success: function (data) {
                data = $.parseJSON($.trim(data));
                $(menuDiv).html(data.menuDiv);
                $(htmlDiv).html(data.htmlDiv);
                window.setTimeout(function () {
                    $("#follow_up,#enq_day,#follow_up_all,#enq_day_all,#jnd,#exd,#jnd_all,#exd_all").datepicker({
                        dateFormat: 'dd-M-yy',
                        changeMonth: true,
                        changeYear: true,
                        yearRange: '2014:' + Number(new Date().getFullYear()) + 2,
                    });
                    $(".srch_type").each(function () {
                        var txt = $(this).text();
                        if (txt === 'Hide') {
                            $(this).bind('click', function () {
                                $(".ser_crit").each(function () {
                                    $(this).hide();
                                });
                            });
                        } else {
                            $(this).bind('click', function () {
                                ShowSearchType(txt + '_ser');
                            });
                        }
                    });
                    $("#Enquiry_ser_but").bind('click', function () {
                        searchEnqList();
                    });
                    $("#Group_ser_but").bind('click', function () {
                        searchGroup();
                    });
                    $("#Personal_ser_but").bind('click', function () {
                        searchPerUser();
                    });
                    $("#Offer_ser_but").bind('click', function () {
                        searchOffUser();
                    });
                    $("#package_ser_but").bind('click', function () {
                        searchPackUser();
                    });
                    $("#Date_ser_but").bind('click', function () {
                        searchDateUser();
                    });
                    $("#All_ser_but").bind('click', function () {
                        searchAllUser();
                    });
                    $.each(SearchAllHide, function (key, value) {
                        (value) ? $("#" + key).remove() : false;
                    });
                }, 1500);
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
