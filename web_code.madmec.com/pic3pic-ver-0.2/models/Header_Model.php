<?php
class Header_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function ListContinents($listtype = false) {
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'continentsH_',
            "class" => 'contiCheckH',
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
                    $data["html"] .= '<li style="cursor:pointer"><input type="checkbox" name="continentsH_" class="contiCheckH" id="continentsH_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["continent_name"]) . '</li><li class="divider">&nbsp;</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="radio" name="continentsH_" class="contiCheckH" id="continentsH_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["continent_name"]) . '</li><li class="divider">&nbsp;</li>';
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
            "id" => 'countriesH_',
            "class" => 'contrCheckH',
            "status" => 'failed'
        );
        $in = '';
        if (isset($this->postBaseData["cont_id"]) && is_array($this->postBaseData["cont_id"])) {
            $in = implode(',', $this->postBaseData["cont_id"]);
        }
        $stm = $this->db->prepare('SELECT GROUP_CONCAT(TRIM(contr.`id`) SEPARATOR  "♥☻♥") AS ids,
                                        GROUP_CONCAT(TRIM(contr.`Country`) SEPARATOR  "♥☻♥") AS cont_names,
                                        TRIM(conti.`continent_name`) AS continent_name
                                    FROM `pic3pic_countries` AS contr 
                                    LEFT JOIN `pic3pic_continents` AS conti ON conti.`id` = contr.`continent_id`
                                    WHERE contr.`status_id` = :stat 
                                    AND contr.`continent_id` IN (' . $in . ') 
                                    GROUP BY (contr.`continent_id`)
                                    ORDER BY contr.`id`');
        $res = $stm->execute(array(
            ":stat" => 4,
        ));
        $res = $stm->execute();
        $newRes = array();
        if ($res) {
            $result = $stm->fetchAll();
            for ($i = 0; $i < $stm->rowCount(); $i++) {
                $ids = (array) explode("♥☻♥",$result[$i]['ids']);
                $cont_names = (array) explode("♥☻♥",$result[$i]['cont_names']);
                array_push($newRes, array(
                    "continent" => $result[$i]["continent_name"],
                    "ids" => (array) $ids,
                    "cont_names" => (array) $cont_names,
                ));
            }
            for ($i = 0; $i < sizeof($newRes); $i++) {
                $data["count"] += count($ids);
            }
            //$data["data"] = $newRes;
            $data["status"] = 'success';
        }
        switch ($listtype) {
            case "checkbox":
                for ($i = 0, $num = 0; $i < sizeof($newRes); $i++) {
                    $data["html"] .= '<li style="cursor:pointer">&nbsp;&nbsp;<strong>' . ucfirst($newRes[$i]["continent"]) . '</strong></li><li class="clearfix divider">&nbsp;</li>';
                    array_push($data["data"], array(
                        "continent" => $newRes[$i]["continent"],
                        "ids" => $newRes[$i]["ids"],
                        "cont_names" => $newRes[$i]["cont_names"],
                    ));
                    for ($j = 0; $j < sizeof($newRes[$i]["ids"]); $j++, $num++) {
                        $data["html"] .= '<li style="cursor:pointer"><input type="checkbox" class="contrCheckH" name="countriesH_" id="countriesH_' . $num . '" value="' . $newRes[$i]["ids"][$j] . '" />&nbsp;&nbsp;' . $newRes[$i]["cont_names"][$j] . '</li><li class="divider">&nbsp;</li>';
                    }
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="radio" class="contrCheckH" name="countriesH_" id="countriesH_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["Country"]) . '</li><li class="divider">&nbsp;</li>';
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
            "id" => 'languagesH_',
            "class" => 'langCheckH',
            "status" => 'failed'
        );
        $in = '';
        if (isset($this->postBaseData["countries_id"]) && is_array($this->postBaseData["countries_id"])) {
            $in = implode(',', $this->postBaseData["countries_id"]);
        }
        $stm = $this->db->prepare('SELECT 
                                    GROUP_CONCAT(TRIM(contr.`id`) SEPARATOR  "♥☻♥") AS ids,
                                    GROUP_CONCAT(TRIM(contr.`Language Name`) SEPARATOR  "♥☻♥") AS cont_names,
                                    TRIM(conti.`Country`) AS continent_name
                                FROM `pic3pic_languages`  AS contr
                                LEFT JOIN `pic3pic_countries` AS conti ON conti.`id` = contr.`country_id`
                                WHERE contr.`status_id` = :stat 
                                AND contr.`country_id` IN (' . $in . ')
                                GROUP BY (contr.`country_id`)
                                ORDER BY contr.`id`');
        $res = $stm->execute(array(
            ":stat" => 4,
        ));
        $res = $stm->execute();
        $newRes = array();
        if ($res) {
            $result = $stm->fetchAll();
            for ($i = 0; $i < $stm->rowCount(); $i++) {
                $ids = (array) explode("♥☻♥",$result[$i]['ids']);
                $cont_names = (array) explode("♥☻♥",$result[$i]['cont_names']);
                array_push($newRes, array(
                    "continent" => $result[$i]["continent_name"],
                    "ids" => (array) $ids,
                    "cont_names" => (array) $cont_names,
                ));
            }
            for ($i = 0; $i < sizeof($newRes); $i++) {
                $data["count"] += count($ids);
            }
            //$data["data"] = $newRes;
            //$data["status"] = 'success';
            //$data["data"] = $result;
            //$data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        switch ($listtype) {
            case "checkbox":
                for ($i = 0, $num = 0; $i < sizeof($newRes); $i++) {
                    $data["html"] .= '<li style="cursor:pointer">&nbsp;&nbsp;<strong>' . ucfirst($newRes[$i]["continent"]) . '</strong></li><li class="clearfix divider">&nbsp;</li>';
                    array_push($data["data"], array(
                        "continent" => $newRes[$i]["continent"],
                        "ids" => $newRes[$i]["ids"],
                        "cont_names" => $newRes[$i]["cont_names"],
                    ));
                    for ($j = 0; $j < sizeof($newRes[$i]["ids"]); $j++, $num++) {
                        $data["html"] .= '<li style="cursor:pointer"><input type="checkbox" class="langCheckH" name="languagesH_" id="languagesH_' . $num . '" value="' . $newRes[$i]["ids"][$j] . '" />&nbsp;&nbsp;' . $newRes[$i]["cont_names"][$j] . '</li><li class="divider">&nbsp;</li>';
                    }
                }
                /*
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="checkbox" class="langCheckH" name="langCheckH" id="languagesH_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["Language Name"]) . '</li><li class="divider">&nbsp;</li>';
                }
                */
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="radio" class="langCheckH" name="languagesH_" id="languagesH_' . $i . '" value="' . $result[$i]["id"] . '" />&nbsp;&nbsp;' . ucfirst($result[$i]["cont_names"]) . '</li><li class="divider">&nbsp;</li>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . ucfirst($result[$i]["cont_names"]) . '</option>';
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
            "class" => 'secCheckH',
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
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="checkbox" class="secCheckH" name="sectionsH_" id="sectionsH_' . $i . '" value="' . $result[$i]["id"] . '" checked="checked" />&nbsp;&nbsp;' . $result[$i]["section_name"] . '</li><li class="divider">&nbsp;</li>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<li style="cursor:pointer"><input type="radio" class="secCheckH" name="sectionsH_" id="sectionsH_' . $i . '" value="' . $result[$i]["id"] . '" checked="checked" />&nbsp;&nbsp;' . $result[$i]["section_name"] . '</li><li class="divider">&nbsp;</li>';
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
}
?>