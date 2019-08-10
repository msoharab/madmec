function controlWebsit() {
    var members = {};
    var dash = {};
    var users = {};
    var post = {};
    var sections = {};
    var channels = {};

    this.__construct = function (para) {
        members = para;
        dash = para.dash;
        users = para.users;
        post = para.post;
        sections = para.sections;
        channels = para.channels;
    }
    this.__constructDash = function () {
        window.setTimeout(function () {
            getTraffic();
        }, 500);
        window.setTimeout(function () {
            getLogs();
        }, 900);
    }
    this.__constructUsers = function () {
        window.setTimeout(function () {
            listUser();
        }, 800);
    }
    this.__constructPosts = function () {
        window.setTimeout(function () {
            listPost();
        }, 800);
    }
    this.__constructSections = function () {
        $(sections.indexlist).click(function () {
            listSection1();
            $(sections.indexbut).click(function () {
                addSection1();
            }, 800);
        });
        $(sections.walllist).click(function () {
            listSection2();
            $(sections.wallbut).click(function () {
                addSection2();
            }, 800);
        });
        $(sections.chlist).click(function () {
            listSection3();
            $(sections.chbut).click(function () {
                addSection3();
            }, 800);
        });
        $(sections.indexlist).trigger('click');
    }
    this.__constructChannels = function () {
        window.setTimeout(function () {
            listChannel();
        }, 800);
    }
    function blockUser(id, stat) {
        $.ajax({
            type: 'POST',
            url: users.url2,
            data: {
                autoloader: true,
                action: 'controlWebsit/blockUser',
                id: Number(id),
                stat: Number(stat),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp === true)
                        {
                            alert('Updated!!');
                        }
                        else {
                            alert('Error occurred!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function listUser() {
        var header = '<table class="table table-striped table-bordered table-hover display" id="' + users.tab1 + '">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="6">Pic3Pic User Lists</th>' +
                '</tr>' +
                '<tr>' +
                '<th>No.</th>' +
                '<th>User Name</th>' +
                '<th>Email</th>' +
                '<th>Cell Number</th>' +
                '<th>Icon</th>' +
                '<th>Action</th>' +
                '</tr></thead>';
        var footer = '</table>';
        $(users.list).html(header + footer);
        window.setTimeout(function () {
            $('#' + users.tab1).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                ajax: {
                    url: users.url1,
                    type: 'POST',
                    data: function (d) {
                        d.autoloader = true;
                        d.action = "controlWebsit/listUser";
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            $(listusers.btnid).bind('click', {
                                uid: listusers.uid,
                                actionid: listusers.actionid,
                            }, function (evt) {
                                var uid = evt.data.uid;
                                var actionid = evt.data.actionid;
                                blockUser(uid, actionid);
                                listUser();
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
                                $('#' + users.tab1).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list users.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + users.tab1).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + users.tab1).css('width', '100%');
                },
                columns: [
                    {data: 'No' , searchable: true, orderable: true},
                    {data: 'User Name', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Cell Number', searchable: true, orderable: true},
                    {data: 'Icon', searchable: false, orderable: false},
                    {data: 'Action', searchable: false, orderable: false},
                ]
            });
            var dtable = $('#' + users.tab1).dataTable().api();
            $(".dataTables_filter input").unbind().bind("input", function (e) {
                if (this.value.length >= 3 || e.keyCode == 13) {
                    dtable.search(this.value).draw();
                }
                if (this.value == "") {
                    dtable.search("").draw();
                }
                return;
            });
        }, 1000);
    }
    function blockChannel(id, stat) {
        $.ajax({
            type: 'POST',
            url: channels.url2,
            data: {
                autoloader: true,
                action: 'controlWebsit/blockChannel',
                id: Number(id),
                stat: Number(stat),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp === true)
                        {
                            alert('Updated!!');
                        }
                        else {
                            alert('Error occurred!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function listChannel() {
        var header = '<table class="table table-striped table-bordered table-hover display" id="' + channels.tab1 + '">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="11">Pic3Pic Channels Lists</th>' +
                '</tr>' +
                '<tr>' +
                '<th>No.</th>' +
                '<th>Name</th>' +
                '<th>Description</th>' +
                '<th>Location</th>' +
                '<th>Icon</th>' +
                '<th>Created</th>' +
                '<th>Owner</th>' +
                '<th>Owner Email</th>' +
                '<th>Countries</th>' +
                '<th>Reports</th>' +
                '<th>Action</th>' +
                '</tr></thead>';
        var footer = '</table>';
        $(channels.list).html(header + footer);
        window.setTimeout(function () {
            $('#' + channels.tab1).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                ajax: {
                    url: channels.url1,
                    type: 'POST',
                    data: function (d) {
                        d.autoloader = true;
                        d.action = "controlWebsit/listChannel";
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            $(listusers.btnid).bind('click', {
                                cid: listusers.cid,
                                actionid: listusers.actionid,
                            }, function (evt) {
                                var cid = evt.data.cid;
                                var actionid = evt.data.actionid;
                                blockChannel(cid, actionid);
                                listChannel();
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
                                $('#' + channels.tab1).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list channels.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + channels.tab1).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + channels.tab1).css('width', '100%');
                },
                columns: [
                    {data: 'No' , searchable: true, orderable: true},
                    {data: 'Name', searchable: true, orderable: true},
                    {data: 'Description', searchable: true, orderable: false},
                    {data: 'Location', searchable: false, orderable: false},
                    {data: 'Icon', searchable: false, orderable: false},
                    {data: 'Created', searchable: true, orderable: true},
                    {data: 'Owner', searchable: true, orderable: true},
                    {data: 'Owner Email', searchable: true, orderable: true},
                    {data: 'Countries', searchable: true, orderable: false},
                    {data: 'Reports', searchable: true, orderable: false},
                    {data: 'Action', searchable: false, orderable: false},
                ]
            });
            var dtable = $('#' + channels.tab1).dataTable().api();
            $(".dataTables_filter input").unbind().bind("input", function (e) {
                if (this.value.length >= 3 || e.keyCode == 13) {
                    dtable.search(this.value).draw();
                }
                if (this.value == "") {
                    dtable.search("").draw();
                }
                return;
            });
        }, 1000);
    }
    function blockPost(id, stat) {
        $.ajax({
            type: 'POST',
            url: post.url2,
            data: {
                autoloader: true,
                action: 'controlWebsit/blockPost',
                id: Number(id),
                stat: Number(stat),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp === true)
                        {
                            alert('Updated!!');
                        }
                        else {
                            alert('Error occurred!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function listPost() {
        var header = '<table class="table table-striped table-bordered table-hover display" id="' + post.tab1 + '">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="9">Pic3Pic Posts Lists</th>' +
                '</tr>' +
                '<tr>' +
                '<th>No.</th>' +
                '<th>Title</th>' +
                '<th>Created</th>' +
                '<th>Owner</th>' +
                '<th>Owner Email</th>' +
                '<th>Icon</th>' +
                '<th>Countries</th>' +
                '<th>Reports</th>' +
                '<th>Action</th>' +
                '</tr></thead>';
        var footer = '</table>';
        $(post.list).html(header + footer);
        window.setTimeout(function () {
            $('#' + post.tab1).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                ajax: {
                    url: post.url1,
                    type: 'POST',
                    data: function (d) {
                        d.autoloader = true;
                        d.action = "controlWebsit/listPost";
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            $(listusers.btnid).bind('click', {
                                pid: listusers.pid,
                                actionid: listusers.actionid,
                            }, function (evt) {
                                var pid = evt.data.pid;
                                var actionid = evt.data.actionid;
                                blockPost(pid, actionid);
                                listPost();
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
                                $('#' + post.tab1).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list post.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + post.tab1).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + post.tab1).css('width', '100%');
                },
                columns: [
                    {data: 'No' , searchable: true, orderable: true},
                    {data: 'Title', searchable: true, orderable: true},
                    {data: 'Created', searchable: true, orderable: true},
                    {data: 'Owner', searchable: true, orderable: true},
                    {data: 'Owner Email', searchable: true, orderable: true},
                    {data: 'Icon', searchable: true, orderable: true},
                    {data: 'Countries', searchable: true, orderable: false},
                    {data: 'Reports', searchable: true, orderable: false},
                    {data: 'Action', searchable: false, orderable: false},
                ]
            });
            var dtable = $('#' + post.tab1).dataTable().api();
            $(".dataTables_filter input").unbind().bind("input", function (e) {
                if (this.value.length >= 3 || e.keyCode == 13) {
                    dtable.search(this.value).draw();
                }
                if (this.value == "") {
                    dtable.search("").draw();
                }
                return;
            });
        }, 1000);
    }
    function addSection1() {
        $.ajax({
            type: 'POST',
            url: sections.url4,
            data: {
                autoloader: true,
                action: 'controlWebsit/addSection1',
                name: $(sections.indexadd).val(),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp.status == "success")
                        {
                            alert('Added!!!');
                        }
                        else {
                            alert('Unable to Added data!!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function addSection2() {
        $.ajax({
            type: 'POST',
            url: sections.url5,
            data: {
                autoloader: true,
                action: 'controlWebsit/addSection2',
                name: $(sections.walladd).val(),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp.status == "success")
                        {
                            alert('Added!!!');
                        }
                        else {
                            alert('Unable to Added data!!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function addSection3() {
        $.ajax({
            type: 'POST',
            url: sections.url6,
            data: {
                autoloader: true,
                action: 'controlWebsit/addSection3',
                name: $(sections.chadd).val(),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp.status == "success")
                        {
                            alert('Added!!!');
                        }
                        else {
                            alert('Unable to Added data!!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function listSection1() {
        $.ajax({
            type: 'POST',
            url: sections.url1,
            data: {
                autoloader: true,
                action: 'controlWebsit/listSection1',
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        var details = '';
                        if (resp.status == "success")
                        {
                            for (i = 0; i < resp.data.length; i++)
                            {
                                details += '<div class="panel">' +
                                        '<div class="row">' +
                                        '<div class="col-lg-6 pull-left">' + resp.data[i]["cname"] + '</div>' +
                                        '<div class="col-lg-6">' +
                                        '<button class="btn ' + resp.data[i]["btn"] + ' pull-right" id="listSection1' + i + '" name="' + resp.data[i]["actionid"] + '">' + resp.data[i]["action"] + '</button>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                            }
                            $(sections.indexout).html(details);
                            window.setTimeout(function () {
                                for (i = 0; i < resp.data.length; i++)
                                {
                                    $('#listSection1' + i).click({
                                        dat: resp,
                                        index: i
                                    }, function (evt) {
                                        evt.preventDefault();
                                        var resp = evt.data.dat.data;
                                        var index = evt.data.index;
                                        console.log(resp);
                                        var continet = Number(resp[index]["id"]);
                                        var stat = Number(resp[index]["actionid"]);
                                        if (continet) {
                                            delSection1(continet, stat);
                                            listSection1();
                                        }
                                        else
                                            alert('Invalid Section ID');
                                    });
                                }
                            }, 900);
                        }
                        else {
                            alert('Unable to fetch data!!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function listSection2() {
        $.ajax({
            type: 'POST',
            url: sections.url2,
            data: {
                autoloader: true,
                action: 'controlWebsit/listSection2',
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        var details = '';
                        if (resp.status == "success")
                        {
                            for (i = 0; i < resp.data.length; i++)
                            {
                                details += '<div class="panel">' +
                                        '<div class="row">' +
                                        '<div class="col-lg-6 pull-left">' + resp.data[i]["cname"] + '</div>' +
                                        '<div class="col-lg-6">' +
                                        '<button class="btn ' + resp.data[i]["btn"] + ' pull-right" id="listSection2' + i + '" name="' + resp.data[i]["actionid"] + '">' + resp.data[i]["action"] + '</button>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                            }
                            $(sections.wallout).html(details);
                            window.setTimeout(function () {
                                for (i = 0; i < resp.data.length; i++)
                                {
                                    $('#listSection2' + i).click({
                                        dat: resp,
                                        index: i
                                    }, function (evt) {
                                        evt.preventDefault();
                                        var resp = evt.data.dat.data;
                                        var index = evt.data.index;
                                        var continet = Number(resp[index]["id"]);
                                        var stat = Number(resp[index]["actionid"]);
                                        if (continet) {
                                            delSection2(continet, stat);
                                            listSection2();
                                        }
                                        else
                                            alert('Invalid Section ID');
                                    });
                                }
                            }, 900);
                        }
                        else {
                            alert('Unable to fetch data!!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function listSection3() {
        $.ajax({
            type: 'POST',
            url: sections.url3,
            data: {
                autoloader: true,
                action: 'controlWebsit/listSection3',
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        var details = '';
                        if (resp.status == "success")
                        {
                            for (i = 0; i < resp.data.length; i++)
                            {
                                details += '<div class="panel">' +
                                        '<div class="row">' +
                                        '<div class="col-lg-6 pull-left">' + resp.data[i]["cname"] + '</div>' +
                                        '<div class="col-lg-6">' +
                                        '<button class="btn ' + resp.data[i]["btn"] + ' pull-right" id="listSection3' + i + '" name="' + resp.data[i]["actionid"] + '">' + resp.data[i]["action"] + '</button>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                            }
                            $(sections.chout).html(details);
                            window.setTimeout(function () {
                                for (i = 0; i < resp.data.length; i++)
                                {
                                    $('#listSection3' + i).click({
                                        dat: resp,
                                        index: i
                                    }, function (evt) {
                                        evt.preventDefault();
                                        var resp = evt.data.dat.data;
                                        var index = evt.data.index;
                                        var continet = Number(resp[index]["id"]);
                                        var stat = Number(resp[index]["actionid"]);
                                        if (continet) {
                                            delSection3(continet, stat);
                                            listSection3();
                                        }
                                        else
                                            alert('Invalid Section ID');
                                    });
                                }
                            }, 900);
                        }
                        else {
                            alert('Unable to fetch data!!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function delSection1(id, stat) {
        $.ajax({
            type: 'POST',
            url: sections.url7,
            data: {
                autoloader: true,
                action: 'controlWebsit/delSection1',
                id: Number(id),
                stat: Number(stat),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp === true)
                        {
                            alert('Updated!!');
                        }
                        else {
                            alert('Error occurred!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function delSection2(id, stat) {
        $.ajax({
            type: 'POST',
            url: sections.url8,
            data: {
                autoloader: true,
                action: 'controlWebsit/delSection2',
                id: Number(id),
                stat: Number(stat),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp === true)
                        {
                            alert('Updated!!');
                        }
                        else {
                            alert('Error occurred!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function delSection3(id, stat) {
        $.ajax({
            type: 'POST',
            url: sections.url9,
            data: {
                autoloader: true,
                action: 'controlWebsit/delSection3',
                id: Number(id),
                stat: Number(stat),
            },
            success: function (data, textStatus, xhr) {
                /*  console.log(data); */
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var resp = $.parseJSON(data);
                        if (resp === true)
                        {
                            alert('Updated!!');
                        }
                        else {
                            alert('Error occurred!!');
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function getTraffic() {
        var header = '<table class="table table-striped table-bordered table-hover display" id="' + dash.tab1 + '">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="8">Traffic to pic3pic</th>' +
                '</tr>' +
                '<tr>' +
                '<th>No.</th>' +
                '<th>ip</th>' +
                '<th>host</th>' +
                '<th>city</th>' +
                '<th>zipcode</th>' +
                '<th>province</th>' +
                '<th>country</th>' +
                '<th>hittime</th>' +
                '</tr></thead>';
        var footer = '</table>';
        $(dash.traffic).html(header + footer);
        window.setTimeout(function () {
            $('#' + dash.tab1).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                ajax: {
                    url: dash.url1,
                    type: 'POST',
                    dataType: 'JSON',
                    data: function (d) {
                        d.autoloader = true;
                        d.action = "controlWebsit/getTraffic";
                    },
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
                                $('#' + dash.tab1).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list website traffic.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + dash.tab1).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + dash.tab1).css('width', '100%');
                },
                columns: [
                    {data: 'No' , searchable: true, orderable: true},
                    {data: 'ip', searchable: true, orderable: true},
                    {data: 'host', searchable: true, orderable: true},
                    {data: 'city', searchable: true, orderable: true},
                    {data: 'zipcode', searchable: true, orderable: true},
                    {data: 'province', searchable: true, orderable: true},
                    {data: 'country', searchable: true, orderable: true},
                    {data: 'hittime', searchable: true, orderable: true},
                ]
            });
            var dtable = $('#' + dash.tab1).dataTable().api();
            $(".dataTables_filter input").addClass(dash.tab1);
            $(".dataTables_filter input").each(function () {
                if ($(this).hasClass('binded') === false) {
                    $(".dataTables_filter input").addClass('binded');
                    $(".dataTables_filter input").addClass(dash.tab1);
                    $("." + dash.tab1 + " input").unbind().bind("input", function (e) {
                        if (this.value.length >= 3 || e.keyCode == 13) {
                            dtable.search(this.value).draw();
                        }
                        if (this.value == "") {
                            dtable.search("").draw();
                        }
                        return;
                    });
                }
            });
        }, 1000);
    }
    function getLogs() {
        var header = '<table class="table table-striped table-bordered table-hover display" id="' + dash.tab2 + '">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="10">User Logs</th>' +
                '</tr>' +
                '<tr>' +
                '<th>No.</th>' +
                '<th>user_name</th>' +
                '<th>email</th>' +
                '<th>ip</th>' +
                '<th>host</th>' +
                '<th>city</th>' +
                '<th>zipcode</th>' +
                '<th>province</th>' +
                '<th>country</th>' +
                '<th>in_time</th>' +
                '</tr></thead>';
        var footer = '</table>';
        $(dash.logs).html(header + footer);
        window.setTimeout(function () {
            $('#' + dash.tab2).DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfliptr',
                ajax: {
                    url: dash.url2,
                    type: 'POST',
                    data: function (d) {
                        d.autoloader = true;
                        d.action = "controlWebsit/getLogs";
                    },
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
                                $('#' + dash.tab2).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list users logs.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + dash.tab2).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + dash.tab2).css('width', '100%');
                },
                columns: [
                    {data: 'No' , searchable: true, orderable: true},
                    {data: 'user_name', searchable: true, orderable: true},
                    {data: 'email', searchable: true, orderable: true},
                    {data: 'ip', searchable: true, orderable: true},
                    {data: 'host', searchable: true, orderable: true},
                    {data: 'city', searchable: true, orderable: true},
                    {data: 'zipcode', searchable: true, orderable: true},
                    {data: 'province', searchable: true, orderable: true},
                    {data: 'country', searchable: true, orderable: true},
                    {data: 'hittime', searchable: true, orderable: true},
                ]
            });
            var dtable = $('#' + dash.tab2).dataTable().api();
            $(".dataTables_filter input").each(function () {
                if ($(this).hasClass('binded') === false) {
                    $(".dataTables_filter input").addClass('binded');
                    $(".dataTables_filter input").addClass(dash.tab2);
                    $("." + dash.tab2 + " input").unbind().bind("input", function (e) {
                        if (this.value.length >= 3 || e.keyCode == 13) {
                            dtable.search(this.value).draw();
                        }
                        if (this.value == "") {
                            dtable.search("").draw();
                        }
                        return;
                    });
                }
            });
        }, 1000);
    }
}