<?php

class clients_ids {

    private $clients_ids;

    public function __construct($config) {
        $this->clients_ids = array(
            "AddClient" => array(
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
                    "field11",
                    "field12",
                    "field13",
                    "field14",
                    "field15",
                    "field16",
                    "field17",
                    "field18",
                    "field19",
                    "field20",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_21"] . "AddClient",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "AssignClient" => array(
                "form" => "AddEnquiryForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                    "field5",
                    "field6",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_21"] . "AssignClient",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "Request" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_21"] . "Request",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListClient" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_21"] . "ListClient",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->clients_ids;
    }

}

?>