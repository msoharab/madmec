function wallController() {
    var members = {};
    var listOfCountries = {};
    var listOfChannels = {};
    var submitCreate = false;
    this.__constructor = function (para) {
        members = para;
        window.setTimeout(function () {
            ListChannels();
        }, 500);
        $(members.create.parentBut).click(function (evt) {
            evt.preventDefault();
			alert('I am here');
            window.setTimeout(function () {
                listCountries();
            }, 800);
        });
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
                    required: "Enter the Channel Name",
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
            createChannel();
        });
    };
    function listCountries() {
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
                listOfCountries = $.parseJSON(data);
                if (listOfCountries.status == "success") {
                    var htm = '';
                    for (i = 0; i < listOfCountries.data.length; i++) {
                        htm += '<option value="' + listOfCountries.data[i]["id"] + '">' + listOfCountries.data[i]["Country"] + '</option>';
                    }
                    $(mem.countries).html(listOfCountries.html);
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
    function createChannel() {
        var mem = members.create;
        var countries = [];
        if ($(mem.country).prop("checked")) {
            $(mem.countries + ' :selected').each(function (i, selected) {
                countries[i] = $(selected).val();
            });
        }
        var attr = {
            name: $(mem.name).val(),
            target: $(mem.world).is('checked') ? $(mem.world).val() : countries,
            langauges: []
        };
        if (submitCreate) {
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
                    // var res = $.parseJSON(data);
                    var res = data;
                    if (res.status = "success") {
                        $(mem.close).trigger('click');
                        ListChannels();
                    }
                    else if (res.status = "Your quota is finished.") {
                        alert(res.status);
                        $(mem.close).trigger('click');
                    }
                },
                error: function (xhr, textStatus) {
                    console.log(xhr.responseText);
                    console.log(textStatus);
                    //document.write(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
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
                console.log(data);
                listOfChannels = $.parseJSON(data);
                if (listOfChannels.status == "success") {
                    var htm = '';
                    for (i = 0; i < listOfChannels.data.length; i++) {
                        htm += '<a class="list-group-item"  href="' + listOfChannels.data[i]["id"] + '">' + listOfChannels.data[i]["channel_name"] + '</a>';
                    }
                    $(mem.outputDiv).html(listOfChannels.html);
					window.setTimeout(function () {
                listCountries();
            }, 800);					
                } else {
                    alert('Failed to retive channel name.');
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
}
$(document).ready(function () {
    var members = {
        create: {
            autoloader: true,
            action: 'create',
            parentDiv: '#createchannel',
            parentBut: '#ex1',
            form: '#channelForm',
            type: 'post',
            dataType: 'JSON',
            name: '#ex4',
            world: '#ex5',
            country: '#ex6',
            countries: '#ex7',
            close: '#ex8',
            botton: '#ex9',
            outputDiv: '#exlist',
            url: URL + 'Channel/CreateChannel',
        },
        countries: {
            autoloader: true,
            action: 'create',
            type: 'post',
            dataType: 'JSON',
            countries: '#ex7',
            outputDiv: '#ex7',
            url: URL + 'Channel/ListCountries',
        },
        list: {
            autoloader: true,
            action: 'list',
            type: 'post',
            dataType: 'JSON',
            outputDiv: '#exlist',
            url: URL + 'Channel/ListChannels'
        },
    };
    var obj1 = new wallController();
    obj1.__constructor(members);
});
