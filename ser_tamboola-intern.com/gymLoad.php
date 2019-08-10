<?php
class PageLoad{
	protected $parameters = array();
	function __construct($para	=	false){
		$this->parameters=$para;	
	}	 
	function LoadGymNames(){
		$htm ='';
		$htm .= '<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h4>'.ucwords($_SESSION["USER_LOGIN_DATA"]["USER_NAME"]).'\'s Club</h4>
					</div>
					<div class="panel-body">';
	
				//$color=["primary","green","yellow","red"];
				// TO display Active Members every month 
				
				for($i=0;$i<=sizeof($_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"])-1;$i++)
				{
					$htm .= '<div class="col-lg-3 col-md-6">
							 <div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-users fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">'.$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]["GYM_NAME"].'</div>
										</div>
									</div>
								</div>
								<a href="javascript:void(0)" class="gymLink" id="'.$i.'" data-toggle="modal" data-target="#myGYMSelectModal_'.$i.'">
                            <div class="panel-footer gymlist_'.$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]["GYM_NAME"].'" id="'.$i.'">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>

                        </a>
							</div>
						</div>
						<div class="modal fade" id="myGYMSelectModal_'.$i.'" tabindex="-1" role="dialog" aria-labelledby="myGYMSelectModalLabel_'.$i.'" aria-hidden="true" style="display: none;">
							<div class="modal-dialog btn-primary">
								<div class="modal-content btn-primary">
									<div class="modal-header btn-primary">
										<lable class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></lable>
										<h4 class="modal-title" id="myGYMSelectModalLabel_'.$i.'">'.$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$i]["GYM_NAME"].' Selected</h4>
									</div>
								</div>
							</div>
						</div>
					';			
				}
		$htm .= '</div><!-- panel body -->
				</div>
			</div><!-- col-lg-12 -->
			</div>';
			$htm .= '<script>	
			$(document).ready(function(){
			
			var gymdynamic = {
				nav		: 	".gymLink",
				outdiv	:	"#printrs",
			};
			var obj=new load_dashboard();
			obj.selectGYM(gymdynamic);

		});
	</script>';
	
	$gymload = array(
		"htm" => (string)$htm,
	);
	
	echo json_encode($gymload);	
		
	}
	function setGYM($id){
		$_SESSION["SETGYM"]=array(
			"GYM_ID"			=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_ID"],
			"GYM_NAME"			=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_NAME"],
			"GYM_HOST"			=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_HOST"],
			"GYM_USERNAME"		=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_USERNAME"],
			"GYM_DB_NAME"		=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_DB_NAME"],
			"GYM_DB_PASSWORD"	=>	$_SESSION["USER_LOGIN_DATA"]["GYM_DETAILS"][$id]["GYM_DB_PASSWORD"],
		);
		echo $_SESSION["SETGYM"]["GYM_NAME"];
		exit(0);
	}
	function addfacility($factNm,$factST) {
	   $result=false;
	   $query='INSERT INTO `facility` (`id`, `name`, `status`) VALUES (NULL, "'.$factNm.'",'.$factST.');';
	   $result=executeQuery($query);
	   if($result){
         echo "success"; 	   
	   }
	   else{
        echo "unsuccess";	   
	   }
	   
	}
	function showhidefacility() {
	  $result = false;
      $i=0;
      $num=0;
		$query='SELECT ft.`id` AS fact_id,
		               ft.`name` AS fact_name   
		        FROM `facility` as ft,
		             `status` as st 
		        WHERE ft.`status`= st.`id` AND 
		              st.`statu_name`="Hide" AND st.`status`=1';
		$result=executeQuery($query);
		$num=mysql_num_rows($result);
		if($num != 0)
		 {
		while($row=mysql_fetch_assoc($result)){
          $i++;
          $v=$row["fact_id"];  
          //$_SESSION["facility"][$i]["name"]=ucwords($row["fact_name"]);
         // $_SESSION["facility"][$i]["id"]=$row["fact_id"];     	
       	echo '<div class="col-lg-3 col-md-6">
							 <div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3" id="allcust_'.$v.'">
											<i class="fa fa-users fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">'.ucwords($row["fact_name"]).'</div>
										</div>
									</div>
								</div>
								<a href="javascript:void(0)" class="gymLink" id="mainlist_'.$v.'" data-toggle="modal" data-target="#myFACTSelectModal_'.$v.'">
								 <div class="panel-footer" id="show_'.$v.'">
                                <span class="pull-left">Remove Deactivation</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
							</div>
						</div>';
				echo '<script>	
			$(document).ready(function(){
							
			var deactiveft = {
				outdiv2	:	"#show_'.$v.'",
				outdiv1	:	"'.$v.'",
			};
			var obj=new controlManageTwo();
			obj.hideshow(deactiveft);

		});
	</script>';		
			}
		}
		else{
          return false;		
		}	
	}
	function showhideft($id){
     $result=false;	  
	  $query='UPDATE `facility` SET status=(SELECT id FROM `status` WHERE statu_name="Show" and status=1) WHERE id='.$id.'';
	  $result=executeQuery($query);
      if($result)	  
	     echo 'success';
	}
	function getfacility($id){
		$result = false;
      $i=0;
		$query='SELECT ft.`id` AS fact_id,
		               ft.`name` AS fact_name   
		        FROM `facility` as ft,
		             `status` as st 
		        WHERE ft.`status`= st.`id` AND 
		              st.`statu_name`="Show" AND st.`status`=1';
		$result=executeQuery($query);
		while($row=mysql_fetch_assoc($result)){
          $i++;  
          $_SESSION["facility"][$i]["name"]=ucwords($row["fact_name"]);
          $_SESSION["facility"][$i]["id"]=$row["fact_id"];
          $fid=$row["fact_id"];     	
       	echo '<div class="col-lg-3 col-md-6">
							 <div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3" id="allfacility_'.$fid.'">
											<i class="fa fa-users fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">'.ucwords($row["fact_name"]).'</div>
										</div>
									</div>
								</div>
								<a href="javascript:void(0)" class="gymLink" id="listfactall_'.$fid.'" data-toggle="modal" data-target="#myFACTSelectModal_'.$fid.'">
							<div class="panel-footer" id="listfact_'.$fid.'">
                                <span class="pull-left">Deactivation</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
							</div>
						</div>';
                  //<div class="modal fade" id="myFACTSelectModal_'.$i.'" tabindex="-1" role="dialog" aria-labelledby="myFACTSelectModal__'.$i.'" aria-hidden="true" style="display: none;">
							//<div class="modal-dialog btn-primary">
								//<div class="modal-content btn-primary">
									//<div class="modal-header btn-primary">
										//<lable class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></lable>
										//<h4 class="modal-title" id="myFACTSelectModal_'.$i.'">'.$_SESSION["facility"][$i]["name"].' Selected</h4>
							      //</div>
								//</div>
							//</div>
						//</div>
			echo '<script>	
					$(document).ready(function(){
									
						var ft = {
							outdiv2		:	"#listfact_'.$fid.'",
							outdiv1		:	"'.$fid.'",
							factNm		:	"'.$_SESSION["facility"][$i]["name"].'",
						};
						var obj=new controlManageTwo();
						obj.dectivefacility(ft);

     				});
	     		</script>';				
					
		}
	
	}
	function getallfacility() {
       $result = false;
      $i=0;
		$query='SELECT ft.`id` AS fact_id,
		               ft.`name` AS fact_name   
		        FROM `facility` as ft,
		             `status` as st 
		        WHERE ft.`status`= st.`id` AND 
		              st.`statu_name`="Show" AND st.`status`=1';
		$result=executeQuery($query);
		echo '<option value="NULL">Select Facility</option>';
		while($row=mysql_fetch_assoc($result)){
         echo '<option value='.$row["fact_id"].' >'.ucwords($row["fact_name"]).'</option>';   	
	   }
	} 
	function getallduration() {
       $result = false;
       $query='SELECT ofd.`id` AS duration_id,
		               ofd.`duration` AS duration_name   
		        FROM `offerduration` as ofd,
		             `status` as st 
		        WHERE ofd.`status`= st.`id` AND 
		              st.`statu_name`="Show" AND st.`status`=1';
		$result=executeQuery($query);
		echo '<option value="NULL">Select Duration</option>';
		while($row=mysql_fetch_assoc($result)){
         echo '<option value='.$row["duration_id"].' >'.ucwords($row["duration_name"]).'</option>';   	
	   }
	}
	function deactivefacility($id){
	  $result=false;	  
	  $query='UPDATE `facility` SET status=(SELECT id FROM `status` WHERE statu_name="Hide" and status=1) WHERE id='.$id.'';
	  $result=executeQuery($query);
      if($result)	  
	     echo 'success';	
	  }
	function addnewoffer($data){
		  $result=false;	  
		  $status=4;
		  $query='INSERT INTO `offers` (`id`, `name`, `duration_id`, `num_of_days`, `facility_id`, `description`, `cost`, `min_members`, `status`) VALUES (NULL,"'.$data["name"].'",'.$data["duration"].','.$data["days"].','.$data["facility"].',"'.$data["description"].'",'.$data["prizing"].','.$data["member"].','.$status.') ';
		  $result=executeQuery($query);
		  if($result)	  
			 echo 'success';	
	   }
	public function loadSingleDash(){
		$activeMem = '';
		$newReg = '';
		$totIncome = '';
		$count = 0;
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		$activeMem .= '<div class="row">
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
				$color=["green","custom1","yellow","red"];
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
					$count = mysql_num_rows(executeQuery("SELECT  DISTINCT `customer_pk` FROM `fee` WHERE `valid_from` <= '".$year."-".$month."-31 00:00:00' AND `valid_till` >=  '".$year."-".$month."-01 00:00:00';"));
					$activeMem .= '<div class="col-lg-3 col-md-6">
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
		$activeMem .= '</div><!-- panel body -->
				</div>
			</div><!-- col-lg-12 -->
		</div>
		';
		
		$count = 0;
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		$newReg .= '<div class="row">
			<div class="col-lg-12">
				<div class="panel  panel-danger">
					<div class="panel-heading">
						<h4>Total New Registration/Customers</h4>
					</div>
					<div class="panel-body">';

				$limit = date('Y-m',strtotime('-3 months'));//direct calculating the month
				$temp = explode('-',$limit);
				$year = $temp[0];
				$month = $temp[1];
				$color=["green","custom1","yellow","red"];
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
					$newReg .= '<div class="col-lg-3 col-md-6">
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

		$newReg .= '</div><!-- panel body -->
				</div>
			</div><!-- col-lg-12 -->
		</div>
		';

		$count = 0;
		$mons = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
		$totIncome .= '<div class="row">
			<div class="col-lg-12">
				<div class="panel  panel-danger">
					<div class="panel-heading">
						<h4>Total Income</h4>
					</div>
					<div class="panel-body">';
	
				$limit = date('Y-m',strtotime('-3 months'));//direct calculating the month
				$temp = explode('-',$limit);
				$year = $temp[0];
				$month = $temp[1];
				$color=["green","custom1","yellow","red"];
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
					$totIncome .= '<div class="col-lg-3 col-md-6">
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
		$totIncome .= '</div><!-- panel body -->
				</div>
			</div><!-- col-lg-12 -->
		</div>
		';
		$data = array(
			"one" => $activeMem,
			"two" => $newReg,
			"thr" => $totIncome,
			"nm" => $this->parameters["GYMNAME"],
			
		);
		return $data;
	}
	
} 
?>
