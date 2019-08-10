(function($) { 
	function calendarWidget(el, params) { 
		var now   = new Date();
		var thismonth = now.getMonth();
		var thisyear  = now.getYear() + 1900;
		var opts = {
			month: thismonth,
			year: thisyear
		};
		$.extend(opts, params);
		var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var dayNames = ['Sun', 'Mon', 'Tues', 'Wed', 'Thu', 'Fri', 'Sat'];
		month = i = parseInt(opts.month);
		year = parseInt(opts.year);
		var m = 0;
		var table = '';
			// next month
			if (month == 11) {
				var next_month = '<a href="?month=' + 1 + '&amp;year=' + (year + 1) + '" title="' + monthNames[0] + ' ' + (year + 1) + '">' + monthNames[0] + ' ' + (year + 1) + '</a>';
			} else {
				var next_month = '<a href="?month=' + (month + 2) + '&amp;year=' + (year) + '" title="' + monthNames[month + 1] + ' ' + (year) + '">' + monthNames[month + 1] + ' ' + (year) + '</a>';
			}
			// previous month
			if (month == 0) {
				var prev_month = '<a href="?month=' + 12 + '&amp;year=' + (year - 1) + '" title="' + monthNames[11] + ' ' + (year - 1) + '">' + monthNames[11] + ' ' + (year - 1) + '</a>';
			} else {
				var prev_month = '<a href="?month=' + (month) + '&amp;year=' + (year) + '" title="' + monthNames[month - 1] + ' ' + (year) + '">' + monthNames[month - 1] + ' ' + (year) + '</a>';
			}		
			table += ('<h3 id="current-month"><a id="prev" class="ui-shadow ui-btn ui-corner-all ui-icon-arrow-l ui-btn-icon-notext ui-btn-inline" onclick="prev_month('+month+','+year+');"><img height="30" src="'+URL+'assets/images/prev.png"></a>&nbsp;&nbsp;'+monthNames[month]+' '+year+'&nbsp;&nbsp;&nbsp;<a class="ui-shadow ui-btn ui-corner-all ui-icon-arrow-r ui-btn-icon-notext ui-btn-inline" onclick="next_month('+month+','+year+');"><img height="30" src="'+URL+'assets/images/right.png"></a></h3>');
			// uncomment the following lines if you'd like to display calendar month based on 'month' and 'view' paramaters from the URL
			//table += ('<div class="nav-prev">'+ prev_month +'</div>');
			//table += ('<div class="nav-next">'+ next_month +'</div>');
			table += ('<table class="calendar-month " ' +'id="calendar-month'+i+' " cellspacing="0">');	
			table += '<tr>';
			for (d=0; d<7; d++) {
				table += '<th class="weekday">' + dayNames[d] + '</th>';
			}
			table += '</tr>';
			var days = getDaysInMonth(month,year);
            var firstDayDate=new Date(year,month,1);
            var firstDay=firstDayDate.getDay();
			var prev_days = getDaysInMonth(month,year);
            var firstDayDate=new Date(year,month,1);
            var firstDay=firstDayDate.getDay();
			var prev_m = month == 0 ? 11 : month-1;
			var prev_y = prev_m == 11 ? year - 1 : year;
			var prev_days = getDaysInMonth(prev_m, prev_y);
			firstDay = (firstDay == 0 && firstDayDate) ? 7 : firstDay;
			var i = 0;
            for (j=0;j<42;j++){
			  if ((j<firstDay)){
                table += ('<td id="'+year+'-'+(month)+'-'+(prev_days-firstDay+j+1)+'" class="other-month" align="right" valign="bottom" onclick="prev_month('+month+','+year+');"><span class="day">'+ (prev_days-firstDay+j+1) +'</span></td>');
			  } else if ((j>=firstDay+getDaysInMonth(month,year))) {
				i = i+1;
                table += ('<td id="'+year+'-'+(month+2)+'-'+i+'" class="other-month" align="right" valign="bottom" onclick="next_month('+month+','+year+');"><span class="day" >'+ i +'</span></td>');			 
              }else{
                table += ('<td id="'+year+'-'+(month+1)+'-'+(j-firstDay+1)+'"  class="current-month day'+(j-firstDay+1)+'" align="right" valign="bottom" onClick="javascript:show_day_details(this.id);"><span class="day">'+(j-firstDay+1)+'</span></td>');
              }
              if (j%7==6)  table += ('</tr>');
            }
            table += ('</table>');
		el.html(table);
		update_calender();
		if( month == 0 && year == 2014 )
		$("#prev").hide();
		else
		$("#prev").show();
	}
	function update_calender(){
		$.ajax({
				url: window.location.href,
				type:'POST',
				data:{action:'update_calender'},
				success: function(data){
					$(".current-month").css("background-color","#f0f0f0");
					var res = data.split(",");
					for(i=0;i<res.length-1;i++)
					{
						$("#"+res[i]).css("background-image","url(../assets/images/check.jpg)");
						$("#"+res[i]).css("background-size","cover");
					}
					update_expiry_date();
					load_today_workout();
				},
				error:function(){
					//alert("Connect internet to see updated calender. ")
				}
			});
	}
	function update_expiry_date(){
		$.ajax({
			url: window.location.href,
			type:'POST',
			data:{action:'update_expiry_date'},
			success: function(data){
					if(data){
						$("#"+data).css("background-color","#f00");
						$("#"+data).html("<span style='font-size:11px; float:left; max-width:45px; max-height:30px; overflow:hidden;'>fee expiry</span>");
					}
			},
		});
	}
	function getDaysInMonth(month,year)  {
		var daysInMonth=[31,28,31,30,31,30,31,31,30,31,30,31];
		if ((month==1)&&(year%4==0)&&((year%100!=0)||(year%400==0))){
		  return 29;
		}else{
		  return daysInMonth[month];
		}
	}
	// jQuery plugin initialisation
	$.fn.calendarWidget = function(params) {    
		calendarWidget(this, params);		
		return this; 
	}; 
})(jQuery);