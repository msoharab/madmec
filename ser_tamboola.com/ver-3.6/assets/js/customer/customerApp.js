function customerApp() {
    var sgym = {};
    this.__construct = function (usreqq) {
        sgym = usreqq;
        fetchlistofGyms();
    };
    function fetchlistofGyms() {
        $.ajax({
            type: 'POST',
            url: sgym.url,
            data: {
                autoloader: true,
                action: 'customer/fetchListOfGyms',
                type: 'customer'
            },
            success: function (data, textStatus, xhr) {
                /*					console.log(data);*/
                data = $.trim(data);
                /*					console.log(xhr.status);*/
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var response = $.parseJSON(data);
                        var gymdetails = new Array();
                        var gymdata = new Array();
                        if (response.status == "success") {
                            gymdata = response.gymdata;
                            if (response.data.length) {
                                for (i = 0; i < response.data.length; i++) {
                                    gymdetails.push({
                                        label: response.data[i],
                                        value: response.data[i],
                                        gymid: response.gymids[i],
                                        gymdata: i,
                                    });
                                }
                            }
                            $(sgym.searchgym).autocomplete({
                                source: gymdetails,
                                minLength: 1,
                                select: function (event, ui) {
                                    $(sgym.mgym).val(ui.item.label);
                                    fetchGymDetails(ui.item.gymid, ui.item.gymdata, gymdata);

                                },
                                Onselect: function (event, ui) {
                                    $(sgym.mgym).val(ui.item.label);
                                    fetchGymDetails(ui.item.gymid, ui.item.gymdata, gymdata);
                                }
                            });

                        }
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
    ;
    function fetchGymDetails(gymid, loc, gymdata) {

        var htm = '<div class="col-lg-12 text-right" id="sendreq"><button type="button"  class="btn btn-primary" id="send' + gymid + '">Send Request</buton></div>' +
                '<div class="col-lg-12 text-right" id="sendres"><button type="button" disabled="" class="btn btn-primary" id="send' + gymid + '">Request Sent</buton></div>' +
                '<div class="col-lg-12">&nbsp;</div>  ' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-6"><div class="col-lg-4"> <strong>Gym Name</strong></div><div class="col-lg-8">' + gymdata[loc]['gym_name'] + '</div></div> ' +
                ' <div class="col-lg-6"><div class="col-lg-4"><strong>Gym Type</strong></div><div class="col-lg-8">' + gymdata[loc]['gym_type'] + '</div></div> ' +
                ' </div>' +
                ' <div class="col-lg-12">&nbsp;</div>' +
                ' <div class="col-lg-12">' +
                '<div class="col-lg-6"><div class="col-lg-4"><strong>Email</strong></div><div class="col-lg-8">' + gymdata[loc]['email'] + '</div></div> ' +
                ' <div class="col-lg-6"><div class="col-lg-4"><strong>Cell Number</strong></div><div class="col-lg-8">' + gymdata[loc]['cell_number'] + '</div></div> ' +
                ' </div>' +
                '<div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                '<div class="col-lg-6"><div class="col-lg-4"><strong>Address</strong></div><div class="col-lg-8">' + gymdata[loc]['addressline'] + '</div></div> ' +
                ' <div class="col-lg-6"><div class="col-lg-4"><strong>Town</strong></div><div class="col-lg-8">' + gymdata[loc]['town'] + '</div></div> ' +
                ' </div>' +
                ' <div class="col-lg-12">&nbsp;</div>' +
                ' <div class="col-lg-12">' +
                ' <div class="col-lg-6"><div class="col-lg-4"><strong>City</strong></div><div class="col-lg-8">' + gymdata[loc]['city'] + '</div></div> ' +
                '<div class="col-lg-6"><div class="col-lg-4"><strong>District</strong></div><div class="col-lg-8">' + gymdata[loc]['district'] + '</div></div> ' +
                ' </div>' +
                ' <div class="col-lg-12">&nbsp;</div>' +
                '<div class="col-lg-12">' +
                ' <div class="col-lg-6"><div class="col-lg-4"><strong>State</strong></div><div class="col-lg-8">' + gymdata[loc]['province_code'] + gymdata[loc]['reqstatus'] + '</div></div> ' +
                ' <div class="col-lg-6"><div class="col-lg-4"><strong>District</strong></div><div class="col-lg-8">' + gymdata[loc]['zipcode'] + '</div></div> ' +
                ' </div>';
        $(sgym.displaygymdetails).html(htm);
        if (gymdata[loc]['reqstatus'] == "no") {
            $('#sendres').hide();
        } else {
            $('#sendreq').hide();
        }
        window.setTimeout(function () {
            $('#send' + gymid).click(function () {
                sendRequest(gymid);
            });
        }, 500);
    }
    function sendRequest(gymid) {
        $('#send' + gymid).hide();
        $.ajax({
            type: 'POST',
            url: sgym.url,
            data: {
                autoloader: true,
                action: 'customer/sendRequest',
                type: 'customer',
                gymid: gymid,
            },
            success: function (data, textStatus, xhr) {
                /*					console.log(data);*/
                data = $.trim(data);
                /*					console.log(xhr.status);*/
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (Number(data) == 2) {
                            $('#sendreq').hide();
                            $('#sendres').show();
                            alert("Approval is Pending From GYM Admin");
                            fetchlistofGyms();
                        } else if (Number(data) == 1) {
                            $('#sendreq').hide();
                            $('#sendres').show();
                            alert("Request has been Successfully Sent");
                            fetchlistofGyms();
                        } else {
                            alert("Error");
                        }
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
}
;
