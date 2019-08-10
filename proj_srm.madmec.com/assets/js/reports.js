function show_screen1(){
	$('#screen1').show();
	$('#screen2').hide();		
}
function show_screen2(){
	$('#screen1').hide();
	$('#screen2').show();		
}
function report_form(){
	$('#load_box').show();
	$.ajax({
		url:window.location.href,
		type:'POST',
		data:{action:'report_form'},
		success:function(data){
			//alert(data);
			show_screen2();
			$('#screen2').html(data);
			$('#load_box').hide();
		}
	});
}
function gen_report(){
	var from = $("#from").val();
	var to = $("#to").val();
	if(!isValidDate(from)) 
		alert("From Date is invalid");
	else if(!isValidDate(to))
		alert("To Date is invalid");
	else if( isValidDate(to) && isValidDate(from) ){
		$.ajax({
			url:window.location.href,
			type:'POST',
			data:{action:'gen_report','from':from,'to':to},
			success:function(data){
				//alert(data);
				show_screen2();
				$('#screen2').html(data);
				$('#load_box').hide();
			}
		}); 
	}
}
function isValidDate(subject){
  if (subject.match(/^(?:(0[1-9]|[12][0-9]|3[01])[\- \/.](0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$/)){
    return true;
  }else{
    return false;
  }
}
$( document ).ready(function() {
});