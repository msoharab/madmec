function admin_login() {
    console.log("hello");
    var user_id = $.trim($("#user_id").val());
    var password = $.trim($("#password").val());
    var browser = navigator.userAgent;
    if (user_id && password) {
        $("input,a").each(function () {
            $(this).attr("disabled", "disabled");
        });
        $(".page-header").html("<img class=\"img-circle\" src=\"" + URL + ASSET_IMG + "spinner_grey_120.gif\" border=\"0\" width=\"60\" height=\"60\" />");
        $.ajax({
            url: window.location.href,
            type: "POST",
            data: {
                action: "admin_login",
                "user_id": user_id,
                "password": password,
                "browser": browser
            },
            success: function (data) {
                console.log(data);
                data = $.parseJSON($.trim(data));
                if (data["flag"] == "success" && data["type"] == "Admin") {
                    $("#login_msg").removeClass("text-danger").addClass("text-success").html("Login Success  Hurray!!!<br />Please while we redirect.");
                    $(".page-header").parent().removeClass('text-default');
                    $(".page-header").parent().removeClass('text-danger');
                    $(".page-header").parent().addClass('text-success');
                    $(".page-header").html('<i class="fa fa-unlock fa-x2 fa-fw"></i>&nbsp;Administrator');
                    window.setTimeout(function () {
                        window.location.href = URL + ADMIN + "control.php";
                    }, 400);
                } else if (data["flag"] == "success" && data["type"] == "Customer") {
                    $("#login_msg").removeClass("text-danger").addClass("text-success").html("Login Success  Hurray!!!<br />Please while we redirect.");
                    $(".page-header").parent().removeClass('text-default');
                    $(".page-header").parent().removeClass('text-danger');
                    $(".page-header").parent().addClass('text-success');
                    $(".page-header").html('<i class="fa fa-unlock fa-x2 fa-fw"></i>&nbsp;Administrator');
                    window.setTimeout(function () {
                        window.location.href = URL + "Customer.php";
                    }, 400);
                } else if (data["flag"] == "success" && data["type"] == "Trainer") {
                    $("#login_msg").removeClass("text-danger").addClass("text-success").html("Login Success  Hurray!!!<br />Please while we redirect.");
                    $(".page-header").parent().removeClass('text-default');
                    $(".page-header").parent().removeClass('text-danger');
                    $(".page-header").parent().addClass('text-success');
                    $(".page-header").html('<i class="fa fa-unlock fa-x2 fa-fw"></i>&nbsp;Administrator');
                    window.setTimeout(function () {
                        window.location.href = URL + "Trainer.php";
                    }, 400);
                } else if (data["type"] == "") {
                    $(".page-header").parent().removeClass('text-default');
                    $(".page-header").parent().addClass('text-danger');
                    $(".page-header").html('<i class="fa fa-lock fa-x2 fa-fw"></i>&nbsp;Administrator');
                    $("#login_msg").addClass("text-danger").html("Email Id or password u have enter is incorrect please try agian.");
                    $("input,a").each(function () {
                        $(this).removeAttr("disabled");
                    });
                }
            }
        });
    } else {
        $("#login_msg").addClass("text-danger").html("Please enter your id and password");
        $("input,a").each(function () {
            $(this).removeAttr("disabled");
        });
    }
}
;
