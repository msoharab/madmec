var loader = "#centerLoad";
var email_reg_new = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
var cell_reg_new = /[0-9]{10,20}$/;
/* Binding the Menu Links  */
$(document).ready(function () {
    var mainpage = {
        leftbuttons: '.atleftmenu',
        prefiex: '#p',
        defaultView: '#pgym',
        outputDiv: '#output',
    };
    var leftbuttons = {
        one: '#Donation',
        conf: '#appointeditBut',
        two: '#Referral',
        thr: '#Rewarding',
        four: '#Report'
    };
    var appointment = {
        appointmentmenuBut: '#appointmentmenuBut',
        appointconfig: '#appointconfig',
        appointview: '#appointview',
        appointconfigBut: '#appointconfigBut',
        appointviewBut: '#appointviewBut',
        appointedit: '#appointedit',
        appointeditBut: '#appointeditBut',
        displayconfigslot: '#displayconfigslot',
        plus: '#plus_slots_',
        eplus: 'eplus_slots_',
        minus: '#minus_slots_',
        eminus: '#eminus_slots_',
        multiple_slots: '#multiple_slots',
        emultiple_slots: '#emultiple_slots',
        num: -1,
        j: 0,
        enum: -1,
        ej: 0,
        alterappts: '#alterappts',
        form: 'div_multiple_slots',
        eform: 'ediv_multiple_slots',
        appointsubmitBut: '#appointsubmitBut',
        eaddappointSubmit: '#eaddappointSubmit',
        fromhour: 'fromhour',
        fromminute: 'fromminute',
        fromampm: 'fromampm',
        tohour: 'tohour',
        tominute: 'tominute',
        toampm: 'toampm',
        locationappoint: 'locationappoint',
        frequencyappoint: 'frequencyappoint',
        efromhour: 'efromhour',
        efromminute: 'efromminute',
        efromampm: 'efromampm',
        etohour: 'etohour',
        etominute: 'etominute',
        etoampm: 'etoampm',
        elocationappoint: 'elocationappoint',
        efrequencyappoint: 'efrequencyappoint',
        appointconfgmsg: '#appointconfgmsg',
        eappointconfgmsg: '#eappointconfgmsg',
        appointform: '#appointform',
        appointbutton: '#appointbutton',
        delete_app: 'delete_app',
        edit_app: 'edit_app',
        deleteOk_: 'deleteOk_',
        edit_details: 'edit_details_',
        row_id: 'row_id',
        viewappointee: 'viewappointee_',
        viewappointeedis: 'viewappointeedis_',
    };
    var editappointment = {
        editfromhour: 'editfromhour',
        editfromminute: 'editfromminute',
        editfromampm: 'editfromampm',
        edittohour: 'edittohour',
        edittominute: 'edittominute',
        edittoampm: 'edittoampm',
        editlocationappoint: 'editlocationappoint',
        editfrequencyappoint: 'editfrequencyappoint',
        editApptDetailsSubmit: 'editApptDetailsSubmit',
        editapptidd: 'editapptidd',
    };
    var doctor = {
        appointment: appointment,
        editappointment: editappointment,
        referpage1: leftbuttons.one,
        referpage2: leftbuttons.conf,
        referpage3: leftbuttons.two,
        referpage4: leftbuttons.thr,
        referpage5: leftbuttons.four,
        url: window.location.href
    };
    loadJavaScript = function (src) {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src =src;
        $(OUTPUT).append(s);
    };
    $(leftbuttons.one).click(function (evt) {
        doctor.appointment.j= 0;
        doctor.appointment.enum= -1;
        doctor.appointment.ej= 0;
		$(OUTPUT).html(MODULES.VEN_APPOINTMENT);
        loadJavaScript(URL + ASSET_JSF + VENDR + "vendor.js");
        obj = new doctorcontroller();
        obj.__construct(doctor);
        obj.referpage1();
    });
    $(leftbuttons.conf).click(function (evt) {
        doctor.appointment.num= -1;
        doctor.appointment.j= 0;
        doctor.appointment.enum= -1;
        doctor.appointment.ej= 0;
        $(OUTPUT).html(MODULES.VEN_CONFIGURE);
        loadJavaScript(URL + ASSET_JSF + VENDR + "vendor.js");
        obj = new doctorcontroller();
        obj.__construct(doctor);
        obj.referpage2();
    });
    $(leftbuttons.two).click(function (evt) {
        doctor.appointment.num= -1;
        doctor.appointment.j= 0;
        doctor.appointment.enum= -1;
        doctor.appointment.ej= 0;
        $(OUTPUT).html(MODULES.VEN_UPCOMING);
        loadJavaScript(URL + ASSET_JSF + VENDR + "vendor.js");
        obj = new doctorcontroller();
        obj.__construct(doctor);
    });
    $(leftbuttons.thr).click(function (evt) {
        doctor.appointment.num= -1;
        doctor.appointment.j= 0;
        doctor.appointment.enum= -1;
        doctor.appointment.ej= 0;
        $(OUTPUT).html(MODULES.VEN_INLINE);
        loadJavaScript(URL + ASSET_JSF + VENDR + "vendor.js");
        obj = new doctorcontroller();
        obj.__construct(doctor);
    });
    $(leftbuttons.four).click(function (evt) {
        doctor.appointment.num= -1;
        doctor.appointment.j= 0;
        doctor.appointment.enum= -1;
        doctor.appointment.ej= 0;
        $(OUTPUT).html(MODULES.VEN_REPORT);
        loadJavaScript(URL + ASSET_JSF + VENDR + "vendor.js");
        obj = new doctorcontroller();
        obj.__construct(doctor);
    });
});