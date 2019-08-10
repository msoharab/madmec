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
	function validateUserDetails(){
		var name = $('#user_name').val();
		var sex = $('#user_sex').select().val();
		var dob = $('#dateofbirth').val();
		var mobile = $('#user_mobile').val();
		var email = $('#user_email').val();
		var acs_id = $('#user_acs').val();
		var occp = $('#user_occ').select().val();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
		var mobile_reg = /^[0-9]{10}$/;
		var num_reg = /^[0-9]{1,10}$/;
		var flag = true;
		if(name.match(name_reg)){
			$('#un_msg').hide();
		}
		else{
			$('#un_msg').show();
			flag = false;
		}
		if(mobile.match(mobile_reg)){
			$('#mob_msg').hide();
		}
		else{
			$('#mob_msg').show();
			flag = false;
		}
		if(email.match(email_reg)){
			$('#eml_msg').hide();
		}
		else{
			$('#eml_msg').show();
			flag = false;
		}
		if(acs_id.match(num_reg)){
			$('#user_acs_msg').hide();
		}
		else{
			$('#user_acs_msg').show();
			flag = false;
		}
		if(dob.length > 0){
			$('#dob_msg').hide();
		}
		else{
			$('#dob_msg').show();
			flag = false;
		}
		if(flag){
			$('#output').html('<center style="padding-top:150px;"><img src="'+URL+'assets/images/progress3.gif" border="0" /></center>');
			$.ajax({
				url:window.location.href,
				data:{autoloader:'true',action:'AddUser',user_name:name,sex:sex,dob:dob,mobile:mobile,email:email,acs_id:acs_id,user_occ:occp},
				type:'POST'
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				$('#output').html(data);
			});
		}
	}
	function validateTrainerDetails(){
		var name = $('#trainer_name').val();
		var sex = $('#trainer_sex').select().val();
		var mobile = $('#trainer_mobile').val();
		var email = $('#trainer_email').val();
		var acs_id = $('#trainer_acs').val();
		var trainer_gym = null;
		var trainer_aer = null;
		var trainer_dan = null;
		var trainer_yog =  null;
		var trainer_zum =  null;
		if($('#trainer_gym').is(":checked"))
			trainer_gym = $('#trainer_gym').val();
		if($('#trainer_aer').is(":checked"))
			trainer_aer = $('#trainer_aer').val();
		if($('#trainer_dan').is(":checked"))
			trainer_dan = $('#trainer_dan').val();
		if($('#trainer_yog').is(":checked"))
			trainer_yog  = $('#trainer_yog').val();
		if($('#trainer_zum').is(":checked"))
			trainer_zum  = $('#trainer_zum').val();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
		var mobile_reg = /^[0-9]{10}$/;
		var num_reg = /^[0-9]{1,10}$/;
		var flag = true;
		if(name.match(name_reg)){
			$('#un_msg').hide();
		}
		else{
			$('#un_msg').show();
			flag = false;
		}
		if(mobile.match(mobile_reg)){
			$('#mob_msg').hide();
		}
		else{
			$('#mob_msg').show();
			flag = false;
		}
		if(email.match(email_reg)){
			$('#eml_msg').hide();
		}
		else{
			$('#eml_msg').show();
			flag = false;
		}
		if(acs_id.match(num_reg)){
			$('#trainer_acs_msg').hide();
		}
		else{
			$('#trainer_acs_msg').show();
			flag = false;
		}
		if(trainer_gym == null && trainer_aer == null && trainer_dan == null && trainer_yog == null){
			$('#trn_msg').show();
			flag = false;
		}
		else{
			$('#trn_msg').hide();
		}
		if(flag){
			$('#output').html('<center style="padding-top:150px;"><img src="'+URL+'assets/images/progress3.gif" border="0" /></center>');
			$.ajax({
				url:window.location.href,
				data:{autoloader:'true',
						user_name:name,
						sex:sex,
						mobile:mobile,
						email:email,
						acs_id:acs_id,
						trainer_gym:trainer_gym,
						trainer_aer:trainer_aer,
						trainer_dan:trainer_dan,
						trainer_yog:trainer_yog,
						trainer_zum:trainer_zum},
				type:'POST'
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				$('#output').html(data);
			});
		}
	}
	function addOptionsFee(obj,amt){
		var total = $('#amount').val();
		if($(obj).is(':checked'))
			total = (total *1) + amt;
		else
			total = (total *1) - amt;
		$('#amount').val(total);
	}
	function ValidatePayment(){
		var email = $('#email').val();
		var amount = $('#amount').val();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var amt_reg = /^[0-9]{2,10}$/;
		var flag = true;
		if(email.match(email_reg)){
			$('#email_msg').hide();
		}
		else{
			$('#email_msg').show();
			flag = false;
		}
		if(amount.match(amt_reg)){
			$('#amt_msg').hide();
		}
		else{
			$('#amt_msg').show();
			flag = false;
		}
		if(flag)
			$('#paymentform').submit();
	}
	function showORhide(){
		$('#feesmenu').toggle();
	}
	function ShowAddGroup(){
		$('#addgrouprow').toggle();
	}
	function AddGroupForm(){
		var num = $('#num_mem').val();
		var num_reg = /^[0-9]{1,2}$/;
		if(num.match(num_reg)){
			$('#output').html('<center style="padding-top:150px;"><img src="'+URL+'assets/images/progress3.gif" border="0" /></center>');
			$.ajax({
				url:window.location.href,
				data:{autoloader:'true',action:'AddGroupForm',number:num},
				type:'POST'
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				$('#output').html(data);
			});
		}
		else
			alert('Enter a valid number!!!');
	}
	function validateGroupDetails(num){
		var group_type = '';
		 $('[name=group_type]').each(function() {
			if($(this).is(':checked')){
				group_type = $(this).val();
			}
		});
		var group_owner = $().val();
		 $('[name=group_owner]').each(function() {
			if($(this).is(':checked')){
				group_owner = $(this).val();
			}
		});
		var group_name = $('#group_name').val();
		var name = new Array();
		var sex = new Array();
		var dob = new Array();
		var mobile = new Array();
		var email = new Array();
		var acs_id = new Array();
		var occp = new Array();
		var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
		var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
		var mobile_reg = /^[0-9]{10}$/;
		var num_reg = /^[0-9]{1,10}$/;
		var flag = true;
		for(i=1;i<=num;i++){
			name[i] = $('#user_name_'+i).val();
			sex[i] = $('#user_sex_'+i).select().val();
			dob[i] = $('#dateofbirth_'+i).val();
			mobile[i] = $('#user_mobile_'+i).val();
			email[i] = $('#user_email_'+i).val();
			acs_id[i] = $('#user_acs_'+i).val();
			occp[i] = $('#user_occ_'+i).select().val();
		}
		for(i=1;i<=num;i++){
			for(j=i+1;j<=num;j++){
				if(email[i] == email[j]){
					flag = false;
					alert("All the customers have same email ids");
					return;
				}
			}
		}
		if(!flag){
			//email
			for(i=1;i<=num;i++){
				if(email[i].match(email_reg)){
					$('#eml_msg_'+i).hide();
				}
				else{
					$('#eml_msg_'+i).show();
					flag = false;
				}
			}
		}
		for(i=1;i<=num;i++){
			//name
			if(name[i].match(name_reg)){
				$('#un_msg_'+i).hide();
			}
			else{
				$('#un_msg_'+i).show();
				flag = false;
			}
			//mobile
			if(mobile[i].match(mobile_reg)){
				$('#mob_msg_'+i).hide();
			}
			else{
				$('#mob_msg_'+i).show();
				flag = false;
			}
			//email
			if(email[i].match(email_reg)){
				$('#eml_msg_'+i).hide();
			}
			else{
				$('#eml_msg_'+i).show();
				flag = false;
			}
			if(acs_id[i].match(num_reg)){
				$('#user_acs_msg_'+i).hide();
			}
			else{
				$('#user_acs_msg_'+i).show();
				flag = false;
			}
			//date of birth
			if(dob[i].length > 0){
				$('#dob_msg_'+i).hide();
			}
			else{
				$('#dob_msg_'+i).show();
				flag = false;
			}
		}
		if(group_name.match(name_reg)){
			$('#group_name_msg').hide();
		}
		else{
			$('#group_name_msg').show();
			flag = false;
		}
		if(group_type){
			$('#group_type_msg').hide();
		}
		else{
			$('#group_type_msg').show();
			flag = false;
		}
		if(group_owner){
			$('#group_owner_msg').hide();
		}
		else{
			$('#group_owner_msg').show();
			flag = false;
		}
		if(flag){
			$('#output').html('<center style="padding-top:150px;"><img src="'+URL+'assets/images/progress3.gif" border="0" /></center>');
			$.ajax({
				url:window.location.href,
				data:{autoloader:'true',action:'AddGroupUsers',group_name:group_name,
						members:num,group_type:group_type,group_owner:group_owner,
						user_name:name,sex:sex,dob:dob,mobile:mobile,email:email,acs_id:acs_id,user_occ:occp},
				type:'POST'
			}).done(function(data){
				if(data == 'logout')
					window.location.href = URL;
				$('#output').html(data);
			});
		}
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