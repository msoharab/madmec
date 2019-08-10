<?php
class Facebook extends BaseController {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->gotoWall();
    }
    public function Index() {
        $this->baseview->setHeader('commonHeader.php');
        $this->baseview->setBody('Facebook');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>