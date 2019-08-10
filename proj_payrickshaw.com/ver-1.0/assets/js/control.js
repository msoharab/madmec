$(document).ready(function(){
    var menutags={
      homepage      : '#homepage',   
      billgenmodule : '#billgenmodule',
      accountmoduledis:  '#accountmoduledis',
      accountsmenu  : '#accountsmenu',
    };
    $(menutags.homepage).on('click',function (){
        $(menutags.accountmoduledis).hide();
        $(menutags.billgenmodule).show();
        goto_form1();
         var billgendetails={
       regdno           : '#regdno',
       drivercheck      : 0,
       passengercheck   : 0,
       driverid         : 0,
       passid           : 0,
       genbillform      : '#genbillform',
       billgenprint     : '#billgenprint',
       formreferesh     : '#formreferesh',
       drivername       : '#drivername',
       drivermobile     : '#drivermobile',
       passengermobile  : '#passengermobile',
       passengername    : '#passengername',
       passngeraddress  : '#passngeraddress',
       source           : '#source',
       destination      : '#destination',
       distance         : '#distance',
       regdnoerr        : '#regdnoerr',
       drivernameerr    : '#drivernameerr',
       drivermobileerr  : '#drivermobileerr',
       passengermobileerr : '#passengermobileerr',
       passengernameerr : '#passengernameerr',
       passngeraddresserr : '#passngeraddresserr',
       amount           : '#amount',
       genButt           : '#genButt',
       next1            : '#next1',
       next2            : '#next2',
       signout          : '#signout',
       url              : 'control.php',
  };
    $(billgendetails.genbillform).get(0).reset();
		var obj = new app();
		obj.__construct(billgendetails);
    });
    $(menutags.accountsmenu).on('click',function (){
        $(menutags.accountmoduledis).show();
        $(menutags.billgenmodule).hide();
         var payments={
        paymentregdno               : '#paymentregdno',
        paymentregdnomsg            : '#paymentregdno_msg',
        paymentdrivermobile         : '#paymentdrivermobile',
        paymentdrivermobilemsg      : '#paymentdrivermobile_msg',
        paymentdrivername           : '#paymentdrivername',
        paymentdrivernamemsg        : '#paymentdrivername_msg',
        paymentamountpaid           : '#paymentamountpaid',
        paymentamountpaidmsg        : '#paymentamountpaid_msg',
        paymentpaiddate             : '#paymentpaiddate',
        paymentpaiddatemsg          : '#paymentpaiddate_msg',
        paymentdueamount            : '#paymentdueamount',
        paymentdueamountmsg         : '#paymentdueamount_msg',
        paymentamountpay            : '#paymentamountpay',
        paymentamountpaymsg         : '#paymentamountpay_msg',
        paymentremark               : '#paymentremark',
        driverid                    : 0,
        paymentremarkmsg            : '#paymentremark_msg',
        addpaymentform              : '#addpaymentform',
        paymentbutt                  : '#paymentbutt'
    };
    paymenthistory ={
        paymenthisregdno               : '#paymenthisregdno',
        paymenthisregdnomsg            : '#paymenthisregdno_msg',
        paymenthisdrivermobile         : '#paymenthisdrivermobile',
        paymenthisdrivermobilemsg      : '#paymenthisdrivermobile_msg',
        paymenthisdrivername           : '#paymenthisdrivername',
        paymenthisdrivernamemsg        : '#paymenthisdrivername_msg',
        displaypaymenthistory          : '#displaypaymenthistory',
        driverid                       : 0
    }
    var account={
        payments       : payments,
        paymenthistory : paymenthistory,
        payment_menubut : '#payment_menubut',
        pay_his_menubut : '#payment_history_menubut',
        url            : 'control.php',
        
    }
    $(account.payments.addpaymentform).get(0).reset();
    var obj = new accounts();
    obj.__construct(account);
    });
    $(menutags.homepage).trigger('click');
});




