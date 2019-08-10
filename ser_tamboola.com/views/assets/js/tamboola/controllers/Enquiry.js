function enquiryController() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddEnquiry = function () {
        var enquiry = members.AddEnquiry;
        var fields = members.AddEnquiry.fields;
        fetchMediumAds({
            mem: enquiry.about,
            fields: fields,
            index: Number(8)
        });
        fetchFacility({
            mem: enquiry.facility,
            fields: fields,
            index: Number(9)
        });
        $('#' + fields[5]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            yearRange: '-30:+0',
        });
        $('#' + fields[6]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            yearRange: '-30:+0',
        });
        $('#' + fields[7]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            yearRange: '-30:+0',
        });
        bindAddEnquiryEvents();
    };
    this.__ListEnq = function () {
        var enquiry = members.EnquiryList;
        var fields = enquiry.fields;
        ListEnquiry();
    };
    function bindAddEnquiryEvents() {
        var enquiry = members.AddEnquiry;
        var fields = enquiry.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + enquiry.form);
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
                frmdata.append("referrer", $('#' + fields[0]).val());
                frmdata.append("attender", $('#' + fields[1]).val());
                frmdata.append("visitor", $('#' + fields[2]).val());
                frmdata.append("email", $('#' + fields[3]).val());
                frmdata.append("mobile", $('#' + fields[4]).val());
                frmdata.append("followup1", $('#' + fields[5]).val());
                frmdata.append("followup2", $('#' + fields[6]).val());
                frmdata.append("followup3", $('#' + fields[7]).val());
                frmdata.append("about", $('#' + fields[8]).val());
                frmdata.append("joining", $('#' + fields[9]).val());
                frmdata.append("comments", $('#' + fields[10]).val());
                AddUserDB(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function AddUserDB(attr) {
        var enquiry = members.AddEnquiry;
        var form = $('#' + enquiry.form);
        LogMessages(attr);
        var obj = {};
        $.ajax({
            url: enquiry.url,
            type: enquiry.type,
            dataType: enquiry.dataType,
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
    function ListEnquiry() {
        var enquiry = members.EnquiryList;
        var fields = enquiry.fields;
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
                    url: enquiry.url,
                    dataType: enquiry.dataType,
                    type: enquiry.type,
//                    processData: gym.processData,
//                    contentType: gym.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = enquiry.url;
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
                    {data: 'Customer Name', searchable: true, orderable: true},
                    {data: 'Cell Number', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Referred', searchable: true, orderable: true},
                    {data: 'Trainer', searchable: true, orderable: true},
                    {data: 'Joining Probability', searchable: true, orderable: true},
                    {data: 'Comments', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true},
                    {data: 'Fitness Goals', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
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
    }
    ;
    function fetchMediumAds(attr) {
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
    function fetchFacility(attr) {
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
