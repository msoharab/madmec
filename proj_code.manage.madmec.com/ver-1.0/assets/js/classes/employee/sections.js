function sections() {
    var genoccp = {};
    var adddonorform = false;
    var ctrl = {};
    var add = {};
    var list = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        add = ctrl.add;
        list = ctrl.list;
        $(list.menuBut).click(function () {
            fetchListOfEmployees();
        })
        $(add.email).change(function () {
            var name = $(add.email).val();
            console.log(name);
            if (name.length > 2)
                checkEmail();
        });
        $(add.email).mouseleave(function () {
            var name = $(add.email).val();
            console.log(name);
            if (name.length > 2)
                checkEmail();
        });

        /*  Validating Fields  */
        $(add.form).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
            },
            messages: {
                name: {
                    required: "Enter the Section Name",
                    minlength: "Length Should be minimum 2 Characters"
                },
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
            } else if (adddonorform && add.emailcheck) {
                $(add.but).prop('disabled', 'disabled');
                $.ajax({
                    type: 'POST',
                    url: ctrl.url,
                    data: formdata + '&autoloader=true&action=activity/addEmployee',
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
                                if (data) {
                                    alert("Section has been Successfully Added");
                                    $(add.err_email).html("");
                                    adddonorform = false;
                                    $(add.form).get(0).reset();
                                } else {
                                    alert("Section hasn't been Added");
                                    $(add.err_email).html("");
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
                action: 'activity/CheckEmail',
                email: $(add.email).val()
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (Number(data) > 0) {
                            add.emailcheck = 0
                            $(add.err_email).html("<strong class='text-danger'>Section Name Already Exist</strog>");
                        } else {
                            add.emailcheck = 1;
                            $(add.err_email).html("<strong class='text-success'>Section Name Is Unique</strog>");
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
    /* Fetching List of Individual Donor */
    function fetchListOfEmployees() {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'activity/fetchListOfEmployees',
            },
            success: function (data, textStatus, xhr) {
                /* console.log(data);*/
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
                                    '<tr><th>#</th><th>Section Name</th><th>Description</th><th>Updated At</th><th>Option</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $(list.display).html(header + type.data + footer);
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
                            $(list.disdonors).html('<span class="text-danger text-center">No Records</span>');
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
        var updated = '';
        if (talldata[loc]['updated_at'] == null || talldata[loc]['updated_at'] == '')
        {
            updated = 'Not Yet Updated';
        }
        else
        {
            updated = talldata[loc]['updated_at'];
        }
        var desc = '';
        if (talldata[loc]['description'] == null || talldata[loc]['description'] == '')
        {
            desc = 'Not Provided';
        }
        else
        {
            desc = talldata[loc]['description'];
        }
        var data = '<div class="col-lg-12">' +
                '<div class="panel panel-info"><div class="col-lg-12 panel-heading"><div class="col-lg-6 text-left">' +
                '<strong>Details</strong>' +
                '</div>' +
                '<div class="col-lg-6 text-right">' +
                '<button  type="button" class="text-info btn btn-warning btn-circle  btn-md" type="button" title="Edit" id="personaledit" ><i class="fa fa-pencil fa-fw "></i></button>&nbsp;</div></div><div class="panel-body" id="pereditbody">' +
                '<table class="table table-hover"><tbody>' +
                '<tr><td><strong>Section Name</strong></td>  <td>' + talldata[loc]['section_name'] + '</td></tr>' +
                '<tr><td><strong>Created At</strong></td> <td>' + talldata[loc]['created_at'] + '</td></tr>' +
                '<tr><td><strong>Updated At</strong></td>  <td>' + updated + '</td> </tr>' +
                '<tr><td><strong>Description</strong></td>  <td>' + desc + '</td> </tr>' +
                '</tbody></table>';
        data += ' ' +
                '</div></div>' +
                '</div>';
        data += '</div>  ' +
                '</div></div>' +
                '</div>';
        $(list.display).html(data);
        window.setTimeout(function () {
            $('#personaledit').click(function () {
                personalEditDetails(donorid, loc, talldata);
            });
        }, 300)
    }
    ;

    /*  Editing Donor Personal Details  */
    function personalEditDetails(donorid, loc, talldata) {
        $('#personaledit').hide();
        var details = '<form id="personaleditform" autocomplete="off">' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Section Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                ' <div class="col-lg-12">' +
                '  <input  id="ename" name="ename" type="text" value="' + talldata[loc]['section_name'] + '" class="form-control" placeholder="Name"/>' +
                '  <span id="err_email1"></span></div><div class="col-lg-12">&nbsp;</div>' +
                '' +
                '<div class="col-lg-12">' +
                '   <strong><span class="text-danger"></span>  Description :<i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '<div class="col-lg-12">' +
                '   <textarea class="form-control" placeholder="Description" name="addrs" id="addrs" >' + talldata[loc]['description'] + '</textarea>' +
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
            $('#ename').change(function () {
                checkEditEmail(donorid);
            });
            $('#ename').mouseleave(function () {
                checkEditEmail(donorid);
            });
            var editpersonalflag = false;
            $('#personaleditform').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                },
                messages: {
                    name: {
                        required: "Enter the Section Name",
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
                if (add.eemailcheck == 0) {
                    $('#ename').focus();
                    return;
                }
                if (editpersonalflag && add.eemailcheck) {
                    $('#personaleditsave').prop('disabled', 'disabled');
                    $.ajax({
                        type: 'POST',
                        url: ctrl.url,
                        data: formdata + '&autoloader=true&action=activity/updateDonorDetails&donorid=' + donorid + '&request=personal',
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
                                        alert("Section Details has been Successfully Updated");
                                        add.eempidcheck == 2;
                                        add.eemailcheck == 2;
                                        fetchListOfEmployees();
                                    } else {
                                        alert("Section Details hasn't been Updated");
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
                action: 'activity/CheckEmail',
                email: $('#ename').val(),
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
                            $('#err_email1').html("<strong class='text-danger'>Section Name Already Exist</strog>");
                        } else {
                            add.eemailcheck = 1;
                            $('#err_email1').html("<strong class='text-success'>Section Name Is Unique</strog>");
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
                action: 'activity/checkEmpId',
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
                            $('#eerr_empid').html("<strong class='text-danger'>Section Id Already Exist</strog>");
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

    /* Delete Donor Details  */
    function deleteDonor(donorid) {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'activity/deleteDonor',
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
                            alert("Section has been Successfully Deleted");
                            fetchListOfEmployees();
                        } else {
                            alert("Section hasn't been Deleted")
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
;
