<?php

class Sales extends BaseController {

    private $para, $logindata, $UserId, $SalesMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->SalesMod = new Sales_Model();
        $this->SalesMod->setPostData($this->postPara);
        $this->SalesMod->setPostFile($this->postFile);
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
        }
    }

    public function OrderSales() {
        
    }

    public function ListSales() {
        
    }

}

?>