function languagesController() {
    var members = {};
    var listOfLanguages = {};
    this.__constructor = function (para) {
        members = para;
        window.setTimeout(function () {
            ListBusinesss();
        }, 100);
        $(members.create.form).validate({
            rules: {
                ex4: {
                    required: true,
                    minlength: 4
                },
                ex5: {
                    required: true
                },
            },
            messages: {
                ex4: {
                    required: "Enter the Business Name",
                    minlength: "Length Should be minimum 4 Characters"
                },
                ex5: {
                    required: "Select target",
                },
            },
            submitHandler: function () {
                submitCreate = true;
            }
        });
        $(members.create.form).submit(function () {
            createBusiness();
        });
    };
    function listLanguages() {
        var mem = members.countries;
        $.ajax({
            url: mem.url,
            type: mem.type,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action
            },
            success: function (data, textStatus, xhr) {
                listOfLanguages = $.parseJSON(data);
                if (listOfLanguages.status == "success") {
                    var htm = '';
                    for (i = 0; i < listOfLanguages.data.length; i++) {
                        htm += '<option value="' + listOfCountries.data[i]["id"] + '">' + listOfCountries.data[i]["Country"] + '</option>';
                    }
                    $(mem.countries).html(listOfLanguages.html);
                    window.setTimeout(function () {
                        $(mem.countries).select2({
                            placeholder: "Select A Country",
                        });
                    }, 200);
                }
            },
            error: function (xhr, textStatus) {
                console.log(xhr);
                console.log(textStatus);
                //document.write(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
}
