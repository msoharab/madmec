function handleClientLoad() {
    gapi.client.setApiKey(gdata.apiKey);
    window.setTimeout(checkAuth, 1);
}
function checkAuth() {
    gapi.auth.authorize({
        client_id: gdata.clientId,
        scope: gdata.scopes,
        approvalprompt: 'force',
        cookiepolicy: 'single_host_origin',
    }, handleAuthResult);
    GPAPI = gapi;
}
function handleAuthResult(authResult) {
    if (authResult && !authResult.error) {
        makeApiCall();
    }
    else if (authResult.status.signed_in === true) {
        request.then(function (resp) {
            setGlobalValues(resp);
        }, function (reason) {
            console.log('Error: ' + reason.result.error.message);
        });
    }
}
function makeApiCall() {
    gapi.client.load('plus', 'v1').then(function () {
        request = gapi.client.plus.people.get({
            'userId': 'me'
        });
        request.then(function (resp) {
            setGlobalValues(resp);
        }, function (reason) {
            console.log('Error: ' + reason.result.error.message);
        });
    });
}
function GooglesignOut() {
    if (gapi.auth)
        gapi.auth.signOut();
}
function setGlobalValues(resp) {
    if (resp.status === 200) {
        if (typeof resp.result === 'object') {
            var res = resp.result;
            console.log(res);
            gdata.id = res.id;
            gdata.name = res.displayName;
            if(typeof res.emails ==='undefined'){
                GooglesignOut()
                alert('Your email id is not verified by goole');
                window.location.href = URL + 'Logout';
            }
            if (res.emails.length > 0){
                gdata.email = res.emails[0].value;
            }

            /* Interact with native webapp */
            $(document).ready(function () {
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Index/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).pic3pic;
                var obj1 = new onGoogleSignIn();
                obj1.__constructor(para);
                obj1.publiccheckEmail();
            });

        }
    }
    else {
        console.log('Could not initialize the global object');
    }
}
function onGoogleSignIn() {
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
        this.email = gdata.email;
        this.name = gdata.name;
        this.id = gdata.id;
    };
    this.publiccheckEmail = function () {
        checkEmail(gdata.email);
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
                    name: $.trim(gdata.name),
                    email: $.trim(gdata.email),
                    socailid: $.trim(gdata.id),
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
