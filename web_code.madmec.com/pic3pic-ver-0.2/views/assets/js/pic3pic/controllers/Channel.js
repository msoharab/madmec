function channelController() {
    var submitCreate;
    var members = {};
    var listOfChannels = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    this.__constructor = function (para) {
        members = para;
        submitCreate = false;
    };

    this.publicListChannels = function () {
        window.setTimeout(function () {
            ListChannels();
        }, 1800);
    };

    function createChannel() {
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
        var res = {};
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
                    if (typeof data === 'object') {
                        res = data;
                    }
                    else {
                        res = $.parseJSON($.trim(data));
                    }
                    if (res.status === "success") {
                        $('#' + mem.form).get(0).reset();
                        $('#' + mem.close).trigger('click');
                        alert("Channel has been Successfully Created");
                        submitCreate = false;
                        ListChannels();
                    }
                    else if (res.status === "Your quota is finished.") {
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
    function ListChannels() {
        var mem = members.list;
        $.ajax({
            url: mem.url,
            type: mem.type,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listOfChannels = data;
                }
                else {
                    listOfChannels = $.parseJSON($.trim(data));
                }
                if (listOfChannels.status === "success") {
                    $('#' + mem.outputDiv).html(listOfChannels.html);
                } else {
                    alert('Failed to retive channels.');
                }
                validateCreateChannelForm();
            },
            error: function (xhr, textStatus) {
                console.log(xhr);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;

    function validateCreateChannelForm() {
        var memadd = members.create;
        window.setTimeout(function () {
            $('#' + memadd.target).change(function () {
                if (this.value === "Country") {
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
                    createChannel(submitCreate);
                }
            });
            $('#' + memadd.form).on('keyup', function (e) {
                var code = Number(e.keyCode || e.which);
                if (code === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }, 600);
    }
    ;

    function fetchListOfContinents() {
        var memadd = members.create;
        var mem = members.create.continents;
        var obj = {};
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
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + memadd.parentFild).html('<div class="col-lg-12"><h4>Select continent.</h4></div><div class="col-lg-12">' +
                            '<select class="form-control" id="' + memadd.continent + '" name="' + memadd.continent + '" required=""><option value="">Select Continent</option>' + data.html +
                            '</select>' +
                            '</div>');
                    window.setTimeout(function () {
                        $('#' + memadd.continent).change(function () {
                            var allval = new Array();
                            $(recentObjCountry).remove();
                            $(recentObjlanguge).remove();
                            if (this.value !== "") {
                                allval[0] = this.value
                                fetchListOfCountries(allval);
                            }
                        });
                    }, 700);
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

    function fetchListOfCountries(cont_id) {
        var memadd = members.create;
        var mem = members.create.countries;
        var obj = {};
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
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    recentObjCountry = $('<div class="col-lg-12"><h4>Select countries.</h4></div><div class="col-lg-12">' +
                            '<select class="form-control" id="' + memadd.country + '" name="' + memadd.country + '" multiple="multiple" required="">' + data.html +
                            '</select>' +
                            '</div>');
                    $('#' + memadd.parentFild).append(recentObjCountry);
                    $('#' + memadd.country).hide();
                    $('#' + memadd.country).select2({
                        maximumSelectionLength: -1,
                        allowClear: true
                    });
                    $(memadd.sel2).addClass('col-lg-12');
                    $(memadd.sel2).removeAttr('style');
                    $('#' + memadd.country + ' > option').prop("selected", "selected");
                    var $eventSelect = $('#' + memadd.country);
                    $eventSelect.on("change", function (e) {
                        $eventSelect.select2("close");
                        var countries = [];
                        $('#' + memadd.country + ' :selected').each(function (i, selected) {
                            countries[i] = $(selected).val();
                        });
                        $(recentObjlanguge).remove();
                        fetchlanguages(countries);
                    });
                    window.setTimeout(function () {
                        $eventSelect.trigger("change");
                    }, 700);
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

    function fetchlanguages(countries_id) {
        var memadd = members.create;
        var mem = members.create.languages;
        var obj = {};
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
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    recentObjlanguge = $('<div class="col-lg-12"><h4>Select languages.</h4></div><div class="col-lg-12">' +
                            '<select class="form-control" id="' + memadd.language + '" name="' + memadd.language + '" multiple="multiple">' + data.html +
                            '</select>' +
                            '</div>');
                    $('#' + memadd.parentFild).append(recentObjlanguge);
                    $('#' + memadd.language).hide();
                    $('#' + memadd.language).select2({
                        minimumResultsForSearch: -1
                    });
                    $(memadd.sel2).addClass('col-lg-12');
                    $(memadd.sel2).removeAttr('style');
                    $('#' + memadd.language + ' > option').prop("selected", "selected");
                    var $eventSelect = $('#' + memadd.language);
                    $eventSelect.on("change", function (e) {
                        $eventSelect.select2("close");
                    });
                    window.setTimeout(function () {
                        $eventSelect.trigger("change");
                    }, 800);
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