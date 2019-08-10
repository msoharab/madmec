<?php

class employees_ids {

    private $employees_ids;

    public function __construct($config) {
        $this->employees_ids = array(
            "AddEmployees" => array(
                "form" => "AddEnquiryForm",
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
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_26"] . "AddEmployees",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ImportEmployees" => array(
                "form" => "AddEnquiryForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_26"] . "ImportEmployees",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListEmployees" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_26"] . "ListEmployees",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->employees_ids;
    }

}

?>