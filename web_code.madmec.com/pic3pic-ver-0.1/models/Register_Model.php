<?php
class Register_Model extends BaseModel {

    private $postData;

    function __construct() {
        parent::__construct();
        //$this->postData = $this->postBaseData;
    }
    public function getPostData() {
        return $this->postData;
    }
    public function setPostData($para, $base = false) {
        if (isset($para))
            $this->postData = $para;
        if (isset($base) && $base)
            $this->setPostBaseData($para);
    }
    public function signUp() {
        $jsondata = array(
            "name" => $this->postData["details"]["name"],
            "email" => $this->postData["details"]["email"],
            "pass" => $this->postData["details"]["pass"],
            "stat" => 4,
            "type" => 2,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT `email` FROM `user_profile` WHERE `email`= :email');
        $res = $stm->execute(array(
            ":email" => mysql_real_escape_string($this->postBaseData["details"]["email"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `photo` (`id`)  VALUES(:id);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL
            ));
            $picid = $this->db->lastInsertId();
            $query2 = 'INSERT INTO `user_profile`(`id`,`user_name`,`email`,`icon`,`password`,`apassword`,`status_id`,`user_type_id`)Values('
                    . ':id1,:id2,:id3,:id4,:id5,MD5(:id6),:id7,:id8)';
            $stm = $this->db->prepare($query2);
            $res2 = $stm->execute(array(
                ":id1" => NULL,
                ":id2" => mysql_real_escape_string($this->postData["details"]["name"]),
                ":id3" => mysql_real_escape_string($this->postData["details"]["email"]),
                ":id4" => mysql_real_escape_string($picid),
                ":id5" => mysql_real_escape_string($this->postData["details"]["pass"]),
                ":id6" => mysql_real_escape_string($this->postData["details"]["pass"]),
                ":id7" => mysql_real_escape_string($jsondata["stat"]),
                ":id8" => mysql_real_escape_string($jsondata["type"])
            ));
            $user_pk = $this->db->lastInsertId();
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
            $query3 = 'UPDATE `user_profile` SET `directory` = :id1 WHERE `id`=:id2';
            $stm = $this->db->prepare($query3);
            $res3 = $stm->execute(array(
                ":id1" => mysql_real_escape_string($directory),
                ":id2" => $user_pk
            ));
            if ($res1 && $res2 && $res3) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }
}
?>