function pharmacycontroller()
{
    var pharmacy = {};
	this.__construct = function(ctrl) {
            pharmacy=ctrl;
            fetchPharmacyPatientList();
            fetchmessagetypes();
            $(pharmacy.pharmcypatientmenuBut).click(function (){
                fetchPharmacyPatientList();
            });
            /* Message Chat */
            $(pharmacy.message.doctorinbox).click(function (){
               fetchMessageTypeChatDetails(window.localStorage.getItem("typeidd"));
            });
            $(pharmacy.message.doctorcompose).click(function (){
               fetchAllUserUnderType(window.localStorage.getItem("typeidd"));
            });
            /* End Message Chat */
        }
        /* Message Box Function Definition*/
        function  fetchmessagetypes()
        {
            $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchmessagetypes',
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
                var messagetype=$.parseJSON(data);
                var head='<a href="javascript:void(0);" class="dropdown-toggle" id="patientmessmenuBut" data-toggle="dropdown">Messages <span class="caret"></span></a><ul class="dropdown-menu" role="menu">'
                $(pharmacy.message.displaymessagetype).html(head+messagetype.data+' </ul>');
                window.setTimeout(function(){
                    for(i=0;i<messagetype.num;i++)
                    {
                        $('#messagetype'+i).bind('click',{id:messagetype.typenum[i]},function(event){
                            var typeid=event.data.id;
                            window.localStorage.setItem("typeidd",typeid);
                            $(".sub_container").slideUp(1000);
                            $("#patientmessages").slideDown(1500);
                            $('.navbar-toggle'+','+'.collapsed').trigger('click');
                            fetchMessageTypeChatDetails(typeid);
                        });
                    }
                },500)
                },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
		}); 
        }
        function fetchMessageTypeChatDetails(typeid){
            $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchmessagetypeschatdel',
                typeid      : typeid,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);   
                data = $.trim(data);
                var messagesdetails=$.parseJSON(data);
                var displaydetails="";
                $(pharmacy.message.displaychatdetails).html('');
                for(i=0;i<messagesdetails.messageids.length;i++)
                {
                  displaydetails += '<a href="javascript:void(0);" id="chathistory'+i+'">'+
                                    '<div class="col-lg-3 col-md-6">'+
                    '<div class="panel panel-primary">'+
                        '<div class="panel-heading">'+
                            '<div class="row">'+
                                '<div class="col-xs-3">'+
                                    '<img src="'+messagesdetails.photopath[i]+'" class="img-circle" width="50px" height="50px"></img>'+
                                '</div>'+
                                '<div class="col-xs-9 text-left">'+
                                    '<div>Name : '+messagesdetails.name[i]+'</div>'+
                                    '<div>Mobile : '+messagesdetails.mobile[i]+'</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
		'</a>';
                }
                $(pharmacy.message.displaychatdetails).html(displaydetails);
                chatDetails(messagesdetails,typeid)
                },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
		}); 
//            $('#displaychatdetails').html(header+body+footer);
            }
        function fetchAllUserUnderType(typeid)   
        {
          $(pharmacy.message.displaychatdetails).html(LOADER); 
          $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchalluserundertype',
                typeid      : typeid,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);
                data = $.trim(data);
                var messagesdetails=$.parseJSON(data);
                var displaydetails="";
                $(pharmacy.message.displaychatdetails).html('');
                for(i=0;i<messagesdetails.names.length;i++)
                {
                  if(messagesdetails.photos[i] == null || messagesdetails.photos[i] == "")
                  var photopath=USERPROFILE;
                  else
                  var photopath=messagesdetails.photos[i];
                  displaydetails += '<a href=javascript:void(0);" id="newchat'+i+'">'+
                                    '<div class="col-lg-3 col-md-6">'+
                    '<div class="panel panel-primary">'+
                        '<div class="panel-heading">'+
                            '<div class="row">'+
                                '<div class="col-xs-3">'+
                                    '<img src="'+photopath+'" class="img-circle" width="50px" height="50px" alt="photo"></img>'+
                                '</div>'+
                                '<div class="col-xs-9 text-left">'+
                                    '<div>Name : '+messagesdetails.names[i]+'</div>'+
                                    '<div>Mobile : '+messagesdetails.mobiles[i]+'</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
		'</a>';
                }
                $(pharmacy.message.displaychatdetails).html(displaydetails);
                window.setTimeout(function(){
                 for(i=0;i<messagesdetails.names.length;i++)
                 {
                    $('#newchat'+i).bind('click',{ttopk:messagesdetails.toids[i]},function(event){
                      var topk=event.data.ttopk;
                      openNewChatWindow(topk,typeid);
                    }) ;
                 }
                },500)
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				}); 
        }
        function openNewChatWindow(topk,typeid)
        {
           $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'checkforchathistory',
                topk        : topk,
                typeid      : typeid,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);   
                data=$.trim(data);
                var result=$.parseJSON(data);
                var header='<div class="chat-panel panel panel-default">'+
                        '<div class="panel-heading">'+
                        '<i class="fa fa-comments fa-fw"></i>'+
                        'Chat'+
                        '<div class="btn-group pull-right">'+
                        '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">'+
                                    '<i class="fa fa-chevron-down"></i>'+
                                '</button>'+
                                '<ul class="dropdown-menu slidedown">'+
                                    '<li>'+
                                        '<a href="#" id="chatrefresh">'+
                                            '<i class="fa fa-refresh fa-fw" ></i> Refresh'+
                                        '</a>'+
                                    '</li>'+
                                    '<li>'+
                                        '<a href="#" id="clearallchat">'+
                                            '<i class="fa fa-trash fa-fw"></i> clear all conversation'+
                                        '</a>'+
                                    '</li>'+
                                '</ul>'+
                            '</div></div>';
                    var footer= '<div class="panel-footer">'+
                            '<div class="input-group">'+
                                '<input id="inputchatmessage" type="text" class="form-control input-sm" placeholder="Type your message here..." />'+
                                '<span class="input-group-btn">'+
                                    '<button class="btn btn-warning btn-sm" id="btnchat">'+
                                       ' Send'+
                                    '</button>'+
                                '</span>'+
                           ' </div>'+
                       ' </div>'+
                        '<!-- /.panel-footer -->'+
                    '</div>'; 
                    var bodyhead='<div class="panel-body">'+
                            '<ul class="chat">';
                    var bodyfoot='</ui></div>';
                    var body="";
                if(Number(result.messid))
                {
                // open old chating history   
                if(result.photopath == null ||  result.photopath == "")
                    var photopath=USERPROFILE;
                 else
                    var photopath=result.photopath ;
                    refreshchatHistory(result.messid,header,bodyhead,bodyfoot,footer,photopath,result.name,typeid);  
                }
                else
                {
                // open new  chating history  
                $(pharmacy.message.displaychatdetails).html(header+bodyhead+body+bodyfoot+footer);
                window.setTimeout(function (){
                        $(pharmacy.message.btnchat).click(function(){
                            startNewChat(topk,result.messid,header,bodyhead,bodyfoot,footer,result.photopath,result.name,typeid);
                        });
                    },500)
                }
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
	});   
        }
        function startNewChat(topk,messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid)
        {
            alert(typeid);
            var flag=false;
           if($(pharmacy.message.inputchatmessage).val()=="") 
           {
              flag=false;
              $(pharmacy.message.inputchatmessage).focus();
           }
           else
           {
               flag=true;
           }
           if(flag)
           {
               var attr={
                   topk     : topk,
                   typeid   : typeid,
                   message  : $(pharmacy.message.inputchatmessage).val(),
               }
             $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'startnewChat',
                details      : attr,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);   
                data = $.trim(data);
                var messid=Number($.parseJSON(data));
                if(messid)
                {
               refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid)    
                }
                else
                {
                    alert("error");
                }
                },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
		});   
           }
        }
        function chatDetails(messagesdetails,typeid){
            window.setTimeout(function (){
                    var header='<div class="chat-panel panel panel-default">'+
                        '<div class="panel-heading">'+
                        '<i class="fa fa-comments fa-fw"></i>'+
                        'Chat'+
                        '<div class="btn-group pull-right">'+
                        '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">'+
                                    '<i class="fa fa-chevron-down"></i>'+
                                '</button>'+
                                '<ul class="dropdown-menu slidedown">'+
                                    '<li>'+
                                        '<a href="#" id="chatrefresh">'+
                                            '<i class="fa fa-refresh fa-fw" ></i> Refresh'+
                                        '</a>'+
                                    '</li>'+
                                    '<li>'+
                                        '<a href="#" id="clearallchat">'+
                                            '<i class="fa fa-trash fa-fw"></i> clear all conversation'+
                                        '</a>'+
                                    '</li>'+
                                '</ul>'+
                            '</div></div>';
                    var footer= '<div class="panel-footer">'+
                            '<div class="input-group">'+
                                '<input id="inputchatmessage" type="text" class="form-control input-sm" placeholder="Type your message here..." />'+
                                '<span class="input-group-btn">'+
                                    '<button class="btn btn-warning btn-sm" id="btnchat">'+
                                       ' Send'+
                                    '</button>'+
                                '</span>'+
                           ' </div>'+
                       ' </div>'+
                        '<!-- /.panel-footer -->'+
                    '</div>'; 
                    var bodyhead='<div class="panel-body">'+
                            '<ul class="chat">';
                    var bodyfoot='</ui></div>';
                    var body="";
                    for(i=0;i<messagesdetails.messageids.length;i++)
                    {
                    $('#chathistory'+i).bind('click',{id:messagesdetails.messageids[i],tphotopath : messagesdetails.photopath[i],tmessages:messagesdetails.messages[i],tname:messagesdetails.name[i],tfrommess:messagesdetails.messagefrom[i],tuserid:messagesdetails.userid,tmsgtime: messagesdetails.msgtime[i]},function(event){
                        var messid=event.data.id;
                        var photopath=event.data.tphotopath;
                        var message=(event.data.tmessages).toString();
                        var name=event.data.tname;
                        var frommessage=event.data.tfrommess;
                        var userid=event.data.tuserid;
                        var msgtime=event.data.tmsgtime;
                        var messages=new Array();
                        var frommessages=new Array();
                        var msgtimes=new Array();
                        messages=message.toString().split(',');
                        frommessages=frommessage.split(',');
                        msgtimes=msgtime.split(',');
                        for(k=0;k<messages.length;k++)
                        {
                            if(Number(userid) == Number(frommessages[k]))
                            {
                        body +='<li class="right clearfix">'+
                                    '<span class="chat-img pull-right">'+
                                        '<img src="'+photopath+'" alt="User Avatar" class="img-circle" width="50px" height="50px"/>'+
                                    '</span>'+
                                    '<div class="chat-body clearfix">'+
                                        '<div class="header">'+
                                            '<small class=" text-muted">'+
                                                '<i class="fa fa-clock-o fa-fw"></i> '+msgtimes[k]+'</small>'+
                                            '<strong class="pull-right primary-font">me</strong>'+
                                        '</div>'+
                                        '<p>'+
                                            messages[k]+
                                        '</p>'+
                                    '</div>'+
                                '</li><hr/>';
                             }
                             else
                             {
                        body +='<li class="left clearfix">'+
                                    '<span class="chat-img pull-left">'+
                                        '<img src="'+photopath+'" alt="User Avatar" class="img-circle" width="50px" height="50px" />'+
                                    '</span>'+
                                    '<div class="chat-body clearfix">'+
                                        '<div class="header">'+
                                            '<strong class="primary-font">'+name+'</strong> '+
                                            '<small class="pull-right text-muted">'+
                                                '<i class="fa fa-clock-o fa-fw"></i> '+msgtimes[k]+'</small>'+
                                        '</div>'+
                                        '<p>'+
                                            messages[k]+
                                        '</p>'+
                                    '</div>'+
                                '</li><hr/>';
                             }
                        }
                        $(pharmacy.message.displaychatdetails).html(header+bodyhead+body+bodyfoot+footer);
                        $(pharmacy.message.chatrefresh).click(function(){
                            refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                        $(pharmacy.message.clearallchat).click(function(){
                            clearChatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                        $(pharmacy.message.btnchat).click(function(){
                            sendChatMessage(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                    });
                    }
                },500)
        }
        function refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid)
        {
            $(pharmacy.message.displaychatdetails).html(LOADER);
         $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'refreshchatHistory',
                messid      : messid,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
                var chatdata=$.parseJSON(data);
                        var body="";
                        var messages=new Array();
                        var frommessages=new Array();
                        var msgtimes=new Array();
                        var message=chatdata.messages;
                        var frommessage=chatdata.frommess;
                        var msgtime=chatdata.messtime;
                        var userid=chatdata.userid;
                        messages=message.toString().split(',');
                        frommessages=frommessage.toString().split(',');
                        msgtimes=msgtime.toString().split(',');
                        if(message != "")
                        {
                        for(k=0;k<messages.length;k++)
                        {
                            if(Number(userid) == Number(frommessages[k]))
                            {
                        body +='<li class="right clearfix">'+
                                    '<span class="chat-img pull-right">'+
                                        '<img src="'+chatdata.userphoto+'" alt="User Avatar" class="img-circle" width="50px" height="50px"/>'+
                                    '</span>'+
                                    '<div class="chat-body clearfix">'+
                                        '<div class="header">'+
                                            '<small class=" text-muted">'+
                                                '<i class="fa fa-clock-o fa-fw"></i> '+msgtimes[k]+'</small>'+
                                            '<strong class="pull-right primary-font">me</strong>'+
                                        '</div>'+
                                        '<p>'+
                                            messages[k]+
                                        '</p>'+
                                    '</div>'+
                                '</li><hr/>';
                             }
                             else
                             {
                        body +='<li class="left clearfix">'+
                                    '<span class="chat-img pull-left">'+
                                        '<img src="'+photopath+'" alt="User Avatar" class="img-circle" width="50px" height="50px" />'+
                                    '</span>'+
                                    '<div class="chat-body clearfix">'+
                                        '<div class="header">'+
                                            '<strong class="primary-font">'+name+'</strong> '+
                                            '<small class="pull-right text-muted">'+
                                                '<i class="fa fa-clock-o fa-fw"></i> '+msgtimes[k]+'</small>'+
                                        '</div>'+
                                        '<p>'+
                                            messages[k]+
                                        '</p>'+
                                    '</div>'+
                                '</li><hr/>';
                             }
                        }
                    }
                    $(pharmacy.message.displaychatdetails).html(header+bodyhead+body+bodyfoot+footer);
                    window.setTimeout(function (){
                        $(pharmacy.message.chatrefresh).click(function(){
                            refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                         $(pharmacy.message.clearallchat).click(function(){
                            clearChatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                        $(pharmacy.message.btnchat).click(function(){
                            sendChatMessage(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                    },500)
                },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
		});   
        }
        function clearChatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid)
        {
            $(pharmacy.message.displaychatdetails).html(LOADER);
            $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'clearchathistory',
                messid      : messid,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);   
                refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name)
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }
        function sendChatMessage(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid)
        {
           var flag=false;
           if($(pharmacy.message.inputchatmessage).val()=="")
           {
            $(pharmacy.message.inputchatmessage).focus();
            flag=false;
            return 
           }
           else
           {
               flag=true;
           }
           if(flag)
           {
             $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'sendchatmessage',
                messid      : messid,
                message     : $(pharmacy.message.inputchatmessage).val(),
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
                    refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid)
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});   
           }
        }
        function fetchPharmacyPatientList()
        {
            var htm='';
           $(pharmacy.ppharmcypatientDisplay).html(LOADER);
            var htm='';
          $.ajax({
                url: pharmacy.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpharmacypatientdetails',
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    for(i=0;i<ppdetails.pdata.length;i++)
                    {
                       htm += ppdetails.pdata[i]
                    }
                    $(pharmacy.pharmcypatientDisplay).html(ppdetails.divheader+htm+ppdetails.divfooter);
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				}); 
        }
    }

