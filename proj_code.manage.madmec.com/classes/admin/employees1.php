<?php
class controlWebsit {

    protected $parameters = array();

    public function __construct($para = false) {
        $this->parameters = $para;
    }
    public function blockUser() {
        $query = 'UPDATE `user_profile` 
                SET `status_id`="' . mysql_real_escape_string($this->parameters['stat']) . '"
                WHERE `id`="' . mysql_real_escape_string($this->parameters['id']) . '"';
        return executeQuery($query);
    }
    public function listUser() {
        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        if (isset($this->parameters["columns"])) {
            //$this->parameters["columns"][]["data"]
            //$this->parameters["columns"][]["name"] = ''
            //$this->parameters["columns"][]["orderable"] = 'true / false'
            //$this->parameters["columns"][]["search"]["regex"] = 'true / false'
            //$this->parameters["columns"][]["search"]["value"] = ''
            //$this->parameters["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->parameters["search"])) {
            $searchqr = ' AND (ad.`user_name`  LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR ad.`email`          LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR ad.`cell_number`    LIKE "%' . $this->parameters["search"]["value"] . '%")';
        }
        if (isset($this->parameters["order"])) {
            $column = (int) $this->parameters["order"][0]["column"];
            $dir = $this->parameters["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY ad.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY ad.`user_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY ad.`email` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY ad.`cell_number` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY ad.`id` ASC';
                    break;
            }
        }

        $query = 'SELECT
            ad.`id` AS replyererid,
            ad.`user_name` AS replyername,
            ad.`email` AS replyeremail,
            ad.`cell_number` AS replyercell,
            IF(ad.`icon` IS NOT NULL OR ad.`icon` != NULL,   (SELECT
                    CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                    THEN "<img src=\'' . DEFAULT_USER_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />" 
                    ELSE CONCAT("<img src=\'' . WEBURL . '",ph1.`ver3`,"\' class=\'img-responsive\' width=\'60\' />")
                    END AS pic
                FROM `photo` AS ph1
                WHERE ad.`icon` = ph1.`id`), "<img src=\'' . DEFAULT_USER_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />"
            ) AS replyerpic,
            IF(ad.status_id = 4, "De-activate","Activate") AS action,
            IF(ad.status_id = 4, "btn-danger", "btn-success") AS btn,
            IF(ad.status_id = 4, 6,4) AS actionid
        FROM `user_profile` AS ad
        WHERE ad.`id` != NULL  OR ad.`id` IS NOT NULL ' . $searchqr . ' ' . $orderqr . ' ;';
        $result = executeQuery($query);
        $num_posts = mysql_num_rows($result);
        if ($num_posts) {
            $listusers = array();
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < count($fetchdata); $i++) {
                array_push($data, array(
                    "No" => $i + 1,
                    "User Name" => $fetchdata[$i]["replyername"],
                    "Email" => $fetchdata[$i]["replyeremail"],
                    "Cell Number" => $fetchdata[$i]["replyercell"],
                    "Icon" => $fetchdata[$i]["replyerpic"],
                    "Action" => '<button class="btn ' . $fetchdata[$i]["btn"] . '" id="listuser_' . $fetchdata[$i]["replyererid"] . '" name="' . $fetchdata[$i]["replyererid"] . '">' . $fetchdata[$i]["action"] . '</button>',
                    "uid" => $fetchdata[$i]["replyererid"],
                    "btnid" => '#listuser_' . $fetchdata[$i]["replyererid"],
                    "actionid" => $fetchdata[$i]["actionid"],
                ));
            }
            $listusers["draw"] = $this->parameters["draw"];
            $listusers["recordsTotal"] = $num_posts;
            $listusers["recordsFiltered"] = $num_posts;
            $listusers["data"] = $data;
        }
        return $listusers;
    }
    public function blockChannel() {
        $query = 'UPDATE `channel` 
                SET `status_id`="' . mysql_real_escape_string($this->parameters['stat']) . '"
                WHERE `id`="' . mysql_real_escape_string($this->parameters['id']) . '"';
        return executeQuery($query);
    }
    public function listChannel() {
        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        if (isset($this->parameters["columns"])) {
            //$this->parameters["columns"][]["data"]
            //$this->parameters["columns"][]["name"] = ''
            //$this->parameters["columns"][]["orderable"] = 'true / false'
            //$this->parameters["columns"][]["search"]["regex"] = 'true / false'
            //$this->parameters["columns"][]["search"]["value"] = ''
            //$this->parameters["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->parameters["search"])) {
            $searchqr = ' AND (t10.`channel_name`       LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t10.`channel_description`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t10.`channel_created_at`     LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t18.`chownname`              LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t18.`chownemail`             LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t10.`id` IN (
                            SELECT `channel_id` 
                            FROM `channel_countries` 
                            WHERE `country_id`  IN (
                                SELECT `id` 
                                FROM `pic3pic_countries`
                                WHERE `Country` LIKE "%' . $this->parameters["search"]["value"] . '%"
                            )
                        )
                        OR t10.`id` IN (
                            SELECT `channel_id` 
                            FROM `channel_report` 
                            WHERE `report_id`  IN (
                                SELECT `id` 
                                FROM `report`
                                WHERE `report_name` LIKE "%' . $this->parameters["search"]["value"] . '%"
                            )
                        ))';
        }
        if (isset($this->parameters["order"])) {
            $column = (int) $this->parameters["order"][0]["column"];
            $dir = $this->parameters["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY t10.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY t10.`channel_name` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY t10.`channel_created_at` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY t18.`chownname` ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY t18.`chownemail` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY t10.`id` ASC';
                    break;
            }
        }
        $query = '/* Channel */
                SELECT
                    t10.`id` AS  chid,
                    t10.`user_id` AS chuid,
                    t10.`channel_name`,
                    t10.`channel_description`,
                    t10.`channel_location`,
                    t10.`channel_language`,
                    IF(t10.`channel_icon` IS NOT NULL OR t10.`channel_icon` != NULL,   (SELECT
                            CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                            THEN "<img src=\'' . DEFAULT_CHANEL_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />" 
                            ELSE CONCAT("<img src=\'' . WEBURL . '",ph1.`ver3`,"\' class=\'img-responsive\' width=\'60\' />")
                            END AS pic
                        FROM `photo` AS ph1
                        WHERE t10.`channel_icon` = ph1.`id`), "<img src=\'' . DEFAULT_CHANEL_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />"
                    ) AS channel_icon,
                    t10.`channel_created_at`,
                    IF(t10.status_id = 4, "De-activate","Activate") AS action,
                    IF(t10.status_id = 4, "btn-danger", "btn-success") AS btn,
                    IF(t10.status_id = 4, 6,4) AS actionid,
                    t14.*,
                    t15.*,
                    t18.*
                FROM  `channel` AS t10
                /* Channel Countries */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chcont_id, 
                        t1.`channel_id`, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chcont_contid, 
                        GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS chcont_contname
                    FROM `channel_countries`        AS t1
                    LEFT JOIN `pic3pic_countries`   AS t2 ON t2.`id` = t1.`country_id`
                    GROUP BY(t1.`channel_id`)
                    ORDER BY(t1.`channel_id`)
                ) AS t14 ON t14.`channel_id` = t10.`id` 
                /* Channel Report */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chrep_id, 
                        t1.`channel_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS chrep_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chrep_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chrep_repid, 
                        GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS chrep_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS chrep_uname
                    FROM `channel_report` 	AS t1
                    LEFT JOIN `report`		AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    GROUP BY(t1.`channel_id`)
                    ORDER BY(t1.`channel_id`)
                ) AS t15 ON t15.`channel_id` = t10.`id` 
                LEFT JOIN (
                    SELECT
                        ad.`id` AS chownid,
                        ad.`user_name` AS chownname,
                        ad.`email` AS chownemail,
                        ad.`cell_number` AS chowncell,
                        IF(ad.`icon` IS NOT NULL OR ad.`icon` != NULL,   (SELECT
                                CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                                THEN "<img src=\'' . DEFAULT_USER_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />" 
                                ELSE CONCAT("<img src=\'' . WEBURL . '",ph1.`ver3`,"\' class=\'img-responsive\' width=\'60\' />")
                                END AS pic
                            FROM `photo` AS ph1
                            WHERE ad.`icon` = ph1.`id`), "<img src=\'' . DEFAULT_USER_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />"
                        ) AS chownpic
                    FROM `user_profile` AS ad
                )AS t18 ON t18.`chownid` = t10.`user_id`
                WHERE t10.`status_id` != NULL OR t10.`status_id` IS NOT NULL
                ' . $searchqr . ' ' . $orderqr . ' ;';
        $result = executeQuery($query);
        $num_posts = mysql_num_rows($result);
        $delimiters = array("♥☻☻♥", "♥☻♥");
        $delimiters1 = array("♥☻☻♥", "♥☻♥", "♥♥");
        $newRes = array(
            "channel" => array(),
            "chcont" => array(),
            "chrep" => array(),
        );
        if ($num_posts) {
            $data["count"] = $num_posts;
            $data["status"] = "success";
            $listusers = array();
            while ($row = mysql_fetch_assoc($result)) {
                /* Channel */
                array_push($newRes["channel"],array(
                    "chid" => (integer) $row["chid"],
                    "channel_name" => ucfirst($row["channel_name"]),
                    "channel_description" => $row["channel_description"],
                    "channel_location" => (integer) $row["channel_location"],
                    "channel_language" => (integer) $row["channel_language"],
                    "channel_icon" => $row["channel_icon"],
                    "channel_created_at" => $row["channel_created_at"],
                    "action" => $row["action"],
                    "actionid" => $row["actionid"],
                    "btn" => $row["btn"],
                    /* Channel Owner */
                    "chownid" => (integer) $row["chownid"],
                    "chownname" => ucfirst($row["chownname"]),
                    "chownemail" => $row["chownemail"],
                    "chowncell" => $row["chowncell"],
                    "chownpic" => $row["chownpic"],
                ));
                /* Channel Countries */
                array_push($newRes["chcont"],array(
                    "chcont_id" => explode("♥☻☻♥", $row['chcont_id']),
                    "chcont_time" => explode("♥☻☻♥", $row['chcont_time']),
                    "chcont_contid" => explode("♥☻☻♥", $row['chcont_contid']),
                    "chcont_contname" => explode("♥☻☻♥", $row['chcont_contname']),
                ));
                /* Channel Report */
                array_push($newRes["chrep"] , array(
                    "chrep_id" => explode("♥☻☻♥", $row['chrep_id']),
                    "chrep_uid" => explode("♥☻☻♥", $row['chrep_uid']),
                    "chrep_uname" => explode("♥☻☻♥", $row['chrep_uname']),
                    "chrep_repid" => explode("♥☻☻♥", $row['chrep_repid']),
                    "chrep_repname" => explode("♥☻☻♥", $row['chrep_repname']),
                    "chrep_time" => explode("♥☻☻♥", $row['chrep_time']),
                ));
            }
            $data = array();
            for ($i = 0; $i < count($newRes["channel"]); $i++) {
                array_push($data, array(
                    "No" => $i + 1,
                    "Name" => $newRes["channel"][$i]["channel_name"],
                    "Description" => $newRes["channel"][$i]["channel_description"],
                    "Location" => (isset($newRes["channel"][$i]["channel_location"]) && $newRes["channel"][$i]["channel_location"] === 0) ? 'World':'Country',
                    "Icon" => $newRes["channel"][$i]["channel_icon"],
                    "Created" => $newRes["channel"][$i]["channel_created_at"],
                    "Owner" => $newRes["channel"][$i]["chownname"],
                    "Owner Email" => $newRes["channel"][$i]["chownemail"],
                    "Countries" => implode("<br />", $newRes["chcont"][$i]["chcont_contname"]),
                    "Reports" => implode("<br />", $newRes["chrep"][$i]["chrep_repname"]),
                    "Action" => '<button class="btn ' . $newRes["channel"][$i]["btn"] . '" id="listchannels_' . $newRes["channel"][$i]["chid"] . '" name="' . $newRes["channel"][$i]["chid"] . '">' . $newRes["channel"][$i]["action"] . '</button>',
                    "cid" => $newRes["channel"][$i]["chid"],
                    "btnid" => '#listchannels_' . $newRes["channel"][$i]["chid"],
                    "actionid" => $newRes["channel"][$i]["actionid"],
                ));
            }
            $listusers["draw"] = $this->parameters["draw"];
            $listusers["recordsTotal"] = $num_posts;
            $listusers["recordsFiltered"] = $num_posts;
            $listusers["data"] = $data;
        }
        return $listusers;
    }
    public function blockPost() {
        $query = 'UPDATE `post` 
                SET `status_id`="' . mysql_real_escape_string($this->parameters['stat']) . '"
                WHERE `id`="' . mysql_real_escape_string($this->parameters['id']) . '"';
        return executeQuery($query);
    }
    public function listPost() {
        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        if (isset($this->parameters["columns"])) {
            //$this->parameters["columns"][]["data"]
            //$this->parameters["columns"][]["name"] = ''
            //$this->parameters["columns"][]["orderable"] = 'true / false'
            //$this->parameters["columns"][]["search"]["regex"] = 'true / false'
            //$this->parameters["columns"][]["search"]["value"] = ''
            //$this->parameters["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->parameters["search"])) {
            $searchqr = ' AND (t1.`title`      LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`created_at`     LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR up.`postername`     LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR up.`posteremail`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`id` IN (
                            SELECT `post_id` 
                            FROM `post_countries` 
                            WHERE `country_id`  IN (
                                SELECT `id` 
                                FROM `pic3pic_countries`
                                WHERE `Country` LIKE "%' . $this->parameters["search"]["value"] . '%"
                            )
                        )
                        OR t1.`id` IN (
                            SELECT `post_id` 
                            FROM `post_report` 
                            WHERE `report_id`  IN (
                                SELECT `id` 
                                FROM `report`
                                WHERE `report_name` LIKE "%' . $this->parameters["search"]["value"] . '%"
                            )
                        ))';
        }
        if (isset($this->parameters["order"])) {
            $column = (int) $this->parameters["order"][0]["column"];
            $dir = $this->parameters["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY t1.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY t1.`title` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t1.`created_at` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY up.`postername` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY up.`posteremail` ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY t1.`id` DESC';
                    break;
            }
        }
        $query = '/*Post Start*/
                SELECT
                    t1.`id`,
                    TRIM(t1.`title`) AS title,
                    t1.`created_at`,
                    IF(t1.status_id = 4, "De-activate","Activate") AS action,
                    IF(t1.status_id = 4, "btn-danger", "btn-success") AS btn,
                    IF(t1.status_id = 4, 6,4) AS actionid,
                    t2.*,
                    t3.*,
                    t9.*,
                    up.`posterpic`,
                    up.`posterid`,
                    up.`postername`,
                    up.`posteremail`,
                    up.`postercell`
                FROM `post` AS t1
                /* Post Countries */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, 
                        t1.`post_id`, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, 
                        GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `post_countries` 	AS t1
                    LEFT JOIN `pic3pic_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    GROUP BY(t1.`post_id`)
                    ORDER BY(t1.`post_id`)
                ) AS t2 ON t2.`post_id` = t1.`id`
                /*Post User*/
                INNER JOIN (
                    SELECT
                        ad.`id` AS posterid,
                        ad.`user_name` AS postername,
                        ad.`email` AS posteremail,
                        ad.`cell_number` AS postercell,
                        IF(ad.`icon` IS NOT NULL OR ad.`icon` != NULL,   (SELECT
                                CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                                THEN "<img src=\'' . DEFAULT_USER_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />" 
                                ELSE CONCAT("<img src=\'' . WEBURL . '",ph1.`ver3`,"\' class=\'img-responsive\' width=\'60\' />")
                                END AS pic
                            FROM `photo` AS ph1
                            WHERE ad.`icon` = ph1.`id`), "<img src=\'' . DEFAULT_USER_ICON_IMG . '\' class=\'img-responsive\' width=\'60\' />"
                        ) AS posterpic
                    FROM `user_profile` AS ad
                ) AS up ON up.`posterid` = t1.`user_id`
                /*Post Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, 
                        t1.`post_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, 
                        GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `post_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    GROUP BY(t1.`post_id`)
                    ORDER BY(t1.`post_id`)
                ) AS t3 ON t3.`post_id` = t1.`id`
                /*Post Photo*/
                LEFT JOIN (
                    SELECT
                        `id` AS p_phid,
                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"' . DEFAULT_POST_IMG . '",CONCAT("'.WEBURL.'",TRIM(`original_pic`))) AS p_ph,
                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"' . DEFAULT_POST_IMG . '",CONCAT("'.WEBURL.'",TRIM(`ver1`))) AS p_pv1,
                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"' . DEFAULT_POST_IMG . '",CONCAT("'.WEBURL.'",TRIM(`ver2`))) AS p_pv2,
                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"' . DEFAULT_POST_IMG . '",CONCAT("'.WEBURL.'",TRIM(`ver3`))) AS p_pv3,
                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"' . DEFAULT_POST_IMG . '",CONCAT("'.WEBURL.'",TRIM(`ver4`))) AS p_pv4,
                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"' . DEFAULT_POST_IMG . '",CONCAT("'.WEBURL.'",TRIM(`ver5`))) AS p_pv5
                    FROM `photo`
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                WHERE t1.`status_id` != NULL OR t1.`status_id` IS NOT NULL
                ' . $searchqr . ' ' . $orderqr . ' ;';
        $result = executeQuery($query);
        $num_posts = mysql_num_rows($result);
        $delimiters = array("♥☻☻♥", "♥☻♥");
        $delimiters1 = array("♥☻☻♥", "♥☻♥", "♥♥");
        $newRes = array();
        if ($num_posts) {
            $data["count"] = $num_posts;
            $data["status"] = "success";
            $listusers = array();
            while ($row = mysql_fetch_assoc($result)) {
                array_push($newRes, array(
                    "posts" => array(
                        "id" => (integer) $row["id"],
                        "title" => $row["title"],
                        "created_at" => $row["created_at"],
                        "posterid" => (integer) $row["posterid"],
                        "postername" => $row["postername"],
                        "posteremail" => $row["posteremail"],
                        "postercell" => $row["postercell"],
                        "posterpic" => $row["posterpic"],
                        "action" => $row["action"],
                        "btn" => $row["btn"],
                        "actionid" => $row["actionid"],
                        "photo" => array(
                            "p_phid" => $row['p_phid'],
                            "p_ph" => $row['p_ph'],
                            "p_pv1" => $row['p_pv1'],
                            "p_pv2" => $row['p_pv2'],
                            "p_pv3" => $row['p_pv3'],
                            "p_pv4" => $row['p_pv4'],
                            "p_pv5" => $row['p_pv5'],
                        ),
                        "post_location" => array(
                            "post_location" => $row["post_location"],
                            "pcont_id" => explode("♥☻☻♥", $row['pcont_id']),
                            "pcont_time" => explode("♥☻☻♥", $row['pcont_time']),
                            "pcont_contid" => explode("♥☻☻♥", $row['pcont_contid']),
                            "pcont_contname" => explode("♥☻☻♥", $row['pcont_contname']),
                        ),
                        "report" => array(
                            "pr_uname" => explode("♥☻☻♥", $row['pr_uname']),
                            "pr_id" => explode("♥☻☻♥", $row['pr_id']),
                            "pr_uid" => explode("♥☻☻♥", $row['pr_uid']),
                            "pr_time" => explode("♥☻☻♥", $row['pr_time']),
                            "pr_repid" => explode("♥☻☻♥", $row['pr_repid']),
                            "pr_repname" => explode("♥☻☻♥", $row['pr_repname']),
                        ),
                    )
                ));
            }
            $data = array();
            for ($i = 0; $i < count($newRes); $i++) {
                array_push($data, array(
                    "No" => $i + 1,
                    "Title" => $newRes[$i]["posts"]["title"],
                    "Created" => $newRes[$i]["posts"]["created_at"],
                    "Owner" => $newRes[$i]["posts"]["postername"],
                    "Owner Email" => $newRes[$i]["posts"]["posteremail"],
                    "Icon" => '<img src="'.$newRes[$i]["posts"]["photo"]["p_pv4"].'" class="img-responsive" width="60" />',
                    "Countries" => implode("<br />", $newRes[$i]["posts"]["post_location"]["post_location"]),
                    "Reports" => implode("<br />", $newRes[$i]["posts"]["report"]["pr_repname"]),
                    "Action" => '<button class="btn ' . $newRes[$i]["posts"]["btn"] . '" id="listposts_' . $newRes[$i]["posts"]["id"] . '" name="' . $newRes[$i]["posts"]["id"] . '">' . $newRes[$i]["posts"]["action"] . '</button>',
                    "pid" => $newRes[$i]["posts"]["id"],
                    "btnid" => '#listposts_' . $newRes[$i]["posts"]["id"],
                    "actionid" => $newRes[$i]["posts"]["actionid"],
                ));
            }
            $listusers["draw"] = $this->parameters["draw"];
            $listusers["recordsTotal"] = $num_posts;
            $listusers["recordsFiltered"] = $num_posts;
            $listusers["data"] = $data;
        }
        return $listusers;
    }
    public function addSection1() {
        $query = 'INSERT INTO `sections_index_post`(`id`, `section_name`, `created_at`, `status_id`) VALUES
            (NULL,
            "' . mysql_real_escape_string($this->parameters['name']) . '",
                NOW(),
                4)';
        return executeQuery($query);
    }
    public function addSection2() {
        $query = 'INSERT INTO `sections_walll_post`(`id`, `section_name`, `created_at`, `status_id`) VALUES
            (NULL,
            "' . mysql_real_escape_string($this->parameters['name']) . '",
                NOW(),
                4)';
        return executeQuery($query);
    }
    public function addSection3() {
        $query = 'INSERT INTO `sections_channel_post`(`id`, `section_name`, `created_at`, `status_id`) VALUES
            (NULL,
            "' . mysql_real_escape_string($this->parameters['name']) . '",
                NOW(),
                4)';
        return executeQuery($query);
    }
    public function listSection1() {
        $query = 'SELECT 
                    con.id,
                    con.section_name AS continent_name,
                    IF(con.status_id = 4, "De-activate","Activate") AS action,
                    IF(con.status_id = 4, "btn-danger", "btn-success") AS btn,
                    IF(con.status_id = 4, 6,4) AS actionid
                FROM `sections_index_post` AS con
                ORDER BY con.section_name ASC;';
        $result = executeQuery($query);
        $data = array();
        $jsondata = array(
            "status" => "failure",
            "data" => NULL);
        if (mysql_num_rows($result)) {
            $i = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $data[$i]["id"] = $row['id'];
                $data[$i]["cname"] = $row['continent_name'];
                $data[$i]["action"] = $row['action'];
                $data[$i]["btn"] = $row['btn'];
                $data[$i]["actionid"] = $row['actionid'];
                ++$i;
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data
            );
        }
        return $jsondata;
    }
    public function listSection2() {
        $query = 'SELECT 
                    con.id,
                    con.section_name AS continent_name,
                    IF(con.status_id = 4, "De-activate","Activate") AS action,
                    IF(con.status_id = 4, "btn-danger", "btn-success") AS btn,
                    IF(con.status_id = 4, 6,4) AS actionid
                FROM `sections_walll_post` AS con
                ORDER BY con.section_name ASC;';
        $result = executeQuery($query);
        $data = array();
        $jsondata = array(
            "status" => "failure",
            "data" => NULL);
        if (mysql_num_rows($result)) {
            $i = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $data[$i]["id"] = $row['id'];
                $data[$i]["cname"] = $row['continent_name'];
                $data[$i]["action"] = $row['action'];
                $data[$i]["btn"] = $row['btn'];
                $data[$i]["actionid"] = $row['actionid'];
                ++$i;
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data
            );
        }
        return $jsondata;
    }
    public function listSection3() {
        $query = 'SELECT 
                    con.id,
                    con.section_name AS continent_name,
                    IF(con.status_id = 4, "De-activate","Activate") AS action,
                    IF(con.status_id = 4, "btn-danger", "btn-success") AS btn,
                    IF(con.status_id = 4, 6,4) AS actionid
                FROM `sections_channel_post` AS con
                ORDER BY con.section_name ASC;';
        $result = executeQuery($query);
        $data = array();
        $jsondata = array(
            "status" => "failure",
            "data" => NULL);
        if (mysql_num_rows($result)) {
            $i = 0;
            while ($row = mysql_fetch_assoc($result)) {
                $data[$i]["id"] = $row['id'];
                $data[$i]["cname"] = $row['continent_name'];
                $data[$i]["action"] = $row['action'];
                $data[$i]["btn"] = $row['btn'];
                $data[$i]["actionid"] = $row['actionid'];
                ++$i;
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data
            );
        }
        return $jsondata;
    }
    public function delSection1() {
        $query = 'UPDATE `sections_index_post` 
                SET `status_id`="' . mysql_real_escape_string($this->parameters['stat']) . '"
                WHERE `id`="' . mysql_real_escape_string($this->parameters['id']) . '"';
        return executeQuery($query);
    }
    public function delSection2() {
        $query = 'UPDATE `sections_walll_post` 
                SET `status_id`="' . mysql_real_escape_string($this->parameters['stat']) . '"
                WHERE `id`="' . mysql_real_escape_string($this->parameters['id']) . '"';
        return executeQuery($query);
    }
    public function delSection3() {
        $query = 'UPDATE `sections_channel_post` 
                SET `status_id`="' . mysql_real_escape_string($this->parameters['stat']) . '"
                WHERE `id`="' . mysql_real_escape_string($this->parameters['id']) . '"';
        return executeQuery($query);
    }
    public function getTraffic() {
        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        if (isset($this->parameters["columns"])) {
            //$this->parameters["columns"][]["data"]
            //$this->parameters["columns"][]["name"] = ''
            //$this->parameters["columns"][]["orderable"] = 'true / false'
            //$this->parameters["columns"][]["search"]["regex"] = 'true / false'
            //$this->parameters["columns"][]["search"]["value"] = ''
            //$this->parameters["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->parameters["search"])) {
            $searchqr = ' AND (t1.`ip`      LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`host`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`city`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`zipcode`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`province`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`country`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`hittime`    LIKE "%' . $this->parameters["search"]["value"] . '%")';
        }
        if (isset($this->parameters["order"])) {
            $column = (int) $this->parameters["order"][0]["column"];
            $dir = $this->parameters["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY t1.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY t1.`ip` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t1.`host` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY t1.`city` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY t1.`zipcode`  ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY t1.`province`  ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY t1.`country`  ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY t1.`hittime`  ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY t1.`id` DESC';
                    break;
            }
        }
        $query = 'SELECT 
            t1.`ip`,
            t1.`host`,
            t1.`city`,
            t1.`zipcode`,
            t1.`province`,
            t1.`country`,
            t1.`hittime`
            FROM `pic3pic_traffic` as t1
            WHERE `id` != NULL ' . $searchqr . ' ' . $orderqr . ' ;';
        $result = executeQuery($query);
        $num_posts = mysql_num_rows($result);
        if ($num_posts) {
            $listusers = array();
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                array_push($data, array(
                    "No" => $i + 1,
                    "ip" => $fetchdata[$i]["ip"],
                    "host" => $fetchdata[$i]["host"],
                    "city" => $fetchdata[$i]["city"],
                    "zipcode" => $fetchdata[$i]["zipcode"],
                    "province" => $fetchdata[$i]["province"],
                    "country" => $fetchdata[$i]["country"],
                    "hittime" => $fetchdata[$i]["hittime"],
                ));
            }
            $listusers["draw"] = $this->parameters["draw"];
            $listusers["recordsTotal"] = $num_posts;
            $listusers["recordsFiltered"] = $num_posts;
            $listusers["data"] = $data;
        }
        return $listusers;
    }
    public function getLogs() {
        $searchqr = '';
        $orderqr = '';
        $data = array();
        $listusers = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
        );
        $num_posts = 0;
        if (isset($this->parameters["columns"])) {
            //$this->parameters["columns"][]["data"]
            //$this->parameters["columns"][]["name"] = ''
            //$this->parameters["columns"][]["orderable"] = 'true / false'
            //$this->parameters["columns"][]["search"]["regex"] = 'true / false'
            //$this->parameters["columns"][]["search"]["value"] = ''
            //$this->parameters["columns"][]["searchable"] = 'true / false'
        }
        if (isset($this->parameters["search"])) {
            $searchqr = ' AND (t1.`ip`      LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`host`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`city`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`zipcode`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`province`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`country`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t1.`in_time`    LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t2.`user_name`      LIKE "%' . $this->parameters["search"]["value"] . '%"
                        OR t2.`email`      LIKE "%' . $this->parameters["search"]["value"] . '%")';
        }
        if (isset($this->parameters["order"])) {
            $column = (int) $this->parameters["order"][0]["column"];
            $dir = $this->parameters["order"][0]["dir"];
            switch ($column) {
                case 0:
                    $orderqr = ' ORDER BY t1.`id` ' . $dir;
                    break;
                case 1:
                    $orderqr = ' ORDER BY t2.`user_name` ' . $dir;
                    break;
                case 2:
                    $orderqr = ' ORDER BY t2.`email` ' . $dir;
                    break;
                case 3:
                    $orderqr = ' ORDER BY t1.`ip` ' . $dir;
                    break;
                case 4:
                    $orderqr = ' ORDER BY t1.`host` ' . $dir;
                    break;
                case 5:
                    $orderqr = ' ORDER BY t1.`city` ' . $dir;
                    break;
                case 6:
                    $orderqr = ' ORDER BY t1.`zipcode`  ' . $dir;
                    break;
                case 7:
                    $orderqr = ' ORDER BY t1.`province`  ' . $dir;
                    break;
                case 8:
                    $orderqr = ' ORDER BY t1.`country`  ' . $dir;
                    break;
                case 9:
                    $orderqr = ' ORDER BY t1.`in_time`  ' . $dir;
                    break;
                default:
                    $orderqr = ' ORDER BY t1.`id` DESC';
                    break;
            }
        }
        $query = 'SELECT 
            t1.`ip`,
            t1.`host`,
            t1.`city`,
            t1.`zipcode`,
            t1.`province`,
            t1.`country`,
            t1.`in_time`,
            t2.`user_name`,
            t2.`email`
            FROM `user_profile_logs` as t1
            LEFT JOIN `user_profile` as t2 ON t2.`id` = t1.`user_id`
            WHERE t1.`id` != NULL ' . $searchqr . ' ' . $orderqr . ' ;';
        $result = executeQuery($query);
        $num_posts = mysql_num_rows($result);
        if ($num_posts) {
            $listusers = array();
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                array_push($data, array(
                    "No" => $i + 1,
                    "user_name" => $fetchdata[$i]["user_name"],
                    "email" => $fetchdata[$i]["email"],
                    "ip" => $fetchdata[$i]["ip"],
                    "host" => $fetchdata[$i]["host"],
                    "city" => $fetchdata[$i]["city"],
                    "zipcode" => $fetchdata[$i]["zipcode"],
                    "province" => $fetchdata[$i]["province"],
                    "country" => $fetchdata[$i]["country"],
                    "in_time" => $fetchdata[$i]["in_time"],
                ));
            }
            $listusers["draw"] = $this->parameters["draw"];
            $listusers["recordsTotal"] = $num_posts;
            $listusers["recordsFiltered"] = $num_posts;
            $listusers["data"] = $data;
        }
        return $listusers;
    }
}
?>