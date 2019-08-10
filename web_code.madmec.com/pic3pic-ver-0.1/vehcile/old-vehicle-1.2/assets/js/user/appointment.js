function appointment()
{
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        fetchvehicles();
    };
    this.bookSlot = function (attr) {
        bookAppointment(attr);
    };
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
                            $(ctrl.add.displayuvehicles).html('<select class="form-control" name="uservehicle" id="uservehicle" required=""><option value="">Please Select Vehicle</option>' + type.appdata + '</option>');
                            $('#uservehicle').change(function () {
                                fetchServiceCenterSlots(this.value);
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

    function fetchServiceCenterSlots(userid)
    {
        $(ctrl.add.pscenter).val('');
        $(ctrl.add.displayvendorapp).html('');
        $(ctrl.add.displayvendorapp).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            datatype: 'JSON',
            data: 'autoloader=true&action=userappointment/checkForPreferedCenter&userid=' + userid,
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
                        if (data != null) {
                            var type = $.parseJSON(data);
                            if (type.status == "success")
                            {
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
                                        window.setTimeout(function (){
                                          $(ctrl.add.pscenter).autocomplete({
                                            source: services,
                                            autoFocus: true,
                                            minLength: 1,
                                            delay: 0,
                                            select: function (event, ui) {
                                                ctrl.add.pscenterid = ui.item.id;
                                                fetchAppointmentsOfVendor(ctrl.add.pscenterid,ui.item.value,userid);
                                            }
                                        });  
                                        },500);
                                        
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
                                }
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

    function fetchAppointmentsOfVendor(venid,vendata,userid)
    {
        $(ctrl.add.displayvendorapp).html(LOADER_SIX)
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: 'venidd=' + venid +'&vendata'+vendata+'&vehicleid='+userid+ '&autoloader=true&action=userappointment/fetchappointmentdetails',
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
                        if (data != null) {
                            var type = $.parseJSON(data);

                            if (type.status == "success")
                            {
                                var htm = '';
                                for (i = 0; i < type.pdata.length; i++) {
                                    htm += type.pdata[i];
                                }
                                $(ctrl.add.displayvendorapp).html(type.divheader + htm + type.divfooter);
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
                        else{
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



