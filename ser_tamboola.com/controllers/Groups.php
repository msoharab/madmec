<?php
class Groups extends BaseController {
    private $para, $logindata, $UserId, $GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->gotoHome();
        $this->para = $para;
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->GymDets = $_SESSION["GYM_DETAILS"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Groups | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Groups', 'group_add.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AddGroups() {
        $this->baseview->title = 'Groups | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHtml('Groups', 'group_add.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ListGroups() {
        $this->baseview->title = 'Groups | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHtml('Groups', 'group_list.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>