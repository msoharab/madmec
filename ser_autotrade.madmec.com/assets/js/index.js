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
            $(signIn.uname).focus();
        }, 2500);
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
        $(signIn.parentDiv).css({display: 'block'});
        $(signIn.uname).change(function () {
            if ($(signIn.uname).val().match(name_reg)) {
                flag = true;
                $(signIn.unmsg).html(VALIDNOT);
            }
            else {
                flag = false;
                $(signIn.unmsg).html(INVALIDNOT);
            }
        });
        $(signIn.password).change(function () {
            if ($(signIn.password).val().match(pass_reg)) {
                $(signIn.pmsg).html(VALIDNOT);
                flag = true;
            }
            else {
                flag = false;
                $(signIn.pmsg).html(INVALIDNOT);
            }
        });
        $(signIn.password).on('keyup', function (evt) {
            if (evt.keyCode == 13) {
                $(signIn.botton).trigger('click');
            }
        });
        $(signIn.botton).on('click', function () {
            if (flag) {
                scrollToOutput();
                $(members.outputDiv).html(LOADER_ONE);
                $(signIn.uname).attr('disabled', 'disabled');
                $(signIn.password).attr('disabled', 'disabled');
                $(signIn.botton).attr('disabled', 'disabled');
                $.ajax({
                    url: signIn.url,
                    type: 'POST',
                    data: {
                        autoloader: true,
                        action: 'signIn',
                        user_name: $(signIn.uname).val(),
                        password: $(signIn.password).val(),
                        browser: navigator.userAgent
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
                                $(members.outputDiv).html('<strong class="text-success">Login successfull !!!</strong>');
                                window.setTimeout(function () {
                                    window.location.href = URL + 'control.php';
                                }, 800);
                                break;
                            case 'password':
                                $(signIn.pmsg).html('<strong class="text-danger">Password is incorrect !!!</strong>');
                                $(signIn.password).removeAttr('disabled', 'disabled');
                                break;
                            case 'error':
                                $(signIn.unmsg).html('<strong class="text-danger">User name is incorrect !!!</strong>');
                                $(signIn.pmsg).html('<strong class="text-danger">Password is incorrect !!!</strong>');
                                $(members.outputDiv).html(LOGN_ERROR);
                                clearSingInForm();
                                break;
                            case 'expired':
                                $(members.outputDiv).html(VALIDITY_EXPIRED);
                                clearSingInForm();
                                break;
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
        var eleoffset = Number($(members.outputDiv).offset().top);
        $("html, body").animate({scrollTop: eleoffset}, "slow");
    }
    ;
}
$(document).ready(function () {
    var signIn = {
        autoloader: true,
        action: 'signIn',
        parentDiv: '#signin',
        form: '#signinform',
        uname: '#user_name',
        unmsg: '#user_name_msg',
        password: '#password',
        pmsg: '#pass_msg',
        botton: '#sigininbut',
        url: URL + 'singin.php',
        display: false
    };
    var members = {
        signIn: signIn,
        outputDiv: '#output'
    };
    var obj = new indexPage();
    obj.__constructor(members);
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {autoloader: true, action: 'updateTraffic'},
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
                    $(members.outputDiv).html('Traffic updated');
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
});
