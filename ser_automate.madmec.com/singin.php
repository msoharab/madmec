<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	$parameters = array(
		"autoloader" 	=> isset($_POST["autoloader"]) 											? $_POST["autoloader"] 	: false,
		"action" 	 	=> isset($_POST["action"]) 												? $_POST["action"]		: false,
		"user_name"		=> (isset($_POST["user_name"]) && validateUserName($_POST["user_name"]))? $_POST["user_name"] 	: false,
		"password"		=> (isset($_POST["password"]) && validatePassword($_POST["password"])) 	? $_POST["password"] 	: false,
		"browser"		=> isset($_POST["browser"])												? $_POST["browser"] 	: false
	);
	unset($_POST);
	function main($parameters){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				$flag = ValidateAdmin();
				if($flag){
					echo "login";
				}
				else if(!$flag){
					switch($parameters["action"]){
						case "signIn":
							$userdata = userLogin($parameters);
							echo $userdata["STATUS"];
						break;
					}
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		exit(0);
	}
	function userLogin($parameters){
		$userdata = array(
			"USER_EMAIL" 	=> NULL,
			"USER_PASS" 	=> NULL,
			"USER_ID" 	=> NULL,
			"USER_NAME" 	=> NULL,
			"USER_PHOTO" 	=> NULL,
                        "user_type_id"  => NULL,
                        "slavedb"       => NULL,
                        "USER_DIRECTORY" => NULL,
			"STATUS" 	=> 'error'
		);
		$query = 'SELECT a.*,
					   CASE WHEN p.`ver2` IS NULL
							THEN \''.USER_ANON_IMAGE.'\'
							ELSE CONCAT(\''.URL.ASSET_DIR.'\',p.`ver2`)
					   END AS photo,
                                CASE WHEN  a.`user_type_id`=10
                                THEN 10
                                ELSE
                                DATEDIFF(v.expiry_date,CURRENT_DATE)  END AS expiry_date
				FROM `user_profile` AS a
				LEFT JOIN `photo` AS p
                                ON p.`id` = a.`photo_id`
                                LEFT JOIN `validity` v
                                ON v.`user_pk`=a.`id`
				WHERE a.`user_name`=\''.mysql_real_escape_string($parameters["user_name"]).'\'
				AND a.`password`=\''.mysql_real_escape_string($parameters["password"]).'\';';
		$res = executeQuery($query);
		if(get_resource_type($res) == 'mysql result'){
			if(mysql_num_rows($res) > 0){
				$row = mysql_fetch_assoc($res);
				// echo '<br />'.print_r($row);
				if( $row["user_name"] 	== $parameters["user_name"] &&
					$row["password"] 	== $parameters["password"]
				){

                                        if($row['expiry_date']<0)
                                        {
                                           $userdata = array(
						"USER_EMAIL" 	=> NULL,
						"USER_PASS" 	=> $parameters["password"],
						"USER_ID" 	=> NULL,
						"USER_NAME" 	=> $parameters["user_name"],
						"USER_PHOTO" 	=> USER_ANON_IMAGE,
                                                "user_type_id"  => NULL,
                                                "slavedb"       => NULL,
                                                "USER_DIRECTORY" => NULL,
                                               "validity"      => NULL,
						"STATUS" 	=> 'expired'
					);
					$_SESSION["IOS"] = array(
						"id" => $row["id"],
						"name" => $row["user_name"],
						"email" => $row["email"],
						"photo" => $row["photo"]
					);
                                        }
                                        else
                                        {
					$userdata = array(
						"USER_EMAIL" 	=> $row["email"],
						"USER_PASS" 	=> $row["password"],
						"USER_ID" 	=> $row["id"],
						"USER_NAME" 	=> $row["user_name"],
						"USER_PHOTO" 	=> $row["photo"],
                                                "user_type_id"  => $row['user_type_id'],
                                                "slavedb"       => $row['db_name'],
                                                "USER_DIRECTORY" => $row['directory'],
                                                "validity"      => $row['expiry_date'],
						"STATUS" 	=> 'success'
                                            );
						$_SESSION["IOS"] = array(
							"id" => 0,
							"name" => 'AutoMate',
							"email" => '',
							"photo" => USER_ANON_IMAGE
						);
                                        }
					updateUserlog($parameters,$row["id"]);
                                        if($userdata['user_type_id']==9)
                                        {
                                         $billingquery='SELECT * FROM '.$userdata['slavedb'].'.billing_details';
                                        $billingres=  executeQuery($billingquery);
                                        if(mysql_num_rows($billingres))
                                        {
                                            $billrow=  mysql_fetch_assoc($billingres);
                                            if($billrow["billlogo"]=="" || $billrow["billlogo"]==NULL)
                                                $billpath=BILL_LOGO;
                                            else
                                                 $billpath=$billrow["billlogo"];
                                            $_SESSION['BillingDetails']=array(
                                                "BILL_LOGO" =>$billpath,
                                                "COMPANAY_NAME" =>$billrow["companyname"],
                                                "COMPANY_ADDRESS" => $billrow["address"],
                                                "COMPANY_LANDLINE" => $billrow["landline"],
                                                "COMPANY_EMAIl"  => $billrow["email"],
                                                "COMPANY_MOBILE"  => $billrow["mobile"],
                                                "COMPANY_TC"  => $billrow["termsncondition"],
                                                "COMPANY_FM"  => $billrow["footermessage"],
                                                );
                                        }
                                        else
                                        {
                                           $_SESSION['BillingDetails']=array(
                                                "BILL_LOGO" =>BILL_LOGO,
                                                "COMPANAY_NAME" =>NULL,
                                                "COMPANY_ADDRESS" => NULL,
                                                "COMPANY_LANDLINE" => NULL,
                                                "COMPANY_EMAIl"  => NULL,
                                                "COMPANY_MOBILE"  => NULL,
                                                "COMPANY_TC"  => NULL,
                                                "COMPANY_FM"  => NULL,
                                                );
                                        }
                                        }

				}
				else if($row["user_name"] == $parameters["user_name"] &&
					$row["password"] != $parameters["password"]){
					$userdata = array(
						"USER_EMAIL" 	=> NULL,
						"USER_PASS" 	=> $parameters["password"],
						"USER_ID" 		=> NULL,
						"USER_NAME" 	=> $parameters["user_name"],
						"USER_PHOTO" 	=> USER_ANON_IMAGE,
                                                "user_type_id"  => NULL,
                                                "slavedb"       => NULL,
                                                "USER_DIRECTORY" => NULL,
						"STATUS" 	=> 'password'
					);
				}
			}
		}
		$_SESSION["USER_LOGIN_DATA"] = $userdata;
		return $userdata;
	}
	function updateUserlog($parameters,$id){
		$curr_time = mysql_result(executeQuery("SELECT NOW();"),0);
		$query = 'INSERT INTO `user_logs` (`id`,
					`ip`,
					`host`,
					`city`,
					`zipcode`,
					`province`,
					`province_code`,
					`country`,
					`country_code`,
					`latitude`,
					`longitude`,
					`timezone`,
					`organization`,
					`isp`,
					`browser`,
					`user_pk`,
					`in_time`)  VALUES(
				NULL,
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["query"]).'\',
				\''.mysql_real_escape_string($_SERVER["SERVER_ADDR"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["city"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["zip"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["regionName"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["region"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["country"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["countryCode"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["lat"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["lon"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["timezone"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["org"].'♥♥♥'.$_SESSION["IP_INFO"]["as"].'♥♥♥'.$_SESSION["IP_INFO"]["isp"]).'\',
				\''.mysql_real_escape_string($_SESSION["IP_INFO"]["isp"]).'\',
				\''.mysql_real_escape_string($parameters["browser"]).'\',
				\''.mysql_real_escape_string($id).'\',
				default);';
		executeQuery($query);
	}
	if(isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true'){
		global $parameters;
		main($parameters);
	}
?>