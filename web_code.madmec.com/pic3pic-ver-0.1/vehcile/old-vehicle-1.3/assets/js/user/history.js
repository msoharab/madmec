function history()
{
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        fetchBookedAppointments();
    };
    function fetchBookedAppointments(){
        $("#displayuvehicless").html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: '&autoloader=true&action=userhistory/fetchBookedAppointments',
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
                                    '<tr><th>#</th><th>Vehicle Name</th><th>Date</th><th>Slot Time</th><th>ServiceType</th><th>BookService</th><th>Center Details</th></tr></thead><tbody>';
                            var footer = '</tbody></table></div>';
                            $("#displayuvehicless").html(header+type.data+footer);
                            window.setTimeout(function (){
                               $('#list_col_table').dataTable();
                                if (type.donorids.length)
                                {

                                    for (i = 0; i < type.donorids.length; i++)
                                    {
                                        $('#donordel_' + type.donorids[i]).bind('click', {
                                            donorid: type.donorids[i],
                                            addpdescbid : type.addpdescbid[i]
                                        }, function (evt) {
                                            deleteAppointment(evt.data.donorid,evt.data.addpdescbid);
                                        });
                                    }
                                }
                            },600)
                            
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
    };
}
;

