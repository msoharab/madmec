function controlCustomerAdd() {
    var custsex = 'NULL';
    var occup = 'NULL';
    var vale = '';
    var ftype1 = 1;
    var mopname = [];
    var cust = {};
    var em = {};
    var cn = {};
    var fp = {};
    var cinfo = {};
    var dccode = '91';
    var dpcode = '080';
    /*var startDate;*/
    var selectedYear;
    var gymid = $(DGYM_ID).attr('name');
    this.__construct = function (customer) {
        cust = customer;
        em = customer.em;
        cn = customer.cn;
        fp = customer.paymentrow;
        cinfo = customer.custinfo;
        //        $(cinfo.ccellnum).change(function () {
        //            checkUserInEnquiry();
        //        });
        $(cinfo.ccellnum).keyup(function () {
            checkUserInEnquiry();
        });
        var id = $(DGYM_ID).attr('name');
        $("#gym_id").val(gymid);
        addcustomerAutoComplete();
        $(cinfo.dob).datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'dd-M-yy',
            yearRange: '-100 : ' + ((new Date().getFullYear()) - 10).toString(),
            maxDate: 0,
            onSelect: function (dateText, inst) {
                var startDate = new Date(dateText);
                selectedYear = startDate.getFullYear();
                /* selected year*/
                /*alert(selectedYear);       */
            }
        });
        /*$(cinfo.dob).*/
        $(cinfo.doj).datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'dd-M-yy',
            yearRange: '-100 : ' + ((new Date().getFullYear()) - 10).toString(),
        });
        $(cinfo.doj).datepicker("setDate", new Date());
        $(".picedit_box").picEdit({
            imageUpdated: function (img) {
            },
            formSubmitted: function (data) {
            },
            redirectUrl: false,
            defaultImage: URL + ASSET_IMG + 'No_image.png',
        });
        $(cinfo.saveBtn).bind("click", function () {
            /*alert($(cinfo.refername).val());  */
            customerAdd();
        });
        $(cust.mofpayment).on('change', function () {
            vale = $(cust.mofpayment + ' :selected').text();
            if (vale == "Cash")
                var html = '';
            else
                var html = '<input name="mod_number_temp_1" type="text" placeholder="Enter the ' + vale + ' number" id="mode_payment_01" class="form-control" width="30" />';
            $("#" + cust.number_box).html(html);
        });
        $(cinfo.occupation).on('change', function () {
            occup = $(cinfo.occupation + ' :selected').val();
            /*alert("occup="+occup);  */
        });
        $(cust.custsexParent).on('change', function () {
            custsex = $(cust.custsexParent + ' :selected').val();
        });
        /*$(cinfo.custfact).on('change',function(){*/
        /*ftype1 = $(cinfo.custfact+' :selected').val();  */
        /*});	*/
        // setcustGym();
        fetchmodeofpayment();
        /* final Mode Of Payment*/
        /*modeofpaymentcust();	  	*/
        fetchgenderType();
        /*fetchfacilitytype();*/
        AddCDummyEmail();
        /*initializefeerow();	  	*/
        /*initializeProfileAddForm();	*/
        bindKeyupFee(1);
    };
    this.ShowTextBox = function (num, id) {
        $("input[name='mod_number_" + num + "_" + num + "']").each(function () {
            $(this).hide();
        });
        var mopval = $('#cust_mod_pay_' + num).select().val();
        $('#mopctext_' + id + '_' + num).show();
    };
    this.addModeOfPayment = function (id, num, mop) {
        var new_num = num + 1;
        textboxval = '';
        for (p = 0; p <= mop.textbox.length; p++) {
            if ((mop.textbox[p]) != "Cash")
                /*if((mop.textbox[p].toLowerCase())!="cash")*/
                textboxval += '<input name="mod_number_' + new_num + '_' + new_num + '" type="text" placeholder="' + mop.textbox[p] + ' Number" id="mopctext_' + mop.id[p] + '_' + new_num + '" class="form-control" style="display:none;"/>';
        }
        $("#custmodeofpament").append(
                '<div class="row" id="usr_fee_row_' + new_num + '_' + new_num + '">' +
                '<div class="col-lg-12">' +
                '<div class="col-md-3">' +
                '<select name="mod_pay" id="cust_mod_pay_' + new_num + '" class="form-control">' +
                '<option value="NULL" selected>Select Mode Of Payment</option>' + mop.htm + '</select><p class="help-block" id="mod_msg_' + new_num + '">&nbsp;</p>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input name="user_fee"   type="text" value="0" id="cust_fee_mop_' + new_num + '" class="form-control"/></div>' +
                '<div class="col-md-3">' + textboxval + '</div>' +
                '<div class="col-md-3">' +
                '<a id="addcmop_' + id + '_' + new_num + '" class="btn btn-success " href="javascript:void(0);"><i class="fa fa-plus"></i></a> ' +
                '<a id="remcmop_' + id + '_' + new_num + '" class="btn btn-danger" href="javascript:void(0);"><i class="fa fa-minus"></i></a>' +
                '</div><div class="col-lg-12">&nbsp;</div></div></div>');
        $("#remcmop_" + id + "_" + new_num).on("click", function () {
            var tot = Number($("#keycodes").text());
            tot -= 1;
            if (tot == 1)
                $("#cust_addmop_1").show();
            if (tot < 1) {
                $("#keycodes").text(1);
            } else {
                $("#keycodes").text(tot);
            }
            $("#remcmop_" + id + "_" + num).show();
            $("#addcmop_" + id + "_" + num).show();
            $("#usr_fee_row_" + new_num + "_" + new_num).remove();
        });
        $("#addcmop_" + id + "_" + new_num).on("click", function (evt) {
            console.log(this.value);
            $("#remcmop_" + id + "_" + new_num).hide();
            $(this).hide();
            var obj = new controlCustomerAdd();
            obj.addModeOfPayment(this.value, new_num, mop);
        });
        $("#cust_mod_pay_" + new_num).on("change", function () {
            var obj = new controlCustomerAdd();
            obj.ShowTextBox(new_num, this.value);
        });
        $('#keycodes').text(new_num);
        bindKeyupFee(new_num);
    };
    /*Address fields*/
    this.bindAddressFields = function (addres, add) {
        var list = this.countries;
        $(add.country).autocomplete({
            minLength: 2,
            source: list,
            autoFocus: true,
            select: function (event, ui) {
                window.setTimeout(function () {
                    $(add.country).val(ui.item.label);
                    $(add.country).attr('name', ui.item.value);
                    add.countryCode = ui.item.countryCode;
                    add.PCR_reg = ui.item.PCR;
                    dccode = ui.item.Phone;
                    $(cn.codep + '0').val(ui.item.Phone);
                    for (i = 0; i <= cn.num; i++) {
                        $(document.getElementById(cn.codep + i)).val(ui.item.Phone);
                    }
                    addres.setCountry(ui.item);
                    $(add.state).val('');
                    $(add.state).focus();
                }, 50);
                $(add.state).focus(function () {
                    this.states = addres.getState();
                    var list = this.states;
                    $(add.state).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.state).val(ui.item.label);
                                $(add.state).attr('name', ui.item.value);
                                add.provinceCode = ui.item.provinceCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setState(ui.item);
                                $(add.district).val('');
                                $(add.district).focus();
                            }, 50);
                        }
                    });
                });
                $(add.district).focus(function () {
                    this.districts = addres.getDistrict();
                    var list = this.districts;
                    $(add.district).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.district).val(ui.item.label);
                                $(add.district).attr('name', ui.item.value);
                                add.districtCode = ui.item.districtCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setDistrict(ui.item);
                                $(add.city_town).val('');
                                $(add.city_town).focus();
                            }, 50);
                        }
                    });
                });
                $(add.city_town).focus(function () {
                    this.cities = addres.getCity();
                    var list = this.cities;
                    $(add.city_town).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.city_town).val(ui.item.label);
                                $(add.city_town).attr('name', ui.item.value);
                                add.city_townCode = ui.item.city_townCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setCity(ui.item);
                                $(add.st_loc).val('');
                                $(add.st_loc).focus();
                            }, 50);
                        }
                    });
                });
                $(add.st_loc).focus(function () {
                    this.localities = addres.getLocality();
                    var list = this.localities;
                    $(add.st_loc).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.st_loc).val(ui.item.label);
                                $(add.st_loc).attr('name', ui.item.value);
                                add.st_locCode = ui.item.st_locCode;
                                add.lat = ui.item.lat;
                                add.lon = ui.item.lon;
                                add.timezone = ui.item.timezone;
                                addres.setLocality(ui.item);
                            }, 200);
                        }
                    });
                });
            }
        });
    };
    function checkUserInEnquiry() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'checkuserinenq',
                id: gymid,
                gymid: gymid,
                cellnum: $(cinfo.ccellnum).val(),
                type: 'slave'
            },
            success: function (data) {
                var data1 = $.parseJSON($.trim(data));
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    if (data1.status == "success") {
                        $(cinfo.name).val(data1.name);
                        $(cinfo.cemail).val(data1.email);
                    } else {
                        $(cinfo.name).val('');
                        $(cinfo.cemail).val('');
                    }
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    ;
    function bindKeyupFee(new_num) {
        for (i = 1; i <= new_num; i++) {
            $('#cust_fee_mop_' + i).on("keyup", function () {
                $(this).val(Number($(this).val()));
                var amt = Number($(this).val());
                $(this).val(Number(amt));
                if (amt < 0) {
                    $(this).val(0);
                }
            });
        }
    }
    function fetchmodeofpayment() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'ModeOfPaymentselect',
                id: gymid,
                gymid: gymid,
                type: 'slave'
            },
            success: function (data) {
                data1 = $.parseJSON($.trim(data));
                if (data == 'logout')
                    logoutAdmin({});
                else {
                    mopname["htm"] = '';
                    mopname["textbox"] = [];
                    mopname["id"] = [];
                    textboxval = '';
                    for (p = 0; p < data1.length; p++) {
                        mopname["htm"] += data1[p]["html"];
                        mopname["textbox"][p] = data1[p]["mopname"];
                        mopname["id"][p] = data1[p]["id"];
                        if ((mopname["textbox"][p].toLowerCase()) != "cash")
                            textboxval += '<input name="mod_number_1_1" type="text" placeholder="' + mopname["textbox"][p] + ' Number" id="mopctext_' + mopname["id"][p] + '_1" class="form-control" style="display:none;"/>';
                    }
                    $(cn.selectBox).append(mopname["htm"]);
                    $(cn.textBox).append(textboxval);
                    $(cn.mopAdd).on("click", function () {
                        var obj = new controlCustomerAdd();
                        obj.addModeOfPayment(this.value, 1, mopname);
                    });
                    $(cn.selectBox).on("change", function () {
                        var obj = new controlCustomerAdd();
                        obj.ShowTextBox(1, this.value);
                    });
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    function setcustGym() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'setGYM',
                id: gymid,
                type: 'master',
                gymid: gymid
            },
            success: function (data) {
                console.log('gym id = ' + data);
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    var htmll = '<strong><span class="text-danger"></span> Person who referred the customer to join ' + data + ' :<i class="fa fa-caret-down fa-fw"></i></strong>';
                    $(cust.outDiv).html(htmll);
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    ;
    function modeofpaymentcust() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'modeofPayment',
                id: gymid,
                type: 'slave',
                gymid: gymid
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(cust.mofpayment).html(data);
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    ;
    function fetchfacilitytype() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'getallfact',
                id: gymid,
                type: 'slave',
                gymid: gymid
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(cinfo.custfact).html(data);
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    ;
    function fetchgenderType() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'cust_sex',
                id: gymid,
                type: 'master',
                gymid: gymid
            },
            success: function (data) {
                console.log(data);
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(cust.custsexParent).html(data);
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    ;
    function AddCDummyEmail() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'AddCDummyEmail',
                type: 'master',
                gymid: gymid
            },
            success: function (data) {
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $("#emer_email").val(data);
                        $("#memail").html(VALIDNOT);
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    function initializeProfileAddForm() {
        $(cn.plus + ',' + em.plus).unbind();
        $(cn.plus).click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            $(cn.plus).hide();
            bulitMultipleCellNumbers();
        });
        $(em.plus).click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            $(em.plus).hide();
            bulitMultipleEmailIds();
        });
    }
    ;
    function initializefeerow() {
        $(fp.plus).click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            $(fp.plus).hide();
            bulitMultiplefeeForm();
        });
    }
    ;
    function bulitMultiplefeeForm() {
        var id = $(DGYM_ID).attr('name');
        if (fp.num == 1) {
            $(fp.parentdiv).html('');
        }
        fp.num++;
        var html = '<div class="col-lg-12" id="' + fp.addfeeform + fp.num + fp.num + '">' +
                '<div class="col-lg-12" id="' + fp.addfeeform + fp.num + '">' +
                '<strong><span id="user_fee_msg_temp_' + fp.num + '">*</span>Fee <i class="fa fa-caret-down"></i></strong>' +
                '</div><div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '<div class="form-group">' +
                '<div class="col-md-4" id="mod_pay_temp_' + fp.num + '">' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input name="user_fee_" type="text" id="' + cust.fee_input + fp.num + '" class="form-control"/>' +
                '<div class="col-md-12" id="' + cust.number_box + fp.num + '"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-4">' +
                '<button type="button" class="btn btn-danger  btn-md" id="' + fp.minus + fp.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-success  btn-md" id="' + fp.plus + fp.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' + '</div>' +
                '</div>';
        $(fp.parentdiv).append(html);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'modeofPayment',
                id: id,
                type: 'slave',
                gymid: id
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $('#mod_pay_temp_' + fp.num).html(data);
                    var v1 = $('#mod_pay_temp_' + fp.num + ' :selected').text();
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        $('#mod_pay_temp_' + fp.num).on('change', function () {
            var v1 = $('#mod_pay_temp_' + fp.num + ' :selected').text();
            if (v1 == "Cash")
                var html = '';
            else
                var html = '' + '<input name="mod_number_temp_' + fp.num + '" type="text" placeholder="Enter the ' + v1 + ' number" id="mode_payment_' + fp.num + '" class="form-control" width="30" />';
            $("#" + cust.number_box + fp.num).html(html);
        });
        window.setTimeout(function () {
            $(document.getElementById(fp.minus + fp.num)).click(function () {
                $(document.getElementById(fp.plus + fp.num)).hide();
                $(document.getElementById(fp.minus + fp.num)).hide();
                $(document.getElementById(fp.addfeeform + fp.num)).hide();
                $(document.getElementById(fp.addfeeform + fp.num + fp.num)).hide();
                fp.num--;
                if (fp.num == 1) {
                    $(fp.plus).show();
                    $(fp.parentdiv).html('');
                } else {
                    $(document.getElementById(fp.plus + fp.num)).show();
                    $(document.getElementById(fp.minus + fp.num)).show();
                }
            });
            $(document.getElementById(fp.plus + fp.num)).click(function () {
                $(document.getElementById(fp.plus + fp.num)).hide();
                $(document.getElementById(fp.minus + fp.num)).hide();
                bulitMultiplefeeForm();
            });
        }, 200);
    }
    ;
    function addcustomerAutoComplete() {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'autoCompleteEnq',
                type: 'slave',
                gymid: gymid
            },
            success: function (data, textStatus, xhr) {
                data = $.parseJSON($.trim(data));
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        listofPeoples = data.listofPeoples;
                        $referred = $(cust.referBox);
                        $referred.autocomplete({
                            minLength: 0,
                            source: listofPeoples,
                            focus: function (event, ui) {
                                $referred.val(ui.item.label);
                                return false;
                            },
                            select: function (event, ui) {
                                $referred.val(ui.item.label);
                                $referred.attr('name', ui.item.id);
                                return false;
                            },
                        });
                        $referred.data("ui-autocomplete")._renderItem = function (ul, item) {
                            var $li = $('<li>'),
                                    $img = $('<img>');
                            $img.attr({
                                src: item.icon,
                                alt: item.label,
                                width: "30px",
                                height: "30px"
                            });
                            $li.attr('data-value', item.label);
                            $li.append('<a href="#">');
                            $li.find('a').append($img).append(item.label);
                            return $li.appendTo(ul);
                        };
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
            /* success over*/
        });
    }
    function customerAdd() {
        $(cust.reciept).html('');
        var attr = validateCustomerFields();
        if (attr) {
            // $(cinfo.saveBtn).prop('disabled', 'disabled');
            $(loader).html(LOADER_SIX);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'customerAdd',
                    type: 'slave',
                    gymid: gymid,
                    eadd: attr
                },
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(loader).hide();
                            $(cinfo.msg).html('<h2>Record success fully added</h2>');
                            $(cinfo.form).get(0).reset();
                            $("#photo_id").val(data.user_id);
                            $(cust.reciept).html('<a href="' + data.url + '" target="_blank">Print Receipt.</a>');
                            window.setTimeout(function () {
                                $(cinfo.phupload).trigger('click');
                            }, 2000);
                            break;
                    }
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                    window.setTimeout(function () {
                        $(cinfo.msg).html('');
                    }, 2000);
                    $(cinfo.saveBtn).removeAttr('disabled');
                }
            });
        } else {
            $(cinfo.saveBtn).removeAttr('disabled');
        }
    }
    function checkValidValue() {
        var em = $(cinfo.cemail).val();
        var valid_scc = $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: 'true',
                action: 'checkEmailEmp',
                type: 'master',
                gymid: gymid,
                email: em,
                empid: "cust"
            },
            success: function (data) {
                data = $.parseJSON($.trim(data));
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
        var valid_scc = $.trim(valid_scc.responseText);
        return valid_scc;
    }
    function validateCustomerFields() {
        var amount = new Array();
        var sum_amount = 0;
        var mod_pay = new Array();
        var transaction_type = '';
        var transaction_number = new Array();
        var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
        var amount_reg = /^[0-9]{0,10}$/;
        var flag = false;
        var sex = custsex;
        var ftype = ftype1;
        var max_mop = Number($('#keycodes').text());
        var dateofjoin = convertDateFormat($(cinfo.doj).val());
        for (i = 1; i <= max_mop; i++) {
            amount[i] = $('#cust_fee_mop_' + i).val();
            if (amount[i].match(amount_reg)) {
                $('#user_fee_msg_' + i).html(VALIDNOT);
                sum_amount += Number(amount[i]);
                flag = true;
            } else {
                $('#user_fee_msg_' + i).html(INVALIDNOT);
                flag = false;
                return;
            }
            mod_pay[i] = $('#cust_mod_pay_' + i).select().val();
            if (mod_pay[i] != 'NULL') {
                $('#user_fee_msg_' + i).hide();
            } else {
                $('#user_fee_msg_' + i).show();
                flag = false;
            }
            /* Cheque number, PDC number, Card number */
            if (mod_pay[i] != 'NULL') {
                transaction_number[i] = $('#mopctext_' + mod_pay[i + 1] + '_' + i).val();
                $('#mod_msg_' + i).html(VALIDNOT);
                flag = true;
            } else {
                $('#mod_msg_' + i).html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($('#mod_msg_' + i).offset().top) - 55
                }, "slow");
                flag = false;
                return;
                /* transaction_number[i] = "Cash"; */
            }
        }
        /* refer mname */
        if (($(cinfo.referBox).val()) != '' && ($(cinfo.referBox).val()) != 'NULL') {
            flag = true;
            $(cinfo.mrefer).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.mrefer).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.mrefer).offset().top) - 55
            }, "slow");
            $(cinfo.refer).focus();
            return;
        }
        /* Email */
        var temp1 = checkValidValue();
        if (temp1 === 'true') {
            if (($(cinfo.cemail).val()) != '' && ($(cinfo.cemail).val()) != 'NULL' && ($(cinfo.cemail).val().match(email_reg))) {
                flag = true;
                $("#emmsg").html(VALIDNOT);
            } else {
                flag = false;
                $("#emmsg").html(INVALIDNOT);
                $('html, body').animate({
                    scrollTop: Number($(cinfo.memail).offset().top) - 55
                }, "slow");
                $(cinfo.cemail).focus();
                return;
            }
        } else if (temp1 === 'false') {
            flag = false;
            $("#emmsg").html("<strong class='text-danger'>Email Already Taken</strong>");
            $('html, body').animate({
                scrollTop: Number($("#emmsg").offset().top) - 95
            }, "slow");
            $(cinfo.cemail).focus();
            return;
        }
        /* name */
        if ($(cinfo.name).val().replace(/  +/g, ' ').match(nm_reg)) {
            flag = true;
            $(cinfo.nmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.nmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.nmsg).offset().top) - 55
            }, "slow");
            $(cinfo.name).focus();
            return;
        }
        /* sex type*/
        if (custsex != 'NULL' && custsex != '') {
            flag = true;
            $(cinfo.smsg).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.smsg).html('<strong class="text-danger">Select sex type.</strong>');
            $('html, body').animate({
                scrollTop: Number($(cinfo.smsg).offset().top) - 95
            }, "slow");
            return;
        }
        /* country */
        /*
         if ($(cinfo.country).val().replace(/  +/g, ' ').match(nm_reg)) {
         flag = true;
         $(cinfo.mcountry).html(VALIDNOT);
         } else {
         flag = false;
         $(cinfo.mcountry).html(INVALIDNOT);
         $('html, body').animate({
         scrollTop : Number($(cinfo.mcountry).offset().top) - 95
         }, "slow");
         $(cinfo.addplus).trigger('click');
         $(cinfo.country).focus();
         return;
         }
         country */
        /* provice */
        /*
         if ($(cinfo.state).val().replace(/  +/g, ' ').match(nm_reg)) {
         flag = true;
         $(cinfo.mstate).html(VALIDNOT);
         } else {
         flag = false;
         $(cinfo.mstate).html(INVALIDNOT);
         $('html, body').animate({
         scrollTop : Number($(cinfo.mstate).offset().top) - 95
         }, "slow");
         $(cinfo.addplus).trigger('click');
         $(cinfo.state).focus();
         return;
         }
         provice */
        /* distrinct */
        /*
         if ($(cinfo.district).val().replace(/  +/g, ' ').match(nm_reg)) {
         flag = true;
         $(cinfo.mdistrict).html(VALIDNOT);
         } else {
         flag = false;
         $(cinfo.mdistrict).html(INVALIDNOT);
         $('html, body').animate({
         scrollTop : Number($(cinfo.mdistrict).offset().top) - 95
         }, "slow");
         $(cinfo.addplus).trigger('click');
         $(cinfo.district).focus();
         return;
         }
         distrinct */
        /* ZipCode*/
        /*
         var PCR_reg = /^[0-9]*$/;
         if ($(cinfo.zipcode).val().match(PCR_reg)) {
         flag = true;
         $(cinfo.mzipcode).html(VALIDNOT);
         } else {
         flag = false;
         $(cinfo.mzipcode).html(INVALIDNOT);
         $('html, body').animate({
         scrollTop : Number($(cinfo.mzipcode).offset().top) - 95
         }, "slow");
         $(cinfo.addplus).trigger('click');
         $(cinfo.zipcode).focus();
         return;
         }
         ZipCode*/
        if (dateofjoin) {
            flag = true;
            $(cinfo.mdoj).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.mdoj).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.mdoj).offset().top) - 95
            }, "slow");
            $(cinfo.doj).focus();
            return;
        }
        /* Emergency Name */
        if ($(cinfo.ename).val().replace(/  +/g, ' ').match(nm_reg)) {
            flag = true;
            $(cinfo.memnm).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.memnm).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.memnm).offset().top) - 95
            }, "slow");
            $(cinfo.emnm).focus();
            return;
        }
        /* Emergency Number */
        if ($(cinfo.enumber).val().match(cell_reg)) {
            flag = true;
            $(cinfo.memnum).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.memnum).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.memnum).offset().top) - 95
            }, "slow");
            $(cinfo.emnum).focus();
            return;
        }
        /*~ if(($(cinfo.cemail).val()) != '' && ($(cinfo.cemail).val()) != 'NULL' && ($(cinfo.cemail).val().match(email_reg)) ){*/
        /*~ flag = true;*/
        /*~ $(cinfo.memail).html(VALIDNOT);*/
        /*~ }*/
        /*~ else{*/
        /*~ flag = false;*/
        /*~ $(cinfo.memail).html(INVALIDNOT);*/
        /*~ $('html, body').animate({scrollTop: Number($(cinfo.memail).offset().top)-55}, "slow");*/
        /*~ $(cinfo.cemail).focus();*/
        /*~ return;*/
        /*~ }*/
        /* cell code */
        if (($(cinfo.ccellcode).val()) != '' && ($(cinfo.ccellcode).val()) != 'NULL') {
            flag = true;
            $(cinfo.mcellcd).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.mcellcd).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.mcellcd).offset().top) - 55
            }, "slow");
            $(cinfo.ccellcode).focus();
            return;
        }
        /* Cell Number */
        if (($(cinfo.ccellnum).val()) != '' && ($(cinfo.ccellnum).val()) != 'NULL') {
            flag = true;
            $(cinfo.mcell).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.mcell).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.mcell).offset().top) - 55
            }, "slow");
            $(cinfo.ccellnum).focus();
            return;
        }
        /* occupation */
        if (occup != 'NULL') {
            flag = true;
            $(cinfo.occupationmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(cinfo.occupationmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(cinfo.mcomp).offset().top) - 55
            }, "slow");
            $(cinfo.occupationmsg).focus();
            return;
        }
        /*~ /* company */
        /*~ if(($(cinfo.company).val().replace(/  +/g, ' ').match(nm_reg)) && ($(cinfo.company).val()) != '' && ($(cinfo.company).val()) != 'NULL' ){*/
        /*~ flag = true;*/
        /*~ $(cinfo.mcomp).html(VALIDNOT);*/
        /*~ }*/
        /*~ else{*/
        /*~ flag = false;*/
        /*~ $(cinfo.mcomp).html(INVALIDNOT);*/
        /*~ $('html, body').animate({scrollTop: Number($(cinfo.mcomp).offset().top)-55}, "slow");*/
        /*~ $(cinfo.mcomp).focus();*/
        /*~ return;*/
        /*~ }*/
        /* dob */
        /* doj */
        /* Address Line */
        /*~ if($(cinfo.address).val().replace(/  +/g, ' ').match(nm_reg)){*/
        /*~ flag = true;*/
        /*~ $(cinfo.maddress).html(VALIDNOT);*/
        /*~ }*/
        /*~ else{*/
        /*~ flag = false;*/
        /*~ $(cinfo.maddress).html(INVALIDNOT);*/
        /*~ $('html, body').animate({scrollTop: Number($(cinfo.maddress).offset().top)-95}, "slow");*/
        /*~ $(cinfo.maddress).focus();*/
        /*~ return;*/
        /*~ }*/
        /* town */
        /*~ if($(cinfo.city_town).val().replace(/  +/g, ' ').match(nm_reg)){*/
        /*~ flag = true;*/
        /*~ $(cinfo.mcity_town).html(VALIDNOT);*/
        /*~ }*/
        /*~ else{*/
        /*~ flag = false;*/
        /*~ $(cinfo.mcity_town).html(INVALIDNOT);*/
        /*~ $('html, body').animate({scrollTop: Number($(cinfo.mcity_town).offset().top)-95}, "slow");*/
        /*~ $(cinfo.mcity_town).focus();*/
        /*~ return;*/
        /*~ }*/
        var attr = {
            max_mop: max_mop,
            amount: amount,
            sum_amount: sum_amount,
            mod_pay: mod_pay,
            transaction_number: transaction_number,
            name: $(cinfo.name).val(),
            email: $(cinfo.cemail).val(),
            cellcode: $(cinfo.ccellcode).val(),
            cellnum: $(cinfo.ccellnum).val(),
            occu: occup,
            dob: convertDateFormat($(cinfo.dob).val()),
            sex_type: custsex,
            doj: convertDateFormat($(cinfo.doj).val()),
            emnm: $(cinfo.ename).val(),
            emnum: $(cinfo.enumber).val(),
            addr: $(cinfo.address).val(),
            town: $(cinfo.city_town).val(),
            city: $(cinfo.city_town).val(),
            district: $(cinfo.district).val(),
            province: $(cinfo.state).val(),
            country: $(cinfo.country).val(),
            company: $(cinfo.company).val(),
        };
        /*alert(attr.province);*/
        if (flag) {
            return attr;
        } else
            return false;
    }
    ;
    function photoUpload(id) {
        var id = id;
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                autoloader: true,
                action: 'customerPhotoUpload',
                type: 'master',
                gymid: gymid,
                id: id
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                /*console.log(data);*/
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(cinfo.form).html(data);
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
}
;
