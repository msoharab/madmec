function controlStatAccount() {
    var gymid = $(DGYM_ID).attr("name");
    sac = {};
    this.__construct = function (stats) {
        sac = stats;
        listAccountStats();
    }
    function listAccountStats() {
        $(loader).html(LOADER_SIX);
        $.ajax({
            url: sac.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'listAccountStats',
                type: 'slave',
                gymid: gymid
            },
            success: function (data, textStatus, xhr) {
                console.log(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(sac.output).html(data);
                        break;
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
}
;
