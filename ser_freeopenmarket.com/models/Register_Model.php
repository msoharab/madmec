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
            "socailid" => isset($this->postBaseData["details"]["socailid"]) && !empty($this->postBaseData["details"]["socailid"]) ? $this->postBaseData["details"]["socailid"] : NULL,
            "stat" => 4,
            "type" => 9,
            "status" => 'error'
        );
        $user_pk = 0;
        $stat = $this->checkEmailDB($this->postBaseData["details"]["email"]);
        if (isset($stat["status"]) && $stat["status"] === 'success') {
            $jsondata["status"] = "alreadyexist";
        } else {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `portal_photo` (`id`)  VALUES(:id);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL
            ));
            $picid = $this->db->lastInsertId();
            $query2 = 'INSERT INTO `users`(`users_pk`,'
                    . '`user_name`,'
                    . '`user_email`,'
                    . '`user_photo_id`,'
                    . '`user_socail_id`,'
                    . '`user_password`,'
                    . '`user_apassword`,'
                    . '`user_type_id`'
                    . ')Values('
                    . ':id1,:id2,:id3,:id4,:id5,:id6,MD5(:id7),:id8)';
            $stm = $this->db->prepare($query2);
            $res2 = $stm->execute(array(
                ":id1" => NULL,
                ":id2" => ($this->postBaseData["details"]["name"]),
                ":id3" => ($this->postBaseData["details"]["email"]),
                ":id4" => ($picid),
                ":id5" => ($jsondata["socailid"]),
                ":id6" => ($this->postBaseData["details"]["pass"]),
                ":id7" => ($this->postBaseData["details"]["pass"]),
                ":id8" => ($jsondata["type"]),
            ));
            $user_pk = $this->db->lastInsertId();
            $directory = $this->createdirectories(substr(md5(microtime()), 0, 6) . '_user_' . $user_pk);
            $query3 = 'UPDATE `users` SET `user_directory` = :id1 WHERE `users_pk`=:id2';
            $stm = $this->db->prepare($query3);
            $res3 = $stm->execute(array(
                ":id1" => ($directory),
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
        return $this->welcomeUser();
    }

    public function welcomeUser() {
        $jsondata = $this->CustomerLoginByEmail($this->postBaseData["details"]["email"]);
        return $jsondata;
    }

}

?>