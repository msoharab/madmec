<?php
class Errors_Model extends BaseModel {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }
}
?>