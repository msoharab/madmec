function catchHit() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
        updateTraffic();
    };
    function updateTraffic() {
        var traffic = members.traffic;
        var obj = {};
        $.ajax({
            url: traffic.url,
            type: 'POST',
            data: {
                autoloader: traffic.autoloader,
                action: traffic.action
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                switch (obj.status) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        $(members.outputDiv).html('<center><h1>Welcome To nOOkleads</h1></center>');
                        break;
                }
            },
            error: function (xhr, textStatus) {
                $(members.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    }
    ;
}
function signIn() {
    var members = {
        signIn: '',
        singUp: '',
        list: '',
        outputDiv: '',
        className: '',
        currDiv: '',
        response: ''
    };
    this.__constructor = function (para) {
        members.signIn = para.signIn;
        members.outputDiv = para.outputDiv;
        initializePage();
    };
    function initializePage() {
        clearSingInForm();
        initializeSingIn();
    }
    ;
    function clearSingInForm() {
        var signIn = members.signIn;
        $(signIn.uname).removeAttr('disabled').val('');
        $(signIn.password).removeAttr('disabled').val('');
        $(signIn.botton).removeAttr('disabled');
    }
    ;
    function initializeSingIn() {
        var flag = false;
        var signIn = members.signIn;
        signIn.display = true;
        $(signIn.uname).change(function () {
            if ($(signIn.uname).val().match(email_reg)) {
                flag = true;
                $(signIn.unmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(signIn.unmsg).html(INVALIDNOT);
            }
        });
        $(signIn.password).change(function () {
            if ($(signIn.password).val().match(pass_reg)) {
                $(signIn.pmsg).html(VALIDNOT);
                flag = true;
            } else {
                flag = false;
                $(signIn.pmsg).html(INVALIDNOT);
            }
        });
        $(signIn.password).keypress(function (e) {
            if (flag) {
                if (e.keyCode == 13) {
                    $(signIn.botton).click();
                }
            }
        });
        $(signIn.botton).on('click', function () {
            if (flag) {
                $(signIn.outputDiv).html(LOADER_ONE);
                $(signIn.uname).attr('disabled', 'disabled');
                $(signIn.password).attr('disabled', 'disabled');
                $(signIn.botton).attr('disabled', 'disabled');
                var obj = {};
                $.ajax({
                    url: signIn.url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        autoloader: true,
                        action: signIn.action,
                        user_name: $(signIn.uname).val(),
                        password: $(signIn.password).val(),
                        browser: members.browser
                    },
                    success: function (data, textStatus, xhr) {
                        if (typeof data === 'object') {
                            obj = data;
                        }
                        else {
                            obj = $.parseJSON($.trim(data));
                        }
                        switch (obj.status) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            case 'success':
                                $(signIn.unmsg).html(VALIDNOT);
                                $(signIn.pmsg).html(VALIDNOT);
                                $(signIn.outputDiv).html('<strong class="text-success">Login successfull !!!</strong>');
                                window.setTimeout(function () {
                                    window.location.href = URL + LAND_PAGE;
                                }, 500);
                                break;
                            case 'password':
                                $(signIn.unmsg).html(INVALIDNOT);
                                $(signIn.pmsg).html(signIn.lables.password);
                                $(signIn.pmsg).html(INVALIDNOT);
                                $(signIn.outputDiv).html('<strong class="text-success">Wrong password !!!</strong>');
                                $(signIn.password).removeAttr('disabled', 'disabled');
                                $(signIn.outputDiv).html(LOGN_ERROR);
                                $(signIn.botton).removeAttr('disabled');
                                break;
                            case 'error':
                                $(signIn.unmsg).html(signIn.lables.uname);
                                $(signIn.pmsg).html(signIn.lables.password);
                                $(signIn.outputDiv).html(LOGN_ERROR);
                                clearSingInForm();
                                break;
                        }
                    },
                    error: function (data) {
                        $(members.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr);
                        clearSingInForm();
                        console.log(textStatus);
                        console.log(xhr.status);
                    }
                });
            }
        });
    }
    ;
}
function forgotPassword() {
    var members = {};
    this.__constructor = function (para) {
        console.log(para);
        members.signIn = para.forgot;
        members.outputDiv = para.outputDiv;
        initializePage();
    };
    function initializePage() {
        clearSingInForm();
        initializeSingIn();
    }
    ;
    function clearSingInForm() {
        var signIn = members.signIn;
        $(signIn.uname).removeAttr('disabled').val('');
        $(signIn.botton).removeAttr('disabled');
    }
    ;
    function initializeSingIn() {
        var flag = false;
        var signIn = members.signIn;
        console.log(signIn);
        signIn.display = true;
        $(signIn.uname).change(function () {
            if ($(signIn.uname).val().match(email_reg)) {
                flag = true;
                $(signIn.unmsg).html(VALIDNOT);
            } else {
                flag = false;
                $(signIn.unmsg).html(INVALIDNOT);
            }
        });
        $(signIn.uname).keypress(function (e) {
            if (flag) {
                if (e.keyCode == 13) {
                    $(signIn.botton).click();
                }
            }
        });
        $(signIn.botton).on('click', function () {
            console.log(signIn);
            if (flag) {
                $(signIn.outputDiv).html(LOADER_ONE);
                $(signIn.uname).attr('disabled', 'disabled');
                $(signIn.botton).attr('disabled', 'disabled');
                var obj = {};
                $.ajax({
                    url: signIn.url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        autoloader: true,
                        action: signIn.action,
                        user_name: $(signIn.uname).val(),
                        browser: members.browser
                    },
                    success: function (data, textStatus, xhr) {
                        if (typeof data === 'object') {
                            obj = data;
                        }
                        else {
                            obj = $.parseJSON($.trim(data));
                        }
                        switch (obj.status) {
                            case 'logout':
                                logoutAdmin({});
                                break;
                            case 'login':
                                loginAdmin({});
                                break;
                            case 'success':
                                $(signIn.unmsg).html(VALIDNOT);
                                $(signIn.outputDiv).html('<strong class="text-success">'+obj.msg+'</strong>');
                                break;
                            case 'error':
                                $(signIn.unmsg).html(signIn.lables.uname);
                                $(signIn.outputDiv).html('<strong class="text-success">'+obj.msg+'</strong>');
                                clearSingInForm();
                                break;
                        }
                    },
                    error: function (data) {
                        $(members.outputDiv).html(INET_ERROR);
                    },
                    complete: function (xhr, textStatus) {
                        console.log(xhr);
                        clearSingInForm();
                        console.log(textStatus);
                        console.log(xhr.status);
                    }
                });
            }
        });
    }
    ;
}
function cutomerRegister() {
    var members = {};
    var checkusr = 0;
    var flag = false;
    this.__constructor = function (para) {
        members = para;
        bindEvents();
    };
    function bindEvents() {
        var register = members.register;
        $(register.name).change(function () {
            if (this.value.replace(/  +/g, ' ').match(nm_reg)) {
                $(register.namemsg).html(VALIDNOT);
            }
            else {
                $(register.namemsg).html(INVALIDNOT);
                flag = false;
            }
        });
        $(register.email).change(function () {
            if (this.value.match(email_reg)) {
                $(register.emailmsg).html(VALIDNOT);
                checkEmail(this.value);
            }
            else {
                checkusr = 0;
                $(register.emailmsg).html(INVALIDNOT);
                flag = false;
            }
        });
        $(register.email).mouseup(function () {
            if (this.value.match(email_reg)) {
                $(register.emailmsg).html(VALIDNOT);
                checkEmail(this.value);
            }
            else {
                checkusr = 0;
                $(register.emailmsg).html(INVALIDNOT);
                flag = false;
            }
        });
        $(register.pass1).keyup(function () {
            if (this.value.length < 6) {
                $(register.pass1msg).html(INVALIDNOT);
                flag = false;
            } else {
                $(register.pass1msg).html(VALIDNOT);
                flag = true;
            }
        });
        $(register.pass2).keyup(function () {
            var pass1 = $(register.pass1).val();
            var pass2 = $(register.pass2).val();
            if (pass1 !== pass2 || this.value.length < 6) {
                $(register.pass2msg).html(INVALIDNOT);
                flag = false;
            } else {
                $(register.pass2msg).html(VALIDNOT);
                flag = true;
            }
        });
        $(register.botton).click(function () {
            subimtForm();
        });
    }
    ;
    function checkEmail(email) {
        var register = members.register;
        var checkemail = members.register.checkemail;
        var obj = {};
        $.ajax({
            url: checkemail.url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                autoloader: checkemail.autoloader,
                action: checkemail.action,
                email: email
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (Number(obj.count) > 0 && obj.status === 'success') {
                    checkusr = 0;
                    $(register.emailmsg).html(INVALIDNOT);
                    $(register.outputDiv).html('<span class="text-danger"><strong>Email Id Already Exist</strong></span>');
                    flag = false;
                } else {
                    checkusr = 1;
                    $(register.emailmsg).html(VALIDNOT);
                    flag = true;
                }
            },
            error: function (xhr, textStatus) {
                $(checkemail.outputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    ;
    function subimtForm() {
        var register = members.register;
        $(register.outputDiv).html(LOADER_ONE);
        var attr = validateRegisterForm();
        var obj = {};
        if (flag && attr && checkusr) {
            $(register.name).attr('disabled', 'disabled');
            $(register.email).attr('disabled', 'disabled');
            $(register.pass1).attr('disabled', 'disabled');
            $(register.pass2).attr('disabled', 'disabled');
            $(register.gender).attr('disabled', 'disabled');
            $(register.botton).attr('disabled', 'disabled');
            $.ajax({
                url: register.url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    autoloader: register.autoloader,
                    action: register.action,
                    details: attr
                },
                success: function (data, textStatus, xhr) {
                    if (typeof data === 'object') {
                        obj = data;
                    }
                    else {
                        obj = $.parseJSON($.trim(data));
                    }
                    switch (obj.status) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        case 'success':
                            $(register.outputDiv).html('<span class="text-success"><strong>Registration has been Successfully Completed.</strong></span>');
                            clearRegisterForm();
                            window.setTimeout(function () {
                                window.location.href = URL + LAND_PAGE;
                            }, 800);
                            break;
                        case 'alreadyexist':
                            $(register.email).removeAttr('disabled').val('');
                            $(register.emailmsg).html(register.lables.email);
                            $(register.botton).removeAttr('disabled');
                            $(register.outputDiv).html('<span class="text-danger"><strong>Email Id Already Exist</strong></span>');
                            break;
                        case 'error':
                            $(register.outputDiv).html('<span class="text-success"><strong>Registration hasn\'t been Completed, Please try After Sometime');
                            clearRegisterForm();
                            break;
                    }
                },
                error: function (xhr, textStatus) {
                    $(register.outputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        }
    }
    function validateRegisterForm() {
        var register = members.register;
        if ($(register.name).val().match(nm_reg)) {
            $(register.namemsg).html(VALIDNOT);
            flag = true;
        } else {
            flag = false;
            $(register.name).focus();
            $(register.namemsg).html(INVALIDNOT);
            return;
        }
        if ($(register.email).val().match(email_reg)) {
            $(register.emailmsg).html(VALIDNOT);
            checkusr = 1;
            flag = true;
        } else {
            checkusr = 0;
            flag = false;
            $(register.email).focus();
            $(register.emailmsg).html(INVALIDNOT);
            return;
        }
        if ($(register.pass1).val().length > 5) {
            $(register.pass1msg).html(VALIDNOT);
            flag = true;
        } else {
            flag = false;
            $(register.pass1).focus();
            $(register.pass1msg).html(INVALIDNOT);
            return;
        }
        if ($(register.pass2).val().length > 5 && $(register.pass1).val() === $(register.pass2).val()) {
            $(register.pass1msg).html(VALIDNOT);
            flag = true;
        } else {
            flag = false;
            $(register.pass2).focus();
            $(register.pass2msg).html(INVALIDNOT);
            return;
        }
        if ($(register.gender).prop('checked')) {
            $(register.gendermsg).html(VALIDNOT);
            flag = true;
        } else {
            flag = false;
            $(register.gender).focus();
            $(register.gendermsg).html(INVALIDNOT);
            return;
        }
        if (flag) {
            $(register.pass2).keypress(function (e) {
                if (flag) {
                    if (e.keyCode == 13) {
                        $(register.botton).click();
                    }
                }
            });
            return {
                name: $(register.name).val(),
                email: $(register.email).val(),
                mobile: $(register.mobile).val(),
                gender: null,
                pass: $(register.pass2).val()
            };
        } else {
            clearRegisterForm();
        }
    }
    ;
    function clearRegisterForm() {
        var register = members.register;
        $(register.name).removeAttr('disabled').val('');
        $(register.email).removeAttr('disabled').val('');
        $(register.gender).removeAttr('disabled').val('');
        $(register.pass1).removeAttr('disabled').val('');
        $(register.pass2).removeAttr('disabled').val('');
        $(register.botton).removeAttr('disabled');
        $(register.namemsg).html(register.lables.name);
        $(register.emailmsg).html(register.lables.email);
        $(register.gendermsg).html(register.lables.gender);
        $(register.pass1msg).html(register.lables.pass1);
        $(register.pass2msg).html(register.lables.pass2);
    }
    ;
}
function indexLeadController() {
    var members = {};
    this.__constructor = function (para) {
        members = para.index;
    };
    this.publicDisplayLead = function () {
        DisplayLead();
    };
    this.publicFilterlead = function (data) {
        var mem = members.list;
        $('#' + mem.outputDiv).html(data);
        window.setTimeout(function () {
            bindLeadActions();
        }, 800);
    };
    function DisplayLead() {
        var mem = members.list;
        $('#' + mem.outputDiv).html(LOADER_ONE);
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
                    where: null,
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
        $('#' + mem.loader).html(LOADER_ONE);
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
        var mem2 = mem1.quotation;
        $('.' + mem2.smiley.class).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).emoticonize({
                    //delay: 800,
                    //animate: false,
                    //exclude: 'pre, code, .no-emoticons'
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
    }
    ;
    function bindLeadQuotationActions() {
        var mem2 = members.list.quotation;
        $('.' + mem2.list.content).each(function () {
            if ($(this).hasClass(mem2.list.binder) === false) {
                $(this).emoticonize({
                    //delay: 800,
                    //animate: false,
                    //exclude: 'pre, code, .no-emoticons'
                });
            }
        });
        var mem3 = mem2.list.wo;
        $('.' + mem3.smiley.class).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
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
    }
    ;
    function bindLeadQuotationWoActions() {
        var mem3 = members.list.quotation.list.wo;
        $('.' + mem3.list.content).each(function () {
            if ($(this).hasClass(mem3.list.binder) === false) {
                $(this).emoticonize({
                    //delay: 800,
                    //animate: false,
                    //exclude: 'pre, code, .no-emoticons'
                });
            }
        });
    }
    ;
}
function faceBook() {
    var members = {};
    var index = {};
    var fbAPI = {};
    var fbJSON = {};
    this.__constructor = function (para) {
        members = para;
        index = members.index;
        fbJSON = index.facebook;
        loadFBSDK(fbJSON);
    };
    function loadFBSDK() {
        fbAPI = FB;
        window.setTimeout(function () {
            intializeFBSDK();
        }, 1000);
    }
    ;
    function intializeFBSDK() {
        fbAPI.init({
            appId: '457733354427936',
            cookie: true,
            xfbml: true,
            version: 'v2.5'
        });
        window.setTimeout(function () {
            fbAPI.getLoginStatus(function (response) {
                statusChangeCallback(response);
            });
            logintoFB();
        }, 1000);
    }
    ;
    function chekLoginStatus() {
        fbAPI.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    }
    ;
    function statusChangeCallback(response) {
        switch (response.status) {
            case 'connected':
                callAPI();
                break;
            case 'not_authorized':
                alert('Please Login to nOOkleads !!!');
                window.setTimeout(function () {
                    chekLoginStatus();
                }, 800);
                break;
            case 'unknown':
                alert('Please Login to Facebook !!!');
                window.setTimeout(function () {
                    chekLoginStatus();
                }, 1200);
                break;
        }
    }
    ;
    function callAPI() {
        fbAPI.api('/me', function (response) {
            members.response = response;
            logintoApp();
        });
    }
    ;
    function logintoFB() {
        fbAPI.login(function (response) {
        }, {
            scope: 'public_profile,' +
                    'email,' +
                    'name,' +
                    'read_friendlists'
        });
    }
    ;
    function logintoApp() {
        // var res = members.response;
        /* id */
        /* email */
        /* name */
        /* first_name */
        /* last_name */
        /* gender */
        /* birthday 12/09/1988 */
        /* locale fb language */
        /* fb link */
        /* timezone */
        /* updated_time UTC */
        /* bio */
        /* verified */
        /* website */
        /* hometown {id:,name:}*/
        /* location {id:,name:}*/
        /* favorite_athletes array[].{id:,name:} */
        /* favorite_teams array[].{id:,name:} */
        /* inspirational_people array[].{id:,name:} */
        /* languages array[].{id:,name:} */
        /* sports array[].{id:,name:} */
//        scope: 'public_profile,'+
//                'email,'+
//                'name,'+
//                'user_friends,'+
//                'user_about_me,'+
//                'user_activities,'+
//                'user_birthday,'+
//                'user_groups,'+
//                'user_hometown,'+
//                'user_interests,'+
//                'user_approvals,'+
//                'user_location,'+
//                'user_photos,'+
//                'user_website,'+
//                'read_friendlists'
    }
}
function googlePlus() {
}
$(document).ready(function () {
    var Index = {
        lead: {},
        popular: {},
        new : {},
        section: {},
        country: {},
        languages: {},
        help: {},
        facbook: {},
        twitter: {},
        instagram: {},
        signIn: {
            autoloader: true,
            action: 'signIn',
            parentDiv: '#login',
            parentBut: '#loginBut',
            form: '#signinform',
            uname: '#recipient-name',
            unmsg: '#user_name_msg',
            password: '#message-text',
            pmsg: '#pass_msg',
            fbotton: '#facebookLogBut',
            gbotton: '#googleLogBut',
            rbotton: '#registerLogBut',
            close: '#loginCloseBut',
            botton: '#getIn',
            outputDiv: '#outputLogRes',
            url: URL + 'Login/signIn',
            display: false,
            lables: {
                uname: 'Email-Id / Username:',
                password: 'Password:'
            }
        },
        register: {
            autoloader: true,
            action: 'Register',
            parentDiv: '#register',
            form: '#custregform',
            name: '#recipient-name1',
            namemsg: '#cust_nmmsg',
            email: '#recipient-email',
            emailmsg: '#emmsg',
            pass1: '#recipientpass1',
            pass1msg: '#passmsgmsg',
            pass2: '#recipientpass2',
            pass2msg: '#cpassmsgmsg',
            gender: '#human',
            gendermsg: '#engmsg',
            lbotton: '#old-receipent',
            rfbotton: '#rfacebookBut',
            rgbotton: '#rgoogleBut',
            close: '#regCloseBut',
            botton: '#registerInBut',
            outputDiv: '#RegisterOutput',
            url: URL + 'Register/signUp',
            display: false,
            checkemail: {
                autoloader: true,
                action: 'checkemail',
                outputDiv: '#RegisterOutput',
                url: URL + 'Register/checkEmail',
                display: false
            },
            lables: {
                name: 'Full Name:',
                email: 'Email-Id:',
                mobile: '+91',
                gender: 'Prove you are a human',
                pass1: 'Password:',
                pass2: 'Confirm Password:'
            }
        },
        traffic: {
            autoloader: true,
            action: 'updateTraffic',
            url: window.location.href,
            display: false
        },
        forgot: {
            autoloader: true,
            action: 'forgotPassword',
            parentDiv: '#forgotPass',
            parentBut: '#forgotPassBut',
            form: '#forgotPasswordform',
            uname: '#frecipient-name',
            unmsg: '#fuser_name_msg',
            close: '#floginCloseBut',
            botton: '#fgetIn',
            outputDiv: '#foutputLogRes',
            url: URL + 'Login/forgotPassword',
            display: false,
            lables: {
                uname: 'Email-Id / Username:',
            }
        },
        outputDiv: '#output',
        browser: navigator.userAgent
    };
    //var obj0 = new catchHit();
    //obj0.__constructor(Index);
    var para = getJSONIds({
        autoloader: true,
        action: 'getIdHolders',
        url: URL + 'Index/getIdHolders',
        type: 'POST',
        dataType: 'JSON'
    });
    var obj1 = new signIn();
    obj1.__constructor(Index);
    var obj3 = new cutomerRegister();
    obj3.__constructor(Index);
    var obj4 = new indexLeadController()
    obj4.__constructor(para.nookleads);
    obj4.publicDisplayLead();
    var obj5 = new HeaderController();
    obj5.__constructor(para.nookleads);
    var obj6 = new forgotPassword();
    obj6.__constructor(Index);
});
