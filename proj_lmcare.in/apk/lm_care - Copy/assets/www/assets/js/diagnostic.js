function diagnosticController()
 {
    var diagnostic = {};
	this.__construct = function(ctrl) {
            diagnostic=ctrl;
             fetchPatientDiagnosticTests();
            $(diagnostic.listofdiagnosticpatientmenuBut).click(function (){
                fetchPatientDiagnosticTests();
            });
        }
        function fetchPatientDiagnosticTests()
        {
              $.ajax({
                    url: diagnostic.url,
                    type: 'POST',
                    data: {
                            autoloader  : true,
                            action      : 'fetchpatienttestss',
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
                                            $(diagnostic.listofdiagnpatient).html(detailss.pdata);
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

