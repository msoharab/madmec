<?php

class Dashboard extends BaseController {

    private $para, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["users_pk"];
    }

    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Welcome To Dashboard | ' . $this->logindata["users_type_type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Dashboard');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

}

?>
