function HeaderController()
{
    var member = {};
    var listOfSessions = {};
    var listOfContinents = {};
    var listOfCountries = {};
    var listOfLanguage = {};
    this.__constructor = function (para) {
        member = para;
        $('#' + member.world).click(function () {
            $('.' + member.geograph).each(function () {
                $(this).removeClass('active');
            });
            $('#' + member.continents.outputDiv).html('');
            $('#' + member.countries.outputDiv).html('');
            $('#' + member.languages.outputDiv).html('');
            $('.' + member.continents.class).each(function () {
                $('.' + member.continents.class).hide(500);
            });
            $(this).parent().addClass('active');
        });
        $('#' + member.country).click(function () {
            $('.' + member.geograph).each(function () {
                $(this).removeClass('active');
            });
            fetchContinents();
            $('.' + member.continents.class).each(function () {
                $(this).show(500);
            });
            $(this).parent().addClass('active');
        });
        window.setTimeout(function () {
            fetchSections();
        }, 1500)
    };

    function fetchSections() {
        var mem = member.sections;
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                listtype: mem.listtype,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listOfSessions = data;
                }
                else {
                    listOfSessions = $.parseJSON(data);
                }
                if (listOfSessions.status == "success") {
                    $('#' + mem.outputDiv).html(listOfSessions.html);
                    $('.' + listOfSessions.class).iCheck({
                        checkboxClass: 'icheckbox_futurico',
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
    ;

    function fetchContinents() {
        var mem = member.continents;
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                listtype: mem.listtype,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listOfContinents = data;
                }
                else {
                    listOfContinents = $.parseJSON(data);
                }
                if (listOfContinents.status == "success") {
                    $('#' + member.continents.outputDiv).html(listOfContinents.html);
                    $('#' + member.countries.outputDiv).html('');
                    $('#' + member.languages.outputDiv).html('');
                    $('.' + listOfContinents.class).iCheck({
                        checkboxClass: member.continents.icheckCH,
                        radioClass: 'iradio_futurico',
                        increaseArea: '10%' // optional
                    });
                    window.setTimeout(function () {
                        $('#' + member.continents.outputDiv).find('.' + member.continents.icheckCH).each(function () {
                            $(this).on('ifChanged', function () {
                                var allVals = [];
                                for (i = 0; i < Number(listOfContinents.count); i++) {
                                    if ($('#' + listOfContinents.id + i).parent().hasClass('checked') ||
                                            $('#' + listOfContinents.id + i).parent().hasClass('hover')) {
                                        allVals.push($('#' + listOfContinents.id + i).val());
                                    }
                                }
                                fetchCountries(allVals);
                            });
                        });
                    }, 600);
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
    ;

    function fetchCountries(allVals) {
        if (allVals.length > 0) {
            var mem = member.countries;
            $.ajax({
                url: mem.url,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
                    listtype: mem.listtype,
                    cont_id: allVals,
                },
                success: function (data, textStatus, xhr) {
                    if (typeof data === 'object') {
                        listOfCountries = data;
                    }
                    else {
                        listOfCountries = $.parseJSON(data);
                    }
                    if (listOfCountries.status == "success") {
                        $('#' + member.countries.outputDiv).html(listOfCountries.html);
                        $('.' + listOfCountries.class).iCheck({
                            checkboxClass: member.countries.icheckCH,
                            radioClass: 'iradio_futurico',
                            increaseArea: '10%' // optional
                        });
                        window.setTimeout(function () {
                            $('#' + member.countries.outputDiv).find('.' + member.countries.icheckCH).each(function () {
                                $(this).on('ifChanged', function () {
                                    var allVals = [];
                                    for (i = 0; i < Number(listOfCountries.count); i++) {
                                        console.log($('#' + listOfCountries.id + i).parent().attr('class'));
                                        console.log($('#' + listOfCountries.id + i).val());
                                        if ($('#' + listOfCountries.id + i).parent().hasClass('checked') ||
                                                $('#' + listOfCountries.id + i).parent().hasClass('hover')) {
                                            allVals.push($('#' + listOfCountries.id + i).val());
                                        }
                                    }
                                    console.log(allVals);
                                    fetchLanguages(allVals);
                                });
                            });
                        }, 600);
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
    }
    ;

    function fetchLanguages(allVals) {
        console.log(allVals);
        if (allVals.length > 0) {
            var mem = member.languages;
            $.ajax({
                url: mem.url,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
                    listtype: mem.listtype,
                    countries_id: allVals,
                },
                success: function (data, textStatus, xhr) {
                    if (typeof data === 'object') {
                        listOfLanguage = data;
                    }
                    else {
                        listOfLanguage = $.parseJSON(data);
                    }
                    if (listOfLanguage.status === "success") {
                        $('#' + member.languages.outputDiv).html(listOfLanguage.html);
                        $('.' + listOfLanguage.class).iCheck({
                            checkboxClass: member.languages.icheckCH,
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
    }
    ;
}
;

$(document).ready(function () {
    var obj = new HeaderController()
    obj.__constructor(getJSONIds({
        autoloader: true,
        action: 'getIdHolders',
        url: URL+'Wall/getIdHolders',
        type: 'POST',
        dataType: 'JSON'
    }).wall.header);
});

