<?php
class gym_select{
	function LoadActiveMem(){
		$count = 0;
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		echo '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h4>Active Customers</h4>
					</div>
					<div class="panel-body">';
				$limit = date('Y-m',strtotime('-3 months'));//direct calculating the month
				$temp = explode('-',$limit);
				$year = $temp[0];
				$month = $temp[1];
				$color=["primary","green","yellow","red"];
				/* TO display Active Members every month */
				for($i=0;$i<4;$i++){
					if($month == 13){
						$month = 1;
						$year++;
					}
					else{
						$month = $month+0;
					}
					$month = ($month < 10) ? "0".$month : $month;
					$count = mysql_num_rows(executeQuery("SELECT  DISTINCT `user_id` FROM `fee` WHERE `valid_from` <= '".$year."-".$month."-31 00:00:00' AND `valid_till` >=  '".$year."-".$month."-01 00:00:00';"));
					echo '<div class="col-lg-3 col-md-6">
							 <div class="panel panel-'.$color[$i%4].'">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-users fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">'.$count.'</div>
											<div><b>Active Members <br /> '.$mons[$month-0].'/'.$year.'</b></div>
										</div>
									</div>
								</div>
							</div>
						</div>';
					$month++;
				}
				/* TO display new registration every month */
		echo '</div><!-- panel body -->
				</div>
			</div><!-- col-lg-12 -->
		</div>
		';
	}
	function LoadNewReg(){
		$count = 0;
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		echo '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h4>Total New Registration/Customers</h4>
					</div>
					<div class="panel-body">';
		//echo "HOST : ".S_DBHOST." - USERNAME : ".S_DBUSER." - PASS : ".S_DBPASS." - DB NAME : ".S_DBNAME_SLAVE;
		$link = MySQLconnect(S_DBHOST,S_DBUSER,S_DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(S_DBNAME_SLAVE,$link)) == 1){
				$limit = date('Y-m',strtotime('-3 months'));//direct calculating the month
				$temp = explode('-',$limit);
				$year = $temp[0];
				$month = $temp[1];
				$color=["primary","green","yellow","red"];
				/* TO display Active Members every month */
				for($i=0;$i<4;$i++){
					if($month == 13){
						$month = 1;
						$year++;
					}
					else{
						$month = $month+0;
					}
					$month = ($month < 10) ? "0".$month : $month;
					$count = mysql_num_rows(executeQuery("SELECT * FROM `customer` WHERE `date_of_join` BETWEEN '".$year."-".$month."-01 00:00:00' AND '".$year."-".$month."-31 00:00:00';"));
					echo '<div class="col-lg-3 col-md-6">
							 <div class="panel panel-'.$color[$i%4].'">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-rocket fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">'.$count.'</div>
											<div><b>Total New Registration <br /> '.$mons[$month-0].'/'.$year.'</b></div>
										</div>
									</div>
								</div>
							</div>
						</div>';
					$month++;
				}
				/* TO display new registration every month */
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		echo '</div><!-- panel body -->
				</div>
			</div><!-- col-lg-12 -->
		</div>
		';
	}
	function LoadTotalIncome(){
		$count = 0;
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		echo '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4>Total Income</h4>
					</div>
					<div class="panel-body">';
		$link = MySQLconnect(S_DBHOST,S_DBUSER,S_DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(S_DBNAME_SLAVE,$link)) == 1){
				$limit = date('Y-m',strtotime('-3 months'));//direct calculating the month
				$temp = explode('-',$limit);
				$year = $temp[0];
				$month = $temp[1];
				$color=["primary","green","yellow","red"];
				/* TO display Active Members every month */
				for($i=0;$i<4;$i++){
					$total = 0;
					if($month == 13){
						$month = 1;
						$year++;
					}
					else{
						$month = $month+0;
					}
					$month = ($month < 10) ? "0".$month : $month;
					$query ="SELECT `total_amount` FROM `money_transactions` WHERE `pay_date` BETWEEN '".$year."-".$month."-01 00:00:00' AND '".$year."-".$month."-31 00:00:00';";
					$res = executeQuery($query);
					$j=1;
						while($row = mysql_fetch_assoc($res)){
							$total = $total + $row['total_amount'];
							$j++;
						}
					echo '<div class="col-lg-3 col-md-6">
							 <div class="panel panel-'.$color[$i%4].'">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-inr fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">'.$total.'</div>
											<div><b>Total Income<br />(including due) <br /> '.$mons[$month-0].'/'.$year.'</b></div>
										</div>
									</div>
								</div>
							</div>
						</div>';
					$month++;
				}
				/* TO display new registration every month */
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		echo '</div><!-- panel body -->
				</div>
			</div><!-- col-lg-12 -->
		</div>
		';
	}
}
