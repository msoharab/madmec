function stockController() {
    var members = {};

    this.__constructor = function (para) {
        members = para;

    };
    this.__AddProduct = function () {
        bindAddProductsEvents();
        ListProducts();
    };
    this.__ProductEdit = function () {
        bindEditProductEvents();
    };

    function bindAddProductsEvents() {
        var mem = members.AddProduct;
        var fields = members.AddProduct.fields;
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
        $('#' + fields[1]).bind('click, keyup', function () {
            var ct = Number($.trim($(this).val()));
            if (typeof ct == 'number') {
                if (ct < 0) {
                    ct = 0;
                }
            }
            $(this).val(ct);
        });
        $(form).validate(params);
        $(form).submit(function (e) {
            if (checkusr) {
                var frmdata = new FormData();
                frmdata.append("name", $('#' + fields[0]).val());
                frmdata.append("cost", $('#' + fields[1]).val());
                frmdata.append("weight", $('#' + fields[2]).val());
                AddDB({jsonattr: mem, attr: frmdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function AddDB(jdata) {
        var mem = jdata.jsonattr;
        var attr = jdata.attr;
        var form = $('#' + mem.form);
        LogMessages(attr);
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            processData: mem.processData,
            contentType: mem.contentType,
			async:false,
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
                    alert('Successfully Done');
                    $(form).get(0).reset();
                }
                else if (obj.status === "alreadyexist") {
                    alert('Not Added, Enter diferent entries');
                    $(form).get(0).reset();
                }
                else if (obj.status === "error") {
                    alert('Wrong Entries');
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
        var prod = members.ListProducts;
        var fields = prod.fields;
        var datatable = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                //pageLength: 10,
				scrollY:480,
				scrollX:false,
				deferRender:true,
				scroller:true,
				//responsive:true,
				//stateSave: true,
				dom: 'Bf<"top"ip>rt<"clear">',
				lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10 item', '25 item', '50 item', 'Show all' ],
				],
				buttons: [
					{
						extend: 'print',
						exportOptions: {
							columns: ':visible'
						},
						key: {
							key: 'p',
							altKey: true
						},
						//autoPrint: false,
						customize: function ( win ) {
							$(win.document.body)
								.css( 'font-size', '10pt' )
								.prepend(
									'<center><h4>Stock</h4></center>'
								);
								
							$(win.document.body).find( 'table' )
								.addClass( 'compact' )
								.css( 'font-size', 'inherit' );
								
						},
					},
					{
						extend: 'colvis',
						text: 'Columns',
						postfixButtons: [ 'colvisRestore' ],
					},
					{
						extend: 'pageLength',
						text: 'Rows',
					},
					{
						text: 'Reload',
						action: function ( e, dt, node, config ) {
							datatable.ajax.reload();
						}
					},
				],
				/*
					{
						extend: 'collection',
						text: 'Export Table',
						autoClose: true,
						buttons: [
							{
								extend: 'print',
								exportOptions: {
									columns: ':visible'
								},
								key: {
									key: 'p',
									altKey: true
								},
							},
							{
								extend: 'pdfFlash',
								exportOptions: {
									columns: ':visible'
								},
							},
							{
								extend: 'csvFlash',
								exportOptions: {
									columns: ':visible'
								},
							},
							{
								extend: 'excelFlash',
								exportOptions: {
									columns: ':visible'
								},
							},
							{
								extend: 'copyFlash',
								exportOptions: {
									columns: ':visible'
								},
							},
						],
					},
				*/
                ajax: {
                    url: prod.url,
                    dataType: prod.dataType,
                    type: prod.type,
                    //processData: users.processData,
                    //contentType: users.contentType,
                    data: function (d) {
                        d.autoloader = true;
                        d.action = prod.url;
                    },
                },
                createdRow: function (row, data, dataIndex) {
                    if (data) {
                        var listusers = data;
                        window.setTimeout(function () {
                            if($(listusers.btnid).hasClass('binded') == false){
                                $(listusers.btnid).bind('click', {
                                    datatable: datatable,
                                    fields: prod,
                                },function (evt) {
									$(listusers.btnid).addClass('binded');
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
											if (typeof data === 'object') {
												obj = data;
											}
											else {
												obj = $.parseJSON($.trim(data));
											}
											if (obj.status === "success") {
												alert('Successfully Done');
											}
											else if (obj.status === "alreadyexist") {
												alert('Not Deleted, Enter diferent entries');
											}
											else if (obj.status === "error") {
												alert('Not Deleted');
											}
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
                        alert('Unable to list Products.');
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
                            chageFOPStatus({jsonattr: prod.deactivate, attr: {fopid: id, stat: 6}});
                            datatable.ajax.reload(null, false);
                        });
                    });
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Name', searchable: true, orderable: true},
                    {data: 'Cost', searchable: true, orderable: true},
                    {data: 'Weight', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
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
        $('#' + prod.btnDiv).click(function () {
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function bindEditProductEvents() {
        var register = members.EditProduct;
        var fields = register.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        $('#' + fields[1]).bind('click, keyup', function () {
            var ct = Number($.trim($(this).val()));
            if (typeof ct == 'number') {
                if (ct > 999) {
                    ct = 0;
                }
                else if (ct < 0) {
                    ct = 0;
                }
            }
            $(this).val(ct);
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
            formdata.append("id", $('#' + fields[4]).val());
            formdata.append("name", $('#' + fields[0]).val());
            formdata.append("cost", $('#' + fields[1]).val());
            formdata.append("weight", $('#' + fields[2]).val());
            LogMessages(formdata);
            AddDB({jsonattr: register, attr: formdata});
			window.location.href = EGPCSURL + 'Stock';
        }
        ;

        params['invalidHandler'] = function () {
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
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
