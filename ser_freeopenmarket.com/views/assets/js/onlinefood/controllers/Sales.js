function gatewayController() {
    var members = {};
    var users = {};
    var restParams = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__AddGate = function () {
        var register = members.AddGateway;
        var fields = members.AddGateway.fields;
        fetchListBusinessType({
            mem: register.btype,
            fields: fields,
            index: Number(1)
        });
        fetchDocTypes({
            mem: register.doctype,
            fields: fields,
            index: Number(15)
        });
        fetchListServices({
            mem: register.services,
            fields: fields,
            index: Number(0)
        });
        bindAddGatewayEvents({
            register: members.AddGateway,
            fields: members.AddGateway.fields
        });
        ListGateway();
//        bindEditUserEvents();

    };
    this.__AddOpt = function () {
        bindAddOperatorEvents({
            register: members.AddOperator,
            fields: members.AddOperator.fields
        });
        bindAddOperatorTypeEvents({
            register: members.AddOperatorType,
            fields: members.AddOperatorType.fields
        }); 
    };
    this.__ListOpt = function () {
     ListOperators();
     ListOperatorTypes();
 };
    this.__AddProtocol = function () {
        var register = members.AddRest;
        var fields = members.AddRest.fields;
        fetchRestParameters({
            mem: register.restParameters,
        });
        fetchListGateways({
            mem: register.gateway,
            fields: fields,
            index: Number(0)
        });
        fetchListProtocolTypes({
            mem: register.protocol,
            fields: fields,
            index: Number(4)
        });
        fetchListRestMethod({
            mem: register.restMethod,
            fields: fields,
            index: Number(5)
        });
        fetchListRestTypes({
            mem: register.restTypes,
            fields: fields,
            index: Number(6)
        });
        addMapValues(register.reqparam);
        addMapValues(register.resparam);
        bindAddRestEvents();
    };
    this.__SetMapp = function () {
        var register = members.Mapping;
        var fields = members.Mapping.fields;
        fetchListServices({
            mem: register.services,
            fields: fields,
            index: Number(0)
        });
        fetchListOperators({
            parent: register,
            mem: register.operator,
            fields: fields,
            index: Number(1)
        });
        fetchListGateways({
            mem: register.gateway,
            fields: fields,
            index: Number(3)
        });
        fetchGatewayOperators({
            mem: register.gateOperator,
            fields: fields,
            index: Number(4)
        });
        fetchGatewayOperatorTypes({
            mem: register.gateOperatorType,
            fields: fields,
            index: Number(5)
        });
        bindSetMappingEvents();
    };
    this.__EditGate = function () {
        var register = members.EditGateway;
        var fields = members.EditGateway.fields;
        fetchListBusinessType({
            mem: register.btype,
            fields: fields,
            index: Number(1)
        });
        fetchDocTypes({
            mem: register.doctype,
            fields: fields,
            index: Number(15)
        });
        fetchListServices({
            mem: register.services,
            fields: fields,
            index: Number(0)
        });
        bindAddGatewayEvents({
            register: members.EditGateway,
            fields: members.EditGateway.fields
        });

    };
     this.__OperatorEdit = function () {
        bindAddOperatorEvents({
            register: members.EditOperator,
            fields: members.EditOperator.fields
        });
    };
     this.__OperatorTypeEdit = function () {
        bindAddOperatorTypeEvents({
            register: members.EditOperatorType,
            fields: members.EditOperatorType.fields
        });
    };
//    this.__EditOpt = function () {
//        bindAddOperatorEvents({
//            register: members.EditOperator,
//            fields: members.EditOperator.fields
//        });
//        bindAddOperatorTypeEvents({
//            register: members.EditOperatorType,
//            fields: members.EditOperatorType.fields
//        });
//    };
    this.__ListUserRequests = function () {
        UserRequests();
    };

    /* Private bind methods */
    function bindAddGatewayEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        var picedit = false;
        var checkusr = 0;
        var picEditObj1 = {};
        $('#' + fields[4]).datepicker({
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
//                LogMessages(_this);
//                picEditObj1._setDefaultImage(img.src);
//                throw new Error('Stop Damn Recursion');
//                return false;
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
        }
        ;
        params['invalidHandler'] = function () {
            picedit = false;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            if (picedit && $('#' + fields[16]).prop('files').length > 0) {
                var formdata = new FormData();
                formdata.append("gateUser_id", $('#' + fields[18]).val());
                formdata.append("service", $('#' + fields[0]).val());
                formdata.append("businesstype", $('#' + fields[1]).val());
                formdata.append("name", $('#' + fields[2]).val());
                formdata.append("email", $('#' + fields[3]).val());
                formdata.append("doc", $('#' + fields[4]).val());
                formdata.append("version", $('#' + fields[5]).val());
                formdata.append("mobile", $('#' + fields[6]).val());
                formdata.append("addline", $('#' + fields[7]).val());
                formdata.append("country", $('#' + fields[8]).val());
                formdata.append("state", $('#' + fields[9]).val());
                formdata.append("distct", $('#' + fields[10]).val());
                formdata.append("city", $('#' + fields[11]).val());
                formdata.append("stloc", $('#' + fields[12]).val());
                formdata.append("zipc", $('#' + fields[13]).val());
                formdata.append("proof_id", $('#' + fields[14]).val());
                formdata.append("proof_type", $('#' + fields[15]).val());
                formdata.append("file", $('#' + fields[16]).prop('files')[0]);
                AddDB({jsonattr: register, attr: formdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindAddRestEvents() {
        var register = members.AddRest;
        var fields = members.AddRest.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
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
            flag = 1;
        }
        ;
        params['invalidHandler'] = function () {
            flag = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            if (flag) {
                var formdata = new FormData();
                var reqparam = register.reqparam;
                var respparam = register.resparam;
                var reqparam1 = new Array();
                var reqparam2 = new Array();
                var reqparam3 = new Array();
                $('.' + reqparam[0]).each(function () {
                    reqparam1.push($(this).val());
                });
                $('.' + reqparam[1]).each(function () {
                    reqparam2.push($(this).val());
                });
                $('.' + reqparam[2]).each(function () {
                    reqparam3.push($(this).val());
                });
                var respparam1 = new Array();
                var respparam2 = new Array();
                var respparam3 = new Array();
                $('.' + respparam[0]).each(function () {
                    respparam1.push($(this).val());
                });
                $('.' + respparam[1]).each(function () {
                    respparam2.push($(this).val());
                });
                $('.' + respparam[2]).each(function () {
                    respparam3.push($(this).val());
                });

                formdata.append("gateway", $('#' + fields[0]).val());
                formdata.append("url", $('#' + fields[1]).val());
                formdata.append("rurl", $('#' + fields[2]).val());
                formdata.append("port", $('#' + fields[3]).val());
                formdata.append("protocoltype", $('#' + fields[4]).val());
                formdata.append("rstmethod", $('#' + fields[5]).val());
                formdata.append("rsttype", $('#' + fields[6]).val());
                formdata.append("request", {para: reqparam1, value: reqparam2, map: respparam3});
                formdata.append("response", {para: respparam1, value: respparam2, map: respparam3});

                AddDB({jsonattr: register, attr: formdata});
            }
        });

        var reqClone = new Array();
        $('#' + register.cloneplusbut[0]).click(function () {
            var $div = $('div[id^="' + register.clone[0] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10) + 1;
            var $klon = $div.clone().prop('id', register.clone[0] + num).insertAfter('div[id^="' + register.clone[0] + '"]:last');
            reqClone.push($klon);
            addMapValues(register.reqparam);
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
            respClone.push($klon);
            addMapValues(register.resparam);
        });
        $('#' + register.cloneminusbut[1]).click(function () {
            var $div = $('div[id^="' + register.clone[1] + '"]:last');
            var num = parseInt($div.prop("id").match(/\d+/g), 10);
            if (num != 0) {
                $div.remove();
                respClone.pop();
            }
        });
    }
    ;
    function addMapValues(param) {
        $('.' + param[2]).each(function () {
            if ($(this).html() == '') {
                $(this).html(restParams.html);
            }
        });
    }
    ;
    function bindAddOperatorEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListGateways({
            mem: register.searchGateway,
            fields: fields,
            index: Number(0)
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
            flag = 1;
        }
        ;
        params['invalidHandler'] = function () {
            flag = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            if (flag) {
                var formdata = new FormData();
                formdata.append("operator_id", $('#' + fields[7]).val());
                formdata.append("gate", $('#' + fields[0]).val());
                formdata.append("name", $('#' + fields[1]).val());
                formdata.append("ocode", $('#' + fields[2]).val());
                formdata.append("alias", $('#' + fields[3]).val());
                formdata.append("flat", $('#' + fields[4]).val());
                formdata.append("variable", $('#' + fields[5]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindAddOperatorTypeEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchGatewayOperators({
            mem: register.operator,
            fields: fields,
            index: Number(0)
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
            flag = 1;
        }
        ;
        params['invalidHandler'] = function () {
            flag = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
           if (flag) {
            var formdata = new FormData();
            formdata.append("operator_type_id", $('#' + fields[6]).val());
            formdata.append("operator", $('#' + fields[0]).val());
            formdata.append("optype", $('#' + fields[1]).val());
            formdata.append("optypecode", $('#' + fields[2]).val());
            formdata.append("flat", $('#' + fields[3]).val());
            formdata.append("variable", $('#' + fields[4]).val());
            AddDB({jsonattr: register, attr: formdata});
            }
            else {
                alert('Please correct the credentials..');
            }
        });
    }
    ;
    function bindSetMappingEvents() {
        var register = members.Mapping;
        var fields = members.Mapping.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
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
            flag = 1;
        }
        ;
        params['invalidHandler'] = function () {
            flag = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            if (flag) {
                var formdata = new FormData();
                formdata.append("serv", $('#' + fields[0]).val());
                formdata.append("oper", $('#' + fields[1]).val());
                formdata.append("operty", $('#' + fields[2]).val());
                formdata.append("gate", $('#' + fields[3]).val());
                formdata.append("gtoper", $('#' + fields[4]).val());
                formdata.append("gtoperty", $('#' + fields[5]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    /* Private fetch methods */
    function fetchListBusinessType(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            processData: mem.processData,
            contentType: mem.contentType,
            data: fields,
            success: function (data, textStatus, xhr) {
                LogMessages(data);
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + fields[index]).html(data.html);
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
    function fetchListServices(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
    function fetchListProtocolTypes(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
    function fetchListRestMethod(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
    function fetchListRestTypes(attr) {
        var mem = attr.mem;
        var fields = attr.fields;
        var index = Number(attr.index);
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
    function fetchListOperators(attr) {
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
                    window.setTimeout(function () {
                        fetchListOperatorTypes({
                            mem: attr.parent.operatorType,
                            fields: attr.fields,
                            index: Number(2),
                            operator: Number($('#' + fields[index]).val()),
                        });
                    }, 400);
                    $('#' + fields[index]).change(function (evt) {
                        fetchListOperatorTypes({
                            mem: attr.parent.operatorType,
                            fields: attr.fields,
                            index: Number(2),
                            operator: Number($(this).val()),
                        });
                    });
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function fetchListOperatorTypes(attr) {
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
                operator: attr.operator,
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
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function fetchListGateways(attr) {
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
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function fetchGatewayOperators(attr) {
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
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function fetchGatewayOperatorTypes(attr) {
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
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function fetchRestParameters(attr) {
        var mem = attr.mem;
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
                    restParams = obj;
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
            }
        });

    }
    ;
    function checkEmail(email) {
        var checkemail = members.AddGateway.checkemail;
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
    /* Private ADD methods */
    function AddDB(jdata) {
        var register = jdata.jsonattr;
        var attr = jdata.attr;
        var form = $('#' + register.form);
        LogMessages(register);
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
    /* List methods */
    function ListGateway() {
        var users = members.ListGateway;
        var fields = users.fields;
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
                        targets: 0,
                        visible: true
                    }
                ],
                ajax: {
                    url: users.url,
                    dataType: users.dataType,
                    type: users.type,
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
                        alert('Unable to list Traffic.');
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
                    {data: 'Gateway Name', searchable: true, orderable: true},
                    {data: 'Business Type', searchable: true, orderable: true},
                    {data: 'Service', searchable: true, orderable: true},
                    {data: 'Gateway API version', searchable: true, orderable: true},
                    {data: 'Email', searchable: true, orderable: true},
                    {data: 'Mobile', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont4";
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
    function ListOperators() {
        var users = members.ListOperator;
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
                    {data: 'Operator Name', searchable: true, orderable: true},
                    {data: 'Gateway Name', searchable: true, orderable: true},
                    {data: 'Operator LT Code', searchable: true, orderable: true},
                    {data: 'Operator Alias', searchable: true, orderable: true},
                    {data: 'Fixed Commission', searchable: true, orderable: true},
                    {data: 'Variable Commission', searchable: true, orderable: true},
                    {data: 'Started At', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont3";
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
    function ListOperatorTypes() {
        var users = members.ListOperatorType;
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
                    {data: 'Operator Name', searchable: true, orderable: true},
                    {data: 'Gateway Name', searchable: true, orderable: true},
                    {data: 'Operator Type', searchable: true, orderable: true},
                    {data: 'Operator Type LT Code', searchable: true, orderable: true},
                    {data: 'Fixed Commission', searchable: true, orderable: true},
                    {data: 'Variable Commission', searchable: true, orderable: true},
                    {data: 'Started At', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont5";
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
    /* methods */
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
    function Listper() {
        var users = members.Personal.ListUser;
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
        $('#' + fields[0]).click(function () {
            fetchUserTypes();
        });
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
                var formdata = new FormData();
                formdata.append("usertype", $('#' + fields[0]).val());
                formdata.append("name", $('#' + fields[1]).val());
                formdata.append("email", $('#' + fields[2]).val());
                formdata.append("dob", $('#' + fields[3]).val());
                formdata.append("gender", $('#' + fields[4]).val());
                formdata.append("mobile1", $('#' + fields[5]).val());
                formdata.append("mobile2", $('#' + fields[6]).val());
                formdata.append("addline", $('#' + fields[7]).val());
                formdata.append("country", $('#' + fields[8]).val());
                formdata.append("state", $('#' + fields[9]).val());
                formdata.append("distct", $('#' + fields[10]).val());
                formdata.append("city", $('#' + fields[11]).val());
                formdata.append("stloc", $('#' + fields[12]).val());
                formdata.append("zipc", $('#' + fields[13]).val());
                formdata.append("proof_id", $('#' + fields[14]).val());
                formdata.append("proof_type", $('#' + fields[15]).val());
                formdata.append("file", $('#' + fields[16]).prop('files')[0]);
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
}
$(document).ready(function () {
    var this_js_script = $("script[src$='Gateway.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            LogMessages('I am In Gateway');
        }
        else {
            LogMessages('I am Out Gateway');
        }
    }
});