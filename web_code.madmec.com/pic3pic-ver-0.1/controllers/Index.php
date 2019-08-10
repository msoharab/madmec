<?php
class Index extends BaseController {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->gotoWall();
    }
    public function Index() {
        $this->baseview->setHeader('Header.php');
        $this->baseview->setBody('Index');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function gotoWall() {
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] === 1) {
            header('Location:' . $this->config["URL"] . 'Wall');
        }
    }
}
?>