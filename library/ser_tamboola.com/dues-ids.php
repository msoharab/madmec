<?php

class dues_ids {

    private $dues_ids;

    public function __construct($config) {
        $this->dues_ids = array(
            "ListCurrent" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_23"] . "ListCurrent",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListPending" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_23"] . "ListPending",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListExpired" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_23"] . "ListExpired",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),

        );
    }

    public function getIds() {
        return $this->dues_ids;
    }

}

?>