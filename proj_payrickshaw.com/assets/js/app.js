function goto_form1() {
    $(".form_div").hide();
    $("#form1").show();
}
function goto_form2() {
    $(".form_div").hide();
    $("#form2").show();
}
function goto_form3() {
    $(".form_div").hide();
    $("#form3").show();
}
function finish() {
    $(".form_div").hide();
    $("#form1").show();
}
function app() {
    var billdetails = {};
    this.__construct = function (billdetailsctrl) {
        billdetails = billdetailsctrl;
        window.setTimeout(function () {
            $(billdetails.regdno).focus();
        }, 1000);
        $(billdetails.formreferesh).click(function () {
            $(billdetails.genbillform).get(0).reset();
            clearErrors()
        });
        $(billdetails.next1).on('click', function () {
            window.setTimeout(function () {
                $(billdetails.passengermobile).focus();
            }, 1000);
            validateDriverDetails();
        });
        $(billdetails.next2).click(function () {
            validatePassengerDetails();
        });
        fetchRegdNumbers();
        $(billdetails.signout).on('click', function () {
            SignOut();
        });
        $(billdetails.regdno).on('keyup', function () {
            var regno = $(billdetails.regdno).val();
            $(billdetails.regdno).val(regno.toUpperCase());
        });

        startGoogle();
    };
    function clearErrors()
    {
        $(billdetails.regdnoerr).html('');
        $(billdetails.drivernameerr).html('');
        $(billdetails.drivermobileerr).html('');
        $(billdetails.regdnoerr).html('');
        $(billdetails.drivernameerr).html('');
        $(billdetails.drivermobileerr).html('');
    }
    function fetchRegdNumbers()
    {
        billdetails.drivercheck = 0;
        billdetails.passengercheck = 0;
        $.ajax({
            type: 'POST',
            url: billdetails.url,
            data: {
                autoloader: true,
                action: 'fetchregdnumber',
            },
            success: function (data, textStatus, xhr) {
//                                            console.log(data)
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var details = $.parseJSON(data);
                        var regdno = new Array();
                        var drivernames = new Array();
                        var drivermobiles = new Array();
                        var passmobiles = new Array();
                        var passnames = new Array();
                        var passaddress = new Array();
                        if ((details.regdno).length)
                        {
                            for (i = 0; i < (details.regdno).length; i++)
                            {
                                // regdno[i]=details.regdno[i];
                                // drivernames[i]=details.drivernames[i];
                                // drivermobiles[i]=details.drivermobiles[i];

                                /* Soharab code */
                                regdno.push({
                                    label: $.trim(details.regdno[i]),
                                    value: $.trim(details.regdno[i]),
                                    name: $.trim(details.drivernames[i]),
                                    num: $.trim(details.drivermobiles[i]),
                                    driverid: $.trim(details.driverid[i])
                                });
                                /* Soharab code */
                            }
                            $(billdetails.regdno).autocomplete({
                                source: regdno,
                                /* Soharab code */
                                select: function (event, ui) {
                                    billdetails.drivercheck = 1;
                                    $(billdetails.drivername).val(ui.item.name);
                                    $(billdetails.drivermobile).val(ui.item.num);
                                    billdetails.driverid = ui.item.driverid;
                                }
                                /* Soharab code */
                            });
                            /* shakeel code commented */
                            $(billdetails.regdno).on('change', function () {
                                for (j = 0; j < (details.regdno).length; j++)
                                {
                                    if (details.regdno[j] == $(billdetails.regdno).val())
                                    {
                                        billdetails.drivercheck = 1;
                                        $(billdetails.drivername).val(drivernames[j]);
                                        $(billdetails.drivermobile).val(drivermobiles[j]);
                                        billdetails.driverid = details.driverid[j];
                                    }
                                    else
                                    {
                                        billdetails.drivercheck = 0;
                                        $(billdetails.drivername).val('');
                                        $(billdetails.drivermobile).val('');
                                        billdetails.driverid = 0;
                                    }
                                }

                            });
                        }
                        if ((details.passmobile).length)
                        {
                            for (i = 0; i < (details.passmobile).length; i++)
                            {
                                // passmobiles[i]=details.passmobile[i];
                                // passnames[i]=details.passnames[i];
                                // passaddress[i]=details.passaddress[i];
                                /* Soharab code */
                                passmobiles.push({
                                    label: $.trim(details.passmobile[i]),
                                    value: $.trim(details.passmobile[i]),
                                    name: $.trim(details.passnames[i]),
                                    num: $.trim(details.passmobile[i]),
                                    address: $.trim(details.passaddress[i]),
                                    passid: $.trim(details.passid[i])
                                });
                                /* Soharab code */
                            }
                            $(billdetails.passengermobile).autocomplete({
                                source: passmobiles,
                                /* Soharab code */
                                select: function (event, ui) {
                                    billdetails.passengercheck = 1;
                                    $(billdetails.passengername).val(ui.item.name);
                                    $(billdetails.passngeraddress).val(ui.item.address);
                                    billdetails.passid = ui.item.passid;
                                }
                                /* Soharab code */
                            });

                            /* shakeel code commented
                             $(billdetails.passengermobile).change(function (){
                             for(j=0;j<(details.passmobile).length;j++)
                             {
                             if(details.passmobile[j]==$(billdetails.passengermobile).val())
                             {
                             billdetails.passengercheck=1;
                             $(billdetails.passengername).val(passnames[j]) ;
                             $(billdetails.passngeraddress).val(passaddress[j]) ;
                             billdetails.passid=details.passid[j];
                             }
                             }
                             })  ; 
                             */
                        }
                        break;
                }
            },
            error: function () {

            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function validateDriverDetails()
    {
        var flag = false;
        if ($(billdetails.regdno).val() == "")
        {

            flag = false;
            $(billdetails.regdno).focus();
            $(billdetails.regdnoerr).html(INVALIDNOT);
            return;
        }
        else
        {
            $(billdetails.regdnoerr).html('');
            flag = true;
        }
        if ($(billdetails.drivername).val() == "")
        {
            flag = false;
            $(billdetails.drivername).focus();
            $(billdetails.drivernameerr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(billdetails.drivernameerr).html('');
        }
        if (($(billdetails.drivermobile).val() == "") || (!$(billdetails.drivermobile).val().match(cell_reg)))
        {
            flag = false;
            $(billdetails.drivermobile).focus();
            $(billdetails.drivermobileerr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(billdetails.regdnoerr).html('');
        }
        if (flag)
        {
            $(billdetails.regdnoerr).html('');
            $(billdetails.drivernameerr).html('');
            $(billdetails.drivermobileerr).html('');
            goto_form2();
        }
    }
    function validatePassengerDetails()
    {
        var flag = false;
        if (($(billdetails.passengermobile).val() == "") || (!$(billdetails.passengermobile).val().match(cell_reg)))
        {
            flag = false;
            $(billdetails.passengermobile).focus();
            $(billdetails.passengermobileerr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(billdetails.passengermobileerr).html('');
        }
        if (($(billdetails.passengername).val() == "") || (!$(billdetails.passengername).val().match(namee_reg)))
        {
            flag = false;
            $(billdetails.passengername).focus();
            $(billdetails.passengernameerr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(billdetails.passengernameerr).html('');
        }
        if ($(billdetails.passngeraddress).val() == "")
        {
            flag = false;
            $(billdetails.passngeraddress).focus();
            $(billdetails.passngeraddresserr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(billdetails.passngeraddresserr).html('');
        }
        if (flag)
        {
            $(billdetails.passngeraddresserr).html('');
            $(billdetails.passengermobileerr).html('');
            $(billdetails.passengernameerr).html('');

            goto_form3();
        }
    }
    function billGeneration()
    {
        var flag = false;
        if ($(billdetails.destination) == "")
        {
            flag = false;
            $(billdetails.destination).focus();
            return;
        }
        else
        {
            flag = true;
        }
        if (flag)
        {
            $(billdetails.genButt).hide();
            var details = {
                regdno: $(billdetails.regdno).val(),
                drivername: $(billdetails.drivername).val(),
                drivermobile: $(billdetails.drivermobile).val(),
                passengermobile: $(billdetails.passengermobile).val(),
                passengername: $(billdetails.passengername).val(),
                passngeraddress: $(billdetails.passngeraddress).val(),
                source: $(billdetails.source).val(),
                destination: $(billdetails.destination).val(),
                distance: $(billdetails.distance).val(),
                amount: $(billdetails.amount).val(),
                drivercheck: billdetails.drivercheck,
                passcheck: billdetails.passengercheck,
                passid: billdetails.passid,
                driverid: billdetails.driverid
            };
            $.ajax({
                type: 'POST',
                url: billdetails.url,
                data: {
                    autoloader: true,
                    action: 'genretebill',
                    attr: details
                },
                success: function (data, textStatus, xhr) {
                    console.log(data)
                    data = $.trim(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            // console.log(billgen);
                            var billgen = $.parseJSON(data);
                            if (billgen)
                            {
                                // alert("completed");
                                $(billdetails.genButt).show();
                                var bill = '<table cellpadding="0" cellspacing="0"><tr><th colspan="2"><h2>Prepaid Auto Rickshaw</h2></th></tr>' +
                                        '<tr><td width="40%">Source</td><td width="60%">' + $(billdetails.source).val() + '</td></tr>' +
                                        '<tr><td>Destination</td><td>' + $(billdetails.destination).val() + '</td></tr>' +
                                        '<tr><td>Distance Travelled</td><td>' + $(billdetails.distance).val() + '</td></tr>' +
                                        '<tr><td>Amount</td><td>' + $(billdetails.amount).val() + ' Rs</td></tr>' +
                                        '<tr></tr>' +
                                        '<tr><th colspan="2"><hr /><h3>Passenger\'s Details</h3></th></tr>' +
                                        '<tr><td>Name</td><td>' + $(billdetails.passengername).val() + '</td></tr>' +
                                        '<tr><td>Mobile</td><td>' + $(billdetails.passengermobile).val() + '</td></tr>' +
                                        '<tr><td>Permanent Address</td><td>' + $(billdetails.passngeraddress).val() + '</td></tr>' +
                                        '<tr></tr>' +
                                        '<tr><th colspan="2"><hr /><h3>Driver\'s Details</h3></th></tr>' +
                                        '<tr><td>Auto Number</td><td>' + $(billdetails.regdno).val() + '</td></tr>' +
                                        '<tr><td>Chauffeur Name</td><td>' + $(billdetails.drivername).val() + '</td></tr>' +
                                        '<tr><td>Chauffeur Mobile</td><td>' + $(billdetails.drivermobile).val() + '</td></tr>' +
                                        '<tr></tr><tr></tr>' +
                                        '<tr><td colspan="2" align="center"><button onclick="window.print();">Print Receipt</button></td></tr>' +
                                        '</table>';
                                localStorage.setItem('bill', bill);
                                window.setTimeout(function () {
                                    window.open("printbill.html", "_blank", "width=800, height=900");
                                }, 1000);
//                                                                        window.location.href=LAND_PAGE;
                            }
                            else
                            {
                                alert("Error");
                                $(billdetails.genButt).show();
                            }

                            break;
                    }
                },
                error: function () {

                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        fetchRegdNumbers();
    }
    function SignOut()
    {
        $.ajax({
            type: 'POST',
            url: billdetails.url,
            data: {
                autoloader: true,
                action: 'logout'
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                }
            },
            error: function () {
                $(sales.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function print_receipt()
    {
        window.print();
    }
    function startGoogle() {
        var map;
        var geocoder;
        var bounds = new google.maps.LatLngBounds();
        var markersArray = [];

        var SRCmarker = new google.maps.Marker({});
        // var origin = new google.maps.LatLng(12.898085, 77.588968); // MadMec
        //var origin = new google.maps.LatLng(12.980954,77.574769); // HITECH PREPAID STATION
        var origin = new google.maps.LatLng(12.9749632, 77.6044059); // HITECH PREPAID STATION

        var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';

        var DESmarker = new google.maps.Marker({});
        var destination = new google.maps.LatLng(12.980816, 77.574785); // Hi tech prepaid auto rickshaw station
        var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';

        var directionsService = new google.maps.DirectionsService({suppressMarkers: true});
        var dirRenderer = new google.maps.DirectionsRenderer({});
        // Create the search box and link it to the UI element.
        var input = /** @type {HTMLInputElement} */(
                document.getElementById('pac-input'));
        var searchBox = new google.maps.places.SearchBox(
                /** @type {HTMLInputElement} */(input));
        var markers = [];

        var opts = {
            // center: new google.maps.LatLng(12.898085, 77.588968),
            center: origin,
            zoom: 16
        };

        function geocodePosition(pos) {
            geocoder.geocode({
                latLng: pos
            }, function (responses) {
                if (responses && responses.length > 0) {
                    updateMarkerAddress(responses[0].formatted_address);
                } else {
                    updateMarkerAddress('Cannot determine address at this location.');
                }
                // calculateDistances();
            });
        }

        function updateMarkerStatus(str) {
            document.getElementById('markerStatus').innerHTML = str;
        }

        function updateMarkerPosition(latLng) {
            document.getElementById('info').innerHTML = [
                latLng.lat(),
                latLng.lng()
            ].join(', ');
            destination = latLng;
        }

        function updateMarkerAddress(str) {
            document.getElementById('address').innerHTML = str;
            $('#destination').val(str);
        }

        function placeMarker(location) {
            if (DESmarker) {
                DESmarker.setPosition(location);
            } else {
                DESmarker = new google.maps.Marker({
                    position: location,
                    title: 'Destination',
                    icon: destinationIcon,
                    map: map,
                    draggable: true
                });
            }
            destination = location;
            geocodePosition(destination);
        }

        function autofocusSearch() {
            /* Position the search the search box */
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);

            // [START region_getplaces]
            // Listen for the event fired when the user selects an item from the
            // pick list. Retrieve the matching places for that item.
            google.maps.event.addListener(searchBox, 'places_changed', function () {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // for (var i = 0, marker; marker = markers[i]; i++) {
                // marker.setMap(null);
                // }
                // for (var i = 0, DESmarker; DESmarker = markers[i]; i++) {
                // DESmarker.setMap(null);
                // }

                // For each place, get the icon, place name, and location.
                markers = [];
                var bounds = new google.maps.LatLngBounds();
                for (var i = 0, place; place = places[i]; i++) {
                    // var image = {
                    // url: place.icon,
                    // size: new google.maps.Size(71, 71),
                    // origin: new google.maps.Point(0, 0),
                    // anchor: new google.maps.Point(17, 34),
                    // scaledSize: new google.maps.Size(25, 25)
                    // };

                    // Create a marker for each place.
                    // var marker = new google.maps.Marker({
                    // map: map,
                    // icon: image,
                    // title: place.name,
                    // position: place.geometry.location
                    // });

                    // markers.push(marker);
                    // markers.push(DESmarker);

                    bounds.extend(place.geometry.location);
                }

                map.fitBounds(bounds);
            });
            // [END region_getplaces]

            // Bias the SearchBox results towards places that are within the bounds of the
            // current map's viewport.
            google.maps.event.addListener(map, 'bounds_changed', function () {
                var bounds = map.getBounds();
                searchBox.setBounds(bounds);
            });
        }

        function calculateDistances() {
            var service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix({
                origins: [origin],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false
            }, callback);
        }

        function callback(response, status) {
            var minfare = 25;
            var minkm = 2;
            var perkm = 13;
            var fare = 0;
            if (dirRenderer) {
                dirRenderer.setMap(null);
            }
            if (status != google.maps.DistanceMatrixStatus.OK) {
                alert('Error was: ' + status);
            } else {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
                var outputDiv = document.getElementById('outputDiv');
                outputDiv.innerHTML = '';
                for (var i = 0; i < origins.length; i++) {
                    var results = response.rows[i].elements;
                    // addMarker(origins[i], false);
                    for (var j = 0; j < results.length; j++) {
                        // addMarker(destinations[j], true);
                        // outputDiv.innerHTML += origins[i] + ' to ' + destinations[j] + ': ' + results[j].distance.text + ' in '+ results[j].duration.text + '<br>';
                        var dist = Number($.trim(results[j].distance.text.split(' ')[0]));
                        if (dist <= 2)
                            fare = minfare
                        else {
                            dist = dist - 2;
                            fare = minfare + (dist * perkm);
                        }
                        $('#distance').val(results[j].distance.text);
                        $('#amount').val(fare);
                        var request = {
                            origin: origin,
                            destination: destination,
                            travelMode: google.maps.DirectionsTravelMode.DRIVING
                        };
                        directionsService.route(request, function (response, status) {
                            if (status == google.maps.DirectionsStatus.OK) {
                                dirRenderer = new google.maps.DirectionsRenderer({map: map, suppressMarkers: true});
                                dirRenderer.setDirections(response);
                            }
                        });
                    }
                }
            }
        }

        function addMarker(location, isDestination) {
            var icon;
            var drag = false;
            var title = $('#source').val();
            if (isDestination) {
                icon = destinationIcon;
                drag = true;
                title = $('#destination').val();
            } else {
                icon = originIcon;
            }
            geocoder.geocode({'address': location}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    bounds.extend(results[0].geometry.location);
                    map.fitBounds(bounds);
                    var mark = new google.maps.Marker({
                        map: map,
                        title: title,
                        position: results[0].geometry.location,
                        icon: icon,
                        draggable: drag
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        function deleteOverlays() {
            for (var i = 0; i < markersArray.length; i++) {
                markersArray[i].setMap(null);
            }
            markersArray = [];
        }

        window.setTimeout(function () {
            map = new google.maps.Map(document.getElementById('map-canvas'), opts);
            geocoder = new google.maps.Geocoder();

            DESmarker = new google.maps.Marker({
                position: destination,
                title: 'Destination',
                icon: destinationIcon,
                map: map,
                draggable: true
            });

            SRCmarker = new google.maps.Marker({
                position: origin,
                title: 'Origin',
                icon: originIcon,
                map: map
            });

            // Update current position info.
            updateMarkerPosition(origin);
            geocodePosition(origin);
            autofocusSearch();

            // Add dragging event listeners.
            google.maps.event.addListener(DESmarker, 'dragstart', function () {
                updateMarkerAddress('Dragging...');
            });

            google.maps.event.addListener(DESmarker, 'drag', function () {
                updateMarkerStatus('Dragging...');
                updateMarkerPosition(DESmarker.getPosition());
            });

            google.maps.event.addListener(DESmarker, 'dragend', function () {
                updateMarkerStatus('Drag ended');
                geocodePosition(DESmarker.getPosition());
                calculateDistances();
            });

            google.maps.event.addListener(map, 'click', function (event) {
                placeMarker(event.latLng);
                calculateDistances();
            });
            $(billdetails.genButt).on('click', function () {
                billGeneration();
            });
        }, 2500);
    }

}
$(document).ready(function () {
    var win_hg = $(window).height();
//            alert(win_hg);
    var hg = win_hg - 80 + 'px';
    $("#map-panel").css('height', hg);
    $("#content-pane").css('height', hg);
//            $("#left-panel").css('height',hg); 

});
        