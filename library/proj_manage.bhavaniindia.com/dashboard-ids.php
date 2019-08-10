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
                "deactivate" => array(
                    "processData" => false,
                    "contentType" => false,
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_9"] . "DeleteProduct",
                    "Redurl" => $config["URL"] . $config["CTRL_9"],
                ),
                "btnDiv" => "DeactProduct",
            ),
            "EditProduct" => array(
                "form" => "custpassform",
                "fields" => array(
                    "field11",
                    "field22",
                    "field33",
                    "field44",
                    "field55",
                    "field66",
                    "field77",
                    "field88",
                    "field99",
                    "field10",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_9"] . "EditProduct",
                "Redurl" => $config["URL"] . $config["CTRL_9"],
                "defaultImage" => $config["URL"] . $config["CTRL_9"],
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
                "deactivate" => array(
                    "processData" => false,
                    "contentType" => false,
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_9"] . "DeleteMember",
                    "Redurl" => $config["URL"] . $config["CTRL_9"],
                ),
                "btnDiv" => "DeactMember",
            ),
            "EditMembers" => array(
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
                    "field11",
                    "fields12",
                    "fields13"
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_9"] . "EditMember",
                "Redurl" => $config["URL"] . $config["CTRL_9"],
                "defaultImage" => $config["URL"] . $config["CTRL_9"],
            ),
            "ListEnquiry" => array(
                "fields" => array(
                    "fieldE1",
                ),
                "type" => "POST",
                "dataType" => "JSON",
                "url" => $config["URL"] . $config["CTRL_9"] . "ListEnquiryDB",
                "deactivate" => array(
                    "processData" => false,
                    "contentType" => false,
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_9"] . "DeleteEnquiry",
                    "Redurl" => $config["URL"] . $config["CTRL_9"],
                ),
                "btnDiv" => "DeactEnquiry",
            ),
        );
    }

    public function getIds() {
        return $this->dashboard_ids;
    }

}

?>