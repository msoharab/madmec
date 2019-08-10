function homeController() {
    var members = {};
    this.__constructor = function (para) {
        members = para;
    };
    this.__gymSearch = function () {
        var obj = new gymController();
        obj.__constructor(members.home);
        obj.__gymSearch({source:members.gym.searchGym,fields:members.gym.searchGym.fields,index:0});
    };
    this.__AddGym = function () {
        var obj = new gymController();
        obj.__constructor(members.home);
        obj.__AddGym();
    };
    this.__EditGym = function () {
        var obj = new gymController();
        obj.__constructor(members.home);
        obj.__EditGym();
    };
}
