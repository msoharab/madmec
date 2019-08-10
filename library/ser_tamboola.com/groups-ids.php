<?php

class groups_ids {

    private $groups_ids;

    public function __construct($config) {
        $this->groups_ids = array(
            "AddGroups" => array(
                "form" => "AddGroupsForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                    "field5",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_25"] . "AddGroups",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListGroups" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_25"] . "ListGroups",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->groups_ids;
    }

}

?>