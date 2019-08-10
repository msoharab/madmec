function projects()
{
    var adddonorform = false;
    var continentdata = new Array();
    var vehtype = {};
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        fetchContinents();
        $(ctrl.list.menubut).click(function () {
            fetchListOfProjects();
        });
        $(ctrl.add.countryname).change(function () {
            checkProjectName(this.value);
        });
        $(ctrl.add.countryname).mouseleave(function () {
            checkProjectName(this.value);
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
                $(ctrl.add.countryname).focus();
                return;
            }
            if (adddonorform && ctrl.add.emailcheck)
            {
                addProject(formdata);
            }
        });
        $(ctrl.add.projectdate).datetimepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: '-100 : +100',
//            minTime : dat.getHours()+':'+(dat.getMinutes()),
            onSelect: function (data) {
            }
        });
        $(ctrl.list.menubut).trigger('click');
    };

    function fetchContinents()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'adminProjects/fetchContinents',
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
                        var resp = $.parseJSON(data);
                        var details = '';
                        if (resp.status == "success")
                        {
                            continentdata = resp.data;
                            for (i = 0; i < resp.data.length; i++)
                            {
                                details += '<option value="' + resp.data[i]["id"] + '">' + resp.data[i]["cname"] + '</option>';
                            }
                        }
                        $('#selectcontinent').html('<select class="form-control" name="selectcont" required="" id="selectcont"><option value="">Please Select Continent</option>' + details + '</select>');
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

    function  addProject(formdata)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=adminProjects/addProject',
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
                        if (type)
                        {
                            alert("Country Details Has been Successfully Added");
                            adddonorform = false;
                            $(ctrl.add.form).get(0).reset();
                        }
                        else
                        {
                            alert("Country Details Hasn't been Added");
                            adddonorform = false;
                            $(ctrl.add.form).get(0).reset();
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

    function fetchListOfProjects()
    {
        $(ctrl.list.disvehicletype).html('Loading.....');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=adminProjects/fetchListOfProjects',
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
                                    '<tr><th>#</th><th>ID</th><th>Country Name</th><th>Capital</th><th>ISO</th><th>CurrencyCode</th><th>Continent Name</th><th>Option</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $(ctrl.list.disvehicletype).html(header + type.data + footer);
                            window.setTimeout(function () {
                                $('#list_col_table').dataTable();
                                if (type.donorids.length)
                                {

                                    for (i = 0; i < type.donorids.length; i++)
                                    {
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
                                            deleteProject(evt.data.donorid);
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

    /* Displaying Donor Details  */
    function viewDetails(donorid, loc, talldata) {
        var data = '<div class="col-lg-12">' +
                '<div class="panel panel-info"><div class="col-lg-12 panel-heading"><div class="col-lg-6 text-left">' +
                '<strong>Country Details</strong>' +
                '</div>' +
                '<div class="col-lg-6 text-right">' +
                '<button  type="button" class="text-info btn btn-warning btn-circle  btn-md" type="button" title="Edit" id="personaledit" ><i class="fa fa-pencil fa-fw "></i></button>&nbsp;</div></div><div class="panel-body" id="pereditbody">' +
                '<table class="table table-hover"><tbody>' +
                '<tr><td><strong>Continent Name</strong></td>  <td>' + talldata[loc]['continent_name'] + '</td></tr>' +
                '<tr><td><strong>Country Name</strong></td> <td>' + talldata[loc]['Country'] + '</td></tr>' +
                '<tr><td><strong>ISO</strong></td>  <td>' + talldata[loc]['ISO'] + '</td> </tr>' +
                '<tr><td><strong>ISO3</strong></td>  <td>' + talldata[loc]['ISO3'] + '</td> </tr>' +
                '<tr><td><strong>ISO-Numeric</strong></td>  <td>' + talldata[loc]['ISO-Numeric'] + '</td> </tr>' +
                '<tr><td><strong>T.L.D </strong></td>  <td>' + talldata[loc]['tld'] + '</td> </tr>' +
                '<tr><td><strong>Currency Code  </strong></td>  <td>' + talldata[loc]['CurrencyCode'] + '</td> </tr>' +
                '<tr><td><strong>Capital  </strong></td>  <td>' + talldata[loc]['Capital'] + '</td> </tr>' +
                '</tbody></table>';
        data += ' ' +
                '</div></div>' +
                '</div>';
        data += '</div>  ' +
                '</div></div>' +
                '</div>';
        $(ctrl.list.disvehicletype).html(data);
        window.setTimeout(function () {
            $('#personaledit').click(function () {
                editDetails(donorid, loc, talldata);
            });
        }, 300);
    }

    function editDetails(id, loc, talldata)
    {
        var contdata = '<option value="' + talldata[loc]['continent_id'] + '">' + talldata[loc]['continent_name'] + '</option>';
        if (continentdata.length)
        {
            for (i = 0; i < continentdata.length; i++)
            {
                if (continentdata[i]['id'] == talldata[loc]['continent_id'])
                {
                    continue;
                }
                contdata += '<option value="' + continentdata[i]['id'] + '">' + continentdata[i]['cname'] + '</option>';
            }
        }
        $(ctrl.list.disvehicletype).html('' +
                '  <form id="eprojectaddform">' +
                ' <div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>Continent : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                ' <div class="col-lg-12" id="selectcontinent">' +
                '      <!--<input  id="projectname" name="projectname" type="text" class="form-control"  placeholder="Continent" required=""/>-->' +
                '       <select class="form-control" name="selectcont" id="selectcontss">' + contdata + '</select>' +
                '    </div>' +
                '</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>Country Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '     <input  id="ecountryname" name="countryname"  type="text" value="' + talldata[loc]['Country'] + '" class="form-control" required="" placeholder="Country Name"/>' +
                '       <span id="eerr_email"></span>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>ISO : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                ' <div class="col-lg-12">' +
                '      <input  id="ISO" name="ISO"  type="text" class="form-control"  value="' + talldata[loc]['ISO'] + '" placeholder="ISO" />' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '    <strong><i class="fa fa-star text-danger">&nbsp;</i>ISO3 : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '  <div class="col-lg-12">' +
                '       <input  id="ISO3" name="ISO3"  type="text" class="form-control" value="' + talldata[loc]['ISO3'] + '"  placeholder="ISO3"/>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>ISO-Numeric : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '     <input  id="ISO-Numeric" name="ISO-Numeric" type="text" class="form-control" value="' + talldata[loc]['ISO-Numeric'] + '"  placeholder="ISO-Numeric" required=""/>' +
                '      <span id="err_email"></span>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>Capital : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                ' <div class="col-lg-12">' +
                '      <input  id="Capital" name="Capital"  type="text" class="form-control" value="' + talldata[loc]['Capital'] + '"  placeholder="Capital"/>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>T.L.D : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                ' <div class="col-lg-12">' +
                '      <input  id="tld" name="tld"  type="text" value="' + talldata[loc]['tld'] + '" class="form-control"  placeholder="Top Level Domain"/>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-3">' +
                ' <div class="col-lg-12">' +
                '      <strong><i class="fa fa-star text-danger">&nbsp;</i>Currency Code : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '   </div>' +
                '    <div class="col-lg-12">' +
                '         <input  id="ccode" name="ccode"  type="text" value="' + talldata[loc]['CurrencyCode'] + '" class="form-control"  placeholder="Currency Code"/>' +
                '      </div>' +
                '   </div>' +
                '    <div class="col-lg-12">&nbsp;</div>' +
                '     <div class="col-lg-12">' +
                ' <button  type="submit" class="text-info btn btn-success"  id="fromupdate" ><i class="fa fa-upload fa-fw "></i>&nbsp;UPDATE</button>&nbsp;' +
                ' <button  type="reset" class="text-info btn btn-warning" id="personaleditreset" ><i class="fa fa-refresh fa-fw "></i>&nbsp;RESET</button>&nbsp;' +
                ' <button  type="button" class="text-info btn btn-danger" id="personaleditclose" ><i class="fa fa-close fa-fw "></i>&nbsp;CLOSE</button>&nbsp;' +
                '       </div>' +
                '</form>');
        window.setTimeout(function () {
            $('#personaleditclose').click(function () {
                $('#personaledit').show();
                viewDetails(id, loc, talldata);
            });
            $('#ecountryname').change(function () {
                checkEditProjectName(id, this.value);
            });
            $('#ecountryname').mouseleave(function () {
                checkEditProjectName(id, this.value);
            });
            var eadddonorform = false;
            $('#eprojectaddform').validate({
                submitHandler: function () {
                    eadddonorform = true;
                }
            });
            $('#eprojectaddform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                if (ctrl.add.eemailcheck == 0)
                {
                    $('#ecountryname').focus();
                    return;
                }
                if (eadddonorform && ctrl.add.eemailcheck)
                {
                    updateProjectDetails(formdata + '&typeid=' + id);
                }
            });
        }, 500);
    }

    function deleteProject(id)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'adminProjects/deleteProject',
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
                            alert("Country Details has been Successfully Deleted");
                            fetchListOfProjects();
                        }
                        else
                        {
                            alert("Country Details hasn't been Deleted")
                            fetchListOfProjects();
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

    function updateProjectDetails(formdata)
    {
        $('#fromupdate').prop('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=adminProjects/updateProjectDetails',
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
                            alert("Country Details has been Successfully Updated");
                            $('#eprojectaddform').get(0).reset();
                            fetchListOfProjects();
                        }
                        else
                        {
                            alert("Country Details hasn't been Updated");
                            $('#eprojectaddform').get(0).reset();
                            fetchListOfProjects();
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

    function checkProjectName(proname)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'adminProjects/checkProjectName',
                proname: proname,
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
                            ctrl.add.emailcheck = 0
                            $(ctrl.add.err_email).html("<strong class='text-danger'>Country Name Already Exist</strog>");
                        }
                        else
                        {
                            ctrl.add.emailcheck = 1;
                            $(ctrl.add.err_email).html("");
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

    function checkEditProjectName(id, proname)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'adminProjects/checkProjectName',
                proname: proname,
                donorid: id,
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
                            ctrl.add.eemailcheck = 0
                            $(ctrl.add.eerr_email).html("<strong class='text-danger'>Country Name Already Exist</strog>");
                        }
                        else
                        {
                            ctrl.add.eemailcheck = 1;
                            $(ctrl.add.eerr_email).html("");
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
}
;


