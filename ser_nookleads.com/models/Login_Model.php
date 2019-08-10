<?php
class Login_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function signIn() {
        $jsondata = array(
            "email" => $this->postBaseData["user_name"],
            "pass" => $this->postBaseData["password"],
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
            WHERE `email`= :email AND `apassword` = MD5(:apassword)
            ');
        $res = $stm->execute(array(
            ":email" => mysql_real_escape_string($jsondata["email"]),
            ":apassword" => mysql_real_escape_string($jsondata["pass"])
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "success";
            $jsondata["loggedin"] = 1;
            $_SESSION["USERDATA"] = $jsondata;
            $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["USERDATA"]["logindata"] = $temp[0];
        }
        return $jsondata;
    }
    public function forgotPassword() {
        $jsondata = array(
            "email" => $this->postBaseData["user_name"],
            "loggedin" => 0,
            "status" => 'error'
        );
        if ($this->validateEmail($jsondata["email"]) === $jsondata["email"]) {
            if ($this->checkEmailDB($jsondata["email"])) {
                $stm = $this->db->prepare('SELECT * FROM `user_profile` WHERE `email`= :email LIMIT 1');
                $res = $stm->execute(array(
                    ":email" => mysql_real_escape_string($jsondata["email"]),
                ));
                $count = $stm->rowCount();
                if ($count > 0) {
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
?>