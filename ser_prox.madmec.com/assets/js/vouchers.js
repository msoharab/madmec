
function dis_voc(val){
	$('#load_box').removeClass("load_box");
	$('#voc_screen_app').remove();
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'dis_voc','val':val},
		success:function(data){
			//alert(data);
			$('#voc_screen').html(data);
			$('#load_box').hide();
		}
	});
}
function dis_voc_scroll_append(val){
	$('.load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		async:false,
		data:{action:'dis_voc_scroll_append','val':'append'},
		success:function(data){
			//alert(data);
			$('#voc_screen_app').append(data);
			$('.load_box').hide();
		
		}
	});
	
}
function dis_voc_scroll(val){
	$('#load_box').addClass("load_box");
	$('.load_box').show();
	$('<div />', {id: 'voc_screen_app',}).appendTo('#page-inner');
 
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'dis_voc_scroll'},
		success:function(data){
			//alert(data);
			
			$('#voc_screen').html(data);
			$('.load_box').hide();
		
		}
	});
	var flag=true;
	$(window).scroll(function(event){
		if(($(document).height() - ($(window).height() + $(window).scrollTop())) < 10){
			if (flag) {
				flag=false;				
				dis_voc_scroll_append();
				flag=true;				
				}
				}
		else 
				$('#load_box').hide();
	
		});
}
function make_payment(val){
	$("#make_payment_btn").hide();
	var flag = true;
	var ser_no = $('#ser_no').val();
	var date = $('#date').val();
	var src_ac = $('#src_ac').val();
	var pre_name = $('#pre_name').val();
	
	
	
	var name = $('#name').val();
	var loc = $('#loc').val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	var amount = $('#amount').val();
	var cheque_no = $("#cheque_no").val();
	var towards = $("#towards").val();
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
	var isamount  = /^\d+(?:\.\d{0,2})$/;
	var num  = /^\d+$/;
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
	if(val == "cheque"){
		if(src_ac.length > 0){
			$('#err_src_ac').hide();
		}else{
			$('#err_src_ac').show();
			flag = false;
		}
		if(cheque_no.length > 5 && num.test(cheque_no)){
			$('#err_cheque_no').hide();
		}else{
			$('#err_cheque_no').show();
			flag = false;
		} 
	}
	if(name.length > 0){
		$('#err_name').hide();
	}else{
		$('#err_name').show();
		flag = false;
	}
	if(amount.length > 0 && (isamount.test(amount) || num.test(amount)) ){
		$('#err_amount').hide();
	}else{
		$('#err_amount').show();
		flag = false;
	} 
	if(flag){
		var flag2 = check_name_exist(name);
		
		if( flag2 > 0 ){
			var data = {
				action:'make_payment',
				'val':val,
				'target_id' : flag2,
				'ser_no':ser_no,
				'date':date,
				'src_ac':src_ac,
				'pre_name':pre_name,
				
				'name':name,
				'loc':loc,
				'email':email,
				'mobile':mobile,
				'amount':amount,
				'cheque_no':cheque_no,
				'towards':towards,
				
				};
		}
		else{
			var data = {
				action:'make_payment',
				'val':val,
				'ser_no':ser_no,
				'date':date,
				'src_ac':src_ac,
				'pre_name':pre_name,
				
				'name':name,
				'loc':loc,
				'email':email,
				'mobile':mobile,
				'amount':amount,
				'cheque_no':cheque_no,
				'towards':towards,
				
				};
		}
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:data,
			success:function(data){
				if(data == 0)
					$('#voc_screen').html("Error!!!");
				else
					$('#voc_screen').html(data);
				$('#load_box').hide();
				load_tar_session();
				load_all_vouchers();
			}
		});
	}
	else{
		
		alert("Please fill the mandatory fields");
		$("#make_payment_btn").show();
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
function load_all_vouchers(){
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_vouchers'},
		success:function(data){
			//alert(data);
		}
	});
}
function view_all_voucher() {

	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_vouchers'},
		success:function(data){
			//alert(data);
			dis_voc_scroll();
			$('#target_screen').html(data);
			$('#load_box').hide();
			$('#voc_screen_app').show();
		}
	});
}
function search_voucher(sname){
	if (sname.length >= 2) {
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_vouchers','name':sname},
		success:function(data){
			dis_voc_scroll();
			$('#target_screen').html(data);
			$('#load_box').hide();
			$('#voc_screen_app').hide();
			
		}
	});
	}
	
}

//Delete the voucher
	function critical_action(id,val){
	$('#load_box').removeClass("load_box");	
	$('#voc_screen_app').remove();
	if(val == 'delete'){
		var flag = confirm("Are you sure you want to delete this Voucher");
		if(flag){
			$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'critical_action','val':val,'id':id},
			success:function(data){
					dis_voc('view');
					 view_all_voucher();
			}
		});
		}
		
	}
}



//End




//Display the mobile number validation
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

function number_allow_sumofruppes() {
$("#amount").keypress(function (e) {
		
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#err_amount").html("Digits Only").show().fadeOut("slow");
               return false;
    }
	});
}








$( document ).ready(function() {
	load_tar_session();
	dis_voc('cheque');
	load_all_vouchers();
});
