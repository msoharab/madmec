function appointment()
{
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        window.localStorage.setItem('serviceid', 0);
        var dat = new Date();
        dat.setMinutes(dat.getMinutes() + 30);
        $(ctrl.add.bookingdate).datetimepicker({
            dateFormat: 'yy-mm-dd',
//            minTime : dat.getHours()+':'+(dat.getMinutes()),
            minDate: 0,
            maxDate: 2,
            onSelect: function (data) {
                
                if (Number(window.localStorage.getItem("serviceid")))
                {
                    fetchVendorAppointments(this.value);
                }
            }
        });
//        $(ctrl.add.bookingdate).change(function (){
//            alert(this.value);
//        })
        fetchvehicles();

        $(ctrl.list.menubut).click(function () {
            fetchBookedAppointments();
        });
    };

    function fetchVendorAppointments(val)
    {
        $(ctrl.add.displayvendorapp).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=userappointment/fetchVendorAppointments&date=' + val + '&serviceid=' + Number(window.localStorage.getItem('serviceid')),
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
                            $(ctrl.add.displayvendorapp).html(type.data);
                            window.setTimeout(function () {
                                for (i = 0; i < type.appdescids.length; i++)
                                    {
                                       $('#blockslot'+type.appdescids[i]).bind('click', {appdescbid: type.appdescids[i],date : type.dates[i]}, function (evt) {
                                            blockSlot(evt.data.appdescbid,evt.data.date);
                                        }) 
                                    }
                            }, 600)
                        }
                        else
                        {
                            $(ctrl.add.displayvendorapp).html('');
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

    function blockSlot(slotid,date)
    {
       if($('#bookaservice').val() == "")
       {
         $('#bookaservice').focus();
         alert("Please Select Book a Service Type");
         return;
       }
       if($('#typeofservice').val() == "")
       {
        alert("Please Select Type of Service");
         $('#typeofservice').focus();
         return;
       }
       var complainttypee = [];
            $.each($("input[name='complainttypee']:checked"), function(){            
                complainttypee.push($(this).val());
            });
            if(!complainttypee.length)
            {
               alert("Please Select Type Complaint Type");   
               return;
            }
         var attr={
            bookaservice : $('#bookaservice').val(), 
            typeofservice : $('#typeofservice').val(), 
            uservehicle : $('#uservehicle').val(), 
            remark : $('#remark').val(), 
            complainttype : complainttypee, 
            slodid : slotid,
            serviceid : window.localStorage.getItem("serviceid"),
            date : date
         };   
         bookAppointment(attr);    
    }

//    this.bookSlot = function (attr) {
//        bookAppointment(attr);
//    };
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
                                $(ctrl.add.displayvendorapp).html('');
                                $(ctrl.add.discomplainttype).html('');
                                window.localStorage.setItem('serviceid', 0);
                                if(this.value !== "")
                                {
                                fetchServiceCenterSlots(this.value, type.vmakeids[this.value]);
                                }
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
        $(ctrl.add.displayvendorapp).html(LOADER_SIX);
        $(ctrl.add.discomplainttype).html(LOADER_SIX);
//        $(ctrl.add.displayvendorapp).html(LOADER_SIX);
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
                                                    window.localStorage.setItem("serviceid", ctrl.add.pscenterid);
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
//                                    $(ctrl.add.displayvendorapp).html(type.divheader + htm + type.divfooter);
                                    $(ctrl.add.discomplainttype).html(type.ctdata);
                                    window.localStorage.setItem("serviceid", type.serviceid);
                                    window.setTimeout(function (){
                                        $('#changevendor').click(function (){
                                          $(ctrl.add.displayvendordet).html('<input  id="pscenter" name="pscenter" type="text" class="form-control" placeholder="Preferred Service Center" required=""/>');  
                                          suggestVendors(userid,ventype);
                                        }); 
                                    },600);
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

    function suggestVendors(userid,ventype)
    {
      $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: 'autoloader=true&action=userappointment/checkForPreferedCenter&userid='+userid+'&ventype=' + ventype+'&change="change"',
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
                                                    window.localStorage.setItem("serviceid", ctrl.add.pscenterid);
                                                    fetchAppointmentsOfVendor(ctrl.add.pscenterid, ui.item.value, userid);
                                                }
                                            });
                                        }, 500);

                                    }
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
                $(ctrl.add.but).removeAttr('disabled');
            }
        });  
    }

    function fetchAppointmentsOfVendor(venid, vendata, userid)
    {
        $(ctrl.add.discomplainttype).html(LOADER_SIX);
//        $(ctrl.add.displayvendorapp).html(LOADER_SIX)
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
//                                $(ctrl.add.displayvendorapp).html(type.divheader + htm + type.divfooter);
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
                        {
                            alert("Sorry, You have Already Booked this Appointment");
                            $(ctrl.add.displayvendorapp).html('');
                            $(ctrl.add.discomplainttype).html('');
                            $('#vehicletypeform').get(0).reset();
                        } 
                        else {
                            $(details.rowid).remove();
                            alert("You have Successfully Booked the Appointment");
                            $(ctrl.add.displayvendorapp).html('');
                            $(ctrl.add.discomplainttype).html('');
                            $('#vehicletypeform').get(0).reset();
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



