function admindue()
{
    var due={};
    this.__construct = function(duectrl){
        due=duectrl;
        fetchDues();
    }
    function  fetchDues()
    {
        $(due.disdues).html(LOADER_ONE)
        $.ajax({
                type:'POST',
                url:due.url,
                data:{autoloader:true,action:'fetchadmindues',type:'master'},
                success:function(data, textStatus, xhr){
                        console.log(data);
                        data = $.trim(data);
                        console.log(xhr.status);
                        switch(data){
                                case 'logout':
                                        logoutAdmin({});
                                break;
                                case 'login':
                                        loginAdmin({});
                                break;
                                default:
                                        var res = $.parseJSON(data);
                                        if(res.status=="success")
                                        {
                                            var header='<table class="table table-striped table-bordered table-hover" id="list_dues_table">';
                                             var tableHeading='<thead><th>#</th><th>Owner Name</th><th>Mobile</th><th>Email</th><th>Username</th><th>Due Amount</th><th>Due Date</th><th>MOP</th><th>PAY</th></tr></thead><tbody>';
                                            var footer='</tbody></table>';
                                            $(due.disdues).html(header+tableHeading+res.data+footer);
                                            window.setTimeout(function (){
                                                $('#list_dues_table').dataTable();
                                                for(j=0;j<res.ids.length;j++)
                                                {
                                                $('#pay'+res.ids[j]).bind('click',{tuserpk : res.userpks[j],tdueamt: res.dueamount[j]},function(event){
                                                    var dueamount = event.data.tdueamt;
                                                    var userpk = event.data.tuserpk;
                                                }); 

                                                $('#payOk_'+res.ids[j]).bind('click',{tuserpk : res.userpks[j],tdueamt: res.dueamount[j],tids:res.ids[j]},function(event){
                                                    var dueamount = event.data.tdueamt;
                                                    var userpk = event.data.tuserpk;
                                                    var dueidd=event.data.tids;
                                                  payDues(dueamount,userpk,dueidd);
                                                });
                                                    }
                                            },400);
                                        }
                                        else
                                        {
                                            $(due.disdues).html('<span class="text-danger"><strong>no dues  ||||</strong></span>');
                                        }
                                break;
                        }
                },
                error:function(){
                        $(due.outputDiv).html(INET_ERROR);
                },
                complete: function(xhr, textStatus) {
                        console.log(xhr.status);
                }
        });
    }
     function payDues(amt,userpk,mopval)
    {
        var flag=false;
        if($('#duemop_'+mopval).val()=="")
        {
           $('#duemop_'+mopval).focus();
           alert("please select MOP");
           flag=false;
           return;
        }
        else
        {
            flag=true;
        }
        if(flag)
        {
           var attr={
          userpk  : userpk,
          amt     : amt,
          mop  : $('#duemop_'+mopval).val()
        };
        $.ajax({
                type:'POST',
                url:due.url,
                data:{autoloader:true,action:'payadmindues',type:'master',details: attr},
                success:function(data, textStatus, xhr){
                        console.log(data);
                        data = $.trim(data);
                        switch(data){
                                case 'logout':
                                        logoutAdmin({});
                                break;
                                case 'login':
                                        loginAdmin({});
                                break;
                                default:
                                        var res = $.parseJSON(data);
                                        if(res)
                                        {
                                          alert("Amount Has been Successfully Updated") ;
                                          fetchDues();
                                        }
                                        else
                                        {
                                        }
                                break;
                        }
                },
                error:function(){
                    alert("error");
                        $(due.outputDiv).html(INET_ERROR);
                },
                complete: function(xhr, textStatus) {
                        console.log(xhr.status);
                }
        });  
    };
    }
}
