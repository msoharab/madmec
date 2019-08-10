function controlReceiptReport() {
    receipt = {};
    var outputDivRec = " ";
    var gymid = $(DGYM_ID).attr("name");
    this.__construct = function (receipt) {
        receipt = receipt;
        outputDivRec = receipt.outputDivRec;
        htmlDiv = receipt.htmlDiv;
        $("html , body").animate({
            scrollTop: 0
        }, "fast");
        DisplayReceipt();
        $(receipt.receiptbut).bind('click', function () {
            SearchReceiptReport();
        });
        $("#by_date").datepicker({
            dateFormat: 'dd-M-yy',
            changeMonth: true,
            changeYear: true,
            altField: '#alternate_1',
            altFormat: 'DD, d MM, yy',
            maxDate: 0,
            yearRange: '2014:' + (new Date).getFullYear() + ''
        });
    };
    function SearchReceiptReport() {
        var by_name_o_email = $('#by_name_o_email').val() ? $('#by_name_o_email').val() : "";
        var by_date = convertDateFormat($('#by_date').val()) ? $convertDateFormat(('#by_date').val()) : "";
        if (by_name_o_email.length > 0 || by_date.length > 0) {
            $.ajax({
                url: receipt.url,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'search_rec_list',
                    type: 'slave',
                    gymid: gymid,
                    by_name_o_email: by_name_o_email,
                    by_date: by_date
                },
                success: function (data) {
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $('#rec_output_load').html("");
                            $("#rec_output").html(data);
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
    function DisplayReceipt() {
        $(receipt.outputrec).html(LOADER_SIX);
        $('#output_load').html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
        var header = '<table class="table table-striped table-bordered table-hover" id="list_receipt_table"><thead><tr><th>#</th><th>Name</th><th class="text-right">Email Id</th><th class="text-right">Amount</th><th class="text-right">Receipt Number</th></tr></thead>';
        var footer = '</table>';
        $.ajax({
            url: receipt.url,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'DisplayReceipt',
                type: 'slave',
                gymid: gymid,
                list_type: 'all'
            },
            success: function (data) {
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
                        $('#rec_output_load').html("");
                        $("#rec_output").html(header + data + footer);
                        window.setTimeout(function () {
                            $('#list_receipt_table').DataTable({});
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
;
