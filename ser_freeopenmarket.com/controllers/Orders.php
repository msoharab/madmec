<?php

class Orders extends BaseController {

    private $para, $logindata, $UserId, $OrdersMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->OrdersMod = new Orders_Model();
        $this->OrdersMod->setPostData($this->postPara);
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
        }
    }

    public function PlaceOrder() {
        
    }

    public function CancelOrder() {
        
    }

    public function ListOrder() {
        
    }

}

?>