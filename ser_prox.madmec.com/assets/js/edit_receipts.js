function show_edit_receipt(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'show_edit_receipt'},
		success:function(data){
			//alert(data);
			$('#show_edit_receipt').html(data);
			$('#load_box').hide();
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
function update_receipt(){
	$('#load_box').show();
	var target_id = $("#target_id").val();
	var income_id = $("#income_id").val();
	var rec_no = $("#rec_no").val();
	var rec_loc = $("#rec_loc").val();
	var alt_date = $("#alt-date").val();
	var rec_loc = $("#rec_loc").val();
	var pre_name = $("#pre").val();
	var tar_name = $("#name").val();
	var loc = $("#loc").val();
	var amount = $("#amount").val();
	var email = $("#email").val();
	var mobile = $("#mobile").val();
	var mop_by = $("#don_type").val();
	var mode = $("input:radio[name=tran_mode]:checked").val();
	var number = $("#number").val();
	var branch_of = $("#branch_of").val();
	var bank = $("#bank").val();
	var des = $("#for").val();
	var date = $("#alt-date").val();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{
			action:'update_receipt',
			'target_id' : target_id ,
			'income_id' : income_id ,
			'rec_no' : rec_no ,
			'rec_loc' : rec_loc ,
			'alt_date' : alt_date,
			'pre_name' : pre_name,
			'tar_name' : tar_name,
			'loc' : loc,
			'email' : email,
			'mobile' : mobile,
			'mop_by' : mop_by,
			'mode' : mode,
			'amount' : amount,
			'number' :number,
			'branch_of' : branch_of,
			'bank' : bank,
			'des' : des,
			'date' : date
		},
		success:function(data){
			//alert(data);
			$('#show_edit_receipt').html(data);
			$('#load_box').hide();
		}
	});	
}
$( document ).ready(function() {
	show_edit_receipt();
});
