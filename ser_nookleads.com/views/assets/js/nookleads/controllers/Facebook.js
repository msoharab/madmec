window.fbAsyncInit = function () {
    FBAPI = FB;
    FBAPI.init({
        appId: fbdata.appId, // App ID
        apiKey: fbdata.apiKey, // App Secret
        businessURL: '', // Business File, not required so leave empty
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        oauth: true, // enable OAuth 2.0
        xfbml: false // parse XFBML
    });
};
window.fbAsyncInit();
function FBlogin() {
    FBAPI.getLoginStatus(function (r) {
        if (r.status === 'connected' && r.authResponse) {
            checkFBLoginStatus();
        } else if (r.status === 'unknown' && r.authResponse === null) {
            FBAPI.login(function (response) {
                if (response.authResponse) {
                    checkFBLoginStatus();
                } else {
                }
            }, {
                scope: 'email'
            });
        }
    });
}
function FBlogOut() {
    FBAPI.getLoginStatus(function (r) {
        if (r.status === 'connected') {
            FBAPI.logout();
        }
    });
}
function checkFBLoginStatus() {
    var fields = [
        'id',
        'name',
        'email',
    ].join(',');
    FBAPI.api('/me', {
        fields: fields
    }, function (response) {
        fbdata.id = response.id;
        fbdata.name = response.name;
        fbdata.email = response.email;
        if(typeof response.email === 'undefined'){
            FBlogOut();
            alert('Your email id is not verified by facebook');
            window.location.href = URL + 'Logout';
        }
        $(document).ready(function () {
            var para = getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Index/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).nookleads;
            var obj1 = new onFacebookSignIn();
            obj1.__constructor(para);
            obj1.publiccheckEmail();
        });
    });
}
function onFacebookSignIn() {
    var members = {};
    var login = {};
    var register = {};
    var id = '';
    var name = '';
    var email = '';
    var pass = '';
    var browser = '';
    var userdata = {};
    this.__constructor = function (para) {
        console.log(para);
        members = para;
        login = members.index.login;
        register = members.index.register;
        this.browser = navigator.userAgent;
        this.email = fbdata.email;
        this.name = fbdata.name;
        this.id = fbdata.id;
    };
    this.publiccheckEmail = function () {
        checkEmail(fbdata.email);
        if (userdata.id) {
            Login();
        }
        else {
            Register();
        }
    }
    function checkEmail(email) {
        var register = members.index.register;
        var checkemail = members.index.register.checkemail;
        var obj = {};
        $.ajax({
            url: checkemail.url,
            type: 'POST',
            dataType: 'JSON',
            async: false,
            data: {
                autoloader: checkemail.autoloader,
                action: checkemail.action,
                user_name: email
            },
            success: function (data, textStatus, xhr) {
                if (typeof data === 'object') {
                    obj = data;
                }
                else {
                    obj = $.parseJSON($.trim(data));
                }
                if (Number(obj.count) > 0 && obj.status === 'success') {
                    $(register.LogoutputDiv).html('<span class="text-danger"><strong>Email Id Already Exist</strong></span>');
                }
                if (obj.userdata) {
                    userdata = obj.userdata;
                }
            },
            error: function (xhr, textStatus) {
                $(checkemail.LogoutputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function Register() {
        var obj = {};
        $.ajax({
            url: register.url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                autoloader: true,
                action: register.action,
                details: {
                    name: $.trim(fbdata.name),
                    email: $.trim(fbdata.email),
                    socailid: $.trim(fbdata.id),
                    pass: generateRandomString(),
                    browser: browser,
                },
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
                        $(register.LogoutputDiv).html('<strong class="text-success">Login successfull !!!</strong>');
                        if (Number(obj.loggedin) === 1) {
                            window.setTimeout(function () {
                                window.location.href = URL + LAND_PAGE;
                            }, 500);
                        }
                        break;
                    case 'password':
                        $(register.LogoutputDiv).html('<strong class="text-success">Wrong password !!!</strong>');
                        $(register.LogoutputDiv).html(LOGN_ERROR);
                        break;
                    case 'error':
                        $(register.LogoutputDiv).html(LOGN_ERROR);
                        break;
                }
            },
            error: function (data) {
                $(members.index.LogoutputDiv).html(INET_ERROR);
            },
            complete: function (xhr, textStatus) {
            }
        });
    }
    function Login() {
        if (userdata.id) {
            var obj = {};
            $.ajax({
                url: login.url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    autoloader: login.autoloader,
                    action: login.action,
                    user_name: userdata.email,
                    password: userdata.password,
                    browser: browser,
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
                            $(login.LogoutputDiv).html('<strong class="text-success">Login successfull !!!</strong>');
                            window.setTimeout(function () {
                                window.location.href = URL + LAND_PAGE;
                            }, 500);
                            break;
                        case 'password':
                            $(login.LogoutputDiv).html('<strong class="text-success">Wrong password !!!</strong>');
                            break;
                        case 'error':
                            $(login.LogoutputDiv).html(LOGN_ERROR);
                            break;
                    }
                },
                error: function (data) {
                    $(members.index.LogoutputDiv).html(INET_ERROR);
                },
                complete: function (xhr, textStatus) {
                }
            });
        }
    }
}
$(document).ready(function () {
    window.setTimeout(function () {
        //FBlogin();
    }, 1200);
});
