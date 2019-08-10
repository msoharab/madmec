<?php
class purchase {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }
    public function startConsignment() {

        $vehicle_pk = 0;
        $patti_ref_no = sprintf("%010s", mysql_result(executeQuery('SELECT COUNT(`id`) FROM `sales`;'), 0) + 1);
        $sales_pk = 0;
        $purchase_pk = 0;
        $product_pk = 0;
        $flag = false;
        if ($this->parameters["sid"] > 0) {
            executeQuery("SET AUTOCOMMIT=0;");
            executeQuery("START TRANSACTION;");
            /* Vehicle */
            $query1 = 'INSERT INTO  `vehicle` (`id`,
                                `consignee`,
                                `driver`,
                                `vehicle_no`,
                                `packing_type_id`,
                                `total_packs`,
                                `total_weight`,
                                `loaded_weight`,
                                `empty_weight`,
                                `advance_amt`,
                                `rent`,
                                `arrival`,
                                `departure`,
                                `status_id` )  VALUES(
                                NULL,
                                \'' . mysql_real_escape_string($this->parameters["sid"]) . '\',
                                NULL,
                                \'' . mysql_real_escape_string($this->parameters["vehicle"]) . '\',
                                \'' . mysql_real_escape_string($this->parameters["pack_type"]) . '\',
                                \'' . mysql_real_escape_string($this->parameters["packs"]) . '\',
                                NULL,
                                NULL,
                                NULL,
                                NULL,
                                NULL,
                                \'' . mysql_real_escape_string($this->parameters["date"]) . '\',
                                NULL,
                                4);';

            $res1 = executeQuery($query1);
            $vehicle_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Sales */
            $query2 = 'INSERT INTO  `sales` (`id`,
                        `from_pk`,
                        `to_pk`,
                        `product_id`,
                        `packing_type_id`,
                        `vehicle_id`,
                        `sales_date`,
                        `patti_ref_no`,
                        `total_packs`,
                        `total_weight`,
                        `balance`,
                        `status_id` )  VALUES(
                        NULL,
                        \'' . mysql_real_escape_string($this->parameters["sid"]) . '\',
                        \'' . mysql_real_escape_string($_SESSION["distributor"]["id"]) . '\',
                        \'' . mysql_real_escape_string($this->parameters["pid"]) . '\',
                        \'' . mysql_real_escape_string($this->parameters["pack_type"]) . '\',
                        \'' . mysql_real_escape_string($vehicle_pk) . '\',
                        \'' . mysql_real_escape_string($this->parameters["date"]) . '\',
                        \'' . mysql_real_escape_string($patti_ref_no) . '\',
                        \'' . mysql_real_escape_string($this->parameters["packs"]) . '\',
                        NULL,
                        NULL,
                        4);';

            $res2 = executeQuery($query2);
            $sales_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Purchase */
            $query3 = 'INSERT INTO  `purchase` (`id`,
                                `from_pk`,
                                `to_pk`,
                                `sales_id`,
                                `vehicle_id`,
                                `product_id`,
                                `packing_type_id`,
                                `patti_ref_no`,
                                `patti_date`,
                                `total_sale`,
                                `total_exp`,
                                `net_sales`,
                                `location`,
                                `status_id` )  VALUES(
                                NULL,
                                \'' . mysql_real_escape_string($this->parameters["sid"]) . '\',
                                \'' . mysql_real_escape_string($_SESSION["distributor"]["id"]) . '\',
                                \'' . mysql_real_escape_string($sales_pk) . '\',
                                \'' . mysql_real_escape_string($vehicle_pk) . '\',
                                \'' . mysql_real_escape_string($this->parameters["pid"]) . '\',
                                \'' . mysql_real_escape_string($this->parameters["pack_type"]) . '\',
                                \'' . mysql_real_escape_string($patti_ref_no) . '\',
                                \'' . mysql_real_escape_string($this->parameters["date"]) . '\',
                                NULL,
                                NULL,
                                NULL,
                                NULL,
                                4);';

            $res3 = executeQuery($query3);
            $purchase_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Consignment */
            $query4 = 'INSERT INTO  `consignment` (`id`,
                                `consignee`,
                                `consignor`,
                                `vehicle_id`,
                                `product_id`,
                                `purchase_id`,
                                `sales_id`,
                                `consignment_date`,
                                `status_id` )  VALUES(
                                NULL,
                                \'' . mysql_real_escape_string($this->parameters["sid"]) . '\',
                                \'' . mysql_real_escape_string($_SESSION["distributor"]["id"]) . '\',
                                \'' . mysql_real_escape_string($vehicle_pk) . '\',
                                \'' . mysql_real_escape_string($this->parameters["pid"]) . '\',
                                \'' . mysql_real_escape_string($purchase_pk) . '\',
                                \'' . mysql_real_escape_string($sales_pk) . '\',
                                \'' . mysql_real_escape_string($this->parameters["date"]) . '\',
                                4);';

            $res4 = executeQuery($query4);
            if ($res1 && $res2 && $res3 && $res4) {
                executeQuery("COMMIT");
                $flag = true;
            }
        }
        return $flag;
    }
    public function listpurchase() {
        $pattys = array();
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
						) AS tnumber,
						CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
							 THEN "' . USER_ANON_IMAGE . '"
							 ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
						END AS usrphoto,
						a.`status_id`,
						b.`email` AS email,
						c.`cnumber` AS cnumber,
						d.`id` AS bank_id,
						d.`bank_name` AS bank_name,
						d.`ac_no` AS ac_no,
						d.`branch` AS branch,
						d.`branch_code` AS branch_code,
						d.`IFSC` AS IFSC,
						e.`id` AS prdid,
						e.`name` AS prdname,
						e.`prdphoto` AS prdphoto,
						f.`user_type`,
						g.`gender_name`,
						/* Consignment */
						h.`conid`,
						h.`supplier`,
						h.`distributor`,
						/* Vehicle */
						h.`vhid`,
						h.`driver`,
						h.`vehicle_no`,
						h.`packtype`,
						h.`loaded_weight`,
						h.`empty_weight`,
						h.`advance_amt`,
						h.`rent`,
						h.`arrival`,
						h.`departure`,
						/* Product */
						h.`prdid` AS saleprdid,
						h.`name` AS saleprdname,
						h.`prdphoto` AS saleprdphoto,
						/* Purchase */
						h.`prchid`,
						h.`patti_date`,
						h.`total_sale`,
						h.`total_exp`,
						h.`net_sales`,
						h.`avg_rate`,
						h.`location`,
						h.`lorry_hire`,
						h.`commision_cash`,
						h.`labour`,
						h.`association_fee`,
						h.`post_fee`,
						h.`rmc`,
						h.`totalexp`,
						h.`purchpt`,
						h.`purchqt`,
						h.`purchprt`,
						h.`purchwt`,
						h.`purchrt`,
						h.`purchat`,
						/* Sales */
						h.`pattyid`,
						h.`sales_date`,
						h.`patti_ref_no`,
						h.`total_packs`,
						h.`total_weight`,
						h.`balance`,
						h.`patti_packs`,
						h.`patti_wt`,
						h.`patti_rt`,
						h.`patti_at`,
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
						/* Due */
						k.`dueid`,
						k.`due_date`,
						k.`due_amount`,
						/* Sale entries */
						l.`se_id`,
						l.`se_date`,
						l.`se_prd`,
						l.`se_nopacks`,
						l.`se_untwt`,
						l.`se_rate`,
						l.`se_amount`,
						l.`se_tblname`,
						l.`se_invloc`
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
							GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`),"☻☻♥♥☻☻") AS cnumber
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
							GROUP_CONCAT(prd.`id`,"☻☻♥♥☻☻") AS id,
							GROUP_CONCAT(prd.`name`,"☻☻♥♥☻☻") AS name,
							GROUP_CONCAT(
								CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
									 THEN "' . VEGIE_IMAGE . '"
									 ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
								END,"☻☻♥♥☻☻"
							) AS prdphoto,
							urpd.`user_pk`
						FROM `product` AS prd
						LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
						LEFT JOIN `user_product` AS urpd ON prd.`id` = urpd.`product_id`
						WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND urpd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (urpd.`user_pk`)
						ORDER BY (urpd.`user_pk`)
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
							/* Consignment */
							GROUP_CONCAT(a.`id`,"♥♥♥") AS conid,
							GROUP_CONCAT(a.`consignee`,"♥♥♥") AS supplier,
							GROUP_CONCAT(a.`consignor`,"♥♥♥") AS distributor,
							/* Vehicle */
							GROUP_CONCAT(b.`id`,"♥♥♥") AS vhid,
							GROUP_CONCAT(b.`driver`,"♥♥♥") AS driver,
							GROUP_CONCAT(b.`vehicle_no`,"♥♥♥") AS vehicle_no,
							GROUP_CONCAT(b.`packing_type`,"♥♥♥") AS packtype,
							GROUP_CONCAT(b.`loaded_weight`,"♥♥♥") AS loaded_weight,
							GROUP_CONCAT(b.`empty_weight`,"♥♥♥") AS empty_weight,
							GROUP_CONCAT(b.`advance_amt`,"♥♥♥") AS advance_amt,
							GROUP_CONCAT(b.`rent`,"♥♥♥") AS rent,
							GROUP_CONCAT(b.`arrival`,"♥♥♥") AS arrival,
							GROUP_CONCAT(b.`departure`,"♥♥♥") AS departure,
							/* Product */
							GROUP_CONCAT(c.`id`,"♥♥♥") AS prdid,
							GROUP_CONCAT(c.`name`,"♥♥♥") AS name,
							GROUP_CONCAT(c.`prdphoto`,"♥♥♥") AS prdphoto,
							/* Purchase */
							GROUP_CONCAT(d.`id`,"♥♥♥") AS prchid,
							GROUP_CONCAT(DATE_FORMAT(d.`patti_date`,"%Y-%c-%d"),"♥♥♥") AS patti_date,
							GROUP_CONCAT(d.`total_sale`,"♥♥♥") AS total_sale,
							GROUP_CONCAT(d.`total_exp`,"♥♥♥") AS total_exp,
							GROUP_CONCAT(d.`avg_rate`,"♥♥♥") AS avg_rate,
							GROUP_CONCAT(d.`net_sales`,"♥♥♥") AS net_sales,
							GROUP_CONCAT(d.`location`,"♥♥♥") AS location,
							GROUP_CONCAT(d.`lorry_hire`,"♥♥♥") AS lorry_hire,
							GROUP_CONCAT(d.`commision_cash`,"♥♥♥") AS commision_cash,
							GROUP_CONCAT(d.`labour`,"♥♥♥") AS labour,
							GROUP_CONCAT(d.`association_fee`,"♥♥♥") AS association_fee,
							GROUP_CONCAT(d.`post_fee`,"♥♥♥") AS post_fee,
							GROUP_CONCAT(d.`rmc`,"♥♥♥") AS rmc,
							GROUP_CONCAT(d.`totalexp`,"♥♥♥") AS totalexp,
							GROUP_CONCAT(d.`packing_type`,"♥♥♥") AS purchpt,
							GROUP_CONCAT(d.`quantity`,"♥♥♥") AS purchqt,
							GROUP_CONCAT(d.`particulars`,"♥♥♥") AS purchprt,
							GROUP_CONCAT(d.`weight_kg`,"♥♥♥") AS purchwt,
							GROUP_CONCAT(d.`rate`,"♥♥♥") AS purchrt,
							GROUP_CONCAT(d.`amount`,"♥♥♥") AS purchat,
							/* Sales */
							GROUP_CONCAT(e.`pattyid`,"♥♥♥") AS pattyid,
							GROUP_CONCAT(e.`from_pk`,"♥♥♥") AS from_pk,
							GROUP_CONCAT(e.`to_pk`,"♥♥♥") AS to_pk,
							GROUP_CONCAT(DATE_FORMAT(e.`sales_date`,"%Y-%c-%d"),"♥♥♥") AS sales_date,
							GROUP_CONCAT(e.`patti_ref_no`,"♥♥♥") AS patti_ref_no,
							GROUP_CONCAT(e.`total_packs`,"♥♥♥") AS total_packs,
							GROUP_CONCAT(e.`total_weight`,"♥♥♥") AS total_weight,
							GROUP_CONCAT(e.`balance`,"♥♥♥") AS balance,
							GROUP_CONCAT(e.`tot_sal_packs`,"♥♥♥") AS patti_packs,
							GROUP_CONCAT(e.`tot_sal_weight`,"♥♥♥") AS patti_wt,
							GROUP_CONCAT(e.`avg_sal_rate`,"♥♥♥") AS patti_rt,
							GROUP_CONCAT(e.`tot_sal_amt`,"♥♥♥") AS patti_at,
							b.`vhstatus`,
							c.`prdtatus`,
							d.`prchstatus`,
							e.`salestatus`
						FROM `consignment` AS a
						LEFT JOIN (
							SELECT
								a.`id`,
								a.`consignee`,
								a.`driver`,
								a.`vehicle_no`,
								b.`packing_type`,
								a.`total_packs`,
								a.`total_weight`,
								a.`loaded_weight`,
								a.`empty_weight`,
								a.`advance_amt`,
								a.`rent`,
								DATE_FORMAT(a.`arrival`,"%Y-%c-%d") AS arrival,
								a.`departure`,
								a.`status_id` AS vhstatus
							FROM `vehicle` AS a
							LEFT JOIN (
								SELECT
									`id`,
									`packing_type`,
									`remark`
								FROM `packing_type`
								WHERE `status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							) AS b ON b.`id` = a.`packing_type_id`
							WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							ORDER BY(b.`id`)
						) AS b ON b.`id` = a.`vehicle_id` AND a.`consignee` = b.`consignee`
						LEFT JOIN (
							SELECT
								prd.`id`,
								prd.`name` AS name,
								CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
									 THEN "' . VEGIE_IMAGE . '"
									 ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
								END AS prdphoto,
								prd.`status_id` AS prdtatus
							FROM `product` AS prd
							LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
							WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							ORDER BY(prd.`id`)
						) AS c ON c.`id` = a.`product_id`
						LEFT JOIN (
							SELECT
								a.`id`,
								a.`from_pk`,
								a.`to_pk`,
								a.`sales_id`,
								a.`vehicle_id`,
								a.`product_id`,
								a.`packing_type_id`,
								a.`patti_ref_no`,
								a.`patti_date`,
								CASE WHEN (a.`avg_rate` IS NULL OR a.`avg_rate` = "")
									 THEN 0
									 ELSE a.`avg_rate`
								END AS avg_rate,
								CASE WHEN (a.`total_sale` IS NULL OR a.`total_sale` = "")
									 THEN 0
									 ELSE a.`total_sale`
								END AS total_sale,
								CASE WHEN (a.`total_exp` IS NULL OR a.`total_exp` = "")
									 THEN 0
									 ELSE a.`total_exp`
								END AS total_exp,
								CASE WHEN (a.`net_sales` IS NULL OR a.`net_sales` = "")
									 THEN 0
									 ELSE a.`net_sales`
								END AS net_sales,
								a.`location`,
								CASE WHEN (b.`lorry_hire` IS NULL OR b.`lorry_hire` = "")
									 THEN 0
									 ELSE b.`lorry_hire`
								END AS lorry_hire,
								CASE WHEN (b.`commision_cash` IS NULL OR b.`commision_cash` = "")
									 THEN 0
									 ELSE b.`commision_cash`
								END AS commision_cash,
								CASE WHEN (b.`labour` IS NULL OR b.`labour` = "")
									 THEN 0
									 ELSE b.`labour`
								END AS labour,
								CASE WHEN (b.`association_fee` IS NULL OR b.`association_fee` = "")
									 THEN 0
									 ELSE b.`association_fee`
								END AS association_fee,
								CASE WHEN (b.`post_fee` IS NULL OR b.`post_fee` = "")
									 THEN 0
									 ELSE b.`post_fee`
								END AS post_fee,
								CASE WHEN (b.`rmc` IS NULL OR b.`rmc` = "")
									 THEN 0
									 ELSE b.`rmc`
								END AS rmc,
								CASE WHEN (b.`total` IS NULL OR b.`total` = "")
									 THEN 0
									 ELSE b.`total`
								END AS totalexp,
								c.`packing_type`,
								c.`quantity`,
								c.`particulars`,
								c.`weight_kg`,
								c.`rate`,
								c.`amount`,
								a.`status_id` AS prchstatus
							FROM `purchase` AS a
							LEFT JOIN (
								SELECT
									a.`id`,
									a.`purchase_id`,
									a.`lorry_hire`,
									a.`commision_id`,
									a.`commision_cash`,
									a.`labour`,
									a.`association_fee`,
									a.`post_fee`,
									a.`rmc`,
									a.`total`,
									b.`percentage`
								FROM `purchase_expenses` AS a
								LEFT JOIN (
									SELECT
										`id`,
										`percentage`
									FROM `commission`
									WHERE `status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								) AS b ON a.`commision_id` = b.`id`
								WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								ORDER BY(a.`purchase_id`)
							) AS b ON b.`purchase_id` = a.`id`
							LEFT JOIN (
								SELECT
									a.`id`,
									a.`purchase_id`,
									a.`product_id`,
									GROUP_CONCAT(b.`packing_type`,"☻♥☻") AS packing_type,
									GROUP_CONCAT(CASE WHEN (a.`quantity` IS NULL OR a.`quantity` = "")
										 THEN 0
										 ELSE a.`quantity`
									END,"☻♥☻") AS quantity,
									GROUP_CONCAT(a.`particulars`,"☻♥☻") AS particulars,
									GROUP_CONCAT(CASE WHEN (a.`weight_kg` IS NULL OR a.`weight_kg` = "")
										 THEN 0
										 ELSE a.`weight_kg`
									END,"☻♥☻") AS weight_kg,
									GROUP_CONCAT(CASE WHEN (a.`rate` IS NULL OR a.`rate` = "")
										 THEN 0
										 ELSE a.`rate`
									END,"☻♥☻") AS rate,
									GROUP_CONCAT(CASE WHEN (a.`amount` IS NULL OR a.`amount` = "")
										 THEN 0
										 ELSE a.`amount`
									END,"☻♥☻") AS amount
								FROM `purchase_fields` AS a
								LEFT JOIN (
									SELECT
										`id`,
										`packing_type`,
										`remark`
									FROM `packing_type`
									WHERE `status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								) AS b ON b.`id` = a.`packing_type_id`
								WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								GROUP BY(a.`purchase_id`)
								ORDER BY(a.`purchase_id`)
							) AS c  ON c.`purchase_id` = a.`id`
							WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							GROUP BY(a.`id`)
							ORDER BY(a.`id`)
						) AS d ON d.`id` = a.`purchase_id`
						LEFT JOIN (
							SELECT
								a.`id` AS pattyid,
								a.`from_pk`,
								a.`to_pk`,
								a.`product_id` AS product_id,
								a.`vehicle_id` AS vehicle_id,
								DATE_FORMAT(a.`sales_date`,"%Y-%c-%d") AS sales_date,
								a.`patti_ref_no` AS patti_ref_no,
								CASE WHEN (a.`total_packs` IS NULL OR a.`total_packs` = "")
									 THEN 0
									 ELSE a.`total_packs`
								END	AS total_packs,
								CASE WHEN (a.`total_weight` IS NULL OR a.`total_packs` = "")
									 THEN 0
									 ELSE a.`total_weight`
								END	AS total_weight,
								CASE WHEN (a.`balance` IS NULL OR a.`total_packs` = "")
									 THEN 0
									 ELSE a.`balance`
								END AS balance,
								a.`status_id` AS salestatus,
								b.`tot_sal_packs`,
								b.`tot_sal_weight`,
								b.`avg_sal_rate`,
								b.`tot_sal_amt`
								/*
									SUM(b.`se_nopacks`) AS tot_sal_packs,
									SUM(b.`se_untwt`) AS tot_sal_weight,
									ROUND(AVG(b.`se_rate`)) AS avg_sal_rate,
									SUM(b.`se_amount`) AS tot_sal_amt,
								*/
							FROM `sales` AS a
							LEFT JOIN(
								SELECT
									SUM(tep.`se_nopacks`) 		AS tot_sal_packs,
									SUM(tep.`se_untwt`) 		AS tot_sal_weight,
									ROUND(AVG(tep.`se_rate`)) 	AS avg_sal_rate,
									SUM(tep.`se_amount`) 		AS tot_sal_amt,
									tep.`sales_id`
									FROM (
										SELECT
											c.`to_pk`,
											c.`id` AS se_id,
											c.`sales_id`,
											CASE WHEN (d.`id` IS NULL OR d.`id` = "")
												 THEN DATE_FORMAT(c.`patti_date`,"%Y-%c-%d")
												 ELSE
													CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
														 THEN DATE_FORMAT(d.`patti_alt_date`,"%Y-%c-%d")
														 ELSE 0
													END
											END  AS se_date,
											CASE WHEN (d.`id` IS NULL OR d.`id` = "")
												 THEN c.`no_packs`
												 ELSE
													CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
														 THEN d.`no_packs`
														 ELSE 0
													END
											END  AS se_nopacks,
											CASE WHEN (d.`id` IS NULL OR d.`id` = "")
												 THEN c.`unit_weight`
												 ELSE
													CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
														 THEN d.`unit_weight`
														 ELSE 0
													END
											END AS se_untwt,
											CASE WHEN (d.`id` IS NULL OR d.`id` = "")
												 THEN c.`rate`
												 ELSE
													CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
														 THEN d.`rate`
														 ELSE 0
													END
											END AS se_rate,
											CASE WHEN (d.`id` IS NULL OR d.`id` = "")
												 THEN c.`amount`
												 ELSE
													CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
														 THEN d.`amount`
														 ELSE 0
													END
											END AS se_amount
										FROM `patti` AS c
										LEFT JOIN `patti_alterations` AS d  ON c.`id` = d.`patti_id`
										WHERE c.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
									) AS tep
									GROUP BY(tep.`sales_id`)
									ORDER BY(tep.`sales_id`)
							) AS b ON b.`sales_id` = a.`id`
							WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							GROUP BY(a.`id`)
							ORDER BY(a.`id`)
						) AS e ON e.`pattyid` = a.`sales_id`
						WHERE a.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND b.`vhstatus`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND c.`prdtatus`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND d.`prchstatus`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND e.`salestatus`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY(a.`consignee`)
						ORDER BY(a.`consignee`)
					) AS h ON h.`supplier` = a.`id`
					LEFT JOIN (
						SELECT
							inc.`from_pk`,
							GROUP_CONCAT(inc.`id`,"☻☻♥♥☻☻") AS incid,
							GROUP_CONCAT(DATE_FORMAT(inc.`arrival`,"%Y-%c-%d"),"☻☻♥♥☻☻") AS colldate,
							GROUP_CONCAT(inc.`amount`,"☻☻♥♥☻☻") AS incamt,
							GROUP_CONCAT(inc.`remark`,"☻☻♥♥☻☻") AS incrmk,
							GROUP_CONCAT(m.`name`,"☻☻♥♥☻☻") AS incmop,
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
							GROUP_CONCAT(m.`name`,"☻☻♥♥☻☻") AS outmop,
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
					LEFT JOIN  (
						SELECT
							`user_pk`,
							GROUP_CONCAT(`id`,"☻☻♥♥☻☻") AS dueid,
							GROUP_CONCAT(DATE_FORMAT(`due_date`,"%Y-%c-%d"),"☻☻♥♥☻☻") AS due_date,
							GROUP_CONCAT(`due_amount`,"☻☻♥♥☻☻") AS due_amount
						FROM `due`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (`user_pk`)
						ORDER BY (`user_pk`)
					) AS k ON a.`id` = k.`user_pk`
					LEFT JOIN (
						SELECT
							c.`to_pk`,
							GROUP_CONCAT(c.`id`,"☻☻♥♥☻☻") AS se_id,
							GROUP_CONCAT(CASE WHEN (d.`id` IS NULL OR d.`id` = "")
								 THEN DATE_FORMAT(c.`patti_date`,"%Y-%c-%d")
								 ELSE
									CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
										 THEN DATE_FORMAT(d.`patti_alt_date`,"%Y-%c-%d")
										 ELSE NULL
									END
							END,"☻☻♥♥☻☻") AS se_date,
							GROUP_CONCAT(g.`name`,"☻☻♥♥☻☻") AS se_prd,
							GROUP_CONCAT(CASE WHEN (d.`id` IS NULL OR d.`id` = "")
								 THEN c.`no_packs`
								 ELSE
									CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
										 THEN d.`no_packs`
										 ELSE NULL
									END
							END,"☻☻♥♥☻☻") AS se_nopacks,
							GROUP_CONCAT(CASE WHEN (d.`id` IS NULL OR d.`id` = "")
								 THEN c.`unit_weight`
								 ELSE
									CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
										 THEN d.`unit_weight`
										 ELSE NULL
									END
							END,"☻☻♥♥☻☻") AS se_untwt,
							GROUP_CONCAT(CASE WHEN (d.`id` IS NULL OR d.`id` = "")
								 THEN c.`rate`
								 ELSE
									CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
										 THEN d.`rate`
										 ELSE NULL
									END
							END,"☻☻♥♥☻☻") AS se_rate,
							GROUP_CONCAT(CASE WHEN (d.`id` IS NULL OR d.`id` = "")
								 THEN c.`amount`
								 ELSE
									CASE WHEN d.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
										 THEN d.`amount`
										 ELSE NULL
									END
							END,"☻☻♥♥☻☻") AS se_amount,
							GROUP_CONCAT(CASE WHEN (d.`id` IS NULL OR d.`id` = "")
								 THEN "patti"
								 ELSE "patti_alterations"
							END,"☻☻♥♥☻☻") AS se_tblname,
							GROUP_CONCAT(CONCAT("' . URL . '",e.`location`),"☻☻♥♥☻☻") AS se_invloc
						FROM `patti` AS c
						LEFT JOIN `patti_alterations` AS d  ON c.`id` = d.`patti_id`
						LEFT JOIN `invoice` AS e  ON c.`id` = e.`patti_id`
						LEFT JOIN `rev_invoice` AS f  ON d.`id` = f.`patti_alt_id`
						LEFT JOIN(
							SELECT
								prd.`id`,
								prd.`name` AS name,
								CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
									 THEN "' . VEGIE_IMAGE . '"
									 ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
								END AS prdphoto
							FROM `product` AS prd
							LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
							WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							ORDER BY(prd.`id`)
						) AS g ON g.`id` =  (SELECT `product_id` FROM `sales` WHERE `id` = c.`sales_id`)
						WHERE c.`status_id`  = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (c.`to_pk`)
						ORDER BY (c.`to_pk`)
					) AS l ON l.`to_pk` = a.`id`
					WHERE f.`type_id` !=  9 AND f.`type_id` !=  3
					AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
					ORDER BY (f.`user_type`);';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $pattys[] = $row;
            }
        }
        $total = sizeof($pattys);
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $pattys[$i]["email"] = explode("☻☻♥♥☻☻", $pattys[$i]["email"]);
                $pattys[$i]["cnumber"] = explode("☻☻♥♥☻☻", $pattys[$i]["cnumber"]);
                $pattys[$i]["bank_id"] = explode("☻☻♥♥☻☻", $pattys[$i]["bank_id"]);
                $pattys[$i]["bank_name"] = explode("☻☻♥♥☻☻", $pattys[$i]["bank_name"]);
                $pattys[$i]["ac_no"] = explode("☻☻♥♥☻☻", $pattys[$i]["ac_no"]);
                $pattys[$i]["branch"] = explode("☻☻♥♥☻☻", $pattys[$i]["branch"]);
                $pattys[$i]["branch_code"] = explode("☻☻♥♥☻☻", $pattys[$i]["branch_code"]);
                $pattys[$i]["IFSC"] = explode("☻☻♥♥☻☻", $pattys[$i]["IFSC"]);
                $pattys[$i]["prdid"] = explode("☻☻♥♥☻☻", $pattys[$i]["prdid"]);
                $pattys[$i]["prdname"] = explode("☻☻♥♥☻☻", $pattys[$i]["prdname"]);
                $pattys[$i]["prdphoto"] = explode("☻☻♥♥☻☻", $pattys[$i]["prdphoto"]);
                /* Consignment */
                $pattys[$i]["conid"] = explode("♥♥♥", $pattys[$i]["conid"]);
                $pattys[$i]["supplier"] = explode("♥♥♥", $pattys[$i]["supplier"]);
                $pattys[$i]["distributor"] = explode("♥♥♥", $pattys[$i]["distributor"]);
                /* Vehicle */
                $pattys[$i]["vhid"] = explode("♥♥♥", $pattys[$i]["vhid"]);
                $pattys[$i]["driver"] = explode("♥♥♥", $pattys[$i]["driver"]);
                $pattys[$i]["vehicle_no"] = explode("♥♥♥", $pattys[$i]["vehicle_no"]);
                $pattys[$i]["packtype"] = explode("♥♥♥", $pattys[$i]["packtype"]);
                $pattys[$i]["loaded_weight"] = explode("♥♥♥", $pattys[$i]["loaded_weight"]);
                $pattys[$i]["empty_weight"] = explode("♥♥♥", $pattys[$i]["empty_weight"]);
                $pattys[$i]["advance_amt"] = explode("♥♥♥", $pattys[$i]["advance_amt"]);
                $pattys[$i]["rent"] = explode("♥♥♥", $pattys[$i]["rent"]);
                $pattys[$i]["arrival"] = explode("♥♥♥", $pattys[$i]["arrival"]);
                $pattys[$i]["departure"] = explode("♥♥♥", $pattys[$i]["departure"]);
                /* Product */
                $pattys[$i]["saleprdid"] = explode("♥♥♥", $pattys[$i]["saleprdid"]);
                $pattys[$i]["saleprdname"] = explode("♥♥♥", $pattys[$i]["saleprdname"]);
                $pattys[$i]["saleprdphoto"] = explode("♥♥♥", $pattys[$i]["saleprdphoto"]);
                /* Purchase */
                $pattys[$i]["prchid"] = explode("♥♥♥", $pattys[$i]["prchid"]);
                $pattys[$i]["patti_date"] = explode("♥♥♥", $pattys[$i]["patti_date"]);
                $pattys[$i]["total_sale"] = explode("♥♥♥", $pattys[$i]["total_sale"]);
                $pattys[$i]["total_exp"] = explode("♥♥♥", $pattys[$i]["total_exp"]);
                $pattys[$i]["net_sales"] = explode("♥♥♥", $pattys[$i]["net_sales"]);
                $pattys[$i]["avg_rate"] = explode("♥♥♥", $pattys[$i]["avg_rate"]);
                $pattys[$i]["location"] = explode("♥♥♥", $pattys[$i]["location"]);
                /* Purchase Expenses */
                $pattys[$i]["lorry_hire"] = explode("♥♥♥", $pattys[$i]["lorry_hire"]);
                $pattys[$i]["commision_cash"] = explode("♥♥♥", $pattys[$i]["commision_cash"]);
                $pattys[$i]["labour"] = explode("♥♥♥", $pattys[$i]["labour"]);
                $pattys[$i]["association_fee"] = explode("♥♥♥", $pattys[$i]["association_fee"]);
                $pattys[$i]["post_fee"] = explode("♥♥♥", $pattys[$i]["post_fee"]);
                $pattys[$i]["rmc"] = explode("♥♥♥", $pattys[$i]["rmc"]);
                $pattys[$i]["totalexp"] = explode("♥♥♥", $pattys[$i]["totalexp"]);
                /* Purchase Fields */
                $pattys[$i]["purchpt"] = explode("♥♥♥", $pattys[$i]["purchpt"]);
                $pattys[$i]["purchqt"] = explode("♥♥♥", $pattys[$i]["purchqt"]);
                $pattys[$i]["purchprt"] = explode("♥♥♥", $pattys[$i]["purchprt"]);
                $pattys[$i]["purchwt"] = explode("♥♥♥", $pattys[$i]["purchwt"]);
                $pattys[$i]["purchrt"] = explode("♥♥♥", $pattys[$i]["purchrt"]);
                $pattys[$i]["purchat"] = explode("♥♥♥", $pattys[$i]["purchat"]);
                for ($j = 0; $j < sizeof($pattys[$i]["purchpt"]) && isset($pattys[$i]["purchpt"][$j]) && $pattys[$i]["purchpt"][$j] != ''; $j++) {
                    $pattys[$i]["purchpt"][$j] = explode("☻♥☻", $pattys[$i]["purchpt"][$j]);
                    $pattys[$i]["purchqt"][$j] = explode("☻♥☻", $pattys[$i]["purchqt"][$j]);
                    $pattys[$i]["purchprt"][$j] = explode("☻♥☻", $pattys[$i]["purchprt"][$j]);
                    $pattys[$i]["purchwt"][$j] = explode("☻♥☻", $pattys[$i]["purchwt"][$j]);
                    $pattys[$i]["purchrt"][$j] = explode("☻♥☻", $pattys[$i]["purchrt"][$j]);
                    $pattys[$i]["purchat"][$j] = explode("☻♥☻", $pattys[$i]["purchat"][$j]);
                }
                /* Sales */
                $pattys[$i]["pattyid"] = explode("♥♥♥", $pattys[$i]["pattyid"]);
                $pattys[$i]["sales_date"] = explode("♥♥♥", $pattys[$i]["sales_date"]);
                $pattys[$i]["patti_ref_no"] = explode("♥♥♥", $pattys[$i]["patti_ref_no"]);
                $pattys[$i]["total_packs"] = explode("♥♥♥", $pattys[$i]["total_packs"]);
                $pattys[$i]["total_weight"] = explode("♥♥♥", $pattys[$i]["total_weight"]);
                $pattys[$i]["balance"] = explode("♥♥♥", $pattys[$i]["balance"]);
                $pattys[$i]["patti_packs"] = explode("♥♥♥", $pattys[$i]["patti_packs"]);
                $pattys[$i]["patti_wt"] = explode("♥♥♥", $pattys[$i]["patti_wt"]);
                $pattys[$i]["patti_rt"] = explode("♥♥♥", $pattys[$i]["patti_rt"]);
                $pattys[$i]["patti_at"] = explode("♥♥♥", $pattys[$i]["patti_at"]);
                /* Incomming */
                $pattys[$i]["incid"] = explode("☻☻♥♥☻☻", $pattys[$i]["incid"]);
                $pattys[$i]["colldate"] = explode("☻☻♥♥☻☻", $pattys[$i]["colldate"]);
                $pattys[$i]["incamt"] = explode("☻☻♥♥☻☻", $pattys[$i]["incamt"]);
                $pattys[$i]["incrmk"] = explode("☻☻♥♥☻☻", $pattys[$i]["incrmk"]);
                $pattys[$i]["incmop"] = explode("☻☻♥♥☻☻", $pattys[$i]["incmop"]);
                $pattys[$i]["incbname"] = explode("☻☻♥♥☻☻", $pattys[$i]["incbname"]);
                $pattys[$i]["incbacno"] = explode("☻☻♥♥☻☻", $pattys[$i]["incbacno"]);
                $pattys[$i]["incbranch"] = explode("☻☻♥♥☻☻", $pattys[$i]["incbranch"]);
                $pattys[$i]["incifsc"] = explode("☻☻♥♥☻☻", $pattys[$i]["incifsc"]);
                /* Outgoing */
                $pattys[$i]["outid"] = explode("☻☻♥♥☻☻", $pattys[$i]["outid"]);
                $pattys[$i]["paydate"] = explode("☻☻♥♥☻☻", $pattys[$i]["paydate"]);
                $pattys[$i]["outamt"] = explode("☻☻♥♥☻☻", $pattys[$i]["outamt"]);
                $pattys[$i]["outrmk"] = explode("☻☻♥♥☻☻", $pattys[$i]["outrmk"]);
                $pattys[$i]["outmop"] = explode("☻☻♥♥☻☻", $pattys[$i]["outmop"]);
                $pattys[$i]["outbname"] = explode("☻☻♥♥☻☻", $pattys[$i]["outbname"]);
                $pattys[$i]["outbacno"] = explode("☻☻♥♥☻☻", $pattys[$i]["outbacno"]);
                $pattys[$i]["outbranch"] = explode("☻☻♥♥☻☻", $pattys[$i]["outbranch"]);
                $pattys[$i]["outbrcode"] = explode("☻☻♥♥☻☻", $pattys[$i]["outbrcode"]);
                $pattys[$i]["outifsc"] = explode("☻☻♥♥☻☻", $pattys[$i]["outifsc"]);
                /* Due */
                $pattys[$i]["dueid"] = explode("☻☻♥♥☻☻", $pattys[$i]["dueid"]);
                $pattys[$i]["due_date"] = explode("☻☻♥♥☻☻", $pattys[$i]["due_date"]);
                $pattys[$i]["due_amount"] = explode("☻☻♥♥☻☻", $pattys[$i]["due_amount"]);
                /* Sale entries */
                $pattys[$i]["se_id"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_id"]);
                $pattys[$i]["se_date"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_date"]);
                $pattys[$i]["se_prd"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_prd"]);
                $pattys[$i]["se_nopacks"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_nopacks"]);
                $pattys[$i]["se_untwt"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_untwt"]);
                $pattys[$i]["se_rate"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_rate"]);
                $pattys[$i]["se_amount"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_amount"]);
                $pattys[$i]["se_tblname"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_tblname"]);
                $pattys[$i]["se_invloc"] = explode("☻☻♥♥☻☻", $pattys[$i]["se_invloc"]);
            }
            $_SESSION["listofpattys"] = $pattys;
        } else {
            $_SESSION["listofpattys"] = NULL;
        }
        return $_SESSION["listofpattys"];
    }
    public function DisplayPurchasetList($para = false) {

        $this->parameters = $para;
        $pattys = array();
        $num_posts = 0;
        if (isset($_SESSION['listofpurchase']) && $_SESSION['listofpurchase'] != NULL)
            $pattys = $_SESSION['listofpurchase'];
        else
            $pattys = NULL;
        if ($pattys != NULL)
            $num_posts = sizeof($pattys);
        if ($num_posts > 0) {
            //for($i=$this->parameters["initial"];$i<$this->parameters["final"] && $i < $num_posts && isset($pattys[$i]['usrid']);$i++){
            $consignment = '';
            $conrow = '';
            $vehicle = '';
            $product = '';
            $sales = '';
            $purchase = '';
            for ($i = 0; $i < $num_posts; $i++) {
                /* Basic info */
                $email = '';
                $cnumber = '';
                $backac = '';
                $prd = '';
                /* Email */
                if (is_array($pattys[$i]["email"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["email"]) && isset($pattys[$i]["email"][$j]) && $pattys[$i]["email"][$j] != ''; $j++) {
                        $flag = true;
                        $email .= '<li>' . $pattys[$i]["email"][$j] . '</li>';
                    }
                    if (!$flag)
                        $email = '<li>Not Provided</li>';
                }
                /* Cell number */
                if (is_array($pattys[$i]["cnumber"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["cnumber"]) && isset($pattys[$i]["cnumber"][$j]) && $pattys[$i]["cnumber"][$j] != ''; $j++) {
                        $flag = true;
                        $cnumber .= '<li>' . $pattys[$i]["cnumber"][$j] . '</li>';
                    }
                    if (!$flag)
                        $cnumber = '<li>Not Provided</li>';
                }
                /* Bank account */
                if (is_array($pattys[$i]["bank_id"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["bank_id"]) && isset($pattys[$i]["bank_name"][$j]) && $pattys[$i]["bank_name"][$j] != ''; $j++) {
                        $flag = true;
                        $backac .= '<li>
										' . $pattys[$i]["bank_name"][$j] . ',&nbsp;
										' . $pattys[$i]["ac_no"][$j] . ',&nbsp;
										' . $pattys[$i]["branch"][$j] . ',&nbsp;
										' . $pattys[$i]["branch_code"][$j] . ',&nbsp;
										' . $pattys[$i]["IFSC"][$j] . '
										</li>';
                    }
                    if (!$flag)
                        $backac = '<li>Not Provided</li>';
                }
                /* Product */
                if (is_array($pattys[$i]["prdid"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["prdid"]) && isset($pattys[$i]["prdid"]) && $pattys[$i]["prdid"][$j] != ''; $j++) {
                        $flag = true;
                        $prd .= '<li>' . ltrim($pattys[$i]["prdname"][$j], ',') . '&nbsp; <img src="' . ltrim($pattys[$i]["prdphoto"][$j], ',') . '" width="50" /> </li>';
                    }
                    if (!$flag)
                        $prd = '<li>Not Provided</li>';
                }
                $basicinfo = '<div class="row"><div class="col-lg-12">&nbsp;</div><div class="col-lg-4"><div class="panel panel-default"><div class="panel-heading"><h4>Photo</h4></div><div class="panel-body"><img src="' . $pattys[$i]["usrphoto"] . '" width="150" /></div></div></div><div class="col-lg-4"><div class="panel panel-default"><div class="panel-heading"><h4>Email ids</h4></div><div class="panel-body"><ul>' . $email . '</ul></div></div></div><div class="col-lg-4"><div class="panel panel-default"><div class="panel-heading"><h4>Cell numbers</h4></div><div class="panel-body"><ul>' . $cnumber . '</ul></div></div></div></div><div class="row"><div class="col-lg-12">&nbsp;</div><div class="col-lg-4"><div class="panel panel-default"><div class="panel-heading"><h4>Products</h4></div><div class="panel-body"><ul>' . $prd . '</ul></div></div></div><div class="col-lg-4"><div class="panel panel-default"><div class="panel-heading"><h4>Bank accounts</h4></div><div class="panel-body"><ul>' . $backac . '</ul></div></div></div><div class="col-lg-4"><div class="panel panel-default"><div class="panel-heading"><h4>Address</h4></div><div class="panel-body"><ul><li><stong>Address line : </storng>' . $pattys[$i]["addressline"] . '</li><li><stong>Street / Locality : </storng>' . $pattys[$i]["town"] . '</li><li><stong>City / Town : </storng>' . $pattys[$i]["city"] . '</li><li><stong>District / Department : </storng>' . $pattys[$i]["district"] . '</li><li><stong>State / Provice : </storng>' . $pattys[$i]["province"] . '</li><li><stong>Country : </storng>' . $pattys[$i]["country"] . '</li><li><stong>Zipcode : </storng>' . $pattys[$i]["zipcode"] . '</li><li><stong>Website : </storng>' . $pattys[$i]["website"] . '</li></ul></div></div></div></div>';
                /* Transactions */
                $incomming = '';
                $outgoing = '';
                $due = '';
                /* Incomming */
                if (is_array($pattys[$i]["incid"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["incid"]) && isset($pattys[$i]["incid"]) && $pattys[$i]["incid"][$j] != ''; $j++) {
                        $flag = true;
                        $mop = ltrim($pattys[$i]["incmop"][$j], ',');
                        if ($mop != 'Cash') {
                            $incbname = isset($pattys[$i]["incbname"][$j]) ? ltrim($pattys[$i]["incbname"][$j], ',') . ', ' : 'Not Provided';
                            $incbacno = isset($pattys[$i]["incbacno"][$j]) ? ltrim($pattys[$i]["incbacno"][$j], ',') . ', ' : 'Not Provided';
                            $incbranch = isset($pattys[$i]["incbranch"][$j]) ? ltrim($pattys[$i]["incbranch"][$j], ',') . ', ' : 'Not Provided';
                            $incifsc = isset($pattys[$i]["incifsc"][$j]) ? ltrim($pattys[$i]["incifsc"][$j], ',') : 'Not Provided';
                            $bankdet = $incbname . $incbacno . $incbranch . $incifsc;
                        } else
                            $bankdet = 'Cash';
                        $incomming .= '<tr>
												<td>' . ($j + 1) . '</td>
												<td>' . date("j-M-Y", strtotime(ltrim($pattys[$i]["colldate"][$j], ','))) . '</td>
												<td class="text-right">' . ltrim($pattys[$i]["incamt"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
												<td class="text-right">' . ltrim($pattys[$i]["incrmk"][$j], ',') . '</td>
												<td class="text-right">' . ltrim($pattys[$i]["incmop"][$j], ',') . '</td>
												<td class="text-right">' . $bankdet . '</td>
											</tr>';
                    }
                    if (!$flag)
                        $incomming = '<tr><td colspan="6">No incomming transactions have been done.</td></tr>';
                }
                /* Outgoing */
                if (is_array($pattys[$i]["outid"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["outid"]) && isset($pattys[$i]["outid"]) && $pattys[$i]["outid"][$j] != ''; $j++) {
                        $flag = true;
                        $mop = ltrim($pattys[$i]["outmop"][$j], ',');
                        if ($mop != 'Cash') {
                            $outbname = isset($pattys[$i]["outbname"][$j]) ? ltrim($pattys[$i]["outbname"][$j], ',') . ', ' : 'Not Provided';
                            $outbacno = isset($pattys[$i]["outbacno"][$j]) ? ltrim($pattys[$i]["outbacno"][$j], ',') . ', ' : 'Not Provided';
                            $outbranch = isset($pattys[$i]["outbranch"][$j]) ? ltrim($pattys[$i]["outbranch"][$j], ',') . ', ' : 'Not Provided';
                            $outifsc = isset($pattys[$i]["outifsc"][$j]) ? ltrim($pattys[$i]["outifsc"][$j], ',') : 'Not Provided';
                            $bankdet = $outbname . $outbacno . $outbranch . $outifsc;
                        } else
                            $bankdet = 'Cash';
                        $outgoing .= '<tr>
											<td>' . ($j + 1) . '</td>
											<td>' . date("j-M-Y", strtotime(ltrim($pattys[$i]["paydate"][$j], ','))) . '</td>
											<td class="text-right">' . ltrim($pattys[$i]["outamt"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
											<td class="text-right">' . ltrim($pattys[$i]["outrmk"][$j], ',') . '</td>
											<td class="text-right">' . ltrim($pattys[$i]["outmop"][$j], ',') . '</td>
											<td class="text-right">' . $bankdet . '</td>
										</tr>';
                    }
                    if (!$flag)
                        $outgoing = '<tr><td colspan="6">No outgoing transactions have been done.</td></tr>';
                }
                /* Due */
                if (is_array($pattys[$i]["dueid"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["dueid"]) && isset($pattys[$i]["dueid"]) && $pattys[$i]["dueid"][$j] != ''; $j++) {
                        $flag = true;
                        $amt = (integer) ltrim($pattys[$i]["due_amount"][$j], ',');
                        if ($amt > 0)
                            $due .= '<tr>
											<td>' . ($j + 1) . '</td>
											<td>' . date("j-M-Y", strtotime(ltrim($pattys[$i]["due_date"][$j], ','))) . '</td>
											<td class="text-right">' . $amt . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
										</tr>';
                    }
                    if (!$flag)
                        $due = '<tr><td colspan="3">No due amounts.</td></tr>';
                }
                $trasac = '<div class="row"><div class="col-lg-12 table-responsive" ><table class="table"><thead><tr><th colspan="6">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>' . $incomming . '</table></div><div class="col-lg-12">&nbsp;</div></div><div class="row"><div class="col-lg-12 table-responsive" ><table class="table"><thead><tr><th colspan="6">Outgoing Transactions</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>' . $outgoing . '</table></div><div class="col-lg-12">&nbsp;</div></div><div class="row"><div class="col-lg-12 table-responsive" ><table class="table"><thead><tr><th colspan="6">Due</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th></tr></thead>' . $due . '</table></div><div class="col-lg-12">&nbsp;</div></div>';
                /* Sale entries */
                $saleentry = '';
                if (is_array($pattys[$i]["se_id"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["se_id"]) && isset($pattys[$i]["se_id"]) && $pattys[$i]["se_id"][$j] != ''; $j++) {
                        $flag = true;
                        $saleentry .= '<tr>
											<td>' . ($j + 1) . '</td>
											<td>' . date("j-M-Y", strtotime(ltrim($pattys[$i]["se_date"][$j], ','))) . '</td>
											<td>' . ltrim($pattys[$i]["se_prd"][$j], ',') . '</td>
											<td class="text-right">' . ltrim($pattys[$i]["se_nopacks"][$j], ',') . '</td>
											<td class="text-right">' . ltrim($pattys[$i]["se_untwt"][$j], ',') . '</td>
											<td class="text-right">' . ltrim($pattys[$i]["se_rate"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
											<td class="text-right">' . ltrim($pattys[$i]["se_amount"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
											<td class="text-right"><button class="btn btn-primary" onClick="window.open(\'' . URL . ltrim($pattys[$i]["se_invloc"][$j], ',') . '\');" href="javascript:void();" target="_new">Print</button></td>
										</tr>';
                    }
                    if (!$flag)
                        $saleentry = '<tr><td colspan="8">No sale entries available.</td></tr>';
                }
                $sals = '<div class="row">
								<div class="col-lg-12 table-responsive">
								<table class="table">
								<thead>
									<tr>
										<th colspan="8">Sale entries</th>
									</tr>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Product</th>
										<th class="text-right">Number</th>
										<th class="text-right">Weight</th>
										<th class="text-right">Rate</th>
										<th class="text-right">Amount</th>
										<th class="text-right">Invoice</th>
									</tr>
								</thead>
								' . $saleentry . '
							</table>
							</div>
							</div>';
                /* Purchase */
                if (is_array($pattys[$i]["conid"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($pattys[$i]["conid"]) && isset($pattys[$i]["conid"]) && $pattys[$i]["conid"][$j] != ''; $j++) {
                        $flag = true;
                        /**/
                        $vhno = isset($pattys[$i]["vehicle_no"][$j]) && $pattys[$i]["vehicle_no"][$j] != '' ? ltrim($pattys[$i]["vehicle_no"][$j], ',') : '';
                        $packtype = isset($pattys[$i]["packtype"][$j]) && $pattys[$i]["packtype"][$j] != '' ? ltrim($pattys[$i]["packtype"][$j], ',') : '';

                        $vehicle = '<dl class="dl-horizontal">
										<dt>Vehicle NO :- </dt><dd>' . $vhno . '</dd>';
                        /**/
                        $saleprdname = isset($pattys[$i]["saleprdname"][$j]) && $pattys[$i]["saleprdname"][$j] != '' ? ltrim($pattys[$i]["saleprdname"][$j], ',') : '';
                        $saleprdphoto = isset($pattys[$i]["saleprdphoto"][$j]) && $pattys[$i]["saleprdphoto"][$j] != '' ? ltrim($pattys[$i]["saleprdphoto"][$j], ',') : '';
                        $product = $saleprdname . '&nbsp; <img src="' . $saleprdphoto . '" width="50" />';
                        /**/
                        $patti_ref_no = isset($pattys[$i]["patti_ref_no"][$j]) && $pattys[$i]["patti_ref_no"][$j] != '' ? ltrim($pattys[$i]["patti_ref_no"][$j], ',') : '';
                        $total_packs = isset($pattys[$i]["total_packs"][$j]) && $pattys[$i]["total_packs"][$j] != '' ? ltrim($pattys[$i]["total_packs"][$j], ',') : '';
                        $total_weight = isset($pattys[$i]["total_weight"][$j]) && $pattys[$i]["total_weight"][$j] != '' ? ltrim($pattys[$i]["total_weight"][$j], ',') : '';
                        $patti_rt = isset($pattys[$i]["patti_rt"][$j]) && $pattys[$i]["patti_rt"][$j] != '' ? ltrim($pattys[$i]["patti_rt"][$j], ',') : 0;
                        $patti_at = isset($pattys[$i]["patti_at"][$j]) && $pattys[$i]["patti_at"][$j] != '' ? ltrim($pattys[$i]["patti_at"][$j], ',') : 0;
                        $sales_date = isset($pattys[$i]["sales_date"][$j]) ? date("j-M-Y", strtotime(ltrim($pattys[$i]["sales_date"][$j], ','))) : '';
                        $pk_type = '<dl class="dl-horizontal">
											<dt>Packing type :- </dt><dd>' . $packtype . '</dd>
										';
                        /**/
                        $total_sale = isset($pattys[$i]["total_sale"][$j]) && $pattys[$i]["total_sale"][$j] != '' ? ltrim($pattys[$i]["total_sale"][$j], ',') : '';
                        $total_exp = isset($pattys[$i]["total_exp"][$j]) && $pattys[$i]["total_exp"][$j] != '' ? ltrim($pattys[$i]["total_exp"][$j], ',') : 0;
                        $avg_rate = isset($pattys[$i]["avg_rate"][$j]) && $pattys[$i]["avg_rate"][$j] != '' ? ltrim($pattys[$i]["avg_rate"][$j], ',') : 0;
                        $net_sales = isset($pattys[$i]["net_sales"][$j]) && $pattys[$i]["net_sales"][$j] != '' ? ltrim($pattys[$i]["net_sales"][$j], ',') : 0;
                        $sales_date = isset($pattys[$i]["patti_date"][$j]) && $pattys[$i]["patti_date"][$j] != '' ? date("j-M-Y", strtotime(ltrim($pattys[$i]["patti_date"][$j], ','))) : '';
                        $purchase_date = '<dl class="dl-horizontal">
										<dt>Patty date :- </dt><dd>' . $sales_date . '</dd></dl>';
                        $pattyloc = isset($pattys[$i]["location"][$j]) && $pattys[$i]["location"][$j] != '' ? ltrim($pattys[$i]["location"][$j], ',') : '';
                        $conrow .= '<tr>
											<td>' . ($j + 1) . '</td>
											<td>' . $vehicle . '</td>
											<td>' . $product . '</td>
											<td>' . $pk_type . '</td>
											<td>' . $purchase_date . '</td>
										</tr>';
                    }
                    //if(!$flag)
                    //$conrow = '';
                }
            }
            // $consignment = '<div class="row">
            if ($conrow != '')
                echo '<div class="row">
								<div class="col-lg-12 table-responsive">
								<table class="table table-striped table-bordered table-hover" id="consignment_table">
								<thead>
									<tr>
										<th colspan="6">PUrchase</th>
									</tr>
									<tr>
										<th>#</th>
										<th>Vehicle</th>
										<th>Product_Type</th>
										<th>Packing_Type</th>
										<th>Purchase_date</th>

									</tr>
								</thead>
								<tbody>
								' . $conrow . '
								</tbody>
							</table>
							</div>
							</div>';
            // echo $consignment;
        }
        else {
            echo '<table class="table table-striped table-bordered table-hover" id="consignment_table">
						<thead>
									<tr>
										<th colspan="6">Pattys</th>
									</tr>
									<tr>
										<th>#</th>
										<th>Vehicle</th>
										<th>Product</th>
										<th>Product_Type</th>
										<th>Purchase_date</th>

									</tr>
								</thead>
								<tbody><tr>
										<th colspan="6"><strong class="text-danger">There are no purchase entries !!!!</strong></th>
									</tr>
									</tbody></table>';
        }
    }
    public function selectRetailer() {
        
    }
    public function generatePatti() {
        
    }
    public function calcExpenses() {
        
    }
    public function calcCommision() {
        
    }
    public function updatePurchaseLedger() {
        
    }
    public function completeConsignment() {
        
    }
}
?>
