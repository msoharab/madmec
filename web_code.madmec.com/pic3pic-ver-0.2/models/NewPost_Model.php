<?php
class NewPost_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function CreateNew_Post() {
        $location = 0;
        $res4 = false;
        $res5 = false;
        $res6 = false;
        if ($this->postBaseData["details"]["target"] == "Country") {
            $location = $this->postBaseData["details"]["continent"];
        } else {
            $location = $this->postBaseData["details"]["target"];
        }
        $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
        $jsondata = array(
            "name" => $this->postBaseData["details"]["name"],
            "target" => $location,
            "continent" => isset($this->postBaseData["details"]["continent"]) ? $this->postBaseData["details"]["continent"] : false,
            "countries" => isset($this->postBaseData["details"]["countries"]) ? (array) $this->postBaseData["details"]["countries"] : false,
            "langauges" => isset($this->postBaseData["details"]["langauges"]) ? (array) $this->postBaseData["details"]["langauges"] : false,
            "sections" => isset($this->postBaseData["details"]["sections"]) ? (array) $this->postBaseData["details"]["sections"] : false,
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
            "error" => (array) $photo["error"],
        );
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
            $query3 = 'INSERT INTO `post`(`title`,`photo_id`,`user_id`,`post_location`,`status_id`,`created_at`)Values('
                    . ':id1,:id2,:id3,:id4,:id5,:id6)';
            $stm = $this->db->prepare($query3);
            $res3 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($jsondata["name"]),
                ":id2" => mysql_real_escape_string($background),
                ":id3" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["id"]),
                ":id4" => mysql_real_escape_string($location),
                ":id5" => mysql_real_escape_string($jsondata["stat"]),
                ":id6" => date("Y-m-d H:i:s")
            ));
            $channel_pk = $this->db->lastInsertId();
            $data = array();
            for ($i = 0; $i < sizeof($jsondata["sections"]); $i++) {
                $data[] = array(
                    "post_id" => $channel_pk,
                    "section_id" => $jsondata["sections"][$i],
                    "created_at" => date("Y-m-d H:i:s")
                );
            }
            $datafields = array("`post_id`", "`section_id`", "`created_at`");
            $question_marks = array();
            $insert_values = array();
            foreach ($data as $d) {
                $question_marks[] = '(' . $this->placeholders('?', sizeof($d)) . ')';
                $insert_values = array_merge($insert_values, array_values($d));
            }
            $query6 = 'INSERT INTO `post_section` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
            $stm = $this->db->prepare($query6);
            $res6 = $stm->execute($insert_values);
            if ($jsondata["target"] > 0) {
                $data = array();
                for ($i = 0; $i < sizeof($jsondata["countries"]); $i++) {
                    $data[] = array(
                        "channel_id" => $channel_pk,
                        "country_id" => $jsondata["countries"][$i],
                        "created_at" => date("Y-m-d H:i:s")
                    );
                }
                $datafields = array("`post_id`", "`country_id`", "`created_at`");
                $question_marks = array();
                $insert_values = array();
                foreach ($data as $d) {
                    $question_marks[] = '(' . $this->placeholders('?', sizeof($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query4 = 'INSERT INTO `post_countries` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query4);
                $res4 = $stm->execute($insert_values);
                $data = array();
                for ($i = 0; $i < sizeof($jsondata["langauges"]); $i++) {
                    $data[] = array(
                        "post_id" => $channel_pk,
                        "languages_id" => $jsondata["langauges"][$i],
                        "created_at" => date("Y-m-d H:i:s")
                    );
                }
                $datafields = array("`post_id`", "`languages_id`", "`created_at`");
                $question_marks = array();
                $insert_values = array();
                foreach ($data as $d) {
                    $question_marks[] = '(' . $this->placeholders('?', sizeof($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query5 = 'INSERT INTO `post_languages` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query5);
                $res5 = $stm->execute($insert_values);
            }
        }
        if ($res1 && $res3 && $res6 && $jsondata["target"] == 0) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["post_id"] = $channel_pk;
        } else if ($res1 && $res3 && $res4 && $res5 && $res6 && $jsondata["target"] > 0) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["post_id"] = $channel_pk;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function ListContinents($listtype = false) {
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `pic3pic_continents` WHERE `status_id` = :stat ORDER BY `continent_name`');
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
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
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
        $stm = $this->db->prepare('SELECT * FROM `pic3pic_countries` WHERE `status_id` = :stat AND `continent_id` IN (' . $in . ') ORDER BY `Country`');
        $res = $stm->execute(array(
            ":stat" => 4,
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
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $in = '';
        if (is_array($this->postBaseData["countries_id"])) {
            $in = implode(',', $this->postBaseData["countries_id"]);
        }
        $stm = $this->db->prepare('SELECT * FROM `pic3pic_languages` WHERE `status_id` = :stat AND `country_id` IN (' . $in . ') ORDER BY `country_id`');
        $res = $stm->execute(array(
            ":stat" => 4,
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
                    $data["html"] .= '<li><input type="checkbox" name="languages_' . $i . '" id="languages_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["Language Name"]) . '</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["Language Name"]) . '</option>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["Language Name"]) . '</option>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function getSectionsNames($listtype = false) {
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'secCheck',
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `sections` WHERE `status_id` = :stat ORDER BY `section_name`');
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
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . $result[$i]["section_name"] . '</option>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function listWallPost() {
        $_SESSION["ListNewPost"] = NULL;
        $stm = $this->db->prepare('/*Post Start*/
                SELECT
                        t1.*,
                        t2.*,
                        t3.*,
                        t4.*,
                        t5.*,
                        t6.*,
                        t7.*,
                        t8.*,
                        t9.*,
                        up.`id` AS posterid,
                        up.`user_name` AS postername
                FROM `post` AS t1
                /*Post Countries*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`post_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                        FROM `post_countries` 	AS t1
                        LEFT JOIN `pic3pic_countries`	AS t2 ON t2.`id` = t1.`country_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t2 ON t2.`post_id` = t1.`id`
                /*Post User*/
                LEFT JOIN `user_profile`   		AS up ON up.`id` = t1.`user_id` 
                /*Post Report*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`post_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                        FROM `post_report` 			AS t1
                        LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                        LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t3 ON t3.`post_id` = t1.`id`
                /*Post Preferences*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`post_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                        FROM `post_preferences` 	AS t1
                        LEFT JOIN `preferences`		AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t4 ON t4.`post_id` = t1.`id`
                /*Post Likes*/
                LEFT JOIN (
                        SELECT 
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`post_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                        FROM `post_likes` 			AS t1
                        LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t5 ON t5.`post_id` = t1.`id`
                /*Post Comments*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                                t1.`post_id`,
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                                GROUP_CONCAT(t1.`comment` SEPARATOR "♥☻☻♥") AS comments, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                                t2.`pcp_id`, t2.`pcp_uid`, t2.`pcp_time`, t2.`pcp_preid`, t2.`pcp_pref`, t2.`pcp_uname`,
                                t3.`lk_pc_id`, t3.`lk_pc_uid`, t3.`lk_pc_time`,  t3.`lk_pc_uname`,
                                GROUP_CONCAT(t4.`pcr_id` SEPARATOR "♥☻☻♥") AS pcr_id, 
                                GROUP_CONCAT(t4.`pcr_uid` SEPARATOR "♥☻☻♥") AS pcr_uid, 
                                GROUP_CONCAT(t4.`reply` SEPARATOR "♥☻☻♥") AS reply, 
                                GROUP_CONCAT(t4.`pcr_time` SEPARATOR "♥☻☻♥") AS pcr_time,  
                                GROUP_CONCAT(t4.`pcrp_id` SEPARATOR "♥☻☻♥") AS pcrp_id, 
                                GROUP_CONCAT(t4.`pcrp_uid` SEPARATOR "♥☻☻♥") AS pcrp_uid, 
                                GROUP_CONCAT(t4.`pcrp_time` SEPARATOR "♥☻☻♥") AS pcrp_time, 
                                GROUP_CONCAT(t4.`pcrp_preid` SEPARATOR "♥☻☻♥") AS pcrp_preid,  
                                GROUP_CONCAT(t4.`pcrp_pref` SEPARATOR "♥☻☻♥") AS pcrp_pref,  
                                GROUP_CONCAT(t4.`pcrp_uname` SEPARATOR "♥☻☻♥") AS pcrp_uname, 
                                GROUP_CONCAT(t4.`lk_rep_id` SEPARATOR "♥☻☻♥") AS lk_rep_id, 
                                GROUP_CONCAT(t4.`lk_replyer_id` SEPARATOR "♥☻☻♥") AS lk_replyer_id, 
                                GROUP_CONCAT(t4.`lk_replytime` SEPARATOR "♥☻☻♥") AS lk_replytime, 
                                GROUP_CONCAT(t4.`lk_replyer_name` SEPARATOR "♥☻☻♥") AS lk_replyer_name, 
                                GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid, 
                                GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph, 
                                GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1, 
                                GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2, 
                                GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,  
                                GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,  
                                GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5, 
                                GROUP_CONCAT(t5.`pc_phid` SEPARATOR "♥☻☻♥") AS pc_phid, 
                                GROUP_CONCAT(t5.`pc_ph` SEPARATOR "♥☻☻♥") AS pc_ph, 
                                GROUP_CONCAT(t5.`pc_pv1` SEPARATOR "♥☻☻♥") AS pc_pv1,  
                                GROUP_CONCAT(t5.`pc_pv2` SEPARATOR "♥☻☻♥") AS pc_pv2, 
                                GROUP_CONCAT(t5.`pc_pv3` SEPARATOR "♥☻☻♥") AS pc_pv3,  
                                GROUP_CONCAT(t5.`pc_pv4` SEPARATOR "♥☻☻♥") AS pc_pv4,  
                                GROUP_CONCAT(t5.`pc_pv5` SEPARATOR "♥☻☻♥") AS pc_pv5, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS  commenter
                        FROM `post_comments` 					AS t1
                        /*Post Comments User*/
                        LEFT JOIN `user_profile` 				AS up ON up.`id` = t1.`user_id` AND up.`status_id` = 4
                        /*Post Comments Preferences*/
                        LEFT JOIN (
                                SELECT
                                        t1.`id` AS pcp_id, t1.`post_comments_id`, t1.`user_id` AS pcp_uid, t1.`created_at` AS pcp_time,
                                        t2.`id` AS pcp_preid, t2.`preferences` AS pcp_pref,
                                        up.`user_name` AS pcp_uname
                                FROM `post_comments_preferences` 	AS t1
                                LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                                LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                                WHERE t1.`status_id` = 4
                                AND t2.`status_id` = 4
                                AND up.`status_id` = 4
                        )AS t2 ON t2.`post_comments_id` = t1.`id`
                        /*Post Comments Likes*/
                    LEFT JOIN (
                                SELECT
                                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_pc_id, 
                                        t1.`post_comments_id`, 
                                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_pc_uid, 
                                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_pc_time,
                                    GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_pc_uname
                                FROM `post_comments_likes` 	AS t1
                                LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                                WHERE t1.`status_id` = 4
                                AND up.`status_id` = 4
                                GROUP BY(t1.`post_comments_id`)
                                ORDER BY(t1.`post_comments_id`)
                        ) AS t3 ON t3.`post_comments_id` = t1.`id`
                        /*Post Comments Reply*/
                    LEFT JOIN (
                                SELECT
                                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                                        t1.`post_comments_id`, 
                                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                                    GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS replyer,
                                        GROUP_CONCAT(t1.`reply` SEPARATOR "♥☻♥") AS reply, 
                                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcr_time,
                                    t2.`pcrp_id`, t2.`pcrp_uid`, t2.`pcrp_time`, t2.`pcrp_preid`, t2.`pcrp_pref`, t2.`pcrp_uname`,
                                    GROUP_CONCAT(t3.`lk_rep_id` SEPARATOR "♥☻♥") AS lk_rep_id, 
                                        GROUP_CONCAT(t3.`lk_replyer_id` SEPARATOR "♥☻♥") AS lk_replyer_id, 
                                        GROUP_CONCAT(t3.`lk_replytime` SEPARATOR "♥☻♥") AS lk_replytime, 
                                        GROUP_CONCAT(t3.`lk_replyer_name` SEPARATOR "♥☻♥") AS lk_replyer_name,
                                        GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻♥") AS pcr_phid, 
                                        GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻♥") AS pcr_ph, 
                                        GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻♥") AS pcr_pv1, 
                                        GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻♥") AS pcr_pv2, 
                                        GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻♥") AS pcr_pv3,  
                                        GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻♥") AS pcr_pv4,  
                                        GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻♥") AS pcr_pv5
                                FROM `post_comments_reply` 						AS t1
                                /*Post Comments Reply User*/
                                LEFT JOIN `user_profile` 						AS up ON up.`id` = t1.`user_id`
                                /*Post Comments Reply Preferences*/
                                LEFT JOIN (
                                        SELECT
                                                t1.`id` AS pcrp_id, 
                                                t1.`post_comments_reply_id`, 
                                                t1.`user_id` AS pcrp_uid, 
                                                t1.`created_at` AS pcrp_time,
                                                t2.`id` AS pcrp_preid, 
                                                t2.`preferences`  AS pcrp_pref,
                                                up.`user_name` AS pcrp_uname
                                        FROM `post_comments_reply_preferences` 	AS t1
                                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                                        WHERE t1.`status_id` = 4
                                        AND t2.`status_id` = 4
                                        AND up.`status_id` = 4
                                ) AS t2 ON t2.`post_comments_reply_id` = t1.`id`
                                /*Post Comments Reply Likes*/
                                LEFT JOIN (
                                        SELECT
                                                t1.`id` AS lk_rep_id, t1.`post_comments_reply_id`, t1.`user_id` AS lk_replyer_id, t1.`created_at` AS lk_replytime,
                                                up.`user_name` AS lk_replyer_name
                                   FROM `post_comments_reply_likes` AS t1
                                   LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                                   WHERE t1.`status_id` = 4
                                ) AS t3 ON t3.`post_comments_reply_id` = t1.`id`
                                /*Post Comments Reply Photo*/
                                LEFT JOIN (
                                        SELECT
                                                `id` AS pcr_phid,
                                                IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"DEFAULT_REPLY_IMG",TRIM(`original_pic`)) AS pcr_ph,
                                                IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver1`)) AS pcr_pv1,
                                                IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver2`)) AS pcr_pv2,
                                                IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver3`)) AS pcr_pv3,
                                                IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver4`)) AS pcr_pv4,
                                                IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver5`)) AS pcr_pv5
                                        FROM `photo`
                                        WHERE `status_id` = 4
                                ) AS t4 ON t4.`pcr_phid` = t1.`photo_id`
                                WHERE t1.`status_id` = 4
                                AND up.`status_id` = 4
                                GROUP BY(t1.`post_comments_id`)
                                ORDER BY(t1.`post_comments_id`)
                    ) AS t4 ON t4.`post_comments_id` = t1.`id`
                        /*Post Comments Photo*/
                        LEFT JOIN (
                                SELECT
                                        `id` AS pc_phid,
                                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"DEFAULT_REPLY_IMG",TRIM(`original_pic`)) AS pc_ph,
                                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver1`)) AS pc_pv1,
                                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver2`)) AS pc_pv2,
                                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver3`)) AS pc_pv3,
                                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver4`)) AS pc_pv4,
                                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver5`)) AS pc_pv5
                                FROM `photo`
                                WHERE `status_id` = 4
                        ) AS t5 ON t5.`pc_phid` = t1.`photo_id`
                    WHERE t1.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t6 ON t6.`post_id` = t1.`id`
                /*Post Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`post_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `post_languages` 	AS t1
                        LEFT JOIN `pic3pic_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t7 ON t7.`post_id` = t1.`id`
                /*Post Sections*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS ps_id, t1.`post_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS ps_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS ps_secid, GROUP_CONCAT(t2.`section_name` SEPARATOR "♥☻☻♥") AS pr_secname
                        FROM `post_section` 	AS t1
                        LEFT JOIN `sections`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t8 ON t8.`post_id` = t1.`id`
                /*Post Photo*/
                LEFT JOIN (
                        SELECT
                                `id` AS p_phid,
                                IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"DEFAULT_REPLY_IMG",TRIM(`original_pic`)) AS p_ph,
                                IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver1`)) AS p_pv1,
                                IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver2`)) AS p_pv2,
                                IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver3`)) AS p_pv3,
                                IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver4`)) AS p_pv4,
                                IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"DEFAULT_REPLY_IMG",TRIM(`ver5`)) AS p_pv5
                        FROM `photo`
                        WHERE `status_id` = 4
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                WHERE t1.`status_id` = 4
                ORDER BY(t1.`id`) DESC
                /*Post Ends*/');
        $res = $stm->execute();
        $newRes = array();
        $delimiters = array("♥☻☻♥", "♥☻♥");
        if ($res) {
            $result = $stm->fetchAll();
            for ($i = 0; $i < $stm->rowCount(); $i++) {
                array_push($newRes, array(
                    "posts" => array(
                        "id" => $result[$i]["id"],
                        "title" => $result[$i]["id"],
                        "photo_id" => $result[$i]["photo_id"],
                        "section_id" => $result[$i]["section_id"],
                        "user_id" => $result[$i]["user_id"],
                        "created_at" => $result[$i]["created_at"],
                        "posterid" => $result[$i]["posterid"],
                        "postername" => $result[$i]["postername"],
                        "photo" => array(
                            "p_phid" => $result[$i]['p_phid'],
                            "p_ph" => $result[$i]['p_ph'],
                            "p_pv1" => $result[$i]['p_pv1'],
                            "p_pv2" => $result[$i]['p_pv2'],
                            "p_pv3" => $result[$i]['p_pv3'],
                            "p_pv4" => $result[$i]['p_pv4'],
                            "p_pv5" => $result[$i]['p_pv5'],
                        ),
                        "post_location" => array(
                            "post_location" => $result[$i]["post_location"],
                            "pcont_id" => (array) explode("♥☻☻♥", $result[$i]['pcont_id']),
                            "pcont_time" => (array) explode("♥☻☻♥", $result[$i]['pcont_time']),
                            "pcont_contid" => (array) explode("♥☻☻♥", $result[$i]['pcont_contid']),
                            "pcont_contname" => (array) explode("♥☻☻♥", $result[$i]['pcont_contname']),
                        ),
                        "report" => array(
                            "pr_uname" => (array) explode("♥☻☻♥", $result[$i]['pr_uname']),
                            "pr_id" => (array) explode("♥☻☻♥", $result[$i]['pr_id']),
                            "pr_uid" => (array) explode("♥☻☻♥", $result[$i]['pr_uid']),
                            "pr_time" => (array) explode("♥☻☻♥", $result[$i]['pr_time']),
                            "pr_repid" => (array) explode("♥☻☻♥", $result[$i]['pr_repid']),
                            "pr_repname" => (array) explode("♥☻☻♥", $result[$i]['pr_repname']),
                        ),
                        "preference" => array(
                            "pp_uname" => (array) explode("♥☻☻♥", $result[$i]['pp_uname']),
                            "pp_id" => (array) explode("♥☻☻♥", $result[$i]['pp_id']),
                            "pp_uid" => (array) explode("♥☻☻♥", $result[$i]['pp_uid']),
                            "pp_time" => (array) explode("♥☻☻♥", $result[$i]['pp_time']),
                            "pp_preid" => (array) explode("♥☻☻♥", $result[$i]['pp_preid']),
                            "pp_pref" => (array) explode("♥☻☻♥", $result[$i]['pp_pref']),
                        ),
                        "likes" => array(
                            "lk_p_uname" => (array) explode("♥☻☻♥", $result[$i]['lk_p_uname']),
                            "lk_p_id" => (array) explode("♥☻☻♥", $result[$i]['lk_p_id']),
                            "lk_p_uid" => (array) explode("♥☻☻♥", $result[$i]['lk_p_uid']),
                            "lk_p_time" => (array) explode("♥☻☻♥", $result[$i]['lk_p_time']),
                        ),
                        "sections" => array(
                            "ps_id" => (array) explode("♥☻☻♥", $result[$i]['ps_id']),
                            "ps_time" => (array) explode("♥☻☻♥", $result[$i]['ps_time']),
                            "ps_secid" => (array) explode("♥☻☻♥", $result[$i]['ps_secid']),
                            "pr_secname" => (array) explode("♥☻☻♥", $result[$i]['pr_secname']),
                        ),
                        "languages" => array(
                            "plng_id" => (array) explode("♥☻☻♥", $result[$i]['plng_id']),
                            "plng_time" => (array) explode("♥☻☻♥", $result[$i]['plng_time']),
                            "plng_lngid" => (array) explode("♥☻☻♥", $result[$i]['plng_lngid']),
                            "plng_lngname" => (array) explode("♥☻☻♥", $result[$i]['plng_lngname']),
                        ),
                        "comments" => array(
                            "pc_id" => (array) explode("♥☻☻♥", $result[$i]['pc_id']),
                            "pc_uid" => (array) explode("♥☻☻♥", $result[$i]['pc_uid']),
                            "commenter" => (array) explode("♥☻☻♥", $result[$i]['commenter']),
                            "comments" => (array) explode("♥☻☻♥", $result[$i]['comments']),
                            "pc_phid" => (array) explode("♥☻☻♥", $result[$i]['pc_phid']),
                            "pc_ph" => (array) explode("♥☻☻♥", $result[$i]['pc_ph']),
                            "pc_pv1" => (array) explode("♥☻☻♥", $result[$i]['pc_pv1']),
                            "pc_pv2" => (array) explode("♥☻☻♥", $result[$i]['pc_pv2']),
                            "pc_pv3" => (array) explode("♥☻☻♥", $result[$i]['pc_pv3']),
                            "pc_pv4" => (array) explode("♥☻☻♥", $result[$i]['pc_pv4']),
                            "pc_pv5" => (array) explode("♥☻☻♥", $result[$i]['pc_pv5']),
                            "pc_time" => (array) explode("♥☻☻♥", $result[$i]['pc_time']),
                            "pcp_id" => (array) explode("♥☻☻♥", $result[$i]['pcp_id']),
                            "pcp_uid" => (array) explode("♥☻☻♥", $result[$i]['pcp_uid']),
                            "pcp_time" => (array) explode("♥☻☻♥", $result[$i]['pcp_time']),
                            "pcp_preid" => (array) explode("♥☻☻♥", $result[$i]['pcp_preid']),
                            "pcp_pref" => (array) explode("♥☻☻♥", $result[$i]['pcp_pref']),
                            "pcp_uname" => (array) explode("♥☻☻♥", $result[$i]['pcp_uname']),
                            "lk_pc_id" => (array) explode("♥☻☻♥", $result[$i]['lk_pc_id']),
                            "lk_pc_uid" => (array) explode("♥☻☻♥", $result[$i]['lk_pc_uid']),
                            "lk_pc_time" => (array) explode("♥☻☻♥", $result[$i]['lk_pc_time']),
                            "lk_pc_uname" => (array) explode("♥☻☻♥", $result[$i]['lk_pc_uname']),
                            "replys" => array(
                                "pcr_id" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_id']),
                                "pcr_uid" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_uid']),
                                "reply" => (array) $this->multiExplode($delimiters, $result[$i]['reply']),
                                "pcr_time" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_time']),
                                "pcrp_id" => (array) $this->multiExplode($delimiters, $result[$i]['pcrp_id']),
                                "pcrp_uid" => (array) $this->multiExplode($delimiters, $result[$i]['pcrp_uid']),
                                "pcrp_time" => (array) $this->multiExplode($delimiters, $result[$i]['pcrp_time']),
                                "pcrp_preid" => (array) $this->multiExplode($delimiters, $result[$i]['pcrp_preid']),
                                "pcrp_pref" => (array) $this->multiExplode($delimiters, $result[$i]['pcrp_pref']),
                                "pcrp_uname" => (array) $this->multiExplode($delimiters, $result[$i]['pcrp_uname']),
                                "lk_rep_id" => (array) $this->multiExplode($delimiters, $result[$i]['lk_rep_id']),
                                "lk_replyer_id" => (array) $this->multiExplode($delimiters, $result[$i]['lk_replyer_id']),
                                "lk_replytime" => (array) $this->multiExplode($delimiters, $result[$i]['lk_replytime']),
                                "lk_replyer_name" => (array) $this->multiExplode($delimiters, $result[$i]['lk_replyer_name']),
                                "pcr_phid" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_phid']),
                                "pcr_ph" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_ph']),
                                "pcr_pv1" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_pv1']),
                                "pcr_pv2" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_pv2']),
                                "pcr_pv3" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_pv3']),
                                "pcr_pv4" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_pv4']),
                                "pcr_pv5" => (array) $this->multiExplode($delimiters, $result[$i]['pcr_pv5']),
                            ),
                        ),
                    )
                ));
            }
            $data["count"] = $stm->rowCount();
            $data["status"] = "success";
        }
        if (sizeof($newRes) > 0) {
            $_SESSION["ListNewPost"] = $newRes;
        }
    }
}
?>