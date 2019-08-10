function accounts() {
    var accdetails = {};
    this.__construct = function (accdetailsctrl) {
        accdetails = accdetailsctrl;
        fetchRegdNumbers();
        $(accdetails.payments.paymentbutt).on('click', function () {
            addPayment();
        });
        $(accdetails.payment_menubut).on('click', function () {
            $(accdetails.payments.addpaymentform).get(0).reset();
        });
        $(accdetails.payments.paymentregdno).on('keyup', function () {
            var regno = $(accdetails.payments.paymentregdno).val();
            $(accdetails.payments.paymentregdno).val(regno.toUpperCase());
        });
        $(accdetails.paymenthistory.paymenthisregdno).on('keyup', function () {
            var regno = $(accdetails.paymenthistory.paymenthisregdno).val();
            $(accdetails.paymenthistory.paymenthisregdno).val(regno.toUpperCase());
        });
        $(accdetails.payments.paymentamountpay).on('keyup', function () {
            var regno = Number($(accdetails.payments.paymentamountpay).val()) ? Number($(accdetails.payments.paymentamountpay).val()) : 0;
            $(accdetails.payments.paymentamountpay).val(regno);
        });
        
    }
    function fetchRegdNumbers()
    {
        $.ajax({
            type: 'POST',
            url: accdetails.url,
            data: {
                autoloader: true,
                action: 'fetchregdnumber',
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
                        var details = $.parseJSON(data);
                        var regdno = new Array();
                        var drivernames = new Array();
                        var drivermobiles = new Array();
                        var passmobiles = new Array();
                        var passnames = new Array();
                        var passaddress = new Array();
                        var dueamount = new Array();
                        var lastpaid = new Array();
                        var amountpaid = new Array();
                        if ((details.regdno).length)
                        {
                            for (i = 0; i < (details.regdno).length; i++)
                            {
                                // regdno[i]=details.regdno[i];
                                // drivernames[i]=details.drivernames[i];
                                // drivermobiles[i]=details.drivermobiles[i];

                                /* Soharab code */
                                regdno.push({
                                    label: $.trim(details.regdno[i]),
                                    value: $.trim(details.regdno[i]),
                                    name: $.trim(details.drivernames[i]),
                                    num: $.trim(details.drivermobiles[i]),
                                    driverid: $.trim(details.driverid[i]),
                                    due: $.trim(details.dueamount[i]),
                                    amountpaid: $.trim(details.amountpaid[i]),
                                    lastpaid: $.trim(details.lastpaid[i])
                                });
                                /* Soharab code */
                            }
                            $(accdetails.payments.paymentregdno).autocomplete({
                                source: regdno,
                                /* Soharab code */
                                select: function (event, ui) {
                                    //													  accdetails.drivercheck=1;
                                    $(accdetails.payments.paymentdrivername).val(ui.item.name);
                                    $(accdetails.payments.paymentdrivermobile).val(ui.item.num);
                                    $(accdetails.payments.paymentamountpaid).val(ui.item.amountpaid);
                                    $(accdetails.payments.paymentpaiddate).val(ui.item.lastpaid);
                                    $(accdetails.payments.paymentdueamount).val(ui.item.due);
                                    accdetails.payments.driverid = ui.item.driverid;
                                    var dueobj = $(accdetails.payments.paymentdueamount);
                                    var dueamt = Number($.trim(dueobj.val()));
                                    $(accdetails.payments.paymentamountpay).bind('keyup', {dueobj: dueobj, dueamt: dueamt}, function (evt) {
                                        var dueobj = evt.data.dueobj;
                                        var dueamt = evt.data.dueamt;
                                        var payamt = Number($.trim($(this).val()));
                                        var balamt = 0;
                                        console.log(dueamt);
                                        console.log(payamt);
//                                                                                                                    if(dueamt > payamt && dueamt > 0){
//                                                                                                                            $(this).val(payamt);
//                                                                                                                            balamt = Number(dueamt - payamt);
//                                                                                                                            dueobj.val(balamt);
//                                                                                                                    }
//                                                                                                                    else if (dueamt < 0){
//                                                                                                                            dueobj.val(dueamt);
//                                                                                                                    }
//                                                                                                                    else if (payamt < 0){
//                                                                                                                            $(this).val(0);
//                                                                                                                    }
                                    });
                                }
                                /* Soharab code */
                            });
                            $(accdetails.paymenthistory.paymenthisregdno).autocomplete({
                                source: regdno,
                                /* Soharab code */
                                select: function (event, ui) {
                                    //													  accdetails.drivercheck=1;
                                    $(accdetails.paymenthistory.paymenthisdrivername).val(ui.item.name);
                                    $(accdetails.paymenthistory.paymenthisdrivermobile).val(ui.item.num);
                                    accdetails.paymenthistory.driverid = ui.item.driverid;
                                    fetchPaymenthistory(accdetails.paymenthistory.driverid);
                                }
                                /* Soharab code */
                            });
                            /* shakeel code commented
                             $(billdetails.regdno).change(function (){
                             for(j=0;j<(details.regdno).length;j++)
                             {
                             if(details.regdno[j]== $(billdetails.regdno).val())
                             {
                             billdetails.drivercheck=1;
                             $(billdetails.drivername).val(drivernames[j]) ;
                             $(billdetails.drivermobile).val(drivermobiles[j]) ;
                             billdetails.driverid=details.driverid[j];
                             }
                             }
                             
                             })  ;   
                             */
                        }
                        break;
                }
            },
            error: function () {

            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function fetchPaymenthistory(driverid)
    {
        $(accdetails.paymenthistory.displaypaymenthistory).html(LOADER_FUR);
        $.ajax({
            type: 'POST',
            url: accdetails.url,
            data: {
                autoloader: true,
                action: 'fetchpaymenthistory',
                driverid: driverid,
            },
            success: function (data, textStatus, xhr) {
                console.log(data)
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default :
                        var details = $.parseJSON(data);
                        var tableheader = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="paymenthistory-dataTable">';
                        var tableheading = '<thead><tr><th>#</th><th>Amount Paid</th><th>Date</th><th>Remark</th></tr></thead><tbody>';
                        var tablefooter = '</tbody></table>';
                        if (details.status == "success")
                        {
                            $(accdetails.paymenthistory.displaypaymenthistory).html(tableheader + tableheading + details.data + tablefooter);
                            window.setTimeout(function () {
                                $('#paymenthistory-dataTable').DataTable();
                            }, 500)
                        }
                        else
                        {
                            $(accdetails.paymenthistory.displaypaymenthistory).html('');
                        }
                }
            },
            error: function () {
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function addPayment()
    {
        var flag = false;
        if ($(accdetails.payments.paymentdueamount).val() == "")
        {
            $(accdetails.payments.paymentdueamount).focus();
            flag = false;
            return
        }
        else
        {
            flag = true;
        }
        if ($(accdetails.payments.paymentamountpay).val() == "'" || !$(accdetails.payments.paymentamountpay).val().match(amount_reg))
        {
            $(accdetails.payments.paymentamountpay).focus();
            $(accdetails.payments.paymentamountpaymsg).html(INVALIDNOT);
            flag = true;
            return;
        }
        else
        {
            flag = true;
            $(accdetails.payments.paymentamountpaymsg).html(VALIDNOT);
        }
        if ($(accdetails.payments.paymentamountpay).val() > $(accdetails.payments.paymentdueamount).val())
        {
            $(accdetails.payments.paymentamountpay).focus();
            $(accdetails.payments.paymentamountpaymsg).html(INVALIDNOT);
            flag = true;
            return;
        }
        else
        {
            flag = true;
            $(accdetails.payments.paymentamountpaymsg).html(VALIDNOT);
        }
        if ($(accdetails.payments.paymentremark).val() == "")
        {
            $(accdetails.payments.paymentremark).focus();
            $(accdetails.payments.paymentremarkmsg).html(INVALIDNOT);
            flag = true;
            return;
        }
        else
        {
            flag = true;
            $(accdetails.payments.paymentremarkmsg).html(VALIDNOT);
        }
        if (flag)
        {
            $(accdetails.payments.paymentbut).hide();
            var attr = {
                driverid: accdetails.payments.driverid,
                amount: $(accdetails.payments.paymentamountpay).val(),
                remark: $(accdetails.payments.paymentremark).val(),
            };
            $.ajax({
                type: 'POST',
                url: accdetails.url,
                data: {
                    autoloader: true,
                    action: 'addpayment',
                    details: attr,
                },
                success: function (data, textStatus, xhr) {
                    console.log(data)
                    data = $.trim(data);
                    console.log(xhr.status);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default :
                            var details = $.parseJSON(data);
                            if (details)
                            {
                                alert("Payment Sucessfull");
                                $(accdetails.payments.addpaymentform).get(0).reset();
                                $(accdetails.payments.paymentbut).show();
                                fetchRegdNumbers();
                            }
                            else
                            {
                                alert("Payment Failure");
                                $(accdetails.payments.paymentbut).show();
                                fetchRegdNumbers();
                            }
                    }
                },
                error: function () {
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
    }
}


