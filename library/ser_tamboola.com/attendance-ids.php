<?php

class attendance_ids {

    private $attendance_ids;

    public function __construct($config) {
        $this->attendance_ids = array(
            "Marked" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_29"] . "Marked",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "Unmarked" => array(
                "fields" => array(
                    "field11",
                    "field12",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_29"] . "Unmarked",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "All" => array(
                "fields" => array(
                    "field21",
                    "field22",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_29"] . "All",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->attendance_ids;
    }

}

?>