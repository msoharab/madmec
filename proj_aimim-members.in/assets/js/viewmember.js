function viewmember()
{
    var memberss = {};
    this.__construct = function (membersctrl) {
        memberss = membersctrl;
        window.setTimeout(function () {
            fetchmembers();
        }, 400);
    };

    function fetchmembers()
    {
        $(memberss.displayviewmembers).html(LOADER_ONE);
        $.ajax({
            type: 'POST',
            url: memberss.url,
            data: {
                autoloader: true,
                action: 'fetchmembers'
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
                    default : {
                          var details=$.parseJSON(data);  
                          if(details.status=="success")
                          {
                              var header='<table class="table table-striped table-bordered table-hover" id="list_col_table"><thead><tr><th>#</th><th>Name</th><th>Mobile</th><th>Email</th><th>UserType</th><th>Address</th><th>Zipcode</th><th>Country</th></tr></thead><tbody>';
                              var footer='<tbody></table>';
                              $(memberss.displayviewmembers).html(header+details.data+footer);
                              window.setTimeout(function (){
                                  $('#list_col_table').dataTable();
                              },400)
                          }
                          else
                          {
                              $(memberss.displayviewmembers).html("<span><strong class='text-danger pull-centers'>no records</strong></span>"); 
                          }
                    };
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

