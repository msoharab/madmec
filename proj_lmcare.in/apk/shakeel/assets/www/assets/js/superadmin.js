 function superAdminController()
 {
    var superadmin = {};
	this.__construct = function(ctrl) {
            superadmin = ctrl;
            $(superadmin.createdoctor.But).click(function (){
                createDoctor();
            }) ;   
            $(superadmin.createdoctor.docotoremailid).change(function (){
                checkdocemailid();
            })
            $(superadmin.createdoctor.doctorusername).change(function (){
                checkdocusername();
            })
            $(superadmin.viewdoctor.viewdoctorsmenuBut).click(function (){
                listOfDoctors();
            }) ; 
            $(superadmin.doctorrequest.docotorreqmenuBut).click(function (){
                FetchDoctorsRequest();
            });
            $(superadmin.testupdates.addtestBut).click(function (){
                AddDiagnosticTest();
            }) 
            $(superadmin.testupdates.viewtests).click(function (){
                fetchDiagnosticTest();
            })
            $(superadmin.testupdates.createtests).click(function (){
                fetchTypesOfTest();
            })
        } 
        function fetchTypesOfTest()
        {
            var typesoftest=[];
          $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'fetchtypesoftest',
                    },
                    success: function(data, textStatus, xhr) {
                            data=$.trim(data);
                            switch (data) {
                                    case 'logout':
                                            logoutAdmin({});
                                            break;
                                    case 'login':
                                            loginAdmin({});
                                            break;
                                    default:
                                            var detailss=$.parseJSON(data);
                                            $(function() {
                                            for(i=0;i<detailss.length;i++)
                                            {
                                                typesoftest[i]=detailss[i];
                                            }
                                             $(superadmin.testupdates.testcate ).autocomplete({
                                                source : typesoftest,
                                                });
                                            });
                                            break;
                            }
                    },
                    error: function() {
//						
                    },
                    complete: function(xhr, textStatus) {
                    }
            });  
        }
        function fetchDiagnosticTest()
        {
             $(superadmin.testupdates.diplaytests).html(LOADER);
          $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'fetchdiagtest',
                    },
                    success: function(data, textStatus, xhr) {
                            console.log(data)
                            data=$.trim(data);
                            switch (data) {
                                    case 'logout':
                                            logoutAdmin({});
                                            break;
                                    case 'login':
                                            loginAdmin({});
                                            break;
                                    default:
                                            var detailss=$.parseJSON(data);
                                            $(superadmin.testupdates.diplaytests).html(detailss.reqdata);
                                                window.setTimeout(function (){
                                                for(i=0;i<detailss.reqids.length;i++)
                                                {
                                               $('#'+superadmin.testupdates.deleteOk+detailss.reqids[i]).bind('click',{id:detailss.reqids[i]},function (event){
                                                        var testid=event.data.id;
                                                        deleteTest(testid);
                                                    });
                                                }
                                                },300);
                                            
                                            break;
                            }
                    },
                    error: function() {
//						
                    },
                    complete: function(xhr, textStatus) {
                    }
            });            
        }
        function deleteTest(testid)
        {
          $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'deltest',
                            testid      : testid,
                    },
                    success: function(data, textStatus, xhr) {
                            data=$.trim(data);
                            switch (data) {
                                    case 'logout':
                                            logoutAdmin({});
                                            break;
                                    case 'login':
                                            loginAdmin({});
                                            break;
                                    default:
                                            var detailss=$.parseJSON(data);
                                            alert("Test has been Deleted Successfully");
                                            $('#'+superadmin.testupdates.viewtestrow+testid).remove();
                                            break;
                            }
                    },
                    error: function() {
//						
                    },
                    complete: function(xhr, textStatus) {
                    }
            });            
        }   
        function AddDiagnosticTest()
        {
            var flag=false;
            if($(superadmin.testupdates.testcate).val()=="")
            {
             flag=false;
                $(superadmin.testupdates.testcatemsg).html(INVALIDNOT);
                $(superadmin.testupdates.testcate).focus();
                $('html, body').animate({
					scrollTop: Number($(superadmin.testupdates.testcatemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $(superadmin.testupdates.testcatemsg).html('');
              flag=true;
            }
            if($(superadmin.testupdates.testname).val()=="")
            {
             flag=false;
                $(superadmin.testupdates.testnamemsg).html(INVALIDNOT);
                $(superadmin.testupdates.testname).focus();
                $('html, body').animate({
					scrollTop: Number($(superadmin.testupdates.testnamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $(superadmin.testupdates.testnamemsg).html('');
              flag=true;
            }
            if(flag)
            {
                var attr={
                  testcat   :   $(superadmin.testupdates.testcate).val(),
                  testname  :   $(superadmin.testupdates.testname).val(),
                }
                $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'addtest',
                           inputinfo    : attr,
                    },
                    success: function(data, textStatus, xhr) {
                            data=$.trim(data);
                            switch (data) {
                                    case 'logout':
                                            logoutAdmin({});
                                            break;
                                    case 'login':
                                            loginAdmin({});
                                            break;
                                    default:
                                            var detailss=$.parseJSON(data);
                                            alert("Test has been Added Successfully");
                                            $(superadmin.testupdates.form).get(0).reset();
                                            break;
                            }
                    },
                    error: function() {
//						
                    },
                    complete: function(xhr, textStatus) {
                    }
            });          
            }
        }
        function FetchDoctorsRequest()
        {
            $(superadmin.doctorrequest.doctorrequests).html(LOADER);
           $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'fetchdocreq',
                    },
                    success: function(data, textStatus, xhr) {
//                            console.log(data);
                            data=$.trim(data);
                            switch (data) {
                                    case 'logout':
                                            logoutAdmin({});
                                            break;
                                    case 'login':
                                            loginAdmin({});
                                            break;
                                    default:
                                            var detailss=$.parseJSON(data);
                                            $(superadmin.doctorrequest.doctorrequests).html(detailss.reqdata);
                                            window.setTimeout(function (){
                                                for(i=0;i<detailss.reqids.length;i++)
                                                {
                                                    $('#'+superadmin.doctorrequest.requsername+detailss.reqids[i]).bind('change',{id:detailss.reqids[i]},function (event){
                                                        var userid=event.data.id;
                                                        checkUsernameRequest(userid);
                                                    });
                                                    $('#'+superadmin.doctorrequest.requseremail+detailss.reqids[i]).bind('change',{id:detailss.reqids[i]},function (event){
                                                        var userid=event.data.id;
                                                        checkEmailRequest(userid);
                                                    });
                                                    $('#'+superadmin.doctorrequest.sendreqemail+detailss.reqids[i]).bind('click',{id:detailss.reqids[i]},function (event){
                                                        var userid=event.data.id;
                                                        activateUserAccount(userid);
                                                    });
                                                }
                                            },300);
                                            break;
                            }
                    },
                    error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function(xhr, textStatus) {
                    }
            });  
        }
        function activateUserAccount(reqid)
        {
            var flag=false;
            if($('#'+superadmin.doctorrequest.requseremail+reqid).val()=="")
            {
                flag=false;
            $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html(INVALIDNOT);
                $('#'+superadmin.doctorrequest.requseremail+reqid).focus();
                $('html, body').animate({
					scrollTop: Number($('#'+superadmin.doctorrequest.requseremailmsg+reqid).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html('');
              flag=true;
            }
            if(!$('#'+superadmin.doctorrequest.requseremail+reqid).val().match(email_reg))
            {
                flag=false;
            $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html(INVALIDNOT);
                $('#'+superadmin.doctorrequest.requseremail+reqid).focus();
                $('html, body').animate({
					scrollTop: Number($('#'+superadmin.doctorrequest.requseremailmsg+reqid).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html('');
              flag=true;
            }
            if(!$('#'+superadmin.doctorrequest.hidrequseremail+reqid).val()=="")
            {
                flag=false;
            $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html(ALREADYEXIST);
                $('#'+superadmin.doctorrequest.requseremail+reqid).focus();
                $('html, body').animate({
					scrollTop: Number($('#'+superadmin.doctorrequest.requseremailmsg+reqid).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html('');
              flag=true;
            }
            if($('#'+superadmin.doctorrequest.requsername+reqid).val()=="" || $('#'+superadmin.doctorrequest.requsername+reqid).val().length < 5)
            {
                flag=false;
            $('#'+superadmin.doctorrequest.requsernamemsg+reqid).html(INVALIDNOT);
                $('#'+superadmin.doctorrequest.requsername+reqid).focus();
                $('html, body').animate({
					scrollTop: Number($('#'+superadmin.doctorrequest.requsernamemsg+reqid).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $('#'+superadmin.doctorrequest.requsernamemsg+reqid).html('');
              flag=true;
            }
            if(!$('#'+superadmin.doctorrequest.hidrequsername+reqid).val()=="" )
            {
                flag=false;
            $('#'+superadmin.doctorrequest.requsernamemsg+reqid).html(ALREADYEXIST);
                $('#'+superadmin.doctorrequest.requsername+reqid).focus();
                $('html, body').animate({
					scrollTop: Number($('#'+superadmin.doctorrequest.requsernamemsg+reqid).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $('#'+superadmin.doctorrequest.requsernamemsg+reqid).html('');
              flag=true;
            }
            if($('#'+superadmin.doctorrequest.reqpassword+reqid).val()=="" || $('#'+superadmin.doctorrequest.reqpassword+reqid).val().length < 5)
            {
                flag=false;
            $('#'+superadmin.doctorrequest.reqpasswordmsg+reqid).html(INVALIDNOT);
                $('#'+superadmin.doctorrequest.reqpassword+reqid).focus();
                $('html, body').animate({
					scrollTop: Number($('#'+superadmin.doctorrequest.reqpasswordmsg+reqid).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $('#'+superadmin.doctorrequest.reqpasswordmsg+reqid).html('');
              flag=true;
            }
            if(flag)
            {
                var attr={
                    reqid       : reqid,
                    reqemail    : $('#'+superadmin.doctorrequest.requseremail+reqid).val(),
                    requsername : $('#'+superadmin.doctorrequest.requsername+reqid).val(),
                    reqpassword : $('#'+superadmin.doctorrequest.reqpassword+reqid).val()
                }
             $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'activateuseraccount',
                            inputinfo   : attr
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
                                            var detailss=$.parseJSON(data);
                                            if(detailss)
                                            {
                                             alert("User has been Activated Successfully"); 
                                             $('#'+superadmin.doctorrequest.rowid+reqid).remove();
                                            }
                                             else
                                             {
                                              alert("User hasn't been Activated"); 
                                                }
                                            break;
                            }
                    },
                    error: function() {
//						
                    },
                    complete: function(xhr, textStatus) {
                    }
            });          
            }
        }
        function checkEmailRequest(reqid)
        {
         $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'checkdoceml',
                            docemail    : $('#'+superadmin.doctorrequest.requseremail+reqid).val(),
                            req         : 'req',
                            reqid       : reqid
                    },
                    success: function(data, textStatus, xhr) {
                            console.log(data);
                            data=$.trim(data);
                            switch (data) {
                                    case 'logout':
                                            logoutAdmin({});
                                            break;
                                    case 'login':
                                            loginAdmin({});
                                            break;
                                    default:
                                            var detailss=$.parseJSON(data);
                                            if(Number(detailss))
                                            {
                                            $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html(ALREADYEXIST);
                                            $('#'+superadmin.doctorrequest.hidrequseremail+reqid).val('exist');
                                            }
                                            else
                                            {
                                             $('#'+superadmin.doctorrequest.requseremailmsg+reqid).html('');
                                             $('#'+superadmin.doctorrequest.hidrequseremail+reqid).val('');
                                            }
                                            break;
                            }
                    },
                    error: function() {
//						
                    },
                    complete: function(xhr, textStatus) {
                    }
            });          
        }
        function checkUsernameRequest(reqid)
        {
            $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'checkdocusr',
                            docuser     : $('#'+superadmin.doctorrequest.requsername+reqid).val()
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
                                            var detailss=$.parseJSON(data);
                                            if(Number(detailss))
                                            {
                                            $('#'+superadmin.doctorrequest.requsernamemsg+reqid).html(ALREADYEXIST);
                                            $('#'+superadmin.doctorrequest.hidrequsername+reqid).val('exist');
                                            }
                                            else
                                            {
                                             $('#'+superadmin.doctorrequest.requsernamemsg+reqid).html('');
                                             $('#'+superadmin.doctorrequest.hidrequsername+reqid).val('');
                                            }
                                            break;
                            }
                    },
                    error: function() {
//						
                    },
                    complete: function(xhr, textStatus) {
                    }
            });       
        }
        function createDoctor()
        {
            var flag=false;
            if($(superadmin.createdoctor.docotoremailid).val()== "")
            {
                flag=false;
                $(superadmin.createdoctor.docotoremailidmsg).html(INVALIDNOT);
                $(superadmin.createdoctor.docotoremailid).focus();
                $('html, body').animate({
					scrollTop: Number($(superadmin.createdoctor.docotoremailidmsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              $(superadmin.createdoctor.docotoremailidmsg).html('');
              flag=true;
            }
            if(!$(superadmin.createdoctor.docotoremailid).val().match(email_reg))
            {
                flag=false;
                $(superadmin.createdoctor.docotoremailidmsg).html(INVALIDNOT);
                $(superadmin.createdoctor.docotoremailid).focus();
                $('html, body').animate({
					scrollTop: Number($(superadmin.createdoctor.docotoremailidmsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              flag=true;
              $(superadmin.createdoctor.docotoremailidmsg).html('');
            } 
            if($(superadmin.createdoctor.hiddocotoremailid).val()=="")
            {
               flag=true;
              $(superadmin.createdoctor.docotoremailidmsg).html(''); 
            }
            else
            {
              flag=false;
                $(superadmin.createdoctor.docotoremailidmsg).html(ALREADYEXIST);
                $(superadmin.createdoctor.docotoremailid).focus();
                $('html, body').animate({
                                        scrollTop: Number($(superadmin.createdoctor.docotoremailidmsg).offset().top) - 95
                                }, 'slow');
                return;   
            }
            if($(superadmin.createdoctor.doctorusername).val()== "" || $(superadmin.createdoctor.doctorusername).val().length < 5)
            {
                flag=false;
                $(superadmin.createdoctor.doctorusernamemsg).html(INVALIDNOT);
                $(superadmin.createdoctor.doctorusername).focus();
                $('html, body').animate({
					scrollTop: Number($(superadmin.createdoctor.doctorusernamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              flag=true;
              $(superadmin.createdoctor.doctorusernamemsg).html('');
            }
            if(!$(superadmin.createdoctor.hiddoctorusername).val()== "")
            {
                flag=false;
                $(superadmin.createdoctor.doctorusernamemsg).html(ALREADYEXIST);
                $(superadmin.createdoctor.doctorusername).focus();
                $('html, body').animate({
					scrollTop: Number($(superadmin.createdoctor.doctorusernamemsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              flag=true;
              $(superadmin.createdoctor.doctorusernamemsg).html('');
            }
            if($(superadmin.createdoctor.doctorpassword).val()== "" || $(superadmin.createdoctor.doctorpassword).val().length < 5)
            {
                flag=false;
                $(superadmin.createdoctor.doctorpasswordmsg).html(INVALIDNOT);
                $(superadmin.createdoctor.doctorpassword).focus();
                $('html, body').animate({
					scrollTop: Number($(superadmin.createdoctor.doctorpasswordmsg).offset().top) - 95
				}, 'slow');
                return;  
            }
            else
            {
              flag=true;
              $(superadmin.createdoctor.doctorpasswordmsg).html('');
            }
            if(flag)
            {
                var attr ={
                  docotoremailid : $(superadmin.createdoctor.docotoremailid).val(),
                  doctorusername : $(superadmin.createdoctor.doctorusername).val(),
                  doctorpassword : $(superadmin.createdoctor.doctorpassword).val(),
                };
              $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'createdoctor',
                          cdocotorinfo  : attr
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
                                            alert("Doctor has been Added successfully");
                                            $(superadmin.createdoctor.createdoctorMsgDiv).html('<h3>Doctor has been Added successfully </h3>');
                                            $('html, body').animate({
                                                    scrollTop: Number($(superadmin.createdoctor.createdoctorMsgDiv).offset().top) - 95
                                            }, 'slow');
                                            $(superadmin.createdoctor.form).get(0).reset();
                                            break;
                            }
                    },
                    error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function(xhr, textStatus) {
                    }
            });  
            }
        }
        function checkdocemailid()
        {
          $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'checkdoceml',
                            docemail    : $(superadmin.createdoctor.docotoremailid).val()
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
                                            var detailss=$.parseJSON(data);
                                            if(Number(detailss))
                                            {
                                            $(superadmin.createdoctor.docotoremailidmsg).html(ALREADYEXIST);
                                            $(superadmin.createdoctor.hiddocotoremailid).val("exist");
                                            }
                                            else
                                            {
                                             $(superadmin.createdoctor.docotoremailidmsg).html('');
                                             $(superadmin.createdoctor.hiddocotoremailid).val('');   
                                            }
                                            break;
                            }
                    },
                    error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function(xhr, textStatus) {
                    }
            });    
        }
        function checkdocusername()
        {
         $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'checkdocusr',
                            docuser     : $(superadmin.createdoctor.doctorusername).val()
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
                                            var detailss=$.parseJSON(data);
                                            if(Number(detailss))
                                            {
                                            $(superadmin.createdoctor.doctorusernamemsg).html(ALREADYEXIST);
                                            $(superadmin.createdoctor.hiddoctorusername).val("exist");
                                            }
                                            else
                                            {
                                             $(superadmin.createdoctor.doctorusernamemsg).html('');
                                             $(superadmin.createdoctor.hiddoctorusername).val('');   
                                            }
                                            break;
                            }
                    },
                    error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function(xhr, textStatus) {
                    }
            });       
        }
        function listOfDoctors()
        {
        $(superadmin.viewdoctor.listofdocotrs).html(LOADER);
         $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'fetchlistofdoctor',
                    },
                    success: function(data, textStatus, xhr) {
                            console.log(data);
                            data=$.trim(data);
                            switch (data) {
                                    case 'logout':
                                            logoutAdmin({});
                                            break;
                                    case 'login':
                                            loginAdmin({});
                                            break;
                                    default:
                                            var detailss=$.parseJSON(data);
                                            $(superadmin.viewdoctor.listofdocotrs).html(detailss.docdata);
                                            window.setTimeout(function (){
                                                for(i=0;i<detailss.docids.length;i++)
                                                {
                                                    $('#'+superadmin.viewdoctor.inactive+detailss.docids[i]).bind('click',{id:detailss.docids[i]},function(event){
                                                        var did=event.data.id;
                                                        makeInactiveDoctor(did);
                                                    });
                                                    $('#'+superadmin.viewdoctor.active+detailss.docids[i]).bind('click',{id:detailss.docids[i]},function(event){
                                                        var did=event.data.id;
                                                        makeActiveDoctor(did);
                                                    });
                                                }
                                            },300)
                                            break;
                            }
                    },
                    error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function(xhr, textStatus) {
                    }
            });      
        }
        function makeInactiveDoctor(did)
        {
         $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'makedocinact',
                            did         : did
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
                                            var detailss=$.parseJSON(data);
                                            alert("Doctor has been Successfully Inactive");
                                            listOfDoctors();
                                            break;
                            }
                    },
                    error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function(xhr, textStatus) {
                    }
            });   
        }
        function makeActiveDoctor(did)
        {
         $.ajax({
                    url: superadmin.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'makedocact',
                            did         : did
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
                                            var detailss=$.parseJSON(data);
                                            alert("Doctor has been Successfully Activated");
                                            listOfDoctors();
                                            break;
                            }
                    },
                    error: function() {
//						$(colls.outputDiv).html(INET_ERROR);
                    },
                    complete: function(xhr, textStatus) {
                    }
            });      
        }
    }

