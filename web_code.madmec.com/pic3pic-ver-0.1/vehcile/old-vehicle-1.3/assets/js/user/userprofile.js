function profile()
{
    var adddonorform = false;
    var genoccp = {};
    var ctrl = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        fetchGendernOccupation();
        //Calling Profile Info
        fetchListOfIndividualDonor();

        /*  Validating Fields  */
        $(ctrl.form).validate({
            rules: {
                cpassword: {
                    required: true,
                    minlength: 4
                },
                npassword: {
                    required: true,
                    minlength: 4
                },
                cfpassword: {
                    required: true,
                    minlength: 4,
                    equalTo: "#npassword"
                },
            },
            messages: {
                cpassword: {
                    required: "Enter the Currernt Password",
                    minlength: "Length Should be minimum 6 Characters"
                },
                npassword: {
                    required: "Enter the Currernt Password",
                    minlength: "Length Should be minimum 6 Characters"
                },
                cfpassword: {
                    required: "Enter the Confirm Password",
                    minlength: "Length Should be minimum 6 Characters",
                    equalTo: "Password Not Matches"
                },
            },
            submitHandler: function () {
                adddonorform = true;
            }
        });
        $(ctrl.form).submit(function (evt) {
            evt.preventDefault();
            var formdata = $(this).serialize();
            if (adddonorform)
                changePassword(formdata);
        });
    };

    /* Fetching Gender and Occupation From Database */
    function fetchGendernOccupation()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'user/fetchGendernOccupation',
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
                        genoccp = type;
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

    //Profile Edit
    function fetchListOfIndividualDonor()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'userprofile/fetchListOfIndividualDonor',
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
                            window.setTimeout(function () {
                                if (type.donorids.length)
                                {
                                    viewDetails(type.donorids[0], 0, type.alldata);
                                }
                            }, 600);
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

    /* Displaying Donor Details  */
    function viewDetails(donorid, loc, talldata)
    {
        var data = '<div class="col-lg-6">' +
                '<div class="panel panel-info"><div class="col-lg-12 panel-heading"><div class="col-lg-6 text-left">' +
                '<strong>Personal Details</strong>' +
                '</div>' +
                '<div class="col-lg-6 text-right">' +
                '<button  type="button" class="text-info btn btn-warning btn-circle  btn-md" type="button" title="Edit" id="personaledit" ><i class="fa fa-pencil fa-fw "></i></button>&nbsp;</div></div><div class="panel-body" id="pereditbody">' +
                '<div class="col-lg-4"><strong>Full Name</strong></div>  <div class="col-lg-8">' + talldata[loc]['user_name'] + '</div>' +
                '<div class="col-lg-4"><strong>Mobile</strong></div>  <div class="col-lg-8">' + talldata[loc]['cell_number'] + '</div> ' +
                '<div class="col-lg-4"><strong>Alternate Mobile</strong></div>  <div class="col-lg-8">';
        if (talldata[loc]['cell_number1'] == null)
        {
            data += 'Not Provided';
        }
        else
        {
            data += talldata[loc]['cell_number1']
        }
        data += '</div> ' +
                '<div class="col-lg-4"><strong>Gender</strong></div>  <div class="col-lg-8">' + talldata[loc]['gender_name'] + '</div> ' +
                '<div class="col-lg-4"><strong>Occupation</strong></div>  <div class="col-lg-8">' + talldata[loc]['occupation'] + '</div> ' +
                '<div class="col-lg-4"><strong>Land-line</strong></div>  <div class="col-lg-8">' + talldata[loc]['postal_code'] + ' - ' + talldata[loc]['telephone'] + '</div>  ' +
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
        $(ctrl.disdonors).html(data);
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

    /*Binding Address to Edit Details*/
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


    /*  Editing Donor Personal Details  */
    function personalEditDetails(donorid, loc, talldata)
    {
        $('#personaledit').hide();
        var details = '<form id="personaleditform" autocomplete="off">' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Full Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="name" name="name" type="text" value="' + talldata[loc]['user_name'] + '" class="form-control" placeholder="Name"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Mobile : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="mobile" name="mobile" type="text" value="' + talldata[loc]['cell_number'] + '" class="form-control" placeholder="Mobile Number"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong>Alternate Mobile : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="amobile" name="amobile" type="text" value="' + talldata[loc]['cell_number1'] + '" class="form-control" placeholder="Alternate Mobile"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong> <i class="fa fa-star text-danger">&nbsp;</i> Gender : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                ' <select class="form-control" name="gender" id="gender" required=""><option value="' + talldata[loc]['genderid'] + '">' + talldata[loc]['gender_name'] + '</option>' + genoccp.data1 + '</select> ' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <strong> <i class="fa fa-star text-danger">&nbsp;</i> Occupation : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                ' <select class="form-control" name="occupation" id="occupation" required=""><option value="' + talldata[loc]['ocpid'] + '">' + talldata[loc]['occupation'] + '</option>' + genoccp.data2 + '</select> ' +
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
                    eemail: {
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
                    occupation: "required",
                    stdcode: {
                        number: true
                    },
                    landline: {
                        number: true
                    },
                },
                messages: {
                    name: {
                        required: "Enter the FullName",
                        minlength: "Length Should be minimum 3 Characters"
                    },
                    eemail: {
                        required: "Enter the Email_id",
                    },
                    mobile: {
                        required: "Enter the Mobile Number",
                    },
                    gender: "Select the Gender",
                    occupation: "Select the Occupation",
                },
                submitHandler: function () {
                    editpersonalflag = true;
                }
            });
            $('#personaleditform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                if (editpersonalflag)
                {
                    $('#personaleditsave').prop('disabled', 'disabled');
                    $.ajax({
                        type: 'POST',
                        url: ctrl.url,
                        data: formdata + '&autoloader=true&action=userprofile/updateDonorDetails&donorid=' + donorid + '&request=personal',
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
                                        alert("user Details has been Successfully Updated");
                                        fetchListOfIndividualDonor();
                                    }
                                    else
                                    {
                                        alert("user Details hasn't been Updated");
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
                action: 'user/CheckEmail',
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
                    data: formdata + '&autoloader=true&action=user/updateDonorDetails&donorid=' + donorid + '&request=commu',
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
                                    alert("user Details has been Successfully Updated");
                                    fetchListOfIndividualDonor();
                                }
                                else
                                {
                                    alert("user Details hasn't been Updated");
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

    //Change Password
    function changePassword(formdata)
    {
        $(ctrl.but).prop('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=userprofile/changeCurrentPassword',
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
                        var data = $.parseJSON(data);
                        if (data == "success")
                        {
                            alert("Password has been Successfully Changed");
                            $(ctrl.form).get(0).reset();
                            window.setTimeout(function () {
                                window.location.href = "index.php";
                            }, 1000)
                        }
                        else if (data == "notmatch") {
                            alert("Current Password n't matches");
                            $('#cpassword').focus();
                        }
                        else
                        {
                            alert("Password hasn't been Changed");
                            $(ctrl.form).get(0).reset();
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $(ctrl.but).removeAttr('disabled');
            }
        });
    }
}


