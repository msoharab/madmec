function importXLS()
{
    var adddonorform = false;
    var continentdata = new Array();
    var vehtype = {};
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        $(ctrl.list.menubut).click(function () {
            fetchListOfProjects();
        });
        $(ctrl.add.languagename).change(function () {
            checkProjectName(this.value);
        });
        $(ctrl.add.languagename).mouseleave(function () {
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
                $(ctrl.add.languagename).focus();
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
        fetchContinents();
    };

    function fetchContinents()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'import/fetchContinents',
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
                        $('#projectnamee').html('<select class="form-control" name="selectcont" required="" id="selectcont"><option value="">Please Select Country</option>' + details + '</select>');
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
            data: formdata + '&autoloader=true&action=import/addProject',
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
                            alert("Language Details Has been Successfully Added");
                            adddonorform = false;
                            $(ctrl.add.form).get(0).reset();
                        }
                        else
                        {
                            alert("Language Details Hasn't been Added");
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
            data: '&autoloader=true&action=import/fetchListOfProjects',
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
                                    '<tr><th>#</th><th>Country Name</th><th>Language Name</th><th>ISO 639-3</th><th>ISO 639-2</th><th>ISO 639-1</th><th>Option</th></tr></thead><tbody>';
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
                '<tr><td><strong>Country Name</strong></td>  <td>' + talldata[loc]['Country'] + '</td></tr>' +
                '<tr><td><strong>Language Name</strong></td> <td>' + talldata[loc]['Language Name'] + '</td></tr>' +
                '<tr><td><strong>ISO 639-3</strong></td>  <td>' + talldata[loc]['ISO 639-3'] + '</td> </tr>' +
                '<tr><td><strong>ISO 639-2</strong></td>  <td>' + talldata[loc]['ISO 639-2'] + '</td> </tr>' +
                '<tr><td><strong>ISO 639-1</strong></td>  <td>' + talldata[loc]['ISO 639-1'] + '</td> </tr>' +
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
        var contdata = '<option value="' + talldata[loc]['country_id'] + '">' + talldata[loc]['Country'] + '</option>';
        if (continentdata.length)
        {
            for (i = 0; i < continentdata.length; i++)
            {
                if (continentdata[i]['id'] == talldata[loc]['country_id'])
                {
                    continue;
                }
                contdata += '<option value="' + continentdata[i]['id'] + '">' + continentdata[i]['cname'] + '</option>';
            }
        }
        $(ctrl.list.disvehicletype).html(' <form id="eprojectaddform">' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-3">' +
                ' <div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>Country : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                ' <div class="col-lg-12" id="projectnamee">' +
                '      <select class="form-control" name="selectcont" id="selectcontss">' + contdata + '</select>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '    <strong><i class="fa fa-star text-danger">&nbsp;</i>ISO 639-3 : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '  <div class="col-lg-12">' +
                '       <input  id="ISO6393" name="ISO6393"  type="text" value="' + talldata[loc]['ISO 639-3'] + '" class="form-control"  placeholder="ISO 639-3"/>' +
                '    </div>' +
                ' </div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '    <strong><i class="fa fa-star text-danger">&nbsp;</i>ISO 639-2 : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '  <div class="col-lg-12">' +
                '       <input  id="ISO6392" name="ISO6392"  type="text" value="' + talldata[loc]['ISO 639-2'] + '" class="form-control"  placeholder="ISO 639-2"/>' +
                '    </div>' +
                ' </div>' +
                '<div class="col-lg-3">' +
                '<div class="col-lg-12">' +
                '    <strong><i class="fa fa-star text-danger">&nbsp;</i>ISO 639-1 : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '  <div class="col-lg-12">' +
                '       <input  id="ISO6391" name="ISO6391"  type="text" class="form-control" value="' + talldata[loc]['ISO 639-1'] + '"  placeholder="ISO 639-1"/>' +
                '    </div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>Language Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                ' <div class="col-lg-12">' +
                '      <input  id="elanguagename" name="languagename" type="text" value="' + talldata[loc]['Language Name'] + '" class="form-control"  placeholder="Language Name" required=""/>' +
                '        <span id="eerr_email"></span>' +
                '    </div>' +
                ' </div>' +
                '  <div class="col-lg-12">&nbsp;</div>' +
                '   <div class="col-lg-12">' +
                ' <button  type="submit" class="text-info btn btn-success"  id="fromupdate" ><i class="fa fa-upload fa-fw "></i>&nbsp;UPDATE</button>&nbsp;' +
                ' <button  type="reset" class="text-info btn btn-warning" id="personaleditreset" ><i class="fa fa-refresh fa-fw "></i>&nbsp;RESET</button>&nbsp;' +
                ' <button  type="button" class="text-info btn btn-danger" id="personaleditclose" ><i class="fa fa-close fa-fw "></i>&nbsp;CLOSE</button>&nbsp;' +
                '  </div>' +
                '</form>');
        window.setTimeout(function () {
            $('#personaleditclose').click(function () {
                $('#personaledit').show();
                viewDetails(id, loc, talldata);
            });
            $('#elanguagename').change(function () {
                checkEditProjectName(id, this.value);
            });
            $('#elanguagename').mouseleave(function () {
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
                    $('#elanguagename').focus();
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
                action: 'import/deleteProject',
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
                            alert("Project has been Successfully Deleted");
                            fetchListOfProjects();
                        }
                        else
                        {
                            alert("Project hasn't been Deleted")
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
            data: formdata + '&autoloader=true&action=import/updateProjectDetails',
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
                            alert("Language Details has been Successfully Updated");
                            $('#eprojectaddform').get(0).reset();
                            fetchListOfProjects();
                        }
                        else
                        {
                            alert("Language Details hasn't been Updated");
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
                action: 'import/checkProjectName',
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
                action: 'import/checkProjectName',
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


