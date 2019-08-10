function vehicletype()
{
    var adddonorform = false;
    var eadddonorform = false;
    var ctrl = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        $(ctrl.list.menubut).click(function () {
            fetchVehicleTypes();
        });
        $(ctrl.add.vehicletype).on('change', function () {
            checkEmail("add");
        });
        $(ctrl.add.vehicletype).mouseleave(function () {
            checkEmail("add");
        });

        $(ctrl.add.form).validate({
            submitHandler: function () {
                adddonorform = true;
            }
        });
        $(ctrl.add.form).submit(function (evt) {
            evt.preventDefault();
            var formdata = $(this).serialize();
            if (ctrl.add.emailcheck == 0)
            {
                $(ctrl.add.vehicletype).focus();
                return;
            }
            if (adddonorform && ctrl.add.emailcheck)
            {
                addVehicleType(formdata);
            }
        });

    };
    function addVehicleType(formdata)
    {
        $(ctrl.add.but).prop('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=vehicle/addVehicleType',
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                var res = $.parseJSON(data)
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (res)
                        {
                            alert("Vehicle Type has been Successfully Added");
                            $(ctrl.add.form).get(0).reset();
                        }
                        else
                        {
                            alert("Vehicle Type hasn't been Added");
                            $(ctrl.add.form).get(0).reset();
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $(ctrl.add.but).removeAttr('disabled');
            }
        });
    }

    function updateVehicleType(formdata)
    {
        $('#fromupdate').prop('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=vehicle/updateVehicleType',
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                var res = $.parseJSON(data)
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (res)
                        {
                            alert("Vehicle Type has been Successfully Updated");
                            $(ctrl.add.form).get(0).reset();
                            fetchVehicleTypes();
                        }
                        else
                        {
                            alert("Vehicle Type hasn't been Updated");
                            $(ctrl.add.form).get(0).reset();
                            fetchVehicleTypes();
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $('#fromupdate').removeAttr('disabled');
            }
        });
    }

    function fetchVehicleTypes()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=vehicle/fetchVehicleType',
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                var res = $.parseJSON(data)
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
                            var header = '<div class="table-responsive"><table class="table table-responsive table-bordered table-hover" id="list_col_table"><thead>' +
                                    '<tr><th>#</th><th>Vehicle Type</th><th>Comment</th><th>Option</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $(ctrl.list.disvehicletype).html(header + type.data + footer);
                            window.setTimeout(function () {
                                $('#list_col_table').dataTable();
                                if (type.donorids.length)
                                {

                                    for (i = 0; i < type.donorids.length; i++)
                                    {
                                        $('#donordet_' + type.donorids[i]).bind('click', {
                                            donorid: type.donorids[i],
                                            tloc: i,
                                            talldata: type.alldata,
                                        }, function (evt) {
                                            editDetails(evt.data.donorid, evt.data.tloc, type.alldata);
                                        });
                                        $('#donordel_' + type.donorids[i]).bind('click', {
                                            donorid: type.donorids[i],
                                        }, function (evt) {
                                            deleteVehicle(evt.data.donorid);
                                        });
                                    }
                                }
                            }, 600);
                        }
                        else
                        {
                            $(ctrl.list.disvehicletype).html('<span class="text-danger text-center">no records</span>');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $(ctrl.add.but).removeAttr('disabled');
            }
        });
    }

    function checkEmail(req, id)
    {
        var vtype = '';
        var typeid = 0;
        if (req == "add") {
            vtype = $(ctrl.add.vehicletype).val();
            typeid = 0;
        }
        else
        {
            vtype = $('#evehicletypee').val();
            typeid = id;
        }
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vehicle/checkVehicleType',
                vehicletype: vtype,
                typeid: typeid,
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
                            if (req == "add")
                            {
                                ctrl.add.emailcheck = 0
                                $(ctrl.add.err_email).html("<strong class='text-danger'>VehicleType Already Exist</strog>");
                            }
                            else
                            {
                                ctrl.add.eemailcheck = 0
                                $('#eerr_email').html("<strong class='text-danger'>VehicleType Already Exist</strog>");
                            }
                        }
                        else
                        {
                            if (req == "add")
                            {
                                ctrl.add.emailcheck = 1;
                                $(ctrl.add.err_email).html("");
                            }
                            else
                            {
                                ctrl.add.eemailcheck = 1;
                                $('#eerr_email').html("");
                            }
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


    function editDetails(id, loc, alldata)
    {
        $(ctrl.list.disvehicletype).html('<form id="editvehicletypeform">' +
                '<div class="col-lg-12">' +
                '   <div class="col-lg-12">' +
                '       <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Type : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '   </div>' +
                '   <div class="col-lg-12">' +
                '       <input  id="evehicletypee" name="evehicletype" type="text" value="' + alldata[loc]['name'] + '" class="form-control" placeholder="Vehicle Type" required=""/>' +
                '       <span id="eerr_email"></span>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '   <div class="col-lg-12">' +
                '       <strong><i class="fa fa-star text-danger">&nbsp;</i>Comment : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '   </div>' +
                '   <div class="col-lg-12">' +
                '       <textarea  id="ecomment" name="ecomment"  class="form-control" placeholder="Comment" required="" style="resize: none;">' + alldata[loc]['comment'] + '</textarea>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '   <button type="submit" name="fromupdate" id="fromupdate" class="btn btn-primary btn-lg btn-block">&nbsp UPDATE</button>' +
                '</div>' +
                '</form>');
        window.setTimeout(function () {
            $('#editvehicletypeform').validate({
                submitHandler: function () {
                    eadddonorform = true;
                }
            });
            $('#editvehicletypeform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                if (ctrl.add.eemailcheck == 0)
                {
                    $('#evehicletypee').focus();
                    return;
                }
                if (eadddonorform && ctrl.add.eemailcheck)
                {
                    updateVehicleType(formdata + '&typeid=' + id);
                }
            });
            $('#evehicletypee').on('change', function () {
                checkEmail("edit", id);
            });
            $('#evehicletypee').mouseleave(function () {
                checkEmail("edit", id);
            });
        }, 500);
    }

    function deleteVehicle(id)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vehicle/deleteVehicleType',
                typeid : id
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
                            alert("Vehicle Type has been Successfully Deleted");
                            fetchVehicleTypes();
                        }
                        else
                        {
                            alert("Vehicle Type hasn't been Deleted")
                            fetchVehicleTypes();
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


