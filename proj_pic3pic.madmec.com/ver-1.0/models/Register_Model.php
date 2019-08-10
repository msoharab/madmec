<?php
class Register_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function signUp() {
        $jsondata = array(
            "name" => $this->postBaseData["details"]["name"],
            "email" => $this->postBaseData["details"]["email"],
            "pass" => $this->postBaseData["details"]["pass"],
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
                ":id2" => mysql_real_escape_string($this->postBaseData["details"]["name"]),
                ":id3" => mysql_real_escape_string($this->postBaseData["details"]["email"]),
                ":id4" => mysql_real_escape_string($picid),
                ":id5" => mysql_real_escape_string($this->postBaseData["details"]["pass"]),
                ":id6" => mysql_real_escape_string($this->postBaseData["details"]["pass"]),
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
        sleep(1);
        $this->welcomeUser($user_pk);
        return $jsondata;
    }
    public function welcomeUser($uid = false){
        $jsondata = array(
            "email" => '',
            "pass" => '',
            "loggedin" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT 
            t1.*,
            CASE WHEN t1.`icon` IS NULL OR t1.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
            END AS profic
            FROM `user_profile` AS t1 
            LEFT JOIN `photo` AS ph1 ON t1.`icon` = ph1.`id`
            WHERE t1.`id`= :uid');
        $res = $stm->execute(array(
            ":uid" => mysql_real_escape_string($uid),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "success";
            $jsondata["loggedin"] = 1;
            $_SESSION["USERDATA"] = $jsondata;
            $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["USERDATA"]["logindata"] = $temp[0];
        }
    }
}
?>