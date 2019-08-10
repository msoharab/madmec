function ownerusers()
{
    var add = {};
    var usreq = {};
    var userasn = {};
    var checkusr = 0;
    this.__construct = function (usreqq) {
        usreq = usreqq;
        add = usreq.adduser;
        userasn = usreq.assignuser;
        checkusr = 0;
        $(add.user_dob).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-100:+100',
            maxDate: '-10y',
        });
        $(add.user_email).change(function () {
            checkEmail(this.value);
        });
        $(add.user_email).mouseleave(function () {
            checkEmail(this.value);
        });
        $(add.but).click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            userAdd();
        });
        $('#listusersbut').click(function(){
           fetchusers(); 
        })
        fetchownergyms();
        fetchadmins();
    };

    function checkEmail(email)
    {
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'checkemail',
                email: email,
                type: "master",
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                if (Number(data)) {
                    checkusr = 0;
                    $('#user_email_msg').html('<span class="text-danger"><strong>Email Id Already Exist</strong></span>');

                } else {
                    checkusr = 1;
                    $('#user_email_msg').html('');
                }
            },
            error: function (xhr, textStatus) {
                $(checkemail.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }

    function userAdd()
    {
        var attr = validateGYMFields();
        if (attr) {
            $(add.but).prop('disabled', 'disabled');
            $(usreq.msgDiv).html('');
            $(usreq.msgDiv).html(LOADER_SIX);
            $.ajax({
                url: usreq.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'clientAdminRequest',
                    type: 'master',
                    details: attr
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
                            alert("Admin has been success fully added")
                            $(add.form).get(0).reset();
//						$('#address_body').hide(300);
                            break;
                    }
                },
                error: function () {
                    $(usreq.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    $(add.but).removeAttr('disabled');
                }
            });
        } else {
            $(add.but).removeAttr('disabled');
        }
    }
    ;
    function fetchownergyms() {
        var gymdata = new Array();
        $(userasn.asignuser).val('');
        $(userasn.asigngym).val('');
        gymdata.length = 0;
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'displayallgymsofowner',
                type: 'master',
                ownerd: 'ownerd',
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
                        for (i = 0; i < details.gymdata.length; i++) {
                            gymdata.push({
                                label: details.gymdata[i],
                                data: details.gymdata[i],
                                ids: details.gymids[i],
                            })
                        }
                        $(userasn.asigngym).autocomplete({
                            minLength: 0,
                            source: gymdata,
                            focus: function (event, ui) {
                                $(userasn.asigngym).val(ui.item.label);
                                userasn.gymid = ui.item.ids;
                                return false;
                            },
                            select: function (event, ui) {
                                $(userasn.asigngym).val(ui.item.label);
                                userasn.gymid = ui.item.ids;
                                return false;
                            },
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
    }

    function fetchadmins() {
        var gymdata = new Array();
        $(userasn.asignuser).val('');
        $(userasn.asigngym).val('');
        gymdata.length = 0;
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'displayalladminsofowner',
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
                        for (i = 0; i < details.gymdata.length; i++) {
                            gymdata.push({
                                label: details.gymdata[i],
                                data: details.gymdata[i],
                                ids: details.gymids[i],
                            })
                        }
                        $(userasn.asignuser).autocomplete({
                            minLength: 0,
                            source: gymdata,
                            focus: function (event, ui) {
                                $(userasn.asignuser).val(ui.item.label);
                                userasn.adminid = ui.item.ids;
                                return false;
                            },
                            select: function (event, ui) {
                                $(userasn.asignuser).val(ui.item.label);
                                userasn.adminid = ui.item.ids;
                                return false;
                            },
                        });

                        $(userasn.form).submit(function (evt) {
                            evt.preventDefault();
                            var attr = {
                                userid: userasn.adminid,
                                gymid: userasn.gymid,
                            };
                            if (userasn.adminid && userasn.gymid)
                            {
                                $.ajax({
                                    url: usreq.url,
                                    type: 'POST',
                                    data: {
                                        autoloader: true,
                                        action: 'addusertogym',
                                        type: 'master',
                                        det: attr
                                    },
                                    success: function (data, textStatus, xhr) {
                                        /*data = $.parseJSON($.trim(data));*/
                                        switch (data) {
                                            case 'logout':
                                                logoutAdmin({});
                                                break;
                                            default:
                                                var details = $.parseJSON($.trim(data));
                                                if (details.status == "alreadyexist") {
                                                    alert("User is Already Assign to this GYM")
                                                } else if (details.status == "pending") {
                                                    alert("Approval is pending From GYM Owner");
                                                } else {
                                                    alert("User has been Successfully Added to this GYM");
                                                    $(userasn.form).get(0).reset();
                                                     userasn.adminid= 0;
                                                      userasn.gymid = 0;
                                                }
                                                break;
                                        }
                                    },
                                    error: function (xhr, textStatus) {
                                    },
                                    complete: function (xhr, textStatus) {
                                    }
                                });
                            }
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
    }


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
                        var assigngyms = new Array();
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
                            if (details.assigngyms.length)
                            {
                                for (i = 0; i < details.assigngyms.length; i++)
                                {
                                    assigngyms[i] = details.assigngyms[i];
                                }
                            }

                            window.setTimeout(function () {
                                $('#listofgymsTable').dataTable();
                                if (flagids.length) {
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
                                if (requids.length)
                                {
                                    for (i = 0; i < requids.length; i++)
                                    {
                                        $('#changepass_' + requids[i]).bind('click', {treqid: requids[i]}, function (evt) {
                                            var flag = true;
                                            if ($('#newpass' + evt.data.treqid).val() == "" || $('#newpass' + evt.data.treqid).val().length < 5)
                                            {
                                                alert("Enter the new Password")
                                                $('#newpass' + evt.data.treqid).focus();
                                                flag = false;
                                                return;
                                            }
                                            if ($('#cnfpass' + evt.data.treqid).val() == "" || $('#newpass' + evt.data.treqid).val().length < 5)
                                            {
                                                alert("Enter the Confirm Password")
                                                $('#cnfpass' + evt.data.treqid).focus();
                                                flag = false;
                                                return;
                                            }
                                            if ($('#newpass' + evt.data.treqid).val() != $('#cnfpass' + evt.data.treqid).val())
                                            {
                                                alert("Password not matches")
                                                $('#cnfpass' + evt.data.treqid).focus();
                                                flag = false;
                                                return;
                                            }
                                            if (flag)
                                            {
                                                changePassword($('#cnfpass' + evt.data.treqid).val(), evt.data.treqid)
                                            }
                                        });
                                    }
                                }
                            }, 400)
                        }
                        else
                        {
                            $(usreq.displayowneruser).html('<span class="text-danger"><strong>no Users</strong></span>');
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
    ;

    function deletegym(gymid)
    {
        $.ajax({
            url: usreq.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'userdeletegym',
                type: 'master',
                gymid: gymid,
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

    function changePassword(newpass, regid)
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

    this.bindAddressFields = function (addres) {
        var list = this.countries;
        $(add.address.country).autocomplete({
            minLength: 2,
            source: list,
            autoFocus: true,
            select: function (event, ui) {
                window.setTimeout(function () {
                    $(add.address.country).val(ui.item.label);
                    $(add.address.country).attr('name', ui.item.value);
                    add.address.countryCode = ui.item.countryCode;
                    add.address.PCR_reg = ui.item.PCR;
                    addres.setCountry(ui.item);
                    $(add.address.province).val('');
                    $(add.address.province).focus();
                }, 50);
                $(add.address.province).focus(function () {
                    this.states = addres.getState();
                    var list = this.states;
                    $(add.address.province).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.province).val(ui.item.label);
                                $(add.address.province).attr('name', ui.item.value);
                                add.address.provinceCode = ui.item.provinceCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setState(ui.item);
                                $(add.address.district).val('');
                                $(add.address.district).focus();
                            }, 50);
                        }
                    });
                });
                $(add.address.district).focus(function () {
                    this.districts = addres.getDistrict();
                    var list = this.districts;
                    $(add.address.district).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.district).val(ui.item.label);
                                $(add.address.district).attr('name', ui.item.value);
                                add.address.districtCode = ui.item.districtCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setDistrict(ui.item);
                                $(add.address.city_town).val('');
                                $(add.address.city_town).focus();
                            }, 50);
                        }
                    });
                });
                $(add.address.city_town).focus(function () {
                    this.cities = addres.getCity();
                    var list = this.cities;
                    $(add.address.city_town).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.city_town).val(ui.item.label);
                                $(add.address.city_town).attr('name', ui.item.value);
                                add.address.city_townCode = ui.item.city_townCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setCity(ui.item);
                                $(add.address.st_loc).val('');
                                $(add.address.st_loc).focus();
                            }, 50);
                        }
                    });
                });
                $(add.address.st_loc).focus(function () {
                    this.localities = addres.getLocality();
                    var list = this.localities;
                    $(add.address.st_loc).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.st_loc).val(ui.item.label);
                                $(add.address.st_loc).attr('name', ui.item.value);
                                add.address.st_locCode = ui.item.st_locCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setLocality(ui.item);
                            }, 200);
                        }
                    });
                });
            }
        });
    };

    function validateGYMFields() {
        var flag = false;

        /* gym name name*nmsg*/
        if (checkusr == 0)
        {
            flag = false;
            $(add.user_email).focus();
            return;
        }
        if ($(add.u_user_name).val().match(name_reg)) {
            flag = true;
            $('#user_comsg').html(VALIDNOT);
        } else {
            alert("name")
            flag = false;
            $('#user_comsg').html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#user_comsg').offset().top) - 95
            }, "slow");
            $(add.u_user_name).focus();
            return;
        }
        if ($(add.docvalue).val() != "") {
            flag = true;
            $('#doc_num_msg').html(VALIDNOT);
        } else {
            alert("doc value")
            flag = false;
            $('#doc_num_msg').html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#doc_num_msg').offset().top) - 95
            }, "slow");
            $(add.docvalue).focus();
            return;
        }
        if ($(add.user_email).val().match(email_reg_new)) {
            flag = true;
            $('#user_email_msg').html(VALIDNOT);
        } else {
            flag = false;
            $('#user_email_msg').html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#user_email_msg').offset().top) - 95
            }, "slow");
            $(add.user_email).focus();
            return;
        }
        if ($(add.mobile).val().match(cell_reg_new)) {
            flag = true;
            $('#user_mobile_msg').html(VALIDNOT);
        } else {
            flag = false;
            $('#user_mobile_msg').html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($('#user_mobile_msg').offset().top) - 95
            }, "slow");
            $(add.mobile).focus();
            return;
        }
        var attr = {
            name: $(add.u_user_name).val(),
            gender: $(add.u_user_gender).val(),
            usertype: $(add.addusertype).val(),
            email: $(add.user_email).val(),
            mobile: $(add.mobile).val(),
            doctype: $(add.u_doc_type).val(),
            docvalue: $(add.u_doc_number).val(),
            dob: $(add.user_dob).val(),
            country: $(add.address.country).val(),
            countryCode: add.address.countryCode,
            province: $(add.address.province).val(),
            provinceCode: add.address.provinceCode,
            district: $(add.address.district).val(),
            city_town: $(add.address.city_town).val(),
            st_loc: $(add.address.st_loc).val(),
            addrsline: $(add.address.addrs).val(),
            tphone: $(add.address.tphone).val(),
            pcode: $(add.address.pcode).val(),
            zipcode: $(add.address.zipcode).val(),
            website: $(add.address.website).val(),
            gmaphtml: $(add.address.gmaphtml).val(),
            timezone: add.address.timezone,
            lat: add.address.lat,
            lon: add.address.lon
        };
        if (flag) {
            return attr;
        } else
            return false;
    }
    ;
}
;