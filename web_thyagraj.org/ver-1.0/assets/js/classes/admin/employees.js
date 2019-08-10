function user() {
    var genoccp = {};
    var adddonorform = false;
    var ctrl = {};
    var add = {};
    var list = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        add = ctrl.add;
        list = ctrl.list;

        $(list.menubut).click(function () {
            fetchListOfEmployees();
        })
        $(add.email).change(function () {
            checkEmail();
        });
        $(add.email).mouseleave(function () {
            checkEmail();
        });
        $(add.empid).change(function () {
            checkEmpId();
        });
        $(add.empid).mouseleave(function () {
            checkEmpId();
        });
        fetchGendernOccupation();

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
                    number: true,
                    minlength: 10,
                    maxlength: 15
                },
                empid: {
                    required: true,
                    minlength: 3
                },
                gender: "required"
            },
            messages: {
                name: {
                    required: "Enter the FullName",
                    minlength: "Length Should be minimum 3 Characters"
                },
                email: {
                    required: "Enter the Email_id",
                },
                empid: {
                    required: "Enter the Employee Id",
                    minlength: "Length Should be minimum 3 Characters"
                },
                mobile: {
                    number: "Enter Numeric Value",
                    required: "Enter the Mobile Number",
                    minlength: "Minimum 10 Digits",
                    maxlength: "Maximum 15 Digits"
                },
                gender: "Select the Gender"
            },
            submitHandler: function () {
                adddonorform = true;
            }
        });
        $(add.form).submit(function (evt) {
            evt.preventDefault();
            var formdata = $(this).serialize();
            if (add.emailcheck == 0) {
                $(add.email).focus();
                return;
            } else if (add.empidcheck == 0) {
                $(add.empid).focus();
                return;
            } else if (adddonorform && add.emailcheck && add.empidcheck) {
                $(add.but).prop('disabled', 'disabled');
                $.ajax({
                    type: 'POST',
                    url: ctrl.url,
                    data: formdata + '&autoloader=true&action=user/addEmployee',
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
                                if (data) {
                                    alert("user has been Successfully Added");
                                    $(add.err_email).html("");
                                    $(add.err_empid).html("");
                                    adddonorform = false;
                                    $(add.form).get(0).reset();
                                } else {
                                    alert("user hasn't been Added");
                                    $(add.err_email).html("");
                                    $(add.err_empid).html("");
                                    adddonorform = false;
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
        $(list.menubut).trigger('click');
    };

    /* Checking Username */
    function checkEmail() {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'user/CheckEmail',
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
                        if (Number(data)) {
                            add.emailcheck = 0
                            $(add.err_email).html("<strong class='text-danger'>Email_Id Already Exist</strog>");
                        } else {
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
    /* Checking Username */
    function checkEmpId() {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'user/checkEmpId',
                email: $(add.empid).val(),
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
                        if (Number(data)) {
                            add.empidcheck = 0
                            $(add.err_empid).html("<strong class='text-danger'>Employee Id Already Exist</strog>");
                        } else {
                            add.empidcheck = 1;
                            $(add.err_empid).html("");
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

    /* Fetching Gender and Occupation From Database */
    function fetchGendernOccupation() {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'user/fetchGendernOccupation',
            },
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
                        var type = $.parseJSON(data);
                        genoccp = type;
                        $(add.disgender).html('<select class="form-control" name="gender" id="gender" required=""><option value="">Please Select Gender</option>' + type.data1 + '</select>');
                        //$(add.disoccup).html('<select class="form-control" name="occupation" id="occupation" required=""><option value="">Please Select Occupation</option>' + type.data2 + '</select>')
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

    /* Fetching List of Individual Donor */
    function fetchListOfEmployees() {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'user/fetchListOfEmployees',
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
                        if (type.status == "success") {
                            var header = '<div class="table-responsive"><table class="table table-responsive table-bordered table-hover" id="list_col_table"><thead>' +
                                    '<tr><th>#</th><th>Employee ID</th><th>Full Name</th><th>Mobile</th><th>Email</th><th>Gender</th><th>Option</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $(list.disdonors).html(header + type.data + footer);
                            window.setTimeout(function () {
                                $('#list_col_table').dataTable();
                                if (type.donorids.length) {

                                    for (i = 0; i < type.donorids.length; i++) {
                                        $("#list_col_table").on("click", "#donordet_" + type.donorids[i], {
                                            donorid: type.donorids[i],
                                            tloc: i,
                                            talldata: type.alldata,
                                        }, function (evt) {
                                            viewDetails(evt.data.donorid, evt.data.tloc, type.alldata);
                                        });

                                        $("#list_col_table").on("click", "#donordel_" + type.donorids[i], {
                                            donorid: type.donorids[i],
                                        }, function (evt) {
                                            deleteDonor(evt.data.donorid);
                                        });
                                    }
                                }
                            }, 600);
                        } else {
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

    /* Displaying Donor Details  */
    function viewDetails(donorid, loc, talldata) {
        var telephone = '';
        var addrs = '';
        if (talldata[loc]['telephone'] == "" || talldata[loc]['telephone'] == null) {
            telephone = ' - ';
        } else {
            telephone = talldata[loc]['telephone'];
        }
        if (talldata[loc]['address'] == "" || talldata[loc]['address'] == null) {
            addrs = '- ';
        } else {
            addrs = talldata[loc]['address'];
        }
        var data = '<div class="col-lg-12">' +
                '<div class="panel panel-info"><div class="col-lg-12 panel-heading"><div class="col-lg-6 text-left">' +
                '<strong>Personal Details</strong>' +
                '</div>' +
                '<div class="col-lg-6 text-right">' +
                '<button  type="button" class="text-info btn btn-warning btn-circle  btn-md" type="button" title="Edit" id="personaledit" ><i class="fa fa-pencil fa-fw "></i></button>&nbsp;</div></div><div class="panel-body" id="pereditbody">' +
                '<div class="col-lg-4"><strong>Employee ID</strong></div>  <div class="col-lg-8">' + talldata[loc]['emp_id'] + '</div>' +
                '<div class="col-lg-4"><strong>Full Name</strong></div>  <div class="col-lg-8">' + talldata[loc]['user_name'] + '</div>' +
                '<div class="col-lg-4"><strong>Email</strong></div>  <div class="col-lg-8">' + talldata[loc]['email_id'] + '</div> ' +
                '<div class="col-lg-4"><strong>Mobile</strong></div>  <div class="col-lg-8">' + talldata[loc]['cell_number'] + '</div> ' +
                '';
        data += ' ' +
                '<div class="col-lg-4"><strong>Gender</strong></div>  <div class="col-lg-8">' + talldata[loc]['gender_name'] + '</div> ' +
                '<div class="col-lg-4"><strong>Telephone</strong></div>  <div class="col-lg-8">' + telephone + '&nbsp;</div>  ' +
                '<div class="col-lg-4"><strong>Address</strong></div>  <div class="col-lg-8">' + addrs + '</div> ' +
                '</div></div>' +
                '</div>';
        data += '</div>  ' +
                '</div></div>' +
                '</div>';
        $(list.disdonors).html(data);
        window.setTimeout(function () {
            $('#personaledit').click(function () {
                personalEditDetails(donorid, loc, talldata);
            });
        }, 300)
    }
    ;

    /*  Editing Donor Personal Details  */
    function personalEditDetails(donorid, loc, talldata) {
        var telephone = '';
        var addrs = '';
        if (talldata[loc]['telephone'] == "" || talldata[loc]['telephone'] == null) {
            telephone = '-';
        } else {
            telephone = talldata[loc]['telephone'];
        }
        if (talldata[loc]['address'] == "" || talldata[loc]['address'] == null) {
            addrs = '-';
        } else {
            addrs = talldata[loc]['address'];
        }
        $('#personaledit').hide();
        var details = '<form id="personaleditform" autocomplete="off">' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Full Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="name" name="name" type="text" value="' + talldata[loc]['user_name'] + '" class="form-control" placeholder="Name"/>' +
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
                ' <strong> <i class="fa fa-star text-danger">&nbsp;</i> Gender : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                ' <select class="form-control" name="gender" id="gender" required=""><option value="' + talldata[loc]['genderid'] + '">' + talldata[loc]['gender_name'] + '</option>' + genoccp.data1 + '</select> ' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                '' +
                ' <div class="col-lg-12">' +
                '    <strong>Employee ID : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '   <input  id="eempid" name="eempid" type="text" class="form-control" value="' + talldata[loc]['emp_id'] + '" placeholder="Employee ID" />' +
                '  <span id="eerr_empid"></span>' +
                ' </div>' +
                '' +
                '<div class="col-lg-12">' +
                ' <strong>TelePhone : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="landline" name="landline" type="text" value="' + telephone + '" class="form-control" placeholder="Telephone"/>' +
                '  </div><div class="col-lg-12">&nbsp;</div>' +
                ' ' +
                '<div class="col-lg-12">' +
                '   <strong><span class="text-danger"></span> Address Line :<i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '<div class="col-lg-12">' +
                '   <textarea class="form-control" placeholder="Address" name="addrs" id="addrs">' + addrs + '</textarea>' +
                '  <p class="help-block" id="gym_admsg">&nbsp;</p>' +
                ' </div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <button  type="submit" class="text-info btn btn-success"  id="personaleditsave" ><i class="fa fa-upload fa-fw "></i>&nbsp;UPDATE</button>&nbsp;' +
                ' <button  type="reset" class="text-info btn btn-warning" id="personaleditreset" ><i class="fa fa-refresh fa-fw "></i>&nbsp;RESET</button>&nbsp;' +
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
            $('#eempid').change(function () {
                checkEditEmpId(donorid);
            });
            $('#eempid').mouseleave(function () {
                checkEditEmpId(donorid);
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
                        number: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    eempid: {
                        required: true,
                        minlength: 3
                    },
                    gender: "required"
                },
                messages: {
                    name: {
                        required: "Enter the FullName",
                        minlength: "Length Should be minimum 3 Characters"
                    },
                    eemail: {
                        required: "Enter the Email_id",
                    },
                    eempid: {
                        required: "Enter the Employee Id",
                        minlength: "Length Should be minimum 3 Characters"
                    },
                    mobile: {
                        number: "Enter Numeric Value",
                        required: "Enter the Mobile Number",
                        minlength: "Minimum 10 Digits",
                        maxlength: "Maximum 15 Digits"
                    },
                    gender: "Select the Gender"
                },
                submitHandler: function () {
                    editpersonalflag = true;
                }
            });
            $('#personaleditform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                if (add.eemailcheck == 0) {
                    $('#eemail').focus();
                    return;
                }
                if (add.eempidcheck == 0) {
                    $('#eempid').focus();
                    return;
                }
                if (editpersonalflag && add.eemailcheck && add.eempidcheck) {
                    $('#personaleditsave').prop('disabled', 'disabled');
                    $.ajax({
                        type: 'POST',
                        url: ctrl.url,
                        data: formdata + '&autoloader=true&action=user/updateDonorDetails&donorid=' + donorid + '&request=personal',
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
                                    if (data) {
                                        alert("Employee Details has been Successfully Updated");
                                        add.eempidcheck == 2;
                                        add.eemailcheck == 2;
                                        fetchListOfEmployees();
                                    } else {
                                        alert("Employee Details hasn't been Updated");
                                        add.eempidcheck == 2;
                                        add.eemailcheck == 2;
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
    function checkEditEmail(donorid) {
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
                        if (Number(data)) {
                            add.eemailcheck = 0
                            $('#err_email1').html("<strong class='text-danger'>Email_Id Already Exist</strog>");
                        } else {
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

    /* Checking Edit Employee ID */
    function checkEditEmpId(donorid) {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'user/checkEmpId',
                email: $('#eempid').val(),
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
                        if (Number(data)) {
                            add.eempidcheck = 0
                            $('#eerr_empid').html("<strong class='text-danger'>Employee Id Already Exist</strog>");
                        } else {
                            add.eempidcheck = 1;
                            $('#eerr_empid').html("");
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
    function communicationAddressEditDetails(donorid, loc, talldata) {
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
                                if (data) {
                                    alert("user Details has been Successfully Updated");
                                    fetchListOfEmployees();
                                } else {
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
    /* Delete Donor Details  */
    function deleteDonor(donorid) {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'user/deleteDonor',
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
                        if (data) {
                            alert("user has been Successfully Deleted");
                            fetchListOfEmployees();
                        } else {
                            alert("user hasn't been Deleted")
                            fetchListOfEmployees();
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
}
