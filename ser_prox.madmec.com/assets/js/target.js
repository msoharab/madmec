
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
//Search for a income details 
function load_target_ac_search_income(sname){
	
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'load_target_ac_income','name':sname},
		success:function(data){
			$('#incomecoll').click();
			$('#target_screen').html(data);
			$('#load_box').hide();
		}
	});
}
$( document ).ready(function() {
	load_target_ac();
});
