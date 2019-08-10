function orderController(){
	var ord={};
	this.__construct = function(order_BasicInfo){
		 ord = order_BasicInfo;
		 $(ord.listclient).click(function(){
			
			 DisplayclientList();
		});	
		$(ord.but).click(function(){
			clientAdd();
		});
            }
                function clientAdd(){
                var attr = validateClientFields();
                var abc ={
                        name : $(ord.name).val(),
                        email : $(ord.email).val(),
                        cellnumber : $(ord.num).val(),
                        handledby : $(ord.handledby).val(),
                        refby :$(ord.refby).val(),
                        ord_prb : $(ord.ord_prb).val(),
                        cdate : $(ord.cdate).val(),
                        comment: $(ord.comment).val()
                        };
                console.log(abc);
                if(attr){
                $(ord.but).prop('disabled','disabled');
                                                $(ord.butmsg).html('');
                                                $.ajax({
                                                        url:ord.url,
                                                        type:'POST',
                                                        data:{autoloader: true,action: 'orderfollowupsAdd',type:'master',clientadd:abc},
                                                        success:function(data, textStatus, xhr){
                                                                console.log(data);
                                                                data = $.trim(data);
                                                                console.log(xhr.status);
                                                                switch(data){
                                                                        case 'logout':
                                                                                logoutAdmin({});
                                                                        break;
                                                                        case 'login':
                                                                                loginAdmin({});
                                                                        break;
                                                                        default:
                                                                                $(ord.butmsg).html('<h2>User added to database</h2>');
                                                                                $('html, body').animate({scrollTop: Number($(ord.butmsg).offset().top)-95}, "slow");
                                                                                $(ord.form).get(0).reset();
                                                                                // em.num = cn.num = ac.num = pd.num = -1;
                                                                        break;
                                                                }
                                                        },
                                                        error:function(){
                                                                $(ord.outputDiv).html(INET_ERROR);
                                                        },
                                                        complete: function(xhr, textStatus) {
                                                                console.log(xhr.status);
                                                                $(ord.but).removeAttr('disabled');
                                                        }
                                                });
                                                        }
                                        else{

                                                $(ord.but).removeAttr('disabled');
                                        }


                        }
                function validateClientFields(){
                var flag = false;
                /* client name */
                if($(ord.name).val().match(name_reg)){
                        flag = true;
                        $(ord.nmsg).html(VALIDNOT);
                }
                else{
                        flag = false;
                        $(ord.nmsg).html(INVALIDNOT);
                        $('html, body').animate({scrollTop: Number($(ord.nmsg).offset().top)-95}, "slow");
                        $(ord.name).focus();
                        return;
                }
                /* Cell numbers */
                                if($(ord.num).val().match(cell_reg)){
                                        flag = true;
                                        $(ord.nummsg).html(VALIDNOT);
                                }
                                else{
                                        flag = false;
                                        $(ord.nummsg).html('<strong class="text-danger">Not Valid Cell prefiex</strong>');
                                        $('html, body').animate({scrollTop: Number($(ord.nummsg).offset().top)-95}, "slow");
                                        $(ord.num).focus();
                                        return;
                                }
                 /* Email ids */

                                if($(ord.email).val().match(email_reg)){
                                    $(ord.emailmsg).html(VALIDNOT);
                                        flag = true;
                                }
                                else{
                                        flag = false;
                                        $(ord.emailmsg).html(INVALIDNOT);
                                        $('html, body').animate({scrollTop: Number($(ord.emailmsg).offset().top)-95}, "slow");
                                        $(ord.email).focus();
                                        return;
                                }                
                                        /* Refered BY */
                if($(ord.refby).val().match(name_reg)){
                        flag = true;
                        $(ord.refbymsg).html(VALIDNOT);
                }
                else{
                        flag = false;
                        $(ord.refbymsg).html(INVALIDNOT);
                        $('html, body').animate({scrollTop: Number($(ord.refbymsg).offset().top)-95}, "slow");
                        $(ord.refby).focus();
                        return;
                }
                                                /* comments */
                if($(ord.comment).val().match(name_reg)){
                        flag = true;
                        $(ord.commentmsg).html(VALIDNOT)
                }
                else{
                        flag = false;
                        $(ord.commentmsg).html(INVALIDNOT);
                        $('html, body').animate({scrollTop: Number($(ord.commentmsg).offset().top)-95}, "slow");
                        $(ord.comment).focus();
                        return;
                }
                                                /* order probabilities */

                if($(ord.ord_prb).val().match(numbs)){
                        flag = true;
                        $(ord.ord_prbmsg).html(VALIDNOT);
                }
                else{
                        flag = false;
                        $(ord.ord_prbmsg).html(INVALIDNOT);
                        $('html, body').animate({scrollTop: Number($(ord.ord_prbmsg).offset().top)-95}, "slow");
                        $(ord.ord_prb).focus();
                        return;
                }
                                                /* Handeled by */
                if($(ord.handledby).val().match(name_reg)){
                        flag = true;
                        $(ord.handlebymsg).html(VALIDNOT);
                }
                else{
                        flag = false;
                        $(ord.handlebymsg).html(INVALIDNOT);
                        $('html, body').animate({scrollTop: Number($(ord.handlebymsg).offset().top)-95}, "slow");
                        $(ord.handledby).focus();
                        return;
                }
                        var attr = {
                        name : $(ord.name).val(),
                        email : $(ord.email).val(),
                        cellnumber : $(ord.num).val(),
                        handledby : $(ord.handledby).val(),
                        refby :$(ord.refby).val(),
                        ord_prb : $(ord.ord_prb).val(),
                        cdate : $(ord.cdate).val(),
                        comment: $(ord.comment).val()
                        };
                                        console.log(attr);
                                        if(flag){
                                                return attr;
                                        }
                                        else
                                                return false;
                                };
                function DisplayclientList(){
                    var header='<table class="table table-striped table-bordered table-hover" id="clients_table"><thead><tr><th colspan="7">Client Details</th></tr><tr><th>#</th><th>name</th><th>Cell_number</th><th class="text-right">Email-id</th><th>Refered By</th><th>HandeledBy</th><th>Order of probability</th><th>Date</th><th>comments</th><th>Delete</th></tr></thead>';
                    var footer='</table>';
                    $(ord.listLoad).html(LOADER_ONE);
                    $.ajax({
                            url:ord.url,
                            type:'post',
                            data:{autoloader:true,action:'DisplayorderClientList',type:'master'},
                            success:function(data, textStatus, xhr){
                                    data = $.trim(data);
                                    console.log(xhr.status);
                                    switch(data){
                                            case 'logout':
                                                    logoutAdmin({});
                                            break;
                                            case 'login':
                                                    loginAdmin({});
                                            break;
                                            default:
                                                    var details=$.parseJSON(data);
                                                    if(details.status=="success")
                                                    {
                                                    $(ord.listDiv).html(header+details.data+footer);
                                                    window.setTimeout(function(){
                                                            $('#clients_table').dataTable();
                                                            for(j=0;j<details.ids.length;j++)
                                                            {
                                                                $('#delorderfoll'+details.ids[j]).bind('click',{tid:details.ids[j]},function(event){
                                                                        var ofid=event.data.tid;
                                                                        
                                                                });
                                                                 $('#deleteOk_'+details.ids[j]).bind('click',{tid:details.ids[j]},function(event){
                                                                        var ofid=event.data.tid;
                                                                        deleteOrderFollow(ofid);
                                                                        
                                                                });
                                                            }
                                                    },600)
                                                    }
                                                    else
                                                    {
                                                    $(ord.listDiv).html('<span class="text-danger"><strong>no Order Follow Ups  ||||</strong></span>');
                                                    }
                                            break;
                                    }
                            },
                            error:function(){
                                    $(ord.outputDiv).html(INET_ERROR);
                            },
                            complete: function(xhr, textStatus) {
                                    console.log(xhr.status);
                            }
                    });
            }
            function deleteOrderFollow(ofid)
            {
                $.ajax({
                type:'POST',
                url:ord.url,
                data:{autoloader:true,action:'deleteordfoll',ofid:ofid,type:'master'},
                success:function(data, textStatus, xhr){
//                        console.log(data);
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
                                        if(res)
                                        {
                                          alert("Order Has been Successfully Deleted") ;
                                          DisplayclientList();
                                        }
                                        else
                                        {
                                            alert("Error, Please try after sometime")
                                        }
                                break;
                        }
                },
                error:function(){
                        $(ord.outputDiv).html(INET_ERROR);
                },
                complete: function(xhr, textStatus) {
                        console.log(xhr.status);
                }
        }); 
            }
                
    };
