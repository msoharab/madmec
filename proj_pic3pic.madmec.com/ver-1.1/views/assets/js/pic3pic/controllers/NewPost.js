function newPostController() {
    var members = {};
    var listOfSections = {};
    var recentObjCountry = $('<select></select>');
    var recentObjlanguge = $('<select></select>');
    var postIDS = {};
    var picEditObj = {};
    var pmem = {};
    this.__constructor = function (para) {
        pmem = para;
        members = para.wall;
    };
    this.publicDisplayPost = function () {
        window.setTimeout(function () {
            DisplayPost();
        }, 200);
    };
    this.publicFilterpost = function (data) {
        var mem = members.list;
        $('#' + mem.outputDiv).html(data);
        window.setTimeout(function () {
            bindPostActions();
        }, 1500);
    };
    this.bindActions = function(){
        $('#' + members.create.parentBut).bind('click', function (evt) {
            fetchSections();
            validateCreatePostForm();
            $('#' + members.create.target).change(function () {
                if (this.value === "Country") {
                    fetchListOfContinents();
                } else {
                    $('#' + members.create.parentFild).html('');
                }
            });
            window.setTimeout(function () {
                picEditObj = $('#' + members.create.postImg).picEdit({
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
                            createPost();
                            members.create.picedit = false;
                        } else {
                            alert('Error could not post on pic3pic!!!.');
                        }
                    },
                    FormObj: $('#' + members.create.form),
                    goFlag: false,
                    picEditUpload: false,
                    redirectUrl: false,
                    defaultImage: members.create.defaultImage
                });
                $('#' + members.create.postImg).parent().css({
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
    function getUserPost(uid) {
        var postIDS = {};
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
                    postIDS = data;
                } else {
                    postIDS = $.parseJSON($.trim(data));
                }
                if (postIDS.status === 'success')
                    postIDS = postIDS.data;
                else
                    postIDS = {};
            },
            error: function () {
                $(OUTPUT).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                $('#' + mem.loader).html('');
            }
        });
        return postIDS;
    }
    ;
    function createPost() {
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
        var mem = members.list.comment.list;
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
                //$('#' + mem.parentDiv + para.postID).slideToggle('slow');
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
        var mem = members.list.comment.list.reply.list;
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
        var mem1 = members.list;
        $('.' + mem1.smiley).emoticonize({
            //delay: 800,
            //animate: false,
            //exclude: 'pre, code, .no-emoticons'
        });
        $('.' + mem1.smiley).css({
            fontSize: '42px'
        });
        //bind individual post
        $('.' + mem1.indiView.class).each(function () {
            if ($(this).hasClass(mem1.binder) === false) {
                $(this).addClass(mem1.binder).on('click', function () {
                    var uid = Number($(this).attr('name'));
                    var post_id = Number($(this).attr('data-bind'));
                    postIDS = getUserPost(Number(uid));
                    var total = Number(postIDS.length);
                    var page = 1;
                    $.each(postIDS, function (i, item) {
                        if (Number(item.id) === post_id) {
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
                            UpdateListPost({
                                post_id: postIDS[Number(page - 1)].id,
                                where: 'prepend',
                                view: members.list.indiView,
                            });
                        },
                        onPageClick: function (event, page) {
                            $('#' + mem1.indiView.outputDiv).text('Page ' + page);
                            UpdateListPost({
                                post_id: postIDS[Number(page - 1)].id,
                                where: 'prepend',
                                view: members.list.indiView,
                            });
                        },
                    });
                });
            }
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
                    console.log('pst id = ' + postID);
                    console.log('rep id = ' + postID);
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
                    cObj.val('');
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
        var mem2 = members.list.comment;
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
                        cObj.val('');
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
        var mem3 = members.list.comment.list.reply;
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
