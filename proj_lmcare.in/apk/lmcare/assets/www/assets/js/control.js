$(document).ready(function() { 
    if(localStorage.getItem("doctor")==null && localStorage.getItem("patient")==null && localStorage.getItem("pharmacy")==null &&  localStorage.getItem("diagnostics")==null && localStorage.getItem("superadmin")==null)
                        {
                            window.location.href='index.html';
                        }
    if(localStorage.getItem("doctor")=="doctor")
                        {                    
    $("#doctorinforeq").hide();
    $("#doctorinforesp").hide();
    $.ajax({
                
                url: AJAX,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'checkdoctorinfo',
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
                console.log(xhr.status);
		switch (data) {
		default:
                    var details=$.parseJSON(data);
                    if(details){
                    $("#doctorinforeq").show();
                }
                else
                {
                   $("#doctorinforesp").show(); 
                }
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
    doctor_information={
        doctorname          :  '#doctorname',
        doctornamemsg       :  '#doctornamemsg',
        doctorid            :  '#doctorid',
        doctoridmsg         :  '#doctoridmsg',
        clinicname          :  '#clinicname',
        clinicnamemsg       :  '#clinicnamemsg',
        doctor_next1        :  '#doctor_info_next1',
        doctoraddress       :  '#doctoraddress',
        doctoraddressmsg    : '#doctoraddressmsg',
        doctorcellnum       : '#doctorcellnum',
        doctorcellnummsg    : '#doctorcellnummsg',
        doctoremail         : '#doctoremail',
        doctoremailmsg      : '#doctoremailmsg',
        doctor_info_next2   : '#doctor_info_next2',
        form                : '#doctor_info_form',
        outputmsgdiv        : '#adddoctormsgdiv'
    }
    registration = {
       registrationmenu     : '#registrationmenuBut',  
      regpatientdetails     : '#regpatientdetails',
      regdiagnosticdetails  : '#regdiagnosticdetails',
      regpharmacydetails    : '#regpharmacydetails' ,
      usertypereg           :'#usertypereg',
      user_type_id          :'#user_type_id',
      form                  : '#patientregform'
    }
     patientregistration={
         user_type_id       :'#user_type_id',
         user_type_idmsg    : '#user_type_idmsg',
         patientname        : '#patientname',
         patientnamemsg     : '#patientnamemsg',
         patientphoto       : '#patientphoto',
         patientphotomsg    : '#patientphotomsg',
         patientregform     : '#patientregform',
         patientage         : '#patientage',
         patientagemsg      : '#patientagemsg',
         patientgender      : '#patientgender',
         patientgendermsg   : '#patientgendermsg',
         patientaddress     : '#patientaddress',
         patientaddressmsg  : '#patientaddress',
         patientcellnum     : '#patientcellnum',
         patientcellnummsg  : '#patientcellnummsg',
         patientemail       : '#patientemail',
         patientemailmsg    : '#patientemailmsg',
         patientgname       : '#patientgname',
         patientgnamemsg    : '#patientgnamemsg',
         patientgcellnum    : '#patientgcellnum',
         patientgcellnummsg : '#patientgcellnummsg',
         patientsubmitBut   :'#patientsubmitBut',
         patientmsgDiv      : '#patientmsgDiv',
         
        }
        pharmacyregistration=
        {
            ppname          : '#ppname',
            ppnamemsg       : '#ppnamemsg',
            pharmacyname    : '#pharmacyname',
            pharmacynamemsg : '#pharmacynamemsg',
            pharaddress     : '#pharaddress',
            pharaddressmsg  : '#pharaddressmsg',
            pphonenum       : '#pphonenum',
            pphonenummsg    : '#pphonenummsg',
            pharemail       : '#pharemail',
            pharemailmsg    : '#pharemailmsg',
         pharmacysubmitBut  : '#pharmacysubmitBut',
         pharmacymsgDiv     : '#pharmacymsgDiv'
        }
        diagnosticregistration=
        {
            dpname          : '#dpname',
            dpnamemsg       : '#dpnamemsg',
          diagnosticname    : '#diagnosticname',
          diagnosticnamemsg : '#diagnosticnamemsg',
            diagaddress     : '#diagaddress',
            diagaddressmsg  : '#diagaddressmsg',
            dphonenum       : '#dphonenum',
            dphonenummsg    : '#dphonenummsg',
            diagemail       : '#diagemail',
            diagemailmsg    : '#diagemailmsg',
        diagnosticsubmitBut : '#diagnosticsubmitBut',
        diagnosticmsgDiv    : '#diagnosticmsgDiv'
        }
      appointment={
      appointmentmenuBut    : '#appointmentmenuBut',
      appointconfig         : '#appointconfig',
      appointview           : '#appointview',
      appointconfigBut      : '#appointconfigBut',
      appointviewBut        : '#appointviewBut',
      appointedit           : '#appointedit',
      appointeditBut        : '#appointeditBut',
      plus                  : '#plus_slots_',
      eplus                 : 'eplus_slots_',
      minus                 : '#minus_slots_',
      eminus                : '#eminus_slots_',
      multiple_slots        : '#multiple_slots',
      emultiple_slots       : '#emultiple_slots', 
       num                  : -1,
       j                    :  0,
       enum                 : -1,
       ej                   :  0,
       alterappts           :'#alterappts',
       form                 :'div_multiple_slots',
       eform                :'ediv_multiple_slots',
       appointsubmitBut     : '#appointsubmitBut',
       eaddappointSubmit    : '#eaddappointSubmit',
       fromhour             : 'fromhour',
       fromminute           : 'fromminute',
       fromampm             : 'fromampm',
       tohour               : 'tohour',
       tominute             : 'tominute',
       toampm               : 'toampm',
       locationappoint      : 'locationappoint',
       frequencyappoint     : 'frequencyappoint',
        efromhour           : 'efromhour',
      efromminute           : 'efromminute',
      efromampm             : 'efromampm',
      etohour               : 'etohour',
      etominute             : 'etominute',
      etoampm               : 'etoampm',
      elocationappoint      : 'elocationappoint',
      efrequencyappoint     : 'efrequencyappoint',
       appointconfgmsg      : '#appointconfgmsg', 
       eappointconfgmsg     : '#eappointconfgmsg', 
       appointform          : '#appointform',
       appointbutton        : '#appointbutton',
       delete_app           : 'delete_app',
       edit_app             : 'edit_app',
       deleteOk_            : 'deleteOk_',
       edit_details         : 'edit_details_',
       row_id               : 'row_id',
       viewappointee        : 'viewappointee_',
       viewappointeedis     : 'viewappointeedis_',
      }
      sendpatienthistory = {
        sendpathistmenuBut  : '#sendpathistmenuBut',  
       displaysendpatienhis : '#displaysendpatienhis', 
       sendpatientid        : '#sendpatientid',
        sendpatientidmsg    : '#sendpatientidmsg',  
        sendpatientemail    : '#sendpatientemail',  
        sendpatientemailmsg : '#sendpatientemailmsg',  
       sendpatientSubmitBut : '#sendpatientSubmitBut',
       form                 : '#sendhistyform',
    sendpatientSubmitButmsg : '#sendpatientSubmitButmsg',  
      };
      editappointment={
        editfromhour        : 'editfromhour',
        editfromminute      : 'editfromminute',
        editfromampm        : 'editfromampm',
        edittohour          : 'edittohour',
        edittominute        : 'edittominute',
        edittoampm          : 'edittoampm',
        editlocationappoint : 'editlocationappoint',
      editfrequencyappoint  : 'editfrequencyappoint',
      editApptDetailsSubmit : 'editApptDetailsSubmit',
      editapptidd           : 'editapptidd',
       
      }
      dpatient={
   patientdetails           :'#patientdetails', 
   patient_list             : '#patient_list',
   patient_list_history     : '#patient_list_history', 
      }
      diagnostic={
    diagnosticdetails       : '#diagnosticdetails',
    diagnostic_list         : '#diagnostic_list',
    diagnosticsendmenuBut   : '#diagnosticsendmenuBut',
    listofdiagnosticmenuBut : '#listofdiagnosticmenuBut',
    configdiagnostic        : '#configdiagnostic',
    diadpatientdis          : '#diadpatientdis',
    diacenterlistdis        : '#diacenterlistdis',
    diagnosticcatedisplay   : '#diagnosticcatedisplay',
    diagnosticcatid         : 'diagnosticcatid',
    diagnosticsubtypedisplay : '#diagnosticsubtypedisplay',
    diagnosticSubmitBut      :'diagnosticSubmitBut',
    diagnosticpatientid      : 'diagnosticpatientid', 
    diagnosticpatientidmsg   : '#diagnosticpatientidmsg',
    diagnosticidd           : 'diagnosticidd',
    diagnosticiddmsg        : '#diagnosticiddmsg',
    patienttestdiag         : '#patienttestdiag',
    diagform                : '#diagform',
    diagnosticpatientsubmitmsg  : '#diagnosticpatientsubmitmsg',
      }
      pharmacy={
          pharmacydetails:'#pharmacydetails',
          pharmacy_list :'#pharmacy_list'
          
      }
      prescibtion={
          presform      : '#presform',
          prespatient   : '#prespatient',
       prespatientselect: '#prespatientselect',
       prespharselect   : '#prespharselect',
       prespatientmsg   : '#prespatientmsg',
       prespharmacy     : '#prespharmacy',
       prespharmacymsg  : '#prespharmacymsg',
       prestabletname   : '#prestabletname',
       plus             : '#plus_tablet_',
       minus            : '#minus_tablet_',
       multiple_tablet  : '#multiple_tablet',
       num              : -1,
       j                :  0,
       form             :'div_new',
       prestabletnamemsg: '#prestabletnamemsg',
       presfrequency    : '#presfrequency',
       presfrequencymsg : '#presfrequencymsg',
       presdosage       : '#presdosage',
       presdosagemsg    : '#presdosagemsg',
  prescribtionsubmitBut : '#prescribtionsubmitBut',
  prescribtionmsgdiv    : '#prescribtionmsgdiv',
  prescribtionmenudiv   : '#prescribtiondetails',
  pharmacyfulldetails   : '#pharmacyfulldetails',
  downloadpres          : '#downloadpres',
  downloadSubmitPres    : '#downloadSubmitPres',
      };
    patientassesment={
   patientassesmentmenuBut  : '#patientassesmentmenuBut',
   passesmentpatient        : '#passesmentpatient',
   passesmentpatientdel     : '#passesmentpatientdel',
   passesmentpatientdelmsg  : '#passesmentpatientdelmsg',
   patientprevioushistory   : '#patientprevioushistory',
   patienthistrydispl       : '#patienthistrydispl',
   patienthistrydisp        : '#patienthistrydisp',
   patientprevioushistorymsg: '#patientprevioushistorymsg',
   patientdiseases          : '#patientdiseases',
   patientdiseasesmsg       : '#patientdiseasesmsg',
   patienthabitdis          : '#patienthabitdis',
   patienthabit             : '#patienthabit',
   habbitsdelt              : '#habbitsdelt',
   passmentcount            : '#passmentcount',
   num                      : '#noofhaits',
   patienthabitdismsg       : '#patienthabitdismsg',
   patientpic               : '#patientpic',
   patientbloodgroupdis     : '#patientbloodgroupdis',
   patientbloodgroup        : '#patientbloodgroup',
   patientbloodgroupdismsg  : '#patientbloodgroupdismsg',
   patientcassesment        : '#patientcassesment',
   patientcassesmentmsg     : '#patientcassesmentmsg',
   patientcassesmentrem     : '#patientcassesmentrem',
   passesmentform           : '#passesmentform',
   patientcassesmentremmsg  : '#patientcassesmentrem',
   passesmentsubmitBut      : '#passesmentsubmitBut',
   passesmentmsgdiv         : '#passesmentmsgdiv'
    };    
      doctor={
   doctor_infor             : doctor_information,
   patientregistration      : patientregistration,
   pharmacyregistration     : pharmacyregistration,
   diagnosticregistration   : diagnosticregistration,
   appointment              : appointment,
   patient                  : dpatient,
   diagnostic               : diagnostic,
   pharmacy                 : pharmacy,
   prescibtion              : prescibtion,
   registration             : registration,
   patientassesment         : patientassesment, 
   editappointment          : editappointment,
   sendpatienthistory       :sendpatienthistory,
   url                      : AJAX   
      }
                obj=new doctorcontroller();
                obj.__construct(doctor);
            } 
      else if(localStorage.getItem("patient")=="patient")  
       {
           $(".sub_container").slideUp(1000);
            $("#prescription").slideDown(1500);
   patientappontment={
   patientappointment       : '#patientappointmentmenuBut',
   appointmendetails        : '#appointmendetails',
   bookapp                  : 'bookapp_',
   bookinghistory           : '#bookinghistory',
   bookappmenuBut           : '#bookappmenuBut',
   bookhistorymenuBut       : '#bookhistorymenuBut',
   bookinghistorydetails    : '#bookinghistorydetails',
   bookOk                   : 'bookOk_',
   };
   patientprescitionhistory ={
 patient_presciption_diplay : '#patient_presciption_diplay',
 patientpresciptionmenuBut  : '#patientpresciptionmenuBut',
 patienthistorydisplay      :'#patienthistorydisplay',
 patienthistorymenuBut      : '#patienthistorymenuBut',
   }
   
   
   patient={
       pappointment         : patientappontment,
    patientpresciption      : patientprescitionhistory,   
       url                  : AJAX
   }
   obj=new patientcontroller();
   obj.__construct(patient); 
       }
       else if(localStorage.getItem("pharmacy")=="pharmacy")
       {
           $(".sub_container").slideUp(1000);
            $("#pharmacy").slideDown(1500);
         var pharmacy={
           pharmcypatientmenuBut : '#pharmcypatientmenuBut',
           pharmcypatientDisplay : '#pharmcypatientDisplay',
            url                  : AJAX
         } 
         obj=new pharmacycontroller();
         obj.__construct(pharmacy); 
       }
       else if(localStorage.getItem("superadmin")=="superadmin")
       {
        var createdoctor={
            menuBut             : '#createdoctormenuBut',
            form                : '#doctorreggform',
            docotoremailidmsg   : '#docotoremailidmsg',
            docotoremailid      : '#docotoremailid',
            doctorusername      : '#doctorusername',
            doctorusernamemsg   : '#doctorusernamemsg',
            doctorpassword      : '#doctorpassword',
            doctorpasswordmsg   : '#doctorpasswordmsg',
            hiddocotoremailid   : '#hiddocotoremailid',
            hiddoctorusername   : '#hiddoctorusername',
            But                 : '#createdoctorBut',
            createdoctorMsgDiv  : '#createdoctorMsgDiv',
            display             : false,
        };   
        var viewdoctors={
            viewdoctorsmenuBut  : '#viewdoctorsmenuBut',
            listofdocotrs       : '#listofdocotrs',
            inactive            : 'inactive_',
            active              : 'active_',
            display             : false,
        };
        var doctorrequest={
            docotorreqmenuBut   : '#docotorreqmenuBut',
            doctorrequests      : '#doctorrequests',
            requsername         : 'requsername',
            reqpassword         : 'reqpassword',
            sendreqemail        : 'sendreqemail',
            requsernamemsg      : 'requsernamemsg',
            reqpasswordmsg      : 'reqpasswordmsg',
            requseremail        : 'requseremail',
            requseremailmsg     : 'requseremailmsg',
            hidrequseremail     : 'hidrequseremail',
            hidrequsername      : 'hidrequsername',
            rowid               : 'actrowid_',
            display             : false,
        };
        var testupdates={
           testupdatesMenuBut   : '#testupdatesMenuBut',
           createtests          : '#createtests',
           viewtests            : '#viewtests',
           form                 : '#testsregform',
           testcate             : '#testcate',
           testcatemsg          : '#testcatemsg',
           testname             : '#testname',
           testnamemsg          : '#testnamemsg',
           addtestBut           : '#addtestBut',
           addtestButmsg        : '#addtestButmsg',
           diplaytests          : '#diplaytests',
           viewtestrow          : 'viewtests_',   
           deleteOk             : 'deletetest_',
           display              : false,
        }
         var superadmin={
           createdoctor          : createdoctor, 
           viewdoctor            : viewdoctors,
           doctorrequest         : doctorrequest,
           testupdates           : testupdates,
            url                  : AJAX
         } 
         obj=new superAdminController();
         obj.__construct(superadmin); 
       }
       else if(localStorage.getItem("diagnostics")=="diagnostics")
       {
           $(".sub_container").slideUp(1000);
            $("#diagnostics").slideDown(1500);
         var diagnostic ={
           listofdiagnpatient             : '#listofdiagnpatient',
           listofdiagnosticpatientmenuBut : '#listofdiagnosticpatientmenuBut',  
           url                            : AJAX
         };
         obj=new diagnosticController();
         obj.__construct(diagnostic);
       }
       else
       {
           
       }
})


