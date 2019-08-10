<?php

class customers_ids {

    private $customers_ids;

    public function __construct($config) {
        $this->customers_ids = array(
            "AddCustomers" => array(
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
                    "field20"
                ),
                "gender" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_24"] . "fetchGender",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_24"] . "AddCustomers",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ImportCustomers" => array(
                "form" => "AddEnquiryForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_24"] . "ImportCustomers",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListCustomers" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_24"] . "ListCustomers",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->customers_ids;
    }

}

?>