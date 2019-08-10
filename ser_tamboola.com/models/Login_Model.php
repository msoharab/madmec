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
        $stm = $this->db->prepare('SELECT
            t1.*,
            t2.*,
            t3.*,
            IF(t1.`photo_id` IS NOT NULL OR t1.`photo_id` != NULL,   (SELECT
                    CASE WHEN ph1.`ver2` IS NULL OR ph1.`ver2` = ""
                    THEN "' . $this->config["DEFAULT_USER_IMG"] . '"
                    ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
                    END AS pic
                FROM `photo` AS ph1
                WHERE t1.`photo_id` = ph1.`id`), "' . $this->config["DEFAULT_USER_IMG"] . '"
            ) AS profic
            FROM`user_profile` AS t1
            RIGHT JOIN `user_profile_type` AS t2 ON t1.`id` = t2.`user_pk`
            LEFT JOIN `user_type` AS t3 ON t2.`usertype_id`= t3.`id`
            WHERE (`user_name`   = :name OR `email_id`   = :email OR `cell_number`   = :cellnumber) 
            AND  t1.`apassword` = MD5(:apassword)
            /*AND t1. `status_id` = :stat*/
            ');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":email" => ($jsondata["name"]),
            ":cellnumber" => ($jsondata["name"]),
            ":apassword" => ($jsondata["pass"]),
            //":stat" => 4,
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $jsondata["status"] = "success";
            $jsondata["loggedin"] = 1;
            $_SESSION["USERDATA"] = $jsondata;
            $temp = $stm->fetchAll(PDO::FETCH_ASSOC);
            //print_r($temp);
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
                    $stm = $this->db->prepare('SELECT * FROM`user_profile` WHERE `user_email`= :email LIMIT 1');
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