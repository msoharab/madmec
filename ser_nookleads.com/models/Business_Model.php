<?php
class Business_Model extends BaseModel {
    public $BusinessDetails, $BusinessId, $BusinessSize;
    public $UserId;
    private $dir;
    function __construct() {
        parent::__construct();
        $this->UserId = (integer) isset($_SESSION["USERDATA"]["logindata"]["id"]) ?
                $_SESSION["USERDATA"]["logindata"]["id"] :
                0;
        $this->dir = $this->config["DOC_ROOT"] . $_SESSION["USERDATA"]["logindata"]["directory"];
        $this->BusinessSize = 0 . 'Bytes';
    }
    public function CreateBusiness() {
        $location = 0;
        $res4 = false;
        $res5 = false;
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
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT COUNT(`user_id`) FROM `business` WHERE `user_id`= :user_id AND `status_id`= :status_id');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($this->UserId),
            ":status_id" => mysql_real_escape_string($jsondata["stat"])
        ));
        $count = $stm->rowCount();
        if ($count > $this->config["CHN_CNT_LMT"]) {
            $jsondata["status"] = "Your quota is finished.";
        } else {
            $this->db->beginTransaction();
            /*
              $query1 = 'INSERT INTO  `photo` (`id`)  VALUES(:id);';
              $stm = $this->db->prepare($query1);
              $res1 = $stm->execute(array(
              ":id" => NULL
              ));
              $icon = $this->db->lastInsertId();
              $query2 = 'INSERT INTO  `photo` (`id`)  VALUES(:id);';
              $stm = $this->db->prepare($query2);
              $res2 = $stm->execute(array(
              ":id" => NULL
              ));
              $background = $this->db->lastInsertId();
              $query3 = 'INSERT INTO `business`(`user_id`,`business_name`,`business_location`,`business_icon`,`business_background`,`status_id`,`business_created_at`)Values('
              . ':id1,:id2,:id3,:id4,:id5,:id6,NOW())';
             */
            $query3 = 'INSERT INTO `business`(`user_id`,
                `business_name`,
                `business_location`,
                `status_id`,
                `business_created_at`)Values('
                    . ':id1,:id2,:id3,:id6,:now)';
            $stm = $this->db->prepare($query3);
            $res3 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($this->UserId),
                ":id2" => mysql_real_escape_string(trim($jsondata["name"])),
                ":id3" => mysql_real_escape_string($location),
                //":id4" => mysql_real_escape_string($icon),
                //":id5" => mysql_real_escape_string($background),
                ":id6" => mysql_real_escape_string($jsondata["stat"]),
                ":now" => mysql_real_escape_string(date("Y-m-d H:i:s")),
            ));
            $business_pk = $this->db->lastInsertId();
            $dirname1 = $this->dir . '/business_' . $business_pk;
            $this->createDirectory($dirname1);
            $directory = $this->getUserDirectory($this->UserId);
            $dirname2 = $directory . '/business_' . $business_pk;
            //$directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $business_pk);
            $query3 = 'UPDATE `business` SET `business_directory` = :id1 WHERE `id`=:id2';
            $stm = $this->db->prepare($query3);
            $res6 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($dirname2),
                ":id2" => $business_pk
            ));
            if ($jsondata["target"] > 0) {
                $data = array();
                for ($i = 0; $i < count($jsondata["countries"]); $i++) {
                    $data[] = array(
                        "business_id" => $business_pk,
                        "country_id" => $jsondata["countries"][$i],
                        "created_at" => date("Y-m-d H:i:s")
                    );
                }
                $datafields = array("`business_id`", "`country_id`", "`created_at`");
                $question_marks = array();
                $insert_values = array();
                foreach ($data as $d) {
                    $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query4 = 'INSERT INTO `business_countries` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query4);
                $res4 = $stm->execute($insert_values);
                $data = array();
                for ($i = 0; $i < count($jsondata["langauges"]); $i++) {
                    $data[] = array(
                        "business_id" => $business_pk,
                        "country_id" => $jsondata["langauges"][$i],
                        "created_at" => date("Y-m-d H:i:s")
                    );
                }
                $datafields = array("`business_id`", "`languages_id`", "`created_at`");
                $question_marks = array();
                $insert_values = array();
                foreach ($data as $d) {
                    $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query5 = 'INSERT INTO `business_languages` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query5);
                $res5 = $stm->execute($insert_values);
            }
            //if ($res1 && $res2 && $res3 && $jsondata["target"] == 0) {
            if ($res3 && $jsondata["target"] == 0 && $res6) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["business_id"] = $business_pk;
                //} else if ($res1 && $res2 && $res3 && $res4 && $res5 && $jsondata["target"] > 0) {
            } else if ($res3 && $res4 && $res5 && $res6 && $jsondata["target"] > 0) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["business_id"] = $business_pk;
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function CreateNew_Lead() {
        $location = 0;
        $res4 = false;
        $res5 = false;
        $res6 = false;
        $res7 = false;
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
            "businessID" => isset($this->postBaseData["details"]["businessID"]) ? (integer) $this->postBaseData["details"]["businessID"] : false,
            "lead_id" => 0,
            "stat" => 4,
            "status" => 'error',
            "error" => '',
        );
        $dir = $this->config["DOC_ROOT"] . $this->getBusinessDirectory($jsondata["businessID"]);
        $size = $this->folderSize($dir);
        if ($size["size"] <= $this->config["CHN_CNT_SIZ"]) {
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
                    if ($jsondata["businessID"] > 0) {
                        $query7 = 'INSERT INTO `business_deal` (`business_id`, `user_id`, `lead_id`, `created_at`)
                        VALUES (:id1,:id2,:id3,:id4)';
                        $stm = $this->db->prepare($query7);
                        $res7 = $stm->execute(array(
                            ":id1" => mysql_real_escape_string($jsondata["businessID"]),
                            ":id2" => mysql_real_escape_string($this->UserId),
                            ":id3" => mysql_real_escape_string($business_pk),
                            ":id4" => date("Y-m-d H:i:s")
                        ));
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
        }
        return $jsondata;
    }
    public function ListBusinesses() {
        $list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $create = (array) $this->idHolders["nookleads"]["business"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `business` WHERE `user_id`= :user_id AND `status_id`= :status_id ORDER BY `business_created_at` DESC');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($this->UserId),
            ":status_id" => mysql_real_escape_string($data["stat"])
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0; $i < $data["count"]; $i++) {
            $data["html"] .= '<a class="list-group-item"  id="' . $list["item"] . '_' . $i . '" href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["id"]) . '"><i class="fa fa-tv fa-fw"></i>&nbsp;' . $result[$i]["business_name"] . '</a>';
        }
        if ($data["count"] < $this->config["CHN_CNT_LMT"]) {
            $data["html"] .= '<button type="button" data-toggle="modal" data-target="#' . $create["create"]["parentDiv"] . '" data-whatever="@mdo" class="list-group-item btn btn-block btn-default" id="' . $create["moodalBut"] . '">Create Business</button>';
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function ListAdminBusinesses() {
        $list = (array) $this->idHolders["nookleads"]["business"]["listAdminBusinesses"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT
                                    t1.*
                                FROM `business` AS t1
                                INNER JOIN `business_roles` AS t2 ON t2.`business_id` = t1.`id`
                                WHERE t2.`user_id`= :user_id
                                AND t1.`status_id`= :status_id1
                                AND t2.`status_id`= :status_id2
                                ORDER BY `business_created_at` DESC');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($this->UserId),
            ":status_id1" => mysql_real_escape_string($data["stat"]),
            ":status_id2" => mysql_real_escape_string($data["stat"])
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0; $i < $data["count"]; $i++) {
            $data["html"] .= '<a class="list-group-item"  id="' . $list["item"] . '_' . $i . '" href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["id"]) . '"><i class="fa fa-tv fa-fw"></i>&nbsp;' . $result[$i]["business_name"] . '</a>';
        }
        return $data;
    }
    public function ListSubscribeBusinesses() {
        $list = (array) $this->idHolders["nookleads"]["business"]["listSubscribeBusinesses"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT
                                    t1.*
                                FROM `business` AS t1
                                INNER JOIN `business_subscribe` AS t2 ON t2.`business_id` = t1.`id`
                                WHERE t2.`user_id`= :user_id
                                AND t1.`status_id`= :status_id1
                                AND t2.`status_id`= :status_id2
                                ORDER BY `business_created_at` DESC');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($this->UserId),
            ":status_id1" => mysql_real_escape_string($data["stat"]),
            ":status_id2" => mysql_real_escape_string($data["stat"])
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0; $i < $data["count"]; $i++) {
            $data["html"] .= '<a class="list-group-item"  id="' . $list["item"] . '_' . $i . '" href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["id"]) . '"><i class="fa fa-tv fa-fw"></i>&nbsp;' . $result[$i]["business_name"] . '</a>';
        }
        return $data;
    }
    public function ListContinents($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'continentsCh_',
            "class" => 'contiSelCh',
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
                    $data["html"] .= '<li><input type="checkbox" name="continentsCh_" class="contiSelCh" id="continentsCh_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst(trim($result[$i]["continent_name"])) . '</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="radio" class="contiSelCh" name="continentsCh_" id="continentsCh_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst(trim($result[$i]["continent_name"])) . '</li><li class="divider">&nbsp;</li>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst(trim($result[$i]["continent_name"])) . '</option>';
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
            "id" => 'countriesCh_',
            "class" => 'contrSelCh',
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
                    $data["html"] .= '<li><input type="checkbox" name="countriesCh_" class="contrSelCh" id="countriesCh_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst(trim($result[$i]["Country"])) . '</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="radio" class="contrSelCh" name="countriesCh_" id="countriesCh_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst(trim($result[$i]["Country"])) . '</li><li class="divider">&nbsp;</li>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst(trim($result[$i]["Country"])) . '</option>';
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
    public function filterListLead() {
        $_SESSION["ListNewLead"] = NULL;
        $languages = '""';
        $countries = '""';
        $sections = '""';
        if (isset($this->postBaseData["action"]) && $this->postBaseData["action"] == "filterListLead") {
            if (isset($this->postBaseData["details"]["target"]) && $this->postBaseData["details"]["target"] === 'Country') {
                if (isset($this->postBaseData["details"]["countries"]) && is_array($this->postBaseData["details"]["countries"]) && count($this->postBaseData["details"]["countries"]) > 0) {
                    $countries = implode(",", array_values($this->postBaseData["details"]["countries"]));
                }
                if (isset($this->postBaseData["details"]["languages"]) && is_array($this->postBaseData["details"]["languages"]) && count($this->postBaseData["details"]["languages"]) > 0) {
                    $languages = implode(",", array_values($this->postBaseData["details"]["languages"]));
                }
            }
            if (isset($this->postBaseData["details"]["sections"]) && is_array($this->postBaseData["details"]["sections"]) && count($this->postBaseData["details"]["sections"]) > 0) {
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
                    OR t2.`id` IN (' . $countries . ')
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
                        OR t2.`id` IN (' . $languages . ')
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
                        LEFT JOIN `sections_business_lead`	AS t2 ON t2.`id` = t1.`section_id`
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
                        LEFT JOIN `sections_business_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        OR t2.`id` IN (' . $sections . ')
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
                        t2.`business_website`,
                        t2.`status_id` AS business_status_id
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    AND t1.`business_id` = "' . mysql_real_escape_string($this->BusinessId) . '"
                    AND t1.`status_id` = 4
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
                ) AS t11 ON t11.`chsubcid` = t10.`chwacid`
                WHERE t1.`status_id` = 4
                AND t10.`chwacid` = "' . mysql_real_escape_string($this->BusinessId) . '"
                AND t10.`business_status_id` = 4
                AND (
                    t1.`id` IN (SELECT `lead_id` FROM `lead_countries` WHERE `country_id` IN (' . $countries . ') AND `status_id` = 4)
                    OR
                    t1.`id` IN (SELECT `lead_id` FROM `lead_languages` WHERE `languages_id` IN (' . $languages . ') AND `status_id` = 4)
                    OR
                    t1.`id` IN (SELECT `lead_id` FROM `lead_section` WHERE `section_id` IN (' . $sections . ') AND `status_id` = 4)
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
                        LEFT JOIN `sections_business_lead`	AS t2 ON t2.`id` = t1.`section_id`
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
                        t2.`business_website`,
                        t2.`status_id` AS business_status_id
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    AND t1.`business_id` = "' . mysql_real_escape_string($this->BusinessId) . '"
                    AND t1.`status_id` = 4
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
                ) AS t11 ON t11.`chsubcid` = t10.`chwacid`
                WHERE t1.`status_id` = 4
                AND t10.`chwacid` = "' . mysql_real_escape_string($this->BusinessId) . '"
                AND t10.`business_status_id` = 4
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
            ":stat" => $jsondata["stat"],
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
        } else
            $this->db->rollBack();
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
    public function getBusinessDetails($businessid = false) {
        $_SESSION["BusinessDetails"] = NULL;
        $stm = $this->db->prepare('/* Business */
                SELECT
                    t10.`id` AS  chid,
                    t10.`user_id` AS chuid,
                    t10.`business_name`,
                    t10.`business_description`,
                    t10.`business_location`,
                    t10.`business_language`,
                    IF(t10.`business_icon` IS NOT NULL OR t10.`business_icon` != NULL,   (SELECT
                            CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                            THEN "' . $this->config["DEFAULT_CHANEL_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver1`)
                            END AS pic
                        FROM `photo` AS ph1
                        WHERE t10.`business_icon` = ph1.`id`), "' . $this->config["DEFAULT_CHANEL_ICON_IMG"] . '"
                    ) AS business_icon,
                    IF(t10.`business_background` IS NOT NULL OR t10.`business_background` != NULL, (SELECT
                            CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                            THEN "' . $this->config["DEFAULT_CHANEL_BACK_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver1`)
                            END AS pic
                        FROM `photo` AS ph1
                        WHERE t10.`business_background` = ph1.`id`), "' . $this->config["DEFAULT_CHANEL_BACK_IMG"] . '"
                    ) AS business_background,
                    t10.`business_created_at`,
                    t10.`business_updated_at`,
                    t10.`business_website`,
                    t10.`business_facebook`,
                    t10.`business_googleplus`,
                    t10.`business_twitter`,
                    t11.*,
                    t12.*,
                    t13.*,
                    t14.*,
                    t15.*,
                    t16.*,
                    t17.*,
                    t18.*,
                    t19.*
                FROM  `business` AS t10
                LEFT JOIN `user_profile` AS up ON up.`id` = t10.`user_id`
                /* Business Subscribers */
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS chsub_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥")  AS chsubid,
                        t1.`business_id` AS chsubcid,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥")  AS chsubuid,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥")  AS chsubtime,
                        GROUP_CONCAT(up.`subscriberid` SEPARATOR "♥☻☻♥")  AS subscriberid,
                        GROUP_CONCAT(up.`subscribername` SEPARATOR "♥☻☻♥")  AS subscribername,
                        GROUP_CONCAT(up.`subscriberemail` SEPARATOR "♥☻☻♥")  AS subscriberemail,
                        GROUP_CONCAT(up.`subscribercell` SEPARATOR "♥☻☻♥")  AS subscribercell,
                        GROUP_CONCAT(up.`subscriberpic` SEPARATOR "♥☻☻♥")  AS subscriberpic
                    FROM `business_subscribe` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    INNER JOIN (
                        SELECT
                            ad.`id` AS subscriberid,
                            ad.`user_name` AS subscribername,
                            ad.`email` AS subscriberemail,
                            ad.`cell_number` AS subscribercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS subscriberpic,
                            ad.`status_id`
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`subscriberid` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`business_id`)
                ) AS t11 ON t11.`chsubcid` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                /* Business Admins */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥")  AS chadmid,
                        t1.`business_id` AS chadmcid,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥")  AS chadmuid,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥")  AS chadmtime,
                        GROUP_CONCAT(up.`adminid` SEPARATOR "♥☻☻♥")  AS adminid,
                        GROUP_CONCAT(up.`adminname` SEPARATOR "♥☻☻♥")  AS adminname,
                        GROUP_CONCAT(up.`adminemail` SEPARATOR "♥☻☻♥")  AS adminemail,
                        GROUP_CONCAT(up.`admincell` SEPARATOR "♥☻☻♥")  AS admincell,
                        GROUP_CONCAT(up.`adminpic` SEPARATOR "♥☻☻♥")  AS adminpic
                    FROM `business_roles` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id` AND t2.`id` = "' . mysql_real_escape_string($businessid) . '"
                    INNER JOIN (
                        SELECT
                            ad.`id` AS adminid,
                            ad.`user_name` AS adminname,
                            ad.`email` AS adminemail,
                            ad.`cell_number` AS admincell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS adminpic,
                            ad.`status_id`
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`adminid` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`business_id`)
                ) AS t12 ON t12.`chadmcid` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                /* Business Messages */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥")  AS chmsgid,
                        t1.`business_id` AS chmsgcid,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥")  AS chmsguid,
                        GROUP_CONCAT(TRIM(t1.`message`) SEPARATOR "♥☻☻♥")  AS message,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥")  AS chmsgtime,
                        GROUP_CONCAT(up.`msginid` SEPARATOR "♥☻☻♥")  AS msginid,
                        GROUP_CONCAT(up.`msginname` SEPARATOR "♥☻☻♥")  AS msginname,
                        GROUP_CONCAT(up.`msginemail` SEPARATOR "♥☻☻♥")  AS msginemail,
                        GROUP_CONCAT(up.`msgincell` SEPARATOR "♥☻☻♥")  AS msgincell,
                        GROUP_CONCAT(up.`msginpic` SEPARATOR "♥☻☻♥")  AS msginpic
                    FROM `business_messages` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id` AND t2.`id` = "' . mysql_real_escape_string($businessid) . '"
                    INNER JOIN (
                        SELECT
                            ad.`id` AS msginid,
                            ad.`user_name` AS msginname,
                            ad.`email` AS msginemail,
                            ad.`cell_number` AS msgincell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS msginpic,
                            ad.`status_id`
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`msginid` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`business_id`)
                ) AS t13 ON t13.`chmsgcid` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                /* Business Countries */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chcont_id, t1.`business_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS chcont_contname
                    FROM `business_countries` 	AS t1
                    LEFT JOIN `nookleads_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4 AND t1.`business_id` = "' . mysql_real_escape_string($businessid) . '"
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`business_id`)
                    ORDER BY(t1.`business_id`)
                ) AS t14 ON t14.`business_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                /* Business Report */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chrep_id, t1.`business_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS chrep_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chrep_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chrep_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS chrep_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS chrep_uname
                    FROM `business_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4 AND t1.`business_id` = "' . mysql_real_escape_string($businessid) . '"
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`business_id`)
                    ORDER BY(t1.`business_id`)
                ) AS t15 ON t15.`business_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                /* Business Languages */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chlng_id, t1.`business_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chlng_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chlng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS chlng_lngname
                    FROM `business_languages` 	AS t1
                    LEFT JOIN `nookleads_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                    WHERE t1.`status_id` = 4 AND t1.`business_id` = "' . mysql_real_escape_string($businessid) . '"
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`business_id`)
                    ORDER BY(t1.`business_id`)
                ) AS t16 ON t16.`business_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                /*Business Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_ch_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_ch_id, t1.`business_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_ch_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_ch_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_ch_uname
                    FROM `business_approvals` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`business_id`)
                    ORDER BY(t1.`business_id`)
                ) AS t17 ON t17.`business_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                LEFT JOIN (
                    SELECT
                        ad.`id` AS chownid,
                        ad.`user_name` AS chownname,
                        ad.`email` AS chownemail,
                        ad.`cell_number` AS chowncell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS chownpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                )AS t18 ON t18.`chownid` = t10.`user_id`
                /* Business Advertise */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chadd_id, 
                        t1.`business_id`, 
                        GROUP_CONCAT(IF(t1.`advertise` IS NOT NULL OR t1.`advertise` != NULL,   (SELECT
                                CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                                THEN "' . $this->config["DEFAULT_CHANEL_ADV_IMG"] . '"
                                ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver1`)
                                END AS pic
                            FROM `photo` AS ph1
                            WHERE t1.`advertise` = ph1.`id`), "' . $this->config["DEFAULT_CHANEL_ADV_IMG"] . '"
                        ) SEPARATOR "♥☻☻♥") AS chadd_img
                    FROM `business_advertise` 	AS t1
                    WHERE t1.`status_id` = 4 AND t1.`business_id` = "' . mysql_real_escape_string($businessid) . '"
                    GROUP BY(t1.`business_id`)
                    ORDER BY(t1.`business_id`)
                ) AS t19 ON t19.`business_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                WHERE t10.`status_id` = 4
                AND up.`status_id` = 4
                AND t10.`id` = "' . mysql_real_escape_string($businessid) . '"
                /* Business Ends */
                ');
        $res = $stm->execute();
        $dir = $this->config["DOC_ROOT"] . $this->getBusinessDirectory($businessid);
        $val = $this->folderSize($dir);
        $newRes = array(
            "business" => array(),
            "business_size" => $val["size"] ." - ". $val["unit"],
            "chsub" => array(),
            "chadm" => array(),
            "chmsg" => array(),
            "chcont" => array(),
            "chrep" => array(),
            "chlng" => array(),
            "lk_ch" => array(),
            "chadd" => array(),
        );
        $delimiters = array("♥☻☻♥", "♥☻♥");
        $delimiters1 = array("♥☻☻♥", "♥☻♥", "♥♥");
        if ($res) {
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            //echo print_r($result).'<hr />';
            //echo $stm->rowCount().'<hr />';
            if ($stm->rowCount() > 0) {
                /* Business */
                $newRes["business"] = array(
                    "chid" => (integer) $result["chid"],
                    "chuid" => (integer) $result["chuid"],
                    "business_name" => ucfirst($result["business_name"]),
                    "business_description" => $result["business_description"],
                    "business_location" => (integer) $result["business_location"],
                    "business_language" => (integer) $result["business_language"],
                    "business_icon" => $result["business_icon"],
                    "business_background" => $result["business_background"],
                    "business_created_at" => $result["business_created_at"],
                    "business_website" => $result["business_website"],
                    "business_facebook" => $result["business_facebook"],
                    "business_googleplus" => $result["business_googleplus"],
                    "business_twitter" => $result["business_twitter"],
                    "lk_ch_ct" => (integer) $result["lk_ch_ct"],
                    "chsub_ct" => (integer) $result["chsub_ct"],
                    /* Business Owner */
                    "chownid" => (integer) $result["chownid"],
                    "chownname" => ucfirst($result["chownname"]),
                    "chownemail" => $result["chownemail"],
                    "chowncell" => $result["chowncell"],
                    "chownpic" => $result["chownpic"],
                );
                /* Business Subscriber */
                $newRes["chsub"] = array(
                    "chsubid" => explode("♥☻☻♥", $result['chsubid']),
                    "chsubcid" => explode("♥☻☻♥", $result['chsubcid']),
                    "chsubuid" => explode("♥☻☻♥", $result['chsubuid']),
                    "chsubtime" => explode("♥☻☻♥", $result['chsubtime']),
                    "subscriberid" => explode("♥☻☻♥", $result['subscriberid']),
                    "subscribername" => explode("♥☻☻♥", $result['subscribername']),
                    "subscriberemail" => explode("♥☻☻♥", $result['subscriberemail']),
                    "subscribercell" => explode("♥☻☻♥", $result['subscribercell']),
                    "subscriberpic" => explode("♥☻☻♥", $result['subscriberpic']),
                );
                /* Business Admins */
                $newRes["chadm"] = array(
                    "chadmid" => explode("♥☻☻♥", $result['chadmid']),
                    "chadmcid" => explode("♥☻☻♥", $result['chadmcid']),
                    "chadmuid" => explode("♥☻☻♥", $result['chadmuid']),
                    "chadmtime" => explode("♥☻☻♥", $result['chadmtime']),
                    "adminid" => explode("♥☻☻♥", $result['adminid']),
                    "adminname" => explode("♥☻☻♥", $result['adminname']),
                    "adminemail" => explode("♥☻☻♥", $result['adminemail']),
                    "admincell" => explode("♥☻☻♥", $result['admincell']),
                    "adminpic" => explode("♥☻☻♥", $result['adminpic']),
                );
                /* Business Messages */
                $newRes["chmsg"] = array(
                    "chmsgid" => explode("♥☻☻♥", $result['chmsgid']),
                    "chmsgcid" => explode("♥☻☻♥", $result['chmsgcid']),
                    "chmsguid" => explode("♥☻☻♥", $result['chmsguid']),
                    "message" => explode("♥☻☻♥", $result['message']),
                    "chmsgtime" => explode("♥☻☻♥", $result['chmsgtime']),
                    "msginid" => explode("♥☻☻♥", $result['msginid']),
                    "msginname" => explode("♥☻☻♥", $result['msginname']),
                    "msginemail" => explode("♥☻☻♥", $result['msginemail']),
                    "msgincell" => explode("♥☻☻♥", $result['msgincell']),
                    "msginpic" => explode("♥☻☻♥", $result['msginpic']),
                );
                /* Business Countries */
                $newRes["chcont"] = array(
                    "chcont_id" => explode("♥☻☻♥", $result['chcont_id']),
                    "chcont_time" => explode("♥☻☻♥", $result['chcont_time']),
                    "chcont_contid" => explode("♥☻☻♥", $result['chcont_contid']),
                    "chcont_contname" => explode("♥☻☻♥", $result['chcont_contname']),
                );
                /* Business Report */
                $newRes["chrep"] = array(
                    "chrep_id" => explode("♥☻☻♥", $result['chrep_id']),
                    "chrep_uid" => explode("♥☻☻♥", $result['chrep_uid']),
                    "chrep_uname" => explode("♥☻☻♥", $result['chrep_uname']),
                    "chrep_repid" => explode("♥☻☻♥", $result['chrep_repid']),
                    "chrep_repname" => explode("♥☻☻♥", $result['chrep_repname']),
                    "chrep_time" => explode("♥☻☻♥", $result['chrep_time']),
                );
                /* Business Languages */
                $newRes["chlng"] = array(
                    "chlng_id" => explode("♥☻☻♥", $result['chlng_id']),
                    "chlng_lngid" => explode("♥☻☻♥", $result['chlng_lngid']),
                    "chlng_lngname" => explode("♥☻☻♥", $result['chlng_lngname']),
                    "chlng_time" => explode("♥☻☻♥", $result['chlng_time']),
                );
                /* Business Approvals */
                $newRes["lk_ch"] = array(
                    "lk_ch_id" => explode("♥☻☻♥", $result['lk_ch_id']),
                    "lk_ch_uid" => explode("♥☻☻♥", $result['lk_ch_uid']),
                    "lk_ch_uname" => explode("♥☻☻♥", $result['lk_ch_uname']),
                    "lk_ch_time" => explode("♥☻☻♥", $result['lk_ch_time']),
                );
                /* Business Advertisement */
                $newRes["chadd"] = array(
                    "chadd_id" => explode("♥☻☻♥", $result['chadd_id']),
                    "chadd_img" => explode("♥☻☻♥", $result['chadd_img']),
                );
            }
            $data["count"] = $stm->rowCount();
            $data["status"] = "success";
        }
        if (count($newRes) > 0) {
            $_SESSION["BusinessDetails"] = $newRes;
        }
        //echo print_r($newRes);
        return $newRes;
    }
    public function getSectionsNames($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'secCheck',
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `sections_business_lead` WHERE `status_id` = :stat ORDER BY `section_name`');
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
    public function ListUsers($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "loading" => true,
            "total_count" => 0,
            "incomplete_results" => false,
            "items" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'usrCheck',
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT
            ad.`id` AS pk,
            ad.`user_name` AS name,
            ad.`email` AS email,
            CONCAT(ad.`cell_code`," - ",ad.`cell_number`) AS cell,
            CASE WHEN (ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` = NULL OR ph1.`ver3` IS NULL OR ph1.`ver3` = "")
            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS photos,
            (SELECT COUNT(`id`) FROM `business` AS t1 WHERE ad.`id` = t1.`user_id` AND t1.`status_id` = 4) AS ch_count,
            (SELECT COUNT(`id`) FROM `lead` AS t2 WHERE ad.`id` = t2.`user_id` AND t2.`status_id` = 4) AS p_count,
            (SELECT COUNT(`id`) FROM `lead_quotations` AS t3 WHERE ad.`id` = t3.`user_id` AND t3.`status_id` = 4) AS pc_count,
            (SELECT COUNT(`id`) FROM `lead_quotations_wo` AS t4 WHERE ad.`id` = t4.`user_id` AND t4.`status_id` = 4) AS pcr_count
        FROM `user_profile` AS ad
        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
        WHERE (ad.`user_name` LIKE "%' . $this->postBaseData["q"] . '%"
        OR ad.`email` LIKE "%' . $this->postBaseData["q"] . '%"
        OR ad.`cell_number` LIKE "%' . $this->postBaseData["q"] . '%")
        AND ad.`id` NOT IN (SELECT `user_id` FROM `business_roles` WHERE `business_id` = "' . $this->BusinessId . '" AND `status_id` = 4)
        AND ad.`id` != "' . $this->UserId . '"
        AND ad.`status_id` = 4;');
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["total_count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0, $j = 0; $i < $data["count"] && $result[$i]["name"]; $i++) {
            $result[$i]["ch_count"] = $result[$i]["ch_count"] ? (integer) $result[$i]["ch_count"] : 0;
            $result[$i]["p_count"] = $result[$i]["p_count"] ? (integer) $result[$i]["p_count"] : 0;
            $result[$i]["pc_count"] = $result[$i]["pc_count"] ? (integer) $result[$i]["pc_count"] : 0;
            $result[$i]["pcr_count"] = $result[$i]["ch_count"] ? (integer) $result[$i]["pcr_count"] : 0;
            array_push($data["items"], array(
                "index" => ($i + 1),
                "text" => $result[$i]["name"],
                "id" => (integer) $result[$i]["pk"],
                "name" => $result[$i]["name"],
                "avatar_url" => $result[$i]["photos"],
                "email" => $result[$i]["email"],
                "cell" => $result[$i]["cell"],
                "ch_count" => (integer) $result[$i]["ch_count"],
                "p_count" => (integer) $result[$i]["p_count"],
                "pc_count" => (integer) $result[$i]["pc_count"],
                "pcr_count" => (integer) $result[$i]["pcr_count"],
            ));
        }
        return $data;
    }
    public function searchBusinesses($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "loading" => true,
            "total_count" => 0,
            "incomplete_results" => false,
            "items" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'usrCheck',
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT
            t1.`id` AS pk,
            t1.`business_name` AS name,
            t1.`business_description` AS ch_des,
            CASE WHEN (t1.`business_icon` IS NULL OR t1.`business_icon`  = "" OR ph1.`ver3` = NULL OR ph1.`ver3` IS NULL OR ph1.`ver3` = "")
            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS photos,
            (SELECT COUNT(`id`) FROM `business_approvals` AS t2 WHERE t1.`id` = t2.`business_id` AND t2.`status_id` = 4) AS ch_count,
            (SELECT COUNT(`id`) FROM `business_roles` AS t3  WHERE t1.`id` = t3.`business_id` AND t3.`status_id` = 4) AS chr_count,
            (SELECT COUNT(`id`) FROM `business_subscribe` AS t4  WHERE t1.`id` = t4.`business_id` AND t4.`status_id` = 4) AS chs_count,
            (SELECT COUNT(`id`) FROM `business_shares` AS t5  WHERE t1.`id` = t5.`business_id` AND t5.`status_id` = 4) AS chsr_count
        FROM `business` AS t1
        LEFT JOIN `photo` AS ph1 ON t1.`business_icon` = ph1.`id`
        WHERE (t1.`business_name` LIKE "%' . mysql_real_escape_string($this->postBaseData["q"]) . '%"
        OR t1.`business_description` LIKE "%' . mysql_real_escape_string($this->postBaseData["q"]) . '%")
        AND t1.`status_id` = 4;');
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["total_count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0, $j = 0; $i < $data["count"] && $result[$i]["name"]; $i++) {
            $result[$i]["ch_count"] = $result[$i]["ch_count"] ? (integer) $result[$i]["ch_count"] : 0;
            $result[$i]["p_count"] = $result[$i]["chr_count"] ? (integer) $result[$i]["chr_count"] : 0;
            $result[$i]["pc_count"] = $result[$i]["chs_count"] ? (integer) $result[$i]["chs_count"] : 0;
            $result[$i]["pcr_count"] = $result[$i]["chsr_count"] ? (integer) $result[$i]["chsr_count"] : 0;
            array_push($data["items"], array(
                "index" => ($i + 1),
                "text" => $result[$i]["name"],
                //"id" => (integer) $result[$i]["pk"],
                "id" => $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["pk"]),
                "name" => $result[$i]["name"],
                "avatar_url" => $result[$i]["photos"],
                "email" => $result[$i]["ch_des"],
                "cell" => '',
                "ch_count" => (integer) $result[$i]["ch_count"],
                "p_count" => (integer) $result[$i]["chr_count"],
                "pc_count" => (integer) $result[$i]["chs_count"],
                "pcr_count" => (integer) $result[$i]["chsr_count"],
            ));
        }
        return $data;
    }
    public function View() {
    }
    public function sendMessage() {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        $res1 = '';
        $this->db->beginTransaction();
        $query1 = 'INSERT INTO  `business_messages` (`id`,`business_id`,`user_id`,`message`,`created_at`,`status_id`)
                    VALUES(:id,:leadid,:uid,:msg,:doc,:stat);';
        $stm = $this->db->prepare($query1);
        $res1 = $stm->execute(array(
            ":id" => NULL,
            ":leadid" => mysql_real_escape_string($this->BusinessId),
            ":uid" => mysql_real_escape_string($this->UserId),
            ":msg" => mysql_real_escape_string($this->postBaseData["msg"]),
            ":doc" => date("Y-m-d H:i:s"),
            ":stat" => $jsondata["stat"],
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 1;
            $jsondata["lead_id"] = $this->BusinessId;
        } elseif (is_resource($res1))
            $this->db->rollBack();
        return $jsondata;
    }
    public function removeAdmin() {
        $res3 = '';
        $business_id = !empty($this->postBaseData["details"]["businessID"]) ? $this->postBaseData["details"]["businessID"] : 0;
        $user_id = !empty($this->postBaseData["details"]["UserId"]) ? $this->postBaseData["details"]["UserId"] : 0;
        $jsondata = array(
            "business_id" => $business_id,
            "user_id" => $user_id,
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query3 = 'UPDATE `business_roles` SET `status_id` = :stat  WHERE `business_id` = :cid AND `user_id` = :uid;';
        $stm = $this->db->prepare($query3);
        $res3 = $stm->execute(array(
            ":stat" => mysql_real_escape_string(6),
            ":cid" => mysql_real_escape_string($business_id),
            ":uid" => mysql_real_escape_string($user_id),
        ));
        if ($res3) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["business_id"] = $business_id;
            $jsondata["user_id"] = $user_id;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function BusinessBG() {
        $location = 0;
        $icon = $res1 = $res2 = 0;
        $jsondata = array(
            "stat" => 4,
            "lead_id" => $icon,
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
                $icon = $this->db->lastInsertId();
                $query2 = 'UPDATE `business` SET `business_background` = :icon WHERE `user_id` = :uid AND `id` = :chid;';
                $stm = $this->db->prepare($query2);
                $res2 = $stm->execute(array(
                    ":icon" => mysql_real_escape_string($icon),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":chid" => mysql_real_escape_string($this->BusinessId),
                ));
                $_SESSION["BusinessDetails"]["business"]["business_background"] = $this->config["URL"] . $photo['version_2'];
                /*
                  $query2 = 'INSERT INTO `lead`(`title`,`photo_id`,`user_id`,`lead_location`,`status_id`,`created_at`)Values('
                  . ':id1,:id2,:id3,:id4,:id5,:id6)';
                  $stm = $this->db->prepare($query2);
                  $res2 = $stm->execute(array(
                  ":id1" => mysql_real_escape_string($jsondata["name"]),
                  ":id2" => mysql_real_escape_string($icon),
                  ":id3" => mysql_real_escape_string($this->UserId),
                  ":id4" => mysql_real_escape_string($location),
                  ":id5" => mysql_real_escape_string($jsondata["stat"]),
                  ":id6" => date("Y-m-d H:i:s")
                  ));
                 */
            }
            if ($res1 && $res2) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["lead_id"] = $icon;
            } else {
                $this->db->rollBack();
            }
            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
    public function BusinessIcon() {
        $location = 0;
        $icon = $res1 = $res2 = 0;
        $jsondata = array(
            "stat" => 4,
            "lead_id" => $icon,
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
                $icon = $this->db->lastInsertId();
                $query2 = 'UPDATE `business` SET `business_icon` = :icon WHERE `user_id` = :uid AND `id` = :chid;';
                $stm = $this->db->prepare($query2);
                $res2 = $stm->execute(array(
                    ":icon" => mysql_real_escape_string($icon),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":chid" => mysql_real_escape_string($this->BusinessId),
                ));
                $_SESSION["BusinessDetails"]["business"]["business_icon"] = $this->config["URL"] . $photo['version_2'];
                /*
                  $query2 = 'INSERT INTO `lead`(`title`,`photo_id`,`user_id`,`lead_location`,`status_id`,`created_at`)Values('
                  . ':id1,:id2,:id3,:id4,:id5,:id6)';
                  $stm = $this->db->prepare($query2);
                  $res2 = $stm->execute(array(
                  ":id1" => mysql_real_escape_string($jsondata["name"]),
                  ":id2" => mysql_real_escape_string($icon),
                  ":id3" => mysql_real_escape_string($this->UserId),
                  ":id4" => mysql_real_escape_string($location),
                  ":id5" => mysql_real_escape_string($jsondata["stat"]),
                  ":id6" => date("Y-m-d H:i:s")
                  ));
                 */
            }
            if ($res1 && $res2) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["lead_id"] = $icon;
            } else {
                $this->db->rollBack();
            }
            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
    public function BusinessAdv() {
        $location = 0;
        $icon = $res1 = $res2 = 0;
        $jsondata = array(
            "stat" => 4,
            "lead_id" => $icon,
            "status" => 'error',
            "error" => '',
        );
        if (isset($_SESSION['Individual_POST_PATH']) && is_array($_SESSION['Individual_POST_PATH'])) {
            $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
            $res1 = '';
            $res2 = '';
            if ($photo["status"] === "success") {
                $query = 'SELECT `id` FROM `business_advertise` WHERE `id` = :chid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":chid" => mysql_real_escape_string($this->BusinessId),
                ));
                if ($stm->rowCount() === 0) {
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
                    $icon = $this->db->lastInsertId();
                    $query2 = 'INSERT INTO `business_advertise` (`business_id`,`advertise`,`created_at`) VALUES(:id1,:id2,:id3);';
                    $stm = $this->db->prepare($query2);
                    $res2 = $stm->execute(array(
                        ":id1" => mysql_real_escape_string($this->BusinessId),
                        ":id2" => mysql_real_escape_string($icon),
                        ":id3" => mysql_real_escape_string(date("Y-m-d H:i:s")),
                    ));
                }
            }
            if ($res1 && $res2) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["lead_id"] = $icon;
            } else {
                $this->db->rollBack();
            }
            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
    public function ReportBusiness() {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => $this->postBaseData["para"]["reportID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `business_report` WHERE `report_id` = :prefId AND `user_id` = :uid AND `business_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":prefId" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["businessID"]),
        ));
        $count = $stm->rowCount();
        if ($count == 0) {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `business_report` (`id`,`business_id`,`user_id`,`report_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:prefId,:doc,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["businessID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":doc" => date("Y-m-d H:i:s"),
                ":stat" => 4,
            ));
        } else {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `business_report` SET `report_id` = :prefId WHERE `business_id` = :leadid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":leadid" => mysql_real_escape_string($this->postBaseData["para"]["businessID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["lead_id"] = $this->postBaseData["para"]["businessID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function SubscribeBusiness($businessID = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->BusinessId == $businessID) {
            $query = 'SELECT `id` FROM `business` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":uid" => mysql_real_escape_string($this->UserId),
                ":leadid" => mysql_real_escape_string($this->BusinessId),
            ));
            $count = $stm->rowCount();
            if ($count === 0) {
                $query = 'SELECT `id` FROM `business` WHERE `status_id` = :stat AND `id` = :leadid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 4,
                    ":leadid" => mysql_real_escape_string($this->BusinessId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    //$query = 'SELECT `id` FROM `business_subscribe` WHERE `status_id` = :prefId AND `user_id` = :uid AND `business_id` = :leadid;';
                    $query = 'SELECT `id` FROM `business_subscribe` WHERE `user_id` = :uid AND `business_id` = :leadid;';
                    $stm = $this->db->prepare($query);
                    $res = $stm->execute(array(
                        //":prefId" => $jsondata["stat"],
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":leadid" => mysql_real_escape_string($this->BusinessId),
                    ));
                    $count = $stm->rowCount();
                    if ($count === 0) {
                        $this->db->beginTransaction();
                        $query1 = 'INSERT INTO  `business_subscribe` (`business_id`,`user_id`,`created_at`,`status_id`)
                                    VALUES(:leadid,:uid,:doc,:stat);';
                        $stm = $this->db->prepare($query1);
                        $res1 = $stm->execute(array(
                            ":leadid" => mysql_real_escape_string($this->BusinessId),
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":doc" => date("Y-m-d H:i:s"),
                            ":stat" => $jsondata["stat"],
                        ));
                    } else {
                        $query = 'SELECT `id` FROM `business_subscribe` WHERE `status_id` = :prefId AND `user_id` = :uid AND `business_id` = :leadid;';
                        $stm = $this->db->prepare($query);
                        $res = $stm->execute(array(
                            ":prefId" => 35,
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":leadid" => mysql_real_escape_string($this->BusinessId),
                        ));
                        $count = $stm->rowCount();
                        if ($count > 0) {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `business_subscribe` SET `status_id` = :prefId WHERE `business_id` = :leadid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => $jsondata["stat"],
                                ":leadid" => mysql_real_escape_string($this->BusinessId),
                                ":uid" => mysql_real_escape_string($this->UserId),
                            ));
                        } else {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `business_subscribe` SET `status_id` = :prefId WHERE `business_id` = :leadid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => 35,
                                ":leadid" => mysql_real_escape_string($this->BusinessId),
                                ":uid" => mysql_real_escape_string($this->UserId),
                            ));
                        }
                    }
                }
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = 0;
                $jsondata["lead_id"] = $this->BusinessId;
            } else if (is_resource($res1))
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function BlockBusiness($businessID = false) {
        $jsondata = array(
            "count" => 0,
            "lead_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->BusinessId == $businessID) {
            $query = 'SELECT `id` FROM `business` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":uid" => mysql_real_escape_string($this->UserId),
                ":leadid" => mysql_real_escape_string($this->BusinessId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `business` SET `status_id` = :stat WHERE `id` = :leadid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => 38,
                    ":leadid" => mysql_real_escape_string($this->BusinessId),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $query = 'SELECT `id` FROM `business` WHERE `status_id` = :stat AND `id` = :leadid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 4,
                    ":leadid" => mysql_real_escape_string($this->BusinessId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    $query = 'SELECT `id` FROM `business_block` WHERE `status_id` = :prefId AND `user_id` = :uid AND `business_id` = :leadid;';
                    $stm = $this->db->prepare($query);
                    $res = $stm->execute(array(
                        ":prefId" => $jsondata["stat"],
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":leadid" => mysql_real_escape_string($this->BusinessId),
                    ));
                    $count = $stm->rowCount();
                    if ($count == 0) {
                        $this->db->beginTransaction();
                        $query1 = 'INSERT INTO  `business_block` (`id`,`business_id`,`user_id`,`created_at`,`status_id`)
                                    VALUES(:id,:leadid,:uid,:prefId,:doc,:stat);';
                        $stm = $this->db->prepare($query1);
                        $res1 = $stm->execute(array(
                            ":id" => NULL,
                            ":leadid" => mysql_real_escape_string($this->BusinessId),
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":doc" => date("Y-m-d H:i:s"),
                            ":stat" => 4,
                        ));
                    } else {
                        $query = 'SELECT `id` FROM `business_block` WHERE `status_id` = :prefId AND `user_id` = :uid AND `business_id` = :leadid;';
                        $stm = $this->db->prepare($query);
                        $res = $stm->execute(array(
                            ":prefId" => 39,
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":leadid" => mysql_real_escape_string($this->BusinessId),
                        ));
                        $count = $stm->rowCount();
                        if ($count == 0) {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `business_block` SET `status_id` = :prefId WHERE `business_id` = :leadid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => $jsondata["stat"],
                                ":leadid" => mysql_real_escape_string($this->BusinessId),
                                ":uid" => mysql_real_escape_string($this->UserId),
                            ));
                        } else {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `business_block` SET `status_id` = :prefId WHERE `business_id` = :leadid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => 39,
                                ":leadid" => mysql_real_escape_string($this->BusinessId),
                                ":uid" => mysql_real_escape_string($this->UserId),
                            ));
                        }
                    }
                }
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = 0;
                $jsondata["lead_id"] = $this->BusinessId;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function approvalBusiness($param = false) {
        $jsondata = array(
            "count" => $this->ApprovalBusinessCount($param),
            "lead_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->BusinessId == $param) {
            $query = 'SELECT `id` FROM `business_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `business_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count === 0) {
                $query = 'SELECT `id` FROM `business_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `business_id` = :leadid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 37,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `business_approvals` SET `status_id` = :stat, `created_at`:= :doc WHERE `business_id` = :leadid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":stat" => $jsondata["stat"],
                        ":doc" => date("Y-m-d H:i:s"),
                        ":leadid" => mysql_real_escape_string($param),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `business_approvals` (`id`,`business_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
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
                    $jsondata["count"] = $this->ApprovalBusinessCount($param);
                    $jsondata["lead_id"] = $param;
                } else
                    $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function disApprovalBusiness($param = false) {
        $jsondata = array(
            "count" => $this->ApprovalBusinessCount($param),
            "lead_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->BusinessId == $param) {
            $query = 'SELECT `id` FROM `business_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `business_id` = :leadid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":leadid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count === 0) {
                $query = 'SELECT `id` FROM `business_approvals` WHERE `status_id` = :stat AND `user_id` = :uid AND `business_id` = :leadid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 36,
                    ":leadid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `business_approvals` SET `status_id`  = :stat, `created_at`:= :doc WHERE `business_id` = :leadid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":stat" => $jsondata["stat"],
                        ":doc" => date("Y-m-d H:i:s"),
                        ":leadid" => mysql_real_escape_string($param),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `business_approvals` (`id`,`business_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:leadid,:uid,:doc,:stat);';
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
                    $jsondata["count"] = $this->ApprovalBusinessCount($param);
                    $jsondata["lead_id"] = $param;
                } else
                    $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function ApprovalBusinessCount($param = false) {
        $query = 'SELECT `id` FROM `business_approvals` WHERE `status_id` = :stat AND `business_id` = :leadid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":leadid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function UpdateBusinessDetails() {
        $location = 0;
        $res1 = '';
        $res3 = '';
        $jsondata = array(
            "name" => $this->postBaseData["details"]["name"],
            "target" => isset($this->postBaseData["details"]["target"]) ? $this->postBaseData["details"]["target"] : false,
            "continent" => isset($this->postBaseData["details"]["continent"]) ? $this->postBaseData["details"]["continent"] : false,
            "countries" => isset($this->postBaseData["details"]["countries"]) ? (array) $this->postBaseData["details"]["countries"] : false,
            "langauges" => isset($this->postBaseData["details"]["langauges"]) ? (array) $this->postBaseData["details"]["langauges"] : false,
            "business_id" => 0,
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query3 = 'UPDATE `business` SET `business_name` = :name,
                        `business_description` = :des,
                        `business_updated_at` = :now,
                        `business_website` = :web,
                        `business_facebook` = :fb,
                        `business_googleplus` = :gp,
                        `business_twitter` = :twt
                    WHERE `id` = :id;';
        $stm = $this->db->prepare($query3);
        $res3 = $stm->execute(array(
            ":name" => mysql_real_escape_string($this->postBaseData["details"]["name"]),
            ":des" => mysql_real_escape_string($this->postBaseData["details"]["description"]),
            ":now" => mysql_real_escape_string(date("Y-m-d H:i:s")),
            ":web" => mysql_real_escape_string($this->postBaseData["details"]["website"]),
            ":fb" => mysql_real_escape_string($this->postBaseData["details"]["facebook"]),
            ":gp" => mysql_real_escape_string($this->postBaseData["details"]["googleplus"]),
            ":twt" => mysql_real_escape_string($this->postBaseData["details"]["twitter"]),
            ":id" => mysql_real_escape_string($this->BusinessId),
        ));
        $admins = (array) $this->postBaseData["details"]["admins"];
        for ($i = 0; $i < count($admins) && $i < 5; $i++) {
            $query1 = 'INSERT INTO `business_roles` (`business_id`,`user_id`,`role_id`,`created_at`) VALUES(
                :id1,:id2,:id3,:id4);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($this->BusinessId),
                ":id2" => mysql_real_escape_string($admins[$i]),
                ":id3" => mysql_real_escape_string(3),
                ":id4" => mysql_real_escape_string(date("Y-m-d H:i:s")),
            ));
        }
        if ($res3 && $res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["business_id"] = $this->BusinessId;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function shareBusiness($param = false) {
    }
}
?>