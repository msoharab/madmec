$(document).ready(function(){
	$(function(){
		var width = 0;
		var left = 0;
		var max = 0;
		var num_of_menus = 0;
		var mooveleft = function(){
			num_of_menus = $('#menuwraper .headingmenusub div').length;
			left = $('.headingmenusub').css('left').replace("px","");
			width = $('.headingmenusub').css('width').replace("px","");
			if(width > 800){
				max = -(width - 800);
				if(left > max){
					left = left - 70;
					$('.headingmenusub').css('left',left+'px');
				}
			}
			$('#rightarrow').stop();
		}
		var moveright = function(){
			num_of_menus = $('#menuwraper .headingmenusub div').length;
			width = $('.headingmenusub').css('width').replace("px","");
			left = $('.headingmenusub').css('left').replace("px","");
			if(width > 800){
				if(left < 0){
					left = ((left * 1) + 70);
					$('.headingmenusub').css('left',left+'px');
				}
			}
			$('#leftarrow').stop();
		}
		$('#menuwraper .headingmenusub div').each(function() {
			width += $(this).outerWidth( true ) + 4;
		});
		$('#menuwraper .headingmenusub').css('width', width + "px");
		$('#rightarrow').css('left',  $('#menuwraper').innerWidth()-30 + "px");
		$('#leftarrow').on('click',mooveleft);
		$('#rightarrow').on('click',moveright);
		$('.headingmenusub').bind('mouseover',function(event){
			$('.headingmenusub').bind('mousewheel',function(event, delta){
				event.stopPropagation();
				event.preventDefault();
				if(delta > 0) {
					moveright();
				}
				else if (delta < 0){
					mooveleft();
				}
			});
		});
		var move = 0;
		$("[class=headingmenusub] div").each(function(){
			var color = $(this)[0].style.backgroundColor;
			if(color.length > 0 && color.length == 18){
				return false;
			}
			else
				move++;
		});
		if(move > 6){
			// if(move < 11)
				left = move * -90;
			// else
				// left = 10 * -90;
			$('.headingmenusub').css('left',left+'px');
		}
			
	});
});
