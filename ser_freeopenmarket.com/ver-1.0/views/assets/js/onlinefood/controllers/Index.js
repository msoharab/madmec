function IndexController() {
    var members = {};

    this.__constructor = function (para) {
        members = para;
        var obj = new Login();
        obj.__constructor(para.index);
        updateTrafficLT();
    };
    this.bindActions = function () {

    };

    function updateTrafficLT() {
        var mem = members.index.traffic;
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            processData: mem.processData,
            contentType: mem.contentType,
            data: {
                browser: window.navigator.userAgent
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        //$(members.outputDiv).html('<center><h1>Welcome To Local Talent</h1></center>');
                        break;
                }
            },
            error: function (xhr, textStatus) {
                $(members.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
}

$(document).ready(function () {
    var this_js_script = $("script[src$='Index.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            LogMessages('I am In Index');
            var para = getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Index/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).onlinefood;
            var obj = new IndexController();
            obj.__constructor(para);
        }
        else {
            LogMessages('I am Out Index');
        }
    }
});
