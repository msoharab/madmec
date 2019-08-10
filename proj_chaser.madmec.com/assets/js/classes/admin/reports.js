function reports()
{
    var reportform = false;
    var ctrl = {};
    this.__construct = function (cctrl) {
        ctrl=cctrl;
       fetchProjects();
       $(ctrl.form).validate({
          submitHandler: function () {
                reportform = true;
            } 
       });
       $(ctrl.form).submit(function(evt){
           evt.preventDefault();
           var formdata=$(this).serialize();
           if(reportform)
           {
               fetchProjectReport(formdata);
           }
       });
    };
    
    /*  Fetch Projects */
    function  fetchProjects()
    {
         $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=activity/fetchActivities',
            success: function (data, textStatus, xhr) {
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
                            $(ctrl.selectproj).html(' <select  id="selectproject" name="selectproject" class="form-control" required="">' +
                                    '<option value="">Select Project</option>' + type.data + '</select>');
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
            }
        });
    }
    
    /*  Fetching Projects Reports  */
    function fetchProjectReport(formdata)
    {
         $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata+'&autoloader=true&action=adminReport/projectsReports',
            success: function (data, textStatus, xhr) {
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
                        if (type)
                        {
                            $(ctrl.displayreports).html(type);
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
            }
        });
    }
    
}

