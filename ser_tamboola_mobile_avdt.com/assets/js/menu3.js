function menu3()
{
    var ctrl = {};
    this.__construct = function (attrctrl) {
        ctrl = attrctrl;
        window.setTimeout(function () {
            fetchGyms();
            fetchDuration();
            fetchFacility();
            $(ctrl.add.offersave).click(function (evt) {
                evt.preventDefault();
                addOffer();
            });
            $(ctrl.add.duration).change(function () {
                alert("i calleed");
            });
            $(ctrl.list.menubut).click(function () {
                fetchOffers();
            });
        }, 400);
    }
    
    /*Fetch Gyms*/
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

    /*Fetch Duration*/
    function fetchDuration()
    {
        $.ajax({
            url: ctrl.url,
            type: 'POST',
            data: {autoloader: true, action: 'fetchdurations', type: 'master'},
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
                        var header = '<select class="form-control" id="duration" name="duration"><option value="">Select the Duration</option>';
                        var footer = '</select>';
                        var det = $.parseJSON(data);
                        if (det.status == "success")
                        {
                            $(ctrl.add.disdura).html(header + det.data + footer);
                        }
                        else
                        {
                            $(ctrl.add.disdura).html(header + det.data + footer);
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

    /*Fetch FACILITY Type*/
    function fetchFacility()
    {
        $.ajax({
            url: ctrl.url,
            type: 'POST',
            data: {autoloader: true, action: 'fetchfactys', type: 'master'},
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
                        var header = '<select class="form-control" id="faciltiy" name="faciltiy"><option value="">Select the Facility</option>';
                        var footer = '</select>';
                        var det = $.parseJSON(data);
                        if (det.status == "success")
                        {
                            $(ctrl.add.disfac).html(header + det.data + footer);
                        }
                        else
                        {
                            $(ctrl.add.disfac).html(header + det.data + footer);
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

    function addOffer()
    {
        var flag = validateOfferForm();
        if (flag)
        {
            $(ctrl.add.offersave).hide();
            var attr = {
                name: $(ctrl.add.name).val(),
                duration: $(ctrl.add.duration).val(),
                days: $(ctrl.add.days).val(),
                faciltiy: $(ctrl.add.faciltiy).val(),
                prize: $(ctrl.add.prize).val(),
                member: $(ctrl.add.member).val(),
                gymname: $(ctrl.add.gymname).val(),
                descb: $(ctrl.add.descb).val(),
            }
            $.ajax({
                url: ctrl.url,
                type: 'POST',
                data: {autoloader: true, action: 'addoffers', type: 'master', details: attr},
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
                                alert("Offer has been Successfully Added");
                                $(ctrl.add.form).get(0).reset();
                                $(ctrl.add.offersave).show();
                            }
                            else
                            {
                                alert("Offer hasn't been Added");
                                $(ctrl.add.form).get(0).reset();
                                $(ctrl.add.offersave).show();
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

    /*validating Add Form Fields*/
    function validateOfferForm()
    {
        var flag = false;
        if (trimming($(ctrl.add.name).val()) == "")
        {
            alert("Enter the Offer Name");
            flag = false;
            $(ctrl.add.name).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.duration).val()) == "")
        {
            alert("Slect the Duration");
            flag = false;
            $(ctrl.add.duration).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.days).val()) == "" || !$(ctrl.add.days).val().match(number_reg))
        {
            flag = false;
            $(ctrl.add.days).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.faciltiy).val()) == "")
        {
            alert("Select the Facility");
            flag = false;
            $(ctrl.add.faciltiy).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.prize).val()) == "" || !$(ctrl.add.prize).val().match(number_reg))
        {
            alert("Enter the Prize");
            flag = false;
            $(ctrl.add.prize).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        if (trimming($(ctrl.add.member).val()) == "" || !$(ctrl.add.member).val().match(number_reg))
        {
            alert("Select the Members");
            flag = false;
            $(ctrl.add.member).focus();
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
        if (trimming($(ctrl.add.descb).val()) == "")
        {
            alert("Enter the Describtion");
            flag = false;
            $(ctrl.add.descb).focus();
            return flag;
        }
        else
        {
            flag = true;
        }
        return flag;
    }

    /*fetch Existing Offers*/
    function fetchOffers()
    {
        $(ctrl.list.disoffes).html(LOADER_ONE);
        $.ajax({
            url: ctrl.url,
            type: 'POST',
            data: {autoloader: true, action: 'fetchoffers', type: 'master'},
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
                            $(ctrl.list.disoffes).html('<table  class="table table-striped table-bordered table-hover" id="listofoffers-datable"><thead><th>#</th><th>Offer Details</th></thead><tbody>' + det.data + '</tbody></table>');
                            $('#listofoffers-datable').dataTable() ;
                        }
                        else
                        {
                            $(ctrl.list.disoffes).html('<span class="text-danger"><strong>no record found</strong></span>');
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

    /*Trimming Values*/
    function trimming(val)
    {
        return $.trim(val);
    }
}