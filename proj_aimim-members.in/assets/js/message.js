function messages()
{
    var memberss = {};
    this.__construct = function (membersctrl) {
        memberss = membersctrl;
        window.setTimeout(function () {
           fetchusertype();
           $(memberss.form).submit(function(evt){
              evt.preventDefault()
			  console.log(evt);
              var formdata=$(this).serialize();
               $.post(memberss.url,formdata+'&autoloader=true&action=sendmessage',function (o,textStatus,jqXHR){
				   console.log(o);
				   console.log(textStatus);
				   console.log(jqXHR);
                   if(o)
                   {
                       alert("Message has been Successfully Sent");
                       $(memberss.form).get(0).reset();
                   }
                   else
                   {
                       alert("Message hasn't been Successfully Sent");
                       $(memberss.form).get(0).reset();
                   }
               },'json');
           });
        }, 400);
    };
    function fetchusertype()
    {
        $(memberss.disuertype).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: AJAXURL,
            data: {
                autoloader: true,
                action: 'fetchusertype'
            },
            success: function (data, textStatus, xhr) {
				console.log(data);
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
                    {
                        var details=$.parseJSON(data);
                        if(details.status == "success")
                        {
                           $(memberss.disuertype).html('<select class="form-control" name="usertype" required="" id="usertype" ><option value="all">ALL</option>'+details.data+'</select>'); 
                        }
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
    }
}
