function loginform() {
    var Formflag = false;
    $("#login-form").validate({
        rules:
                {
                    password: {
                        required: true,
                    },
                    name: {
                        required: true,
                        name: true
                    },
                },
        messages:
                {
                    password: {
                        required: "please enter your password"
                    },
                    name: "please enter your user name",
                },
        submitHandler: function () {
            Formflag = true;
        }
    });
    /* validation */

    $("#login-form").submit(function () {
        var formdata = $("#login-form").serialize();
        if (Formflag)
        {
            $('#submit').prop('disabled', 'disabled');
            $.ajax({
                url: AJAX_URL,
                type: 'POST',
                data: formdata + '&action=signIn&autoloader=true',
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    if (data)
                    {
                        alert("Successfully Logged In");
                        $("#login-form").get(0).reset();
                        Formflag = false;
                    }
                },
                error: function (data) {
                    alert('Error in internet connection !!!');
                },
                complete: function (data, textStatus, xhr) {
                    $('#submit').removeAttr('disabled');
                }
            });
        }
    });
}
function bindContatForm() {
    var contactFormflag = false;
    $("#contactForm").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                number: true,
            },
            subject: {
                required: true,
            }
        },
        submitHandler: function () {
            contactFormflag = true;
        }
    });
    $("#contactForm").submit(function () {
        var formdata = $("#contactForm").serialize();
        console.log(formdata);
        if (contactFormflag)
        {
            $('#messagebtn').prop('disabled', 'disabled');
            $.ajax({
                url: AJAX_URL,
                type: 'POST',
                data: 'action=messages&autoloader=true&'+formdata,
                //data: 'action=messages&autoloader=true',
                async:false,
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    if (data)
                    {
                        alert("Successfully recieved your contact details  , Will get back to you soon");
                        $("#contactForm").get(0).reset();
                        contactFormflag = false;
                    }
                },
                error: function (data) {
                    alert('Error in internet connection !!!');
                },
                complete: function (data, textStatus, xhr) {
                    $('#messagebtn').removeAttr('disabled');
                }
            });
        }
    });
}
