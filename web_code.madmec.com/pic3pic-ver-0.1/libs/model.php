<?php
class BaseModel extends configure {

    protected $db, $postBaseData, $configBase;

    public function __construct() {
        parent::__construct();
        $this->db = new dataBase();
        $this->postBaseData = NULL;
    }
    public function getPostBaseData() {
        return $this->postBaseData;
    }
    public function setPostBaseData($para) {
        if (isset($para))
            $this->postBaseData = $para;
    }
    public function checkEmailDB() {
        $data = array(
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT `email` FROM `user_profile` WHERE `email`= :email');
        $res = $stm->execute(array(
            ":email" => mysql_real_escape_string($this->postBaseData["email"])
        ));
        if ($res) {
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function ListCountries() {
        $data = array(
            "data" => '',
            "html" => '',
            "count" => 0,
            "status" => 'failed'
        );
        $stm = $this->db->prepare('SELECT * FROM `pic3pic_countries` ORDER BY `Country`');
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
            $data["count"] = $stm->rowCount();
            $data["status"] = 'success';
        }
        for ($i = 0; $i < $data["count"]; $i++) {
            $data["html"] .= '<option value="' . $result[$i]["id"] . '">' . $result[$i]["Country"] . '</option>';
        }
        //$data = $stm->fetchAll();
        return $data;
    }
    public function placeholders($text, $count = 0, $separator = ",") {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; $x++) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }
}
?>