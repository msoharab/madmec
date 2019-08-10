function controlRegistrationReport() {
    var gymid = $(DGYM_ID).attr("name");
    reg = {};
    this.__construct = function (para1) {
        reg = para1;
        console.log(reg);
        $("html , body").animate({
            scrollTop: 0
        }, "fast");
        $(reg.dt1).datepicker({
            dateFormat: 'dd-M-yy',
            changeMonth: true,
            changeYear: true,
            altField: '#alternate_1',
            altFormat: 'DD, d MM, yy',
            maxDate: 0,
            yearRange: '2014:' + (new Date).getFullYear() + ''
        });
        $(reg.dt2).datepicker({
            dateFormat: 'dd-M-yy',
            changeMonth: true,
            changeYear: true,
            altField: '#alternate_2',
            altFormat: 'DD, d MM, yy',
            maxDate: 0,
            yearRange: '2014:' + (new Date).getFullYear() + '',
            beforeShow: function () {
                jQuery(this).datepicker('option', 'minDate', $(reg.dt1).val());
            }
        });
        $(reg.btn).bind('click', function () {
            GenerateRegistrationReport();
        });
    }
    function GenerateRegistrationReport() {
        var flag = true;
        var reptype = '';
        var attrName = '';
        var attrValue = '';
        var date1 = convertDateFormat($(reg.dt1).val()) ? convertDateFormat($(reg.dt1).val()) : null;
        var date2 = convertDateFormat($(reg.dt2).val()) ? convertDateFormat($(reg.dt2).val()) : null;
        ;
        var attrName = reg.type_reports;
        var attrValue = $(DGYM_ID).text();
        if ($(reg.dt1).val() == "") {
            $(reg.dt1).focus();
            return
            flag = false;
        } else {
            flag = true;
        }
        if (date1 || date2) {
            $('#date_rpt_msg').hide();
        } else {
            $('#date_rpt_msg').show();
            flag = false;
        }
        if (flag) {
            console.log(attrName);
            $(reg.output).html('<img class="img-circle" src="' + URL + ASSET_IMG + 'spinner_grey_120.gif" border="0" width="60" height="60" />');
            $.ajax({
                url: window.location.href,
                data: {
                    autoloader: 'true',
                    action: 'reportRegistration',
                    type: 'slave',
                    gymid: gymid,
                    attrName: attrName,
                    attrValue: reptype,
                    date1: date1,
                    date2: date2
                },
                type: 'POST'
            }).done(function (data) {
                console.log(data);
                if (data == 'logout')
                    window.location.href = URL;
                $(reg.output).html(data);
            });
        }
    }
}
;
