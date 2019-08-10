function engage()
{
    var adddonorform = false;
    var globalactivy = '';
    var vehtype = {};
    var ctrl = {};
    var form = ' <form id="engageaddform">' +
            '<div class="col-lg-12">&nbsp;</div>' +
            '<div class="col-lg-12">' +
            '<div class="col-lg-12">' +
            '   <strong><i class="fa fa-star text-danger">&nbsp;</i> Select Project : <i class="fa fa-caret-down fa-fw"></i></strong>' +
            '</div>' +
            '<div class="col-lg-12">' +
            '   <select  id="selectproject" name="selectproject" class="form-control" required="">' +
            '        <option value="">Select Project</option>' +
            '     </select>' +
            '       <span id="err_email"></span>' +
            '   </div>' +
            '</div>' +
            '<div class="col-lg-12">&nbsp;</div>' +
            '<div class="col-lg-12">' +
            '<div class="col-lg-12">' +
            '   <strong><i class="fa fa-star text-danger">&nbsp;</i> Select Activity : <i class="fa fa-caret-down fa-fw"></i></strong>' +
            '</div>' +
            '<div class="col-lg-12">' +
            '   <select  id="selectactivity" name="selectactivity" class="form-control" required="">' +
            '        <option value="">Select Project</option>' +
            '     </select>' +
            '       <span id="err_email"></span>' +
            '   </div>' +
            '</div>' +
            '  <div class="col-lg-12">&nbsp;</div>' +
            '' +
            '  <div class="col-lg-12">' +
            '       <button type="submit" name="formsubmit" id="formsubmit" class="btn btn-primary btn-lg btn-block">&nbsp Engage</button>' +
            '    </div>' +
            ' </form>';
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        checkLoginStatus();
//        fetchprojects();
        $(ctrl.list.menuBut).click(function () {
            fetchListOfActivities();
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
    };

    function  checkLoginStatus()
    {
        $(ctrl.disnewengageform).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=engage/checkLoginStatus',
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
                            $(ctrl.disnewengageform).html(type.data);
                            window.setTimeout(function () {
                                $('#logout' + type.id).bind('click', {id: type.id}, function (evt) {
                                    disengage(evt.data.id);
                                });
                            });
                        }
                        else
                        {
                            $(ctrl.disnewengageform).html(form);
                            window.setTimeout(function () {
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
                                        addActivity(formdata);
                                    }
                                });
                                fetchprojects();
                            }, 600);
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

    function disengage(id)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'engage/disengage',
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
                            alert("You has been Successfully DisEngaged");
                            checkLoginStatus();
                        }
                        else
                        {
                            alert("You hasn't been DisEngaged")
                            checkLoginStatus();
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

    function fetchprojects()
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=engage/fetchprojects',
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
                            globalactivy = type.data;
                            $(ctrl.add.selectproject).html(' <select  id="selectproject" name="selectproject" class="form-control" required="">' +
                                    '<option value="">Select Project</option>' + type.data + '</select>');
                            window.setTimeout(function () {
                                $('#selectproject').change(function () {
                                    fetchActivities(this.value);
                                })
                            }, 800);
                        }
                        else
                        {

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

    function  addActivity(formdata)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=engage/addActivity',
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
                            alert("You have been Successfully Engaged");
                            adddonorform = false;
                            $(ctrl.add.form).get(0).reset();
                            checkLoginStatus();
                        }
                        else
                        {
                            alert("You haven't been Engaged");
                            adddonorform = false;
                            $(ctrl.add.form).get(0).reset();
                            fetchprojects();
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

    function fetchListOfActivities()
    {
        $(ctrl.list.displayactivities).html('Loading.....');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=activity/fetchListOfActivities',
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
                                    '<tr><th>#</th><th>Project Name</th><th>Activity Name</th><th>Description</th><th>Option</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $(ctrl.list.displayactivities).html(header + type.data + footer);
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
                                            deleteActivity(evt.data.donorid);
                                        });
                                    }
                                }
                            }, 600);
                        }
                        else
                        {
                            $(ctrl.list.displayactivities).html('<span class="text-danger text-center">no records</span>');
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
        $(ctrl.list.displayactivities).html('<form id="editvehicletypeform" autocomplete="off">' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i> Select Project : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '   <select  id="selectproject" name="selectproject" class="form-control" required="">' +
                '        <option value="' + talldata[loc]['project_id'] + '">' + talldata[loc]['project_name'] + '</option>' + globalactivy +
                '     </select>' +
                '       <span id="err_email"></span>' +
                '   </div>' +
                '</div>' +
                ' <div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i> Name : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                '<div class="col-lg-12">' +
                '     <input  id="name" name="name" type="text" class="form-control" value="' + talldata[loc]['activity_name'] + '"  placeholder="Activity Name" required=""/>' +
                '       <span id="err_email"></span>' +
                '   </div>' +
                '</div>' +
                ' <div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-12">' +
                '   <strong><i class="fa fa-star text-danger">&nbsp;</i>Description : <i class="fa fa-caret-down fa-fw"></i></strong>' +
                '</div>' +
                ' <div class="col-lg-12">' +
                '      <textarea class="form-control" name="description" placeholder="Description" id="description" required="" style="resize: none;">' + talldata[loc]['description'] + '</textarea>' +
                '   </div>' +
                '</div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
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
                    updateProjectDetails(formdata + '&typeid=' + id);
                }
            });
            $('#evehicletype').change(function () {
                fetchVehicleMakes(this.value, "edit");
            });

        }, 500);
    }

    function deleteActivity(id)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: {
                autoloader: true,
                action: 'activity/deleteActivity',
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
                            alert("Activity has been Successfully Deleted");
                            fetchListOfActivities();
                        }
                        else
                        {
                            alert("Activity hasn't been Deleted")
                            fetchListOfActivities();
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
            data: formdata + '&autoloader=true&action=activity/updateProjectActivity',
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
                            alert("Activity Details has been Successfully Updated");
                            $('#editvehicletypeform').get(0).reset();
                            fetchListOfActivities();
                        }
                        else
                        {
                            alert("Activity Details hasn't been Updated");
                            $('#editvehicletypeform').get(0).reset();
                            fetchListOfActivities();
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

    function fetchActivities(proname)
    {
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=engage/fetchActivities&projid=' + proname,
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
                            globalactivy = type.data;
                            $(ctrl.add.selectactivity).html(' <select  id="selectactivity" name="selectactivity" class="form-control" required="">' +
                                    '<option value="">Select Activity</option>' + type.data + '</select>');

                        }
                        else
                        {

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
    ;


}
;


