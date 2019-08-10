function userRequest()
{
    var usreq = {};
    this.__construct = function (usreqq) {
        usreq = usreqq;
        fetchRequests();
    }
    function fetchRequests()
    {
        $(usreq.displaydetailsreq).html(LOADER_ONE);
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'fetchuserrequestdet',
                type: 'master',
            },
            success: function (data) {
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var details = $.parseJSON($.trim(data));
                        var requids = new Array();
                        if (details.status == "success")
                        {
                            $(usreq.displaydetailsreq).html('<table class="table table-hover" id="listofgymsTable">' +
                                    '<thead><tr><th>#</th><th>USER</th><th>GYM Details</th><th>option</th></tr></thead>' +
                                    '<tbody>' + details.data + '</tbody></table>');
                            if (details.ugpgids.length)
                            {
                                for (i = 0; i < details.ugpgids.length; i++)
                                {
                                    requids[i] = details.ugpgids[i];
                                }
                            }
                            window.setTimeout(function () {
                                for (i = 0; i < requids.length; i++)
                                {
                                    $('#accep_' + requids[i]).bind('click', {treqid: requids[i]}, function (evt) {
                                        AcceptnReject(evt.data.treqid, "accept")
                                    });
                                    $('#delt_' + requids[i]).bind('click', {treqid: requids[i]}, function (evt) {
                                        AcceptnReject(evt.data.treqid, "reject")
                                    });
                                }
                            }, 400)
                        }
                        else
                        {
                            $(usreq.displaydetailsreq).html('<span class="text-danger"><strong>no Requests</strong></span>');
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

    function  AcceptnReject(reqid, req)
    {
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'userreqres',
                type: 'master',
                reqid: reqid,
                req: req
            },
            success: function (data) {
                data = $.trim(data);
                switch (data) {
                    case "logout":
                        logoutAdmin();
                        break;
                    default:
                        var details = $.parseJSON($.trim(data));
                        if (details.status == "success")
                        {
                            if (details.req == "accept")
                            {

                                alert('User Has Been Successfully Added');
                                fetchRequests();
                                fetchuserrequest()
                            }
                            else
                            {
                                alert('Request Has Been Deleted');
                                fetchRequests();
                                fetchuserrequest()
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

    function  fetchuserrequest()
    {
        $.ajax({
            url: 'control.php',
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'fetchuserrequest',
                type: 'master',
            },
            success: function (data) {
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $('#displayreqts').html(data + ' Requests');
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
}

