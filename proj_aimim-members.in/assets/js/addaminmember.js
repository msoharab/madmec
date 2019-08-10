function adminaddmember()
{
    var memberss = {};
    this.__construct = function (membersctrl) {
        memberss = membersctrl;
        window.setTimeout(function () {
            fetchusertype();
            $(memberss.dob).datepicker({
                dateFormat : 'yy-mm-dd',
                changeYear : true,
		changeMonth : true,
                yearRange : '-100 : +100',
                maxDate : 0
            });
           $(memberss.form).submit(function(evt){
              evt.preventDefault()
              var formdata=$(this).serialize();
               $.post(memberss.url,formdata+'&autoloader=true&action=addadminmember',function (o){
                   if(o)
                   {
                       alert("Details has been Successfully added");
                       $(memberss.form).get(0).reset();
                   }
                   else
                   {
                       alert("Details hasn't been Successfully added");
                       $(memberss.form).get(0).reset();
                   }
               },'json');
           });
        }, 400);
        
    }
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
                           $(memberss.disuertype).html('<select class="form-control" name="usertype" required="" id="usertype" ><option value="">Please select usertype</option>'+details.data+'</select>'); 
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
