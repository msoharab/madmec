<?php
	class user{
		private $order   = array("\r\n", "\n", "\r", "\t");
		private $replace = '';
		protected $parameters = array();
		function __construct($para = false) {
			$this->parameters = $para;
		}
		public function addUser(){
			$user_pk = 0;
			$product_pk = 0;
			$flag = false;
			// echo $this->parameters;
			// echo print_r($this->parameters);
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$curr_time = mysql_result(executeQuery("SELECT NOW();"),0);
			$pass = md5($this->parameters["password"]);
			/* Photo */
			$query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
					NULL,NULL,NULL,NULL,NULL,NULL);';
			if(executeQuery($query)){
				/* Profile */
				$query = 'INSERT INTO  `user_profile` (`id`,
							`user_name`,
							`acs_id`,
							`photo_id`,
							`password`,
							`apassword`,
							`passwordreset`,
							`authenticatkey`,
							`postal_code`,
							`telephone`,
							`dob`,
							`gender`,
							`date_of_join`,
							`user_type_id`,
							`status_id`,
							`addressline`,
							`town`,
							`city`,
							`district`,
							`province`,
							`province_code`,
							`country`,
							`country_code`,
							`zipcode`,
							`website`,
							`latitude`,
							`longitude`,
							`timezone`,
							`gmaphtml` )  VALUES(
						NULL,
						\''.mysql_real_escape_string($this->parameters["name"]).'\',
						\''.mysql_real_escape_string($this->parameters["acs"]).'\',
						LAST_INSERT_ID(),
						\''.mysql_real_escape_string($this->parameters["password"]).'\',
						\''.mysql_real_escape_string($pass).'\',
						NULL,
						NULL,
						\''.mysql_real_escape_string($this->parameters["pcode"]).'\',
						\''.mysql_real_escape_string($this->parameters["tphone"]).'\',
						\''.mysql_real_escape_string(date('Y-m-d')).'\',
						3,
						default,
						\''.mysql_real_escape_string($this->parameters["user_type"]).'\',
						1,
						\''.mysql_real_escape_string($this->parameters["addrsline"]).'\',
						\''.mysql_real_escape_string($this->parameters["st_loc"]).'\',
						\''.mysql_real_escape_string($this->parameters["city_town"]).'\',
						\''.mysql_real_escape_string($this->parameters["district"]).'\',
						\''.mysql_real_escape_string($this->parameters["province"]).'\',
						\''.mysql_real_escape_string($this->parameters["provinceCode"]).'\',
						\''.mysql_real_escape_string($this->parameters["country"]).'\',
						\''.mysql_real_escape_string($this->parameters["countryCode"]).'\',
						\''.mysql_real_escape_string($this->parameters["zipcode"]).'\',
						\''.mysql_real_escape_string($this->parameters["website"]).'\',
						\''.mysql_real_escape_string($this->parameters["lat"]).'\',
						\''.mysql_real_escape_string($this->parameters["lon"]).'\',
						\''.mysql_real_escape_string($this->parameters["timezone"]).'\',
						\''.mysql_real_escape_string($this->parameters["gmaphtml"]).'\');';
				if(executeQuery($query)){
					$user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
					/* Company Representative names*/
				    if(is_array($this->parameters["crname"]) && sizeof($this->parameters["crname"]) > -1){
						$query = 'INSERT INTO  `user_name` (`id`,`user_pk`,`name`,`status_id` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["crname"]);$i++){
							if($i == sizeof($this->parameters["crname"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["crname"][$i]).'\',4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["crname"][$i]).'\',4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `crname`= \''.mysql_real_escape_string($this->parameters["crname"][0]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
                                            /* Pan*/
				    if(is_array($this->parameters["pan"]) && sizeof($this->parameters["pan"]) > -1){
						$query = 'INSERT INTO  `code_pan` (`id`,`user_pk`,`pan`,`status_id` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["pan"]);$i++){
							if($i == sizeof($this->parameters["pan"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["pan"][$i]).'\',4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["pan"][$i]).'\',4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `pan`= \''.mysql_real_escape_string($this->parameters["pan"][0]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
//                                        STC
                                    if(is_array($this->parameters["svt"]) && sizeof($this->parameters["svt"]) > -1){
						$query = 'INSERT INTO  `code_stc` (`id`,`user_pk`,`stc`,`status_id` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["svt"]);$i++){
							if($i == sizeof($this->parameters["svt"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["svt"][$i]).'\',4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["svt"][$i]).'\',4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `stc`= \''.mysql_real_escape_string($this->parameters["svt"][0]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
//                                          TIN
                                    if(is_array($this->parameters["tin"]) && sizeof($this->parameters["tin"]) > -1){
						$query = 'INSERT INTO  `code_tin` (`id`,`user_pk`,`tin`,`status_id` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["tin"]);$i++){
							if($i == sizeof($this->parameters["tin"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["tin"][$i]).'\',4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["tin"][$i]).'\',4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `tin`= \''.mysql_real_escape_string($this->parameters["tin"][0]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
					/* emails */
					if(is_array($this->parameters["email"]) && sizeof($this->parameters["email"]) > -1){
						$query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status_id` ) VALUES';
						for($i=0;$i<sizeof($this->parameters["email"]);$i++){
							if($i == sizeof($this->parameters["email"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["email"][$i]).'\',4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["email"][$i]).'\',4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `email`= \''.mysql_real_escape_string($this->parameters["email"][0]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
					/* cell_numbers */
					if(is_array($this->parameters["cellnumbers"]) && sizeof($this->parameters["cellnumbers"]) > -1){
						$query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_code`,`cell_number`,`status_id`) VALUES';
						for($i=0;$i<sizeof($this->parameters["cellnumbers"]);$i++){
							if($i == sizeof($this->parameters["cellnumbers"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]).'\',
										4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]).'\',
										\''.mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]).'\',
										4),';
						}
						executeQuery($query);
						executeQuery('UPDATE `user_profile` SET `cell_code`= \''.mysql_real_escape_string($this->parameters["cellnumbers"][0]["codep"]).'\',
											`cell_number`= \''.mysql_real_escape_string($this->parameters["cellnumbers"][0]["nump"]).'\'
										WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
					}
					/* Bank accounts */
					if(is_array($this->parameters["accounts"]) && sizeof($this->parameters["accounts"]) > -1){
						$query = 'INSERT INTO  `bank_accounts` (`id`,`user_pk`,`bank_name`,`ac_no`,`branch`,`branch_code`,`IFSC`,`status_id`)  VALUES';
						for($i=0;$i<sizeof($this->parameters["accounts"]);$i++){
							if($i == sizeof($this->parameters["accounts"])-1)
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["bankname"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["accno"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["braname"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["bracode"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["IFSC"]).'\',
										4);';
							else
								$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["bankname"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["accno"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["braname"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["bracode"]).'\',
										\''.mysql_real_escape_string($this->parameters["accounts"][$i]["IFSC"]).'\',
										4),';
						}
						executeQuery($query);
					}
					/* Products */
					if(is_array($this->parameters["products"]) && sizeof($this->parameters["products"]) > -1){
						/* Photo */
						$directory_prod = array();
						$product_pk = array();
						for($i=0;$i<sizeof($this->parameters["products"]);$i++){
							$query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
									NULL,NULL,NULL,NULL,NULL,NULL);';
							executeQuery($query);
							$photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
							$query = 'INSERT INTO  `product` (`id`,`name`,`photo_id`,`doc`,`status_id`,`user_pk`) VALUES (NULL,
										\''.mysql_real_escape_string($this->parameters["products"][$i]).'\',
										\''.mysql_real_escape_string($photo_pk).'\',
										default,
										4,\''.mysql_real_escape_string($user_pk).'\');';
							executeQuery($query);
							$product_pk[$i] = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
							$directory_prod[$i] = substr(md5(microtime()),0,6).'_product_'.$product_pk[$i];
							/* Assign product to user */
//							$query = 'INSERT INTO  `user_product` (`id`,`product_id`,`user_pk`,`status_id`) VALUES (NULL,
//									\''.mysql_real_escape_string($product_pk[$i]).'\',
//									\''.mysql_real_escape_string($user_pk).'\',
//									4);';
//							executeQuery($query);
						}
						for($i=0;$i<sizeof($this->parameters["products"]);$i++){
							createdirectories($directory_prod[$i]);
							executeQuery('UPDATE `product` SET `directory` = \''.ASSET_DIR.$directory_prod[$i].'\' WHERE `id`=\''.mysql_real_escape_string($product_pk[$i]).'\';');
						}
					}
					$directory_user = createdirectories(substr(md5(microtime()),0,6).'_user_'.$user_pk);
					executeQuery('UPDATE `user_profile` SET `directory` = \''.$directory_user.'\' WHERE `id`=\''.mysql_real_escape_string($user_pk).'\';');
					$flag = true;
				}
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function searchUser() {
		}
                public function fetchDesigner() {
                    $designer=array();
                    $data='';
                    $query="SELECT `user_name`,`id` FROM `user_profile` WHERE user_type_id='2' AND status_id='1'";
                    $result=executeQuery($query);
                    if(mysql_num_rows($result))
                    {
                        while($row=  mysql_fetch_assoc($result))
                        {
                            $designer[]=$row;
                        }
                        for($i=0;$i<sizeof($designer);$i++)
                        {
                            $data .='<option value="'.$designer[$i]['id'].'">'.$designer[$i]['user_name'].'</option>';
                        }
                    }
                    return $data;
                }
		public function listUser() {
			$users = array();
			$utype = (isset($para["utype"]) && !empty($para["utype"]))  ? ' AND f.`user_type` LIKE "%'.$para["utype"].'%"' : '';
			$uid = (isset($para["uid"]) && !empty($para["uid"])) ? ' AND a.`id` = "'.$para["uid"].'"'  : '';
			executeQuery('SET SESSION group_concat_max_len = 1000000;');
			$query = 'SELECT
						a.`id` AS usrid,
						a.`user_name`,
						a.`acs_id`,
						a.`directory`,
						a.`password`,
						CASE WHEN (a.`addressline` IS NULL OR a.`addressline` = "" )
							 THEN "Not provided"
							 ELSE a.`addressline`
						END AS addressline,
						CASE WHEN (a.`town` IS NULL OR a.`town` = "" )
							 THEN "Not provided"
							 ELSE a.`town`
						END AS town,
						CASE WHEN (a.`city` IS NULL OR a.`city` = "" )
							 THEN "Not provided"
							 ELSE a.`city`
						END AS city,
						CASE WHEN (a.`district` IS NULL OR a.`district` = "" )
							 THEN "Not provided"
							 ELSE a.`district`
						END AS district,
						CASE WHEN (a.`province` IS NULL OR a.`province` = "" )
							 THEN "Not provided"
							 ELSE a.`province`
						END AS province,
						CASE WHEN (a.`province_code` IS NULL OR a.`province_code` = "" )
							 THEN NULL
							 ELSE a.`province_code`
						END AS province_code,
						CASE WHEN (a.`country` IS NULL OR a.`country` = "" )
							 THEN "Not provided"
							 ELSE a.`country`
						END AS country,
						CASE WHEN (a.`country_code` IS NULL OR a.`country_code` = "" )
							 THEN NULL
							 ELSE a.`country_code`
						END AS country_code,
						CASE WHEN (a.`zipcode` IS NULL OR a.`zipcode` = "" )
							 THEN "Not provided"
							 ELSE a.`zipcode`
						END AS zipcode,
						CASE WHEN (a.`website` IS NULL OR a.`website` = "" )
							 THEN "http://"
							 ELSE a.`website`
						END AS website,
						CASE WHEN (a.`gmaphtml` IS NULL OR a.`gmaphtml` = "" )
							 THEN "http://"
							 ELSE a.`gmaphtml`
						END AS gmaphtml,
						/*
							CONCAT(
								CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
									 THEN "---"
									 ELSE a.`postal_code`
								END,
								CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
									 THEN "Not provided"
									 ELSE a.`telephone`
								END
							) AS tnumber,
						*/
						CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
							 THEN "---"
							 ELSE a.`postal_code`
						END  AS pcode,
						CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
							 THEN "Not provided"
							 ELSE a.`telephone`
						END AS tnumber,
						CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
							 THEN "'.USER_ANON_IMAGE .'"
							 ELSE CONCAT("'.URL.ASSET_DIR.'",ph.`ver2`)
						END AS usrphoto,
						a.`status_id`,
						b.`email_pk`  AS email_pk,
						b.`email` AS email,
						c.`cnumber_pk` AS cnumber_pk,
						c.`cnumber` AS cnumber,
						d.`bank_pk` AS bank_pk,
						d.`bank_name` AS bank_name,
						d.`ac_no` AS ac_no,
						d.`branch` AS branch,
						d.`branch_code` AS branch_code,
						d.`IFSC` AS IFSC,
						e.`prd_pk` AS prd_pk,
						e.`name` AS prdname,
						e.`prdphoto` AS prdphoto,
						f.`user_type`,
						g.`gender_name`,
						h.*,
						/* Incomming */
						i.`incid`,
						i.`colldate`,
						i.`incamt`,
						i.`incrmk`,
						i.`incmop`,
						i.`incbname`,
						i.`incbacno`,
						i.`incbranch`,
						i.`incifsc`,
						/* Outgoing */
						j.`outid`,
						j.`paydate`,
						j.`outamt`,
						j.`outrmk`,
						j.`outmop`,
						j.`outbname`,
						j.`outbacno`,
						j.`outbranch`,
						j.`outbrcode`,
						j.`outifsc`,
						ljpan.`pan_pk`,
						ljpan.`pan`,
						ljstc.`stc_pk`,
						ljstc.`stc`,
						ljtin.`tin_pk`,
						ljtin.`tin`,
                                                ljcrn.`crn`,
                                                ljcrn.`crn_pk`
					FROM `user_profile` AS a
					LEFT JOIN `photo` AS ph ON a.`photo_id` = ph.`id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(em.`id`,"☻☻♥♥☻☻") AS email_pk,
							GROUP_CONCAT(em.`email`,"☻☻♥♥☻☻") AS email,
							em.`user_pk`
						FROM `email_ids` AS em
						WHERE em.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (em.`user_pk`)
						ORDER BY (em.`user_pk`)
					)  AS b ON a.`id` = b.`user_pk`
                                        LEFT JOIN (
						SELECT
							GROUP_CONCAT(pn.`id`,"☻☻♥♥☻☻") AS pan_pk,
							GROUP_CONCAT(pn.`pan`,"☻☻♥♥☻☻") AS pan,
							pn.`user_pk`
						FROM `code_pan` AS pn
						WHERE pn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (pn.`user_pk`)
						ORDER BY (pn.`user_pk`)
					)  AS ljpan ON a.`id` = ljpan.`user_pk`
                                        LEFT JOIN (
						SELECT
							GROUP_CONCAT(st.`id`,"☻☻♥♥☻☻") AS stc_pk,
							GROUP_CONCAT(st.`stc`,"☻☻♥♥☻☻") AS stc,
							st.`user_pk`
						FROM `code_stc` AS st
						WHERE st.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (st.`user_pk`)
						ORDER BY (st.`user_pk`)
					)  AS ljstc ON a.`id` = ljstc.`user_pk`
                                        LEFT JOIN (
						SELECT
							GROUP_CONCAT(tn.`id`,"☻☻♥♥☻☻") AS tin_pk,
							GROUP_CONCAT(tn.`tin`,"☻☻♥♥☻☻") AS tin,
							tn.`user_pk`
						FROM `code_tin` AS tn
						WHERE tn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (tn.`user_pk`)
						ORDER BY (tn.`user_pk`)
					)  AS ljtin ON a.`id` = ljtin.`user_pk`
                                        LEFT JOIN (
						SELECT
							GROUP_CONCAT(cr.`id`,"☻☻♥♥☻☻") AS crn_pk,
							GROUP_CONCAT(cr.`name`,"☻☻♥♥☻☻") AS crn,
							cr.`user_pk`
						FROM `user_name` AS cr
						WHERE cr.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (cr.`user_pk`)
						ORDER BY (cr.`user_pk`)
					)  AS ljcrn ON a.`id` = ljcrn.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(cn.`id`,"☻☻♥♥☻☻") AS cnumber_pk,
							cn.`user_pk`,
							/* GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`),"☻☻♥♥☻☻") AS cnumber */
							GROUP_CONCAT(cn.`cell_number`,"☻☻♥♥☻☻") AS cnumber
						FROM `cell_numbers` AS cn
						WHERE cn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (cn.`user_pk`)
						ORDER BY (cn.`user_pk`)
					) AS c ON a.`id` = c.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(ba.`id`,"☻☻♥♥☻☻") AS bank_pk,
							ba.`user_pk`,
							GROUP_CONCAT(ba.`bank_name`,"☻☻♥♥☻☻") AS bank_name,
							GROUP_CONCAT(ba.`ac_no`,"☻☻♥♥☻☻") AS ac_no,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch`
								END,"☻☻♥♥☻☻"
							) AS branch,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch_code`
								END,"☻☻♥♥☻☻"
							) AS branch_code,
							GROUP_CONCAT(
								CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
									 THEN "Not provided"
									 ELSE ba.`IFSC`
								END,"☻☻♥♥☻☻"
							) AS IFSC,
							ba.`status_id`
						FROM `bank_accounts` AS ba
						WHERE ba.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (ba.`user_pk`)
						ORDER BY (ba.`user_pk`)
					) AS d ON a.`id` = d.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(prd.`id`,"☻☻♥♥☻☻") AS prd_pk,
							GROUP_CONCAT(prd.`name`,"☻☻♥♥☻☻") AS NAME,
							/*
								GROUP_CONCAT(
									CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
										 THEN "VEGIE_IMAGE"
										 ELSE CONCAT("URL.ASSET_DIR",ph.`ver2`)
									END,"☻☻♥♥☻☻"
								) AS prdphoto,
							*/
							GROUP_CONCAT("","☻☻♥♥☻☻") AS prdphoto,
							prd.`user_pk`
						FROM `product` AS prd
						LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
						WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (prd.`user_pk`)
						ORDER BY (prd.`user_pk`)
					) AS e ON a.`id` = e.`user_pk`
					LEFT JOIN (
						SELECT
							utype.`id` AS type_id,
							utype.`user_type`
						FROM `user_type` AS utype
						WHERE utype.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
					) AS f ON a.`user_type_id` = f.`type_id`
					LEFT JOIN `gender` AS g ON a.`gender` = g.`id`
					LEFT JOIN (
						SELECT
							IF(COUNT(uname.`id`) > 0,COUNT(uname.`id`),0) AS rep_count,
							GROUP_CONCAT(uname.`id`,"☻♥☻") AS rep_id,
							GROUP_CONCAT(uname.`name`,"☻♥☻") AS representative,
							uname.user_pk
						FROM `user_name` AS uname
						WHERE uname.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (uname.`user_pk`)
						ORDER BY (uname.`user_pk`)
					) AS h ON a.`id` = h.`user_pk`
					LEFT JOIN (
						SELECT
							inc.`from_pk`,
							GROUP_CONCAT(inc.`id`,"☻☻♥♥☻☻") AS incid,
							GROUP_CONCAT(DATE_FORMAT(inc.`arrival`,"%Y-%c-%d"),"☻☻♥♥☻☻") AS colldate,
							GROUP_CONCAT(inc.`amount`,"☻☻♥♥☻☻") AS incamt,
							GROUP_CONCAT(inc.`remark`,"☻☻♥♥☻☻") AS incrmk,
							GROUP_CONCAT(m.`mop`,"☻☻♥♥☻☻") AS incmop,
							GROUP_CONCAT(ba.`bank_name`,"☻☻♥♥☻☻") AS incbname,
							GROUP_CONCAT(ba.`ac_no`,"☻☻♥♥☻☻") AS incbacno,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch`
								END,"☻☻♥♥☻☻"
							) AS incbranch,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch_code`
								END,"☻☻♥♥☻☻"
							) AS incbrcode,
							GROUP_CONCAT(
								CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
									 THEN "Not provided"
									 ELSE ba.`IFSC`
								END,"☻☻♥♥☻☻"
							) AS incifsc
						FROM `incomming` AS inc
						LEFT JOIN `bank_accounts` AS ba ON ba.`id` = inc.`bank_acc_id`
						LEFT JOIN `mode_of_payment` AS m ON m.`id` = inc.`mop`
						WHERE inc.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (inc.`from_pk`)
						ORDER BY (inc.`from_pk`)
					) AS i ON a.`id` = i.`from_pk`
					LEFT JOIN (
						SELECT
							ou.`to_pk`,
							GROUP_CONCAT(ou.`id`,"☻☻♥♥☻☻") AS outid,
							GROUP_CONCAT(DATE_FORMAT(ou.`departure`,"%Y-%c-%d"),"☻☻♥♥☻☻") AS paydate,
							GROUP_CONCAT(ou.`amount`,"☻☻♥♥☻☻") AS outamt,
							GROUP_CONCAT(ou.`remark`,"☻☻♥♥☻☻") AS outrmk,
							GROUP_CONCAT(m.`mop`,"☻☻♥♥☻☻") AS outmop,
							GROUP_CONCAT(ba.`bank_name`,"☻☻♥♥☻☻") AS outbname,
							GROUP_CONCAT(ba.`ac_no`,"☻☻♥♥☻☻") AS outbacno,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch`
								END,"☻☻♥♥☻☻"
							) AS outbranch,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch_code`
								END,"☻☻♥♥☻☻"
							) AS outbrcode,
							GROUP_CONCAT(
								CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
									 THEN "Not provided"
									 ELSE ba.`IFSC`
								END,"☻☻♥♥☻☻"
							) AS outifsc
						FROM `outgoing` AS ou
						LEFT JOIN `bank_accounts` AS ba ON ba.`id` = ou.`bank_acc_id`
						LEFT JOIN `mode_of_payment` AS m ON m.`id` = ou.`mop`
						WHERE ou.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (ou.`to_pk`)
						ORDER BY (ou.`to_pk`)
					) AS j ON a.`id` = j.`to_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(pan.`id`,"☻☻♥♥☻☻") AS pan_pk,
							GROUP_CONCAT(pan.`pan`,"☻☻♥♥☻☻") AS pan,
							pan.`user_pk`
						FROM `code_pan` AS pan
						WHERE pan.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (pan.`user_pk`)
						ORDER BY (pan.`user_pk`)
					)  AS k ON a.`id` = k.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(stc.`id`,"☻☻♥♥☻☻") AS stc_pk,
							GROUP_CONCAT(stc.`stc`,"☻☻♥♥☻☻") AS stc,
							stc.`user_pk`
						FROM `code_stc` AS stc
						WHERE stc.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (stc.`user_pk`)
						ORDER BY (stc.`user_pk`)
					)  AS l ON a.`id` = l.`user_pk`
					WHERE f.`type_id` !=  9 
					AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
					ORDER BY (f.`user_type`);';
			$res = executeQuery($query);
			if(mysql_num_rows($res) > 0){
				while($row = mysql_fetch_assoc($res)){
					$users[] = $row;
				}
			}
			$total = sizeof($users);
			if($total){
				for($i=0;$i<$total;$i++){
					$users[$i]["email_pk"] = explode("☻☻♥♥☻☻",$users[$i]["email_pk"]);
					$users[$i]["email"] = explode("☻☻♥♥☻☻",$users[$i]["email"]);
                                        $users[$i]["pan_pk"] = explode("☻☻♥♥☻☻",$users[$i]["pan_pk"]);
					$users[$i]["pan"] = explode("☻☻♥♥☻☻",$users[$i]["pan"]);
                                        $users[$i]["stc_pk"] = explode("☻☻♥♥☻☻",$users[$i]["stc_pk"]);
					$users[$i]["stc"] = explode("☻☻♥♥☻☻",$users[$i]["stc"]);
                                        $users[$i]["tin_pk"] = explode("☻☻♥♥☻☻",$users[$i]["tin_pk"]);
					$users[$i]["tin"] = explode("☻☻♥♥☻☻",$users[$i]["tin"]);
                                        $users[$i]["crn_pk"] = explode("☻☻♥♥☻☻",$users[$i]["crn_pk"]);
					$users[$i]["crn"] = explode("☻☻♥♥☻☻",$users[$i]["crn"]);
					$users[$i]["cnumber_pk"] = explode("☻☻♥♥☻☻",$users[$i]["cnumber_pk"]);
					$users[$i]["cnumber"] = explode("☻☻♥♥☻☻",$users[$i]["cnumber"]);
					$users[$i]["bank_pk"] = explode("☻☻♥♥☻☻",$users[$i]["bank_pk"]);
					$users[$i]["bank_name"] = explode("☻☻♥♥☻☻",$users[$i]["bank_name"]);
					$users[$i]["ac_no"] = explode("☻☻♥♥☻☻",$users[$i]["ac_no"]);
					$users[$i]["branch"] = explode("☻☻♥♥☻☻",$users[$i]["branch"]);
					$users[$i]["branch_code"] = explode("☻☻♥♥☻☻",$users[$i]["branch_code"]);
					$users[$i]["IFSC"] = explode("☻☻♥♥☻☻",$users[$i]["IFSC"]);
					$users[$i]["prd_pk"] = explode("☻☻♥♥☻☻",$users[$i]["prd_pk"]);
					$users[$i]["prdname"] = explode("☻☻♥♥☻☻",$users[$i]["prdname"]);
					$users[$i]["prdphoto"] = explode("☻☻♥♥☻☻",$users[$i]["prdphoto"]);
					/* Incomming */
					$users[$i]["incid"] = explode("☻☻♥♥☻☻",$users[$i]["incid"]);
					$users[$i]["colldate"] = explode("☻☻♥♥☻☻",$users[$i]["colldate"]);
					$users[$i]["incamt"] = explode("☻☻♥♥☻☻",$users[$i]["incamt"]);
					$users[$i]["incrmk"] = explode("☻☻♥♥☻☻",$users[$i]["incrmk"]);
					$users[$i]["incmop"] = explode("☻☻♥♥☻☻",$users[$i]["incmop"]);
					$users[$i]["incbname"] = explode("☻☻♥♥☻☻",$users[$i]["incbname"]);
					$users[$i]["incbacno"] = explode("☻☻♥♥☻☻",$users[$i]["incbacno"]);
					$users[$i]["incbranch"] = explode("☻☻♥♥☻☻",$users[$i]["incbranch"]);
					$users[$i]["incifsc"] = explode("☻☻♥♥☻☻",$users[$i]["incifsc"]);
					/* Outgoing */
					$users[$i]["outid"] = explode("☻☻♥♥☻☻",$users[$i]["outid"]);
					$users[$i]["paydate"] = explode("☻☻♥♥☻☻",$users[$i]["paydate"]);
					$users[$i]["outamt"] = explode("☻☻♥♥☻☻",$users[$i]["outamt"]);
					$users[$i]["outrmk"] = explode("☻☻♥♥☻☻",$users[$i]["outrmk"]);
					$users[$i]["outmop"] = explode("☻☻♥♥☻☻",$users[$i]["outmop"]);
					$users[$i]["outbname"] = explode("☻☻♥♥☻☻",$users[$i]["outbname"]);
					$users[$i]["outbacno"] = explode("☻☻♥♥☻☻",$users[$i]["outbacno"]);
					$users[$i]["outbranch"] = explode("☻☻♥♥☻☻",$users[$i]["outbranch"]);
					$users[$i]["outbrcode"] = explode("☻☻♥♥☻☻",$users[$i]["outbrcode"]);
					$users[$i]["outifsc"] = explode("☻☻♥♥☻☻",$users[$i]["outifsc"]);
				}
				$_SESSION["listofusers"] = $users;
			}
			else{
				$_SESSION["listofusers"] = NULL;
			}
			return $_SESSION["listofusers"];
		}
		public function displayUserList($para = false) {
			$this->parameters = $para;
			$users = array();
			$listusers = array(
				"html"			=> '<strong class="text-danger">There are no users available !!!!</strong>',
				"uid"			=> 0,
				"sr"			=> '',
				"alertUSRDEL"	=> '',
				"usrdelOk" 		=> '',
				"usrdelCancel" 	=> ''
			);
			$num_posts = 0;
			if(isset($_SESSION['listofusers']) && $_SESSION['listofusers'] != NULL)
				$users = $_SESSION['listofusers'];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			if($num_posts > 0){
				$listusers = array();
				//for($i=$this->parameters["initial"];$i<$this->parameters["final"] && $i < $num_posts && isset($users[$i]['usrid']);$i++){
                                    for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					/* Basic info */
					$email = $cnumber = $backac = $prd =$pan=$tin=$stc=$crn= '';
					$email_no = $cnum_no = $bank_no = $prd_no =$pan_no=$tin_no=$stc_no=$crn_no= -1;
					/* Email */
					if(is_array($users[$i]["email"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != '';$j++){
							$flag = true;
							$email .= '<li>'.ltrim($users[$i]["email"][$j] ,',').'</li>';
							$email_no++;
						}
						if(!$flag){
							$email = '<li>Not Provided</li>';
						}
					}
                                        /* Pan */
                                        if(is_array($users[$i]["pan"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["pan"]) && isset($users[$i]["pan"][$j]) && $users[$i]["pan"][$j] != '';$j++){
							$flag = true;
							$pan .= '<li>'.ltrim($users[$i]["pan"][$j] ,',').'</li>';
							$pan_no++;
						}
						if(!$flag){
							$pan = '<li>Not Provided</li>';
						}
					}
                                        /* STC */
                                        if(is_array($users[$i]["stc"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["stc"]) && isset($users[$i]["stc"][$j]) && $users[$i]["stc"][$j] != '';$j++){
							$flag = true;
							$stc .= '<li>'.ltrim($users[$i]["stc"][$j] ,',').'</li>';
							$stc_no++;
						}
						if(!$flag){
							$stc = '<li>Not Provided</li>';
						}
					}
                                        /* CRName */
                                        if(is_array($users[$i]["crn"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["crn"]) && isset($users[$i]["crn"][$j]) && $users[$i]["crn"][$j] != '';$j++){
							$flag = true;
							$crn .= '<li>'.ltrim($users[$i]["crn"][$j] ,',').'</li>';
							$crn_no++;
						}
						if(!$flag){
							$crn = '<li>Not Provided</li>';
						}
					}
                                        /* TIN */
                                        if(is_array($users[$i]["tin"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["tin"]) && isset($users[$i]["tin"][$j]) && $users[$i]["tin"][$j] != '';$j++){
							$flag = true;
							$tin .= '<li>'.ltrim($users[$i]["tin"][$j] ,',').'</li>';
							$tin_no++;
						}
						if(!$flag){
							$tin = '<li>Not Provided</li>';
						}
					}
					/* Cell number */
					if(is_array($users[$i]["cnumber"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != '';$j++){
							$flag = true;
							$cnumber .= '<li>'.ltrim($users[$i]["cnumber"][$j] ,',').'</li>';
							$cnum_no++;
						}
						if(!$flag){
							$cnumber = '<li>Not Provided</li>';
						}
					}
					/* Bank account */
					if(is_array($users[$i]["bank_pk"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["bank_pk"]) && isset($users[$i]["bank_name"][$j]) && $users[$i]["bank_name"][$j] != '';$j++){
							$flag = true;
							$backac .= '<li>
										'.ltrim($users[$i]["bank_name"][$j] ,',').',&nbsp;
										'.ltrim($users[$i]["ac_no"][$j] ,',').',&nbsp;
										'.ltrim($users[$i]["branch"][$j] ,',').',&nbsp;
										'.ltrim($users[$i]["branch_code"][$j] ,',').',&nbsp;
										'.ltrim($users[$i]["IFSC"][$j] ,',').'
										</li>';
							$bank_no++;
						}
						if(!$flag){
							$backac = '<li>Not Provided</li>';
						}
					}
					/* Product */
					if(is_array($users[$i]["prd_pk"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["prd_pk"]) && isset($users[$i]["prd_pk"]) && $users[$i]["prd_pk"][$j] != '';$j++){
							$flag = true;
							// $prd .= '<li>'.ltrim($users[$i]["prdname"][$j] ,',').'&nbsp; <img src="'.ltrim($users[$i]["prdphoto"][$j] ,',').'" width="50" /> </li>';
							$prd .= '<li>'.ltrim($users[$i]["prdname"][$j] ,',').'&nbsp;</li>';
							$prd_no++;
						}
						if(!$flag){
							$prd = '<li>Not Provided</li>';
						}
					}
					$basicinfo = '<div class="row"><div class="col-lg-12">&nbsp;</div><div class="col-lg-4"><div class="panel panel-warning"><div class="panel-heading">Photo</div><div class="panel-body" id="usrphoto_'.$users[$i]["usrid"].'"><img src="'.$users[$i]["usrphoto"].'" width="150" /></div><div class="panel-footer" style="display:none;"><button class="btn btn-warning btn-md" id="usrphoto_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
					<div class="col-lg-4"><div class="panel panel-success"><div class="panel-heading">Email ids</div><div class="panel-body" id="usremail_'.$users[$i]["usrid"].'"><ul>'.$email.'</ul></div><div class="panel-footer"><button class="btn btn-success btn-md" id="usremail_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
					<div class="col-lg-4"><div class="panel panel-primary"><div class="panel-heading">Cell numbers</div><div class="panel-body" id="usrcnum_'.$users[$i]["usrid"].'"><ul>'.$cnumber.'</ul></div><div class="panel-footer"><button class="btn btn-primary btn-md" id="usrcnum_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div></div>
					<div class="row"><div class="col-lg-12">&nbsp;</div>
                                        <div class="col-lg-4"><div class="panel panel-success"><div class="panel-heading">PAN</div><div class="panel-body" id="usrpan_'.$users[$i]["usrid"].'"><ul>'.$pan.'</ul></div><div class="panel-footer"><button class="btn btn-primary btn-md" id="usrpan_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
                                        <div class="col-lg-4"><div class="panel panel-danger"><div class="panel-heading">TIN</div><div class="panel-body" id="usrtin_'.$users[$i]["usrid"].'"><ul>'.$tin.'</ul></div><div class="panel-footer"><button class="btn btn-primary btn-md" id="usrtin_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
                                        <div class="col-lg-4"><div class="panel panel-warning"><div class="panel-heading">STC</div><div class="panel-body" id="usrstc_'.$users[$i]["usrid"].'"><ul>'.$stc.'</ul></div><div class="panel-footer"><button class="btn btn-primary btn-md" id="usrstc_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div></div>
                                        <div class="row"><div class="col-lg-12">&nbsp;</div>
					<div class="col-lg-6"><div class="panel panel-success"><div class="panel-heading">Products</div><div class="panel-body" id="usrprod_'.$users[$i]["usrid"].'"><ul>'.$prd.'</ul></div><div class="panel-footer"><button class="btn btn-success btn-md" id="usrprod_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
                                        <div class="col-lg-6"><div class="panel panel-primary"><div class="panel-heading">Company Representative Name</div><div class="panel-body" id="usrcrn_'.$users[$i]["usrid"].'"><ul>'.$crn.'</ul></div><div class="panel-footer"><button class="btn btn-success btn-md" id="usrcrn_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
                                        <div class="row"><div class="col-lg-12">&nbsp;
                                        <div class="row"></div><div class="col-lg-8"><div class="panel panel-danger"><div class="panel-heading">Address</div>
					<div class="panel-body" id="usradd_'.$users[$i]["usrid"].'" style="display:block;">
						<ul>
							<li><strong>Address line : </strong>'.$users[$i]["addressline"].'</li>
							<li><strong>Street / Locality : </strong>'.$users[$i]["town"].'</li>
							<li><strong>City / Town : </strong>'.$users[$i]["city"].'</li>
							<li><strong>District / Department : </strong>'.$users[$i]["district"].'</li>
							<li><strong>State / Provice : </strong>'.$users[$i]["province"].'</li>
							<li><strong>Country : </strong>'.$users[$i]["country"].'</li>
							<li><strong>Zipcode : </strong>'.$users[$i]["zipcode"].'</li>
							<li><strong>Website : </strong>'.$users[$i]["website"].'</li>
							<li><strong>Google Map : </strong>'.$users[$i]["website"].'</li>
						</ul>
					</div></div>
					<div class="panel-body" id="usradd_edit_'.$users[$i]["usrid"].'" style="display:none;">
						<form id="user_address_edit_form_'.$users[$i]["usrid"].'">
						<!-- Country -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Country <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="Country" name="country" type="text" id="country_'.$users[$i]["usrid"].'" maxlength="100" value="'.$users[$i]["country"].'"/>
								<p class="help-block" id="comsg_'.$users[$i]["usrid"].'">Enter / Select</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- State / Province -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> State / Province <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="State / Province" name="province" type="text" id="province_'.$users[$i]["usrid"].'" maxlength="150" value="'.$users[$i]["province"].'"/>
								<p class="help-block" id="prmsg_'.$users[$i]["usrid"].'">Enter / Select</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- District / Department -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> District / Department <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="District / Department" name="district" type="text" id="district_'.$users[$i]["usrid"].'" maxlength="100" value="'.$users[$i]["district"].'"/>
								<p class="help-block" id="dimsg_'.$users[$i]["usrid"].'">Enter / Select</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- City / Town -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> City / Town <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="City / Town" name="city_town" type="text" id="city_town_'.$users[$i]["usrid"].'" maxlength="100" value="'.$users[$i]["city"].'"/>
								<p class="help-block" id="citmsg_'.$users[$i]["usrid"].'">Enter / Select</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- Street / Locality -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Street / Locality <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="Street / Locality" name="st_loc" type="text" id="st_loc_'.$users[$i]["usrid"].'" maxlength="100" value="'.$users[$i]["town"].'"/>
								<p class="help-block" id="stlmsg'.$users[$i]["usrid"].'">Press enter or go button to move to next feild.</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- Address Line -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Address Line <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="Address Line" name="addrs" type="text" id="addrs_'.$users[$i]["usrid"].'" maxlength="200" value="'.$users[$i]["addressline"].'"/>
								<p class="help-block" id="admsg_'.$users[$i]["usrid"].'">Enter / Select</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- Zipcode -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Zipcode <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="Zipcode" name="zipcode" type="text" id="zipcode_'.$users[$i]["usrid"].'" maxlength="25" value="'.$users[$i]["zipcode"].'"/>
								<p class="help-block" id="zimsg_'.$users[$i]["usrid"].'">Enter / Select</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- Personal Website -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Personal Website <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="Personal Website" name="website" type="text" id="website_'.$users[$i]["usrid"].'" maxlength="250" value="'.$users[$i]["website"].'"/>
								<p class="help-block" id="wemsg_'.$users[$i]["usrid"].'">Enter / Select</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- Google Map URL -->
						<div class="row">
							<div class="col-lg-12">
								<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Google Map URL <i class="fa fa-caret-down fa-fw"></i></strong>
							</div>
							<div class="col-lg-12">
								<input class="form-control" placeholder="Google Map URL" name="gmaphtml" type="text" id="gmaphtml_'.$users[$i]["usrid"].'" value="'.$users[$i]["gmaphtml"].'"/>
								<p class="help-block" id="gmmsg_'.$users[$i]["usrid"].'">Press enter or go button to update user address.</p>
							</div>
							<div class="col-lg-12">&nbsp;</div>
						</div>
						<!-- Update -->
						<div class="row">
							<div class="col-lg-12">&nbsp;</div>
							<div class="col-lg-12 text-center">
								<button class="btn btn-danger btn-md" id="usr_address_update_but_'.$users[$i]["usrid"].'"><i class="fa fa-upload fa-fw "></i> Update</button>
								&nbsp;<button class="btn btn-danger btn-md" id="usr_address_close_but_'.$users[$i]["usrid"].'"><i class="fa fa-close fa-fw "></i> Close</button>
							</div>
						</div>
						</form>
					</div>
					<div class="panel-footer"><button class="btn btn-danger btn-md" id="usraddr_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div></div></div>';
					/* Transactions */
					$incomming = '';
					$outgoing = '';
					$due = '';
					/* Incomming */
					if(is_array($users[$i]["incid"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["incid"]) && isset($users[$i]["incid"]) && $users[$i]["incid"][$j] != '';$j++){
							$flag = true;
							$mop = ltrim($users[$i]["incmop"][$j] ,',');
							if($mop != 'Cash' && $mop != 'Petty Cash'){
								$incbname = isset($users[$i]["incbname"][$j]) ? ltrim($users[$i]["incbname"][$j],',').', ' : 'Not Provided';
								$incbacno = isset($users[$i]["incbacno"][$j])  ? ltrim($users[$i]["incbacno"][$j],',').', ' : 'Not Provided';
								$incbranch = isset($users[$i]["incbranch"][$j])  ? ltrim($users[$i]["incbranch"][$j],',').', ' : 'Not Provided';
								$incifsc = isset($users[$i]["incifsc"][$j])  ? ltrim( $users[$i]["incifsc"][$j],',') : 'Not Provided';
								$bankdet = $incbname.$incbacno.$incbranch.$incifsc;
							}
							else if($mop == 'Cash')
								$bankdet = 'Cash';
							else if($mop == 'Petty Cash')
								$bankdet = 'Petty Cash';
							$incomming .= '<tr>
												<td>'.($j+1).'</td>
												<td>'.date("j-M-Y",strtotime(ltrim($users[$i]["colldate"][$j] ,','))).'</td>
												<td class="text-right">'.ltrim($users[$i]["incamt"][$j] ,',').'&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
												<td class="text-right">'.ltrim($users[$i]["incrmk"][$j] ,',').'</td>
												<td class="text-right">'.ltrim($users[$i]["incmop"][$j] ,',').'</td>
												<td class="text-right">'.$bankdet.'</td>
											</tr>';
						}
						if(!$flag)
							$incomming = '<tr><td colspan="6">No incomming transactions have been done.</td></tr>';
					}
					/* Outgoing */
					if(is_array($users[$i]["outid"])){
						$flag = false;
						for($j=0;$j<sizeof($users[$i]["outid"]) && isset($users[$i]["outid"]) && $users[$i]["outid"][$j] != '';$j++){
							$flag = true;
							$mop = ltrim($users[$i]["outmop"][$j] ,',');
							if($mop != 'Cash' && $mop != 'Petty Cash'){
								$incbname = isset($users[$i]["incbname"][$j]) ? ltrim($users[$i]["incbname"][$j],',').', ' : 'Not Provided';
								$incbacno = isset($users[$i]["incbacno"][$j])  ? ltrim($users[$i]["incbacno"][$j],',').', ' : 'Not Provided';
								$incbranch = isset($users[$i]["incbranch"][$j])  ? ltrim($users[$i]["incbranch"][$j],',').', ' : 'Not Provided';
								$incifsc = isset($users[$i]["incifsc"][$j])  ? ltrim( $users[$i]["incifsc"][$j],',') : 'Not Provided';
								$bankdet = $incbname.$incbacno.$incbranch.$incifsc;
							}
							else if($mop == 'Cash')
								$bankdet = 'Cash';
							else if($mop == 'Petty Cash')
								$bankdet = 'Petty Cash';
							$outgoing .= '<tr>
											<td>'.($j+1).'</td>
											<td>'.date("j-M-Y",strtotime(ltrim($users[$i]["paydate"][$j] ,','))).'</td>
											<td class="text-right">'.ltrim($users[$i]["outamt"][$j] ,',').'&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
											<td class="text-right">'.ltrim($users[$i]["outrmk"][$j] ,',').'</td>
											<td class="text-right">'.ltrim($users[$i]["outmop"][$j] ,',').'</td>
											<td class="text-right">'.$bankdet.'</td>
										</tr>';
						}
						if(!$flag)
							$outgoing = '<tr><td colspan="6">No outgoing transactions have been done.</td></tr>';
					}
					$trasac = '<div class="row"><div class="col-lg-12 table-responsive" ><table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="6">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>'.$incomming.'</table></div><div class="col-lg-12">&nbsp;</div></div><div class="row"><div class="col-lg-12 table-responsive" ><table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="6">Outgoing Transactions</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>'.$outgoing.'</table></div><div class="col-lg-12">&nbsp;</div></div><div class="row"><div class="col-lg-12 table-responsive" ><table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="6">Due</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th></tr></thead>'.$due.'</table></div><div class="col-lg-12">&nbsp;</div></div>';
					$editHtml = '<div class="col-lg-6">
						<div class="panel panel-warning">
						<div class="panel-heading">
							<h4>Basic Info </h4>
						</div>
						<div class="panel-body" id="acrdedituser_'.$users[$i]["usrid"].'">
						<form id="usreditForm_'.$users[$i]["usrid"].'">
						<div class="row">
						<div class="col-lg-12">
						<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> User Type <i class="fa fa-caret-down fa-fw"></i></strong>
						</div>
						<div class="col-lg-12 form-group">
						<div class="form-group" id="TVUtype_'.$users[$i]["usrid"].'">
						<input type="radio" class="radio-botton" value="1"/> : Supplier<br />
						<input type="radio" class="radio-botton" value="2"/> : Collector<br />
						<input type="radio" class="radio-botton" value="3"/> : Retailer<br />
						<input type="radio" class="radio-botton" value="4"/> : Distributor<br />
						Fetch the user type from db display radio buttons
						</div>
						</div>
						<div class="col-lg-12">&nbsp;</div>
						</div>
						<div class="row">
						<div class="col-lg-12">
						<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> User Name <i class="fa fa-caret-down fa-fw"></i></strong>
						</div>
						<div class="col-lg-12">
						<input class="form-control" placeholder="User Name" name="user_name_'.$users[$i]["usrid"].'" type="text" id="user_name_'.$users[$i]["usrid"].'" maxlength="100" value="'.$users[$i]["user_name"].'"/>
						<p class="help-block" id="user_name_msg_'.$users[$i]["usrid"].'">Enter / Select</p>
						</div>
						<div class="col-lg-12">&nbsp;</div>
						</div>
						<div class="row">
						<div class="col-lg-12">
						<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Telephone Number <i class="fa fa-caret-down fa-fw"></i></strong>
						</div>
						<div class="col-lg-12">
						<div class="col-lg-4">
						<input class="form-control" placeholder="080" name="pcode_'.$users[$i]["usrid"].'" type="text" id="pcode_'.$users[$i]["usrid"].'" maxlength="15" value="'.$users[$i]["pcode"].'" />
						</div>
						<div class="col-lg-8">
						<input class="form-control" placeholder="Telephone Number" name="telephone_'.$users[$i]["usrid"].'" type="text" id="telephone_'.$users[$i]["usrid"].'" maxlength="20" value="'.$users[$i]["tnumber"].'" />
						</div>
						<p class="help-block" id="tp_msg_'.$users[$i]["usrid"].'">Enter / Select</p>
						</div>
						<div class="col-lg-12">&nbsp;</div>
						</div>
						<div class="row" style="display:none;">
						<div class="col-lg-12">
						<strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> ACS ID <i class="fa fa-caret-down fa-fw"></i></strong>
						</div>
						<div class="col-lg-12">
						<input class="form-control" placeholder="Access Id for short login id" name="acs_id_'.$users[$i]["usrid"].'" type="text" id="acs_id_'.$users[$i]["usrid"].'" maxlength="15" />
						<p class="help-block" id="ac_msg_'.$users[$i]["usrid"].'">Enter / Select</p>
						</div>
						<div class="col-lg-12">&nbsp;</div>
						</div>
						<div class="pane-footer">
						<button class="btn btn-md btn-warning" href="javascript:void(0);" id="edituserBut_'.$users[$i]["usrid"].'"><i class="fa fa-upload fa-fw fa-2x"></i> &nbsp;Update</button>
						</div>
						</form>
						</div>
						</div>
						</div>
						<div class="col-lg-6">
						<div class="panel panel-danger">
						<div class="panel-heading">
						<h4>Bank accounts</h4>
						</div>
						<div class="panel-body" id="usrbank_'.$users[$i]["usrid"].'">
						<ul>'.$backac.'</ul>
						</div>
						<div class="panel-footer">
						<button class="btn btn-danger btn-md" id="usrbank_but_edit_'.$users[$i]["usrid"].'"><i class="fa fa-edit fa-fw "></i> Edit</button>
						</div>
						</div>
						</div>
						<script language="javascript">
							$(document).ready(function(){
								console.log("2");
								window.setTimeout(function(){
									var editUserBasicInfo = {
										autoloader : true,
										action 	   	: "editUserBasicInfo",
										outputDiv  	: "#output",
										parentDiv  	: "#acrdedituser_'.$users[$i]["usrid"].'",
										but  	   	: "#edituserBut_'.$users[$i]["usrid"].'",
										menuBut  	 : "#edt_user_but_'.$users[$i]["usrid"].'",
										reloadBut  	 : "#listusersbut",
										uid	   	   	: '.$users[$i]["usrid"].',
										index  	   	: '.$i.',
										listindex  	: "listofusers",
										form  		: "#usreditForm_'.$users[$i]["usrid"].'",
										TVUtype		: "#TVUtype_'.$users[$i]["usrid"].'",
										user_type	: "user_type_edit_'.$users[$i]["usrid"].'",
										ut_msg		: "user_type_msg_'.$users[$i]["usrid"].'",
										name 		: "#user_name_'.$users[$i]["usrid"].'",
										nmsg 		: "#user_name_msg_'.$users[$i]["usrid"].'",
										pcode 		: "#pcode_'.$users[$i]["usrid"].'",
										tphone 		: "#telephone_'.$users[$i]["usrid"].'",
										tpmsg 		: "#tp_msg_'.$users[$i]["usrid"].'",
										acs_id 		: "#acs_id_'.$users[$i]["usrid"].'",
										ac_msg 		: "#ac_msg_'.$users[$i]["usrid"].'",
										url			: window.location.href
									};
									var obj = new userController();
									obj.editUserBasicInfo(editUserBasicInfo);
									var editUserEmailIds = {
										autoloader : true,
										action 	   : "loadEmailIdForm",
										outputDiv  : "#output",
										parentDiv  : "#usremail_'.$users[$i]["usrid"].'",
										but  	   : "#usremail_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$email_no.',
										uid	   	   : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "email_id_'.$users[$i]["usrid"].'_",
										email 	   : "email_'.$users[$i]["usrid"].'_",
										msgDiv 	   : "email_msg_'.$users[$i]["usrid"].'_",
										plus 	   : "plus_email_'.$users[$i]["usrid"].'_",
										minus 	   : "minus_email_'.$users[$i]["usrid"].'_",
										saveBut	   : "usremail_but_'.$users[$i]["usrid"].'",
										closeBut   : "usremail_close_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserEmailIds(editUserEmailIds);
                                                                        var editUserPans = {
										autoloader : true,
										action 	   : "loadPanForm",
										outputDiv  : "#output",
										parentDiv  : "#usrpan_'.$users[$i]["usrid"].'",
										but  	   : "#usrpan_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$pan_no.',
										uid	   	   : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "pan_num_'.$users[$i]["usrid"].'_",
										pan 	   : "pan_'.$users[$i]["usrid"].'_",
										msgDiv 	   : "pan_msg_'.$users[$i]["usrid"].'_",
										plus 	   : "plus_pan_'.$users[$i]["usrid"].'_",
										minus 	   : "minus_pan_'.$users[$i]["usrid"].'_",
										saveBut	   : "usrpan_but_'.$users[$i]["usrid"].'",
										closeBut   : "usrpan_close_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserPans(editUserPans);
                                                                        var editUserStc = {
										autoloader : true,
										action 	   : "loadStcForm",
										outputDiv  : "#output",
										parentDiv  : "#usrstc_'.$users[$i]["usrid"].'",
										but  	   : "#usrstc_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$stc_no.',
										uid	   	   : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "stc_num_'.$users[$i]["usrid"].'_",
										stc 	   : "stc_'.$users[$i]["usrid"].'_",
										msgDiv 	   : "stc_msg_'.$users[$i]["usrid"].'_",
										plus 	   : "plus_stc_'.$users[$i]["usrid"].'_",
										minus 	   : "minus_stc_'.$users[$i]["usrid"].'_",
										saveBut	   : "usrstc_but_'.$users[$i]["usrid"].'",
										closeBut   : "usrstc_close_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserStc(editUserStc);
                                                                        var editUserCrn = {
										autoloader : true,
										action 	   : "loadCrnForm",
										outputDiv  : "#output",
										parentDiv  : "#usrcrn_'.$users[$i]["usrid"].'",
										but  	   : "#usrcrn_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$crn_no.',
										uid	   : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "crn_num_'.$users[$i]["usrid"].'_",
										stc 	   : "crn_'.$users[$i]["usrid"].'_",
										msgDiv 	   : "crn_msg_'.$users[$i]["usrid"].'_",
										plus 	   : "plus_crn_'.$users[$i]["usrid"].'_",
										minus 	   : "minus_crn_'.$users[$i]["usrid"].'_",
										saveBut	   : "usrcrn_but_'.$users[$i]["usrid"].'",
										closeBut   : "usrcrn_close_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserCrn(editUserCrn);
                                                                        var editUserTins = {
										autoloader : true,
										action 	   : "loadTinForm",
										outputDiv  : "#output",
										parentDiv  : "#usrtin_'.$users[$i]["usrid"].'",
										but  	   : "#usrtin_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$tin_no.',
										uid         : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "tin_num_'.$users[$i]["usrid"].'_",
										tin 	   : "tin_'.$users[$i]["usrid"].'_",
										msgDiv 	   : "tin_msg_'.$users[$i]["usrid"].'_",
										plus 	   : "plus_tin_'.$users[$i]["usrid"].'_",
										minus 	   : "minus_tin_'.$users[$i]["usrid"].'_",
										saveBut	   : "usrtin_but_'.$users[$i]["usrid"].'",
										closeBut   : "usrtin_close_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserTins(editUserTins);
									var editUserCellNumbers = {
										autoloader : true,
										action 	   : "loadCellNumForm",
										outputDiv  : "#output",
										parentDiv  : "#usrcnum_'.$users[$i]["usrid"].'",
										but  	   : "#usrcnum_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$cnum_no.',
										uid	   	   : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "cnum_id_'.$users[$i]["usrid"].'_",
										cnumber	   : "cnum_'.$users[$i]["usrid"].'_",
										msgDiv 	   : "cnum_msg_'.$users[$i]["usrid"].'_",
										plus 	   : "plus_cnum_'.$users[$i]["usrid"].'_",
										minus 	   : "minus_cnum_'.$users[$i]["usrid"].'_",
										saveBut	   : "usrcnum_but_'.$users[$i]["usrid"].'",
										closeBut   : "usrcnum_close_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserCellNumbers(editUserCellNumbers);
									var editUserProducts = {
										autoloader : true,
										action 	   : "loadProdForm",
										outputDiv  : "#output",
										parentDiv  : "#usrprod_'.$users[$i]["usrid"].'",
										but  	   : "#usrprod_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$prd_no.',
										uid	   	   : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "prod_id_'.$users[$i]["usrid"].'_",
										prdname	   : "prod_'.$users[$i]["usrid"].'_",
										msgDiv 	   : "prod_msg_'.$users[$i]["usrid"].'_",
										plus 	   : "plus_prod_'.$users[$i]["usrid"].'_",
										minus 	   : "minus_prod_'.$users[$i]["usrid"].'_",
										saveBut	   : "usrprod_but_'.$users[$i]["usrid"].'",
										closeBut   : "usrprod_close_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserProducts(editUserProducts);
									var editUserBankAccounts = {
										autoloader : true,
										action 	   : "loadBankAcForm",
										outputDiv  : "#output",
										parentDiv  : "#usrbank_'.$users[$i]["usrid"].'",
										but  	   : "#usrbank_but_edit_'.$users[$i]["usrid"].'",
										num   	   : '.$bank_no.',
										uid	   	   : '.$users[$i]["usrid"].',
										index  	   : '.$i.',
										listindex  : "listofusers",
										form 	   : "usrbankname_form_'.$users[$i]["usrid"].'_",
										bankname   : "usrbankname_'.$users[$i]["usrid"].'_",
										nmsg  	   : "usrbanknamemsg_'.$users[$i]["usrid"].'_",
										accno 	   : "usraccno_'.$users[$i]["usrid"].'_",
										nomsg 	   : "usraccnomsg_'.$users[$i]["usrid"].'_",
										braname	   : "usrbraname_'.$users[$i]["usrid"].'_",
										bnmsg	   : "usrbranamemsg_'.$users[$i]["usrid"].'_",
										bracode	   : "usrbracode_'.$users[$i]["usrid"].'_",
										bcmsg	   : "usrbracodemsg_'.$users[$i]["usrid"].'_",
										IFSC	   : "usrIFSC_'.$users[$i]["usrid"].'_",
										IFSCmsg	   : "usrIFSCmsg_'.$users[$i]["usrid"].'_",
										plus 	   : "usrplus_bankac'.$users[$i]["usrid"].'_",
										minus 	   : "usrminus_bankac'.$users[$i]["usrid"].'_",
										saveBut	   : "usrusrbankacbut_'.$users[$i]["usrid"].'",
										closeBut   : "usrusrbankacclose_'.$users[$i]["usrid"].'",
										url 	   : window.location.href
									};
									var obj = new userController();
									obj.editUserBankAccounts(editUserBankAccounts);
									var editUserAddress = {
										autoloader 		: true,
										action 	   		: "loadAddressForm",
										outputDiv  		: "#output",
										showDiv 		: "#usradd_'.$users[$i]["usrid"].'",
										updateDiv 		: "#usradd_edit_'.$users[$i]["usrid"].'",
										uid                     : '.$users[$i]["usrid"].',
										index  	   		: '.$i.',
										listindex  		: "listofusers",
										but                     : "#usraddr_but_edit_'.$users[$i]["usrid"].'",
										saveBut	   		: "#usr_address_update_but_'.$users[$i]["usrid"].'",
										closeBut   		: "#usr_address_close_but_'.$users[$i]["usrid"].'",
										form 	   		: "#usrbankname_form_'.$users[$i]["usrid"].'_",
										country 		: "#country_'.$users[$i]["usrid"].'",
										countryCode 	: null,
										countryId 		: null,
										comsg 			: "#comsg_'.$users[$i]["usrid"].'",
										province 		: "#province_'.$users[$i]["usrid"].'",
										provinceCode	: null,
										provinceId 		: null,
										prmsg 			: "#prmsg_'.$users[$i]["usrid"].'",
										district 		: "#district_'.$users[$i]["usrid"].'",
										districtCode	: null,
										districtId 		: null,
										dimsg 			: "#dimsg_'.$users[$i]["usrid"].'",
										city_town 		: "#city_town_'.$users[$i]["usrid"].'",
										city_townCode	: null,
										city_townId 	: null,
										citmsg 			: "#citmsg_'.$users[$i]["usrid"].'",
										st_loc 			: "#st_loc_'.$users[$i]["usrid"].'",
										st_locCode 		: null,
										st_locId 		: null,
										stlmsg 			: "#stlmsg_'.$users[$i]["usrid"].'",
										addrs 			: "#addrs_'.$users[$i]["usrid"].'",
										admsg 			: "#admsg_'.$users[$i]["usrid"].'",
										zipcode 		: "#zipcode_'.$users[$i]["usrid"].'",
										zimsg 			: "#zimsg_'.$users[$i]["usrid"].'",
										website 		: "#website_'.$users[$i]["usrid"].'",
										wemsg 			: "#wemsg_'.$users[$i]["usrid"].'",
										tphone 			: "#telephone_'.$users[$i]["usrid"].'",
										gmaphtml 		: "#gmaphtml_'.$users[$i]["usrid"].'",
										gmmsg 			: "#gmmsg_'.$users[$i]["usrid"].'",
										lat 			: null,
										lon 			: null,
										timezone 		: null,
										PCR_reg 		: null,
										url				: URL+"address.php",
										Updateurl		: window.location.href
									};
									var obj = new userController();
									obj.editUserAddress(editUserAddress);
									$(".input-group-addon").each(function(){
										$(this).css({padding:"0px"});
									});
								},800);
							});
						</script>';
					$html =  '<tr><td><div class="panel panel-default" id="usr_'.$users[$i]["usrid"].'">
						<div class="panel-heading">
							<div class="row">

								<div class="col-md-6">
									<a data-toggle="collapse" data-parent="#accorlistuser" href="#user_type_'.$users[$i]["usrid"].'">
										{'.($i+1).'} - {'.$users[$i]["user_name"].'} - {'.$users[$i]["user_type"].'} - {'.$users[$i]["tnumber"].'}
									</a>
								</div>
								<div class="modal fade" id="myUSRDELModal_'.$users[$i]["usrid"].'" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModalLabel_'.$users[$i]["usrid"].'" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myUSRDELModalLabel_'.$users[$i]["usrid"].'">Select Cell Numbers to send SMS</h4>
								</div>
								<div class="modal-body" id="myUSRDEL_'.$users[$i]["usrid"].'">
									Do you really want to delete {'.$users[$i]["user_name"].'} - {'.$users[$i]["user_type"].'} - {'.$users[$i]["tnumber"].'}<br />
									Press OK to delete ??
								</div>
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteUSRDELOk_'.$users[$i]["usrid"].'">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteUSRDELCancel_'.$users[$i]["usrid"].'">Cancel</button>
								</div>
								</div>
								</div>
								<div class="col-md-6 text-right">
									<!-- <button class="btn btn-primary btn-md" id="usr_but_flag_'.$users[$i]["usrid"].'"><i class="fa fa-flag fa-fw "></i> Flag</button>&nbsp; -->
									<button class="btn btn-danger btn-md" id="usr_but_trash_'.$users[$i]["usrid"].'" data-toggle="modal" data-target="#myUSRDELModal_'.$users[$i]["usrid"].'" ><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp;
								</div>
							</div>
						</div>
						<div id="user_type_'.$users[$i]["usrid"].'" class="panel-body panel-collapse collapse" style="height: 0px;">
							<ul class="nav nav-pills">
								<li class="active"><a href="#info_user_type_'.$users[$i]["usrid"].'" data-toggle="tab">Basic info</a></li>
								<li><a href="#trans_user_type_'.$users[$i]["usrid"].'" data-toggle="tab">Transactions</a></li>
								<li><a href="#edt_user_type_'.$users[$i]["usrid"].'" id="edt_user_but_'.$users[$i]["usrid"].'" data-toggle="tab">Edit</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="info_user_type_'.$users[$i]["usrid"].'">
									'.str_replace($this->order, $this->replace, $basicinfo).'
								</div>
								<div class="tab-pane fade" id="trans_user_type_'.$users[$i]["usrid"].'">
									'.str_replace($this->order, $this->replace, $trasac).'
								</div>
								<div class="tab-pane fade" id="edt_user_type_'.$users[$i]["usrid"].'">
									<div class="row">
									<div class="col-lg-12">
									'.str_replace($this->order, $this->replace, $editHtml).'
									</div>
									</div>
								</div>
							</div>
						</div>
					</div></td></tr>';
					$listusers[] = array(
						"html"			=> (string) str_replace($this->order, $this->replace,($html)),
						"uid"			=> $users[$i]["usrid"],
						"sr"			=> '#usr_row'.$users[$i]["usrid"],
						"alertUSRDEL"	=> '#myUSRDELModal_'.$users[$i]["usrid"],
						"usrdelOk" 		=> '#deleteUSRDELOk_'.$users[$i]["usrid"],
						"usrdelCancel" 	=> '#deleteUSRDELCancel_'.$users[$i]["usrid"]
					);
				}
			}
			return $listusers;
		}
		/* Basic Info */
		public function editBasicInfo(){
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["uid"];
			/* Profile BasicInfo */
			$query = 'UPDATE  `user_profile`
					SET `user_name` = \''.mysql_real_escape_string($this->parameters["name"]).'\',
						`postal_code` = \''.mysql_real_escape_string($this->parameters["pcode"]).'\',
						`telephone` = \''.mysql_real_escape_string($this->parameters["tphone"]).'\',
						`user_type_id` = \''.mysql_real_escape_string($this->parameters["user_type"]).'\'
					WHERE `id` = \''.mysql_real_escape_string($user_pk).'\';';
			$flag = executeQuery($query);
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		/* Email ids */
		public function loadEmailIdForm() {
			$users = user::listUser();
			$html = '';
			$emailHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$emailids = array(
				"oldemail" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["email"])){
							for($j=0;$j<=sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != '';$j++){
								$flag = true;
								$emailids["oldemail"][$j] =  array(
													"id" 		=> ltrim($users[$i]["email_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["email"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["email"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["email"].$j.'_delete',
													"deleteOk"  => 'deleteEmlOk_'.ltrim($users[$i]["email_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteEmlCancel_'.ltrim($users[$i]["email_pk"][$j] ,',').'_'.$j
												);
								$emailHTM .= '<div id="'.$emailids["oldemail"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="Email ID" name="'.$emailids["oldemail"][$j]["id"].'" type="text" id="'.$emailids["oldemail"][$j]["textid"].'" maxlength="100" value="'.ltrim( $users[$i]["email"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$emailids["oldemail"][$j]["deleteid"].'" data-toggle="modal" data-target="#myEmailModal_'.$j.'">
														<i class="fa fa-trash fa-fw "></i>
													</button>
													<div class="modal fade" id="myEmailModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myEmailModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myEmailModalLabel_'.$j.'">Delete Email Id</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["email"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$emailids["oldemail"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$emailids["oldemail"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-12" id="'.$emailids["oldemail"][$j]["form"].'">
													<p class="help-block" id="'.$emailids["oldemail"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
										}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra email ids : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $emailHTM).'</div>';
				$emailids["html"] = $html;
			}
			return $emailids;
		}
		public function editEmailId() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["emailids"]["uid"];
			/* Emails Insert */
			if(isset($this->parameters["emailids"]["insert"]) && is_array($this->parameters["emailids"]["insert"]) && sizeof($this->parameters["emailids"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status_id` ) VALUES';
				for($i=0;$i<sizeof($this->parameters["emailids"]["insert"]);$i++){
					if($i == sizeof($this->parameters["emailids"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `email`= \''.mysql_real_escape_string($this->parameters["emailids"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* Emails Update */
			if(isset($this->parameters["emailids"]["update"]) && is_array($this->parameters["emailids"]["update"]) && sizeof($this->parameters["emailids"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["emailids"]["update"]);$i++){
					$query = 'UPDATE  `email_ids`
							 SET `email` = \''.mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["email"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function deleteEmailId() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* Emails Update */
			if(isset($this->parameters["eid"]) && $this->parameters["eid"] > -1){
				$query = 'UPDATE  `email_ids`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["eid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listEmailIds() {
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$emailHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["email"]) && $users[$i]["email"][0] != ''){
							$emailHTM = '';
							for($j=0;$j<=sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != '';$j++){
									$emailHTM .= '<li>'.ltrim($users[$i]["email"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			return $emailHTM;
		}
                /*  Pans  */
                public function loadPanForm() {
			$users = user::listUser();
			$html = '';
			$panHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$pans = array(
				"oldpan" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["pan"])){
							for($j=0;$j<=sizeof($users[$i]["pan"]) && isset($users[$i]["pan"][$j]) && $users[$i]["pan"][$j] != '';$j++){
								$flag = true;
								$pans["oldpan"][$j] =  array(
													"id" 		=> ltrim($users[$i]["pan_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["pan"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["pan"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["pan"].$j.'_delete',
													"deleteOk"  => 'deletePnOk_'.ltrim($users[$i]["pan_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteEmlCancel_'.ltrim($users[$i]["pan_pk"][$j] ,',').'_'.$j
												);
								$panHTM .= '<div id="'.$pans["oldpan"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="PAN NUMBER" name="'.$pans["oldpan"][$j]["id"].'" type="text" id="'.$pans["oldpan"][$j]["textid"].'" maxlength="100" value="'.ltrim( $users[$i]["pan"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$pans["oldpan"][$j]["deleteid"].'" data-toggle="modal" data-target="#myPanModal_'.$j.'">
														<i class="fa fa-trash fa-fw "></i>
													</button>
													<div class="modal fade" id="myPanModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myEmailModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myEmailModalLabel_'.$j.'">Delete Pan</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["pan"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$pans["oldpan"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$pans["oldpan"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-12" id="'.$pans["oldpan"][$j]["form"].'">
													<p class="help-block" id="'.$pans["oldpan"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
										}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra PAN Numbers : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $panHTM).'</div>';
				$pans["html"] = $html;
			}
			return $pans;
		}
		public function editPan() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["pans"]["uid"];
			/* Emails Insert */
			if(isset($this->parameters["pans"]["insert"]) && is_array($this->parameters["pans"]["insert"]) && sizeof($this->parameters["pans"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `code_pan` (`id`,`user_pk`,`pan`,`status_id` ) VALUES';
				for($i=0;$i<sizeof($this->parameters["pans"]["insert"]);$i++){
					if($i == sizeof($this->parameters["pans"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["pans"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["pans"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `pan`= \''.mysql_real_escape_string($this->parameters["pans"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* Emails Update */
			if(isset($this->parameters["pans"]["update"]) && is_array($this->parameters["pans"]["update"]) && sizeof($this->parameters["pans"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["pans"]["update"]);$i++){
					$query = 'UPDATE  `code_pan`
							 SET `pan` = \''.mysql_real_escape_string($this->parameters["pans"]["update"][$i]["pan"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["pans"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function deletePan() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* Emails Update */
			if(isset($this->parameters["pid"]) && $this->parameters["pid"] > -1){
				$query = 'UPDATE  `code_pan`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["pid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listPans() {
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$panHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["pan"]) && $users[$i]["pan"][0] != ''){
							$panHTM = '';
							for($j=0;$j<=sizeof($users[$i]["pan"]) && isset($users[$i]["pan"][$j]) && $users[$i]["pan"][$j] != '';$j++){
									$panHTM .= '<li>'.ltrim($users[$i]["pan"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			return $panHTM;
		}
                /*  CRNames  */
                public function loadCrnForm() {
			$users = user::listUser();
			$html = '';
			$stcHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$stcs = array(
				"oldstc" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["crn"])){
							for($j=0;$j<=sizeof($users[$i]["crn"]) && isset($users[$i]["crn"][$j]) && $users[$i]["crn"][$j] != '';$j++){
								$flag = true;
								$stcs["oldstc"][$j] =  array(
													"id" 		=> ltrim($users[$i]["crn_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["crn"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["stc"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["stc"].$j.'_delete',
													"deleteOk"  => 'deletePnOk_'.ltrim($users[$i]["stc_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteEmlCancel_'.ltrim($users[$i]["stc_pk"][$j] ,',').'_'.$j
												);
								$stcHTM .= '<div id="'.$stcs["oldstc"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="Company Representative Name" name="'.$stcs["oldstc"][$j]["id"].'" type="text" id="'.$stcs["oldstc"][$j]["textid"].'" maxlength="100" value="'.ltrim( $users[$i]["crn"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$stcs["oldstc"][$j]["deleteid"].'" data-toggle="modal" data-target="#myStcModal_'.$j.'">
														<i class="fa fa-trash fa-fw "></i>
													</button>
													<div class="modal fade" id="myStcModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myStcModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myEmailModalLabel_'.$j.'">Delete Pan</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["crn"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$stcs["oldstc"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$stcs["oldstc"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-12" id="'.$stcs["oldstc"][$j]["form"].'">
													<p class="help-block" id="'.$stcs["oldstc"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
										}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra Company Representative Names : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $stcHTM).'</div>';
				$stcs["html"] = $html;
			}
			return $stcs;
		}
		public function editCrn() {
                        $query='';
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["stcs"]["uid"];
			/* Emails Insert */
			if(isset($this->parameters["stcs"]["insert"]) && is_array($this->parameters["stcs"]["insert"]) && sizeof($this->parameters["stcs"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `user_name` (`id`,`user_pk`,`name`,`status_id` ) VALUES';
				for($i=0;$i<sizeof($this->parameters["stcs"]["insert"]);$i++){
					if($i == sizeof($this->parameters["stcs"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["stcs"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["stcs"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `crname`= \''.mysql_real_escape_string($this->parameters["stcs"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* STC Update */
			if(isset($this->parameters["stcs"]["update"]) && is_array($this->parameters["stcs"]["update"]) && sizeof($this->parameters["stcs"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["stcs"]["update"]);$i++){
					$query = 'UPDATE  `user_name`
							 SET `name` = \''.mysql_real_escape_string($this->parameters["stcs"]["update"][$i]["stc"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["stcs"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $query;
		}
		public function deleteCrn() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* STC Update */
			if(isset($this->parameters["sid"]) && $this->parameters["sid"] > -1){
				$query = 'UPDATE  `user_name`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["sid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listCrns() {
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$stcHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* STC */
						if(is_array($users[$i]["crn"]) && $users[$i]["crn"][0] != ''){
							$stcHTM = '';
							for($j=0;$j<=sizeof($users[$i]["crn"]) && isset($users[$i]["crn"][$j]) && $users[$i]["crn"][$j] != '';$j++){
									$stcHTM .= '<li>'.ltrim($users[$i]["crn"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			return $stcHTM;
		}
                /*  STC  */
                public function loadStcForm() {
			$users = user::listUser();
			$html = '';
			$stcHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$stcs = array(
				"oldstc" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Email */
						if(is_array($users[$i]["stc"])){
							for($j=0;$j<=sizeof($users[$i]["stc"]) && isset($users[$i]["stc"][$j]) && $users[$i]["stc"][$j] != '';$j++){
								$flag = true;
								$stcs["oldstc"][$j] =  array(
													"id" 		=> ltrim($users[$i]["stc_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["stc"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["stc"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["stc"].$j.'_delete',
													"deleteOk"  => 'deletePnOk_'.ltrim($users[$i]["stc_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteEmlCancel_'.ltrim($users[$i]["stc_pk"][$j] ,',').'_'.$j
												);
								$stcHTM .= '<div id="'.$stcs["oldstc"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="STC" name="'.$stcs["oldstc"][$j]["id"].'" type="text" id="'.$stcs["oldstc"][$j]["textid"].'" maxlength="100" value="'.ltrim( $users[$i]["stc"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$stcs["oldstc"][$j]["deleteid"].'" data-toggle="modal" data-target="#myStcModal_'.$j.'">
														<i class="fa fa-trash fa-fw "></i>
													</button>
													<div class="modal fade" id="myStcModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myStcModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myEmailModalLabel_'.$j.'">Delete Pan</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["stc"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$stcs["oldstc"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$stcs["oldstc"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-12" id="'.$stcs["oldstc"][$j]["form"].'">
													<p class="help-block" id="'.$stcs["oldstc"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
										}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra STC Numbers : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $stcHTM).'</div>';
				$stcs["html"] = $html;
			}
			return $stcs;
		}
		public function editStc() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["stcs"]["uid"];
			/* Emails Insert */
			if(isset($this->parameters["stcs"]["insert"]) && is_array($this->parameters["stcs"]["insert"]) && sizeof($this->parameters["stcs"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `code_stc` (`id`,`user_pk`,`stc`,`status_id` ) VALUES';
				for($i=0;$i<sizeof($this->parameters["stcs"]["insert"]);$i++){
					if($i == sizeof($this->parameters["stcs"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["stcs"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["stcs"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `stc`= \''.mysql_real_escape_string($this->parameters["stcs"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* STC Update */
			if(isset($this->parameters["stcs"]["update"]) && is_array($this->parameters["stcs"]["update"]) && sizeof($this->parameters["stcs"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["stcs"]["update"]);$i++){
					$query = 'UPDATE  `code_stc`
							 SET `stc` = \''.mysql_real_escape_string($this->parameters["stcs"]["update"][$i]["stc"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["stcs"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function deleteStc() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* STC Update */
			if(isset($this->parameters["sid"]) && $this->parameters["sid"] > -1){
				$query = 'UPDATE  `code_stc`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["sid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listStcs() {
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$stcHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* STC */
						if(is_array($users[$i]["stc"]) && $users[$i]["stc"][0] != ''){
							$stcHTM = '';
							for($j=0;$j<=sizeof($users[$i]["stc"]) && isset($users[$i]["stc"][$j]) && $users[$i]["stc"][$j] != '';$j++){
									$stcHTM .= '<li>'.ltrim($users[$i]["stc"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			return $stcHTM;
		}
                /* TIN  */
                public function loadTinForm() {
			$users = user::listUser();
			$html = '';
			$tinHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$tins = array(
				"oldtin" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* TIN */
						if(is_array($users[$i]["tin"])){
							for($j=0;$j<=sizeof($users[$i]["tin"]) && isset($users[$i]["tin"][$j]) && $users[$i]["tin"][$j] != '';$j++){
								$flag = true;
								$tins["oldtin"][$j] =  array(
													"id" 		=> ltrim($users[$i]["tin_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["tin"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["tin"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["tin"].$j.'_delete',
													"deleteOk"  => 'deletePnOk_'.ltrim($users[$i]["tin_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteEmlCancel_'.ltrim($users[$i]["tin_pk"][$j] ,',').'_'.$j
												);
								$tinHTM .= '<div id="'.$tins["oldtin"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="TIN" name="'.$tins["oldtin"][$j]["id"].'" type="text" id="'.$tins["oldtin"][$j]["textid"].'" maxlength="100" value="'.ltrim( $users[$i]["tin"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$tins["oldtin"][$j]["deleteid"].'" data-toggle="modal" data-target="#myTinModal_'.$j.'">
														<i class="fa fa-trash fa-fw "></i>
													</button>
													<div class="modal fade" id="myTinModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myTinModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myEmailModalLabel_'.$j.'">Delete TIN</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["tin"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$tins["oldtin"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$tins["oldtin"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-12" id="'.$tins["oldtin"][$j]["form"].'">
													<p class="help-block" id="'.$tins["oldtin"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
										}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra TIN Numbers : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $tinHTM).'</div>';
				$tins["html"] = $html;
			}
			return $tins;
		}
		public function editTin() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["tins"]["uid"];
			/* STC Insert */
			if(isset($this->parameters["tins"]["insert"]) && is_array($this->parameters["tins"]["insert"]) && sizeof($this->parameters["tins"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `code_tin` (`id`,`user_pk`,`tin`,`status_id` ) VALUES';
				for($i=0;$i<sizeof($this->parameters["tins"]["insert"]);$i++){
					if($i == sizeof($this->parameters["tins"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["tins"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["tins"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `tin`= \''.mysql_real_escape_string($this->parameters["tins"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* TIN Update */
			if(isset($this->parameters["tins"]["update"]) && is_array($this->parameters["tins"]["update"]) && sizeof($this->parameters["tins"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["tins"]["update"]);$i++){
					$query = 'UPDATE  `code_tin`
							 SET `tin` = \''.mysql_real_escape_string($this->parameters["tins"]["update"][$i]["tin"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["tins"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function deleteTin() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* tin Update */
			if(isset($this->parameters["tid"]) && $this->parameters["tid"] > -1){
				$query = 'UPDATE  `code_tin`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["tid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listTins() {
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$tinHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* TIN */
						if(is_array($users[$i]["tin"]) && $users[$i]["tin"][0] != ''){
							$tinHTM = '';
							for($j=0;$j<=sizeof($users[$i]["tin"]) && isset($users[$i]["tin"][$j]) && $users[$i]["tin"][$j] != '';$j++){
									$tinHTM .= '<li>'.ltrim($users[$i]["tin"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			return $tinHTM;
		}
		/* Cell numbers */
		public function loadCellNumForm() {
			$users = user::listUser();
			$html = '';
			$cnumHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$cnums = array(
				"oldcnum" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						$cnumHTM = '';
						/* Cell numbers */
						if(is_array($users[$i]["cnumber"])){
							for($j=0;$j<=sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != '';$j++){
								$flag = true;
								$cnums["oldcnum"][$j] =  array(
													"id" 		=> ltrim($users[$i]["cnumber_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["cnumber"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["cnumber"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["cnumber"].$j.'_delete',
													"deleteOk"  => 'deleteCnumOk_'.ltrim($users[$i]["cnumber_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deleteCnumCancel_'.ltrim($users[$i]["cnumber_pk"][$j] ,',').'_'.$j
												);
								$cnumHTM .= '<div id="'.$cnums["oldcnum"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="Cell number" name="'.$cnums["oldcnum"][$j]["id"].'" type="text" id="'.$cnums["oldcnum"][$j]["textid"].'" maxlength="10" value="'.ltrim( $users[$i]["cnumber"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$cnums["oldcnum"][$j]["deleteid"].'" data-toggle="modal" data-target="#myCnumModal_'.$j.'">
														<i class="fa fa-trash fa-fw"></i>
													</button>
													<div class="modal fade" id="myCnumModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myCnumModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myCnumModalLabel_'.$j.'">Delete Cell Number</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["cnumber"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$cnums["oldcnum"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$cnums["oldcnum"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-12" id="'.$cnums["oldcnum"][$j]["form"].'">
													<p class="help-block" id="'.$cnums["oldcnum"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
							}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra Cell NO : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $cnumHTM).'</div>';
				$cnums["html"] = $html;
			}
			return $cnums;
		}
		public function editCellNum() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["CellNums"]["uid"];
			/* Cell Numbers Insert */
			if(isset($this->parameters["CellNums"]["insert"]) && is_array($this->parameters["CellNums"]["insert"]) && sizeof($this->parameters["CellNums"]["insert"]) > -1 && $user_pk > 0){
				$query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status_id`) VALUES';
				for($i=0;$i<sizeof($this->parameters["CellNums"]["insert"]);$i++){
					if($i == sizeof($this->parameters["CellNums"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]).'\',4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',\''.mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]).'\',4),';
				}
				executeQuery($query);
				executeQuery('UPDATE `user_profile` SET `cell_number`= \''.mysql_real_escape_string($this->parameters["CellNums"]["insert"][0]).'\'
								WHERE `id` = \''.mysql_real_escape_string($user_pk).'\'');
				$flag = true;
			}
			/* Cell Numbers Update */
			if(isset($this->parameters["CellNums"]["update"]) && is_array($this->parameters["CellNums"]["update"]) && sizeof($this->parameters["CellNums"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["CellNums"]["update"]);$i++){
					$query = 'UPDATE  `cell_numbers`
							 SET `cell_number` = \''.mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["cnumber"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function deleteCellNum() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* Emails Update */
			if(isset($this->parameters["eid"]) && $this->parameters["eid"] > -1){
				$query = 'UPDATE  `cell_numbers`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["eid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listCellNums() {
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$cnumHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Cell numbers */
						if(is_array($users[$i]["cnumber"]) && $users[$i]["cnumber"][0] != ''){
							$cnumHTM = '';
							for($j=0;$j<=sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != '';$j++){
								$cnumHTM .= '<li>'.ltrim( $users[$i]["cnumber"][$j] ,',').'</li>';
							}
						}
					}
				}
			}
			return $cnumHTM;
		}
		/* Products */
		public function loadPrdNameForm() {
			$users = user::listUser();
			$html = '';
			$pnameHTM = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$prdnames = array(
				"oldprdname" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						$pnameHTM = '';
						/* Products */
						if(is_array($users[$i]["prdname"])){
							for($j=0;$j<=sizeof($users[$i]["prdname"]) && isset($users[$i]["prdname"][$j]) && $users[$i]["prdname"][$j] != '';$j++){
								$flag = true;
								$prdnames["oldprdname"][$j] =  array(
													"id" 		=> ltrim($users[$i]["prd_pk"][$j] ,','),
													"value" 	=> ltrim($users[$i]["prdname"][$j] ,','),
													"form" 		=> $this->parameters["form"].$j,
													"textid" 	=> $this->parameters["prdname"].$j,
													"msgid" 	=> $this->parameters["msgDiv"].$j,
													"deleteid" 	=> $this->parameters["prdname"].$j.'_delete',
													"deleteOk"  => 'deletePnameOk_'.ltrim($users[$i]["prd_pk"][$j] ,',').'_'.$j,
													"deleteCancel" => 'deletePnameCancel_'.ltrim($users[$i]["prd_pk"][$j] ,',').'_'.$j
												);
								$pnameHTM .= '<div id="'.$prdnames["oldprdname"][$j]["form"].'">
												<div class="form-group input-group">
												<input class="form-control" placeholder="Product name" name="'.$prdnames["oldprdname"][$j]["id"].'" type="text" id="'.$prdnames["oldprdname"][$j]["textid"].'" maxlength="10" value="'.ltrim( $users[$i]["prdname"][$j] ,',').'" />
												<span class="input-group-addon">
													<button class="btn btn-danger btn-circle" id="'.$prdnames["oldprdname"][$j]["deleteid"].'" data-toggle="modal" data-target="#myPnameModal_'.$j.'">
														<i class="fa fa-trash fa-fw"></i>
													</button>
													<div class="modal fade" id="myPnameModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="myPnameModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
													<div class="modal-dialog">
													<div class="modal-content" style="color:#000;">
													<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title" id="myPnameModalLabel_'.$j.'">Delete product entry</h4>
													</div>
													<div class="modal-body">
													Do You really want to delete <strong>'.ltrim( $users[$i]["prdname"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
													</div>
													<div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$prdnames["oldprdname"][$j]["deleteOk"].'">Ok</button>
													<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$prdnames["oldprdname"][$j]["deleteCancel"].'">Cancel</button>
													</div>
													</div>
													</div>
													</div>
												</span>
												</div>
												<div class="col-lg-12" id="'.$prdnames["oldprdname"][$j]["form"].'">
													<p class="help-block" id="'.$prdnames["oldprdname"][$j]["msgid"].'">Valid.</p>
												</div>
											</div>';
							}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra Products : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $pnameHTM).'</div>';
				$prdnames["html"] = $html;
			}
			return $prdnames;
		}
		public function editPrdName() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["PrdNames"]["uid"];
			/* Product Insert */
			if(isset($this->parameters["PrdNames"]["insert"]) && is_array($this->parameters["PrdNames"]["insert"]) && sizeof($this->parameters["PrdNames"]["insert"]) > -1 && $user_pk > 0){
				$directory_prod = array();
				$product_pk = array();
				for($i=0;$i<sizeof($this->parameters["PrdNames"]["insert"]);$i++){
					$query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
							NULL,NULL,NULL,NULL,NULL,NULL);';
					executeQuery($query);
					$photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
					$query = 'INSERT INTO  `product` (`id`,`name`,`photo_id`,`doc`,`status_id`,`user_pk`) VALUES (NULL,
								\''.mysql_real_escape_string($this->parameters["PrdNames"]["insert"][$i]).'\',
								\''.mysql_real_escape_string($photo_pk).'\',
								default,
								4,'.mysql_real_escape_string($user_pk).');';
					executeQuery($query);
					$product_pk[$i] = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'),0);
					$directory_prod[$i] = substr(md5(microtime()),0,6).'_product_'.$product_pk[$i];
					/* Assign product to user */
					$query = 'INSERT INTO  `user_product` (`id`,`product_id`,`user_pk`,`status_id`) VALUES (NULL,
							\''.mysql_real_escape_string($product_pk[$i]).'\',
							\''.mysql_real_escape_string($user_pk).'\',
							4);';
					executeQuery($query);
				}
				for($i=0;$i<sizeof($this->parameters["PrdNames"]["insert"]);$i++){
					createdirectories($directory_prod[$i]);
					executeQuery('UPDATE `product` SET `directory` = \''.ASSET_DIR.$directory_prod[$i].'\' WHERE `id`=\''.mysql_real_escape_string($product_pk[$i]).'\';');
				}
				$flag = true;
			}
			/* Product Update */
			if(isset($this->parameters["PrdNames"]["update"]) && is_array($this->parameters["PrdNames"]["update"]) && sizeof($this->parameters["PrdNames"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["PrdNames"]["update"]);$i++){
					$query = 'UPDATE  `product`
							 SET `name` = \''.mysql_real_escape_string($this->parameters["PrdNames"]["update"][$i]["prdname"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["PrdNames"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function deletePrdName() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* Emails Update */
			if(isset($this->parameters["eid"]) && $this->parameters["eid"] > -1){
				$query = 'UPDATE  `product`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["eid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listPrdNames() {
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$pnameHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Products */
						if(is_array($users[$i]["prdname"]) && $users[$i]["prdname"][0] != ''){
							$pnameHTM = '';
							for($j=0;$j<=sizeof($users[$i]["prdname"]) && isset($users[$i]["prdname"][$j]) && $users[$i]["prdname"][$j] != '';$j++){
								$pnameHTM .= '<li>'.ltrim( $users[$i]["prdname"][$j] ,',').'&nbsp; <img src="'.ltrim($users[$i]["prdphoto"][$j] ,',').'" width="50" /> </li>';
							}
						}
					}
				}
			}
			return $pnameHTM;
		}
		/* Bank account */
		public function loadBankAcForm() {
			$users = user::listUser();
			$html = '';
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$banks = array(
				"oldbank" => NULL,
				"html" => NULL
			);
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						$backacHTM = '';
						/* Bank Account */
						if(is_array($users[$i]["bank_name"])){
							for($j=0;$j<=sizeof($users[$i]["bank_name"]) && isset($users[$i]["bank_name"][$j]) && $users[$i]["bank_name"][$j] != '';$j++){
								$banks["oldbank"][$j] =  array(
										"id" 		=> ltrim($users[$i]["bank_pk"][$j] ,','),
										"form" 		=> $this->parameters["form"].$j,
										"bankname" 	=> $this->parameters["bankname"].$j,
										"nmsg" 		=> $this->parameters["nmsg"].$j,
										"accno" 	=> $this->parameters["accno"].$j,
										"nomsg" 	=> $this->parameters["nomsg"].$j,
										"braname" 	=> $this->parameters["braname"].$j,
										"bnmsg"   	=> $this->parameters["bnmsg"].$j,
										"bracode" 	=> $this->parameters["bracode"].$j,
										"bcmsg" 	=> $this->parameters["bcmsg"].$j,
										"IFSC" 		=> $this->parameters["IFSC"].$j,
										"IFSCmsg" 	=> $this->parameters["IFSCmsg"].$j,
										"deleteid" 	=> $this->parameters["bankname"].$j.'_delete',
										"deleteOk"  => 'deleteBnkAcOk_'.ltrim($users[$i]["bank_pk"][$j] ,',').'_'.$j,
										"deleteCancel" => 'deleteBnkAcCancel_'.ltrim($users[$i]["bank_pk"][$j] ,',').'_'.$j
								);
								$backacHTM .= '<div id="'.$banks["oldbank"][$j]["form"].'">
									<div class="col-lg-12">
										<div class="panel panel-warning">
											<div class="panel-heading">
												<strong>Bank account</strong>
												&nbsp;<button class="btn btn-danger btn-circle" id="'.$banks["oldbank"][$j]["deleteid"].'" data-toggle="modal" data-target="#mybanknameModal_'.$j.'"><i class="fa fa-trash fa-fw"></i></button>
												<div class="modal fade" id="mybanknameModal_'.$j.'" tabindex="-1" role="dialog" aria-labelledby="mybanknameModalLabel_'.$j.'" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
												<div class="modal-content" style="color:#000;" >
												<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="mybanknameModalLabel_'.$j.'">Delete Bank Account</h4>
												</div>
												<div class="modal-body">
												Do You really want to delete <strong>'.ltrim($users[$i]["bank_name"][$j] ,',').'</strong> ?? press <strong>OK</strong> to delete
												</div>
												<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="'.$banks["oldbank"][$j]["deleteOk"].'">Ok</button>
												<button type="button" class="btn btn-success" data-dismiss="modal" id="'.$banks["oldbank"][$j]["deleteCancel"].'">Cancel</button>
												</div>
												</div>
												</div>
												</div>
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="col-lg-12">
														<input class="form-control" placeholder="Bank Name" name="'.$banks["oldbank"][$j]["id"].'" type="text" id="'.$banks["oldbank"][$j]["bankname"].'" maxlength="100" value="'.ltrim($users[$i]["bank_name"][$j] ,',').'"/>
														<p class="help-block" id="'.$banks["oldbank"][$j]["nmsg"].'">Valid.</p>
													</div>
													<div class="col-lg-12">&nbsp;</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<input class="form-control" placeholder="Account Number" name="'.$banks["oldbank"][$j]["id"].'" type="text" id="'.$banks["oldbank"][$j]["accno"].'" maxlength="100" value="'.ltrim($users[$i]["ac_no"][$j] ,',').'"/>
														<p class="help-block" id="'.$banks["oldbank"][$j]["nomsg"].'">Valid.</p>
													</div>
													<div class="col-lg-12">&nbsp;</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<input class="form-control" placeholder="Branch Name" name="'.$banks["oldbank"][$j]["id"].'" type="text" id="'.$banks["oldbank"][$j]["braname"].'" maxlength="100" value="'.ltrim($users[$i]["branch"][$j] ,',').'"/>
														<p class="help-block" id="'.$banks["oldbank"][$j]["bnmsg"].'">Valid.</p>
													</div>
													<div class="col-lg-12">&nbsp;</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<input class="form-control" placeholder="Branch Code" name="'.$banks["oldbank"][$j]["id"].'" type="text" id="'.$banks["oldbank"][$j]["bracode"].'" maxlength="100" value="'.ltrim($users[$i]["branch_code"][$j] ,',').'"/>
														<p class="help-block" id="'.$banks["oldbank"][$j]["bcmsg"].'">Valid.</p>
													</div>
													<div class="col-lg-12">&nbsp;</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<input class="form-control" placeholder="IFSC" name="'.$banks["oldbank"][$j]["id"].'" type="text" id="'.$banks["oldbank"][$j]["IFSC"].'" maxlength="100" value="'.ltrim($users[$i]["IFSC"][$j] ,',').'"/>
														<p class="help-block" id="'.$banks["oldbank"][$j]["IFSCmsg"].'">Valid.</p>
													</div>
													<div class="col-lg-12">&nbsp;</div>
												</div>
											</div>
										</div>
									</div>
								</div>';
							}
						}
					}
				}
				$html = '<div class="col-lg-12">
							Add extra Bank : <button class="btn btn-success btn-circle" id="'.$this->parameters["plus"].'"><i class="fa fa-plus fa-fw "></i></button>
							&nbsp;<button class="btn btn-info btn-circle" id="'.$this->parameters["saveBut"].'"><i class="fa fa-save fa-fw "></i></button>
							&nbsp;<button class="btn btn-danger btn-circle" id="'.$this->parameters["closeBut"].'"><i class="fa fa-close fa-fw "></i></button>
						</div><div class="col-lg-12">'.str_replace($this->order, $this->replace, $backacHTM).'</div>';
				$banks["html"] = $html;
			}
			return $banks;
		}
		public function editBankAc() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["BankAcs"]["uid"];
			/* Bank Account Insert */
			if(isset($this->parameters["BankAcs"]["insert"]) && is_array($this->parameters["BankAcs"]["insert"]) && sizeof($this->parameters["BankAcs"]["insert"]) > -1 && $user_pk > 0){
				$directory_prod = array();
				$product_pk = array();
				$query = 'INSERT INTO  `bank_accounts` (`id`,`user_pk`,`bank_name`,`ac_no`,`branch`,`branch_code`,`IFSC`,`status_id`)  VALUES';
				for($i=0;$i<sizeof($this->parameters["BankAcs"]["insert"]);$i++){
					if($i == sizeof($this->parameters["BankAcs"]["insert"])-1)
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bankname"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["accno"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["braname"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bracode"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["IFSC"]).'\',
								4);';
					else
						$query .= '(NULL,\''.mysql_real_escape_string($user_pk).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bankname"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["accno"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["braname"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bracode"]).'\',
								\''.mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["IFSC"]).'\',
								4),';
				}
				executeQuery($query);
				$flag = true;
			}
			/*  Bank Account Update */
			if(isset($this->parameters["BankAcs"]["update"]) && is_array($this->parameters["BankAcs"]["update"]) && sizeof($this->parameters["BankAcs"]["update"]) > -1 && $user_pk > 0){
				for($i=0;$i<sizeof($this->parameters["BankAcs"]["update"]);$i++){
					$query = 'UPDATE  `bank_accounts`
							 SET `bank_name` = \''.mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["bankname"]).'\',
							 `ac_no` = \''.mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["accno"]).'\',
							 `branch` = \''.mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["braname"]).'\',
							 `branch_code` = \''.mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["bracode"]).'\',
							 `IFSC` = \''.mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["IFSC"]).'\'
							 WHERE `id` = \''.mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["id"]).'\';';
					executeQuery($query);
				}
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function deleteBankAc() {
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			/* Emails Update */
			if(isset($this->parameters["eid"]) && $this->parameters["eid"] > -1){
				$query = 'UPDATE  `bank_accounts`
						 SET `status_id` = 6
						 WHERE `id` = \''.mysql_real_escape_string($this->parameters["eid"]).'\';';
				executeQuery($query);
				$flag = true;
			}
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listBankAcs() {
			/* Bank account */
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$backacHTM = '<li>Not Provided</li>';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						/* Bank account */
						$backacHTM = '';
						if(is_array($users[$i]["bank_name"]) && $users[$i]["bank_name"][0] != ''){
							for($j=0;$j<=sizeof($users[$i]["bank_name"]) && isset($users[$i]["bank_name"][$j]) && $users[$i]["bank_name"][$j] != '';$j++){
								$backacHTM .= '<li>
											'.ltrim($users[$i]["bank_name"][$j] ,',').',&nbsp;
											'.ltrim($users[$i]["ac_no"][$j] ,',').',&nbsp;
											'.ltrim($users[$i]["branch"][$j] ,',').',&nbsp;
											'.ltrim($users[$i]["branch_code"][$j] ,',').',&nbsp;
											'.ltrim($users[$i]["IFSC"][$j] ,',').'
											</li>';
							}
						}
					}
				}
			}
			return $backacHTM;
		}
		/* Address */
		public function editAddress(){
			$flag = false;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$user_pk = $this->parameters["uid"];
			/* Profile Address */
			$query = 'UPDATE  `user_profile`
					SET `addressline` = \''.mysql_real_escape_string($this->parameters["addrsline"]).'\',
						`town` = \''.mysql_real_escape_string($this->parameters["st_loc"]).'\',
						`city` = \''.mysql_real_escape_string($this->parameters["city_town"]).'\',
						`district` = \''.mysql_real_escape_string($this->parameters["district"]).'\',
						`province` = \''.mysql_real_escape_string($this->parameters["province"]).'\',
						`province_code` = \''.mysql_real_escape_string($this->parameters["provinceCode"]).'\',
						`country` = \''.mysql_real_escape_string($this->parameters["country"]).'\',
						`country_code` = \''.mysql_real_escape_string($this->parameters["countryCode"]).'\',
						`zipcode` = \''.mysql_real_escape_string($this->parameters["zipcode"]).'\',
						`website` = \''.mysql_real_escape_string($this->parameters["website"]).'\',
						`latitude` = \''.mysql_real_escape_string($this->parameters["lat"]).'\',
						`longitude` = \''.mysql_real_escape_string($this->parameters["lon"]).'\',
						`timezone` = \''.mysql_real_escape_string($this->parameters["timezone"]).'\',
						`gmaphtml` = \''.mysql_real_escape_string($this->parameters["gmaphtml"]).'\'
					WHERE `id` = \''.mysql_real_escape_string($user_pk).'\';';
			$flag = executeQuery($query);
			if($flag){
				executeQuery("COMMIT");
			}
			return $flag;
		}
		public function listAddress(){
			$users = user::listUser();
			$num_posts = 0;
			if(isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
				$users = $_SESSION[$this->parameters["sindex"]];
			else
				$users = NULL;
			if($users != NULL)
				$num_posts = sizeof($users);
			$addrHTM = '';
			if($num_posts > 0){
				for($i=0;$i < $num_posts && isset($users[$i]['usrid']);$i++){
					if($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]){
						$addrHTM .= '<ul>
										<li><strong>Address line : </strong>'.$users[$i]["addressline"].'</li>
										<li><strong>Street / Locality : </strong>'.$users[$i]["town"].'</li>
										<li><strong>City / Town : </strong>'.$users[$i]["city"].'</li>
										<li><strong>District / Department : </strong>'.$users[$i]["district"].'</li>
										<li><strong>State / Provice : </strong>'.$users[$i]["province"].'</li>
										<li><strong>Country : </strong>'.$users[$i]["country"].'</li>
										<li><strong>Zipcode : </strong>'.$users[$i]["zipcode"].'</li>
										<li><strong>Website : </strong>'.$users[$i]["website"].'</li>
										<li><strong>Google Map : </strong>'.$users[$i]["website"].'</li>
									</ul>';
					}
				}
			}
			return $addrHTM;
		}
		public function deleteUser() {
			$flag = false;
			$query = NULL;
			executeQuery("SET AUTOCOMMIT=0;");
			executeQuery("START TRANSACTION;");
			$query = 'UPDATE  `user_profile` SET `status_id`=6 WHERE `id` = "'.mysql_real_escape_string($this->parameters["entry"]).'";';
			if(executeQuery($query)){
				$flag = true;
				executeQuery("COMMIT;");
			}
			return $flag;
		}
	}
?>