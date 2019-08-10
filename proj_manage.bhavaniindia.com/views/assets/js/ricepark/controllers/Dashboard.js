function dashboardController() {
    var members = {};
    var __defaultImage = null;
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddProduct = function () {
        bindAddProductEvents();
    };
    this.__ListProduct = function () {
        ListProducts();
    };
    this.__AddMembers = function () {
        bindAddMembersEvents();
    };
    this.__ListMembers = function () {
        ListMembers();
    };
    this.__EditProduct = function () {
        bindEditProductEvents();
    };
    this.__EditMembers = function () {
        bindEditMembersEvents();
    };
    this.__ListEnquiry = function () {
        ListEnquiry();
    };
    this.__setDefualtImage = function (img) {
        __defaultImage = img;
    };
    function bindAddProductEvents() {
        var register = members.AddProduct;
        var fields = register.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picEditObj1 = {};
        window.setTimeout(function () {
            picEditObj1 = $('#' + fields[6]).picEdit({
                imageUpdated: function (_this) {
                },
                formError: function (res) {
                },
                formProgress: null,
                formSubmitted: null,
                FormObj: $('#' + register.form),
                goFlag: true,
                picEditUpload: false,
                redirectUrl: false,
            });
        }, 600);
        window.setTimeout(function () {
            $('#' + fields[6]).parent().css({
                marginLeft: '0%',
                marginRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 700);
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
            var formObj = $(form)[0];
            var formdata = new FormData(formObj);
            formdata.append("name", $('#' + fields[0]).val());
            formdata.append("brand", $('#' + fields[1]).val());
            formdata.append("category", $('#' + fields[2]).val());
            formdata.append("price", $('#' + fields[3]).val());
            formdata.append("quantity", $('#' + fields[4]).val());
            formdata.append("description", $('#' + fields[5]).val());
            formdata.append("photo", $('#' + fields[6])[0].files[0]);
            LogMessages(formdata);
            AddUserDB({jsonattr: register, attr: formdata});
        }
        ;
        params['invalidHandler'] = function () {
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
//        $(form).submit(function (e) {
//            e.preventDefault();
//            if (checkusr) {
//            }
//            else {
//                alert('Please correct the credentials..');
//            }
//        });
    }
    ;
    function bindAddMembersEvents() {
        var register = members.AddMembers;
        var fields = register.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picEditObj1 = {};
        window.setTimeout(function () {
            picEditObj1 = $('#' + fields[9]).picEdit({
                imageUpdated: function (_this) {
                },
                formError: function (res) {
                },
                formProgress: null,
                formSubmitted: null,
                FormObj: $('#' + register.form),
                goFlag: true,
                picEditUpload: false,
                redirectUrl: false,
            });
        }, 600);
        window.setTimeout(function () {
            $('#' + fields[9]).parent().css({
                marginLeft: '0%',
                marginRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 700);
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
            var formObj = $(form)[0];
            var formdata = new FormData(formObj);
            formdata.append("name", $('#' + fields[0]).val());
            formdata.append("designation", $('#' + fields[1]).val());
            formdata.append("email", $('#' + fields[2]).val());
            formdata.append("mobile1", $('#' + fields[3]).val());
            formdata.append("mobile2", $('#' + fields[4]).val());
            formdata.append("facebook", $('#' + fields[5]).val());
            formdata.append("twitter", $('#' + fields[6]).val());
            formdata.append("googlep", $('#' + fields[7]).val());
            formdata.append("address", $('#' + fields[8]).val());
            formdata.append("photo", $('#' + fields[9])[0].files[0]);
            LogMessages(formdata);
            AddUserDB({jsonattr: register, attr: formdata});
        }
        ;
        params['invalidHandler'] = function () {
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
//        $(form).submit(function (e) {
//            e.preventDefault();
//            if (checkusr) {
//            }
//            else {
//                alert('Please correct the credentials..');
//            }
//        });
    }
    ;
    function AddUserDB(jdata) {
        var register = jdata.jsonattr;
        var attr = jdata.attr;
        var form = $('#' + register.form);
        var obj = {};
        $.ajax({
            url: register.url,
            type: register.type,
            dataType: register.dataType,
            processData: register.processData,
            contentType: register.contentType,
            async: false,
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
                    alert('Successfully Done !!!');
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
    function ListProducts() {
        var prods = members.ListProducts;
        var fields = prods.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                //dom: 'Bfliptr',
                dom: 'Bfrtip',
                //dom: 'CBlfrtip',
                //dom: 'C&gt;"clear"&lt;lfrtip',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    //'colvis',
                ],
                columnDefs: [{
                        targets: 0,
                        visible: true,
                    }
                ],
                ajax: {
                    url: prods.url,
                    dataType: prods.dataType,
                    type: prods.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = prods.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            if($(listusers.btnid).hasClass('binded') == false){
                                $(listusers.btnid).bind('click', {
                                    datatable: datatable,
                                    fields: prods,
                                },function (evt) {
                                    evt.preventDefault();
                                    var fields = evt.data.fields.deactivate;
                                    var datatable = evt.data.datatable;
                                    var id = listusers.id;
                                    $.ajax({
                                        url: fields.url,
                                        type: fields.type,
                                        dataType: fields.dataType,
                                        //processData: fields.processData,
                                        //contentType: fields.contentType,
                                        async: false,
                                        data: {id:id},
                                        success: function (data, textStatus, xhr) {
                                            datatable.ajax.reload();
                                        },
                                        error: function () {
                                        },
                                        complete: function (xhr, textStatus) {
                                        }
                                    });
                                });
                            }
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
                    $(".deactivate").each(function () {
                        $(this).click(function (evt) {
                            evt.preventDefault();
                            var id = $(this).attr("data-delProduct");
                            chageFOPStatus({jsonattr: prods.deactivate, attr: {fopid: id, stat: 6}});
                            datatable.ajax.reload(null, false);
                        });
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Product Name', searchable: true, orderable: true},
                    {data: 'Brand', searchable: true, orderable: true},
                    {data: 'Category', searchable: true, orderable: true},
                    {data: 'Quantity', searchable: true, orderable: true},
                    {data: 'Price', searchable: true, orderable: true},
                    {data: 'Image', searchable: false, orderable: false},
                    {data: 'Description', searchable: true, orderable: true},
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
        $('#' + prods.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function ListMembers() {
        var prods = members.ListMembers;
        var fields = prods.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                //dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    //'colvis'
                ],
                columnDefs: [{
                        targets: 0,
                        visible: true
                    }
                ],
                ajax: {
                    url: prods.url,
                    dataType: prods.dataType,
                    type: prods.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = prods.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            if($(listusers.btnid).hasClass('binded') == false){
                                $(listusers.btnid).bind('click', {
                                    datatable: datatable,
                                    fields: prods,
                                },function (evt) {
                                    evt.preventDefault();
                                    var fields = evt.data.fields.deactivate;
                                    var datatable = evt.data.datatable;
                                    var id = listusers.id;
                                    LogMessages(id);
                                    $.ajax({
                                        url: fields.url,
                                        type: fields.type,
                                        dataType: fields.dataType,
                                        //processData: fields.processData,
                                        //contentType: fields.contentType,
                                        //async: false,
                                        data: {id:id},
                                        success: function (data, textStatus, xhr) {
                                            datatable.ajax.reload();
                                        },
                                        error: function () {
                                        },
                                        complete: function (xhr, textStatus) {
                                        }
                                    });
                                });
                            }
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
                    $(".deactivate").each(function () {
                        $(this).click(function (evt) {
                            evt.preventDefault();
                            var id = $(this).attr("data-delMember");
                            chageFOPStatus({jsonattr: prods.deactivate, attr: {fopid: id, stat: 6}});
                            datatable.ajax.reload(null, false);
                        });
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Member Name', searchable: true, orderable: true},
                    {data: 'Designation', searchable: true, orderable: true},
                    {data: 'Mobile', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Address', searchable: true, orderable: true},
                    {data: 'Facebook', searchable: false, orderable: false},
                    {data: 'Image', searchable: false, orderable: false},
                    {data: 'Date', searchable: true, orderable: true},
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
        $('#' + prods.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function ListEnquiry() {
        var prods = members.ListEnquiry;
        var fields = prods.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                //dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    //'colvis'
                ],
                columnDefs: [{
                        targets: 0,
                        visible: true
                    }
                ],
                ajax: {
                    url: prods.url,
                    dataType: prods.dataType,
                    type: prods.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = prods.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            if($(listusers.btnid).hasClass('binded') == false){
                                $(listusers.btnid).bind('click', {
                                    datatable: datatable,
                                    fields: prods,
                                },function (evt) {
                                    evt.preventDefault();
                                    $(listusers.btnid).addClass('binded');
                                    var fields = evt.data.fields.deactivate;
                                    var datatable = evt.data.datatable;
                                    var id = listusers.id;
                                    $.ajax({
                                        url: fields.url,
                                        type: fields.type,
                                        dataType: fields.dataType,
                                        //processData: fields.processData,
                                        //contentType: fields.contentType,
                                        async: false,
                                        data: {id:id},
                                        success: function (data, textStatus, xhr) {
                                            datatable.ajax.reload();
                                        },
                                        error: function () {
                                        },
                                        complete: function (xhr, textStatus) {
                                        }
                                    });
                                });
                            }
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
                    $(".deactivate").each(function () {
                        $(this).click(function (evt) {
                            evt.preventDefault();
                            var id = $(this).attr("data-delEnquiry");
                            chageFOPStatus({jsonattr: prods.deactivate, attr: {fopid: id, stat: 6}});
                            datatable.ajax.reload(null, false);
                        });
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Name', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Mobile', searchable: true, orderable: true},
                    {data: 'Subject', searchable: true, orderable: true},
                    {data: 'Message', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true},
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
        $('#' + prods.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function bindEditProductEvents() {
        var register = members.EditProduct;
        var fields = register.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picEditObj1 = {};
        window.setTimeout(function () {
            picEditObj1 = $('#' + fields[6]).picEdit({
                imageUpdated: function (_this) {
                    LogMessages(_this);
                },
                formError: function (res) {
                },
                formProgress: null,
                formSubmitted: null,
                FormObj: $('#' + register.form),
                goFlag: true,
                picEditUpload: false,
                redirectUrl: false,
            });
        }, 600);
        window.setTimeout(function () {
            $('#' + fields[6]).parent().css({
                marginLeft: '0%',
                marginRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 700);
        window.setTimeout(function () {
            picEditObj1._setDefaultImage(__defaultImage);
        }, 900);
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
            var formObj = $(form)[0];
            var formdata = new FormData(formObj);
            formdata.append("id", $('#' + fields[8]).val());
            formdata.append("photo_id", $('#' + fields[9]).val());
            formdata.append("name", $('#' + fields[0]).val());
            formdata.append("brand", $('#' + fields[1]).val());
            formdata.append("category", $('#' + fields[2]).val());
            formdata.append("price", $('#' + fields[3]).val());
            formdata.append("quantity", $('#' + fields[4]).val());
            formdata.append("description", $('#' + fields[5]).val());
            formdata.append("photo", $('#' + fields[6])[0].files[0]);
            LogMessages(formdata);
            AddUserDB({jsonattr: register, attr: formdata});
            window.location.href = URL + 'Dashboard/ListProduct';
        }
        ;
        params['invalidHandler'] = function () {
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
//        $(form).submit(function (e) {
//            e.preventDefault();
//            if (checkusr) {
//            }
//            else {
//                alert('Please correct the credentials..');
//            }
//        });
    }
    ;
    function bindEditMembersEvents() {
        var register = members.EditMembers;
        var fields = register.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picEditObj1 = {};
        window.setTimeout(function () {
            picEditObj1 = $('#' + fields[9]).picEdit({
                imageUpdated: function (_this) {
                    LogMessages(_this);
                },
                formError: function (res) {
                },
                formProgress: null,
                formSubmitted: null,
                FormObj: $('#' + register.form),
                goFlag: true,
                picEditUpload: false,
                redirectUrl: false,
            });
        }, 600);
        window.setTimeout(function () {
            $('#' + fields[9]).parent().css({
                marginLeft: '0%',
                marginRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 700);
        window.setTimeout(function () {
            picEditObj1._setDefaultImage(__defaultImage);
        }, 900);
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
            var formObj = $(form)[0];
            var formdata = new FormData(formObj);
            formdata.append("id", $('#' + fields[11]).val());
            formdata.append("photo_id", $('#' + fields[12]).val());
            formdata.append("name", $('#' + fields[0]).val());
            formdata.append("designation", $('#' + fields[1]).val());
            formdata.append("email", $('#' + fields[2]).val());
            formdata.append("mobile1", $('#' + fields[3]).val());
            formdata.append("mobile2", $('#' + fields[4]).val());
            formdata.append("facebook", $('#' + fields[5]).val());
            formdata.append("twitter", $('#' + fields[6]).val());
            formdata.append("googlep", $('#' + fields[7]).val());
            formdata.append("address", $('#' + fields[8]).val());
            formdata.append("photo", $('#' + fields[9])[0].files[0]);
            LogMessages(formdata);
            AddUserDB({jsonattr: register, attr: formdata});
            window.location.href = URL + 'Dashboard/ListMembers';
        }
        ;
        params['invalidHandler'] = function () {
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
//        $(form).submit(function (e) {
//            e.preventDefault();
//            if (checkusr) {
//            }
//            else {
//                alert('Please correct the credentials..');
//            }
//        });
    }
    ;
    function chageFOPStatus(jdata) {
        LogMessages(jdata);
        var register = jdata.jsonattr;
        var attr = jdata.attr;
        var obj = {};
        $.ajax({
            url: register.url,
            type: register.type,
            dataType: register.dataType,
            //processData: false,
            //contentType: false,
            async: false,
            data: attr,
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    LogMessages('Successfully Done!!!');
                }
                else if (obj.status === "alreadyexist") {
                    LogMessages('You have already Added.... Please enter unique values!!! ');
                }
                else {
                    LogMessages('Error occured !!!');
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
