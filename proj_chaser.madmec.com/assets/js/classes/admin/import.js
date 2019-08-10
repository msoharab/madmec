function importXLS()
{
    var ctrl = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
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
}

