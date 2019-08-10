<?php
class index_ids {

    private $index_ids;

    public function __construct($config) {

        $this->index_ids = array(
            "Login" => array(
                "form" => "signinform",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "processData" => false,
                "contentType" => false,
                "url" => $config["URL"] . $config["CTRL_3"] . "signIn",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "Register" => array(
                "form" => "custregform",
                "fields" => array(
                    "reg1",
                    "reg2",
                    "reg3",
                    "reg4",
                    "reg5",
                    "reg6",
                    "reg7",
                    "reg8",
                    "reg9"
                ),
                "usertype" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "usertype_ids" => array(1,3,4,5,6,7,8,9),
                    "url" => $config["URL"] . $config["CTRL_6"] . "fetchUserTypes",
                ),
                "gender" => array(
                    "id" => "gender_",
                    "class" => "megender",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "gender_ids" => array(1,2,3),
                    "url" => $config["URL"] . $config["CTRL_6"] . "fetchGender",
                ),
                "checkemail" => array(
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_6"] . "checkEmail",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_6"] . "signUp",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ForgotPassword" => array(
                "form" => "custpassform",
                "fields" => array(
                    "pass1",
                    "pass2",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_18"] . "forgotPassword",
                "Redurl" => $config["URL"] . $config["CTRL_1"],
            ),
            "traffic" => array(
                "autoloader" => false,
                "dataType" => "JSON",
                "type" => "POST",
                "processData" => false,
                "contentType" => false,
                "url" => $config["URL"] . $config["CTRL_1"] . "updateTrafficLT",
                "Redurl" => $config["URL"] . $config["CTRL_1"],
            )
        );
    }
    public function getIds() {
        return $this->index_ids;
    }
}
?>