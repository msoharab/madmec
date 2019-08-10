<?php

class alerts {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    function LoadAlerts() {
        /* Expiring */
        $datetime = new DateTime();
        $datetime->add(new DateInterval('P1M'));
        $validity_expire = $datetime->format('Y-m-d');
        $query = 'SELECT 
					c.`cnumber`,
					b.`email_pk`,
					c.`cnumber_pk`,
					b.`email_ids`,
					a.`user_name`,
					a.`password`,
					a.`id` AS usrid,
					a.`user_type_id`,
					v.`expiry_date`,
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
						CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
							 THEN "---"
							 ELSE a.`postal_code`
						END  AS pcode,
						CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
							 THEN "Not provided"
							 ELSE a.`telephone`
						END AS tnumber,
					   CASE WHEN p.`ver2` IS NULL
						THEN "' . USER_ANON_IMAGE . '"
						ELSE CONCAT("' . URL . ASSET_DIR . '",p.`ver2`)
				   END AS photo
					FROM `user_profile` AS a
					LEFT JOIN `photo` AS p ON p.`id` = a.`photo_id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(em.`id`) AS email_pk,
							GROUP_CONCAT(em.`email`) AS email_ids,
							em.`user_pk`
						FROM `email_ids` AS em
						WHERE em.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (em.`user_pk`)
						ORDER BY (em.`user_pk`)
						) AS b ON b.`user_pk` = a.`id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(cn.`id`) AS cnumber_pk,
							cn.`user_pk`,
							/* GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`)) AS cnumber */
							GROUP_CONCAT(cn.`cell_number`) AS cnumber
						FROM `cell_numbers` AS cn
						WHERE cn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (cn.`user_pk`)
						ORDER BY (cn.`user_pk`)
					) AS c ON a.`id` = c.`user_pk`
					LEFT JOIN (
						SELECT vl.`expiry_date`,
								vl.	`user_pk`
							FROM validity AS vl
							WHERE vl.`status` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
					)AS v ON a.`id` = v.`user_pk`
					WHERE a.`user_type_id` !=  10 and v.`expiry_date` BETWEEN  "' . date("Y-m-d") . '" AND "' . $validity_expire . '"
					AND a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive"))';
        $res = executeQuery($query);
        executeQuery("COMMIT;");
        echo mysql_num_rows($res);
    }

}

?>
