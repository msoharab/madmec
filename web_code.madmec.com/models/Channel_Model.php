<?php
class Channel_Model extends BaseModel {
    function __construct() {
        parent::__construct();
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
            "channel_id" => 0,
            "stat" => 4,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT COUNT(`user_id`) FROM `channel` WHERE `user_id`= :user_id AND `status_id`= :status_id');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["id"]),
            ":status_id" => mysql_real_escape_string($jsondata["stat"])
        ));
        $count = $stm->rowCount();
        if ($count >= 5) {
            $jsondata["status"] = "Your quota is finished.";
        } else {
            $this->db->beginTransaction();
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
            $stm = $this->db->prepare($query3);
            $res3 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["id"]),
                ":id2" => mysql_real_escape_string($jsondata["name"]),
                ":id3" => mysql_real_escape_string($location),
                ":id4" => mysql_real_escape_string($icon),
                ":id5" => mysql_real_escape_string($background),
                ":id6" => mysql_real_escape_string($jsondata["stat"])
            ));
            $channel_pk = $this->db->lastInsertId();

            if ($jsondata["target"] > 0) {
                $data = array();
                for ($i = 0; $i < sizeof($jsondata["countries"]); $i++) {
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
                    $question_marks[] = '(' . $this->placeholders('?', sizeof($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query4 = 'INSERT INTO `channel_countries` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query4);
                $res4 = $stm->execute($insert_values);


                $data = array();
                for ($i = 0; $i < sizeof($jsondata["langauges"]); $i++) {
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
                    $question_marks[] = '(' . $this->placeholders('?', sizeof($d)) . ')';
                    $insert_values = array_merge($insert_values, array_values($d));
                }
                $query5 = 'INSERT INTO `channel_languages` (' . implode(",", $datafields) . ') VALUES ' . implode(',', $question_marks);
                $stm = $this->db->prepare($query5);
                $res5 = $stm->execute($insert_values);
            }
            if ($res1 && $res2 && $res3 && $jsondata["target"] == 0) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["channel_id"] = $channel_pk;
            } else if ($res1 && $res2 && $res3 && $res4 && $res5 && $jsondata["target"] > 0) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["channel_id"] = $channel_pk;
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
    public function ListChannels() {
        $list = (array) $this->idHolders["wall"]["channel"]["list"];
        $create = (array) $this->idHolders["wall"]["channel"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "stat" => 4,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `channel` WHERE `user_id`= :user_id AND `status_id`= :status_id ORDER BY `channel_created_at` DESC');
        $res = $stm->execute(array(
            ":user_id" => mysql_real_escape_string($_SESSION["USERDATA"]["logindata"]["id"]),
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
            $data["html"] .= '<a class="list-group-item"  id="' . $list["item"] . '_' . $i . '" href="' . $this->config["URL"] . $this->config["CTRL_1"] . 'View/' . base64_encode($result[$i]["id"]) . '">' . $result[$i]["channel_name"] . '</a>';
        }
        if ($data["count"] <= 5) {
            $data["html"] .= '<button type="button" data-toggle="modal" data-target="#' . $create["create"]["parentDiv"] . '" data-whatever="@mdo" class="list-group-item btn btn-block btn-default" id="' . $create["moodalBut"] . '">Create Channel</button>';
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function ListContinents($listtype = false) {
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
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
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
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
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'languagesCh_',
            "class" => 'langSelCH',
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
                    $data["html"] .= '<li><input type="checkbox" name="languagesCh_" class="langSelCH" id="languagesCh_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst(trim($result[$i]["Language Name"])) . '</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="radio" class="langSelCH" name="languagesCh_" id="languagesCh_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst(trim($result[$i]["Language Name"])) . '</li><li class="divider">&nbsp;</li>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst(trim($result[$i]["Language Name"])) . '</option>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function View() {
    }
}
?>