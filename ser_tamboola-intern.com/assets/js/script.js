	/*specific to attendence*/
	function key_impression(e){
		if(e.which == 49) {
			$("#one").css('background-color','#78BDE2');
			setTimeout("$('#one').css('background-color','')",100);
		}
		else if(e.which == 50) {
			$("#two").css('background-color','#78BDE2');
			setTimeout("$('#two').css('background-color','')",100);
		}
		else if(e.which == 51) {
			$("#three").css('background-color','#78BDE2');
			setTimeout("$('#three').css('background-color','')",100);
		}
		else if(e.which == 52) {
			$("#four").css('background-color','#78BDE2');
			setTimeout("$('#four').css('background-color','')",100);
		}
		else if(e.which == 53) {
			$("#five").css('background-color','#78BDE2');
			setTimeout("$('#five').css('background-color','')",100);
		}
		else if(e.which == 54) {
			$("#six").css('background-color','#78BDE2');
			setTimeout("$('#six').css('background-color','')",100);
		}
		else if(e.which == 55) {
			$("#seven").css('background-color','#78BDE2');
			setTimeout("$('#seven').css('background-color','')",100);
		}
		else if(e.which == 56) {
			$("#eight").css('background-color','#78BDE2');
			setTimeout("$('#eight').css('background-color','')",100);
		}
		else if(e.which == 57) {
			$("#nine").css('background-color','#78BDE2');
			setTimeout("$('#nine').css('background-color','')",100);
		}
		else if(e.which == 48) {
			$("#zero").css('background-color','#78BDE2');
			setTimeout("$('#zero').css('background-color','')",100);
		}
	}
	function showORhide(){
		$('#feesmenu').toggle();
	}
	$(document).ready(function(){
		$('#fees').attr('onClick','javascript:showORhide();');
		$.ajax({
			url:window.location.href,
			data:{autoloader:'true'},
			type:'POST'
		}).done(function(data){
			if(data == 'logout')
				window.location.href = URL;
		});
	});