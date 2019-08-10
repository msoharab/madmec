function manageController() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddFacility = function () {
        bindAddFacilityEvents();
        ListShowfacility();
        ListReactivefacility();
    };
    this.__AddOffer = function () {
        bindAddOfferEvents();
        Listoffer({
            one: members.ListOffers1,
            two: members.ListOffers1.fields,
            thr: members.ListOffers1.deactivate,
            fur: {btnclass: "btn-danger", btntext: "Deactivate",stat:4},
        });
        Listoffer({
            one: members.ListOffers2,
            two: members.ListOffers2.fields,
            thr: members.ListOffers2.activate,
            fur: {btnclass: "btn-success", btntext: "Activate",stat:6},
        });
    };
    this.__AddPackage = function () {
        bindAddPackageEvents();
        ListPackages({
            one: members.ListPackages.PersonalPack,
            two: members.ListPackages.PersonalPack.fields,
            thr: members.ListPackages.PersonalPack.deactivate,
            fur: {btnclass: "btn-danger", btntext: "Deactivate",stat:4},
        });
        ListPackages({
            one: members.ListPackages.NutritionPack,
            two: members.ListPackages.NutritionPack.fields,
            thr: members.ListPackages.NutritionPack.activate,
            fur: {btnclass: "btn-success", btntext: "Activate",stat:6},
        });
    };
    this.__EditFacilityEvents = function () {
        bindEditFacilityEvents();
    };
    this.__EditOfferEvents = function () {
        bindEditOfferEvents();
    };
    this.__EditPackageEvents = function () {
        bindEditPackageEvents();
    };
    function bindAddFacilityEvents() {
        var manage = members.Facilities.AddFacilities;
        var fields = manage.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + manage.form);
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
                frmdata.append("facility", $('#' + fields[0]).val());
                frmdata.append("status", $('#' + fields[1]).val());
                AddDB({jsonattr: manage, attr: frmdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindAddPackageEvents() {
        var manage = members.AddPackages;
        var fields = manage.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + manage.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
         fetchOfferData({
            mem: manage.package,
            fields: fields,
            index: Number(0)
        });
        fetchOfferData({
            mem: manage.minmem,
            fields: fields,
            index: Number(3)
        });
        fetchOfferData({
            mem: manage.facility,
            fields: fields,
            index: Number(1)
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
                formdata.append("packType", $('#' + fields[0]).val());
                formdata.append("facility", $('#' + fields[1]).val());
                formdata.append("name", $('#' + fields[2]).val());
                formdata.append("minmem", $('#' + fields[3]).val());
                formdata.append("numofSess", $('#' + fields[4]).val());
                formdata.append("price", $('#' + fields[5]).val());
                formdata.append("desp", $('#' + fields[7]).val());
                AddDB({jsonattr: manage, attr: formdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindAddOfferEvents() {
        var manage = members.AddOffers;
        var fields = manage.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + manage.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        fetchOfferData({
            mem: manage.duration,
            fields: fields,
            index: Number(1)
        });
        fetchOfferData({
            mem: manage.minmem,
            fields: fields,
            index: Number(2)
        });
        fetchOfferData({
            mem: manage.facility,
            fields: fields,
            index: Number(3)
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
                formdata.append("duration", $('#' + fields[1]).val());
                formdata.append("minmember", $('#' + fields[2]).val());
                formdata.append("facility", $('#' + fields[3]).val());
                formdata.append("price", $('#' + fields[4]).val());
                formdata.append("descrip", $('#' + fields[5]).val());
                AddDB({jsonattr: manage, attr: formdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindEditFacilityEvents() {
        var manage = members.EditFacilities;
        var fields = manage.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + manage.form);
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
//            if (rules.length > 0 && messages.length > 0) {
//                rules = $.parseJSON(rules);
//                messages = $.parseJSON(messages);
//                params['rules'][field] = rules;
//                params['messages'][field] = messages;
//            }
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
                frmdata.append("facility", $('#' + fields[0]).val());
                frmdata.append("status", $('#' + fields[1]).val());
                AddDB({jsonattr: manage, attr: frmdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindEditOfferEvents() {
        var manage = members.EditOffers;
        var fields = manage.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + manage.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        fetchOfferData({
            mem: manage.duration,
            fields: fields,
            index: Number(1)
        });
        fetchOfferData({
            mem: manage.minmem,
            fields: fields,
            index: Number(2)
        });
        fetchOfferData({
            mem: manage.facility,
            fields: fields,
            index: Number(3)
        });
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
//            if (rules.length > 0 && messages.length > 0) {
//                rules = $.parseJSON(rules);
//                messages = $.parseJSON(messages);
//                params['rules'][field] = rules;
//                params['messages'][field] = messages;
//            }
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
                formdata.append("offid", $('#' + fields[7]).val());
                formdata.append("name", $('#' + fields[0]).val());
                formdata.append("duration", $('#' + fields[1]).val());
                formdata.append("minmember", $('#' + fields[2]).val());
                formdata.append("facility", $('#' + fields[3]).val());
                formdata.append("price", $('#' + fields[4]).val());
                formdata.append("descrip", $('#' + fields[5]).val());
                AddDB({jsonattr: manage, attr: formdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindEditPackageEvents() {
         var manage = members.EditPackages;
        var fields = manage.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + manage.form);
        var checkusr = 0;
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
         fetchOfferData({
            mem: manage.package,
            fields: fields,
            index: Number(0)
        });
        fetchOfferData({
            mem: manage.minmem,
            fields: fields,
            index: Number(3)
        });
        fetchOfferData({
            mem: manage.facility,
            fields: fields,
            index: Number(1)
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
                formdata.append("packid", $('#' + fields[8]).val());
                formdata.append("packType", $('#' + fields[0]).val());
                formdata.append("facility", $('#' + fields[1]).val());
                formdata.append("name", $('#' + fields[2]).val());
                formdata.append("minmem", $('#' + fields[3]).val());
                formdata.append("numofSess", $('#' + fields[4]).val());
                formdata.append("price", $('#' + fields[5]).val());
                formdata.append("desp", $('#' + fields[6]).val());
                AddDB({jsonattr: manage, attr: formdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function AddDB(jdata) {
        var register = jdata.jsonattr;
        var attr = jdata.attr;
        var form = $('#' + register.form);
        var obj = {};
        $.ajax({
            url: register.url,
            type: register.type,
            dataType: register.dataType,
            processData: false,
            contentType: false,
            data: attr,
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    alert('Successfully Done!!!');
                    $(form).get(0).reset();
                }
                else if (obj.status === "alreadyexist") {
                    alert('You have already Added.... Please enter unique values!!! ');
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
    /*Fetch Methods*/
    function fetchOfferData(attr) {
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
    /*List Methods*/
    function ListShowfacility() {
        var gym = members.Facilities.ShowFacilities;
        var fields = gym.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
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
                    url: gym.url,
                    dataType: gym.dataType,
                    type: gym.type,
//                    processData: gym.processData,
//                    contentType: gym.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = gym.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        //LogMessages(listusers);
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
                            var id = $(this).attr("data-defacility");
                            chageFOPStatus({jsonattr: gym.deactivate, attr: {fopid: id, stat: 6}});
                            datatable.ajax.reload(null, false);
                        });
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Facility', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Deactive', searchable: false, orderable: false}
                ],
                columnDefs: [
                    {targets: 2, visible: false},
                ],
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont0";
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
        $('#' + gym.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function ListReactivefacility() {
        var gym = members.Facilities.ReactFacilities;
        var fields = gym.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
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
                    url: gym.url,
                    dataType: gym.dataType,
                    type: gym.type,
//                    processData: gym.processData,
//                    contentType: gym.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = gym.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        //LogMessages(listusers);
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
                    $(".activate").each(function () {
                        $(this).click(function (evt) {
                            evt.preventDefault();
                            var id = $(this).attr("data-acfacility");
                            chageFOPStatus({jsonattr: gym.activate, attr: {fopid: id, stat: 4}});
                            datatable.ajax.reload(null, false);
                        });
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Facility', searchable: true, orderable: true},
                    {data: 'Reactive', searchable: false, orderable: false}
                ],
            });
//            $(".dataTables_filter input").attr("placeholder", "Enter search terms here");
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont0";
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
        $('#' + gym.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
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
    function Listoffer(attr) {
        var gym = attr.one;
        var fields = attr.two;
        var action = attr.thr;
        var ajaxdata = attr.fur;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
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
                ajax: {
                    url: gym.url,
                    dataType: gym.dataType,
                    type: gym.type,
                    processData: gym.processData,
                    contentType: gym.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = ajaxdata;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        //LogMessages(listusers);
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
                    var api = this.api();
                    var rows = api.rows().nodes();
                    var last = null;
                    window.setTimeout(function () {
                        var jdata = api.rows({page: 'current'}).data();
                        if (jdata) {
                            for (i = 0; i < jdata.length; i++) {
                                $('#' + jdata[i].actionbtn).on('click',{jdata:jdata[i],action:action,stat:ajaxdata.stat},function (evt) {
                                    var edata = evt.data;
                                    evt.preventDefault();
                                    var id = edata.jdata.ide;
                                    var action = edata.action;
                                    var stat = Number(edata.stat);
                                    if(stat == 6){
                                        stat -=2;
                                    }else{
                                        stat+=2;
                                    }
                                    chageFOPStatus({jsonattr: action, attr: {fopid: id, stat: stat}});
                                    datatable.ajax.reload(null, false);
                                });
                            }
                        }
                    },500);
                    api.column(3, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="9" align="center"><strong>' + group + '</strong></td></tr>'
                                    );
                            last = group;
                        }
                    });
                    /*
                    //LogMessages(api.rows({page: 'current'}).data());
                    //api.column(3, {page: 'current'}).data().each(function (group, i) {
                    api.column(3).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="9" align="center"><strong>' + group + '</strong></td></tr>'
                                    );
                            last = group;
                        }
                    });
                     $(".deloffer").each(function () {
                     $(this).click(function (evt) {
                     evt.preventDefault();
                     var id = $(this).attr("data-deloffer");
                     chageFOPStatus({jsonattr: action, attr: {fopid: id, stat: 6}});
                     datatable.ajax.reload(null, false);
                     });
                     });
                     */
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Offer Name', searchable: true, orderable: true},
                    {data: 'Duration', searchable: true, orderable: true},
                    {data: 'Facility', searchable: false, orderable: false},
                    {data: 'Cost', searchable: true, orderable: true},
                    {data: 'Min Members', searchable: true, orderable: true},
                    {data: 'Description', searchable: false, orderable: false},
                    {data: 'View', searchable: false, orderable: false},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Status', searchable: false, orderable: false}
                ],
                columnDefs: [
                    {targets: 3, visible: false},
                    {targets: 6, visible: false},
                    {targets: 7, visible: false},
                ],
                order: [[3, 'asc']],
                displayLength: 10,
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont0";
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
        $('#' + gym.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function ListPackages(attr) {
        var gym = attr.one;
        var fields = attr.two;
        var action = attr.thr;
        var ajaxdata = attr.fur;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
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
                    url: gym.url,
                    dataType: gym.dataType,
                    type: gym.type,
//                    processData: gym.processData,
//                    contentType: gym.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = ajaxdata;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        //LogMessages(listusers);
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
                    var api = this.api();
                    var rows = api.rows().nodes();
                    var last = null;
                    window.setTimeout(function () {
                        var jdata = api.rows({page: 'current'}).data();
                        if (jdata) {
                            for (i = 0; i < jdata.length; i++) {
                                $('#' + jdata[i].actionbtn).on('click',{jdata:jdata[i],action:action,stat:ajaxdata.stat},function (evt) {
                                    var edata = evt.data;
                                    evt.preventDefault();
                                    var id = edata.jdata.ide;
                                    var action = edata.action;
                                    var stat = Number(edata.stat);
                                    if(stat == 6){
                                        stat -=2;
                                    }else{
                                        stat+=2;
                                    }
                                    chageFOPStatus({jsonattr: action, attr: {fopid: id, stat: stat}});
                                    datatable.ajax.reload(null, false);
                                });
                            }
                        }
                    },500);
                    api.column(2, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="8" align="center"><strong>' + group + '</strong></td></tr>'
                                    );
                            last = group;
                        }
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Package name', searchable: true, orderable: true},
                    {data: 'Package type', searchable: false, orderable: false},
                    {data: 'Facility', searchable: true, orderable: true},
                    {data: 'Min Members', searchable: true, orderable: true},
                    {data: 'Number of Sessions', searchable: true, orderable: true},
                    {data: 'Cost', searchable: true, orderable: true},
                    {data: 'Description', searchable: false, orderable: false},
                    {data: 'View', searchable: false, orderable: false},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Status', searchable: false, orderable: false}
                ],
                columnDefs: [
                    {targets: 2, visible: false},
                    {targets: 7, visible: false},
                    {targets: 8, visible: false},
                ],
                order: [[2, 'asc']],
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont0";
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
        $('#' + gym.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
}
