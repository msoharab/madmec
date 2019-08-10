function  marketingmanager()
{
    var markcntrl = {};
    var countries = {};
    var states = {};
    var districts = {};
    var cities = {};
    var localities = {};
    var addres = {};
    this.__construct = function (markcontrl) {
        markcntrl = markcontrl;
        fetchMM();
        $(markcntrl.list.menuBut).on('click', function () {
            fetchListOfMM();
        });
        $(markcntrl.add.but).on('click', function () {
            addLocation();
        });
         $(markcntrl.list.menuBut).on('click', function () {
           $(markcntrl.msgDiv).html(''); 
        });
        addres = new Address();
        addres.__construct({url: markcntrl.address.url, outputDiv: markcntrl.outputDiv});
        addres.getIPData();
        countries = addres.getCountry();
        bindAddressFields(markcntrl.address);
    };
    /* Fetching List of Marketing Mangers*/
    function fetchListOfMM()
    {

    }
    function bindAddressFields(fields) {
        var list = countries;
        $(fields.country).focus();
        $(fields.country).val('');
        $(fields.province).val('');
        $(fields.district).val('');
        $(fields.city_town).val('');
        $(fields.st_loc).val('');
        var htm1 = $(fields.prmsg).html();
        var htm2 = $(fields.dimsg).html();
        var htm3 = $(fields.citmsg).html();
        var htm4 = $(fields.stlmsg).html();
        $(fields.country).autocomplete({
            minLength: 2,
            source: list,
            autoFocus: true,
            select: function (event, ui) {
                window.setTimeout(function () {
                    $(fields.country).val(ui.item.label);
                    $(fields.country).attr('name', ui.item.value);
                    fields.countryCode = ui.item.countryCode;
                    fields.PCR_reg = ui.item.PCR;
//					dccode = ui.item.Phone;
//					$(cn.codep + '0').val(ui.item.Phone);
//					for (i = 0; i <= cn.num; i++) {
//						$(document.getElementById(cn.codep + i)).val(ui.item.Phone);
//					}
                    addres.setCountry(ui.item);
                    $(fields.province).val('');
                    $(fields.province).focus();
                }, 50);
                $(fields.province).autocomplete({
                    source: function (request, response) {
                        $(fields.prmsg).html(LOADER_THR);
                        response(addres.getState($(fields.province).val()));
                        $(fields.prmsg).html(htm1);
                    },
                    minLength: 3,
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.province).val(ui.item.label);
                            $(fields.province).attr('name', ui.item.value);
                            fields.provinceCode = ui.item.provinceCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            $(fields.district).val('');
                            $(fields.district).focus();
                            addres.setState(ui.item);
                        }, 50);
                    }
                });
                $(fields.district).autocomplete({
                    minLength: 3,
                    source: function (request, response) {
                        $(fields.dimsg).html(LOADER_THR);
                        response(addres.getDistrict($(fields.district).val()));
                        $(fields.dimsg).html(htm2);
                    },
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.district).val(ui.item.label);
                            $(fields.district).attr('name', ui.item.value);
                            fields.districtCode = ui.item.districtCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            $(fields.city_town).val('');
                            $(fields.city_town).focus();
                            addres.setDistrict(ui.item);
                        }, 50);
                    }
                });
                $(fields.city_town).autocomplete({
                    minLength: 3,
                    source: function (request, response) {
                        $(fields.citmsg).html(LOADER_THR);
                        response(addres.getCity($(fields.city_town).val()));
                        $(fields.citmsg).html(htm3);
                    },
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.city_town).val(ui.item.label);
                            $(fields.city_town).attr('name', ui.item.value);
                            fields.city_townCode = ui.item.city_townCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            $(fields.st_loc).val('');
                            $(fields.st_loc).focus();
                            $(fields.citmsg).html(htm3);
                            addres.setCity(ui.item);
                        }, 50);
                    }
                });
                $(fields.st_loc).autocomplete({
                    minLength: 3,
                    source: function (request, response) {
                        $(fields.stlmsg).html(LOADER_THR);
                        response(addres.getLocality($(fields.st_loc).val()));
                        $(fields.stlmsg).html(htm4);
                    },
                    autoFocus: true,
                    select: function (event, ui) {
                        window.setTimeout(function () {
                            $(fields.st_loc).val(ui.item.label);
                            $(fields.st_loc).attr('name', ui.item.value);
                            fields.st_locCode = ui.item.st_locCode;
                            fields.lat = ui.item.lat;
                            fields.lon = ui.item.lon;
                            fields.timezone = ui.item.timezone;
                            addres.setLocality(ui.item);
                        }, 200);
                    }
                });
            }
        });
    }
    ;

    function addLocation()
    {

        if (Number(markcntrl.add.mgrid) == 0 || markcntrl.add.mgrid == null || markcntrl.add.cmgrid == 0 || markcntrl.add.cmgrid == null)
        {
            $(markcntrl.add.name).focus();
            return;
        }
        else
        {
            var attr = {
                name: $(markcntrl.add.name).val(),
                mgrrid: Number(markcntrl.add.mgrid),
                country: $(markcntrl.address.country).val(),
                countryCode: markcntrl.address.countryCode,
                province: $(markcntrl.address.province).val(),
                provinceCode: markcntrl.address.provinceCode,
                district: $(markcntrl.address.district).val(),
                city_town: $(markcntrl.address.city_town).val(),
                st_loc: $(markcntrl.address.st_loc).val(),
                addrsline: $(markcntrl.address.addrs).val(),
                tphone: $(markcntrl.address.tphone).val(),
                pcode: $(markcntrl.address.pcode).val(),
                zipcode: $(markcntrl.address.zipcode).val(),
                website: $(markcntrl.address.website).val(),
                gmaphtml: $(markcntrl.address.gmaphtml).val(),
                timezone: markcntrl.address.timezone,
                lat: markcntrl.address.lat,
                lon: markcntrl.address.lon
            };
            $(markcntrl.add.but).prop('disabled', 'disabled');
            $(markcntrl.msgDiv).html('');
            $.ajax({
                url: markcntrl.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'marketinglocadd',
                    mmadd: attr
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
                            $(markcntrl.msgDiv).html('<h2>Location  added to database</h2>');
                            $('html, body').animate({
                                scrollTop: Number($(markcntrl.msgDiv).offset().top) - 95
                            }, "slow");
                            markcntrl.add.mgrid = 0;
                            $(markcntrl.add.form).get(0).reset();
                            break;
                    }
                },
                error: function () {
                    $(markcntrl.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    $(markcntrl.add.but).removeAttr('disabled');
                }
            });
        }
    }
    function fetchMM()
    {
        $.ajax({
            url: markcntrl.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'fetchmm',
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
                        var listofmanagers = $.parseJSON(data);
                        var regdno = new Array();
                        if (listofmanagers.flag === true)
                        {
                            for (i = 0; i < (listofmanagers.label).length; i++)
                            {
                                // regdno[i]=details.regdno[i];
                                // drivernames[i]=details.drivernames[i];
                                // drivermobiles[i]=details.drivermobiles[i];

                                /* Soharab code */
                                regdno.push({
                                    label: $.trim(listofmanagers.label[i]),
                                    value: $.trim(listofmanagers.label[i]),
                                    midd: $.trim(listofmanagers.value[i]),
                                });
                                /* Soharab code */
                            }
                            $(markcntrl.add.name).autocomplete({
                                source: regdno,
                                select: function (event, ui) {
                                    markcntrl.add.mgrid = ui.item.midd;
                                },
                                change: function (event, ui) {
                                    markcntrl.add.cmgrid = ui.item.midd;
                                },
                            });
                            $(markcntrl.list.lmmname).autocomplete({
                                source: regdno,
                                select: function (event, ui) {
                                    markcntrl.add.lmgrid = ui.item.midd;
                                    fetchLocationDetails(markcntrl.add.lmgrid);
                                },
//                                change : function (event, ui) {
//                                    markcntrl.add.lcmgrid = ui.item.midd;
//                                    fetchLocationDetails(markcntrl.add.lcmgrid);
//                                },
                            });
                        }
                        ;
                        break;
                }
            },
            error: function () {
                $(markcntrl.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {

            }
        });
    }
    function  fetchLocationDetails(mid)
    {
       $(markcntrl.list.listmm).html(LOADER_ONE); 
        if (mid == 0 || mid == null )
        {
            $(markcntrl.list.lmmname).focus();
            return;
        }
        else
        {
            $.ajax({
                url: markcntrl.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'fetchlocwisemm',
                    mid : mid
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
                            var details=$.parseJSON(data);
                            if(details.status == "success")
                            {
                                var tableheader='<table class="table table-striped table-bordered table-hover" id="list_locwmm_table">';
                                var tabletitle='<thead><tr><th>#</th><th>Address</th><th>Town</th><th>City</th><th>District</th><th>State</th><th>Country</th><th>Zipcode</th></tr></thead><tbody>';
                                var tablefooter='</tbody></table>';
                                
                            $(markcntrl.list.listmm).html(tableheader+tabletitle+details.data+tablefooter);
                            window.setTimeout(function (){
                              $("#list_locwmm_table").dataTable();  
                            },400)
                                markcntrl.add.mgrid = 0;
                                }
                                else
                                {
                                    $(markcntrl.list.listmm).html('<h2 class="text-danger pull-center">no record found</h2>');
                                }
                            break;
                    }
                },
                error: function () {
                    $(markcntrl.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    $(markcntrl.add.but).removeAttr('disabled');
                }
            });
        }
    }
}
;

