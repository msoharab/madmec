<?php

class stats_ids {

    private $stats_ids;

    public function __construct($config) {
        $this->stats_ids = array(
            "Transaction" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_30"] . "Transaction",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "Registration" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_30"] . "Registration",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "Attendance" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_30"] . "Attendance",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->stats_ids;
    }

}

?>