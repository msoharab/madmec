function vehiclemake()
{
    var adddonorform = false;
    var eadddonorform = false;
    var vehtype={};
    var ctrl = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        fetchVehicleType();
        $(ctrl.list.menubut).click(function () {
            fetchVehicleTypes();
        });
        $(ctrl.add.vehiclemake).on('change', function () {
            checkEmail("add");
        });
        $(ctrl.add.vehiclemake).mouseleave(function () {
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
                $(ctrl.add.vehiclemake).focus();
                return;
            }
            if (adddonorform && ctrl.add.emailcheck)
            {
                addVehicleType(formdata);
            }
        });

    };
    
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
                        var data1='';
                        if(type.status="success")
                        {
                            if(type.data.length)
                            {
                                for(i=0;i<type.data.length;i++)
                                {
                                    data1 +=type.data[i];
                                }
                            }
                        }
                        $(ctrl.add.displayvtype).html('<select class="form-control" name="vehicletype" id="vehicletype" required=""><option value="">Please Select Vehicle Type</option>' + data1 + '</select>');
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
    
    function addVehicleType(formdata)
    {
        $(ctrl.add.but).prop('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=vehicle/addVehicleMake',
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
                            alert("Vehicle Make has been Successfully Added");
                            $(ctrl.add.form).get(0).reset();
                        }
                        else
                        {
                            alert("Vehicle Make hasn't been Added");
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
            data: formdata + '&autoloader=true&action=vehicle/updateVehicleMake',
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
                            fetchVehicleTypes();
                        }
                        else
                        {
                            alert("Vehicle Details hasn't been Updated");
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
            data: '&autoloader=true&action=vehicle/fetchVehicleMake',
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
                                    '<tr><th>#</th><th>Vehicle Type</th><th>Vehicle Name</th><th>Comment</th><th>Option</th></tr></thead><tbody>';
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
            vtype = $(ctrl.add.vehiclemake).val();
            typeid = 0;
        }
        else
        {
            vtype = $('#evehiclemakee').val();
            typeid = id;
        }
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'vehicle/checkVehicleMake',
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
                                $(ctrl.add.err_email).html("<strong class='text-danger'>Vehicle Name Already Exist</strog>");
                            }
                            else
                            {
                                ctrl.add.eemailcheck = 0
                                $('#eerr_email').html("<strong class='text-danger'>Vehicle Name Already Exist</strog>");
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
        var data1='';
        if(vehtype.status="success")
                        {
                            if(vehtype.data.length)
                            {
                                for(i=0;i<vehtype.data.length;i++)
                                {
                                    data1 +=vehtype.data[i];
                                }
                            }
                        }
        $(ctrl.list.disvehicletype).html('<form id="editvehicletypeform">' +
                '<div class="col-lg-12">' +
                '        <div class="col-lg-12">' +
                '            <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Type : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '        </div>' +
                '        <div class="col-lg-12">' +
                '          <select class="form-control" name="evehicletype" id="evehicletype" required=""><option value="'+alldata[loc]['vtid'] +'">'+alldata[loc]["vtname"] +'</option>' +  data1+ '</select>  ' +
                '        </div>' +
                '    </div>' +
                 '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '   <div class="col-lg-12">' +
                '       <strong><i class="fa fa-star text-danger">&nbsp;</i>Vehicle Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '   </div>' +
                '   <div class="col-lg-12">' +
                '       <input  id="evehiclemakee" name="evehiclemake" type="text" value="' + alldata[loc]['vmname'] + '" class="form-control" placeholder="Vehicle Name" required=""/>' +
                '       <span id="eerr_email"></span>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '   <div class="col-lg-12">' +
                '       <strong><i class="fa fa-star text-danger">&nbsp;</i>Comment : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '   </div>' +
                '   <div class="col-lg-12">' +
                '       <textarea  id="ecomment" name="ecomment"  class="form-control" placeholder="Comment" required="" style="resize: none;">' + alldata[loc]['vmakecomment'] + '</textarea>' +
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
                    $('#evehiclemakee').focus();
                    return;
                }
                if (eadddonorform && ctrl.add.eemailcheck)
                {
                    updateVehicleType(formdata + '&typeid=' + id);
                }
            });
            $('#evehiclemakee').on('change', function () {
                checkEmail("edit", id);
            });
            $('#evehiclemakee').mouseleave(function () {
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
                action: 'vehicle/deleteVehicleMake',
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
                            alert("Vehicle Details has been Successfully Deleted");
                            fetchVehicleTypes();
                        }
                        else
                        {
                            alert("Vehicle Details hasn't been Deleted")
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


