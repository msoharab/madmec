<?php
	class crm{
		protected $parameters = array();
		function __construct($para = false) {
			$this->parameters = $para;
		}
		public function smsSaleEntry(){
			$query = '';
			$msg = '';
			$pid = 0;
			$from_pk = $_SESSION["USER_LOGIN_DATA"]["USER_ID"];
			$distributor = $_SESSION["USER_LOGIN_DATA"]["USER_NAME"];
			$to_pk = 0;
			$user_name = 0;
			$saleentry_date = '';
			$no_packs = 0;
			$unit_weight = 0;
			$rate = 0;
			$amount = 0;
			$due = 0;
			switch($this->parameters["msgType"]){
				case 'saleentry':
					$query = 'SELECT
							c.`id`  AS pid,
							c.`sales_id`,
							c.`to_pk`,
							c.`saleentry_date`,
							c.`no_packs`,
							c.`unit_weight`,
							c.`rate`,
							c.`amount`,
							c.`due_id`,
							c.`tblname`,
							c.`invlocation`,
							
							b.`id` AS dueid,
							b.`user_pk`,
							DATE_FORMAT(b.`due_date`,\'%d-%b-%Y\') AS due_date,
							b.`due_amount`,
							
							users.`id` AS usr_id,
							users.`user_name`,
							users.`usrphoto`,
							users.`email`,
							users.`cnumber`,
							users.`tnumber`,
							users.`addressline`,
							users.`town`,
							users.`city`
						FROM
						(
							SELECT
								c.`id`,
								c.`sales_id`,
								c.`to_pk`,
								CASE WHEN (d.`id` IS NULL OR d.`id` = "")
									 THEN DATE_FORMAT(c.`patti_date`,\'%d-%b-%Y\')
									 ELSE 
										CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
											 THEN DATE_FORMAT(d.`patti_alt_date`,\'%d-%b-%Y\')
											 ELSE NULL
										END
								END AS saleentry_date,
								CASE WHEN (d.`id` IS NULL OR d.`id` = "")
									 THEN c.`no_packs`
									 ELSE 
										CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
											 THEN d.`no_packs`
											 ELSE NULL
										END
								END AS no_packs,
								CASE WHEN (d.`id` IS NULL OR d.`id` = "")
									 THEN c.`unit_weight`
									 ELSE 
										CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
											 THEN d.`unit_weight`
											 ELSE NULL
										END
								END AS unit_weight,
								CASE WHEN (d.`id` IS NULL OR d.`id` = "")
									 THEN c.`rate`
									 ELSE 
										CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
											 THEN d.`rate`
											 ELSE NULL
										END
								END AS rate,
								CASE WHEN (d.`id` IS NULL OR d.`id` = "")
									 THEN c.`amount`
									 ELSE 
										CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
											 THEN d.`amount`
											 ELSE NULL
										END
								END AS amount,
								c.`due_id`,
								CASE WHEN (d.`id` IS NULL OR d.`id` = "")
									 THEN "patti"
									 ELSE "patti_alterations"
								END AS tblname,
								/* 
									CASE WHEN (d.`id` IS NULL OR d.`id` = "")
										 THEN CONCAT("'.URL.'",e.`location`)
										 ELSE CONCAT("'.URL.'",f.`location`)
									END AS invlocation,
								*/
								CONCAT("'.URL.'",e.`location`) AS invlocation,
								c.`status_id`
							FROM `patti` AS c
							LEFT JOIN `patti_alterations` AS d  ON c.`id` = d.`patti_id`
							LEFT JOIN `invoice` AS e  ON c.`id` = e.`patti_id`
							LEFT JOIN `rev_invoice` AS f  ON d.`id` = f.`patti_alt_id`
							WHERE c.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							AND c.`id` =\''.mysql_real_escape_string($this->parameters["pid"]).'\'
							ORDER BY (c.`id`) 
						) AS c
						LEFT JOIN `due` AS b ON c.`due_id` = b.`id`
						LEFT JOIN (
							SELECT
								a.`id`,
								a.`user_name`,
								a.`acs_id`,
								a.`directory`,
								a.`password`,
								CONCAT(a.`postal_code`, "-", a.`telephone`) AS tnumber,
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
									 THEN "Not provided"
									 ELSE a.`website`
								END AS website,
								CONCAT(
									CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
										 THEN "---"
										 ELSE a.`postal_code`
									END,
									CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
										 THEN "Not provided"
										 ELSE a.`telephone`
									END
								) AS telephonenumber,
								CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
									 THEN "'.USER_ANON_IMAGE .'"
									 ELSE CONCAT("'.URL.ASSET_DIR.'",ph.`ver2`)
								END AS usrphoto,
								a.`status_id`,
								b.`email` AS email,
								c.`cnumber` AS cnumber,
								d.`bank_name` AS bank_name,
								d.`ac_no` AS ac_no,
								d.`branch` AS branch,
								d.`branch_code` AS branch_code,
								d.`IFSC` AS IFSC,
								e.`name` AS prdname,
								e.`prdphoto` AS prdphoto,
								f.`user_type`,
								g.`gender_name`
							FROM `user_profile` AS a
							LEFT JOIN `photo` AS ph ON a.`photo_id` = ph.`id`
							LEFT JOIN (
								SELECT
									em.`id`,
									GROUP_CONCAT(em.`email`,"☻☻♥♥☻☻") AS email,
									em.`user_pk`
								FROM `email_ids` AS em
								WHERE em.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								GROUP BY (em.`user_pk`)
								ORDER BY (em.`user_pk`)
							)  AS b ON a.`id` = b.`user_pk`
							LEFT JOIN (
								SELECT
									cn.`id`,
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
									ba.`id`,
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
									prd.`id`,
									GROUP_CONCAT(prd.`name`,"☻☻♥♥☻☻") AS name,
									GROUP_CONCAT(
										CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
											 THEN "'.VEGIE_IMAGE.'"
											 ELSE CONCAT("'.URL.ASSET_DIR.'",ph.`ver2`)
										END,"☻☻♥♥☻☻"
									) AS prdphoto,
									urpd.`user_pk`
								FROM `product` AS prd
								LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
								JOIN `user_product` AS urpd ON prd.`id` = urpd.`product_id` AND urpd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								GROUP BY (urpd.`user_pk`)
								ORDER BY (urpd.`user_pk`)
							) AS e ON a.`id` = e.`user_pk`
							LEFT JOIN (
								SELECT
									utype.`id`,
									utype.`user_type`
								FROM `user_type` AS utype
								WHERE utype.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							) AS f ON a.`user_type_id` = f.`id`
							LEFT JOIN `gender` AS g ON a.`gender` = g.`id`
							WHERE (f.`id` !=  9)
							AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																		`statu_name` = "Hide" OR
																		`statu_name` = "Delete" OR
																		`statu_name` = "Fired" OR
																		`statu_name` = "Inactive" OR
																		`statu_name` = "Flag"))
							ORDER BY (a.`id`)
						) AS users  ON users.`id` = c.`to_pk`
						WHERE c.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND c.`id` =\''.mysql_real_escape_string($this->parameters["pid"]).'\'
						ORDER BY (c.`id`);';
					$res = executeQuery($query);
					if(mysql_num_rows($res) > 0){
						$row = mysql_fetch_assoc($res);
						$pid = $row["pid"];
						$from_pk = $_SESSION["distributor"]["id"];
						$distributor = $_SESSION["distributor"]["name"];
						$to_pk = $row["to_pk"];
						$user_name = $row["user_name"];
						$saleentry_date = $row["saleentry_date"];
						$no_packs = $row["no_packs"];
						$unit_weight = $row["unit_weight"];
						$rate = $row["rate"];
						$amount = $row["amount"];
						$due = $row["due_amount"];
						$msg = 'From '.$distributor.
							   ', TO '.$user_name.
							   ', Purchased on '.$saleentry_date.
							   ', Packs '.$no_packs.
							   ', Kg\'s '.$unit_weight.' * Rate '.$rate.' = Total '.$amount;
						// .', Due  = '.$due.' Balance'
					}
				break;
				case '':
				break;
			}
			$restPara = array(
				"user" 					=> 'madmec',
				"password" 				=> 'madmec',
				"mobiles" 				=> $this->parameters["num"],
				"sms" 					=> $msg,
				"senderid" 				=> 'MADMEC',
				"version" 				=> 3,
				"accountusagetypeid"	=> 1
			);
			$url = 'http://trans.profuseservices.com/sendsms.jsp?'.http_build_query($restPara);
			$response = file_get_contents($url);
			if($response){
				$query = 'INSERT INTO `crm_sms`(`id`,
												`from_pk`,
												`to_pk`, 
												`to_mobile`, 
												`text`, 
												`msg_type`, 
												`date`, 
												`status_id`) VALUES 
							(NULL,
							\''.mysql_real_escape_string($_SESSION["distributor"]["id"]).'\',
							\''.mysql_real_escape_string($to_pk).'\',
							\''.mysql_real_escape_string($this->parameters["num"]).'\',
							\''.mysql_real_escape_string($msg).'\',
							1,
							NOW(),
							14);';
				 executeQuery($query);
			}			
		}
	}
?>