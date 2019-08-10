<?php

class enquiry_ids {

    private $enquiry_ids;

    public function __construct($config) {
        $this->enquiry_ids = array(
            "AddEnquiry" => array(
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
                ),
                "about" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "fetchMediumAds",
                ),
                "facility" => array(
                    "id" => "usertypeme_",
                    "class" => "meusertype",
                    "listtype" => "option",
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "fetchFacility",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_20"] . "AddEnquiry",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
            "EnquiryFollows" => array(
                "CurrentFollow" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "CurrentFollow",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "PendingFollow" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "PendingFollow",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "ExpiredFollow" => array(
                    "fields" => array(
                        "field1",
                        "field2",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_20"] . "ExpiredFollow",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
            ),
            "EnquiryList" => array(
                "fields" => array(
                    "field1",
                    "field2",
                ),
                "dataType" => "JSON",
                "type" => "POST",
                "url" => $config["URL"] . $config["CTRL_20"] . "ListEnquiry",
                "Redurl" => $config["URL"] . $config["CTRL_35"],
            ),
        );
    }

    public function getIds() {
        return $this->enquiry_ids;
    }

}

?>