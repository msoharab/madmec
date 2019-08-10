function ForgotPassword() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__SendPass = function () {
        bindAddUserEvents();
    };
    function bindAddUserEvents() {
        var register = members.ForgotPassword;
        var fields = register.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        params['submitHandler'] = function () {
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            checkusr = 0;
            alert('Please correct the credentials..');
        }
        ;
        $(form).validate(params);
        $(form).submit(function (e) {
            if (checkusr) {
                var frmdata = new FormData();
                frmdata.append("email", $('#' + fields[0]).val());
                SendPassword(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function SendPassword(attr) {
        var register = members.ForgotPassword;
        var form = $('#' + register.form);
        LogMessages(attr);
        var obj = {};
        $.ajax({
            url: register.url,
            type: register.type,
            dataType: register.dataType,
            processData: register.processData,
            contentType: register.contentType,
            data: attr,
            success: function (data, textStatus, xhr) {
                LogMessages(data);
                $(form).get(0).reset();
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                alert(obj.msg);
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
}
