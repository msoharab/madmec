function businessController() {
    var submitCreate;
    var members = {};
    var listOfBusinesss = {};
    var listAdminBusinesss = {};
    var listSubscribeBusinesss = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    var picEditObj = {};
    this.__constructor = function (para) {
        members = para;
        submitCreate = false;
    };
    this.publicDisplayLead = function () {
        var mem1 = members.business;
        $('#' + mem1.home.targetDiv).trigger('click');
    };
    this.publicFilterlead = function (data) {
        var mem = members.business.home.list;
        $('#' + mem.outputDiv).html(data);
        window.setTimeout(function () {
            bindLeadActions();
        }, 1500);
    };
    this.publicListBusinesss = function () {
        window.setTimeout(function () {
            ListBusinesss();
        }, 1600);
    };
    this.publicListAdminBusinesss = function () {
        window.setTimeout(function () {
            ListAdminBusinesss();
        }, 2000);
    };
    this.publicListSubscribeBusinesss = function () {
        window.setTimeout(function () {
            ListSubscribeBusinesss();
        }, 2400);
    };
    this.publicsearchBusinesss = function () {
        window.setTimeout(function () {
            searchBusinesss();
        }, 2100);
    };
    this.bindActions = function () {
        var mem1 = members.business;
        //bind business approval
        $('#' + mem1.approval.id).on('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var businessID = $(this).attr('name');
            $('#' + mem1.approval.counter).html(LOADER_ONE);
            $.ajax({
                url: mem1.approval.url + '/' + businessID,
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
                    $('#' + mem1.approval.counter).html(obj.count);
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        //bind business disapproval
        $('#' + mem1.disapproval.id).on('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var businessID = $(this).attr('name');
            $('#' + mem1.disapproval.counter).html(LOADER_ONE);
            $.ajax({
                url: mem1.disapproval.url + '/' + businessID,
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
                    $('#' + mem1.disapproval.counter).html(obj.count);
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        //bind business report
        $('.' + mem1.report.class).each(function () {
            $(this).on('click', function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                var obj = {};
                var businessID = $(this).parent().attr('name');
                var reportID = $(this).attr('name');
                $.ajax({
                    url: mem1.report.url,
                    type: mem1.report.type,
                    async: false,
                    data: {
                        autoloader: mem1.report.autoloader,
                        action: mem1.report.action,
                        dataType: mem1.report.dataType,
                        para: {businessID: businessID, reportID: reportID},
                    },
                    success: function (data) {
                        if (typeof data === 'object') {
                            obj = data;
                        } else {
                            obj = $.parseJSON($.trim(data));
                        }
                        if (obj.status === 'success') {
                            $(mem1.report.parentDiv + businessID).hide(600);
                        }
                    },
                    error: function () {
                        $(OUTPUT).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                    }
                });
            });
        });
        //bind business banner update
        $('#' + mem1.backgroud.parentBut).bind('click', function (evt) {
            validateBusinessBGForm();
            window.setTimeout(function () {
                picEditObj = $('#' + mem1.backgroud.leadImg).picEdit({
                    imageUpdated: function (_this) {
                        //console.log(_this);
                        //picEditObj._setDefaultImage(img.src);
                        //throw new Error('Stop Damn Recursion');
                        //return false;
                    },
                    formError: function (res) {
                        mem1.backgroud.picedit = false;
                    },
                    /* Soharab Modification */
                    formProgress: function (data) {
                        $('#' + mem1.backgroud.create).prop('disabled', 'disabled');
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
                        $('#' + mem1.backgroud.create).removeAttr('disabled');
                        var res = {};
                        if (typeof data === 'object') {
                            res = data;
                        } else {
                            res = $.parseJSON($.trim(data));
                        }
                        if (res.readyState && picEditObj._formComplete()) {
                            updateBusinessBG();
                            mem1.backgroud.picedit = false;
                        } else {
                            alert('Error could not update profile picture !!!.');
                        }
                    },
                    FormObj: $('#' + mem1.backgroud.form),
                    goFlag: true,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: mem1.backgroud.defaultImage
                });
                $('#' + mem1.backgroud.leadImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1500);
            $('#' + mem1.backgroud.leadImg).change(function () {
                mem1.backgroud.picedit = true;
            });
        });
        //bind business icon update
        $('#' + mem1.icon.parentBut).bind('click', function (evt) {
            validateBusinessIconForm();
            window.setTimeout(function () {
                picEditObj = $('#' + mem1.icon.leadImg).picEdit({
                    imageUpdated: function (_this) {
                        //console.log(_this);
                        //picEditObj._setDefaultImage(img.src);
                        //throw new Error('Stop Damn Recursion');
                        //return false;
                    },
                    formError: function (res) {
                        mem1.icon.picedit = false;
                    },
                    /* Soharab Modification */
                    formProgress: function (data) {
                        $('#' + mem1.icon.create).prop('disabled', 'disabled');
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
                        $('#' + mem1.icon.create).removeAttr('disabled');
                        var res = {};
                        if (typeof data === 'object') {
                            res = data;
                        } else {
                            res = $.parseJSON($.trim(data));
                        }
                        if (res.readyState && picEditObj._formComplete()) {
                            updateBusinessIcon();
                            mem1.icon.picedit = false;
                        } else {
                            alert('Error could not update profile picture !!!.');
                        }
                    },
                    FormObj: $('#' + mem1.icon.form),
                    goFlag: true,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: mem1.icon.defaultImage
                });
                $('#' + mem1.icon.leadImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1500);
            $('#' + mem1.icon.leadImg).change(function () {
                mem1.icon.picedit = true;
            });
        });
        //bind business Advertise update
        $('#' + mem1.advertisement.parentBut).bind('click', function (evt) {
            validateBusinessAdvForm();
            window.setTimeout(function () {
                picEditObj = $('#' + mem1.advertisement.leadImg).picEdit({
                    imageUpdated: function (_this) {
                        //console.log(_this);
                        //picEditObj._setDefaultImage(img.src);
                        //throw new Error('Stop Damn Recursion');
                        //return false;
                    },
                    formError: function (res) {
                        mem1.advertisement.picedit = false;
                    },
                    /* Soharab Modification */
                    formProgress: function (data) {
                        $('#' + mem1.advertisement.create).prop('disabled', 'disabled');
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
                        $('#' + mem1.advertisement.create).removeAttr('disabled');
                        var res = {};
                        if (typeof data === 'object') {
                            res = data;
                        } else {
                            res = $.parseJSON($.trim(data));
                        }
                        if (res.readyState && picEditObj._formComplete()) {
                            updateBusinessAdv();
                            mem1.advertisement.picedit = false;
                        } else {
                            alert('Error could not update profile picture !!!.');
                        }
                    },
                    FormObj: $('#' + mem1.advertisement.form),
                    goFlag: true,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: mem1.advertisement.defaultImage
                });
                $('#' + mem1.advertisement.leadImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1500);
            $('#' + mem1.advertisement.leadImg).change(function () {
                mem1.advertisement.picedit = true;
            });
        });
        //bind business block
        $('#' + mem1.block.create).bind('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var businessID = Number($('#' + mem1.block.text).val());
            $('#' + mem1.block.counter + businessID).html(LOADER_ONE);
            $.ajax({
                url: mem1.block.url + '/' + businessID,
                type: mem1.block.type,
                async: false,
                data: {
                    autoloader: mem1.block.autoloader,
                    action: mem1.block.action,
                    dataType: mem1.block.dataType,
                },
                success: function (data) {
                    if (typeof data === 'object') {
                        obj = data;
                    } else {
                        obj = $.parseJSON($.trim(data));
                    }
                    //$('#' + mem1.block.counter + businessID).html(obj.count);
                    window.location.href = URL + 'Deal/Index';
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        //bind business subscribe
        $('#' + mem1.subscribe.create).bind('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var businessID = Number($('#' + mem1.subscribe.text).val());
            $('#' + mem1.subscribe.counter).html(LOADER_ONE);
            $.ajax({
                url: mem1.subscribe.url + '/' + businessID,
                type: mem1.subscribe.type,
                async: false,
                data: {
                    autoloader: mem1.subscribe.autoloader,
                    action: mem1.subscribe.action,
                    dataType: mem1.subscribe.dataType,
                },
                success: function (data) {
                    if (typeof data === 'object') {
                        obj = data;
                    } else {
                        obj = $.parseJSON($.trim(data));
                    }
                    $('#' + mem1.subscribe.counter).html(obj.count);
                    //window.location.href = URL+'Deal/Index';
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        var mem2 = members.business.home;
        //bind create lead
        $('#' + mem2.create.parentBut).bind('click', function (evt) {
            fetchSections();
            validateCreateLeadForm();
            $('#' + mem2.create.target).change(function () {
                if (this.value === "Country") {
                    fetchListOfContinents();
                } else {
                    $('#' + mem2.create.parentFild).html('');
                }
            });
            window.setTimeout(function () {
                picEditObj = $('#' + mem2.create.leadImg).picEdit({
                    imageUpdated: function (_this) {
                        //console.log(_this);
                        //picEditObj._setDefaultImage(img.src);
                        //throw new Error('Stop Damn Recursion');
                        //return false;
                    },
                    formError: function (res) {
                        mem2.create.picedit = false;
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
                            mem2.create.picedit = false;
                        } else {
                            alert('Error could not lead on nookleads!!!.');
                        }
                    },
                    FormObj: $('#' + mem2.create.form),
                    goFlag: false,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: mem2.create.defaultImage
                });
                $('#' + mem2.create.leadImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1000);
        });
        //bind business lead list
        $('#' + mem1.home.targetDiv).bind('click', function (evt) {
            DisplayLead();
        });
        $('#' + members.business.about.targetDiv).bind('click', function () {
            //bind send message to admin
            var mem3 = members.business.about.msgAJAX;
            $('#' + mem3.submit).bind('click', function (evt) {
                var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
                var message = $('#' + mem3.msg).val();
                var obj = {};
                if (message.length > 0 && message.length < 251) {
                    $.ajax({
                        url: mem3.url + '/' + businessID,
                        type: mem3.type,
                        data: {
                            autoloader: mem3.autoloader,
                            action: mem3.action,
                            dataType: mem3.dataType,
                            msg: message,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            if (obj.status === 'success') {
                                alert('Message sent!!');
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                }
            });
            //bind remove admin ajax
            var classRemove = members.business.about.removeAdm;
            $('.' + classRemove).each(function () {
                var mem4 = members.business.about.adminsAJAX;
                $(this).bind('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var businessID = $(this).parent().attr('name');
                    var UID = Number($(this).attr('data-uid'));
                    var obj = {};
                    $.ajax({
                        url: mem4.url + '/' + businessID,
                        type: mem4.type,
                        data: {
                            autoloader: mem4.autoloader,
                            action: mem4.action,
                            dataType: mem4.dataType,
                            details: {businessID: businessID, UserId: UID},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            if (obj.status === 'success') {
                                alert('Admin removed!!');
                                window.location.href = window.location.href;
                            }
                        },
                        error: function () {
                            $(OUTPUT).html(INET_ERROR);
                        },
                        complete: function (xhr, textStatus) {
                        }
                    });
                });
            });
        });
        //bind business settings
        var mem5 = members.business.setting;
        $('#' + mem5.targetDiv).bind('click', function (evt) {
            validateBusinessSettingForm();
            fetchBusinessAdmins();
        });
        //bind list messages
        var mem6 = members.business.message;
        $('#' + mem6.targetDiv).bind('click', function () {
            listMessages();
        });
        //list business lead list
        window.setTimeout(function () {
            DisplayLead();
        }, 200);
    };
    function ListAdminBusinesss() {
        var mem = members.business.listAdminBusinesss;
        $.ajax({
            url: mem.url,
            type: mem.type,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listAdminBusinesss = data;
                }
                else {
                    listAdminBusinesss = $.parseJSON($.trim(data));
                }
                if (listAdminBusinesss.status === "success") {
                    $('#' + mem.outputDiv).html(listAdminBusinesss.html);
                } else {
                    alert('Failed to retive businesss.');
                }
                validateCreateBusinessForm();
            },
            error: function (xhr, textStatus) {
                console.log(xhr);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function ListSubscribeBusinesss() {
        var mem = members.business.listSubscribeBusinesss;
        $.ajax({
            url: mem.url,
            type: mem.type,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listSubscribeBusinesss = data;
                }
                else {
                    listSubscribeBusinesss = $.parseJSON($.trim(data));
                }
                if (listSubscribeBusinesss.status === "success") {
                    $('#' + mem.outputDiv).html(listSubscribeBusinesss.html);
                } else {
                    alert('Failed to retive businesss.');
                }
                validateCreateBusinessForm();
            },
            error: function (xhr, textStatus) {
                console.log(xhr);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function updateBusinessDetails() {
        var mem3 = members.business.setting;
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        var admins = [];
        $('#' + mem3.admins + ' :selected').each(function (i, selected) {
            admins[i] = $(selected).val();
        });
        var attr = {
            name: $('#' + mem3.name).val(),
            description: $('#' + mem3.description).val(),
            admins: admins,
            facebook: $('#' + mem3.facebook).val(),
            googleplus: $('#' + mem3.googleplus).val(),
            twitter: $('#' + mem3.twitter).val(),
            website: $('#' + mem3.website).val(),
            target: 0,
            continent: 0,
            countries: 0,
            langauges: 0,
        };
        $.ajax({
            url: mem3.url + '/' + businessID,
            type: mem3.type,
            data: {
                autoloader: mem3.autoloader,
                action: mem3.action,
                dataType: mem3.dataType,
                details: attr,
            },
            success: function (data) {
                if (typeof data === 'object') {
                    obj = data;
                } else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === 'success') {
                    alert('Business Settings updated!!');
                    window.location.href = window.location.href;
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
    function validateBusinessSettingForm() {
        var memadd = members.business.setting;
        var submitCreate = false;
        window.setTimeout(function () {
            var $params = {debug: false, rules: {}, messages: {}};
            //Business name
            var field = $('#' + memadd.name).attr("name");
            $params['rules'][field] = {
                required: true,
                minlength: 4
            };
            $params['messages'][field] = {
                required: 'Enter the Business Name',
                minlength: 'Length Should be minimum 4 Characters'
            };
            //Business description
            var field = $('#' + memadd.description).attr("name");
            $params['rules'][field] = {
                required: true,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Business Description',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Business facebook
            var field = $('#' + memadd.facebook).attr("name");
            $params['rules'][field] = {
                required: false,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Facebook link',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Business googleplus
            var field = $('#' + memadd.googleplus).attr("name");
            $params['rules'][field] = {
                required: false,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Google plus link',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Business twitter
            var field = $('#' + memadd.twitter).attr("name");
            $params['rules'][field] = {
                required: false,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Twitter link',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Business website
            var field = $('#' + memadd.website).attr("name");
            $params['rules'][field] = {
                required: false,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Website link',
                minlength: 'Length Should be minimum 10 Characters'
            };
            $params['submitHandler'] = function () {
                submitCreate = true;
            };
            $('#' + memadd.form).validate($params);
            $('#' + memadd.form).submit(function () {
                if (submitCreate) {
                    updateBusinessDetails();
                }
            });
            $('#' + memadd.form).on('keyup', function (e) {
                var code = Number(e.keyCode || e.which);
                if (code === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }, 600);
    }
    ;
    function updateBusinessBG() {
        var mem = members.business.backgroud;
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        var res = {};
        if (mem.picedit) {
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + businessID,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
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
                        alert("Your background image successfully updated.");
                        window.location.href = window.location.href;
                        mem.picedit = false;
                        mem.ajaxForm = false;
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
    function validateBusinessBGForm() {
        var memadd = members.business.backgroud;
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
        $params['submitHandler'] = function () {
            memadd.ajaxForm = true;
            picEditObj._setGoFlag(memadd.ajaxForm);
            if (memadd.ajaxForm && memadd.picedit) {
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
        $(form).validate($params);
    }
    ;
    function updateBusinessIcon() {
        var mem = members.business.icon;
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        var res = {};
        if (mem.picedit) {
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + businessID,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
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
                        alert("Your profile image successfully updated.");
                        window.location.href = window.location.href;
                        mem.picedit = false;
                        mem.ajaxForm = false;
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
    function validateBusinessIconForm() {
        var memadd = members.business.icon;
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
        $params['submitHandler'] = function () {
            memadd.ajaxForm = true;
            picEditObj._setGoFlag(memadd.ajaxForm);
            if (memadd.ajaxForm && memadd.picedit) {
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
        $(form).validate($params);
    }
    ;
    function updateBusinessAdv() {
        var mem = members.business.advertisement;
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        var res = {};
        if (mem.picedit) {
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + businessID,
                type: mem.type,
                dataType: mem.dataType,
                async: false,
                data: {
                    autoloader: mem.autoloader,
                    action: mem.action,
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
                        alert("Your Advertisement successfully updated.");
                        window.location.href = window.location.href;
                        mem.picedit = false;
                        mem.ajaxForm = false;
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
    function validateBusinessAdvForm() {
        var memadd = members.business.advertisement;
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
        $params['submitHandler'] = function () {
            memadd.ajaxForm = true;
            picEditObj._setGoFlag(memadd.ajaxForm);
            if (memadd.ajaxForm && memadd.picedit) {
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
        $(form).validate($params);
    }
    ;
    function createBusiness() {
        var mem = members.business.create;
        var countries = [];
        var languages = [];
        $('#' + mem.country + ' :selected').each(function (i, selected) {
            countries[i] = $(selected).val();
        });
        $('#' + mem.language + ' :selected').each(function (i, selected) {
            languages[i] = $(selected).val();
        });
        var attr = {
            name: $('#' + mem.name).val(),
            target: $('#' + mem.target).val(),
            continent: $('#' + mem.continent).val(),
            countries: countries,
            langauges: languages,
        };
        var res = {};
        if (submitCreate) {
            $(recentObjCountry).remove();
            $(recentObjlanguge).remove();
            $('#' + mem.botton).prop('disabled', 'disabled');
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
                    }
                    else {
                        res = $.parseJSON($.trim(data));
                    }
                    if (res.status === "success") {
                        $('#' + mem.form).get(0).reset();
                        $('#' + mem.close).trigger('click');
                        alert("Business has been Successfully Created");
                        submitCreate = false;
                        ListBusinesss();
                    }
                    else if (res.status === "Your quota is finished.") {
                        $('#' + mem.form).get(0).reset();
                        submitCreate = false;
                        alert(res.status);
                        $('#' + mem.close).trigger('click');
                    }
                },
                error: function (xhr, textStatus) {
                    console.log(xhr.responseText);
                    console.log(textStatus);
                    //document.write(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                    console.log(xhr.status);
                    $('#' + mem.botton).removeAttr('disabled');
                }
            });
        }
    }
    ;
    function ListBusinesss() {
        var mem = members.business.list;
        $.ajax({
            url: mem.url,
            type: mem.type,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    listOfBusinesss = data;
                }
                else {
                    listOfBusinesss = $.parseJSON($.trim(data));
                }
                if (listOfBusinesss.status === "success") {
                    $('#' + mem.outputDiv).html(listOfBusinesss.html);
                } else {
                    alert('Failed to retive businesss.');
                }
                validateCreateBusinessForm();
            },
            error: function (xhr, textStatus) {
                console.log(xhr);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function validateCreateBusinessForm() {
        var memadd = members.business.create;
        window.setTimeout(function () {
            $('#' + memadd.target).change(function () {
                if (this.value === "Country") {
                    fetchListOfContinents();
                }
                else {
                    $('#' + memadd.parentFild).html('');
                }
            });
            var $params = {debug: false, rules: {}, messages: {}};
            var field = $('#' + memadd.name).attr("name");
            $params['rules'][field] = {
                required: true,
                minlength: 4
            };
            $params['messages'][field] = {
                required: 'Enter the Business Name',
                minlength: 'Length Should be minimum 4 Characters'
            };
            var field = $('#' + memadd.target).attr("name");
            $params['rules'][field] = {
                required: true
            };
            $params['messages'][field] = {
                required: 'Select target'
            };
            $params['submitHandler'] = function () {
                submitCreate = true;
            };
            $('#' + memadd.form).validate($params);
            $('#' + memadd.form).submit(function () {
                if (submitCreate) {
                    createBusiness(submitCreate);
                }
            });
            $('#' + memadd.form).on('keyup', function (e) {
                var code = Number(e.keyCode || e.which);
                if (code === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }, 600);
    }
    ;
    function createLead() {
        var mem = members.business.home.create;
        var countries = [];
        var languages = [];
        $('#' + mem.country + ' :selected').each(function (i, selected) {
            countries[i] = $(selected).val();
        });
        $('#' + mem.language + ' :selected').each(function (i, selected) {
            languages[i] = $(selected).val();
        });
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        var allVals = [];
        /*
         $('#PoSections :checked').each(function () {
         allVals.push($(this).val());
         });
         */
        allVals.push($('#' + members.business.home.sections.id).val());
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
            businessID: $('#' + mem.businessID).val(),
        };
        var res = {};
        if (attr) {
            $(recentObjCountry).remove();
            $(recentObjlanguge).remove();
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + businessID,
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
        var mem = members.business.home.list;
        $('#' + mem.outputDiv).html(LOADER_ONE);
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        $.ajax({
            url: mem.url + '/' + businessID,
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
        var mem = members.business.home.list;
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        $('#' + mem.loader).html(LOADER_ONE);
        $.ajax({
            url: mem.url1 + '/' + businessID,
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
                        $('#' + mem.outputDiv).prepend(data);
                        break;
                    default:
                        $('#' + mem.outputDiv).append(data);
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
        var mem = members.business.home.list.quotation.list;
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
//                $('#' + mem.parentDiv + para.leadID).slideToggle('slow');
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
        var mem = members.business.home.list.quotation.list.wo.list;
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
        var mem1 = members.business.home.list;
        $('.' + mem1.smiley).emoticonize({
            //delay: 800,
            //animate: false,
            //exclude: 'pre, code, .no-emoticons'
        });
        $('.' + mem1.smiley).css({
            fontSize: '42px'
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
        var mem2 = members.business.home.list.quotation;
        $('.' + mem2.list.content).each(function () {
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
        var mem3 = members.business.home.list.quotation.list.wo;
        $('.' + mem3.list.content).each(function () {
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
        var memadd = members.business.home.create;
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
        var mem = members.business.home.sections;
        $('#' + mem.outputDiv).html('Loading...');
        $.ajax({
            url: mem.url,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                listtype: mem.listtype,
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
        var memadd = members.business.create;
        var mem = members.business.create.continents;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
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
                console.log(xhr.responseText);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchListOfCountries(cont_id) {
        var memadd = members.business.create;
        var mem = members.business.create.countries;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                cont_id: cont_id,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (obj.status === "success") {
                    recentObjCountry = $('<div class="col-lg-12"><h4>Select countries.</h4></div><div class="col-lg-12">' +
                            '<select class="form-control" id="' + memadd.country + '" name="' + memadd.country + '" multiple="multiple" required="">' + data.html +
                            '</select>' +
                            '</div>');
                    $('#' + memadd.parentFild).append(recentObjCountry);
                    $('#' + memadd.country).hide();
                    $('#' + memadd.country).select2({
                        maximumSelectionLength: -1,
                        allowClear: true
                    });
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
                console.log(xhr.responseText);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchlanguages(countries_id) {
        var memadd = members.business.create;
        var mem = members.business.create.languages;
        var obj = {};
        $.ajax({
            url: mem.url,
            type: mem.type,
            dataType: mem.dataType,
            async: false,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                countries_id: countries_id,
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
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
                console.log(xhr.responseText);
                console.log(textStatus);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
    function fetchBusinessAdmins() {
        var mem = members.business.setting.adminsAJAX;
        var sel = members.business.setting.admins;
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        $('#' + sel).select2({
            ajax: {
                url: mem.url + '/' + businessID,
                dataType: mem.dataType,
                type: mem.type,
                delay: 250,
                data: function (params) {
                    return {
                        autoloader: mem.autoloader,
                        action: mem.action,
                        q: params.term,
                        page: params.page,
                        listtype: mem.listtype,
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true,
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            maximumSelectionLength: -1,
            placeholder: "Search users",
            allowClear: true,
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width: 'resolve',
        });
        window.setTimeout(function () {
            var sel2 = members.business.setting.sel2;
            $(sel2).css({width: '100%'});
        }, 600);
    }
    ;
    function searchBusinesss() {
        var mem = members.deal.header.businessSearch.adminsAJAX;
        var sel = members.deal.header.businessSearch.admins;
        $('#' + sel).select2({
            ajax: {
                url: mem.url,
                dataType: mem.dataType,
                type: mem.type,
                delay: 250,
                data: function (params) {
                    return {
                        autoloader: mem.autoloader,
                        action: mem.action,
                        q: params.term,
                        page: params.page,
                        listtype: mem.listtype,
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true,
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            maximumSelectionLength: -1,
            placeholder: "Search businesss",
            allowClear: true,
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width: 'resolve',
        });
        window.setTimeout(function () {
            var sel2 = members.deal.header.businessSearch.sel2;
            $(sel2).css({width: '100%'});
            $('#' + sel).on("change", function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                window.location.href = $('#' + sel + ' :selected').val();
            });
        }, 600);
    }
    ;
    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'><img src='" + repo.avatar_url + "' /></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.name + "</div>";
        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.email + ", " + repo.cell + "</div>";
        }
        markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-tv'></i> " + repo.ch_count + " Businesss</div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.p_count + " Leads</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-quotations'></i> " + repo.pc_count + " Quotations</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-wo-all'></i> " + repo.pcr_count + " Replies</div>" +
                "</div>" +
                "</div></div>";
        return markup;
    }
    ;
    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
    ;
    function listMessages() {
        var businessID = Number($('#' + members.business.home.create.create).attr('data-business'));
        var mem1 = members.business.message;
        $('#' + mem1.thisDiv).html(LOADER_ONE);
        $.ajax({
            url: mem1.url + '/' + businessID,
            type: mem1.type,
            async: false,
            data: {
                autoloader: mem1.autoloader,
                action: mem1.action,
                dataType: mem1.dataType,
            },
            success: function (data) {
                $('#' + mem1.thisDiv).html(data);
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
}
$(document).ready(function () {
    var this_js_script = $("script[src$='Business.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            console.log('I am In Business');
            var para = getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Deal/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).nookleads;
            var obj = new businessController();
            obj.__constructor(para);
            //obj.publicsearchBusinesss();
            obj.bindActions();
            var obj1 = new HeaderController();
            obj1.__constructor(para);
     }
        else {
            console.log('I am Out Business');
        }
    }
});