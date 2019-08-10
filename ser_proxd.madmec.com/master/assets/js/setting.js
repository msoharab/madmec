function Setting(){
		var stng = {};
		this.__construct = function(stngctrl) {
		stng = stngctrl;
//                $(stng.adddetails.savesettingbut).click(function (){
//                  addDetails();  
//                });   
                fetchBillingDetails();  
	$(function() {
		$(stng.adddetails.photo).picEdit({
                    imageUpdated: function(img){
//                        console.log(img);
                    },
                    formSubmitted: function(data){
                        console.log(data.response);
                    },
                    redirectUrl: false,
                    defaultImage: false
		});
	});
    };
            function addDetails()
            {
                var flag=false;
                if($(stng.adddetails.companyname).val()==""  || $(stng.adddetails.companyname).val().length<5)
                {
                   flag=false;
                   $(stng.adddetails.companyname).focus();
                   return;
                }
                else
                {
                    flag=true;
                }
                if($(stng.adddetails.companyaddress).val()==""  || $(stng.adddetails.companyaddress).val().length<5)
                {
                   flag=false;
                   $(stng.adddetails.companyaddress).focus();
                   return;
                }
                else
                {
                    flag=true;
                }
                if($(stng.adddetails.companyemail).val()==""  || (! $(stng.adddetails.companyemail).val().match(email_reg)))
                {
                   flag=false;
                   $(stng.adddetails.companyemail).focus();
                   return;
                }
                else
                {
                    flag=true;
                }
                if($(stng.adddetails.companymobile).val()==""  || (! $(stng.adddetails.companymobile).val().match(cell_reg)))
                {
                   flag=false;
                   $(stng.adddetails.companymobile).focus();
                   return;
                }
                else
                {
                    flag=true;
                }
                if($(stng.adddetails.termsncondition).val()==""  || ($(stng.adddetails.termsncondition).val().length<5))
                {
                   flag=false;
                   $(stng.adddetails.termsncondition).focus();
                   return;
                }
                else
                {
                    flag=true;
                }
                if($(stng.adddetails.footermsg).val()==""  || ($(stng.adddetails.footermsg).val().length<5))
                {
                   flag=false;
                   $(stng.adddetails.footermsg).focus();
                   return;
                }
                else
                {
                    flag=true;
                }
                if(flag)
                {
                    var attr={
                        companyname : $(stng.adddetails.companyname).val(), 
                        companyaddress : $(stng.adddetails.companyaddress).val(),
                        companyemail : $(stng.adddetails.companyemail).val(), 
                        companymobile : $(stng.adddetails.companymobile).val(),
                        termsncondition : $(stng.adddetails.termsncondition).val(), 
                        footermsg : $(stng.adddetails.footermsg).val(),
                        companylandline : $(stng.adddetails.companylandline).val(), 
                        check : Number(stng.adddetails.check),
                    }
                    $.ajax({
			type: 'POST',
			url: stng.url,
			data:{
                            autoloader: true,
			    action: 'addbillingdetails',
                            details : attr,
                        },
			success:function(data){
//                               console.log(data);
                               data=$.trim(data)
                               details=$.parseJSON
                               if(details)
                               {
                                  alert("Details are Updated Successfully") ;
                                  fetchBillingDetails();
                               }
			}
		});
                    
                }
            }
            function fetchBillingDetails()
            {
                $.ajax({
			type: 'POST',
			url: stng.url,
			data:{
                            autoloader: true,
			    action: 'fetchbillingdetails'
                        },
			success:function(data){
                               console.log(data);
                               data=$.trim(data)
                               var details=$.parseJSON(data);
                               if(details.noofrecords)
                               {
                                   if(details.billlogo == null || details.billlogo == "")
                                   {
                                   $(".picedit_canvas_box").css({"width": "100%","height": "100%","display": "block","text-align": "center", "position": "relative"});
                                   setTimeout($(".picedit_canvas_box").css('background-image', 'url('+Bill_Logo+')'),500);
                                    }
                                   else
                                   {
//                                   $(stng.adddetails.displaybilllogo).html('<img src="'+details.billlogo+'" width="200px" height="150px"></img>');
                                    $(".picedit_canvas_box").css({"width": "100%","height": "100%","display": "block","text-align": "center", "position": "relative"});
                                        setTimeout(function(){
                                            $(".picedit_canvas_box").css('background-image', 'url(../'+details.billlogo+')')
                                        },500);
                                    }
                                   $(stng.adddetails.companyname).val(details.companyname);
                                   $(stng.adddetails.companyaddress).val(details.address);
                                   $(stng.adddetails.companylandline).val(details.landline);
                                   $(stng.adddetails.companyemail).val(details.email);
                                   $(stng.adddetails.companymobile).val(details.mobile);
                                   $(stng.adddetails.termsncondition).val(details.termsncondition);
                                   $(stng.adddetails.footermsg).val(details.footermessage); 
                                   $('#check').val('1')
                                   stng.adddetails.check = 1;
                               }
                               else
                               {
                                $(stng.adddetails.displaybilllogo).html('<img src="'+Bill_Logo+'" width="400px" height="150px"></img>')
                               }
				
			}
		});
            }
    }

