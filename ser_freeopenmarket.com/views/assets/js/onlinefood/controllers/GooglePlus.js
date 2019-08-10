
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
}

function handleAuthResult(authResult) {
    if (authResult && !authResult.error) {
        makeApiCall();
    }
    else if (authResult.status.signed_in === true) {
        request.then(function (resp) {
            setGlobalValues(resp);
        }, function (reason) {
            LogMessages('Error: ' + reason.result.error.message);
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
            LogMessages('Error: ' + reason.result.error.message);
        });
    });
}

function GooglesignOut() {
    gapi.auth.signOut();
}


function setGlobalValues(resp) {
    if (resp.status === 200) {
        if (typeof resp.result === 'object') {
            var res = resp.result;
            LogMessages(res);
            gdata.id = res.id;
            gdata.name = res.displayName;
            if (res.emails.length > 0)
                gdata.email = res.emails[0].value;
            /* Interact with native webapp */
            onGoogleSignIn();
        }
    }
    else {
        LogMessages('Could not initialize the global object');
    }
}

