<?php

class managers_ids {

    private $managers_ids;

    public function __construct($config) {
        $this->managers_ids = array(
            "AddManager" => array(
                "form" => "AddManagerForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                    "field5",
                    "field6",
                    "field7",
                    "field8",
                    "field9",
                    "field10",
                    "field11",
                    "field12",
                    "field13",
                    "field14",
                    "field15",
                    "field16",
                    "field17"
                ),
                "gender" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_33"] . "fetchGender",
                ),
                "utype" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_33"] . "fetchUserTypes",
                ),
                "doctype" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_33"] . "fetchDocTypes",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_33"] . "ManagersAdd",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "AssignManager" => array(
                "form" => "EnquiryFollowsForm",
                "fields" => array(
                    "fieldA1",
                    "fieldA2",
                    "fieldA3"
                ),
                "admin" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_33"] . "fetchAdmin",
                ),
                "gym" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_33"] . "fetchGyms",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_33"] . "AssignManager",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListManager" => array(
                "fields" => array(
                    "fieldL1",
                    "fieldL2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_33"] . "ListManager",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->managers_ids;
    }

}

?>