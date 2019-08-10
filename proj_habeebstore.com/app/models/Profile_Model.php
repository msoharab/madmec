<?php

class Profile_Model extends BaseModel {

    private $para, $logindata, $UserId, $GymId, $GymData;

    function __construct() {
        parent::__construct();
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }

    public function changePassword() {
        $jsondata = array(
            "oldpass" => $this->postBaseData["oldpass"],
            "newpass" => $this->postBaseData["newpass"],
            "confrmpass" => $this->postBaseData["confrmpass"],
            "stat" => 4,
            "status" => 'error'
        );
        $id = $this->UserId;
        $d = date("Y-m-d H:i:s", time());
        $this->db->beginTransaction();
        $stm = $this->db->prepare('SELECT * FROM `user_profile` WHERE `id`= :id');
        $res = $stm->execute(array(
            ":id" => ($id)
        ));
        $res = $stm->execute();
        if ($res) {
            $result = $stm->fetchAll();
            $data["data"] = $result;
        }
        $old = $result[0]["password"];
        if (($jsondata["oldpass"]) !== $old) {
            $jsondata["status"] = "error";
        } else if (($jsondata["newpass"]) === $old) {
            $jsondata["status"] = "alreadyexist";
        } else {
            $query1 = 'UPDATE `user_profile` SET
                           `password`=:id1,
                           `apassword`=MD5(:id2),
                           `status`=:id3
                           WHERE `id`=:id';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id1" => ($jsondata["newpass"]),
                ":id2" => ($jsondata["confrmpass"]),
                ":id3" => ($jsondata["stat"]),
                ":id" => ($id)
            ));
            if ($res && $res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function changeEmail() {
        $jsondata = array(
            "emails" => (array) json_decode($this->postBaseData["emails"]),
            "stat" => 4,
            "status" => 'error'
        );
        $id = $this->UserId;
        $d = date("Y-m-d H:i:s", time());
        $this->db->beginTransaction();
        $data = array();
        if (count($jsondata["emails"]["mail"]) > 0) {
            for ($i = 0; $i < count($jsondata["emails"]["mail"]); $i++) {
                $data[] = array(
                    "user_pk" => $id,
                    "email" => $jsondata["emails"]["mail"][$i],
                );
            }
            $datafields = array("`user_pk`", "`email`");
            $question_marks = array();
            $insert_values = array();
            foreach ($data as $d) {
                $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                $insert_values = array_merge($insert_values, array_values($d));
            }
            $stm = $this->db->prepare('SELECT * FROM `user_email_ids` WHERE `id`= :id');
            $res = $stm->execute(array(
                ":id" => ($id)
            ));
            $res = $stm->execute();
            if ($res) {
                $result = $stm->fetchAll();
                $data["data"] = $result;
            }
            $email = $result[0]["email"];
            if (($jsondata["emails"]) === $email) {
                $jsondata["status"] = "alreadyexist";
            } else {
//                $query2 = 'UPDATE `user_email_ids` SET ' . implode(',', $datafields);
//                $stm2 = $this->db->prepare($query2);
//                $res2 = $stm2->execute($insert_values);
                $query1 = 'UPDATE `user_email_ids` SET
                           `email`=:id1,
                           `status`=:id2
                           WHERE `id`=:id';
                $stm1 = $this->db->prepare($query1);
                $res1 = $stm1->execute(array(
                    ":id1" => ($jsondata["emails"]),
                    ":id2" => ($jsondata["stat"]),
                    ":id" => ($id)
                ));
            }
            if ($res && $res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
            } else {
                $this->db->rollBack();
            }
        }
        return $jsondata;
    }

    public function changeCell() {
        $jsondata = array(
            "cellnumner" => (array) json_decode($this->postBaseData["cellnumner"]),
            "stat" => 4,
            "status" => 'error'
        );
        $id = $this->UserId;
        $d = date("Y-m-d H:i:s", time());
        $this->db->beginTransaction();
        $data = array();
        if (count($jsondata["cellnumner"]["num"]) > 0) {
            for ($i = 0; $i < count($jsondata["cellnumner"]["num"]); $i++) {
                $data[] = array(
                    "id" => $id,
                    "cell_code" => $jsondata["cellnumner"]["cod"][$i],
                    "cell_number" => $jsondata["cellnumner"]["num"][$i],
                );
            }
            $datafields = array("`user_pk`", "`cell_code`", "`cell_number`");
            $question_marks = array();
            $insert_values = array();
            foreach ($data as $d) {
                $question_marks[] = '(' . $this->placeholders('?', count($d)) . ')';
                $insert_values = array_merge($insert_values, array_values($d));
            }
            $query1 = 'UPDATE `user_cell_numbers`SET
                           `cell_code`=:id1,
                           `cell_number`=:id2,
                           `status`=:id3
                           WHERE `id`=:id';
            $stm1 = $this->db->prepare($query1);
            $res1 = $stm1->execute(array(
                ":id1" => ($jsondata["cellnumner"]["cod"][$i]),
                ":id2" => ($jsondata["cellnumner"]["num"][$i]),
                ":id3" => ($jsondata["stat"]),
                ":id" => ($id)
            ));
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

    public function changePic() {
        $jsondata = array(
            "picids" => array(),
            "stat" => 4,
            "status" => 'error'
        );
        $id = $this->UserId;
        $d = date("Y-m-d H:i:s", time());
        $this->db->beginTransaction();
        $query0 = 'INSERT INTO `photo` (`id`) VALUES (NULL);';
        $stm0 = $this->db->prepare($query0);
        $res0 = $stm0->execute();
        $pic = $this->db->lastInsertId();
        array_push($jsondata["picids"], $pic);
        $query1 = 'UPDATE `user_profile` SET
                           `photo_id`=:id1,
                           `status`=:id2
                           WHERE `id`=:id';
        $stm1 = $this->db->prepare($query1);
        $res1 = $stm1->execute(array(
            ":id1" => ($pic),
            ":id2" => ($jsondata["stat"]),
            ":id" => ($id)
        ));
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
        } else {
            $this->db->rollBack();
        }
        return $jsondata;
    }

}

?>