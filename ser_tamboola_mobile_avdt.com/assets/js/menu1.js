function menu1() {
    var docpath = {};
    var ct = {};
    var usr = {};
    var uem = {};
    var ucn = {};
    var add = {};
    var em = {};
    var cn = {};
    var cn = {};
    var lusr = {};
    var dflag = false;
    var dccode = '91';
    var dpcode = '080';
    var luser = {};
    this.__construct = function(clnt) {
        ct = clnt;
        luser = clnt.listuser;
        editClient();
    };
    this.alterClientEmailIds = function(email) {
        var em = email;
        var min = -1;
        $(em.addd).bind("click", function() {
            em.num = min;
            $(em.parentDiv).html('<div class="col-lg-12">'+
                    '<div class="col-lg-4">Add extra Email ids : </div><div class="col-lg-8 text-right"><button type="button" class="btn btn-success btn-circle" id="' +em.plus+'"><i class="fa fa-plus fa-fw "></i></button>'+
                    '&nbsp;<button  type="button" class="btn btn-success btn-circle" id="' +em.minus+'"><i class="fa fa-minus fa-fw "></i></button>'+
                    '&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' +em.closeBut+'"><i class="fa fa-close fa-fw "></i></button>'+
            '</div>');
            $('#' + em.plus).click(function() {
                addMultipleEmailIds();
            });
            $('#' + em.minus).bind('click', function() {
                minusMultipleEmailIds();
                return false;
            });
            $('#' + em.saveBut).unbind();
            $('#' + em.saveBut).click(function() {
                adddClientEmailId();
            });
            $('#' + em.closeBut).click(function() {
                listEmailIds();
            });
            $('#' + em.saveBut).show();
            $(em.addd).hide();
            $(em.edit).hide();
            $(em.delt).hide();
        });
        $(em.edit).bind("click", function() {
            $('#' + em.saveBut).hide();
            $(em.addd).hide();
            $(em.edit).hide();
            $(em.delt).hide();
            loadClientEmailIdEditForm();
        });
        $(em.delt).bind("click", function() {
            $('#' + em.saveBut).hide();
            $(em.addd).hide();
            $(em.edit).hide();
            $(em.delt).hide();
            loadClientEmailIdDeltForm();
        });
        function loadClientEmailIdEditForm() {
            $(em.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientEmailIdEditForm',
                    type: 'master',
                    det: em
                },
                success: function(data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data.html);
                             em.num = data.num;
                            $('#' + em.saveBut).show();
                            $(document).ready(function() {
                                console.log(em.saveBut);
                                $('#' + em.saveBut).unbind();
                                $('#' + em.saveBut).click(function() {
                                    editClientEmailId();
                                });
                                $('#' + em.closeBut).click(function() {
                                    $(em.edit).toggle();
                                    $('#' + em.saveBut).toggle();
                                    listEmailIds();
                                });
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
        function loadClientEmailIdDeltForm() {
            $(em.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: em.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientEmailIdDeltForm',
                    type: 'master',
                    det: em
                },
                success: function(data, textStatus, xhr) {
                    data = $.parseJSON(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        default:
                            $(em.parentDiv).html(data.html);
                            em.num = data.num;
                            $(document).ready(function() {
                               $('#' + em.closeBut).click(function() {
                                    $(em.edit).toggle();
                                    $('#' + em.saveBut).toggle();
                                    listEmailIds();
                                });
                                 window.setTimeout(function() {
                                    if (data.oldemail) {
                                        for (i = 0; i < data.oldemail.length; i++) {
                                            var cid = Number(data.oldemail[i].id);
                                            $('#' + data.oldemail[i].deleteOk).bind("click", {
                                                param1: cid
                                            }, function(event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteEmailId(event.data.param1)) {
                                                    loadClientEmailIdDeltForm();
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
            var html = '<div class="col-lg-12"><div class="form-group" id="' + oldemail.formid + '">' + '<input class="form-control" required placeholder="Email ID" name="email" type="text" id="' + oldemail.textid + '" maxlength="100"/>' + '<p class="help-block" id="' + oldemail.msgid + '">Enter/ Select.</p>' + '</div></div>';
            $(em.parentDiv).append(html);
            window.setTimeout(function() {
                $(document.getElementById(oldemail.deleteid)).click(function() {
                    if (em.num >= min)
                        em.num--;
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(em.minus + em.num + '_delete')).show();
                });
            }, 200);
		};
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
            window.setTimeout(function() {
                $(document.getElementById(oldemail.deleteid)).click(function() {
                    if (em.num >= min) {
                        em.num--;
                    }
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(em.minus + em.num + '_delete')).hide();
                });
            }, 200);
		};
        function adddClientEmailId() {
            var insert = [];
            var emailids = {
                insert: insert,
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            /* min*/
            /* Email ids */
            if (em.num > -1) {
                k = 0;
                for (i = 0; i <= em.num; i++) {
                    var ems = $(document.getElementById(em.email + i)).val();
                    if (ems.match(email_reg)) {
                        flag = true;
                        insert[k] = ems;
                        k++;
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
                $(em.parentDiv).html(LOADER_TWO);
                emailids.insert = insert;
                $('#' + em.saveBut).unbind();
                $('#' + em.saveBut).toggle();
                $.ajax({
                    url: em.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'adddClientEmailId',
                        type: 'master',
                        emailids: emailids
                    },
                    success: function(data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                listEmailIds();
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
        function editClientEmailId() {
            var update = [];
            var emailids = {
                update: update,
                uid: em.uid,
                index: em.index,
                listindex: em.listindex
            };
            var flag = false;
            /* min*/
            /* Email ids */
            console.log(em.num);
            if (em.num > -1) {
                j = 0;
                for (i = 0; i < em.num; i++) {
                    var ems = $(document.getElementById(em.email + i)).val();
                    var id = $(document.getElementById(em.email + i)).prop('name');
                    if (ems.match(email_reg)) {
                        flag = true;
                        $(document.getElementById(em.msgDiv + i)).html(VALIDNOT);
                        update[j] = {
                            email: ems,
                            id: id
                        };
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
            console.log(emailids);
            if (flag) {
                $(em.parentDiv).html(LOADER_TWO);
                emailids.update = update;
                $('#' + em.saveBut).unbind();
                $('#' + em.saveBut).toggle();
                $.ajax({
                    url: em.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editClientEmailId',
                        type: 'master',
                        emailids: emailids
                    },
                    success: function(data, textStatus, xhr) {
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                listEmailIds();
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
                    action: 'deleteClientEmailId',
                    type: 'master',
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
            $('#' + em.saveBut).hide();
            $(em.parentDiv).html(LOADER_TWO);
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
                            $(em.addd).show();
                            $(em.edit).show();
                            $(em.delt).show();
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
    this.alterClientCellNumbers = function(cnumber) {
        var cn = cnumber;
        var min = -1;
        $(cn.addd).bind("click", function() {
            cn.num = min;
            $(cn.parentDiv).html('<div class="col-lg-12">'+
                    '<div class="col-lg-4">Add extra Cell NO : </div><div class="col-lg-8 text-right"><button type="button" class="btn btn-success btn-circle" id="' +cn.plus+'"><i class="fa fa-plus fa-fw "></i></button>'+
                    '&nbsp;<button  type="button" class="btn btn-success btn-circle" id="' +cn.minus+'"><i class="fa fa-minus fa-fw "></i></button>'+
                    '&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' +cn.closeBut+'"><i class="fa fa-close fa-fw "></i></button></div>'+
            '</div>');
            $('#' + cn.plus).click(function() {
                addMultipleCellNums();
            });
            $('#' + cn.minus).bind('click', function() {
                minusMultipleCellNums();
                return false;
            });
            $('#' + cn.saveBut).unbind();
            $('#' + cn.saveBut).click(function() {
                adddClientCellNum();
            });
            $('#' + cn.closeBut).click(function() {
                listClientCellNums();
            });
            $('#' + cn.saveBut).show();
            $(cn.addd).hide();
            $(cn.edit).hide();
            $(cn.delt).hide();
        });
        $(cn.edit).bind("click", function() {
            $('#' + cn.saveBut).hide();
            $(cn.addd).hide();
            $(cn.edit).hide();
            $(cn.delt).hide();
            loadClientCellNumEditForm();
        });
        $(cn.delt).bind("click", function() {
            $('#' + cn.saveBut).hide();
            $(cn.addd).hide();
            $(cn.edit).hide();
            $(cn.delt).hide();
            loadClientCellNumDeltForm();
        });
        function loadClientCellNumEditForm() {
            $(cn.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientCellNumEditForm',
                    type: 'master',
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
							cn.num = data.num;
							$('#' + cn.saveBut).show();
                            $(document).ready(function() {
                                $('#' + cn.plus).click(function() {
                                    addMultipleCellNums();
                                });
                                $('#' + cn.minus).bind('click', function() {
                                    minusMultipleCellNums();
                                    return false;
                                });
                                $('#' + cn.saveBut).click(function() {
                                    editClientCellNum();
                                });
                                $('#' + cn.closeBut).click(function() {
                                    $(cn.but).toggle();
                                    $('#' + cn.saveBut).toggle();
                                    listClientCellNums();
                                });
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
        function loadClientCellNumDeltForm() {
            $(cn.parentDiv).html(LOADER_TWO);
            $.ajax({
                url: cn.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'loadClientCellNumDeltForm',
                    type: 'master',
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
							cn.num = data.num;
							$('#' + cn.saveBut).show();
                            $(document).ready(function() {
                                $('#' + cn.closeBut).click(function() {
                                    $(cn.but).toggle();
                                    $('#' + cn.saveBut).toggle();
                                    listClientCellNums();
                                });
                                window.setTimeout(function() {
                                    if (data.oldcnum) {
                                        for (i = 0; i < data.oldcnum.length; i++) {
                                            var id = Number(data.oldcnum[i].id);
                                            $('#' + data.oldcnum[i].deleteOk).bind("click", {
                                                param1: id
                                            }, function(event) {
                                                $($(this).prop('name')).hide(400);
                                                if (deleteClientCellNum(event.data.param1)) {
                                                    loadClientCellNumDeltForm();
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
            for (i = 0; i < cn.num; i++) {
                $(document.getElementById(cn.minus + i + '_delete')).hide();
            }
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                deleteid: cn.minus + cn.num + '_delete'
            };
            var html = '<div class="col-lg-12"><div class="form-group" id="' + oldcnum.formid + '">' + '<input class="form-control" placeholder="Cell number" name="cnumber" type="text" id="' + oldcnum.textid + '" maxlength="10"/>' + '<p class="help-block" id="' + oldcnum.msgid + '">Enter/ Select.</p>' + '</div></div>';
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
        function minusMultipleCellNums() {
            var oldcnum = {
                formid: cn.form + cn.num,
                textid: cn.cnumber + cn.num,
                msgid: cn.msgDiv + cn.num,
                deleteid: cn.minus + cn.num + '_delete'
            };
            $(document.getElementById(cn.form + cn.num)).remove();
            $(document.getElementById(cn.cnumber + cn.num)).remove();
            $(document.getElementById(cn.msgDiv + cn.num)).remove();
            cn.num--;
            window.setTimeout(function() {
                $(document.getElementById(oldcnum.deleteid)).click(function() {
                    if (cn.num >= min) {
                        cn.num--;
                    }
                    $(this).parent().parent().parent().remove();
                    $(document.getElementById(cn.minus + cn.num + '_delete')).hide();
                });
            }, 200);
        };
        function adddClientCellNum() {
            var insert = [];
            var CellNums = {
                insert: insert,
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            /* min*/
            /* Cell numbers */
            if (cn.num > -1) {
                k = 0;
                for (i = 0; i < cn.num; i++) {
                    var ems = $(document.getElementById(cn.cnumber + i)).val();
                    var id = $(document.getElementById(cn.cnumber + i)).prop('name');
                    if (ems.match(cell_reg)) {
                        flag = true;
                        $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
						insert[k] = ems;
						k++;
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
				$(cn.parentDiv).html(LOADER_TWO);
                CellNums.insert = insert;
                $('#' + cn.saveBut).unbind();
                $.ajax({
                    url: cn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'adddClientCellNum',
                        type: 'master',
                        CellNums: CellNums
                    },
                    success: function(data, textStatus, xhr) {
						console.log(data);
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                listClientCellNums();
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
        function editClientCellNum() {
            var update = [];
            var CellNums = {
                update: update,
                uid: cn.uid,
                index: cn.index,
                listindex: cn.listindex
            };
            var flag = false;
            /* min*/
            /* Cell numbers */
            if (cn.num > -1) {
                j = 0;
                for (i = 0; i < cn.num; i++) {
                    var ems = $(document.getElementById(cn.cnumber + i)).val();
                    var id = $(document.getElementById(cn.cnumber + i)).prop('name');
                    if (ems.match(cell_reg)) {
                        flag = true;
                        $(document.getElementById(cn.msgDiv + i)).html(VALIDNOT);
						update[j] = {
							cnumber: ems,
							id: id
						};
						j++
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
				$(cn.parentDiv).html(LOADER_TWO);
                CellNums.update = update;
                $('#' + cn.saveBut).unbind();
                $.ajax({
                    url: cn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'editClientCellNum',
                        type: 'master',
                        CellNums: CellNums
                    },
                    success: function(data, textStatus, xhr) {
						console.log(data);
                        data = $.parseJSON($.trim(data));
                        switch (data) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            default:
                                min++;
                                listClientCellNums();
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
        function deleteClientCellNum(id) {
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
        function listClientCellNums() {
			$('#' + cn.saveBut).hide();
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
                            $(cn.addd).show();
                            $(cn.edit).show();
                            $(cn.delt).show();
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
    /*edit client*/
    function editClient() {
        var htm = '';
        $.ajax({
            url: window.location.href,
            type: 'POST',
            async: false,
            data: {
                autoloader: true,
                action: 'editClient',
                type: 'master'
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
                        $(luser.gnt_pnlist).html(data);
                        window.setTimeout(function() {
                            $(".picedit_box").picEdit({
                                imageUpdated: function(img) {
                                },
                                formSubmitted: function(data) {
                                    window.setTimeout(function() {
                                        $('#myModal_pf').modal('toggle');
                                        editClient(usrid);
                                    }, 500);
                                },
                                redirectUrl: false,
                                defaultImage: URL + ASSET_IMG + 'No_image.png',
                            });
                        }, 300);
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
        /*return flag;*/
    }
}