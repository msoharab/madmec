<?php
class Dashboard extends BaseController {
    private $para, $logindata, $UserId, $DashMod;
    function __construct($para = false) {
        parent::__construct();
		$this->gotoIndex();
        $this->para = $para;
        $this->DashMod = new Dashboard_Model();
        $this->DashMod->setPostData($this->postPara);
        $this->DashMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'HabeebShop | Dashboard ';
        $this->baseview->setMenuFile('MMAdminLeftNavMenu.php');
        $this->baseview->setHeader('MMAdminHeader.php');
        $this->baseview->setBody('Dashboard');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function SaleList() {
        $this->baseview->setjsonData($this->DashMod->SaleList());
        echo $this->baseview->renderJson();
    }
}
?>
