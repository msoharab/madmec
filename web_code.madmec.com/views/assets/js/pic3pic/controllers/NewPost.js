function newPostController() {
    var submitCreate;
    var members = {};
    var listOfSessions = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    this.__constructor = function (para) {
        members = para;
        console.log(members);
        submitCreate = false;
        $('.' + members.create.postImg).picEdit({
            imageUpdated: function (img) {
            },
            formSubmitted: function (response) {
                console.log(response);
                if (submitCreate) {
                    createPost(submitCreate);
                }
            },
            redirectUrl: false,
            defaultImage: false
        });
        validateCreatePostForm();
        $('#' + members.create.target).change(function () {
            if (this.value == "Country") {
                fetchListOfContinents();
            }
            else {
                $('#' + members.create.parentFild).html('');
            }
        });
        fetchSections();
        window.setTimeout(function(){
            DisplayPost();
        },1500)
    };

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
        var allVals = [];
        $('#PoSections :checked').each(function () {
            allVals.push($(this).val());
        });
        if (!allVals.length)
        {
            alert("Select Section");
            return;
        }
        var attr = {
            name: $('#' + mem.title).val(),
            target: $('#' + mem.target).val(),
            continent: $('#' + mem.continent).val(),
            countries: countries,
            langauges: languages,
            sections: allVals,
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
                        alert("Your image Successfully Posted");
                        submitCreate = false;
                        $('#closePost').trigger('click');
                        DisplayPost();
                    }
                },
                error: function (xhr, textStatus) {
                },
                complete: function (xhr, textStatus) {
                    $('#' + mem.botton).removeAttr('disabled');
                }
            });
        }
    }
    ;

    function DisplayPost() {
        var mem = members.list;
        $('#'+mem.outputDiv).html('Loadin.....');
        $.ajax({
            url: mem.url1,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action1,
                dataType: mem.dataType,
            },
            success: function (data) {
                $('#'+mem.outputDiv).html(data);
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
        $(window).scroll(function (event) {
            if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10) {
                UpdateListPost();
                return;
            } else {
                //$('#'+mem.outputDiv).html('');
            }
        });
    }

    function UpdateListPost() {
        var mem = members.list;
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                dataType: mem.dataType,
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
                        $('#'+mem.outputDiv).append(data);
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }

    function validateCreatePostForm() {
        var memadd = members.create;
        window.setTimeout(function () {
            var $params = {debug: false, rules: {}, messages: {}};
            var field = $('#' + memadd.title).attr("name");
            $params['rules'][field] = {
                required: true,
                minlength: 2
            };
            $params['messages'][field] = {
                required: 'Enter the Title',
                minlength: 'Length Should be minimum 2 Characters'
            };
            var field = $('#' + memadd.target).attr("name");
            $params['rules'][field] = {
                required: true
            };
            $params['messages'][field] = {
                required: 'Select target'
            };
            var field = $('#' + memadd.iagree).attr("name");
            $params['rules'][field] = {
                required: true
            };
            $params['messages'][field] = {
                required: 'Select Agree'
            };
            $params['submitHandler'] = function () {
                submitCreate = true;
            };
            $('#' + memadd.form).validate($params);
            /*
             $('#' + memadd.form).submit(function () {
             if (submitCreate) {
             createPost(submitCreate);
             }
             });
             */
            $('#' + members.create.form).on('keyup', function (e) {
                var code = Number(e.keyCode || e.which);
                if (code == 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }, 600);
    }
    ;

    function fetchSections() {
        var mem = members.sections;
        $('#' + mem.outputDiv).html('Loading...');
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                listtype: 'checkbox',
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listOfSessions = data;
                }
                else {
                    listOfSessions = $.parseJSON($.trim(data));
                }
                if (listOfSessions.status == "success") {
                    $('#' + mem.outputDiv).html(listOfSessions.html);
                    $('.' + listOfSessions.class).iCheck({
                        checkboxClass: members.sections.icheckCH,
                        radioClass: 'iradio_futurico',
                        increaseArea: '10%' // optional
                    });
                } else {
                    alert('Failed to retive channels.');
                }
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

    function fetchListOfContinents() {
        var memadd = members.create;
        var mem = members.continents;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
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
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;

    function fetchListOfCountries(cont_id) {
        var memadd = members.create;
        var mem = members.countries;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
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
                    $('#' + memadd.country).select2();
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
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;

    function fetchlanguages(countries_id) {
        var memadd = members.create;
        var mem = members.languages;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
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
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
}