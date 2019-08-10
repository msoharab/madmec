function channelController() {
    var submitCreate;
    var members = {};
    var listOfChannels = {};
    var listAdminChannels = {};
    var listSubscribeChannels = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    var picEditObj = {};
    this.__constructor = function (para) {
        members = para;
        submitCreate = false;
    };
    this.publicDisplayPost = function () {
        var mem1 = members.channel;
        $('#' + mem1.home.targetDiv).trigger('click');
    };
    this.publicFilterpost = function (data) {
        var mem = members.channel.home.list;
        $('#' + mem.outputDiv).html(data);
        window.setTimeout(function () {
            bindPostActions();
        }, 1500);
    };

    this.publicListChannels = function () {
        window.setTimeout(function () {
            ListChannels();
        }, 1600);
    };

    this.publicListAdminChannels = function () {
        window.setTimeout(function () {
            ListAdminChannels();
        }, 2000);
    };

    this.publicListSubscribeChannels = function () {
        window.setTimeout(function () {
            ListSubscribeChannels();
        }, 2400);
    };

    this.publicsearchChannels = function () {
        window.setTimeout(function () {
            searchChannels();
        }, 2100);
    };

    this.bindActions = function () {
        var mem1 = members.channel;
        //bind channel like
        $('#' + mem1.like.id).on('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var channelID = $(this).attr('name');
            $('#' + mem1.like.counter).html(LOADER_ONE);
            $.ajax({
                url: mem1.like.url + '/' + channelID,
                type: mem1.like.type,
                async: false,
                data: {
                    autoloader: mem1.like.autoloader,
                    action: mem1.like.action,
                    dataType: mem1.like.dataType,
                },
                success: function (data) {
                    if (typeof data === 'object') {
                        obj = data;
                    } else {
                        obj = $.parseJSON($.trim(data));
                    }
                    $('#' + mem1.like.counter).html(obj.count);
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        //bind channel dislike
        $('#' + mem1.dislike.id).on('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var channelID = $(this).attr('name');
            $('#' + mem1.dislike.counter).html(LOADER_ONE);
            $.ajax({
                url: mem1.dislike.url + '/' + channelID,
                type: mem1.dislike.type,
                async: false,
                data: {
                    autoloader: mem1.dislike.autoloader,
                    action: mem1.dislike.action,
                    dataType: mem1.dislike.dataType,
                },
                success: function (data) {
                    if (typeof data === 'object') {
                        obj = data;
                    } else {
                        obj = $.parseJSON($.trim(data));
                    }
                    $('#' + mem1.dislike.counter).html(obj.count);
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        //bind channel report
        $('.' + mem1.report.class).each(function () {
            $(this).on('click', function (evt) {
                evt.preventDefault();
                evt.stopPropagation();
                var obj = {};
                var channelID = $(this).parent().attr('name');
                var reportID = $(this).attr('name');
                $.ajax({
                    url: mem1.report.url,
                    type: mem1.report.type,
                    async: false,
                    data: {
                        autoloader: mem1.report.autoloader,
                        action: mem1.report.action,
                        dataType: mem1.report.dataType,
                        para: {channelID: channelID, reportID: reportID},
                    },
                    success: function (data) {
                        if (typeof data === 'object') {
                            obj = data;
                        } else {
                            obj = $.parseJSON($.trim(data));
                        }
                        if (obj.status === 'success') {
                            $(mem1.report.parentDiv + channelID).hide(600);
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
        //bind channel banner update
        $('#' + mem1.backgroud.parentBut).bind('click', function (evt) {
            validateChannelBGForm();
            window.setTimeout(function () {
                picEditObj = $('#' + mem1.backgroud.postImg).picEdit({
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
                            updateChannelBG();
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
                $('#' + mem1.backgroud.postImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1500);
            $('#' + mem1.backgroud.postImg).change(function () {
                mem1.backgroud.picedit = true;
            });
        });
        //bind channel icon update
        $('#' + mem1.icon.parentBut).bind('click', function (evt) {
            validateChannelIconForm();
            window.setTimeout(function () {
                picEditObj = $('#' + mem1.icon.postImg).picEdit({
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
                            updateChannelIcon();
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
                $('#' + mem1.icon.postImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1500);
            $('#' + mem1.icon.postImg).change(function () {
                mem1.icon.picedit = true;
            });
        });
        //bind channel Advertise update
        $('#' + mem1.advertisement.parentBut).bind('click', function (evt) {
            validateChannelAdvForm();
            window.setTimeout(function () {
                picEditObj = $('#' + mem1.advertisement.postImg).picEdit({
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
                            updateChannelAdv();
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
                $('#' + mem1.advertisement.postImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });
            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1500);
            $('#' + mem1.advertisement.postImg).change(function () {
                mem1.advertisement.picedit = true;
            });
        });
        //bind channel block
        $('#' + mem1.block.create).bind('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var channelID = Number($('#' + mem1.block.text).val());
            $('#' + mem1.block.counter + channelID).html(LOADER_ONE);
            $.ajax({
                url: mem1.block.url + '/' + channelID,
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
                    //$('#' + mem1.block.counter + channelID).html(obj.count);
                    window.location.href = URL + 'Wall/Index';
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        //bind channel subscribe
        $('#' + mem1.subscribe.create).bind('click', function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var obj = {};
            var channelID = Number($('#' + mem1.subscribe.text).val());
            $('#' + mem1.subscribe.counter).html(LOADER_ONE);
            $.ajax({
                url: mem1.subscribe.url + '/' + channelID,
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
                    //window.location.href = URL+'Wall/Index';
                },
                error: function () {
                    $(OUTPUT).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        });
        var mem2 = members.channel.home;
        //bind create post
        $('#' + mem2.create.parentBut).bind('click', function (evt) {
            fetchSections();
            validateCreatePostForm();
            $('#' + mem2.create.target).change(function () {
                if (this.value === "Country") {
                    fetchListOfContinents();
                } else {
                    $('#' + mem2.create.parentFild).html('');
                }
            });
            window.setTimeout(function () {
                picEditObj = $('#' + mem2.create.postImg).picEdit({
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
                            createPost();
                            mem2.create.picedit = false;
                        } else {
                            alert('Error could not post on pic3pic!!!.');
                        }
                    },
                    FormObj: $('#' + mem2.create.form),
                    goFlag: false,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: mem2.create.defaultImage
                });
                $('#' + mem2.create.postImg).parent().css({
                    paddingLeft: '15%',
                    paddingRight: '15%',
                    backgroundColor: '#C0C0C0',
                });

            }, 500);
            window.setTimeout(function () {
                picEditObj._setDefaultValues();
            }, 1000);
        });
        //bind channel post list
        $('#' + mem1.home.targetDiv).bind('click', function (evt) {
            DisplayPost();
        });
        $('#' + members.channel.about.targetDiv).bind('click', function () {
            //bind send message to admin
            var mem3 = members.channel.about.msgAJAX;
            $('#' + mem3.submit).bind('click', function (evt) {
                var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
                var message = $('#' + mem3.msg).val();
                var obj = {};
                if (message.length > 0 && message.length < 251) {
                    $.ajax({
                        url: mem3.url + '/' + channelID,
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
            var classRemove = members.channel.about.removeAdm;
            $('.' + classRemove).each(function () {
                var mem4 = members.channel.about.adminsAJAX;
                $(this).bind('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var channelID = $(this).parent().attr('name');
                    var UID = Number($(this).attr('data-uid'));
                    var obj = {};
                    $.ajax({
                        url: mem4.url + '/' + channelID,
                        type: mem4.type,
                        data: {
                            autoloader: mem4.autoloader,
                            action: mem4.action,
                            dataType: mem4.dataType,
                            details: {channelID: channelID, UserId: UID},
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

        //bind channel settings
        var mem5 = members.channel.setting;
        $('#' + mem5.targetDiv).bind('click', function (evt) {
            validateChannelSettingForm();
            fetchChannelAdmins();
        });
        //bind list messages
        var mem6 = members.channel.message;
        $('#' + mem6.targetDiv).bind('click', function () {
            listMessages();
        });
        //list channel post list
        window.setTimeout(function () {
            DisplayPost();
        }, 200);
    };

    function ListAdminChannels() {
        var mem = members.channel.listAdminChannels;
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
                    listAdminChannels = data;
                }
                else {
                    listAdminChannels = $.parseJSON($.trim(data));
                }
                if (listAdminChannels.status === "success") {
                    $('#' + mem.outputDiv).html(listAdminChannels.html);
                } else {
                    alert('Failed to retive channels.');
                }
                validateCreateChannelForm();
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
    function ListSubscribeChannels() {
        var mem = members.channel.listSubscribeChannels;
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
                    listSubscribeChannels = data;
                }
                else {
                    listSubscribeChannels = $.parseJSON($.trim(data));
                }
                if (listSubscribeChannels.status === "success") {
                    $('#' + mem.outputDiv).html(listSubscribeChannels.html);
                } else {
                    alert('Failed to retive channels.');
                }
                validateCreateChannelForm();
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
    function updateChannelDetails() {
        var mem3 = members.channel.setting;
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
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
            url: mem3.url + '/' + channelID,
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
                    alert('Channel Settings updated!!');
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
    function validateChannelSettingForm() {
        var memadd = members.channel.setting;
        var submitCreate = false;
        window.setTimeout(function () {
            var $params = {debug: false, rules: {}, messages: {}};
            //Channel name
            var field = $('#' + memadd.name).attr("name");
            $params['rules'][field] = {
                required: true,
                minlength: 4
            };
            $params['messages'][field] = {
                required: 'Enter the Channel Name',
                minlength: 'Length Should be minimum 4 Characters'
            };
            //Channel description
            var field = $('#' + memadd.description).attr("name");
            $params['rules'][field] = {
                required: true,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Channel Description',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Channel facebook
            var field = $('#' + memadd.facebook).attr("name");
            $params['rules'][field] = {
                required: false,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Facebook link',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Channel googleplus
            var field = $('#' + memadd.googleplus).attr("name");
            $params['rules'][field] = {
                required: false,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Google plus link',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Channel twitter
            var field = $('#' + memadd.twitter).attr("name");
            $params['rules'][field] = {
                required: false,
                minlength: 10
            };
            $params['messages'][field] = {
                required: 'Enter the Twitter link',
                minlength: 'Length Should be minimum 10 Characters'
            };
            //Channel website
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
                    updateChannelDetails();
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
    function updateChannelBG() {
        var mem = members.channel.backgroud;
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        var res = {};
        if (mem.picedit) {
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + channelID,
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
    function validateChannelBGForm() {
        var memadd = members.channel.backgroud;
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
        var field = $('#' + memadd.postImg).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: pic3pic.imgTypes
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
    function updateChannelIcon() {
        var mem = members.channel.icon;
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        var res = {};
        if (mem.picedit) {
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + channelID,
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
    function validateChannelIconForm() {
        var memadd = members.channel.icon;
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
        var field = $('#' + memadd.postImg).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: pic3pic.imgTypes
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
    function updateChannelAdv() {
        var mem = members.channel.advertisement;
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        var res = {};
        if (mem.picedit) {
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + channelID,
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
    function validateChannelAdvForm() {
        var memadd = members.channel.advertisement;
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
        var field = $('#' + memadd.postImg).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: pic3pic.imgTypes
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
    function createChannel() {
        var mem = members.channel.create;
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
                        alert("Channel has been Successfully Created");
                        submitCreate = false;
                        ListChannels();
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
    function ListChannels() {
        var mem = members.channel.list;
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
                    listOfChannels = data;
                }
                else {
                    listOfChannels = $.parseJSON($.trim(data));
                }
                if (listOfChannels.status === "success") {
                    $('#' + mem.outputDiv).html(listOfChannels.html);
                } else {
                    alert('Failed to retive channels.');
                }
                validateCreateChannelForm();
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
    function validateCreateChannelForm() {
        var memadd = members.channel.create;
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
                required: 'Enter the Channel Name',
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
                    createChannel(submitCreate);
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
    function createPost() {
        var mem = members.channel.home.create;
        var countries = [];
        var languages = [];
        $('#' + mem.country + ' :selected').each(function (i, selected) {
            countries[i] = $(selected).val();
        });
        $('#' + mem.language + ' :selected').each(function (i, selected) {
            languages[i] = $(selected).val();
        });
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        var allVals = [];
        /*
         $('#PoSections :checked').each(function () {
         allVals.push($(this).val());
         });
         */
        allVals.push($('#' + members.channel.home.sections.id).val());
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
            channelID: $('#' + mem.channelID).val(),
        };
        var res = {};
        if (attr) {
            $(recentObjCountry).remove();
            $(recentObjlanguge).remove();
            $('#' + mem.create).prop('disabled', 'disabled');
            $.ajax({
                url: mem.url + '/' + channelID,
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
                        alert("Your image Successfully Posted");
                        mem.picedit = false;
                        mem.ajaxForm = false;
                        $('#closePost').trigger('click');
                        window.setTimeout(function () {
                            UpdateListPost({
                                post_id: res.post_id,
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
    function DisplayPost() {
        var mem = members.channel.home.list;
        $('#' + mem.outputDiv).html(LOADER_ONE);
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        $.ajax({
            url: mem.url + '/' + channelID,
            type: mem.type,
            data: {
                autoloader: mem.autoloader,
                action: mem.action,
                dataType: mem.dataType,
            },
            success: function (data) {
                $('#' + mem.outputDiv).html(data);
                window.setTimeout(function () {
                    bindPostActions();
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
                UpdateListPost({
                    post_id: null,
                    where: 'append',
                });
                return;
            } else {
                $('#' + mem.loader).html('');
            }
        });
    }
    ;
    function UpdateListPost(para) {
        var mem = members.channel.home.list;
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        $('#' + mem.loader).html(LOADER_ONE);
        $.ajax({
            url: mem.url1 + '/' + channelID,
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
                    bindPostActions();
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
    function DisplayPostComment(para) {
        var mem = members.channel.home.list.comment.list;
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
                $('#' + mem.outputDiv + para.postID).html(data);
//                $('#' + mem.parentDiv + para.postID).slideToggle('slow');
                $('#' + mem.parentDiv + para.postID).css({
                    display: 'block'
                });
                window.setTimeout(function () {
                    bindPostCommentActions();
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
    function DisplayPostCommentReply(para) {
        var mem = members.channel.home.list.comment.list.reply.list;
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
                $('#' + mem.outputDiv + para.postComID).html(data);
                //$('#' + mem.parentDiv + para.postComID).slideToggle('slow');
                $('#' + mem.parentDiv + para.postComID).css({
                    display: 'block'
                });
                window.setTimeout(function () {
                    bindPostCommentReplyActions();
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
    function bindPostActions() {
        var mem1 = members.channel.home.list;
        $('.' + mem1.smiley).emoticonize({
            //delay: 800,
            //animate: false,
            //exclude: 'pre, code, .no-emoticons'
        });
        $('.' + mem1.smiley).css({
            fontSize: '42px'
        });
        //bind post like
        $('.' + mem1.like.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postID = $(this).attr('name');
                    $('#' + mem1.like.counter + postID).html(LOADER_ONE);
                    $.ajax({
                        url: mem1.like.url + '/' + postID,
                        type: mem1.like.type,
                        async: false,
                        data: {
                            autoloader: mem1.like.autoloader,
                            action: mem1.like.action,
                            dataType: mem1.like.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem1.like.counter + postID).html(obj.count);
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
        //bind post dislike
        $('.' + mem1.dislike.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postID = $(this).attr('name');
                    $('#' + mem1.dislike.counter + postID).html(LOADER_ONE);
                    $.ajax({
                        url: mem1.dislike.url + '/' + postID,
                        type: mem1.dislike.type,
                        async: false,
                        data: {
                            autoloader: mem1.dislike.autoloader,
                            action: mem1.dislike.action,
                            dataType: mem1.dislike.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem1.dislike.counter + postID).html(obj.count);
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
        //bind post preferences
        $('.' + mem1.pref.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postID = $(this).parent().attr('name');
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
                            para: {postID: postID, prefID: prefID, action: action},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            switch (action) {
                                case 'hide':
                                    $('#' + mem1.postDiv + postID).hide(300);
                                    break;
                                case 'delete':
                                    $('#' + mem1.postDiv + postID).remove();
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
        //bind post report
        $('.' + mem1.report.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postID = $(this).parent().attr('name');
                    var reportID = $(this).attr('name');
                    $.ajax({
                        url: mem1.report.url,
                        type: mem1.report.type,
                        async: false,
                        data: {
                            autoloader: mem1.report.autoloader,
                            action: mem1.report.action,
                            dataType: mem1.report.dataType,
                            para: {postID: postID, reportID: reportID},
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
        //bind post subscription
        $('.' + mem1.subscription.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var channelID = $(this).parent().attr('name');
                    $.ajax({
                        url: mem1.subscription.url + '/' + channelID,
                        type: mem1.subscription.type,
                        async: false,
                        data: {
                            autoloader: mem1.subscription.autoloader,
                            action: mem1.subscription.action,
                            dataType: mem1.subscription.dataType,
                            para: {channelID: channelID},
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
        var mem2 = mem1.comment;
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
                //bind smilies for comment
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var smiley = $(this).text();
                    var postID = $(this).parent().attr('name');
                    var obj = $('#' + postID);
                    var val = obj.val();
                    obj.val(val + ' ' + smiley + ' ');
                });
            }
        });
        //bind comment div expander
        $('.' + mem2.expandClass).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var postID = $(this).attr('name');
                    var pindex = $(this).data().bind;
                    if ($('#' + mem2.list.parentDiv + postID).css('display') !== 'block') {
                        DisplayPostComment({
                            pindex: pindex,
                            postID: postID
                        });
                    } else {
                        $('#' + mem2.list.parentDiv + postID).css({
                            display: 'none'
                        });
                    }
                });
            }
        });
        //bind commentBOX
        $('.' + mem2.commentBOX.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postID = $(this).attr('name');
                    var cObj = $('#' + mem2.commentBOX.id + postID);
                    var comment = $.trim(cObj.val());
                    if (comment) {
                        cObj.attr('disable', 'disable');
                        $.ajax({
                            url: mem2.commentBOX.url,
                            type: mem2.commentBOX.type,
                            async: false,
                            data: {
                                autoloader: mem2.commentBOX.autoloader,
                                action: mem2.commentBOX.action,
                                dataType: mem2.commentBOX.dataType,
                                postID: postID,
                                comment: encodeURIComponent(comment),
                            },
                            success: function (data) {
                                if (typeof data === 'object') {
                                    obj = data;
                                }
                                else {
                                    obj = $.parseJSON($.trim(data));
                                }
                                $('#' + mem2.counter + postID).html(obj.count);
                                window.setTimeout(function () {
                                    DisplayPostComment({pindex: null, pcindex: null, postID: postID});
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
                    var postID = $(this).attr('name');
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
                                var comment = $('#' + mem2.camera.text).val();
                                if (typeof data === 'object') {
                                    res = data;
                                } else {
                                    res = $.parseJSON($.trim(data));
                                }
                                if (res.readyState && comment) {
                                    cObj.attr('disable', 'disable');
                                    $.ajax({
                                        url: mem2.camera.url,
                                        type: mem2.camera.type,
                                        async: false,
                                        data: {
                                            autoloader: mem2.camera.autoloader,
                                            action: mem2.camera.action,
                                            dataType: mem2.camera.dataType,
                                            postID: postID,
                                            comment: encodeURIComponent(comment),
                                        },
                                        success: function (data) {
                                            if (typeof data === 'object') {
                                                obj = data;
                                            }
                                            else {
                                                obj = $.parseJSON($.trim(data));
                                            }
                                            $('#' + mem2.counter + postID).html(obj.count);
                                            mem2.camera.picedit = false;
                                            $('#' + mem2.camera.close).click(function () {
                                                DisplayPostComment({pindex: null, pcindex: null, postID: postID});
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
                                    alert('Error could not comment on post!!!.');
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
                        validateCreateCommentForm(picEditObj);
                    }, 700);
                    window.setTimeout(function () {
                        picEditObj._setDefaultValues();
                    }, 1000);
                });
            }
        });
    }
    ;
    function bindPostCommentActions() {
        var mem2 = members.channel.home.list.comment;
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
        //bind post commet like
        $('.' + mem2.list.like.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postComID = $(this).attr('name');
                    $('#' + mem2.list.like.counter + postComID).html(LOADER_ONE);
                    $.ajax({
                        url: mem2.list.like.url + '/' + postComID,
                        type: mem2.list.like.type,
                        async: false,
                        data: {
                            autoloader: mem2.list.like.autoloader,
                            action: mem2.list.like.action,
                            dataType: mem2.list.like.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem2.list.like.counter + postComID).html(obj.count);
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
        //bind post comment dislike
        $('.' + mem2.list.dislike.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postComID = $(this).attr('name');
                    $('#' + mem2.list.dislike.counter + postComID).html(LOADER_ONE);
                    $.ajax({
                        url: mem2.list.dislike.url + '/' + postComID,
                        type: mem2.list.dislike.type,
                        async: false,
                        data: {
                            autoloader: mem2.list.dislike.autoloader,
                            action: mem2.list.dislike.action,
                            dataType: mem2.list.dislike.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem2.list.dislike.counter + postComID).html(obj.count);
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
        //bind post comment preferences
        $('.' + mem2.list.pref.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).addClass(mem2.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postID = $(this).parent().attr('name');
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
                            para: {postID: postID, prefID: prefID, action: action},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            switch (action) {
                                case 'hide':
                                    $('#' + mem2.list.postDiv + postID).hide(300);
                                    break;
                                case 'delete':
                                    $('#' + mem2.list.postDiv + postID).remove();
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
        var mem3 = mem2.list.reply;
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
                //bind smilies for reply
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var smiley = $(this).text();
                    var postComID = $(this).parent().attr('name');
                    var obj = $('#' + postComID);
                    var val = obj.val();
                    obj.val(val + ' ' + smiley + ' ');
                });
            }
        });
        //bind reply div expander
        $('.' + mem3.expandClass).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var postComID = $(this).attr('name');
                    var pindex = $(this).parent().data().bind;
                    var pcindex = $(this).data().bind;
                    if ($('#' + mem3.list.parentDiv + postComID).css('display') !== 'block') {
                        DisplayPostCommentReply({
                            pindex: pindex,
                            pcindex: pcindex,
                            postComID: postComID
                        });
                    } else {
                        $('#' + mem3.list.parentDiv + postComID).css({
                            display: 'none'
                        });
                    }
                });
            }
        });
        //bind replyBOX
        $('.' + mem3.replyBOX.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                if ($(this).hasClass(mem3.list.binder) === false) {
                    $(this).addClass(mem3.list.binder).on('click', function (evt) {
                        evt.preventDefault();
                        evt.stopPropagation();
                        var obj = {};
                        var postComID = $(this).attr('name');
                        var cObj = $('#' + mem3.replyBOX.id + postComID);
                        var reply = $.trim(cObj.val());
                        if (reply) {
                            cObj.attr('disable', 'disable');
                            $.ajax({
                                url: mem3.replyBOX.url,
                                type: mem3.replyBOX.type,
                                async: false,
                                data: {
                                    autoloader: mem3.replyBOX.autoloader,
                                    action: mem3.replyBOX.action,
                                    dataType: mem3.replyBOX.dataType,
                                    postComID: postComID,
                                    reply: encodeURIComponent(reply),
                                },
                                success: function (data) {
                                    if (typeof data === 'object') {
                                        obj = data;
                                    } else {
                                        obj = $.parseJSON($.trim(data));
                                    }
                                    $('#' + mem3.counter + postComID).html(obj.count);
                                    window.setTimeout(function () {
                                        DisplayPostCommentReply({
                                            pindex: null,
                                            pcindex: null,
                                            postComID: postComID
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
                    var postComID = $(this).attr('name');
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
                                var reply = $('#' + mem3.camera.text).val();
                                if (typeof data === 'object') {
                                    res = data;
                                } else {
                                    res = $.parseJSON($.trim(data));
                                }
                                if (res.readyState && reply) {
                                    cObj.attr('disable', 'disable');
                                    $.ajax({
                                        url: mem3.camera.url,
                                        type: mem3.camera.type,
                                        async: false,
                                        data: {
                                            autoloader: mem3.camera.autoloader,
                                            action: mem3.camera.action,
                                            dataType: mem3.camera.dataType,
                                            postComID: postComID,
                                            reply: encodeURIComponent(reply),
                                        },
                                        success: function (data) {
                                            if (typeof data === 'object') {
                                                obj = data;
                                            }
                                            else {
                                                obj = $.parseJSON($.trim(data));
                                            }
                                            $('#' + mem3.counter + postComID).html(obj.count);
                                            mem3.camera.picedit = false;
                                            $('#' + mem3.camera.close).click(function () {
                                                DisplayPostCommentReply({
                                                    pindex: null,
                                                    pcindex: null,
                                                    postComID: postComID
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
                                    alert('Error could not comment on post!!!.');
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
                        validateCreateCommentReplyForm(picEditObj);
                    }, 700);
                    window.setTimeout(function () {
                        picEditObj._setDefaultValues();
                    }, 1200);
                });
            }
        });
    }
    ;
    function bindPostCommentReplyActions() {
        var mem3 = members.channel.home.list.comment.list.reply;
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
        //bind post commet reply like
        $('.' + mem3.list.like.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postComRepID = $(this).attr('name');
                    $('#' + mem3.list.like.counter + postComRepID).html(LOADER_ONE);
                    $.ajax({
                        url: mem3.list.like.url + '/' + postComRepID,
                        type: mem3.list.like.type,
                        async: false,
                        data: {
                            autoloader: mem3.list.like.autoloader,
                            action: mem3.list.like.action,
                            dataType: mem3.list.like.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem3.list.like.counter + postComRepID).html(obj.count);
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
        //bind post comment reply list.dislike
        $('.' + mem3.list.dislike.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postComRepID = $(this).attr('name');
                    $('#' + mem3.list.dislike.counter + postComRepID).html(LOADER_ONE);
                    $.ajax({
                        url: mem3.list.dislike.url + '/' + postComRepID,
                        type: mem3.list.dislike.type,
                        async: false,
                        data: {
                            autoloader: mem3.list.dislike.autoloader,
                            action: mem3.list.dislike.action,
                            dataType: mem3.list.dislike.dataType,
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            $('#' + mem3.list.dislike.counter + postComRepID).html(obj.count);
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
        //bind post preferences
        $('.' + mem3.list.pref.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).addClass(mem3.list.binder).on('click', function (evt) {
                    evt.preventDefault();
                    evt.stopPropagation();
                    var obj = {};
                    var postID = $(this).parent().attr('name');
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
                            para: {postID: postID, prefID: prefID, action: action},
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                obj = data;
                            } else {
                                obj = $.parseJSON($.trim(data));
                            }
                            switch (action) {
                                case 'hide':
                                    $('#' + mem3.list.postDiv + postID).hide(300);
                                    break;
                                case 'delete':
                                    $('#' + mem3.list.postDiv + postID).remove();
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
    function validateCreatePostForm() {
        var memadd = members.channel.home.create;
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
        var field = $('#' + memadd.postImg).attr("name");
        $params['rules'][field] = {
            required: true,
            accept: pic3pic.imgTypes
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
    function validateCreateCommentForm(picEditObj) {
        var memadd = members.list.comment;
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
            accept: pic3pic.imgTypes
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
            required: 'Enter the comment',
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
    function validateCreateCommentReplyForm(picEditObj) {
        var memadd = members.list.comment.list.reply;
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
            accept: pic3pic.imgTypes
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
            required: 'Enter the reply',
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
        var mem = members.channel.home.sections;
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
        var memadd = members.channel.create;
        var mem = members.channel.create.continents;
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
        var memadd = members.channel.create;
        var mem = members.channel.create.countries;
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
        var memadd = members.channel.create;
        var mem = members.channel.create.languages;
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
    function fetchChannelAdmins() {
        var mem = members.channel.setting.adminsAJAX;
        var sel = members.channel.setting.admins;
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        $('#' + sel).select2({
            ajax: {
                url: mem.url + '/' + channelID,
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
            var sel2 = members.channel.setting.sel2;
            $(sel2).css({width: '100%'});
        }, 600);
    }
    ;
    function searchChannels() {
        var mem = members.header.channelSearch.adminsAJAX;
        var sel = members.header.channelSearch.admins;
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
            placeholder: "Search channels",
            allowClear: true,
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection,
            width: 'resolve',
        });
        window.setTimeout(function () {
            var sel2 = members.header.channelSearch.sel2;
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
                "<div class='select2-result-repository__forks'><i class='fa fa-tv'></i> " + repo.ch_count + " Channels</div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.p_count + " Posts</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-comments'></i> " + repo.pc_count + " Comments</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-reply-all'></i> " + repo.pcr_count + " Replies</div>" +
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
        var channelID = Number($('#' + members.channel.home.create.create).attr('data-channel'));
        var mem1 = members.channel.message;
        $('#' + mem1.thisDiv).html(LOADER_ONE);
        $.ajax({
            url: mem1.url + '/' + channelID,
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
    var this_js_script = $("script[src$='Channel.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            console.log('I am In Channel');
            var para = getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Wall/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).pic3pic;
            var obj = new channelController();
            obj.__constructor(para);
            //obj.publicsearchChannels();
            obj.bindActions();
            var obj1 = new HeaderController();
            obj1.__constructor(para);
     }
        else {
            console.log('I am Out Channel');
        }
    }
});