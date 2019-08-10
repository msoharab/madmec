<?php
class empProfile {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }
    public function changeCurrentPassword() {
        $query = 'SELECT * FROM `user_profile` WHERE `id`="' . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . '" AND `password`="' . mysql_real_escape_string($this->parameters['cpassword']) . '"';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            $query = 'UPDATE `user_profile` SET `password` = "' . $this->parameters["cfpassword"] . '" WHERE `user_profile`.`id` = ' . $_SESSION['USER_LOGIN_DATA']['USER_ID'];
            executeQuery($query);
            return "success";
        } else {
            return "notmatch";
        }
    }
}