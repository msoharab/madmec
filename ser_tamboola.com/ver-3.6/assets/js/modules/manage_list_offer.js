function controlManageSix() {
    var mgsix = {};
    var v1 = null;
    var v2 = null;
    var v5 = null;
    var dur = null;
    var fact = null;
    var att = {};
    var gymid = $(DGYM_ID).attr('name');
    this.__construct = function (managesix) {
        mgsix = managesix;
        initializeofferpanel();
    }
    this.offereditData = function (editdata) {
        console.log(editdata);
        v5 = $(editdata.mem + ' :selected').val();
        dur = editdata.durVal;
        fact = editdata.faceid;
        att = {
            name: $(editdata.name).val(),
            numofday: $(editdata.numofday).val(),
            prize: $(editdata.prize).val(),
            mem: v5,
            duration: dur,
            facility: fact,
            descr: $(editdata.descr).val()
        };
        console.log(att);
        initializelistofferduration(editdata);
        initializelistofferfacility(editdata);
        $(editdata.mem).on('change', function () {
            v5 = $(editdata.mem + ' :selected').val();
            att = {
                name: $(editdata.name).val(),
                numofday: $(editdata.numofday).val(),
                prize: $(editdata.prize).val(),
                mem: v5,
                duration: dur,
                facility: fact,
                descr: $(editdata.descr).val(),
            };
            console.log(att);
        });
        $(editdata.facility).on('change', function () {
            fact = $(editdata.facility + ' :selected').val();
            att = {
                name: $(editdata.name).val(),
                numofday: $(editdata.numofday).val(),
                prize: $(editdata.prize).val(),
                mem: v5,
                duration: dur,
                facility: fact,
                descr: $(editdata.descr).val(),
            };
            console.log(att);
        });
        $(editdata.duration).on('change', function () {
            dur = $(editdata.duration + ' :selected').val();
            if (dur != 'null') {
                var temp = $(editdata.duration + ' :selected').text();
                $(editdata.numofday).val(temp.split("-")[1]);
            }
            att = {
                name: $(editdata.name).val(),
                numofday: $(editdata.numofday).val(),
                prize: $(editdata.prize).val(),
                mem: v5,
                duration: dur,
                facility: fact,
                descr: $(editdata.descr).val(),
            };
            console.log(att);
        });
        var flag = true;
        $(editdata.offersave).bind('click', {
            eId: editdata.editId,
            tabid: editdata.tabId
        }, function (evt) {
            if (dur == null || dur === 'null') {
                flag = false;
                /*alert("Select Offer Duration");	 */
                $(editdata.validDur).html("Select Offer Duration");
            } else {
                flag = true;
                $(editdata.validDur).html("valid");
            }
            if (fact == null || fact === 'null') {
                flag = false;
                $(editdata.validFact).html("Select Offer Facility");
                /*alert("Select Offer facility");	 */
            } else {
                flag = true;
                $(editdata.validFact).html("valid");
            }
            if (flag) {
                att = {
                    name: $(editdata.name).val(),
                    numofday: $(editdata.numofday).val(),
                    prize: $(editdata.prize).val(),
                    mem: v5,
                    duration: dur,
                    facility: fact,
                    descr: $(editdata.descr).val(),
                };
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        autoloader: 'true',
                        action: 'updatelistdataoffer',
                        id: gymid,
                        type: 'slave',
                        gymid: gymid,
                        attdata: att,
                        ofId: evt.data.eId
                    },
                    success: function (data) {
                        console.log(data);
                        if (data == 'logout')
                            window.location.href = URL;
                        else {
                            /*alert("dfsdf");*/
                            $("#edit_offer").hide();
                            $(evt.data.tabid).click();
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
        });
        $(editdata.offercancel).bind('click', {
            tabid: editdata.tabId
        }, function (evt) {
            $("#edit_offer").hide();
            $(evt.data.tabid).click();
        });
    }
    this.listoffertable = function (attdata) {
        $("#edit_offer").hide();
        window.setTimeout(function () {
            $(attdata.tableid).dataTable({
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
                ],
                "autoWidth": true
            });
        }, 200);
        $(attdata.editBtn).bind('click', {
            index: attdata.index,
            of_id: attdata.id,
            fid: attdata.facility,
            tabid: attdata.tabId
        }, function (evt) {
            /*$("#offermpack").html('');*/
            $("#opanel_div").hide();
            $("#edit_offer").show();
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'offereditdata',
                    id: gymid,
                    type: 'slave',
                    gymid: gymid,
                    index: evt.data.index,
                    of_id: evt.data.of_id,
                    tId: evt.data.tabid
                },
                success: function (data) {
                    console.log(data);
                    if (data == 'logout')
                        window.location.href = URL;
                    else {
                        $("#edit_offer").html(data);
                    }
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        });
        $(attdata.delOkBtn).bind('click', {
            of_id: attdata.id,
            fid: attdata.facility,
            tabid: attdata.tabId
        }, function (evt) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'offerdel',
                    id: gymid,
                    type: 'slave',
                    gymid: gymid,
                    of_id: evt.data.of_id
                },
                success: function (data) {
                    if (data == 'logout')
                        window.location.href = URL;
                    else {
                        /*initializeofferpanel();*/
                        $(evt.data.tabid).click();
                    }
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        });
        $(attdata.flagokBtn).bind('click', {
            of_id: attdata.id,
            fid: attdata.facility,
            tabid: attdata.tabId
        }, function (evt) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'offerflag',
                    type: 'slave',
                    gymid: gymid,
                    of_id: evt.data.of_id
                },
                success: function (data) {
                    if (data == 'logout')
                        window.location.href = URL;
                    else {
                        /*initializeofferpanel();*/
                        $(evt.data.tabid).click();
                    }
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        });
        $(attdata.unflagokBtn).bind('click', {
            of_id: attdata.id,
            fid: attdata.facility,
            tabid: attdata.tabId
        }, function (evt) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    autoloader: 'true',
                    action: 'offerUnflag',
                    type: 'slave',
                    gymid: gymid,
                    of_id: evt.data.of_id
                },
                success: function (data) {
                    if (data == 'logout')
                        window.location.href = URL;
                    else {
                        /*initializeofferpanel();*/
                        $(evt.data.tabid).click();
                    }
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    /*console.log(xhr.status);*/
                }
            });
        });
    }
    function initializelistofferfacility(editdata) {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'getallfact1',
                id: gymid,
                type: 'slave',
                gymid: gymid,
                fid: editdata.faceid
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(editdata.facility).html(data);
                    fact = $(editdata.facility + ' :selected').val();
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
    function initializelistofferduration(editdata) {
        var dur = ($(editdata.duration + ' :selected').val());
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'getallduration1',
                id: gymid,
                type: 'slave',
                gymid: gymid,
                dura: editdata.durVal
            },
            success: function (data) {
                if (data == 'logout')
                    window.location.href = URL;
                else {
                    $(editdata.duration).html(data);
                    dur = $(editdata.duration + ' :selected').val();
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
    function initializeofferpanel() {
        var rad = '<ul class="nav nav-tabs" id="dynamicFee">';
        $(loader).html(LOADER_SIX);
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                autoloader: true,
                action: 'fetchInterestedIn',
                type: 'slave',
                gymid: gymid
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
                        var fee = $.parseJSON($.trim(data));
                        $(mgsix.panelheading).html(fee[0]["html"] + " Offer");
                        /* for(i=0;i<fee.length;i++){*/
                        /* if(i==0)*/
                        /* rad += '<li class="active"><a href="'+mgsix.pillpanel_div+'" id="attoTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';*/
                        /* else*/
                        /* rad += '<li><a href="'+mgsix.pillpanel_div+'" id="attoTab'+i+'" data-toggle="tab">'+fee[i]["html"]+'</a></li>';*/
                        /* }*/
                        /* rad += "</ul>";*/
                        if (fee.length > 7) {
                            var max = 7;
                            for (i = 0; i < max; i++) {
                                if (i == 0)
                                    rad += '<li class="active"><a href="' + mgsix.pillpanel_div + '" id="attoTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                                else
                                    rad += '<li><a href="cregpanel_div" id="attoTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                            }
                            rad += ' <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">More..<span class="caret"></span></a><ul class="dropdown-menu">';
                            for (i = max; i < fee.length; i++) {
                                rad += '<li><a href="cregpanel_div" id="attoTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                            }
                            rad += ' </li></ul>';
                        } else {
                            for (i = 0; i < fee.length; i++) {
                                if (i == 0)
                                    rad += '<li class="active"><a href="' + mgsix.pillpanel_div + '" id="attoTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                                else
                                    rad += '<li><a href="cregpanel_div" id="attoTab' + i + '" data-toggle="tab">' + fee[i]["html"] + '</a></li>';
                            }
                        }
                        $(mgsix.st_panel).html(rad);
                        $(loader).html('');
                        for (i = 0; i < fee.length; i++) {
                            $(mgsix.allattTab + i).bind('click', {
                                fid: fee[i]["id"],
                                name: fee[i]["html"],
                                sindex: i
                            }, function (evt) {
                                $(mgsix.pillpanel_div).show();
                                $(mgsix.panelheading).html(evt.data.name + " Offer");
                                var para1 = {
                                    fid: evt.data.fid,
                                    fname: evt.data.name,
                                    sindex: evt.data.sindex,
                                    tabId: mgsix.allattTab + evt.data.sindex,
                                }
                                /*displayFeeUserList(para1);*/
                                initializeofferdata(para1);
                            });
                            if (i == 0) {
                                var para1 = {
                                    fid: fee[i]["id"],
                                    fname: fee[i]["html"],
                                    sindex: i,
                                    tabId: mgsix.allattTab + i,
                                }
                                $(mgsix.pillpanel_div).show();
                                $(mgsix.panelheading).html(para1.fname + " Offer");
                                initializeofferdata(para1);
                            }
                        }
                        break;
                }
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    function initializeofferdata(para1) {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                autoloader: 'true',
                action: 'list_offer',
                gymid: gymid,
                type: 'slave',
                fid: para1.fid,
                tid: para1.tabId
            },
            success: function (data) {
                console.log(data);
                if (data == 'logout')
                    window.location.href = URL;
                else
                    $(mgsix.pillpanel_div).html(data);
                /*$(para1.tabId).click();*/
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                /*console.log(xhr.status);*/
            }
        });
    }
}
;
