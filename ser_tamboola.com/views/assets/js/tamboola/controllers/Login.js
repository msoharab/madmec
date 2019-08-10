function Login() {
    var members = {};
    this.__constructor = function (para) {
        members = para.Login;
        initializeSingIn();
    };
    function initializeSingIn() {
        var memadd = members;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + memadd.form);
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        for (i = 0; i < memadd.fields.length; i++) {
            var field = $('#' + memadd.fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                LogMessages(rules);
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        params['submitHandler'] = function () {
            signIn({
                name: $('#' + memadd.fields[0]).val(),
                pass: $('#' + memadd.fields[1]).val(),
                browser: window.navigator.userAgent,
            });
        };
        params['invalidHandler'] = function () {
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
    }
    ;
    function signIn(attr) {
        var mem = members
        var res = {};
        if (attr) {
            disableFileds();
            $.ajax({
                url: mem.url,
                type: mem.type,
                dataType: mem.dataType,
                //processData: mem.processData,
                //contentType: mem.contentType,
                async: false,
                data: attr,
                success: function (data, textStatus, xhr) {
                    if (typeof data === 'object') {
                        res = data;
                    } else {
                        res = $.parseJSON($.trim(data));
                    }
                    if (res.status === "success") {
                        window.setTimeout(function () {
                            window.location.href = mem.Redurl;
                        }, 800);
                    }
                    else {
                        alert("Invalid Username/Password");
                    }
                },
                error: function (xhr, textStatus) {
                },
                complete: function (xhr, textStatus) {
                }
            });
        }
        enableFileds();
    }
    ;
    function disableFileds() {
        var memadd = members;
        for (i = 0; i < memadd.fields.length; i++) {
            $('#' + memadd.fields[i]).prop('disabled', 'disabled');
        }
    }
    ;
    function enableFileds() {
        var memadd = members;
        for (i = 0; i < memadd.fields.length; i++) {
            $('#' + memadd.fields[i]).removeAttr('disabled');
        }
    }
    ;
}
$(document).ready(function () {
    var this_js_script = $("script[src$='Login.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            LogMessages('I am In Login');
            var para = getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Login/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).tamboola.index;
            var obj = new Login();
            obj.__constructor(para);
        }
        else {
            LogMessages('I am Out Login');
        }
    }
});
