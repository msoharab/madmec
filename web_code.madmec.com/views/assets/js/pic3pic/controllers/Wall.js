function wallController() {
    var mem = {};
    this.__constructor = function (para) {
        //console.log(para);
        mem = para;
        var obj1 = new channelController();
        obj1.__constructor(para.channel);
        obj1.publicListChannels();
        window.setTimeout(function () {
            var obj2 = new newPostController();
            obj2.__constructor(para.post);
        }, 1300);
    };
}
$(document).ready(function () {
    var obj = new wallController()
    obj.__constructor(getJSONIds({
        autoloader: true,
        action: 'getIdHolders',
        url: URL + 'Wall/getIdHolders',
        type: 'POST',
        dataType: 'JSON'
    }).wall);
    /*
     if (typeof pic3pic.Wall === 'object') {
     }
     pic3pic.Wall = getJSONIds({
     autoloader: true,
     action: 'getIdHolders',
     url: 'Wall/getIdHolders',
     type: 'POST',
     dataType: 'JSON'
     });
     wall = JSON.parse(wall);

     if (typeof wall === 'object') {
     var obj = new HeaderController()
     obj.__constructor(wall);
     }
     var wall = sessionStorage.getItem("Wall");
     if (wall == null || !wall || wall == 'undefined') {
     pic3pic.Wall = getJSONIds({
     autoloader: true,
     action: 'getIdHolders',
     url: 'Wall/getIdHolders',
     type: 'POST',
     dataType: 'JSON'
     });
     sessionStorage.setItem("Wall", JSON.stringify(pic3pic.Wall));
     wall = pic3pic.Wall;
     }
     else {
     wall = JSON.parse(wall);
     }
     console.log(wall);
     var flag = false;
     if (typeof wall === 'object') {
     flag = walk(wall);
     pic3pic.Wall = getJSONIds({
     autoloader: true,
     action: 'getIdHolders',
     url: 'Wall/getIdHolders',
     type: 'POST',
     dataType: 'JSON'
     });
     sessionStorage.setItem("Wall", JSON.stringify(pic3pic.Wall));
     wall = pic3pic.Wall;
     }
     else {
     throw new Error('Unable to retrive HTML Ids.');
     }
     if (flag) {
     var obj = new HeaderController()
     obj.__constructor(wall);
     }
     */
});




