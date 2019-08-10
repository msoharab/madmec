function controlStaffPay() {
    var gymid = $(DGYM_ID).attr("name");
    pay = {};
    this.__construct = function (payment) {
        pay = payment;
        $(pay.paydate).datepicker({
            dateFormat: "dd-M-yy",
            changeYear: true,
            changeMonth: true,
            yearRange: "date('Y'):(date('Y')+2)"
        });
        $(pay.paydate).datepicker("setDate", "date('dd-M-yy')");
        addEnqAutoComplete();
        $(pay.btn).bind('click', function (evt) {
            validatePaymentDetails();
        });
    }
    function addEnqAutoComplete() {
        console.log("fun called");
        $.ajax({
            url: pay.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'autoCompletePay',
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
                        $referred = $("#" + pay.payname);
                        $referred.on('click, focus', function () {
                            $(this).val('');
                        });
                        window.setTimeout(function () {
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
                                    class: "img-circle"
                                });
                                $li.attr('data-value', item.label);
                                $li.append('<a href="#">');
                                $li.find('a').append($img).append(item.label);
                                return $li.appendTo(ul);
                            };
                        }, 800);
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
    function validatePaymentDetails() {
        var usr_id = $("#" + pay.payname).attr('name');
        var name = $("#" + pay.payname);
        var amount = $("#" + pay.amt);
        var pay_date = convertDateFormat($(pay.paydate).val());
        var description = $('#' + pay.dec).val();
        description = description.replace(/\n/g, "<br />").replace(/\r\n/g, "<br />").replace(/\r/g, "<br />");
        /*var amount_reg = /^[1-9][0-9]{1,10}$/;*/
        var amount_reg = /[0-9]+(?:\.[0-9]*)?/;
        var flag = true;
        if (name.val() != "") {
            flag = true;
            $("#pnm_msg").html(VALIDNOT);
        } else {
            flag = false;
            $("#pnm_msg").html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($("#pnm_msg").offset().top) - 95
            }, "slow");
            name.focus();
            return;
        }
        if (amount.val().match(amount_reg)) {
            flag = true;
            $("#pamt_msg").html(VALIDNOT);
        } else {
            flag = false;
            $("#pamt_msg").html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($("#pamt_msg").offset().top) - 95
            }, "slow");
            amount.focus();
            return;
        }
        if (description != "") {
            flag = true;
            $("#pdec_msg").html(VALIDNOT);
        } else {
            flag = false;
            $("#pdec_msg").html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($("#pdec_msg").offset().top) - 95
            }, "slow");
            $('#' + pay.dec).focus();
            return;
        }
        if (flag) {
            var stfpay = {
                name: name.val(),
                usr_id: usr_id,
                amount: amount.val(),
                pay_date: pay_date,
                description: description,
            };
            console.log(stfpay);
            $(loader).html(LOADER_SIX);
            $.ajax({
                url: pay.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'AddPayments',
                    type: 'slave',
                    gymid: gymid,
                    stfpay: stfpay
                },
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            data = $.parseJSON($.trim(data));
                            $(pay.alertbody).html(data.msg);
                            $(pay.alert).trigger('click');
                            $(pay.form).get(0).reset();
                            $(loader).html('');
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
}
;
