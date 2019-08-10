function sms() {
    var smsc = {};
    this.__construct = function (smsctrl) {
        smsc = smsctrl;
        $(smsc.smssendbtn).hide();
        $(smsc.msglength).html('0');
        $(smsc.message).keyup(function () {
            $(smsc.msglength).html($(smsc.message).val().length);
        });
        fetchcity();
        $(smsc.gymsearch).click(function () {
            fetchlistofgym($(smsc.gym_searchh).val());
        })
    };
    function fetchcity() {
        $(smsc.smssendbtn).hide();
        $.ajax({
            url: smsc.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'fetchlistofcity',
                type: 'jddata',
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                var details = $.parseJSON($.trim(data));
                if (details.status == "success") {
                    if (details.data.length) {
                        var citys = new Array();
                        for (i = 0; i < details.data.length; i++) {
                            citys[i] = details.data[i];
                        }
                        $(smsc.gym_searchh).autocomplete({
                            source: citys
                        });
                    }
                }
            },
            error: function (xhr, textStatus) {
                $(members.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function fetchlistofgym(val) {
        $('#listofgyms').html(LOADER_ONE);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'listofgyms',
                city: val,
                type: 'jddata',
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                var details = $.parseJSON($.trim(data));
                var contacts = new Array();
                $('#listofgyms').html('<table class="table table-hover" id="listofgymsTable">' +
                        '<thead><tr><th>#</th><th>Name</th><th>Contact</th><th>Estd</th><th>Address</th><th>City</th><th><input type="checkbox" name="selecctall" id="selecctall">&nbsp;&nbsp;<strong>All</strong></th></tr></thead>' +
                        '<tbody>' + details.data + '</tbody></table>');
                if (Number(details.noofrec) > 0) {
                    $(smsc.smssendbtn).show();
                    for (i = 0; i < details.ids.length; i++) {
                        contacts[details.ids[i]] = details.contacts[i];
                    }
                } else {
                    $(smsc.smssendbtn).hide();
                }
                window.setTimeout(function () {
                    //                     $("#selectall").on("click", function() {
                    //                       if($(this).attr("checked") == "checked")
                    //                       {
                    //
                    //                       }
                    //                       else
                    //                       {
                    //
                    //                       }
                    //                      });
                    $('#selecctall').click(function (event) { //on click
                        if (this.checked) { // check select status
                            $('.checkbox1').each(function () { //loop through each checkbox
                                this.checked = true; //select all checkboxes with class "checkbox1"
                            });
                        } else {
                            $('.checkbox1').each(function () { //loop through each checkbox
                                this.checked = false; //deselect all checkboxes with class "checkbox1"
                            });
                        }
                    });
                    // add multiple select / deselect functionality
                    //                    $("#selecctall").each(function(){
                    //                        $(this).click(function () {
                    //                            $('.checkbox1').attr('checked', this.checked);
                    //                        });
                    //                    })
                    // if all checkbox are selected, check the selectall checkbox
                    // and viceversa
                    //                    $(".checkbox1").click(function () {
                    //
                    //                        if ($(".checkbox1").length == $(".checkbox1:checked").length) {
                    //                            $("#selectall").attr("checked", "checked");
                    //                        } else {
                    //                            $("#selectall").removeAttr("checked");
                    //                        }
                    //
                    //                    });
                    $(smsc.smssendbtn).click(function () {
                        sendSMS(contacts);
                    });
                });
            },
            error: function (xhr, textStatus) {
                $(members.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
                $("#selecctall").each(function () {
                    $(this).click(function () {
                        $('.checkbox1').attr('checked', this.checked);
                    });
                });
                window.setTimeout(function () {
                    $(document).ready(function () {
                        $('#listofgymsTable').dataTable({
                            retrieve: true,
                            destroy: true,
                            "pageLength": 7,
                            "aoColumns": [
                                null,
                                null,
                                null,
                                null,
                                null,
                                null,
                                null
                            ],
                            "autoWidth": true
                        });
                    });
                }, 600);
            }
        });
    }
    ;
    function sendSMS(contacts) {
        var i = 0;
        var flag = false;
        var newcontacts = new Array();
        if ($.trim($(smsc.message).val()) == "" && $.trim($(smsc.message).val()).length < 320) {
            flag = false;
            $(smsc.message).focus();
            return;
        } else {
            flag = true;
        }
        $('input[name="checkbox1"]:checked').each(function () {
            temp = this.value;
            newcontacts[i++] = contacts[temp];
            flag = true;
        });
        console.log(newcontacts);
        if (flag) {
            $.ajax({
                type: 'POST',
                url: window.location.href,
                data: {
                    autoloader: true,
                    action: 'sendsms',
                    type: 'jddata',
                    ids: newcontacts,
                    message: $.trim($(smsc.message).val())
                },
                success: function (data, textStatus, xhr) {
                    console.log(data);
                    data = $.trim(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            if (data) {
                                alert("Message Has been Successfully Sent");
                                $(smsc.sendmsgform).get(0).reset();
                                $(smsc.msglength).html('0');
                            }
                            break;
                    }
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        }
        ;
    }
    ;
}
;