<?php
class Login_Model extends BaseModel {

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
    public function signIn() {
        $jsondata = array(
            "email" => $this->postBaseData["user_name"],
            "pass" => $this->postBaseData["password"],
            "loggedin" => 0,
            "status" => 'error'
        );
        $stm = $this->db->prepare('SELECT * FROM `user_profile` WHERE `email`= :email AND `apassword` = MD5(:apassword)');
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
}
?>