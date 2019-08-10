function display_src_ac(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'display_src_ac'},
		success:function(data){
			show_screen1();
			$('#src_ac_screen').html(data);
			$('#load_box').hide();
		}
	});
}
function src_ac_details(id,ac_name){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'src_ac_details','id':id,'ac_name':ac_name},
		success:function(data){
			show_screen2();
			$('#src_ac_screen2').html(data);
			$('#load_box').hide();
		}
	});
}
function add_balance_entry_form(id,type){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'add_balance_entry_form','id':id,'type':type},
		success:function(data){
			show_screen2();
			$('#src_ac_screen2').html(data);
			$('#load_box').hide();
		}
	});
}
function add_balance_entry(){
	var id = $('#bal_src_id').val();
	var type = $('#bal_action').val();
	var bal_amt = $('#bal_amt').val();
	var bal_des = $('#bal_des').val();
	if(bal_amt.length > 1 && bal_des.length > 1 ){
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'add_balance_entry',
				'id':id,
				'type':type,
				'bal_amt':bal_amt,
				'bal_des':bal_des},
			success:function(data){
				show_screen1();
				alert(data);
				$('#load_box').hide();
			}
		});
	}
	else{
		alert("Please enter all the fields");
	}
}
function show_screen1(){
	$('#src_ac_screen').show();
	$('#src_ac_screen2').hide();		
}
function show_screen2(){
	$('#src_ac_screen').hide();
	$('#src_ac_screen2').show();		
}
function add_form_src_ac(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'add_form_src_ac'},
		success:function(data){
			show_screen1();
			$('#src_ac_screen').html(data);
			$('#load_box').hide();
		}
	});
}
function add_src_ac(){
	var flag = true;
	var src_ac_no = $('#src_ac_no').val();
	var src_ac_name = $('#src_ac_name').val();
	var src_branch = $('#src_branch').val();
	var src_bank = $('#src_bank').val();
	var src_pan = $('#src_pan').val();
	var des = $('#des').val();
	var src_ac_type = $("#src_ac_type").val();
	if(src_ac_no.length > 0){
		$('#err_src_ac_no').hide();
	}else{
		$('#err_src_ac_no').show();
		flag = false;
	}
	if(src_ac_name.length > 0){
		$('#err_src_ac_name').hide();
	}else{
		$('#err_src_ac_name').show();
		flag = false;
	}
	if(src_branch.length > 0){
		$('#err_src_branch').hide();
	}else{
		$('#err_src_branch').show();
		flag = false;
	}
	if(src_bank.length > 0){
		$('#err_src_bank').hide();
	}else{
		$('#err_src_bank').show();
		flag = false;
	}
	if(flag){
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{
				action:'add_src_ac',
				'src_ac_no' : src_ac_no,
				'src_ac_name' : src_ac_name,
				'src_bank' : src_bank,
				'src_branch' : src_branch,
				'src_pan' : src_pan,
				'des' : des, 
				'src_ac_type' : src_ac_type},
			success:function(data){
				show_screen1();
				if(data == 1)
					$('#src_ac_screen').html("Updates Successfully!!!");
				else
					$('#src_ac_screen').html("Error please try agian!!!");
				$('#load_box').hide();
			}
		});
	}else{
		alert("Please fill the mandatory fields");
	}
}
function edit_src_ac(id){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'edit_src_ac',id:id},
		success:function(data){
			show_screen1();
			$('#src_ac_screen').html(data);
			$('#load_box').hide();
		}
	});
}
function update_src_ac(id){
	var flag = true;
	var up_src_ac_no = $('#up_src_ac_no').val();
	var up_src_ac_name = $('#up_src_ac_name').val();
	var up_src_bank = $('#up_src_bank').val();
	var up_src_branch = $('#up_src_branch').val();
	var up_src_pan = $('#up_src_pan').val();
	var up_des = $('#up_des').val();
	var up_src_ac_type = $("#up_src_ac_type").val();
	if(up_src_ac_no.length > 0){
		$('#err_src_ac_no').hide();
	}else{
		$('#err_src_ac_no').show();
		flag = false;
	}
	if(up_src_ac_name.length > 0){
		$('#err_src_ac_name').hide();
	}else{
		$('#err_src_ac_name').show();
		flag = false;
	}
	if(up_src_branch.length > 0){
		$('#err_src_branch').hide();
	}else{
		$('#err_src_branch').show();
		flag = false;
	}
	if(up_src_bank.length > 0){
		$('#err_src_bank').hide();
	}else{
		$('#err_src_bank').show();
		flag = false;
	}
	if(flag){
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{
				action:'update_src_ac',
				id:id,
				'up_src_ac_no':up_src_ac_no,
				'up_src_ac_name':up_src_ac_name,
				'up_src_bank':up_src_bank,
				'up_src_branch':up_src_branch,
				'up_src_pan':up_src_pan,
				'up_des':up_des,
				'up_src_ac_type':up_src_ac_type},
			success:function(data){
				show_screen1();
				if(data == 1)
					$('#src_ac_screen').html("Updated successfully!!!");
				else
					$('#src_ac_screen').html("Error!!!");
				$('#load_box').hide();
			}
		});
	}else{
		alert("Please fill the mandatory fields");
	}
}
function deactivate_src_ac(id){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'deactivate_src_ac',id:id},
		success:function(data){
			show_screen1();
			if(data == 1)
				$('#src_ac_screen').html("Deactivated successfully!!!");
			else
				$('#src_ac_screen').html("Error!!!");
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
	display_src_ac();
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


//Display the account number :--
function number_allow() {
	$("#src_ac_no").keypress(function (e) {
		
     // digit  and alphabets then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122)) {
        //display error message
        $("#err_src_ac_no").html("Alphabets & Digits Only").show().fadeOut("slow");
               return false;
    }
	});
}
//Display the account name
function account_name() {
	
$("#src_ac_name").keypress(function (e) {
		
     // digit  and alphabets then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))  {
        //display error message
        $("#err_src_ac_name").html("Alphabets Only").show().fadeOut("slow");
               return false;
    }
	});
}

//Display the bank name 
function bank_name() {
	
$("#src_bank").keypress(function (e) {
		
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122)) {
        //display error message
        $("#err_src_bank").html("Digits Only").show().fadeOut("slow");
               return false;
    }
	});
}




