function appointment()
{
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        fetchvehicles();
        $(ctrl.list.menubut).click(function () {
            fetchBookedAppointments();
        });
    };
    this.bookSlot = function (attr) {
        bookAppointment(attr);
    };
    function fetchBookedAppointments() {
        $("#displayuvehicless").html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=userappointment/fetchBookedAppointments',
            success: function (data, textStatus, xhr) {
                /* console.log(data); */
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
                            var header = '<div class="table-responsive"><table class="table table-responsive table-bordered table-hover" id="list_col_table"><thead>' +
                                    '<tr><th>#</th><th>Vehicle Name</th><th>Date</th><th>Slot Time</th><th>ServiceType</th><th>BookService</th><th>Center Details</th><th>Option</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $("#displayuvehicless").html(header + type.data + footer);
                            window.setTimeout(function () {
                                $('#list_col_table').dataTable();
                                if (type.donorids.length)
                                {

                                    for (i = 0; i < type.donorids.length; i++)
                                    {
                                        $('#donordel_' + type.donorids[i]).bind('click', {
                                            donorid: type.donorids[i],
                                            addpdescbid: type.addpdescbid[i]
                                        }, function (evt) {
                                            deleteAppointment(evt.data.donorid, evt.data.addpdescbid);
                                        });
                                    }
                                }
                            }, 600)

                        }
                        else
                        {
                            $("#displayuvehicless").html("<strong class='text-danger'>no records</strong>");
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

    function deleteAppointment(id, addpdescbid)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'userappointment/deleteAppointment',
                typeid: id,
                addpdescbid: addpdescbid
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
                            alert("Appointment has been Successfully Deleted");
                            fetchBookedAppointments();
                        }
                        else
                        {
                            alert("Appointment hasn't been Deleted")
                            fetchBookedAppointments();
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

    function fetchvehicles()
    {
        $(ctrl.add.displayuvehicles).html('Loading.....');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=uservehicle/fetchListOfVehicles',
            success: function (data, textStatus, xhr) {
                /* console.log(data); */
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
//                            var vmakeids=new Array();
//                            for(i=0;i<type.vmakeids.length;i++)
//                            {
//                                
//                            }
                            $(ctrl.add.displayuvehicles).html('<select class="form-control" name="uservehicle" id="uservehicle" required=""><option value="">Please Select Vehicle</option>' + type.appdata + '</option>');
                            $('#uservehicle').change(function () {
                                fetchServiceCenterSlots(this.value, type.vmakeids[this.value]);
                            });
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

    function fetchServiceCenterSlots(userid, ventype)
    {
        $(ctrl.add.pscenter).val('');
        $(ctrl.add.displayvendorapp).html('');
        $(ctrl.add.discomplainttype).html('');
        $(ctrl.add.displayvendorapp).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            datatype: 'JSON',
            data: 'autoloader=true&action=userappointment/checkForPreferedCenter&userid=' + userid + '&ventype=' + ventype,
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
                        if (data != null) {
                            var type = $.parseJSON(data);
                            if (type.status == "success")
                            {
                                $(ctrl.add.displayvendorapp).html('');
                                $(ctrl.add.discomplainttype).html('');
                                if (type.res == "suggest")
                                {
                                    $(ctrl.add.displayvendordet).html('<input  id="pscenter" name="pscenter" type="text" class="form-control" placeholder="Preferred Service Center" required=""/>');
                                    var services = new Array();
                                    if (type.data.length)
                                    {
                                        for (i = 0; i < type.data.length; i++)
                                        {
                                            services.push({
                                                label: type.data[i],
                                                value: type.data[i],
                                                id: type.ids[i]
                                            });
                                        }
                                        window.setTimeout(function () {
                                            $(ctrl.add.pscenter).autocomplete({
                                                source: services,
                                                autoFocus: true,
                                                minLength: 1,
                                                delay: 0,
                                                select: function (event, ui) {
                                                    ctrl.add.pscenterid = ui.item.id;
                                                    fetchAppointmentsOfVendor(ctrl.add.pscenterid, ui.item.value, userid);
                                                }
                                            });
                                        }, 500);

                                    }
                                }
                                else
                                {
                                    var htm = '';
                                    for (i = 0; i < type.pdata.length; i++) {
                                        htm += type.pdata[i];
                                    }
                                    $(ctrl.add.displayvendordet).html(type.det);
                                    $(ctrl.add.displayvendorapp).html(type.divheader + htm + type.divfooter);
                                    $(ctrl.add.discomplainttype).html(type.ctdata);
                                }
                            }
                            else
                            {
                                $(ctrl.add.displayvendorapp).html('');
                                $(ctrl.add.discomplainttype).html('');
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

    function fetchAppointmentsOfVendor(venid, vendata, userid)
    {
        $(ctrl.add.discomplainttype).html('');
        $(ctrl.add.displayvendorapp).html(LOADER_SIX)
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: 'venidd=' + venid + '&vendata' + vendata + '&vehicleid=' + userid + '&autoloader=true&action=userappointment/fetchappointmentdetails',
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
                        if (data != null) {
                            var type = $.parseJSON(data);

                            if (type.status == "success")
                            {
                                var htm = '';
                                for (i = 0; i < type.pdata.length; i++) {
                                    htm += type.pdata[i];
                                }
                                $(ctrl.add.displayvendorapp).html(type.divheader + htm + type.divfooter);
                                $(ctrl.add.discomplainttype).html(type.ctdata);
                            }

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

    function bookAppointment(attr)
    {
        $.ajax({
            url: ctrl.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'userappointment/bookSlot',
                inputdetl: attr
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                switch (data) {
                    default:
                        var details = $.parseJSON(data);

                        if (details.status == "failure")
                            alert("Sorry, You have Already Booked this Appointment");
                        else {
                            $(details.rowid).remove();
                            alert("You have Successfully Booked the Appointment");
                        }
//                        fetchServiceCenterSlots(test.userid);
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }

}



