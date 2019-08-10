function dueController()
{
    var due = {};
    this.__construct = function (duectrl) {
        due = duectrl;
        fetchDues();
    }
    function  fetchDues()
    {
        $(due.displaydues).html(LOADER_ONE)
        $.ajax({
            type: 'POST',
            url: due.url,
            data: {autoloader: true, action: 'fetchdues', type: 'slave'},
            success: function (data, textStatus, xhr) {
                console.log(data);
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var res = $.parseJSON(data);
                        if (res.status == "success")
                        {
                            $(due.displaydues).html(res.filename);
                        }
                        else
                        {
                            $(due.displaydues).html('<span class="text-danger"><strong>no dues  ||||</strong></span>');
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
    function payDues(amt, userpk, mopval)
    {
        var flag = false;
        if ($('#duemop_' + mopval).val() == "")
        {
            $('#duemop_' + mopval).focus();
            alert("please select MOP");
            flag = false;
            return;
        }
        else
        {
            flag = true;
        }
        if (flag)
        {
            var attr = {
                userpk: userpk,
                amt: amt,
                mop: $('#duemop_' + mopval).val()
            };
            $.ajax({
                type: 'POST',
                url: due.url,
                data: {autoloader: true, action: 'payadmindues', type: 'master', details: attr},
                success: function (data, textStatus, xhr) {
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
                            var res = $.parseJSON(data);
                            if (res)
                            {
                                alert("Amount Has been Successfully Updated");
                                fetchDues();
                            }
                            else
                            {
                            }
                            break;
                    }
                },
                error: function () {
                    alert("error");
                    $(due.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
    }
}
