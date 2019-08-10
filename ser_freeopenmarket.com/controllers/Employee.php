<?php

class Employee extends BaseController {

    private $para, $logindata, $UserId, $EmployeeMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->EmployeeMod = new Employee_Model();
        $this->EmployeeMod->setPostData($this->postPara);
        $this->EmployeeMod->setPostFile($this->postFile);
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
        }
    }

    public function ProcessOrders() {
        
    }

    public function SellOrder() {
        
    }

}
