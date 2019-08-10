function userprofile()
{
    var userprfl = {};
    this.__construct = function (userprflctrl) {
        userprfl = userprflctrl;
        $(userprfl.changepass.changepasswordBut).on('click', function () {
            changePassword();
        });
        $(userprfl.personaldet.menuBut).click(function () {
            fetchClientDetails();
        });
        fetchClientDetails();
    };
    function  fetchClientDetails()
    {
        $(userprfl.personaldet.displaydata).html(LOADER_FUR);
        $.ajax({
            url: userprfl.url,
            type: 'POST',
            data: {
                autoloader: true,
                action: 'fetchclientprofile',
                type: 'master',
            },
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                data = $.trim(data);
                switch (data) {
                    case 'logout':
                        logoutAdmin({});
                        break;
                    case 'login':
                        loginAdmin({});
                        break;
                    default:
                        var result = $.parseJSON(data);
                        if (result.status == "success")
                        {
                            $(userprfl.personaldet.displaydata).html(result.data);
                        }
                        else
                        {
                            alert("ERROR");
                        }
                        break;
                }
            }
        })
    }
    function  changePassword()
    {
        var flag = false;
//       if($(userprfl.changepass.currentpassword).val()=="")
//       {
//           flag=false;
//           $(userprfl.changepass.currentpassword).focus();
//           $(userprfl.changepass.currentpassworderr).html(INVALIDNOT);
//            return ;
//       }
//       else
//       {
//          flag=true; 
//          $(userprfl.changepass.currentpassworderr).html(VALIDNOT);
//       }
        if ($(userprfl.changepass.newpassword).val() == "")
        {
            flag = false;
            $(userprfl.changepass.newpassword).focus();
            $(userprfl.changepass.newpassworderr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(userprfl.changepass.newpassworderr).html(VALIDNOT);
        }
        if ($(userprfl.changepass.confirmpassword).val() == "")
        {
            flag = false;
            $(userprfl.changepass.confirmpassword).focus();
            $(userprfl.changepass.confirmpassworderr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(userprfl.changepass.confirmpassworderr).html(VALIDNOT);
        }
        if ($(userprfl.changepass.newpassword).val() != $(userprfl.changepass.confirmpassword).val())
        {
            flag = false;
            $(userprfl.changepass.confirmpassword).focus();
            $(userprfl.changepass.confirmpassworderr).html(INVALIDNOT);
            return;
        }
        else
        {
            flag = true;
            $(userprfl.changepass.confirmpassworderr).html(VALIDNOT);
        }
        if (flag)
        {
            $.ajax({
                url: userprfl.url,
                type: 'POST',
                data: {
                    autoloader: true,
                    action: 'changepassword',
                    type: 'master',
                    confirmpassword: $(userprfl.changepass.confirmpassword).val(),
                },
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    data = $.trim(data);
                    switch (data) {
                        case 'logout':
                            logoutAdmin({});
                            break;
                        case 'login':
                            loginAdmin({});
                            break;
                        default:
                            var result = $.parseJSON(data);
                            if (result)
                            {
                                alert("Password has been Succcessfully Changed");
                                $(userprfl.changepass.changepasswordform).get(0).reset();
                                $(userprfl.changepass.newpassworderr).html('');
                                $(userprfl.changepass.confirmpassworderr).html('');
                            }
                            else
                            {
                                alert("Password hasn't been Changed, Please try after sometime");
                            }
                            break;
                    }
                }
            })
        }
    }

}
