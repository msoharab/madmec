<?php
class NewLead_Model extends BaseModel {
    public $UserId;
    function __construct() {
        parent::__construct();
        $this->UserId = (integer) isset($_SESSION["USERDATA"]["logindata"]["id"]) ?
                $_SESSION["USERDATA"]["logindata"]["id"] :
                0;
    }
    public function CreateNew_Lead() {
        $location = 0;
        $res4 = false;
        $res5 = false;
        $res6 = false;
        if ($this->postBaseData["details"]["target"] == "Country") {
            $location = $this->postBaseData["details"]["continent"];
        } else {
            $location = $this->postBaseData["details"]["target"];
        }
        $jsondata = array(
            "name" => $this->postBaseData["details"]["name"],
            "target" => $location,
            "continent" => isset($this->postBaseData["details"]["continent"]) ? $this->postBaseData["details"]["continent"] : false,
            "countries" => isset($this->postBaseData["details"]["countries"]) ? (array) $this->postBaseData["details"]["countries"] : false,
            "langauges" => isset($this->postBaseData["details"]["langauges"]) ? (array) $this->postBaseData["details"]["langauges"] : false,
            "sections" => isset($this->postBaseData["details"]["sections"]) ? (array) $this->postBaseData["details"]["sections"] : false,
            "lead_id" => 0,
            "stat" => 4,
            "status" => 'error',
            "error" => '',
        );
        if (isset($_SESSION['Individual_POST_PATH']) && is_array($_SESSION['Individual_POST_PATH'])) {
            $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
            if ($photo["status"] === "success") {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`ver4`,`ver5`)  VALUES(:id,:orgpic,:ver1,:ver2,:ver3,:ver4,:ver5);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":orgpic" => $photo['original_pic'],
                    ":ver1" => $photo['version_1'],
                    ":ver2" => $photo['version_2'],
                    ":ver3" => $photo['version_3'],
                    ":ver4" => $photo['version_4'],
                    ":ver5" => $photo['version_5']
                ));
                $background = $this->db->lastInsertId();
                $query3 = 'INSERT INTO `lead`(`title`,`photo_id`,`user_id`,`lead_location`,`status_id`,`created_at`)Values('
                        . ':id1,:id2,:id3,:id4,:id5,:id6)';
                $stm = $this->db->prepare($query3);
                $res3 = $stm->execute(array(
                    ":id1" => mysql_real_escape_string($jsondata["name"]),
                    ":id2" => mysql_real_escape_string($background),
                    ":id3" => mysql_real_escape_string($this->UserId),
                    ":id4" => mysql_real_escape_string($location),
                    ":id5" => mysql_real_escape_string($jsondata["stat"]),
                    ":id6" => date("Y-m-d H:i:s")
                ));
                $business_pk = $this->db->lastInsertId();
                $data = array();
                for ($i = 0; $i < count($jsondata["sections"]); $i++) {
                    $data[] = array(
                        "lead_id" => $business_pk,
                        "section_id" => $jsondata["sections"][$i],
                        "created_at" => date("Y-m-d H:i:s")
                    );
                }
                $datafields = array("`lead_id`", "`section_id`", "`created_at`");
                $question_marks = array();
                $insert_values = array();
                foreach ($data as $d) {
                    $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query6 = 'INSERT INTO `lead_section` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query6);
                $res6 = $stm->execute($insert_values);
                if ($jsondata["target"] > 0) {
                    $data = array();
                    for ($i = 0; $i < count($jsondata["countries"]); $i++) {
                        $data[] = array(
                            "business_id" => $business_pk,
                            "country_id" => $jsondata["countries"][$i],
                            "created_at" => date("Y-m-d H:i:s")
                        );
                    }
                    $datafields = array("`lead_id`", "`country_id`", "`created_at`");
                    $question_marks = array();
                    $insert_values = array();
                    foreach ($data as $d) {
                        $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                        $insert_values = array_merge($insert_values, array_values($d));
                    }
                    $query4 = 'INSERT INTO `lead_countries` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                    $stm = $this->db->prepare($query4);
                    $res4 = $stm->execute($insert_values);
                    $data = array();
                    for ($i = 0; $i < count($jsondata["langauges"]); $i++) {
                        $data[] = array(
                            "lead_id" => $business_pk,
                            "languages_id" => $jsondata["langauges"][$i],
                            "created_at" => date("Y-m-d H:i:s")
                        );
                    }
                    $datafields = array("`lead_id`", "`languages_id`", "`created_at`");
                    $question_marks = array();
                    $insert_values = array();
                    foreach ($data as $d) {
                        $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                        $insert_values = array_merge($insert_values, array_values($d));
                    }
                    $query5 = 'INSERT INTO `lead_languages` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                    $stm = $this->db->prepare($query5);
                    $res5 = $stm->execute($insert_values);
                }
            }
            if ($res1 && $res3 && $res6 && $jsondata["target"] == 0) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["lead_id"] = $business_pk;
            } else if ($res1 && $res3 && $res4 && $res5 && $res6 && $jsondata["target"] > 0) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["lead_id"] = $business_pk;
            } else {
                $this->db->rollBack();
            }
            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
    public function ListContinents($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `nookleads_continents` WHERE `status_id` = :stat ORDER BY `continent_name`');
        $res = $stm->execute(array(
            ":stat" => 4
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        switch ($listtype) {
            case "checkbox":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li><input type="checkbox" name="continents[]" id="continents_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["continent_name"]) . '</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["Country"]) . '</option>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["continent_name"]) . '</option>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function ListCountries($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $in = '';
        if (is_array($this->postBaseData["cont_id"])) {
            $in = implode(',', $this->postBaseData["cont_id"]);
        }
        $stm = $this->db->prepare('SELECT * FROM `nookleads_countries` WHERE `status_id` = :stat AND `continent_id` IN (' . $in . ') ORDER BY `Country`');
        $res = $stm->execute(array(
            ":stat" => 4,
        ));
        //$res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        switch ($listtype) {
            case "checkbox":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li><input type="checkbox" name="countries_' . $i . '" id="countries_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["Country"]) . '</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["Country"]) . '</option>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["Country"]) . '</option>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function ListLanguages($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $in = '';
        $result = array();
        if (is_array($this->postBaseData["countries_id"])) {
            $in = implode(',', $this->postBaseData["countries_id"]);
        }
        //$stm = $this->db->prepare('SELECT * FROM `nookleads_languages` WHERE `status_id` = :stat AND `country_id` IN (' . $in . ') ORDER BY `country_id`');
        $stm = $this->db->prepare('SELECT
                                    TRIM(t2.`Country`) AS Country,
                                    GROUP_CONCAT(t1.`id` SEPARATOR "☻♥☻") AS id,
                                    GROUP_CONCAT(t1.`country_id` SEPARATOR "☻♥☻") AS c_id,
                                    GROUP_CONCAT(t1.`Language Name` SEPARATOR "☻♥☻") AS lname
                                  FROM `nookleads_languages` AS t1
                                  JOIN `nookleads_countries` AS t2 ON t1.`country_id` = t2.`id` AND t2.`status_id` = 4
                                  WHERE t1.`status_id` = 4
                                      AND t1.`country_id` IN (' . $in . ')
                                  GROUP BY (t1.country_id)
                                  ORDER BY t2.`Country`');
        $res = $stm->execute();
        //$res = $stm->execute(array(
        //":stat" => 4,
        //));
        $res = $stm->execute();
        if ($res) {
            $res = $stm->fetchAll();
            for ($i = 0; $i < count($res); $i++) {
                array_push($result, array(
                    "Country" => $res[$i]['Country'],
                    "id" => explode("☻♥☻", $res[$i]['id']),
                    "Language Name" => explode("☻♥☻", $res[$i]['lname']),
                ));
            }
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        switch ($listtype) {
            case "checkbox":
                for ($i = 0; $i < count($result); $i++) {
                    $data["html"] .= '<li>' . ucfirst($result[$i]["Country"]) . '</li>';
                    for ($j = 0; $j < count($result[$i]["id"]) && isset($result[$i]["id"]); $j++) {
                        $data["html"] .= '<li><input type="checkbox" name="languages_' . $j . '" id="languages_' . $j . '" value="' . $result[$i]["id"][$j] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["Language Name"][$j]) . '</li>';
                    }
                }
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li><input type="checkbox" name="languages_' . $i . '" id="languages_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["Language Name"]) . '</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["Language Name"]) . '</option>';
                }
                break;
            default:
                for ($i = 0; $i < count($result); $i++) {
                    $data["html"] .= '<optgroup label="' . ucfirst($result[$i]["Country"]) . '">';
                    for ($j = 0; $j < count($result[$i]["id"]) && isset($result[$i]["id"]); $j++) {
                        $data["html"] .= '<option value="' . $result[$i]["id"][$j] . '">' . ucfirst($result[$i]["Language Name"][$j]) . '</option>';
                    }
                    $data["html"] .= '</optgroup>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function getSectionsNames($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'secCheckH',
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `sections_deall_lead` WHERE `status_id` = :stat ORDER BY `section_name`');
        $res = $stm->execute(array(
            ":stat" => 4
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        switch ($listtype) {
            case "checkbox":
                for ($i = 0, $j = 0; $i < $data["count"]; $i++) {
                    if ($i == ($j * 4)) {
                        $j += 1;
                        $data["html"] .= '<div class="col-lg-12">&nbsp;</div>';
                    }
                    $data["html"] .= '<div class="col-lg-3">' .
                            '<div class="input-group">' .
                            '<span class="input-group-addon woborder">' .
                            '<input type="checkbox" class="secCheck" name="sectionso_' . $i . '" id="sectionspo_' . $i . '" value="' . $result[$i]["id"] . '" aria-label="..." checked="checked" />' .
                            '</span><p class="wop"><strong>' . $result[$i]["section_name"] . '</strong> </p></div></div>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . $result[$i]["section_name"] . '</option>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst(trim($result[$i]["section_name"])) . '</option>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function getUserLead($param = false) {
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'secCheck',
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT `id` FROM `lead` WHERE `status_id` = :stat AND  `user_id` = :uid ORDER BY `id` DESC;');
        $res = $stm->execute(array(
            ":stat" => 4,
            ":uid" => mysql_real_escape_string($param),
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        return $data;
    }
    public function filterListLead() {
        $_SESSION["ListNewLead"] = NULL;
        $languages = '""';
        $countries = '""';
        $sections = '""';
        if (isset($this->postBaseData["action"]) 
                && $this->postBaseData["action"] == "filterListLead") {
            if (isset($this->postBaseData["details"]["target"]) 
                    && $this->postBaseData["details"]["target"] === 'Country') {
                if (isset($this->postBaseData["details"]["countries"]) 
                        && is_array($this->postBaseData["details"]["countries"])
                        && count($this->postBaseData["details"]["countries"]) > 0) {
                    $countries = implode(",", array_values($this->postBaseData["details"]["countries"]));
                }
                if (isset($this->postBaseData["details"]["languages"]) 
                        && is_array($this->postBaseData["details"]["languages"])
                        && count($this->postBaseData["details"]["languages"]) > 0) {
                    $languages = implode(",", array_values($this->postBaseData["details"]["languages"]));
                }
            }
            if (isset($this->postBaseData["details"]["sections"]) 
                    && is_array($this->postBaseData["details"]["sections"])
                    && count($this->postBaseData["details"]["sections"]) > 0) {
                $sections = implode(",", array_values($this->postBaseData["details"]["sections"]));
            }
        }
        $stm = $this->db->prepare('/*Lead Start*/
                SELECT
                    /*COUNT(t1.`id`) AS lead_ct,*/
                    t1.*,
                    t1.`id`,
                    TRIM(t1.`title`) AS title,
                    t1.`photo_id`,
                    t1.`section_id`,
                    t1.`user_id`,
                    t1.`created_at`,
                    IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), NULL , t1.`photo_id`) AS p_pic_flag,
                    t2.*,
                    t3.*,
                    t4.*,
                    t5.*,
                    t6.*,
                    t7.*,
                    t8.*,
                    t9.*,
                    t10.*,
                    t11.*,
                    up.`leaderpic`,
                    up.`leaderid`,
                    up.`leadername`,
                    up.`leaderemail`,
                    up.`leadercell`
                FROM `lead` AS t1
                /*Lead Countries*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `lead_countries` 	AS t1
                    LEFT JOIN `nookleads_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    OR t2.`id` IN ('.$countries.')
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t2 ON t2.`lead_id` = t1.`id`
                /*Lead User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS leaderid,
                        ad.`user_name` AS leadername,
                        ad.`email` AS leaderemail,
                        ad.`cell_number` AS leadercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS leaderpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id` 
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`leaderid` = t1.`user_id` 
                /*Lead Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `lead_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t3 ON t3.`lead_id` = t1.`id`
                /*Lead Preferences*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                    FROM `lead_preferences` 	AS t1
                    LEFT JOIN `preferences`		AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t4 ON t4.`lead_id` = t1.`id`
                /*Lead Approvals*/
                LEFT JOIN (
                    SELECT 
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `lead_approvals` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t5 ON t5.`lead_id` = t1.`id`
                /*Lead Quotations*/
                LEFT JOIN (
                SELECT
                    t1.`lead_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                    GROUP_CONCAT(t1.`quotation` SEPARATOR "♥☻☻♥") AS quotations, 
                    GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                    GROUP_CONCAT(IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) SEPARATOR "♥☻☻♥") AS pc_pic_flag,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_phid, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_ph, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv1, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv2, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv3, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv4, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv5, 
                    GROUP_CONCAT(t2.`pcp_id` SEPARATOR "♥☻☻♥") AS pcp_id, 
                    GROUP_CONCAT(t2.`pcp_uid` SEPARATOR "♥☻☻♥") AS pcp_uid, 
                    GROUP_CONCAT(t2.`pcp_time` SEPARATOR "♥☻☻♥") AS pcp_time, 
                    GROUP_CONCAT(t2.`pcp_preid` SEPARATOR "♥☻☻♥") AS pcp_preid, 
                    GROUP_CONCAT(t2.`pcp_pref` SEPARATOR "♥☻☻♥") AS pcp_pref, 
                    GROUP_CONCAT(t2.`pcp_uname` SEPARATOR "♥☻☻♥") AS pcp_uname, 
                    GROUP_CONCAT(t3.`lk_pc_id` SEPARATOR "♥☻☻♥") AS lk_pc_id, 
                    GROUP_CONCAT(t3.`lk_pc_uid` SEPARATOR "♥☻☻♥") AS lk_pc_uid, 
                    GROUP_CONCAT(t3.`lk_pc_time` SEPARATOR "♥☻☻♥") AS lk_pc_time, 
                    GROUP_CONCAT(t3.`lk_pc_uname` SEPARATOR "♥☻☻♥") AS lk_pc_uname, 
                    GROUP_CONCAT(t3.`lk_pc_ct` SEPARATOR "♥☻☻♥") AS lk_pc_ct,
                    GROUP_CONCAT(t4.`pcr_id` SEPARATOR "♥☻☻♥") AS pcr_id, 
                    GROUP_CONCAT(t4.`pcr_uid` SEPARATOR "♥☻☻♥") AS pcr_uid, 
                    GROUP_CONCAT(t4.`wo` SEPARATOR "♥☻☻♥") AS wo, 
                    GROUP_CONCAT(t4.`pcr_time` SEPARATOR "♥☻☻♥") AS pcr_time,  
                    GROUP_CONCAT(t4.`pcr_ct` SEPARATOR "♥☻☻♥") AS pcr_ct, 
                    GROUP_CONCAT(t4.`pcrp_id` SEPARATOR "♥☻☻♥") AS pcrp_id, 
                    GROUP_CONCAT(t4.`pcrp_uid` SEPARATOR "♥☻☻♥") AS pcrp_uid, 
                    GROUP_CONCAT(t4.`pcrp_time` SEPARATOR "♥☻☻♥") AS pcrp_time, 
                    GROUP_CONCAT(t4.`pcr_pic_flag` SEPARATOR "♥☻☻♥") AS pcr_pic_flag, 
                    GROUP_CONCAT(t4.`pcrp_preid` SEPARATOR "♥☻☻♥") AS pcrp_preid,  
                    GROUP_CONCAT(t4.`pcrp_pref` SEPARATOR "♥☻☻♥") AS pcrp_pref,  
                    GROUP_CONCAT(t4.`pcrp_uname` SEPARATOR "♥☻☻♥") AS pcrp_uname, 
                    GROUP_CONCAT(t4.`lk_rep_ct` SEPARATOR "♥☻☻♥") AS lk_rep_ct, 
                    GROUP_CONCAT(t4.`lk_rep_id` SEPARATOR "♥☻☻♥") AS lk_rep_id, 
                    GROUP_CONCAT(t4.`lk_woer_id` SEPARATOR "♥☻☻♥") AS lk_woer_id, 
                    GROUP_CONCAT(t4.`lk_wotime` SEPARATOR "♥☻☻♥") AS lk_wotime, 
                    GROUP_CONCAT(t4.`lk_woer_name` SEPARATOR "♥☻☻♥") AS lk_woer_name, 
                    GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid, 
                    GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph, 
                    GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1, 
                    GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2, 
                    GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,  
                    GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,  
                    GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5, 
                    GROUP_CONCAT(t4.`woererid` SEPARATOR "♥☻☻♥") AS woererid,
                    GROUP_CONCAT(t4.`woername` SEPARATOR "♥☻☻♥") AS woername,
                    GROUP_CONCAT(t4.`woeremail` SEPARATOR "♥☻☻♥") AS woeremail,
                    GROUP_CONCAT(t4.`woercell` SEPARATOR "♥☻☻♥") AS woercell,
                    GROUP_CONCAT(t4.`woerpic` SEPARATOR "♥☻☻♥") AS woerpic,
                    GROUP_CONCAT(up.`quotationererid` SEPARATOR "♥☻☻♥") AS  quotationererid,
                    GROUP_CONCAT(up.`quotationername` SEPARATOR "♥☻☻♥") AS  quotationername,
                    GROUP_CONCAT(up.`quotationeremail` SEPARATOR "♥☻☻♥") AS  quotationeremail,
                    GROUP_CONCAT(up.`quotationercell` SEPARATOR "♥☻☻♥") AS  quotationercell,
                    GROUP_CONCAT(up.`quotationerpic` SEPARATOR "♥☻☻♥") AS  quotationerpic
                FROM `lead_quotations` 					AS t1
                /*Lead Quotations User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS quotationererid,
                        ad.`user_name` AS quotationername,
                        ad.`email` AS quotationeremail,
                        ad.`cell_number` AS quotationercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS quotationerpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`quotationererid` = t1.`user_id`
                /*Lead Quotations Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`lead_quotations_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `lead_quotations_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                )AS t2 ON t2.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`lead_quotations_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `lead_quotations_approvals` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t3 ON t3.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Wo*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                        t1.`lead_quotations_id` AS pcr_pc_id, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                        GROUP_CONCAT(t1.`wo` SEPARATOR "♥☻♥") AS wo, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcr_time,
                        GROUP_CONCAT(
                            IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) 
                             SEPARATOR "♥☻♥"
                        ) AS pcr_pic_flag,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_phid, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_ph, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv1, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv2, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv3, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv4, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv5, 
                        GROUP_CONCAT(t2.`pcrp_id` SEPARATOR "♥☻♥") AS pcrp_id,
                        GROUP_CONCAT(t2.`pcrp_uid` SEPARATOR "♥☻♥") AS pcrp_uid,
                        GROUP_CONCAT(t2.`pcrp_time` SEPARATOR "♥☻♥") AS pcrp_time,
                        GROUP_CONCAT(t2.`pcrp_preid` SEPARATOR "♥☻♥") AS pcrp_preid,
                        GROUP_CONCAT(t2.`pcrp_pref` SEPARATOR "♥☻♥") AS pcrp_pref,
                        GROUP_CONCAT(t2.`pcrp_uname` SEPARATOR "♥☻♥") AS pcrp_uname,
                        GROUP_CONCAT(t3.`lk_rep_id` SEPARATOR "♥☻♥") AS lk_rep_id,
                        GROUP_CONCAT(t3.`lk_woer_id` SEPARATOR "♥☻♥") AS lk_woer_id,
                        GROUP_CONCAT(t3.`lk_wotime` SEPARATOR "♥☻♥") AS lk_wotime,
                        GROUP_CONCAT(t3.`lk_woer_name` SEPARATOR "♥☻♥") AS lk_woer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        GROUP_CONCAT(up.`woererid` SEPARATOR "♥☻♥") AS woererid,
                        GROUP_CONCAT(up.`woername` SEPARATOR "♥☻♥") AS woername,
                        GROUP_CONCAT(up.`woeremail` SEPARATOR "♥☻♥") AS woeremail,
                        GROUP_CONCAT(up.`woercell` SEPARATOR "♥☻♥") AS woercell,
                        GROUP_CONCAT(up.`woerpic` SEPARATOR "♥☻♥") AS woerpic
                    FROM `lead_quotations_wo` 						AS t1
                    /*Lead Quotations Wo User*/
                    INNER JOIN (
                        SELECT 
                            ad.`id` AS woererid,
                            ad.`user_name` AS woername,
                            ad.`email` AS woeremail,
                            ad.`cell_number` AS woercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS woerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`woererid` = t1.`user_id`
                    /*Lead Quotations Wo Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id, 
                            t1.`lead_quotations_wo_id`, 
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid, 
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time, 
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid, 
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref, 
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `lead_quotations_wo_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`lead_quotations_wo_id`)
                        ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t2 ON t2.`lead_quotations_wo_id` = t1.`id`
                    /*Lead Quotations Wo Approvals*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id, 
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`lead_quotations_wo_id`, 
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_woer_id, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_wotime, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_woer_name
                        FROM `lead_quotations_wo_approvals` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`lead_quotations_wo_id`)
                       ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t3 ON t3.`lead_quotations_wo_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
                WHERE t1.`status_id` = 4
                GROUP BY(t1.`lead_id`)
                ORDER BY(t1.`lead_id`)
                ) AS t6 ON t6.`lead_id` = t1.`id`
                /*Lead Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `lead_languages` 	AS t1
                        LEFT JOIN `nookleads_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        OR t2.`id` IN ('.$languages.')
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`)
                ) AS t7 ON t7.`lead_id` = t1.`id`
                /*Lead Sections*/
                LEFT JOIN (
                        /*
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS ps_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS ps_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS ps_secid, GROUP_CONCAT(TRIM(t2.`section_name`) SEPARATOR "♥☻☻♥") AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_deall_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`) DESC
                        */
                        SELECT
                            t1.`id` AS ps_id, 
                            t1.`lead_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_deall_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        OR t2.`id` IN ('.$sections.')
                ) AS t8 ON t8.`lead_id` = t1.`id`
                /*Lead Photo*/
                LEFT JOIN (
                    SELECT
                        `id` AS p_phid,
                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`original_pic`)) AS p_ph,
                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver1`)) AS p_pv1,
                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver2`)) AS p_pv2,
                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver3`)) AS p_pv3,
                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver4`)) AS p_pv4,
                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver5`)) AS p_pv5
                    FROM `photo`
                    WHERE `status_id` = 4
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                /* Lead Business */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`business_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`lead_id` AS chwalead_id,
                        t1.`created_at` AS chwatime,
                        t2.`business_name`,
                        t2.`business_description`,
                        t2.`business_location`,
                        t2.`business_language`,
                        t2.`business_icon`,
                        t2.`business_background`,
                        t2.`business_created_at`,
                        t2.`business_updated_at`,
                        t2.`business_website`
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t10 ON t10.`chwalead_id` = t1.`id`
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chsubid,
                        t1.`business_id` AS chsubcid,
                        t1.`user_id` AS chsubuid,
                        t1.`created_at` AS chsubtime
                    FROM `business_subscribe` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND up.`status_id` = 4
                    AND t1.`user_id` = "' . mysql_real_escape_string($this->UserId) . '"
                ) AS t11 ON t11.`chsubcid` = t10.`chwacid`
                WHERE t1.`status_id` = 4
                AND t1.`id` NOT IN (SELECT `lead_id` FROM `lead_preferences` WHERE `status_id` = 4 AND (`preferences_id` IN (5,6)))
                AND (
                    t1.`id` IN (SELECT `lead_id` FROM `lead_countries` WHERE `country_id` IN ('.$countries.') AND `status_id` = 4)
                    OR
                    t1.`id` IN (SELECT `lead_id` FROM `lead_languages` WHERE `languages_id` IN ('.$languages.') AND `status_id` = 4)
                    OR
                    t1.`id` IN (SELECT `lead_id` FROM `lead_section` WHERE `section_id` IN ('.$sections.') AND `status_id` = 4)
                )
                ORDER BY(t1.`id`) DESC
                /*Lead Ends*/');
        $res = $stm->execute();
        //echo $stm->queryString;
        return $this->buildListLeadArray($res, $stm);
    }
    public function listDealLead() {
        $_SESSION["ListNewLead"] = NULL;
        $stm = $this->db->prepare('/*Lead Start*/
                SELECT
                    /*COUNT(t1.`id`) AS lead_ct,*/
                    t1.*,
                    t1.`id`,
                    TRIM(t1.`title`) AS title,
                    t1.`photo_id`,
                    t1.`section_id`,
                    t1.`user_id`,
                    t1.`created_at`,
                    IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), NULL , t1.`photo_id`) AS p_pic_flag,
                    t2.*,
                    t3.*,
                    t4.*,
                    t5.*,
                    t6.*,
                    t7.*,
                    t8.*,
                    t9.*,
                    t10.*,
                    t11.*,
                    up.`leaderpic`,
                    up.`leaderid`,
                    up.`leadername`,
                    up.`leaderemail`,
                    up.`leadercell`
                FROM `lead` AS t1
                /* Lead Countries */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `lead_countries` 	AS t1
                    LEFT JOIN `nookleads_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t2 ON t2.`lead_id` = t1.`id`
                /*Lead User*/
                INNER JOIN (
                    SELECT
                        ad.`id` AS leaderid,
                        ad.`user_name` AS leadername,
                        ad.`email` AS leaderemail,
                        ad.`cell_number` AS leadercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS leaderpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`leaderid` = t1.`user_id`
                /*Lead Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `lead_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t3 ON t3.`lead_id` = t1.`id`
                /*Lead Preferences*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                    FROM `lead_preferences` 	AS t1
                    LEFT JOIN `preferences`     AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t4 ON t4.`lead_id` = t1.`id`
                /*Lead Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `lead_approvals` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t5 ON t5.`lead_id` = t1.`id`
                /*Lead Quotations*/
                LEFT JOIN (
                SELECT
                    t1.`lead_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id,
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid,
                    GROUP_CONCAT(TRIM(t1.`quotation`) SEPARATOR "♥☻☻♥") AS quotations,
                    GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                    GROUP_CONCAT(IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) SEPARATOR "♥☻☻♥") AS pc_pic_flag,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_phid,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
			(SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_ph,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
			(SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv1,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
			(SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv2,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
			(SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv3,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
			(SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv4,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
			(SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv5,
                    GROUP_CONCAT(t2.`pcp_id` SEPARATOR "♥☻☻♥") AS pcp_id,
                    GROUP_CONCAT(t2.`pcp_uid` SEPARATOR "♥☻☻♥") AS pcp_uid,
                    GROUP_CONCAT(t2.`pcp_time` SEPARATOR "♥☻☻♥") AS pcp_time,
                    GROUP_CONCAT(t2.`pcp_preid` SEPARATOR "♥☻☻♥") AS pcp_preid,
                    GROUP_CONCAT(t2.`pcp_pref` SEPARATOR "♥☻☻♥") AS pcp_pref,
                    GROUP_CONCAT(t2.`pcp_uname` SEPARATOR "♥☻☻♥") AS pcp_uname,
                    GROUP_CONCAT(t3.`lk_pc_id` SEPARATOR "♥☻☻♥") AS lk_pc_id,
                    GROUP_CONCAT(t3.`lk_pc_uid` SEPARATOR "♥☻☻♥") AS lk_pc_uid,
                    GROUP_CONCAT(t3.`lk_pc_time` SEPARATOR "♥☻☻♥") AS lk_pc_time,
                    GROUP_CONCAT(t3.`lk_pc_uname` SEPARATOR "♥☻☻♥") AS lk_pc_uname,
                    GROUP_CONCAT(t3.`lk_pc_ct` SEPARATOR "♥☻☻♥") AS lk_pc_ct,
                    GROUP_CONCAT(t4.`pcr_id` SEPARATOR "♥☻☻♥") AS pcr_id,
                    GROUP_CONCAT(t4.`pcr_uid` SEPARATOR "♥☻☻♥") AS pcr_uid,
                    GROUP_CONCAT(t4.`wo` SEPARATOR "♥☻☻♥") AS wo,
                    GROUP_CONCAT(t4.`pcr_time` SEPARATOR "♥☻☻♥") AS pcr_time,
                    GROUP_CONCAT(t4.`pcr_ct` SEPARATOR "♥☻☻♥") AS pcr_ct,
                    GROUP_CONCAT(t4.`pcrp_id` SEPARATOR "♥☻☻♥") AS pcrp_id,
                    GROUP_CONCAT(t4.`pcrp_uid` SEPARATOR "♥☻☻♥") AS pcrp_uid,
                    GROUP_CONCAT(t4.`pcrp_time` SEPARATOR "♥☻☻♥") AS pcrp_time,
                    GROUP_CONCAT(t4.`pcr_pic_flag` SEPARATOR "♥☻☻♥") AS pcr_pic_flag,
                    GROUP_CONCAT(t4.`pcrp_preid` SEPARATOR "♥☻☻♥") AS pcrp_preid,
                    GROUP_CONCAT(t4.`pcrp_pref` SEPARATOR "♥☻☻♥") AS pcrp_pref,
                    GROUP_CONCAT(t4.`pcrp_uname` SEPARATOR "♥☻☻♥") AS pcrp_uname,
                    GROUP_CONCAT(t4.`lk_rep_ct` SEPARATOR "♥☻☻♥") AS lk_rep_ct,
                    GROUP_CONCAT(t4.`lk_rep_id` SEPARATOR "♥☻☻♥") AS lk_rep_id,
                    GROUP_CONCAT(t4.`lk_woer_id` SEPARATOR "♥☻☻♥") AS lk_woer_id,
                    GROUP_CONCAT(t4.`lk_wotime` SEPARATOR "♥☻☻♥") AS lk_wotime,
                    GROUP_CONCAT(t4.`lk_woer_name` SEPARATOR "♥☻☻♥") AS lk_woer_name,
                    GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid,
                    GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph,
                    GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1,
                    GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2,
                    GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,
                    GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,
                    GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5,
                    GROUP_CONCAT(t4.`woererid` SEPARATOR "♥☻☻♥") AS woererid,
                    GROUP_CONCAT(t4.`woername` SEPARATOR "♥☻☻♥") AS woername,
                    GROUP_CONCAT(t4.`woeremail` SEPARATOR "♥☻☻♥") AS woeremail,
                    GROUP_CONCAT(t4.`woercell` SEPARATOR "♥☻☻♥") AS woercell,
                    GROUP_CONCAT(t4.`woerpic` SEPARATOR "♥☻☻♥") AS woerpic,
                    GROUP_CONCAT(up.`quotationererid` SEPARATOR "♥☻☻♥") AS  quotationererid,
                    GROUP_CONCAT(up.`quotationername` SEPARATOR "♥☻☻♥") AS  quotationername,
                    GROUP_CONCAT(up.`quotationeremail` SEPARATOR "♥☻☻♥") AS  quotationeremail,
                    GROUP_CONCAT(up.`quotationercell` SEPARATOR "♥☻☻♥") AS  quotationercell,
                    GROUP_CONCAT(up.`quotationerpic` SEPARATOR "♥☻☻♥") AS  quotationerpic
                FROM `lead_quotations` 					AS t1
                /*Lead Quotations User*/
                INNER JOIN (
                    SELECT
                        ad.`id` AS quotationererid,
                        ad.`user_name` AS quotationername,
                        ad.`email` AS quotationeremail,
                        ad.`cell_number` AS quotationercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS quotationerpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`quotationererid` = t1.`user_id`
                /*Lead Quotations Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`lead_quotations_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `lead_quotations_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                )AS t2 ON t2.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`lead_quotations_id`,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `lead_quotations_approvals` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t3 ON t3.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Wo*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id,
                        t1.`lead_quotations_id` AS pcr_pc_id,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid,
                        GROUP_CONCAT(TRIM(t1.`wo`) SEPARATOR "♥☻♥") AS wo,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcr_time,
                        GROUP_CONCAT(
                            IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`)
                             SEPARATOR "♥☻♥"
                        ) AS pcr_pic_flag,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_phid,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
                            (SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_ph,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
                            (SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv1,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
                            (SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv2,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
                            (SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv3,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
                            (SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv4,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = ""
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" ,
                            (SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv5,
                        GROUP_CONCAT(t2.`pcrp_id` SEPARATOR "♥☻♥") AS pcrp_id,
                        GROUP_CONCAT(t2.`pcrp_uid` SEPARATOR "♥☻♥") AS pcrp_uid,
                        GROUP_CONCAT(t2.`pcrp_time` SEPARATOR "♥☻♥") AS pcrp_time,
                        GROUP_CONCAT(t2.`pcrp_preid` SEPARATOR "♥☻♥") AS pcrp_preid,
                        GROUP_CONCAT(t2.`pcrp_pref` SEPARATOR "♥☻♥") AS pcrp_pref,
                        GROUP_CONCAT(t2.`pcrp_uname` SEPARATOR "♥☻♥") AS pcrp_uname,
                        GROUP_CONCAT(t3.`lk_rep_id` SEPARATOR "♥☻♥") AS lk_rep_id,
                        GROUP_CONCAT(t3.`lk_woer_id` SEPARATOR "♥☻♥") AS lk_woer_id,
                        GROUP_CONCAT(t3.`lk_wotime` SEPARATOR "♥☻♥") AS lk_wotime,
                        GROUP_CONCAT(t3.`lk_woer_name` SEPARATOR "♥☻♥") AS lk_woer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        GROUP_CONCAT(up.`woererid` SEPARATOR "♥☻♥") AS woererid,
                        GROUP_CONCAT(up.`woername` SEPARATOR "♥☻♥") AS woername,
                        GROUP_CONCAT(up.`woeremail` SEPARATOR "♥☻♥") AS woeremail,
                        GROUP_CONCAT(up.`woercell` SEPARATOR "♥☻♥") AS woercell,
                        GROUP_CONCAT(up.`woerpic` SEPARATOR "♥☻♥") AS woerpic
                    FROM `lead_quotations_wo` 						AS t1
                    /*Lead Quotations Wo User*/
                    INNER JOIN (
                        SELECT
                            ad.`id` AS woererid,
                            ad.`user_name` AS woername,
                            ad.`email` AS woeremail,
                            ad.`cell_number` AS woercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS woerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`woererid` = t1.`user_id`
                    /*Lead Quotations Wo Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id,
                            t1.`lead_quotations_wo_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `lead_quotations_wo_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`lead_quotations_wo_id`)
                        ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t2 ON t2.`lead_quotations_wo_id` = t1.`id`
                    /*Lead Quotations Wo Approvals*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id,
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`lead_quotations_wo_id`,
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_woer_id,
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_wotime,
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_woer_name
                        FROM `lead_quotations_wo_approvals` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`lead_quotations_wo_id`)
                       ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t3 ON t3.`lead_quotations_wo_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
                WHERE t1.`status_id` = 4
                GROUP BY(t1.`lead_id`)
                ORDER BY(t1.`lead_id`)
                ) AS t6 ON t6.`lead_id` = t1.`id`
                /*Lead Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `lead_languages` 	AS t1
                        LEFT JOIN `nookleads_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`)
                ) AS t7 ON t7.`lead_id` = t1.`id`
                /*Lead Sections*/
                LEFT JOIN (
                        SELECT
                            t1.`id` AS ps_id,
                            t1.`lead_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_deall_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                ) AS t8 ON t8.`lead_id` = t1.`id`
                /*Lead Photo*/
                LEFT JOIN (
                    SELECT
                        `id` AS p_phid,
                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`original_pic`)) AS p_ph,
                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver1`)) AS p_pv1,
                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver2`)) AS p_pv2,
                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver3`)) AS p_pv3,
                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver4`)) AS p_pv4,
                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver5`)) AS p_pv5
                    FROM `photo`
                    WHERE `status_id` = 4
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                /* Lead Business */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`business_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`lead_id` AS chwalead_id,
                        t1.`created_at` AS chwatime,
                        t2.`business_name`,
                        t2.`business_description`,
                        t2.`business_location`,
                        t2.`business_language`,
                        t2.`business_icon`,
                        t2.`business_background`,
                        t2.`business_created_at`,
                        t2.`business_updated_at`,
                        t2.`business_website`
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t10 ON t10.`chwalead_id` = t1.`id`
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chsubid,
                        t1.`business_id` AS chsubcid,
                        t1.`user_id` AS chsubuid,
                        t1.`created_at` AS chsubtime
                    FROM `business_subscribe` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND up.`status_id` = 4
                    AND t1.`user_id` = "' . mysql_real_escape_string($this->UserId) . '"
                ) AS t11 ON t11.`chsubcid` = t10.`chwacid`
                WHERE t1.`status_id` = 4
                AND t1.`id` NOT IN (SELECT `lead_id` FROM `lead_preferences` WHERE `status_id` = 4 AND (`preferences_id` IN (5,6)))
                ORDER BY(t1.`id`) DESC
                /*Lead Ends*/');
        $res = $stm->execute();
        //echo $stm->queryString;
        return $this->buildListLeadArray($res, $stm);
    }
    public function approvalLead($param = false) {
        $jsondata = array(
            "count" => $this->ApprovalLeadCount($param),
            "lead_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":leadid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `lead_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `lead_approvals` SET `status_id` = :stat, `created_at`:= :doc WHERE `lead_id` = :leadid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `lead_approvals` (`id`,`lead_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->ApprovalLeadCount($param);
                $jsondata["lead_id"] = $param;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disApprovalLead($param = false) {
        $jsondata = array(
            "count" => $this->ApprovalLeadCount($param),
            "lead_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":leadid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `lead_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `lead_approvals` SET `status_id`  = :stat, `created_at`:= :doc WHERE `lead_id` = :leadid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `lead_approvals` (`id`,`lead_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->ApprovalLeadCount($param);
                $jsondata["lead_id"] = $param;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changeLeadPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 4,
            ":uid" => mysql_real_escape_string($this->UserId),
            ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `lead` SET `status_id` = :stat WHERE `id` = :leadid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `lead` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `lead_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `lead_id` = :leadid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `lead_preferences` (`id`,`lead_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `lead_preferences` SET `preferences_id` = :prefId WHERE `lead_id` = :leadid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["lead_id"] = $this->postBaseData["para"]["leadID"];
        } else {
            $this->db->rollback();
        }
        return $jsondata;
    }
    public function reportLead($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => $this->postBaseData["para"]["reportID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_report` WHERE `report_id` = :prefId AND `user_id` = :uid AND `lead_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":prefId" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
        ));
        $count = $stm->rowCount();
        if ($count == 0) {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `lead_report` (`id`,`lead_id`,`user_id`,`report_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:prefId,:doc,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":doc" => date("Y-m-d H:i:s"),
                ":stat" => 4,
            ));
        } else {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `lead_report` SET `report_id` = :prefId WHERE `lead_id` = :leadid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["lead_id"] = $this->postBaseData["para"]["leadID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function subscribeBusiness($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        return $jsondata;
    }
    public function addQuotation($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        if ($this->postBaseData["leadID"] > 0) {
            $res1 = '';
            $background = NULL;
            $this->db->beginTransaction();
            if (isset($_SESSION['Individual_POST_PATH']) && is_array($_SESSION['Individual_POST_PATH'])) {
                $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
                if ($photo["status"] === "success") {
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`ver4`,`ver5`)  VALUES(:id,:orgpic,:ver1,:ver2,:ver3,:ver4,:ver5);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":orgpic" => $photo['original_pic'],
                        ":ver1" => $photo['version_1'],
                        ":ver2" => $photo['version_2'],
                        ":ver3" => $photo['version_3'],
                        ":ver4" => $photo['version_4'],
                        ":ver5" => $photo['version_5']
                    ));
                    $background = $this->db->lastInsertId();
                    unset($_SESSION['Individual_POST_PATH']);
                }
            }
            $query1 = 'INSERT INTO  `lead_quotations` (`id`,`lead_id`,`user_id`,`quotation`,`created_at`,`photo_id`,`status_id`) VALUES(:id,:leadid,:uid,:cmt,:doc,:photo,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":leadid" => mysql_real_escape_string($this->postBaseData["leadID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":cmt" => mysql_real_escape_string(urldecode($this->postBaseData["quotation"])),
                ":doc" => date("Y-m-d H:i:s"),
                ":photo" => mysql_real_escape_string($background),
                ":stat" => $jsondata["stat"],
            ));
            if ($res1)
                $this->db->commit();
            else
                $this->db->rollBack();
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LeadQuotationCount($this->postBaseData["leadID"]);
                $jsondata["lead_id"] = $this->postBaseData["leadID"];
            }
        }
        return $jsondata;
    }
    public function approvalLeadQuotation($param = false) {
        $jsondata = array(
            "count" => $this->ApprovalLeadQuotationCount($param),
            "lead_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_quotations_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":leadid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `lead_quotations_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `lead_quotations_approvals` SET `status_id` = :stat, `created_at`:= :doc WHERE `lead_quotations_id` = :leadid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `lead_quotations_approvals` (`id`,`lead_quotations_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->ApprovalLeadQuotationCount($param);
                $jsondata["lead_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disApprovalLeadQuotation($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_quotations_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":leadid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `lead_quotations_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `lead_quotations_approvals` SET `status_id`  = :stat, `created_at`:= :doc WHERE `lead_quotations_id` = :leadid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `lead_quotations_approvals` (`id`,`lead_quotations_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->ApprovalLeadQuotationCount($param);
                $jsondata["lead_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changeLeadQuotationPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_quotations` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `lead_quotations` SET `status_id` = :stat WHERE `id` = :leadid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `lead_quotations` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `lead_quotations_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `lead_quotations_id` = :leadid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `lead_quotations_preferences` (`id`,`lead_quotations_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `lead_quotations_preferences` SET `preferences_id` = :prefId WHERE `lead_quotations_id` = :leadid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["lead_id"] = $this->postBaseData["para"]["leadID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function addQuotationWo($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        if ($this->postBaseData["leadComID"] > 0) {
            $res1 = '';
            $background = NULL;
            $this->db->beginTransaction();
            if (isset($_SESSION['Individual_POST_PATH']) && is_array($_SESSION['Individual_POST_PATH'])) {
                $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
                if ($photo["status"] === "success") {
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`ver4`,`ver5`)  VALUES(:id,:orgpic,:ver1,:ver2,:ver3,:ver4,:ver5);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":orgpic" => $photo['original_pic'],
                        ":ver1" => $photo['version_1'],
                        ":ver2" => $photo['version_2'],
                        ":ver3" => $photo['version_3'],
                        ":ver4" => $photo['version_4'],
                        ":ver5" => $photo['version_5']
                    ));
                    $background = $this->db->lastInsertId();
                    unset($_SESSION['Individual_POST_PATH']);
                }
            }
            $query1 = 'INSERT INTO  `lead_quotations_wo` (`id`,`lead_quotations_id`,`user_id`,`wo`,`created_at`,`photo_id`,`status_id`) VALUES(:id,:leadid,:uid,:wo,:doc,:photo,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":leadid" => mysql_real_escape_string($this->postBaseData["leadComID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":wo" => mysql_real_escape_string(urldecode($this->postBaseData["wo"])),
                ":doc" => date("Y-m-d H:i:s"),
                ":photo" => mysql_real_escape_string($background),
                ":stat" => $jsondata["stat"],
            ));
            if ($res1)
                $this->db->commit();
            else
                $this->db->rollBack();
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LeadQuotationWoCount($this->postBaseData["leadComID"]);
                $jsondata["lead_id"] = $this->postBaseData["leadComID"];
            }
        }
        return $jsondata;
    }
    public function approvalLeadQuotationWo($param = false) {
        $jsondata = array(
            "count" => $this->ApprovalLeadQuotationWoCount($param),
            "lead_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_quotations_wo_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_wo_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":leadid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `lead_quotations_wo_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_wo_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `lead_quotations_wo_approvals` SET `status_id` = :stat, `created_at`:= :doc WHERE `lead_quotations_wo_id` = :leadid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `lead_quotations_wo_approvals` (`id`,`lead_quotations_wo_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->ApprovalLeadQuotationWoCount($param);
                $jsondata["lead_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disApprovalLeadQuotationWo($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_quotations_wo_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_wo_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":leadid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `lead_quotations_wo_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `lead_quotations_wo_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `lead_quotations_wo_approvals` SET `status_id`  = :stat, `created_at`:= :doc WHERE `lead_quotations_wo_id` = :leadid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `lead_quotations_wo_approvals` (`id`,`lead_quotations_wo_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->ApprovalLeadQuotationWoCount($param);
                $jsondata["lead_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changeLeadQuotationWoPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `lead_quotations_wo` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `lead_quotations_wo` SET `status_id` = :stat WHERE `id` = :leadid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `lead_quotations_wo` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `lead_quotations_wo_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `lead_quotations_wo_id` = :leadid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `lead_quotations_wo_preferences` (`id`,`lead_quotations_wo_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `lead_quotations_wo_preferences` SET `preferences_id` = :prefId WHERE `lead_quotations_wo_id` = :leadid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["leadID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["lead_id"] = $this->postBaseData["para"]["leadID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function ApprovalLeadCount($param = false) {
        $query = 'SELECT `id` FROM `lead_approvals` WHERE `status_id` = :stat AND `lead_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":leadid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function ApprovalLeadQuotationCount($param = false) {
        $query = 'SELECT `id` FROM `lead_quotations_approvals` WHERE `status_id` = :stat AND `lead_quotations_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":leadid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function ApprovalLeadQuotationWoCount($param = false) {
        $query = 'SELECT `id` FROM `lead_quotations_wo_approvals` WHERE `status_id` = :stat AND `lead_quotations_wo_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":leadid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function LeadQuotationCount($param = false) {
        $query = 'SELECT `id` FROM `lead_quotations` WHERE `status_id` = :stat AND `lead_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 4,
            ":leadid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function LeadQuotationWoCount($param = false) {
        $query = 'SELECT `id` FROM `lead_quotations_wo` WHERE `status_id` = :stat AND `lead_quotations_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 4,
            ":leadid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
}
?>