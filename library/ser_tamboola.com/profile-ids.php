<?php
class profile_ids {

    private $profile_ids;

    public function __construct($config) {

        $this->profile_ids = array(
            "ChangePassword" => array(
                "form" => "changepassform",
                "fields" => array(
                    "ch1",
                    "ch2",
                    "ch3",
                    "ch4",
                    "ch5",
                    "ch6"
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_5"] . "changePassword",
                "Redurl" => $config["URL"] . $config["CTRL_35"]
            )
        );
    }
    public function getIds() {
        return $this->profile_ids;
    }
}
?>