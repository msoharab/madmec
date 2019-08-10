<?php

class Orders extends BaseController {

    private $para, $logindata, $OrdersMod, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->OrdersMod = new Orders_Model();
        $this->OrdersMod->setPostData($this->postPara);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["users_pk"];
    }

    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Orders';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('Orders', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }


}

?>