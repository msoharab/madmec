var loader = "#loader";
function controlAccountFee() {
    var gymid = $(DGYM_ID).attr("name");
    var ac = {};
    var list_type = '';
    this.__construct = function (account) {
        if ("htm" in account)
            ac = account.ac;
        else
            ac = account;
        if (ac.list_type == "offer" && !("htm" in account))
            loadFeeTab();
        if (ac.list_type == "package" && !("htm" in account))
            loadFeeTab();
        if (ac.list_type == "due" && !("htm" in account))
            loadFeeTab();
    }
    this.dynamicOffer = function (obj) {
        $(obj.loadoffer).html(LOADER_SIX);
        $.ajax({
            url: ac.url,
            type: 'POST',
            data: {
                autoloader: obj.autoloader,
                action: obj.action,
                type: obj.type,
                gymid: gymid,
                id: obj.id,
                fid: obj.fid
            },
            success: function (data) {
                switch (data) {
                    case "logout":
                        logoutAdmin();
                        break;
                    default:
                        $(obj.printoffer).html(data);
                        $(obj.loadoffer).html('');
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
    this.fetchExpAndDue = function (obj) {
        var id = obj.id;
        var fid = obj.fid;
        $.ajax({
            url: ac.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'fetchExpAndDue',
                type: 'slave',
                gymid: gymid,
                id: id,
                fid: fid
            },
            success: function (data) {
                var listusers = $.parseJSON($.trim(data));
                switch (data) {
                    case "logout":
                        logoutAdmin();
                        break;
                    default:
                        dueamt = '';
                        duedate = '';
                        expdate = '';
                        htm = '';
                        if (listusers) {
                            for (i = 0; i < listusers.length; i++) {
                                if (i == 0) {
                                    htm += "<div class='col-lg-6'><div class='well well-sm'><span><strong>Offer Name:</strong><span style='color:blue';>" + listusers[i]["offer_name"] + "</span></br><strong>Due Amount:</strong><span style='color:red';>" + listusers[i]["due_amt"] + "</span></br><strong>Due Date:</strong><span style='color:blue';>" + listusers[i]["due_date"] + "</span></br><strong>Expire Date:</strong><span style='color:blue';>" + listusers[i]["valid_till"] + "</span></span></div></div>";
                                } else {
                                    htm += "<div class='col-lg-6'><div class='well well-sm'><span><strong>Offer Name:</strong><span style='color:blue';>" + listusers[i]["offer_name"] + "</span></br><strong>Due Amount:</strong><span style='color:red';>" + listusers[i]["due_amt"] + "</span></br><strong>Due Date:</strong><span style='color:blue';>" + listusers[i]["due_date"] + "</span></br><strong>Expire Date:</strong><span style='color:blue';>" + listusers[i]["valid_till"] + "</span></span></div></div>";
                                }
                                /*htm += "<strong style='color:red';>Due Amount:</strong>&nbsp;"+listusers[i]["due_amt"]+"<strong>Due Date:</strong>&nbsp;"+listusers[i]["due_date"]+"<strong>Expire Date:</strong>&nbsp;"+listusers[i]["valid_till"]+"<br />";*/
                            }
                        } else {
                            htm += "<div class='col-lg-12'><div class='well well-sm'><hr></hr><h4>Not Applied for this facility</h4></div></div>";
                        }
                        $('#facilitybody_' + id).html(htm);
                        // $('#expDueClick' + id).click();
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
    this.addModeOfPayment = function (id, num, mop) {
        var new_num = num + 1;
        $texbox = '';
        /*
         for(i=1;i< new_num;i++){
         $('#user_fee_'+id +'_'+i).attr("readonly","readonly");
         }
         */
        for ($p = 0; $p <= mop.textbox.length; $p++) {
            if (mop.textbox[$p] != "Cash")
                $texbox += '<input name="mod_number_' + id + '_' + new_num + '" type="text" placeholder="' + mop.textbox[$p] + ' Number"    id="mop' + mop.id[$p] + '_' + id + '_' + new_num + '"    class="form-control" style="display:none;"  />';
        }
        $('#add_mop_' + id).append('<div class="col-lg-12"  id="usr_fee_row_' + id + '_' + new_num + '">' +
                '<div class="col-lg-6">' +
                '<div class="col-lg-6">' +
                '<strong>Mode Of Payment : <i class="fa fa-caret-down"></i></strong>' +
                '<select name="mod_pay" id="mod_pay_' + id + '_' + new_num + '" class="form-control">' +
                '<option value="NULL" selected>Select Mode Of Payment</option>' + mop.htm + '</select>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<span id="user_fee_msg_' + id + '_' + new_num + '" style="display:none; color:#FF0000; font-size:25px;">*</span>' +
                '<strong>Amount Paid : <i class="fa fa-caret-down"></i></strong>' +
                '<input name="user_fee" type="number" value="0" id="user_fee_' + id + '_' + new_num + '" class="form-control"/>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-6">' +
                '<div class="col-lg-6"><strong>&nbsp;</strong>' + $texbox + '</div>' +
                '<div class="col-lg-6"><strong>&nbsp;</strong>' +
                '<a id="addmop_' + id + '_' + new_num + '" class="btn btn-success " href="javascript:void(0);"><i class="fa fa-plus  "></i></a> ' +
                '<a id="remmop_' + id + '_' + new_num + '" class="btn btn-danger " href="javascript:void(0);"><i class="fa fa-minus "></i></a>' +
                '</div>' +
                '</div>' +
                '</div>');
        $("#remmop_" + id + "_" + new_num).on("click", function () {
            var tot = Number($("#keycodes_" + id).text());
            tot -= 1;
            if (tot < 1) {
                $("#keycodes_" + id).text(1);
            } else {
                $("#keycodes_" + id).text(tot);
            }
            $("#remmop_" + id + "_" + num).show();
            $("#addmop_" + id + "_" + num).show();
            $("#usr_fee_row_" + id + "_" + new_num).remove();
            /* $('#user_fee_'+id +'_'+num).removeAttr("readonly"); */
        });
        $("#addmop_" + id + "_" + new_num).on("click", function (evt) {
            $("#remmop_" + id + "_" + new_num).hide();
            $(this).hide();
            var obj = new controlAccountFee();
            obj.addModeOfPayment(id, new_num, mop);
        });
        $("#mod_pay_" + id + "_" + new_num).on("change", function () {
            var jsonobj = {
                num: new_num,
                id: id
            };
            var obj = new controlAccountFee();
            obj.ShowTextBox(jsonobj);
        });
        $('#keycodes_' + id).text(new_num);
        for (i = 1; i <= new_num; i++) {
            $('#user_fee_' + id + '_' + i).bind("keyup", function () {
                /* var new_num = Number($('#keycodes_' + id).text()); */
                var tot_amt = Number($('#amount_tot_' + id).val());
                $(this).val(Number($(this).val()));
                var amt = Number($(this).val());
                var bamt = Number($("#bal_amount_" + id).val());
                $(this).val(amt);
                var tot_ent_amt = 0;
                for (j = 1; j <= new_num; j++) {
                    tot_ent_amt += Number($('#user_fee_' + id + '_' + j).val());
                }
                if (amt < 0) {
                    $(this).val(0);
                }
                if ((tot_ent_amt) > tot_amt) {
                    $(this).val(0);
                }
                var due = Number(tot_amt - tot_ent_amt);
                if (due >= 0) {
                    $("#bal_amount_" + id).val(Number(due));
                } else {
                    $("#bal_amount_" + id).val(0);
                }
            });
        }
        /*
         $("#bal_amount_" + id).bind("keyup", function () {
         var tot_amt = Number($('#amount_tot_'+id).val());
         var amt = Number($(this).val());
         $(this).val(amt);
         var tot_ent_amt = 0;
         for(j=1;j<= new_num;j++){
         tot_ent_amt += Number($('#user_fee_'+id +'_'+j).val());
         }
         if(amt < 0){
         $(this).val(0);
         }
         if(tot_ent_amt > tot_amt){
         $(this).val(0);
         }
         else{
         $(this).val(Number(tot_amt - tot_ent_amt));
         }
         });
         */
    }
    this.ShowTextBox = function (obj) {
        var num = obj.num;
        var id = obj.id;
        $("input[name='mod_number_" + id + "_" + num + "']").each(function () {
            $(this).hide();
        });
        var mopval = $('#mod_pay_' + id + '_' + num).select().val();
        $('#mop' + mopval + '_' + id + '_' + num).show();
    }
    this.AddIndividualFee = function (obj) {
        var id = obj.id;
        var num = obj.num;
        var list_type = obj.list_type;
        $(window).unbind();
        $(window).scroll(function (event) {
            event.preventDefault();
        });
        var joining_date = convertDateFormat($('#joindate_' + id).val());
        var total = $('#amount_tot_' + id).val();
        var facility = $('#faclity_' + id).val();
        var email = $('#email_' + id).val();
        var offer = $('#offer_' + id).select().val();
        var max_mop = Number($('#keycodes_' + id).text());
        var amount = new Array();
        var sum_amount = 0;
        var mod_pay = new Array();
        var transaction_type = '';
        /* cheque number, PDC number, Card number */
        var transaction_number = new Array();
        var due_amt = Number($('#bal_amount_' + id).val());
        var due_date = convertDateFormat($('#duedate_' + id).val());
        var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
        var amount_reg = /^[0-9]{0,10}$/;
        var flag = true;
        if (facility != 'NULL') {
            $('#faclity_msg' + id).hide();
        } else {
            $('#faclity_msg' + id).show();
            flag = false;
        }
        if (offer != 'NULL') {
            $('#offer_msg' + id).hide();
            transaction_type = (offer) ? $('#offer_' + id + ' option:selected').html() : 'Gym fee'
        } else {
            $('#offer_msg' + id).show();
            flag = false;
        }
        for (i = 1; i <= max_mop; i++) {
            if ($('#user_fee_' + id + '_' + i).length) {
                amount[i] = $('#user_fee_' + id + '_' + i).val();
                if (amount[i].match(amount_reg)) {
                    $('#user_fee_msg_' + id + '_' + i).hide();
                    sum_amount += Number(amount[i]);
                } else {
                    $('#user_fee_msg_' + id + '_' + i).show();
                    flag = false;
                }
                mod_pay[i] = $('#mod_pay_' + id + '_' + i).select().val();
                if (mod_pay[i] != 'NULL') {
                    $('#user_fee_msg_' + id + '_' + i).hide();
                } else {
                    $('#user_fee_msg_' + id + '_' + i).show();
                    flag = false;
                }
                /* cheque number, PDC number, Card number */
                if (mod_pay[i] != 'NULL') {
                    transaction_number[i] = $('#mod_pay_' + id + '_' + i).val();
                }
            }
        }
        if (total.match(amount_reg)) {
            $('#amt_msg' + id).hide();
        } else {
            $('#amt_msg' + id).show();
            flag = false;
        }
        if (joining_date.match(/(\d{4})-(\d{2})-(\d{2})/)) {
            $('#joindate_msg' + id).hide();
        } else {
            $('#joindate_msg' + id).show();
            flag = false;
        }
        total = Number($('#amount_tot_' + id).val()) - due_amt;
        total1 = Number($('#amount_tot_' + id).val());
        amount.shift();
        transaction_number.shift();
        mod_pay.shift();
        sum_amount += due_amt;
        if (sum_amount != total1 || total < 0 || total > sum_amount) {
            alert("Total Amount does not match with the individual amount !!!");
            flag = false;
        }
        if (due_amt > 0) {
            if (due_date.match(/(\d{4})-(\d{2})-(\d{2})/)) {
                $('#duedate_msg_' + id).hide();
            } else {
                $('#duedate_msg_' + id).show();
                flag = false;
            }
        }
        $('#output_load').hide();
        if (flag) {
            var payfee = {
                id: id,
                num: num,
                offer: offer,
                total: total,
                joining_date: joining_date,
                amount: amount,
                transaction_number: transaction_number,
                transaction_type: transaction_type,
                mod_pay: mod_pay,
                due_amt: due_amt,
                due_date: due_date,
                list_type: list_type,
                newfacility: $("#faclity_" + id + " option:selected").val(),
            };
            $('#receipt_show').html(LOADER_SIX);
            $.ajax({
                type: 'POST',
                url: ac.url,
                data: {
                    autoloader: true,
                    action: 'AddIndividualFee',
                    type: 'slave',
                    gymid: gymid,
                    indfee: payfee
                },
                success: function (data, textStatus, xhr) {
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            data = $.parseJSON($.trim(data));
                            $('#output_load').show();
                            $('#receipt_show').html(data.msg);
                            window.setTimeout(function () {
                                $("#print_invoice_" + id).bind("click", function () {
                                    /*PayIndividualUserForm(id,num);*/
                                    window.open(data.rcpturl);
                                });
                            }, 300);
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
    this.AddIndividualFeeDue = function (obj) {
        var id = obj.id;
        var num = obj.num;
        var list_type = obj.list_type;
        var total = $('#amount_tot_' + id).val();
        var max_mop = Number($('#keycodes_' + id).text());
        var amount = new Array();
        var sum_amount = 0;
        var mod_pay = new Array();
        var transaction_type = 'Due payment';
        /* cheque number, PDC number, Card number */
        var transaction_number = new Array();
        var due_amt = Number($('#bal_amount_' + id).val());
        var due_date = $('#duedate_' + id).val();
        var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
        var amount_reg = /^[0-9]{0,10}$/;
        var flag = true;
        for (i = 1; i <= max_mop; i++) {
            if ($('#user_fee_' + id + '_' + i).length) {
                amount[i] = $('#user_fee_' + id + '_' + i).val();
                if (amount[i].match(amount_reg)) {
                    $('#user_fee_msg_' + id + '_' + i).hide();
                    sum_amount += Number(amount[i]);
                } else {
                    $('#user_fee_msg_' + id + '_' + i).show();
                    flag = false;
                }
                mod_pay[i] = $('#mod_pay_' + id + '_' + i).select().val();
                if (mod_pay[i] != 'NULL') {
                    $('#user_fee_msg_' + id + '_' + i).hide();
                } else {
                    $('#user_fee_msg_' + id + '_' + i).show();
                    flag = false;
                }
                /* cheque number, PDC number, Card number */
                if (mod_pay[i] != 'NULL') {
                    transaction_number[i] = $('#mod_pay_' + id + '_' + i).val();
                }
            }
        }
        if (total.match(amount_reg)) {
            $('#amt_msg' + id).hide();
        } else {
            $('#amt_msg' + id).show();
            flag = false;
        }
        total1 = Number($('#amount_tot_' + id).val());
        amount.shift();
        transaction_number.shift();
        mod_pay.shift();
        if (sum_amount > total1) {
            alert("Total Amount does not match with the individual amount !!!");
            flag = false;
        }
        if (flag) {
            var payfee = {
                id: id,
                num: num,
                total: sum_amount,
                amount: amount,
                transaction_number: transaction_number,
                transaction_type: transaction_type,
                mod_pay: mod_pay,
                list_type: list_type
            };
            $('#receipt_show').html(LOADER_SIX);
            $.ajax({
                type: 'POST',
                url: ac.url,
                data: {
                    autoloader: true,
                    action: 'AddIndividualFee',
                    type: 'slave',
                    gymid: gymid,
                    indfee: payfee
                },
                success: function (data, textStatus, xhr) {
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            data = $.parseJSON($.trim(data));
                            $('#output_load').show();
                            $('#userdetails_' + id).html(data.msg);
                            window.setTimeout(function () {
                                $("#print_invoice_" + id).bind("click", function () {
                                    window.open(data.rcpturl);
                                });
                            }, 300);
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
    };
    this.SetIndivisualAmt = function (obj, id, num) {
        var textofopt = new String();
        var offer_id = $(obj).select().val();
        var max_mop = Number($('#keycodes_' + id).text());
        if (offer_id != 'NULL') {
            textofopt = obj.options[obj.selectedIndex].text;
            textofopt = textofopt.split("-");
            var amt = textofopt[textofopt.length - 1];
            for (i = 2; i <= max_mop; i++) {
                $('#remmop_' + id + '_' + i).click();
            }
            amt = $.trim(amt)
            $('#user_fee_' + id + '_1').val(amt);
            $('#amount_tot_' + id).val(amt);
            $('#bal_amount_' + id).val('0');
        } else {
            max_mop = Number($('#keycodes_' + id).text());
            $('#bal_amount_' + id).val('0');
            $('#amount_tot_' + id).val('0');
            for (i = 1; i <= max_mop; i++) {
                $('#user_fee_' + id + '_' + i).val('0');
            }
        }
    }
    this.AddGroupFee = function (id, num) {
        var joining_date = convertDateFormat($('#joindate_' + id).val());
        var total = $('#amount_tot_' + id).val();
        var email = $('#email_' + id).val();
        var own_pk1 = $('#email_' + id).attr('name');
        own_pk1 = own_pk1.split("_");
        var own_pk = own_pk1["1"];
        var name = $('#group_name_' + id).val();
        var offer = $('#offer_' + id).select().val();
        var max_mop = Number($('#keycodes_' + id).text());
        var amount = new Array();
        var sum_amount = 0;
        var mod_pay = new Array();
        var transaction_type = '';
        /* cheque number, PDC number, Card number */
        var transaction_number = new Array();
        var due_amt = Number($('#bal_amount_' + id).val());
        var due_date = convertDateFormat($('#duedate_' + id).val());
        var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
        var amount_reg = /^[0-9]{0,10}$/;
        var payee = 1;
        var flag = true;
        for (i = 1; i <= max_mop; i++) {
            if ($('#user_fee_' + id + '_' + i).length) {
                amount[i] = $('#user_fee_' + id + '_' + i).val();
                if (amount[i].match(amount_reg)) {
                    $('#user_fee_msg_' + id + '_' + i).hide();
                    sum_amount += Number(amount[i]);
                } else {
                    $('#user_fee_msg_' + id + '_' + i).show();
                    flag = false;
                }
                mod_pay[i] = $('#mod_pay_' + id + '_' + i).select().val();
                if (mod_pay[i] != 'NULL') {
                    $('#user_fee_msg_' + id + '_' + i).hide();
                } else {
                    $('#user_fee_msg_' + id + '_' + i).show();
                    flag = false;
                }
                /* cheque number, PDC number, Card number */
                if (mod_pay[i] != 'NULL') {
                    transaction_number[i] = $('#mop' + mod_pay[i] + '_' + id + '_' + i).val();
                }
            }
        }
        if (total.match(amount_reg)) {
            $('#amt_msg_' + id).hide();
        } else {
            $('#amt_msg_' + id).show();
            flag = false;
        }
        if (joining_date.match(/(\d{4})-(\d{2})-(\d{2})/)) {
            $('#joindate_msg_' + id).hide();
        } else {
            $('#joindate_msg_' + id).show();
            flag = false;
        }
        if (offer != 'NULL') {
            $('#offer_msg' + id).hide();
            transaction_type = (offer) ? $('#offer_' + id + ' option:selected').html() : 'Fee'
        } else {
            $('#offer_msg' + id).show();
            flag = false;
        }
        total = Number($('#amount_tot_' + id).val()) - due_amt;
        total1 = Number($('#amount_tot_' + id).val());
        amount.shift();
        transaction_number.shift();
        mod_pay.shift();
        sum_amount += due_amt;
        if (sum_amount != total1 || total < 0 || total > sum_amount) {
            alert("Total Amount does not match with the individual amount !!!");
            flag = false;
        }
        if (due_amt > 0) {
            if (due_date.match(/(\d{4})-(\d{2})-(\d{2})/)) {
                $('#duedate_msg_' + id).hide();
            } else {
                $('#duedate_msg_' + id).show();
                flag = false;
            }
        }
        if (flag) {
            var grppara = {
                id: id,
                num: num,
                email: email,
                name: name,
                offer: offer,
                total: total,
                joining_date: joining_date,
                amount: amount,
                transaction_number: transaction_number,
                transaction_type: transaction_type,
                mod_pay: mod_pay,
                due_amt: due_amt,
                due_date: due_date,
                payee: payee,
                ac: ac,
                newfacility: $("#faclity_" + id + " option:selected").val(),
                own_pk: own_pk,
            }
            /*$('#receipt_show').html(LOADER_SIX);*/
            $.ajax({
                type: 'POST',
                url: ac.url,
                data: {
                    autoloader: true,
                    action: 'AddGroupFee',
                    type: 'slave',
                    gymid: gymid,
                    grpfee: grppara
                },
                success: function (data, textStatus, xhr) {
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            data = $.parseJSON($.trim(data));
                            $('#output_load').show();
                            $('#receipt_show').html(data.msg);
                            window.setTimeout(function () {
                                $("#print_invoice_" + id).bind("click", function () {
                                    window.open(data.rcpturl);
                                });
                            }, 300);
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
    function loadFeeTab() {
        var rad = '<option value="NULL" selected>Select Facility</option>';
        ;
        $(loader).html(LOADER_SIX);
        var acc = ac;
        $.ajax({
            type: 'POST',
            url: acc.url,
            data: {
                autoloader: true,
                action: 'fetchInterestedIn',
                type: 'slave',
                gymid: gymid
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var fee = $.parseJSON($.trim(data));
                        for (i = 0; i < fee.length; i++) {
                            rad += '<option value="' + fee[i]["id"] + '">' + fee[i]["html"] + '</option>';
                        }
                        var para1 = {
                            list_type: acc.list_type,
                            ac: acc,
                            foption: rad,
                        }
                        $s1 = '<span class="pull-left" id="listUser"><a href="javascript:void(0);" class="btn btn-primary btn-xs" id="list_customer_fee">List Customers</a>' +
                                '<input type="hidden" id="fact_type" value="0"/>' +
                                '<input type="hidden" id="list_type" value="' + para1.list_type + '"/></span>';
                        /*
                         if (para1.list_type != "due")
                         $s1 += '<span class="pull-right" id="listGroup"><a href="javascript:void(0);" class="btn btn-primary btn-xs" id="list_group_fee">List Groups</a></span>';
                         */
                        $(acc.smenu).html($s1);
                        $("#list_customer_fee").on('click', function (evt) {
                            $(acc.grpoutput).html('');
                            $(acc.grpoutput).hide();
                            $(acc.output).show();
                            displayFeeUserList(para1);
                        });
                        $("#list_group_fee").on('click', function (evt) {
                            $(acc.output).html('');
                            $(acc.output).hide();
                            $(acc.grpoutput).show();
                            DisplayListGroups(para1);
                        });
                        displayFeeUserList(para1);
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
    function displayFeeUserList(para) {
        $(ac.output).html(LOADER_SIX);
        $.ajax({
            url: ac.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'feeUserList',
                type: 'slave',
                gymid: gymid,
                fee: para
            },
            success: function (data) {
                var json = $.parseJSON($.trim(data));
                switch (data) {
                    case "logout":
                        logoutAdmin();
                        break;
                    default:
                        $(ac.output).html(json.parentHtml);
                        $(loader).html('');
                        if (json.flag == true) {
                            list_type = json.list_type;
                            $(json.textInputId).on('focus, click', function (evt) {
                                $(this).val('');
                                $(json.parentHtmlId).html('');
                            });
                            $(json.textInputId).autocomplete({
                                minLength: 1,
                                source: json.data,
                                autoFocus: true,
                                select: function (event, ui) {
                                    $(json.parentHtmlId).html(ui.item.offerHtml);
                                    window.setTimeout(function () {
                                        $(json.textInputId).val(ui.item.label);
                                    }, 300);
                                    /* var filterJson = json.data.filter(function(el){ return el.label != ui.item.label; }); */
                                    /* $(this).autocomplete("option","source",filterJson); */
                                    return false;
                                    /* json.flag */
                                    /* json.parentHtmlId */
                                    /* ui.item.textInputId */
                                    /* ui.item.label */
                                    /* ui.item.value */
                                    /* ui.item.offerHtmlId */
                                }
                            });
                        }
                        /*
                         $(window).scroll(function (event) {
                         if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
                         displayFeeUpdateList(para);
                         else
                         $(loader).html('');
                         });
                         */
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
    function DisplayListGroups(para) {
        console.log(para);
        $(ac.grpoutput).html(LOADER_SIX);
        $.ajax({
            url: ac.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'DisplayListGroups',
                type: 'slave',
                gymid: gymid,
                fee: para
            },
            success: function (data) {
                console.log(data);
                var json = $.parseJSON($.trim(data));
                switch (data) {
                    case "logout":
                        logoutAdmin();
                        break;
                    default:
                        console.log(ac);
                        $(ac.grpoutput).html(json.parentHtml);
                        $(loader).html('');
                        if (json.flag == true) {
                            $(json.textInputId).on('focus, click', function (evt) {
                                $(this).val('');
                                $(json.parentHtmlId).html('');
                            });
                            $(json.textInputId).autocomplete({
                                minLength: 1,
                                source: json.data,
                                autoFocus: true,
                                select: function (event, ui) {
                                    $(json.parentHtmlId).html(ui.item.offerHtml);
                                    window.setTimeout(function () {
                                        $(json.textInputId).val(ui.item.label);
                                    }, 300);
                                    var filterJson = json.data.filter(function (el) {
                                        return el.label != ui.item.label;
                                    });
                                    $(this).autocomplete("option", "source", filterJson);
                                    return false;
                                    /* json.flag */
                                    /* json.parentHtmlId */
                                    /* ui.item.textInputId */
                                    /* ui.item.label */
                                    /* ui.item.value */
                                    /* ui.item.offerHtmlId */
                                }
                            });
                        }
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
    function displayPackageUserList() {
        $(ac.output).html(LOADER_SIX);
        var para = {
            list_type: ac.list_type,
            ac: ac,
        }
        $.ajax({
            url: ac.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'feeUserList',
                type: 'slave',
                gymid: gymid,
                fee: para
            },
            success: function (data) {
                switch (data) {
                    case "logout":
                        logoutAdmin();
                        break;
                    default:
                        $s1 = '<span class="pull-left" id="listUser"><a href="javascript:void(0);" class="btn btn-primary btn-xs" id="list_customer_fee">List Customers</a>';
                        $(ac.smenu).html($s1);
                        $(ac.output).html(data);
                        $(loader).html('');
                        $("#list_customer_fee").bind('click', function (evt) {
                            displayPackageUserList();
                        });
                        $(window).scroll(function (event) {
                            if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
                                displayPackageUpdateList(para);
                            else
                                $(loader).html('');
                        });
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
    function PayPackageUserForm(uid, num) {
        $(window).unbind();
        $(window).scroll(function (event) {
            event.preventDefault();
        });
        var payform = {
            uid: uid,
            num: num,
            list_type: list_type
        };
        $('#receipt_show').html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: ac.url,
            data: {
                autoloader: true,
                action: 'PayPackageUserForm',
                type: 'slave',
                gymid: gymid,
                payform: payform
            },
            success: function (data, textStatus, xhr) {
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $('#receipt_show').html(data);
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
