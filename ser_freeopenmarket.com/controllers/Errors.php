<?php

class Errors extends BaseController {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
    }

    public function Index() {
        $this->baseview->setHeader('IndexHeader.php');
        $this->baseview->setBody('Errors');
        $this->baseview->setFooter('IndexFooter.php');
        $this->baseview->RenderView(true);
    }

}

?>