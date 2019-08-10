function profile() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
        changePassword();
    };
    function changePassword() {
        var mem = members.ChangePassword;
        var fields = members.ChangePassword.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + mem.form);
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
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            if (checkusr) {
                var formdata = new FormData();
                formdata.append("oldpass", $('#' + fields[0]).val());
                formdata.append("newpass", $('#' + fields[1]).val());
                formdata.append("confrmpass", $('#' + fields[2]).val());
                AddUserDB(formdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function AddUserDB(attr) {
        var mem = members.ChangePassword;
        var form = $('#' + mem.form);
        LogMessages(attr);
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            processData: mem.processData,
            contentType: mem.contentType,
            data: attr,
            success: function (data, textStatus, xhr) {
                LogMessages(data);
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    alert('Password changed successfully');
                    $(form).get(0).reset();
                }
                else if (obj.status === "alreadyexist") {
                    alert('Password not changed,same password entered');
                    $(form).get(0).reset();
                }
                else if (obj.status === "error") {
                    alert('Wrong password entered');
                    $(form).get(0).reset();
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
 }


