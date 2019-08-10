<?php
class Managers extends BaseController {
    private $para, $ManagersMod, $logindata, $UserId, $GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->ManagersMod = new Managers_Model();
        $this->ManagersMod->setPostData($this->postPara);
        $this->ManagersMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->GymDets = $_SESSION["GYM_DETAILS"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Managers | ' . $this->logindata["type"];
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('Managers', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ManagersAdd() {
        $this->baseview->setjsonData($this->ManagersMod->ManagerAdd());
        echo $this->baseview->renderJson();
    }
}
?>