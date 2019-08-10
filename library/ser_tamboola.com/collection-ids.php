<?php

class collection_ids {

    private $collection_ids;

    public function __construct($config) {
        $this->collection_ids = array(
            "AddCollec" => array(
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
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_32"] . "AddCollec",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListCollec" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_32"] . "ListCollec",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "Dues" => array(
                "CurrentDue" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_32"] . "CurrentDue",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "PendingDue" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_32"] . "PendingDue",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "ExpiredDue" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_32"] . "ExpiredDue",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
            ),
             "FollowUp" => array(
                "CurrentFollow" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_32"] . "CurrentFollow",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "PendingFollow" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_32"] . "PendingFollow",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "ExpiredFollow" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_32"] . "ExpiredFollow",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
            ),
        );
    }

    public function getIds() {
        return $this->collection_ids;
    }

}

?>