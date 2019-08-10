	function userController() {
	    var usr = {};
	    var ipdata = {};
	    var em = {};
	    var cn = {};
	    var ac = {};
	    var pd = {};
	    var crn = {};
	    var pan = {};
	    var tin = {};
	    var svt = {};
	    var usertypes = {};
	    var PCR_reg = '';
	    var dccode = '91';
	    var dpcode = '080';
	    var tableheader = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover" id="dataTables-Listusers"><tbody>';
	    var tablefooter = '</tbody></table></div>';
	    this.countries = {};
	    this.states = {};
	    this.districts = {};
	    this.cities = {};
	    this.localities = {};
	    this.__construct = function(usrctrl) {
	        usr = usrctrl.usr;
	        pan = usrctrl.pan;
	        cn = usrctrl.cn;
	        em = usrctrl.em;
	        ac = usrctrl.ac;
	        pd = usrctrl.pd;
	        crn = usrctrl.crn;
	        tin = usrctrl.tin;
	        svt = usrctrl.svt;
	        if (usr.list) {
	            $(usr.list.menuBut).click(function() {
	                DisplayUserList();
	            });
	        }
	        if (usr.add.action == 'addUser') {
	            $(usr.add.menuBut).click(function(evt) {
	                // evt.stopPropagation();
	                // evt.preventDefault();
	                clearuserAddForm();
	                $(usr.msgDiv).html('');
	            });
	            $(usr.add.but).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                userAdd();
	            });

	            fetchUserTypes();

	        } else if (usr.add.action == 'editUser') {} else {}
	        initializeUserAddForm();
	        $(usr.add.addshow).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(this).hide();
	            $(usr.add.addhide).show();
	            $(usr.add.addbody).show();
	        })
	        $(usr.add.addhide).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(this).hide();
	            $(usr.add.addshow).show();
	            $(usr.add.addbody).hide();
	        })
	    };
	    this.editUserBasicInfo = function(binfo) {
	        var basicinfo = binfo;
	        $(basicinfo.menuBut).click(function(evt) {
	            // evt.stopPropagation();
	            // evt.preventDefault();
	            $(basicinfo.name).change(function() {
	                if ($(basicinfo.name).val().match(name_reg)) {
	                    flag = true;
	                    $(basicinfo.nmsg).html(VALIDNOT);
	                } else {
	                    flag = false;
	                    $(basicinfo.nmsg).html(INVALIDNOT);
	                }
	            });
	            fetchUserTypes();
	        });
	        $(basicinfo.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            editBasicInfo();
	        });

	        function fetchUserTypes() {
	            var htm = '';
	            $(basicinfo.TVUtype).html('');
	            $.ajax({
	                type: 'POST',
	                url: basicinfo.url,
	                data: {
	                    autoloader: true,
	                    action: 'fetchUserTypes'
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            var type = $.parseJSON(data);
	                            usertypes = type;
	                            for (i = 0; i < type.length; i++) {
	                                htm += type[i]["html"];
	                            }
	                            $(basicinfo.TVUtype).html('<select class="form-control" id="' + basicinfo.user_type + '"><option value="NULL" selected>Select user type</option>' + htm + '</select><p class="help-block" id="' + basicinfo.ut_msg + '">Enter / Select</p>');
	                            break;
	                    }
	                },
	                error: function() {
	                    $(basicinfo.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        }

	        function editBasicInfo() {
	            var flag = false;
	            var type = $('#' + basicinfo.user_type).val();
	            /* ACS ID */
	            if ($(basicinfo.acs_id).val().length < 21) {
	                flag = true;
	                $(basicinfo.ac_msg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(basicinfo.ac_msg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(basicinfo.ac_msg).offset().top) - 95
	                }, "slow");
	                $(basicinfo.acs_id).focus();
	                return;
	            }
	            if (type != 'NULL' && type != '') {
	                flag = true;
	            } else {
	                flag = false;
	                $('#' + basicinfo.ut_msg).html('<strong class="text-danger">Select user type.</strong>');
	                $('html, body').animate({
	                    scrollTop: Number($('#' + basicinfo.ut_msg).offset().top) - 95
	                }, "slow");
	                return;
	            }
	            /* User name */
	            if ($(basicinfo.name).val().match(name_reg)) {
	                flag = true;
	                $(basicinfo.nmsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(basicinfo.nmsg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(basicinfo.nmsg).offset().top) - 95
	                }, "slow");
	                $(basicinfo.name).focus();
	                return;
	            }
	            /* Postal Code */
	            if ($(basicinfo.pcode).val().length > 0) {
	                if ($(basicinfo.pcode).val().match(ccod_reg)) {
	                    flag = true;
	                    $(basicinfo.tpmsg).html(VALIDNOT);
	                } else {
	                    flag = false;
	                    $(basicinfo.tpmsg).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(basicinfo.tpmsg).offset().top) - 95
	                    }, "slow");
	                    $(basicinfo.pcode).focus();
	                    return;
	                }
	            }
	            /* Telephone Number */
	            if ($(basicinfo.tphone).val().length > 0) {
	                if ($(basicinfo.tphone).val().match(tele_reg)) {
	                    flag = true;
	                    $(basicinfo.tpmsg).html(VALIDNOT);
	                } else {
	                    flag = false;
	                    $(basicinfo.tpmsg).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(basicinfo.tpmsg).offset().top) - 95
	                    }, "slow");
	                    $(basicinfo.tele_reg).focus();
	                    return;
	                }
	            }
	            if (flag) {
	                var attr = {
	                    uid: basicinfo.uid,
	                    index: basicinfo.index,
	                    listindex: basicinfo.listindex,
	                    user_type: type,
	                    name: $(basicinfo.name).val(),
	                    acs_id: $(basicinfo.acs_id).val(),
	                    tphone: $(basicinfo.tphone).val(),
	                    pcode: $(basicinfo.pcode).val()
	                };
	                $.ajax({
	                    url: basicinfo.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editBasicInfo',
	                        binfo: attr
	                    },
	                    success: function(data, textStatus, xhr) {
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                $(basicinfo.reloadBut).trigger('click');
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(basicinfo.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };
	    };
	    this.editUserEmailIds = function(email) {
	        var em = email;
	        var min = em.num;
	        $(em.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            em.num = min;
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
	                    action: 'loadEmailIdForm',
	                    det: em
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(em.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + em.plus).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    addMultipleEmailIds();
	                                });
	                                $('#' + em.saveBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    editEmailId();
	                                });
	                                $('#' + em.closeBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    listEmailIds();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldemail) {
	                                        for (i = 0; i < data.oldemail.length; i++) {
	                                            var id = Number(data.oldemail[i].id);
	                                            $('#' + data.oldemail[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
	                                                event.stopPropagation();
	                                                event.preventDefault();
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
	                error: function(xhr, textStatus) {
	                    $(em.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultipleEmailIds() {
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
	                '<input class="form-control" placeholder="Email ID" name="email" type="text" id="' + oldemail.textid + '" maxlength="100"/>' +
	                '<span class="input-group-addon"><button class="btn  btn-danger btn-circle" id="' + oldemail.deleteid + '"><i class="fa fa-minus fa-fw "></i></button></span>' +
	                '</div><div class="col-lg-12"><p class="help-block" id="' + oldemail.msgid + '">Enter / Select</p></div></div>';
	            $(em.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldemail.deleteid)).click(function(evt) {
	                    evt.stopPropagation();
	                    evt.preventDefault();
	                    if (em.num >= min)
	                        em.num--;
	                    $(this).parent().parent().parent().remove();
	                    $(document.getElementById(em.minus + em.num + '_delete')).show();
	                });
	            }, 200);
	        };

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
	            /* Email ids */
	            if (em.num > -1) {
	                j = 0;
	                k = 0;
	                for (i = 0; i <= em.num; i++) {
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
	                $.ajax({
	                    url: em.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editEmailId',
	                        emailids: emailids
	                    },
	                    success: function(data, textStatus, xhr) {
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                loadEmailIdForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(em.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deleteEmailId(id) {
	            var flag = false;
	            $.ajax({
	                url: em.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deleteEmailId',
	                    eid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(em.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

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
	                    action: 'listEmailIds',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
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
	                error: function(xhr, textStatus) {
	                    $(em.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserPans = function(pann) {
	        var pn = pann;
	        var min = pn.num;
	        $(pn.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            pn.num = min;
	            loadPanForm();
	        });

	        function loadPanForm() {
	            pn.num = min;
	            $(pn.parentDiv).html(LOADER_TWO);
	            $.ajax({
	                url: pn.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'loadPanForm',
	                    det: pn
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(pn.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + pn.plus).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    addMultiplePans();
	                                });
	                                $('#' + pn.saveBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    editPan();
	                                });
	                                $('#' + pn.closeBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    listPans();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldpan) {
	                                        for (i = 0; i < data.oldpan.length; i++) {
	                                            var id = Number(data.oldpan[i].id);
	                                            $('#' + data.oldpan[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
	                                                event.stopPropagation();
	                                                event.preventDefault();
	                                                $($(this).prop('name')).hide(400);
	                                                if (deletePan(event.data.param1)) {
	                                                    loadPanForm();
	                                                }
	                                            });
	                                        }
	                                    }
	                                }, 300);
	                            });
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(pn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultiplePans() {
	            pn.num++;
	            for (i = min; i < pn.num; i++) {
	                $(document.getElementById(pn.minus + i + '_delete')).hide();
	            }
	            var oldpan = {
	                formid: pn.form + pn.num,
	                textid: pn.pan + pn.num,
	                msgid: pn.msgDiv + pn.num,
	                deleteid: pn.minus + pn.num + '_delete'
	            };
	            var html = '<div><div class="form-group input-group" id="' + oldpan.formid + '">' +
	                '<input class="form-control" placeholder="PAN Number" name="pan" type="text" id="' + oldpan.textid + '" maxlength="100"/>' +
	                '<span class="input-group-addon"><button class="btn  btn-danger btn-circle" id="' + oldpan.deleteid + '"><i class="fa fa-minus fa-fw "></i></button></span>' +
	                '</div><div class="col-lg-12"><p class="help-block" id="' + oldpan.msgid + '">Enter / Select</p></div></div>';
	            $(pn.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldpan.deleteid)).click(function(evt) {
	                    evt.stopPropagation();
	                    evt.preventDefault();
	                    if (pn.num >= min)
	                        pn.num--;
	                    $(this).parent().parent().parent().remove();
	                    $(document.getElementById(pn.minus + pn.num + '_delete')).show();
	                });
	            }, 200);
	        };

	        function editPan() {
	            var insert = [];
	            var update = [];
	            var pans = {
	                insert: insert,
	                update: update,
	                uid: pn.uid,
	                index: pn.index,
	                listindex: pn.listindex
	            };
	            var flag = false;
	            /* Pans*/
	            if (pn.num > -1) {
	                j = 0;
	                k = 0;
	                for (i = 0; i <= pn.num; i++) {
	                    var pns = $(document.getElementById(pn.pan + i)).val();
	                    var id = $(document.getElementById(pn.pan + i)).prop('name');
	                    if (!pns == "") {
	                        flag = true;
	                        $(document.getElementById(pns.msgDiv + i)).html(VALIDNOT);
	                        if (id != 'pan') {
	                            update[j] = {
	                                pan: pns,
	                                id: id
	                            };
	                            j++;
	                        } else if (id == 'pan') {
	                            insert[k] = pns;
	                            k++;
	                        }
	                    } else {
	                        flag = false;
	                        $(document.getElementById(pn.msgDiv + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(pn.msgDiv + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(pn.pan + i)).focus();
	                        return;
	                    }
	                }
	            }
	            if (flag) {
	                pans.insert = insert;
	                pans.update = update;
	                $.ajax({
	                    url: pn.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editPan',
	                        pans: pans
	                    },
	                    success: function(data, textStatus, xhr) {
	                        console.log(data)
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                loadPanForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(pn.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deletePan(id) {
	            var flag = false;
	            $.ajax({
	                url: pn.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deletePan',
	                    pid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(pn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

	        function listPans() {
	            var para = {
	                uid: pn.uid,
	                index: pn.index,
	                listindex: pn.listindex
	            };
	            var flag = false;
	            $.ajax({
	                url: pn.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'listPans',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(pn.parentDiv).html(data);
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(em.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserStc = function(stcc) {
	        var st = stcc;
	        var min = st.num;
	        $(st.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            st.num = min;
	            loadStcForm();
	        });

	        function loadStcForm() {
	            st.num = min;
	            $(st.parentDiv).html(LOADER_TWO);
	            $.ajax({
	                url: st.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'loadStcForm',
	                    det: st
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(st.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + st.plus).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    addMultipleStc();
	                                });
	                                $('#' + st.saveBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    editStc();
	                                });
	                                $('#' + st.closeBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    listStcs();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldstc) {
	                                        for (i = 0; i < data.oldstc.length; i++) {
	                                            var id = Number(data.oldstc[i].id);
	                                            $('#' + data.oldstc[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
	                                                event.stopPropagation();
	                                                event.preventDefault();
	                                                $($(this).prop('name')).hide(400);
	                                                if (deleteStc(event.data.param1)) {
	                                                    loadStcForm();
	                                                }
	                                            });
	                                        }
	                                    }
	                                }, 300);
	                            });
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(st.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultipleStc() {
	            st.num++;
	            for (i = min; i < st.num; i++) {
	                $(document.getElementById(st.minus + i + '_delete')).hide();
	            }
	            var oldstc = {
	                formid: st.form + st.num,
	                textid: st.stc + st.num,
	                msgid: st.msgDiv + st.num,
	                deleteid: st.minus + st.num + '_delete'
	            };
	            var html = '<div><div class="form-group input-group" id="' + oldstc.formid + '">' +
	                '<input class="form-control" placeholder="STC Number" name="stc" type="text" id="' + oldstc.textid + '" maxlength="100"/>' +
	                '<span class="input-group-addon"><button class="btn  btn-danger btn-circle" id="' + oldstc.deleteid + '"><i class="fa fa-minus fa-fw "></i></button></span>' +
	                '</div><div class="col-lg-12"><p class="help-block" id="' + oldstc.msgid + '">Enter / Select</p></div></div>';
	            $(st.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldstc.deleteid)).click(function(evt) {
	                    evt.stopPropagation();
	                    evt.preventDefault();
	                    if (st.num >= min)
	                        st.num--;
	                    $(this).parent().parent().parent().remove();
	                    $(document.getElementById(st.minus + st.num + '_delete')).show();
	                });
	            }, 200);
	        };

	        function editStc() {
	            var insert = [];
	            var update = [];
	            var stcs = {
	                insert: insert,
	                update: update,
	                uid: st.uid,
	                index: st.index,
	                listindex: st.listindex
	            };
	            var flag = false;
	            /* Stcs*/
	            if (st.num > -1) {
	                j = 0;
	                k = 0;
	                for (i = 0; i <= st.num; i++) {
	                    var sts = $(document.getElementById(st.stc + i)).val();
	                    var id = $(document.getElementById(st.stc + i)).prop('name');
	                    if (!sts == "") {
	                        flag = true;
	                        $(document.getElementById(sts.msgDiv + i)).html(VALIDNOT);
	                        if (id != 'stc') {
	                            update[j] = {
	                                stc: sts,
	                                id: id
	                            };
	                            j++;
	                        } else if (id == 'stc') {
	                            insert[k] = sts;
	                            k++;
	                        }
	                    } else {
	                        flag = false;
	                        $(document.getElementById(st.msgDiv + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(st.msgDiv + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(st.stc + i)).focus();
	                        return;
	                    }
	                }
	            }
	            if (flag) {
	                stcs.insert = insert;
	                stcs.update = update;
	                $.ajax({
	                    url: st.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editStc',
	                        stcs: stcs
	                    },
	                    success: function(data, textStatus, xhr) {
	                        console.log(data)
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                loadStcForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(st.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deleteStc(id) {
	            var flag = false;
	            $.ajax({
	                url: st.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deleteStc',
	                    pid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(st.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

	        function listStcs() {
	            var para = {
	                uid: st.uid,
	                index: st.index,
	                listindex: st.listindex
	            };
	            var flag = false;
	            $.ajax({
	                url: st.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'listStcs',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(st.parentDiv).html(data);
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(st.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserTins = function(tinn) {
	        var tn = tinn;
	        var min = tn.num;
	        $(tn.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            tn.num = min;
	            loadTinForm();
	        });

	        function loadTinForm() {
	            tn.num = min;
	            $(tn.parentDiv).html(LOADER_TWO);
	            $.ajax({
	                url: tn.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'loadTinForm',
	                    det: tn
	                },
	                success: function(data, textStatus, xhr) {
	                    console.log(data);
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(tn.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + tn.plus).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    addMultipleTin();
	                                });
	                                $('#' + tn.saveBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    editTin();
	                                });
	                                $('#' + tn.closeBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    listTins();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldtin) {
	                                        for (i = 0; i < data.oldtin.length; i++) {
	                                            var id = Number(data.oldtin[i].id);
	                                            $('#' + data.oldtin[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
	                                                event.stopPropagation();
	                                                event.preventDefault();
	                                                $($(this).prop('name')).hide(400);
	                                                if (deleteTin(event.data.param1)) {
	                                                    loadTinForm();
	                                                }
	                                            });
	                                        }
	                                    }
	                                }, 300);
	                            });
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(tn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultipleTin() {
	            tn.num++;
	            for (i = min; i < tn.num; i++) {
	                $(document.getElementById(tn.minus + i + '_delete')).hide();
	            }
	            var oldtin = {
	                formid: tn.form + tn.num,
	                textid: tn.tin + tn.num,
	                msgid: tn.msgDiv + tn.num,
	                deleteid: tn.minus + tn.num + '_delete'
	            };
	            var html = '<div><div class="form-group input-group" id="' + oldtin.formid + '">' +
	                '<input class="form-control" placeholder="TIN Number" name="tin" type="text" id="' + oldtin.textid + '" maxlength="100"/>' +
	                '<span class="input-group-addon"><button class="btn  btn-danger btn-circle" id="' + oldtin.deleteid + '"><i class="fa fa-minus fa-fw "></i></button></span>' +
	                '</div><div class="col-lg-12"><p class="help-block" id="' + oldtin.msgid + '">Enter / Select</p></div></div>';
	            $(tn.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldtin.deleteid)).click(function(evt) {
	                    evt.stopPropagation();
	                    evt.preventDefault();
	                    if (tn.num >= min)
	                        tn.num--;
	                    $(this).parent().parent().parent().remove();
	                    $(document.getElementById(tn.minus + tn.num + '_delete')).show();
	                });
	            }, 200);
	        };

	        function editTin() {
	            var insert = [];
	            var update = [];
	            var tins = {
	                insert: insert,
	                update: update,
	                uid: tn.uid,
	                index: tn.index,
	                listindex: tn.listindex
	            };
	            var flag = false;
	            /* Tins */
	            if (tn.num > -1) {

	                j = 0;
	                k = 0;
	                for (i = 0; i <= tn.num; i++) {
	                    var tns = $(document.getElementById(tn.tin + i)).val();
	                    var id = $(document.getElementById(tn.tin + i)).prop('name');
	                    if (tns != "") {
	                        flag = true;
	                        $(document.getElementById(tn.msgDiv + i)).html(VALIDNOT);
	                        if (id != 'tin') {
	                            update[j] = {
	                                tin: tns,
	                                id: id
	                            };
	                            j++;
	                        } else if (id == 'tin') {
	                            insert[k] = tns;
	                            k++;
	                        }
	                    } else {
	                        flag = false;
	                        $(document.getElementById(tn.msgDiv + i)).html(INVALIDNOT);
	                        alert(Number($(document.getElementById(tn.msgDiv + i))));
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(tn.msgDiv + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(tn.tin + i)).focus();
	                        return;
	                    }
	                    console.log(tn.msgDiv + i)
	                }
	            }
	            if (flag) {
	                tins.insert = insert;
	                tins.update = update;
	                $.ajax({
	                    url: tn.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editTin',
	                        tins: tins
	                    },
	                    success: function(data, textStatus, xhr) {
	                        console.log(data);
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                loadTinForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(tn.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deleteTin(id) {
	            alert(id);
	            console.log(id);
	            var flag = false;
	            $.ajax({
	                url: tn.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deleteTin',
	                    pid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                            flag = data;
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(tn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

	        function listTins() {
	            var para = {
	                uid: tn.uid,
	                index: tn.index,
	                listindex: tn.listindex
	            };
	            var flag = false;
	            $.ajax({
	                url: tn.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'listTins',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(tn.parentDiv).html(data);
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(tn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserCrn = function(crnn) {
	        var st = crnn;
	        var min = st.num;
	        $(st.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            st.num = min;
	            loadCrnForm();
	        });

	        function loadCrnForm() {
	            st.num = min;
	            $(st.parentDiv).html(LOADER_TWO);
	            $.ajax({
	                url: st.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'loadCrnForm',
	                    det: st
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(st.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + st.plus).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    addMultipleCrn();
	                                });
	                                $('#' + st.saveBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    editCrn();
	                                });
	                                $('#' + st.closeBut).click(function(evt) {
	                                    evt.stopPropagation();
	                                    evt.preventDefault();
	                                    listCrns();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldstc) {
	                                        for (i = 0; i < data.oldstc.length; i++) {
	                                            var id = Number(data.oldstc[i].id);
	                                            $('#' + data.oldstc[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
	                                                event.stopPropagation();
	                                                event.preventDefault();
	                                                $($(this).prop('name')).hide(400);
	                                                if (deleteCrn(event.data.param1)) {
	                                                    loadCrnForm();
	                                                }
	                                            });
	                                        }
	                                    }
	                                }, 300);
	                            });
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(st.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultipleCrn() {
	            st.num++;
	            for (i = min; i < st.num; i++) {
	                $(document.getElementById(st.minus + i + '_delete')).hide();
	            }
	            var oldstc = {
	                formid: st.form + st.num,
	                textid: st.stc + st.num,
	                msgid: st.msgDiv + st.num,
	                deleteid: st.minus + st.num + '_delete'
	            };
	            var html = '<div><div class="form-group input-group" id="' + oldstc.formid + '">' +
	                '<input class="form-control" placeholder="Company Representative Name" name="crn" type="text" id="' + oldstc.textid + '" maxlength="100"/>' +
	                '<span class="input-group-addon"><button class="btn  btn-danger btn-circle" id="' + oldstc.deleteid + '"><i class="fa fa-minus fa-fw "></i></button></span>' +
	                '</div><div class="col-lg-12"><p class="help-block" id="' + oldstc.msgid + '">Enter / Select</p></div></div>';
	            $(st.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldstc.deleteid)).click(function(evt) {
	                    evt.stopPropagation();
	                    evt.preventDefault();
	                    if (st.num >= min)
	                        st.num--;
	                    $(this).parent().parent().parent().remove();
	                    $(document.getElementById(st.minus + st.num + '_delete')).show();
	                });
	            }, 200);
	        };

	        function editCrn() {
	            var insert = [];
	            var update = [];
	            var stcs = {
	                insert: insert,
	                update: update,
	                uid: st.uid,
	                index: st.index,
	                listindex: st.listindex
	            };
	            var flag = false;
	            /* Stcs*/
	            if (st.num > -1) {
	                j = 0;
	                k = 0;
	                for (i = 0; i <= st.num; i++) {
	                    var sts = $(document.getElementById(st.stc + i)).val();
	                    var id = $(document.getElementById(st.stc + i)).prop('name');
	                    if (!sts == "") {
	                        flag = true;
	                        $(document.getElementById(sts.msgDiv + i)).html(VALIDNOT);
	                        if (id != 'crn') {
	                            update[j] = {
	                                stc: sts,
	                                id: id
	                            };
	                            j++;
	                        } else if (id == 'crn') {
	                            insert[k] = sts;
	                            k++;
	                        }
	                    } else {
	                        flag = false;
	                        $(document.getElementById(st.msgDiv + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(st.msgDiv + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(st.stc + i)).focus();
	                        return;
	                    }
	                }
	            }
	            if (flag) {
	                stcs.insert = insert;
	                stcs.update = update;
	                $.ajax({
	                    url: st.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editCrn',
	                        stcs: stcs
	                    },
	                    success: function(data, textStatus, xhr) {
	                        console.log(data);
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                loadCrnForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(st.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deleteCrn(id) {
	            var flag = false;
	            $.ajax({
	                url: st.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deleteCrn',
	                    pid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(st.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

	        function listCrns() {
	            var para = {
	                uid: st.uid,
	                index: st.index,
	                listindex: st.listindex
	            };
	            var flag = false;
	            $.ajax({
	                url: st.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'listCrns',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(st.parentDiv).html(data);
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(st.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserCellNumbers = function(cnumber) {
	        var cn = cnumber;
	        var min = cn.num;
	        $(cn.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            cn.num = min;
	            loadCellNumForm();
	        });

	        function loadCellNumForm() {
	            cn.num = min;
	            $(cn.parentDiv).html(LOADER_TWO);
	            $.ajax({
	                url: cn.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'loadCellNumForm',
	                    det: cn
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(cn.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + cn.plus).click(function() {
	                                    addMultipleCellNums();
	                                });
	                                $('#' + cn.saveBut).click(function() {
	                                    editCellNum();
	                                });
	                                $('#' + cn.closeBut).click(function() {
	                                    listCellNums();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldcnum) {
	                                        for (i = 0; i < data.oldcnum.length; i++) {
	                                            var id = Number(data.oldcnum[i].id);
	                                            $('#' + data.oldcnum[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
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
	                error: function(xhr, textStatus) {
	                    $(cn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultipleCellNums() {
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
	                '<input class="form-control" placeholder="Cell number" name="cnumber" type="text" id="' + oldcnum.textid + '" maxlength="10"/>' +
	                '<span class="input-group-addon"><button class="btn  btn-danger btn-circle" id="' + oldcnum.deleteid + '"><i class="fa fa-minus fa-fw "></i></button></span>' +
	                '</div><div class="col-lg-12"><p class="help-block" id="' + oldcnum.msgid + '">Enter / Select</p></div></div>';
	            $(cn.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldcnum.deleteid)).click(function() {
	                    if (cn.num >= min)
	                        cn.num--;
	                    $(this).parent().parent().parent().remove();
	                    $(document.getElementById(cn.minus + cn.num + '_delete')).show();
	                });
	            }, 200);
	        };

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
	            /* Cell numbers */
	            if (cn.num > -1) {
	                j = 0;
	                k = 0;
	                for (i = 0; i <= cn.num; i++) {
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
	                $.ajax({
	                    url: cn.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editCellNum',
	                        CellNums: CellNums
	                    },
	                    success: function(data, textStatus, xhr) {
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                loadCellNumForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(cn.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deleteCellNum(id) {
	            var flag = false;
	            $.ajax({
	                url: cn.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deleteCellNum',
	                    eid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(cn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

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
	                    action: 'listCellNums',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(cn.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserProducts = function(prdname) {
	        var pd = prdname;
	        var min = pd.num;
	        $(pd.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            pd.num = min;
	            loadPrdNameForm();
	        });

	        function loadPrdNameForm() {
	            pd.num = min;
	            $(pd.parentDiv).html(LOADER_TWO);
	            $.ajax({
	                url: pd.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'loadPrdNameForm',
	                    det: pd
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(pd.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + pd.plus).click(function() {
	                                    addMultiplePrdNames();
	                                });
	                                $('#' + pd.saveBut).click(function() {
	                                    editPrdName();
	                                });
	                                $('#' + pd.closeBut).click(function() {
	                                    listPrdNames();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldprdname) {
	                                        for (i = 0; i < data.oldprdname.length; i++) {
	                                            var id = Number(data.oldprdname[i].id);
	                                            $('#' + data.oldprdname[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
	                                                $($(this).prop('name')).hide(400);
	                                                if (deletePrdName(event.data.param1)) {
	                                                    loadPrdNameForm();
	                                                }
	                                            });
	                                        }
	                                    }
	                                }, 300);
	                            });
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(pd.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultiplePrdNames() {
	            pd.num++;
	            for (i = min; i < pd.num; i++) {
	                $(document.getElementById(pd.minus + i + '_delete')).hide();
	            }
	            var oldprdname = {
	                formid: pd.form + pd.num,
	                textid: pd.prdname + pd.num,
	                msgid: pd.msgDiv + pd.num,
	                deleteid: pd.minus + pd.num + '_delete'
	            };
	            var html = '<div><div class="form-group input-group" id="' + oldprdname.formid + '">' +
	                '<input class="form-control" placeholder="Product name" name="prdname" type="text" id="' + oldprdname.textid + '" maxlength="50"/>' +
	                '<span class="input-group-addon"><button class="btn  btn-danger btn-circle" id="' + oldprdname.deleteid + '"><i class="fa fa-minus fa-fw "></i></button></span>' +
	                '</div><div class="col-lg-12"><p class="help-block" id="' + oldprdname.msgid + '">Enter / Select</p></div></div>';
	            $(pd.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldprdname.deleteid)).click(function() {
	                    if (pd.num >= min)
	                        pd.num--;
	                    $(this).parent().parent().parent().remove();
	                    $(document.getElementById(pd.minus + pd.num + '_delete')).show();
	                });
	            }, 200);
	        };

	        function editPrdName() {
	            var insert = [];
	            var update = [];
	            var PrdNames = {
	                insert: insert,
	                update: update,
	                uid: pd.uid,
	                index: pd.index,
	                listindex: pd.listindex
	            };
	            var flag = false;
	            if (pd.num > -1) {
	                j = 0;
	                k = 0;
	                for (i = 0; i <= pd.num; i++) {
	                    // console.log($(document.getElementById(pd.prdname+i)).val());
	                    // console.log(pd.pdumber+i);
	                    var ems = $(document.getElementById(pd.prdname + i)).val();
	                    var id = $(document.getElementById(pd.prdname + i)).prop('name');
	                    if (ems.match(name_reg)) {
	                        flag = true;
	                        $(document.getElementById(pd.msgDiv + i)).html(VALIDNOT);
	                        if (id != 'prdname') {
	                            update[j] = {
	                                prdname: ems,
	                                id: id
	                            };
	                            j++;
	                        } else if (id == 'prdname') {
	                            insert[k] = ems;
	                            k++;
	                        }
	                    } else {
	                        flag = false;
	                        $(document.getElementById(pd.msgDiv + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(pd.msgDiv + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(pd.email + i)).focus();
	                        return;
	                    }
	                }
	            }
	            if (flag) {
	                PrdNames.insert = insert;
	                PrdNames.update = update;
	                $.ajax({
	                    url: pd.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editPrdName',
	                        PrdNames: PrdNames
	                    },
	                    success: function(data, textStatus, xhr) {
	                        console.log(data);
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                console.log(data);
	                                loadPrdNameForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(pd.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deletePrdName(id) {
	            var flag = false;
	            $.ajax({
	                url: pd.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deletePrdName',
	                    eid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(pd.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

	        function listPrdNames() {
	            var para = {
	                uid: pd.uid,
	                index: pd.index,
	                listindex: pd.listindex
	            };
	            var flag = false;
	            $.ajax({
	                url: pd.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'listPrdNames',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(pd.parentDiv).html(data);
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(pd.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserBankAccounts = function(acc) {
	        var ac = acc;
	        var min = Number(ac.num);
	        ac.num = Number(ac.num);
	        $(ac.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            ac.num = min;
	            loadBankAcForm();
	        });

	        function loadBankAcForm() {
	            ac.num = min;
	            $(ac.parentDiv).html(LOADER_TWO);
	            $.ajax({
	                url: ac.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'loadBankAcForm',
	                    det: ac
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.parseJSON($.trim(data));
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        default:
	                            $(ac.parentDiv).html(data.html);
	                            $(document).ready(function() {
	                                $('#' + ac.plus).click(function() {
	                                    addMultipleBankAcs();
	                                });
	                                $('#' + ac.saveBut).click(function() {
	                                    editBankAc();
	                                });
	                                $('#' + ac.closeBut).click(function() {
	                                    listBankAcs();
	                                });
	                                window.setTimeout(function() {
	                                    if (data.oldbank) {
	                                        for (i = 0; i < data.oldbank.length; i++) {
	                                            var id = Number(data.oldbank[i].id);
	                                            $('#' + data.oldbank[i].deleteOk).click({
	                                                param1: id
	                                            }, function(event) {
	                                                $($(this).prop('name')).hide(400);
	                                                if (deleteBankAc(event.data.param1)) {
	                                                    loadBankAcForm();
	                                                }
	                                            });
	                                        }
	                                    }
	                                }, 300);
	                            });
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(ac.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	        };

	        function addMultipleBankAcs() {
	            ac.num++;
	            for (i = min; i < ac.num; i++) {
	                $(document.getElementById(ac.minus + i + '_delete')).hide();
	            }
	            var oldbank = {
	                form: ac.form + ac.num,
	                bankname: ac.bankname + ac.num,
	                nmsg: ac.nmsg + ac.num,
	                accno: ac.accno + ac.num,
	                nomsg: ac.nomsg + ac.num,
	                braname: ac.braname + ac.num,
	                bnmsg: ac.bnmsg + ac.num,
	                bracode: ac.bracode + ac.num,
	                bcmsg: ac.bcmsg + ac.num,
	                IFSC: ac.IFSC + ac.num,
	                IFSCmsg: ac.IFSCmsg + ac.num,
	                deleteid: ac.minus + ac.num + '_delete'
	            };
	            var html = '<div id="' + oldbank.form + '">' +
	                '<div class="col-lg-12">' +
	                '<div class="panel panel-warning">' +
	                '<div class="panel-heading">' +
	                '<strong>Bank account ' + (ac.num + 1) + '</strong>' +
	                '&nbsp;<button class="btn btn-danger btn-circle" id="' + oldbank.deleteid + '"><i class="fa fa-trash fa-fw"></i></button>' +
	                '</div>' +
	                '<div class="panel-body">' +
	                '<div class="row">' +
	                '<div class="col-lg-12">' +
	                '<input class="form-control" placeholder="Bank Name" name="bankname" type="text" id="' + oldbank.bankname + '" maxlength="100"/>' +
	                '<p class="help-block" id="' + oldbank.nmsg + '">Valid.</p>' +
	                '</div>' +
	                '</div>' +
	                '<div class="row">' +
	                '<div class="col-lg-12">' +
	                '<input class="form-control" placeholder="Account Number" name="accno" type="text" id="' + oldbank.accno + '" maxlength="100"/>' +
	                '<p class="help-block" id="' + oldbank.nomsg + '">Valid.</p>' +
	                '</div>' +
	                '</div>' +
	                '<div class="row">' +
	                '<div class="col-lg-12">' +
	                '<input class="form-control" placeholder="Branch Name" name="braname" type="text" id="' + oldbank.braname + '" maxlength="100" />' +
	                '<p class="help-block" id="' + oldbank.bnmsg + '">Valid.</p>' +
	                '</div>' +
	                '</div>' +
	                '<div class="row">' +
	                '<div class="col-lg-12">' +
	                '<input class="form-control" placeholder="Branch Code" name="bracode" type="text" id="' + oldbank.bracode + '" maxlength="100"/>' +
	                '<p class="help-block" id="' + oldbank.bcmsg + '">Valid.</p>' +
	                '</div>' +
	                '</div>' +
	                '<div class="row">' +
	                '<div class="col-lg-12">' +
	                '<input class="form-control" placeholder="IFSC" name="IFSC" type="text" id="' + oldbank.IFSC + '" maxlength="100"/>' +
	                '<p class="help-block" id="' + oldbank.IFSCmsg + '">Valid.</p>' +
	                '</div>' +
	                '</div>' +
	                '</div>' +
	                '</div>' +
	                '</div>' +
	                '</div>';
	            $(ac.parentDiv).append(html);
	            window.setTimeout(function() {
	                $(document.getElementById(oldbank.deleteid)).click(function() {
	                    $(document.getElementById(ac.form + ac.num)).remove();
	                    if (ac.num >= min)
	                        ac.num--;
	                    $(document.getElementById(ac.minus + ac.num + '_delete')).show();
	                });
	            }, 200);
	        };

	        function editBankAc() {
	            var insert = [];
	            var update = [];
	            var BankAcs = {
	                insert: insert,
	                update: update,
	                uid: ac.uid,
	                index: ac.index,
	                listindex: ac.listindex
	            };
	            var flag = false;
	            /* Bank Account */
	            if (ac.num > -1) {
	                j = 0;
	                k = 0;
	                for (i = 0; i <= ac.num; i++) {
	                    var bankname = $(document.getElementById(ac.bankname + i)).val();
	                    var accno = $(document.getElementById(ac.accno + i)).val();
	                    var braname = $(document.getElementById(ac.braname + i)).val();
	                    var bracode = $(document.getElementById(ac.bracode + i)).val();
	                    var IFSC = $(document.getElementById(ac.IFSC + i)).val();
	                    var id = $(document.getElementById(ac.bankname + i)).prop('name');
	                    if ($(document.getElementById(ac.bankname + i)).val().match(name_reg)) {
	                        flag = true;
	                        $(document.getElementById(ac.nmsg + i)).html(VALIDNOT);
	                    } else {
	                        flag = false;
	                        $(document.getElementById(ac.nmsg + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(ac.nmsg + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(ac.bankname + i)).focus();
	                        return;
	                    }
	                    if ($(document.getElementById(ac.accno + i)).val().match(accn_reg)) {
	                        flag = true;
	                        $(document.getElementById(ac.nomsg + i)).html(VALIDNOT);
	                    } else {
	                        flag = false;
	                        $(document.getElementById(ac.nomsg + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(ac.nomsg + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(ac.accno + i)).focus();
	                        return;
	                    }
	                    if ($(document.getElementById(ac.braname + i)).val().length < 101) {
	                        flag = true;
	                        $(document.getElementById(ac.bnmsg + i)).html(VALIDNOT);
	                    } else {
	                        flag = false;
	                        $(document.getElementById(ac.bnmsg + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(ac.bnmsg + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(ac.braname + i)).focus();
	                        return;
	                    }
	                    if ($(document.getElementById(ac.bracode + i)).val().length < 101) {
	                        flag = true;
	                        $(document.getElementById(ac.bcmsg + i)).html(VALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
	                        }, "slow");
	                    } else {
	                        flag = false;
	                        $(document.getElementById(ac.bcmsg + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(ac.bracode + i)).focus();
	                        return;
	                    }
	                    if ($(document.getElementById(ac.IFSC + i)).val().length < 101) {
	                        flag = true;
	                        $(document.getElementById(ac.IFSCmsg + i)).html(VALIDNOT);
	                    } else {
	                        flag = false;
	                        $(document.getElementById(ac.IFSCmsg + i)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(ac.IFSCmsg + i)).offset().top) - 95
	                        }, "slow");
	                        $(document.getElementById(ac.IFSC + i)).focus();
	                        return;
	                    }
	                    if (flag) {
	                        if (id != 'bankname') {
	                            update[j] = {
	                                bankname: bankname,
	                                accno: accno,
	                                braname: braname,
	                                bracode: bracode,
	                                IFSC: IFSC,
	                                id: id
	                            };
	                            j++;
	                        } else if (id == 'bankname') {
	                            insert[k] = {
	                                bankname: bankname,
	                                accno: accno,
	                                braname: braname,
	                                bracode: bracode,
	                                IFSC: IFSC
	                            };
	                            k++;
	                        }
	                    }
	                }
	            }
	            if (flag) {
	                BankAcs.insert = insert;
	                BankAcs.update = update;
	                $.ajax({
	                    url: ac.url,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editBankAc',
	                        BankAcs: BankAcs
	                    },
	                    success: function(data, textStatus, xhr) {
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                loadBankAcForm();
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(ac.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function deleteBankAc(id) {
	            var flag = false;
	            $.ajax({
	                url: ac.url,
	                type: 'POST',
	                async: false,
	                data: {
	                    autoloader: true,
	                    action: 'deleteBankAc',
	                    eid: id
	                },
	                success: function(data, textStatus, xhr) {
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
	                error: function(xhr, textStatus) {
	                    $(ac.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };

	        function listBankAcs() {
	            var flag = false;
	            var para = {
	                uid: ac.uid,
	                index: ac.index,
	                listindex: ac.listindex
	            };
	            var flag = false;
	            $.ajax({
	                url: ac.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'listBankAcs',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(ac.parentDiv).html(data);
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(ac.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.editUserAddress = function(addr) {
	        var address = addr;
	        var addres;
	        var PCR_reg = '';
	        var countries = {};
	        var states = {};
	        var districts = {};
	        var cities = {};
	        var localities = {};
	        $(address.but).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(address.showDiv).toggle();
	            $(address.updateDiv).toggle();
	            if ($(address.updateDiv).css('display') == 'block') {
	                addres = new Address();
	                addres.__construct({
	                    url: address.url,
	                    outputDiv: address.outputDiv
	                });
	                addres.getIPData({});
	                // addres.fillAddressFields(address);
	                countries = addres.getCountry();
	                attachAddressFields();
	            }
	        });
	        $(address.saveBut).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            editAddress();
	        });
	        $(address.closeBut).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            listAddress();
	        });

	        function attachAddressFields() {
	            var list = countries;
	            $(address.country).autocomplete({
	                minLength: 2,
	                source: list,
	                autoFocus: true,
	                select: function(event, ui) {
	                    window.setTimeout(function() {
	                        $(address.country).val(ui.item.label);
	                        $(address.country).attr('name', ui.item.value);
	                        address.countryCode = ui.item.countryCode;
	                        address.PCR_reg = ui.item.PCR;
	                        addres.setCountry(ui.item);
	                        $(address.province).val('');
	                        $(address.province).focus();
	                    }, 50);
	                    $(address.province).focus(function() {
	                        states = addres.getState();
	                        var list = states;
	                        $(address.province).autocomplete({
	                            minLength: 2,
	                            source: list,
	                            autoFocus: true,
	                            select: function(event, ui) {
	                                window.setTimeout(function() {
	                                    $(address.province).val(ui.item.label);
	                                    $(address.province).attr('name', ui.item.value);
	                                    address.provinceCode = ui.item.provinceCode;
	                                    address.lat = ui.item.lat;
	                                    address.lon = ui.item.lon;
	                                    address.timezone = ui.item.timezone;
	                                    addres.setState(ui.item);
	                                    $(address.district).val('');
	                                    $(address.district).focus();
	                                }, 50);
	                            }
	                        });
	                    });
	                    $(address.district).focus(function() {
	                        districts = addres.getDistrict();
	                        var list = districts;
	                        $(address.district).autocomplete({
	                            minLength: 2,
	                            source: list,
	                            autoFocus: true,
	                            select: function(event, ui) {
	                                window.setTimeout(function() {
	                                    $(address.district).val(ui.item.label);
	                                    $(address.district).attr('name', ui.item.value);
	                                    address.districtCode = ui.item.districtCode;
	                                    address.lat = ui.item.lat;
	                                    address.lon = ui.item.lon;
	                                    address.timezone = ui.item.timezone;
	                                    addres.setDistrict(ui.item);
	                                    $(address.city_town).val('');
	                                    $(address.city_town).focus();
	                                }, 50);
	                            }
	                        });
	                    });
	                    $(address.city_town).focus(function() {
	                        cities = addres.getCity();
	                        var list = cities;
	                        $(address.city_town).autocomplete({
	                            minLength: 2,
	                            source: list,
	                            autoFocus: true,
	                            select: function(event, ui) {
	                                window.setTimeout(function() {
	                                    $(address.city_town).val(ui.item.label);
	                                    $(address.city_town).attr('name', ui.item.value);
	                                    address.city_townCode = ui.item.city_townCode;
	                                    address.lat = ui.item.lat;
	                                    address.lon = ui.item.lon;
	                                    address.timezone = ui.item.timezone;
	                                    addres.setCity(ui.item);
	                                    $(address.st_loc).val('');
	                                    $(address.st_loc).focus();
	                                }, 50);
	                            }
	                        });
	                    });
	                    $(address.st_loc).focus(function() {
	                        localities = addres.getLocality();
	                        var list = localities;
	                        $(address.st_loc).autocomplete({
	                            minLength: 2,
	                            source: list,
	                            autoFocus: true,
	                            select: function(event, ui) {
	                                window.setTimeout(function() {
	                                    $(address.st_loc).val(ui.item.label);
	                                    $(address.st_loc).attr('name', ui.item.value);
	                                    address.st_locCode = ui.item.st_locCode;
	                                    address.lat = ui.item.lat;
	                                    address.lon = ui.item.lon;
	                                    address.timezone = ui.item.timezone;
	                                    addres.setLocality(ui.item);
	                                }, 200);
	                            }
	                        });
	                    });
	                }
	            });
	        };

	        function editAddress() {
	            /* Address */
	            var flag = false;
	            /* Country */
	            if ($(address.country).val().match(st_city_dist_cont_reg)) {
	                flag = true;
	                $(address.comsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(address.comsg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(address.comsg).offset().top) - 95
	                }, "slow");
	                $(address.country).focus();
	                return;
	            }
	            /* Province */
	            if ($(address.province).val().match(prov_reg)) {
	                flag = true;
	                $(address.prmsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(address.prmsg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(address.prmsg).offset().top) - 95
	                }, "slow");
	                $(address.province).focus();
	                return;
	            }
	            /* District */
	            if ($(address.district).val().match(st_city_dist_cont_reg)) {
	                flag = true;
	                $(address.dimsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(address.dimsg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(address.dimsg).offset().top) - 95
	                }, "slow");
	                $(address.district).focus();
	                return;
	            }
	            /* City */
	            if ($(address.city_town).val().match(st_city_dist_cont_reg)) {
	                flag = true;
	                $(address.citmsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(address.citmsg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(address.citmsg).offset().top) - 95
	                }, "slow");
	                $(address.city_town).focus();
	                return;
	            }
	            /* Street / Locality */
	            if ($(address.st_loc).val().match(st_city_dist_cont_reg)) {
	                flag = true;
	                $(address.stlmsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(address.stlmsg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(address.stlmsg).offset().top) - 95
	                }, "slow");
	                $(address.st_loc).focus();
	                return;
	            }
	            /* Address Line */
	            if ($(address.addrs).val().match(addline_reg)) {
	                flag = true;
	                $(address.admsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(address.admsg).html(INVALIDNOT);
	                $('html, body').animate({
	                    scrollTop: Number($(address.admsg).offset().top) - 95
	                }, "slow");
	                $(address.addrs).focus();
	                return;
	            }
	            // /* ZipCode*/
	            // var PCR_reg = '/'+address.PCR_reg+'/';
	            // if($(address.zipcode).val().match(PCR_reg)){
	            // flag = true;
	            // $(address.zimsg).html(VALIDNOT);
	            // }
	            // else{
	            // flag = false;
	            // $(address.zimsg).html(INVALIDNOT);
	            // $('html, body').animate({scrollTop: Number($(address.zimsg).offset().top)-95}, "slow");
	            // $(address.zipcode).focus();
	            // return;
	            // }
	            // /* Website */
	            // var url_reg = '/'+url_reg+'/';
	            // if($(address.website).val().match(url_reg)){
	            // flag = true;
	            // $(address.wemsg).html(VALIDNOT);
	            // }
	            // else{
	            // flag = false;
	            // $(address.wemsg).html(INVALIDNOT);
	            // $('html, body').animate({scrollTop: Number($(address.wemsg).offset().top)-95}, "slow");
	            // $(address.website).focus();
	            // return;
	            // }
	            // /* GMAP */
	            // if($(address.gmaphtml).val().match(url_reg)){
	            // flag = true;
	            // $(address.gmmsg).html(VALIDNOT);
	            // }
	            // else{
	            // flag = false;
	            // $(address.gmmsg).html(INVALIDNOT);
	            // $('html, body').animate({scrollTop: Number($(address.gmmsg).offset().top)-95}, "slow");
	            // $(address.gmaphtml).focus();
	            // return;
	            // }
	            var attr = {
	                uid: address.uid,
	                index: address.index,
	                listindex: address.listindex,
	                country: $(address.country).val(),
	                countryCode: address.countryCode,
	                province: $(address.province).val(),
	                provinceCode: address.provinceCode,
	                district: $(address.district).val(),
	                city_town: $(address.city_town).val(),
	                st_loc: $(address.st_loc).val(),
	                addrsline: $(address.addrs).val(),
	                zipcode: $(address.zipcode).val(),
	                website: $(address.website).val(),
	                gmaphtml: $(address.gmaphtml).val(),
	                timezone: address.timezone,
	                lat: address.lat,
	                lon: address.lon
	            };
	            if (flag) {
	                $.ajax({
	                    url: address.Updateurl,
	                    type: 'POST',
	                    data: {
	                        autoloader: true,
	                        action: 'editAddress',
	                        address: attr
	                    },
	                    success: function(data, textStatus, xhr) {
	                        data = $.parseJSON($.trim(data));
	                        switch (data) {
	                            case 'logout':
	                                logoutAdmin({});
	                                break;
	                            default:
	                                $(address.closeBut).trigger('click');
	                                break;
	                        }
	                    },
	                    error: function(xhr, textStatus) {
	                        $(address.outputDiv).html(INET_ERROR);
	                    },
	                    complete: function(xhr, textStatus) {
	                        console.log(xhr.status);
	                    }
	                });
	            }
	        };

	        function listAddress() {
	            var para = {
	                uid: address.uid,
	                index: address.index,
	                listindex: address.listindex
	            };
	            var flag = false;
	            $.ajax({
	                url: pd.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'listAddress',
	                    para: para
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(address.showDiv).html(data);
	                            $(address.showDiv).toggle();
	                            $(address.updateDiv).toggle();
	                            break;
	                    }
	                },
	                error: function(xhr, textStatus) {
	                    $(address.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                }
	            });
	            return flag;
	        };
	    };
	    this.bindAddressFields = function(addres) {
	        var list = this.countries;
	        $(usr.add.address.country).autocomplete({
	            minLength: 2,
	            source: list,
	            autoFocus: true,
	            select: function(event, ui) {
	                window.setTimeout(function() {
	                    $(usr.add.address.country).val(ui.item.label);
	                    $(usr.add.address.country).attr('name', ui.item.value);
	                    usr.add.address.countryCode = ui.item.countryCode;
	                    usr.add.address.PCR_reg = ui.item.PCR;
	                    dccode = ui.item.Phone;
	                    $(cn.codep + '0').val(ui.item.Phone);
	                    for (i = 0; i <= cn.num; i++) {
	                        $(document.getElementById(cn.codep + i)).val(ui.item.Phone);
	                    }
	                    addres.setCountry(ui.item);
	                    $(usr.add.address.province).val('');
	                    $(usr.add.address.province).focus();
	                }, 50);
	                $(usr.add.address.province).focus(function() {
	                    this.states = addres.getState();
	                    var list = this.states;
	                    $(usr.add.address.province).autocomplete({
	                        minLength: 2,
	                        source: list,
	                        autoFocus: true,
	                        select: function(event, ui) {
	                            window.setTimeout(function() {
	                                $(usr.add.address.province).val(ui.item.label);
	                                $(usr.add.address.province).attr('name', ui.item.value);
	                                usr.add.address.provinceCode = ui.item.provinceCode;
	                                usr.add.address.lat = ui.item.lat;
	                                usr.add.address.lon = ui.item.lon;
	                                usr.add.address.timezone = ui.item.timezone;
	                                addres.setState(ui.item);
	                                $(usr.add.address.district).val('');
	                                $(usr.add.address.district).focus();
	                            }, 50);
	                        }
	                    });
	                });
	                $(usr.add.address.district).focus(function() {
	                    this.districts = addres.getDistrict();
	                    var list = this.districts;
	                    $(usr.add.address.district).autocomplete({
	                        minLength: 2,
	                        source: list,
	                        autoFocus: true,
	                        select: function(event, ui) {
	                            window.setTimeout(function() {
	                                $(usr.add.address.district).val(ui.item.label);
	                                $(usr.add.address.district).attr('name', ui.item.value);
	                                usr.add.address.districtCode = ui.item.districtCode;
	                                usr.add.address.lat = ui.item.lat;
	                                usr.add.address.lon = ui.item.lon;
	                                usr.add.address.timezone = ui.item.timezone;
	                                addres.setDistrict(ui.item);
	                                $(usr.add.address.city_town).val('');
	                                $(usr.add.address.city_town).focus();
	                            }, 50);
	                        }
	                    });
	                });
	                $(usr.add.address.city_town).focus(function() {
	                    this.cities = addres.getCity();
	                    var list = this.cities;
	                    $(usr.add.address.city_town).autocomplete({
	                        minLength: 2,
	                        source: list,
	                        autoFocus: true,
	                        select: function(event, ui) {
	                            window.setTimeout(function() {
	                                $(usr.add.address.city_town).val(ui.item.label);
	                                $(usr.add.address.city_town).attr('name', ui.item.value);
	                                usr.add.address.city_townCode = ui.item.city_townCode;
	                                usr.add.address.lat = ui.item.lat;
	                                usr.add.address.lon = ui.item.lon;
	                                usr.add.address.timezone = ui.item.timezone;
	                                addres.setCity(ui.item);
	                                $(usr.add.address.st_loc).val('');
	                                $(usr.add.address.st_loc).focus();
	                            }, 50);
	                        }
	                    });
	                });
	                $(usr.add.address.st_loc).focus(function() {
	                    this.localities = addres.getLocality();
	                    var list = this.localities;
	                    $(usr.add.address.st_loc).autocomplete({
	                        minLength: 2,
	                        source: list,
	                        autoFocus: true,
	                        select: function(event, ui) {
	                            window.setTimeout(function() {
	                                $(usr.add.address.st_loc).val(ui.item.label);
	                                $(usr.add.address.st_loc).attr('name', ui.item.value);
	                                usr.add.address.st_locCode = ui.item.st_locCode;
	                                usr.add.address.lat = ui.item.lat;
	                                usr.add.address.lon = ui.item.lon;
	                                usr.add.address.timezone = ui.item.timezone;
	                                addres.setLocality(ui.item);
	                            }, 200);
	                        }
	                    });
	                });
	            }
	        });
	    };

	    function initializeUserAddForm() {
	        var flag = false;
	        $(usr.add.basicinfo.name).change(function() {
	            if ($(usr.add.basicinfo.name).val().match(name_reg)) {
	                flag = true;
	                $(usr.add.basicinfo.nmsg).html(VALIDNOT);
	            } else {
	                flag = false;
	                $(usr.add.basicinfo.nmsg).html(INVALIDNOT);
	            }
	        });
	        $(crn.plus + ',' + cn.plus + ',' + ac.plus + ',' + pd.plus + ',' + em.plus + ',' + pan.plus + ',' + tin.plus + ',' + svt.plus).unbind();
	        $(cn.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(cn.plus).hide();
	            bulitMultipleCellNumbers();
	        });
	        $(em.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(em.plus).hide();
	            bulitMultipleEmailIds();
	        });
	        $(crn.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(crn.plus).hide();
	            builtMultiplecrnames();
	        });
	        $(pan.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(pan.plus).hide();
	            builtMultiplePan();
	        });
	        $(tin.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(tin.plus).hide();
	            builtMultipleTin();
	        });
	        $(svt.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(svt.plus).hide();
	            builtMultipleSVT();
	        });
	        $(ac.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(ac.plus).hide();
	            bulitMultipleAccounts();
	        });
	        $(pd.plus).click(function(evt) {
	            evt.stopPropagation();
	            evt.preventDefault();
	            $(pd.plus).hide();
	            bulitMultipleProducts();
	        });
	    };

	    function fetchUserTypes() {
	        var htm = '';
	        $(usr.add.basicinfo.TVUtype).html(LOADER_ONE);
	        $.ajax({
	            type: 'POST',
	            url: usr.add.url,
	            data: {
	                autoloader: true,
	                action: 'fetchUserTypes'
	            },
	            success: function(data, textStatus, xhr) {
//                        console.log(data);
	                data = $.trim(data);
	                switch (data) {
	                    case 'logout':
	                        logoutAdmin({});
	                        break;
	                    case 'login':
	                        loginAdmin({});
	                        break;
	                    default:
	                        var type = $.parseJSON(data);
	                        if (type != null) {
	                            usertypes = type;
	                            for (i = 0; i < type.length; i++) {
	                                htm += type[i]["html"];
	                            }
	                            $(usr.add.basicinfo.TVUtype).html('<select class="form-control" id="' + usr.add.basicinfo.user_type + '"><option value="NULL" selected>Select user type</option>' + htm + '</select><p class="help-block" id="' + usr.add.basicinfo.ut_msg + '">Enter / Select</p>');
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(usr.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    }

	    function userAdd() {
	        var flag = false;
	        var email = [];
	        var crname = [];
	        var cellnumbers = [];
	        var accounts = [];
	        var products = [];
	        var pandata = [];
	        var tindata = [];
	        var svtdata = [];
	        var type = $('#' + usr.add.basicinfo.user_type).val();
	        /* ACS ID */
	        if ($(usr.add.basicinfo.acs_id).val().length < 21) {
	            flag = true;
	            $(usr.add.basicinfo.ac_msg).html('');
	        } else {
	            flag = false;
	            $(usr.add.basicinfo.ac_msg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(usr.add.basicinfo.ac_msg).offset().top) - 95
	            }, 'slow');
	            $(usr.add.basicinfo.acs_id).focus();
	            return;
	        }
	        if (type != 'NULL') {
	            flag = true;
	        } else {
	            flag = false;
	            $('#' + usr.add.basicinfo.ut_msg).html('<strong class="text-danger">Select user type.</strong>');
	            $('html, body').animate({
	                scrollTop: Number($('#' + usr.add.basicinfo.ut_msg).offset().top) - 95
	            }, 'slow');
	            $(usr.add.basicinfo.nmsg).focus();
	            return;
	        }
	        /* User name */
	        if ($(usr.add.basicinfo.name).val().match(name_reg)) {
	            flag = true;
	            $(usr.add.basicinfo.nmsg).html('');
	        } else {
	            flag = false;
	            $(usr.add.basicinfo.nmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(usr.add.basicinfo.nmsg).offset().top) - 95
	            }, 'slow');
	            $(usr.add.basicinfo.name).focus();
	            return;
	        }
	        /* validation for company representive names*/
	        if (crn.num > -1) {
	            j = 0;
	            for (i = 0; i <= crn.num; i++) {
	                if ($(document.getElementById(crn.crname + i)).val().match(namee_reg)) {
	                    flag = true;
	                    $(document.getElementById(crn.msgDiv + i)).html('');
	                    crname[j] = $(document.getElementById(crn.crname + i)).val();
	                    j++;
	                } else {
	                    flag = false;
	                    $(document.getElementById(crn.msgDiv + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(crn.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(crn.crname + i)).focus();
	                    return;
	                }
	            }
	        }

	        /* validation for pan   */
	        if (pan.num > -1) {
	            j = 0;
	            for (i = 0; i <= pan.num; i++) {
	                if (!$(document.getElementById(pan.pan + i)).val() == "") {
	                    flag = true;
	                    $(document.getElementById(pan.msgDiv + i)).html('');
	                    pandata[j] = $(document.getElementById(pan.pan + i)).val();
	                    j++;
	                } else {
	                    flag = false;
	                    $(document.getElementById(pan.msgDiv + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(pan.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(pan.pan + i)).focus();
	                    return;
	                }
	            }
	        }
	        for (k = 0; k < pandata.length; k++) {
	            for (l = 0; l < k; l++) {
	                if (pandata[k] == pandata[l]) {
	                    flag = false;
	                    $(document.getElementById(pan.msgDiv + k)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(pan.msgDiv + k)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(pan.pan + k)).focus();
	                    return;
	                } else {
	                    flag = true;
	                    $(document.getElementById(pan.msgDiv + k)).html('');
	                }
	            }
	        }
	        /* validation for tin   */
	        if (tin.num > -1) {
	            j = 0;
	            for (i = 0; i <= tin.num; i++) {
	                if (!$(document.getElementById(tin.tin + i)).val() == "") {
	                    flag = true;
	                    $(document.getElementById(tin.msgDiv + i)).html('');
	                    tindata[j] = $(document.getElementById(tin.tin + i)).val();
	                    j++;
	                } else {
	                    flag = false;
	                    $(document.getElementById(tin.msgDiv + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(tin.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(tin.tin + i)).focus();
	                    return;
	                }
	            }
	            for (k = 0; k < tindata.length; k++) {
	                for (l = 0; l < k; l++) {
	                    if (tindata[k] == tindata[l]) {
	                        flag = false;
	                        $(document.getElementById(tin.msgDiv + k)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(tin.msgDiv + k)).offset().top) - 95
	                        }, 'slow');
	                        $(document.getElementById(tin.tin + k)).focus();
	                        return;
	                    } else {
	                        flag = true;
	                        $(document.getElementById(tin.msgDiv + k)).html('');
	                    }
	                }
	            }
	        }
	        /* validation for stc   */
	        if (svt.num > -1) {
	            j = 0;
	            for (i = 0; i <= svt.num; i++) {
	                if (!$(document.getElementById(svt.svt + i)).val() == "") {
	                    flag = true;
	                    $(document.getElementById(svt.msgDiv + i)).html('');
	                    svtdata[j] = $(document.getElementById(svt.svt + i)).val();
	                    j++;
	                } else {
	                    flag = false;
	                    $(document.getElementById(svt.msgDiv + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(svt.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(svt.svt + i)).focus();
	                    return;
	                }
	            }
	            for (k = 0; k < svtdata.length; k++) {
	                for (l = 0; l < k; l++) {
	                    if (svtdata[k] == svtdata[l]) {
	                        flag = false;
	                        $(document.getElementById(svt.msgDiv + k)).html(INVALIDNOT);
	                        $('html, body').animate({
	                            scrollTop: Number($(document.getElementById(svt.msgDiv + k)).offset().top) - 95
	                        }, 'slow');
	                        $(document.getElementById(svt.tin + k)).focus();
	                        return;
	                    } else {
	                        flag = true;
	                        $(document.getElementById(svt.msgDiv + k)).html('');
	                    }
	                }
	            }
	        }
	        if (em.num > -1) {
	            j = 0;
	            for (i = 0; i <= em.num; i++) {
	                if ($(document.getElementById(em.email + i)).val().match(email_reg)) {
	                    flag = true;
	                    $(document.getElementById(em.msgDiv + i)).html('');
	                    email[j] = $(document.getElementById(em.email + i)).val();
	                    j++;
	                } else {
	                    flag = false;
	                    $(document.getElementById(em.msgDiv + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(em.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(em.email + i)).focus();
	                    return;
	                }
	            }
	        }
	        // else if(em.num == -1){
	        //	$(em.plus).trigger('click');
	        //	flag = false;
	        //	return;
	        // }
	        /* Cell numbers */
	        if (cn.num > -1) {
	            j = 0;
	            for (i = 0; i <= cn.num; i++) {
	                if ($(document.getElementById(cn.codep + i)).val().match(ccod_reg)) {
	                    flag = true;
	                    $(document.getElementById(cn.msgDiv + i)).html('');
	                } else {
	                    flag = false;
	                    $(document.getElementById(cn.msgDiv + i)).html('<strong class="text-danger">Not Valid Cell prefiex</strong>');
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(cn.codep + i)).focus();
	                    return;
	                }
	                if ($(document.getElementById(cn.nump + i)).val().match(cell_reg)) {
	                    flag = true;
	                    $(document.getElementById(cn.msgDiv + i)).html('');
	                } else {
	                    flag = false;
	                    $(document.getElementById(cn.msgDiv + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(cn.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
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
	        // else if(cn.num == -1){
	        //	$(cn.plus).trigger('click');
	        //	flag = false;
	        //	return;
	        // }
	        /* Bank Account */
	        if (ac.num > -1) {
	            j = 0;
	            for (i = 0; i <= ac.num; i++) {
	                if ($(document.getElementById(ac.bankname + i)).val().match(name_reg)) {
	                    flag = true;
	                    $(document.getElementById(ac.nmsg + i)).html('');
	                } else {
	                    flag = false;
	                    $(document.getElementById(ac.nmsg + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(ac.nmsg + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(ac.bankname + i)).focus();
	                    return;
	                }
	                if ($(document.getElementById(ac.accno + i)).val().match(accn_reg)) {
	                    flag = true;
	                    $(document.getElementById(ac.nomsg + i)).html('');
	                } else {
	                    flag = false;
	                    $(document.getElementById(ac.nomsg + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(ac.nomsg + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(ac.accno + i)).focus();
	                    return;
	                }
	                if ($(document.getElementById(ac.braname + i)).val().length < 101) {
	                    flag = true;
	                    $(document.getElementById(ac.bnmsg + i)).html('');
	                } else {
	                    flag = false;
	                    $(document.getElementById(ac.bnmsg + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(ac.bnmsg + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(ac.braname + i)).focus();
	                    return;
	                }
	                if ($(document.getElementById(ac.bracode + i)).val().length < 101) {
	                    flag = true;
	                    $(document.getElementById(ac.bcmsg + i)).html('');
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
	                    }, 'slow');
	                } else {
	                    flag = false;
	                    $(document.getElementById(ac.bcmsg + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(ac.bcmsg + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(ac.bracode + i)).focus();
	                    return;
	                }
	                if ($(document.getElementById(ac.IFSC + i)).val().length < 101) {
	                    flag = true;
	                    $(document.getElementById(ac.IFSCmsg + i)).html('');
	                } else {
	                    flag = false;
	                    $(document.getElementById(ac.IFSCmsg + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(ac.IFSCmsg + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(ac.IFSC + i)).focus();
	                    return;
	                }
	                if (flag) {
	                    accounts[j] = {
	                        bankname: $(document.getElementById(ac.bankname + i)).val(),
	                        accno: $(document.getElementById(ac.accno + i)).val(),
	                        braname: $(document.getElementById(ac.braname + i)).val(),
	                        bracode: $(document.getElementById(ac.bracode + i)).val(),
	                        IFSC: $(document.getElementById(ac.IFSC + i)).val()
	                    };
	                    j++;
	                }
	            }
	        }
	        /* Products */
	        if (pd.num > -1) {
	            j = 0;
	            for (i = 0; i <= pd.num; i++) {
	                if ($(document.getElementById(pd.product + i)).val().match(name_reg)) {
	                    flag = true;
	                    $(document.getElementById(pd.msgDiv + i)).html('');
	                    products[j] = $(document.getElementById(pd.product + i)).val();
	                    j++;
	                } else {
	                    flag = false;
	                    $(document.getElementById(pd.msgDiv + i)).html(INVALIDNOT);
	                    $('html, body').animate({
	                        scrollTop: Number($(document.getElementById(pd.msgDiv + i)).offset().top) - 95
	                    }, 'slow');
	                    $(document.getElementById(pd.product + i)).focus();
	                    return;
	                }
	            }
	        }
	        // else if(pd.num == -1){
	        //	$(pd.plus).trigger('click');
	        //	flag = false;
	        //	return;
	        // }
	        var attr = {
	            user_type: type,
	            name: $(usr.add.basicinfo.name).val(),
	            acs: $(usr.add.basicinfo.acs_id).val(),
	            email: email,
	            crname: crname,
	            pan: pandata,
	            tin: tindata,
	            svt: svtdata,
	            cellnumbers: cellnumbers,
	            accounts: accounts,
	            products: products,
	            country: $(usr.add.address.country).val(),
	            countryCode: usr.add.address.countryCode,
	            province: $(usr.add.address.province).val(),
	            provinceCode: usr.add.address.provinceCode,
	            district: $(usr.add.address.district).val(),
	            city_town: $(usr.add.address.city_town).val(),
	            st_loc: $(usr.add.address.st_loc).val(),
	            addrsline: $(usr.add.address.addrs).val(),
	            tphone: $(usr.add.address.tphone).val(),
	            pcode: $(usr.add.address.pcode).val(),
	            zipcode: $(usr.add.address.zipcode).val(),
	            website: $(usr.add.address.website).val(),
	            gmaphtml: $(usr.add.address.gmaphtml).val(),
	            timezone: usr.add.address.timezone,
	            lat: usr.add.address.lat,
	            lon: usr.add.address.lon
	        };
	        if (flag) {
	            $(usr.msgDiv).html('');
	            $(usr.add.but).prop('disabled', 'disabled');
	            $(usr.msgDiv).html('');
	            $.ajax({
	                url: usr.add.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'userAdd',
	                    usradd: attr
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(usr.msgDiv).html('<h2>User added to database</h2>');
	                            $('html, body').animate({
	                                scrollTop: Number($(usr.msgDiv).offset().top) - 95
	                            }, 'slow');
	                            $(usr.add.form).get(0).reset();
	                            // em.num = cn.num = ac.num = pd.num = -1;
	                            break;
	                    }
	                },
	                error: function() {
	                    $(usr.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                    $(usr.add.but).removeAttr('disabled');
	                }
	            });
	        }
	    };

	    function builtMultiplecrnames() {
	        if (crn.num == -1) $(crn.parentDiv).html('');
	        crn.num++;
	        var html = '<div id="' + crn.form + crn.num + '">' + '<div class="col-lg-8">' + '<input class="form-control" placeholder="Name of the Company Representative" name="crname" type="text" id="' + crn.crname + crn.num + '" maxlength="100"/>' + '<p class="help-block" id="' + crn.msgDiv + crn.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-4">' + '<button class="btn btn-danger  btn-md" id="' + crn.minus + crn.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  btn-md" id="' + crn.plus + crn.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
	        $(crn.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(crn.minus + crn.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(crn.form + crn.num)).remove();
	                crn.num--;
	                if (crn.num == -1) {
	                    $(crn.plus).show();
	                    $(crn.parentDiv).html('');
	                } else {
	                    $(document.getElementById(crn.plus + crn.num)).show();
	                    $(document.getElementById(crn.minus + crn.num)).show();
	                }
	            });
	            $(document.getElementById(crn.plus + crn.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(crn.plus + crn.num)).hide();
	                $(document.getElementById(crn.minus + crn.num)).hide();
	                builtMultiplecrnames();
	            });
	        }, 200);
	    };

	    function builtMultiplePan() {
	        if (pan.num == -1) $(pan.parentDiv).html('');
	        pan.num++;
	        var html = '<div id="' + pan.form + pan.num + '">' + '<div class="col-lg-8">' + '<input class="form-control" placeholder="Pan Number" name="pan" type="text" id="' + pan.pan + pan.num + '" maxlength="100"/>' + '<p class="help-block" id="' + pan.msgDiv + pan.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-4">' + '<button type="button" class="btn btn-danger  btn-md" id="' + pan.minus + pan.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  type="button" btn-md" id="' + pan.plus + pan.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
	        $(pan.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(pan.minus + pan.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(pan.form + pan.num)).remove();
	                pan.num--;
	                if (pan.num == -1) {
	                    $(pan.plus).show();
	                    $(pan.parentDiv).html('');
	                } else {
	                    $(document.getElementById(pan.plus + pan.num)).show();
	                    $(document.getElementById(pan.minus + pan.num)).show();
	                }
	            });
	            $(document.getElementById(pan.plus + pan.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(pan.plus + pan.num)).hide();
	                $(document.getElementById(pan.minus + pan.num)).hide();
	                builtMultiplePan();
	            });
	        }, 200);
	    };

	    function builtMultipleTin() {
	        if (tin.num == -1) $(tin.parentDiv).html('');
	        tin.num++;
	        var html = '<div id="' + tin.form + tin.num + '">' + '<div class="col-lg-8">' + '<input class="form-control" placeholder="TIN" name="pan" type="text" id="' + tin.tin + tin.num + '" maxlength="100"/>' + '<p class="help-block" id="' + tin.msgDiv + tin.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-4">' + '<button type="button" class="btn btn-danger  btn-md" id="' + tin.minus + tin.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  type="button" btn-md" id="' + tin.plus + tin.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
	        $(tin.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(tin.minus + tin.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(tin.form + tin.num)).remove();
	                tin.num--;
	                if (tin.num == -1) {
	                    $(tin.plus).show();
	                    $(tin.parentDiv).html('');
	                } else {
	                    $(document.getElementById(tin.plus + tin.num)).show();
	                    $(document.getElementById(tin.minus + tin.num)).show();
	                }
	            });
	            $(document.getElementById(tin.plus + tin.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(tin.plus + tin.num)).hide();
	                $(document.getElementById(tin.minus + tin.num)).hide();
	                builtMultipleTin();
	            });
	        }, 200);
	    };

	    function builtMultipleSVT() {
	        if (svt.num == -1) $(svt.parentDiv).html('');
	        svt.num++;
	        var html = '<div id="' + svt.form + svt.num + '">' + '<div class="col-lg-8">' + '<input class="form-control" placeholder="STC" name="svt" type="text" id="' + svt.svt + svt.num + '" maxlength="100"/>' + '<p class="help-block" id="' + svt.msgDiv + svt.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-4">' + '<button type="button" class="btn btn-danger  btn-md" id="' + svt.minus + svt.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  type="button" btn-md" id="' + svt.plus + svt.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
	        $(svt.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(svt.minus + svt.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(svt.form + svt.num)).remove();
	                svt.num--;
	                if (svt.num == -1) {
	                    $(svt.plus).show();
	                    $(svt.parentDiv).html('');
	                } else {
	                    $(document.getElementById(svt.plus + svt.num)).show();
	                    $(document.getElementById(svt.minus + svt.num)).show();
	                }
	            });
	            $(document.getElementById(svt.plus + svt.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(svt.plus + svt.num)).hide();
	                $(document.getElementById(svt.minus + svt.num)).hide();
	                builtMultipleSVT();
	            });
	        }, 200);
	    };

	    function bulitMultipleEmailIds() {
	        if (em.num == -1) $(em.parentDiv).html('');
	        em.num++;
	        var html = '<div id="' + em.form + em.num + '">' + '<div class="col-lg-8">' + '<input class="form-control" placeholder="Email ID" name="email" type="text" id="' + em.email + em.num + '" maxlength="100"/>' + '<p class="help-block" id="' + em.msgDiv + em.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-4">' + '<button class="btn btn-danger  btn-md" id="' + em.minus + em.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  btn-md" id="' + em.plus + em.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
	        $(em.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(em.minus + em.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(em.form + em.num)).remove();
	                em.num--;
	                if (em.num == -1) {
	                    $(em.plus).show();
	                    $(em.parentDiv).html('');
	                } else {
	                    $(document.getElementById(em.plus + em.num)).show();
	                    $(document.getElementById(em.minus + em.num)).show();
	                }
	            });
	            $(document.getElementById(em.plus + em.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(em.plus + em.num)).hide();
	                $(document.getElementById(em.minus + em.num)).hide();
	                bulitMultipleEmailIds();
	            });
	        }, 200);
	    };

	    function bulitMultipleProducts() {
	        if (pd.num == -1) $(pd.parentDiv).html('');
	        pd.num++;
	        var html = '<div id="' + pd.form + pd.num + '">' + '<div class="col-lg-8">' + '<input class="form-control" placeholder="Product Name" name="product" type="text" id="' + pd.product + pd.num + '" maxlength="100"/>' + '<p class="help-block" id="' + pd.msgDiv + pd.num + '">Enter / Select</p>' + '</div>' + '<div class="col-lg-4">' + '<button class="btn btn-danger  btn-md" id="' + pd.minus + pd.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  btn-md" id="' + pd.plus + pd.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>';
	        $(pd.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(pd.minus + pd.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(pd.form + pd.num)).remove();
	                pd.num--;
	                if (pd.num == -1) {
	                    $(pd.plus).show();
	                    $(pd.parentDiv).html('');
	                } else {
	                    $(document.getElementById(pd.plus + pd.num)).show();
	                    $(document.getElementById(pd.minus + pd.num)).show();
	                }
	            });
	            $(document.getElementById(pd.plus + pd.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(pd.plus + pd.num)).hide();
	                $(document.getElementById(pd.minus + pd.num)).hide();
	                bulitMultipleProducts();
	            });
	        }, 200);
	    };

	    function bulitMultipleAccounts() {
	        if (ac.num == -1) $(ac.parentDiv).html('');
	        ac.num++;
	        var html = '<div id="' + ac.form + ac.num + '">' + '<div class="col-lg-6">' + '<div class="panel panel-warning">' + '<div class="panel-heading">' + '<strong>Bank account ' + Number(ac.num + 1) + '</strong>&nbsp;' + '<button class="btn btn-danger  btn-md" id="' + ac.minus + ac.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  btn-md" id="' + ac.plus + ac.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '<div class="panel-body">' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Bank Name </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Bank Name" name="bankname" type="text" id="' + ac.bankname + ac.num + '" maxlength="100"/>' + '<p class="help-block" id="' + ac.nmsg + ac.num + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Account Number </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Account Number" name="accno" type="text" id="' + ac.accno + ac.num + '" maxlength="100"/>' + '<p class="help-block" id="' + ac.nomsg + ac.num + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Name </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Branch Name" name="braname" type="text" id="' + ac.braname + ac.num + '" maxlength="100"/>' + '<p class="help-block" id="' + ac.bnmsg + ac.num + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> Branch Code </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="Branch Code" name="bracode" type="text" id="' + ac.bracode + ac.num + '" maxlength="100"/>' + '<p class="help-block" id="' + ac.bcmsg + ac.num + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '<div class="row">' + '<div class="col-lg-12">' + '<strong><span class="text-warning"><i class="fa fa-star fa-fw"></i></span> IFSC </strong>' + '</div>' + '<div class="col-lg-12">' + '<input class="form-control" placeholder="IFSC" name="IFSC" type="text" id="' + ac.IFSC + ac.num + '" maxlength="100"/>' + '<p class="help-block" id="' + ac.IFSCmsg + ac.num + '">Enter / Select</p>' + '</div>' + '' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>';
	        $(ac.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(ac.minus + ac.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(ac.form + ac.num)).remove();
	                ac.num--;
	                if (ac.num == -1) {
	                    $(ac.plus).show();
	                    $(ac.parentDiv).html('');
	                } else {
	                    $(document.getElementById(ac.plus + ac.num)).show();
	                    $(document.getElementById(ac.minus + ac.num)).show();
	                }
	            });
	            $(document.getElementById(ac.plus + ac.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(ac.plus + ac.num)).hide();
	                $(document.getElementById(ac.minus + ac.num)).hide();
	                bulitMultipleAccounts();
	            });
	        }, 200);
	    };

	    function bulitMultipleCellNumbers() {
	        if (cn.num == -1) $(cn.parentDiv).html('');
	        cn.num++;
	        var html = '<div class="row show-grid" id="' + cn.form + cn.num + '">' + '<div class="col-xs-6 col-md-4">' + '<input class="form-control" value="' + dccode + '" name="ccode" type="text" id="' + cn.codep + cn.num + '" readonly="" maxlength="15" />' + '</div>' + '<div class="col-xs-6 col-md-4">' + '<input class="form-control" placeholder="Cell Number" name="cnumber" type="text" id="' + cn.nump + cn.num + '" maxlength="20" />' + '</div>' + '<div class="col-xs-6 col-md-4">' + '<button class="btn btn-danger  btn-md" id="' + cn.minus + cn.num + '"><i class="fa fa-minus fa-fw fa-x2"></i></button>&nbsp;' + '<button class="btn btn-success  btn-md" id="' + cn.plus + cn.num + '"><i class="fa fa-plus fa-fw fa-x2"></i></button>' + '</div>' + '</div>' + '<div class="col-lg-12"><p class="help-block" id="' + cn.msgDiv + cn.num + '">Enter / Select</p></div>';
	        $(cn.parentDiv).append(html);
	        window.setTimeout(function() {
	            $(document.getElementById(cn.minus + cn.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(cn.form + cn.num)).remove();
	                cn.num--;
	                if (cn.num == -1) {
	                    $(cn.plus).show();
	                    $(cn.parentDiv).html('');
	                } else {
	                    $(document.getElementById(cn.plus + cn.num)).show();
	                    $(document.getElementById(cn.minus + cn.num)).show();
	                }
	            });
	            $(document.getElementById(cn.plus + cn.num)).click(function(evt) {
	                evt.stopPropagation();
	                evt.preventDefault();
	                $(document.getElementById(cn.plus + cn.num)).hide();
	                $(document.getElementById(cn.minus + cn.num)).hide();
	                bulitMultipleCellNumbers();
	            });
	        }, 200);
	    };

	    function clearuserAddForm() {
	        // usr = usrctrl.usr;
	        // cn = usrctrl.cn;
	        // em = usrctrl.em;
	        // ac = usrctrl.ac;
	        cn.num = -1;
	        em.num = -1;
	        ac.num = -1;
	        crn.num = -1;
	    };

	    function DisplayUpdatedUserList() {
	        var htm = '';
	        $(usr.list.listLoad).html(LOADER_FUR);
	        $.ajax({
	            url: usr.list.url,
	            type: 'post',
	            data: {
	                autoloader: true,
	                action: 'DisplayUpdatedUserList'
	            },
	            success: function(data, textStatus, xhr) {
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
	                        var listusers = $.parseJSON(data);
	                        if (listusers != null) {
	                            for (i = 0; i < listusers.length; i++) {
	                                htm += listusers[i]["html"];
	                            }
	                            $(usr.list.listDiv).append(htm);
	                            for (i = 0; i < listusers.length; i++) {
	                                $(listusers[i].usrdelOk).bind('click', {
	                                    uid: listusers[i].uid,
	                                    sr: listusers[i].sr
	                                }, function(evt) {
	                                    $($(this).prop('name')).hide(400);
	                                    var hid = deleteUser(evt.data.uid);
	                                    if (hid) {
	                                        $(evt.data.sr).remove();
	                                        DisplayUserList();
	                                    }
	                                });
	                            }
	                            $(usr.list.listLoad).html('');
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(usr.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	    };

	    function DisplayUserList() {
	        var htm = '';
	        $(usr.msgDiv).html('');
	        $(usr.list.listDiv).html(LOADER_FUR);
	        $.ajax({
	            url: usr.list.url,
	            type: 'post',
	            data: {
	                autoloader: true,
	                action: 'DisplayUserList'
	            },
	            success: function(data, textStatus, xhr) {
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
	                        var listusers = $.parseJSON(data);
	                        if (listusers != null) {
	                            for (i = 0; i < listusers.length; i++) {
	                                htm += listusers[i]["html"];
	                            }
	                            $(usr.list.listDiv).html(tableheader + htm + tablefooter);
	                            for (i = 0; i < listusers.length; i++) {
	                                $(listusers[i].usrdelOk).bind('click', {
	                                    uid: listusers[i].uid,
	                                    sr: listusers[i].sr
	                                }, function(evt) {
	                                    $($(this).prop('name')).hide(400);
	                                    var hid = deleteUser(evt.data.uid);
	                                    if (hid) {
	                                        $(evt.data.sr).remove();
	                                        DisplayUserList();
	                                    }
	                                });
	                            }
	                            window.setTimeout(function() {
	                                //                                                                   $('#dataTables-Listusers').dataTable();  
	                            }, 600);
	                            $(usr.list.listLoad).html('');
	                        }
	                        break;
	                }
	            },
	            error: function() {
	                $(usr.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	        //			$(window).scroll(function(event){
	        //				if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10)
	        //					DisplayUpdatedUserList();
	        //				else
	        //					$(usr.list.listLoad).html('');
	        //			});
	    };

	    function deleteUser(uid) {
	        var flag = false;
	        var attr = {
	            entid: uid
	        };
	        $.ajax({
	            url: usr.add.url,
	            type: 'POST',
	            async: false,
	            data: {
	                autoloader: true,
	                action: 'deleteUser',
	                ptydeletesale: attr
	            },
	            success: function(data, textStatus, xhr) {
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
	            error: function() {
	                $(usr.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	            }
	        });
	        return flag;
	    }
	}