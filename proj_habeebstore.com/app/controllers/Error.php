<?php
class Error extends BaseController {
    private $para;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }
    public function Index() {
        $this->baseview->setHeader('IndexHeader.php');
        $this->baseview->setBody('Error');
        $this->baseview->setFooter('IndexFooter.php');
        $this->baseview->RenderView(true);
    }
}
?>