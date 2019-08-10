<?php
class Header_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function ListContinents($listtype = false) {
        //$list = (array) $this->idHolders["nookleads"]["business"]["list"];
        $data = array(
            "data" => array(),
            "html" => '',
            "count" => 0,
            "id" => 'continentsH_',
            "class" => 'contiCheckH',
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
        $stm = $this->db->prepare('SELECT * FROM `sections_index_lead` WHERE `status_id` = :stat ORDER BY `section_name`');
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