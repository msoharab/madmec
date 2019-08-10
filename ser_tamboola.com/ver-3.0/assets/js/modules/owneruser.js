function ownerusers()
{
    var usreq = {};
    this.__construct = function (usreqq) {
        usreq = usreqq;
        fetchusers();
    };
    function fetchusers()
    {
        $(usreq.displayowneruser).html(LOADER_ONE);
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'fetchowneruser',
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
                        var flagids = new Array();
                        var unflagids = new Array();
                        var assigngyms=new Array();
                        if (details.status == "success")
                        {
                            $(usreq.displayowneruser).html('<table class="table table-hover" id="listofgymsTable">' +
                                    '<thead><tr><th>#</th><th>USER</th><th>GYM Details</th><th>Change Password</th><th>Flag/Unflag</th></tr></thead>' +
                                    '<tbody>' + details.data + '</tbody></table>');
                            if (details.userid.length)
                            {
                                for (i = 0; i < details.userid.length; i++)
                                {
                                    requids[i] = details.userid[i];
                                }
                            }
                            if (details.flagids.length)
                            {
                                for (i = 0; i < details.flagids.length; i++)
                                {
                                    flagids[i] = details.flagids[i];
                                }
                            }
                            if (details.unflagids.length)
                            {
                                for (i = 0; i < details.unflagids.length; i++)
                                {
                                    unflagids[i] = details.unflagids[i];
                                }
                            }
                            if(details.assigngyms.length)
                            {
                                for (i = 0; i < details.assigngyms.length; i++)
                                {
                                    assigngyms[i] = details.assigngyms[i];
                                }
                            }
                            
                            window.setTimeout(function () {
                                $('#listofgymsTable').dataTable();
                                if (flagids.length){
                                for (i = 0; i < flagids.length; i++)
                                {
                                    $('#flag_' + flagids[i]).bind('click', {treqid: flagids[i]}, function (evt) {
                                        makeFlagnUnflag(evt.data.treqid, "flag")
                                    });
                                }
                            }
                            if (unflagids.length)
                            {
                                for (i = 0; i < unflagids.length; i++)
                                {
                                    $('#unflag_' + unflagids[i]).bind('click', {treqid: unflagids[i]}, function (evt) {
                                        makeFlagnUnflag(evt.data.treqid, "unflag")
                                    });
                                }
                            }
                            if (assigngyms.length)
                            {
                                for (i = 0; i < assigngyms.length; i++)
                                {
                                    $('#deletegym_' + assigngyms[i]).bind('click', {treqid: assigngyms[i]}, function (evt) {
                                        deletegym(evt.data.treqid)
                                    });
                                }
                            }
                            if(requids.length)
                            {
                               for (i = 0; i < requids.length; i++)
                                {
                                    $('#changepass_' + requids[i]).bind('click', {treqid: requids[i]}, function (evt) {
                                        var flag=true;
                                        if($('#newpass'+evt.data.treqid).val() == "" || $('#newpass'+evt.data.treqid).val().length <5)
                                        {
                                            alert("Enter the new Password")
                                           $('#newpass'+evt.data.treqid).focus();
                                           flag=false;
                                           return;
                                        }
                                        if($('#cnfpass'+evt.data.treqid).val() == "" || $('#newpass'+evt.data.treqid).val().length <5)
                                        {
                                            alert("Enter the Confirm Password")
                                           $('#cnfpass'+evt.data.treqid).focus();
                                           flag=false;
                                           return;
                                        }
                                        if($('#newpass'+evt.data.treqid).val() != $('#cnfpass'+evt.data.treqid).val())
                                        {
                                            alert("Password not matches")
                                           $('#cnfpass'+evt.data.treqid).focus();
                                           flag=false;
                                           return;
                                        }
                                        if(flag)
                                        {
                                            changePassword($('#cnfpass'+evt.data.treqid).val(),evt.data.treqid)
                                        }
                                    });
                                } 
                            }
                            }, 400)
                        }
                        else
                        {
                            $(usreq.displaydetailsreq).html('<span class="text-danger"><strong>no Users</strong></span>');
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
    };
    
    function deletegym(gymid)
    {
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'userdeletegym',
                type: 'master',
                gymid : gymid,
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
                                alert('GYM Has Been Successfully Removed to the USER');
                                 fetchusers();
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
    
     function  makeFlagnUnflag(reqid, req)
    {
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'makeflagnunflag',
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
                            if (details.req == "flag")
                            {

                                alert('User Has Been Successfully Flag');
                                fetchusers();
                            }
                            else
                            {
                                alert('User Has Been Successfully UnFlag');
                                fetchusers();
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
    
    function changePassword(newpass,regid)
    {
       $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'changeuserpass',
                type: 'master',
                newpass: newpass,
                regid: regid
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
                                alert('Password Has Been Successfully Changed');
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
}
;