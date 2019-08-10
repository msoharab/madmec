<?php
class Logout extends BaseController {
    function __construct() {
        parent::__construct();
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] === 1) {
            session_destroy();
            header('Location:' . $this->config["URL"]);
            exit(0);
        }
    }
    public function Index() {
        $this->baseview->setHeader('Header.php');
        $this->baseview->setBody('Index');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
}
?>