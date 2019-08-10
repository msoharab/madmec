<?php
class dashboard_ids {

    private $dashboard_ids;

    public function __construct($config) {
        $this->dashboard_ids = array(
            "header" => array(
                "profile" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                    ),
                    "type" => "POST",
                    "dataType" => "JSON",
                    "url" => $config["EGPCSURL"] . $config["CTRL_5"] . "getProfile",
                ),
                "notifications" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                    ),
                    "type" => "POST",
                    "dataType" => "JSON",
                    "url" => $config["EGPCSURL"] . $config["CTRL_19"] . "getNotifications",
                ),
            ),
            "DashboardInfo" => array(
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["EGPCSURL"] . $config["CTRL_19"] . "getDashboardInfo",
            ),
            "RevenueInfo" => array(
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["EGPCSURL"] . $config["CTRL_19"] . "getRevenueInfo",
            ),
            "LatestOrders" => array(
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["EGPCSURL"] . $config["CTRL_19"] . "getLatestOrders",
            ),
            "LatestMembers" => array(
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["EGPCSURL"] . $config["CTRL_19"] . "getLatestMembers",
            ),
            "SaleList" => array(
                "fields" => array(
                    "fieldL1",
                    "fieldL2",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_19"] . "SaleList",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
            ),
        );
    }
    public function getIds() {
        return $this->dashboard_ids;
    }
}
?>