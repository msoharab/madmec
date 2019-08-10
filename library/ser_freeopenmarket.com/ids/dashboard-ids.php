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
                    "url" => $config["URL"] . $config["CTRL_5"] . "getProfile",
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
                    "url" => $config["URL"] . $config["CTRL_1"] . "getNotifications",
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
                "url" => $config["URL"] . $config["CTRL_1"] . "getDashboardInfo",
            ),
            "RevenueInfo" => array(
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["URL"] . $config["CTRL_1"] . "getRevenueInfo",
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
                "url" => $config["URL"] . $config["CTRL_1"] . "getLatestOrders",
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
                "url" => $config["URL"] . $config["CTRL_1"] . "getLatestMembers",
            ),
        );
    }

    public function getIds() {
        return $this->dashboard_ids;
    }

}

?>