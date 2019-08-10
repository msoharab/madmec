function vendor()
{
    var cortype = {};
    var adddonorform = false;
    var ctrl = {};
    var add = {};
    var list = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        add = ctrl.add;
        list = ctrl.list;
        $(list.menubut).click(function () {
            fetchListOfCorporateDonor();
        });
        $(add.email).change(function () {
            checkEmail();
        });
        $(add.email).mouseleave(function () {
            checkEmail();
        });
        fetchCorporateType();

        /*  Validating Fields  */
        $(add.form).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    number: true
                },
                amobile: {
                    number: true
                },
                gender: "required",
                corporatetype: "required",
                stdcode: {
                    number: true
                },
                repmobile: {
                    number: true
                },
                landline: {
                    number: true
                },
                repname: {
                    required: true,
                    minlength: 3
                },
            },
            messages: {
                name: {
                    required: "Enter the Corporate Name",
                    minlength: "Length Should be minimum 3 Characters"
                },
                email: {
                    required: "Enter the Email_id",
                },
                mobile: {
                    required: "Enter the Mobile Number",
                },
                gender: "Select the Gender",
                corporatetype: "Select the Occupation",
                repname: {
                    required: "Enter the Representative Name",
                    minlength: "Length Should be minimum 3 Characters"
                },
            },
            submitHandler: function () {
                adddonorform = true;
            }
        });
        $(add.form).submit(function (evt) {
            evt.preventDefault();
            var formdata = $(this).serialize();
            if (adddonorform)
            {
                $(add.but).prop('disabled', 'disabled');
                $.ajax({
                    type: 'POST',
                    url: ctrl.url,
                    data: formdata + '&autoloader=true&action=vendor/addCorporate',
                    success: function (data, textStatus, xhr) {
                        /*                                        console.log(data);*/
                        data = $.trim(data);
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                if (data)
                                {
                                    alert("vendor has been Successfully Added");
                                    $(add.form).get(0).reset();
                                }
                                else
                                {
                                    alert("vendor hasn't been Added");
                                    $(add.form).get(0).reset();
                                }
                                break;
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        $(add.but).removeAttr('disabled');
                    }
                });
            }
        });
    };

    /*  Binding Address Fields  */
    this.bindAddressFields = function (addres, add) {
        var list = this.countries;
        $(add.country).autocomplete({
            minLength: 2,
            source: list,
            autoFocus: true,
            select: function (event, ui) {
                window.setTimeout(function () {
                    $(add.country).val(ui.item.label);
//					$(add.country).attr('name', ui.item.value);
                    add.countryCode = ui.item.countryCode;
                    add.PCR_reg = ui.item.PCR;
//					dccode = ui.item.Phone;
//					$(cn.codep + '0').val(ui.item.Phone);
//					for (i = 0; i <= cn.num; i++) {
//						$(document.getElementById(cn.codep + i)).val(ui.item.Phone);
//					}
                    addres.setCountry(ui.item);
                    $(add.state).val('');
                    $(add.state).focus();
                }, 50);
                $(add.state).focus(function () {
                    this.states = addres.getState();
                    var list = this.states;
                    $(add.state).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.state).val(ui.item.label);
//								$(add.state).attr('name', ui.item.value);
                                add.provinceCode = ui.item.provinceCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setState(ui.item);
                                $(add.district).val('');
                                $(add.district).focus();
                            }, 50);
                        }
                    });
                });
                $(add.district).focus(function () {
                    this.districts = addres.getDistrict();
                    var list = this.districts;
                    $(add.district).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.district).val(ui.item.label);
//								$(add.district).attr('name', ui.item.value);
                                add.districtCode = ui.item.districtCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setDistrict(ui.item);
                                $(add.city_town).val('');
                                $(add.city_town).focus();
                            }, 50);
                        }
                    });
                });
                $(add.city_town).focus(function () {
                    this.cities = addres.getCity();
                    var list = this.cities;
                    $(add.city_town).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.city_town).val(ui.item.label);
//								$(add.city_town).attr('name', ui.item.value);
                                add.city_townCode = ui.item.city_townCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setCity(ui.item);
                                $(add.st_loc).val('');
                                $(add.st_loc).focus();
                            }, 50);
                        }
                    });
                });
                $(add.st_loc).focus(function () {
                    this.localities = addres.getLocality();
                    var list = this.localities;
                    $(add.st_loc).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.st_loc).val(ui.item.label);
//								$(add.st_loc).attr('name', ui.item.value);
                                add.st_locCode = ui.item.st_locCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setLocality(ui.item);
                            }, 200);
                        }
                    });
                });
            }
        });
    };

    /* Checking Username */
    function checkEmail()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vendor/CheckEmail',
                email: $(add.email).val(),
            },
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (Number(data))
                        {
                            add.emailcheck = 0
                            $(add.err_email).html("<strong class='text-danger'>Email_Id Already Exist</strog>");
                        }
                        else
                        {
                            add.emailcheck = 1;
                            $(add.err_email).html("");
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }

    /* Fetching Corporate Types */
    function fetchCorporateType()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vendor/fetchCorporateType',
            },
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var type = $.parseJSON(data);
                        cortype = type;
                        $(add.discorptype).html('<select class="form-control" name="corporatetype" id="corporatetype" required=""><option value="">Please Select Shop Type</option>' + type.data1 + '</select>');
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }

    function fetchListOfCorporateDonor()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vendor/fetchListOfCorporateDonor',
            },
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var type = $.parseJSON(data);
                        if (type.status == "success")
                        {
                            var header = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="list_col_table1"><thead><tr><th>#</th><th>Shop Name</th><th>Shop Type</th>\n\
                                <th>Mobile</th><th>Email</th><th>Land-Line</th><th>Representative Name</th><th>Option</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $(list.disdonors).html(header + type.data + footer);
                            window.setTimeout(function () {
                                $('#list_col_table1').dataTable();
                                if (type.donorids.length)
                                {

                                    for (i = 0; i < type.donorids.length; i++)
                                    {
                                        $('#donordet_' + type.donorids[i]).bind('click', {
                                            donorid: type.donorids[i],
                                            tloc: i,
                                            talldata: type.alldata,
                                        }, function (evt) {
                                            viewDetails(evt.data.donorid, evt.data.tloc, type.alldata);
                                        });
                                        $('#donordel_' + type.donorids[i]).bind('click', {
                                            donorid: type.donorids[i],
                                        }, function (evt) {
                                            deleteDonor(evt.data.donorid);
                                        });
                                    }
                                }
                            })
                        }
                        else
                        {
                            $(list.disdonors).html('<span class="text-danger text-center">no records</span>');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;

    /* Displaying Corporate Details  */
    function viewDetails(donorid, loc, talldata)
    {
        var data = '<div class="col-lg-6">' +
                '<div class="panel panel-info"><div class="col-lg-12 panel-heading"><div class="col-lg-6 text-left">' +
                '<strong>Personal Details</strong>' +
                '</div>' +
                '<div class="col-lg-6 text-right">' +
                '<button  type="button" class="text-info btn btn-warning btn-circle  btn-md" title="Edit" id="personaledit" ><i class="fa fa-pencil fa-fw "></i></button>&nbsp;</div></div><div class="panel-body" id="pereditbody">' +
                '<div class="col-lg-5"><strong>Shop Name</strong></div>  <div class="col-lg-7">' + talldata[loc]['user_name'] + '</div>' +
                '<div class="col-lg-5"><strong>Shop Type</strong></div>  <div class="col-lg-7">' + talldata[loc]['corporate_type'] + '</div> ' +
                '<div class="col-lg-5"><strong>Email</strong></div>  <div class="col-lg-7">' + talldata[loc]['email_id'] + '</div> ' +
                '<div class="col-lg-5"><strong>Mobile</strong></div>  <div class="col-lg-7">' + talldata[loc]['cell_number'] + '</div> ';
        data += '<div class="col-lg-5"><strong>Land-line</strong></div>  <div class="col-lg-7">' + talldata[loc]['postal_code'] + ' - ' + talldata[loc]['telephone'] + '</div>  ' +
                '<div class="col-lg-5"><strong>Representative Name</strong></div>  <div class="col-lg-7">' + talldata[loc]['representative_name'] + '</div> ' +
                '<div class="col-lg-5"><strong>Representative Mobile</strong></div>  <div class="col-lg-7">' + talldata[loc]['representative_mobile'] + '</div> ' +
                '</div></div>' +
                '</div>';
        data += '<div class="col-lg-6">' +
                '<div class="panel panel-info"><div class="col-lg-12 panel-heading"><div class="col-lg-6 text-left">' +
                '<strong>Communication Details</strong>' +
                '</div>' +
                '<div class="col-lg-6 text-right">' +
                '<button  type="button" class="text-info btn btn-warning btn-circle  btn-md" title="Edit" id="commuedit" ><i class="fa fa-pencil fa-fw "></i></button>&nbsp;</div></div><div class="panel-body"  id="commeditbody">' +
                '<div class="col-lg-4"><strong>Address </strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['addressline'] == null || talldata[loc]['addressline'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['addressline'];
        }
        data += '</div>  ' +
                '<div class="col-lg-4"><strong>Street</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['town'] == null || talldata[loc]['town'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['town'];
        }
        data += '</div> ' +
                '<div class="col-lg-4"><strong>Town</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['city'] == null || talldata[loc]['city'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['city'];
        }
        data += '</div>  ' +
                '<div class="col-lg-4"><strong>District</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['district'] == null || talldata[loc]['district'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['district'];
        }
        data += '</div> ' +
                '<div class="col-lg-4"><strong>State</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['province'] == null || talldata[loc]['province'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['province'];
        }
        data += '</div> ' +
                '<div class="col-lg-4"><strong>Pincode</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['zipcode'] == null || talldata[loc]['zipcode'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['zipcode'];
        }
        data += '</div> ' +
                '<div class="col-lg-4"><strong>Country</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['country'] == null || talldata[loc]['country'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['country'];
        }
        data += '</div>  ' +
                '<div class="col-lg-4"><strong>Website</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['website'] == null || talldata[loc]['website'] == "")
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['website'];
        }
        data += '</div>  ' +
                '</div></div>' +
                '</div>';
        $(list.disdonors).html(data);
        window.setTimeout(function () {
            $('#personaledit').click(function () {
                personalEditDetails(donorid, loc, talldata);
            });
            $('#commuedit').click(function () {
                communicationAddressEditDetails(donorid, loc, talldata);
            });
        }, 300)
    }
    ;

    /*  Editing Donor Personal Details  */
    function personalEditDetails(donorid, loc, talldata)
    {
        $('#personaledit').hide();
        var details = '<form id="personaleditform" autocomplete="off">' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Shop Name  : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="name" name="name" type="text" value="' + talldata[loc]['user_name'] + '" class="form-control" placeholder="Corporate Name "/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Shop Type  : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                ' <select class="form-control" name="corporatetype" id="corporatetype" required=""><option value="' + talldata[loc]['corpid'] + '">' + talldata[loc]['corporate_type'] + '</option>' + cortype.data1 + '</select> ' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Email : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="eemail" name="email" type="text" value="' + talldata[loc]['email_id'] + '" class="form-control" placeholder="Email"/>' +
                '  <span id="err_email1"></span></div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Mobile : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="mobile" name="mobile" type="text" value="' + talldata[loc]['cell_number'] + '" class="form-control" placeholder="Mobile Number"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong>STD CODE : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="stdcode" name="stdcode" type="text" value="' + talldata[loc]['postal_code'] + '" class="form-control" placeholder="STD Code"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong>TelePhone : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="landline" name="landline" type="text" value="' + talldata[loc]['telephone'] + '" class="form-control" placeholder="Telephone"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong>Representative Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="repname" name="repname" type="text" value="' + talldata[loc]['representative_name'] + '" class="form-control" placeholder="Representative Name"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong>Representative Mobile : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="repmobile" name="repmobile" type="text" value="' + talldata[loc]['representative_mobile'] + '" class="form-control" placeholder="Representative Mobile"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <button  type="submit" class="text-info btn btn-success"  id="personaleditsave" ><i class="fa fa-upload fa-fw "></i>&nbsp;UPDATE</button>&nbsp;' +
                ' <button  type="button" class="text-info btn btn-danger" id="personaleditclose" ><i class="fa fa-close fa-fw "></i>&nbsp;CLOSE</button>&nbsp;' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '</form>';
        $('#pereditbody').html(details)
        window.setTimeout(function () {
            $('#personaleditclose').click(function () {
                $('#personaledit').show();
                viewDetails(donorid, loc, talldata);
            });
            $('#eemail').change(function () {
                checkEditEmail(donorid);
            });
            $('#eemail').mouseleave(function () {
                checkEditEmail(donorid);
            });
            var editpersonalflag = false;
            $('#personaleditform').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: {
                        required: true,
                        number: true
                    },
                    amobile: {
                        number: true
                    },
                    gender: "required",
                    corporatetype: "required",
                    stdcode: {
                        number: true
                    },
                    repmobile: {
                        number: true
                    },
                    landline: {
                        number: true
                    },
                    repname: {
                        required: true,
                        minlength: 3
                    },
                },
                messages: {
                    name: {
                        required: "Enter the Corporate Name",
                        minlength: "Length Should be minimum 3 Characters"
                    },
                    email: {
                        required: "Enter the Email_id",
                    },
                    mobile: {
                        required: "Enter the Mobile Number",
                    },
                    gender: "Select the Gender",
                    corporatetype: "Select the Occupation",
                    repname: {
                        required: "Enter the Representative Name",
                        minlength: "Length Should be minimum 3 Characters"
                    },
                },
                submitHandler: function () {
                    editpersonalflag = true;
                }
            });
            $('#personaleditform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                if (add.eemailcheck == 0)
                {
                    $('#eemail').focus();
                    return;
                }
                if (editpersonalflag && add.eemailcheck)
                {
                    $('#personaleditsave').prop('disabled', 'disabled');
                    $.ajax({
                        type: 'POST',
                        url: ctrl.url,
                        data: formdata + '&autoloader=true&action=vendor/updateDonorDetails&donorid=' + donorid + '&request=personal',
                        success: function (data, textStatus, xhr) {
                            /*                                        console.log(data);*/
                            data = $.trim(data);
                            switch (data) {
                                case 'logout':
                                    logoutAdmin({});
                                    break;
                                case 'login':
                                    loginAdmin({});
                                    break;
                                default:
                                    if (data)
                                    {
                                        alert("vendor Details has been Successfully Updated");
                                        fetchListOfCorporateDonor();
                                    }
                                    else
                                    {
                                        alert("vendor Details hasn't been Updated");
                                        viewDetails(donorid, loc, talldata);
                                    }
                                    break;
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                            $('#personaleditsave').removeAttr('disabled');
                        }
                    });
                }
            });
        }, 600)
    }
    ;

    /* Checking Edit Donor Email _ ID */
    function checkEditEmail(donorid)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vendor/CheckEmail',
                email: $('#eemail').val(),
                donorid: donorid

            },
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (Number(data))
                        {
                            add.eemailcheck = 0
                            $('#err_email1').html("<strong class='text-danger'>Email_Id Already Exist</strog>");
                        }
                        else
                        {
                            add.eemailcheck = 1;
                            $('#err_email1').html("");
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }

    /*  Edit Donor Communication Address Details  */
    function communicationAddressEditDetails(donorid, loc, talldata)
    {
        $('#commuedit').hide();
        var details = '<form id="communicationeditform">' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i> Country : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="ecountry" name="country" type="text" value="' + talldata[loc]['country'] + '" class="form-control" placeholder="Country"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>State / Province : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="eprovince" name="province" type="text" value="' + talldata[loc]['province'] + '" class="form-control" placeholder="Email State / Province"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>District / Department : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="edistrict" name="district" type="text" value="' + talldata[loc]['district'] + '" class="form-control" placeholder="District / Department"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong> City / Town : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="ecity_town" name="city_town" type="text" value="' + talldata[loc]['city'] + '" class="form-control" placeholder="City / Town"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong> <i class="fa fa-star text-danger">&nbsp;</i> Street / Locality  : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="est_loc" name="st_loc" type="text" value="' + talldata[loc]['town'] + '" class="form-control" placeholder="Street / Locality :"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong> <i class="fa fa-star text-danger">&nbsp;</i>  Address Line : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="eaddrs" name="addrs" type="text" value="' + talldata[loc]['addressline'] + '" class="form-control" placeholder=" Address Line"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong>Zipcode : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="ezipcode" name="zipcode" type="text" value="' + talldata[loc]['zipcode'] + '" class="form-control" placeholder="Zipcode"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong>Website : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="ewebsite" name="website" type="text" value="' + talldata[loc]['website'] + '" class="form-control" placeholder="Personal Website"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <button  type="submit" class="text-info btn btn-success"  id="commueditsave" ><i class="fa fa-upload fa-fw "></i>&nbsp;UPDATE</button>&nbsp;' +
                ' <button  type="button" class="text-info btn btn-danger" id="commueditclose" ><i class="fa fa-close fa-fw "></i>&nbsp;CLOSE</button>&nbsp;' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '</form>';
        $('#commeditbody').html(details)
        window.setTimeout(function () {
            $('#commueditclose').click(function () {
                $('#personaledit').show();
                viewDetails(donorid, loc, talldata);
            });
            var custdata = {
                url: URL + 'address.php',
                country: "#ecountry",
                state: "#eprovince",
                district: "#edistrict",
                city_town: "#ecity_town",
                street: "#est_loc",
                address: "#eaddrs",
                zipcode: "#ezipcode",
                website: "#ewebsite",
            };
            addres = new Address();
            addres.__construct({
                url: custdata.url,
            });
            this.countries = addres.getCountry();
            bindEditAddressFields(addres, custdata);
            var editpersonalflag = false;
            $('#communicationeditform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                $('#commueditsave').prop('disabled', 'disabled');
                $.ajax({
                    type: 'POST',
                    url: ctrl.url,
                    data: formdata + '&autoloader=true&action=vendor/updateDonorDetails&donorid=' + donorid + '&request=commu',
                    success: function (data, textStatus, xhr) {
                        /*                                        console.log(data);*/
                        data = $.trim(data);
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                if (data)
                                {
                                    alert("vendor Details has been Successfully Updated");
                                    fetchListOfCorporateDonor();
                                }
                                else
                                {
                                    alert("vendor Details hasn't been Updated");
                                    viewDetails(donorid, loc, talldata);
                                }
                                break;
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        $('#commueditsave').removeAttr('disabled');
                    }
                });
            });
        }, 600)
    }
    ;
    /* Delete Coporate Details  */
    function deleteDonor(donorid)
    {

        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vendor/deleteDonor',
                donorid: donorid
            },
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (data)
                        {
                            alert("Vendor has been Successfully Deleted");
                            fetchListOfCorporateDonor();
                        }
                        else
                        {
                            alert("Vendor hasn't been Deleted")
                            fetchListOfCorporateDonor();
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });

    }
    ;
    /*Binding Address to Edit Corporate Details*/
    function bindEditAddressFields(addres, add)
    {
        var list = this.countries;
        $(add.country).autocomplete({
            minLength: 2,
            source: list,
            autoFocus: true,
            select: function (event, ui) {
                window.setTimeout(function () {
                    $(add.country).val(ui.item.label);
//					$(add.country).attr('name', ui.item.value);
                    add.countryCode = ui.item.countryCode;
                    add.PCR_reg = ui.item.PCR;
//					dccode = ui.item.Phone;
//					$(cn.codep + '0').val(ui.item.Phone);
//					for (i = 0; i <= cn.num; i++) {
//						$(document.getElementById(cn.codep + i)).val(ui.item.Phone);
//					}
                    addres.setCountry(ui.item);
                    $(add.state).val('');
                    $(add.state).focus();
                }, 50);
                $(add.state).focus(function () {
                    this.states = addres.getState();
                    var list = this.states;
                    $(add.state).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.state).val(ui.item.label);
//								$(add.state).attr('name', ui.item.value);
                                add.provinceCode = ui.item.provinceCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setState(ui.item);
                                $(add.district).val('');
                                $(add.district).focus();
                            }, 50);
                        }
                    });
                });
                $(add.district).focus(function () {
                    this.districts = addres.getDistrict();
                    var list = this.districts;
                    $(add.district).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.district).val(ui.item.label);
//								$(add.district).attr('name', ui.item.value);
                                add.districtCode = ui.item.districtCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setDistrict(ui.item);
                                $(add.city_town).val('');
                                $(add.city_town).focus();
                            }, 50);
                        }
                    });
                });
                $(add.city_town).focus(function () {
                    this.cities = addres.getCity();
                    var list = this.cities;
                    $(add.city_town).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.city_town).val(ui.item.label);
//								$(add.city_town).attr('name', ui.item.value);
                                add.city_townCode = ui.item.city_townCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setCity(ui.item);
                                $(add.st_loc).val('');
                                $(add.st_loc).focus();
                            }, 50);
                        }
                    });
                });
                $(add.st_loc).focus(function () {
                    this.localities = addres.getLocality();
                    var list = this.localities;
                    $(add.st_loc).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.st_loc).val(ui.item.label);
//								$(add.st_loc).attr('name', ui.item.value);
                                add.st_locCode = ui.item.st_locCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setLocality(ui.item);
                            }, 200);
                        }
                    });
                });
            }
        });
    }
    ;
}

