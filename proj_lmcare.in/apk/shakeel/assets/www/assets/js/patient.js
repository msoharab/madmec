function patientcontroller()
{
    var patient = {};
	this.__construct = function(ctrl) {
            patient=ctrl;
            displayCurrentPrescription();
            $(patient.pappointment.patientappointment).click(function (){
               fetchDoctorAppointments();
               $(patient.pappointment.appointmendetails).show();
               $(patient.pappointment.bookinghistory).hide();
            })
            $(patient.pappointment.bookhistorymenuBut).click(function (){
               fetchAppointmentsBookingHistory();
               $(patient.pappointment.appointmendetails).hide();
               $(patient.pappointment.bookinghistory).show();
            })
            $(patient.pappointment.bookappmenuBut).click(function (){
               $(patient.pappointment.appointmendetails).show();
               $(patient.pappointment.bookinghistory).hide();
            })
           
            $(patient.patientpresciption.patientpresciptionmenuBut).click(function() {
                displayCurrentPrescription();
            });
            $(patient.patientpresciption.patienthistorymenuBut).click(function() {
                displayPatientHistory();
            });
        }
        function fetchAppointmentsBookingHistory()
        {
          $(patient.pappointment.bookinghistorydetails).html(LOADER);
            var htm='';
          $.ajax({
                url: patient.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchappointbookinghis',
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(patient.pappointment.bookinghistorydetails).html(ppdetails);
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});  
        }
        function displayPatientHistory()
        {
            $(patient.patientpresciption.patienthistorydisplay).html(LOADER);
            var htm='';
          $.ajax({
                url: patient.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpatienthistorydes',
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    for(i=0;i<ppdetails.pdata.length;i++)
                    {
                        htm +=ppdetails.pdata[i];
                    }
                    $(patient.patientpresciption.patienthistorydisplay).html(ppdetails.divheader+htm+ppdetails.divfooter);
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});  
        }
        function displayCurrentPrescription()
        {
            $(patient.patientpresciption.patient_presciption_diplay).html(LOADER);
            $.ajax({
                url: patient.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchpatientcurrentpres',
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var ppdetails=$.parseJSON(data);
                    $(patient.patientpresciption.patient_presciption_diplay).html(ppdetails);
                        break;
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});
        }
        function fetchDoctorAppointments()
        {
         $(patient.pappointment.appointmendetails).html(LOADER);
            var htm='';
         $.ajax({
                url: patient.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'fetchdocappointmentdetails',
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
                    $(patient.pappointment.appointmendetails).html(ppdetails.divheader1+htm+ppdetails.divfooter);
                        break;
			}
                    window.setTimeout(function (){    
                    for(i=0;i<ppdetails.appids.length;i++)
                     {
                        $('#'+patient.pappointment.bookOk+ppdetails.appids[i]).bind('click',{id:ppdetails.appids[i],date:ppdetails.dates[i]},function(event){
                        var apptid = event.data.id;
                        var dates=event.data.date;
                        bookAppointment(apptid,dates);
                       });
                     }
                    },300);   
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				});  
        }
        function bookAppointment(apptid,date)
        {
            var attr={
                apptid : apptid,
                date   : date,
            }
            $.ajax({
                url: patient.url,
                type: 'POST',
		data: {
		autoloader  : true,
		action      : 'bookappointment',
                inputdetl   : attr
		},
		success: function(data, textStatus, xhr) {
                console.log(data);    
                data = $.trim(data);
		switch (data) {
		default:
                    var details=$.parseJSON(data);
                    if(details)
                    alert("Sorry, You have Already Booked this Appointment");
                    else
                    alert("You have Successfully Booked the Appointment");
                    fetchDoctorAppointments();
			}
                    },
                error: function() {
			},
		complete: function(xhr, textStatus) {
			}
				}); 
        }
    }


