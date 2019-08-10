function Register() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddUser = function () {
        fetchUserTypes();
        bindAddUserEvents();
        updateTraffic();
    };
    function updateTraffic() {
        var traffic = members.traffic;
        var obj = {};
        $.ajax({
            url: traffic.url,
            type: 'POST',
            data: {
                autoloader: traffic.autoloader,
                action: traffic.action
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                switch (obj.status) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(members.outputDiv).html('<center><h1>Welcome To Local Talent</h1></center>');
                        break;
                }
            },
            error: function (xhr, textStatus) {
                $(members.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                LogMessages(xhr.status);
            }
        });
    }
    ;
    function bindAddUserEvents() {
        var register = members.Register;
        var fields = register.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var checkusr = 0;
        $('#' + fields[0]).change(function () {
            if (this.value.match(nm_reg)) {
                checkusr = 1;
            }
            else {
                checkusr = 0;
            }
        });
        $('#' + fields[1]).on('mouseup blur change', function () {
            if (this.value.match(email_reg)) {
                checkusr = checkEmail(this.value);
            }
            else {
                checkusr = 0;
            }
        });
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
                formdata.append("name", $('#' + fields[0]).val());
                formdata.append("email", $('#' + fields[1]).val());
                formdata.append("pass1", $('#' + fields[2]).val());
                formdata.append("pass2", $('#' + fields[3]).val());
                formdata.append("mobile1", $('#' + fields[4]).val());
                formdata.append("mobile2", $('#' + fields[5]).val());
                formdata.append("utype", $('#' + fields[6]).val());
                AddUserDB(formdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function checkEmail(email) {
        var checkemail = members.Register.checkemail;
        var checkusr = 0;
        var obj = {};
        $.ajax({
            url: checkemail.url,
            type: checkemail.type,
            dataType: checkemail.dataType,
            async: false,
            data: {
                email: email
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (Number(obj.count) > 0 && obj.status === 'success') {
                    checkusr = 0;
                } else {
                    checkusr = 1;
                }
            },
            error: function (xhr, textStatus) {
                $(checkemail.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
        return checkusr;
    }
    ;
    function fetchUserTypes() {
        var mem = members.Register.usertype;
        var fields = members.Register.fields;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                listtype: mem.listtype,
                usertype_ids: mem.usertype_ids,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + fields[6]).html(data.html);
                }
            },
            error: function (xhr, textStatus) {
                LogMessages(xhr.responseText);
                LogMessages(textStatus);
            },
            complete: function (xhr, textStatus) {
                LogMessages(xhr.status);
            }
        });
    }
    ;
    function AddUserDB(attr) {
        var register = members.Register;
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
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    alert('Successfully Registered');
                    $(form).get(0).reset();
                }
                else if (obj.status === "alreadyexist") {
                    alert('You have already registered.... Please enter unique UserName!!! ');
                    $(form).get(0).reset();
                }
                else if (obj.status === "error") {
                    alert('Error occured');
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
