function masterdataController() {
    var members = {};
    /* Public methods */
    this.__constructor = function (para) {
        members = para;
    };
    this.__Company = function () {
        bindBusinessInfoEvents({
            register: members.AddBusinessInfo,
            fields: members.AddBusinessInfo.fields
        });
        bindBankEvents({
            register: members.AddBank,
            fields: members.AddBank.fields
        });
        bindAddServiceEvents({
            register: members.AddService,
            fields: members.AddService.fields
        });
        bindAddOperatorEvents({
            register: members.AddOperator,
            fields: members.AddOperator.fields
        });
        bindAddOperatorTypeEvents({
            register: members.AddOperatorType,
            fields: members.AddOperatorType.fields
        });
        bindSetCurrencyEvents({
            register: members.SetCurrency,
            fields: members.SetCurrency.fields
        });
        ListBusinessInfo();
        ListBankDetails();
        ListService();
        ListOperators();
        ListOperatorTypes();
        ListSetCurrency();
    };
    this.__BusinessInfoEdit = function () {
        bindEditBusinessEvents({
            register: members.EditBusinessInfo,
            fields: members.EditBusinessInfo.fields
        });
    };
    this.__BankEdit = function () {
        bindEditBankEvents({
            register: members.EditBank,
            fields: members.EditBank.fields
        });
    };
    this.__SetCurrencyEdit = function () {
       bindSetCurrencyEvents({
            register: members.EditSetCurrency,
            fields: members.EditSetCurrency.fields
        });
    };
    this.__ServiceEdit = function () {
        bindAddServiceEvents({
            register: members.EditService,
            fields: members.EditService.fields
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
    this.__Application = function () {
        bindCountriesAddEvents({
            register: members.AddCountries,
            fields: members.AddCountries.fields
        });
        bindCurrenciesAddEvents({
            register: members.AddCurrencies,
            fields: members.AddCurrencies.fields
        });
        bindBusinessTypesAddEvents({
            register: members.AddBusinessType,
            fields: members.AddBusinessType.fields
        });
        bindMOPAddEvents({
            register: members.AddMOP,
            fields: members.AddMOP.fields
        });
        bindMOSAddEvents({
            register: members.AddMOS,
            fields: members.AddMOS.fields
        });
        bindProtocolAddEvents({
            register: members.AddProtocol,
            fields: members.AddProtocol.fields
        });
        bindRestParamAddEvents({
            register: members.AddRestParameter,
            fields: members.AddRestParameter.fields
        });
        bindProofAddEvents({
            register: members.AddProof,
            fields: members.AddProof.fields
        });
        ListCountries();
        ListCurrencies();
        ListBusinessType();
        ListModeOfPay();
        ListModeOfServ();
        ListProtocols();
        ListRestParam();
        ListTraffic();
        ListUserProof();
    };
    this.__CountriesEdit = function () {
        bindCountriesAddEvents({
            register: members.EditCountries,
            fields: members.EditCountries.fields
        });
    };
    this.__CurrenciesEdit = function () {
        bindCurrenciesAddEvents({
            register: members.EditCurrencies,
            fields: members.EditCurrencies.fields
        });
    };
    this.__BusinessTypesEdit = function () {
        bindBusinessTypesAddEvents({
            register: members.EditBusinessType,
            fields: members.EditBusinessType.fields
        });
    };
    this.__RestParamEdit = function () {
        bindRestParamAddEvents({
            register: members.EditRestParameter,
            fields: members.EditRestParameter.fields
        });
    };
    this.__MOPEdit = function () {
        bindMOPAddEvents({
            register: members.EditMOP,
            fields: members.EditMOP.fields
        });
    };
    this.__MOSEdit = function () {
        bindMOSAddEvents({
            register: members.EditMOS,
            fields: members.EditMOS.fields
        });
    };
    this.__ProtocolEdit = function () {
        bindProtocolAddEvents({
            register: members.EditProtocol,
            fields: members.EditProtocol.fields
        });
    };
    this.__ProofEdit = function () {
        bindProofAddEvents({
            register: members.EditProof,
            fields: members.EditProof.fields
        });
    };
    this.__User = function () {
        bindUserTypeAddEvents({
            register: members.AddUserType,
            fields: members.AddUserType.fields
        });
        ListUserTypes();
    };
    this.__UserTypeEdit = function () {
        bindUserTypeAddEvents({
            register: members.EditUserType,
            fields: members.EditUserType.fields
        });
    };
    /* Private bind methods */
    function bindBusinessInfoEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListBusinessType({
            mem: register.btype,
            fields: fields,
            index: Number(0)
        });
        $('#' + fields[2]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-30:+0'
                    //onClose: function (dateText, inst) {
                    //    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDate));
                    //}
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
                formdata.append("btype", $('#' + fields[0]).val());
                formdata.append("cname", $('#' + fields[1]).val());
                formdata.append("doc", $('#' + fields[2]).val());
                formdata.append("website", $('#' + fields[4]).val());
                formdata.append("addline", $('#' + fields[5]).val());
                formdata.append("country", $('#' + fields[6]).val());
                formdata.append("state", $('#' + fields[7]).val());
                formdata.append("distct", $('#' + fields[8]).val());
                formdata.append("city", $('#' + fields[9]).val());
                formdata.append("stloc", $('#' + fields[10]).val());
                formdata.append("zipc", $('#' + fields[11]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindBankEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
        fetchListCompany({
            mem: register.company,
            fields: fields,
            index: Number(0)
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
            e.preventDefault();
            if (flag) {
                var formdata = new FormData();
                formdata.append("cmpname", $('#' + fields[0]).val());
                formdata.append("acname", $('#' + fields[1]).val());
                formdata.append("acno", $('#' + fields[2]).val());
                formdata.append("acifsc", $('#' + fields[3]).val());
                formdata.append("bnkame", $('#' + fields[4]).val());
                formdata.append("bnkcode", $('#' + fields[5]).val());
                formdata.append("bbrname", $('#' + fields[6]).val());
                formdata.append("bbrcode", $('#' + fields[7]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindSetCurrencyEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
        fetchListCompany({
            mem: register.company,
            fields: fields,
            index: Number(0)
        });
        fetchListCurrency({
            mem: register.currency,
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
            flag = 1;
        }
        ;
        params['invalidHandler'] = function () {
            flag = 0;
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            e.preventDefault();
            if (flag) {
                var formdata = new FormData();
                formdata.append("company_currency_id", $('#' + fields[3]).val());
                formdata.append("company", $('#' + fields[0]).val());
                formdata.append("currency", $('#' + fields[1]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindAddServiceEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListCompany({
            mem: register.company,
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
                formdata.append("services_id", $('#' + fields[6]).val());
                formdata.append("company", $('#' + fields[0]).val());
                formdata.append("name", $('#' + fields[1]).val());
                formdata.append("code", $('#' + fields[2]).val());
                formdata.append("flatcommission", $('#' + fields[3]).val());
                formdata.append("variablecommission", $('#' + fields[4]).val());
                AddDB({jsonattr: register, attr: formdata});
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
        fetchListServices({
            mem: register.services,
            fields: fields,
            index: Number(0)
        });
        $('#' + register.parentBut).click(function () {
            fetchListServices(attr);
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
                formdata.append("serv", $('#' + fields[0]).val());
                formdata.append("name", $('#' + fields[1]).val());
                formdata.append("ocde", $('#' + fields[2]).val());
                formdata.append("alas", $('#' + fields[3]).val());
                formdata.append("flat", $('#' + fields[4]).val());
                formdata.append("variable", $('#' + fields[5]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindAddOperatorTypeEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var form = $('#' + register.form);
        fetchListOperators({
            mem: register.operator,
            fields: fields,
            index: Number(0)
        });
        $('#' + register.parentBut).click(function () {
            fetchListOperators(attr);
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
        }
        ;
        params['invalidHandler'] = function () {
            alert('Please correct the credentials..');
        };
        $(form).validate(params);
        $(form).submit(function (e) {
            //e.preventDefault();
            var formdata = new FormData();
            formdata.append("operator_type_id", $('#' + fields[6]).val());
            formdata.append("operator", $('#' + fields[0]).val());
            formdata.append("optype", $('#' + fields[1]).val());
            formdata.append("optypecode", $('#' + fields[2]).val());
            formdata.append("flat", $('#' + fields[3]).val());
            formdata.append("variable", $('#' + fields[4]).val());
            AddDB({jsonattr: register, attr: formdata});
        });
    }
    ;
    function bindCountriesAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListContinents({
            mem: register.continents,
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
//            e.preventDefault();
            if (flag) {
                var formdata = new FormData();
                formdata.append("portal_countries_id", $('#' + fields[11]).val());
                formdata.append("continent", $('#' + fields[0]).val());
                formdata.append("countname", $('#' + fields[1]).val());
                formdata.append("countcap", $('#' + fields[2]).val());
                formdata.append("countiso", $('#' + fields[3]).val());
                formdata.append("countis3", $('#' + fields[4]).val());
                formdata.append("countisn", $('#' + fields[5]).val());
                formdata.append("counttld", $('#' + fields[6]).val());
                formdata.append("countfib", $('#' + fields[7]).val());
                formdata.append("countphn", $('#' + fields[8]).val());
                formdata.append("countcurnm", $('#' + fields[9]).val());
                formdata.append("countcurcd", $('#' + fields[10]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindCurrenciesAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListCountries({
            mem: register.countire,
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
                formdata.append("curr_id", $('#' + fields[4]).val());
                formdata.append("country", $('#' + fields[0]).val());
                formdata.append("currname", $('#' + fields[1]).val());
                formdata.append("currcode", $('#' + fields[2]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindBusinessTypesAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListCountries({
            mem: register.countire,
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
                formdata.append("business_type_id", $('#' + fields[3]).val());
                formdata.append("country", $('#' + fields[0]).val());
                formdata.append("btype", $('#' + fields[1]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindMOPAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
                formdata.append("mop_id", $('#' + fields[2]).val());
                formdata.append("mop", $('#' + fields[0]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindMOSAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
                formdata.append("mos_id", $('#' + fields[2]).val());
                formdata.append("mos", $('#' + fields[0]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindProtocolAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
                formdata.append("pname", $('#' + fields[0]).val());
                formdata.append("pbname", $('#' + fields[1]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindRestParamAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
                formdata.append("rest_param_id", $('#' + fields[4]).val());
                formdata.append("Param", $('#' + fields[0]).val());
                formdata.append("meang", $('#' + fields[1]).val());
                formdata.append("desc", $('#' + fields[2]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindProofAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListCountries({
            mem: register.countire,
            fields: fields,
            index: Number(0),
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
                formdata.append("proof_id", $('#' + fields[3]).val());
                formdata.append("country", $('#' + fields[0]).val());
                formdata.append("proof", $('#' + fields[1]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindUserTypeAddEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
                formdata.append("userType_id", $('#' + fields[3]).val());
                formdata.append("userType", $('#' + fields[0]).val());
                formdata.append("minBalance", $('#' + fields[1]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindEditBusinessEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
        fetchListBusinessType({
            mem: register.btype,
            fields: fields,
            index: Number(0)
        });
        $('#' + fields[2]).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '-30:+0'
                    //onClose: function (dateText, inst) {
                    //    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDate));
                    //}
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
                formdata.append("company_id", $('#' + fields[12]).val());
                formdata.append("btype", $('#' + fields[0]).val());
                formdata.append("cname", $('#' + fields[1]).val());
                formdata.append("doc", $('#' + fields[2]).val());
                formdata.append("website", $('#' + fields[3]).val());
                formdata.append("addline", $('#' + fields[4]).val());
                formdata.append("country", $('#' + fields[5]).val());
                formdata.append("state", $('#' + fields[6]).val());
                formdata.append("distct", $('#' + fields[7]).val());
                formdata.append("city", $('#' + fields[8]).val());
                formdata.append("stloc", $('#' + fields[9]).val());
                formdata.append("zipc", $('#' + fields[10]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindEditBankEvents(attr) {
        var register = attr.register;
        var fields = attr.fields;
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
        fetchListCompany({
            mem: register.company,
            fields: fields,
            index: Number(0)
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
            e.preventDefault();
            if (flag) {
                var formdata = new FormData();
                formdata.append("company_bank_accounts_id", $('#' + fields[9]).val());
                formdata.append("cmpname", $('#' + fields[0]).val());
                formdata.append("acname", $('#' + fields[1]).val());
                formdata.append("acno", $('#' + fields[2]).val());
                formdata.append("acifsc", $('#' + fields[3]).val());
                formdata.append("bnkame", $('#' + fields[4]).val());
                formdata.append("bnkcode", $('#' + fields[5]).val());
                formdata.append("bbrname", $('#' + fields[6]).val());
                formdata.append("bbrcode", $('#' + fields[7]).val());
                AddDB({jsonattr: register, attr: formdata});
            }
        });
    }
    ;
    function bindEditBusinessTypeEvents() {
        var register = members.AddBusinessType;
        var fields = members.EditBusinessType.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
//        fetchListCountries({
//            mem: register.countires,
//            fields: fields,
//            index: Number(0),
//        });
//        $('#' + register.parentBut).click(function() {
//            fetchListCountries();
//        });
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
                formdata.append("country", $('#' + fields[1]).val());
                formdata.append("btype", $('#' + fields[2]).val());
                EditBusinessDB(formdata);
            }
        });
    }
    ;
    function bindEditCurrencyEvents() {
        var register = members.AddCurrencies;
        var fields = members.EditCurrencies.fields;
        var params = {debug: false, rules: {}, messages: {}};
        var flag = 0;
        var form = $('#' + register.form);
//        $('#' + register.parentBut).click(function() {
//            fetchListCountries();
//        });
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
                formdata.append("country", $('#' + fields[1]).val());
                formdata.append("currname", $('#' + fields[2]).val());
                formdata.append("currcode", $('#' + fields[3]).val());
                EditBusinessDB(formdata);
            }
        });
    }
    ;
    /* Private Add methods */
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
                    alert('Successfully Done !!!');
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
    /* Private fetch methods */
    function fetchListCompany(attr) {
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
    function fetchListCurrency(attr) {
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
    function fetchListContinents(attr) {
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
    function fetchListCountries(attr) {
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
                    $('#' + fields[index]).html(obj.html);
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
    /* Private List methods */
    function ListBusinessInfo() {
        var users = members.ListBusinessInfo;
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
                    {data: 'Business Name', searchable: true, orderable: true},
                    {data: 'Website', searchable: true, orderable: true},
                    {data: 'Address line', searchable: true, orderable: true},
                    {data: 'Country', searchable: true, orderable: true},
                    {data: 'City', searchable: true, orderable: true},
                    {data: 'Business Established', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
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
    }
    ;
    function ListBankDetails() {
        var users = members.ListBankDetails;
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
                        alert('Unable to list Bank details.');
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
                    {data: 'Company', searchable: true, orderable: true},
                    {data: 'Account Name', searchable: true, orderable: true},
                    {data: 'Account Number', searchable: true, orderable: true},
                    {data: 'Bank Name', searchable: true, orderable: true},
                    {data: 'Branch', searchable: true, orderable: true},
                    {data: 'Branch Code', searchable: true, orderable: true},
                    {data: 'IFSC', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false},
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont2";
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
    function ListSetCurrency() {
        var users = members.ListSetCurrency;
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
                        alert('Unable to list Currencies.');
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
                    {data: 'Company', searchable: true, orderable: true},
                    {data: 'Currency', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont15";
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
    function ListService() {
        var users = members.ListService;
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
                    {data: 'Company', searchable: true, orderable: true},
                    {data: 'Service Name', searchable: true, orderable: true},
                    {data: 'Service LT Code', searchable: true, orderable: true},
                    {data: 'Flat Commission', searchable: true, orderable: true},
                    {data: 'Variable Commission', searchable: true, orderable: true},
                    {data: 'Started At', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
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
                    {data: 'Service Name', searchable: true, orderable: true},
                    {data: 'Operator LT Code', searchable: true, orderable: true},
                    {data: 'Operator Alias', searchable: true, orderable: true},
                    {data: 'Flat Commission', searchable: true, orderable: true},
                    {data: 'Variable Commission', searchable: true, orderable: true},
                    {data: 'Started At', searchable: true, orderable: true},
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
                    {data: 'Service Name', searchable: true, orderable: true},
                    {data: 'Operator Type', searchable: true, orderable: true},
                    {data: 'Operator Type LT Code', searchable: true, orderable: true},
                    {data: 'Flat Commission', searchable: true, orderable: true},
                    {data: 'Variable Commission', searchable: true, orderable: true},
                    {data: 'Started At', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
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
    function ListBusinessType() {
        var users = members.ListBusinessType;
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
                        targets: 2,
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
                        alert('Unable to list Business Type.');
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
                    {data: 'Business Type', searchable: true, orderable: true},
                    {data: 'Country', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont6";
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
    function ListCountries() {
        var users = members.ListCountries;
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
                        targets: 4,
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
                    }
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
                        LogMessages(data);
                        $('#' + fields[0]).css('width', '100%');
                    }
                    else {
                        alert('Unable to list countries.');
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
                    {data: 'Country Name', searchable: true, orderable: true},
                    {data: 'Country Capital', searchable: true, orderable: true},
                    {data: 'Country Fips', searchable: true, orderable: true},
                    {data: 'Continent', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont7";
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
    function ListCurrencies() {
        var users = members.ListCurrencies;
        var fields = users.fields;
        window.setTimeout(function () {
            $('#' + fields[0]).DataTable({
                processing: true,
                serverSide: true,
                paging: true,
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
                        targets: 3,
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
                        alert('Unable to list countries.');
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
                    {data: 'Currency Name', searchable: true, orderable: true},
                    {data: 'Currency Code', searchable: true, orderable: true},
                    {data: 'Created At', searchable: true, orderable: true},
                    {data: 'Country', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont8";
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
    function ListModeOfPay() {
        var users = members.ListModeOfPay;
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
                        targets: 2,
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
                        alert('Unable to list countries.');
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
                    {data: 'Mode Of Payment', searchable: true, orderable: true},
                    {data: 'Created At', searchable: true, orderable: true},
                    {data: 'Updated At', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont9";
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
    function ListModeOfServ() {
        var users = members.ListModeOfServ;
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
                        targets: 3,
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
                        alert('Unable to list countries.');
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
                    {data: 'Mode Of Service', searchable: true, orderable: true},
                    {data: 'Created At', searchable: true, orderable: true},
                    {data: 'Updated At', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont10";
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
    function ListProtocols() {
        var users = members.ListProtocols;
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
                        targets: 3,
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
                        alert('Unable to list countries.');
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
                    {data: 'Protocol Name', searchable: true, orderable: true},
                    {data: 'Base Name', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont11";
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
    function ListRestParam() {
        var users = members.ListRestParam;
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
                        targets: 3,
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
                        alert('Unable to list countries.');
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
                    {data: 'Parameter Field', searchable: true, orderable: true},
                    {data: 'Parameter Meaning', searchable: true, orderable: true},
                    {data: 'Parameter Description', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont11";
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
    function ListTraffic() {
        var users = members.ListTraffic;
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
                        targets: 7,
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
                    {data: 'Traffic Ip', searchable: true, orderable: true},
                    {data: 'Traffic Host', searchable: true, orderable: true},
                    {data: 'Organisation', searchable: true, orderable: true},
                    {data: 'Traffic Isp', searchable: true, orderable: true},
                    {data: 'Traffic Hit Time', searchable: true, orderable: true},
                    {data: 'City', searchable: true, orderable: true},
                    {data: 'Country', searchable: true, orderable: true},
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont12";
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
    function ListUserProof() {
        var users = members.ListUserProof;
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
                        targets: 3,
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
                        alert('Unable to list user proofs.');
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
                    {data: 'ID Proof Type', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true},
                    {data: 'Country', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                    {data: 'Delete', searchable: false, orderable: false}
                ]
            });
            $(".dataTables_filter input").attr("placeholder", "Enter search terms here");
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont13";
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
    function ListUserTypes() {
        var users = members.ListUserTypes;
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
                        targets: 3,
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
                        d.who = users.who;
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
                        alert('Unable to list user proofs.');
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
                    {data: 'User Type', searchable: true, orderable: true},
                    {data: 'Minimum Balance', searchable: true, orderable: true},
                    {data: 'Date', searchable: true, orderable: true},
                    {data: 'Edit', searchable: false, orderable: false},
                ]
            });
            $(".dataTables_filter input").each(function () {
                var attr = $(this).attr("aria-controls");
                if (attr === fields[0]) {
                    $(this).attr("placeholder", "Enter search terms here");
                    var id = fields[0] + "_cont14";
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
    /* Private Edit methods */
    function EditBusinessDB(attr) {
        var register = members.EditBusiness;
        var form = $('#' + register.form);
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
    function EditBankDB() {
        var register = members.EditBank;
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
                    alert('Successfully modified Bank Details !!!');
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
    var this_js_script = $("script[src$='MasterData.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            LogMessages('I am In Master Data');
        }
        else {
            LogMessages('I am Out Master Data');
        }
    }
});