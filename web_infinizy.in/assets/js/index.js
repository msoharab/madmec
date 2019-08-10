$(document).ready(function () {
    var formflag = false;
    var loginformflag = false;
    var contactformflag = false;
    var smsflag = false;

    $('#sendmessage').keyup(function () {
        if ($(this).val().length > 160)
        {
            $(this).val($(this).val().substring(0, $(this).val().length - 1))
        }
        $("#count").text("Characters left: " + (160 - $(this).val().length));
    });

    var formdata = $(this).serialize();
    $("#regiserform").validate({
        rules: {
            username: "required",
            cellnum: "required",
            address: "required",
            password: {
                required: true,
                minlength: 5,
                maxlength: 25
            },
            email: {
                required: true,
                email: true
            }

        },
        submitHandler: function () {
            formflag = true;
        }
    });

    $("#regiserform").submit(function () {
        var formdata = $(this).serialize();
        if (formflag)
        {
            $('#regiserformbtn').prop('disabled', 'disabled');
            $.ajax({
                url: "register.php",
                type: 'POST',
                data: formdata + '&action=register&autoloader=true',
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    if (data)
                    {
                        alert("We Have successfully recieved your Request,, Will get back to you soon");
                        $("#regiserform").get(0).reset();
                        formflag = false;
                    }
                },
                error: function (data) {
                    alert("Internet Connection Error");
                },
                complete: function (data, textStatus, xhr) {
                    $('#regiserformbtn').removeAttr('disabled');
                }
            });
        }
    });

    $("#loginform").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 4
            }
        },
        submitHandler: function () {
            loginformflag = true;
        }
    });

    $("#loginform").submit(function () {
        var formdata = $(this).serialize();
        if (loginformflag) {
            $('#loginformbtn').prop('disabled', 'disabled');

            $.ajax({
                type: 'post',
                url: 'register.php',
                data: formdata + '&action=login&autoloader=true',
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    var data = $.trim(data);
                    if (data == "success") {
                        alert("You Have successfully logged in! ");
                        window.location.href = "sms.php";
                    }
                    else
                    {
                        alert("Username and Password Incorrect");
                    }
                },
                error: function (data) {
                    alert("Internet Connection Error");
                },
                complete: function (data, textStatus, xhr) {
                    $('#loginformbtn').removeAttr('disabled');
                }
            });
        }
    });

    $("#smsform").validate({
        submitHandler: function () {
            smsflag = true;
        }
    });

    $("#smsform").submit(function () {
        var formdata = $(this).serialize();
        if (smsflag) {
            $('#Sendmessagebtn').prop('disabled', 'disabled');

            $.ajax({
                type: 'post',
                url: 'register.php',
                data: formdata + '&action=sms&autoloader=true',
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    var data = $.trim(data);
                    if (data == "success") {
                        alert("SMS has been Sent ");
                        $("#smsform").get(0).reset();
                        formflag = false;
                        $("#count").text("Characters left: 0");
                    }
                    else if (data == "completed")
                    {
                        alert("You have already sent 5 SMS ");
                        $("#smsform").get(0).reset();
                        formflag = false;
                        $("#count").text("Characters left: 0");
                    }
                },
                error: function (data) {
                    alert("Internet Connection Error");
                },
                complete: function (data, textStatus, xhr) {
                    $('#Sendmessagebtn').removeAttr('disabled');
                }
            });
        }
    });

    $("#contactform").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            cell_no: {
                required: true,
                number: true,
            },
            company_name: {
                required: true,
            },
        },
        submitHandler: function () {
            contactformflag = true;
        }
    });

    $("#contactform").submit(function () {
        var formdata = $(this).serialize();
        if (contactformflag)
        {
            $('#Sendmessagebtn').prop('disabled', 'disabled');
            $.ajax({
                url: "register.php",
                type: 'POST',
                data: formdata + '&action=contact&autoloader=true',
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    if (data)
                    {
                        alert("Successfully recieved your contact details  ,, Will get back to you soon");
                        $("#contactform").get(0).reset();
                        contactformflag = false;
                    }
                },
                error: function (data) {
                    alert("Internet Connection Error");
                },
                complete: function (data, textStatus, xhr) {
                    $('#Sendmessagebtn').removeAttr('disabled');
                }
            });
        }
    });

});