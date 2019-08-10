function fetch_letter_opt(){
	//$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		
		data:{action:'fetch_letter_opt'},
		success:function(data){
			//alert(data);
		}
	});
}
function fetch_facilities(){
	//$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		
		data:{action:'fetch_facilities'},
		success:function(data){
			//alert(data);
		}
	});
}
function fetch_artists(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		
		data:{action:'fetch_artists'},
		success:function(data){
			$('#src_artists').html(data);
			$('#load_box').hide();
		}
	});
}
function fetch_advertisers(){
	//$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		
		data:{action:'fetch_advertisers'},
		success:function(data){
			$('#src_advertisers').html(data);
			$('#load_box').hide();
		}
	});
}
function fetch_invitees(){
	//$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		
		data:{action:'fetch_invitees'},
		success:function(data){
			$('#src_invitees').html(data);
			$('#load_box').hide();
		}
	});
}
function save_letter(type,id){
	$('#load_box').show();
	if( type == 'art'){
		var last_amount = $('#art_last_'+id).val();
		var pres_amount = $('#art_pres_'+id).val();
		var total_fac = $('#total_fac_art_'+id).val();
		var letter_sel = $('input[name="art_let_'+id+'"]:checked').val();
		var facilities = [];
		for(var i=1;i<=total_fac;i++){
			facilities[i] = $('#'+type+'_fac_'+id+'_'+i).is(':checked') ? $('#'+type+'_fac_'+id+'_'+i).val() : 0 ;
			
		}
		var print = $('#art_print_'+id).is(':checked') ? "yes" : "no";
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'save_letter',
				'type':type,
				'id':id,
				'last_amount':last_amount,
				'pres_amount':pres_amount,
				'letter_sel':letter_sel,
				'print':print,
				'total_fac':total_fac,
				'facilities':facilities},
			success:function(data){
				alert(data);
				$('#load_box').hide();
		
			}
		}); 
	}
	else if( type == 'adv'){
		var last_amount = $('#adv_last_'+id).val();
		var pres_amount = $('#adv_pres_'+id).val();
		var total_fac = $('#total_fac_adv_'+id).val();
		var letter_sel = $('input[name="adv_let_'+id+'"]:checked').val();
		var facilities = [];
		for(var i=1;i<=total_fac;i++){
			facilities[i] = $('#'+type+'_fac_'+id+'_'+i).is(':checked') ? $('#'+type+'_fac_'+id+'_'+i).val() : 0 ;
			
		}
		var print = $('#adv_print_'+id).is(':checked') ? "yes" : "no";
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'save_letter',
				'type':type,
				'id':id,
				'last_amount':last_amount,
				'pres_amount':pres_amount,
				'letter_sel':letter_sel,
				'print':print,
				'total_fac':total_fac,
				'facilities':facilities},
			success:function(data){
				alert(data);
				$('#load_box').hide();
			}
		}); 
	}
	else if( type == 'inv'){
		var last_amount = $('#inv_last_'+id).val();
		var pres_amount = $('#inv_pres_'+id).val();
		var total_fac = $('#total_fac_inv_'+id).val();
		var letter_sel = $('input[name="inv_let_'+id+'"]:checked').val();
		var facilities = [];
		for(var i=1;i<=total_fac;i++){
			facilities[i] = $('#'+type+'_fac_'+id+'_'+i).is(':checked') ? $('#'+type+'_fac_'+id+'_'+i).val() : 0 ;
			
		}
		var print = $('#inv_print_'+id).is(':checked') ? "yes" : "no";
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'save_letter',
				'type':type,
				'id':id,
				'last_amount':last_amount,
				'pres_amount':pres_amount,
				'letter_sel':letter_sel,
				'print':print,
				'total_fac':total_fac,
				'facilities':facilities},
			success:function(data){
				alert(data);
				$('#load_box').hide();
			}
		}); 
	}
}
function print_all(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'print_all'},
		success:function(data){
			alert(data);
			$('#load_box').hide();
		}
	}); 
}
function edit_entry(type,id){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'edit_entry','type':type,'id':id},
		success:function(data){
			if(type == 'art')
				$('#src_artists').html(data);
			else if (type == 'adv')
				$('#src_advertisers').html(data);
			else if(type == 'inv')
				$('#src_invitees').html(data);
			
			$('#load_box').hide();
		}
	}); 
}
function update_entry(type,id){
	$('#load_box').show();
	var designation = $("#up_designation").val();
	var name = $("#up_name").val();
	var address = $("#up_address").val();
	var phone = $("#up_phone").val();
	var mobile = $("#up_mobile").val();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'update_entry',
			'type':type,
			'id':id,
			'designation':designation,
			'name':name,
			'address':address,
			'phone':phone,
			'mobile':mobile
			},
		success:function(data){
				$('#load_box').hide();
				if(type == 'art')
					fetch_artists();
				else if (type == 'adv')
					fetch_advertisers();
				else if(type == 'inv')
					fetch_invitees();
				alert(data);
		}
	});  
}
function add_new_user_form(type){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'add_new_user_form','type':type},
		success:function(data){
			if(type == 'art')
				$('#src_artists').html(data);
			else if (type == 'adv')
				$('#src_advertisers').html(data);
			else if(type == 'inv')
				$('#src_invitees').html(data);
			$('#load_box').hide();
		}
	}); 
}
function add_entry(type){
	$('#load_box').show();
	var designation = $("#designation").val();
	var name = $("#name").val();
	var address = $("#address").val();
	var phone = $("#phone").val();
	var mobile = $("#mobile").val();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'add_entry',
			'type':type,
			'designation':designation,
			'name':name,
			'address':address,
			'phone':phone,
			'mobile':mobile
			},
		success:function(data){
				$('#load_box').hide();
				if(type == 'art')
					fetch_artists();
				else if (type == 'adv')
					fetch_advertisers();
				else if(type == 'inv')
					fetch_invitees();
				alert(data);
		}
	});  
}
function delete_entry(type,id){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'delete_entry','type':type,'id':id},
		success:function(data){
			alert(data);
			$('#load_box').hide();
		}
	}); 
}
function print_summary(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'print_summary'},
		success:function(data){
			$('#src_print').html(data);
			$('#src_print').html(data);
			$('#load_box').hide();
		}
	}); 
}
function print_list(id,val){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'print_list','id':id,'val':val},
		success:function(data){
			window.location.href="prints.php";
			//alert(data);
			//$('#src_print').html(data);
			//$('#load_box').hide();
		}
	}); 
}
function letter_list(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'letter_list'},
		success:function(data){
			$('#src_letter').html(data);
			$('#load_box').hide();
		}
	}); 
}
function delete_letter(id){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'delete_letter','id':id},
		success:function(data){
			letter_list();
			$('#load_box').hide();
		}
	}); 
}
function add_new_letter(type,id){
	var loc = URL+'php/nicedit.php?action=add_new_letter&type='+type+'&id='+id;
	window.location.href= loc;
	/*$('#load_box').show();
	$.ajax({
		url:URL+'php/nicedit.php',
		type:'POST',
		data:{action:'add_new_letter','type':type,'id':id},
		success:function(data){
			$('#src_letter').html(data);
			$('#load_box').hide();
		}
	}); */
}
function create_letter(){
	var title = $("#title").val();
	var content = $("#content").val();
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'create_letter','title':title,'content':content},
		success:function(data){
			$('#load_box').hide();
			letter_list();
		}
	}); 
}
function update_letter(id){
	var title = $("#title").val();
	var content = $("#content").val();
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'update_letter','id':id,'title':title,'content':content},
		success:function(data){
			alert(data);
			$('#load_box').hide();
			letter_list();
		}
	});
}
function dis_art(){
	$("#src_art").show();
	$("#src_adv").hide();
	$("#src_inv").hide();
	$("#src_prt").hide();
	$("#src_let").hide();
}
function dis_adv(){
	$("#src_art").hide();
	$("#src_adv").show();
	$("#src_inv").hide();
	$("#src_prt").hide();
	$("#src_let").hide();
}
function dis_inv(){
	$("#src_art").hide();
	$("#src_adv").hide();
	$("#src_inv").show();
	$("#src_prt").hide();
	$("#src_let").hide();
}
function dis_print(){
	$("#src_art").hide();
	$("#src_adv").hide();
	$("#src_inv").hide();
	$("#src_prt").show();
	$("#src_let").hide();
	print_summary();
}
function dis_add_letter(){
	$("#src_art").hide();
	$("#src_adv").hide();
	$("#src_inv").hide();
	$("#src_prt").hide();
	$("#src_let").show();
	letter_list();
}
$( document ).ready(function() {
	//$("#src_art").hide();
	$("#src_adv").hide();
	$("#src_inv").hide();
	$("#src_prt").hide();
	$("#src_let").hide();
	fetch_letter_opt();
	fetch_facilities();
	fetch_artists();
	fetch_advertisers();
	fetch_invitees();
	print_summary();
	  //<![CDATA[
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    //]]>
  
});