function clientController() {
    var uadd ={};
    var docpath = {};
    var ct = {};
    var usr = {};
    var uem = {};
    var ucn = {};
    var add = {};
    var em = {};
    var cn = {};
    var cn = {};
    var userasn = {};
    var lusr = {};
    var dflag = false;
    var dccode = '91';
    var dpcode = '080';
    this.__construct = function (clnt) {
        ct = clnt;
        uadd = clnt.addusr;
        uem = clnt.addusr.em;
        ucn = clnt.addusr.cn;
        add = clnt.addgym;
        em = clnt.addgym.em;
        cn = clnt.addgym.cn;
        userasn = clnt.assignuser;
        luser = clnt.listuser;
        $(uadd.picbox).picEdit({
            imageUpdated: function (img) {
            },
            formSubmitted: function (data) {
                var dataValue = $.trim(data.response.replace(/[\t\n]+/g, ' '));
                console.log(dataValue);
                switch (dataValue) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    case 'email':
                        $(ct.msgDiv).html('<h2>Minimum 1 Email required</h2>');
                        break;
                    case '':
                        $(ct.msgDiv).html('<h2>Enter proper required field</h2>');
                        window.setTimeout(function () {
                            $(ct.msgDiv).html('');
                        }, 2000);
                        break;
                    default:
                        $(ct.msgDiv).html('<h2>Record success fully added</h2>');
                        $(loader).hide();
                        $(uadd.form).get(0).reset();
                        window.setTimeout(function () {
                            $(ct.msgDiv).html('');
                        }, 2000);
                        break;
                }
            },
            redirectUrl: false,
            defaultImage: URL + ASSET_IMG + 'No_image.png',
        });
        $(uadd.dob).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: "-100:+100",
            maxDate: '-7Y',
        });
        $(add.but).click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            gymAdd();
        });
        $(add.tab).click(function () {
            userAutoComplete();
        });
        /*~ var $form = $(uadd.form);*/
        /*~ $form.find('input[type="submit"]').click(function() {*/
        /*~ return false;*/
        /*~ });*/
        initializeProfileAddForm();
        initializeUserAddForm();
        initializeUserList(dflag);
        fetchuserngyms();
    };
    function fetchuserngyms()
    {
        $.ajax({
            url: ct.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'fetchusersngyms',
                type: 'master',
            },
            success: function (data, textStatus, xhr) {
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    default:
                        var details = $.parseJSON(data);
                        var userdata = new Array();
                        var ownerdata = new Array();
                        for (i = 0; i < details.userdata.length; i++)
                        {
                            userdata.push({
                                label: details.userdata[i],
                                data: details.userdata[i],
                                ids: details.userids[i],
                            })
                        }
                        for (i = 0; i < details.ownerdata.length; i++)
                        {
                            ownerdata.push({
                                label: details.ownerdata[i],
                                data: details.ownerdata[i],
                                ids: details.ownerids[i],
                            })
                        }
                        $(userasn.asignuser).autocomplete({
                            source: userdata,
                            select: function (event, ui) {
                                $(userasn.asignuser).val(ui.item.label);
                                userasn.userid = ui.item.ids
                                return false;
                            },
                        });
                        $(userasn.asignowner).autocomplete({
                            minLength: 0,
                            source: ownerdata,
                            focus: function (event, ui) {
                                $(userasn.asignowner).val(ui.item.label);
                                userasn.ownerid = ui.item.ids
                                return false;
                            },
                            select: function (event, ui) {
                                $(userasn.asignowner).val(ui.item.label);
                                userasn.ownerid = ui.item.ids
                                fetchownergyms(ui.item.ids);
                                return false;
                            },
                        });
                        $(userasn.form).submit(function (evt) {
                            evt.preventDefault();
                            var attr = {
                                userid: userasn.userid,
                                gymid: userasn.gymid, 
                                ownerid: userasn.ownerid,
                            };
                            $.ajax({
                                url: ct.url,
                                type: 'POST',
                                data: {
                                    autoloader: true,
                                    action: 'addusertogym',
                                    type: 'master',
                                    det: attr
                                },
                                success: function (data, textStatus, xhr) {
                                    /*data = $.parseJSON($.trim(data));*/
                                    switch (data) {
                                        case 'logout':
                                            logoutAdmin({});
                                            break;
                                        default:
                                            var details = $.parseJSON($.trim(data));
                                            if (details.status == "alreadyexist")
                                            {
                                                alert("User is Already Assign to this GYM")
                                            }
                                            else if (details.status == "pending")
                                            {
                                                alert("Approval is pending From GYM Owner");
                                            }
                                            else
                                            {
                                                alert("User has been Successfully Added to this GYM");
                                                $(userasn.form).get(0).reset();
                                            }
                                            break;
                                    }
                                },
                                error: function (xhr, textStatus) {
                                    $(gymbasicinfo.outputDiv).html(INET_ERROR);
                                },
                                complete: function (xhr, textStatus) {
                                    console.log(xhr.status);
                                }
                            });
                        });
                        break;
                }
            },
            error: function (xhr, textStatus) {
                $(gymbasicinfo.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    
    function fetchownergyms(val)
    {
        var gymdata = new Array();
        $(userasn.asignuser).val('');
        $(userasn.asigngym).val('');
        gymdata.length=0;
        $.ajax({
			url : ct.url,
			type : 'POST',
			data : {
				autoloader : 'true',
				action : 'displayallgymsofowner',
				type : 'master',
				ownerid : val,
			},
			success : function (data) {
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
                        
                        for (i = 0; i < details.gymdata.length; i++)
                        {
                            gymdata.push({
                                label: details.gymdata[i],
                                data: details.gymdata[i],
                                ids: details.gymids[i],
                            })
                        }
                        $(userasn.asigngym).autocomplete({
                            minLength: 0,
                            source: gymdata,
                            focus: function (event, ui) {
                                $(userasn.asigngym).val(ui.item.label);
                                userasn.gymid = ui.item.ids;
                                return false;
                            },
                            select: function (event, ui) {
                                $(userasn.asigngym).val(ui.item.label);
                                userasn.gymid = ui.item.ids;
                                return false;
                            },
                        });
					break;
				}
			},
			error : function () {
				$(OUTPUT).html(INET_ERROR);
			},
			complete : function (xhr, textStatus) {
				/*console.log(xhr.status);*/
			}
		});
    }
    
    this.gymAddressEditBasicInfo = function (binfo) {
        var gymbasicinfo = binfo;
        $(gymbasicinfo.editbut).click(function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            /*alert($(gymbasicinfo.addrs).val());*/
            /*editBasicInfo();*/
            $(gymbasicinfo.showDiv).hide();
            $(gymbasicinfo.editbut).hide();
            $(gymbasicinfo.updateDiv).show();
            $(gymbasicinfo.closebut).click(function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                $(gymbasicinfo.showDiv).show();
                $(gymbasicinfo.editbut).show();
                $(gymbasicinfo.updateDiv).hide();
            });
            $(gymbasicinfo.savebut).click(function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                flag = false;
                /* check validation for country*/
                if ($(gymbasicinfo.country).val()) {
                    flag = true;
                    $(gymbasicinfo.comsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.comsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.comsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.comsg).focus();
                    return;
                }
                /* check validation for state*/
                if ($(gymbasicinfo.province).val()) {
                    flag = true;
                    $(gymbasicinfo.prmsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.prmsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.prmsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.prmsg).focus();
                    return;
                }
                /* check validation for district*/
                if ($(gymbasicinfo.district).val()) {
                    flag = true;
                    $(gymbasicinfo.dimsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.dimsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.dimsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.dimsg).focus();
                    return;
                }
                /* check validation for city*/
                if ($(gymbasicinfo.city_town).val()) {
                    flag = true;
                    $(gymbasicinfo.citymsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.citymsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.citymsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.citymsg).focus();
                    return;
                }
                /* check validation for street*/
                if ($(gymbasicinfo.st_loc).val()) {
                    flag = true;
                    $(gymbasicinfo.stlmsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.stlmsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.stlmsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.stlmsg).focus();
                    return;
                }
                /* check validation for address*/
                if ($(gymbasicinfo.addrs).val()) {
                    flag = true;
                    $(gymbasicinfo.admsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.admsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.admsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.admsg).focus();
                    return;
                }
                /* check validation for zipcode*/
                if ($(gymbasicinfo.zipcode).val()) {
                    flag = true;
                    $(gymbasicinfo.zimsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.zimsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.zimsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.zimsg).focus();
                    return;
                }
                /* check validation for website*/
                if ($(gymbasicinfo.website).val()) {
                    flag = true;
                    $(gymbasicinfo.wemsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.wemsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.wemsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.wemsg).focus();
                    return;
                }
                /* check validation for url*/
                if ($(gymbasicinfo.gmaphtml).val()) {
                    flag = true;
                    $(gymbasicinfo.gmmsg).html("<blink><font color=green>Valid</font></blink>");
                } else {
                    flag = false;
                    $(gymbasicinfo.gmmsg).html("<blink><font color=red>Invalid</font></blink>");
                    $('html, body').animate({
                        scrollTop: Number($(gymbasicinfo.gmmsg).offset().top) - 55
                    }, "slow");
                    $(gymbasicinfo.gmmsg).focus();
                    return;
                }
                if (flag) {
                    var attr = {
                        gymid: gymbasicinfo.gymid,
                        index: gymbasicinfo.index,
                        gymname: $(gymbasicinfo.gymname).val(),
                        gymtype: $(gymbasicinfo.gymtype).val(),
                        db_host: $(gymbasicinfo.db_host).val(),
                        db_username: $(gymbasicinfo.db_username).val(),
                        db_name: $(gymbasicinfo.db_name).val(),
                        db_password: $(gymbasicinfo.db_password).val(),
                        short_logo: $(gymbasicinfo.short_logo).val(),
                        header_logo: $(gymbasicinfo.header_logo).val(),
                        postal_code: $(gymbasicinfo.postal_code).val(),
                        telephone: $(gymbasicinfo.telephone).val(),
                        directory: $(gymbasicinfo.directory).val(),
                        currency_code: $(gymbasicinfo.currency_code).val(),
                        reg_fee: $(gymbasicinfo.reg_fee).val(),
                        service_tax: $(gymbasicinfo.service_tax).val(),
                        country: $(gymbasicinfo.country).val(),
                        province: $(gymbasicinfo.province).val(),
                        district: $(gymbasicinfo.district).val(),
                        city_town: $(gymbasicinfo.city_town).val(),
                        st_loc: $(gymbasicinfo.st_loc).val(),
                        addrs: $(gymbasicinfo.addrs).val(),
                        zipcode: $(gymbasicinfo.zipcode).val(),
                        website: $(gymbasicinfo.website).val(),
                        gmaphtml: $(gymbasicinfo.gmaphtml).val()
                    };
                    $.ajax({
                        url: gymbasicinfo.url,
                        type: 'POST',
                        data: {
                            autoloader: true,
                            action: 'gymeditAddrBasicInfo',
                            addBinfo: attr
                        },
                        success: function (data, textStatus, xhr) {
                            /*data = $.parseJSON($.trim(data));*/
                            switch (data) {
                                case 'logout':
                                    logoutAdmin({});
                                    break;
                                default:
                                    /*$(gymbasicinfo.reloadBut).trigger('click');*/
                                    alert("updated");
                                    break;
                            }
                        },
                        error: function (xhr, textStatus) {
                            $(gymbasicinfo.outputDiv).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                            console.log(xhr.status);
                        }
                    });
                }
            });
        });
    }
    this.bindAddressFields = function (addres) {
        var list = this.countries;
        $(add.address.country).autocomplete({
            minLength: 2,
            source: list,
            autoFocus: true,
            select: function (event, ui) {
                window.setTimeout(function () {
                    $(add.address.country).val(ui.item.label);
                    $(add.address.country).attr('name', ui.item.value);
                    add.address.countryCode = ui.item.countryCode;
                    add.address.PCR_reg = ui.item.PCR;
                    dccode = ui.item.Phone;
                    $(cn.codep + '0').val(ui.item.Phone);
                    for (i = 0; i <= cn.num; i++) {
                        $(document.getElementById(cn.codep + i)).val(ui.item.Phone);
                    }
                    addres.setCountry(ui.item);
                    $(add.address.province).val('');
                    $(add.address.province).focus();
                }, 50);
                $(add.address.province).focus(function () {
                    this.states = addres.getState();
                    var list = this.states;
                    $(add.address.province).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.province).val(ui.item.label);
                                $(add.address.province).attr('name', ui.item.value);
                                add.address.provinceCode = ui.item.provinceCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setState(ui.item);
                                $(add.address.district).val('');
                                $(add.address.district).focus();
                            }, 50);
                        }
                    });
                });
                $(add.address.district).focus(function () {
                    this.districts = addres.getDistrict();
                    var list = this.districts;
                    $(add.address.district).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.district).val(ui.item.label);
                                $(add.address.district).attr('name', ui.item.value);
                                add.address.districtCode = ui.item.districtCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setDistrict(ui.item);
                                $(add.address.city_town).val('');
                                $(add.address.city_town).focus();
                            }, 50);
                        }
                    });
                });
                $(add.address.city_town).focus(function () {
                    this.cities = addres.getCity();
                    var list = this.cities;
                    $(add.address.city_town).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.city_town).val(ui.item.label);
                                $(add.address.city_town).attr('name', ui.item.value);
                                add.address.city_townCode = ui.item.city_townCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setCity(ui.item);
                                $(add.address.st_loc).val('');
                                $(add.address.st_loc).focus();
                            }, 50);
                        }
                    });
                });
                $(add.address.st_loc).focus(function () {
                    this.localities = addres.getLocality();
                    var list = this.localities;
                    $(add.address.st_loc).autocomplete({
                        minLength: 2,
                        source: list,
                        autoFocus: true,
                        select: function (event, ui) {
                            window.setTimeout(function () {
                                $(add.address.st_loc).val(ui.item.label);
                                $(add.address.st_loc).attr('name', ui.item.value);
                                add.address.st_locCode = ui.item.st_locCode;
                                add.address.lat = ui.item.lat;
                                add.address.lon = ui.item.lon;
                                add.address.timezone = ui.item.timezone;
                                addres.setLocality(ui.item);
                            }, 200);
                        }
                    });
                });
            }
        });
    };
    this.close = function (clid) {
        var cl = clid;
        $(cl.closeDiv).click(function () {
            $(cl.clisttab).click();
        });
    }
    this.editUserEmailIds = function (email) {
        var em = email;
        var min = em.num;
        $(em.but).bind("click", function () {
            em.num = min;
            $(em.but).toggle();
            $('#' + em.saveBut).toggle();
            loadEmailIdForm();
        });
        function loadEmailIdForm() {
            em.num = min;
            $(em.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientEmailId',
                    type: 'master',
                    det: em
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data.html);
                            $(document).ready(function () {
                                $('#' + em.plus).click(function () {
                                    addMultipleEmailIds();
                                });
                                $('#' + em.saveBut).click(function () {
                                    editEmailId();
                                });
                                $('#' + em.minus).bind('click', function () {
                                    minusMultipleEmailIds();
                                    return false;
                                });
                                $('#' + em.closeBut).click(function () {
                                    $(em.but).toggle();
                                    $('#' + em.saveBut).toggle();
                                    listEmailIds();
                                });
                                window.setTimeout(function () {
                                    if (data.oldemail) {
                                        for (i = 0; i < data.oldemail.length; i++) {
                                            var cid = Number(data.oldemail[i].id);
                                            $('#' + data.oldemail[i].deleteOk).bind("click", {
                                                param1: cid
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteEmailId(event.data.param1)) {
                                                    loadEmailIdForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function addMultipleEmailIds() {
            /* console.log(em.num);*/
            em.num++;
            for (i = min; i < em.num; i++) {
                $(document.getElementById(em.minus + i + '_delete')).hide();
            }
            var oldemail = {
                formid: em.form + em.num,
                textid: em.email + em.num,
                msgid: em.msgDiv + em.num,
                deleteid: em.minus + em.num + '_delete'
            };
            var html = '<div><div class="form-group input-group" id="' + oldemail.formid + '">' +
                    '<input class="form-control" required placeholder="Email Id" name="email" type="text" id="' + oldemail.textid + '" maxlength="100"/>' +
                    '<span class="input-group-addon"></span>' +
                    '</div><div class="col-lg-16"><p class="help-block" id="' + oldemail.msgid + '">Enter/ Select.</p></div></div>';
            $(em.parentDiv).append(html);
            window.setTimeout(function () {
                $(document.getElementById(oldemail.deleteid)).click(function () {
                    if (em.num >= min)
                        em.num--;
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(em.minus + em.num + '_delete')).show();
                });
            }, 200);
        }
        ;
        function minusMultipleEmailIds() {
            var oldemail = {
                formid: em.form + em.num,
                textid: em.email + em.num,
                msgid: em.msgDiv + em.num,
                deleteid: em.minus + em.num + '_delete'
            };
            $(document.getElementById(oldemail.textid)).remove();
            $(document.getElementById(oldemail.msgid)).remove();
            $(document.getElementById(oldemail.formid)).remove();
            em.num--;
            window.setTimeout(function () {
                $(document.getElementById(oldemail.deleteid)).click(function () {
                    if (em.num >= min) {
                        em.num--;
                    }
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(em.minus + em.num + '_delete')).hide();
                });
            }, 200);
        }
        ;
        function editEmailId() {
            var insert = [];
            var update = [];
            var emailids = {
                insert: insert,
                update: update,
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            /* min*/
            /* Email Ids */
            /*console.log("save"+em.num);*/
            if (em.num > -1) {
                j = 0;
                k = 0;
                for (i = 1; i <= em.num; i++) {
                    /*console.dir($(document.getElementById(em.email+i)));*/
                    /* console.log(em.email+i);*/
                    var ems = $(document.getElementById(em.email + i)).val();
                    var id = $(document.getElementById(em.email + i)).prop('name');
                    if (ems.match(email_reg)) {
                        flag = true;
                        $(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
                        if (id != 'email') {
                            update[j] = {
                                email: ems,
                                id: id
                            };
                            j++;
                        } else if (id == 'email') {
                            insert[k] = ems;
                            k++;
                        }
                    } else {
                        flag = false;
                        $(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(em.email + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                emailids.insert = insert;
                emailids.update = update;
                $('#' + em.saveBut).unbind();
                /* console.log(emailids);*/
                $.ajax({
                    url: em.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editClientEmailId',
                        type: 'master',
                        emailids: emailids
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                loadEmailIdForm();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(em.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteEmailId(id) {
            /* console.log(id);*/
            var flag = false;
            $.ajax({
                url: em.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteClientEmailId',
                    type: 'master',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listEmailIds() {
            var para = {
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listClientEmailIds',
                    type: 'master',
                    para: para
                },
                success: function (data, textStatus, xhr) {
                    data = $.trim(data);
                    console.log(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data);
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    this.editUserCellNumbers = function (cnumber) {
        var cn = cnumber;
        var min = cn.num;
        $(cn.but).click(function () {
            cn.num = min;
            $(cn.but).toggle();
            $('#' + cn.saveBut).toggle();
            loadCellNumForm();
        });
        function loadCellNumForm() {
            cn.num = min;
            /* console.log(cn.num);*/
            $(cn.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientCellNumForm',
                    type: 'master',
                    det: cn
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(cn.parentDiv).html(data.html);
                            $(document).ready(function () {
                                $('#' + cn.plus).click(function () {
                                    addMultipleCellNums();
                                });
                                $('#' + cn.minus).bind('click', function () {
                                    minusMultipleCellNums();
                                    return false;
                                });
                                $('#' + cn.saveBut).click(function () {
                                    editCellNum();
                                });
                                $('#' + cn.closeBut).click(function () {
                                    $(cn.but).toggle();
                                    $('#' + cn.saveBut).toggle();
                                    listCellNums();
                                });
                                window.setTimeout(function () {
                                    if (data.oldcnum) {
                                        for (i = 0; i < data.oldcnum.length; i++) {
                                            var id = Number(data.oldcnum[i].id);
                                            $('#' + data.oldcnum[i].deleteOk).bind("click", {
                                                param1: id
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteCellNum(event.data.param1)) {
                                                    loadCellNumForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function addMultipleCellNums() {
            /* console.log(cn.num);*/
            cn.num++;
            for (i = min; i < cn.num; i++) {
                $(document.getElementById(cn.minus + i + '_delete')).hide();
            }
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                deleteid: cn.minus + cn.num + '_delete'
            };
            var html = '<div><div class="form-group input-group" id="' + oldcnum.formid + '">' +
                    '<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="' + oldcnum.textid + '" maxlength="10"/>' +
                    '<span class="input-group-addon"></span>' +
                    '</div><div class="col-lg-16"><p class="help-block" id="' + oldcnum.msgid + '">Enter/ Select.</p></div></div>';
            $(cn.parentDiv).append(html);
            window.setTimeout(function () {
                $(document.getElementById(oldcnum.deleteid)).click(function () {
                    if (cn.num >= min)
                        cn.num--;
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(cn.minus + cn.num + '_delete')).show();
                });
            }, 200);
        }
        ;
        function minusMultipleCellNums() {
            /* console.log(cn.num);*/
            cn.num--;
            /*for(i=min;i<cn.num;i++){*/
            $(document.getElementById(cn.minus + i + '_delete')).hide();
            /*}*/
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                deleteid: cn.minus + cn.num + '_delete'
            };
            $(document.getElementById(cn.form + cn.num)).hide();
            $(document.getElementById(cn.cnumber + cn.num)).hide();
            $(document.getElementById(cn.msgDiv + cn.num)).hide();
            var html = '<div><div class="form-group input-group" id="' + oldcnum.formid + '"></div></div>';
            /*$(cn.parentDiv).append(html);*/
            window.setTimeout(function () {
                $(document.getElementById(oldcnum.deleteid)).click(function () {
                    if (cn.num >= min)
                        cn.num--;
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(cn.minus + cn.num + '_delete')).show();
                });
            }, 200);
        }
        ;
        function editCellNum() {
            var insert = [];
            var update = [];
            var CellNums = {
                insert: insert,
                update: update,
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            /* min*/
            /* Cell Numbers */
            /* console.log(cn.num);*/
            if (cn.num > -1) {
                j = 0;
                k = 0;
                for (i = 0; i <= cn.num; i++) {
                    /* console.log($(document.getElementById(cn.cnumber+i)).val());*/
                    /* console.log(cn.cnumber+i);*/
                    var ems = $(document.getElementById(cn.cnumber + i)).val();
                    var id = $(document.getElementById(cn.cnumber + i)).prop('name');
                    if (ems.match(cell_reg)) {
                        flag = true;
                        $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                        if (id != 'cnumber') {
                            update[j] = {
                                cnumber: ems,
                                id: id
                            };
                            j++;
                        } else if (id == 'cnumber') {
                            insert[k] = ems;
                            k++;
                        }
                    } else {
                        flag = false;
                        $(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(cn.cnumber + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                CellNums.insert = insert;
                CellNums.update = update;
                $('#' + cn.saveBut).unbind();
                /* console.log(CellNums);*/
                $.ajax({
                    url: cn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editClientCellNum',
                        type: 'master',
                        CellNums: CellNums
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                loadCellNumForm();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(cn.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteCellNum(id) {
            /* console.log(id);*/
            var flag = false;
            $.ajax({
                url: cn.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteClientCellNum',
                    type: 'master',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listCellNums() {
            var para = {
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listClientCellNums',
                    type: 'master',
                    para: para
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
                            $(cn.parentDiv).html(data);
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    this.editGYMEmailIds = function (email) {
        console.dir(email);
        var em = email;
        var min = em.num;
        $(em.but).click(function () {
            em.num = min;
            $(em.but).toggle();
            $('#' + em.saveBut).show();
            loadEmailIdForm();
        });
        function loadEmailIdForm() {
            em.num = min;
            $(em.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadGYMEmailId1',
                    type: 'master',
                    det: em
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data.html);
                            $(document).ready(function () {
                                $('#' + em.plus).click(function () {
                                    addMultipleEmailIds();
                                });
                                $('#' + em.saveBut).click(function () {
                                    editEmailId();
                                    $(em.but).hide();
                                    $('#' + em.saveBut).show();
                                });
                                $('#' + em.minus).bind('click', function () {
                                    minusMultipleEmailIds();
                                    return false;
                                });
                                $('#' + em.closeBut).click(function () {
                                    listEmailIds();
                                    $(em.but).show();
                                    $('#' + em.saveBut).hide();
                                });
                                window.setTimeout(function () {
                                    if (data.oldemail) {
                                        for (i = 0; i < data.oldemail.length; i++) {
                                            var cid = Number(data.oldemail[i].id);
                                            $('#' + data.oldemail[i].deleteOk).bind("click", {
                                                param1: cid
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteEmailId(event.data.param1)) {
                                                    loadEmailIdForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function addMultipleEmailIds() {
            /* console.log(em.num);*/
            em.num++;
            for (i = min; i < em.num; i++) {
                $(document.getElementById(em.minus + i + '_delete')).hide();
            }
            var oldemail = {
                formid: em.form + em.num,
                textid: em.email + em.num,
                msgid: em.msgDiv + em.num,
                deleteid: em.minus + em.num + '_delete'
            };
            var html = '<div><div class="form-group input-group" id="' + oldemail.formid + '">' +
                    '<input class="form-control" required placeholder="Email Id" name="email" type="text" id="' + oldemail.textid + '" maxlength="100"/>' +
                    '<span class="input-group-addon"></span>' +
                    '</div><div class="col-lg-16"><p class="help-block" id="' + oldemail.msgid + '">Enter/ Select.</p></div></div>';
            $(em.parentDiv).append(html);
            window.setTimeout(function () {
                $(document.getElementById(oldemail.deleteid)).click(function () {
                    if (em.num >= min)
                        em.num--;
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(em.minus + em.num + '_delete')).show();
                });
            }, 200);
        }
        ;
        function minusMultipleEmailIds() {
            var oldemail = {
                formid: em.form + em.num,
                textid: em.email + em.num,
                msgid: em.msgDiv + em.num,
                deleteid: em.minus + em.num + '_delete'
            };
            $(document.getElementById(oldemail.textid)).remove();
            $(document.getElementById(oldemail.msgid)).remove();
            $(document.getElementById(oldemail.formid)).remove();
            em.num--;
            window.setTimeout(function () {
                $(document.getElementById(oldemail.deleteid)).click(function () {
                    if (em.num >= min) {
                        em.num--;
                    }
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(em.minus + em.num + '_delete')).hide();
                });
            }, 200);
        }
        ;
        function editEmailId() {
            var insert = [];
            var update = [];
            var emailids = {
                insert: insert,
                update: update,
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            /* min*/
            /* Email Ids */
            /* console.log(em.num);*/
            if (em.num > -1) {
                j = 0;
                k = 0;
                for (i = 0; i <= em.num; i++) {
                    console.log($(document.getElementById(em.email + i)).val());
                    console.log(em.email + i);
                    var ems = $(document.getElementById(em.email + i)).val();
                    var id = $(document.getElementById(em.email + i)).prop('name');
                    if (ems.match(email_reg_new)) {
                        flag = true;
                        $(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
                        if (id != 'email') {
                            update[j] = {
                                email: ems,
                                id: id
                            };
                            j++;
                        } else if (id == 'email') {
                            insert[k] = ems;
                            k++;
                        }
                    } else {
                        flag = false;
                        $(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(em.email + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                emailids.insert = insert;
                emailids.update = update;
                $('#' + em.saveBut).unbind();
                /* console.log(emailids);*/
                $.ajax({
                    url: em.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editGYMEmailId',
                        type: 'master',
                        emailids: emailids
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                loadEmailIdForm();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(em.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteEmailId(id) {
            /* console.log(id);*/
            var flag = false;
            $.ajax({
                url: em.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteGYMEmailId',
                    type: 'master',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listEmailIds() {
            var para = {
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listGYMEmailIds',
                    type: 'master',
                    para: para
                },
                success: function (data, textStatus, xhr) {
                    data = $.trim(data);
                    console.log(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data);
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(em.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    this.editGYMCellNumbers = function (cnumber) {
        var cn = cnumber;
        var min = cn.num;
        $('#' + cn.saveBut).hide();
        $(cn.but).click(function () {
            cn.num = min;
            $(cn.but).toggle();
            $('#' + cn.saveBut).show();
            loadCellNumForm();
        });
        function loadCellNumForm() {
            cn.num = min;
            /* console.log(cn.num);*/
            $(cn.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadGYMCellNumForm',
                    type: 'master',
                    det: cn
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(cn.parentDiv).html(data.html);
                            $(document).ready(function () {
                                $('#' + cn.plus).click(function () {
                                    $('#' + cn.saveBut).show();
                                    addMultipleCellNums();
                                });
                                $('#' + cn.minus).bind('click', function () {
                                    $('#' + cn.saveBut).show();
                                    minusMultipleCellNums();
                                    return false;
                                });
                                $('#' + cn.saveBut).click(function () {
                                    editCellNum();
                                    $(cn.but).hide();
                                    $('#' + cn.saveBut).show();
                                });
                                $('#' + cn.closeBut).click(function () {
                                    listCellNums();
                                    $(cn.but).show();
                                    $('#' + cn.saveBut).hide();
                                });
                                window.setTimeout(function () {
                                    if (data.oldcnum) {
                                        for (i = 0; i < data.oldcnum.length; i++) {
                                            var id = Number(data.oldcnum[i].id);
                                            $('#' + data.oldcnum[i].deleteOk).bind("click", {
                                                param1: id
                                            }, function (event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteCellNum(event.data.param1)) {
                                                    loadCellNumForm();
                                                }
                                            });
                                        }
                                    }
                                }, 300);
                            });
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
        }
        ;
        function addMultipleCellNums() {
            /* console.log(cn.num);*/
            cn.num++;
            for (i = min; i < cn.num; i++) {
                $(document.getElementById(cn.minus + i + '_delete')).hide();
            }
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                deleteid: cn.minus + cn.num + '_delete'
            };
            var html = '<div><div class="form-group input-group" id="' + oldcnum.formid + '">' +
                    '<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="' + oldcnum.textid + '" maxlength="10"/>' +
                    '<span class="input-group-addon"></span>' +
                    '</div><div class="col-lg-16"><p class="help-block" id="' + oldcnum.msgid + '">Enter/ Select.</p></div></div>';
            $(cn.parentDiv).append(html);
            window.setTimeout(function () {
                $(document.getElementById(oldcnum.deleteid)).click(function () {
                    if (cn.num >= min)
                        cn.num--;
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(cn.minus + cn.num + '_delete')).show();
                });
            }, 200);
        }
        ;
        function minusMultipleCellNums() {
            /* console.log(cn.num);*/
            cn.num--;
            /*for(i=min;i<cn.num;i++){*/
            $(document.getElementById(cn.minus + i + '_delete')).hide();
            /*}*/
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                deleteid: cn.minus + cn.num + '_delete'
            };
            $(document.getElementById(cn.form + cn.num)).hide();
            $(document.getElementById(cn.cnumber + cn.num)).hide();
            $(document.getElementById(cn.msgDiv + cn.num)).hide();
            var html = '<div><div class="form-group input-group" id="' + oldcnum.formid + '"></div></div>';
            /*$(cn.parentDiv).append(html);*/
            window.setTimeout(function () {
                $(document.getElementById(oldcnum.deleteid)).click(function () {
                    if (cn.num >= min)
                        cn.num--;
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(cn.minus + cn.num + '_delete')).show();
                });
            }, 200);
        }
        ;
        function editCellNum() {
            var insert = [];
            var update = [];
            var CellNums = {
                insert: insert,
                update: update,
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            /* min*/
            /* Cell Numbers */
            /* console.log(cn.num);*/
            if (cn.num > -1) {
                j = 0;
                k = 0;
                for (i = 0; i <= cn.num; i++) {
                    /* console.log($(document.getElementById(cn.cnumber+i)).val());*/
                    /* console.log(cn.cnumber+i);*/
                    var ems = $(document.getElementById(cn.cnumber + i)).val();
                    var id = $(document.getElementById(cn.cnumber + i)).prop('name');
                    if (ems.match(cell_reg_new)) {
                        flag = true;
                        $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                        if (id != 'cnumber') {
                            update[j] = {
                                cnumber: ems,
                                id: id
                            };
                            j++;
                        } else if (id == 'cnumber') {
                            insert[k] = ems;
                            k++;
                        }
                    } else {
                        flag = false;
                        $(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
                        $('html, body').animate({
                            scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                        }, "slow");
                        $(document.getElementById(cn.cnumber + i)).focus();
                        return;
                    }
                }
            }
            if (flag) {
                CellNums.insert = insert;
                CellNums.update = update;
                $('#' + cn.saveBut).unbind();
                /* console.log(CellNums);*/
                $.ajax({
                    url: cn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editGYMCellNum',
                        type: 'master',
                        CellNums: CellNums
                    },
                    success: function (data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                loadCellNumForm();
                                break;
                        }
                    },
                    error: function (xhr, textStatus) {
                        $(cn.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        }
        ;
        function deleteCellNum(id) {
            /* console.log(id);*/
            var flag = false;
            $.ajax({
                url: cn.url,
                type: 'POST',
                async: false,
                data: {
                    autoloader: true,
                    action: 'deleteGYMCellNum',
                    type: 'master',
                    eid: id
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
                            flag = data;
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
        function listCellNums() {
            var para = {
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'listGYMCellNums',
                    type: 'master',
                    para: para
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
                            $(cn.parentDiv).html(data);
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(cn.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                }
            });
            return flag;
        }
        ;
    };
    this.editGYMDataDoc = function (doc) {
        $(doc.gymdocEditbtn).bind("click", function () {
            $(doc.gymdocDiv).hide();
            $(doc.gymdocEditbtn).hide();
            $(doc.gymdocEditDiv).show();
        });
        $(doc.gymdocUpdatebtn).bind("click", function () {
            var attr = {
                gymid: doc.gymid,
                gymBname: $(doc.gymBname).val(),
                gymType: $(doc.gymType).val(),
                gymdbHost: $(doc.gymdbHost).val(),
                gymdbUsernm: $(doc.gymdbUsernm).val(),
                gymdbName: $(doc.gymdbName).val(),
                gymdbPass: $(doc.gymdbPass).val(),
                gymslogo: $(doc.gymslogo).val(),
                gymhlogo: $(doc.gymhlogo).val(),
            };
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'gymdataDoc',
                    type: 'master',
                    attr: attr
                },
                success: function (data, textStatus, xhr) {
                    htm1 = '';
                    data = $.parseJSON($.trim(data));
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            /*$(gymData.addressform).get(0).reset();*/
                            $(doc.gymdocEditDiv).hide();
                            if (data.status)
                                $(doc.gymdocDiv).html(data.htm);
                            $(doc.gymdocDiv).show();
                            $(doc.gymdocEditbtn).show();
                            break;
                    }
                },
                error: function () {
                    $(loader).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        });
        $(doc.gymdocClosebtn).bind("click", function () {
            $(doc.gymdocEditDiv).hide();
            $(doc.gymdocDiv).show();
            $(doc.gymdocEditbtn).show();
        });
    }
    this.gymdeleteflag1 = function (btn) {
        $(btn.gymdeleteokbtn).bind("click", function () {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'gymDeleTe',
                    type: 'master',
                    id: btn.gymid
                },
                success: function (data, textStatus, xhr) {
                    /*data = $.trim(data);*/
                    alert(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            if (!data)
                                alert("Some Problem in Connection");
                            else
                                alert(btn.gid);
                            /*displayGymdata(btn.gid)*/
                            break;
                    }
                },
                error: function () {
                    $(loader).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        });
        $(btn.gymflagbtn).bind("click", function () {
            alert("flag");
        });
    }
    function userAutoComplete() {
        $.ajax({
            url: ct.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'autoCompleteClient',
                type: 'master'
            },
            success: function (data, textStatus, xhr) {
                data = $.parseJSON(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        console.log(data.listofClient);
                        $(add.mgym).autocomplete({
                            source: data.listofClient,
                            minLength: 1,
                            select: function (event, ui) {
                                $(add.mgym).val(ui.item.label);
                                $(add.mgmsg).attr('name', ui.item.id);
                                return false;
                            },
                            Onselect: function (event, ui) {
                                $(add.mgym).val(ui.item.label);
                                return false;
                            }
                        });
                        break;
                }
            },
            error: function () {
                $(usr.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
                $(uadd.but).removeAttr('disabled');
            }
        });
    }
    function initializeUserAddForm() {
        $(ucn.plus + ',' + uem.plus).unbind();
        $(ucn.plus).click(function (evt) {
            $(ucn.plus).hide();
            evt.preventDefault();
            evt.stopPropagation();
            bulitUserMultipleCellNumbers();
        });
        $(uem.plus).click(function (evt) {
            $(uem.plus).hide();
            evt.preventDefault();
            evt.stopPropagation();
            bulitUserMultipleEmailIds();
        });
    }
    ;
    /* USer email*/
    function bulitUserMultipleEmailIds() {
        if (uem.num == -1)
            $(uem.parentDiv).html('');
        uem.num++;
        var html = '<div id="' + uem.form + uem.num + '">' +
                '<div class="col-lg-8">' +
                '<input class="form-control" pattern="^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$" placeholder="Email Id" required name="email[]" type="text" id="' + uem.email + uem.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + uem.msgDiv + uem.num + '">&nbsp;</p>' +
                '</div>' +
                '<div class="col-lg-4">' +
                '<button  type="button" class="btn btn-danger  btn-md" id="' + uem.minus + uem.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button  type="button" class="btn btn-success  btn-md" id="' + uem.plus + uem.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '</div>';
        $(uem.parentDiv).append(html);
        window.setTimeout(function () {
            $(document.getElementById(uem.minus + uem.num)).click(function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                $(document.getElementById(uem.form + uem.num)).remove();
                $(document.getElementById(uem.msgDiv + uem.num)).remove();
                uem.num--;
                if (uem.num == -1) {
                    $(uem.plus).show();
                    $(uem.parentDiv).html('');
                } else {
                    $(document.getElementById(uem.plus + uem.num)).show();
                    $(document.getElementById(uem.minus + uem.num)).show();
                }
                if (uem.count && uem.count == uem.num) {
                    $(uem.plus).show();
                }
            });
            $(document.getElementById(uem.plus + uem.num)).click(function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                $(document.getElementById(uem.plus + uem.num)).hide();
                $(document.getElementById(uem.minus + uem.num)).hide();
                bulitUserMultipleEmailIds();
            });
            $(document.getElementById(uem.email + uem.num)).blur(function () {
                var id = $(document.getElementById(uem.email + uem.num)).val();
                checkExisting(id);
            });
        }, 200);
    }
    ;
    function checkExisting(id) {
        em = id;
        $(document.getElementById(uem.msgDiv + uem.num)).html("Checking...");
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'checkEmailEmp',
                type: 'master',
                email: em
            },
            success: function (data) {
                data = $.parseJSON($.trim(data));
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        if (data.flag) {
                            flag = true;
                            $(document.getElementById(uem.msgDiv + uem.num)).html(VALIDNOT);
                        } else {
                            flag = false;
                            $(document.getElementById(uem.email + uem.num)).val('');
                            $(document.getElementById(uem.msgDiv + uem.num)).html("<strong class='text-danger'>Email Already Taken</strong>");
                        }
                        break;
                }
            },
            error: function () {
                $(loader).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    /*user list*/
    function initializeUserList(dflag) {
        if (dflag) {
            alert("inner=" + dflag);
            displayGymdata(dflag);
            return;
        }
        var header = '<table class="table table-striped table-bordered table-hover" id="list_user_table">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="11" class="text-center">Client Lists</th>' +
                '</tr>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>User Name</th>' +
                '<th class="text-center">Type</th>' +
                '<th class="text-center">Client Email Id</th>' +
                '<th class="text-center">Client Cellnumber</th>' +
                '<th class="text-center">Date of Join</th>' +
                '<th class="text-center">GYM Details</th>' +
                '<th class="text-center">Edit</th>' +
                '<th>Delete</th>' +
                '<th>Flag/Unflag</th>' +
                '<th>Credentials</th>' +
                '</tr>' +
                '</thead>';
        var footer = '</table>';
        $(luser.listuserBtn).on("click", function () {
            $(luser.gymedit_div).hide();
            $(luser.gnt_pnlist).show();
            var i = 1;
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'mmuser_list',
                    type: 'master'
                },
                success: function (data) {
                    if (data == 'logout')
                        window.location.href = URL;
                    else {
                        $.ajax({
                            url: window.location.href,
                            type: 'POST',
                            data: {
                                autoloader: 'true',
                                action: 'mmuser_list1',
                                type: 'master'
                            },
                            success: function (data, textStatus, xhr) {
                                htm = '';
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
                                        var total_record = listusers.length;
                                        for (i = 0; i < total_record; i++) {
                                            htm += listusers[i]["html"];
                                        }
                                        $(luser.gnt_gymlist).hide();
                                        $(luser.gnt_pnlist).html(header + htm + footer);
                                        for (i = 0; i < total_record; i++) {
                                            $(listusers[i]["showgym"]).bind('click', {
                                                uid: listusers[i].uid
                                            }, function (evt) {
                                                $(luser.gnt_pnlist).hide();
                                                $(luser.gnt_gymlist).show();
                                                var selectid = evt.data.uid;
                                                displayGymdata(selectid);
                                            });
                                        }
                                        window.setTimeout(function () {
                                            $('#list_user_table').dataTable({
                                                retrieve: true,
                                                destroy: true,
                                                "aoColumns": [
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                    null,
                                                ],
                                                "autoWidth": true
                                            });
                                        }, 300);
                                        for (i = 0; i < listusers.length; i++) {
                                            $(listusers[i].usredit).bind('click', {
                                                uid: listusers[i].uid,
                                                sr: listusers[i].sr
                                            }, function (evt) {
                                                $($(this).prop('name')).hide(400);
                                                var hid = editClient(evt.data.uid);
                                            });
                                            $(listusers[i].usrsend).bind('click', {
                                                uid: listusers[i].uid,
                                                sr: listusers[i].sr
                                            }, function (evt) {
                                                $($(this).prop('name')).hide(400);
                                                var hid = sendCredentials(evt.data.uid);
                                            });
                                            $(listusers[i].usrdelOk).bind('click', {
                                                uid: listusers[i].uid,
                                                sr: listusers[i].sr
                                            }, function (evt) {
                                                $($(this).prop('name')).hide(400);
                                                console.log(evt.data.uid);
                                                var hid = deleteClient(evt.data.uid);
                                                if (hid) {
                                                    $(evt.data.sr).remove();
                                                    $(luser.listuserBtn).click();
                                                }
                                            });
                                            $(listusers[i].usrflgOk).bind('click', {
                                                uid: listusers[i].uid,
                                                sr: listusers[i].sr
                                            }, function (evt) {
                                                $($(this).prop('name')).hide(400);
                                                var hid = flagUser(evt.data.uid);
                                                $(luser.listuserBtn).click();
                                            });
                                            $(listusers[i].usruflgOk).bind('click', {
                                                uid: listusers[i].uid,
                                                sr: listusers[i].sr
                                            }, function (evt) {
                                                $($(this).prop('name')).hide(400);
                                                var hid = unflagUser(evt.data.uid);
                                                $(luser.listuserBtn).click();
                                            });
                                        }
                                        break;
                                }
                            },
                            error: function () {
                                $(add.outputDiv).html(INET_ERROR);
                            },
                            complete: function (xhr, textStatus) {
                            }
                        });
                    }
                },
                error: function () {
                    alert("there was an error");
                }
            });
        });
    }
    ;
    /* display gym data*/
    function displayGymdata(selectid) {
        var gymheader = '<table  class="table table-striped table-bordered table-hover" id="list_gym_table">' +
                '<thead>' +
                '<tr>' +
                '<th colspan="12" class="text-center">Branch Lists</th>' +
                '<th colspan="3">' +
                '<center><button class="text-center btn btn-danger btn-md" id="gymlist_Close_But"><i class="fa fa-reply fa-fw "></i>Back</button></center>' +
                '</th>' +
                '</tr>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Branch Name</th>' +
                '<th class="text-center">Branch Type</th>' +
                '<th class="text-center">DB-Host</th>' +
                '<th class="text-center">DB-UserName</th>' +
                '<th class="text-center">DB-Name</th>' +
                '<th class="text-center">DB-Password</th>' +
                '<th class="text-center">Email Ids</th>' +
                '<th class="text-center">Cell-Number</th>' +
                '<th class="text-center">City</th>' +
                '<th class="text-center">State</th>' +
                '<th class="text-center">Country</th>' +
                '<th class="text-center">Edit</th>' +
                '<th>Delete</th>' +
                '<th>Flag</th>' +
                '</tr>' +
                '</thead>';
        var gymfooter = '</table>';
        var gymid = selectid;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'mmgymlist_data1',
                type: 'master',
                id: gymid
            },
            success: function (data, textStatus, xhr) {
                htm1 = '';
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var listgymusers = $.parseJSON(data);
                        var total = listgymusers.length;
                        for (i = 0; i < total; i++) {
                            htm1 += listgymusers[i]["html"];
                        }
                        $(luser.gymedit_div).hide();
                        $(luser.gnt_gymlist).html(gymheader + htm1 + gymfooter);
                        $("#gymlist_Close_But").click(function () {
                            $(luser.gnt_gymlist).hide();
                            $(luser.gnt_pnlist).show();
                        });
                        for (i = 0; i < total; i++) {
                            var allData = {
                                addressform: listgymusers[i]["addressform"],
                                gymcountryval: listgymusers[i]["gymcountry"],
                                gymprovivnceval: listgymusers[i]["gymprovince"],
                                gymdistrictval: listgymusers[i]["gymdistrict"],
                                gymcityval: listgymusers[i]["gymcity_town"],
                                gymstreetval: listgymusers[i]["gymst_loc"],
                                gymaddrsval: listgymusers[i]["gymaddrs"],
                                gymzipcodeval: listgymusers[i]["gymzipcode"],
                                gymwebsiteval: listgymusers[i]["gymwebsite"],
                                gymgmapval: listgymusers[i]["gymgmaphtml"],
                                gymEditListcloseBtn: listgymusers[i]["gymeditlistclbtn"],
                                gymaddCloseBut: listgymusers[i]["gymaddCloseBut"],
                                gymaddSaveBut: listgymusers[i]["gymaddSaveBut"],
                                gymaddUpadteDiv: listgymusers[i]["gymaddUpdateDiv"],
                                gymaddEditBut: listgymusers[i]["gymaddEditBut"],
                                gymaddDiv: listgymusers[i]["gymaddDiv"],
                                gid: listgymusers[i].gid,
                                editdiv: listgymusers[i]["gymEditDiv"],
                                edigymaddtbut: listgymusers[i]["gymaddEditBut"],
                                editgymemailbut: listgymusers[i]["gymemailEditBut"],
                                editgymcellbut: listgymusers[i]["gymcellEditBut"]
                            }
                            $(listgymusers[i]["gymeditBtn"]).bind('click', allData, function (evt) {
                                $(luser.gnt_gymlist).hide();
                                /*alert("after id="+selectid);*/
                                $(luser.gymedit_div).show();
                                $(luser.gymedit_div).html(evt.data.editdiv);
                                $(evt.data.edigymaddtbut).bind('click', function () {
                                    gymaddressEditData(evt.data, selectid);
                                });
                                /*$(evt.data.editgymemailbut).bind('click',function () {*/
                                /*$(evt.data.editgymemailbut).toggle();*/
                                /*loadGymEmailIdForm(evt.data);*/
                                /*});*/
                                /*$(evt.data.editgymcellbut).bind('click',function () {*/
                                /*alert("Click cell Edit  button");*/
                                /*});*/
                                $(evt.data.gymEditListcloseBtn).bind('click', function () {
                                    $(luser.gymedit_div).hide();
                                    $(luser.gnt_gymlist).show();
                                });
                            });
                            $(listgymusers[i]["gymdeleteokbtn"]).bind('click', {
                                gid: listgymusers[i]["gymid"]
                            }, function (evt) {
                                /*$($(this).prop('name')).hide(400);*/
                                var hid = deleteGym(evt.data.gid);
                                if (hid) {
                                    dflag = gymid;
                                    $('#listgymsbut').click();
                                    /*initializeUserList(gymid);*/
                                }
                            });
                            $(listgymusers[i]["gymflagokbtn"]).bind('click', {
                                gid: listgymusers[i]["gymid"]
                            }, function (evt) {
                                $($(this).prop('name')).hide(400);
                                var hid = flagGYM(evt.data.gid);
                                $("#listgymsbut").click();
                            });
                            $(listgymusers[i]["gymunflagokbtn"]).bind('click', {
                                gid: listgymusers[i]["gymid"]
                            }, function (evt) {
                                $($(this).prop('name')).hide(400);
                                var hid = unflagUser(evt.data.gid);
                                $("#listgymsbut").click();
                            });
                        }
                        window.setTimeout(function () {
                            $('#list_gym_table').dataTable({
                                "aoColumns": [
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                ],
                                "autoWidth": true
                            });
                        }, 300);
                        break;
                }
            },
            error: function () {
                $(loader).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
    function loadGymEmailIdForm(emaildata) {
        /*em.num = min;*/
        /*$(em.parentDiv).html(LOADER_TWO);*/
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'loadGymEmailId',
                type: 'master',
                det: em
            },
            success: function (data, textStatus, xhr) {
                data = $.parseJSON(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    default:
                        $(em.parentDiv).html(data.html);
                        $(document).ready(function () {
                            $('#' + em.plus).click(function () {
                                addMultipleEmailIds();
                                $('#' + em.saveBut).show();
                            });
                            $('#' + em.saveBut).click(function () {
                                editEmailId();
                                $(em.but).toggle();
                                $('#' + em.saveBut).toggle();
                            });
                            $('#' + em.minus).bind('click', function () {
                                minusMultipleEmailIds();
                                return false;
                            });
                            $('#' + em.closeBut).click(function () {
                                listEmailIds();
                                $(em.but).toggle();
                                $('#' + em.saveBut).hide();
                            });
                            window.setTimeout(function () {
                                if (data.oldemail) {
                                    for (i = 0; i < data.oldemail.length; i++) {
                                        var cid = Number(data.oldemail[i].id);
                                        $('#' + data.oldemail[i].deleteOk).bind("click", {
                                            param1: cid
                                        }, function (event) {
                                            $($(this).prop('name')).hide(400);
                                            if (deleteEmailId(event.data.param1)) {
                                                loadEmailIdForm();
                                            }
                                        });
                                    }
                                }
                            }, 300);
                        });
                        break;
                }
            },
            error: function (xhr, textStatus) {
                $(em.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    /*edit gym address data*/
    function gymaddressEditData(gymData, selectid) {
        var gymId = gymData.gid;
        var pro = $(gymData.gymprovivnceval).val();
        $(gymData.gymaddDiv).hide();
        $(gymData.gymaddEditBut).hide();
        $(gymData.gymaddUpadteDiv).show();
        $(gymData.gymaddSaveBut).bind("click", function () {
            var gymupdata = {
                gymid: gymData.gid,
                country: $(gymData.gymcountryval).val(),
                province: $(gymData.gymprovivnceval).val(),
                district: $(gymData.gymdistrictval).val(),
                city_town: $(gymData.gymcityval).val(),
                street: $(gymData.gymstreetval).val(),
                addrs: $(gymData.gymaddrsval).val(),
                zipcode: $(gymData.gymzipcodeval).val(),
                website: $(gymData.gymwebsiteval).val(),
                gmaphtml: $(gymData.gymgmapval).val()
            };
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'gymaddressedit',
                    type: 'master',
                    attr: gymupdata
                },
                success: function (data, textStatus, xhr) {
                    data = $.parseJSON($.trim(data));
                    /*console.log(data);*/
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            $(gymData.addressform).get(0).reset();
                            $(gymData.gymaddUpadteDiv).hide();
                            if (data.status)
                                $(gymData.gymaddDiv).html(data.htm);
                            $(gymData.gymaddDiv).show();
                            $(gymData.gymaddEditBut).show();
                            break;
                    }
                },
                error: function () {
                    $(loader).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        });
        $(gymData.gymaddCloseBut).bind("click", function () {
            $(gymData.gymaddUpadteDiv).hide();
            $(gymData.gymaddDiv).show();
            $(gymData.gymaddEditBut).show();
        });
    }
    /*delete client*/
    function deleteClient(uid) {
        var flag = false;
        var entid = uid;
        console.log(entid);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'deleteClient',
                type: 'master',
                uid: entid
            },
            success: function (data, textStatus, xhr) {
                console.log("delete status" + data);
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        flag = data;
                        break;
                }
            },
            error: function () {
                $(usr.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        return flag;
    }
    /*edit client*/
    function editClient(id) {
        var usrid = id;
        var htm = '';
        console.log("i clicked edit" + usrid);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'editClient',
                type: 'master',
                usrid: usrid
            },
            success: function (data, textStatus, xhr) {
                /*data = $.trim(data);*/
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(luser.gnt_pnlist).html(data);
                        $(".picedit_box").picEdit({
                            imageUpdated: function (img) {
                            },
                            formSubmitted: function (data) {
                                window.setTimeout(function () {
                                    $('#myModal_pf').modal('toggle');
                                    editClient(usrid);
                                }, 500);
                            },
                            redirectUrl: false,
                            defaultImage: URL + ASSET_IMG + 'No_image.png',
                        });
                        /*flag = data;*/
                        break;
                }
            },
            error: function () {
                $(usr.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        /*return flag;*/
    }
    /*flag unflag*/
    function flagUser(id) {
        var uid = id;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'flagClient',
                type: 'master',
                fuser: uid
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                /*console.log(data);*/
                if (!data) {
                    flag = false;
                } else
                    flag = true;
            },
            error: function () {
                $(loader).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
    function sendCredentials(id) {
        var uid = id;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'sendcredential',
                type: 'master',
                fuser: uid
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                /*console.log(data);*/
                if (data) {
                    alert("Credentails Has been Successfully Sent")
                } else
                    alert("Credentails Hasn't been Sent")
            },
            error: function () {
                $(loader).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
    function unflagUser(id) {
        var uid = id;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'unflagClient',
                type: 'master',
                ufuser: uid
            },
            success: function (data, textStatus, xhr) {
                console.log(data);
                data = $.trim(data);
                if (data) {
                    flag = true;
                }
            },
            error: function () {
                $(loader).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
    /* User Cell Number*/
    function bulitUserMultipleCellNumbers() {
        if (ucn.num == -1)
            $(ucn.parentDiv).html('');
        ucn.num++;
        var html = '<div class="row show-grid" id="' + ucn.form + ucn.num + '">' +
                '<div class="col-xs-6 col-md-4">' +
                '<input class="form-control" value="' + dccode + '" pattern="[0-9]{2,15}$" name="cellnumbers[' + ucn.num + '][codep]" required type="text" id="' + ucn.codep + ucn.num + '" maxlength="15" readonly=""/>' +
                '</div>' +
                '<div class="col-xs-6 col-md-4">' +
                '<input class="form-control" placeholder="Cell Number" pattern="[0-9]{10,20}$" required name="cellnumbers[' + ucn.num + '][nump]" type="text" id="' + ucn.nump + ucn.num + '" maxlength="10" />' +
                '</div>' +
                '<div class="col-xs-6 col-md-4" id="btn' + ucn.num + '">' +
                '<button  type="button" class="btn btn-danger  btn-md" id="' + ucn.minus + ucn.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button  type="button" class="btn btn-success  btn-md" id="' + ucn.plus + ucn.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-12"><p class="help-block" id="' + ucn.msgDiv + ucn.num + '">&nbsp;</p></div>';
        $(ucn.parentDiv).append(html);
        window.setTimeout(function () {
            $(function () {
                $(document.getElementById(ucn.minus + ucn.num)).click(function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(document.getElementById(ucn.form + ucn.num)).remove();
                    $(document.getElementById(ucn.msgDiv + ucn.num)).remove();
                    ucn.num--;
                    if (ucn.num == -1) {
                        $(ucn.plus).show();
                    } else if (ucn.count && ucn.count == ucn.num) {
                        $(ucn.plus).show();
                    } else {
                        $(document.getElementById(ucn.plus + ucn.num)).show();
                        $(document.getElementById(ucn.minus + ucn.num)).show();
                        btdiv = "btn" + ucn.num;
                        document.getElementById(btdiv).style.visibility = "visible";
                    }
                });
                $(document.getElementById(ucn.plus + ucn.num)).click(function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(document.getElementById(ucn.plus + ucn.num)).hide();
                    $(document.getElementById(ucn.minus + ucn.num)).hide();
                    btdiv = "btn" + ucn.num;
                    document.getElementById(btdiv).style.visibility = "hidden";
                    bulitUserMultipleCellNumbers();
                });
            });
        }, 200);
    }
    ;
    /* gym add*/
    function gymAdd() {
        var attr = validateGYMFields();
        if (attr) {
            $(add.but).prop('disabled', 'disabled');
            $(ct.msgDiv).html('');
            $(ct.msgDiv).html('<i class="fa fa-spinner fa-5x fa-spin"></i>');
            $.ajax({
                url: ct.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'gymAdd',
                    type: 'master',
                    gymadd: attr
                },
                success: function (data, textStatus, xhr) {
                    console.log(data);
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
                            $(loader).hide();
                            $(ct.msgDiv).html('<h2>Record success fully added</h2>');
                            $(add.form).get(0).reset();
                            $('#address_body').hide(300);
                            break;
                    }
                },
                error: function () {
                    $(usr.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    window.setTimeout(function () {
                        $(ct.msgDiv).html('');
                    }, 2000);
                    $(add.but).removeAttr('disabled');
                }
            });
        } else {
            $(add.but).removeAttr('disabled');
        }
    }
    ;
    function validateGYMFields() {
        var flag = false;
        var email = [];
        var cellnumbers = [];
        /* user name mgym*mgmsg*/
        if ($(add.mgym).val().length > 0) {
            flag = true;
            $(add.mgmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(add.mgmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(add.mgmsg).offset().top) - 95
            }, "slow");
            $(add.mgym).focus();
            return;
        }
        /* gym name name*nmsg*/
        if ($(add.name).val().match(name_reg)) {
            flag = true;
            $(add.nmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(add.nmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(add.nmsg).offset().top) - 95
            }, "slow");
            $(add.name).focus();
            return;
        }
        /* gym fee fee*fmsg*/
        if ($(add.fee).val().match(number_reg)) {
            flag = true;
            $(add.fmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(add.fmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(add.fmsg).offset().top) - 95
            }, "slow");
            $(add.fee).focus();
            return;
        }
        /* gym country*comsg $('#address_body').show(300);*/
        if ($(add.address.country).val()) {
            flag = true;
            $(add.address.comsg).html(VALIDNOT);
        } else {
            flag = false;
            $(add.address.comsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(add.address.comsg).offset().top) - 95
            }, "slow");
            $(add.address.addbody).show();
            $(add.address.country).focus();
            return;
        }
        /*~ // gym province-prmsg*/
        if ($(add.address.province).val()) {
            flag = true;
            $(add.address.prmsg).html(VALIDNOT);
        } else {
            flag = false;
            $(add.address.prmsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(add.address.prmsg).offset().top) - 95
            }, "slow");
            $(add.address.addbody).show();
            $(add.address.province).focus();
            return;
        }
        /* gym district-dimsg*/
        if ($(add.address.district).val()) {
            flag = true;
            $(add.address.dimsg).html(VALIDNOT);
        } else {
            flag = false;
            $(add.address.dimsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(add.address.dimsg).offset().top) - 95
            }, "slow");
            $(add.address.addbody).show();
            $(add.address.district).focus();
            return;
        }
        /* gym zipcode-zimsg*/
        if ($(add.address.zipcode).val()) {
            flag = true;
            $(add.address.zimsg).html(VALIDNOT);
        } else {
            flag = false;
            $(add.address.zimsg).html(INVALIDNOT);
            $('html, body').animate({
                scrollTop: Number($(add.address.zimsg).offset().top) - 95
            }, "slow");
            $(add.address.addbody).show();
            $(add.address.zipcode).focus();
            return;
        }
        /* Email Ids */
        if (em.num > -1) {
            j = 0;
            for (i = 0; i <= em.num; i++) {
                if ($(document.getElementById(em.email + i)).val().match(email_reg)) {
                    flag = true;
                    $(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
                    email[j] = $(document.getElementById(em.email + i)).val();
                    j++;
                } else {
                    flag = false;
                    $(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(em.email + i)).focus();
                    return;
                }
            }
        }
        /* Cell Numbers */
        if (cn.num > -1) {
            j = 0;
            for (i = 0; i <= cn.num; i++) {
                if ($(document.getElementById(cn.codep + i)).val().match(ccod_reg)) {
                    flag = true;
                    $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(cn.msgDiv + i)).html('<strong class="text-danger">Not Valid Cell prefiex</strong>');
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(cn.codep + i)).focus();
                    return;
                }
                if ($(document.getElementById(cn.nump + i)).val().match(cell_reg)) {
                    flag = true;
                    $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
                } else {
                    flag = false;
                    $(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
                    $('html, body').animate({
                        scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
                    }, "slow");
                    $(document.getElementById(cn.nump + i)).focus();
                    return;
                }
                if (flag) {
                    cellnumbers[j] = {
                        codep: $(document.getElementById(cn.codep + i)).val(),
                        nump: $(document.getElementById(cn.nump + i)).val()
                    };
                    j++;
                }
            }
        }
        var attr = {
            type: $(add.type).val(),
            mgym: $(add.mgym).val(),
            userpk: $(add.mgmsg).attr('name'),
            name: $(add.name).val(),
            acs: $(add.acs_id).val(),
            email: email,
            cellnumbers: cellnumbers,
            fee: $(add.fee).val(),
            tax: $(add.tax).val(),
            country: $(add.address.country).val(),
            countryCode: add.address.countryCode,
            province: $(add.address.province).val(),
            provinceCode: add.address.provinceCode,
            district: $(add.address.district).val(),
            city_town: $(add.address.city_town).val(),
            st_loc: $(add.address.st_loc).val(),
            addrsline: $(add.address.addrs).val(),
            tphone: $(add.address.tphone).val(),
            pcode: $(add.address.pcode).val(),
            zipcode: $(add.address.zipcode).val(),
            website: $(add.address.website).val(),
            gmaphtml: $(add.address.gmaphtml).val(),
            timezone: add.address.timezone,
            lat: add.address.lat,
            lon: add.address.lon
        };
        if (flag) {
            return attr;
        } else
            return false;
    }
    ;
    function initializeProfileAddForm() {
        $(cn.plus + ',' + em.plus).unbind();
        $(cn.plus).click(function (evt) {
            $(cn.plus).hide();
            evt.preventDefault();
            evt.stopPropagation();
            bulitMultipleCellNumbers();
        });
        $(em.plus).click(function (evt) {
            $(em.plus).hide();
            evt.preventDefault();
            evt.stopPropagation();
            bulitMultipleEmailIds();
        });
    }
    ;
    /* gym branch email*/
    function bulitMultipleEmailIds() {
        if (em.num == -1)
            $(em.parentDiv).html('');
        em.num++;
        var html = '<div id="' + em.form + em.num + '">' +
                '<div class="col-lg-8">' +
                '<input class="form-control" required="required" placeholder="Email Id" name="email" type="text" id="' + em.email + em.num + '" maxlength="100"/>' +
                '<p class="help-block" id="' + em.msgDiv + em.num + '">&nbsp;</p>' +
                '</div>' +
                '<div class="col-lg-4">' +
                '<button  type="button" class="btn btn-danger  btn-md" id="' + em.minus + em.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-success  btn-md" id="' + em.plus + em.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '</div>';
        $(em.parentDiv).append(html);
        window.setTimeout(function () {
            $(document.getElementById(em.minus + em.num)).click(function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                $(document.getElementById(em.form + em.num)).remove();
                $(document.getElementById(em.msgDiv + em.num)).remove();
                em.num--;
                if (em.num == -1) {
                    $(em.plus).show();
                    $(em.parentDiv).html('');
                } else {
                    $(document.getElementById(em.plus + em.num)).show();
                    $(document.getElementById(em.minus + em.num)).show();
                }
                if (em.count && em.count == em.num) {
                    $(em.plus).show();
                }
            });
            $(document.getElementById(em.plus + em.num)).click(function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                $(document.getElementById(em.plus + em.num)).hide();
                $(document.getElementById(em.minus + em.num)).hide();
                bulitMultipleEmailIds();
            });
        }, 200);
    }
    ;
    /* gym branch Cell Number*/
    function bulitMultipleCellNumbers() {
        if (cn.num == -1)
            $(cn.parentDiv).html('');
        cn.num++;
        var html = '<div class="row show-grid" id="' + cn.form + cn.num + '">' +
                '<div class="col-xs-6 col-md-4">' +
                '<input class="form-control" required="required" value="' + dccode + '" name="ccode" type="text" id="' + cn.codep + cn.num + '" maxlength="15" readonly="" />' +
                '</div>' +
                '<div class="col-xs-6 col-md-4">' +
                '<input class="form-control" required="required" placeholder="Cell Number" name="cnumber" type="text" id="' + cn.nump + cn.num + '" maxlength="10" />' +
                '</div>' +
                '<div class="col-xs-6 col-md-4" id="btn' + cn.num + '">' +
                '<button type="button" class="btn btn-danger  btn-md" id="' + cn.minus + cn.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-success  btn-md" id="' + cn.plus + cn.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' +
                '</div>' +
                '</div>' +
                '<div class="col-lg-12"><p class="help-block" id="' + cn.msgDiv + cn.num + '">&nbsp;</p></div>';
        $(cn.parentDiv).append(html);
        window.setTimeout(function () {
            $(function () {
                $(document.getElementById(cn.minus + cn.num)).click(function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(document.getElementById(cn.form + cn.num)).remove();
                    $(document.getElementById(cn.msgDiv + cn.num)).remove();
                    cn.num--;
                    if (cn.num == -1) {
                        $(cn.plus).show();
                    } else if (cn.count && cn.count == cn.num) {
                        $(cn.plus).show();
                    } else {
                        $(document.getElementById(cn.plus + cn.num)).show();
                        $(document.getElementById(cn.minus + cn.num)).show();
                        btdiv = "btn" + cn.num;
                        document.getElementById(btdiv).style.visibility = "visible";
                    }
                });
                $(document.getElementById(cn.plus + cn.num)).click(function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(document.getElementById(cn.plus + cn.num)).hide();
                    $(document.getElementById(cn.minus + cn.num)).hide();
                    btdiv = "btn" + cn.num;
                    document.getElementById(btdiv).style.visibility = "hidden";
                    bulitMultipleCellNumbers();
                });
            });
        }, 200);
    }
    ;
    function deleteGym(uid) {
        var flag = false;
        var entid = uid;
        console.log(entid);
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: 'true',
                action: 'gymDeleTe',
                type: 'master',
                id: entid
            },
            success: function (data, textStatus, xhr) {
                /*alert("delete status="+data);*/
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        flag = data;
                        break;
                }
            },
            error: function () {
                $(usr.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
        return flag;
    }
    /* gym flag btn*/
    function flagGYM(id) {
        var uid = id;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'flagGYM',
                type: 'master',
                fuser: uid
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                /*console.log(data);*/
                if (!data) {
                    flag = false;
                } else
                    flag = true;
            },
            error: function () {
                $(loader).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
    function unflagGYM(id) {
        var uid = id;
        var flag = false;
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'unflagGYM',
                type: 'master',
                ufuser: uid
            },
            success: function (data, textStatus, xhr) {
                console.log(data);
                data = $.trim(data);
                if (data) {
                    flag = true;
                }
            },
            error: function () {
                $(loader).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
        return flag;
    }
}

