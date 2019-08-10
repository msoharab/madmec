<?php
class Languages_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function ListLanguages($listtype = false) {
        //$list = (array) $this->idHolders["pic3pic"]["channel"]["list"];
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `pic3pic_languages` WHERE `status_id` = :stat ORDER BY `Country`');
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
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . $result[$i]["Language Name"] . '</option>';
                }
                break;
            case "radio":
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . $result[$i]["Language Name"] . '</option>';
                }
                break;
            default:
                for ($i = 0; $i < $data["count"]; $i++) {
                    $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . $result[$i]["Language Name"] . '</option>';
                }
                break;
        }
        //$data = $stm->fetchAll();
        return $data;
    }
}
?>