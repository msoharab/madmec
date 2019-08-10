function controller()
{
    var ctrl = {};
	this.__construct = function(ctrll) {
           ctrl=ctrll ;
           $(ctrl.news.newsmenubut).on('click',function (){
               fetchNEWS();
           });
           $(ctrl.business.newsmenubut).on('click',function (){
               fetchNEWS();
           });
           $(ctrl.news.viewnews).on('click',function (){
               fetchNEWS();
           });
           $(ctrl.news.addnewsbut).click(function (){
               addnews();
           });
           $(ctrl.business.addbusinessbut).on('click',function (){
               addBusiness();
           });
           $(ctrl.business.viewbuzz).click(function (){
               fetchBusiness();
           })
           /*on chnage to automatically upload images once selected */
           $(ctrl.news.newspic).change(function (){
                        var count = 0;
                        var img='';
                        var val = $.trim( $((ctrl.news.newspic)).val() );
                                if( val == '' ){
                                    count= 1;
                                }
                        if(count == 0){
                                for (var i = 0; i < $(ctrl.news.newspic).get(0).files.length; ++i) {
                                img = $(ctrl.news.newspic).get(0).files[i].name;
                                var extension = img.split('.').pop().toUpperCase();
                                if(extension!="PNG" && extension!="JPG" && extension!="GIF" && extension!="JPEG"){
                                        count= count+ 1
                                }
                            }

                        }
                        if(count == 0) {   
                            $(ctrl.news.form).ajaxForm(
                        {
                        }).submit();
                        }
                    })
           $(ctrl.business.bussinessimg).change(function (){
                        var count = 0;
                        var img='';
                        var val = $.trim( $((ctrl.business.bussinessimg)).val() );
                                if( val == '' ){
                                    count= 1;
                                }
                        if(count == 0){
                                for (var i = 0; i < $(ctrl.business.bussinessimg).get(0).files.length; ++i) {
                                img = $(ctrl.business.bussinessimg).get(0).files[i].name;
                                var extension = img.split('.').pop().toUpperCase();
                                if(extension!="PNG" && extension!="JPG" && extension!="GIF" && extension!="JPEG"){
                                        count= count+ 1
                                }
                            }

                        }
                        if(count == 0) {   
                            $(ctrl.business.form).ajaxForm(
                        {
                        }).submit();
                        }
                    })         
           fetchNEWS();
        };
        this.fetnews = function(){
            fetchNEWS();
        };
        this.fetbusiness = function(){
            fetchBusiness();
        };
    function fetchNEWS(){
       $.ajax({
                url: ctrl.url,
                type: 'POST',
		data: {
		action      : 'fetchnews'
		},
		success: function(data, textStatus, xhr) {
                console.log(data);   
                data = $.trim(data);
                var det=$.parseJSON(data);
                if(det.status=="success")
                {
                  $(ctrl.news.disnews).html(det.data);
                }
                else
                {
                 $(ctrl.news.disnews).html('<span class="text-danger"><strong>no records</strong></span>');   
                }
                
                },
                error: function() {
                    alert("hello")
			},
		complete: function(xhr, textStatus) {
			}
		});   
    };
   
    function addnews()
    {
        var flag=false;
        if($(ctrl.news.newsheading).val()=="")
        {
            $(ctrl.news.newsheading).focus();
            flag=false;
            return
        }
        else
        {
           flag=true; 
        }
         if($(ctrl.news.newsdescb).val()=="")
        {
            $(ctrl.news.newsdescb).focus();
            flag=false;
            return
        }
        else
        {
           flag=true; 
        }
        if(flag)
        {
            var attr={
                heading :  $(ctrl.news.newsheading).val(),
                descb   : $(ctrl.news.newsdescb).val()
            }
            $.ajax({
                url: ctrl.url,
                type: 'POST',
		data: {
		action      : 'addnews',
                details      : attr,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);   
                console.log(textStatus); 
                data = $.trim(data);
                var det=$.parseJSON(data);
                if(det)
                {
                    alert("NEWS has been Successfully Added");
                    $(ctrl.news.form).get(0).reset();
                }
                
                },
                error: function() {
                    alert("hello")
			},
		complete: function(xhr, textStatus) {
			}
		});   
        }
    }
    
    var business={
      businessmenubut   : '#businessmenubut',
      bussinessname     : '#bussinessname',
      busdescripttion   : '#busdescripttion',
      bussinessphone    : '#bussinessphone',
      bussinessemail    : '#bussinessemail',
      bussinessdesc     : '#bussinessdesc',
      addbusinessbut    : '#addbusinessbut',
      
   };
    function addBusiness()
    {
        var flag=false;
        if($(ctrl.business.bussinessname).val()=="")
        {
           $(ctrl.business.bussinessname).focus();
           flag=false;
           return;
        }
        else
        {
            flag=true;
        }
         if($(ctrl.business.busdescripttion).val()=="")
        {
           $(ctrl.business.busdescripttion).focus();
           flag=false;
           return;
        }
        else
        {
            flag=true;
        }
        if($(ctrl.business.bussinessphone).val()=="" || !$(ctrl.business.bussinessphone).val().match(numbs))
        {
           $(ctrl.business.bussinessphone).focus();
           flag=false;
           return;
        }
        else
        {
            flag=true;
        }
        if($(ctrl.business.bussinessemail).val()=="" || !$(ctrl.business.bussinessemail).val().match(email_reg))
        {
           $(ctrl.business.bussinessemail).focus();
           flag=false;
           return;
        }
        else
        {
            flag=true;
        }
        if($(ctrl.business.bussinessdesc).val()=="")
        {
           $(ctrl.business.bussinessdesc).focus();
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
                businame :  $(ctrl.business.bussinessname).val(),
                addr :  $(ctrl.business.busdescripttion).val(),
                mobile :  $(ctrl.business.bussinessphone).val(),
                email :  $(ctrl.business.bussinessemail).val(),
                descb :  $(ctrl.business.bussinessdesc).val()
            }
            $.ajax({
                url: ctrl.url,
                type: 'POST',
		data: {
		action      : 'addbusiness',
                details      : attr,
		},
		success: function(data, textStatus, xhr) {
                console.log(data);   
                console.log(textStatus); 
                data = $.trim(data);
                var det=$.parseJSON(data);
                if(det)
                {
                    alert("Business has been Successfully Added");
                    $(ctrl.business.form).get(0).reset();
                }
                
                },
                error: function() {
                    alert("hello")
			},
		complete: function(xhr, textStatus) {
			}
		});  
        }
    };
    
    function fetchBusiness()
    {
       $.ajax({
                url: ctrl.url,
                type: 'POST',
		data: {
		action      : 'fetchbusiness'
		},
		success: function(data, textStatus, xhr) {
                data = $.trim(data);
                var det=$.parseJSON(data);
                if(det.status=="success")
                {
                  $(ctrl.business.displaybusiness).html(det.data);
                }
                else
                {
                 $(ctrl.business.displaybusiness).html('<span class="text-danger"><strong>no records</strong></span>');   
                }
                
                },
                error: function() {
                
			},
		complete: function(xhr, textStatus) {
			}
		});   
    };
};

