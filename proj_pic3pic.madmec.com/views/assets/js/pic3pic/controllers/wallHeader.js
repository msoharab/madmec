function HeaderController()
{
    var member = {};
    var members = {};
    var listOfSections = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    this.__constructor = function (para) {
        members = para;
        member = para.wall.header.filter;
        $('#' + member.list.parentBut).bind('click', function (evt) {
            fetchSections();
            $('#' + member.list.target).change(function () {
                if (this.value === "Country") {
                    fetchListOfContinents();
                } else {
                    $('#' + member.list.parentFild).html('');
                }
            });
        });
        $('#' + member.list.create).on('click', function (evt) {
            filterListPost();
        });
    };
    function fetchSections() {
        var mem = member.sections;
        $('#' + mem.outputDiv).html('Loading...');
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                listtype: mem.listtype,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listOfSections = data;
                } else {
                    listOfSections = $.parseJSON($.trim(data));
                }
                if (listOfSections.status === "success") {
                    $('#' + mem.outputDiv).html('<select name="' + mem.id + '" id="' + mem.id + '" class="' + mem.class + '" multiple="multiple">' + listOfSections.html + '</select>');
                    window.setTimeout(function () {
                        $('#' + mem.id).select2();
                    }, 300);
                } else {
                    alert('Failed to retive sections.');
                }
            },
            error: function (xhr, textStatus) {
                //console.log(xhr);
                //console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                //console.log(xhr.status);
            }
        });
    }
    ;
    function fetchListOfContinents() {
        var memadd = member.list;
        var mem = member.continents;
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
                } else {
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
        var memadd = member.list;
        var mem = member.countries;
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
                } else {
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
                    //$('#' + memadd.country + ' > option').prop("selected", "selected");
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
                    /*
                     window.setTimeout(function () {
                     $eventSelect.trigger("change");
                     }, 700);
                     */
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
        var memadd = member.list;
        var mem = member.languages;
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
                } else {
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
                    //$('#' + memadd.language + ' > option').prop("selected", "selected");
                    var $eventSelect = $('#' + memadd.language);
                    $eventSelect.on("change", function (e) {
                        $eventSelect.select2("close");
                    });
                    /*
                     window.setTimeout(function () {
                     $eventSelect.trigger("change");
                     }, 800);
                     */
                }
            },
            error: function (xhr, textStatus) {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function filterListPost() {
        var mem = member.list;
        var countries = new Array();
        var languages = new Array();
        $('#' + mem.country + ' :selected').each(function (i, selected) {
            countries[i] = $(selected).val();
        });
        $('#' + mem.language + ' :selected').each(function (i, selected) {
            languages[i] = $(selected).val();
        });
        var allVals = [];
        $('#' + mem.section + ' :selected').each(function () {
            allVals.push($(this).val());
        });
        if (!allVals.length) {
            alert("Select Section");
            return;
        }
        var attr = {
            target: $('#' + mem.target).val(),
            continent: $('#' + mem.continent).val(),
            countries: countries,
            langauges: languages,
            sections: allVals,
        };
        var res = {};
        if (attr) {
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
                    window.setTimeout(function () {
                        var obj = new indexPostController();
                        obj.__constructor(members);
                        obj.publicFilterpost(data);
                    }, 400);
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
}
;

