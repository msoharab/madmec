function app() {
    var billdetails = {};
    var checkusr = {
        email: 0,
        regdno: 0,
    };
    this.__construct = function (billdetailsctrl) {
        billdetails = billdetailsctrl;
        window.setTimeout(function () {
            $(billdetails.regdno).focus();
        }, 1000);
        $(billdetails.formreferesh).click(function () {
            $(billdetails.genbillform).get(0).reset();
            clearErrors();
        });
        $(billdetails.saveform).on('click', function () {
            validateDriverDetails();
        });
        $(billdetails.signout).on('click', function () {
            $(billdetails.mainOutput).html('<h1>Thank You, See You Have nice Tracking..</h1>');
            window.setTimeout(function () {
                SignOut();
            }, 600)
        });
        $(billdetails.driveremail).change(function () {
            if (this.value.match(email_reg)) {
                $(billdetails.driveremailerr).html(VALIDNOT);
                checkEmail(this.value);
            } else {
                checkusr.email = 0;
                $(billdetails.driveremailerr).html(INVALIDNOT);
                flag = false;
            }
        });
        $(billdetails.driveremail).mouseup(function () {
            if (this.value.match(email_reg)) {
                $(billdetails.driveremailerr).html(VALIDNOT);
                checkEmail(this.value);
            } else {
                checkusr.email = 0;
                $(billdetails.driveremailerr).html(INVALIDNOT);
                flag = false;
            }
        });
        $(billdetails.regdno).change(function () {
            if (this.value.match(name_reg)) {
                $(billdetails.regdnoerr).html(VALIDNOT);
                checkRegdNo(this.value);
            } else {
                checkusr.regdno = 0;
                $(billdetails.driveremailerr).html(INVALIDNOT);
                flag = false;
            }
        });
        $(billdetails.regdno).mouseup(function () {
            if (this.value.match(name_reg)) {
                $(billdetails.regdnoerr).html(VALIDNOT);
                checkRegdNo(this.value);
            } else {
                checkusr.regdno = 0;
                $(billdetails.driveremailerr).html(INVALIDNOT);
                flag = false;
            }
        });
        window.setTimeout(function () {
            startGoogle();
        }, 600);
    };
    function clearErrors() {
        $(billdetails.regdnoerr).html('');
        $(billdetails.drivernameerr).html('');
        $(billdetails.driveremailerr).html('');
        $(billdetails.drivermobileerr).html('');
        $(billdetails.drivertypeerr).html('');
    }
    ;
    function validateDriverDetails() {
        var flag = false;
        if (($(billdetails.driveremail).val() == "") || (!$(billdetails.driveremail).val().match(email_reg)))
        {
            flag = false;
            $(billdetails.driveremail).focus();
            $(billdetails.driveremailerr).html(INVALIDNOT);
            return;
        }
        else
        {
            $(billdetails.driveremailerr).html('');
            flag = true;
        }
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
            $(billdetails.drivermobileerr).html('');
        }
        if (($(billdetails.usertype).val() == "") || (!$(billdetails.usertype).val().match(numbs)))
        {
            flag = false;
            $(billdetails.usertype).focus();
            $(billdetails.drivertypeerr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(billdetails.drivertypeerr).html('');
        }
        attr = {
            regdno: $(billdetails.regdno).val(),
            drivername: $(billdetails.drivername).val(),
            driveremail: $(billdetails.driveremail).val(),
            drivermobile: $(billdetails.drivermobile).val(),
            usertype: $(billdetails.usertype).val()
        };
        console.log(attr);
        console.log(checkusr);
        if (flag && checkusr.regdno && checkusr.email)
        {
            $(billdetails.regdnoerr).html(VALIDNOT);
            $(billdetails.drivernameerr).html(VALIDNOT);
            $(billdetails.driveremailerr).html(VALIDNOT);
            $(billdetails.drivermobileerr).html(VALIDNOT);
            $(billdetails.drivertypeerr).html(VALIDNOT);
            attr = {
                regdno: $(billdetails.regdno).val(),
                drivername: $(billdetails.drivername).val(),
                driveremail: $(billdetails.driveremail).val(),
                drivermobile: $(billdetails.drivermobile).val(),
                usertype: $(billdetails.usertype).val()
            };
            saveUserDetails(attr);
        }
    }
    ;
    function saveUserDetails(attr) {
        $(billdetails.saveform).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: billdetails.url,
            data: {
                autoloader: true,
                action: 'saveUserDetails',
                attr: attr
            },
            success: function (data, textStatus, xhr) {
                console.log(data)
                $(billdetails.saveform).html('Save');
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        break;
                }
            },
            error: function () {
                $(billdetails.saveform).html('Save');
                throw new Error('Could Not Connect To The Server... = ' + URL);
            },
            complete: function (xhr, textStatus) {
                $(billdetails.saveform).html('Save');
                console.log(xhr.status);
            }
        });
    }
    ;
    function checkEmail(email) {
        var checkemail = billdetails.checkemail;
        $.ajax({
            url: checkemail.url,
            type: 'POST',
            data: {
                autoloader: checkemail.autoloader,
                action: checkemail.action,
                email: email
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                if (Number(data)) {
                    checkusr.email = 0;
                    $(checkemail.outputDiv).html('<span class="text-danger"><strong>Email Id Already Exist</strong></span>');
                    flag = false;
                } else {
                    checkusr.email = 1;
                    $(checkemail.outputDiv).html(VALIDNOT);
                    flag = true;
                }
            },
            error: function (xhr, textStatus) {
                $(checkemail.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function checkRegdNo(email) {
        var checkemail = billdetails.checkRegdNo;
        $.ajax({
            url: checkemail.url,
            type: 'POST',
            data: {
                autoloader: checkemail.autoloader,
                action: checkemail.action,
                email: email
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                if (Number(data)) {
                    checkusr.regdno = 0;
                    $(checkemail.outputDiv).html('<span class="text-danger"><strong>Vehicle Id Already Exist</strong></span>');
                    flag = false;
                } else {
                    checkusr.regdno = 1;
                    $(checkemail.outputDiv).html(VALIDNOT);
                    flag = true;
                }
            },
            error: function (xhr, textStatus) {
                $(checkemail.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function SignOut() {
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
    ;
    function getUser() {

    }
    ;
    function startGoogle() {
        console.log(billdetails);
        var map;
        var geocoder;
        var bounds = new google.maps.LatLngBounds();
        var markersArray = [];
        var SRCmarker = new google.maps.Marker({});
        var origins = [];
        var origin = new google.maps.LatLng(12.898085, 77.588968); // MadMec
        //var origin = new google.maps.LatLng(12.980954,77.574769); // HITECH PREPAID STATION
        //var origin = new google.maps.LatLng(12.9749632, 77.6044059); // Mgaadi Garuda Mall
        var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=AvtiveUser|FFFF00|000000';
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
            zoom: 18
        };
        var latlangs = [];
        var listofusers = [];
        /*
         $(billdetails.moveLocations).on('click', function () {
         $.ajax({
         type: 'POST',
         url: billdetails.url,
         async: false,
         data: {
         autoloader: true,
         action: 'getLocations'
         },
         success: function (data, textStatus, xhr) {
         //console.log(data);
         //console.log(typeof data);
         //console.log(data[0]);
         data = $.parseJSON($.trim(data));
         //console.log(typeof data);
         //console.log(data[0]);
         switch (data) {
         case 'logout':
         logoutAdmin({});
         break;
         case 'login':
         loginAdmin({});
         break;
         default:
         //console.log(latlangs);
         //console.log(latlangs[0]);
         latlangs = data;
         playMarker1(0);
         break;
         }
         },
         error: function () {
         throw new Error('Could Not Connect To The Server... = ' + URL);
         },
         complete: function (xhr, textStatus) {
         console.log(xhr.status);
         }
         });
         });
         */
        $(billdetails.saveLocations).on('click', function () {
            console.log(latlangs);
            if (latlangs.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: billdetails.url,
                    data: {
                        autoloader: true,
                        action: 'saveLocations',
                        locations: latlangs
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
                                playMarker1(0);
                                break;
                        }
                    },
                    error: function () {
                        throw new Error('Could Not Connect To The Server... = ' + URL);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        });
        function playMarker1(loop) {
            console.log('Latitude = ' + latlangs[loop].lat);
            console.log('Longititude = ' + latlangs[loop].lng);
            SRCmarker.setMap(null);
            SRCmarker = new google.maps.Marker({
                position: new google.maps.LatLng(latlangs[loop].lat, latlangs[loop].lng),
                title: 'Origin',
                icon: originIcon,
                map: map,
                draggable: true
            });
            updateMarkerPosition(SRCmarker.getPosition());
            geocodePosition(SRCmarker.getPosition());
            window.setTimeout(function () {
                if (loop < latlangs.length) {
                    loop++;
                    playMarker2(loop);
                }
                else {
                    return;
                }
            }, 200);
        }
        function playMarker2(loop) {
            console.log('Latitude = ' + latlangs[loop].lat);
            console.log('Longititude = ' + latlangs[loop].lng);
            SRCmarker.setMap(null);
            SRCmarker = new google.maps.Marker({
                position: new google.maps.LatLng(latlangs[loop].lat, latlangs[loop].lng),
                title: 'Origin',
                icon: originIcon,
                map: map,
                draggable: true
            });
            updateMarkerPosition(SRCmarker.getPosition());
            geocodePosition(SRCmarker.getPosition());
            window.setTimeout(function () {
                if (loop < latlangs.length) {
                    loop += 2;
                    playMarker1(loop);
                }
                else {
                    return;
                }
            }, 300);
        }

        function geocodePosition(pos,id) {
            console.log(pos);
            geocoder.geocode({
                latLng: pos,
            }, function (responses) {
                if (responses && responses.length > 0) {
                    $(id).html(responses[0].formatted_address);
                } else {
                    $(id).html('Cannot determine address at this location.');
                }
                //if (responses && responses.length > 0) {
                    //updateMarkerAddress(responses[0].formatted_address);
                //} else {
                    //updateMarkerAddress('Cannot determine address at this location.');
                //}
                // calculateDistances();
            });
        }

        function updateMarkerStatus(str) {
            document.getElementById('markerStatus').innerHTML = str;
        }

        function updateMarkerPosition(latLng) {
            //document.getElementById('info').innerHTML = [
                //latLng.lat(),
                //latLng.lng()
            //].join(', ');
            //destination = latLng;
            //latlangs.push({
            //    lat: latLng.lat(),
            //    lng: latLng.lng()
            //});
        }

        function updateMarkerAddress(str) {
            document.getElementById('address').innerHTML = str;
            //$('#destination').val(str);
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
                        //$('#distance').val(results[j].distance.text);
                        //$('#amount').val(fare);
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
            //var title = $('#source').val();
            var title = '';
            if (isDestination) {
                icon = destinationIcon;
                drag = true;
                //title = $('#destination').val();
                title = '';
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
            /*
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
             map: map,
             draggable: true
             });
             //Update current position info.
             updateMarkerPosition(origin);
             geocodePosition(origin);
             autofocusSearch();
             //Add dragging event listeners.
             google.maps.event.addListener(SRCmarker, 'dragstart', function () {
             updateMarkerAddress('Dragging Start...');
             });
             google.maps.event.addListener(SRCmarker, 'drag', function () {
             updateMarkerStatus('Dragging...');
             updateMarkerPosition(SRCmarker.getPosition());
             });
             google.maps.event.addListener(SRCmarker, 'dragend', function () {
             updateMarkerStatus('Drag End...');
             geocodePosition(SRCmarker.getPosition());
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
             */
            function playMarker() {
                if (listofusers.length > 0) {
                    for (i = 0; i < listofusers.length; i++) {
                        //listofusers[i].marker.setMap(null);
                        //updateMarkerPosition(listofusers[i].marker.getPosition());
                        geocodePosition(listofusers[i].marker.getPosition(),listofusers[i].address);
                    }
                }
                else {
                    throw new Error('User list is empty, Press F5!!!');
                }
            }
            function clearMarker() {
                $(billdetails.getuser).html('Clear Map For you......');
                if (listofusers.length > 0) {
                    for (i = 0; i < listofusers.length; i++) {
                        listofusers[i].marker.setMap(null);
                    }
                }
                else {
                    console.log('User list is empty, Press F5!!!');
                }
            }
            function getUsers1() {
                clearMarker();
                $(billdetails.getuser).html('Loading please wait......');
                $.ajax({
                    type: 'POST',
                    url: billdetails.url,
                    async: false,
                    data: {
                        autoloader: true,
                        action: 'getUsers'
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.trim(data);
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            default:
                                var listusers = $.parseJSON(data);
                                var htm = '';
                                if (listusers.length > 0) {
                                    for (i = 0; i < listusers.length; i++) {
                                        var addr = 'address_user'+i;
                                        htm += '<p">' +
                                                (i + 1) + ' - ' +
                                                listusers[i].user_name + ' - ' +
                                                listusers[i].cell_number + + ' - ' +
                                                listusers[i].lat + ' , ' + listusers[i].lng +'</p><p id="'+addr+'"  style="border-bottom:solid 1px;></p>';
                                        listofusers.push({
                                            id: listusers[i].id,
                                            name: listusers[i].user_name,
                                            email: listusers[i].email,
                                            cell: listusers[i].cell_number,
                                            lat: listusers[i].lat,
                                            lng: listusers[i].lng,
                                            address: '#'+addr,
                                            marker: new google.maps.Marker({
                                                position: new google.maps.LatLng(listusers[i].lat, listusers[i].lng),
                                                title: 'Origin',
                                                icon: 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=' + listusers[i].user_name + '|FFFF00|000000',
                                                map: map,
                                                draggable: true
                                            })
                                        });
                                        $('#'+addr).html('Loading Closest Matching Address');
                                    }
                                    window.setTimeout(function () {
                                        playMarker();
                                    }, 3000);
                                    window.setTimeout(function () {
                                        getUsers2();
                                    }, 18500);
                                }
                                else {
                                    htm = '<span>Users Not found........, Press F5!!!</span>';
                                    throw new Error('User list is empty, Press F5!!!');
                                }
                                $(billdetails.getuser).html(htm);
                                break;
                        }
                    },
                    error: function () {
                        throw new Error('Could Not Connect To The Server... = ' + URL);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
            function getUsers2() {
                window.setTimeout(function () {
                    getUsers1();
                }, 25000);
            }
            $(billdetails.moveLocations).on('click', function () {
                getUsers1();
            });
        }, 2500);
    }
    ;
}
$(document).ready(function () {
    var win_hg = $(window).height();
    var hg = win_hg - 80 + 'px';
    $("#map-panel").css('height', hg);
    $("#content-pane").css('height', hg);
    var billgendetails = {
        genbillform: '#genbillform',
        regdno: '#regdno',
        drivername: '#drivername',
        driveremail: '#driveremail',
        drivermobile: '#drivermobile',
        usertype: '#usertype',
        formreferesh: '#formreferesh',
        saveform: '#saveform',
        driverid: 0,
        drivercheck: 0,
        regdnoerr: '#regdnoerr',
        drivernameerr: '#drivernameerr',
        driveremailerr: '#driveremailerr',
        drivermobileerr: '#drivermobileerr',
        drivertypeerr: '#drivertypeerr',
        mainOutput: '#mainOutput',
        signout: '#signout',
        url: 'control.php',
        saveLocations: '#saveLocations',
        moveLocations: '#moveLocations',
        getuser: '#listusers',
        checkemail: {
            autoloader: true,
            action: 'checkemail',
            outputDiv: '#driveremailerr',
            url: 'control.php',
            display: false
        },
        checkRegdNo: {
            autoloader: true,
            action: 'checkRegdNo',
            outputDiv: '#regdnoerr',
            url: 'control.php',
            display: false
        },
    };
    var obj = new app();
    obj.__construct(billgendetails);
});
