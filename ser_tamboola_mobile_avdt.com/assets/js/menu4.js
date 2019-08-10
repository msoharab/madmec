function menu4()
{
    var ctrl = {};
    this.__construct = function (attrctrl) {
        ctrl = attrctrl;
        window.setTimeout(function () {
            fetchPackegs();
            fetchPackagestype();
            fetchGyms()
            $(ctrl.add.savepack).click(function () {
                addPackage();
            });
            $(ctrl.list.menubut).click(function () {
                fetchExistingpackages();
            });
        }, 400);
    }
    function fetchPackegs()
    {

    }

    /*Fetch Packages type*/
    function fetchPackagestype()
    {
        $.ajax({
            url: ctrl.url,
            type: 'POST',
            data: {autoloader: true, action: 'fetchpcktypes', type: 'master'},
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
                        var header = '<select class="form-control" id="packtype" name="packtype"><option value="">Select the Type</option>';
                        var footer = '</select>';
                        var det = $.parseJSON(data);
                        if (det.status == "success")
                        {
                            $(ctrl.add.distypeofpack).html(header + det.data + footer);
                        }
                        else
                        {
                            $(ctrl.add.distypeofpack).html(header + det.data + footer);
                        }
                        break;
                }
            },
            error: function () {
                $(ctrl.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                window.setTimeout(function () {
                    $(ctrl.msgDiv).html('');
                }, 2000);
            }
        });
    }

    /*Add Package*/
    function addPackage()
    {
        var flag = false;
        flag = validatePackTypeForm();
        if (flag)
        {
            $(ctrl.add.savepack).hide();
            var attr = {
                packagename: $(ctrl.add.packagename).val(),
                sessions: $(ctrl.add.sessions).val(),
                packtype: $(ctrl.add.packtype).val(),
                amount: $(ctrl.add.amount).val(),
                gymname: $(ctrl.add.gymname).val()
            };
            $.ajax({
                url: ctrl.url,
                type: 'POST',
                data: {autoloader: true, action: 'addpacks', type: 'master', details: attr},
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
                            var det = $.parseJSON(data);
                            if (det)
                            {
                                alert("Package has been Successfully Added");
                                $(ctrl.add.form).get(0).reset();
                                $(ctrl.add.savepack).show();
                            }
                            else
                            {
                                alert("Package hasn't been Added");
                                $(ctrl.add.form).get(0).reset();
                                $(ctrl.add.savepack).show();
                            }
                            break;
                    }
                },
                error: function () {
                    $(ctrl.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    window.setTimeout(function () {
                        $(ctrl.msgDiv).html('');
                    }, 2000);
                }
            });
        }
    }

    function fetchGyms()
    {
        $.ajax({
            url: ctrl.url,
            type: 'POST',
            data: {autoloader: true, action: 'fetchgyms', type: 'master'},
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
                        var header = '<select class="form-control" id="gymname" name="gymname"><option value="">Select the GYM</option>';
                        var footer = '</select>';
                        var det = $.parseJSON(data);
                        if (det.status == "success")
                        {
                            $(ctrl.add.displaygyms).html(header + det.data + footer);
                        }
                        else
                        {
                            $(ctrl.add.displaygyms).html(header + det.data + footer);
                        }
                        break;
                }
            },
            error: function () {
                $(ctrl.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                window.setTimeout(function () {
                    $(ctrl.msgDiv).html('');
                }, 2000);
            }
        });
    }

    /*fetch Existing Packages*/
    function fetchExistingpackages()
    {
        $(ctrl.list.dispacks).html(LOADER_ONE);
        $.ajax({
            url: ctrl.url,
            type: 'POST',
            data: {autoloader: true, action: 'fetchexistingpacks', type: 'master'},
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
                        var det = $.parseJSON(data);
                        if (det.status == "success")
                        {
                            $(ctrl.list.dispacks).html('<table  class="table table-striped " id="listofoffers-datable"><thead><th>#</th><th>Package Details</th></thead><tbody>' + det.data + '</tbody></table>');
                            window.setTimeout(function (){
                               $('#listofoffers-datable').dataTable() ; 
                            });
                        }
                        else
                        {
                            $(ctrl.list.dispacks).html('<span class="text-danger"><strong>no record found</strong></span>');
                        }
                        break;
                }
            },
            error: function () {
                $(ctrl.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                window.setTimeout(function () {
                    $(ctrl.msgDiv).html('');
                }, 2000);
            }
        });
    }

    /*validate*/
    function validatePackTypeForm()
    {
        var flag = false;
        if (trimming($(ctrl.add.gymname).val()) == "")
        {
            alert("Select the Gym Name");
            flag = false;
            $(ctrl.add.gymname).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.packagename).val()) == "")
        {
            alert("Enter the Package Name");
            flag = false;
            $(ctrl.add.packagename).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.sessions).val()) == "" || !$(ctrl.add.sessions).val().match(number_reg))
        {
            alert("Enter the Sessions");
            flag = false;
            $(ctrl.add.sessions).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.gymname).val()) == "")
        {
            alert("Select the Gym Name");
            flag = false;
            $(ctrl.add.gymname).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.packtype).val()) == "")
        {
            alert("Select the Package Type");
            flag = false;
            $(ctrl.add.packtype).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.amount).val()) == "" || !$(ctrl.add.amount).val().match(number_reg))
        {
            alert("Enter the Amount");
            flag = false;
            $(ctrl.add.amount).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        return flag;
    }

    /*Trimming Values*/
    function trimming(val)
    {
        return $.trim(val);
    }
}