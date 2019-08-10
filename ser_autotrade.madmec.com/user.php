<?php

class user {

    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';
    private $searchQuery = array(
        "var" => '',
        "status" => 'error'
    );
    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function addUser() {
        $user_pk = 0;
        $product_pk = 0;
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
        $pass = md5($this->parameters["password"]);
        /* Photo */
        $query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
				NULL,NULL,NULL,NULL,NULL,NULL);';
        if (executeQuery($query)) {
            /* Profile */
            $query = 'INSERT INTO  `user_profile` (`id`,
						`user_name`,
						`ot_amt`,
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
					\'' . mysql_real_escape_string($this->parameters["name"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["otamt"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["acs"]) . '\',
					LAST_INSERT_ID(),
					\'' . mysql_real_escape_string($this->parameters["password"]) . '\',
					\'' . mysql_real_escape_string($pass) . '\',
					NULL,
					NULL,
					\'' . mysql_real_escape_string($this->parameters["pcode"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["tphone"]) . '\',
					\'' . mysql_real_escape_string(date('Y-m-d')) . '\',
					3,
					default,
					\'' . mysql_real_escape_string($this->parameters["user_type"]) . '\',
					1,
					\'' . mysql_real_escape_string($this->parameters["addrsline"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["st_loc"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["city_town"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["district"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["province"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["provinceCode"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["country"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["countryCode"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["zipcode"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["website"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["lat"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["lon"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["timezone"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["gmaphtml"]) . '\');';
            if (executeQuery($query)) {
                $user_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                /* emails */
                if (is_array($this->parameters["email"]) && sizeof($this->parameters["email"]) > -1) {
                    $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status_id` ) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["email"]); $i++) {
                        if ($i == sizeof($this->parameters["email"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',4);';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["email"][$i]) . '\',4),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `user_profile` SET `email`= \'' . mysql_real_escape_string($this->parameters["email"][0]) . '\'
									WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
                }
                /* cell_numbers */
                if (is_array($this->parameters["cellnumbers"]) && sizeof($this->parameters["cellnumbers"]) > -1) {
                    $query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_code`,`cell_number`,`status_id`) VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["cellnumbers"]); $i++) {
                        if ($i == sizeof($this->parameters["cellnumbers"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
									4);';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["codep"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["cellnumbers"][$i]["nump"]) . '\',
									4),';
                    }
                    executeQuery($query);
                    executeQuery('UPDATE `user_profile` SET `cell_code`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["codep"]) . '\',
										`cell_number`= \'' . mysql_real_escape_string($this->parameters["cellnumbers"][0]["nump"]) . '\'
									WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
                }
                /* Bank accounts */
                if (is_array($this->parameters["accounts"]) && sizeof($this->parameters["accounts"]) > -1) {
                    $query = 'INSERT INTO  `bank_accounts` (`id`,`user_pk`,`bank_name`,`ac_no`,`branch`,`branch_code`,`IFSC`,`status_id`)  VALUES';
                    for ($i = 0; $i < sizeof($this->parameters["accounts"]); $i++) {
                        if ($i == sizeof($this->parameters["accounts"]) - 1)
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["bankname"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["accno"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["braname"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["bracode"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["IFSC"]) . '\',
									4);';
                        else
                            $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["bankname"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["accno"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["braname"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["bracode"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["accounts"][$i]["IFSC"]) . '\',
									4),';
                    }
                    executeQuery($query);
                }
                /* Products */
                if (is_array($this->parameters["products"]) && sizeof($this->parameters["products"]) > -1) {
                    /* Photo */
                    $directory_prod = array();
                    $product_pk = array();
                    for ($i = 0; $i < sizeof($this->parameters["products"]); $i++) {
                        $query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
								NULL,NULL,NULL,NULL,NULL,NULL);';
                        executeQuery($query);
                        $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        $query = 'INSERT INTO  `product` (`id`,`name`,`photo_id`,`doc`,`status_id`) VALUES (NULL,
									\'' . mysql_real_escape_string($this->parameters["products"][$i]) . '\',
									\'' . mysql_real_escape_string($photo_pk) . '\',
									default,
									4);';
                        executeQuery($query);
                        $product_pk[$i] = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        $directory_prod[$i] = substr(md5(microtime()), 0, 6) . '_product_' . $product_pk[$i];
                        /* Assign product to user */
                        $query = 'INSERT INTO  `user_product` (`id`,`product_id`,`user_pk`,`status_id`) VALUES (NULL,
								\'' . mysql_real_escape_string($product_pk[$i]) . '\',
								\'' . mysql_real_escape_string($user_pk) . '\',
								4);';
                        executeQuery($query);
                    }
                    for ($i = 0; $i < sizeof($this->parameters["products"]); $i++) {
                        createdirectories($directory_prod[$i]);
                        executeQuery('UPDATE `product` SET `directory` = \'' . ASSET_DIR . $directory_prod[$i] . '\' WHERE `id`=\'' . mysql_real_escape_string($product_pk[$i]) . '\';');
                    }
                }
                $directory_user = createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
                executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_user . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
                $flag = true;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listUser($para = false) {
        $users = array();
        $utype = (isset($para["utype"]) && !empty($para["utype"])) ? ' AND f.`user_type` LIKE "%' . $para["utype"] . '%"' : '';
        $uid = (isset($para["uid"]) && !empty($para["uid"])) ? ' AND a.`id` = "' . $para["uid"] . '"' : '';
        $status = isset($para["status"]) ? $para["status"] : '';
        $success = "succ";
        $searchqr = $sortqr = '';
        if ($status == $success) {
            $searchqr = $para["var"];
        }
        if (isset($this->parameters["search"]["value"])) {
            $searchqr = 'AND (a.`user_name`  LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR a.`ot_amt`       LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR b.`email`        LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR c.`cnumber`      LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR f.`user_type`    LIKE "%' . $this->parameters["search"]["value"] . '%")';
        }
        if (isset($this->parameters["order"])) {
            $sortcolums = isset($this->parameters["order"][0]["column"]) ? (integer) $this->parameters["order"][0]["column"] : 0;
            $sortdir = isset($this->parameters["order"][0]["dir"]) ? strtoupper($this->parameters["order"][0]["dir"]) : 'ASC';
            switch ($sortcolums) {
                case 0: {
                        $sortqr = 'ORDER BY  (a.`id`)  ' . $sortdir;
                    }break;
                case 1: {
                        $sortqr = 'ORDER BY  (a.`user_name`)  ' . $sortdir;
                    }break;
                case 2: {
                        $sortqr = 'ORDER BY  (f.`user_type`)  ' . $sortdir;
                    }break;
                case 3: {
                        $sortqr = 'ORDER BY  (b.`email`)  ' . $sortdir;
                    }break;
                case 4: {
                        $sortqr = 'ORDER BY  (c.`cnumber`)  ' . $sortdir;
                    }break;
                case 5: {
                        $sortqr = 'ORDER BY  (a.`ot_amt`)  ' . $sortdir;
                    }break;
                default: {
                        $sortqr = 'ORDER BY (a.`id`) DESC';
                    }break;
            }
        }
        /* dynamic query for edit single user list */
        $single_user = $para["var"];
        executeQuery('SET SESSION group_concat_max_len = 1000000;');
        $query = 'SELECT
                a.`id` AS usrid,
                a.`user_name`,
                a.`ot_amt`,
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
                         THEN "' . USER_ANON_IMAGE . '"
                         ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
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
        WHERE (f.`type_id` !=  9 AND f.`type_id` !=  3)
        ' . $searchqr . '
        ' . $single_user . '
        AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
                                                                    `statu_name` = "Hide" OR
                                                                    `statu_name` = "Delete" OR
                                                                    `statu_name` = "Fired" OR
                                                                    `statu_name` = "Inactive"))
        '.$sortqr.';';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $users[] = $row;
            }
        }
        $total = sizeof($users);
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["email_pk"] = explode("☻☻♥♥☻☻", $users[$i]["email_pk"]);
                $users[$i]["email"] = explode("☻☻♥♥☻☻", $users[$i]["email"]);
                $users[$i]["cnumber_pk"] = explode("☻☻♥♥☻☻", $users[$i]["cnumber_pk"]);
                $users[$i]["cnumber"] = explode("☻☻♥♥☻☻", $users[$i]["cnumber"]);
                $users[$i]["bank_pk"] = explode("☻☻♥♥☻☻", $users[$i]["bank_pk"]);
                $users[$i]["bank_name"] = explode("☻☻♥♥☻☻", $users[$i]["bank_name"]);
                $users[$i]["ac_no"] = explode("☻☻♥♥☻☻", $users[$i]["ac_no"]);
                $users[$i]["branch"] = explode("☻☻♥♥☻☻", $users[$i]["branch"]);
                $users[$i]["branch_code"] = explode("☻☻♥♥☻☻", $users[$i]["branch_code"]);
                $users[$i]["IFSC"] = explode("☻☻♥♥☻☻", $users[$i]["IFSC"]);
                $users[$i]["prd_pk"] = explode("☻☻♥♥☻☻", $users[$i]["prd_pk"]);
                $users[$i]["prdname"] = explode("☻☻♥♥☻☻", $users[$i]["prdname"]);
                $users[$i]["prdphoto"] = explode("☻☻♥♥☻☻", $users[$i]["prdphoto"]);
                /* Consignment */
                $users[$i]["conid"] = explode("♥♥♥", $users[$i]["conid"]);
                $users[$i]["supplier"] = explode("♥♥♥", $users[$i]["supplier"]);
                $users[$i]["distributor"] = explode("♥♥♥", $users[$i]["distributor"]);
                /* Vehicle */
                $users[$i]["vhid"] = explode("♥♥♥", $users[$i]["vhid"]);
                $users[$i]["driver"] = explode("♥♥♥", $users[$i]["driver"]);
                $users[$i]["vehicle_no"] = explode("♥♥♥", $users[$i]["vehicle_no"]);
                $users[$i]["packtype"] = explode("♥♥♥", $users[$i]["packtype"]);
                $users[$i]["loaded_weight"] = explode("♥♥♥", $users[$i]["loaded_weight"]);
                $users[$i]["empty_weight"] = explode("♥♥♥", $users[$i]["empty_weight"]);
                $users[$i]["advance_amt"] = explode("♥♥♥", $users[$i]["advance_amt"]);
                $users[$i]["rent"] = explode("♥♥♥", $users[$i]["rent"]);
                $users[$i]["arrival"] = explode("♥♥♥", $users[$i]["arrival"]);
                $users[$i]["departure"] = explode("♥♥♥", $users[$i]["departure"]);
                /* Product */
                $users[$i]["saleprdid"] = explode("♥♥♥", $users[$i]["saleprdid"]);
                $users[$i]["saleprdname"] = explode("♥♥♥", $users[$i]["saleprdname"]);
                $users[$i]["saleprdphoto"] = explode("♥♥♥", $users[$i]["saleprdphoto"]);
                /* Purchase */
                $users[$i]["prchid"] = explode("♥♥♥", $users[$i]["prchid"]);
                $users[$i]["patti_date"] = explode("♥♥♥", $users[$i]["patti_date"]);
                $users[$i]["total_sale"] = explode("♥♥♥", $users[$i]["total_sale"]);
                $users[$i]["total_exp"] = explode("♥♥♥", $users[$i]["total_exp"]);
                $users[$i]["net_sales"] = explode("♥♥♥", $users[$i]["net_sales"]);
                $users[$i]["avg_rate"] = explode("♥♥♥", $users[$i]["avg_rate"]);
                $users[$i]["location"] = explode("♥♥♥", $users[$i]["location"]);
                /* Purchase Expenses */
                $users[$i]["lorry_hire"] = explode("♥♥♥", $users[$i]["lorry_hire"]);
                $users[$i]["commision_cash"] = explode("♥♥♥", $users[$i]["commision_cash"]);
                $users[$i]["labour"] = explode("♥♥♥", $users[$i]["labour"]);
                $users[$i]["association_fee"] = explode("♥♥♥", $users[$i]["association_fee"]);
                $users[$i]["post_fee"] = explode("♥♥♥", $users[$i]["post_fee"]);
                $users[$i]["rmc"] = explode("♥♥♥", $users[$i]["rmc"]);
                $users[$i]["totalexp"] = explode("♥♥♥", $users[$i]["totalexp"]);
                /* Purchase Fields */
                $users[$i]["purchpt"] = explode("♥♥♥", $users[$i]["purchpt"]);
                $users[$i]["purchqt"] = explode("♥♥♥", $users[$i]["purchqt"]);
                $users[$i]["purchprt"] = explode("♥♥♥", $users[$i]["purchprt"]);
                $users[$i]["purchwt"] = explode("♥♥♥", $users[$i]["purchwt"]);
                $users[$i]["purchrt"] = explode("♥♥♥", $users[$i]["purchrt"]);
                $users[$i]["purchat"] = explode("♥♥♥", $users[$i]["purchat"]);
                for ($j = 0; $j < sizeof($users[$i]["purchpt"]) && isset($users[$i]["purchpt"][$j]) && $users[$i]["purchpt"][$j] != ''; $j++) {
                    $users[$i]["purchpt"][$j] = explode("☻♥☻", $users[$i]["purchpt"][$j]);
                    $users[$i]["purchqt"][$j] = explode("☻♥☻", $users[$i]["purchqt"][$j]);
                    $users[$i]["purchprt"][$j] = explode("☻♥☻", $users[$i]["purchprt"][$j]);
                    $users[$i]["purchwt"][$j] = explode("☻♥☻", $users[$i]["purchwt"][$j]);
                    $users[$i]["purchrt"][$j] = explode("☻♥☻", $users[$i]["purchrt"][$j]);
                    $users[$i]["purchat"][$j] = explode("☻♥☻", $users[$i]["purchat"][$j]);
                }
                /* Sales */
                $users[$i]["pattyid"] = explode("♥♥♥", $users[$i]["pattyid"]);
                $users[$i]["sales_date"] = explode("♥♥♥", $users[$i]["sales_date"]);
                $users[$i]["patti_ref_no"] = explode("♥♥♥", $users[$i]["patti_ref_no"]);
                $users[$i]["total_packs"] = explode("♥♥♥", $users[$i]["total_packs"]);
                $users[$i]["total_weight"] = explode("♥♥♥", $users[$i]["total_weight"]);
                $users[$i]["balance"] = explode("♥♥♥", $users[$i]["balance"]);
                $users[$i]["patti_packs"] = explode("♥♥♥", $users[$i]["patti_packs"]);
                $users[$i]["patti_wt"] = explode("♥♥♥", $users[$i]["patti_wt"]);
                $users[$i]["patti_rt"] = explode("♥♥♥", $users[$i]["patti_rt"]);
                $users[$i]["patti_at"] = explode("♥♥♥", $users[$i]["patti_at"]);
                /* Incomming */
                $users[$i]["incid"] = explode("☻☻♥♥☻☻", $users[$i]["incid"]);
                $users[$i]["colldate"] = explode("☻☻♥♥☻☻", $users[$i]["colldate"]);
                $users[$i]["incamt"] = explode("☻☻♥♥☻☻", $users[$i]["incamt"]);
                $users[$i]["incrmk"] = explode("☻☻♥♥☻☻", $users[$i]["incrmk"]);
                $users[$i]["incmop"] = explode("☻☻♥♥☻☻", $users[$i]["incmop"]);
                $users[$i]["incbname"] = explode("☻☻♥♥☻☻", $users[$i]["incbname"]);
                $users[$i]["incbacno"] = explode("☻☻♥♥☻☻", $users[$i]["incbacno"]);
                $users[$i]["incbranch"] = explode("☻☻♥♥☻☻", $users[$i]["incbranch"]);
                $users[$i]["incifsc"] = explode("☻☻♥♥☻☻", $users[$i]["incifsc"]);
                /* Outgoing */
                $users[$i]["outid"] = explode("☻☻♥♥☻☻", $users[$i]["outid"]);
                $users[$i]["paydate"] = explode("☻☻♥♥☻☻", $users[$i]["paydate"]);
                $users[$i]["outamt"] = explode("☻☻♥♥☻☻", $users[$i]["outamt"]);
                $users[$i]["outrmk"] = explode("☻☻♥♥☻☻", $users[$i]["outrmk"]);
                $users[$i]["outmop"] = explode("☻☻♥♥☻☻", $users[$i]["outmop"]);
                $users[$i]["outbname"] = explode("☻☻♥♥☻☻", $users[$i]["outbname"]);
                $users[$i]["outbacno"] = explode("☻☻♥♥☻☻", $users[$i]["outbacno"]);
                $users[$i]["outbranch"] = explode("☻☻♥♥☻☻", $users[$i]["outbranch"]);
                $users[$i]["outbrcode"] = explode("☻☻♥♥☻☻", $users[$i]["outbrcode"]);
                $users[$i]["outifsc"] = explode("☻☻♥♥☻☻", $users[$i]["outifsc"]);
                /* Due */
                $users[$i]["dueid"] = explode("☻☻♥♥☻☻", $users[$i]["dueid"]);
                $users[$i]["due_date"] = explode("☻☻♥♥☻☻", $users[$i]["due_date"]);
                $users[$i]["due_amount"] = explode("☻☻♥♥☻☻", $users[$i]["due_amount"]);
                /* Sale entries */
                $users[$i]["se_id"] = explode("☻☻♥♥☻☻", $users[$i]["se_id"]);
                $users[$i]["se_date"] = explode("☻☻♥♥☻☻", $users[$i]["se_date"]);
                $users[$i]["se_prd"] = explode("☻☻♥♥☻☻", $users[$i]["se_prd"]);
                $users[$i]["se_nopacks"] = explode("☻☻♥♥☻☻", $users[$i]["se_nopacks"]);
                $users[$i]["se_untwt"] = explode("☻☻♥♥☻☻", $users[$i]["se_untwt"]);
                $users[$i]["se_rate"] = explode("☻☻♥♥☻☻", $users[$i]["se_rate"]);
                $users[$i]["se_amount"] = explode("☻☻♥♥☻☻", $users[$i]["se_amount"]);
                $users[$i]["se_tblname"] = explode("☻☻♥♥☻☻", $users[$i]["se_tblname"]);
                $users[$i]["se_invloc"] = explode("☻☻♥♥☻☻", $users[$i]["se_invloc"]);
            }
            $_SESSION["listofusers"] = $users;
        } else {
            $_SESSION["listofusers"] = NULL;
        }
        return $_SESSION["listofusers"];
    }

    public function displayUserList($para = false) {
        $this->parameters = $para;
        $users = array();
        $num_posts = 0;
        if (isset($_SESSION["listofusers"]) && $_SESSION["listofusers"] != NULL)
            $users = $_SESSION["listofusers"];
        else
            $users = NULL;
        if ($users != NULL) {
            //sorting
            if (isset($_GET['sort'])) {
                switch ($_GET['sort']) {
                    case 0:
                        $query = "SELECT * FROM users ORDER BY id DESC";
                        mysqli_query($con, $query);
                        break;
                    case 1:
                        $query = 'SELECT * FROM users ORDER BY user_name DESC';
                        mysqli_query($con, $query);
                        break;
                }
            }
        }

        $num_posts = count($users);
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $data = array();
        $flag = '';
        if ($num_posts > 0) {
            $listusers = array();
            for ($i = $this->parameters["initial"]; $i < $this->parameters["final"] && $i < $num_posts && isset($users[$i]["usrid"]); $i++
            ) {
                //for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                /* Basic info */
                $email = $cnumber = $backac = $prd = '';
                $email_no = $cnum_no = $bank_no = $prd_no = -1;
                /* Email */
                if (is_array($users[$i]["email"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                        $flag = true;
                        $email .= ltrim($users[$i]["email"][$j], ',') . '<br/>';
                        $email_no++;
                    }
                    if (!$flag) {
                        $email = 'Not Provided';
                    }
                }
                /* Cell number */
                if (is_array($users[$i]["cnumber"])) {
                    $flag = false;
                    for ($j = 0; $j < sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                        $flag = true;
                        $cnumber .= ltrim($users[$i]["cnumber"][$j], ',') . '<br/>';
                        $cnum_no++;
                    }
                    if (!$flag) {
                        $cnumber = 'Not Provided';
                    }
                }
                if ($users[$i]["status_id"] == '1') {
                    $flag = '<button class="btn btn-primary btn-md" id="usr_but_flag_' . $users[$i]["usrid"] . '" data-toggle="modal" data-target="#myModal_flag' . $users[$i]["usrid"] . '"><i class="fa fa-flag fa-fw "></i> Flag</button>';
                } else {
                    $flag = '<button class="btn btn-primary btn-md" id="usr_but_unflag_' . $users[$i]["usrid"] . '" data-toggle="modal" data-target="#myModal_unflag' . $users[$i]["usrid"] . '"><i class="fa fa-flag fa-fw "></i> Unflag</button>';
                }
                $htm = '<button class="btn btn-success btn-md" id="usr_but_edit_' . $users[$i]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>
                     <div class="modal fade" id="myUSRDELModal_' . $users[$i]["usrid"] . '" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModalLabel_' . $users[$i]["usrid"] . '" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog">
                        <div class="modal-content" style="color:#000;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myUSRDELModalLabel_' . $users[$i]["usrid"] . '">Select Cell Numbers to send SMS</h4>
                            </div>
                            <div class="modal-body" id="myUSRDEL_' . $users[$i]["usrid"] . '">
                                 Do you really want to delete {' . $users[$i]["user_name"] . '} - {' . $users[$i]["user_type"] . '} - {' . $users[$i]["tnumber"] . '}<br />
                                Press OK to delete ??
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteUSRDELOk_' . $users[$i]["usrid"] . '">Ok</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="deleteUSRDELCancel_' . $users[$i]["usrid"] . '">Cancel</button>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal_flag' . $users[$i]["usrid"] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $users[$i]["usrid"] . '" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog">
                        <div class="modal-content" style="color:#000;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModal_flag_Label_' . $users[$i]["usrid"] . '">Flag User entry</h4>
                            </div>
                            <div class="modal-body">
                                Do You really want to flag the User ' . $users[$i]["user_name"] . ' entry ?? press <strong>OK</strong> to flag
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="$(\'#usr_but_unflag_' . $users[$i]["usrid"] . '\').show(300);$(\'#usr_but_flag_' . $users[$i]["usrid"] . '\').hide(300);" name=".modal-backdrop" id="flagOk_' . $users[$i]["usrid"] . '">Ok</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal" id="flagCancel_' . $users[$i]["usrid"] . '">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal_unflag' . $users[$i]["usrid"] . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $users[$i]["usrid"] . '" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog">
                        <div class="modal-content" style="color:#000;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModal_unflag_Label_' . $users[$i]["usrid"] . '">UnFlag User entry</h4>
                            </div>
                            <div class="modal-body">
                                Do You really want to UnFlag the User ' . $users[$i]["user_name"] . ' entry ?? press <strong>OK</strong> to UnFlag
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflagOk_' . $users[$i]["usrid"] . '">Ok</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal" id="unflagCancel_' . $users[$i]["usrid"] . '">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                </div>';
                array_push($data, array(
                    "#" => $i + 1,
                    "User Name" => $users[$i]["user_name"],
                    "User Type" => $users[$i]["user_type"],
                    "Email" => $email,
                    "Cell No" => $cnumber,
                    "OutStanding" => $users[$i]["ot_amt"] . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i>',
                    "Delete" => '<button class="btn btn-danger btn-md" id="usr_but_trash_' . $users[$i]["usrid"] . '" data-toggle="modal" data-target="#myUSRDELModal_' . $users[$i]["usrid"] . '" ><i class="fa fa-trash fa-fw "></i> Delete</button>',
                    "Flag/Unflag" => $flag,
                    "Edit" => (string) str_replace($this->order, $this->replace, $htm),
                    "uid" => $users[$i]["usrid"],
                    "sr" => '#usr_row' . $users[$i]["usrid"],
                    "alertUSRDEL" => '#myUSRDELModal_' . $users[$i]["usrid"],
                    "usrdelOk" => '#deleteUSRDELOk_' . $users[$i]["usrid"],
                    "usrdelCancel" => '#deleteUSRDELCancel_' . $users[$i]["usrid"],
                    "alertUSRFLG" => '#myModal_flag' . $users[$i]["usrid"] . '',
                    "usrflgOk" => '#flagOk_' . $users[$i]["usrid"] . '',
                    "usrflgCancel" => '#flagCancel_' . $users[$i]["usrid"] . '',
                    "butuflg" => '#usr_but_unflag_' . $users[$i]["usrid"] . '',
                    "alertUSRUFLG" => '#myModal_unflag' . $users[$i]["usrid"] . '',
                    "usruflgOk" => '#unflagOk_' . $users[$i]["usrid"] . '',
                    "usruflgCancel" => '#unflagCancel_' . $users[$i]["usrid"] . '',
                    "usredit" => '#usr_but_edit_' . $users[$i]["usrid"] . '',
                ));
            }
            $listusers["draw"] = $this->parameters["draw"];
            $listusers["recordsTotal"] = $num_posts;
            $listusers["recordsFiltered"] = $num_posts;
            $listusers["data"] = $data;
        }
        return $listusers;
    }

    /* Edit */

    public function editUser() {
        $html = '';
        $listusers = array(
            "html" => '',
        );
        $user_id = $this->parameters["usrid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["usrid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        if (isset($users[0]["usrid"])) {
            /* Basic info */
            $email = $cnumber = $backac = $prd = '';
            $email_no = $cnum_no = $bank_no = $prd_no = -1;
            /* Email */
            if (is_array($users[0]["email"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["email"]) && isset($users[0]["email"][$j]) && $users[0]["email"][$j] != ''; $j++) {
                    $flag = true;
                    $email .= '<li>' . ltrim($users[0]["email"][$j], ',') . '</li>';
                    $email_no++;
                }
                if (!$flag) {
                    $email = '<li>Not Provided</li>';
                }
            }
            /* Cell number */
            if (is_array($users[0]["cnumber"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["cnumber"]) && isset($users[0]["cnumber"][$j]) && $users[0]["cnumber"][$j] != ''; $j++) {
                    $flag = true;
                    $cnumber .= '<li>' . ltrim($users[0]["cnumber"][$j], ',') . '</li>';
                    $cnum_no++;
                }
                if (!$flag) {
                    $cnumber = '<li>Not Provided</li>';
                }
            }
            /* Bank account */
            if (is_array($users[0]["bank_pk"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["bank_pk"]) && isset($users[0]["bank_name"][$j]) && $users[0]["bank_name"][$j] != ''; $j++) {
                    $flag = true;
                    $backac .= '<li>
							' . ltrim($users[0]["bank_name"][$j], ',') . ',&nbsp;
							' . ltrim($users[0]["ac_no"][$j], ',') . ',&nbsp;
							' . ltrim($users[0]["branch"][$j], ',') . ',&nbsp;
							' . ltrim($users[0]["branch_code"][$j], ',') . ',&nbsp;
							' . ltrim($users[0]["IFSC"][$j], ',') . '
							</li>';
                    $bank_no++;
                }
                if (!$flag) {
                    $backac = '<li>Not Provided</li>';
                }
            }
            /* Product */
            if (is_array($users[0]["prd_pk"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["prd_pk"]) && isset($users[0]["prd_pk"]) && $users[0]["prd_pk"][$j] != ''; $j++) {
                    $flag = true;
                    $prd .= '<li>' . ltrim($users[0]["prdname"][$j], ',') .
                            '&nbsp; <img src="' .
                            ltrim($users[0]["prdphoto"][$j], ',') .
                            '" width="50" /> </li>';
                    $prd_no++;
                }
                if (!$flag) {
                    $prd = '<li>Not Provided</li>';
                }
            }
            $basicinfo = str_replace($this->order, $this->replace, '<div class="row"><div class="col-lg-12">
            <div class="col-lg-4"><div class="panel panel-success">
            <div class="panel-heading"><h4>Products</h4></div>
            <div class="panel-body" id="usrprod_' . $users[0]["usrid"] . '">
            <ul>' . $prd . '</ul>
            </div>
            <div class="panel-footer">
            <button type="button" class="btn btn-danger btn-md" id="usrprod_but_addd_' . $users[0]["usrid"] . '"><i class="fa fa-plus fa-fw "></i> Add</button>&nbsp&nbsp
            <button type="button" class="btn btn-danger btn-md" id="usrprod_but_edit_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
            <button type="button" class="btn btn-danger btn-md" id="usrprod_but_delt_' . $users[0]["usrid"] . '"><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp&nbsp
            <button type="button" class="btn btn-danger btn-md" style="display:none" id="usrprod_but_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Save</button>
            </div>
            </div>
            </div>
            <div class="col-lg-4"><div class="panel panel-green">
                    <div class="panel-heading">
                      <h4>Email ids</h4>
                    </div>
                    <div class="panel-body" id="usremail_' . $users[0]["usrid"] . '">
                      <ul>' . $email . '</ul>
                    </div>
                    <div class="panel-footer">
                      <button type="button" class="btn btn-danger btn-md" id="usremail_but_addd_' . $users[0]["usrid"] . '"><i class="fa fa-plus fa-fw "></i> Add</button>&nbsp&nbsp
                      <button type="button" class="btn btn-danger btn-md" id="usremail_but_edit_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
                      <button type="button" class="btn btn-danger btn-md" id="usremail_but_delt_' . $users[0]["usrid"] . '"><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp&nbsp
                      <button type="button" class="btn btn-danger btn-md" style="display:none" id="usremail_but_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Save</button>
                    </div>
                    </div>
            </div>
            <div class="col-lg-4">
                    <div class="panel panel-primary">
                    <div class="panel-heading">
                      <h4>Cell numbers</h4>
                    </div>
                    <div class="panel-body" id="usrcnum_' . $users[0]["usrid"] . '">
                      <ul>' . $cnumber . '</ul>
                    </div>
                    <div class="panel-footer">
                      <button type="button" class="btn btn-danger btn-md" id="usrcnum_but_addd_' . $users[0]["usrid"] . '"><i class="fa fa-plus fa-fw "></i> Add</button>&nbsp&nbsp
                      <button type="button" class="btn btn-danger btn-md" id="usrcnum_but_edit_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>&nbsp&nbsp
                      <button type="button" class="btn btn-danger btn-md" id="usrcnum_but_delt_' . $users[0]["usrid"] . '"><i class="fa fa-trash fa-fw "></i> Delete</button>&nbsp&nbsp
                      <button type="button" class="btn btn-danger btn-md" style="display:none" id="usrcnum_but_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Save</button>
                    </div>
                    </div>
            </div>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
            <div class="col-lg-4"><div class="panel panel-yellow"><div class="panel-heading"><h4>Photo</h4></div><div class="panel-body" id="usrphoto_' . $users[0]["usrid"] . '"><img src="' . $users[0]["usrphoto"] . '" width="150" /></div><div class="panel-footer" style="display:none;"><button type="button"  class="btn btn-yellow btn-md" id="usrphoto_but_edit_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div>
            <div class="col-lg-8"><div class="panel panel-red"><div class="panel-heading"><h4>Address</h4></div>
            <div class="panel-body" id="usradd_' . $users[0]["usrid"] . '" style="display:block;">
                    <ul>
                            <li><strong>Address line : </strong>' . $users[0]["addressline"] . '</li>
                            <li><strong>Street / Locality : </strong>' . $users[0]["town"] . '</li>
                            <li><strong>City / Town : </strong>' . $users[0]["city"] . '</li>
                            <li><strong>District / Department : </strong>' . $users[0]["district"] . '</li>
                            <li><strong>State / Province : </strong>' . $users[0]["province"] . '</li>
                            <li><strong>Country : </strong>' . $users[0]["country"] . '</li>
                            <li><strong>Zipcode : </strong>' . $users[0]["zipcode"] . '</li>
                            <li><strong>Website : </strong>' . $users[0]["website"] . '</li>
                            <li><strong>Google Map : </strong>' . $users[0]["website"] . '</li>
                    </ul>
            </div>
            <div class="panel-body" id="usradd_edit_' . $users[0]["usrid"] . '" style="display:none;">
                    <form id="user_address_edit_form_' . $users[0]["usrid"] . '">
                    <!-- Country -->
                    <div class="row">
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Country <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="Country" name="country" type="text" id="country_' . $users[0]["usrid"] . '" maxlength="100" value="' . $users[0]["country"] . '"/>
                                            <p class="help-block" id="comsg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                            <!-- State / Province -->
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> State / Province <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="State / Province" name="province" type="text" id="province_' . $users[0]["usrid"] . '" maxlength="150" value="' . $users[0]["province"] . '"/>
                                            <p class="help-block" id="prmsg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                    </div>
                    <!-- District / Department -->
                    <div class="row">
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> District / Department <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="District / Department" name="district" type="text" id="district_' . $users[0]["usrid"] . '" maxlength="100" value="' . $users[0]["district"] . '"/>
                                            <p class="help-block" id="dimsg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                            <!-- City / Town -->
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> City / Town <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="City / Town" name="city_town" type="text" id="city_town_' . $users[0]["usrid"] . '" maxlength="100" value="' . $users[0]["city"] . '"/>
                                            <p class="help-block" id="citmsg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                    </div>
                    <!-- Street / Locality -->
                    <div class="row">
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Street / Locality <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="Street / Locality" name="st_loc" type="text" id="st_loc_' . $users[0]["usrid"] . '" maxlength="100" value="' . $users[0]["town"] . '"/>
                                            <p class="help-block" id="stlmsg_' . $users[0]["usrid"] . '">Press enter or go button to move to next feild.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                            <!-- Address Line -->
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Address Line <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="Address Line" name="addrs" type="text" id="addrs_' . $users[0]["usrid"] . '" maxlength="200" value="' . $users[0]["addressline"] . '"/>
                                            <p class="help-block" id="admsg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                    </div>
                    <!-- Zipcode -->
                    <div class="row">
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Zipcode <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="Zipcode" name="zipcode" type="text" id="zipcode_' . $users[0]["usrid"] . '" maxlength="25" value="' . $users[0]["zipcode"] . '"/>
                                            <p class="help-block" id="zimsg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                            <!-- Personal Website -->
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Personal Website <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="Personal Website" name="website" type="text" id="website_' . $users[0]["usrid"] . '" maxlength="250" value="' . $users[0]["website"] . '"/>
                                            <p class="help-block" id="wemsg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                    </div>
                    <!-- Google Map URL -->
                    <div class="row">
                            <div class="col-lg-6">
                                    <div class="col-lg-12">
                                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Google Map URL <i class="fa fa-caret-down fa-fw"></i></strong>
                                    </div>
                                    <div class="col-lg-12">
                                            <input class="form-control" placeholder="Google Map URL" name="gmaphtml" type="text" id="gmaphtml_' . $users[0]["usrid"] . '" value="' . $users[0]["gmaphtml"] . '"/>
                                            <p class="help-block" id="gmmsg_' . $users[0]["usrid"] . '">Press enter or go button to update user address.</p>
                                    </div>
                                    <div class="col-lg-12">&nbsp;</div>
                            </div>
                    </div>
                    <!-- Update -->
                    <div class="row">
                            <div class="col-lg-12">&nbsp;</div>
                            <div class="col-lg-12 text-center">
                                    <button type="button"  class="btn btn-danger btn-md" id="usr_address_update_but_' . $users[0]["usrid"] . '"><i class="fa fa-upload fa-fw "></i> Update</button>
                                    &nbsp;<button type="button"  class="btn btn-danger btn-md" id="usr_address_close_but_' . $users[0]["usrid"] . '"><i class="fa fa-close fa-fw "></i> Close</button>
                            </div>
                    </div>
                    </form>
            </div>
            <div class="panel-footer"><button type="button"  class="btn btn-danger btn-md" id="usraddr_but_edit_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button></div></div></div></div></div>');
            /* Transactions */
            $incomming = '';
            $outgoing = '';
            $due = '';
            /* Incomming */
            if (is_array($users[0]["incid"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["incid"]) && isset($users[0]["incid"]) && $users[0]["incid"][$j] != ''; $j++) {
                    $flag = true;
                    $mop = ltrim($users[0]["incmop"][$j], ',');
                    if ($mop != 'Cash') {
                        $incbname = isset($users[0]["incbname"][$j]) ? ltrim($users[0]["incbname"][$j], ',') . ', ' : 'Not Provided';
                        $incbacno = isset($users[0]["incbacno"][$j]) ? ltrim($users[0]["incbacno"][$j], ',') . ', ' : 'Not Provided';
                        $incbranch = isset($users[0]["incbranch"][$j]) ? ltrim($users[0]["incbranch"][$j], ',') . ', ' : 'Not Provided';
                        $incifsc = isset($users[0]["incifsc"][$j]) ? ltrim($users[0]["incifsc"][$j], ',') : 'Not Provided';
                        $bankdet = $incbname . $incbacno . $incbranch . $incifsc;
                    } else
                        $bankdet = 'Cash';
                    $incomming .= '<tr>
                                <td>' . ($j + 1) . '</td>
                                <td>' . date("j-M-Y", strtotime(ltrim($users[0]["colldate"][$j], ','))) . '</td>
                                <td class="text-right">' . ltrim($users[0]["incamt"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
                                <td class="text-right">' . ltrim($users[0]["incrmk"][$j], ',') . '</td>
                                <td class="text-right">' . ltrim($users[0]["incmop"][$j], ',') . '</td>
                                <td class="text-right">' . $bankdet . '</td>
                                </tr>';
                }
                if (!$flag)
                    $incomming = '<tr><td colspan="6">No incomming transactions have been done.</td></tr>';
            }
            /* Outgoing */
            if (is_array($users[0]["outid"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["outid"]) && isset($users[0]["outid"]) && $users[0]["outid"][$j] != ''; $j++) {
                    $flag = true;
                    $mop = ltrim($users[0]["outmop"][$j], ',');
                    if ($mop != 'Cash') {
                        $outbname = isset($users[0]["outbname"][$j]) ? ltrim($users[0]["outbname"][$j], ',') . ', ' : 'Not Provided';
                        $outbacno = isset($users[0]["outbacno"][$j]) ? ltrim($users[0]["outbacno"][$j], ',') . ', ' : 'Not Provided';
                        $outbranch = isset($users[0]["outbranch"][$j]) ? ltrim($users[0]["outbranch"][$j], ',') . ', ' : 'Not Provided';
                        $outifsc = isset($users[0]["outifsc"][$j]) ? ltrim($users[0]["outifsc"][$j], ',') : 'Not Provided';
                        $bankdet = $outbname . $outbacno . $outbranch . $outifsc;
                    } else
                        $bankdet = 'Cash';
                    $outgoing .= '<tr>
                    <td>' . ($j + 1) . '</td>
                    <td>' . date("j-M-Y", strtotime(ltrim($users[0]["paydate"][$j], ','))) . '</td>
                    <td class="text-right">' . ltrim($users[0]["outamt"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
                    <td class="text-right">' . ltrim($users[0]["outrmk"][$j], ',') . '</td>
                    <td class="text-right">' . ltrim($users[0]["outmop"][$j], ',') . '</td>
                    <td class="text-right">' . $bankdet . '</td>
                    </tr>';
                }
                if (!$flag)
                    $outgoing = '<tr><td colspan="6">No outgoing transactions have been done.</td></tr>';
            }
            /* Due */
            if (is_array($users[0]["dueid"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["dueid"]) && isset($users[0]["dueid"]) && $users[0]["dueid"][$j] != ''; $j++) {
                    $flag = true;
                    $amt = (integer) ltrim($users[0]["due_amount"][$j], ',');
                    if ($amt > 0)
                        $due .= '<tr>
                            <td>' . ($j + 1) . '</td>
                            <td>' . date("j-M-Y", strtotime(ltrim($users[0]["due_date"][$j], ','))) . '</td>
                            <td class="text-right">' . $amt . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
                    </tr>';
                }
                if (!$flag)
                    $due = '<tr><td colspan="3">No due amounts.</td></tr>';
            }
            $trasac = '<div class="row"><div class="col-lg-12 table-responsive" ><table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="6">Incomming Transactions</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>' . $incomming . '</table></div><div class="col-lg-12">&nbsp;</div></div><div class="row"><div class="col-lg-12 table-responsive" ><table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="6">Outgoing Transactions</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th><th class="text-right">Remark</th><th class="text-right">Mode of payment</th><th class="text-right">Bank details</th></tr></thead>' . $outgoing . '</table></div><div class="col-lg-12">&nbsp;</div></div><div class="row"><div class="col-lg-12 table-responsive" ><table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="6">Due</th></tr><tr><th>#</th><th>Date</th><th class="text-right">Amount</th></tr></thead>' . $due . '</table></div><div class="col-lg-12">&nbsp;</div></div>';
            /* Sale entries */
            $saleentry = '';
            if (is_array($users[0]["se_id"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["se_id"]) && isset($users[0]["se_id"]) && $users[0]["se_id"][$j] != ''; $j++) {
                    $flag = true;
                    $saleentry .= '<tr>
                                <td>' . ($j + 1) . '</td>
                                <td>' . date("j-M-Y", strtotime(ltrim($users[0]["se_date"][$j], ','))) . '</td>
                                <td>' . ltrim($users[0]["se_prd"][$j], ',') . '</td>
                                <td class="text-right">' . ltrim($users[0]["se_nopacks"][$j], ',') . '</td>
                                <td class="text-right">' . ltrim($users[0]["se_untwt"][$j], ',') . '</td>
                                <td class="text-right">' . ltrim($users[0]["se_rate"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
                                <td class="text-right">' . ltrim($users[0]["se_amount"][$j], ',') . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></td>
                                <td class="text-right"><button type="button"  class="btn btn-primary" onClick="window.open(\'' . ltrim($users[0]["se_invloc"][$j], ',') . '\');" href="javascript:void();" target="_new">Print</button></td>
                        </tr>';
                }
                if (!$flag)
                    $saleentry = '<tr><td colspan="8">No sale entries available.</td></tr>';
            }
            $sals = str_replace($this->order, $this->replace, '<div class="row">
                    <div class="col-lg-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover">
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
            </div>');
            /* Purchase */
            $consignment = '';
            $conrow = '';
            $vehicle = '';
            $product = '';
            $sales = '';
            $purchase = '';
            if (is_array($users[0]["conid"])) {
                $flag = false;
                for ($j = 0; $j < sizeof($users[0]["conid"]) && isset($users[0]["conid"]) && $users[0]["conid"][$j] != ''; $j++) {
                    $flag = true;
                    /**/
                    $vhno = isset($users[0]["vehicle_no"][$j]) && $users[0]["vehicle_no"][$j] != '' ? ltrim($users[0]["vehicle_no"][$j], ',') : '';
                    $packtype = isset($users[0]["packtype"][$j]) && $users[0]["packtype"][$j] != '' ? ltrim($users[0]["packtype"][$j], ',') : '';
                    $ld = isset($users[0]["loaded_weight"][$j]) && $users[0]["loaded_weight"][$j] != '' ? ltrim($users[0]["loaded_weight"][$j], ',') : '';
                    $arr = isset($users[0]["arrival"][$j]) ? date("j-M-Y", strtotime(ltrim($users[0]["arrival"][$j], ','))) : '';
                    $vehicle = str_replace($this->order, $this->replace, '<dl class="dl-horizontal">
                                        <dt>Vehicle NO :- </dt><dd>' . $vhno . '</dd>
                                        <dt>Packing type :- </dt><dd>' . $packtype . '</dd>
                                        <dt>Loaded Weight :- </dt><dd>' . $ld . '</dd>
                                        <dt>Arrival :- </dt><dd>' . $arr . '</dd></dl>');
                    /**/
                    $saleprdname = isset($users[0]["saleprdname"][$j]) && $users[0]["saleprdname"][$j] != '' ? ltrim($users[0]["saleprdname"][$j], ',') : '';
                    $saleprdphoto = isset($users[0]["saleprdphoto"][$j]) && $users[0]["saleprdphoto"][$j] != '' ? ltrim($users[0]["saleprdphoto"][$j], ',') : '';
                    $product = $saleprdname . '&nbsp; <img src="' . $saleprdphoto . '" width="50" />';
                    /**/
                    $patti_ref_no = isset($users[0]["patti_ref_no"][$j]) && $users[0]["patti_ref_no"][$j] != '' ? ltrim($users[0]["patti_ref_no"][$j], ',') : '';
                    $total_packs = isset($users[0]["total_packs"][$j]) && $users[0]["total_packs"][$j] != '' ? ltrim($users[0]["total_packs"][$j], ',') : '';
                    $total_weight = isset($users[0]["total_weight"][$j]) && $users[0]["total_weight"][$j] != '' ? ltrim($users[0]["total_weight"][$j], ',') : '';
                    $patti_rt = isset($users[0]["patti_rt"][$j]) && $users[0]["patti_rt"][$j] != '' ? ltrim($users[0]["patti_rt"][$j], ',') : 0;
                    $patti_at = isset($users[0]["patti_at"][$j]) && $users[0]["patti_at"][$j] != '' ? ltrim($users[0]["patti_at"][$j], ',') : 0;
                    $sales_date = isset($users[0]["sales_date"][$j]) ? date("j-M-Y", strtotime(ltrim($users[0]["sales_date"][$j], ','))) : '';
                    $sales = str_replace($this->order, $this->replace, '<dl class="dl-horizontal">
                            <dt>Reference NO :- </dt><dd>' . $patti_ref_no . '</dd>
                            <dt>Total packs :- </dt><dd>' . $total_packs . '</dd>
                            <dt>Total Weight :- </dt><dd>' . $total_weight . '</dd>
                            <dt>Avg Rate :- </dt><dd>' . $patti_rt . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></dd>
                            <dt>Net Sale :- </dt><dd>' . $patti_at . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></dd>
                            <dt>Sales date :- </dt><dd>' . $sales_date . '</dd></dl>');
                    /**/
                    $total_sale = isset($users[0]["total_sale"][$j]) && $users[0]["total_sale"][$j] != '' ? ltrim($users[0]["total_sale"][$j], ',') : '';
                    $total_exp = isset($users[0]["total_exp"][$j]) && $users[0]["total_exp"][$j] != '' ? ltrim($users[0]["total_exp"][$j], ',') : 0;
                    $avg_rate = isset($users[0]["avg_rate"][$j]) && $users[0]["avg_rate"][$j] != '' ? ltrim($users[0]["avg_rate"][$j], ',') : 0;
                    $net_sales = isset($users[0]["net_sales"][$j]) && $users[0]["net_sales"][$j] != '' ? ltrim($users[0]["net_sales"][$j], ',') : 0;
                    $sales_date = isset($users[0]["patti_date"][$j]) && $users[0]["patti_date"][$j] != '' ? date("j-M-Y", strtotime(ltrim($users[0]["patti_date"][$j], ','))) : '';
                    $purchase = str_replace($this->order, $this->replace, '<dl class="dl-horizontal">
                            <dt>Total Sale :- </dt><dd>' . $total_sale . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></dd>
                            <dt>Total Expenses :- </dt><dd>' . $total_exp . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></dd>
                            <dt>Avg rate :- </dt><dd>' . $avg_rate . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></dd>
                            <dt>Total Net Sale :- </dt><dd>' . $net_sales . '&nbsp;<i class="fa fa-rupee fa-fw fa-x2"></i></dd>
                            <dt>Patty date :- </dt><dd>' . $sales_date . '</dd></dl>');
                    $pattyloc = isset($users[0]["location"][$j]) && $users[0]["location"][$j] != '' ? ltrim($users[0]["location"][$j], ',') : '';
                    $conrow .= str_replace($this->order, $this->replace, '<tr>
                                <td>' . ($j + 1) . '</td>
                                <td>' . $vehicle . '</td>
                                <td>' . $product . '</td>
                                <td>' . $sales . '</td>
                                <td>' . $purchase . '</td>
                                <td><button type="button"  class="btn btn-primary" onClick="window.open(\'' . URL . $pattyloc . '\');" href="javascript:void();" target="_new">Print</button></td>
                        </tr>');
                }
                if (!$flag)
                    $conrow = '<tr><td colspan="6">No purchase entries available.</td></tr>';
            }
            $consignment = '<div class="row"><div class="col-lg-12 table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th colspan="6">Pattys</th></tr><tr><th>#</th><th>Vehicle</th><th>Product</th><th>Sales</th><th>Purchase</th><th>Patty</th></tr></thead>' . $conrow . '</table></div></div>';
            $editHtml = str_replace($this->order, $this->replace, '<div class="col-lg-6">
            <div class="panel panel-yellow">
            <div class="panel-heading">
                    <h4>Basic Info -- ' . ucfirst($users[0]["user_name"]) . ' -- ' . ucfirst($users[0]["user_type"]) . '</h4>
            </div>
            <div class="panel-body" id="acrdedituser_' . $users[0]["usrid"] . '">
            <form id="usreditForm_' . $users[0]["usrid"] . '">
            <div class="row">
            <div class="col-lg-12">
            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> User Type <i class="fa fa-caret-down fa-fw"></i></strong>
            </div>
            <div class="col-lg-12 form-group">
            <div class="form-group" id="TVUtype_' . $users[0]["usrid"] . '">
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
            <input class="form-control" placeholder="User Name" name="user_name_' . $users[0]["usrid"] . '" type="text" id="user_name_' . $users[0]["usrid"] . '" maxlength="100" value="' . $users[0]["user_name"] . '"/>
            <p class="help-block" id="user_name_msg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            </div>
            <div class="row">
            <div class="col-lg-12">
            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Outstanding Amount <i class="fa fa-caret-down fa-fw"></i></strong>
            </div>
            <div class="col-lg-12">
            <input class="form-control" placeholder="Outstanding Amount" name="ot_amt_' . $users[0]["usrid"] . '" type="text" id="ot_amt_' . $users[0]["usrid"] . '" maxlength="11" value="' . $users[0]["ot_amt"] . '"/>
            <p class="help-block" id="ot_amt_msg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            </div>
            <div class="row">
            <div class="col-lg-12">
            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Telephone Number <i class="fa fa-caret-down fa-fw"></i></strong>
            </div>
            <div class="col-lg-12">
            <div class="col-lg-4">
            <input class="form-control" placeholder="080" name="pcode_' . $users[0]["usrid"] . '" type="text" id="pcode_' . $users[0]["usrid"] . '" maxlength="15" value="' . $users[0]["pcode"] . '" />
            </div>
            <div class="col-lg-8">
            <input class="form-control" placeholder="Telephone Number" name="telephone_' . $users[0]["usrid"] . '" type="text" id="telephone_' . $users[0]["usrid"] . '" maxlength="20" value="' . $users[0]["tnumber"] . '" />
            </div>
            <p class="help-block" id="tp_msg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            </div>
            <div class="row" style="display:none;">
            <div class="col-lg-12">
            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> ACS ID <i class="fa fa-caret-down fa-fw"></i></strong>
            </div>
            <div class="col-lg-12">
            <input class="form-control" placeholder="Access Id for short login id" name="acs_id_' . $users[0]["usrid"] . '" type="text" id="acs_id_' . $users[0]["usrid"] . '" maxlength="15" />
            <p class="help-block" id="ac_msg_' . $users[0]["usrid"] . '">Enter/ Select.</p>
            </div>
            <div class="col-lg-12">&nbsp;</div>
            </div>
            <div class="pane-footer">
            <button type="button"  class="btn btn-md btn-warning" href="javascript:void(0);" id="edituserBut_' . $users[0]["usrid"] . '"><i class="fa fa-upload fa-fw fa-2x"></i> &nbsp;Update</button>
            </div>
            </form>
            </div>
            </div>
            </div>
            <div class="col-lg-6">
            <div class="panel panel-red">
            <div class="panel-heading">
            <h4>Bank accounts</h4>
            </div>
            <div class="panel-body" id="usrbank_' . $users[0]["usrid"] . '">
            <ul>' . $backac . '</ul>
            </div>
            <div class="panel-footer">
            <button type="button"  class="btn btn-danger btn-md" id="usrbank_but_edit_' . $users[0]["usrid"] . '"><i class="fa fa-edit fa-fw "></i> Edit</button>
            </div>
            </div>
            </div>
            <script>') . '
                    $(document).ready(function(){
                            var editUserBasicInfo = {
                                    autoloader : true,
                                    action 	   	: "editUserBasicInfo",
                                    outputDiv  	: "#output",
                                    parentDiv  	: "#acrdedituser_' . $users[0]["usrid"] . '",
                                    but  	   	: "#edituserBut_' . $users[0]["usrid"] . '",
                                    menuBut  	: "#edt_user_but_' . $users[0]["usrid"] . '",
                                    reloadBut	: "#listusersbut",
                                    uid	   	: ' . $users[0]["usrid"] . ',
                                    index  	   	: 0,
                                    listindex  	: "listofusers",
                                    form  		: "#usreditForm_' . $users[0]["usrid"] . '",
                                    TVUtype		: "#TVUtype_' . $users[0]["usrid"] . '",
                                    user_type	: "user_type_edit_' . $users[0]["usrid"] . '",
                                    ut_msg		: "user_type_msg_' . $users[0]["usrid"] . '",
                                    name 		: "#user_name_' . $users[0]["usrid"] . '",
                                    nmsg 		: "#user_name_msg_' . $users[0]["usrid"] . '",
                                    otamt 		: "#ot_amt_' . $users[0]["usrid"] . '",
                                    otamtmsg 	: "#ot_amt_msg_' . $users[0]["usrid"] . '",
                                    pcode 		: "#pcode_' . $users[0]["usrid"] . '",
                                    tphone 		: "#telephone_' . $users[0]["usrid"] . '",
                                    tpmsg 		: "#tp_msg_' . $users[0]["usrid"] . '",
                                    acs_id 		: "#acs_id_' . $users[0]["usrid"] . '",
                                    ac_msg 		: "#ac_msg_' . $users[0]["usrid"] . '",
                                    url		: window.location.href
                            };
                            $(editUserBasicInfo.menuBut).click(function(evt){
                                    var obj = new userController();
                                    obj.editUserBasicInfo(editUserBasicInfo);
                            });
                            var email = {
                                    autoloader : true,
                                    action 	   : "loadEmailIdForm",
                                    outputDiv  : "#output",
                                    parentDiv  : "#usremail_' . $users[0]["usrid"] . '",
                                    addd       : "#usremail_but_addd_' . $users[0]["usrid"] . '",
                                    edit       : "#usremail_but_edit_' . $users[0]["usrid"] . '",
                                    delt       : "#usremail_but_delt_' . $users[0]["usrid"] . '",
                                    num        : Number(' . ($email_no - 1) . '),
                                    uid	   : ' . $users[0]["usrid"] . ',
                                    index  	   : 0,
                                    listindex  : "listofusers",
                                    form 	   : "email_id_' . $users[0]["usrid"] . '_",
                                    email 	   : "email_' . $users[0]["usrid"] . '_",
                                    msgDiv 	   : "email_msg_' . $users[0]["usrid"] . '_",
                                    plus 	   : "plus_email_' . $users[0]["usrid"] . '_",
                                    minus 	   : "minus_email_' . $users[0]["usrid"] . '_",
                                    saveBut	   : "usremail_but_' . $users[0]["usrid"] . '",
                                    closeBut   : "usremail_close_' . $users[0]["usrid"] . '",
                                    url 	   : window.location.href
                            };
                            var obj = new userController();
                            obj.alterClientEmailIds(email);
                            var cnum = {
                                    autoloader : true,
                                    action 	   : "loadCellNumForm",
                                    outputDiv  : "#output",
                                    parentDiv  : "#usrcnum_' . $users[0]["usrid"] . '",
                                    addd	   : "#usrcnum_but_addd_' . $users[0]["usrid"] . '",
                                    edit       : "#usrcnum_but_edit_' . $users[0]["usrid"] . '",
                                    delt       : "#usrcnum_but_delt_' . $users[0]["usrid"] . '",
                                    num        : Number(' . ($cnum_no - 1) . '),
                                    uid        : ' . $users[0]["usrid"] . ',
                                    index  	   : 0,
                                    listindex  : "listofusers",
                                    form 	   : "cnum_id_' . $users[0]["usrid"] . '_",
                                    cnumber	   : "cnum_' . $users[0]["usrid"] . '_",
                                    msgDiv 	   : "cnum_msg_' . $users[0]["usrid"] . '_",
                                    plus 	   : "plus_cnum_' . $users[0]["usrid"] . '_",
                                    minus 	   : "minus_cnum_' . $users[0]["usrid"] . '_",
                                    saveBut	   : "usrcnum_but_' . $users[0]["usrid"] . '",
                                    closeBut   : "usrcnum_close_' . $users[0]["usrid"] . '",
                                    url 	   : window.location.href
                            };
                            var obj = new userController();
                            obj.alterClientCellNumbers(cnum);
                            var editUserProducts = {
                                    autoloader : true,
                                    action 	   : "loadProdForm",
                                    outputDiv  : "#output",
                                    parentDiv  : "#usrprod_' . $users[0]["usrid"] . '",
                                    addd	   : "#usrprod_but_addd_' . $users[0]["usrid"] . '",
                                    edit       : "#usrprod_but_edit_' . $users[0]["usrid"] . '",
                                    delt       : "#usrprod_but_delt_' . $users[0]["usrid"] . '",
                                    num   	   : Number(' . ($prd_no - 1) . '),
                                    uid	   	   : ' . $users[0]["usrid"] . ',
                                    index  	   : 0,
                                    listindex  : "listofusers",
                                    form 	   : "prod_id_' . $users[0]["usrid"] . '_",
                                    prdname	   : "prod_' . $users[0]["usrid"] . '_",
                                    msgDiv 	   : "prod_msg_' . $users[0]["usrid"] . '_",
                                    plus 	   : "plus_prod_' . $users[0]["usrid"] . '_",
                                    minus 	   : "minus_prod_' . $users[0]["usrid"] . '_",
                                    saveBut	   : "usrprod_but_' . $users[0]["usrid"] . '",
                                    closeBut   : "usrprod_close_' . $users[0]["usrid"] . '",
                                    url 	   : window.location.href
                            };
                            var obj = new userController();
                            obj.alterClientProducts(editUserProducts);
                            var editUserBankAccounts = {
                                    autoloader : true,
                                    action 	   : "loadBankAcForm",
                                    outputDiv  : "#output",
                                    parentDiv  : "#usrbank_' . $users[0]["usrid"] . '",
                                    but  	   : "#usrbank_but_edit_' . $users[0]["usrid"] . '",
                                    num   	   : ' . $bank_no . ',
                                    uid        : ' . $users[0]["usrid"] . ',
                                    index  	   : 0,
                                    listindex  : "listofusers",
                                    form 	   : "usrbankname_form_' . $users[0]["usrid"] . '_",
                                    bankname   : "usrbankname_' . $users[0]["usrid"] . '_",
                                    nmsg  	   : "usrbanknamemsg_' . $users[0]["usrid"] . '_",
                                    accno 	   : "usraccno_' . $users[0]["usrid"] . '_",
                                    nomsg 	   : "usraccnomsg_' . $users[0]["usrid"] . '_",
                                    braname	   : "usrbraname_' . $users[0]["usrid"] . '_",
                                    bnmsg	   : "usrbranamemsg_' . $users[0]["usrid"] . '_",
                                    bracode	   : "usrbracode_' . $users[0]["usrid"] . '_",
                                    bcmsg	   : "usrbracodemsg_' . $users[0]["usrid"] . '_",
                                    IFSC	   : "usrIFSC_' . $users[0]["usrid"] . '_",
                                    IFSCmsg	   : "usrIFSCmsg_' . $users[0]["usrid"] . '_",
                                    plus 	   : "usrplus_bankac' . $users[0]["usrid"] . '_",
                                    minus 	   : "usrminus_bankac' . $users[0]["usrid"] . '_",
                                    saveBut	   : "usrusrbankacbut_' . $users[0]["usrid"] . '",
                                    closeBut   : "usrusrbankacclose_' . $users[0]["usrid"] . '",
                                    url 	   : window.location.href
                            };
                            $(editUserBankAccounts.but).click(function(evt){
                                    evt.preventDefault();
                                    $(this).toggle();
                                    var obj = new userController();
                                    obj.editUserBankAccounts(editUserBankAccounts);
                            });
                            var editUserAddress = {
                                    autoloader 		: true,
                                    action 	   		: "loadAddressForm",
                                    outputDiv  		: "#output",
                                    showDiv 		: "#usradd_' . $users[0]["usrid"] . '",
                                    updateDiv 		: "#usradd_edit_' . $users[0]["usrid"] . '",
                                    uid			: ' . $users[0]["usrid"] . ',
                                    index  	   		: 0,
                                    listindex  		: "listofusers",
                                    but			: "#usraddr_but_edit_' . $users[0]["usrid"] . '",
                                    saveBut	   		: "#usr_address_update_but_' . $users[0]["usrid"] . '",
                                    closeBut   		: "#usr_address_close_but_' . $users[0]["usrid"] . '",
                                    form 	   		: "#usrbankname_form_' . $users[0]["usrid"] . '_",
                                    country 		: "#country_' . $users[0]["usrid"] . '",
                                    countryCode		: null,
                                    countryId 		: null,
                                    comsg 			: "#comsg_' . $users[0]["usrid"] . '",
                                    province 		: "#province_' . $users[0]["usrid"] . '",
                                    provinceCode		: null,
                                    provinceId 		: null,
                                    prmsg 			: "#prmsg_' . $users[0]["usrid"] . '",
                                    district 		: "#district_' . $users[0]["usrid"] . '",
                                    districtCode		: null,
                                    districtId 		: null,
                                    dimsg 			: "#dimsg_' . $users[0]["usrid"] . '",
                                    city_town 		: "#city_town_' . $users[0]["usrid"] . '",
                                    city_townCode		: null,
                                    city_townId		: null,
                                    citmsg 			: "#citmsg_' . $users[0]["usrid"] . '",
                                    st_loc 			: "#st_loc_' . $users[0]["usrid"] . '",
                                    st_locCode 		: null,
                                    st_locId 		: null,
                                    stlmsg 			: "#stlmsg_' . $users[0]["usrid"] . '",
                                    addrs 			: "#addrs_' . $users[0]["usrid"] . '",
                                    admsg 			: "#admsg_' . $users[0]["usrid"] . '",
                                    zipcode 		: "#zipcode_' . $users[0]["usrid"] . '",
                                    zimsg 			: "#zimsg_' . $users[0]["usrid"] . '",
                                    website 		: "#website_' . $users[0]["usrid"] . '",
                                    wemsg 			: "#wemsg_' . $users[0]["usrid"] . '",
                                    tphone 			: "#telephone_' . $users[0]["usrid"] . '",
                                    gmaphtml 		: "#gmaphtml_' . $users[0]["usrid"] . '",
                                    gmmsg 			: "#gmmsg_' . $users[0]["usrid"] . '",
                                    lat 			: null,
                                    lon 			: null,
                                    timezone 		: null,
                                    PCR_reg 		: null,
                                    url 			: URL+"address.php",
                                    Updateurl		: window.location.href
                            };
                            $(editUserAddress.but).click(function(evt){
                                    evt.preventDefault();
                                    $(this).toggle();
                                    var obj = new userController();
                                    obj.editUserAddress(editUserAddress);
                            });
                            var close = {
                                    closeDiv    : "#close_' . $users[0]["usrid"] . '",
                                    listtab	    : "#listusersbut"
                            };
                            var obj = new userController();
                            obj.close(close);
                    });
            </script>';
            $html = '<div class="panel panel-default" id="usr_row' . $users[0]["usrid"] . '">
                    <div class="panel-heading" >
                            <div class="row" >
                                    <div class="col-md-6">
                                            <button type="button"  class="btn btn-danger btn-md" id="close_' . $users[0]["usrid"] . '"><i class="fa fa-close fa-fw "></i> Close</button>
                                    </div>
                            </div>
                    </div>';
            $html .= '<div id="user_type_' . $users[0]["usrid"] . '" class="active" class="panel-body panel-collapse collapse" style="height: 0px;">
                            <ul class="nav nav-pills">
                                    <li class="active"><a href="#info_user_type_' . $users[0]["usrid"] . '" data-toggle="tab">Basic info</a></li>
                                    <li><a href="#trans_user_type_' . $users[0]["usrid"] . '" data-toggle="tab">Transactions</a></li>
                                    <li><a href="#sal_user_type_' . $users[0]["usrid"] . '" data-toggle="tab">Sales</a></li>
                                    <li><a href="#pur_user_type_' . $users[0]["usrid"] . '" data-toggle="tab">Purchase</a></li>
                                    <li><a  href="#edt_user_type_' . $users[0]["usrid"] . '" id="edt_user_but_' . $users[0]["usrid"] . '" data-toggle="tab">Edit</a></li>
                            </ul>
                            <div class="tab-content">
                                    <div class="tab-pane fade in active" id="info_user_type_' . $users[0]["usrid"] . '">
                                            <h4>&nbsp;</h4>
                                            <p>' . str_replace($this->order, $this->replace, $basicinfo) . '</p>
                                    </div>
                                    <div class="tab-pane fade" id="trans_user_type_' . $users[0]["usrid"] . '">
                                            <h4>&nbsp;</h4>
                                            <p>' . str_replace($this->order, $this->replace, $trasac) . '</p>
                                    </div>
                                    <div class="tab-pane fade" id="sal_user_type_' . $users[0]["usrid"] . '">
                                            <h4>&nbsp;</h4>
                                            <p>' . str_replace($this->order, $this->replace, $sals) . '</p>
                                    </div>
                                    <div class="tab-pane fade" id="pur_user_type_' . $users[0]["usrid"] . '">
                                            <h4>&nbsp;</h4>
                                            <p>' . str_replace($this->order, $this->replace, $consignment) . '</p>
                                    </div>
                                    <div class="tab-pane fade" id="edt_user_type_' . $users[0]["usrid"] . '">
                                            <h4>&nbsp;</h4>
                                            <div class="row">
                                                    <div class="col-lg-12">
                                                            ' . str_replace($this->order, $this->replace, $editHtml) . '
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </div>';
            $listusers = array(
                //"html" => (string) str_replace($this->order, $this->replace, $html),
                "html" => (string) $html,
            );
        }
        return $listusers;
    }

    /* Basic Info */

    public function editBasicInfo() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["uid"];
        /* Profile BasicInfo */
        $query = 'UPDATE  `user_profile`
				SET `user_name` = \'' . mysql_real_escape_string($this->parameters["name"]) . '\',
					`ot_amt` = \'' . mysql_real_escape_string($this->parameters["otamt"]) . '\',
					`postal_code` = \'' . mysql_real_escape_string($this->parameters["pcode"]) . '\',
					`telephone` = \'' . mysql_real_escape_string($this->parameters["tphone"]) . '\',
					`user_type_id` = \'' . mysql_real_escape_string($this->parameters["user_type"]) . '\'
				WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\';';
        $flag = executeQuery($query);
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    /* EMAIL */

    public function loadClientEmailIdEditForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $emailHTM = 'Not Provided';
        $num_posts = 0;
        $email_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Email */
                    if (is_array($users[$i]["email"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                            $flag = true;
                            $emailids["oldemail"][$j] = array(
                                "id" => ltrim($users[$i]["email_pk"][$j], ','),
                                "value" => ltrim($users[$i]["email"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["email"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j
                            );
                            $emailHTM .= '<div class="col-lg-12" id="' . $emailids["oldemail"][$j]["form"] . '">
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Email ID" name="' . $emailids["oldemail"][$j]["id"] . '" type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($users[$i]["email"][$j], ',') . '" />
                                                    <p class="help-block" id="' . $emailids["oldemail"][$j]["msgid"] . '">Valid.</p>
                                            </div>
                                    </div>';
                            $email_no++;
                        }
                    }
                }
            }
            $html = '<div class="col-lg-12 text-right">&nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '">
				<i class="fa fa-close fa-fw "></i></button>
			    </div>
			    <div class="col-lg-12">&nbsp;</div><div class="col-lg-12">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = (string) str_replace($this->order, $this->replace, $html);
            $emailids["num"] = $email_no;
        }
        return $emailids;
    }

    public function loadClientEmailIdDeltForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $emailHTM = 'Not Provided';
        $num_posts = 0;
        $email_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Email */
                    if (is_array($users[$i]["email"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                            $flag = true;
                            $emailids["oldemail"][$j] = array(
                                "id" => ltrim($users[$i]["email_pk"][$j], ','),
                                "value" => ltrim($users[$i]["email"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["email"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j,
                                "deleteid" => $this->parameters["email"] . $j . '_delete',
                                "deleteOk" => 'deleteEmlOk_' . ltrim($users[$i]["email_pk"][$j], ',') . '_' . $j,
                                "deleteCancel" => 'deleteEmlCancel_' . ltrim($users[$i]["email_pk"][$j], ',') . '_' . $j
                            );
                            $emailHTM .= '<div id="' . $emailids["oldemail"][$j]["form"] . '">
                                        <div class="form-group input-group">
                                        <input class="form-control" placeholder="Email ID" name="' . $emailids["oldemail"][$j]["id"] . '" type="text" id="' . $emailids["oldemail"][$j]["textid"] . '" maxlength="100" value="' . ltrim($users[$i]["email"][$j], ',') . '" readonly="readonly"/>
                                        <span class="input-group-addon">
                                                <button type="button" class="btn btn-danger btn-circle" id="' . $emailids["oldemail"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myEmailModal_' . $j . '">
                                                        <i class="fa fa-trash-o fa-fw"></i>
                                                </button>
                                                <div class="modal fade" id="myEmailModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myEmailModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                <div class="modal-content" style="color:#000;">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myEmailModalLabel_' . $j . '">Delete Email Id</h4>
                                                </div>
                                                <div class="modal-body">
                                                Do You really want to delete <strong>' . ltrim($users[$i]["email"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $emailids["oldemail"][$j]["deleteOk"] . '">Ok</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="' . $emailids["oldemail"][$j]["deleteCancel"] . '">Cancel</button>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                        </span>
                                        </div>
                                </div>';
                            $email_no++;
                        }
                    }
                }
            }
            $html = '<div class="col-lg-12 text-right">
				&nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
			</div><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = (string) str_replace($this->order, $this->replace, $html);
            $emailids["num"] = $email_no;
        }
        return $emailids;
    }

    public function adddClientEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        /* Emails Insert */
        $query = 'INSERT INTO  `email_ids` (`id`,`user_pk`,`email`,`status_id` ) VALUES';
        for ($i = 0; $i < sizeof($this->parameters["emailids"]["insert"]); $i++) {
            if ($i == sizeof($this->parameters["emailids"]["insert"]) - 1)
                $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',default);';
            else
                $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',default),';
        }
        if (executeQuery($query)) {
            $flag = true;
            executeQuery('UPDATE `user_profile` SET `email`= \'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][0]) . '\'WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function editClientEmailId() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        for ($i = 0; $i < sizeof($this->parameters["emailids"]["update"]); $i++) {
            $query = 'UPDATE  `email_ids` SET `email` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["email"]) . '\'WHERE `id` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["id"]) . '\';';
            if (executeQuery($query))
                $flag = true;
            else {
                $flag = false;
                break;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deleteClientEmailId() {
        $flag = false;
        $del = getStatusId("delete");
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `email_ids` SET `status_id` = \'' . mysql_real_escape_string($del) . '\'WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listClientEmailIds() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailHTM = '<ul>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Email */
                    if (is_array($users[$i]["email"]) && $users[$i]["email"][0] != '') {
                        for ($j = 0; $j <= sizeof($users[$i]["email"]) && isset($users[$i]["email"][$j]) && $users[$i]["email"][$j] != ''; $j++) {
                            $emailHTM.= '<li>' . ltrim($users[$i]["email"][$j], ',') . '</li>';
                        }
                        $emailHTM.= '</ul>';
                    }
                }
            }
        }
        return $emailHTM;
    }

    /* Cell Numbers */

    public function loadClientCellNumEditForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $cnumHTM = 'Not Provided';
        $num_posts = 0;
        $cnum_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnums = array(
            "oldcnum" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    $cnumHTM = '';
                    /* Cell numbers */
                    if (is_array($users[$i]["cnumber"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                            $flag = true;
                            $cnums["oldcnum"][$j] = array(
                                "id" => ltrim($users[$i]["cnumber_pk"][$j], ','),
                                "value" => ltrim($users[$i]["cnumber"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["cnumber"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j
                            );
                            $cnumHTM .= '<div class="col-lg-12" id="' . $cnums["oldcnum"][$j]["form"] . '">
								<div class="form-group">
								<input class="form-control" placeholder="Cell number" name="' . $cnums["oldcnum"][$j]["id"] . '" type="text" min="0" id="' . $cnums["oldcnum"][$j]["textid"] . '" maxlength="10" value="' . ltrim($users[$i]["cnumber"][$j], ',') . '" />
								</div>
								<div class="col-lg-12" id="' . $cnums["oldcnum"][$j]["form"] . '">
									<p class="help-block" id="' . $cnums["oldcnum"][$j]["msgid"] . '">Valid.</p>
								</div>
							</div>';
                            $cnum_no++;
                        }
                    }
                }
            }
            $html = '<div class="col-lg-12 text-right">
				&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
			</div><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
            $cnums["html"] = (string) str_replace($this->order, $this->replace, $html);
            $cnums["num"] = $cnum_no;
        }
        return $cnums;
    }

    public function loadClientCellNumDeltForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $cnumHTM = 'Not Provided';
        $num_posts = 0;
        $cnum_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnums = array(
            "oldcnum" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    $cnumHTM = '';
                    /* Cell numbers */
                    if (is_array($users[$i]["cnumber"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                            $flag = true;
                            $cnums["oldcnum"][$j] = array(
                                "id" => ltrim($users[$i]["cnumber_pk"][$j], ','),
                                "value" => ltrim($users[$i]["cnumber"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["cnumber"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j,
                                "deleteid" => $this->parameters["cnumber"] . $j .
                                '_delete',
                                "deleteOk" => 'deleteCnumOk_' . ltrim($users[$i]["cnumber_pk"][$j], ',') .
                                '_' . $j,
                                "deleteCancel" => 'deleteCnumCancel_' . ltrim($users[$i]["cnumber_pk"][$j], ',') .
                                '_' . $j
                            );
                            $cnumHTM .= '<div id="' . $cnums["oldcnum"][$j]["form"] . '">
								<div class="form-group input-group">
								<input class="form-control" placeholder="Cell number" name="' . $cnums["oldcnum"][$j]["id"] . '" type="text" min="0" id="' . $cnums["oldcnum"][$j]["textid"] . '" maxlength="10" value="' . ltrim($users[$i]["cnumber"][$j], ',') . '" readonly="readonly" />
								<span class="input-group-addon">
									<button type="button" class="btn btn-danger btn-circle" id="' . $cnums["oldcnum"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myCnumModal_' . $j . '">
										<i class="fa fa-trash-o fa-fw"></i>
									</button>
									<div class="modal fade" id="myCnumModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myCnumModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
									<div class="modal-content" style="color:#000;">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myCnumModalLabel_' . $j . '">Delete Cell Number</h4>
									</div>
									<div class="modal-body">
									Do You really want to delete <strong>' . ltrim($users[$i]["cnumber"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
									</div>
									<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $cnums["oldcnum"][$j]["deleteOk"] . '">Ok</button>
									<button type="button" class="btn btn-danger" data-dismiss="modal" id="' . $cnums["oldcnum"][$j]["deleteCancel"] . '">Cancel</button>
									</div>
									</div>
									</div>
									</div>
								</span>
								</div>
							</div>';
                            $cnum_no++;
                        }
                    }
                }
            }
            $html = '<div class="col-lg-12 text-right">
				&nbsp;<button  type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
			</div><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">' . str_replace($this->order, $this->replace, $cnumHTM) . '</div>';
            $cnums["html"] = (string) str_replace($this->order, $this->replace, $html);
            $cnums["num"] = $cnum_no;
        }
        return $cnums;
    }

    public function adddClientCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["CellNums"]["uid"];
        /* Cell Numbers Insert */
        $query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status_id`) VALUES';
        for ($i = 0; $i < sizeof($this->parameters["CellNums"]["insert"]); $i++) {
            if ($i == sizeof($this->parameters["CellNums"]["insert"]) - 1)
                $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',default);';
            else
                $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',default),';
        }
        if (executeQuery($query)) {
            $flag = true;
            executeQuery('UPDATE `user_profile` SET `cell_number`= \'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][0]) . '\'WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function editClientCellNum() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["CellNums"]["uid"];
        /* Cell Numbers Insert */
        if (isset($this->parameters["CellNums"]["insert"]) && is_array($this->parameters["CellNums"]["insert"]) && sizeof($this->parameters["CellNums"]["insert"]) > -1 && $user_pk > 0) {
            $query = 'INSERT INTO  `cell_numbers` (`id`,`user_pk`,`cell_number`,`status`) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["CellNums"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["CellNums"]["insert"]) - 1)
                    $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
                else
                    $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][$i]) . '\',\'' . mysql_real_escape_string($this->statu["undel"]) . '\');';
            }
            executeQuery($query);
            executeQuery('UPDATE `user_profile` SET `cell_number`= \'' . mysql_real_escape_string($this->parameters["CellNums"]["insert"][0]) . '\'WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\'');
            $flag = true;
        }
        /* Cell Numbers Update */
        if (isset($this->parameters["CellNums"]["update"]) && is_array($this->parameters["CellNums"]["update"]) && sizeof($this->parameters["CellNums"]["update"]) > -1 && $user_pk > 0) {
            for ($i = 0; $i < sizeof($this->parameters["CellNums"]["update"]); $i++) {
                $query = 'UPDATE  `cell_numbers`
				SET `cell_number` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["cnumber"]) .
                        '\'
				WHERE `id` = \'' . mysql_real_escape_string($this->parameters["CellNums"]["update"][$i]["id"]) .
                        '\';';
                executeQuery($query);
            }
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deleteClientCellNum() {
        $flag = false;
        $del = getStatusId("delete");
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `cell_numbers` SET `status_id` = \'' . mysql_real_escape_string($del) . '\' WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listClientCellNums() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $cnumHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    $cnumHTM = '<ul>';
                    /* Cell numbers */
                    if (is_array($users[$i]["cnumber"]) && $users[$i]["cnumber"][0] != '') {
                        for ($j = 0; $j <= sizeof($users[$i]["cnumber"]) && isset($users[$i]["cnumber"][$j]) && $users[$i]["cnumber"][$j] != ''; $j++) {
                            $cnumHTM.= '<li>' . ltrim($users[$i]["cnumber"][$j], ',') . '</li>';
                        }
                        $cnumHTM.= '</ul>';
                    }
                }
            }
        }
        return $cnumHTM;
    }

    /* PRODCUT */

    public function loadClientProductEditForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $emailHTM = 'Not Provided';
        $num_posts = 0;
        $email_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            //var_dump($this->parameters);
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Product */
                    if (is_array($users[$i]["prdname"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["prdname"]) && isset($users[$i]["prdname"][$j]) && $users[$i]["prdname"][$j] != ''; $j++) {
                            $flag = true;
                            $emailids["oldemail"][$j] = array(
                                "id" => ltrim($users[$i]["prd_pk"][$j], ','),
                                "value" => ltrim($users[$i]["prdname"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["email"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j
                            );
                            $emailHTM .= '<div class="col-lg-12" id="' . $emailids["oldemail"][$j]["form"] . '">
                                    <div class="form-group">
                                    <input class="form-control" 
                                    placeholder="Email ID" 
                                    name="' . $emailids["oldemail"][$j]["id"] . '" 
                                    type="text" 
                                    id="' . $emailids["oldemail"][$j]["textid"] . '" 
                                    maxlength="100" 
                                    value="' . ltrim($users[$i]["prdname"][$j], ',') . '" />
                                    <p class="help-block" id="' . $emailids["oldemail"][$j]["msgid"] . '">Valid.</p>
                                    </div>
                                    </div>';
                            $email_no++;
                        }
                    }
                }
            }
            $html = '<div class="col-lg-12 text-right">&nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '">
                    <i class="fa fa-close fa-fw "></i></button>
                    </div>
                    <div class="col-lg-12">&nbsp;</div><div class="col-lg-12">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = (string) str_replace($this->order, $this->replace, $html);
            $emailids["num"] = $email_no;
        }
        return $emailids;
    }

    public function loadClientProductDeltForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $emailHTM = 'Not Provided';
        $num_posts = 0;
        $email_no = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailids = array(
            "oldemail" => NULL,
            "html" => 'Not Provided',
            "num" => 0
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Product */
                    if (is_array($users[$i]["prdname"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["prdname"]) && isset($users[$i]["prdname"][$j]) && $users[$i]["prdname"][$j] != ''; $j++) {
                            $flag = true;
                            $emailids["oldemail"][$j] = array(
                                "id" => ltrim($users[$i]["prd_pk"][$j], ','),
                                "value" => ltrim($users[$i]["prdname"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["email"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j,
                                "deleteid" => $this->parameters["email"] . $j . '_delete',
                                "deleteOk" => 'deleteEmlOk_' . ltrim($users[$i]["prd_pk"][$j], ',') . '_' . $j,
                                "deleteCancel" => 'deleteEmlCancel_' . ltrim($users[$i]["prd_pk"][$j], ',') . '_' . $j
                            );
                            $emailHTM .= '<div id="' . $emailids["oldemail"][$j]["form"] . '">
                                        <div class="form-group input-group">
                                        <input class="form-control" 
                                        placeholder="Email ID" 
                                        name="' . $emailids["oldemail"][$j]["id"] . '" 
                                        type="text" 
                                        id="' . $emailids["oldemail"][$j]["textid"] . '" 
                                        maxlength="100" 
                                        value="' . ltrim($users[$i]["prdname"][$j], ',') . '" 
                                        readonly="readonly"/>
                                        <span class="input-group-addon">
                                        <button type="button" class="btn btn-danger btn-circle" id="' . $emailids["oldemail"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myEmailModal_' . $j . '">
                                        <i class="fa fa-trash-o fa-fw"></i>
                                        </button>
                                        <div class="modal fade" id="myEmailModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myEmailModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                        <div class="modal-content" style="color:#000;">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title" id="myEmailModalLabel_' . $j . '">Delete Email Id</h4>
                                        </div>
                                        <div class="modal-body">
                                        Do You really want to delete <strong>' . ltrim($users[$i]["prdname"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $emailids["oldemail"][$j]["deleteOk"] . '">Ok</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="' . $emailids["oldemail"][$j]["deleteCancel"] . '">Cancel</button>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </span>
                                        </div>
                                </div>';
                            $email_no++;
                        }
                    }
                }
            }
            $html = '<div class="col-lg-12 text-right">
				&nbsp;<button type="button" class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
			</div><div class="col-lg-12">&nbsp;</div><div class="col-lg-12">' . str_replace($this->order, $this->replace, $emailHTM) . '</div>';
            $emailids["html"] = (string) str_replace($this->order, $this->replace, $html);
            $emailids["num"] = $email_no;
        }
        return $emailids;
    }

    public function adddClientProduct() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        /* Products Insert */
        $query = 'INSERT INTO  `product` (`id`,`user_pk`,`name`,`status_id` ) VALUES';
        for ($i = 0; $i < sizeof($this->parameters["emailids"]["insert"]); $i++) {
            if ($i == sizeof($this->parameters["emailids"]["insert"]) - 1)
                $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',default);';
            else
                $query.= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',\'' . mysql_real_escape_string($this->parameters["emailids"]["insert"][$i]) . '\',default),';
        }
        if (executeQuery($query)) {
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function editClientProduct() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["emailids"]["uid"];
        for ($i = 0; $i < sizeof($this->parameters["emailids"]["update"]); $i++) {
            $query = 'UPDATE  `product` SET `name` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["email"]) . '\'WHERE `id` = \'' . mysql_real_escape_string($this->parameters["emailids"]["update"][$i]["id"]) . '\';';
            if (executeQuery($query))
                $flag = true;
            else {
                $flag = false;
                break;
            }
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deleteClientProduct() {
        $flag = false;
        $del = getStatusId("delete");
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Products Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `product` SET `status_id` = \'' . mysql_real_escape_string($del) . '\'WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listClientProducts() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $emailHTM = '<ul>';
//        if (is_array($users[0]["prd_pk"] )) {
//            $flag = false;
//            for ($j = 0; $j < sizeof($users[0]["prd_pk"]) 
//                    && isset($users[0]["prd_pk"]) 
//                    && $users[0]["prd_pk"][$j] != ''; $j++) {
//                $flag = true;
//                $prd .= '<li>' . ltrim($users[0]["prdname"][$j], ',') . 
//                        '&nbsp; <img src="' . 
//                        ltrim($users[0]["prdphoto"][$j], ',') . 
//                        '" width="50" /> </li>';
//                $prd_no++;
//            }
//            if (!$flag) {
//                $prd = '<li>Not Provided</li>';
//            }
//        }
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Product */
                    if (is_array($users[$i]["prdname"]) && $users[$i]["prdname"][0] != '') {
                        for ($j = 0; $j <= sizeof($users[$i]["prdname"]) && isset($users[$i]["prdname"][$j]) && $users[$i]["prdname"][$j] != ''; $j++) {
                            $emailHTM.= '<li>' . ltrim($users[$i]["prdname"][$j], ',') .
                                    '&nbsp; <img src="' .
                                    ltrim($users[$i]["prdphoto"][$j], ',') .
                                    '" width="50" /></li>';
                        }
                        $emailHTM.= '</ul>';
                    }
                }
            }
        }
        return $emailHTM;
    }

    /* Products */

    public function loadPrdNameForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $pnameHTM = '';
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $prdnames = array(
            "oldprdname" => NULL,
            "html" => NULL
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    $pnameHTM = '';
                    /* Products */
                    if (is_array($users[$i]["prdname"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["prdname"]) && isset($users[$i]["prdname"][$j]) && $users[$i]["prdname"][$j] != ''; $j++) {
                            $flag = true;
                            $prdnames["oldprdname"][$j] = array(
                                "id" => ltrim($users[$i]["prd_pk"][$j], ','),
                                "value" => ltrim($users[$i]["prdname"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "textid" => $this->parameters["email"] . $j,
                                "msgid" => $this->parameters["msgDiv"] . $j,
                                "deleteid" => $this->parameters["email"] . $j . '_delete',
                                "deleteOk" => 'deletePnameOk_' . ltrim($users[$i]["prd_pk"][$j], ',') . '_' . $j,
                                "deleteCancel" => 'deletePnameCancel_' . ltrim($users[$i]["prd_pk"][$j], ',') . '_' . $j
                            );
                            $pnameHTM .= '<div id="' . $prdnames["oldprdname"][$j]["form"] . '">
											<div class="form-group input-group">
											<input class="form-control" placeholder="Product name" name="' . $prdnames["oldprdname"][$j]["id"] . '" type="text" id="' . $prdnames["oldprdname"][$j]["textid"] . '" maxlength="10" value="' . ltrim($users[$i]["prdname"][$j], ',') . '" />
											<span class="input-group-addon">
												<button type="button"  class="btn btn-danger btn-circle" id="' . $prdnames["oldprdname"][$j]["deleteid"] . '" data-toggle="modal" data-target="#myPnameModal_' . $j . '">
													<i class="fa fa-trash fa-fw"></i>
												</button>
												<div class="modal fade" id="myPnameModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="myPnameModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
												<div class="modal-dialog">
												<div class="modal-content" style="color:#000;">
												<div class="modal-header">
												<button type="button"  type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="myPnameModalLabel_' . $j . '">Delete product entry</h4>
												</div>
												<div class="modal-body">
												Do You really want to delete <strong>' . ltrim($users[$i]["prdname"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
												</div>
												<div class="modal-footer">
												<button type="button"  type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $prdnames["oldprdname"][$j]["deleteOk"] . '">Ok</button>
												<button type="button"  type="button" class="btn btn-success" data-dismiss="modal" id="' . $prdnames["oldprdname"][$j]["deleteCancel"] . '">Cancel</button>
												</div>
												</div>
												</div>
												</div>
											</span>
											</div>
											<div class="col-lg-16" id="' . $prdnames["oldprdname"][$j]["form"] . '">
												<p class="help-block" id="' . $prdnames["oldprdname"][$j]["msgid"] . '">Valid.</p>
											</div>
										</div>';
                        }
                    }
                }
            }
            $html = '<div class="col-lg-16">
						Add extra Products : <button type="button"  class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus fa-fw "></i></button>
						&nbsp;<button type="button"  class="btn btn-danger btn-circle" id="' . $this->parameters["minus"] . '"><i class="fa fa-close fa-minus "></i></button>
						&nbsp;<button type="button"  class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
					</div><div class="class="col-lg-16">' . str_replace($this->order, $this->replace, $pnameHTM) . '</div>';
            $prdnames["html"] = str_replace($this->order, $this->replace, $html);
        }
        return $prdnames;
    }

    public function editPrdName() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["PrdNames"]["uid"];
        /* Product Insert */
        if (isset($this->parameters["PrdNames"]["insert"]) && is_array($this->parameters["PrdNames"]["insert"]) && sizeof($this->parameters["PrdNames"]["insert"]) > -1 && $user_pk > 0) {
            $directory_prod = array();
            $product_pk = array();
            $query = 'INSERT INTO  `product` (`id`,`name`,`photo_id`,`directory`,`doc`,`status_id`) VALUES';
            for ($i = 0; $i < sizeof($this->parameters["PrdNames"]["insert"]); $i++) {
                $query = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
						NULL,NULL,NULL,NULL,NULL,NULL);';
                executeQuery($query);
                $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                $query = 'INSERT INTO  `product` (`id`,`name`,`photo_id`,`doc`,`status_id`) VALUES (NULL,
							\'' . mysql_real_escape_string($this->parameters["PrdNames"]["insert"][$i]) . '\',
							\'' . mysql_real_escape_string($photo_pk) . '\',
							default,
							4);';
                executeQuery($query);
                $product_pk[$i] = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                $directory_prod[$i] = substr(md5(microtime()), 0, 6) . '_product_' . $product_pk[$i];
                /* Assign product to user */
                $query = 'INSERT INTO  `user_product` (`id`,`product_id`,`user_pk`,`status_id`) VALUES (NULL,
						\'' . mysql_real_escape_string($product_pk[$i]) . '\',
						\'' . mysql_real_escape_string($user_pk) . '\',
						4);';
                executeQuery($query);
            }
            for ($i = 0; $i < sizeof($this->parameters["PrdNames"]["insert"]); $i++) {
                createdirectories($directory_prod[$i]);
                executeQuery('UPDATE `product` SET `directory` = \'' . ASSET_DIR . $directory_prod[$i] . '\' WHERE `id`=\'' . mysql_real_escape_string($product_pk[$i]) . '\';');
            }
            $flag = true;
        }
        /* Product Update */
        if (isset($this->parameters["PrdNames"]["update"]) && is_array($this->parameters["PrdNames"]["update"]) && sizeof($this->parameters["PrdNames"]["update"]) > -1 && $user_pk > 0) {
            for ($i = 0; $i < sizeof($this->parameters["PrdNames"]["update"]); $i++) {
                $query = 'UPDATE  `product`
						 SET `name` = \'' . mysql_real_escape_string($this->parameters["PrdNames"]["update"][$i]["prdname"]) . '\'
						 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["PrdNames"]["update"][$i]["id"]) . '\';';
                executeQuery($query);
            }
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deletePrdName() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Products Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `product`
					 SET `status_id` = 6
					 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listPrdNames() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $pnameHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Products */
                    if (is_array($users[$i]["prdname"]) && $users[$i]["prdname"][0] != '') {
                        $pnameHTM = '';
                        for ($j = 0; $j <= sizeof($users[$i]["prdname"]) && isset($users[$i]["prdname"][$j]) && $users[$i]["prdname"][$j] != ''; $j++) {
                            $pnameHTM .= '<li>' . ltrim($users[$i]["prdname"][$j], ',') . '&nbsp; <img src="' . ltrim($users[$i]["prdphoto"][$j], ',') . '" width="50" /> </li>';
                        }
                    }
                }
            }
        }
        return $pnameHTM;
    }

    /* Bank account */

    public function loadBankAcForm() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $html = '';
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $banks = array(
            "oldbank" => NULL,
            "html" => NULL
        );
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    $backacHTM = '';
                    /* Bank Account */
                    if (is_array($users[$i]["bank_name"])) {
                        for ($j = 0; $j <= sizeof($users[$i]["bank_name"]) && isset($users[$i]["bank_name"][$j]) && $users[$i]["bank_name"][$j] != ''; $j++) {
                            $banks["oldbank"][$j] = array(
                                "id" => ltrim($users[$i]["bank_pk"][$j], ','),
                                "form" => $this->parameters["form"] . $j,
                                "bankname" => $this->parameters["bankname"] . $j,
                                "nmsg" => $this->parameters["nmsg"] . $j,
                                "accno" => $this->parameters["accno"] . $j,
                                "nomsg" => $this->parameters["nomsg"] . $j,
                                "braname" => $this->parameters["braname"] . $j,
                                "bnmsg" => $this->parameters["bnmsg"] . $j,
                                "bracode" => $this->parameters["bracode"] . $j,
                                "bcmsg" => $this->parameters["bcmsg"] . $j,
                                "IFSC" => $this->parameters["IFSC"] . $j,
                                "IFSCmsg" => $this->parameters["IFSCmsg"] . $j,
                                "deleteid" => $this->parameters["bankname"] . $j . '_delete',
                                "deleteOk" => 'deleteBnkAcOk_' . ltrim($users[$i]["bank_pk"][$j], ',') . '_' . $j,
                                "deleteCancel" => 'deleteBnkAcCancel_' . ltrim($users[$i]["bank_pk"][$j], ',') . '_' . $j
                            );
                            $backacHTM .= '<div id="' . $banks["oldbank"][$j]["form"] . '">
								<div class="col-lg-12">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<strong>Bank account</strong>
											&nbsp;<button type="button"  class="btn btn-danger btn-circle" id="' . $banks["oldbank"][$j]["deleteid"] . '" data-toggle="modal" data-target="#mybanknameModal_' . $j . '"><i class="fa fa-trash fa-fw"></i></button>
											<div class="modal fade" id="mybanknameModal_' . $j . '" tabindex="-1" role="dialog" aria-labelledby="mybanknameModalLabel_' . $j . '" aria-hidden="true" style="display: none;">
											<div class="modal-dialog">
											<div class="modal-content" style="color:#000;" >
											<div class="modal-header">
											<button type="button"  type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title" id="mybanknameModalLabel_' . $j . '">Delete Bank Account</h4>
											</div>
											<div class="modal-body">
											Do You really want to delete <strong>' . ltrim($users[$i]["bank_name"][$j], ',') . '</strong> ?? press <strong>OK</strong> to delete
											</div>
											<div class="modal-footer">
											<button type="button"  type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="' . $banks["oldbank"][$j]["deleteOk"] . '">Ok</button>
											<button type="button"  type="button" class="btn btn-success" data-dismiss="modal" id="' . $banks["oldbank"][$j]["deleteCancel"] . '">Cancel</button>
											</div>
											</div>
											</div>
											</div>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-lg-12">
													<input class="form-control" placeholder="Bank Name" name="' . $banks["oldbank"][$j]["id"] . '" type="text" id="' . $banks["oldbank"][$j]["bankname"] . '" maxlength="100" value="' . ltrim($users[$i]["bank_name"][$j], ',') . '"/>
													<p class="help-block" id="' . $banks["oldbank"][$j]["nmsg"] . '">Valid.</p>
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<input class="form-control" placeholder="Account Number" name="' . $banks["oldbank"][$j]["id"] . '" type="text" id="' . $banks["oldbank"][$j]["accno"] . '" maxlength="100" value="' . ltrim($users[$i]["ac_no"][$j], ',') . '"/>
													<p class="help-block" id="' . $banks["oldbank"][$j]["nomsg"] . '">Valid.</p>
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<input class="form-control" placeholder="Branch Name" name="' . $banks["oldbank"][$j]["id"] . '" type="text" id="' . $banks["oldbank"][$j]["braname"] . '" maxlength="100" value="' . ltrim($users[$i]["branch"][$j], ',') . '"/>
													<p class="help-block" id="' . $banks["oldbank"][$j]["bnmsg"] . '">Valid.</p>
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<input class="form-control" placeholder="Branch Code" name="' . $banks["oldbank"][$j]["id"] . '" type="text" id="' . $banks["oldbank"][$j]["bracode"] . '" maxlength="100" value="' . ltrim($users[$i]["branch_code"][$j], ',') . '"/>
													<p class="help-block" id="' . $banks["oldbank"][$j]["bcmsg"] . '">Valid.</p>
												</div>
												<div class="col-lg-12">&nbsp;</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<input class="form-control" placeholder="IFSC" name="' . $banks["oldbank"][$j]["id"] . '" type="text" id="' . $banks["oldbank"][$j]["IFSC"] . '" maxlength="100" value="' . ltrim($users[$i]["IFSC"][$j], ',') . '"/>
													<p class="help-block" id="' . $banks["oldbank"][$j]["IFSCmsg"] . '">Valid.</p>
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
						Add extra Bank : <button type="button"  class="btn btn-success btn-circle" id="' . $this->parameters["plus"] . '"><i class="fa fa-plus fa-fw "></i></button>
						&nbsp;<button type="button"  class="btn btn-info btn-circle" id="' . $this->parameters["saveBut"] . '"><i class="fa fa-save fa-fw "></i></button>
						&nbsp;<button type="button"  class="btn btn-danger btn-circle" id="' . $this->parameters["closeBut"] . '"><i class="fa fa-close fa-fw "></i></button>
					</div><div class="class="col-lg-12">' . str_replace($this->order, $this->replace, $backacHTM) . '</div>';
            $banks["html"] = str_replace($this->order, $this->replace, $html);
        }
        return $banks;
    }

    public function editBankAc() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["BankAcs"]["uid"];
        /* Bank Account Insert */
        if (isset($this->parameters["BankAcs"]["insert"]) && is_array($this->parameters["BankAcs"]["insert"]) && sizeof($this->parameters["BankAcs"]["insert"]) > -1 && $user_pk > 0) {
            $directory_prod = array();
            $product_pk = array();
            $query = 'INSERT INTO  `bank_accounts` (`id`,`user_pk`,`bank_name`,`ac_no`,`branch`,`branch_code`,`IFSC`,`status_id`)  VALUES';
            for ($i = 0; $i < sizeof($this->parameters["BankAcs"]["insert"]); $i++) {
                if ($i == sizeof($this->parameters["BankAcs"]["insert"]) - 1)
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bankname"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["accno"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["braname"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bracode"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["IFSC"]) . '\',
							4);';
                else
                    $query .= '(NULL,\'' . mysql_real_escape_string($user_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bankname"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["accno"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["braname"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["bracode"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["BankAcs"]["insert"][$i]["IFSC"]) . '\',
							4),';
            }
            executeQuery($query);
            $flag = true;
        }
        /*  Bank Account Update */
        if (isset($this->parameters["BankAcs"]["update"]) && is_array($this->parameters["BankAcs"]["update"]) && sizeof($this->parameters["BankAcs"]["update"]) > -1 && $user_pk > 0) {
            for ($i = 0; $i < sizeof($this->parameters["BankAcs"]["update"]); $i++) {
                $query = 'UPDATE  `bank_accounts`
						 SET `bank_name` = \'' . mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["bankname"]) . '\',
						 `ac_no` = \'' . mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["accno"]) . '\',
						 `branch` = \'' . mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["braname"]) . '\',
						 `branch_code` = \'' . mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["bracode"]) . '\',
						 `IFSC` = \'' . mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["IFSC"]) . '\'
						 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["BankAcs"]["update"][$i]["id"]) . '\';';
                executeQuery($query);
            }
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function deleteBankAc() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Emails Update */
        if (isset($this->parameters["eid"]) && $this->parameters["eid"] > -1) {
            $query = 'UPDATE  `bank_accounts`
					 SET `status_id` = 6
					 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["eid"]) . '\';';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listBankAcs() {
        /* Bank account */
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $backacHTM = '<li>Not Provided</li>';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    /* Bank account */
                    $backacHTM = '';
                    if (is_array($users[$i]["bank_name"]) && $users[$i]["bank_name"][0] != '') {
                        for ($j = 0; $j <= sizeof($users[$i]["bank_name"]) && isset($users[$i]["bank_name"][$j]) && $users[$i]["bank_name"][$j] != ''; $j++) {
                            $backacHTM .= '<li>
										' . ltrim($users[$i]["bank_name"][$j], ',') . ',&nbsp;
										' . ltrim($users[$i]["ac_no"][$j], ',') . ',&nbsp;
										' . ltrim($users[$i]["branch"][$j], ',') . ',&nbsp;
										' . ltrim($users[$i]["branch_code"][$j], ',') . ',&nbsp;
										' . ltrim($users[$i]["IFSC"][$j], ',') . '
										</li>';
                        }
                    }
                }
            }
        }
        return $backacHTM;
    }

    /* Address */

    public function editAddress() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $user_pk = $this->parameters["uid"];
        /* Profile Address */
        $query = 'UPDATE  `user_profile`
				SET `addressline` = \'' . mysql_real_escape_string($this->parameters["addrsline"]) . '\',
					`town` = \'' . mysql_real_escape_string($this->parameters["st_loc"]) . '\',
					`city` = \'' . mysql_real_escape_string($this->parameters["city_town"]) . '\',
					`district` = \'' . mysql_real_escape_string($this->parameters["district"]) . '\',
					`province` = \'' . mysql_real_escape_string($this->parameters["province"]) . '\',
					`province_code` = \'' . mysql_real_escape_string($this->parameters["provinceCode"]) . '\',
					`country` = \'' . mysql_real_escape_string($this->parameters["country"]) . '\',
					`country_code` = \'' . mysql_real_escape_string($this->parameters["countryCode"]) . '\',
					`zipcode` = \'' . mysql_real_escape_string($this->parameters["zipcode"]) . '\',
					`website` = \'' . mysql_real_escape_string($this->parameters["website"]) . '\',
					`latitude` = \'' . mysql_real_escape_string($this->parameters["lat"]) . '\',
					`longitude` = \'' . mysql_real_escape_string($this->parameters["lon"]) . '\',
					`timezone` = \'' . mysql_real_escape_string($this->parameters["timezone"]) . '\',
					`gmaphtml` = \'' . mysql_real_escape_string($this->parameters["gmaphtml"]) . '\'
				WHERE `id` = \'' . mysql_real_escape_string($user_pk) . '\';';
        $flag = executeQuery($query);
        if ($flag) {
            executeQuery("COMMIT");
        }
        return $flag;
    }

    public function listAddress() {
        $user_id = $this->parameters["uid"] != "" ? ' AND a.`id` LIKE CONCAT(' . $this->parameters["uid"] . ')' : '';
        $searchQuery["var"] = $user_id;
        $users = $this->listUser($searchQuery);
        $num_posts = 0;
        if (isset($_SESSION[$this->parameters["sindex"]]) && $_SESSION[$this->parameters["sindex"]] != NULL)
            $users = $_SESSION[$this->parameters["sindex"]];
        else
            $users = NULL;
        if ($users != NULL)
            $num_posts = sizeof($users);
        $addrHTM = '';
        if ($num_posts > 0) {
            for ($i = 0; $i < $num_posts && isset($users[$i]['usrid']); $i++) {
                if ($i == $this->parameters["index"] && $users[$i]['usrid'] == $this->parameters["uid"]) {
                    $addrHTM .= '<ul>
									<li><strong>Address line : </strong>' . $users[$i]["addressline"] . '</li>
									<li><strong>Street / Locality : </strong>' . $users[$i]["town"] . '</li>
									<li><strong>City / Town : </strong>' . $users[$i]["city"] . '</li>
									<li><strong>District / Department : </strong>' . $users[$i]["district"] . '</li>
									<li><strong>State / Province : </strong>' . $users[$i]["province"] . '</li>
									<li><strong>Country : </strong>' . $users[$i]["country"] . '</li>
									<li><strong>Zipcode : </strong>' . $users[$i]["zipcode"] . '</li>
									<li><strong>Website : </strong>' . $users[$i]["website"] . '</li>
									<li><strong>Google Map : </strong>' . $users[$i]["website"] . '</li>
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
        $query = 'UPDATE  `user_profile` SET `status_id`=6 WHERE `id` = "' . mysql_real_escape_string($this->parameters["entry"]) . '";';
        if (executeQuery($query)) {
            $flag = true;
            executeQuery("COMMIT;");
        }
        return $flag;
    }

    public function flagUser() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `user_profile` SET `status_id`=7 WHERE `id` = "' . mysql_real_escape_string($this->parameters["uid"]) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

    public function unflagUser() {
        $flag = false;
        $query = NULL;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `user_profile` SET `status_id`=1 WHERE `id` = "' . mysql_real_escape_string($this->parameters["uid"]) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

}

?>