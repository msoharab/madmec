
function dis_receipts(val){
	$('#load_box').removeClass("load_box");	
	$('#rec_screen_app').remove();
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'dis_receipts','val':val},
		success:function(data){
			//alert(data);
			$('#rec_screen').html(data);
			$('#load_box').hide();
			$('#rec_screen_app').hide();
		}
		
	});
	
}

function dis_receipts_scroll(val){
	$('#load_box').addClass("load_box");
	$('.load_box').show();
	$('<div />', {id: 'rec_screen_app',}).appendTo('#page-inner');
 
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'dis_receipts_scroll'},
		success:function(data){
			//console.log(data);
			$('#rec_screen').html(data);
			$('.load_box').hide();						
		}
	});
	var flag = true;
	$(window).scroll(function(event){
		if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10){
			if(flag){	
				flag = false;				
				dis_receipts_scroll_append();
				flag=true;
			}
		}
		else 
				$('#load_box').hide();
	
		});
}
function dis_receipts_scroll_append(val){
	$('.load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		async:false,
		data:{action:'dis_receipts_scroll_append','val':'append'},
		success:function(data){
			
			$('#rec_screen_app').append(data);
			$('.load_box').hide();
		}
	});
	
}


function show_pre_div(elem){
	if(elem.value == 'The'){
		$("#hq_at").show();
		$("#res_at").hide();
	}
	else{
		$("#hq_at").hide();
		$("#res_at").show();
	}
	
}
function make_receipt(){
	$("#make_receipt_btn").hide();
	var flag = true;
	var date = $('#date').val();
	var from = $('#from').val();
	var pre_name = $('#pre_name').val();
	var name = $('#name').val();
	var user_type = $('#user_type').val();
	var towards = $("#for").val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	
	var isamount  = /^\d+(?:\.\d{0,2})$/;
	//Display the email id validation
	 var emailreg= /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(email.length > 0)
            if(emailreg.test(email))
            {  //allow_email()
                    $('#err_email').hide();
            }else {
                    //allow_email()
                    $('#err_email').show();
                    flag=false;
            }
	var num  = /^\d+$/;
	if(name.length > 0){
		$('#err_name').hide();
	}else{
		$('#err_name').show();
		flag = false;
	}
	
	if(flag){
		var flag2 = check_name_exist(name);
		if( flag2 > 0 ){
			var data = {
				action:'make_receipt',
				'target_id' : flag2,
				'date':date,
				'pre_name':pre_name,
				'name':name,
				'from':from,
				'user_type':user_type,
				'mobile':mobile,
				'email':email,
				'towards':towards
				};
		}
		else{
			var data = {
				action:'make_receipt',
				'date':date,
				'pre_name':pre_name,
				'name':name,
				'from':from,
				'user_type':user_type,
				'mobile':mobile,
				'email':email,
				'towards':towards
				};
		}
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:data,
			success:function(data){
				//alert(data);
				if(data == 0)
					$('#rec_screen').html("Error!!!");
				else
					$('#rec_screen').html(data);
				$('#load_box').hide();
				load_tar_session();
				load_all_receipts();
			}
		});
	}
	else{
		alert("Please fill the mandatory fields");
		$("#make_receipt_btn").show();
	}
}

function check_name_exist(name){
	var id = 0;
	$.ajax({
		async: false,	
		url:window.location.href,
		type:'POST',
		data:{action:'check_name_exist','name':name},
		success:function(data){
			id = data;
		}
	});
	return id;
}
function auto_fill(name){
	$('#load_box').show();
	$.ajax({
            url:window.location.href,
            type:'POST',
            dataType: 'json',
            data:{action:'auto_fill','name':name},
            success:function(data){
                $('#load_box').hide();
                $('#user_details').show();
                $("#email").val(data["email"]);
                $("#mobile").val(data["phone"]);
                $("#loc").val(data["address"]);
               // $("#err_name").html('ERROR!! User Name alreay exist try again with different name.');
                $("#err_name").show();
                setTimeout($("#name").val(data["tar_name"]),500);
                
            },
            error:function(data){
                $('#load_box').hide();
                $('#user_details').show();
            }
	});
}
function load_tar_session(){
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_tar_session'},
		success:function(data){
			//alert(data);
			//alert(data);
		}
	});
}

function load_all_receipts(){
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts'},
		success:function(data){
			//alert(data);
		}
	});
}
function caltime(){
	var hh = $("#hh").val();
	var mm = $("#mm").val();
	var meridiem = $("#meridiem").val();
	from = (meridiem == 'PM') ? parseInt(hh)+12 : hh;
	$("#from").val(from+':'+mm+':00');
}
function critical_action(id,val,dt = false){
	$('#load_box').removeClass("load_box");	
	$('#rec_screen_app').remove();
	console.log(val);
	if(val == 'edit'){
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'critical_action','val':val,'id':id},
			success:function(data){
				//alert(data);
				$('#load_box').hide();
				$('#rec_screen').html(data);
				$('#rec_screen_app').hide();
			}
		});
	}
	else if(val == 'delete'){
		var flag = confirm("Are you sure you want to delete this appointment");
		if(flag){
			$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'critical_action','val':val,'id':id},
			success:function(data){
				view_all_receipts();
					//dis_receipts_scroll();
					//dis_receipts('view');
			}
		});
		}
		
	}
	if(val == 'history'){
		console.log(dt);
		//console.log(dt.toUTCString());
		$("#rec_screen_app").remove('#page-inner');
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'critical_action','val':val,'id':id,'dt':dt},
			success:function(data){
				$('#load_box').hide();
				$('#rec_screen').html(data);
			}
		});
	}
	
}
function update_appiontment(){
	$("#make_receipt_btn").hide();
	var flag = true;
	var id = $('#id').val();
	var tar_id = $('#tar_id').val();
	var date = $('#date').val();
	var from = $('#from').val();
	var towards = $("#for").val();
	var mobile = $("#mobile").val();
	if(flag){
		var data = {
			action:'update_appointment',
			'appointment_id' : id,
			'tar_id' : tar_id,
			'date':date,
			'from':from,
                        'mobile':mobile,
			'towards':towards
                };
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:data,
			success:function(data){
				//alert(data);
				if(data == 0)
					$('#rec_screen').html("Error!!!");
				else
					$('#rec_screen').html(data);
				$('#load_box').hide();
				load_tar_session();
				load_all_receipts();
			}
		});
	}
	else{
		alert("Please fill the mandatory fields");
		$("#make_receipt_btn").show();
	}
}
$( document ).ready(function() {
	load_tar_session();
	dis_receipts('create');
	load_all_receipts();
});
//Dispaly the search Appointment 
function search_receipt_name(sname){
	if (sname.length >= 2) {
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts','name':sname},
		success:function(data){
			dis_receipts_scroll(sname);
			  dis_receipts_scroll_append();
			$('#target_screen').html(data);
			$('#load_box').hide();
			$('#rec_screen_app').show();
		}
	});
	}
}

function  date_rec(sdate) {
	
	var appdate	=	$('#date').val();
		$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts','date_app':appdate},
		success:function(data){
			dis_receipts_scroll(appdate);
			$('#target_screen').html(data);
			$('#load_box').hide();
			$('#rec_screen_app').hide();
		}
	});
}



function search_receipt_mobile(smobile){
	if (smobile.length >= 2) {
	$.ajax({
			url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts','mobile':smobile},
		success:function(data){
			dis_receipts_scroll();
			$('#target_screen').html(data);
			$('#load_box').hide();
			$('#rec_screen_app').hide();
		}
	});
  }
}
function search_receipt_email(semail){
	if (semail.length >= 2) {	
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts','email':semail},
		success:function(data){
			//alert(data);
			//dis_receipts_scroll_append();
			dis_receipts_scroll();
			$('#target_screen').html(data);
			$('#load_box').hide();
			$('#rec_screen_app').hide();
		}
	});
  }
}

function view_all_receipts() {

	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts'},
		success:function(data){
			//alert(data);
			dis_receipts_scroll();
			$('#target_screen').html(data);
			$('#load_box').hide();
		}
	});
}
//

//Display the mobile number 
function number_allow() {
	
$("#mobile").keypress(function (e) {
		
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#err_mobile").html("Digits Only").show().fadeOut("slow");
               return false;
    }
	});
}

