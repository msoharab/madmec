$(document).ready(function (){
   $('#signform').submit(function (evt){
       evt.preventDefault();
       var attr={
           username : $('#user_name').val(),
           password : $('#password').val()
       };
       $.ajax({
            type: 'POST',
            url: 'login.php',
            data: {
                autoloader: true,
                action: 'checkuser',
                details : attr
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
                     default :
                            if(data == "success")
                            {
                                 $('#output').html("<span class='text-success'>Login Successfull...</span>");
                                window.setTimeout(function (){
                                   window.location.href="admin.php";
                                },1200);
                            }
                            else
                            {
                                 $('#output').html("<span class='text-danger'>Access Denied</span>");
                            }
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
   })
});

