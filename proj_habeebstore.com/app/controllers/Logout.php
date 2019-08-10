<?php
class Logout extends BaseController {
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        if (!$para) {
            $this->loginMod = new Login_Model();
            $this->loginMod->setPostData($this->postPara);
        }
        if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] === 1) {
			//$this->updateUserLogOut();
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
    public function updateUserLogOut() {
        $this->loginMod->updateUserlog();
    }
}
?>