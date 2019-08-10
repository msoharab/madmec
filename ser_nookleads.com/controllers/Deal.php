<?php
class Deal extends BaseController {
    private $para, $DealMod;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->gotoIndex();
        $this->DealMod = new Deal_Model();
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->UserId = $this->UserId;
    }
    public function Index() {
        $this->baseview->setHeader('dealHeader.php');
        $this->baseview->setBody('Deal');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function B2B() {
        $this->baseview->setHeader('dealHeader.php');
        $this->baseview->setBody('Deal');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function B2C() {
        $this->baseview->setHeader('dealHeader.php');
        $this->baseview->setBody('Deal');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function B2G() {
        $this->baseview->setHeader('dealHeader.php');
        $this->baseview->setBody('Deal');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function C2C() {
        $this->baseview->setHeader('dealHeader.php');
        $this->baseview->setBody('Deal');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>