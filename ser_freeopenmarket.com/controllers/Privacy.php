<?php
class Privacy extends BaseController {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }
    public function Index() {
        $this->baseview->setHeader('CommonHeader.php');
        $this->baseview->setBody('Privacy');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>