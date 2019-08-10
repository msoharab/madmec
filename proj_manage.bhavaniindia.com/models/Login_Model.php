<?php
class Login_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function signIn() {
        $jsondata = array(
            "name" => $this->postBaseData["name"],
            "pass" => $this->postBaseData["pass"],
            "loggedin" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT *
            FROM `user_profile`
            WHERE `user_name`   = :name
            AND `password` = :pass
            AND `status` = :stat
            ');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":pass" => ($jsondata["pass"]),
            ":stat" => 4,
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "success";
            $jsondata["loggedin"] = 1;
            $_SESSION["USERDATA"] = $jsondata;
            $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["USERDATA"]["logindata"] = $temp[0];
            $this->updateUserlog();
        }
        return $jsondata;
    }
    public function forgotPassword() {
        if (isset($this->postBaseData["email"])) {
            $jsondata = array(
                "email" => $this->postBaseData["email"],
                "loggedin" => 0,
                "status" => 'error'
            );
            if ($this->validateEmail($jsondata["email"]) === $jsondata["email"]) {
                if ($this->checkEmailDB($jsondata["email"])) {
                    $stm = $this->db->prepare('SELECT * FROM `users` WHERE `user_email`= :email LIMIT 1');
                    $res = $stm->execute(array(
                        ":email" => ($jsondata["email"]),
                    ));
                    $count = $stm->rowCount();
                    $this->getMyCompany();
                    if ($count > 0 && isset($_SESSION["DEFAULT_COMPANY"]) && $_SESSION["DEFAULT_COMPANY"] != NULL) {
                        $jsondata["status"] = "success";
                        $jsondata["loggedin"] = 1;
                        $_SESSION["PASSWD"] = $jsondata;
                        $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
                        $_SESSION["PASSWD"]["logindata"] = $temp[0];
                    }
                }
            }
            return $jsondata;
        }
    }
    public function getMyCompany() {
        $_SESSION["DEFAULT_COMPANY"] = NULL;
        $stm = $this->db->prepare('SELECT *
            FROM `company`
            WHERE `company_status_id` = :stat ORDER BY DESC LIMIT 1
            ');
        $res = $stm->execute(array(
            ":stat" => 4,
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["DEFAULT_COMPANY"] = $temp[0];
        }
    }
}
?>