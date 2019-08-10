function faceBook() {
    this.__constructor = function (members) {
        loadFBSDK(members);
    };
    function loadFBSDK(members) {
        window.setTimeout(function () {
            intializeFBSDK(members);
        }, 1000);
    }
    ;
    function intializeFBSDK(members) {
        FB.init({
            appId: '278738005649674',
            cookie: true,
            xfbml: true,
            version: 'v2.1'
        });
        window.setTimeout(function () {
            FB.getLoginStatus(function (response) {
                statusChangeCallback(response, members);
            });
            logintoFB();
        }, 1000);
    }
    ;
    function chekLoginStatus(members) {
        FB.getLoginStatus(function (response) {
            statusChangeCallback(response, members);
        });
    }
    ;
    function statusChangeCallback(response, members) {
        switch (response.status) {
            case 'connected':
                callAPI(members);
                break;
            case 'not_authorized':
                $(members.outputDiv).html('<strong class="text-danger">Please Log in to Tamboola !!!</strong>');
                window.setTimeout(function () {
                    chekLoginStatus(members);
                }, 800);
                break;
            case 'unknown':
                $(members.outputDiv).html('<strong class="text-danger">Please Log in to Facebook !!!</strong>');
                window.setTimeout(function () {
                    chekLoginStatus(members);
                }, 1200);
                break;
        }
    }
    ;
    function callAPI(members) {
        FB.api('/me', function (response) {
            members.response = response;
            logintoApp();
        });
    }
    ;
    function logintoFB() {
        FB.login(function (response) {
        }, {scope: 'public_profile,email,user_friends,user_about_me,user_activities,user_birthday,user_groups,user_hometown,user_interests,user_likes,user_location,user_photos,user_website,read_friendlists'});
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
    }
}
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
