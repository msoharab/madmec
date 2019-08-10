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
            IF(t1.`user_photo_id` IS NOT NULL OR t1.`user_photo_id` != NULL,   (SELECT
                    CASE WHEN ph1.`ver2` IS NULL OR ph1.`ver2` = ""
                    THEN "' . $this->config["DEFAULT_USER_IMG"] . '"
                    ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver2`)
                    END AS pic
                FROM `portal_photo` AS ph1
                WHERE t1.`user_photo_id` = ph1.`id`), "' . $this->config["DEFAULT_USER_IMG"] . '"
            ) AS profic
            FROM `users` AS t1
            LEFT JOIN `users_type` AS t2 ON t1.`user_type_id` = t2.`users_type_id`
            WHERE `user_email`   = :name
            AND `user_apassword` = MD5(:apassword)
            AND `user_status_id` = :stat
            ');
        $res = $stm->execute(array(
            ":name" => ($jsondata["name"]),
            ":apassword" => ($jsondata["pass"]),
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
}

?>