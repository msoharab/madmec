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
            "AddProduct" => array(
                "form" => "custpassform",
                "fields" => array(
                    "field1",
                    "field2",
                    "field3",
                    "field4",
                    "field5",
                    "field6",
                    "field7",
                    "field8"
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_9"] . "AddProduct",
                "Redurl" => $config["URL"] . $config["CTRL_9"],
                "defaultImage" => $config["URL"] . $config["CTRL_9"],

        ),
            "ListProducts" => array(
                "fields" => array(
                    "fieldL1",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["URL"] . $config["CTRL_9"] . "ListProducts",
            ),
             "AddMembers" => array(
                "form" => "custpassform",
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
                    "field11"
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_9"] . "AddMembers",
                "Redurl" => $config["URL"] . $config["CTRL_9"],
                "defaultImage" => $config["URL"] . $config["CTRL_9"],

        ),
            "ListMembers" => array(
                "fields" => array(
                    "fieldM1",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["URL"] . $config["CTRL_9"] . "ListMembersDB",
            ),
        );
    }
    public function getIds() {
        return $this->dashboard_ids;
    }
}
?>