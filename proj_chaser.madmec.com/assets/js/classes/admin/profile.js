function changePassword()
{
    var adddonorform = false;
    var ctrl = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        /*  Validating Fields  */
        $(ctrl.form).validate({
            rules: {
                cpassword: {
                    required: true,
                    minlength: 4
                },
                npassword: {
                    required: true,
                    minlength: 4
                },
                cfpassword: {
                    required: true,
                    minlength: 4,
                    equalTo: "#npassword"
                },
            },
            messages: {
                cpassword: {
                    required: "Enter the Currernt Password",
                    minlength: "Length Should be minimum 6 Characters"
                },
                npassword: {
                    required: "Enter the Currernt Password",
                    minlength: "Length Should be minimum 6 Characters"
                },
                cfpassword: {
                    required: "Enter the Confirm Password",
                    minlength: "Length Should be minimum 6 Characters",
                    equalTo: "Password Not Matches"
                },
            },
            submitHandler: function () {
                adddonorform = true;
            }
        });
        $(ctrl.form).submit(function (evt) {
            evt.preventDefault();
            var formdata = $(this).serialize();
            if (adddonorform)
                changePassword(formdata);
        });

    };
    function changePassword(formdata)
    {
        $(ctrl.but).prop('disabled', 'disabled');
        $.ajax({
            type: 'POST',
            url: ctrl.url,
            data: formdata + '&autoloader=true&action=adminProfile/changeCurrentPassword',
            success: function (data, textStatus, xhr) {
                /*                                        console.log(data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var data = $.parseJSON(data);
                        if (data == "success")
                        {
                            alert("Password has been Successfully Changed");
                            $(ctrl.form).get(0).reset();
                            window.setTimeout(function () {
                                window.location.href = "index.php";
                            }, 1000)
                        }
                        else if (data == "notmatch") {
                            alert("Current Password n't matches");
                            $('#cpassword').focus();
                        }
                        else
                        {
                            alert("Password hasn't been Changed");
                            $(ctrl.form).get(0).reset();
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $(ctrl.but).removeAttr('disabled');
            }
        });
    }
}

