
function load_target_ac(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_target_ac'},
		success:function(data){
			//alert(data);
			$('#target_screen').html(data);
			$('#load_box').hide();
		}
	});
}

//Search for a income details 
function load_target_ac_search_income(sname){
	
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_target_ac_income','name':sname},
		success:function(data){
			//alert(data);
			
			$('#incomecoll').click();
			$('#target_screen').html(data);
			$('#load_box').hide();
		}
	});
}
//search for a target payments details 
function load_target_ac_search_payment(sname){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_target_ac_payment','name':sname},
		success:function(data){
			//alert(data);
			$('#paymentcoll').click();
			$('#target_screen').html(data);
			$('#load_box').hide();
		}
	});
}




function show_target_ac(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'show_target_ac'},
		success:function(data){
			//alert(data);
			$('#target_screen').html(data);
			$('#load_box').hide();
		}
	});
}
function target_ac_detail(id,name,type){
	console.log(name);
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'target_ac_detail','id':id,'name':name,'tp':type},
		success:function(data){
			//alert(data);
			$('#target_screen').html(data);
			$('#load_box').hide();
		}
	});
}

function report_status(){
	var email = $("#email_report").val();
	var pass = $("#password_report").val();
	
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'function_login_report_sheet',email:email,pass:pass},
			success:function(data){
				if(data=="valid"){
					
					$("#report").show();
					$("#formclass").hide();
				}
				else{
					$("#passauth").html("<h3> This information is not valid<h3>");
				}
			}
		
		
	
	});
}


$( document ).ready(function() {
	load_target_ac();
	$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'checkBalanceSheet'},
			success:function(data){
				
				if(data=="allow"){
								
					$("#formclass").show();
				}
				else{
						$("#report").show();
					//$("#error_msg").html("<h1> This facility not supported<h1>");
				}
			}
		});
});



