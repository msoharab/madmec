	/* Admin constraints */
	var LAND_PAGE = URL + "control.php";
	var ERROR_000 = URL + "error/page_000.php";
	var ERROR_402 = URL + "error/page_402.php";
	var ERROR_404 = URL + "error/page_404.php";
	var ERROR_505 = URL + "error/page_505.php";
	var INC = "inc/";
	var INC_MOD = INC + "modules/";
	var LOAD_MODULE = URL + INC + "modules.php";
	var ASSET_DIR = "assets/";
	var ASSET_JSF = "assets/js/";
	var JSF_jQUERY = "jquery/";
	var ASSET_CSS = "assets/css/";
	var ASSET_IMG = "assets/images/";
	var photo_img = "upload_pic/";
	var LOADER_ONE = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader1.gif" border="0" width="60" height="60" />';
	var LOADER_TWO = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader2.gif" border="0" width="25" height="25" />';
	var LOADER_THR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader3.gif" border="0" width="25" height="25" />';
	var LOADER_FUR = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader4.gif" border="0" />';
	var LOADER_FIV = '<img class="img-circle" src="' + URL + ASSET_IMG + 'loader5.gif" border="0" width="60" height="60" />';
	var INET_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in internet connection !!!</span>';
	var LOGN_ERROR = '<span class="text-danger"><i class="fa fa-bomb fa-5x"/></i></span><span class="text-danger">Error in login credentials !!!</span>';
	var VALIDITY_EXPIRED = '<span class="text-info"><i class="fa fa-phone fa-5x"/></i></span><span class="text-warning"> <strong>Your Validity has been Expired Kindly Activate your Service or Conact to your Service Provider </strong></span>';
	var VALIDNOT = '<strong class="text-success">Valid</strong>';
	var INVALIDNOT = '<strong class="text-danger">Not Valid</strong>';
	var ALREADYEXIST = '<strong class="text-danger">ALREADYEXIST</strong>';
	var numbs = /^[0-9]+$/;
	var MODULES = {};
	var OUTPUT = "#output";
	var MOD_USER = URL + INC_MOD + 'user.html';
	var MOD_PRODUCT = URL + INC_MOD + 'product.html';
	var MOD_SALES = URL + INC_MOD + 'sales.html';
	var MOD_PURCHASE = URL + INC_MOD + 'purchase.html';
	var MOD_PAYMENT = URL + INC_MOD + 'payment.html';
	var MOD_COLLECTION = URL + INC_MOD + 'collection.html';
	var MOD_SIGNOUT = URL + INC_MOD + 'signout.html';
	var MOD_PROFILE = URL + INC_MOD + 'profile.html';
	var MOD_CLIENT = URL + INC_MOD + 'client.html';
	var MOD_ADMINPAYMENT = URL + INC_MOD + 'admincollection.html';
	var MOD_BILLLIST = URL + INC_MOD + 'billlist.html';
	var MOD_ORDFOLUPS = URL + INC_MOD + 'orderfollowups.html';
	var MOD_NOTIFY = URL + INC_MOD + 'notify.html';
	var MOD_SALE = URL + INC_MOD + 'sale.html';
	var User = URL + ASSET_IMG + "user.png";
	var email_reg = /^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$/;
	var name_reg = /^[A-Z_a-z\.\'\- 0-9]{3,100}$/;
	var pass_reg = /.{6,100}$/;
	var accn_reg = /[0-9]{5,100}$/;
	var cell_reg = /[0-9]{10,20}$/;
	var ccod_reg = /[0-9]{2,15}$/;
	var tele_reg = /[0-9]{4,20}$/;
	var id_reg = /[1-9]{1,20}$/;
	var ind_reg = /[0-9]{1,20}$/;
	var addline_reg = /.{3,200}$/;
	var st_city_dist_cont_reg = /.{3,100}$/;
	var prov_reg = /.{3,150}$/;
	var url_reg = '^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?';
	var deci_reg = /^[0-9]+(?:\.[0-9])?$/;
	/* function to create and delete a cookie */
	function createCookie(name, value, days) {
	    if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	    }
	    else
		var expires = "";
	    document.cookie = name + "=" + value + expires + "; path=/";
	}
	/* function to read a cookie */
	function readCookie(name) {
	    var nameEQ = name + "=";
	    var ca = document.cookie.split(';');
	    for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ')
		    c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0)
		    return decodeURIComponent(c.substring(nameEQ.length, c.length));
	    }
	    return null;
	}
	function BindScrollEvents() {

	    $(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
		    $('.toTopNav').show(300);
		}
		if ($(this).scrollTop() < 100) {
		    $('.toTopNav').hide(400);
		}
		var scrollbartop = $(window).scrollTop();

		if (scrollbartop == 0) {
		    $('#sidebar').css('top', '0px');
		}
		else if (scrollbartop > 52) {
		    $('#sidebar').css('top', Number(scrollbartop * 0.010) + 'px')
		}
	    });
	}
	function checkExistence(fields) {
	    $(fields.msgDiv).html(LOADER_TWO);
	    $.ajax({
		url: fields.url,
		type: 'POST',
		async: false,
		data: fields,
		success: function (data) {
		    fields.status = data;

		    if (data == '1') {
			$(fields.msgDiv).html('<strong class="text-success">Available</strong>');
		    }
		    else {
			$(fields.msgDiv).html('<strong class="text-danger">Not available</strong>');
		    }

		},
		error: function (data) {
		    hideDivs();
		    $(fields.errDiv).html(INET_ERROR);
		}
	    });
	}
	function loginAdmin(para) {
	    console.log("I am here");
	    window.location.href = LAND_PAGE;
	}
	function logoutAdmin(para) {
	    window.location.href = URL;
	}
	function ntow(junkVal) {

	    junkVal = Math.floor(junkVal);
	    var obStr = new String(junkVal);
	    numReversed = obStr.split("");
	    actnumber = numReversed.reverse();
	    if (Number(junkVal) >= 0) {

	    }
	    else {

		return false;
	    }
	    if (Number(junkVal) == 0) {

		return false;
	    }
	    if (actnumber.length > 9) {

		return false;
	    }
	    var iWords = ["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
	    var ePlace = ['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
	    var tensPlace = ['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety'];
	    var iWordsLength = numReversed.length;
	    var totalWords = "";
	    var inWords = new Array();
	    var finalWord = "";
	    j = 0;
	    for (i = 0; i < iWordsLength; i++) {
		switch (i)
		{
		    case 0:
			if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
			    inWords[j] = '';
			}
			else {
			    inWords[j] = iWords[actnumber[i]];
			}
			inWords[j] = inWords[j] + ' Only';
			break;
		    case 1:
			tens_complication();
			break;
		    case 2:
			if (actnumber[i] == 0) {
			    inWords[j] = '';
			}
			else if (actnumber[i - 1] != 0 && actnumber[i - 2] != 0) {
			    inWords[j] = iWords[actnumber[i]] + ' Hundred and';
			}
			else {
			    inWords[j] = iWords[actnumber[i]] + ' Hundred';
			}
			break;
		    case 3:
			if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
			    inWords[j] = '';
			}
			else {
			    inWords[j] = iWords[actnumber[i]];
			}
			if (actnumber[i + 1] != 0 || actnumber[i] > 0) {
			    inWords[j] = inWords[j] + " Thousand";
			}
			break;
		    case 4:
			tens_complication();
			break;
		    case 5:
			if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
			    inWords[j] = '';
			}
			else {
			    inWords[j] = iWords[actnumber[i]];
			}
			if (actnumber[i + 1] != 0 || actnumber[i] > 0) {
			    inWords[j] = inWords[j] + " Lakh";
			}
			break;
		    case 6:
			tens_complication();
			break;
		    case 7:
			if (actnumber[i] == 0 || actnumber[i + 1] == 1) {
			    inWords[j] = '';
			}
			else {
			    inWords[j] = iWords[actnumber[i]];
			}
			inWords[j] = inWords[j] + " Crore";
			break;
		    case 8:
			tens_complication();
			break;
		    default:
			break;
		}
		j++;
	    }
	    function tens_complication() {
		if (actnumber[i] == 0) {
		    inWords[j] = '';
		}
		else if (actnumber[i] == 1) {
		    inWords[j] = ePlace[actnumber[i - 1]];
		}
		else {
		    inWords[j] = tensPlace[actnumber[i]];
		}
	    }
	    inWords.reverse();
	    for (i = 0; i < inWords.length; i++) {
		finalWord += inWords[i];
	    }

	    return finalWord;
	}
	$(document).ready(function () {
	    window.setTimeout(function () {
		$('#page-loader').hide();
		$('document,body').css({
		    overflowX: "hidden",
		    overflowY: "auto"
		}).show().animate({scrollTop: 0}, "slow");
	    }, 800);
	    $.ajax({
		type: 'POST',
		url: LOAD_MODULE,
		data: {},
		success: function (data) {
		    MODULES = $.parseJSON(data);
		    $(OUTPUT).html('<center><h2>Welcome To Autotrade</h2></center>');
		},
		error: function (xhr, textStatus) {
		    $(OUTPUT).html(INET_ERROR);
		},
		complete: function (xhr, textStatus) {
		    console.log(xhr.status);
		}
	    });
	    BindScrollEvents();
	});
