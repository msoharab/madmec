<?php
class BaseModel extends configure {

    protected $db, $postBaseData, $configBase;

    public function __construct() {
        parent::__construct();
        $this->db = new dataBase();
        $this->db->query('SET SESSION group_concat_max_len=18446744073709551615');
        $this->postBaseData = NULL;
    }
    public function getPostData() {
        return $this->postBaseData;
    }
    public function setPostData($para) {
        if (isset($para))
            $this->postBaseData = $para;
    }
    public function setIdHolders($para = false) {
        $this->idHolders = $para;
    }
    public function getIdHolders() {
        return $this->idHolders;
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
    /* Query Builder */
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