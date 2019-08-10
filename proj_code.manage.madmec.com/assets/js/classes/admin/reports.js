function reports()
{
    var reportform = false;
    var ctrl = {};
    this.__construct = function (cctrl) {
        ctrl = cctrl;
        $(ctrl.fromdate).datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'dd-M-yy',
            maxDate: 0,
        });
        $(ctrl.todate).datepicker({
            changeYear: true,
            changeMonth: true,
            dateFormat: 'dd-M-yy',
            maxDate: 0,
        });
        $(ctrl.form).validate({
            submitHandler: function () {
                reportform = true;
            }
        });
        $(ctrl.form).submit(function (evt) {
            evt.preventDefault();
            generateReport();
        });
    };
    function  generateReport()
    {
        if (reportform)
        {
            $(ctrl.displayreports).html("<strong class=<'test-danger'>Loading.............</strong>");
        }
    }
}
;

