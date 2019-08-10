function newLeadController() {
    var members = {};
    var listOfSections = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    var leadIDS = {};
    var picEditObj = {};
    var pmem = {};
    this.__constructor = function (para) {
        pmem = para;
        members = para.deal;
    };
    this.publicDisplayLead = function () {
        window.setTimeout(function () {
            DisplayLead();
        }, 200);
    };
    this.publicFilterlead = function (data) {
        var mem = members.list;
        $('#' + mem.outputDiv).html(data);
        window.setTimeout(function () {
            bindLeadActions();
        }, 1500);
    };
    this.bindActions = function(){
        $('#' + members.create.parentBut).bind('click', function (evt) {
            fetchSections();
            validateCreateLeadForm();
            $('#' + members.create.target).change(function () {
                if (this.value === "Country") {
                    fetchListOfContinents();
                } else {
                    $('#' + members.create.parentFild).html('');
                }
            });
            window.setTimeout(function () {
                picEditObj = $('#' + members.create.leadImg).picEdit({
                    imageUpdated: function (_this) {
                        //console.log(_this);
                        //picEditObj._setDefaultImage(img.src);
                        //throw new Error('Stop Damn Recursion');
                        //return false;
                    },
                    formError: function (res) {
                        members.create.picedit = false;
                    },
                    /* Soharab Modification */
                    formProgress: function (data) {
                        var res = {};
                        if (typeof data === 'object') {
                            res = data;
                        } else {
                            res = $.parseJSON($.trim(data));
                        }
                        //console.log(res);
                    },
                    /* Soharab Modification */
                    formSubmitted: function (data) {
                        var res = {};
                        if (typeof data === 'object') {
                            res = data;
                        } else {
                            res = $.parseJSON($.trim(data));
                        }
                        if (res.readyState && picEditObj._formComplete()) {
                            createLead();
                            members.create.picedit = false;
                        } else {
                            alert('Error could not lead on nookleads!!!.');
                        }
                    },
                    FormObj: $('#' + members.create.form),
                    goFlag: false,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: members.create.defaultImage
                });
                $('#' + members.create.leadImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1000);
        });
    }
    function getUserLead(uid) {
        var leadIDS = {};
        var mem = members.list.indiView;
        $('#' + mem.outputDiv).html(LOADER_ONE);
        $.ajax({
            url: mem.url + '/' + uid,
            type: mem.type,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                dataType: mem.dataType,
            },
            success: function (data) {
                if (typeof data === 'object') {
                    leadIDS = data;
                } else {
                    leadIDS = $.parseJSON($.trim(data));
                }
                if (leadIDS.status === 'success')
                    leadIDS = leadIDS.data;
                else
                    leadIDS = {};
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $('#' + mem.loader).html('');
            }
        });
        return leadIDS;
    }
    ;
    function createLead() {
        var mem = members.create;
        var memadd = members.create;
        var countries = [];
        var languages = [];
        var checkboxes = [];
        $('#' + mem.country + ' :selected').each(function (i, selected) {
            countries[i] = $(selected).val();
        });
        $('#' + mem.language + ' :selected').each(function (i, selected) {
            languages[i] = $(selected).val();
        });
        var allVals = [];
        /*
         $('#PoSections :checked').each(function () {
         allVals.push($(this).val());
         });
         */
//         $('#' + mem.checkbox + ' :checked').each(function () {
//         allVals.push($(this).val());
//         });
        allVals.push($('#' + members.sections.id).val());
        if (!allVals.length) {
            alert("Select Section");
            return;
        }
        var attr = {
            name: $('#' + mem.title).val(),
            target: $('#' + mem.target).val(),
            continent: $('#' + mem.continent).val(),
            countries: countries,
            langauges: languages,
            sections: allVals,
            checkboxes: $('#' + mem.checkbox).val()
        };
        var res = {};
        if (attr) {
            $(recentObjCountry).remove();
            $(recentObjlanguge).remove();
            $('#' + mem.checkbox).remove();
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
                    details: attr
                },
                success: function (data, textStatus, xhr) {
                    if (typeof data === 'object') {
                        res = data;
                    } else {
                        res = $.parseJSON($.trim(data));
                    }
                    if (res.status === "success") {
                        $('#' + mem.form).get(0).reset();
                        $('#' + mem.close).trigger('click');
                        alert("Your image Successfully Leaded");
                        mem.picedit = false;
                        mem.ajaxForm = false;
                        $('#closeLead').trigger('click');
                        window.setTimeout(function () {
                            UpdateListLead({
                                lead_id: res.lead_id,
                                where: 'prepend'
                            });
                        }, 400);
                    }
                },
                error: function (xhr, textStatus) {
                },
                complete: function (xhr, textStatus) {
                    $('#' + mem.create).removeAttr('disabled');
                }
            });
        }
    }
    ;
    function DisplayLead() {
        var mem = members.list;
        $('#' + mem.loader).html(LOADER_ONE);
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                dataType: mem.dataType,
            },
            success: function (data) {
                $('#' + mem.outputDiv).html(data);
                window.setTimeout(function () {
                    bindLeadActions();
                }, 800);
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
        $(window).scroll(function (event) {
            if (($(document).height() - ($(window).height() + $(window).scrollTop())) < 10) {
                UpdateListLead({
                    lead_id: null,
                    where: 'append',
                });
                return;
            } else {
                $('#' + mem.loader).html('');
            }
        });
    }
    ;
    function UpdateListLead(para) {
        var mem = members.list;
        var outputDiv = '';
        if (para.view) {
            outputDiv = para.view.outputDiv;
            console.log(mem);
        }
        else {
            $('#' + mem.loader).html(LOADER_ONE);
            outputDiv = mem.outputDiv;
        }
        $.ajax({
            url: mem.url1,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action1,
                dataType: mem.dataType,
                para: para,
            },
            success: function (data) {
                switch (para.where) {
                    case 'prepend':
                        $('#' + outputDiv).prepend(data);
                        break;
                    default:
                        $('#' + outputDiv).append(data);
                        break;
                }
                window.setTimeout(function () {
                    bindLeadActions();
                }, 800);
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $('#' + mem.loader).html('');
            }
        });
    }
    ;
    function DisplayLeadQuotation(para) {
        var mem = members.list.quotation.list;
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                dataType: mem.dataType,
                para: para,
            },
            success: function (data) {
                $('#' + mem.outputDiv + para.leadID).html(data);
                //$('#' + mem.parentDiv + para.leadID).slideToggle('slow');
                $('#' + mem.parentDiv + para.leadID).css({
                    display: 'block'
                });
                window.setTimeout(function () {
                    bindLeadQuotationActions();
                }, 1500);
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function DisplayLeadQuotationWo(para) {
        var mem = members.list.quotation.list.wo.list;
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                dataType: mem.dataType,
                para: para,
            },
            success: function (data) {
                $('#' + mem.outputDiv + para.leadComID).html(data);
                //$('#' + mem.parentDiv + para.leadComID).slideToggle('slow');
                $('#' + mem.parentDiv + para.leadComID).css({
                    display: 'block'
                });
                window.setTimeout(function () {
                    bindLeadQuotationWoActions();
                }, 1500);
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function bindLeadActions() {
        var mem1 = members.list;
        $('.' + mem1.smiley).emoticonize({
            //delay: 800,
            //animate: false,
            //exclude: 'pre, code, .no-emoticons'
        });
        $('.' + mem1.smiley).css({
            fontSize: '42px'
        });
        //bind individual lead
        $('.' + mem1.indiView.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function () {
                    var uid = Number($(this).attr('name'));
                    var lead_id = Number($(this).attr('data-bind'));
                    leadIDS = getUserLead(Number(uid));
                    var total = Number(leadIDS.length);
                    var page = 1;
                    $.each(leadIDS, function (i, item) {
                        if (Number(item.id) === lead_id) {
                            page = Number(i + 1);
                            return false;
                        }
                    });
                    var list = $('<ul id="pagination-list" class=""></ul>');
                    $('#' + mem1.indiView.pagination).html(list);
                    $(list).twbsPagination({
                        totalPages: total,
                        startPage: page,
                        initiateStartPageClick: function (event, page) {
                            $('#' + mem1.indiView.outputDiv).text('Page ' + page);
                            UpdateListLead({
                                lead_id: leadIDS[Number(page - 1)].id,
                                where: 'prepend',
                                view: members.list.indiView,
                            });
                        },
                        onPageClick: function (event, page) {
                            $('#' + mem1.indiView.outputDiv).text('Page ' + page);
                            UpdateListLead({
                                lead_id: leadIDS[Number(page - 1)].id,
                                where: 'prepend',
                                view: members.list.indiView,
                            });
                        },
                    });
                });
            }
        });
        //bind lead approval
        $('.' + mem1.approval.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).attr('name');
                    $('#' + mem1.approval.counter + leadID).html(LOADER_ONE);
                    $.ajax({
                        url: mem1.approval.url + '/' + leadID,
                        type: mem1.approval.type,
                        async: false,
                        data: {
                            autoloader: mem1.approval.autoloader,
                            action: mem1.approval.action,
                            dataType: mem1.approval.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem1.approval.counter + leadID).html(obj.count);
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead disapproval
        $('.' + mem1.disapproval.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).attr('name');
                    $('#' + mem1.disapproval.counter + leadID).html(LOADER_ONE);
                    $.ajax({
                        url: mem1.disapproval.url + '/' + leadID,
                        type: mem1.disapproval.type,
                        async: false,
                        data: {
                            autoloader: mem1.disapproval.autoloader,
                            action: mem1.disapproval.action,
                            dataType: mem1.disapproval.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem1.disapproval.counter + leadID).html(obj.count);
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead preferences
        $('.' + mem1.pref.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).parent().attr('name');
                    var prefID = $(this).attr('name');
                    var action = $(this).parent().attr('id');
                    $.ajax({
                        url: mem1.pref.url,
                        type: mem1.pref.type,
                        async: false,
                        data: {
                            autoloader: mem1.pref.autoloader,
                            action: mem1.pref.action,
                            dataType: mem1.pref.dataType,
                            para: {leadID: leadID, prefID: prefID, action: action},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            switch (action) {
                                case 'hide':
                                    $('#' + mem1.leadDiv + leadID).hide(300);
                                    break;
                                case 'delete':
                                    $('#' + mem1.leadDiv + leadID).remove();
                                    break;
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead report
        $('.' + mem1.report.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).parent().attr('name');
                    var reportID = $(this).attr('name');
                    console.log('pst id = ' + leadID);
                    console.log('rep id = ' + leadID);
                    $.ajax({
                        url: mem1.report.url,
                        type: mem1.report.type,
                        async: false,
                        data: {
                            autoloader: mem1.report.autoloader,
                            action: mem1.report.action,
                            dataType: mem1.report.dataType,
                            para: {leadID: leadID, reportID: reportID},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead subscription
        $('.' + mem1.subscription.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var businessID = $(this).parent().attr('name');
                    $.ajax({
                        url: mem1.subscription.url + '/' + businessID,
                        type: mem1.subscription.type,
                        async: false,
                        data: {
                            autoloader: mem1.subscription.autoloader,
                            action: mem1.subscription.action,
                            dataType: mem1.subscription.dataType,
                            para: {businessID: businessID},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        var mem2 = mem1.quotation;
        $('.' + mem2.smiley.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).bind('mouseover', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(this).emoticonize({
                        //delay: 800,
                        //animate: false,
                        //exclude: 'pre, code, .no-emoticons'
                    });
                });
                //bind smilies for quotation
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var smiley = $(this).text();
                    var leadID = $(this).parent().attr('name');
                    var obj = $('#' + leadID);
                    var val = obj.val();
                    obj.val(val + ' ' + smiley + ' ');
                });
            }
        });
        //bind quotation div expander
        $('.' + mem2.expandClass).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var leadID = $(this).attr('name');
                    var pindex = $(this).data().bind;
                    if ($('#' + mem2.list.parentDiv + leadID).css('display') !== 'block') {
                        DisplayLeadQuotation({
                            pindex: pindex,
                            leadID: leadID
                        });
                    } else {
                        $('#' + mem2.list.parentDiv + leadID).css({
                            display: 'none'
                        });
                    }
                });
            }
        });
        //bind quotationBOX
        $('.' + mem2.quotationBOX.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).attr('name');
                    var cObj = $('#' + mem2.quotationBOX.id + leadID);
                    var quotation = $.trim(cObj.val());
                    cObj.val('');
                    if (quotation) {
                        cObj.attr('disable', 'disable');
                        $.ajax({
                            url: mem2.quotationBOX.url,
                            type: mem2.quotationBOX.type,
                            async: false,
                            data: {
                                autoloader: mem2.quotationBOX.autoloader,
                                action: mem2.quotationBOX.action,
                                dataType: mem2.quotationBOX.dataType,
                                leadID: leadID,
                                quotation: encodeURIComponent(quotation),
                            },
                            success: function (data) {
                                if (typeof data === 'object') {
                                    obj = data;
                                }
                                else {
                                    obj = $.parseJSON($.trim(data));
                                }
                                $('#' + mem2.counter + leadID).html(obj.count);
                                window.setTimeout(function () {
                                    DisplayLeadQuotation({pindex: null, pcindex: null, leadID: leadID});
                                }, 800);
                            },
                            error: function () {
                                $(OUTPUT).html(INET_ERROR);
                            },
                            complete: function (xhr, textStatus) {
                                cObj.removeAttr('disable');
                            }
                        });
                    }
                });
            }
        });
        $('.' + mem2.camera.moodalClass).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    //evt.preventDefault();
                    //evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).attr('name');
                    var cObj = $('#' + mem2.camera.create);
                    var picEditObj = {};
                    window.setTimeout(function () {
                        picEditObj = $('#' + mem2.camera.img).picEdit({
                            imageUpdated: function (_this) {
                            },
                            formError: function (res) {
                                mem2.camera.picedit = false;
                            },
                            /* Soharab Modification */
                            formProgress: function (data) {
                                var res = {};
                                if (typeof data === 'object') {
                                    res = data;
                                } else {
                                    res = $.parseJSON($.trim(data));
                                }
                                //console.log(res);
                            },
                            /* Soharab Modification */
                            formSubmitted: function (data) {
                                var res = {};
                                var quotation = $('#' + mem2.camera.text).val();
                                if (typeof data === 'object') {
                                    res = data;
                                } else {
                                    res = $.parseJSON($.trim(data));
                                }
                                if (res.readyState && quotation) {
                                    cObj.attr('disable', 'disable');
                                    $.ajax({
                                        url: mem2.camera.url,
                                        type: mem2.camera.type,
                                        async: false,
                                        data: {
                                            autoloader: mem2.camera.autoloader,
                                            action: mem2.camera.action,
                                            dataType: mem2.camera.dataType,
                                            leadID: leadID,
                                            quotation: encodeURIComponent(quotation),
                                        },
                                        success: function (data) {
                                            if (typeof data === 'object') {
                                                obj = data;
                                            }
                                            else {
                                                obj = $.parseJSON($.trim(data));
                                            }
                                            $('#' + mem2.counter + leadID).html(obj.count);
                                            mem2.camera.picedit = false;
                                            $('#' + mem2.camera.close).click(function () {
                                                DisplayLeadQuotation({pindex: null, pcindex: null, leadID: leadID});
                                            });
                                        },
                                        error: function () {
                                            $(OUTPUT).html(INET_ERROR);
                                        },
                                        complete: function (xhr, textStatus) {
                                            cObj.removeAttr('disable');
                                        }
                                    });
                                    mem2.camera.picedit = false;
                                    mem2.camera.ajaxForm = false;
                                } else {
                                    alert('Error could not quotation on lead!!!.');
                                }
                            },
                            FormObj: $('#' + mem2.camera.form),
                            goFlag: false,
                            picEditUpload: false,
                            redirectUrl: false,
                            defaultImage: mem2.camera.defaultImage
                        });
                        $('#' + mem2.camera.img).parent().css({
                            paddingLeft: '15%',
                            paddingRight: '15%',
                            backgroundColor: '#C0C0C0',
                        });
                        validateCreateQuotationForm(picEditObj);
                    }, 700);
                    window.setTimeout(function () {
                        picEditObj._setDefaultValues();
                    }, 1000);
                });
            }
        });
    }
    ;
    function bindLeadQuotationActions() {
        var mem2 = members.list.quotation;
        $('.' + mem2.list.content).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder);
                $(this).emoticonize({
                    //delay: 800,
                    //animate: false,
                    //exclude: 'pre, code, .no-emoticons'
                });
                /*
                $(this).addClass(mem2.list.binder).bind('mouseover', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(this).emoticonize({
                        //delay: 800,
                        //animate: false,
                        //exclude: 'pre, code, .no-emoticons'
                    });
                });
                */
            }
        });
        //bind lead quotation approval
        $('.' + mem2.list.approval.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadComID = $(this).attr('name');
                    $('#' + mem2.list.approval.counter + leadComID).html(LOADER_ONE);
                    $.ajax({
                        url: mem2.list.approval.url + '/' + leadComID,
                        type: mem2.list.approval.type,
                        async: false,
                        data: {
                            autoloader: mem2.list.approval.autoloader,
                            action: mem2.list.approval.action,
                            dataType: mem2.list.approval.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem2.list.approval.counter + leadComID).html(obj.count);
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead quotation disapproval
        $('.' + mem2.list.disapproval.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadComID = $(this).attr('name');
                    $('#' + mem2.list.disapproval.counter + leadComID).html(LOADER_ONE);
                    $.ajax({
                        url: mem2.list.disapproval.url + '/' + leadComID,
                        type: mem2.list.disapproval.type,
                        async: false,
                        data: {
                            autoloader: mem2.list.disapproval.autoloader,
                            action: mem2.list.disapproval.action,
                            dataType: mem2.list.disapproval.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem2.list.disapproval.counter + leadComID).html(obj.count);
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead quotation preferences
        $('.' + mem2.list.pref.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).parent().attr('name');
                    var prefID = $(this).attr('name');
                    var action = $(this).parent().attr('id');
                    $.ajax({
                        url: mem2.list.pref.url,
                        type: mem2.list.pref.type,
                        async: false,
                        data: {
                            autoloader: mem2.list.pref.autoloader,
                            action: mem2.list.pref.action,
                            dataType: mem2.list.pref.dataType,
                            para: {leadID: leadID, prefID: prefID, action: action},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            switch (action) {
                                case 'hide':
                                    $('#' + mem2.list.leadDiv + leadID).hide(300);
                                    break;
                                case 'delete':
                                    $('#' + mem2.list.leadDiv + leadID).remove();
                                    break;
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        var mem3 = mem2.list.wo;
        $('.' + mem3.smiley.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).bind('mouseover', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(this).emoticonize({
                        //delay: 800,
                        //animate: false,
                        //exclude: 'pre, code, .no-emoticons'
                    });
                });
                //bind smilies for wo
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var smiley = $(this).text();
                    var leadComID = $(this).parent().attr('name');
                    var obj = $('#' + leadComID);
                    var val = obj.val();
                    obj.val(val + ' ' + smiley + ' ');
                });
            }
        });
        //bind wo div expander
        $('.' + mem3.expandClass).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var leadComID = $(this).attr('name');
                    var pindex = $(this).parent().data().bind;
                    var pcindex = $(this).data().bind;
                    if ($('#' + mem3.list.parentDiv + leadComID).css('display') !== 'block') {
                        DisplayLeadQuotationWo({
                            pindex: pindex,
                            pcindex: pcindex,
                            leadComID: leadComID
                        });
                    } else {
                        $('#' + mem3.list.parentDiv + leadComID).css({
                            display: 'none'
                        });
                    }
                });
            }
        });
        //bind woBOX
        $('.' + mem3.woBOX.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                if ($(this).hasClass(mem3.list.binder) === false) {
                    $(this).addClass(mem3.list.binder).on('click', function (evt) {
                        evt.preventDefault();
                        evt.stopPropagation();
                        var obj = {};
                        var leadComID = $(this).attr('name');
                        var cObj = $('#' + mem3.woBOX.id + leadComID);
                        var wo = $.trim(cObj.val());
                        cObj.val('');
                        if (wo) {
                            cObj.attr('disable', 'disable');
                            $.ajax({
                                url: mem3.woBOX.url,
                                type: mem3.woBOX.type,
                                async: false,
                                data: {
                                    autoloader: mem3.woBOX.autoloader,
                                    action: mem3.woBOX.action,
                                    dataType: mem3.woBOX.dataType,
                                    leadComID: leadComID,
                                    wo: encodeURIComponent(wo),
                                },
                                success: function (data) {
                                    if (typeof data === 'object') {
                                        obj = data;
                                    } else {
                                        obj = $.parseJSON($.trim(data));
                                    }
                                    $('#' + mem3.counter + leadComID).html(obj.count);
                                    window.setTimeout(function () {
                                        DisplayLeadQuotationWo({
                                            pindex: null,
                                            pcindex: null,
                                            leadComID: leadComID
                                        });
                                    }, 800);
                                },
                                error: function () {
                                    $(OUTPUT).html(INET_ERROR);
                                },
                                complete: function (xhr, textStatus) {
                                    cObj.removeAttr('disable');
                                }
                            });
                        }
                    });
                }
            }
        });
        $('.' + mem3.camera.moodalClass).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    //evt.preventDefault();
                    //evt.stopPropagation();
                    var obj = {};
                    var leadComID = $(this).attr('name');
                    var cObj = $('#' + mem3.camera.create);
                    var picEditObj = {};
                    window.setTimeout(function () {
                        picEditObj = $('#' + mem3.camera.img).picEdit({
                            imageUpdated: function (_this) {
                            },
                            formError: function (res) {
                                mem3.camera.picedit = false;
                            },
                            /* Soharab Modification */
                            formProgress: function (data) {
                                var res = {};
                                if (typeof data === 'object') {
                                    res = data;
                                } else {
                                    res = $.parseJSON($.trim(data));
                                }
                                //console.log(res);
                            },
                            /* Soharab Modification */
                            formSubmitted: function (data) {
                                var res = {};
                                var wo = $('#' + mem3.camera.text).val();
                                if (typeof data === 'object') {
                                    res = data;
                                } else {
                                    res = $.parseJSON($.trim(data));
                                }
                                if (res.readyState && wo) {
                                    cObj.attr('disable', 'disable');
                                    $.ajax({
                                        url: mem3.camera.url,
                                        type: mem3.camera.type,
                                        async: false,
                                        data: {
                                            autoloader: mem3.camera.autoloader,
                                            action: mem3.camera.action,
                                            dataType: mem3.camera.dataType,
                                            leadComID: leadComID,
                                            wo: encodeURIComponent(wo),
                                        },
                                        success: function (data) {
                                            if (typeof data === 'object') {
                                                obj = data;
                                            }
                                            else {
                                                obj = $.parseJSON($.trim(data));
                                            }
                                            $('#' + mem3.counter + leadComID).html(obj.count);
                                            mem3.camera.picedit = false;
                                            $('#' + mem3.camera.close).click(function () {
                                                DisplayLeadQuotationWo({
                                                    pindex: null,
                                                    pcindex: null,
                                                    leadComID: leadComID
                                                });
                                            });
                                        },
                                        error: function () {
                                            $(OUTPUT).html(INET_ERROR);
                                        },
                                        complete: function (xhr, textStatus) {
                                            cObj.removeAttr('disable');
                                        }
                                    });
                                    mem3.camera.picedit = false;
                                    mem3.camera.ajaxForm = false;
                                } else {
                                    alert('Error could not quotation on lead!!!.');
                                }
                            },
                            FormObj: $('#' + mem3.camera.form),
                            goFlag: false,
                            picEditUpload: false,
                            redirectUrl: false,
                            defaultImage: mem3.camera.defaultImage
                        });
                        $('#' + mem3.camera.img).parent().css({
                            paddingLeft: '15%',
                            paddingRight: '15%',
                            backgroundColor: '#C0C0C0',
                        });
                        validateCreateQuotationWoForm(picEditObj);
                    }, 700);
                    window.setTimeout(function () {
                        picEditObj._setDefaultValues();
                    }, 1200);
                });
            }
        });
    }
    ;
    function bindLeadQuotationWoActions() {
        var mem3 = members.list.quotation.list.wo;
        $('.' + mem3.list.content).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder);
                $(this).emoticonize({
                    //delay: 800,
                    //animate: false,
                    //exclude: 'pre, code, .no-emoticons'
                });
                /*
                $(this).addClass(mem3.list.binder).bind('mouseover', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    $(this).emoticonize({
                        //delay: 800,
                        //animate: false,
                        //exclude: 'pre, code, .no-emoticons'
                    });
                });
                */
            }
        });
        //bind lead quotation wo approval
        $('.' + mem3.list.approval.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadComRepID = $(this).attr('name');
                    $('#' + mem3.list.approval.counter + leadComRepID).html(LOADER_ONE);
                    $.ajax({
                        url: mem3.list.approval.url + '/' + leadComRepID,
                        type: mem3.list.approval.type,
                        async: false,
                        data: {
                            autoloader: mem3.list.approval.autoloader,
                            action: mem3.list.approval.action,
                            dataType: mem3.list.approval.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem3.list.approval.counter + leadComRepID).html(obj.count);
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead quotation wo list.disapproval
        $('.' + mem3.list.disapproval.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadComRepID = $(this).attr('name');
                    $('#' + mem3.list.disapproval.counter + leadComRepID).html(LOADER_ONE);
                    $.ajax({
                        url: mem3.list.disapproval.url + '/' + leadComRepID,
                        type: mem3.list.disapproval.type,
                        async: false,
                        data: {
                            autoloader: mem3.list.disapproval.autoloader,
                            action: mem3.list.disapproval.action,
                            dataType: mem3.list.disapproval.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem3.list.disapproval.counter + leadComRepID).html(obj.count);
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
        //bind lead preferences
        $('.' + mem3.list.pref.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var leadID = $(this).parent().attr('name');
                    var prefID = $(this).attr('name');
                    var action = $(this).parent().attr('id');
                    $.ajax({
                        url: mem3.list.pref.url,
                        type: mem3.list.pref.type,
                        async: false,
                        data: {
                            autoloader: mem3.list.pref.autoloader,
                            action: mem3.list.pref.action,
                            dataType: mem3.list.pref.dataType,
                            para: {leadID: leadID, prefID: prefID, action: action},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            switch (action) {
                                case 'hide':
                                    $('#' + mem3.list.leadDiv + leadID).hide(300);
                                    break;
                                case 'delete':
                                    $('#' + mem3.list.leadDiv + leadID).remove();
                                    break;
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            }
        });
    }
    ;
    function validateCreateLeadForm() {
        var memadd = members.create;
        var $params = {
            debug: true,
            rules: {},
            messages: {}
        };
        var form = $('#' + memadd.form);
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        var field = $('#' + memadd.leadImg).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: nookleads.imgTypes
        };
        $params['messages'][field] = {
            required: 'Select Image',
            minlength: 'Select JPEG OR PNG image'
        };
        var field = $('#' + memadd.title).attr("name");
        $params['rules'][field] = {
            required: true,
            minlength: 2
        };
        $params['messages'][field] = {
            required: 'Enter the Title',
            minlength: 'Length Should be minimum 2 Characters'
        };
        var field = $('#' + memadd.target).attr("name");
        $params['rules'][field] = {
            required: true
        };
        $params['messages'][field] = {
            required: 'Select target'
        };
        var field = $('#' + memadd.iagree).attr("name");
        $params['rules'][field] = {
            required: true
        };
        $params['messages'][field] = {
            required: 'Select Agree'
        };
        $params['submitHandler'] = function () {
            memadd.ajaxForm = true;
            picEditObj._setGoFlag(memadd.ajaxForm);
            //console.log(picEditObj._formComplete());
            if (memadd.ajaxForm && picEditObj._formComplete()) {
                picEditObj.formSubmit();
            }
            else {
                alert('Upload picture or fill in the blanks!!!');
            }
        };
        $params['invalidHandler'] = function () {
            //console.log('I am in errorHandler');
            memadd.ajaxForm = false;
            picEditObj._setGoFlag(memadd.ajaxForm);
        };
        $('#' + memadd.form).validate($params);
    }
    ;
    function validateCreateQuotationForm(picEditObj) {
        var memadd = members.list.quotation;
        var $params = {
            debug: true,
            rules: {},
            messages: {}
        };
        var form = $('#' + memadd.camera.form);
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        var field = $('#' + memadd.camera.img).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: nookleads.imgTypes
        };
        $params['messages'][field] = {
            required: 'Select Image',
            minlength: 'Select JPEG OR PNG image'
        };
        var field = $('#' + memadd.camera.text).attr("name");
        $params['rules'][field] = {
            required: true,
            minlength: 2
        };
        $params['messages'][field] = {
            required: 'Enter the quotation',
            minlength: 'Length Should be minimum 2 Characters'
        };
        $params['submitHandler'] = function () {
            memadd.camera.ajaxForm = true;
            picEditObj._setGoFlag(memadd.camera.ajaxForm);
            if (memadd.camera.ajaxForm && picEditObj._formComplete()) {
                picEditObj.formSubmit();
            }
            else {
                alert('Upload picture or fill in the blanks!!!');
            }
        };
        $params['invalidHandler'] = function () {
            memadd.camera.ajaxForm = false;
            picEditObj._setGoFlag(memadd.camera.ajaxForm);
        };
        $('#' + memadd.camera.form).validate($params);
    }
    ;
    function validateCreateQuotationWoForm(picEditObj) {
        var memadd = members.list.quotation.list.wo;
        var $params = {
            debug: true,
            rules: {},
            messages: {}
        };
        var form = $('#' + memadd.camera.form);
        form.on('keyup', function (e) {
            var code = Number(e.keyCode || e.which);
            if (code === 13) {
                e.preventDefault();
                return false;
            }
        });
        var field = $('#' + memadd.camera.img).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: nookleads.imgTypes
        };
        $params['messages'][field] = {
            required: 'Select Image',
            minlength: 'Select JPEG OR PNG image'
        };
        var field = $('#' + memadd.camera.text).attr("name");
        $params['rules'][field] = {
            required: true,
            minlength: 2
        };
        $params['messages'][field] = {
            required: 'Enter the wo',
            minlength: 'Length Should be minimum 2 Characters'
        };
        $params['submitHandler'] = function () {
            memadd.camera.ajaxForm = true;
            picEditObj._setGoFlag(memadd.camera.ajaxForm);
            if (memadd.camera.ajaxForm && picEditObj._formComplete()) {
                picEditObj.formSubmit();
            }
            else {
                alert('Upload picture or fill in the blanks!!!');
            }
        };
        $params['invalidHandler'] = function () {
            memadd.camera.ajaxForm = false;
            picEditObj._setGoFlag(memadd.camera.ajaxForm);
        };
        $('#' + memadd.camera.form).validate($params);
    }
    ;
    function fetchSections() {
        var mem = members.sections;
        $('#' + mem.outputDiv).html('Loading...');
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                listtype: mem.listtype
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listOfSections = data;
                } else {
                    listOfSections = $.parseJSON($.trim(data));
                }
                if (listOfSections.status === "success") {
                    $('#' + mem.outputDiv).html('<select name="' + mem.id + '" id="' + mem.id + '" class="' + mem.class + '">' + listOfSections.html + '</select>');
                } else {
                    alert('Failed to retive sections.');
                }
            },
            error: function (xhr, textStatus) {
                //console.log(xhr);
                //console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                //console.log(xhr.status);
            }
        });
    }
    ;
    function fetchListOfContinents() {
        var memadd = members.create;
        var mem = members.continents;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                } else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    $('#' + memadd.parentFild).html('<div class="col-lg-12"><h4>Select continent.</h4></div><div class="col-lg-12">' +
                            '<select class="form-control" id="' + memadd.continent + '" name="' + memadd.continent + '" required=""><option value="">Select Continent</option>' + data.html +
                            '</select>' +
                            '</div>');
                    window.setTimeout(function () {
                        $('#' + memadd.continent).change(function () {
                            var allval = new Array();
                            $(recentObjCountry).remove();
                            $(recentObjlanguge).remove();
                            if (this.value !== "") {
                                allval[0] = this.value
                                fetchListOfCountries(allval);
                            }
                        });
                    }, 700);
                }
            },
            error: function (xhr, textStatus) {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function fetchListOfCountries(cont_id) {
        var memadd = members.create;
        var mem = members.countries;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                cont_id: cont_id,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                } else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    recentObjCountry = $('<div class="col-lg-12"><h4>Select countries.</h4></div><div class="col-lg-12">' +
                            '<select class="form-control" id="' + memadd.country + '" name="' + memadd.country + '" multiple="multiple" required="">' + data.html +
                            '</select>' +
                            '</div>');
                    $('#' + memadd.parentFild).append(recentObjCountry);
                    $('#' + memadd.country).hide();
                    $('#' + memadd.country).select2();
                    $(memadd.sel2).addClass('col-lg-12');
                    $(memadd.sel2).removeAttr('style');
                    //$('#' + memadd.country + ' > option').prop("selected", "selected");
                    var $eventSelect = $('#' + memadd.country);
                    $eventSelect.on("change", function (e) {
                        $eventSelect.select2("close");
                        var countries = [];
                        $('#' + memadd.country + ' :selected').each(function (i, selected) {
                            countries[i] = $(selected).val();
                        });
                        $(recentObjlanguge).remove();
                        fetchlanguages(countries);
                    });
                    /*
                     window.setTimeout(function () {
                     $eventSelect.trigger("change");
                     }, 700);
                     */
                }
            },
            error: function (xhr, textStatus) {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function fetchlanguages(countries_id) {
        var memadd = members.create;
        var mem = members.languages;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                countries_id: countries_id,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                } else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    recentObjlanguge = $('<div class="col-lg-12"><h4>Select languages.</h4></div><div class="col-lg-12">' +
                            '<select class="form-control" id="' + memadd.language + '" name="' + memadd.language + '" multiple="multiple">' + data.html +
                            '</select>' +
                            '</div>');
                    $('#' + memadd.parentFild).append(recentObjlanguge);
                    $('#' + memadd.language).hide();
                    $('#' + memadd.language).select2({
                        minimumResultsForSearch: -1
                    });
                    $(memadd.sel2).addClass('col-lg-12');
                    $(memadd.sel2).removeAttr('style');
                    //$('#' + memadd.language + ' > option').prop("selected", "selected");
                    var $eventSelect = $('#' + memadd.language);
                    $eventSelect.on("change", function (e) {
                        $eventSelect.select2("close");
                    });
                    /*
                     window.setTimeout(function () {
                     $eventSelect.trigger("change");
                     }, 800);
                     */
                }
            },
            error: function (xhr, textStatus) {
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
}
