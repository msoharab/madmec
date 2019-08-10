<?php
/*
	PHP class to 
		1. Find the difference between two dates 
		2. Add an integer to a date to get future date.
	Developer
		Start : 11:34 AM 1/25/2014
		Mohammed Soharab S
		connect@soharab.net
		End : 3:11 PM 1/25/2014
	Constraints
		date 1 should be greater than date 2
	Example
		date 1 => 31-12-2014
		date 2 => 5-6-2014
		require_once('Date.php');
		$date1 = new DATECALC(1,1,2017);
		$date2 = new DATECALC(1,1,2016);
		$days = $date1->SubtractTwoDates($date2);
		echo 'difference between two dates = '.$days.'<br />';
		$date2->AddDays($days);
		echo $date1->MysqlDateReturn().'<br />';
	Note:-
		This script does not validate dates
*/
	class DATECALC{
		private $dd;
		private $mm;
		private $yy;
		public static $months = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
		public static $full_names_months = array(0,'January',
												   'February',
												   'March',
												   'April',
												   'May',
												   'June',
												   'July',
												   'August',
												   'September',
												   'October',
												   'November',
												   'December');
		public static $acc_months = array(0,'Jan',
										   'Feb',
										   'Mar',
										   'Apr',
										   'May',
										   'Jun',
										   'Jul',
										   'Aug',
										   'Sep',
										   'Oct',
										   'Nov',
										   'Dec');
		function __construct($dd,$mm,$yy){
			$this->dd = $dd;
			$this->mm = $mm;
			$this->yy = $yy;
		}
		/* Days which are yet to come referred from Date 2 for the current year from given month to till December month */
		public function FutureDays(){
			$num=0; 
			$this->LeapYear($this->yy);
			for($i=$this->mm;$i<13;$i++) 
				$num += DATECALC::$months[$i];
			$num = $num -$this->dd;
			return ($num);
		}
		/* Days which are passed  referred from Date 1 for the current year from January month to given month */
		public function PastDays(){
			$num=0; 
			$this->LeapYear($this->yy);
			for($i=$this->mm;$i>0;$i--){
				$num += DATECALC::$months[$i];
			}
			$num = $num - (DATECALC::$months[$this->mm] - $this->dd);
			return $num;
		}
		/* Verify the year is leap or not if year is leap update months array and return true else false */
		public function LeapYear($year){
			if (($year%100) == 0 || ($year%400) == 0 || ($year%4) == 0){
				DATECALC::$months[2] = 29;
				return 1;
			}
			else{
				DATECALC::$months[2] = 28;
				return 0;
			}
		}
		/* Add an integer to date 1 and return the future date */
		public function AddDays($no_of_days){
			$this->LeapYear($this->yy);
			for($i=$no_of_days;$i>0;$i--){
				$this->dd += 1; 
				if($this->dd > DATECALC::$months[$this->mm]){
					$this->dd = 1; 
					$this->mm += 1;
					if($this->mm > 12){
						$this->LeapYear($this->yy);
						$this->dd = 1; 
						$this->mm = 1; 
						$this->yy += 1;
					}
				}
			}
		}
		/* Subtract date 2 from date 1 and return days */
		public function SubtractTwoDates(DATECALC $D2){
			$nyy = 0;
			if($this->yy == $D2->yy){
				return($this->PastDays() - $D2->PastDays());
			}
			else{
				for($i = $D2->yy+1;$i<$this->yy;$i++){
					($this->LeapYear($i))? $nyy+= 366:$nyy+= 365;
				}
				return($this->PastDays() + $D2->FutureDays() + $nyy);
			}
		}
		/* Return the date as mysql format */
		public function MysqlDateReturn(){
			return $this->yy.'-'.$this->mm.'-'.$this->dd;
		}
	}
 ?>