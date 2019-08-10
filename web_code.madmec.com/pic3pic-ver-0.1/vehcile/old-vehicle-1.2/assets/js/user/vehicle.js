function vehicle()
{
    var adddonorform = false;
    var vehtype = {};
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        $(ctrl.list.menubut).click(function () {
            fetchListOfVehicles();
        })
        $(ctrl.add.form).validate({
            submitHandler: function () {
                adddonorform = true;
            }
        });
        $(ctrl.add.form).submit(function (evt) {
            evt.preventDefault();
            var formdata = $(this).serialize();
            if (adddonorform)
            {
                addVehicle(formdata);
            }
        });

        fetchVehicleType();
        fetchServiceCenters();
    };

    function  addVehicle(formdata)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=uservehicle/addVehicle&psid=' + ctrl.add.pscenterid,
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
                        if (type)
                        {
                            alert("Vehicle Has been Successfully Added");
                            $(ctrl.add.form).get(0).reset();
                            fetchVehicleType();
                        }
                        else
                        {
                            alert("Vehicle Hasn't been Added");
                            $(ctrl.add.form).get(0).reset();
                            fetchVehicleType();
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

    function fetchVehicleType()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vehicle/fetchVehicleTypes',
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
                        vehtype = type;
                        var data1 = '';
                        if (type.status = "success")
                        {
                            if (type.data.length)
                            {
                                for (i = 0; i < type.data.length; i++)
                                {
                                    data1 += type.data[i];
                                }
                            }
                        }
                        $(ctrl.add.displayvtype).html('<select class="form-control" name="vehicletype" id="vehicletypee" required=""><option value="">Please Select Vehicle Type</option>' + data1 + '</select>');
                        window.setTimeout(function () {
                            $('#vehicletypee').change(function () {
                                fetchVehicleMakes(this.value, "add");
                            });
                        }, 600)
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

    function fetchServiceCenters()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'uservehicle/fetchServiceCenters',
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
                        var services = new Array();
                        if (type.status == "success")
                        {
                            if (type.data.length)
                            {
                                for (i = 0; i < type.data.length; i++)
                                {
                                    services.push({
                                        label: type.data[i],
                                        value: type.data[i],
                                        id: type.ids[i],
                                    });
                                }
                                $(ctrl.add.pscenter).autocomplete({
                                    source: services,
                                    autoFocus: true,
                                    minLength: 1,
                                    delay: 0,
                                    select: function (event, ui) {
                                        ctrl.add.pscenterid = ui.item.id
                                    }
                                });
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

    function fetchVehicleMakes(vtypeid, req)
    {
        if (req == "edit")
        {
            $('#edisplayvmake').html('Loading..');
        }
        else
        {
            $(ctrl.add.displayvmake).html('Loading..');
        }
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vehicle/fetchVehicleMakes',
                vtypeid: vtypeid
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
                        var data111 = '';
                        if (type.status = "success")
                        {
                            if (type.data.length)
                            {
                                for (i = 0; i < type.data.length; i++)
                                {
                                    data111 += type.data[i];
                                }
                            }
                        }
                        if (req == "edit")
                        {
                            $('#edisplayvmake').html('<select class="form-control" name="evehicalmakee" id="evehicalmakee" required=""><option value="">Please Select Vehicle Make</option>' + data111 + '</select>');
                        }
                        else {
                            $(ctrl.add.displayvmake).html('<select class="form-control" name="vehicalmakee" id="vehicalmakee" required=""><option value="">Please Select Vehicle Make</option>' + data111 + '</select>');
                        }
                        window.setTimeout(function () {
                            $('#evehicalmakee').change(function () {
                                fetchVehicelModel(this.value, "edit");
                            })
                            $('#vehicalmakee').change(function () {
                                fetchVehicelModel(this.value, "add");
                            })
                        }, 500)
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
    function fetchVehicelModel(makeid, req)
    {
        if (req == "edit")
        {
            $('#edisplayvmodel').html('Loading..');
        }
        else {
            $(ctrl.add.displayvmodel).html('Loading..');
        }
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vehicle/fetchVehicleModels',
                makeid: makeid
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
                        var data112 = '';
                        if (type.status = "success")
                        {
                            if (type.data.length)
                            {
                                for (i = 0; i < type.data.length; i++)
                                {
                                    data112 += type.data[i];
                                }
                            }
                        }
                        if (req == "edit")
                        {
                            $('#edisplayvmodel').html('<select class="form-control" name="evehiclemodel" id="evehiclemodel" required=""><option value="">Please Select Vehicle Model</option>' + data112 + '</select>');
                        }
                        else {
                            $(ctrl.add.displayvmodel).html('<select class="form-control" name="vehiclemodel" id="vehiclemodel" required=""><option value="">Please Select Vehicle Model</option>' + data112 + '</select>');
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

    function fetchListOfVehicles()
    {
        $(ctrl.list.disvehicletype).html('Loading.....');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=uservehicle/fetchListOfVehicles',
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
                                    '<tr><th>#</th><th>Vehicle Nick Name</th><th>Vehicle Reg no.</th><th>Model</th><th>Comment</th><th>Option</th></tr></thead><tbody>';
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

    function editDetails(id, loc, alldata)
    {
        var data11 = '';
        if (vehtype.status = "success")
        {
            if (vehtype.data.length)
            {
                for (i = 0; i < vehtype.data.length; i++)
                {
                    data11 += vehtype.data[i];
                }
            }
        }
        $(ctrl.list.disvehicletype).html('<form id="editvehicletypeform">' +
                '<div class="col-lg-12">' +
                '        <div class="col-lg-12">' +
                '            <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Type : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '        </div>' +
                '        <div class="col-lg-12">' +
                '          <select class="form-control" name="evehicletype" id="evehicletype" required=""><option value="' + alldata[loc]['vtypeid'] + '">' + alldata[loc]["vtypename"] + '</option>' + data11 + '</select>  ' +
                '        </div>' +
                '    </div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Make : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '<div class="col-lg-12"> <div id="edisplayvmake">' +
                '<select class="form-control" name="evehiclemakee" id="evehiclemakee" required=""><option value="' + alldata[loc]['vmakeid'] + '">' + alldata[loc]['vmakename'] + '</option></select>' +
                '</div></div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div> ' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-12">' +
                ' <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Model : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '<div class="col-lg-12"> <div id="edisplayvmodel">' +
                '<select class="form-control" name="evehiclemodel" id="evehiclemodel" required=""><option value="' + alldata[loc]['vehiclemodel'] + '">' + alldata[loc]['vehiclemodelname'] + '</option></select>' +
                '</div></div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div> ' +
                '<div class="col-lg-12">' +
                '   <div class="col-lg-12">' +
                '       <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Reg no. (EX. KA12A1234) : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '   </div>' +
                '   <div class="col-lg-12">' +
                '       <input  id="evehicleregno" name="evehicleregno" type="text" value="' + alldata[loc]['vehicle_number'] + '" class="form-control" placeholder="Vehicle Reg no. (EX. KA12A1234)" required=""/>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '   <div class="col-lg-12">' +
                '       <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Nick Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '   </div>' +
                '   <div class="col-lg-12">' +
                '       <input  id="evehiclenickname" name="evehiclenickname" type="text" value="' + alldata[loc]['vehicle_nickname'] + '" class="form-control" placeholder="Vehicle Nick Name" required=""/>' +
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
            var eadddonorform = false;
            $('#editvehicletypeform').validate({
                submitHandler: function () {
                    eadddonorform = true;
                }
            });
            $('#editvehicletypeform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                if (eadddonorform)
                {
                    updateVehicleType(formdata + '&typeid=' + id);
                }
            });
            $('#evehicletype').change(function () {
                fetchVehicleMakes(this.value, "edit");
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
                action: 'uservehicle/deleteVehicle',
                typeid: id
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
                            alert("Vehicle has been Successfully Deleted");
                            fetchListOfVehicles();
                        }
                        else
                        {
                            alert("Vehicle hasn't been Deleted")
                            fetchListOfVehicles();
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

    function updateVehicleType(formdata)
    {
        $('#fromupdate').prop('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=uservehicle/updateUserVehicle',
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
                            alert("Vehicle Details has been Successfully Updated");
                            $(ctrl.add.form).get(0).reset();
                            fetchListOfVehicles();
                        }
                        else
                        {
                            alert("Vehicle Details hasn't been Updated");
                            $(ctrl.add.form).get(0).reset();
                            fetchListOfVehicles();
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
}
;


