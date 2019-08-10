function followup() {
    var fallowup = {};
    this.__construct = function (ctrl) {
        fallowup = ctrl;
        fetchfollowups();
    }

    function fetchfollowups() {
        var fallowuplist = [];
        $.ajax({
            type: 'POST',
            url: fallowup.url,
            data: {
                autoloader: true,
                action: 'fetchfollowup',
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
                        fallowuplist = $.parseJSON(data);
                        if (fallowuplist.currentfollow == '') {
                            $(fallowup.currentfollowup).html(fallowuplist.header + '<h3>  <center><strong class="text-danger">No follow ups !!!..</strong></h3>' + fallowuplist.footer);
                        } else {
                            $(fallowup.currentfollowup).html(fallowuplist.header + fallowuplist.tableheader + fallowuplist.tablehead + fallowuplist.currentfollow + fallowuplist.footer);
                        }
                        if (fallowuplist.pendingfollow == '') {
                            $(fallowup.pendingfollowup).html(fallowuplist.header + '<h3>  <center><strong class="text-danger">No follow ups !!!..</strong></h3>' + fallowuplist.footer);
                        } else {
                            $(fallowup.pendingfollowup).html(fallowuplist.header + fallowuplist.tableheader1 + fallowuplist.tablehead + fallowuplist.pendingfollow + fallowuplist.footer);
                        }
                        if (fallowuplist.expiredfollow == '') {
                            $(fallowup.expiredfollowup).html(fallowuplist.header + '<h3>  <center><strong class="text-danger">No follow ups !!!..</strong></h3>' + fallowuplist.footer);
                        } else {
                            $(fallowup.expiredfollowup).html(fallowuplist.header + fallowuplist.tableheader2 + fallowuplist.tablehead + fallowuplist.expiredfollow + fallowuplist.footer);
                        }
                        window.setTimeout(function () {
                            $('#followupduescurr-example').dataTable();
                            $('#followupduespen-example').dataTable();
                            $('#followupduesexp-example').dataTable();
                        }, 300);
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
}