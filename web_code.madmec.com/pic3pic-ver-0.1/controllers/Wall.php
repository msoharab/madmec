<?php
class Wall extends BaseController {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->gotoIndex();
    }
    public function Index() {

        $this->baseview->setHeader('wallHeader.php');
        $this->baseview->setBody('Wall');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function gotoIndex() {
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] !== 1) {
            header('Location:' . $this->config["URL"] . 'Logout');
        }
    }
}
?>