function wallController() {
    var mem = {};
    var obj1 = {};
    var obj2 = {};
    var obj3 = {};
    var obj4 = {};
    this.__constructor = function (para) {
        mem = para;
        obj1 = new channelController();
        obj1.__constructor(para);
        obj1.publicListChannels();
        obj1.publicListAdminChannels();
        obj1.publicListSubscribeChannels();
        //obj1.publicsearchChannels();
        window.setTimeout(function () {

            obj2 = new newPostController();
            obj2.__constructor(para);
            obj2.bindActions();
            obj2.publicDisplayPost();

            obj3 = new profilePicController();
            obj3.__constructor(para.profile.pic);

            obj4 = new HeaderController();
            obj4.__constructor(para);

        }, 1300);
    };
}
$(document).ready(function () {
    var this_js_script = $("script[src$='Wall.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            console.log('I am In Wall');
            var obj = new wallController()
            obj.__constructor(getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Wall/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).pic3pic);
        }
        else {
            console.log('I am Out Wall');
        }
    }
});




