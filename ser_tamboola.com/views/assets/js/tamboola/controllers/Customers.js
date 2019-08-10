function customersController() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddCustomers = function () {
        var managers = members.AddCustomers;
        var fields = members.AddCustomers.fields;
        fetchGender({
            mem: managers.gender,
            fields: fields,
            index: Number(1)
        });
        $('#' + fields[8]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            yearRange: '-30:+0',
        });
        bindAddCustomersEvents();
//        bindAssignManagersEvents();
    };
    function bindAddCustomersEvents() {
        var managers = members.AddCustomers;
        var fields = managers.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + managers.form);
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
                var frmdata = new FormData();
                frmdata.append("name", $('#' + fields[0]).val());
                frmdata.append("gender", $('#' + fields[1]).val());
                frmdata.append("cellnumber", $('#' + fields[2]).val());
                frmdata.append("email", $('#' + fields[3]).val());
                frmdata.append("company", $('#' + fields[4]).val());
                frmdata.append("occupation", $('#' + fields[5]).val());
                frmdata.append("regisfee", $('#' + fields[6]).val());
                frmdata.append("amount", $('#' + fields[7]).val());
                frmdata.append("doj", $('#' + fields[8]).val());
                frmdata.append("referred", $('#' + fields[9]).val());
                frmdata.append("emergencyname", $('#' + fields[10]).val());
                frmdata.append("emergencynum", $('#' + fields[11]).val());
                frmdata.append("country", $('#' + fields[12]).val());
                frmdata.append("state", $('#' + fields[13]).val());
                frmdata.append("district", $('#' + fields[14]).val());
                frmdata.append("city", $('#' + fields[15]).val());
                frmdata.append("street", $('#' + fields[16]).val());
                frmdata.append("addressline", $('#' + fields[17]).val());
                frmdata.append("zipcode", $('#' + fields[18]).val());
                AddUserDB(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindAssignManagersEvents() {
        var managers = members.AssignManager;
        var fields = managers.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + managers.form);
        var checkusr = 0;
        fetchAdmin({
            mem: managers.admin,
            fields: fields,
            index: Number(0)
        });
        fetchGyms({
            mem: managers.gym,
            fields: fields,
            index: Number(1)
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
                var frmdata = new FormData();
                frmdata.append("name", $('#' + fields[0]).val());
                frmdata.append("gender", $('#' + fields[1]).val());
                AddUserDB(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function AddUserDB(attr) {
        var managers = members.AddCustomers;
        var form = $('#' + managers.form);
        LogMessages(attr);
        var obj = {};
        $.ajax({
            url: managers.url,
            type: managers.type,
            dataType: managers.dataType,
            processData: false,
            contentType: false,
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
    function fetchGender(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
                    $('#' + fields[index]).html(data.html);
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
    function fetchUserType(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
                    $('#' + fields[index]).html(data.html);
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
    function fetchDocType(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
                    $('#' + fields[index]).html(data.html);
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
    function fetchAdmin(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
                    $('#' + fields[index]).html(data.html);
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
    function fetchGyms(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
                    $('#' + fields[index]).html(data.html);
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
}
