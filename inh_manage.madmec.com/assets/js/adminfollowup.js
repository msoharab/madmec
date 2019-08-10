function adminfollowup()
{
    var followup = {};
    this.__construct = function (followupctrl) {
        followup = followupctrl;
        fetchCurrentFollowups();
        $(followup.pending_followmenubut).on('click', function () {
            fetchPendingFollowups();
        });
        $(followup.expired_followmenubut).on('click', function () {
            fetchExpiredFollowups();
        });
//        $('#numbut').click(function (){
//            callAnotherServerFile();
//        })
    }
    function fetchCurrentFollowups()
    {
        $(followup.current_follow_data).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {autoloader: true, action: 'fetchcurrfollowup', type: 'master'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var details = $.parseJSON(data);
                        if (details.status == "success")
                        {
                            var header = '<table class="table table-striped table-bordered table-hover" id="curr_follo_table">';
                            var tableHeading = '<thead><th>#</th><th>Owner Name</th><th>User Name</th><th>Mobile</th><th>Email</th><th>Follow Up Date</th><th>Due Amount</th></tr></thead><tbody>';
                            var footer = '</tbody></table>';
                            $(followup.current_follow_data).html(header + tableHeading + details.data + footer);
                            window.setTimeout(function () {
                                $('#curr_follo_table').dataTable();
                            }, 400);
                        }
                        else
                        {
                            $(followup.current_follow_data).html('<span class="text-danger"><strong>no Current Followup  ||||</strong></span>');
                        }
                        break;
                }
            },
            error: function () {
                $(followup.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function  fetchPendingFollowups()
    {
        $(followup.pending_follow_data).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {autoloader: true, action: 'fetchpendingfollowup', type: 'master'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
//                        console.log(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var details = $.parseJSON(data);
                        if (details.status == "success")
                        {
                            var header = '<table class="table table-striped table-bordered table-hover" id="pend_follo_table">';
                            var tableHeading = '<thead><th>#</th><th>Owner Name</th><th>User Name</th><th>Mobile</th><th>Email</th><th>Follow Up Date</th><th>Due Amount</th></tr></thead><tbody>';
                            var footer = '</tbody></table>';
                            $(followup.pending_follow_data).html(header + tableHeading + details.data + footer);
                            window.setTimeout(function () {
                                $('#pend_follo_table').dataTable();
                            }, 400);
                        }
                        else
                        {
                            $(followup.pending_follow_data).html('<span class="text-danger"><strong>no Pending Followup  ||||</strong></span>');
                        }
                        break;
                }
            },
            error: function () {
                $(followup.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchExpiredFollowups()
    {
        $(followup.expired_follow_data).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {autoloader: true, action: 'fetchexpiredfollowup', type: 'master'},
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
//                        console.log(data);
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
                            var header = '<table class="table table-striped table-bordered table-hover" id="exp_follo_table">';
                            var tableHeading = '<thead><th>#</th><th>Owner Name</th><th>User Name</th><th>Mobile</th><th>Email</th><th>Follow Up Date</th><th>Due Amount</th></tr></thead><tbody>';
                            var footer = '</tbody></table>';
                            $(followup.expired_follow_data).html(header + tableHeading + type.data + footer);
                            window.setTimeout(function () {
                                $('#exp_follo_table').dataTable();
                            }, 400);
                        }
                        else
                        {
                            $(followup.expired_follow_data).html('<span class="text-danger"><strong>no Expired Followup  ||||</strong></span>');
                        }
                        break;
                }
            },
            error: function () {
                $(followup.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

//    function  callAnotherServerFile()
//    {
//        var num1=$('#num1').val();
//        var num2=$('#num2').val();
//        alert(num1+num2)
//        $.ajax({
//                url : 'http://localhost:8084/test/test.jsp',
//                dataType: 'jsonp',
//                data:{num1:num1,num2:num2},
//                success:function(data, textStatus, xhr){
//                        data = $.trim(data);
//                        console.log(data);
//                        alert(data);
//                },
//                error:function(){
//                        $(followup.outputDiv).html(INET_ERROR);
//                },
//                complete: function(xhr, textStatus) {
//                        console.log(xhr.status);
//                }
//        });  
//    }
}



