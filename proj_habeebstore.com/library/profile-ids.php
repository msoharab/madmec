<?php
class profile_ids {

    private $profile_ids;

    public function __construct($config) {

        $this->profile_ids = array(
            "ChangePassword" => array(
                "form" => "changepassform",
                "fields" => array(
                    "ch1",
                    "ch2",
                    "ch3",
                    "ch4"
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_5"] . "changePassword",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                "inView" => "file",
                "inViewClass" => "picedit_box"

            ),
            "ChangeEmail" => array(
                "form" => "changeemailform",
                "fields" => array(
                    "fieldE1",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_5"] . "changeEmail",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                "clone" => array(
                    "clonereq00",
                    "cloneresp00",
                ),
                "cloneplusbut" => array(
                    "cloneplusbut1",
                    "cloneplusbut2",
                ),
                "cloneminusbut" => array(
                    "cloneminusbut1",
                    "cloneminusbut2",
                ),
                "reqparam" => array(
                    "reqparam0",
                ),
            ),
            "ChangeCell" => array(
                "form" => "changecellform",
                "fields" => array(
                    "fieldC1",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_5"] . "changeCell",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                "clone" => array(
                    "clonereq00",
                    "cloneresp00",
                ),
                "cloneplusbut" => array(
                    "cloneplusbut1",
                    "cloneplusbut2",
                ),
                "cloneminusbut" => array(
                    "cloneminusbut1",
                    "cloneminusbut2",
                ),
                "resparam" => array(
                    "respparam0",
                    "respval0",
                ),
            ),
            "ChangePic" => array(
                "form" => "changepicform",
                "fields" => array(
                    "fieldP1",
                ),
                "dataType" => "JSON",
                "processData" => false,
                "contentType" => false,
                "type" => "POST",
                "url" => $config["EGPCSURL"] . $config["CTRL_5"] . "changePic",
                "Redurl" => $config["EGPCSURL"] . $config["CTRL_19"],
                "inView" => "file",
                "inViewClass" => "picedit_box",
                "status" => "#status",
                "bar" => ".bar",
                "percent" => ".percent",
                "percentVal" => "0%",
                "picedit" => false,
                "ajaxForm" => false,
                "defaultImage" => $config["DEFAULT_IMG"],
            ),
        );
    }
    public function getIds() {
        return $this->profile_ids;
    }
}
?>