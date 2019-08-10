function dis_receipts(val){
	$('#load_box').removeClass("load_box");	
	$('#rec_screen_app').remove();
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'dis_receipts','val':val},
		success:function(data){
		
			$('#rec_screen').html(data);
			$('#load_box').hide();
			
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
			console.log(data);
			$('#rec_screen').html(data);
			$('.load_box').hide();
			//$("#rec_table").dataTable();
			//display_in_datatables();
		
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
function search_receipt(sname){
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts','name':sname},
		success:function(data){
		dis_receipts_scroll();
			$('#target_screen').html(data);
			$('#load_box').hide();
			$('#rec_screen_app').hide();
		}
	});
}

function view_all_receipts() {

	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_all_receipts'},
		success:function(data){
				dis_receipts_scroll();
			$('#target_screen').html(data);
			$('#load_box').hide();
			//DisAllReceipts();
		}
	});
}

function show_pre_div(elem){
	if(elem.value == 'The' || elem.value == 'M/S'){
		$("#hq_at").show();
		$("#res_at").hide();
	}
	else{
		$("#hq_at").hide();
		$("#res_at").show();
	}
	
}
function show_mop_div(elem){
	if(elem.value == 'dd'){
		$("#dd_div").show();
		$("#transer_div").hide();
		$("#cheque_div").hide();
		$("#trans_mode_div").hide();
	}
	else if(elem.value == 'transfer'){
		$("#dd_div").hide();
		$("#transer_div").show();
		$("#cheque_div").hide();
		$("#trans_mode_div").show();
	}
	else if(elem.value == 'cheque'){
		$("#dd_div").hide();
		$("#transer_div").hide();
		$("#cheque_div").show();
		$("#trans_mode_div").hide();
	}
}
function show_mop_opt(elem){
	if(elem.value == 0){
		$("#mop_opt").hide();
	}
	else if(elem.value != 0){
		$("#mop_opt").show();
	}
}
function make_receipt(){
	$("#make_receipt_btn").hide();
	var flag = true;
	var rec_no = $('#rec_no').val();
	var date = $('#date').val();
	var src_ac = $('#src_ac').val();
	var pre_name = $('#pre_name').val();
	//bank name
	var bank_name = $('#bank_name').val();
	
	var name = $('#name').val();
	var amount = $('#amount').val();
	var towards = $("#for").val();
	var val = ( src_ac == 0) ? 'cash' : 'bank';
	var loc = $('#loc').val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	
	
	var number = $("#number").val();
	var mop_by = $("#mop_by").val();
	var tran_mode = $("input:radio[name=tran_mode]:checked").val();
	var branch_of = $("#branch_of").val();
	var bank = $("#bank").val();
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
	if(val == "bank"){
		if(src_ac.length > 0){
			$('#err_src_ac').hide();
		}else{
			$('#err_src_ac').show();
			flag = false;
		}
		if(number.length > 5 && num.test(number)){
			$('#err_number').hide();
		}else{
			$('#err_number').show();
			flag = false;
		} 
	}
	if(flag){
		var flag2 = check_name_exist(name);
		if( flag2 > 0 ){
			var data = {
				action:'make_receipt',
				'val':val,
				'target_id' : flag2,
				'rec_no':rec_no,
				'date':date,
				'src_ac':src_ac,
				'pre_name':pre_name,
				'bank_name':bank_name,
				'name':name,
				'mobile':mobile,
				'email':email,
				'loc':loc,
				'amount':amount,
				'towards':towards,
				'number':number,
				'mop_by':mop_by,
				'tran_mode':tran_mode,
				'branch_of':branch_of,
				
				};
				console.log(data);
		}
		else{
			var data = {
				action:'make_receipt',
				'val':val,
				'rec_no':rec_no,
				'date':date,
				'src_ac':src_ac,
				'pre_name':pre_name,
				'bank_name':bank_name,
				'name':name,
				'mobile':mobile,
				'email':email,
				'loc':loc,
				'amount':amount,
				'towards':towards,
				'number':number,
				'mop_by':mop_by,
				'tran_mode':tran_mode,
				'branch_of':branch_of,
				
				};
		}
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:data,
			success:function(data){
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
//sum of rupees
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

//Delete the receipts
function critical_action(id,val){
	$('#load_box').removeClass("load_box");	
	$('#rec_screen_app').remove();
	if(val == 'delete'){
		var flag = confirm("Are you sure you want to delete this Receipts");
		if(flag){
			$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'critical_action','val':val,'id':id},
			success:function(data){
					dis_receipts('view');
					view_all_receipts();
			}
		});
		}
		
	}
}
























$( document ).ready(function() {
	load_tar_session();
	dis_receipts('create');
	load_all_receipts();
});
