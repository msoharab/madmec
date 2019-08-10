function show_screen1() {
    $('#screen1').show();
    $('#screen2').hide();
}
function show_screen2() {
    $('#screen1').hide();
    $('#screen2').show();
}
function report_form() {
    $('#load_box').show();
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'report_form'},
        success: function (data) {
            //alert(data);
            show_screen2();
            $('#screen2').html(data);
            $('#load_box').hide();
        }
    });
}


function report_status() {
    var email = $("#email_report").val();
    var pass = $("#password_report").val();
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'function_login_report_sheet', email: email, pass: pass},
        success: function (data) {
            if (data == "valid") {
                $("#report").show();
                $("#formclass").hide();
            }
            else {
                $("#passauth").html("<h3> This information is not valid<h3>");
            }
        }
    });
}
function gen_report() {
    var from = $("#from").val();
    var to = $("#to").val();
    if (to < from)
    {
        tempvalid = false;
        alert("Invalid Date");
        return;
    }
    else
    {
        tempvalid = true;
    }
    if (!isValidDate(from))
        alert("From Date is invalid");
    else if (!isValidDate(to))
        alert("To Date is invalid");
    else if (isValidDate(to) && isValidDate(from)) {
        if (tempvalid)
        {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {action: 'gen_report', 'from': from, 'to': to},
                success: function (data) {
                    //alert(data);
                    show_screen2();
                    $('#screen2').html(data);
                    $('#load_box').hide();
                }
            });
        }
    }
}
function isValidDate(subject) {
    if (subject.match(/^(?:(0[1-9]|[12][0-9]|3[01])[\- \/.](0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$/)) {
        return true;
    } else {
        return false;
    }
}
$(document).ready(function () {
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {action: 'checkBalanceSheet'},
        success: function (data) {
            if (data == "allow") {
                $("#formclass").show();
            }
            else {
                $("#report").show();
                //$("#error_msg").html("<h1> This facility not supported<h1>");
            }
        }
    });
});
