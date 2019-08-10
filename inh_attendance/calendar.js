	var IE4 = (document.all && !document.getElementById) ? true : false;
    var NS4 = (document.layers) ? true : false;
    var IE5 = (document.all && document.getElementById) ? true : false;
    var N6 = (document.getElementById && !document.all) ? true : false;
  

var aMonthNames = new Array(
	'JANUARY', 'FEBRUARY', 'MARCH', 
	'APRIL', 'MAY', 'JUNE', 
	'JULY',	'AUGUST', 'SEPTEMBER', 
	'OCTOBER', 'NOVEMBER', 'DECEMBER'
	);
var aMonthDisplay = new Array(
	'01', '02', '03', 
	'04', '05', '06', 
	'07',	'08', '09', 
	'10', '11', '12'
	);	
var aMonthDays = new Array(  
	/* Jan */ 31,     /* Feb */ 28, /* Mar */ 31,     /* Apr */ 30, 
	/* May */ 31,     /* Jun */ 30, /* Jul */ 31,     /* Aug */ 31, 
	/* Sep */ 30,     /* Oct */ 31, /* Nov */ 30,     /* Dec */ 31 
	);
var days = new Array(42);
		
		
		function daylayerdisplay(b,a,c)
		{
		
		monthreduction=a;
		monthincrease=a;
		            if (b%4 == 0 || b%100 ==0){
					aMonthDays[1]=29;
					}
					else{
					aMonthDays[1]=28;
					}
				    var oDateNow = new Date();	
					var oDate = new Date(aMonthNames[a] +  1 + "," + b);
					dayofweek=oDate.getDay();
					
					var count=0;
					var count1;
					var end=aMonthDays[a]+(dayofweek);
					for (s=1;s<=42;s++){
					document.getElementById("day"+s).childNodes[0].innerHTML="";
					}
					for (s=(dayofweek+1);s<=end;s++){
					count=count+1;
					document.getElementById("day"+s).childNodes[0].innerHTML=count;
					if (count<=9)
					{
					count1=0+""+count;
					}
					else
					{
					count1=count;
					}
					document.getElementById("day"+s).childNodes[0].id=count1;
					}
			}
				
				
				function sendvalue(y,m,d)
				{
					if (y == 1){
					todayobj= new Date();
					today=todayobj.getYear()+todayobj.getMonth()+todayobj.getDate();
					if (N6){
					year=todayobj.getYear()+1900;
					}
					else
					{
					year=todayobj.getYear();
					}					
					if (todayobj.getDate() <= 9)
					{
					var todayday=0+""+todayobj.getDate();
					}
					else
					{
					var todayday=todayobj.getDate();
					}
					parent.document.form1.date1.value=year + "-" + aMonthDisplay[todayobj.getMonth()]+ "-" + todayday;
					parent.document.getElementById('calendarframe').style.display='none'
					}
					else{
					parent.document.form1.date1.value= y+"-"+aMonthDisplay[m]+"-"+d;//y + m + d;
					parent.document.getElementById('calendarframe').style.display='none'
					}
				 }
				 
				 function reducemonths()
				 { 
				 monthreduction= +monthreduction - 1;
				 if (monthreduction==-1)
				 {
				 monthreduction=11;
				 document.calendarform.year.value=
				 parseFloat(document.calendarform.year.value)-1;
				 }
				 
				 document.calendarform.month[monthreduction].selected = "1";
				 daylayerdisplay(document.calendarform.year.value,monthreduction,101);
				 }
				 
				 function increasemonths()
				 { 
				 monthincrease= +monthincrease + 1;
				 if (monthincrease==12)
				 {
				 monthincrease=0;
				 document.calendarform.year.value=
				 parseFloat(document.calendarform.year.value)+1;
				 }
				 document.calendarform.month[monthincrease].selected = "1";
				 daylayerdisplay(document.calendarform.year.value,monthincrease,101);
				 }
				
								 
