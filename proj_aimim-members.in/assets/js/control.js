$(document).ready(function(){
    var menutags={
      homepage      : '#homepage',   
      viewmembers : '#viewmembers',
      adminaddmembers:  '#adminaddmembers',
      messages  : '#messages',
      logout  : '#logout',
    };
    $(menutags.homepage).on('click',function (){
        $(OUTPUT).load(WELCOME_MODULE);
        
    });
    $(menutags.viewmembers).on('click',function (){
        $(OUTPUT).load(VIEWMEMBER_MODULE);
        var members={
            displayviewmembers  : '#displayviewmembers',
            url                 :  AJAXURL
        };
        var obj = new viewmember();
        obj.__construct(members);
        
    });
    $(menutags.adminaddmembers).on('click',function (){
        
        $(OUTPUT).load(ADMINADDMEMBER_MODULE);
        var members={
            dob : '#dob',
            disuertype : '#disuertype',
            form  : '#adminaddform',
            url     :  AJAXURL
        };
        var obj = new adminaddmember();
        obj.__construct(members);
    });
    $(menutags.messages).on('click',function (){
        $(OUTPUT).load(MESSAGE_MODULE);
        var members={
            disuertype : '#disuertype',
            form  : '#adminaddform',
            url                 :  AJAXURL
        };
        var obj = new messages();
        obj.__construct(members);
    });
    $(menutags.logout).on('click',function (){
        $(OUTPUT).load(LOGOUT_MODULE);
        $.ajax({
            type: 'POST',
            url: AJAXURL,
            data: {
                autoloader: true,
                action: 'logout'
            },
            success: function (data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                }
            },
            error: function () {
               alert("INTERNET ERROR")
            },
            complete: function (xhr, textStatus) {
                console.log(xhr.status);
            }
        });
    });
    $(menutags.homepage).trigger('click');
});




