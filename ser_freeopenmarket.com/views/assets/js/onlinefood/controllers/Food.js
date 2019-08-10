function APIController() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddUser = function () {
//        fetchUserTypes();
        fetchUserGender();
        bindAddUserEvents();
        ListUserPersonal();
//        fetchUserTypesEdit();
//        fetchUserGenderEdit();
        bindEditUserEvents();
        fetchDocTypes();

    };
    this.__AddBusinessUser = function () {
        bindAddUserBusinessEvents();
        ListUserBusiness();
        fetchBusIdTypes();
        fetchBusAddTypes();
    };
    this.__ListUserRequests = function () {
        UserRequests();
    };
    function bindAddUserEvents() {
        var register = members.ApiPersonal.AddUser;
        var fields = members.ApiPersonal.AddUser.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picedit = false;
        var checkusr = 0;
        var picEditObj1 = {};
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
        $('#' + fields[2]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-30:+0',
            //onClose: function (dateText, inst) {
            //    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDate));
            //}
        });
        picEditObj1 = $('#' + fields[15]).picEdit({
            imageUpdated: function (_this) {
                //LogMessages(_this);
                //picEditObj1._setDefaultImage(img.src);
                //throw new Error('Stop Damn Recursion');
                //return false;
            },
            formError: function (res) {
                picedit = false;
            },
            /* Soharab Modification */
            formProgress: function (data) {
                $('#' + fields[16]).prop('disabled', 'disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                //LogMessages(res);
            },
            /* Soharab Modification */
            formSubmitted: function (data) {
                $('#' + fields[16]).removeAttr('disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                if (res.readyState && picEditObj1._formComplete()) {
                    picedit = true;
                } else {
                    alert('Error could not update ID proof !!!.');
                }
            },
            FormObj: $('#' + register.form),
            goFlag: true,
            picEditUpload: false,
            redirectUrl: false,
            defaultImage: register.defaultImage,
        });
        //$('#' + fields[8]).parent().css({
        //marginLeft: '0%',
        //marginRight: '0%',
        //backgroundColor: '#C0C0C0',
        //});
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
            picedit = true;
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            picedit = false;
            checkusr = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            if (checkusr && picedit && $('#' + fields[15]).prop('files').length > 0) {
                var formdata = new FormData();
                formdata.append("name", $('#' + fields[0]).val());
                formdata.append("email", $('#' + fields[1]).val());
                formdata.append("dob", $('#' + fields[2]).val());
                formdata.append("gender", $('#' + fields[3]).val());
                formdata.append("mobile1", $('#' + fields[4]).val());
                formdata.append("mobile2", $('#' + fields[5]).val());
                formdata.append("addline", $('#' + fields[6]).val());
                formdata.append("country", $('#' + fields[7]).val());
                formdata.append("state", $('#' + fields[8]).val());
                formdata.append("distct", $('#' + fields[9]).val());
                formdata.append("city", $('#' + fields[10]).val());
                formdata.append("stloc", $('#' + fields[11]).val());
                formdata.append("zipc", $('#' + fields[12]).val());
                formdata.append("proof_id", $('#' + fields[13]).val());
                formdata.append("proof_type", $('#' + fields[14]).val());
                formdata.append("file", $('#' + fields[15]).prop('files')[0]);
                AddUserDB(formdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindAddUserBusinessEvents() {
        var register = members.ApiBusiness.AddBusiness;
        var fields = members.ApiBusiness.AddBusiness.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picedit1 = false;
        var picedit2 = false;
        var picEditObj1 = {};
        var picEditObj2 = {};
        $('#' + fields[24]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-30:+0',
        });
        picEditObj1 = $('#' + fields[19]).picEdit({
            imageUpdated: function (_this) {
                //LogMessages(_this);
                //picEditObj1._setDefaultImage(img.src);
                //throw new Error('Stop Damn Recursion');
                //return false;
            },
            formError: function (res) {
                picedit1 = false;
            },
            /* Soharab Modification */
            formProgress: function (data) {
                $('#' + fields[23]).prop('disabled', 'disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                //LogMessages(res);
            },
            /* Soharab Modification */
            formSubmitted: function (data) {
                $('#' + fields[23]).removeAttr('disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                if (res.readyState && picEditObj1._formComplete()) {
                    picedit1 = true;
                } else {
                    alert('Error could not update ID proof !!!.');
                }
            },
            FormObj: $('#' + register.form),
            goFlag: true,
            picEditUpload: false,
            redirectUrl: false,
            defaultImage: register.defaultImage,
        });
        picEditObj2 = $('#' + fields[22]).picEdit({
            imageUpdated: function (_this) {
                //LogMessages(_this);
                //picEditObj2._setDefaultImage(img.src);
                //throw new Error('Stop Damn Recursion');
                //return false;
            },
            formError: function (res) {
                picedit2 = false;
            },
            /* Soharab Modification */
            formProgress: function (data) {
                $('#' + fields[23]).prop('disabled', 'disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                //LogMessages(res);
            },
            /* Soharab Modification */
            formSubmitted: function (data) {
                $('#' + fields[23]).removeAttr('disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                if (res.readyState && picEditObj2._formComplete()) {
                    picedit2 = true;
                } else {
                    alert('Error could not update ID proof !!!.');
                }
            },
            FormObj: $('#' + register.form),
            goFlag: true,
            picEditUpload: false,
            redirectUrl: false,
            defaultImage: register.defaultImage,
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
            picedit1 = true;
            picedit2 = true;
        }
        ;
        params['invalidHandler'] = function () {
            picedit1 = false;
            picedit2 = false;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            if (picedit1 &&
                    picedit2 &&
                    $('#' + fields[19]).prop('files').length > 0 &&
                    $('#' + fields[22]).prop('files').length > 0) {
                var formdata = new FormData();
                formdata.append("user_pk", $('#' + fields[25]).val());
                formdata.append("bname", $('#' + fields[0]).val());
                formdata.append("doc", $('#' + fields[24]).val());
                formdata.append("oname", $('#' + fields[1]).val());
                formdata.append("websiet", $('#' + fields[2]).val());
                formdata.append("acname", $('#' + fields[3]).val());
                formdata.append("acno", $('#' + fields[4]).val());
                formdata.append("acifsc", $('#' + fields[5]).val());
                formdata.append("bnkame", $('#' + fields[6]).val());
                formdata.append("bnkcode", $('#' + fields[7]).val());
                formdata.append("bbrname", $('#' + fields[8]).val());
                formdata.append("bbrcode", $('#' + fields[9]).val());
                formdata.append("addline", $('#' + fields[10]).val());
                formdata.append("country", $('#' + fields[11]).val());
                formdata.append("state", $('#' + fields[12]).val());
                formdata.append("distct", $('#' + fields[13]).val());
                formdata.append("city", $('#' + fields[14]).val());
                formdata.append("stloc", $('#' + fields[15]).val());
                formdata.append("zipc", $('#' + fields[16]).val());
                formdata.append("bproof_id", $('#' + fields[17]).val());
                formdata.append("bproof_type", $('#' + fields[18]).val());
                formdata.append("adproof_id", $('#' + fields[20]).val());
                formdata.append("adproof_type", $('#' + fields[21]).val());
                formdata.append("file[]", $('#' + fields[19]).prop('files')[0]);
                formdata.append("file[]", $('#' + fields[22]).prop('files')[0]);
                AddUserBusinessDB(formdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
        searchUsers({
            mem: register.searchuser,
            sel: fields[25],
        });
    }
    ;
    function fetchDocTypes() {
        var mem = members.ApiPersonal.AddUser.doctype;
        var fields = members.ApiPersonal.AddUser.fields;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                listtype: mem.listtype
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + fields[14]).html(data.html);
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
     function fetchBusIdTypes() {
        var mem = members.ApiBusiness.AddBusiness.busidtype;
        var fields = members.ApiBusiness.AddBusiness.fields;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                listtype: mem.listtype
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + fields[18]).html(data.html);
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
     function fetchBusAddTypes() {
        var mem = members.ApiBusiness.AddBusiness.busadddoctype;
        var fields = members.ApiBusiness.AddBusiness.fields;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                listtype: mem.listtype
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + fields[21]).html(data.html);
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
    function fetchUserGender() {
        var mem = members.ApiPersonal.AddUser.gender;
        var fields = members.ApiPersonal.AddUser.fields;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                listtype: mem.listtype,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + fields[3]).html(data.html);
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
    function checkEmail(email) {
        var checkemail = members.ApiPersonal.AddUser.checkemail;
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
    function  AddUserDB(attr) {
        var register = members.ApiPersonal.AddUser;
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
                    alert('Successfully added user !!!');
                    $(form).get(0).reset();
                }
                else {
                    alert('Error occured !!!');
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
    function AddUserBusinessDB(attr) {
        var register = members.ApiBusiness.AddBusiness;
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
                if (obj.status === "success") {
                    alert('Successfully added business details !!!');
                }
                else {
                    alert('Error occured !!!');
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function ListUserPersonal() {
        var users = members.ApiPersonal.ListUser;
        var fields = users.fields;
        window.setTimeout(function () {
            $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                ajax: {
                    url: users.url,
                    dataType: users.dataType,
                    type: users.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = users.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        LogMessages(listusers);
                    }
                },
                initComplete: function (settings, json) {
                    var data = json.data;
                    if (data) {
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                $('#' + fields[0]).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list users.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Name', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Mobile', searchable: true, orderable: true},
                    {data: 'Proof ID', searchable: true, orderable: true},
                    {data: 'Proof Type', searchable: true, orderable: true},
                    {data: 'Proof Picture', searchable: false, orderable: false},
                    {data: 'Edit', searchable: false, orderable: false},
                ]
            });
            var dtable = $('#' + fields[0]).dataTable().api();
            $(".dataTables_filter input").unbind().bind("input", function (e) {
                if (this.value.length >= 3 || e.keyCode == 13) {
                    dtable.search(this.value).draw();
                }
                if (this.value == "") {
                    dtable.search("").draw();
                }
                return;
            });
        }, 600);
    }
    ;
    function ListUserBusiness() {
        var users = members.ApiBusiness.ListBusiness;
        var fields = users.fields;
        window.setTimeout(function () {
            $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                ajax: {
                    url: users.url,
                    dataType: users.dataType,
                    type: users.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = users.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        LogMessages(listusers);
                    }
                },
                initComplete: function (settings, json) {
                    var data = json.data;
                    if (data) {
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                $('#' + fields[0]).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list users.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Name', searchable: true, orderable: true},
                    {data: 'Owner', searchable: true, orderable: true},
                    {data: 'Established', searchable: true, orderable: true},
                    {data: 'Website', searchable: true, orderable: true},
                    {data: 'Proof ID', searchable: true, orderable: true},
                    {data: 'Proof Type', searchable: true, orderable: true},
                    {data: 'Proof Picture', searchable: false, orderable: false},
                    {data: 'Edit', searchable: false, orderable: false},
                ]
            });
            var dtable = $('#' + fields[0]).dataTable().api();
            $(".dataTables_filter input").unbind().bind("input", function (e) {
                if (this.value.length >= 3 || e.keyCode == 13) {
                    dtable.search(this.value).draw();
                }
                if (this.value == "") {
                    dtable.search("").draw();
                }
                return;
            });
        }, 600);
    }
    ;
    function searchUsers(para) {
        var mem = para.mem;
        var sel = para.sel;
        $('#' + sel).select2({
            ajax: {
                url: mem.url,
                dataType: mem.dataType,
                type: mem.type,
                //processData: mem.processData,
                //contentType: mem.contentType,
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true,
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            maximumSelectionLength: -1,
            placeholder: "Select User",
            allowClear: true,
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width: 'resolve',
        });
    }
    ;
    function ProcessUser(id, stat) {
        var users = members.ApiRequest.ProcessUser;
        var obj = {};
        $.ajax({
            dataType: users.dataType,
            type: users.type,
            //processData: users.processData,
            //contentType: users.contentType,
            url: users.url,
            data: {
                id: Number(id),
                stat: Number(stat),
            },
            success: function (data, textStatus, xhr) {
                LogMessages(data);
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    alert('Successfully Done !!!');
                }
                else {
                    alert('Error occured !!!');
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function UserRequests() {
        var buts = members.ApiRequest;
        window.setTimeout(function () {
            $('#' + buts.but1).click(function () {
                var users = members.ApiRequest.ListNewRequest;
                var fields = users.fields;
                bindShowListBind(users, fields);
            });
            $('#' + buts.but1).trigger('click');
        }, 200);
        window.setTimeout(function () {
            $('#' + buts.but2).click(function () {
                var users = members.ApiRequest.ListAcceptRequest;
                var fields = users.fields;
                bindShowListBind(users, fields);
            });
            $('#' + buts.but2).trigger('click');
        }, 400);
        window.setTimeout(function () {
            $('#' + buts.but3).click(function () {
                var users = members.ApiRequest.ListRejectRequest;
                var fields = users.fields;
                bindShowListBind(users, fields);
            });
            $('#' + buts.but3).trigger('click');
        }, 600);
    }
    ;
    function bindShowListBind(users, fields) {
        window.setTimeout(function () {
            $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                dom: 'Bfliptr',
                ajax: {
                    url: users.url,
                    dataType: users.dataType,
                    type: users.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = users.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            $(listusers.btnid).bind('click', {
                                uid: listusers.uid,
                                actionid: listusers.actionid,
                                users: fields,
                                fields: fields,
                            }, function (evt) {
                                var uid = evt.data.uid;
                                var actionid = evt.data.actionid;
                                var users = evt.data.users;
                                var fields = evt.data.fields;
                                ProcessUser(uid, actionid);
                                bindShowListBind(users, fields);
                            });
                        }, 800);
                    }
                },
                initComplete: function (settings, json) {
                    var data = json.data;
                    if (data) {
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                $('#' + fields[0]).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list users.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + fields[0]).css('width', '100%');
                },
                columns: [
                    {data: 'Id', searchable: true, orderable: true},
                    {data: 'Name', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Cell', searchable: true, orderable: true},
                    {data: 'Registered Date', searchable: true, orderable: true},
                    {data: 'Action', searchable: false, orderable: false},
                ]
            });
            var dtable = $('#' + fields[0]).dataTable().api();
            $(".dataTables_filter input").unbind().bind("input", function (e) {
                if (this.value.length >= 3 || e.keyCode == 13) {
                    dtable.search(this.value).draw();
                }
                if (this.value == "") {
                    dtable.search("").draw();
                }
                return;
            });
        }, 600);
    }
    ;
    function bindEditUserEvents() {
        var register = members.EditUser;
        var fields = members.EditUser.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picedit = false;
        var checkusr = 0;
        var picEditObj1 = {};
//        $('#' + fields[0]).click(function () {
//            fetchUserTypes();
//        });
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
        $('#' + fields[2]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-30:+0',
            //onClose: function (dateText, inst) {
            //    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDate));
            //}
        });
        picEditObj1 = $('#' + fields[15]).picEdit({
            imageUpdated: function (_this) {
                //LogMessages(_this);
                //picEditObj1._setDefaultImage(img.src);
                //throw new Error('Stop Damn Recursion');
                //return false;
            },
            formError: function (res) {
                picedit = false;
            },
            /* Soharab Modification */
            formProgress: function (data) {
                $('#' + fields[16]).prop('disabled', 'disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                //LogMessages(res);
            },
            /* Soharab Modification */
            formSubmitted: function (data) {
                $('#' + fields[16]).removeAttr('disabled');
                var res = {};
                if (typeof data === 'object') {
                    res = data;
                } else {
                    res = $.parseJSON($.trim(data));
                }
                if (res.readyState && picEditObj1._formComplete()) {
                    picedit = true;
                } else {
                    alert('Error could not update ID proof !!!.');
                }
            },
            FormObj: $('#' + register.form),
            goFlag: true,
            picEditUpload: false,
            redirectUrl: false,
            defaultImage: register.defaultImage,
        });
        //$('#' + fields[8]).parent().css({
        //marginLeft: '0%',
        //marginRight: '0%',
        //backgroundColor: '#C0C0C0',
        //});
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
            picedit = true;
            checkusr = 1;
        }
        ;
        params['invalidHandler'] = function () {
            picedit = false;
            checkusr = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            if (checkusr && picedit && $('#' + fields[15]).prop('files').length > 0) {
                var formdata = new FormData();
                formdata.append("name", $('#' + fields[0]).val());
                formdata.append("email", $('#' + fields[1]).val());
                formdata.append("dob", $('#' + fields[2]).val());
                formdata.append("gender", $('#' + fields[3]).val());
                formdata.append("mobile1", $('#' + fields[4]).val());
                formdata.append("mobile2", $('#' + fields[5]).val());
                formdata.append("addline", $('#' + fields[6]).val());
                formdata.append("country", $('#' + fields[7]).val());
                formdata.append("state", $('#' + fields[8]).val());
                formdata.append("distct", $('#' + fields[9]).val());
                formdata.append("city", $('#' + fields[10]).val());
                formdata.append("stloc", $('#' + fields[11]).val());
                formdata.append("zipc", $('#' + fields[12]).val());
                formdata.append("proof_id", $('#' + fields[13]).val());
                formdata.append("proof_type", $('#' + fields[14]).val());
                formdata.append("file", $('#' + fields[15]).prop('files')[0]);
                EditUserDB(formdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function EditUserDB() {
        var register = members.EditUser;
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
                    alert('Successfully modified user !!!');
                    $(form).get(0).reset();
                }
                else {
                    alert('Error occured !!!');
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
//    function fetchUserTypesEdit() {
//        var mem = members.EditUser.usertype;
//        var fields = members.EditUser.fields;
//        var obj = {};
//        $.ajax({
//            url: mem.url,
//            type: mem.type,
//            dataType: mem.dataType,
//            data: {
//                listtype: mem.listtype,
//                usertype_ids: [2, 3, 4, 5, 6, 7, 8],
//            },
//            success: function (data, textStatus, xhr) {
//                if (typeof data === 'object') {
//                    obj = data;
//                }
//                else {
//                    obj = $.parseJSON($.trim(data));
//                }
//                if (obj.status === "success") {
//                    $('#' + fields[0]).html(data.html);
//                }
//            },
//            error: function (xhr, textStatus) {
//                LogMessages(xhr.responseText);
//                LogMessages(textStatus);
//            },
//            complete: function (xhr, textStatus) {
//                LogMessages(xhr.status);
//            }
//        });
//    }
//    ;
//    function fetchUserGenderEdit() {
//        var mem = members.EditUser.gender;
//        var fields = members.EditUser.fields;
//        var obj = {};
//        $.ajax({
//            url: mem.url,
//            type: mem.type,
//            dataType: mem.dataType,
//            async: false,
//            data: {
//                listtype: mem.listtype,
//            },
//            success: function (data, textStatus, xhr) {
//                if (typeof data === 'object') {
//                    obj = data;
//                }
//                else {
//                    obj = $.parseJSON($.trim(data));
//                }
//                if (obj.status === "success") {
//                    $('#' + fields[4]).html(data.html);
//                }
//            },
//            error: function (xhr, textStatus) {
//                LogMessages(xhr.responseText);
//                LogMessages(textStatus);
//            },
//            complete: function (xhr, textStatus) {
//                LogMessages(xhr.status);
//            }
//        });
//    }
//    ;
}
