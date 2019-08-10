function indexPage() {
    /* Constructor */
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
        var signIn = members.signIn;
        clearSingInForm();
        initializeSingIn();
        window.setTimeout(function () {
            $('html,body').animate({
                scrollTop: $(signIn.parentDiv).offset().top
            }, 2500);
            $(signIn.uname).focus();
        }, 1000);
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
                scrollToOutput();
                $(signIn.outputDiv).html(LOADER_SIX);
                $(signIn.uname).attr('disabled', 'disabled');
                $(signIn.password).attr('disabled', 'disabled');
                $(signIn.botton).attr('disabled', 'disabled');
                $.ajax({
                    url: signIn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: signIn.action,
                        user_name: $(signIn.uname).val(),
                        password: $(signIn.password).val(),
                        browser: members.browser
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data);
                        data = $.trim(data);
                        switch (data) {
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
                                    location.replace(LAND_PAGE);
                                }, 1000);
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
                        console.log(xhr.status);
                    }
                });
            }
        });
    }
    ;
    function scrollToOutput() {
        var signIn = members.signIn;
        var eleoffset = Number($(signIn.outputDiv).offset().top);
        $("html, body").animate({
            scrollTop: eleoffset
        }, "slow");
    }
    ;
}
function catchHit() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
        updateTraffic();
    };
    function updateTraffic() {
        var traffic = members.traffic;
        $.ajax({
            url: traffic.url,
            type: 'POST',
            data: {
                autoloader: traffic.autoloader,
                action: traffic.action
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
                        $(members.outputDiv).html('<center><h1>Welcome To Tamboola</h1></center>');
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
            } else {
                $(register.namemsg).html(INVALIDNOT);
                flag = false;
            }
        });
        $(register.email).change(function () {
            if (this.value.match(email_reg)) {
                $(register.emailmsg).html(VALIDNOT);
                checkEmail(this.value);
            } else {
                checkusr = 0;
                $(register.emailmsg).html(INVALIDNOT);
                flag = false;
            }
        });
        $(register.email).mouseup(function () {
            if (this.value.match(email_reg)) {
                $(register.emailmsg).html(VALIDNOT);
                checkEmail(this.value);
            } else {
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
            if ($(register.pass1).val() !== $(register.pass2).val() || this.value.length < 6) {
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
        $.ajax({
            url: checkemail.url,
            type: 'POST',
            data: {
                autoloader: checkemail.autoloader,
                action: checkemail.action,
                email: email
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                if (Number(data)) {
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
        var attr = validateRegisterForm();
        if (flag && attr && checkusr) {
            $(register.name).attr('disabled', 'disabled');
            $(register.email).attr('disabled', 'disabled');
            $(register.mobile).attr('disabled', 'disabled');
            $(register.gender).attr('disabled', 'disabled');
            $(register.pass1).attr('disabled', 'disabled');
            $(register.pass2).attr('disabled', 'disabled');
            $(register.botton).attr('disabled', 'disabled');
            $.ajax({
                url: register.url,
                type: 'POST',
                data: {
                    autoloader: register.autoloader,
                    action: register.action,
                    details: attr
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
                        case 'success':
                            $(register.outputDiv).html('<span class="text-success"><strong>Registration has been Successfully Completed.</strong></span>');
                            clearRegisterForm();
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
					clearRegisterForm();
                }
            });
        }
    }
    ;
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
        if ($(register.mobile).val().match(cell_reg)) {
            $(register.mobilemsg).html(VALIDNOT);
            flag = true;
        } else {
            flag = false;
            $(register.mobile).focus();
            $(register.mobilemsg).html(INVALIDNOT);
            return;
        }
        if ($(register.gender + ' :selected').val() != "") {
            $(register.gendermsg).html(VALIDNOT);
            flag = true;
        } else {
            flag = false;
            $(register.gender).focus();
            $(register.gendermsg).html(INVALIDNOT);
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
                gender: $(register.gender).val(),
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
        $(register.mobile).removeAttr('disabled').val('');
        $(register.gender).removeAttr('disabled').val('');
        $(register.pass1).removeAttr('disabled').val('');
        $(register.pass2).removeAttr('disabled').val('');
        $(register.botton).removeAttr('disabled');
        $(register.namemsg).html(register.lables.name);
        $(register.emailmsg).html(register.lables.email);
        $(register.mobilemsg).html(register.lables.mobile);
        $(register.gendermsg).html(register.lables.gender);
        $(register.pass1msg).html(register.lables.pass1);
        $(register.pass2msg).html(register.lables.pass2);
    }
    ;
    function scrollToOutput() {
        var register = members.register;
        var eleoffset = Number($(register.outputDiv).offset().top);
        $("html, body").animate({
            scrollTop: eleoffset
        }, "slow");
    }
    ;
}
$(document).ready(function () {
    var members = {
        home: {
            autoloader: true,
            action: 'home',
            parentDiv: '#Home',
            menuBut: '#HomeBut',
            url: window.location.href,
            display: false
        },
        features: {
            autoloader: true,
            action: 'features',
            parentDiv: '#Features',
            menuBut: '#FeaturesBut',
            url: window.location.href,
            display: false
        },
        find: {
            autoloader: true,
            action: 'fetchlistofcity',
            parentDiv: '#Find',
            menuBut: '#FindBut',
            listcities: {
                autoloader: true,
                action: 'listofgyms',
                form: '#gym_searchhform',
                city: '#gym_searchh',
                citymsg: '#gym_searchh_msg',
                but: '#gymsearch',
                outputTable: 'listofgymsTable',
                outputDiv: '#listofgyms',
                url: window.location.href,
                display: false
            },
            url: window.location.href,
            display: false
        },
        signIn: {
            autoloader: true,
            action: 'signIn',
            parentDiv: '#SignIn',
            form: '#signinform',
            uname: '#user_name',
            unmsg: '#user_name_msg',
            password: '#password',
            pmsg: '#pass_msg',
            botton: '#sigininbut',
            outputDiv: '#SignInOutput',
            url: URL + 'singin.php',
            display: false,
            lables: {
                uname: '<i class="fa fa-envelope fa-fw"></i>',
                password: '<i class="fa fa-key fa-fw"></i>'
            }
        },
        register: {
            autoloader: true,
            action: 'custreg',
            parentDiv: '#regformm',
            menuDiv: '#CustomerRegister',
            form: '#custregform',
            name: '#cust_name',
            namemsg: '#cust_nmmsg',
            email: '#email',
            emailmsg: '#emmsg',
            mobile: '#cell_numbeb',
            mobilemsg: '#cellmsg',
            gender: '#gender',
            gendermsg: '#engmsg',
            pass1: '#regpassword',
            pass1msg: '#passmsgmsg',
            pass2: '#cpassword',
            pass2msg: '#cpassmsgmsg',
            botton: '#custregformBut',
            outputDiv: '#RegisterOutput',
            url: window.location.href,
            display: false,
            checkemail: {
                autoloader: true,
                action: 'checkemail',
                outputDiv: '#RegisterOutput',
                url: window.location.href,
                display: false
            },
            lables: {
                name: '<i class="fa fa-user fa-fw"></i>',
                email: '<i class="fa fa-envelope fa-fw"></i>',
                mobile: '+91',
                gender: '<i class="fa fa-users fa-fw"></i>',
                pass1: '<i class="fa fa-key fa-fw"></i>',
                pass2: '<i class="fa fa-key fa-fw"></i>'
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
    var obj0 = new catchHit();
    obj0.__constructor(members);
    var obj1 = new indexPage();
    obj1.__constructor(members);
    var obj2 = new cutomerRegister();
    obj2.__constructor(members);
});
