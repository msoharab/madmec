function Facebook() {
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
                alert('Please Login to Local Talent !!!');
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
//                'user_likes,'+
//                'user_location,'+
//                'user_photos,'+
//                'user_website,'+
//                'read_friendlists'
    }
}
