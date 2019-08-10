function dashboardVendor() {
    var data = {};
    var jsondata = {};
    this.__construct = function (para) {
        data = para;
        switch (data.action) {
            case "getNoCustomers":
            {
                getNoCustomers();
                break;
            }
            case "getUpcomming":
            {
                getUpcomming();
                break;
            }
            case "getInline":
            {
                getInline();
                break;
            }
            case "getCompleted":
            {
                getCompleted();
                break;
            }
            case "getTodaysSolts":
            {
                getTodaysSolts();
                break;
            }
            case "dashMe":
            {
                dashMe();
                break;
            }
        }
    }
    function getNoCustomers() {
    }
    function getUpcomming() {
    }
    function getInline() {
    }
    function getCompleted() {
    }
    function getTodaysSolts() {
    }
    function dashMe() {
    }
}