<?php
class Channel_Model extends BaseModel {

    public $ChannelDetails, $ChannelId;
    public $UserId;

    function __construct() {
        parent::__construct();
        $this->UserId = (integer) isset($_SESSION["USERDATA"]["logindata"]["id"]) ?
                $_SESSION["USERDATA"]["logindata"]["id"] :
                0;
    }
    public function CreateChannel() {
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
        $stm = $this->db->prepare('SELECT COUNT(`user_id`) FROM `channel` WHERE `user_id`= :user_id AND `status_id`= :status_id');
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
              $query3 = 'INSERT INTO `channel`(`user_id`,`channel_name`,`channel_location`,`channel_icon`,`channel_background`,`status_id`,`channel_created_at`)Values('
              . ':id1,:id2,:id3,:id4,:id5,:id6,NOW())';
             */
            $query3 = 'INSERT INTO `channel`(`user_id`,
                `channel_name`,
                `channel_location`,
                `status_id`,
                `channel_created_at`)Values('
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
            $channel_pk = $this->db->lastInsertId();

            if ($jsondata["target"] > 0) {
                $data = array();
                for ($i = 0; $i < count($jsondata["countries"]); $i++) {
                    $data[] = array(
                        "channel_id" => $channel_pk,
                        "country_id" => $jsondata["countries"][$i],
                        "created_at" => date("Y-m-d H:i:s")
                    );
                }
                $datafields = array("`channel_id`", "`country_id`", "`created_at`");
                $question_marks = array();
                $insert_values = array();
                foreach ($data as $d) {
                    $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query4 = 'INSERT INTO `channel_countries` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query4);
                $res4 = $stm->execute($insert_values);


                $data = array();
                for ($i = 0; $i < count($jsondata["langauges"]); $i++) {
                    $data[] = array(
                        "channel_id" => $channel_pk,
                        "country_id" => $jsondata["langauges"][$i],
                        "created_at" => date("Y-m-d H:i:s")
                    );
                }
                $datafields = array("`channel_id`", "`languages_id`", "`created_at`");
                $question_marks = array();
                $insert_values = array();
                foreach ($data as $d) {
                    $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query5 = 'INSERT INTO `channel_languages` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query5);
                $res5 = $stm->execute($insert_values);
            }
            //if ($res1 && $res2 && $res3 && $jsondata["target"] == 0) {
            if ($res3 && $jsondata["target"] == 0) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["channel_id"] = $channel_pk;
                //} else if ($res1 && $res2 && $res3 && $res4 && $res5 && $jsondata["target"] > 0) {
            } else if ($res3 && $res4 && $res5 && $jsondata["target"] > 0) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["channel_id"] = $channel_pk;
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function CreateNew_Post() {
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
            "channelID" => isset($this->postBaseData["details"]["channelID"]) ? (integer) $this->postBaseData["details"]["channelID"] : false,
            "post_id" => 0,
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
                $query3 = 'INSERT INTO `post`(`title`,`photo_id`,`user_id`,`post_location`,`status_id`,`created_at`)Values('
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
                $channel_pk = $this->db->lastInsertId();
                $data = array();
                for ($i = 0; $i < count($jsondata["sections"]); $i++) {
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
                    $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query6 = 'INSERT INTO `post_section` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query6);
                $res6 = $stm->execute($insert_values);
                if ($jsondata["target"] > 0) {
                    $data = array();
                    for ($i = 0; $i < count($jsondata["countries"]); $i++) {
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
                        $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                        $insert_values = array_merge($insert_values, array_values($d));
                    }
                    $query4 = 'INSERT INTO `post_countries` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                    $stm = $this->db->prepare($query4);
                    $res4 = $stm->execute($insert_values);
                    $data = array();
                    for ($i = 0; $i < count($jsondata["langauges"]); $i++) {
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
                        $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                        $insert_values = array_merge($insert_values, array_values($d));
                    }
                    $query5 = 'INSERT INTO `post_languages` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                    $stm = $this->db->prepare($query5);
                    $res5 = $stm->execute($insert_values);
                }
                if ($jsondata["channelID"] > 0) {
                    $query7 = 'INSERT INTO `channel_wall` (`channel_id`, `user_id`, `post_id`, `created_at`) 
                        VALUES (:id1,:id2,:id3,:id4)';
                    $stm = $this->db->prepare($query7);
                    $res7 = $stm->execute(array(
                        ":id1" => mysql_real_escape_string($jsondata["channelID"]),
                        ":id2" => mysql_real_escape_string($this->UserId),
                        ":id3" => mysql_real_escape_string($channel_pk),
                        ":id4" => date("Y-m-d H:i:s")
                    ));
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

            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
    public function ListChannels() {
        $list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
        $create = (array) $this->idHolders["pic3pic"]["channel"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `channel` WHERE `user_id`= :user_id AND `status_id`= :status_id ORDER BY `channel_created_at` DESC');
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
            $data["html"] .= '<a class="list-group-item"  id="' . $list["item"] . '_' . $i . '" href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["id"]) . '"><i class="fa fa-tv fa-fw"></i>&nbsp;' . $result[$i]["channel_name"] . '</a>';
        }
        if ($data["count"] < $this->config["CHN_CNT_LMT"]) {
            $data["html"] .= '<button type="button" data-toggle="modal" data-target="#' . $create["create"]["parentDiv"] . '" data-whatever="@mdo" class="list-group-item btn btn-block btn-default" id="' . $create["moodalBut"] . '">Create Channel</button>';
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function ListAdminChannels() {
        $list = (array) $this->idHolders["pic3pic"]["channel"]["listAdminChannels"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT 
                                    t1.* 
                                FROM `channel` AS t1
                                INNER JOIN `channel_roles` AS t2 ON t2.`channel_id` = t1.`id`
                                WHERE t2.`user_id`= :user_id 
                                AND t1.`status_id`= :status_id1 
                                AND t2.`status_id`= :status_id2
                                ORDER BY `channel_created_at` DESC');
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
            $data["html"] .= '<a class="list-group-item"  id="' . $list["item"] . '_' . $i . '" href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["id"]) . '"><i class="fa fa-tv fa-fw"></i>&nbsp;' . $result[$i]["channel_name"] . '</a>';
        }
        return $data;
    }
    public function ListSubscribeChannels() {
        $list = (array) $this->idHolders["pic3pic"]["channel"]["listSubscribeChannels"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT 
                                    t1.* 
                                FROM `channel` AS t1
                                INNER JOIN `channel_subscribe` AS t2 ON t2.`channel_id` = t1.`id`
                                WHERE t2.`user_id`= :user_id 
                                AND t1.`status_id`= :status_id1 
                                AND t2.`status_id`= :status_id2
                                ORDER BY `channel_created_at` DESC');
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
            $data["html"] .= '<a class="list-group-item"  id="' . $list["item"] . '_' . $i . '" href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["id"]) . '"><i class="fa fa-tv fa-fw"></i>&nbsp;' . $result[$i]["channel_name"] . '</a>';
        }
        return $data;
    }
    public function ListContinents($listtype = false) {
        //$list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'continentsCh_',
            "class" => 'contiSelCh',
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
        //$list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
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
        //$list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
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
        //$stm = $this->db->prepare('SELECT * FROM `pic3pic_languages` WHERE `status_id` = :stat AND `country_id` IN (' . $in . ') ORDER BY `country_id`');
        $stm = $this->db->prepare('SELECT
                                    TRIM(t2.`Country`) AS Country,
                                    GROUP_CONCAT(t1.`id` SEPARATOR "☻♥☻") AS id,
                                    GROUP_CONCAT(t1.`country_id` SEPARATOR "☻♥☻") AS c_id,
                                    GROUP_CONCAT(t1.`Language Name` SEPARATOR "☻♥☻") AS lname
                                  FROM `pic3pic_languages` AS t1
                                  JOIN `pic3pic_countries` AS t2 ON t1.`country_id` = t2.`id` AND t2.`status_id` = 4
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
    public function listWallPost() {
        $_SESSION["ListNewPost"] = NULL;
        $stm = $this->db->prepare('/*Post Start*/
                SELECT
                    /*COUNT(t1.`id`) AS post_ct,*/
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
                    up.`posterpic`,
                    up.`posterid`,
                    up.`postername`,
                    up.`posteremail`,
                    up.`postercell`
                FROM `post` AS t1
                /* Post Countries */
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
                INNER JOIN (
                    SELECT 
                        ad.`id` AS posterid,
                        ad.`user_name` AS postername,
                        ad.`email` AS posteremail,
                        ad.`cell_number` AS postercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS posterpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id` 
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`posterid` = t1.`user_id` 
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
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`post_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `post_likes` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_id`)
                    ORDER BY(t1.`post_id`)
                ) AS t5 ON t5.`post_id` = t1.`id`
                /*Post Comments*/
                LEFT JOIN (
                SELECT
                    t1.`post_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                    GROUP_CONCAT(TRIM(t1.`comment`) SEPARATOR "♥☻☻♥") AS comments, 
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
                    GROUP_CONCAT(t4.`reply` SEPARATOR "♥☻☻♥") AS reply, 
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
                    
                    GROUP_CONCAT(t4.`replyererid` SEPARATOR "♥☻☻♥") AS replyererid,
                    GROUP_CONCAT(t4.`replyername` SEPARATOR "♥☻☻♥") AS replyername,
                    GROUP_CONCAT(t4.`replyeremail` SEPARATOR "♥☻☻♥") AS replyeremail,
                    GROUP_CONCAT(t4.`replyercell` SEPARATOR "♥☻☻♥") AS replyercell,
                    GROUP_CONCAT(t4.`replyerpic` SEPARATOR "♥☻☻♥") AS replyerpic,
                    GROUP_CONCAT(up.`commentererid` SEPARATOR "♥☻☻♥") AS  commentererid,
                    GROUP_CONCAT(up.`commentername` SEPARATOR "♥☻☻♥") AS  commentername,
                    GROUP_CONCAT(up.`commenteremail` SEPARATOR "♥☻☻♥") AS  commenteremail,
                    GROUP_CONCAT(up.`commentercell` SEPARATOR "♥☻☻♥") AS  commentercell,
                    GROUP_CONCAT(up.`commenterpic` SEPARATOR "♥☻☻♥") AS  commenterpic
                FROM `post_comments` 					AS t1
                /*Post Comments User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS commentererid,
                        ad.`user_name` AS commentername,
                        ad.`email` AS commenteremail,
                        ad.`cell_number` AS commentercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS commenterpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`commentererid` = t1.`user_id`
                /*Post Comments Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`post_comments_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `post_comments_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_comments_id`)
                    ORDER BY(t1.`post_comments_id`)
                )AS t2 ON t2.`post_comments_id` = t1.`id`
                /*Post Comments Likes*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`post_comments_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `post_comments_likes` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_comments_id`)
                    ORDER BY(t1.`post_comments_id`)
                ) AS t3 ON t3.`post_comments_id` = t1.`id`
                /*Post Comments Reply*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                        t1.`post_comments_id` AS pcr_pc_id, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                        GROUP_CONCAT(TRIM(t1.`reply`) SEPARATOR "♥☻♥") AS reply, 
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
                        GROUP_CONCAT(t3.`lk_replyer_id` SEPARATOR "♥☻♥") AS lk_replyer_id,
                        GROUP_CONCAT(t3.`lk_replytime` SEPARATOR "♥☻♥") AS lk_replytime,
                        GROUP_CONCAT(t3.`lk_replyer_name` SEPARATOR "♥☻♥") AS lk_replyer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        
                        GROUP_CONCAT(up.`replyererid` SEPARATOR "♥☻♥") AS replyererid,
                        GROUP_CONCAT(up.`replyername` SEPARATOR "♥☻♥") AS replyername,
                        GROUP_CONCAT(up.`replyeremail` SEPARATOR "♥☻♥") AS replyeremail,
                        GROUP_CONCAT(up.`replyercell` SEPARATOR "♥☻♥") AS replyercell,
                        GROUP_CONCAT(up.`replyerpic` SEPARATOR "♥☻♥") AS replyerpic
                    FROM `post_comments_reply` 						AS t1
                    /*Post Comments Reply User*/
                    INNER JOIN (
                        SELECT 
                            ad.`id` AS replyererid,
                            ad.`user_name` AS replyername,
                            ad.`email` AS replyeremail,
                            ad.`cell_number` AS replyercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS replyerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`replyererid` = t1.`user_id`
                    /*Post Comments Reply Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id, 
                            t1.`post_comments_reply_id`, 
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid, 
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time, 
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid, 
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref, 
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `post_comments_reply_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`post_comments_reply_id`)
                        ORDER BY(t1.`post_comments_reply_id`)
                    ) AS t2 ON t2.`post_comments_reply_id` = t1.`id`
                    /*Post Comments Reply Likes*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id, 
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`post_comments_reply_id`, 
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_replyer_id, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_replytime, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_replyer_name
                        FROM `post_comments_reply_likes` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`post_comments_reply_id`)
                       ORDER BY(t1.`post_comments_reply_id`)
                    ) AS t3 ON t3.`post_comments_reply_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`post_comments_id`)
                    ORDER BY(t1.`post_comments_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
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
                            t1.`id` AS ps_id, 
                            t1.`post_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `post_section` 	AS t1
                        LEFT JOIN `sections_channel_post`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                ) AS t8 ON t8.`post_id` = t1.`id`
                /*Post Photo*/
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
                /* Post Channel */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`channel_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`post_id` AS chwapost_id,
                        t1.`created_at` AS chwatime,
                        t2.`channel_name`,
                        t2.`channel_description`,
                        t2.`channel_location`,
                        t2.`channel_language`,
                        t2.`channel_icon`,
                        t2.`channel_background`,
                        t2.`channel_created_at`,
                        t2.`channel_updated_at`,
                        t2.`channel_website`,
                        t2.`status_id` AS channel_status_id
                    FROM `channel_wall` AS t1
                    LEFT JOIN `channel`	AS t2 ON t2.`id` = t1.`channel_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    AND t1.`channel_id` = "' . mysql_real_escape_string($this->ChannelId) . '" 
                    AND t1.`status_id` = 4
                ) AS t10 ON t10.`chwapost_id` = t1.`id`
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chsubid,
                        t1.`channel_id` AS chsubcid,
                        t1.`user_id` AS chsubuid,
                        t1.`created_at` AS chsubtime
                    FROM `channel_subscribe` AS t1
                    LEFT JOIN `channel`	AS t2 ON t2.`id` = t1.`channel_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t11 ON t11.`chsubcid` = t10.`chwacid`
                WHERE t1.`status_id` = 4
                AND t10.`chwacid` = "' . mysql_real_escape_string($this->ChannelId) . '"
                AND t10.`channel_status_id` = 4
                ORDER BY(t1.`id`) DESC
                /*Post Ends*/');
        $res = $stm->execute();
        $newRes = array();
        $delimiters = array("♥☻☻♥", "♥☻♥");
        $delimiters1 = array("♥☻☻♥", "♥☻♥", "♥♥");
        if ($res) {
            $result = $stm->fetchAll();
            for ($i = 0; $i < $stm->rowCount() && isset($result[$i]["chwacid"]) && $result[$i]["chwacid"] != NULL; $i++) {
                array_push($newRes, array(
                    "posts" => array(
                        //"post_ct" => (integer) $result[$i]["post_ct"],
                        "id" => (integer) $result[$i]["id"],
                        "title" => $result[$i]["title"],
                        "photo_id" => (integer) $result[$i]["photo_id"],
                        "section_id" => (integer) $result[$i]["section_id"],
                        "user_id" => (integer) $result[$i]["user_id"],
                        "created_at" => $result[$i]["created_at"],
                        "posterid" => (integer) $result[$i]["posterid"],
                        "postername" => $result[$i]["postername"],
                        "posteremail" => $result[$i]["posteremail"],
                        "postercell" => $result[$i]["postercell"],
                        "posterpic" => $result[$i]["posterpic"],
                        "p_pic_flag" => $result[$i]["p_pic_flag"],
                        "lk_p_ct" => (integer) $result[$i]["lk_p_ct"],
                        "pc_ct" => (integer) $result[$i]["pc_ct"],
                        "chwaid" => (integer) $result[$i]["chwaid"],
                        "chwauid" => (integer) $result[$i]["chwauid"],
                        "chwacid" => (integer) $result[$i]["chwacid"],
                        "chwapost_id" => (integer) $result[$i]["chwapost_id"],
                        "chwatime" => $result[$i]["chwatime"],
                        "chsubid" => isset($result[$i]["chsubid"]) ? (integer) $result[$i]["chsubid"] : 0,
                        "chsubcid" => isset($result[$i]["chsubcid"]) ? (integer) $result[$i]["chsubcid"] : 0,
                        "chsubuid" => isset($result[$i]["chsubuid"]) ? (integer) $result[$i]["chsubuid"] : 0,
                        "chsubtime" => isset($result[$i]["chsubtime"]) ? $result[$i]["chsubtime"] : '',
                        "channel_name" => $result[$i]["channel_name"],
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
                            "pcont_id" => explode("♥☻☻♥", $result[$i]['pcont_id']),
                            "pcont_time" => explode("♥☻☻♥", $result[$i]['pcont_time']),
                            "pcont_contid" => explode("♥☻☻♥", $result[$i]['pcont_contid']),
                            "pcont_contname" => explode("♥☻☻♥", $result[$i]['pcont_contname']),
                        ),
                        "report" => array(
                            "pr_uname" => explode("♥☻☻♥", $result[$i]['pr_uname']),
                            "pr_id" => explode("♥☻☻♥", $result[$i]['pr_id']),
                            "pr_uid" => explode("♥☻☻♥", $result[$i]['pr_uid']),
                            "pr_time" => explode("♥☻☻♥", $result[$i]['pr_time']),
                            "pr_repid" => explode("♥☻☻♥", $result[$i]['pr_repid']),
                            "pr_repname" => explode("♥☻☻♥", $result[$i]['pr_repname']),
                        ),
                        "preference" => array(
                            "pp_uname" => explode("♥☻☻♥", $result[$i]['pp_uname']),
                            "pp_id" => explode("♥☻☻♥", $result[$i]['pp_id']),
                            "pp_uid" => explode("♥☻☻♥", $result[$i]['pp_uid']),
                            "pp_time" => explode("♥☻☻♥", $result[$i]['pp_time']),
                            "pp_preid" => explode("♥☻☻♥", $result[$i]['pp_preid']),
                            "pp_pref" => explode("♥☻☻♥", $result[$i]['pp_pref']),
                        ),
                        "likes" => array(
                            "lk_p_uname" => explode("♥☻☻♥", $result[$i]['lk_p_uname']),
                            "lk_p_id" => explode("♥☻☻♥", $result[$i]['lk_p_id']),
                            "lk_p_uid" => explode("♥☻☻♥", $result[$i]['lk_p_uid']),
                            "lk_p_time" => explode("♥☻☻♥", $result[$i]['lk_p_time']),
                        ),
                        "sections" => array(
                            "ps_id" => $result[$i]['ps_id'],
                            "ps_time" => $result[$i]['ps_time'],
                            "ps_secid" => $result[$i]['ps_secid'],
                            "pr_secname" => $result[$i]['pr_secname'],
                        ),
                        "languages" => array(
                            "plng_id" => explode("♥☻☻♥", $result[$i]['plng_id']),
                            "plng_time" => explode("♥☻☻♥", $result[$i]['plng_time']),
                            "plng_lngid" => explode("♥☻☻♥", $result[$i]['plng_lngid']),
                            "plng_lngname" => explode("♥☻☻♥", $result[$i]['plng_lngname']),
                        ),
                        "comments" => array(
                            "pc_id" => explode("♥☻☻♥", $result[$i]['pc_id']),
                            "pc_uid" => explode("♥☻☻♥", $result[$i]['pc_uid']),
                            "commentererid" => explode("♥☻☻♥", $result[$i]['commentererid']),
                            "commentername" => explode("♥☻☻♥", $result[$i]['commentername']),
                            "commenteremail" => explode("♥☻☻♥", $result[$i]['commenteremail']),
                            "commentercell" => explode("♥☻☻♥", $result[$i]['commentercell']),
                            "commenterpic" => explode("♥☻☻♥", $result[$i]['commenterpic']),
                            "comments" => explode("♥☻☻♥", $result[$i]['comments']),
                            "pc_phid" => explode("♥☻☻♥", $result[$i]['pc_phid']),
                            "pc_ph" => explode("♥☻☻♥", $result[$i]['pc_ph']),
                            "pc_pv1" => explode("♥☻☻♥", $result[$i]['pc_pv1']),
                            "pc_pv2" => explode("♥☻☻♥", $result[$i]['pc_pv2']),
                            "pc_pv3" => explode("♥☻☻♥", $result[$i]['pc_pv3']),
                            "pc_pv4" => explode("♥☻☻♥", $result[$i]['pc_pv4']),
                            "pc_pv5" => explode("♥☻☻♥", $result[$i]['pc_pv5']),
                            "pc_pic_flag" => explode("♥☻☻♥", $result[$i]['pc_pic_flag']),
                            "pc_time" => explode("♥☻☻♥", $result[$i]['pc_time']),
                            "pcp_id" => $this->multiExplode($delimiters, $result[$i]['pcp_id']),
                            "pcp_uid" => $this->multiExplode($delimiters, $result[$i]['pcp_uid']),
                            "pcp_time" => $this->multiExplode($delimiters, $result[$i]['pcp_time']),
                            "pcp_preid" => $this->multiExplode($delimiters, $result[$i]['pcp_preid']),
                            "pcp_pref" => $this->multiExplode($delimiters, $result[$i]['pcp_pref']),
                            "pcp_uname" => $this->multiExplode($delimiters, $result[$i]['pcp_uname']),
                            "lk_pc_ct" => explode("♥☻☻♥", $result[$i]['lk_pc_ct']),
                            "lk_pc_id" => $this->multiExplode($delimiters, $result[$i]['lk_pc_id']),
                            "lk_pc_uid" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uid']),
                            "lk_pc_time" => $this->multiExplode($delimiters, $result[$i]['lk_pc_time']),
                            "lk_pc_uname" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uname']),
                            "replys" => array(
                                "pcr_ct" => explode("♥☻☻♥", $result[$i]['pcr_ct']),
                                "pcr_id" => $this->multiExplode($delimiters, $result[$i]['pcr_id']),
                                "pcr_uid" => $this->multiExplode($delimiters, $result[$i]['pcr_uid']),
                                "reply" => $this->multiExplode($delimiters, $result[$i]['reply']),
                                "replyererid" => $this->multiExplode($delimiters, $result[$i]['replyererid']),
                                "replyername" => $this->multiExplode($delimiters, $result[$i]['replyername']),
                                "replyeremail" => $this->multiExplode($delimiters, $result[$i]['replyeremail']),
                                "replyercell" => $this->multiExplode($delimiters, $result[$i]['replyercell']),
                                "replyerpic" => $this->multiExplode($delimiters, $result[$i]['replyerpic']),
                                "pcr_time" => $this->multiExplode($delimiters, $result[$i]['pcr_time']),
                                "pcr_pic_flag" => $this->multiExplode($delimiters, $result[$i]['pcr_pic_flag']),
                                "pcr_phid" => $this->multiExplode($delimiters, $result[$i]['pcr_phid']),
                                "pcr_ph" => $this->multiExplode($delimiters, $result[$i]['pcr_ph']),
                                "pcr_pv1" => $this->multiExplode($delimiters, $result[$i]['pcr_pv1']),
                                "pcr_pv2" => $this->multiExplode($delimiters, $result[$i]['pcr_pv2']),
                                "pcr_pv3" => $this->multiExplode($delimiters, $result[$i]['pcr_pv3']),
                                "pcr_pv4" => $this->multiExplode($delimiters, $result[$i]['pcr_pv4']),
                                "pcr_pv5" => $this->multiExplode($delimiters, $result[$i]['pcr_pv5']),
                                "lk_rep_ct" => $this->multiExplode($delimiters, $result[$i]['lk_rep_ct']),
                                "pcrp_id" => $this->multiExplode($delimiters1, $result[$i]['pcrp_id']),
                                "pcrp_uid" => $this->multiExplode($delimiters1, $result[$i]['pcrp_uid']),
                                "pcrp_time" => $this->multiExplode($delimiters1, $result[$i]['pcrp_time']),
                                "pcrp_preid" => $this->multiExplode($delimiters1, $result[$i]['pcrp_preid']),
                                "pcrp_pref" => $this->multiExplode($delimiters1, $result[$i]['pcrp_pref']),
                                "pcrp_uname" => $this->multiExplode($delimiters1, $result[$i]['pcrp_uname']),
                                "lk_rep_id" => $this->multiExplode($delimiters1, $result[$i]['lk_rep_id']),
                                "lk_replyer_id" => $this->multiExplode($delimiters1, $result[$i]['lk_replyer_id']),
                                "lk_replytime" => $this->multiExplode($delimiters1, $result[$i]['lk_replytime']),
                                "lk_replyer_name" => $this->multiExplode($delimiters1, $result[$i]['lk_replyer_name']),
                            ),
                        ),
                    )
                ));
            }
            $data["count"] = $stm->rowCount();
            $data["status"] = "success";
        }
        $_SESSION["ListNewPost"] = $newRes;
        return $newRes;
    }
    public function likePost($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCount($param),
            "post_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_likes` SET `status_id` = :stat, `created_at`:= :doc WHERE `post_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_likes` (`id`,`post_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCount($param);
                $jsondata["post_id"] = $param;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disLikePost($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCount($param),
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_likes` SET `status_id`  = :stat, `created_at`:= :doc WHERE `post_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_likes` (`id`,`post_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCount($param);
                $jsondata["post_id"] = $param;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changePostPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post` SET `status_id` = :stat WHERE `id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `post` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `post_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `post_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `post_preferences` (`id`,`post_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `post_preferences` SET `preferences_id` = :prefId WHERE `post_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function reportPost($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["reportID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_report` WHERE `report_id` = :prefId AND `user_id` = :uid AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":prefId" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count == 0) {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `post_report` (`id`,`post_id`,`user_id`,`report_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":doc" => date("Y-m-d H:i:s"),
                ":stat" => 4,
            ));
        } else {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post_report` SET `report_id` = :prefId WHERE `post_id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function addComment($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        if ($this->postBaseData["postID"] > 0) {
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
            $query1 = 'INSERT INTO  `post_comments` (`id`,`post_id`,`user_id`,`comment`,`created_at`,`photo_id`,`status_id`) VALUES(:id,:postid,:uid,:cmt,:doc,:photo,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":postid" => mysql_real_escape_string($this->postBaseData["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":cmt" => mysql_real_escape_string(urldecode($this->postBaseData["comment"])),
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
                $jsondata["count"] = $this->PostCommentCount($this->postBaseData["postID"]);
                $jsondata["post_id"] = $this->postBaseData["postID"];
            }
        }
        return $jsondata;
    }
    public function likePostComment($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCommentCount($param),
            "post_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_likes` SET `status_id` = :stat, `created_at`:= :doc WHERE `post_comments_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_likes` (`id`,`post_comments_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disLikePostComment($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_likes` SET `status_id`  = :stat, `created_at`:= :doc WHERE `post_comments_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_likes` (`id`,`post_comments_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changePostCommentPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post_comments` SET `status_id` = :stat WHERE `id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `post_comments` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `post_comments_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `post_comments_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `post_comments_preferences` (`id`,`post_comments_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `post_comments_preferences` SET `preferences_id` = :prefId WHERE `post_comments_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function addCommentReply($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        if ($this->postBaseData["postComID"] > 0) {
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
            $query1 = 'INSERT INTO  `post_comments_reply` (`id`,`post_comments_id`,`user_id`,`reply`,`created_at`,`photo_id`,`status_id`) VALUES(:id,:postid,:uid,:reply,:doc,:photo,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":postid" => mysql_real_escape_string($this->postBaseData["postComID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":reply" => mysql_real_escape_string(urldecode($this->postBaseData["reply"])),
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
                $jsondata["count"] = $this->PostCommentReplyCount($this->postBaseData["postComID"]);
                $jsondata["post_id"] = $this->postBaseData["postComID"];
            }
        }
        return $jsondata;
    }
    public function likePostCommentReply($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCommentReplyCount($param),
            "post_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_reply_likes` SET `status_id` = :stat, `created_at`:= :doc WHERE `post_comments_reply_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_reply_likes` (`id`,`post_comments_reply_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentReplyCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disLikePostCommentReply($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_reply_likes` SET `status_id`  = :stat, `created_at`:= :doc WHERE `post_comments_reply_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_reply_likes` (`id`,`post_comments_reply_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentReplyCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changePostCommentReplyPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_reply` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post_comments_reply` SET `status_id` = :stat WHERE `id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `post_comments_reply` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `post_comments_reply_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `post_comments_reply_preferences` (`id`,`post_comments_reply_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `post_comments_reply_preferences` SET `preferences_id` = :prefId WHERE `post_comments_reply_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function LikePostCount($param = false) {
        $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function LikePostCommentCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function LikePostCommentReplyCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `post_comments_reply_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function PostCommentCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments` WHERE `status_id` = :stat AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 4,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function PostCommentReplyCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments_reply` WHERE `status_id` = :stat AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 4,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function getChannelDetails($channelid = false) {
        $_SESSION["ChannelDetails"] = NULL;
        $stm = $this->db->prepare('/* Channel */
                SELECT
                    t10.`id` AS  chid,
                    t10.`user_id` AS chuid,
                    t10.`channel_name`,
                    t10.`channel_description`,
                    t10.`channel_location`,
                    t10.`channel_language`,
                    IF(t10.`channel_icon` IS NOT NULL OR t10.`channel_icon` != NULL,   (SELECT 
                            CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                            THEN "' . $this->config["DEFAULT_CHANEL_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver1`)
                            END AS pic
                        FROM `photo` AS ph1 
                        WHERE t10.`channel_icon` = ph1.`id`), "' . $this->config["DEFAULT_CHANEL_ICON_IMG"] . '"
                    ) AS channel_icon,
                    IF(t10.`channel_background` IS NOT NULL OR t10.`channel_background` != NULL, (SELECT 
                            CASE WHEN ph1.`ver1` IS NULL OR ph1.`ver1` = ""
                            THEN "' . $this->config["DEFAULT_CHANEL_BACK_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver1`)
                            END AS pic
                        FROM `photo` AS ph1 
                        WHERE t10.`channel_background` = ph1.`id`), "' . $this->config["DEFAULT_CHANEL_BACK_IMG"] . '"
                    ) AS channel_background,
                    t10.`channel_created_at`,
                    t10.`channel_updated_at`,
                    t10.`channel_website`,
                    t10.`channel_facebook`,
                    t10.`channel_googleplus`,
                    t10.`channel_twitter`,
                    t11.*,
                    t12.*,
                    t13.*,
                    t14.*,
                    t15.*,
                    t16.*,
                    t17.*,
                    t18.*
                FROM  `channel` AS t10 
                LEFT JOIN `user_profile` AS up ON up.`id` = t10.`user_id`
                /* Channel Subscribers */
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS chsub_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥")  AS chsubid,
                        t1.`channel_id` AS chsubcid,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥")  AS chsubuid,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥")  AS chsubtime,
                        GROUP_CONCAT(up.`subscriberid` SEPARATOR "♥☻☻♥")  AS subscriberid,
                        GROUP_CONCAT(up.`subscribername` SEPARATOR "♥☻☻♥")  AS subscribername,
                        GROUP_CONCAT(up.`subscriberemail` SEPARATOR "♥☻☻♥")  AS subscriberemail,
                        GROUP_CONCAT(up.`subscribercell` SEPARATOR "♥☻☻♥")  AS subscribercell,
                        GROUP_CONCAT(up.`subscriberpic` SEPARATOR "♥☻☻♥")  AS subscriberpic
                    FROM `channel_subscribe` AS t1
                    LEFT JOIN `channel`	AS t2 ON t2.`id` = t1.`channel_id`
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
                    GROUP BY(t1.`channel_id`)
                ) AS t11 ON t11.`chsubcid` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
                /* Channel Admins */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥")  AS chadmid,
                        t1.`channel_id` AS chadmcid,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥")  AS chadmuid,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥")  AS chadmtime,
                        GROUP_CONCAT(up.`adminid` SEPARATOR "♥☻☻♥")  AS adminid,
                        GROUP_CONCAT(up.`adminname` SEPARATOR "♥☻☻♥")  AS adminname,
                        GROUP_CONCAT(up.`adminemail` SEPARATOR "♥☻☻♥")  AS adminemail,
                        GROUP_CONCAT(up.`admincell` SEPARATOR "♥☻☻♥")  AS admincell,
                        GROUP_CONCAT(up.`adminpic` SEPARATOR "♥☻☻♥")  AS adminpic
                    FROM `channel_roles` AS t1
                    LEFT JOIN `channel`	AS t2 ON t2.`id` = t1.`channel_id` AND t2.`id` = "' . mysql_real_escape_string($channelid) . '"
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
                    GROUP BY(t1.`channel_id`)
                ) AS t12 ON t12.`chadmcid` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
                /* Channel Messages */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥")  AS chmsgid,
                        t1.`channel_id` AS chmsgcid,
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥")  AS chmsguid,
                        GROUP_CONCAT(TRIM(t1.`message`) SEPARATOR "♥☻☻♥")  AS message,
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥")  AS chmsgtime,
                        GROUP_CONCAT(up.`msginid` SEPARATOR "♥☻☻♥")  AS msginid,
                        GROUP_CONCAT(up.`msginname` SEPARATOR "♥☻☻♥")  AS msginname,
                        GROUP_CONCAT(up.`msginemail` SEPARATOR "♥☻☻♥")  AS msginemail,
                        GROUP_CONCAT(up.`msgincell` SEPARATOR "♥☻☻♥")  AS msgincell,
                        GROUP_CONCAT(up.`msginpic` SEPARATOR "♥☻☻♥")  AS msginpic
                    FROM `channel_messages` AS t1
                    LEFT JOIN `channel`	AS t2 ON t2.`id` = t1.`channel_id` AND t2.`id` = "' . mysql_real_escape_string($channelid) . '"
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
                    GROUP BY(t1.`channel_id`)
                ) AS t13 ON t13.`chmsgcid` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
                /* Channel Countries */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chcont_id, t1.`channel_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS chcont_contname
                    FROM `channel_countries` 	AS t1
                    LEFT JOIN `pic3pic_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4 AND t1.`channel_id` = "' . mysql_real_escape_string($channelid) . '"
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`channel_id`)
                    ORDER BY(t1.`channel_id`)
                ) AS t14 ON t14.`channel_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
                /* Channel Report */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chrep_id, t1.`channel_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS chrep_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chrep_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chrep_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS chrep_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS chrep_uname
                    FROM `channel_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4 AND t1.`channel_id` = "' . mysql_real_escape_string($channelid) . '"
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`channel_id`)
                    ORDER BY(t1.`channel_id`)
                ) AS t15 ON t15.`channel_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
                /* Channel Languages */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS chlng_id, t1.`channel_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS chlng_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS chlng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS chlng_lngname
                    FROM `channel_languages` 	AS t1
                    LEFT JOIN `pic3pic_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                    WHERE t1.`status_id` = 4 AND t1.`channel_id` = "' . mysql_real_escape_string($channelid) . '"
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`channel_id`)
                    ORDER BY(t1.`channel_id`)
                ) AS t16 ON t16.`channel_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
                /*Channel Likes*/
                LEFT JOIN (
                    SELECT 
                        COUNT(t1.`id`) AS lk_ch_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_ch_id, t1.`channel_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_ch_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_ch_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_ch_uname
                    FROM `channel_likes` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`channel_id`)
                    ORDER BY(t1.`channel_id`)
                ) AS t17 ON t17.`channel_id` = t10.`id` AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
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
                WHERE t10.`status_id` = 4
                AND up.`status_id` = 4
                AND t10.`id` = "' . mysql_real_escape_string($channelid) . '"
                /* Channel Ends */');
        $res = $stm->execute();
        $newRes = array(
            "channel" => array(),
            "chsub" => array(),
            "chadm" => array(),
            "chmsg" => array(),
            "chcont" => array(),
            "chrep" => array(),
            "chlng" => array(),
            "lk_ch" => array(),
        );
        $delimiters = array("♥☻☻♥", "♥☻♥");
        $delimiters1 = array("♥☻☻♥", "♥☻♥", "♥♥");
        if ($res) {
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            //echo print_r($result).'<hr />';
            //echo $stm->rowCount().'<hr />';
            if ($stm->rowCount() > 0) {
                /* Channel */
                $newRes["channel"] = array(
                    "chid" => (integer) $result["chid"],
                    "chuid" => (integer) $result["chuid"],
                    "channel_name" => ucfirst($result["channel_name"]),
                    "channel_description" => $result["channel_description"],
                    "channel_location" => (integer) $result["channel_location"],
                    "channel_language" => (integer) $result["channel_language"],
                    "channel_icon" => $result["channel_icon"],
                    "channel_background" => $result["channel_background"],
                    "channel_created_at" => $result["channel_created_at"],
                    "channel_website" => $result["channel_website"],
                    "channel_facebook" => $result["channel_facebook"],
                    "channel_googleplus" => $result["channel_googleplus"],
                    "channel_twitter" => $result["channel_twitter"],
                    "lk_ch_ct" => (integer) $result["lk_ch_ct"],
                    "chsub_ct" => (integer) $result["chsub_ct"],
                    /* Channel Owner */
                    "chownid" => (integer) $result["chownid"],
                    "chownname" => ucfirst($result["chownname"]),
                    "chownemail" => $result["chownemail"],
                    "chowncell" => $result["chowncell"],
                    "chownpic" => $result["chownpic"],
                );
                /* Channel Subscriber */
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
                /* Channel Admins */
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
                /* Channel Messages */
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
                /* Channel Countries */
                $newRes["chcont"] = array(
                    "chcont_id" => explode("♥☻☻♥", $result['chcont_id']),
                    "chcont_time" => explode("♥☻☻♥", $result['chcont_time']),
                    "chcont_contid" => explode("♥☻☻♥", $result['chcont_contid']),
                    "chcont_contname" => explode("♥☻☻♥", $result['chcont_contname']),
                );
                /* Channel Report */
                $newRes["chrep"] = array(
                    "chrep_id" => explode("♥☻☻♥", $result['chrep_id']),
                    "chrep_uid" => explode("♥☻☻♥", $result['chrep_uid']),
                    "chrep_uname" => explode("♥☻☻♥", $result['chrep_uname']),
                    "chrep_repid" => explode("♥☻☻♥", $result['chrep_repid']),
                    "chrep_repname" => explode("♥☻☻♥", $result['chrep_repname']),
                    "chrep_time" => explode("♥☻☻♥", $result['chrep_time']),
                );
                /* Channel Languages */
                $newRes["chlng"] = array(
                    "chlng_id" => explode("♥☻☻♥", $result['chlng_id']),
                    "chlng_lngid" => explode("♥☻☻♥", $result['chlng_lngid']),
                    "chlng_lngname" => explode("♥☻☻♥", $result['chlng_lngname']),
                    "chlng_time" => explode("♥☻☻♥", $result['chlng_time']),
                );
                /* Channel Likes */
                $newRes["lk_ch"] = array(
                    "lk_ch_id" => explode("♥☻☻♥", $result['lk_ch_id']),
                    "lk_ch_uid" => explode("♥☻☻♥", $result['lk_ch_uid']),
                    "lk_ch_uname" => explode("♥☻☻♥", $result['lk_ch_uname']),
                    "lk_ch_time" => explode("♥☻☻♥", $result['lk_ch_time']),
                );
            }
            $data["count"] = $stm->rowCount();
            $data["status"] = "success";
        }
        if (count($newRes) > 0) {
            $_SESSION["ChannelDetails"] = $newRes;
        }
        //echo print_r($newRes);
        return $newRes;
    }
    public function getSectionsNames($listtype = false) {
        //$list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "class" => 'secCheck',
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `sections_channel_post` WHERE `status_id` = :stat ORDER BY `section_name`');
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
        //$list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
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
            (SELECT COUNT(`id`) FROM `channel` AS t1 WHERE ad.`id` = t1.`user_id` AND t1.`status_id` = 4) AS ch_count,
            (SELECT COUNT(`id`) FROM `post` AS t2 WHERE ad.`id` = t2.`user_id` AND t2.`status_id` = 4) AS p_count,
            (SELECT COUNT(`id`) FROM `post_comments` AS t3 WHERE ad.`id` = t3.`user_id` AND t3.`status_id` = 4) AS pc_count,
            (SELECT COUNT(`id`) FROM `post_comments_reply` AS t4 WHERE ad.`id` = t4.`user_id` AND t4.`status_id` = 4) AS pcr_count
        FROM `user_profile` AS ad
        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
        WHERE (ad.`user_name` LIKE "%' . $this->postBaseData["q"] . '%"
        OR ad.`email` LIKE "%' . $this->postBaseData["q"] . '%"
        OR ad.`cell_number` LIKE "%' . $this->postBaseData["q"] . '%")
        AND ad.`id` NOT IN (SELECT `user_id` FROM `channel_roles` WHERE `channel_id` = "' . $this->ChannelId . '" AND `status_id` = 4)
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
    public function searchChannels($listtype = false) {
        //$list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
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
            t1.`channel_name` AS name,
            t1.`channel_description` AS ch_des,
            CASE WHEN (t1.`channel_icon` IS NULL OR t1.`channel_icon`  = "" OR ph1.`ver3` = NULL OR ph1.`ver3` IS NULL OR ph1.`ver3` = "")
            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
            END AS photos,
            (SELECT COUNT(`id`) FROM `channel_likes` AS t2 WHERE t1.`id` = t2.`channel_id` AND t2.`status_id` = 4) AS ch_count,
            (SELECT COUNT(`id`) FROM `channel_roles` AS t3  WHERE t1.`id` = t3.`channel_id` AND t3.`status_id` = 4) AS chr_count,
            (SELECT COUNT(`id`) FROM `channel_subscribe` AS t4  WHERE t1.`id` = t4.`channel_id` AND t4.`status_id` = 4) AS chs_count,
            (SELECT COUNT(`id`) FROM `channel_shares` AS t5  WHERE t1.`id` = t5.`channel_id` AND t5.`status_id` = 4) AS chsr_count
        FROM `channel` AS t1
        LEFT JOIN `photo` AS ph1 ON t1.`channel_icon` = ph1.`id`
        WHERE (t1.`channel_name` LIKE "%' . mysql_real_escape_string($this->postBaseData["q"]) . '%"
        OR t1.`channel_description` LIKE "%' . mysql_real_escape_string($this->postBaseData["q"]) . '%")
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
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        $res1 = '';
        $this->db->beginTransaction();
        $query1 = 'INSERT INTO  `channel_messages` (`id`,`channel_id`,`user_id`,`message`,`created_at`,`status_id`) 
                    VALUES(:id,:postid,:uid,:msg,:doc,:stat);';
        $stm = $this->db->prepare($query1);
        $res1 = $stm->execute(array(
            ":id" => NULL,
            ":postid" => mysql_real_escape_string($this->ChannelId),
            ":uid" => mysql_real_escape_string($this->UserId),
            ":msg" => mysql_real_escape_string($this->postBaseData["msg"]),
            ":doc" => date("Y-m-d H:i:s"),
            ":stat" => $jsondata["stat"],
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 1;
            $jsondata["post_id"] = $this->ChannelId;
        } elseif (is_resource($res1))
            $this->db->rollBack();
        return $jsondata;
    }
    public function removeAdmin() {
        $res3 = '';
        $channel_id = !empty($this->postBaseData["details"]["channelID"]) ? $this->postBaseData["details"]["channelID"] : 0;
        $user_id = !empty($this->postBaseData["details"]["UserId"]) ? $this->postBaseData["details"]["UserId"] : 0;
        $jsondata = array(
            "channel_id" => $channel_id,
            "user_id" => $user_id,
            "stat" => 6,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query3 = 'UPDATE `channel_roles` SET `status_id` = :stat  WHERE `channel_id` = :cid AND `user_id` = :uid;';
        $stm = $this->db->prepare($query3);
        $res3 = $stm->execute(array(
            ":stat" => mysql_real_escape_string(6),
            ":cid" => mysql_real_escape_string($channel_id),
            ":uid" => mysql_real_escape_string($user_id),
        ));
        if ($res3) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["channel_id"] = $channel_id;
            $jsondata["user_id"] = $user_id;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function ChannelBG() {
        $location = 0;
        $icon = $res1 = $res2 = 0;
        $jsondata = array(
            "stat" => 4,
            "post_id" => $icon,
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
                $query2 = 'UPDATE `channel` SET `channel_background` = :icon WHERE `user_id` = :uid AND `id` = :chid;';
                $stm = $this->db->prepare($query2);
                $res2 = $stm->execute(array(
                    ":icon" => mysql_real_escape_string($icon),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":chid" => mysql_real_escape_string($this->ChannelId),
                ));
                $_SESSION["ChannelDetails"]["channel"]["channel_icon"] = $this->config["URL"] . $photo['version_2'];
                /*
                  $query2 = 'INSERT INTO `post`(`title`,`photo_id`,`user_id`,`post_location`,`status_id`,`created_at`)Values('
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
                $jsondata["post_id"] = $icon;
            } else {
                $this->db->rollBack();
            }

            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
    public function ChannelIcon() {
        $location = 0;
        $icon = $res1 = $res2 = 0;
        $jsondata = array(
            "stat" => 4,
            "post_id" => $icon,
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
                $query2 = 'UPDATE `channel` SET `channel_icon` = :icon WHERE `user_id` = :uid AND `id` = :chid;';
                $stm = $this->db->prepare($query2);
                $res2 = $stm->execute(array(
                    ":icon" => mysql_real_escape_string($icon),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":chid" => mysql_real_escape_string($this->ChannelId),
                ));
                $_SESSION["ChannelDetails"]["channel"]["channel_background"] = $this->config["URL"] . $photo['version_2'];
                /*
                  $query2 = 'INSERT INTO `post`(`title`,`photo_id`,`user_id`,`post_location`,`status_id`,`created_at`)Values('
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
                $jsondata["post_id"] = $icon;
            } else {
                $this->db->rollBack();
            }

            if (isset($_SESSION['Individual_POST_PATH'])) {
                unset($_SESSION['Individual_POST_PATH']);
            }
        }
        return $jsondata;
    }
    public function ReportChannel() {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["reportID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `channel_report` WHERE `report_id` = :prefId AND `user_id` = :uid AND `channel_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":prefId" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["channelID"]),
        ));
        $count = $stm->rowCount();
        if ($count == 0) {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `channel_report` (`id`,`channel_id`,`user_id`,`report_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["channelID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":doc" => date("Y-m-d H:i:s"),
                ":stat" => 4,
            ));
        } else {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `channel_report` SET `report_id` = :prefId WHERE `channel_id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["channelID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["channelID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function SubscribeChannel($channelID = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->ChannelId == $channelID) {
            $query = 'SELECT `id` FROM `channel` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->ChannelId),
            ));
            $count = $stm->rowCount();
            if ($count === 0) {
                $query = 'SELECT `id` FROM `channel` WHERE `status_id` = :stat AND `id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 4,
                    ":postid" => mysql_real_escape_string($this->ChannelId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    //$query = 'SELECT `id` FROM `channel_subscribe` WHERE `status_id` = :prefId AND `user_id` = :uid AND `channel_id` = :postid;';
                    $query = 'SELECT `id` FROM `channel_subscribe` WHERE `user_id` = :uid AND `channel_id` = :postid;';
                    $stm = $this->db->prepare($query);
                    $res = $stm->execute(array(
                        //":prefId" => $jsondata["stat"],
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":postid" => mysql_real_escape_string($this->ChannelId),
                    ));
                    $count = $stm->rowCount();
                    if ($count === 0) {
                        $this->db->beginTransaction();
                        $query1 = 'INSERT INTO  `channel_subscribe` (`channel_id`,`user_id`,`created_at`,`status_id`) 
                                    VALUES(:postid,:uid,:doc,:stat);';
                        $stm = $this->db->prepare($query1);
                        $res1 = $stm->execute(array(
                            ":postid" => mysql_real_escape_string($this->ChannelId),
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":doc" => date("Y-m-d H:i:s"),
                            ":stat" => $jsondata["stat"],
                        ));
                    } else {
                        $query = 'SELECT `id` FROM `channel_subscribe` WHERE `status_id` = :prefId AND `user_id` = :uid AND `channel_id` = :postid;';
                        $stm = $this->db->prepare($query);
                        $res = $stm->execute(array(
                            ":prefId" => 35,
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":postid" => mysql_real_escape_string($this->ChannelId),
                        ));
                        $count = $stm->rowCount();
                        if ($count > 0) {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `channel_subscribe` SET `status_id` = :prefId WHERE `channel_id` = :postid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => $jsondata["stat"],
                                ":postid" => mysql_real_escape_string($this->ChannelId),
                                ":uid" => mysql_real_escape_string($this->UserId),
                            ));
                        } else {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `channel_subscribe` SET `status_id` = :prefId WHERE `channel_id` = :postid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => 35,
                                ":postid" => mysql_real_escape_string($this->ChannelId),
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
                $jsondata["post_id"] = $this->ChannelId;
            } else if (is_resource($res1))
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function BlockChannel($channelID = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->ChannelId == $channelID) {
            $query = 'SELECT `id` FROM `channel` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->ChannelId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `channel` SET `status_id` = :stat WHERE `id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => 38,
                    ":postid" => mysql_real_escape_string($this->ChannelId),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $query = 'SELECT `id` FROM `channel` WHERE `status_id` = :stat AND `id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 4,
                    ":postid" => mysql_real_escape_string($this->ChannelId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    $query = 'SELECT `id` FROM `channel_block` WHERE `status_id` = :prefId AND `user_id` = :uid AND `channel_id` = :postid;';
                    $stm = $this->db->prepare($query);
                    $res = $stm->execute(array(
                        ":prefId" => $jsondata["stat"],
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":postid" => mysql_real_escape_string($this->ChannelId),
                    ));
                    $count = $stm->rowCount();
                    if ($count == 0) {
                        $this->db->beginTransaction();
                        $query1 = 'INSERT INTO  `channel_block` (`id`,`channel_id`,`user_id`,`created_at`,`status_id`) 
                                    VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
                        $stm = $this->db->prepare($query1);
                        $res1 = $stm->execute(array(
                            ":id" => NULL,
                            ":postid" => mysql_real_escape_string($this->ChannelId),
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":doc" => date("Y-m-d H:i:s"),
                            ":stat" => 4,
                        ));
                    } else {
                        $query = 'SELECT `id` FROM `channel_block` WHERE `status_id` = :prefId AND `user_id` = :uid AND `channel_id` = :postid;';
                        $stm = $this->db->prepare($query);
                        $res = $stm->execute(array(
                            ":prefId" => 39,
                            ":uid" => mysql_real_escape_string($this->UserId),
                            ":postid" => mysql_real_escape_string($this->ChannelId),
                        ));
                        $count = $stm->rowCount();
                        if ($count == 0) {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `channel_block` SET `status_id` = :prefId WHERE `channel_id` = :postid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => $jsondata["stat"],
                                ":postid" => mysql_real_escape_string($this->ChannelId),
                                ":uid" => mysql_real_escape_string($this->UserId),
                            ));
                        } else {
                            $this->db->beginTransaction();
                            $query1 = 'UPDATE `channel_block` SET `status_id` = :prefId WHERE `channel_id` = :postid AND `user_id` = :uid;';
                            $stm = $this->db->prepare($query1);
                            $res1 = $stm->execute(array(
                                ":prefId" => 39,
                                ":postid" => mysql_real_escape_string($this->ChannelId),
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
                $jsondata["post_id"] = $this->ChannelId;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function likeChannel($param = false) {
        $jsondata = array(
            "count" => $this->LikeChannelCount($param),
            "post_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->ChannelId == $param) {
            $query = 'SELECT `id` FROM `channel_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `channel_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count === 0) {
                $query = 'SELECT `id` FROM `channel_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `channel_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 37,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `channel_likes` SET `status_id` = :stat, `created_at`:= :doc WHERE `channel_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":stat" => $jsondata["stat"],
                        ":doc" => date("Y-m-d H:i:s"),
                        ":postid" => mysql_real_escape_string($param),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `channel_likes` (`id`,`channel_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($param),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => $jsondata["stat"],
                    ));
                }
                if ($res1) {
                    $this->db->commit();
                    $jsondata["status"] = "success";
                    $jsondata["count"] = $this->LikeChannelCount($param);
                    $jsondata["post_id"] = $param;
                } else
                    $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function disLikeChannel($param = false) {
        $jsondata = array(
            "count" => $this->LikeChannelCount($param),
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        if ($this->ChannelId == $param) {
            $query = 'SELECT `id` FROM `channel_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `channel_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count === 0) {
                $query = 'SELECT `id` FROM `channel_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `channel_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":stat" => 36,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `channel_likes` SET `status_id`  = :stat, `created_at`:= :doc WHERE `channel_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":stat" => $jsondata["stat"],
                        ":doc" => date("Y-m-d H:i:s"),
                        ":postid" => mysql_real_escape_string($param),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `channel_likes` (`id`,`channel_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($param),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => $jsondata["stat"],
                    ));
                }
                if ($res1) {
                    $this->db->commit();
                    $jsondata["status"] = "success";
                    $jsondata["count"] = $this->LikeChannelCount($param);
                    $jsondata["post_id"] = $param;
                } else
                    $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function LikeChannelCount($param = false) {
        $query = 'SELECT `id` FROM `channel_likes` WHERE `status_id` = :stat AND `channel_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function UpdateChannelDetails() {
        $location = 0;
        $res1 = '';
        $res3 = '';
        $jsondata = array(
            "name" => $this->postBaseData["details"]["name"],
            "target" => isset($this->postBaseData["details"]["target"]) ? $this->postBaseData["details"]["target"] : false,
            "continent" => isset($this->postBaseData["details"]["continent"]) ? $this->postBaseData["details"]["continent"] : false,
            "countries" => isset($this->postBaseData["details"]["countries"]) ? (array) $this->postBaseData["details"]["countries"] : false,
            "langauges" => isset($this->postBaseData["details"]["langauges"]) ? (array) $this->postBaseData["details"]["langauges"] : false,
            "channel_id" => 0,
            "stat" => 4,
            "status" => 'error'
        );
        $this->db->beginTransaction();
        $query3 = 'UPDATE `channel` SET `channel_name` = :name,
                        `channel_description` = :des,
                        `channel_updated_at` = :now,
                        `channel_website` = :web,
                        `channel_facebook` = :fb,
                        `channel_googleplus` = :gp,
                        `channel_twitter` = :twt
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
            ":id" => mysql_real_escape_string($this->ChannelId),
        ));
        $admins = (array) $this->postBaseData["details"]["admins"];
        for ($i = 0; $i < count($admins) && $i < 5; $i++) {
            $query1 = 'INSERT INTO `channel_roles` (`channel_id`,`user_id`,`role_id`,`created_at`) VALUES(
                :id1,:id2,:id3,:id4);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($this->ChannelId),
                ":id2" => mysql_real_escape_string($admins[$i]),
                ":id3" => mysql_real_escape_string(3),
                ":id4" => mysql_real_escape_string(date("Y-m-d H:i:s")),
            ));
        }
        if ($res3 && $res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["channel_id"] = $this->ChannelId;
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }
    public function shareChannel($param = false) {
        
    }
}
?>