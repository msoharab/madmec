function auto_msg(msg) {
    setTimeout("$('#dynamic_div').html('<a href=\" " + URL + " \" style=\" text-decoration:none;\"><div class=\"menu_option\" align=\"center\" style=\"font-size:24px;\" >Menu</div></a><br><strong style=\"color:#FFF;font-weight:bold;\">" + msg + "</strong>');", 100);
    $.ajax({
        url: 'destory_session.php',
        success: function (data) {
            window.location.replace(URL);
        }
    });
}
/*specific to schedule.html*/
function prev_month(mm, yy) {
    if (mm <= 0) {
        --yy;
        mm = 12;
    }
    $("#calendar").calendarWidget({
        month: --mm,
        year: yy
    });
}
function next_month(mm, yy) {
    if (mm >= 11) {
        ++yy;
        mm = -1;
    }
    $("#calendar").calendarWidget({
        month: ++mm,
        year: yy
    });
}
function validate_pass() {
    var pass1 = $("#password1").val();
    var pass2 = $("#password2").val();
    if (pass1 != pass2) {
        $("#pass2_err").css('display', 'inline');
    } else {
        $("#pass2_err").css('display', 'none');
    }
}
$(document).ready(function () {
    var hg = $("#middle_fg_panel").css('height');
    $("#middle_bg_panel").css('height', hg);
});
