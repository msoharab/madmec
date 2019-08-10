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
                "url" => $config["URL"] . $config["CTRL_6"] . "signIn",
                "Redurl" => $config["URL"] . $config["CTRL_0"],
            ),
            "facebook" => array(
                "but" => "facebookBut",
                "id1" => "facebookLogBut1",
                "url" => $config["URL"] . $config["CTRL_2"],
            ),
            "googleplus" => array(
                "but" => "googleplusBut",
                "id1" => "googleLogBut1",
                "url" => $config["URL"] . $config["CTRL_4"],
            ),
            "traffic" => array(
                "autoloader" => false,
                "dataType" => "JSON",
                "type" => "POST",
                "processData" => false,
                "contentType" => false,
                "url" => $config["URL"] . $config["CTRL_5"] . "updateTrafficLT",
                "Redurl" => $config["URL"] . $config["CTRL_1"],
            )
        );
    }

    public function getIds() {
        return $this->index_ids;
    }

}

?>