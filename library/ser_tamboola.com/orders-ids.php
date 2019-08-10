<?php

class orders_ids {

    private $orders_ids;

    public function __construct($config) {
        $this->orders_ids = array(
            "AddOrderFol" => array(
                "form" => "AddEnquiryForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                    "field5",
                    "field6",
                    "field7"
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_31"] . "AddOrderFol",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ListOrderFol" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_31"] . "ListOrderFol",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->orders_ids;
    }

}

?>