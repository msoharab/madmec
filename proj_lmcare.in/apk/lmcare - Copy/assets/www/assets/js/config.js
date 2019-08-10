//var URL="http://local.lmcare.loginics.com/"
var URL="http://lmcare.in/"
var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
	var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
	var pass_reg = /.{6,100}$/;
	var accn_reg = /[0-9]{5,100}$/;
	var cell_reg = /^[1-9]+[0-9]{9,20}$/;
	var numbs	 =/^[0-9]+$/;
	var ccod_reg = /[0-9]{1,15}$/;
	var tele_reg = /^[1-9]+[0-9]{5,20}$/;
	var id_reg 	 = /^[1-9]+[0-9]{1,20}$/;
	var ind_reg	 = /[0-9]{1,20}$/;
	var namee_reg=/^[a-zA-Z]+(\s[a-zA-Z]+)*$/;
	var deci_reg=/^[0-9]+(?:\.[0-9])?$/;
        var ASSEST_IMG          = "assets/img/"; 
        var AJAX                = URL+"ajax/control.php"
        var VALIDNOT		= '<strong class="text-success">Valid</strong>';
	var INVALIDNOT		= '<strong class="text-danger">Not Valid</strong>';
	var ALREADYEXIST	= '<strong class="text-danger">ALREADYEXIST</strong>';
        var LOADER              = '<img class="img-circle" src="'+URL+ASSEST_IMG+'PleaseWait.gif" height="60" width="60">';