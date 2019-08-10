<?php
class Popular extends BaseController {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->gotoWall();
    }
    public function Index() {
        $this->baseview->setHeader('Header.php');
        $this->baseview->setBody('Popular');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>