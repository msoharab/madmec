function Address() {
    var addata = {};
    var ipdata = {};
    var dccode = '91';
    var dpcode = '080';
    var url = '';
    var outputDiv = '';
    this.__construct = function (para) {
        if (para.url != '' || para.url != null) {
            url = para.url;
        } else {
            url = URL + 'address.php';
        }
        if (para.outputDiv != '' || para.outputDiv != null) {
            outputDiv = para.outputDiv;
        } else {
            outputDiv = '#output';
        }
	addata = {
		url: null,
		outputDiv: null,
		country: null,
		countryCode: null,
		province: null,
		provinceCode: null,
		district: null,
		districtCode: null,
		city_town: null,
		city_townCode: null,
		st_loc: null,
		st_locCode: null,
		zipcode: null,
		lat: null,
		lon: null,
		codep: null,
		PCR_reg: null,
		countryId: null,
		provinceId: null,
		districtId: null,
		city_townId: null,
		st_locId: null,
		timezone: null,
		txt: null
	};
    };
    this.getIPData = function () {
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {autoloader: true, action: 'getIPData'},
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
                        ipdata = $.parseJSON(data);
                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        addata.country = ipdata.country;
        addata.countryCode = ipdata.countryCode;
        addata.PCR_reg = '';
        addata.province = ipdata.province;
        addata.provinceCode = ipdata.provinceCode;
        addata.district = ipdata.district;
        addata.districtCode = ipdata.districtCode;
        addata.city_town = ipdata.city_town;
        addata.city_townCode = ipdata.city_townCode;
        addata.lat = ipdata.lat;
        addata.lon = ipdata.lon;
        addata.timezone = ipdata.timezone;
        return ipdata;
    };
    this.fillAddressFields = function (usr) {
        /* $(usr.add.address.country).val(ipdata.country);  */
        /* $(usr.add.address.province).val(ipdata.regionName);  */
        /* $(usr.add.address.district).val(ipdata.city);  */
        /* $(usr.add.address.city_town).val(ipdata.city);  */
        /* $(usr.add.address.zipcode).val(ipdata.zip);  */
        /* $(usr.add.address.pcode).val(dpcode);  */
        /* usr.add.address.countryCode = ipdata.countryCode;  */
        /* usr.add.address.provinceCode = ipdata.region;  */
        /* usr.add.address.lat = ipdata.lat;  */
        /* usr.add.address.lon = ipdata.lon;  */
        /* usr.add.address.timezone = ipdata.timezone;  */
        /* usr.add.address.cnumber.codep = dccode;  */
        /* usr.add.address.pcode = dpcode;  */
        /* usr.add.address.PCR_reg = ipdata.PCR; */
    };
    this.getCountry = function () {
        var cont = '';
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {autoloader: true, action: 'getCountry'},
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
                    default:
                        cont = $.parseJSON(data);
                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        return cont;
    };
    this.getState = function (txt) {
        var cont = '';
        addata.txt = txt;
	console.log(addata);
        if (txt.length > 2) {
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {autoloader: true, action: 'getState', addata: addata},
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
                        default:
                            cont = $.parseJSON(data);
                            break;
                    }
                },
                error: function () {
                    $(outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        return cont;
    };
    this.getDistrict = function (txt) {
        var cont = '';
        addata.txt = txt;
        if (txt.length > 2) {
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {autoloader: true, action: 'getDistrict', addata: addata},
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
                        default:
                            cont = $.parseJSON(data);
                            break;
                    }
                },
                error: function () {
                    $(outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        return cont;
    };
    this.getCity = function (txt) {
        var cont = '';
        addata.txt = txt;
        if (txt.length > 2) {
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {autoloader: true, action: 'getCity', addata: addata},
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
                        default:
                            cont = $.parseJSON(data);
                            break;
                    }
                },
                error: function () {
                    $(outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        return cont;
    };
    this.getLocality = function (txt) {
        var cont = '';
        addata.txt = txt;
        if (txt.length > 2) {
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {autoloader: true, action: 'getLocality', addata: addata},
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
                        default:
                            cont = $.parseJSON(data);
                            break;
                    }
                },
                error: function () {
                    $(outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        return cont;
    };
    this.setCountry = function (para) {
        addata.country = para.Country;
        addata.countryCode = para.countryCode;
        addata.PCR_reg = para.PCR;
        addata.codep = para.Phone;
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {autoloader: true, action: 'setCountry', addata: addata},
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
                    default:

                        break;
                }
            },
            error: function () {
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    };
    this.setState = function (para) {
        addata.province = para.province;
        addata.provinceCode = para.provinceCode;
        addata.lat = para.lat;
        addata.lon = para.lon;
        addata.timezone = para.timezone;
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {autoloader: true, action: 'setState', addata: addata},
            success: function (data, textStatus, xhr) {
                console.log(xhr.status);
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
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    };
    this.setDistrict = function (para) {
        addata.district = para.district;
        addata.districtCode = para.districtCode;
        addata.lat = para.lat;
        addata.lon = para.lon;
        addata.timezone = para.timezone;
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {autoloader: true, action: 'setDistrict', addata: addata},
            success: function (data, textStatus, xhr) {
                console.log(xhr.status);
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
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    };
    this.setCity = function (para) {
        addata.city_town = para.city_town;
        addata.city_townCode = para.city_townCode;
        addata.lat = para.lat;
        addata.lon = para.lon;
        addata.timezone = para.timezone;
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {autoloader: true, action: 'setCity', addata: addata},
            success: function (data, textStatus, xhr) {
                console.log(xhr.status);
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
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    };
    this.setLocality = function (para) {
        addata.st_loc = para.city_town;
        addata.st_locCode = para.city_townCode;
        addata.lat = para.lat;
        addata.lon = para.lon;
        addata.timezone = para.timezone;
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: {autoloader: true, action: 'setLocality', addata: addata},
            success: function (data, textStatus, xhr) {
                console.log(xhr.status);
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
                $(outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    };
}