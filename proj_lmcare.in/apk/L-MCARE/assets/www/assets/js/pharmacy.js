function pharmacycontroller()
{
    var pharmacy = {};
	this.__construct = function(ctrl) {
            pharmacy=ctrl;
            fetchPharmacyPatientList();
            $(pharmacy.pharmcypatientmenuBut).click(function (){
                fetchPharmacyPatientList();
            });
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

