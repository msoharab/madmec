	function pattycashController() {
	    var pattycash = {};
	    this.__construct = function(pcctrl) {
	        pattycash = pcctrl;
	        $(pattycash.add.but).click(function() {
	            addpettycash()
	        });
	        $(pattycash.list.menubut).click(function() {
	            $(pattycash.msgDiv).html('');
	            fetchpettycashhistory();
	        });
	    }

	    function fetchpettycashhistory() {
	        $(pattycash.list.displayhistory).html(LOADER_ONE);
	        $.ajax({
	            url: pattycash.add.url,
	            type: 'POST',
	            data: {
	                autoloader: true,
	                action: 'fetchpettycashhistory',
	            },
	            success: function(data, textStatus, xhr) {
	                data = $.trim(data);
	                switch (data) {
	                    case 'logout':
	                        logoutAdmin({});
	                        break;
	                    case 'login':
	                        loginAdmin({});
	                        break;
	                    default:
	                        var htm = $.parseJSON(data);
	                        $(pattycash.list.displayhistory).html(htm);
	                        window.setTimeout(function() {
	                            $('#dataTables-pettycash').dataTable();
	                        });
	                        break;
	                }
	            },
	            error: function() {
	                $(pattycash.outputDiv).html(INET_ERROR);
	            },
	            complete: function(xhr, textStatus) {
	                console.log(xhr.status);
	                $(pattycash.add.but).removeAttr('disabled');
	            }
	        });
	    }

	    function addpettycash() {
	        var flag = false;
	        /* Item type / name */
	        if ($(pattycash.add.pamount).val().match(numbs)) {
	            flag = true;
	            $(pattycash.add.pamountmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(pattycash.add.pamountmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(pattycash.add.pamountmsg).offset().top) - 95
	            }, 'slow');
	            $(pattycash.add.pamount).focus();
	            return;
	        }
	        if (Number($(pattycash.add.pamount).val()) != 0) {
	            flag = true;
	            $(pattycash.add.pamountmsg).html(VALIDNOT);
	        } else {
	            flag = false;
	            $(pattycash.add.pamountmsg).html(INVALIDNOT);
	            $('html, body').animate({
	                scrollTop: Number($(pattycash.add.pamountmsg).offset().top) - 95
	            }, 'slow');
	            $(pattycash.add.pamount).focus();
	            return;
	        }
	        var attr = {
	            amount: $(pattycash.add.pamount).val(),
	            remark: $(pattycash.add.remark).val()
	        };
	        if (flag) {
	            $(pattycash.add.but).prop('disabled', 'disabled');
	            $(pattycash.msgDiv).html('');
	            $.ajax({
	                url: pattycash.add.url,
	                type: 'POST',
	                data: {
	                    autoloader: true,
	                    action: 'pettycashadd',
	                    petyadd: attr
	                },
	                success: function(data, textStatus, xhr) {
	                    data = $.trim(data);
	                    switch (data) {
	                        case 'logout':
	                            logoutAdmin({});
	                            break;
	                        case 'login':
	                            loginAdmin({});
	                            break;
	                        default:
	                            $(pattycash.msgDiv).html('<h2>Cash added to Avaliable Cash</h2>');
	                            $('html, body').animate({
	                                scrollTop: Number($(pattycash.msgDiv).offset().top) - 95
	                            }, 'slow');
	                            $(pattycash.add.form).get(0).reset();
	                            break;
	                    }
	                },
	                error: function() {
	                    $(pattycash.outputDiv).html(INET_ERROR);
	                },
	                complete: function(xhr, textStatus) {
	                    console.log(xhr.status);
	                    $(pattycash.add.but).removeAttr('disabled');
	                }
	            });
	        } else {
	            $(pattycash.add.but).removeAttr('disabled');
	        }
	    };
	}