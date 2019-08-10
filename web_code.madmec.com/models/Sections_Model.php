<?php
class Sections_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function getSectionsNames($listtype = false) {
        //$list = (array) $this->idHolders["wall"]["channel"]["list"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
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
                    $data["html"] .= '<li><input type="checkbox" name="sections_' . $i . '" id="sections_' . $i . '" value="' . $result[$i]["id"] . '" checked="checked" />&nbsp;&nbsp;' . $result[$i]["section_name"] . '</li>';
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
}
?>