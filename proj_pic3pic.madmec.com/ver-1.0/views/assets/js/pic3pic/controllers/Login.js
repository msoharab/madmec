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
                alert('Please Login to Pic3Pic !!!');
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
//                'user_likes,'+
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
        post: {},
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
    var obj1 = new signIn();
    obj1.__constructor(Index);
});
