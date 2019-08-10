<?php
class crm_ids {

    private $crm_ids;

    public function __construct($config) {
        $this->crm_ids = array(
            "CRM" => array(
                "Mail" => array(
                    "form" => "MailForm",
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
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "checkemail" => array(
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_0"] . "checkEmail",
                    ),
                    "url" => $config["URL"] . $config["CTRL_0"] . "Crm",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "Sms" => array(
                    "form" => "MailForm",
                    "fields" => array(
                        "field1",
                        "field2",
                        "field3",
                        "field4",
                        "field5",
                        "field6",
                        "field7",
                        "field8",
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "url" => $config["URL"] . $config["CTRL_0"] . "Crm",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
                "SmsToApp" => array(
                    "form" => "MailForm",
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
                    ),
                    "dataType" => "JSON",
                    "type" => "POST",
                    "checkemail" => array(
                        "dataType" => "JSON",
                        "type" => "POST",
                        "url" => $config["URL"] . $config["CTRL_0"] . "checkEmail",
                    ),
                    "url" => $config["URL"] . $config["CTRL_0"] . "Crm",
                    "Redurl" => $config["URL"] . $config["CTRL_35"],
                ),
            ),
        );
    }
    public function getIds() {
        return $this->crm_ids;
    }
}
?>