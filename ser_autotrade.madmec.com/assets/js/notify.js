function notifyController(){
	var ntfy={};
	this.__construct = function(notify_list){
	ntfy = notify_list;
	console.log("am in display notification");

        fetchNotifications();
	}
		function  fetchNotifications()
		{
                    $(ntfy.displaynotifications).html(LOADER_FIV);
                   $.ajax({
                type:'POST',
                url:ntfy.url,
                data:{autoloader:true,action:'fetchadminnotify',type:'master'},
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
                                        if(res.status=="success")
                                        {
                                          $(ntfy.displaynotifications).html(res.data);
                                          window.setTimeout(function (){
                                              $('#listnotifycations-example').dataTable();
                                          });
                                        }
                                        else
                                        {
                                            $(ntfy.displaynotifications).html('<span class="text-danger"><strong>no Notification .....!!!!!!</strong>');
                                        }
                                break;
                        }
                },
                error:function(){
                        $(ntfy.outputDiv).html(INET_ERROR);
                },
                complete: function(xhr, textStatus) {
                        console.log(xhr.status);
                }
					}); 
                }
	}
