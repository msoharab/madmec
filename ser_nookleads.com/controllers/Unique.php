<?php
class Unique extends BaseController {
    private $para;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }
    public function Index() {
        $this->baseview->setHeader('commonHeader.php');
        $this->baseview->setBody('Unique');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>