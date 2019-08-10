function projects()
{
    var adddonorform = false;
    var vehtype = {};
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        $(ctrl.list.menubut).click(function () {
            fetchListOfProjects();
        });
        $(ctrl.add.projectname).change(function () {
            checkProjectName(this.value);
        });
        $(ctrl.add.projectname).mouseleave(function () {
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
                            alert("Project Has been Successfully Added");
                            adddonorform = false;
                            $(ctrl.add.form).get(0).reset();
                        }
                        else
                        {
                            alert("Project Hasn't been Added");
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
                                    '<tr><th>#</th><th>Project Name</th><th>Created BY</th><th>Created Date</th><th>Option</th></tr></thead><tbody>';
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
                                            editDetails(evt.data.donorid, evt.data.tloc, type.alldata);
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

    function editDetails(id, loc, talldata)
    {
        var data11 = '';
        $(ctrl.list.disvehicletype).html('<form id="editvehicletypeform">' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-6">' +
                ' <div class="col-lg-12">' +
                '    <strong><i class="fa fa-star text-danger">&nbsp;</i>Project Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '   <input  id="eprojectname" name="projectname" type="text" value="' + talldata[loc]['project_name'] + '" class="form-control"  placeholder="Project Name" required=""/>' +
                ' <span id="eerr_email"></span></div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '   <div class="col-lg-12">' +
                '      <strong><i class="fa fa-star text-danger">&nbsp;</i>Project Start Date : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                ' </div>' +
                '<div class="col-lg-12">' +
                '   <input  id="eprojectdate" name="eprojectdate" readonly="" type="text" value="' + talldata[loc]['created_at'] + '" class="form-control"  placeholder="Project Start Date"/>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '   <button type="submit" name="fromupdate" id="fromupdate" class="btn btn-primary btn-lg btn-block">&nbsp UPDATE</button>' +
                '</div>' +
                '</form>');
        window.setTimeout(function () {
            $('#eprojectdate').datetimepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100 : +100',
//            minTime : dat.getHours()+':'+(dat.getMinutes()),
                onSelect: function (data) {
                }
            });
            $('#eprojectname').change(function () {
                checkEditProjectName(id, this.value);
            });
            $('#eprojectname').mouseleave(function () {
                checkEditProjectName(id, this.value);
            });
            var eadddonorform = false;
            $('#editvehicletypeform').validate({
                submitHandler: function () {
                    eadddonorform = true;
                }
            });
            $('#editvehicletypeform').submit(function (evt) {
                evt.preventDefault();
                var formdata = $(this).serialize();
                if (eadddonorform && ctrl.add.eemailcheck)
                {
                    updateProjectDetails(formdata + '&typeid=' + id);
                }
            });
            $('#evehicletype').change(function () {
                fetchVehicleMakes(this.value, "edit");
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
                            alert("Project Details has been Successfully Updated");
                            $('#editvehicletypeform').get(0).reset();
                            fetchListOfProjects();
                        }
                        else
                        {
                            alert("Project Details hasn't been Updated");
                            $('#editvehicletypeform').get(0).reset();
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
                            $(ctrl.add.err_email).html("<strong class='text-danger'>ProjectName Already Exist</strog>");
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
                            $(ctrl.add.eerr_email).html("<strong class='text-danger'>ProjectName Already Exist</strog>");
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


