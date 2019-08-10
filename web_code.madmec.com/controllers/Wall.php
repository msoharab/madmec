<?php
class Wall extends BaseController {

    private $para, $WallMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->gotoIndex();
        $this->WallMod = new Wall_Model();
    }
    public function Index() {
        $this->baseview->setHeader('wallHeader.php');
        $this->baseview->setBody('Wall');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>