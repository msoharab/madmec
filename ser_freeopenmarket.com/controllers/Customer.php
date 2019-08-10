<?php

class Customer extends BaseController {

    private $para, $logindata, $UserId, $CustomerMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->CustomerMod = new Customer_Model();
        $this->CustomerMod->setPostData($this->postPara);
        $this->CustomerMod->setPostFile($this->postFile);
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
        }
    }

    public function Index() {
        
    }

    public function SearchFood() {
        
    }

    public function PlaceOrder() {
        
    }

    public function CancelOrder() {
        
    }

    public function ListOrder() {
        
    }

}

?>