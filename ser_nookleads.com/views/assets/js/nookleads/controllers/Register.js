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
function faceBook() {
    var members = {};
    var index = {};
    var fbAPI = {};
    var fbJSON = {};
    this.__constructor = function (para) {
        members = para;
        index= members.index;
        fbJSON= index.facebook;
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
            scope: 'public_profile,'+
                    'email,'+
                    'name,'+
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
function googlePlus(){
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
        outputDiv: '#output',
        browser: navigator.userAgent
    };
    var obj3 = new cutomerRegister();
    obj3.__constructor(Index);
});
