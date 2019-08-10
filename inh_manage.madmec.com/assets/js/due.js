function projDue() {
    var due = {};
    this.__construct = function (ctrl) {
        due = ctrl;
        fetchprojdues();
    }

    function fetchprojdues() {
        var duelist = [];
        var htm = '';
        var rad = '';
        $.ajax({
            type: 'POST',
            url: due.url,
            data: {
                autoloader: true,
                action: 'projdue',
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
                        duelist = $.parseJSON(data);
                        if (duelist != null) {
                            for (i = 0; i < duelist.html.length; i++) {
                                htm += duelist.html[i];
                            }
                            if (duelist.html.length == 0) {
                                $(due.list.displayhistory).html(duelist.header_html + '<h3>  <center><strong class="text-danger">No Dues !!!..</strong></h3>' + duelist.footer);
                            } else {
                                $(due.list.displayhistory).html(duelist.header_html + duelist.tableheader + htm + duelist.footer);
                            }
                            window.setTimeout(function () {
                                for (i = 0; i < duelist.html.length; i++) {
                                    $(duelist.deleteOk + duelist.dueids[i]).bind('click', {
                                        tdueid: duelist.dueids[i],
                                        tprojid: duelist.Projectids[i],
                                        tclientid: duelist.clientids[i],
                                        tdueamount: duelist.dueamount[i]
                                    }, function (event) {
                                        $($(this).prop('name')).hide(400);
                                        var dueid = event.data.tdueid;
                                        var projid = event.data.tprojid;
                                        var clientid = event.data.tclientid;
                                        var dueamount = event.data.tdueamount;
                                        var chk = payDueAmount(dueid, projid, clientid, dueamount);
                                        if (chk) {
                                            $('#due_row_' + dueid).remove();
                                        }
                                    });
                                }
                                $('#dataTables-projectdue').dataTable();
                            }, 200);
                        }
                        break;
                }
            },
            error: function () {
                $(due.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }

    function payDueAmount(dueid, projid, clientid, dueamount) {
        attr = {
            dueid: dueid,
            projid: projid,
            clientid: clientid,
            dueamount: dueamount,
        }
        console.log(attr)
        var flag = false;
        $.ajax({
            url: due.url,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'payprojdueamount',
                payduecash: attr
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
                $(due.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        return flag;
    }
}