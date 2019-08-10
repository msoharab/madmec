	$(document).ready(function(){
		var alert_count = 0;
		window.setTimeout(function(){
			$.ajax({
				url:window.location.href,
				type:'post',
				data:{autoloader:'true',action:'LoadAlerts',type:'master'}
			}).done(function(data){
				data = $.trim(data);
				console.log(data);
				var notification= data;
				/* Expiring */
				var exp_count = Number(notification);
				$('#notification').html('<i class="fa fa-bell-o"></i>' + exp_count ) ;
				alert_count += exp_count;
				if(alert_count)
					$('#notification').css("color","red");
			});
		},1500);
	});
