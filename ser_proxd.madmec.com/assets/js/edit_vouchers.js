function show_edit_voucher(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'show_edit_voucher'},
		success:function(data){
			//alert(data);
			$('#show_edit_voucher').html(data);
			$('#load_box').hide();
		}
	});
}
function update_payment(){
	$("#make_payment_btn").hide();
	var flag = true;
	var val = $('#val').val();
	var src_ac = $('#src_ac').val();
	var target_id = $('#target_id').val();
	var payment_id = $('#payment_id').val();
	var voc_loc = $('#voc_loc').val();
	var ser_no = $('#ser_no').val();
	var alt_date = $('#alt-date').val();
	var date = $('#date').val();
	var pre_name = $('#pre').val();
	var name = $('#name').val();
	var loc = $('#loc').val();
	var mobile = $("#mobile").val();
	var email = $("#email").val();
	var amount = $('#amount').val();
	var cheque_no = $("#cheque_no").val();
	var towards = $("#towards").val();
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
	if(flag){
		$('#load_box').show();
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{
				action:'update_payment',
				'val' : val,
				'src_ac' : src_ac,
				'target_id' : target_id,
				'payment_id' : payment_id,
				'voc_loc' : voc_loc,
				'ser_no':ser_no,
				'date':date,
				'alt_date':alt_date,
				'pre_name':pre_name,
				'name':name,
				'loc':loc,
				'email':email,
				'mobile':mobile,
				'amount':amount,
				'cheque_no':cheque_no,
				'towards':towards 
			},
			success:function(data){
				//alert(data);
				$('#show_edit_voucher').html(data);
				$('#load_box').hide();
			}
		});
	}
	else{
		alert("Please fill the mandatory fields");
		$("#make_payment_btn").show();
	}
}
$( document ).ready(function() {
	show_edit_voucher();
});