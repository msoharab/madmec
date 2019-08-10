	function repController() {
		var rep = {};
		this.__construct = function(repctrl) {
			rep = repctrl;
			$(rep.msgDiv).html('');
			$(rep.add.dfrom).datepicker({
				dateFormat: 'yy-mm-dd',
				maxDate:0,
				changeYear: true,
				changeMonth: true
			});
			$(rep.add.dto).datepicker({
				dateFormat: 'yy-mm-dd',
				maxDate:0,
				changeYear: true,
				changeMonth: true
			});
			$(rep.add.xlsbut).click(function(){
				generateReport();
			});
		};
		function generateReport(){
			var flag = false;
			/* Date From */
			if ($(rep.add.dfrom).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
				flag = true;
				$(rep.add.dfrommsg).html(VALIDNOT);
			} else {
				flag = false;
				$(rep.add.dfrommsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop: Number($(rep.add.dfrommsg).offset().top) - 95
				}, 'slow');
				$(rep.add.dfrom).focus();
				return;
			}
			/* Date To */
			if ($(rep.add.dto).val().match(/(\d{4})-(\d{2})-(\d{2})/)) {
				flag = true;
				$(rep.add.dtomsg).html(VALIDNOT);
			} else {
				flag = false;
				$(rep.add.dtomsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop: Number($(rep.add.dtomsg).offset().top) - 95
				}, 'slow');
				$(rep.add.dto).focus();
				return;
			}
                        var fromdate=new Date($(rep.add.dfrom).val());
                        var todate=new Date($(rep.add.dto).val())
                        if(todate<fromdate)
                        {
                          flag = false;
				$(rep.add.dtomsg).html(INVALIDNOT);
				$('html, body').animate({
					scrollTop: Number($(rep.add.dtomsg).offset().top) - 95
				}, 'slow');
				$(rep.add.dto).focus();
				return;  
                        }
                        else
                        {
                          flag = true;
			  $(rep.add.dtomsg).html(VALIDNOT);  
                        }
			var attr = {
				dfrom: $(rep.add.dfrom).val(),
				dto: $(rep.add.dto).val()
			};
			if (flag) {
				$(rep.add.xlsbut).prop('disabled', 'disabled');
				$(rep.msgDiv).html('');
				$.ajax({
					url: rep.add.url,
					type: 'POST',
					data: {
						autoloader: true,
						action: 'generateReport',
						rep: attr
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
								$(rep.msgDiv).html('<h2>'+data+'</h2>');
								$('html, body').animate({
									scrollTop: Number($(rep.msgDiv).offset().top) - 95
								}, 'slow');
							break;
						}
					},
					error: function() {
						$(rep.outputDiv).html(INET_ERROR);
					},
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
						$(rep.add.xlsbut).removeAttr('disabled');
					}
				});
			}
		};
	}
