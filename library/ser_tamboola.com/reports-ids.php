<?php

class reports_ids {

    private $reports_ids;

    public function __construct($config) {
        $this->reports_ids = array(
            "OfferRepo" => array(
                "form" => "OfferRepoForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_8"] . "OfferRepo",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "PackageRepo" => array(
                "form" => "PackageRepoForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_8"] . "PackageRepo",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "PaymentRepo" => array(
                "form" => "PaymentRepoForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_8"] . "PaymentRepo",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ExpensesRepo" => array(
                "form" => "ExpensesRepoForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_8"] . "ExpensesRepo",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "BalanceRepo" => array(
                "form" => "BalanceRepoForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_8"] . "BalanceRepo",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "AttendanceRepo" => array(
                "form" => "AttendanceRepoForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_8"] . "AttendanceRepo",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "ReceiptRepo" => array(
                "form" => "ReceiptRepoForm",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_8"] . "ReceiptRepo",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->reports_ids;
    }

}

?>