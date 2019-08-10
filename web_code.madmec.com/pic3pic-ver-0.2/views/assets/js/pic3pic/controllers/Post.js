function postController() {
    var members = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    var submitCreate = false;
    this.__constructor = function (para) {
        members = para;
    };
    this.publicCreatePost = function () {
        validateCreatePostForm();
    };

    function validateCreatePostForm() {
        var memadd = members.create;
        window.setTimeout(function () {
            $('#' + memadd.target).change(function () {
                if (this.value == "Country") {
                    fetchListOfContinents();
                }
                else {
                    $('#' + memadd.parentFild).html('');
                }
            });
            var $params = {debug: false, rules: {}, messages: {}};
            var field = $('#' + memadd.name).attr("name");
            $params['rules'][field] = {
                required: true,
                minlength: 4
            };
            $params['messages'][field] = {
                required: 'Enter the Channel Name',
                minlength: 'Length Should be minimum 4 Characters'
            };
            var field = $('#' + memadd.target).attr("name");
            $params['rules'][field] = {
                required: true
            };
            $params['messages'][field] = {
                required: 'Select target'
            };
            $params['submitHandler'] = function () {
                submitCreate = true;
            };
            $('#' + memadd.form).validate($params);
            $('#' + memadd.form).submit(function () {
                if (submitCreate) {
                    createPost(submitCreate);
                }
            });
        }, 600);
    }
    ;
    function createPost() {
        var mem = members.create;
        var countries = [];
        var languages = [];
        $('#' + mem.country + ' :selected').each(function (i, selected) {
            countries[i] = $(selected).val();
        });
        $('#' + mem.language + ' :selected').each(function (i, selected) {
            languages[i] = $(selected).val();
        });
        var attr = {
            name: $('#' + mem.name).val(),
            target: $('#' + mem.target).val(),
            continent: $('#' + mem.continent).val(),
            countries: countries,
            langauges: languages,
        };
        if (submitCreate) {
            $(recentObjCountry).remove();
            $(recentObjlanguge).remove();
            $('#' + mem.botton).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
                    details: attr
                },
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    var res = data;
                    if (res.status = "success") {
                        $('#' + mem.form).get(0).reset();
                        $('#' + mem.close).trigger('click');
                        alert("Channel has been Successfully Created");
                        submitCreate = false;
                        ListChannels();
                    }
                    else if (res.status = "Your quota is finished.") {
                        $('#' + mem.form).get(0).reset();
                        submitCreate = false;
                        alert(res.status);
                        $('#' + mem.close).trigger('click');
                    }
                },
                error: function (xhr, textStatus) {
                    console.log(xhr.responseText);
                    console.log(textStatus);
                    //document.write(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $('#' + mem.botton).removeAttr('disabled');
                }
            });
        }
    }
    ;

    function fetchListOfContinents()
    {
        var memadd = members.create;
        var mem = members.create.continents;
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
            },
            success: function (data, textStatus, xhr) {
                if (data.status === "success") {
                    $('#' + memadd.parentFild).html('<div class="col-lg-12">&nbsp;</div><div class="col-lg-12"><div class="input-group">' +
                            '<span class="input-group-addon" id="basic-addon1">Select Continent </span>' +
                            '<select class="form-control" id="' + memadd.continent + '" name="' + memadd.continent + '" required=""><option value="">SELECT Continent</option>' + data.html +
                            '</select>' +
                            '</div>' +
                            '</div>');
                    window.setTimeout(function () {
                        $('#' + memadd.continent).change(function () {
                            $(recentObjCountry).remove();
                            $(recentObjlanguge).remove();
                            if (this.value !== "") {
                                fetchListOfCountries(this.value);
                            }
                        });
                    }, 700);
                }
                else {

                }
            },
            error: function (xhr, textStatus) {
                console.log(xhr.responseText);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function fetchListOfCountries(cont_id)
    {
        var memadd = members.create;
        var mem = members.create.countries;
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                cont_id: cont_id,
            },
            success: function (data, textStatus, xhr) {
                if (data.status === "success") {
                    recentObjCountry = $('<div class="col-lg-12">&nbsp;</div><div class="col-lg-12"><div class="input-group">' +
                            '<span class="input-group-addon" id="basic-addon1">Select Countries </span>' +
                            '<select class="form-control" id="' + memadd.country + '" name="' + memadd.country + '" multiple="multiple" required="">' + data.html +
                            '</select>' +
                            '</div>' +
                            '</div>');
                    $('#' + memadd.parentFild).append(recentObjCountry);
                    window.setTimeout(function () {
                        $('#' + memadd.country).hide();
                        $('#' + memadd.country).select2();
                        $(memadd.sel2).removeAttr('style');
                        $(memadd.sel2).addClass('col-lg-12');
                        $(memadd.sel2).addClass('form-control');
                        window.setTimeout(function () {
                            var $eventSelect = $('#' + memadd.country);
                            $eventSelect.on("change", function (e) {
                                var countries = [];
                                $('#' + memadd.country + ' :selected').each(function (i, selected) {
                                    countries[i] = $(selected).val();
                                });
                                $(recentObjlanguge).remove();
                                fetchlanguages(countries);
                            });
                        }, 700);

                    }, 700);
                }
                else {

                }
            },
            error: function (xhr, textStatus) {
                console.log(xhr.responseText);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function fetchlanguages(countries_id)
    {
        var memadd = members.create;
        var mem = members.create.languages;
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                countries_id: countries_id,
            },
            success: function (data, textStatus, xhr) {
                if (data.status === "success") {
                    recentObjlanguge = $('<div class="col-lg-12">&nbsp;</div><div class="col-lg-12"><div class="input-group">' +
                            '<span class="input-group-addon" id="basic-addon1">Select Languages </span>' +
                            '<select class="form-control" id="' + memadd.language + '" name="' + memadd.language + '" multiple="multiple">' + data.html +
                            '</select>' +
                            '</div>' +
                            '</div>');
                    $('#' + memadd.parentFild).append(recentObjlanguge);
                    window.setTimeout(function () {
                        $('#' + memadd.language).hide();
                        $('#' + memadd.language).select2();
                        $(memadd.sel2).removeAttr('style');
                        $(memadd.sel2).addClass('col-lg-12');
                        $(memadd.sel2).addClass('form-control');
                    }, 700);
                }
                else {

                }
            },
            error: function (xhr, textStatus) {
                console.log(xhr.responseText);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
}
