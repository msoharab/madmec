<?php

class Profile_Model extends BaseModel {

    private $para, $logindata, $UserId;

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
        $id=$this->UserId;
        $d=date("Y-m-d H:i:s",time());
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

}

?>