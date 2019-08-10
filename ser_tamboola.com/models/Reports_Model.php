<?php
class Reports_Model extends BaseModel {
    private $para,$logindata, $UserId,$GymId, $GymData;
    function __construct() {
        parent::__construct();
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
    }
}
?>