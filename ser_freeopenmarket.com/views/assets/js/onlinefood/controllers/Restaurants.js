function RestaurantsController() {
    var members = {};
    var picEditObj1 = {};
    var picEditObj2 = {};
    var picEditObj3 = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddGym = function () {
        bindAddGymEvents({source: members.AddGym, fields: members.AddGym.fields,action:'add'});
        bindAssignGymEvents({source: members.AssignGym, fields: members.AssignGym.fields});
        ListGyms({source: members.ListGym, fields: members.ListGym.fields, index: 0});
        $('#' + members.AssignGym.btnDiv).click(function () {
            gymSearch({source: members.AssignGym.searchGym, fields: members.AssignGym.fields, index: 1});
            userSearch({source: members.AssignGym.searchUser, fields: members.AssignGym.fields, index: 0});
        });
    };
    this.__EditGym = function () {
        bindAddGymEvents({source: members.EditGym, fields: members.EditGym.fields,action:'edit'});
    };
    this.__gymSearch = function (attr) {
        gymSearch({source: attr.source, fields: attr.source.fields, index: attr.index});
    };
    function bindAddGymEvents(attr) {
        var register = attr.source;
        var fields = attr.fields;
        //var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);

        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        /*Logo*/
        window.setTimeout(function () {
            picEditObj1 = $('#' + register.logoImg).picEdit({
                imageUpdated: function (_this) {
                },
                formError: function (res) {
                    register.picedit = false;
                },
                /* Soharab Modification */
                formProgress: function (data) {
                    var res = {};
                    if (typeof data === 'object') {
                        res = data;
                    } else {
                        res = $.parseJSON($.trim(data));
                    }
                    //console.log(res);
                },
                formSubmitted: false,
                FormObj: $('#' + register.form),
                goFlag: false,
                picEditUpload: false,
                redirectUrl: false,
                defaultImage: register.defaultImage
            });
            $('#' + register.logoImg).parent().css({
                paddingLeft: '0%',
                paddingRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 500);
        window.setTimeout(function () {
            picEditObj1._setDefaultValues();
        }, 1000);
        /*Header*/
        window.setTimeout(function () {
            picEditObj2 = $('#' + register.headerImg).picEdit({
                imageUpdated: function (_this) {
                },
                formError: function (res) {
                    register.picedit = false;
                },
                /* Soharab Modification */
                formProgress: function (data) {
                    var res = {};
                    if (typeof data === 'object') {
                        res = data;
                    } else {
                        res = $.parseJSON($.trim(data));
                    }
                    //console.log(res);
                },
                formSubmitted: false,
                FormObj: $('#' + register.form),
                goFlag: false,
                picEditUpload: false,
                redirectUrl: false,
                defaultImage: register.defaultImage
            });
            $('#' + register.headerImg).parent().css({
                paddingLeft: '0%',
                paddingRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 500);
        window.setTimeout(function () {
            picEditObj2._setDefaultValues();
        }, 1000);
        /*Internal / External View*/
        window.setTimeout(function () {
            picEditObj3 = $('#' + register.inView).picEdit({
                imageUpdated: function (_this) {
                },
                formError: function (res) {
                    register.picedit = false;
                },
                /* Soharab Modification */
                formProgress: function (data) {
                    var res = {};
                    if (typeof data === 'object') {
                        res = data;
                    } else {
                        res = $.parseJSON($.trim(data));
                    }
                    //console.log(res);
                },
                formSubmitted: false,
                FormObj: $('#' + register.form),
                goFlag: false,
                picEditUpload: false,
                redirectUrl: false,
                defaultImage: register.defaultImage
            });
            $('#' + register.inView).parent().css({
                paddingLeft: '0%',
                paddingRight: '0%',
                backgroundColor: '#C0C0C0',
            });
        }, 500);
        window.setTimeout(function () {
            picEditObj3._setDefaultValues();
        }, 1000);
        //$(form).on('submit', function (evt) {
        //});
        var reqClone = new Array();
        $('#' + register.cloneplusbut[0]).click(function () {
            var $div = $('div[id^="' + register.clone[0] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            var $klon = $div.clone().prop('id', register.clone[0] + num).insertAfter('div[id^="' + register.clone[0] + '"]:last');
            window.setTimeout(function () {
                for (i = 0; i < register.reqparam.length; i++) {
                    $div.find('input.' + register.reqparam[i]).prop('id', register.reqparam[i] + num);
                    $div.find('input.' + register.reqparam[i]).prop('name', register.reqparam[i] + num);
                }
            }, 500);
            reqClone.push($klon);
            // $(form).validate(params);
        });
        $('#' + register.cloneminusbut[0]).click(function () {
            var $div = $('div[id^="' + register.clone[0] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10);
            if (num != 0) {
                $div.remove();
                reqClone.pop();
            }
        });
        var respClone = new Array();
        $('#' + register.cloneplusbut[1]).click(function () {
            var $div = $('div[id^="' + register.clone[1] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            var $klon = $div.clone().prop('id', register.clone[1] + num).insertAfter('div[id^="' + register.clone[1] + '"]:last');
            window.setTimeout(function () {
                for (i = 0; i < register.resparam.length; i++) {
                    $div.find('input.' + register.resparam[i]).prop('id', register.resparam[i] + num);
                    $div.find('input.' + register.resparam[i]).prop('name', register.resparam[i] + num);
                }
            }, 500);
            respClone.push($klon);
        });
        $('#' + register.cloneminusbut[1]).click(function () {
            var $div = $('div[id^="' + register.clone[1] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10);
            if (num != 0) {
                $div.remove();
                respClone.pop();
            }
        });
        validateAddGymEvents({source: register, fields: register.fields,action:'edit'});
    }
    ;
    function validateAddGymEvents(attr) {
        var register = attr.source;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        $(register.status).empty();
        $(register.bar).width(register.percentVal);
        $(register.percent).html(register.percentVal);
        for (i = 0; i < register.reqparam.length; i++) {
            $('input.' + register.reqparam[i]).each(function () {
                var rules = $(this).attr("data-rules");
                var messages = $(this).attr("data-messages");
                var jqObj = $(this);
                //LogMessages(rules);
                if (rules.length > 0 && messages.length > 0) {
                    rules = $.parseJSON(rules);
                    messages = $.parseJSON(messages);
                    params['rules'][jqObj] = rules;
                    params['messages'][jqObj] = messages;
                }
            });
        }
        for (i = 0; i < register.resparam.length; i++) {
            $('input.' + register.resparam[i]).each(function () {
                var rules = $(this).attr("data-rules");
                var messages = $(this).attr("data-messages");
                var jqObj = $(this);
                // LogMessages(rules);
                if (rules.length > 0 && messages.length > 0) {
                    rules = $.parseJSON(rules);
                    messages = $.parseJSON(messages);
                    params['rules'][jqObj] = rules;
                    params['messages'][jqObj] = messages;
                }
            });
        }
        for (i = 0; i < fields.length; i++) {
            var field = $('#' + fields[i]).attr("name");
            var rules = $('#' + field).attr("data-rules");
            var messages = $('#' + field).attr("data-messages");
            //LogMessages(field);
            if (rules.length > 0 && messages.length > 0) {
                rules = $.parseJSON(rules);
                messages = $.parseJSON(messages);
                params['rules'][field] = rules;
                params['messages'][field] = messages;
            }
        }
        params['submitHandler'] = function () {
            //$(form).on('submit', function (evt) {
            //evt.stopPropagation();
            //evt.preventDefault();
            ///});
            var formObj = $(form)[0];
            var frmdata = new FormData(formObj);
            //var frmdata = {};
            var reqparam = register.reqparam;
            var respparam = register.resparam;
            var reqparam1 = new Array();
            $('.' + reqparam[0]).each(function () {
                reqparam1.push($(this).val());
            });
            var respparam1 = new Array();
            var respparam2 = new Array();
            $('.' + respparam[0]).each(function () {
                respparam1.push($(this).val());
            });
            $('.' + respparam[1]).each(function () {
                respparam2.push($(this).val());
            });
            /*
             var frmdata = {gymtype: $('#' + fields[0]).val(),
             gymname: $('#' + fields[1]).val(),
             regisfee: $('#' + fields[2]).val(),
             servtax: $('#' + fields[3]).val(),
             telecode: $('#' + fields[4]).val(),
             telephone: $('#' + fields[5]).val(),
             country: $('#' + fields[6]).val(),
             state: $('#' + fields[7]).val(),
             district: $('#' + fields[8]).val(),
             city: $('#' + fields[9]).val(),
             street: $('#' + fields[10]).val(),
             addressline: $('#' + fields[11]).val(),
             zipcode: $('#' + fields[12]).val(),
             website: $('#' + fields[13]).val(),
             gmapurl: $('#' + fields[14]).val(),
             emails: JSON.stringify({mail: reqparam1}),
             cellnumner: JSON.stringify({cod: respparam1, num: respparam2}),
             gymlogo: $('#' + register.logoImg)[0].files[0],
             gymheader: $('#' + register.headerImg)[0].files[0],
             inView: $('#' + register.inView)[0].files[0],
             };*/
            frmdata.append("gymtype", $('#' + fields[0]).val());
            frmdata.append("gymname", $('#' + fields[1]).val());
            frmdata.append("regisfee", $('#' + fields[2]).val());
            frmdata.append("servtax", $('#' + fields[3]).val());
            frmdata.append("telecode", $('#' + fields[4]).val());
            frmdata.append("telephone", $('#' + fields[5]).val());
            frmdata.append("country", $('#' + fields[6]).val());
            frmdata.append("state", $('#' + fields[7]).val());
            frmdata.append("district", $('#' + fields[8]).val());
            frmdata.append("city", $('#' + fields[9]).val());
            frmdata.append("street", $('#' + fields[10]).val());
            frmdata.append("addressline", $('#' + fields[11]).val());
            frmdata.append("zipcode", $('#' + fields[12]).val());
            frmdata.append("website", $('#' + fields[13]).val());
            frmdata.append("gmapurl", $('#' + fields[14]).val());
            frmdata.append("emails", JSON.stringify({mail: reqparam1}));
            frmdata.append("cellnumner", JSON.stringify({cod: respparam1, num: respparam2}));
            frmdata.append("gymlogo", $('#' + register.logoImg)[0].files[0]);
            frmdata.append("gymheader", $('#' + register.headerImg)[0].files[0]);
            frmdata.append("inView", $('#' + register.inView)[0].files[0]);
            if(attr.action === "edit"){
                frmdata.append("gymid", $('#' + fields[16]).val());
            }
            AddDB({jsonattr: register, attr: frmdata});
        }
        ;
        params['invalidHandler'] = function (e, validator) {
            for (var i = 0; i < validator.errorList.length; i++) {
                LogMessages(validator.errorList[i]);
            }

            //validator.errorMap is an object mapping input names -> error messages
            for (var i in validator.errorMap) {
                LogMessages(i, ":", validator.errorMap[i]);
            }
        }
        ;
        $(form).validate(params);
        //LogMessages(flag);
        //return flag;
        /*
         if (flag) {
         //var formObj = $(form)[0];
         //var frmdata = new FormData(formObj);
         var frmdata = {};
         var reqparam = register.reqparam;
         var respparam = register.resparam;
         var reqparam1 = new Array();
         $('.' + reqparam[0]).each(function () {
         reqparam1.push($(this).val());
         });
         var respparam1 = new Array();
         var respparam2 = new Array();
         $('.' + respparam[0]).each(function () {
         respparam1.push($(this).val());
         });
         $('.' + respparam[1]).each(function () {
         respparam2.push($(this).val());
         });
         /*
         frmdata.append("gymtype", $('#' + fields[0]).val());
         frmdata.append("gymname", $('#' + fields[1]).val());
         frmdata.append("regisfee", $('#' + fields[2]).val());
         frmdata.append("servtax", $('#' + fields[3]).val());
         frmdata.append("telecode", $('#' + fields[4]).val());
         frmdata.append("telephone", $('#' + fields[5]).val());
         frmdata.append("country", $('#' + fields[6]).val());
         frmdata.append("state", $('#' + fields[7]).val());
         frmdata.append("district", $('#' + fields[8]).val());
         frmdata.append("city", $('#' + fields[9]).val());
         frmdata.append("street", $('#' + fields[10]).val());
         frmdata.append("addressline", $('#' + fields[11]).val());
         frmdata.append("zipcode", $('#' + fields[12]).val());
         frmdata.append("website", $('#' + fields[13]).val());
         frmdata.append("gmapurl", $('#' + fields[14]).val());
         frmdata.append("emails", JSON.stringify({mail: reqparam1}));
         frmdata.append("cellnumner", JSON.stringify({cod: respparam1, num: respparam2}));
         frmdata.append("gymlogo", $('#' + register.logoImg)[0].files[0]);
         frmdata.append("gymheader", $('#' + register.headerImg)[0].files[0]);
         frmdata.append("inView", $('#' + register.inView)[0].files[0]);
         }
         else {
         alert('Please correct the credentials..');
         }
         */
    }
    ;
    function bindAssignGymEvents(attr) {
        var gym = attr.source;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + gym.form);
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
                frmdata.append("owner", $('#' + fields[0]).val());
                frmdata.append("gymid", $('#' + fields[1]).val());
                //AddDB(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindEditGymEvents() {
        var gym = members.EditGym;
        var fields = gym.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + gym.form);
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
                frmdata.append("id", $('#' + fields[16]).val());
                frmdata.append("gymtype", $('#' + fields[0]).val());
                frmdata.append("gymname", $('#' + fields[1]).val());
                frmdata.append("regisfee", $('#' + fields[2]).val());
                frmdata.append("servtax", $('#' + fields[3]).val());
                frmdata.append("telecode", $('#' + fields[4]).val());
                frmdata.append("telephone", $('#' + fields[5]).val());
                frmdata.append("country", $('#' + fields[6]).val());
                frmdata.append("state", $('#' + fields[7]).val());
                frmdata.append("district", $('#' + fields[8]).val());
                frmdata.append("city", $('#' + fields[9]).val());
                frmdata.append("street", $('#' + fields[10]).val());
                frmdata.append("addressline", $('#' + fields[11]).val());
                frmdata.append("zipcode", $('#' + fields[12]).val());
                frmdata.append("website", $('#' + fields[13]).val());
                frmdata.append("gmapurl", $('#' + fields[14]).val());
                frmdata.append("emails", JSON.stringify({mail: reqparam1}));
                frmdata.append("cellnumner", JSON.stringify({cod: respparam1, num: respparam2}));
                frmdata.append("gymlogo", $('#' + register.logoImg)[0].files[0]);
                frmdata.append("gymheader", $('#' + register.headerImg)[0].files[0]);
                frmdata.append("inView", $('#' + register.inView)[0].files[0]);
                AddDB({jsonattr: register, attr: frmdata});
                EditGymDB(frmdata);
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function EditGymDB(attr) {
        var register = members.EditGym;
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
                //LogMessages(data);
                $(form).get(0).reset();
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    alert('Successfully Modified !!!');
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
    function ListGyms(attr) {
        var gym = attr.source;
        var fields = attr.fields;
        var datatable  = {};
        window.setTimeout(function () {
            datatable = $('#' + fields[attr.index]).DataTable({
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
                                $('#' + fields[attr.index]).css('width', '100%');
                                break;
                        }
                    }
                    else {
                        alert('Unable to list users.');
                    }
                },
                preDrawCallback: function (settings) {
                    $('#' + fields[attr.index]).css('width', '100%');
                },
                drawCallback: function (settings) {
                    $('#' + fields[attr.index]).css('width', '100%');
                },
                columns: [
                    {data: '#', searchable: true, orderable: true},
                    {data: 'Gym Name', searchable: true, orderable: true},
                    {data: 'Gym Type', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Telephone', searchable: true, orderable: true},
                    {data: 'Cell Number', searchable: true, orderable: true},
                    {data: 'Registration Fee', searchable: true, orderable: true},
                    {data: 'Address', searchable: true, orderable: true},
                    {data: 'View', searchable: false, orderable: false},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
//            $(".dataTables_filter input").attr("placeholder", "Enter search terms here");
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[attr.index]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[attr.index] + "_cont0";
                    //aria-controls="fieldCurr1"
                    $(this).attr("id", id);
                    $('#' + id).bind("input", {
                        dtable: $('#' + fields[attr.index]).dataTable().api()
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
        $('#'+gym.btnDiv).click(function(){
            datatable.ajax.reload(null, false);
        });
    }
    ;
    function AddDB(jdata) {
        var register = jdata.jsonattr;
        var attr = jdata.attr;
        var obj = {};
        /*
         var options = {
         url: register.url,
         type: register.type,
         dataType: register.dataType,
         processData: register.processData,
         contentType: register.contentType,
         clearForm: true,
         resetForm: true,
         target: register.status,
         data: attr,
         beforeSubmit: function () {
         //var flag = validateAddGymEvents({source: register, fields: register.fields})
         //if (!flag)
         //return;
         },
         uploadProgress: function (event, position, total, percentComplete) {
         register.percentVal = percentComplete + '%';
         $(register.bar).width(register.percentVal)
         $(register.percent).html(register.percentVal);
         },
         success: function (json, statusText, xhr, $form) {
         register.percentVal = '100%';
         $(register.bar).width(register.percentVal)
         $(register.percent).html(register.percentVal);
         $(register.status).html(json.msg);
         },
         complete: function (xhr) {
         var percentVal = '0%';
         if (xhr.responseText.length == 0) {
         $(register.bar).width(percentVal);
         $(register.percent).html(percentVal);
         }
         },
         error: function (xhr) {
         $(register.status).html(xhr.responseText);
         $(register.status).append('<br />Some thing went wrong');
         }
         };
         LogMessages(options);
         $('#' + register.form).ajaxSubmit(options);
         */
        $.ajax({
            url: register.url,
            type: register.type,
            dataType: register.dataType,
            processData: register.processData,
            contentType: register.contentType,
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
    function gymSearch(attr) {
        var gym = attr.source;
        var fields = attr.fields;
        $('#' + fields[attr.index]).select2({
            ajax: {
                url: gym.url,
                dataType: gym.dataType,
                type: gym.type,
                delay: 250,
                data: function (params) {
                    return {
                        autoloader: gym.autoloader,
                        action: gym.action,
                        q: params.term,
                        page: params.page,
                        listtype: gym.listtype,
                    };
                },
                processResults: function (data, params) {
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
            placeholder: "Search your Gym - [Gym name / Telephone / Email / Cell number / Location ]",
            allowClear: true,
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width: '100%',
        });
        if (gym.loadGym) {
            $('#' + fields[attr.index]).on("change", function (e) {
                window.location.href = $(this).val();
            });
        }
    }
    ;
    function userSearch(attr) {
        var gym = attr.source;
        var fields = attr.fields;
        $('#' + fields[attr.index]).select2({
            ajax: {
                url: gym.url,
                dataType: gym.dataType,
                type: gym.type,
                delay: 250,
                data: function (params) {
                    return {
                        autoloader: gym.autoloader,
                        action: gym.action,
                        q: params.term,
                        page: params.page,
                        listtype: gym.listtype,
                    };
                },
                processResults: function (data, params) {
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
            placeholder: "Search your Owner- [Owner name / Email / Cell number ]",
            allowClear: true,
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width: '100%',
        });
        if (gym.loadUser) {
            $('#' + fields[attr.index]).on("change", function (e) {
                window.location.href = $(this).val();
            });
        }
    }
    ;
    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;
        var markup = '<ul class="products-list product-list-in-box" id="listitem_' + repo.gymid + '">' +
                '<li class="item">' +
                '<div class="product-img">' +
                '<img alt="Product Image" src="' + repo.avatar_url + '">' +
                '</div>' +
                '<div class="product-info">' +
                '<a class="product-title" href="javascript::;">' + repo.name + ' ' + repo.email + ', ' + repo.cell + '<span class="label label-warning pull-right">' + repo.ch_count + '</span></a>' +
                '<span class="product-description">' +
                '<span class="text-danger">&nbsp;Facilities :-<small>' + repo.p_count + '</small>&nbsp;</span>' +
                '<span class="text-danger">&nbsp;Offers :-<small>' + repo.pc_count + '</small>&nbsp;</span>' +
                '<span class="text-danger">&nbsp;Packages :-<small>' + repo.pcr_count + '</small>&nbsp;</span>' +
                '</span>' +
                '</div>' +
                '</li>' +
                '</ul>' +
                '<script language="javascript">' +
                '$("#listitem_' + repo.gymid + '").click(function(e){ e.preventDefault();window.location.href = "' + URL + 'Home/SetGym/' + repo.gymid + '"});' +
                '</script>' +
                '';
        return markup;
    }
    ;
    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
    ;
}
