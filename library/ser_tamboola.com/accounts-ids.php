<?php

class accounts_ids {

    private $accounts_ids;

    public function __construct($config) {
        $this->accounts_ids = array(
            "StaffPay" => array(
                "form" => "AddEnquiryForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                    "field5",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_27"] . "StaffPay",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "Expenses" => array(
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
                "url" => $config["URL"] . $config["CTRL_27"] . "Expenses",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "PackageFee" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_27"] . "PackageFee",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "sellOffer" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_27"] . "sellOffer",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "DueBalance" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_27"] . "DueBalance",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->accounts_ids;
    }

}

?>