<?php
class Index extends BaseController {
    private $para, $IndexPostMod;
    public function __construct($para = false) {
        parent::__construct();
        $this->gotoDashboard();
        $this->para = $para;
        $this->IndexPostMod = new Index_Model();
        $this->IndexPostMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->title = 'Welcome To Bhavani Enterprises';
        $this->baseview->setHeader('IndexHeader.php');
        $this->baseview->setBody('Index');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function updateTrafficLT() {
        $this->IndexPostMod->updateTrafficLT();
    }
}
?>