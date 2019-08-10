function userController() {
    var members = {};
    var users = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddUser = function () {
        var register = members.Personal.AddUser;
        var fields = members.Personal.AddUser.fields;
        fetchUserTypes({
            mem: register.usertype,
            fields: fields,
            index: Number(0)
        });
        fetchUserGender({
            mem: register.gender,
            fields: fields,
            index: Number(4)
        });
        bindAddUserEvents();
        ListUserPersonal();
        fetchDocTypes({
            mem: register.doctype,
            fields: fields,
            index: Number(15)
        });
    };
    this.__EditUser = function () {
        var register = members.EditUser;
        var fields = members.EditUser.fields;
        fetchUserTypes({
            mem: register.usertype,
            fields: fields,
            index: Number(0)
        });
        fetchUserGender({
            mem: register.gender,
            fields: fields,
            index: Number(4)
        });
        bindEditUserEvents();
        fetchDocTypes({
            mem: register.doctype,
            fields: fields,
            index: Number(15)
        });
    };
    this.__AddBusinessUser = function () {
        bindAddUserBusinessEvents();
        ListUserBusiness();
    };
    this.__ListUserRequests = function () {
        UserRequests();
    };
    function bindAddUserEvents() {
        var register = members.Personal.AddUser;
        var fields = members.Personal.AddUser.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picedit = false;
        var checkusr = 0;
        var picEditObj1 = {};
        $('#' + fields[1]).change(function () {
            if (this.value.match(nm_reg)) {
                checkusr = 1;
            }
            else {
                checkusr = 0;
            }
        });
        $('#' + fields[2]).on('mouseup blur change', function () {
            if (this.value.match(email_reg)) {
                checkusr = checkEmail(this.value);
            }
            else {
                checkusr = 0;
            }
        });
        $('#' + fields[3]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-30:+0',
            //onClose: function (dateText, inst) {
            //    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDate));
            //}
        });
        picEditObj1 = $('#' + fields[16]).picEdit({
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
                $('#' + fields[17]).prop('disabled', 'disabled');
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
                $('#' + fields[17]).removeAttr('disabled');
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
            if (checkusr && picedit && $('#' + fields[16]).prop('files').length > 0) {
                var frmdata = new FormData();
                frmdata.append("usertype", $('#' + fields[0]).val());
                frmdata.append("name", $('#' + fields[1]).val());
                frmdata.append("email", $('#' + fields[2]).val());
                frmdata.append("dob", $('#' + fields[3]).val());
                frmdata.append("gender", $('#' + fields[4]).val());
                frmdata.append("mobile1", $('#' + fields[5]).val());
                frmdata.append("mobile2", $('#' + fields[6]).val());
                frmdata.append("addline", $('#' + fields[7]).val());
                frmdata.append("country", $('#' + fields[8]).val());
                frmdata.append("state", $('#' + fields[9]).val());
                frmdata.append("distct", $('#' + fields[10]).val());
                frmdata.append("city", $('#' + fields[11]).val());
                frmdata.append("stloc", $('#' + fields[12]).val());
                frmdata.append("zipc", $('#' + fields[13]).val());
                frmdata.append("proof_id", $('#' + fields[14]).val());
                frmdata.append("proof_type", $('#' + fields[15]).val());
                frmdata.append("file", $('#' + fields[16]).prop('files')[0]);
                AddUserDB(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindAddUserBusinessEvents() {
        var register = members.Business.AddBusiness;
        var fields = members.Business.AddBusiness.fields;
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
                var frmdata = new FormData();
                frmdata.append("user_pk", $('#' + fields[25]).val());
                frmdata.append("bname", $('#' + fields[0]).val());
                frmdata.append("doc", $('#' + fields[24]).val());
                frmdata.append("oname", $('#' + fields[1]).val());
                frmdata.append("websiet", $('#' + fields[2]).val());
                frmdata.append("acname", $('#' + fields[3]).val());
                frmdata.append("acno", $('#' + fields[4]).val());
                frmdata.append("acifsc", $('#' + fields[5]).val());
                frmdata.append("bnkame", $('#' + fields[6]).val());
                frmdata.append("bnkcode", $('#' + fields[7]).val());
                frmdata.append("bbrname", $('#' + fields[8]).val());
                frmdata.append("bbrcode", $('#' + fields[9]).val());
                frmdata.append("addline", $('#' + fields[10]).val());
                frmdata.append("country", $('#' + fields[11]).val());
                frmdata.append("state", $('#' + fields[12]).val());
                frmdata.append("distct", $('#' + fields[13]).val());
                frmdata.append("city", $('#' + fields[14]).val());
                frmdata.append("stloc", $('#' + fields[15]).val());
                frmdata.append("zipc", $('#' + fields[16]).val());
                frmdata.append("bproof_id", $('#' + fields[17]).val());
                frmdata.append("bproof_type", $('#' + fields[18]).val());
                frmdata.append("adproof_id", $('#' + fields[20]).val());
                frmdata.append("adproof_type", $('#' + fields[21]).val());
                frmdata.append("file[]", $('#' + fields[19]).prop('files')[0]);
                frmdata.append("file[]", $('#' + fields[22]).prop('files')[0]);
                AddUserBusinessDB(frmdata);
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
    function fetchUserTypes(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                listtype: mem.listtype,
                usertype_ids: mem.usertype_ids
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
    function fetchDocTypes(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
    function fetchUserGender(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
    function checkEmail(email) {
        var checkemail = members.Personal.AddUser.checkemail;
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
    function AddUserDB(attr) {
        var register = members.Personal.AddUser;
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
        var register = members.Business.AddBusiness;
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
        var users = members.Personal.ListUser;
        var fields = users.fields;
        window.setTimeout(function () {
            $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ],
                columnDefs: [{
                        targets: 0,
                        visible: true
                    }
                ],
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
                    {data: 'User Type', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").attr("placeholder", "Enter search terms here");
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont1";
                    //aria-controls="fieldCurr1"
                    $(this).attr("id", id);
                    $('#' + id).bind("input", {
                        dtable: $('#' + fields[0]).dataTable().api()
                    }, function (e) {
                        var dtable = e.data.dtable;
                        if (this.value.length >= 2 || e.keyCode == 13) {
                            dtable.search(this.value).draw();
                        }
                        if (this.value == "") {
                            dtable.search("").draw();
                        }
                        return;
                    });
                    return;
                }
            });
        }, 600);
    }
    ;
    function ListUserBusiness() {
        var users = members.Business.ListBusiness;
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
                    {data: 'User Type', searchable: true, orderable: true},
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
        var users = members.Request.ProcessUser;
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
        var buts = members.Request;
        window.setTimeout(function () {
            $('#' + buts.but1).click(function () {
                var users = members.Request.ListNewRequest;
                var fields = users.fields;
                bindShowListBind(users, fields);
            });
            $('#' + buts.but1).trigger('click');
        }, 200);
        window.setTimeout(function () {
            $('#' + buts.but2).click(function () {
                var users = members.Request.ListAcceptRequest;
                var fields = users.fields;
                bindShowListBind(users, fields);
            });
            $('#' + buts.but2).trigger('click');
        }, 400);
        window.setTimeout(function () {
            $('#' + buts.but3).click(function () {
                var users = members.Request.ListRejectRequest;
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
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ],
                columnDefs: [{
                        targets: 2,
                        visible: true
                    }
                ],
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
                    {data: 'User Type', searchable: true, orderable: true},
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
        $('#' + fields[1]).change(function () {
            if (this.value.match(nm_reg)) {
                checkusr = 1;
            }
            else {
                checkusr = 0;
            }
        });
        $('#' + fields[2]).on('mouseup blur change', function () {
            if (this.value.match(email_reg)) {
                checkusr = 1;
            }
            else {
                checkusr = 0;
            }
        });
        $('#' + fields[3]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-30:+0',
            //onClose: function (dateText, inst) {
            //    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDate));
            //}
        });
        picEditObj1 = $('#' + fields[16]).picEdit({
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
                $('#' + fields[17]).prop('disabled', 'disabled');
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
                $('#' + fields[17]).removeAttr('disabled');
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
            if (checkusr && picedit && $('#' + fields[16]).prop('files').length > 0) {
                var frmdata = new FormData();
                frmdata.append("user_id", $('#' + fields[18]).val());
                frmdata.append("usertype", $('#' + fields[0]).val());
                frmdata.append("name", $('#' + fields[1]).val());
                frmdata.append("email", $('#' + fields[2]).val());
                frmdata.append("dob", $('#' + fields[3]).val());
                frmdata.append("gender", $('#' + fields[4]).val());
                frmdata.append("mobile1", $('#' + fields[5]).val());
                frmdata.append("mobile2", $('#' + fields[6]).val());
                frmdata.append("addline", $('#' + fields[7]).val());
                frmdata.append("country", $('#' + fields[8]).val());
                frmdata.append("state", $('#' + fields[9]).val());
                frmdata.append("distct", $('#' + fields[10]).val());
                frmdata.append("city", $('#' + fields[11]).val());
                frmdata.append("stloc", $('#' + fields[12]).val());
                frmdata.append("zipc", $('#' + fields[13]).val());
                frmdata.append("proof_id", $('#' + fields[14]).val());
                frmdata.append("proof_type", $('#' + fields[15]).val());
                frmdata.append("file", $('#' + fields[16]).prop('files')[0]);
                EditUserDB(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function EditUserDB(attr) {
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
