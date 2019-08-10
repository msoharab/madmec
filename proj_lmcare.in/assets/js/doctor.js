function doctorcontroller()
{
    var doctor = {};
	this.__construct = function(ctrl) {
                    doctor = ctrl;
                    intialization();
                    fetchmessagetypes();
                    $(doctor.doctor_infor.doctor_next1).click(function (){
                        adddoctorinfo();
                    })
                    $(doctor.patientregistration.patientsubmitBut).click(function (){
                        addpatientdetails();
                    }) 
                    $(doctor.pharmacyregistration.pharmacysubmitBut).click(function (){
                        addPharmacydetails();
                    })
                    $(doctor.diagnosticregistration.diagnosticsubmitBut).click(function (){
                        addDiagnosticdetails();
                    })
                    $(doctor.patient.patientdetails).click(function (){
                        fetchpatientdetails();
                    })
                    $('#dateee').datepicker({
                        changeMonth: true,
                        changeYear : true,
                        dateFormat: 'yy-mm-dd',
                        showButtonPanel : true,
                    });
                    $(doctor.diagnostic.diagnosticdetails).click(function (){
                        $(doctor.diagnostic.configdiagnostic).show();
                        $(doctor.diagnostic.diagnostic_list).hide();
                        $(doctor.diagnostic.diagnosticsubtypedisplay).html('');
                        fetchdiagnosticpatients();
                        fetchTestCategory();
                    })
                    $(doctor.diagnostic.listofdiagnosticmenuBut).click(function (){
                        $(doctor.diagnostic.configdiagnostic).hide();
                        $(doctor.diagnostic.diagnostic_list).show();
                        fetchdiagnosticsdetails();
                    })
                    $(doctor.diagnostic.diagnosticsendmenuBut).click(function (){
                         $(doctor.diagnostic.configdiagnostic).show();
                        $(doctor.diagnostic.diagnostic_list).hide();
                    })
                    $(doctor.pharmacy.pharmacydetails).click(function (){
                        fetchPharmacydetails();
                    })
                    $(doctor.registration.registrationmenu).click(function (){
                        fetchusertypes();
                    });
                    $(doctor.prescibtion.prescribtionmenudiv).click(function (){
                        fetchpateintandpharmacy();
                    })
                    $(doctor.prescibtion.plus).click(function (){
                        $(doctor.prescibtion.plus).hide();
                        buildMultipleTablets();
                    });
                    $(doctor.prescibtion.prescribtionsubmitBut).click(function (){
                        var flag=true;
                       addprescribtion(flag); 
                    });
                    $(doctor.patientassesment.patientassesmentmenuBut).click(function (){
                        $(doctor.patientassesment.patienthistrydispl).html('');
                        fetchpassmentpatient();
                        fetchbloodgroupandhabbit();
                    })
                    $(doctor.patientassesment.passesmentsubmitBut).click(function (){
                        addpatientassesment();
                    });
                    $(doctor.appointment.appointmentmenuBut).click(function (){
                       $(doctor.appointment.appointconfig).show(); 
                       $(doctor.appointment.appointview).hide();
                       $(doctor.appointment.appointedit).hide();
                       $(doctor.appointment.appointbutton).hide();
                       $(doctor.appointment.appointconfgmsg).html('');
                       fetchconfiguredappointment();
                    });
                    $(doctor.appointment.appointconfigBut).click(function (){
                       $(doctor.appointment.appointconfig).show(); 
                       $(doctor.appointment.appointview).hide();
                       $(doctor.appointment.appointedit).hide();
			fetchconfiguredappointment();
                       var numbb=$(doctor.appointment.num)
                       for(i=0;i<=numbb;i++)
                        {
                         $('#'+doctor.appointment.form +i).remove(); 
                         doctor.appointment.j--;
                         doctor.appointment.num--;
                        }
                        $(doctor.appointment.plus).show();
                       $(doctor.appointment.appointconfgmsg).html('');
                                          });
                    $(doctor.appointment.appointviewBut).click(function (){
                       $(doctor.appointment.appointconfig).hide(); 
                       $(doctor.appointment.appointview).show();
                       $(doctor.appointment.appointedit).hide();
                       showAppointmentDetails();
                       $(doctor.appointment.appointconfgmsg).html('');
                    });
                    $(doctor.appointment.appointeditBut).click(function (){
                       $(doctor.appointment.appointconfig).hide(); 
                       $(doctor.appointment.appointview).hide();
                       $(doctor.appointment.appointedit).show();
                       showAppointmentEditDetails()
                    });
                    $(doctor.appointment.plus).click(function (){
                        $(doctor.appointment.plus).hide();
                        $(doctor.appointment.appointbutton).show();
                        buildMultipleSlots();
                    })
                    $(doctor.appointment.appointsubmitBut).click(function() {
                        configureappointment();
                    });
                    $(doctor.sendpatienthistory.sendpathistmenuBut).click(function (){
                       fetchSendPatientList(); 
                    }); 
                    $(doctor.sendpatienthistory.sendpatientSubmitBut).click(function (){
                       sendPatientHistory(); 
                    });
                    /* Message Chat */
                    $(doctor.message.doctorinbox).click(function (){
                       fetchMessageTypeChatDetails(window.localStorage.getItem("typeidd"));
                    });
                    $(doctor.message.doctorcompose).click(function (){
                       fetchAllUserUnderType(window.localStorage.getItem("typeidd"));
                    });
                    $(doctor.patientregistration.patientphoto).change(function (){
                        var count = 0;
                        var img='';
                        var val = $.trim( $(doctor.patientregistration.patientphoto).val() );
                                if( val == '' ){
                                        count= 1;
                                        $(doctor.patientregistration.patientphotomsg).html(INVALIDNOT);
                                }
                        if(count == 0){
                                        for (var i = 0; i < $(doctor.patientregistration.patientphoto).get(0).files.length; ++i) {
                                        img = $(doctor.patientregistration.patientphoto).get(0).files[i].name;
                                        var extension = img.split('.').pop().toUpperCase();
                                        if(extension!="PNG" && extension!="JPG" && extension!="GIF" && extension!="JPEG"){
                                                count= count+ 1
                                        }
                                    }
                                        if( count> 0) $( doctor.patientregistration.patientphotomsg ).html(INVALIDNOT);
                                        else
                                        $( doctor.patientregistration.patientphotomsg ).html('');    
                                }
                            if(count == 0) {   
                        $(doctor.patientregistration.patientregform).ajaxForm(
                    {
                    }).submit();
                            }
                    })
               }
        function intialization()
        {   
            $(doctor.patientregistration.patientname).keyup(function (){
            if($(doctor.patientregistration.patientname).val()=="")
                {
                flag=false;
                $(doctor.patientregistration.patientnamemsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientnamemsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.patientregistration.patientnamemsg).html('');
                flag=true;  
                }
            if($(doctor.patientregistration.patientname).val().match(namee_reg))
                {
                $(doctor.patientregistration.patientnamemsg).html('');
                flag=true; 
                } 
                else
                {
                flag=false;
                $(doctor.patientregistration.patientnamemsg).html(INVALIDNOT+CHARACTERMSG);
                $(doctor.patientregistration.patientname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientnamemsg).offset().top) - 95
				}, 'slow');
                return;
                }
            });
            $(doctor.patientregistration.patientage).keyup(function(){
            if($(doctor.patientregistration.patientage).val()== "" || Number($(doctor.patientregistration.patientage).val())==0 || $(doctor.patientregistration.patientage).val().length >3)
                {
                flag=false;
                $(doctor.patientregistration.patientagemsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientage).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientagemsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.patientregistration.patientagemsg).html('');
                flag=true;  
                } 
             if($(doctor.patientregistration.patientage).val().match(numbs) )
                {
                $(doctor.patientregistration.patientagemsg).html('');
                flag=true;      
                } 
                else
                {
                flag=false;
                $(doctor.patientregistration.patientagemsg).html(INVALIDNOT+INTEGERMSG);
                $(doctor.patientregistration.patientage).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientagemsg).offset().top) - 95
				}, 'slow');
                return;
                } 
            })
            $(doctor.patientregistration.patientcellnum).keyup(function (){
            
            if($(doctor.patientregistration.patientcellnum).val()=="" || Number($(doctor.patientregistration.patientcellnum).val())==0)
                {
                flag=false;
                $(doctor.patientregistration.patientcellnummsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientcellnum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientcellnummsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.patientregistration.patientcellnummsg).html('');
                flag=true;  
                }  
            });
            $(doctor.patientregistration.patientgname).keyup(function (){
            
            if($(doctor.patientregistration.patientgname).val()!="" )
                {
                   if($(doctor.patientregistration.patientgname).val().match(namee_reg) ) 
                   {
                    flag=true;
                    $(doctor.patientregistration.patientgnamemsg).html(''); 
                   }
                 else
                 {
                    flag=false;
                    $(doctor.patientregistration.patientgnamemsg).html(INVALIDNOT);
                    $(doctor.patientregistration.patientgname).focus();
                    $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientgnamemsg).offset().top) - 95
				}, 'slow');
                return;
                }
                }
                    
            })
            $(doctor.patientregistration.patientgcellnum).keyup(function (){
            
                if($(doctor.patientregistration.patientgcellnum).val()!="" )
                {
                   if($(doctor.patientregistration.patientgcellnum).val().match(cell_reg) ) 
                   {
                    flag=true;
                    $(doctor.patientregistration.patientgcellnummsg).html(''); 
                   }
                 else
                 {
                    flag=false;
                    $(doctor.patientregistration.patientgcellnummsg).html(INVALIDNOT);
                    $(doctor.patientregistration.patientgcellnum).focus();
                    $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientgcellnummsg).offset().top) - 95
				}, 'slow');
                return;
                }
                }
            });
            $(doctor.diagnosticregistration.dpname).keyup(function (){
            if($(doctor.diagnosticregistration.dpname).val()=="")
            {
                flag=false;
                $(doctor.diagnosticregistration.dpnamemsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.dpname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dpnamemsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.diagnosticregistration.dpnamemsg).html('');
            }
            if($(doctor.diagnosticregistration.dpname).val().match(namee_reg))
            {
                 flag=true;
                 $(doctor.diagnosticregistration.dpnamemsg).html('');
            }
            else
            {
                flag=false;
                $(doctor.diagnosticregistration.dpnamemsg).html(INVALIDNOT+CHARACTERNSPACEMSG);
                $(doctor.diagnosticregistration.dpname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dpnamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            });
            $(doctor.diagnosticregistration.dphonenum).keyup(function (){
            if($(doctor.diagnosticregistration.dphonenum).val()=="" || Number($(doctor.diagnosticregistration.dphonenum).val())==0)
            {
                flag=false;
                $(doctor.diagnosticregistration.dphonenummsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.dphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dphonenummsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.diagnosticregistration.dphonenummsg).html('');
            }
            if($(doctor.diagnosticregistration.dphonenum).val().match(numbs))
            {
                flag=true;
                $(doctor.diagnosticregistration.dphonenummsg).html('');  
            }
            else
            {
               flag=false;
                $(doctor.diagnosticregistration.dphonenummsg).html(INVALIDNOT+INTEGERMSG);
                $(doctor.diagnosticregistration.dphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dphonenummsg).offset().top) - 95
				}, 'slow');
                return; 
            }
            });
            $(doctor.pharmacyregistration.ppname).keyup(function (){
            if($(doctor.pharmacyregistration.ppname).val()=="")
            {
                flag=false;
                $(doctor.pharmacyregistration.ppnamemsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.ppname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.ppnamemsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.pharmacyregistration.ppnamemsg).html('');
            }
            if($(doctor.pharmacyregistration.ppname).val().match(namee_reg))
            {
                 flag=true;
                 $(doctor.pharmacyregistration.ppnamemsg).html('');
            }
            else
            {
                flag=false;
                $(doctor.pharmacyregistration.ppnamemsg).html(INVALIDNOT+CHARACTERNSPACEMSG);
                $(doctor.pharmacyregistration.ppname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.ppnamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            });
            $(doctor.pharmacyregistration.pphonenum).keyup(function (){
            if($(doctor.pharmacyregistration.pphonenum).val()=="" || Number($(doctor.pharmacyregistration.pphonenum).val())==0)
            {
                flag=false;
                $(doctor.pharmacyregistration.pphonenummsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.pphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pphonenummsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.pharmacyregistration.pphonenummsg).html('');
            }
            if($(doctor.pharmacyregistration.pphonenum).val().match(numbs))
            {
                flag=true;
                $(doctor.pharmacyregistration.pphonenummsg).html('');  
            }
            else
            {
               flag=false;
                $(doctor.pharmacyregistration.pphonenummsg).html(INVALIDNOT+INTEGERMSG);
                $(doctor.pharmacyregistration.pphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pphonenummsg).offset().top) - 95
				}, 'slow');
                return; 
            }
            })
        }
        function  fetchmessagetypes()
        {
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchmessagetypes',
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
                var messagetype=$.parseJSON(data);
                var head='<a class="dropdown-toggle" id="docmessmenuBut" data-toggle="dropdown">Messages <span class="caret"></span></a><ul class="dropdown-menu" role="menu">'
                $(doctor.message.displaymessagetype).html(head+messagetype.data+' </ul>');
                window.setTimeout(function(){
                    for(i=0;i<messagetype.num;i++)
                    {
                        $('#messagetype'+i).bind('click',{id:messagetype.typenum[i]},function(event){
                            var typeid=event.data.id;
                            window.localStorage.setItem("typeidd",typeid);
                            $(".sub_container").slideUp(1000);
                            $("#doctormessages").slideDown(1500);
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
                url: doctor.url,
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
                $(doctor.message.displaychatdetails).html('');
                for(i=0;i<messagesdetails.messageids.length;i++)
                {
                  displaydetails += '<a href="#" id="chathistory'+i+'">'+
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
                $(doctor.message.displaychatdetails).html(displaydetails);
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
          $(doctor.message.displaychatdetails).html(LOADER); 
          $.ajax({
                url: doctor.url,
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
                $(doctor.message.displaychatdetails).html('');
                for(i=0;i<messagesdetails.names.length;i++)
                {
                 if(messagesdetails.photos[i] == null || messagesdetails.photos[i] == "")
                  var photopath=USERPROFILE;
                  else
                  var photopath=messagesdetails.photos[i];
                  displaydetails += '<a href="javascript:void(0);" id="newchat'+i+'">'+
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
                $(doctor.message.displaychatdetails).html(displaydetails);
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
                url: doctor.url,
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
                    if(result.photopath== null ||result.photopath == "")
                  var photopath=USERPROFILE;
                  else
                  var photopath=result.photopath;
                  refreshchatHistory(result.messid,header,bodyhead,bodyfoot,footer,photopath,result.name,typeid);  
                }
                else
                {
                // open new  chatinng history  
                $(doctor.message.displaychatdetails).html(header+bodyhead+body+bodyfoot+footer);
                window.setTimeout(function (){
                        $(doctor.message.btnchat).click(function(){
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
            var flag=false;
           if($(doctor.message.inputchatmessage).val()=="") 
           {
              flag=false;
              $(doctor.message.inputchatmessage).focus();
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
                   message  : $(doctor.message.inputchatmessage).val(),
               }
             $.ajax({
                url: doctor.url,
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
                    $('#chathistory'+i).bind('click',{id:messagesdetails.messageids[i],tphotopath : messagesdetails.photopath[i],tmessages:messagesdetails.messages[i],tname:messagesdetails.name[i],tfrommess:messagesdetails.messagefrom[i],tuserid:messagesdetails.userid,tuserphoto:messagesdetails.userphoto,tmsgtime: messagesdetails.msgtime[i]},function(event){
                        var messid=event.data.id;
                        var photopath=event.data.tphotopath;
                        var message=(event.data.tmessages).toString();
                        var name=event.data.tname;
                        var frommessage=event.data.tfrommess;
                        var userid=event.data.tuserid; 
                        var userphoto=event.data.tuserphoto;
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
                                        '<img src="'+userphoto+'" alt="User Avatar" class="img-circle" width="50px" height="50px"/>'+
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
                        $(doctor.message.displaychatdetails).html(header+bodyhead+body+bodyfoot+footer);
                        $(doctor.message.chatrefresh).click(function(){
                            refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                        $(doctor.message.clearallchat).click(function(){
                            clearChatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                        $(doctor.message.btnchat).click(function(){
                            sendChatMessage(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                    });
                    }
                },500)
        }
        function refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid)
        {
            $(doctor.message.displaychatdetails).html(LOADER);
         $.ajax({
                url: doctor.url,
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
                    $(doctor.message.displaychatdetails).html(header+bodyhead+body+bodyfoot+footer);
                    window.setTimeout(function (){
                        $(doctor.message.chatrefresh).click(function(){
                            refreshchatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                         $(doctor.message.clearallchat).click(function(){
                            clearChatHistory(messid,header,bodyhead,bodyfoot,footer,photopath,name,typeid);
                        });
                        $(doctor.message.btnchat).click(function(){
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
            $(doctor.message.displaychatdetails).html(LOADER);
            $.ajax({
                url: doctor.url,
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
           if($(doctor.message.inputchatmessage).val()=="")
           {
            $(doctor.message.inputchatmessage).focus();
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
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'sendchatmessage',
                messid      : messid,
                message     : $(doctor.message.inputchatmessage).val(),
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
        function fetchconfiguredappointment()
        {
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchconfiguredappointment',
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                        if(ppdetails.num !=7)
                        {
                            $(doctor.appointment.displayconfigslot).html(ppdetails.data);
                        }
						else
						{
							$(doctor.appointment.displayconfigslot).html('<h4>Already Configured, please goto Edit</h4>');
						}
                        if(ppdetails.num ==0)
                        {
                           $(doctor.appointment.displayconfigslot).html(ppdetails.data);
                        }
                        window.setTimeout(function (){
                        $(doctor.appointment.appointbutton).hide();
                       $(doctor.appointment.plus).click(function (){
                        $(doctor.appointment.plus).hide();
                        $(doctor.appointment.appointbutton).show();
                        buildMultipleSlots();
                        });
                        },300)
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				}); 
        }
        function sendPatientHistory()
        {
           var flag=false;
          if($(doctor.sendpatienthistory.sendpatientid).val()=="")
          {
             flag=false;
             $(doctor.sendpatienthistory.sendpatientidmsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.sendpatienthistory.sendpatientidmsg).offset().top) - 95
				}, 'slow');
             $(doctor.sendpatienthistory.sendpatientid).focus();                   
             return 
          }
          else
          {
              $(doctor.sendpatienthistory.sendpatientidmsg).html('');
              flag=true;
          } 
          if($(doctor.sendpatienthistory.sendpatientemail).val()=="" || (!$(doctor.sendpatienthistory.sendpatientemail).val().match(email_reg)))
          {
             flag=false;
             $(doctor.sendpatienthistory.sendpatientemailmsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.sendpatienthistory.sendpatientemailmsg).offset().top) - 95
				}, 'slow');
             $(doctor.sendpatienthistory.sendpatientemail).focus();                   
             return 
          }
          else
          {
              $(doctor.sendpatienthistory.sendpatientemailmsg).html('');
              flag=true;
          } 
          if(flag)
          {
              $(doctor.sendpatienthistory.sendpatientSubmitBut).prop('disabled', 'disabled');
              $(doctor.sendpatienthistory.sendpatientSubmitButmsg).html(LOADER);
           var attr={
               patientid : $(doctor.sendpatienthistory.sendpatientid).val(),
               email     : $(doctor.sendpatienthistory.sendpatientemail).val(), 
           }
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'sendPatienthis',
                inputinfo   : attr
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    alert("email have been successfully Sent");
                    $(doctor.sendpatienthistory.form).get(0).reset();
                    $(doctor.sendpatienthistory.sendpatientSubmitButmsg).html('');
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
                    $(doctor.sendpatienthistory.sendpatientSubmitBut).removeAttr('disabled');
			}
				}); 
          }
        }
        function fetchSendPatientList(){
            $(doctor.sendpatienthistory.displaysendpatienhis).html(LOADER);
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpassesmentpatient',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(doctor.sendpatienthistory.displaysendpatienhis).html('<select id="sendpatientid" class="form-control"><option value="">Please Select Patient</option>'+ppdetails.pdetails+'</select>');
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }       
        function fetchTestCategory()
        {
            $(doctor.diagnostic.diagnosticcatedisplay).html(LOADER);
           $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchtestcate',
		},
		success: function(data, textStatus, xhr) {
//                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(doctor.diagnostic.diagnosticcatedisplay).html('<select id="diagnosticcatid" class="form-control"><option value="">Please select the Test Category</option>'+ppdetails+'</select');
                        window.setTimeout(function (){
                          $('#'+doctor.diagnostic.diagnosticcatid).change(function (){
                              var id=$('#'+doctor.diagnostic.diagnosticcatid).val();
                              fetchSubTypeOfTest(id);
                          });  
                        }) ;   
                            break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }
        function fetchSubTypeOfTest(cid){
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchsubtypeoftest',
                catid       : cid,
		},
		success: function(data, textStatus, xhr) {
//                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(doctor.diagnostic.diagnosticsubtypedisplay).html('<label>Select Test </label> <br/>'+ppdetails.testdata+'<br/><button type="button" id="diagnosticSubmitBut" class="btn btn-danger">submit</button>');
                         var nooftests=ppdetails.nooftests;
                            window.setTimeout(function (){
                            $('#'+doctor.diagnostic.diagnosticSubmitBut).click(function (){
                                addDiagnostictoPatient(nooftests);
                            })  
                          },300)  
                            break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				}); 
        }
        function addDiagnostictoPatient(nooftests)
        {
            var tests=[];
            var flag=false;
            if($('#'+doctor.diagnostic.diagnosticpatientid).val()=="")
            {
            flag=false;
             $(doctor.diagnostic.diagnosticpatientidmsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.diagnostic.diagnosticpatientidmsg).offset().top) - 95
				}, 'slow');
             $(doctor.diagnostic.diagnosticpatientid).focus();                   
             return 
          }
          else
          {
              $(doctor.diagnostic.diagnosticpatientidmsg).html('');
              flag=true;
          }
          if($('#'+doctor.diagnostic.diagnosticidd).val()=="")
            {
            flag=false;
             $(doctor.diagnostic.diagnosticiddmsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.diagnostic.diagnosticiddmsg).offset().top) - 95
				}, 'slow');
             $(doctor.diagnostic.diagnosticidd).focus();                   
             return 
          }
          else
          {
              $(doctor.diagnostic.diagnosticiddmsg).html('');
              flag=true;
          }
          if($('#'+doctor.diagnostic.diagnosticcatid).val()=="")
            {
            flag=false;
             $(doctor.diagnostic.diagnosticcatidmsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.diagnostic.diagnosticcatidmsg).offset().top) - 95
				}, 'slow');
             $(doctor.diagnostic.diagnosticcatid).focus();                   
             return 
          }
          else
          {
              $(doctor.diagnostic.diagnosticcatidmsg).html('');
              flag=true;
          }
        var checkValues = $('input[name=patienttestdiag]:checked').map(function()
            {
                return $(this).val();
            }).get();
        if(checkValues.length == 0)
        {
            flag=false;
            alert("Please Select Test")
            $('html, body').animate({
					scrollTop: Number($(doctor.diagnostic.diagnosticcatidmsg).offset().top) - 95
				}, 'slow');
             $(doctor.diagnostic.diagnosticcatid).focus(); 
            
        }
        else
        {
           flag=true; 
        }
          if(flag)
          {
              $('#'+doctor.diagnostic.diagnosticSubmitBut).prop('disabled','disabled');
              $(doctor.diagnostic.diagnosticpatientsubmitmsg).html(LOADER);
              var attr={
                pid     : $('#'+doctor.diagnostic.diagnosticpatientid).val(),
                diagid  : $('#'+doctor.diagnostic.diagnosticidd).val(),
                tests   : checkValues,
                  
              }
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'adddiagtopatient',
                inputinfo   : attr,
		},
		success: function(data, textStatus, xhr) {
//                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                        alert("Test has been Added to Patient History");
                        $(doctor.diagnostic.diagform).get(0).reset();
                           break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
                    $('#'+doctor.diagnostic.diagnosticSubmitBut).removeAttr('disabled');
                    $(doctor.diagnostic.diagnosticpatientsubmitmsg).html('');
			}
				});  
          }
        }
        function fetchdiagnosticpatients()
        {
            $(doctor.diagnostic.diadpatientdis).html(LOADER);
            $(doctor.diagnostic.diacenterlistdis).html(LOADER);
          $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpassesmentpatient',
		},
		success: function(data, textStatus, xhr) {
//                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(doctor.diagnostic.diadpatientdis).html('<select id="diagnosticpatientid" class="form-control"><option value="">Please select the patient</option>'+ppdetails.pdetails+'</select');
                    $(doctor.diagnostic.diacenterlistdis).html('<select id="diagnosticidd" class="form-control"><option value="">Please select the Diagnostics</option>'+ppdetails.diagnostic+'</select');    
                            break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }
        function showAppointmentDetails()
        {
            $(doctor.appointment.appointview).html(LOADER);
            var htm='';
         $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchappointmentdetails',
		},
		success: function(data, textStatus, xhr) {
//                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    for(i=0;i<ppdetails.pdata.length;i++)
                    {
                      htm += ppdetails.pdata[i];  
                    }
                    $(doctor.appointment.appointview).html(ppdetails.divheader+htm+ppdetails.divfooter);
                        break;
			}
                        window.setTimeout(function (){
                            for(i=0;i<ppdetails.appids.length;i++)
                     {
                         $('#'+doctor.appointment.viewappointee+ppdetails.appids[i]).bind('click',{id:ppdetails.appids[i],datee:ppdetails.dates[i]},function(event){
                           var apptid = event.data.id;
                           var date=event.data.datee;
                          fetchAppointeeDetails(apptid,date);
                         })
                     }
                        },300);
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});  
        } 
        function fetchAppointeeDetails(appid,date)
        {
            var attr={
                appid : appid,
                date  : date,
            }
           $.ajax({
                        url: doctor.url,
                        type: 'POST',
                        data: {
                                autoloader      : true,
                                action          : 'fetchappointeedetails',
                                inputinfo       : attr
                        },
                        success: function(data, textStatus, xhr) {
                                data = $.trim(data);
//                                console.log(xhr.status);
                                switch (data) {
                                        case 'logout':
                                                logoutAdmin({});
                                                break;
                                        case 'login':
                                                loginAdmin({});
                                                break;
                                        default:
                                            var appointeedel=$.parseJSON(data);
                                            $('#'+doctor.appointment.viewappointeedis+appid).html(appointeedel);
                                }
                        },
                        error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                        },
                        complete: function(xhr, textStatus) {
                                console.log(xhr.status);

                        }
                });    
        }
        function showAppointmentEditDetails()
        {
            $(doctor.appointment.appointedit).html(LOADER);
            var htm='';
         $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchappointmentdetails',
		},
		success: function(data, textStatus, xhr) {
                    console.log(data);
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    for(i=0;i<ppdetails.pdata1.length;i++)
                    {
                      htm += ppdetails.pdata1[i];  
                    }
                    $(doctor.appointment.appointedit).html(ppdetails.divheader1+htm+ppdetails.divfooter);
                        break;
			}
                    window.setTimeout(function (){
                        var fromtime=[];
                        var totime=[];
                     for(i=0;i<ppdetails.appids.length;i++)
                     {
                         $('#'+doctor.appointment.edit_app+ppdetails.appids[i]).bind('click',{id:ppdetails.appids[i],
                         ft:ppdetails.fromtime[i],tt:ppdetails.totime[i],loc:ppdetails.location[i],freq:ppdetails.frequency[i]},function(event){
                           var apptid = event.data.id;
                            fromtime = (event.data.ft).split('-');
                            totime = (event.data.tt).split('-');
                           var location = event.data.loc;
                           var frequency = event.data.freq;
                           editappointmentdetails(apptid,fromtime,totime,location,frequency)
                         })
                         $('#'+doctor.appointment.deleteOk_+ppdetails.appids[i]).bind('click',{id:ppdetails.appids[i]},function(event){
                           var apptid = event.data.id;
                           DeleteAppointment(apptid);
                       });
                     }
                     for(k=0;k<ppdetails.weekofdays.length;k++)
                     {
                         $(doctor.appointment.eaddappointSubmit+ppdetails.weekofdays[k]).hide();
                     $('#'+doctor.appointment.eplus+ppdetails.weekofdays[k]).bind('click',{id:ppdetails.weekofdays[k]},function(event){
                           var apptid = event.data.id;
                            ebuildMultipleSlots(apptid);
                       });
                       $(doctor.appointment.eaddappointSubmit+ppdetails.weekofdays[k]).bind('click',{id:ppdetails.weekofdays[k],weekid:ppdetails.weekofdayid[k]},function(event){
                         var apptid = event.data.id;
                         var weekidd=event.data.weekid;
                         econfigAppointments(apptid,weekidd);
                       });
                       
                    }
                    },300)    
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});  
        }
        function econfigAppointments(idd,weekidd)
        {
           var flag=false;
            var da=doctor.appointment;
            var fromtime=[];
            var totime=[];
            var location=[];
            var frequency=[];
            var j=0;
          for(i=0;i<=da.enum;i++)
          {
           fromtime[i]=($('#'+da.efromhour+i).val())+'-'+($('#'+da.efromminute+i).val())+'-'+($('#'+da.efromampm+i).val());
           totime[i]=($('#'+da.etohour+i).val())+'-'+($('#'+da.etominute+i).val())+'-'+($('#'+da.etoampm+i).val());
           if(fromtime[i]==totime[i])
           {
               alert("To Time is incorrect");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.efromhour+i).val())>=10 && $('#'+da.efromampm+i).val()=='PM') || (Number($('#'+da.efromhour+i).val())< 6 && $('#'+da.efromampm+i).val()=='AM')) && (Number($('#'+da.efromhour+i).val())!= 12 ) )
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.etohour+i).val())>10 && $('#'+da.etoampm+i).val()=='PM') || (Number($('#'+da.etohour+i).val())<= 6 && $('#'+da.etoampm+i).val()=='AM'))  && (Number($('#'+da.etohour+i).val())!= 12 ))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.efromhour+i).val())< 10 && $('#'+da.efromampm+i).val()=='PM') && (Number($('#'+da.etohour+i).val()) < 12 && $('#'+da.etoampm+i).val()=='AM'))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.efromhour+i).val()) > Number($('#'+da.etohour+i).val() ) ) && ($('#'+da.efromampm+i).val()==$('#'+da.etoampm+i).val())) && (Number($('#'+da.efromhour+i).val())!= 12 ))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.efromhour+i).val()) == Number($('#'+da.etohour+i).val() ) )&& (Number($('#'+da.efromminute+i).val()) > Number($('#'+da.etominute+i).val() ) ) && ($('#'+da.efromampm+i).val()==$('#'+da.etoampm+i).val()))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.efromhour+i).val()) == 12) && ($('#'+da.efromampm+i).val()=='AM'))
           {
          alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if($('#'+da.elocationappoint+i).val()=="")
           {
              $('#'+da.elocationappoint+i).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
           location[i]=$('#'+da.elocationappoint+i).val();
            }
            if($('#'+da.elocationappoint+i).val()=="")
           {
              $('#'+da.elocationappoint+i).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
           location[i]=$('#'+da.elocationappoint+i).val();
            }
            if($('#'+da.efrequencyappoint+i).val()=="" ||(!$('#'+da.efrequencyappoint+i).val().match(numbs)))
           {
              $('#'+da.efrequencyappoint+i).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
           frequency[i]=$('#'+da.efrequencyappoint+i).val();
            }
           
          }
         var attr={
             fromtime   : fromtime,
             totime     : totime,
             location   : location,
             frequency  : frequency,
             weekidd    : weekidd,
             day        : idd,
         }
         if(flag)
         {
//            $(doctor.appointment.appointsubmitBut) .prop('disabled', 'disabled');
            $(doctor.appointment.eappointconfgmsg).html(LOADER);
             $.ajax({
                        url: doctor.url,
                        type: 'POST',
                        data: {
                              autoloader          : true,
                              action              : 'econfigureappointment',
                              configureappt       : attr
                        },
                        success: function(data, textStatus, xhr) {
//                            console.log(data);
                                data = $.trim(data);
                                switch (data) {
                                        case 'logout':
                                                logoutAdmin({});
                                                break;
                                        case 'login':
                                                loginAdmin({});
                                                break;
                                        default:
                                                alert("Appointment has been successfully Configured");
                                                $(doctor.appointment.eappointconfgmsg).html('');
                                                showAppointmentEditDetails()
                                                break;
                                }
                        },
                        error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                        },
                        complete: function(xhr, textStatus) { 
                                console.log(xhr.status);
//                                $(doctor.appointment.appointsubmitBut) .removeAttr('disabled');
                                var numbb=doctor.appointment.enum
                       for(i=0;i<=numbb;i++)
                        {
                         $('#'+doctor.appointment.eform +i).remove(); 
                         doctor.appointment.ej--;
                         doctor.appointment.enum--;
                        }
                        $(doctor.appointment.eplus).show();
                                  
                        }
                });
            } 
        }
        function DeleteAppointment(apptid)
        {
         $.ajax({
                        url: doctor.url,
                        type: 'POST',
                        data: {
                                autoloader      : true,
                                action          : 'deleteappointment',
                                apptid          : apptid
                        },
                        success: function(data, textStatus, xhr) {
                                data = $.trim(data);
                                switch (data) {
                                        case 'logout':
                                                logoutAdmin({});
                                                break;
                                        case 'login':
                                                loginAdmin({});
                                                break;
                                        default:
                                            $('#'+doctor.appointment.row_id+apptid).remove();
                                            $('.modal-backdrop').remove();

                                }
                        },
                        error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                        },
                        complete: function(xhr, textStatus) {
                                console.log(xhr.status);

                        }
                });   
        }
        function editappointmentdetails(apptid,fromtime,totime,location,frequency)
        {
         var editslott  ='<div class="form-group">'+
                    '<div class="col-md-12"><label>Edit Slot </label>'+
                    '</div>'+
                    '<br/><div class="col-md-3">'+
                    '<label>From Time</label><br/>'+
                    '<select id="editfromhour" class="form-group" name="editfromhour">'+
                    '<option value="'+fromtime[0]+'">'+fromtime[0]+'</option>'+
                    '<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>'+ 
                    '<option value="4">4</option> <option value="5">5</option> <option value="6">6</option>'+ 
                    '<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>'+ 
                    '<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>'+ 
                    '</select>'+
                    '<select id="editfromminute" class="form-group" name="editfromminute">'+
                    '<option value="'+fromtime[1]+'">'+fromtime[1]+'</option><option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>'+  
                    '</select>'+
                    '<select id="editfromampm" class="form-group" name="editfromampm">'+
                    '<option value="'+fromtime[2]+'">'+fromtime[2]+'</option> <option value="AM">AM</option> <option value="PM">PM</option>'+
                    '</select>'+
                    '</div>'+
                    '<div class="col-lg-3">'+
                    '<label>To Time</label>'+
                    '<br/>'+
                    '<select id="edittohour" class="form-group" name="edittohour">'+
                    '<option value="'+totime[0]+'">'+totime[0]+'</option>'+
                    '<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>'+ 
                    '<option value="4">4</option> <option value="5">5</option> <option value="6">6</option>'+ 
                    '<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>'+ 
                    '<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>'+ 
                    '</select>'+
                    '<select id="edittominute" class="form-group" name="edittominute">'+
                    '<option value="'+totime[1]+'">'+totime[1]+'</option>'+
                    '<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>'+  
                    '</select>'+
                    '<select id="edittoampm" class="form-group" name="edittoampm">'+
                    '<option value="'+totime[2]+'">'+totime[2]+'</option>'+
                    '<option value="AM">AM</option> <option value="PM">PM</option>'+
                    '</select>'+
                    '<p class="help-block"></p>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<label>Location</label>'+
                    '<input type="text" name="editlocationappoint" id="editlocationappoint" value="'+location+'" class="form-control"/>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<label>no of Patient</label>'+
                    '<input type="number" name="editfrequencyappoint" id="editfrequencyappoint" value="'+frequency+'" class="form-control"/>'+
                    '</div></div>'+
                   '</div><div class="col-md-12"><button class="btn btn-success" id="editApptDetailsSubmit" type="button">Save</button></div><input type="text" id="editapptidd" value="'+apptid+'" hidden="">';
                   $('#'+doctor.appointment.edit_details+apptid).html(editslott); 
                   window.setTimeout(function (){
                    $('#'+doctor.editappointment.editApptDetailsSubmit).click(function (){
                        var da=doctor.editappointment;
                         var fromtime = $('#'+doctor.editappointment.editfromhour).val()+'-'+$('#'+doctor.editappointment.editfromminute).val()+'-'+$('#'+doctor.editappointment.editfromampm).val();
                         var totime   = $('#'+doctor.editappointment.edittohour).val()+'-'+$('#'+doctor.editappointment.edittominute).val()+'-'+$('#'+doctor.editappointment.edittoampm).val();
                           
           if(fromtime==totime)
           {
               alert("To Time is incorrect");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.editfromhour).val())>=10 && $('#'+da.editfromampm).val()=='PM') || (Number($('#'+da.editfromhour).val())< 6 && $('#'+da.editfromampm).val()=='AM')) && (Number($('#'+da.editfromhour).val())!= 12 ) )
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.edittohour).val())>10 && $('#'+da.edittoampm).val()=='PM') || (Number($('#'+da.edittohour).val())<= 6 && $('#'+da.edittoampm).val()=='AM'))  && (Number($('#'+da.edittohour).val())!= 12 ))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.editfromhour).val())< 10 && $('#'+da.editfromampm).val()=='PM') && (Number($('#'+da.edittohour).val()) < 12 && $('#'+da.edittoampm).val()=='AM'))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.editfromhour).val()) > Number($('#'+da.edittohour).val() ) ) && ($('#'+da.editfromampm).val()==$('#'+da.edittoampm).val())) && (Number($('#'+da.editfromhour).val())!= 12 ))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.editfromhour).val()) == Number($('#'+da.edittohour).val() ) )&& (Number($('#'+da.editfromminute).val()) > Number($('#'+da.edittominute).val() ) ) && ($('#'+da.editfromampm).val()==$('#'+da.edittoampm).val()))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.editfromhour).val()) == 12) && ($('#'+da.editfromampm).val()=='AM'))
           {
          alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if($('#'+da.editlocationappoint).val()=="")
           {
              $('#'+da.editlocationappoint).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
            }
            if($('#'+da.editlocationappoint).val()=="")
           {
              $('#'+da.editlocationappoint).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
            }
            if($('#'+da.editfrequencyappoint).val()=="" ||(!$('#'+da.editfrequencyappoint).val().match(numbs)))
           {
              $('#'+da.editfrequencyappoint).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
            }
                    if(flag)
                    {
                       var attr={
                           fromtime : $('#'+doctor.editappointment.editfromhour).val()+'-'+$('#'+doctor.editappointment.editfromminute).val()+'-'+$('#'+doctor.editappointment.editfromampm).val(),
                           totime   : $('#'+doctor.editappointment.edittohour).val()+'-'+$('#'+doctor.editappointment.edittominute).val()+'-'+$('#'+doctor.editappointment.edittoampm).val(),
                           location : $('#'+doctor.editappointment.editlocationappoint).val(),
                           frequency: $('#'+doctor.editappointment.editfrequencyappoint).val(),
                           apptid   : $('#'+doctor.editappointment.editapptidd).val(),
                        }
                        $.ajax({
                        url: doctor.url,
                        type: 'POST',
                        data: {
                                autoloader      : true,
                                action          : 'editappointment',
                                editappt        : attr
                        },
                        success: function(data, textStatus, xhr) {
                                data = $.trim(data);
                                console.log(xhr.status);
                                switch (data) {
                                        case 'logout':
                                                logoutAdmin({});
                                                break;
                                        case 'login':
                                                loginAdmin({});
                                                break;
                                        default:
                                            alert("Appointment has been Successfully Altered");
                                            showAppointmentEditDetails();

                                }
                        },
                        error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                        },
                        complete: function(xhr, textStatus) {
                                console.log(xhr.status);

                        }
                });
            }     
                    }) ;  
                   },300)
        }
        function configureappointment()
        {
            var flag=false;
            var da=doctor.appointment;
            var Days=[];
            var fromtime=[];
            var totime=[];
            var location=[];
            var frequency=[];
            var j=0;
          for(i=1;i<=7;i++)
          {
              if($('input[name=day'+i+']').prop('checked'))
              {
           Days[j++]=$('input[name="day'+i+'"]:checked').val();  
              }
          }
          if(Days.length==0)
          {
              alert("please select the day/days");
              flag=false;
              return 
          }
          else
          {
              flag=true;
          }
          for(i=0;i<=da.num;i++)
          {
           fromtime[i]=($('#'+da.fromhour+i).val())+'-'+($('#'+da.fromminute+i).val())+'-'+($('#'+da.fromampm+i).val());
           totime[i]=($('#'+da.tohour+i).val())+'-'+($('#'+da.tominute+i).val())+'-'+($('#'+da.toampm+i).val());
           if(fromtime[i]==totime[i])
           {
               alert("To Time is incorrect");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.fromhour+i).val())>=10 && $('#'+da.fromampm+i).val()=='PM') || (Number($('#'+da.fromhour+i).val())< 6 && $('#'+da.fromampm+i).val()=='AM')) && (Number($('#'+da.fromhour+i).val())!= 12 ) )
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.tohour+i).val())>10 && $('#'+da.toampm+i).val()=='PM') || (Number($('#'+da.tohour+i).val())<= 6 && $('#'+da.toampm+i).val()=='AM'))  && (Number($('#'+da.tohour+i).val())!= 12 ))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.fromhour+i).val())< 10 && $('#'+da.fromampm+i).val()=='PM') && (Number($('#'+da.tohour+i).val()) < 12 && $('#'+da.toampm+i).val()=='AM'))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if(((Number($('#'+da.fromhour+i).val()) > Number($('#'+da.tohour+i).val() ) ) && ($('#'+da.fromampm+i).val()==$('#'+da.toampm+i).val())) && (Number($('#'+da.fromhour+i).val())!= 12 ))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.fromhour+i).val()) == Number($('#'+da.tohour+i).val() ) )&& (Number($('#'+da.fromminute+i).val()) > Number($('#'+da.tominute+i).val() ) ) && ($('#'+da.fromampm+i).val()==$('#'+da.toampm+i).val()))
           {
               alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if((Number($('#'+da.fromhour+i).val()) == 12) && ($('#'+da.fromampm+i).val()=='AM'))
           {
          alert("Invalid Time");
               flag=false;
                return 
           }
           else
           {
               flag=true;
           }
           if($('#'+da.locationappoint+i).val()=="")
           {
              $('#'+da.locationappoint+i).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
           location[i]=$('#'+da.locationappoint+i).val();
            }
            if($('#'+da.locationappoint+i).val()=="")
           {
              $('#'+da.locationappoint+i).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
           location[i]=$('#'+da.locationappoint+i).val();
            }
            if($('#'+da.frequencyappoint+i).val()=="" ||(!$('#'+da.frequencyappoint+i).val().match(numbs)))
           {
              $('#'+da.frequencyappoint+i).focus();
              flag=false;
                return ;
           }
           else
           {
               flag=true;
           frequency[i]=$('#'+da.frequencyappoint+i).val();
            }
           
          }
         var attr={
             days       : Days,
             fromtime   : fromtime,
             totime     : totime,
             location   : location,
             frequency  : frequency,
         }
         $(doctor.appointment.appointconfgmsg).html('');
         if(flag)
         {
            $(doctor.appointment.appointsubmitBut) .prop('disabled', 'disabled');
            $(doctor.appointment.appointconfgmsg).html(LOADER);
             $.ajax({
                        url: doctor.url,
                        type: 'POST',
                        data: {
                                autoloader      : true,
                                action          : 'configureappointment',
                                configureappt    : attr
                        },
                        success: function(data, textStatus, xhr) {
                                data = $.trim(data);
                                switch (data) {
                                        case 'logout':
                                                logoutAdmin({});
                                                break;
                                        case 'login':
                                                loginAdmin({});
                                                break;
                                        default:
                                                alert("Appointment has been successfully Configured");
                                                $(doctor.appointment.appointconfgmsg).html('');
                                                $('html, body').animate({
                                                        scrollTop: Number($(doctor.appointment.appointconfgmsg).offset().top) - 95
                                                }, 'slow');
												fetchconfiguredappointment();
                                                break;
                                }
                        },
                        error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                        },
                        complete: function(xhr, textStatus) { 
                                $(doctor.appointment.appointsubmitBut) .removeAttr('disabled');
                                var numbb=doctor.appointment.num
                       for(i=0;i<=numbb;i++)
                        {
                         $('#'+doctor.appointment.form +i).remove(); 
                         doctor.appointment.j--;
                         doctor.appointment.num--;
                        }
                        $(doctor.appointment.plus).show();
                        }
                });
            }
         }
        function addpatientassesment()
        {
          var flag=false;
          if($(doctor.patientassesment.passesmentpatientdel).val()=="")
          {
             flag=false;
             $(doctor.patientassesment.passesmentpatientdelmsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.patientassesment.passesmentpatientdelmsg).offset().top) - 95
				}, 'slow');
             $(doctor.patientassesment.passesmentpatientdel).focus();                   
             return 
          }
          else
          {
              $(doctor.patientassesment.passesmentpatientdelmsg).html('');
              flag=true;
          }
          if($(doctor.patientassesment.patientprevioushistory).val()=="")
          {
             flag=false;
             $(doctor.patientassesment.patientprevioushistorymsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.patientassesment.patientprevioushistorymsg).offset().top) - 95
				}, 'slow');
            $(doctor.patientassesment.patientprevioushistory).focus();                    
             return 
          }
          else
          {
              $(doctor.patientassesment.patientprevioushistorymsg).html('');
              flag=true;
          }
          if($(doctor.patientassesment.patientcassesment).val()=="")
          {
             flag=false;
             $(doctor.patientassesment.patientcassesmentmsg).html(INVALIDNOT);
             $('html, body').animate({
					scrollTop: Number($(doctor.patientassesment.patientcassesmentmsg).offset().top) - 95
				}, 'slow');
            $(doctor.patientassesment.patientcassesment).focus();                    
             return 
          }
          else
          {
              $(doctor.patientassesment.patientcassesmentmsg).html('');
              flag=true;
          }
          
          if(flag)
          {
             $(".sub_container").slideUp(1000);
                $("#prescription").slideDown(1500); 
                fetchpateintandpharmacy();
                flag=false;
                addprescribtion(flag);
            }
        }
        function fetchpassmentpatient() 
        {
          $(doctor.patientassesment.passesmentpatient).html(LOADER);
          $(doctor.patientassesment.patientpic).html('');
          $(doctor.patientassesment.passesmentform).get(0).reset();
          
        $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpassesmentpatient',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(doctor.patientassesment.passesmentpatient).html('<select id="passesmentpatientdel" class="form-control"><option value="">Please Select Patient</option>'+ppdetails.pdetails+'</select>');
                    window.setTimeout(function (){
                     $(doctor.patientassesment.passesmentpatientdel).change(function(){
                        var pid= $(doctor.patientassesment.passesmentpatientdel).val();
                        fetchPatientAssesmentDetails(pid);
                     })
                    },300);
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }
        function fetchPatientAssesmentDetails(pid)
        {
        for(i=0;i<doctor.patientassesment.num;i++)
        {
         $('input[name=habbitsdelt'+i+']').attr('checked',false);   
        }
         $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpatientassesmentdetails',
                passmtid    : pid
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    if(ppdetails.previoushistory == null)
                    {
                    $(doctor.patientassesment.patienthistrydispl).hide();
                    $(doctor.patientassesment.patienthistrydisp).show(); 
                    $(doctor.patientassesment.patientprevioushistory).show();
                    $(doctor.patientassesment.patienthistrydisp).html('<textarea class="form-control" placeholder="Enter the Previous Healthy History" name="patientprevioushistory" id="patientprevioushistory"></textarea>'); 
//                    $(doctor.patientassesment.patientprevioushistory).val(ppdetails.previoushistory);
                    }
                    else
                    {
                      $(doctor.patientassesment.patienthisrydisp).hide();   
                      $(doctor.patientassesment.patientprevioushistory).hide(); 
                      $(doctor.patientassesment.patienthistrydispl).show();
                      $(doctor.patientassesment.patienthistrydispl).html(ppdetails.previoushistory);
                    }
                    $(doctor.patientassesment.patientdiseases).val(ppdetails.disease); 
                    $(doctor.patientassesment.passmentcount).val(ppdetails.count);
                    if(ppdetails.bg != null)
                    {
                     $(doctor.patientassesment.patientbloodgroupdis).html(ppdetails.bg);  
                    }
                    else
                    {
                            fetchbloodgroupandhabbit();
                    }
                    var hlen=ppdetails.habits.length;
                    if(hlen)
                    {
                        for(i=0;i<hlen;i++)
                        {
                              $('input[name=habbitsdelt'+(ppdetails.habits[i]-1)+']').attr('checked',true);  
                        }
                    }
                    $(doctor.patientassesment.patientpic).html('<img src="'+ppdetails.photo+'" width="100" height="100"></img>');
                    break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }
        function fetchbloodgroupandhabbit() 
        {
        $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchbloodgroup',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(doctor.patientassesment.patientbloodgroupdis).html('<select id="patientbloodgroup" class="form-control"><option value="">Please Select Blood Group</option>'+ppdetails.bloogroups+'</select>');
                    $(doctor.patientassesment.patienthabitdis).html(ppdetails.habits);
                    $(doctor.patientassesment.num).val(Number(ppdetails.noofhabits));
                    break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});    
        }
        function addprescribtion(flag)
        {
            var flag1=flag;
           var dp=doctor.prescibtion;
           var tablets=[];
           var morning=[];
           var afternoon=[];
           var dinner=[];
           var frequency=[];
           var dosage=[];
           var numbb=$(doctor.patientassesment.num).val();
          var habits=[];
          for(i=0;i<numbb;i++)
          {
              if($('input[name=habbitsdelt'+i+']').prop('checked'))
              {
           habits[i]=$('input[name="habbitsdelt'+i+'"]:checked').val();  
              }
              
          }
           var nom=dp.num;
            for(i=0;i<=nom;i++)
           {
             if($(dp.prestabletname+i).val()=="")
             {
                 flag1=false;
                $(dp.prestabletname+i).focus();
                return ;
             }
             else
             {
                flag1=true; 
             }
           }
           for(i=0;i<=nom;i++)
           {
             tablets[i]=$(dp.prestabletname+i).val() ; 
             morning[i]=$('input[name=morning'+i+']:checked').val() ;
             afternoon[i]=$('input[name=afternoon'+i+']:checked').val();
             dinner[i]=$('input[name=dinner'+i+']:checked').val();;
             frequency[i]=$(dp.presfrequency+i).val() ;
             dosage[i]=$(dp.presdosage+i).val() ;
           }
           var attr={
              patientid : $(doctor.patientassesment.passesmentpatientdel).val(),
              count     : $(doctor.patientassesment.passmentcount).val(),
              phh       : $(doctor.patientassesment.patientprevioushistory).val(),
              disease   : $(doctor.patientassesment.patientdiseases).val(),
              bg        : $(doctor.patientassesment.patientbloodgroup).val(),
              cass      : $(doctor.patientassesment.patientcassesment).val(),
              cassrem   : $(doctor.patientassesment.patientcassesmentrem).val(),
              habits    : habits,
            cpatientid  : $(doctor.patientassesment.passmentcount).val(),  
            pharid      :  $(dp.prespharselect).val(),
            tablets     : tablets,
            morning      : morning,
            afternoon   : afternoon,
            dinner      : dinner,
            frequency   : frequency,
            dosage      : dosage
           };
           if(flag1)
           {
                $(doctor.prescibtion.prescribtionsubmitBut).prop('disabled','disabled');
                $(dp.prescribtionmsgdiv).html(LOADER);
                    $.ajax({
					url: doctor.url,
					type: 'POST',
					data: {
						autoloader  : true,
						action      : 'addpatientassesment',
						patientassinfo  : attr
					},
					success: function(data, textStatus, xhr) {
						data = $.trim(data);
						switch (data) {
							case 'logout':
								logoutAdmin({});
								break;
							case 'login':
								loginAdmin({});
								break;
							default:
                                                                alert("priscription has been Added successfully");
//								$(dp.prescribtionmsgdiv).html('Prescribtion has been Added successfully ');
								$('html, body').animate({
									scrollTop: Number($(dp.prescribtionmsgdiv).offset().top) - 95
								}, 'slow');
                                                                $(dp.presform).get(0).reset();
//                                                                $(dp.downloadpres).html('<button type="button" class="btn btn-success" id="downloadSubmitPres">Download Prescription</button>');
//                                                                window.setTimeout(function (){
//                                                                    $(dp.downloadSubmitPres).click(function (){
//                                                                       alert("am here"); 
//                                                                    });
//                                                                },300)
								break;
						}
					},
					error: function() {
					},
					complete: function(xhr, textStatus) {
                                           $(doctor.prescibtion.prescribtionsubmitBut).removeAttr('disabled');
                                           $(dp.prescribtionmsgdiv).html('');
					}
				});  
            }
        }
        function buildMultipleTablets()
        {
           if (doctor.prescibtion.num == -1) $(doctor.prescibtion.multiple_tablet).html('');
           doctor.prescibtion.num++;
           doctor.prescibtion.j++;
           var htm='<div id="'+doctor.prescibtion.form +doctor.prescibtion.num+'"><div class="col-md-4"><label>Tablet'+doctor.prescibtion.j+' Name</label></div>'+
                   '<div class="col-md-8"><button  id="plus_tablet_'+doctor.prescibtion.num+'" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw fa-x2"></i> </button><button  id="minus_tablet_'+doctor.prescibtion.num+'" type="button" class="text-primary btn btn-danger  btn-md"> <i class="fa fa-minus fa-fw fa-x2"></i></button></div>'+
                   '<div class="col-md-12"><input class="form-control" id="prestabletname'+doctor.prescibtion.num+'" placeholder="Enter the tablet name" required=""/></div>'+
                    '<div class="col-md-4"><label>Morning</label><br /><input type="radio" name="morning'+doctor.prescibtion.num+'" value="25"> Before Breakfast<br /><input type="radio" name="morning'+doctor.prescibtion.num+'" value="26"> After Breakfast<br /><input type="radio" name="morning'+doctor.prescibtion.num+'" value="27"> N/A</div>'+
                    '<div class="col-md-4"><label>Afternoon</label><br /><input type="radio" name="afternoon'+doctor.prescibtion.num+'" value="25"> Before Lunch<br /><input type="radio" name="afternoon'+doctor.prescibtion.num+'" value="26"> After Lunch'+
                    '<br /><input type="radio" name="afternoon'+doctor.prescibtion.num+'" value="27"> N/A</div><div class="col-md-4"><label>Dinner</label><br /><input type="radio" name="dinner'+doctor.prescibtion.num+'" value="25"> Before Dinner<br />'+
                    '<input type="radio" name="dinner'+doctor.prescibtion.num+'" value="26"> After Dinner<br /><input type="radio" name="dinner'+doctor.prescibtion.num+'" value="27"> N/A</div>'+
                    '<div align="left" class="form-group"> <label>Frequency</label>'+
                    '<input class="form-control" id="presfrequency'+doctor.prescibtion.num+'" placeholder="enter the no of days consumtion">'+
                    '<p class="help-block" id="presfrequencymsg'+doctor.prescibtion.num+'"></p></div><div class="form-group">'+
                    '<label>Dosage</label><input class="form-control" id="presdosage'+doctor.prescibtion.num+'" placeholder="enter the no of Dosage"><p class="help-block" id="presdosagemsg"></p></div>'
                    '</div>';
           $(doctor.prescibtion.multiple_tablet).append(htm);
           console.log(doctor.prescibtion.form +doctor.prescibtion.num)
           window.setTimeout(function() {
				$(doctor.prescibtion.minus + doctor.prescibtion.num).click(function() {
                                        console.log(doctor.prescibtion.form + doctor.prescibtion.num);
					$('#'+doctor.prescibtion.form + doctor.prescibtion.num).remove();
					doctor.prescibtion.num--;
                                        doctor.prescibtion.j--;
                                        
					if (doctor.prescibtion.num == -1) {
						$(doctor.prescibtion.plus).show();
						$(doctor.prescibtion.multiple_tablet).html('');
					} else {
						$(doctor.prescibtion.plus + doctor.prescibtion.num).show();
						$(doctor.prescibtion.minus + doctor.prescibtion.num).show();
					}
				});
				$(doctor.prescibtion.plus + doctor.prescibtion.num).click(function() {
				        $(doctor.prescibtion.plus + doctor.prescibtion.num).hide();
					$(doctor.prescibtion.minus + doctor.prescibtion.num).hide();
                                        buildMultipleTablets();
				});
			}, 500);
        }
        function buildMultipleSlots()
        {
         if (doctor.appointment.num == -1) $(doctor.appointment.multiple_slots).html('');
           doctor.appointment.num++;
           doctor.appointment.j++;
           var htm='<div id="'+doctor.appointment.form +doctor.appointment.num+'">'+
                   '<div class="form-group">'+
                    '<div class="col-md-12"><label> Slot </label>'+
                    ' &nbsp;&nbsp;&nbsp;<button  id="plus_slots_'+doctor.appointment.num+'" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw fa-x2"></i> </button><button  id="minus_slots_'+doctor.appointment.num+'" type="button" class="text-primary btn btn-danger  btn-md"> <i class="fa fa-minus fa-fw fa-x2"></i></button></div>'+
                    '<br/><div class="col-md-3">'+
                    '<label>From Time</label><br/>'+
                    '<select id="fromhour'+doctor.appointment.num+'" class="form-group" name="fromhour">'+
                    '<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>'+ 
                    '<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>'+ 
                    '<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>'+ 
                    '<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>'+ 
                    '</select>'+
                    '<select id="fromminute'+doctor.appointment.num+'" class="form-group" name="fromminute">'+
                    '<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>'+  
                    '</select>'+
                    '<select id="fromampm'+doctor.appointment.num+'" class="form-group" name="fromampm">'+
                    '<option value="AM">AM</option> <option value="PM">PM</option>'+
                    '</select>'+
                    '</div>'+
                    '<div class="col-lg-3">'+
                    '<label>To Time</label>'+
                    '<br/>'+
                    '<select id="tohour'+doctor.appointment.num+'" class="form-group" name="tohour">'+
                    '<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>'+ 
                    '<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>'+ 
                    '<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>'+ 
                    '<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>'+ 
                    '</select>'+
                    '<select id="tominute'+doctor.appointment.num+'" class="form-group" name="tominute">'+
                    '<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>'+  
                    '</select>'+
                    '<select id="toampm'+doctor.appointment.num+'" class="form-group" name="toampm">'+
                    '<option value="AM">AM</option> <option value="PM">PM</option>'+
                    '</select>'+
                    '<p class="help-block"></p>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<label>Location</label>'+
                    '<input type="text" name="locationappoint'+doctor.appointment.num+'" id="locationappoint'+doctor.appointment.num+'" placeholder="Location" required="required" class="form-control"/>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<label>no of Patient</label>'+
                    '<input type="number" name="frequencyappoint'+doctor.appointment.num+'" id="frequencyappoint'+doctor.appointment.num+'" placeholder="no of Patient" class="form-control"/>'+
                    '</div></div>'+
                   '</div>';
           $(doctor.appointment.multiple_slots).append(htm);
           window.setTimeout(function() {
				$(doctor.appointment.minus + doctor.appointment.num).click(function() {
                                        console.log(doctor.appointment.form + doctor.appointment.num);
					$('#'+doctor.appointment.form + doctor.appointment.num).remove();
					doctor.appointment.num--;
                                        doctor.appointment.j--;
                                        
					if (doctor.appointment.num == -1) {
						$(doctor.appointment.plus).show();
                                                $(doctor.appointment.appointbutton).hide();
						$(doctor.appointment.multiple_slots).html('');
					} else {
						$(doctor.appointment.plus + doctor.appointment.num).show();
						$(doctor.appointment.minus + doctor.appointment.num).show();
					}
				});
				$(doctor.appointment.plus + doctor.appointment.num).click(function() {
				        $(doctor.appointment.plus + doctor.appointment.num).hide();
					$(doctor.appointment.minus + doctor.appointment.num).hide();
                                        buildMultipleSlots();
				});
                                $(doctor.appointment.appointbutton).click(function (){
                                    configureappointment();
                                })
			}, 500);   
        }
        function ebuildMultipleSlots(apptid)
        {
         if (doctor.appointment.enum == -1) $(doctor.appointment.emultiple_slots+apptid).html('');
           doctor.appointment.enum++;
           doctor.appointment.ej++;
           var htm='<div id="'+doctor.appointment.eform +doctor.appointment.enum+'">'+
                   '<div class="form-group">'+
                    '<div class="col-md-12"><label> Slot '+''+'</label>'+
                    ' &nbsp;&nbsp;&nbsp;<button  id="eplus_slots_'+apptid+doctor.appointment.enum+'" type="button" class="text-primary btn btn-success  btn-md"><i class="fa fa-plus fa-fw fa-x2"></i> </button><button  id="eminus_slots_'+apptid+doctor.appointment.enum+'" type="button" class="text-primary btn btn-danger  btn-md"> <i class="fa fa-minus fa-fw fa-x2"></i></button></div>'+
                    '<br/><div class="col-md-3">'+
                    '<label>From Time</label><br/>'+
                    '<select id="efromhour'+doctor.appointment.enum+'" class="form-group" name="fromhour">'+
                    '<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>'+ 
                    '<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>'+ 
                    '<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>'+ 
                    '<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>'+ 
                    '</select>'+
                    '<select id="efromminute'+doctor.appointment.enum+'" class="form-group" name="fromminute">'+
                    '<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>'+  
                    '</select>'+
                    '<select id="efromampm'+doctor.appointment.enum+'" class="form-group" name="fromampm">'+
                    '<option value="AM">AM</option> <option value="PM">PM</option>'+
                    '</select>'+
                    '</div>'+
                    '<div class="col-lg-3">'+
                    '<label>To Time</label>'+
                    '<br/>'+
                    '<select id="etohour'+doctor.appointment.enum+'" class="form-group" name="tohour">'+
                    '<option value="1">1</option> <option value="2">2</option> <option value="3">3</option>'+ 
                    '<option value="4">4</option> <option value="5">5</option> <option value="6" selected>6</option>'+ 
                    '<option value="7">7</option> <option value="8">8</option> <option value="9">9</option>'+ 
                    '<option value="10">10</option> <option value="11">11</option> <option value="12">12</option>'+ 
                    '</select>'+
                    '<select id="etominute'+doctor.appointment.enum+'" class="form-group" name="tominute">'+
                    '<option value="00">00</option> <option value="15">15</option> <option value="30">30</option><option value="45">45</option>'+  
                    '</select>'+
                    '<select id="etoampm'+doctor.appointment.enum+'" class="form-group" name="toampm">'+
                    '<option value="AM">AM</option> <option value="PM">PM</option>'+
                    '</select>'+
                    '<p class="help-block"></p>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<label>Location</label>'+
                    '<input type="text" name="elocationappoint'+doctor.appointment.enum+'" id="elocationappoint'+doctor.appointment.enum+'" placeholder="Location" required="required" class="form-control"/>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<label>no of Patient</label>'+
                    '<input type="number" name="efrequencyappoint'+doctor.appointment.enum+'" id="efrequencyappoint'+doctor.appointment.enum+'" placeholder="no of Patient" class="form-control"/>'+
                    '</div></div>'+
                   '</div>';
           $(doctor.appointment.emultiple_slots+apptid).append(htm);
           $(doctor.appointment.eaddappointSubmit+apptid).show();
           window.setTimeout(function() {
				$(doctor.appointment.eminus+apptid + doctor.appointment.enum).click(function() {
                                        console.log(doctor.appointment.eform + doctor.appointment.enum);
					$('#'+doctor.appointment.eform + doctor.appointment.enum).remove();
					doctor.appointment.enum--;
                                        doctor.appointment.ej--;
                                        
					if (doctor.appointment.enum == -1) {
						$(doctor.appointment.eplus+apptid).show();
                                                $(doctor.appointment.eaddappointSubmit+apptid).hide();
						$(doctor.appointment.emultiple_slots+apptid).html('');
					} else {
						$('#'+doctor.appointment.eplus+apptid + doctor.appointment.enum).show();
						$(doctor.appointment.eminus+apptid + doctor.appointment.enum).show();
					}
				});
				$('#'+doctor.appointment.eplus+apptid + doctor.appointment.enum).click(function() {
				        $('#'+doctor.appointment.eplus+apptid + doctor.appointment.enum).hide();
					$(doctor.appointment.eminus+apptid + doctor.appointment.enum).hide();
                                        ebuildMultipleSlots(apptid);
				});
			}, 400);   
        }
        function fetchpateintandpharmacy()
        {
         $(doctor.prescibtion.pharmacyfulldetails).html('');
         $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpatientpharmacy',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
//                    $(doctor.prescibtion.prespatient).html('<select id="prespatientselect" class="form-control"><option value="">Please Select Patient</option>'+ppdetails.patientdetails+'</select>');
                    $(doctor.prescibtion.prespharmacy).html('<select id="prespharselect" class="form-control"><option value="">Please Select Pharmacy</option>'+ppdetails.pharmacydetails+'</select>');
                    window.setTimeout(function (){
                        $(doctor.prescibtion.prespharselect).change(function (){
                            var pharid=this.value;
                            fetchFullPharmacyDetails(pharid);
                        })
                    },300)
                            break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});     
        }
        function fetchFullPharmacyDetails(pharid)
        {
           $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchfullpharmacydel',
                pharid      : pharid,
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(doctor.prescibtion.pharmacyfulldetails).html(ppdetails);
                            break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});      
        }
        function addPharmacydetails()
        {
            var flag=false;
            if($(doctor.pharmacyregistration.ppname).val()=="")
            {
                flag=false;
                $(doctor.pharmacyregistration.ppnamemsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.ppname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.ppnamemsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.pharmacyregistration.ppnamemsg).html('');
            }
            if($(doctor.pharmacyregistration.ppname).val().match(namee_reg))
            {
                 flag=true;
                 $(doctor.pharmacyregistration.ppnamemsg).html('');
            }
            else
            {
                flag=false;
                $(doctor.pharmacyregistration.ppnamemsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.ppname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.ppnamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            if($(doctor.pharmacyregistration.pharmacyname).val()=="")
            {
                flag=false;
                $(doctor.pharmacyregistration.pharmacynamemsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.pharmacyname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pharmacynamemsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.pharmacyregistration.pharmacynamemsg).html('');
            }
            if($(doctor.pharmacyregistration.pharmacyname).val().match(namee_reg))
            {
                 flag=true;
                 $(doctor.pharmacyregistration.pharmacynamemsg).html('');
            }
            else
            {
                flag=false;
                $(doctor.pharmacyregistration.pharmacynamemsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.pharmacyname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pharmacynamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            if($(doctor.pharmacyregistration.pharaddress).val()=="")
            {
                flag=false;
                $(doctor.pharmacyregistration.pharaddressmsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.pharaddress).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pharaddressmsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.pharmacyregistration.pharaddressmsg).html('');
            }
            if($(doctor.pharmacyregistration.pphonenum).val()=="" || Number($(doctor.pharmacyregistration.pphonenum).val())==0)
            {
                flag=false;
                $(doctor.pharmacyregistration.pphonenummsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.pphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pphonenummsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.pharmacyregistration.pphonenummsg).html('');
            }
            if($(doctor.pharmacyregistration.pphonenum).val().match(cell_reg))
            {
                flag=true;
                $(doctor.pharmacyregistration.pphonenummsg).html('');  
            }
            else
            {
               flag=false;
                $(doctor.pharmacyregistration.pphonenummsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.pphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pphonenummsg).offset().top) - 95
				}, 'slow');
                return; 
            }
            if($(doctor.pharmacyregistration.pharemail).val() != "")
            {
                if($(doctor.pharmacyregistration.pharemail).val() .match(email_reg))
                {
                    flag=true;
                $(doctor.pharmacyregistration.pharemailmsg).html(''); 
                }
                else
                {
                flag=false;
                $(doctor.pharmacyregistration.pharemailmsg).html(INVALIDNOT);
                $(doctor.pharmacyregistration.pharemail).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.pharmacyregistration.pharemailmsg).offset().top) - 95
				}, 'slow');
                return;   
                }
            }    
                if(flag)
                {
                    $(doctor.pharmacyregistration.pharmacysubmitBut).prop('disabled','disabled');
                    $(doctor.pharmacyregistration.pharmacymsgDiv).html(LOADER);
                    var attr={
                usertypeid      : $(doctor.registration.user_type_id).val(),
                ppname          : $(doctor.pharmacyregistration.ppname).val(),
                pharmacyname    : $(doctor.pharmacyregistration.pharmacyname).val(),
                pharaddress     : $(doctor.pharmacyregistration.pharaddress).val(),
                pphonenum       : Number($(doctor.pharmacyregistration.pphonenum).val()),
                pharemail       : $(doctor.pharmacyregistration.pharemail).val(),
                    }  
                            $.ajax({
					url: doctor.url,
					type: 'POST',
					data: {
						autoloader      : true,
						action          : 'addpharmacysinfo',
                                                pharmacyinfoinfo: attr
					},
					success: function(data, textStatus, xhr) {
						data = $.trim(data);
						switch (data) {
							case 'logout':
								logoutAdmin({});
								break;
							case 'login':
								loginAdmin({});
								break;
							default:
                                                                alert("Pharmacy has been successfully Added");
								$(doctor.pharmacyregistration.pharmacymsgDiv).html('');
								$('html, body').animate({
									scrollTop: Number($(doctor.pharmacyregistration.pharmacymsgDiv).offset().top) - 95
								}, 'slow');
								$(doctor.registration.form).get(0).reset();
								$(doctor.pharmacyregistration.pharemailmsg).html('');
                                                                $(doctor.pharmacyregistration.pharaddressmsg).html('');
                                                                $(doctor.pharmacyregistration.pharmacynamemsg).html('');
                                                                $(doctor.pharmacyregistration.pphonenummsg).html('');
                                                                $(doctor.pharmacyregistration.ppnamemsg).html('');
                                                                $(doctor.registration.regpharmacydetails).hide();
								break;
						}
					},
					error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
                                           $(doctor.pharmacyregistration.pharmacysubmitBut).removeAttr('disabled');
					}
				});
                }
        }
        function addDiagnosticdetails()
        {
            var flag=false;
            if($(doctor.diagnosticregistration.dpname).val()=="")
            {
                flag=false;
                $(doctor.diagnosticregistration.dpnamemsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.dpname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dpnamemsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.diagnosticregistration.dpnamemsg).html('');
            }
            if($(doctor.diagnosticregistration.dpname).val().match(namee_reg))
            {
                 flag=true;
                 $(doctor.diagnosticregistration.dpnamemsg).html('');
            }
            else
            {
                flag=false;
                $(doctor.diagnosticregistration.dpnamemsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.dpname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dpnamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            if($(doctor.diagnosticregistration.diagnosticname).val()=="")
            {
                flag=false;
                $(doctor.diagnosticregistration.diagnosticnamemsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.diagnosticname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.diagnosticnamemsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.diagnosticregistration.diagnosticnamemsg).html('');
            }
            if($(doctor.diagnosticregistration.diagnosticname).val().match(namee_reg))
            {
                 flag=true;
                 $(doctor.diagnosticregistration.diagnosticnamemsg).html('');
            }
            else
            {
                flag=false;
                $(doctor.diagnosticregistration.diagnosticnamemsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.diagnosticname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.diagnosticnamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            if($(doctor.diagnosticregistration.diagaddress).val()=="")
            {
                flag=false;
                $(doctor.diagnosticregistration.diagaddressmsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.diagaddress).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.diagaddressmsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.diagnosticregistration.diagaddressmsg).html('');
            }
            if($(doctor.diagnosticregistration.dphonenum).val()=="" || Number($(doctor.diagnosticregistration.dphonenum).val())==0)
            {
                flag=false;
                $(doctor.diagnosticregistration.dphonenummsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.dphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dphonenummsg).offset().top) - 95
				}, 'slow');
                return;
            }
            else
            {
                flag=true;
                $(doctor.diagnosticregistration.dphonenummsg).html('');
            }
            if($(doctor.diagnosticregistration.dphonenum).val().match(numbs))
            {
                flag=true;
                $(doctor.diagnosticregistration.dphonenummsg).html('');  
            }
            else
            {
               flag=false;
                $(doctor.diagnosticregistration.dphonenummsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.dphonenum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.dphonenummsg).offset().top) - 95
				}, 'slow');
                return; 
            }
            if($(doctor.diagnosticregistration.diagemail).val() != "")
            {
                if($(doctor.diagnosticregistration.diagemail).val() .match(email_reg))
                {
                    flag=true;
                $(doctor.diagnosticregistration.diagemailmsg).html(''); 
                }
                else
                {
                flag=false;
                $(doctor.diagnosticregistration.diagemailmsg).html(INVALIDNOT);
                $(doctor.diagnosticregistration.diagemail).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.diagnosticregistration.diagemailmsg).offset().top) - 95
				}, 'slow');
                return;   
                }
            }    
                if(flag)
                {
                    $(doctor.diagnosticregistration.diagnosticSubmitBut).prop('disabled','disabled');
                    $(doctor.diagnosticregistration.diagnosticmsgDiv).html(LOADER);
                    var attr={
                usertypeid      : $(doctor.registration.user_type_id).val(),
                ppname          : $(doctor.diagnosticregistration.dpname).val(),
                pharmacyname    : $(doctor.diagnosticregistration.diagnosticname).val(),
                pharaddress     : $(doctor.diagnosticregistration.diagaddress).val(),
                pphonenum       : Number($(doctor.diagnosticregistration.dphonenum).val()),
                pharemail       : $(doctor.diagnosticregistration.diagemail).val(),
                
                    }  
                            $.ajax({
					url: doctor.url,
					type: 'POST',
					data: {
						autoloader      : true,
						action          : 'addpharmacysinfo',
                                                pharmacyinfoinfo: attr
					},
					success: function(data, textStatus, xhr) {
						data = $.trim(data);
						switch (data) {
							case 'logout':
								logoutAdmin({});
								break;
							case 'login':
								loginAdmin({});
								break;
							default:
                                                                alert("Diagnostic has been successfully Added");
								$(doctor.diagnosticregistration.diagnosticmsgDiv).html('');
								$('html, body').animate({
									scrollTop: Number($(doctor.diagnosticregistration.diagnosticmsgDiv).offset().top) - 95
								}, 'slow');
								$(doctor.registration.form).get(0).reset();
								$(doctor.diagnosticregistration.diagemailmsg).html('');
                                                                $(doctor.diagnosticregistration.diagaddressmsg).html('');
                                                                $(doctor.diagnosticregistration.diagnosticnamemsg).html('');
                                                                $(doctor.diagnosticregistration.dphonenummsg).html('');
                                                                $(doctor.diagnosticregistration.dpnamemsg).html('');
                                                                $(doctor.registration.regdiagnosticdetails).hide();
								break;
						}
					},
					error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
					$(doctor.diagnosticregistration.diagnosticSubmitBut).removeAttr('disabled');
						
					}
				});
                }
        }
        function displayregistrationdetails()
        {
            if(Number($(doctor.registration.user_type_id).val())=='')
            {
                $(doctor.registration.regdiagnosticdetails).hide();
                $(doctor.registration.regpatientdetails).hide();
                $(doctor.registration.regpharmacydetails).hide();
            }
            if(Number($(doctor.registration.user_type_id).val())==2)
            {
                $(doctor.registration.regdiagnosticdetails).hide();
                $(doctor.registration.regpatientdetails).show();
                $(doctor.registration.regpharmacydetails).hide();
            }
            if(Number($(doctor.registration.user_type_id).val())==3)
            {
                $(doctor.registration.regdiagnosticdetails).hide();
                $(doctor.registration.regpatientdetails).hide();
                $(doctor.registration.regpharmacydetails).show();
            }
            if(Number($(doctor.registration.user_type_id).val())==4)
            {
                $(doctor.registration.regdiagnosticdetails).show();
                $(doctor.registration.regpatientdetails).hide();
                $(doctor.registration.regpharmacydetails).hide();
            }
        }
        function fetchusertypes()
        {
        $(doctor.registration.regdiagnosticdetails).hide();
        $(doctor.registration.regpatientdetails).hide();
        $(doctor.registration.regpharmacydetails).hide();
        $(doctor.registration.usertypereg).html(LOADER);
         $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchusertypes',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var usertype=$.parseJSON(data);
                    $(doctor.registration.usertypereg).html(usertype);
                    window.setTimeout(function (){
                        $(doctor.registration.user_type_id).change(function (){
                        displayregistrationdetails();
                    });
                    },300)
                    
		break;
			}
                    },
                error: function() {
//		$(colls.outputDiv).html(INET_ERROR);
			},
		complete: function(xhr, textStatus) {
		console.log(xhr.status);
			}
				});   
        }
        function adddoctorinfo()
        {
            var flag=false;
            if($(doctor.doctor_infor.doctorname).val()=="")
                {
                flag=false;
                $(doctor.doctor_infor.doctornamemsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctorname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctornamemsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.doctor_infor.doctornamemsg).html('');
                flag=true;  
                }
            if($(doctor.doctor_infor.doctorname).val().match(namee_reg))
                {
                $(doctor.doctor_infor.doctornamemsg).html('');
                flag=true; 
                } 
                else
                {
                flag=false;
                $(doctor.doctor_infor.doctornamemsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctorname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctornamemsg).offset().top) - 95
				}, 'slow');
                return;
            }
            if($(doctor.doctor_infor.doctorid).val()=="")
                {
                flag=false;
                $(doctor.doctor_infor.doctoridmsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctorid).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctoridmsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.doctor_infor.doctoridmsg).html('');
                flag=true;  
                }    
            if($(doctor.doctor_infor.clinicname).val()=="")
                {
                flag=false;
                $(doctor.doctor_infor.clinicnamemsg).html(INVALIDNOT);
                $(doctor.doctor_infor.clinicname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.clinicnamemsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.doctor_infor.clinicnamemsg).html('');
                flag=true;  
                }   
            if(flag)
                {
                $(".sub_container").slideUp(1000);
                $("#doctor_info_nextpro").slideDown(1500);
                $(doctor.doctor_infor.doctor_info_next2).click(function (){
                    adddoctorinfonextpro();
                })
                }
        };
        function adddoctorinfonextpro()
        {
            var flag=false;
            if($(doctor.doctor_infor.doctoraddress).val()=="")
                {
                flag=false;
                $(doctor.doctor_infor.doctoraddressmsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctoraddress).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctoraddressmsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.doctor_infor.doctoraddressmsg).html('');
                flag=true;  
                } 
            if($(doctor.doctor_infor.doctorcellnum).val()=="")
                {
                flag=false;
                $(doctor.doctor_infor.doctorcellnummsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctorcellnum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctorcellnummsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.doctor_infor.doctorcellnummsg).html('');
                flag=true;  
                }
            if($(doctor.doctor_infor.doctorcellnum).val().match(cell_reg))
                {
                $(doctor.doctor_infor.doctorcellnumsmsg).html('');
                flag=true;    
                } 
                else
                {
                flag=false;
                $(doctor.doctor_infor.doctorcellnummsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctorcellnum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctorcellnummsg).offset().top) - 95
				}, 'slow');
                return;  
                }    
            if($(doctor.doctor_infor.doctoremail).val()=="")
                {
                flag=false;
                $(doctor.doctor_infor.doctoremailmsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctoremail).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctoremailmsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.doctor_infor.doctoremailmsg).html('');
                flag=true;  
                }  
            if($(doctor.doctor_infor.doctoremail).val().match(email_reg))
                {
                $(doctor.doctor_infor.doctoremailmsg).html('');
                flag=true;
                } 
                else
                {
                flag=false;
                $(doctor.doctor_infor.doctoremailmsg).html(INVALIDNOT);
                $(doctor.doctor_infor.doctoremail).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.doctor_infor.doctoremailmsg).offset().top) - 95
				}, 'slow');
                return;  
                }  
                attr ={
                    doctorname      : $(doctor.doctor_infor.doctorname).val(),
                    doctorid        : $(doctor.doctor_infor.doctorid).val(),
                    clinicname      : $(doctor.doctor_infor.clinicname).val(),
                    doctoraddress   : $(doctor.doctor_infor.doctoraddress).val(),
                    doctorcellnum   : Number($(doctor.doctor_infor.doctorcellnum).val()),
                    doctoremail     : $(doctor.doctor_infor.doctoremail).val(),
                }
                if(flag)
                {
                    $.ajax({
					url: doctor.url,
					type: 'POST',
					data: {
						autoloader  : true,
						action      : 'adddoctorinfo',
						doctorinfo  : attr
					},
					success: function(data, textStatus, xhr) {
						switch (data) {
							case 'logout':
								logoutAdmin({});
								break;
							case 'login':
								loginAdmin({});
								break;
							default:
                                                                alert("Details has been updated");
//								$(doctor.doctor_infor.outputmsgdiv).html('Details has been updated');
								$('html, body').animate({
									scrollTop: Number($(doctor.doctor_infor.outputmsgdiv).offset().top) - 95
								}, 'slow');
								$(doctor.doctor_infor.form).get(0).reset();
                                                                $(doctor.doctor_infor.doctoraddressmsg).html('');
                                                                $(doctor.doctor_infor.doctorcellnummsg).html('');
                                                                $(doctor.doctor_infor.doctoremailmsg).html('');
                                                                window.location.href='doctor.html';
								// fetchUsers();
								break;
						}
					},
					error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
						
					}
				});
                }
                
                
        }
        function addpatientdetails()
        {
            var flag=false;
            var pgender=$('input[name=patientgender]:checked').val();
            if($(doctor.patientregistration.user_type_id).val()=="")
            {
              flag=false;
                $(doctor.patientregistration.user_type_idmsg).html(INVALIDNOT);
                $(doctor.patientregistration.user_type_id).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.user_type_idmsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $(doctor.patientregistration.user_type_idmsg).html('');
              flag=true;
            }
            if($(doctor.patientregistration.patientname).val()=="")
                {
                flag=false;
                $(doctor.patientregistration.patientnamemsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientnamemsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.patientregistration.patientnamemsg).html('');
                flag=true;  
                }
            if($(doctor.patientregistration.patientname).val().match(namee_reg))
                {
                $(doctor.patientregistration.patientnamemsg).html('');
                flag=true; 
                } 
                else
                {
                flag=false;
                $(doctor.patientregistration.patientnamemsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientname).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientnamemsg).offset().top) - 95
				}, 'slow');
                return;
                }
                var count = 0;
                var img='';
                var val = $.trim( $(doctor.patientregistration.patientphoto).val() );
			                if(count == 0){
				for (var i = 0; i < $(doctor.patientregistration.patientphoto).get(0).files.length; ++i) {
			    	img = $(doctor.patientregistration.patientphoto).get(0).files[i].name;
			    	var extension = img.split('.').pop().toUpperCase();
			    	if(extension!="PNG" && extension!="JPG" && extension!="GIF" && extension!="JPEG"){
			    		count= count+ 1
			    	}
			    }
				if( count> 0) $( doctor.patientregistration.patientphotomsg ).html(INVALIDNOT);
			}    
                if( count> 0){
                        flag=false
		    	return;
		    } else {
		    	$(doctor.patientregistration.patientphotomsg).html( "" );
		    }        
            if($(doctor.patientregistration.patientage).val()== "" || Number($(doctor.patientregistration.patientage).val())==0 || $(doctor.patientregistration.patientage).val().length >3)
                {
                flag=false;
                $(doctor.patientregistration.patientagemsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientage).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientagemsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.patientregistration.patientagemsg).html('');
                flag=true;  
                } 
             if($(doctor.patientregistration.patientage).val().match(numbs) )
                {
                $(doctor.patientregistration.patientagemsg).html('');
                flag=true;      
                } 
                else
                {
                flag=false;
                $(doctor.patientregistration.patientagemsg).html(INVALIDNOT+INTEGERMSG);
                $(doctor.patientregistration.patientage).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientagemsg).offset().top) - 95
				}, 'slow');
                return;
                }  
            if(pgender.length <= 0)
                {
                flag=false;
                $(doctor.patientregistration.patientgendermsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientgender).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientgendermsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.patientregistration.patientgendermsg).html('');
                flag=true;  
                }     
            if($(doctor.patientregistration.patientcellnum).val()=="" || Number($(doctor.patientregistration.patientcellnum).val())==0)
                {
                flag=false;
                $(doctor.patientregistration.patientcellnummsg).html(INVALIDNOT);
                $(doctor.patientregistration.patientcellnum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientcellnummsg).offset().top) - 95
				}, 'slow');
                return;
                } 
                else
                {
                $(doctor.patientregistration.patientcellnummsg).html('');
                flag=true;  
                }  
             if($(doctor.patientregistration.patientcellnum).val().match(cell_reg))
                {
                $(doctor.patientregistration.patientcellnummsg).html('');
                flag=true;    
                } 
                else
                {
                flag=false;
                $(doctor.patientregistration.patientcellnummsg).html(INVALIDNOT+INTEGERMSG);
                $(doctor.patientregistration.patientcellnum).focus();
                $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientcellnummsg).offset().top) - 95
				}, 'slow');
                return; 
                }   
            if($(doctor.patientregistration.patientemail).val()!="" )
                {
                   if($(doctor.patientregistration.patientemail).val().match(email_reg) ) 
                   {
                    flag=true;
                    $(doctor.patientregistration.patientemailmsg).html(''); 
                   }
                 else
                 {
                    flag=false;
                    $(doctor.patientregistration.patientemailmsg).html(INVALIDNOT);
                    $(doctor.patientregistration.patientemail).focus();
                    $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientemailmsg).offset().top) - 95
				}, 'slow');
                return;
                }
                }
                if($(doctor.patientregistration.patientgname).val()!="" )
                {
                   if($(doctor.patientregistration.patientgname).val().match(namee_reg) ) 
                   {
                    flag=true;
                    $(doctor.patientregistration.patientgnamemsg).html(''); 
                   }
                 else
                 {
                    flag=false;
                    $(doctor.patientregistration.patientgnamemsg).html(INVALIDNOT);
                    $(doctor.patientregistration.patientgname).focus();
                    $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientgnamemsg).offset().top) - 95
				}, 'slow');
                return;
                }
                }
                if($(doctor.patientregistration.patientgcellnum).val()!="" )
                {
                   if($(doctor.patientregistration.patientgcellnum).val().match(cell_reg) ) 
                   {
                    flag=true;
                    $(doctor.patientregistration.patientgcellnummsg).html(''); 
                   }
                 else
                 {
                    flag=false;
                    $(doctor.patientregistration.patientgcellnummsg).html(INVALIDNOT);
                    $(doctor.patientregistration.patientgcellnum).focus();
                    $('html, body').animate({
					scrollTop: Number($(doctor.patientregistration.patientgcellnummsg).offset().top) - 95
				}, 'slow');
                return;
                }
                }
            var attr={
                usertypeid  : $(doctor.patientregistration.user_type_id).val(),
                patientname : $(doctor.patientregistration.patientname).val(),
                patientage  : $(doctor.patientregistration.patientage).val(),
                patientgender :$('input[name=patientgender]:checked').val(),
                patientaddress :$(doctor.patientregistration.patientaddress).val(),
                patientcellnum :$(doctor.patientregistration.patientcellnum).val(),
                patientemail :$(doctor.patientregistration.patientemail).val(),
                patientgname :$(doctor.patientregistration.patientgname).val(),
                patientgcellnum :$(doctor.patientregistration.patientgcellnum).val(),
            };
                    if(flag)
                    {
                        $(doctor.patientregistration.patientmsgDiv).html(LOADER);
                        $(doctor.patientregistration.patientsubmitBut).prop('disabled','disabled');
                            $.ajax({
					url: doctor.url,
					type: 'POST',
					data: {
						autoloader  : true,
						action      : 'addpatientinfo',
						patientinfo  : attr
					},
					success: function(data, textStatus, xhr) {
						switch (data) {
							case 'logout':
								logoutAdmin({});
								break;
							case 'login':
								loginAdmin({});
								break;
							default:
                                                                alert("patient has been successfully Added");
								$(doctor.patientregistration.patientmsgDiv).html('');
								$('html, body').animate({
									scrollTop: Number($(doctor.patientregistration.patientmsgDiv).offset().top) - 95
								}, 'slow');
								$(doctor.registration.form).get(0).reset();
                                                                $(doctor.patientregistration.patientnamemsg).html('');
                                                                $(doctor.patientregistration.patientagemsg).html('');
                                                                $(doctor.patientregistration.patientgendermsg).html('');
                                                                $(doctor.patientregistration.patientaddressmsg).html('');
                                                                $(doctor.patientregistration.patientcellnummsg).html('');
                                                                $(doctor.patientregistration.patientemailmsg).html('');
                                                                $(doctor.patientregistration.patientgnamemsg).html('');
                                                                $(doctor.patientregistration.patientgcellnummsg).html('');
                                                                $(doctor.registration.regpatientdetails).hide();
								// fetchUsers();
								break;
						}
					},
					error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
                                                $(doctor.patientregistration.patientsubmitBut).removeAttr('disabled');
					}
				});   
                    }
            
        }
        function fetchpatientdetails()
        {
            $(doctor.patient.patient_list).html(LOADER);
            var htm='';
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpatientdetails',
		},
		success: function(data, textStatus, xhr) {
		switch (data) {
		default:
                    var pdetails=$.parseJSON(data)
                    var leng=pdetails.pdata.length;
                    if(leng > 0)
                    {
                        for(i=0;i<leng;i++)
                        {
                            htm +=pdetails.pdata[i];
                        }
                    $(doctor.patient.patient_list_history).hide();   
                    $(doctor.patient.patient_list).show();
                    $(doctor.patient.patient_list).html(pdetails.divheader+pdetails.tableheader+ htm +pdetails.tablefooter+pdetails.divfooter);    
                    }
                    else
                    {
                     $(doctor.patient.patient_list).html(pdetails.divheader+" No Patient has Registered"+pdetails.divfooter);   
                    }
                    window.setTimeout(function (){
//                        $('#dataTable-patientlist').dataTable();
                        for(i=0;i<leng;i++)
                        {
                            $(pdetails.viewhistory+pdetails.pids[i]).bind('click',{id: pdetails.pids[i]},function(event) {
                               var pid= event.data.id;
                              fetchpatienthistory(pid);
                            })
                        }
                    },300)
		break;
			}
                    },
                error: function() {
//		$(colls.outputDiv).html(INET_ERROR);
			},
		complete: function(xhr, textStatus) {
			}
				});
        }
        function fetchpatienthistory(pid)
        {
            var htm='';
         $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpatienthistory',
                pid         : pid
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    var  pdetails=$.parseJSON(data);
                    var len=pdetails.pdata.length;
                    for(i=0;i<len;i++)
                    {
                        htm +=pdetails.pdata[i];
                    }
                    $(doctor.patient.patient_list_history).show();
                    $(doctor.patient.patient_list_history).html(pdetails.divheader+htm+pdetails.divfooter);
                    $(doctor.patient.patient_list).hide();
		break;
			}
                    },
                error: function() {
//		$(colls.outputDiv).html(INET_ERROR);
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }
        function fetchdiagnosticsdetails()
        {
            $(doctor.diagnostic.diagnostic_list).html(LOADER);
            $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchdiagnosticsdetails',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    $(doctor.diagnostic.diagnostic_list).html(data);
                    
		break;
			}
                    },
                error: function() {
//		$(colls.outputDiv).html(INET_ERROR);
			},
		complete: function(xhr, textStatus) {
			}
				});
            
        }
        function fetchPharmacydetails()
        {
            $(doctor.pharmacy.pharmacy_list).html(LOADER);
         $.ajax({
                url: doctor.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchPharmacydetails',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
		switch (data) {
		default:
                    $(doctor.pharmacy.pharmacy_list).html(data);
		break;
			}
                    },
                error: function() {
//		$(colls.outputDiv).html(INET_ERROR);
			},
		complete: function(xhr, textStatus) {
			}
				});   
        }
}


