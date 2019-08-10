function controlCustomerImport() {
    var impcust = {};
    var gymid = $(DGYM_ID).attr("name");
    this.__construct = function (imp) {
        impcust = imp;
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status1');
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
        /*fetchTrainerType();*/
        fetchfactdata();
    };
    function fetchfactdata() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'getallfact',
                id: gymid,
                type: 'slave',
                gymid: gymid
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $("#import_facility").html(data);
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    ;
}
;
