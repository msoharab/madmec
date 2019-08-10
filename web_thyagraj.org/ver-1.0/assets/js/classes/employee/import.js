function imports()
{
    var ctrl = {};
    this.__construct = function (ctrl1) {
        ctrl = ctrl1;
        fetchActivities();
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#upload_status');
        $('#customerdetailsxls').ajaxForm({
            beforeSend: function () {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function () {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            complete: function (xhr) {
                var percentVal = '0%';
                if (xhr.responseText.length == 0) {
                    bar.width(percentVal);
                    percent.html(percentVal);
                }
                /*alert("reach last");*/
                status.html(xhr.responseText);
                /*status.append("kul");*/
            }
        });
    };

    function fetchActivities()
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
                            $('#displayallproj').html(' <select  id="selectproject" name="selectproject" class="form-control" required="">' +
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

}
;


