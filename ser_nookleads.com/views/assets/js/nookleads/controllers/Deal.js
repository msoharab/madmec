function dealController() {
    var mem = {};
    var obj1 = {};
    var obj2 = {};
    var obj3 = {};
    var obj4 = {};
    this.__constructor = function (para) {
        mem = para;
        obj1 = new businessController();
        obj1.__constructor(para);
        obj1.publicListBusinesss();
        obj1.publicListAdminBusinesss();
        obj1.publicListSubscribeBusinesss();
        obj1.publicsearchBusinesss();
        window.setTimeout(function () {
            obj2 = new newLeadController();
            obj2.__constructor(para);
            obj2.bindActions();
            obj2.publicDisplayLead();
            obj3 = new profilePicController();
            obj3.__constructor(para.profile.pic);
            obj4 = new HeaderController();
            obj4.__constructor(para);
        }, 1300);
    };
}
$(document).ready(function () {
    var this_js_script = $("script[src$='Deal.js']");
    if (this_js_script) {
        var flag = this_js_script.attr('data-autoloader');
        if (flag === 'true') {
            console.log('I am In Deal');
            var obj = new dealController()
            obj.__constructor(getJSONIds({
                autoloader: true,
                action: 'getIdHolders',
                url: URL + 'Deal/getIdHolders',
                type: 'POST',
                dataType: 'JSON'
            }).nookleads);
        }
        else {
            console.log('I am Out Deal');
        }
    }
});
