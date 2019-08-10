<?php
class Login extends BaseController {

    private $loginMod;

    function __construct() {
        parent::__construct();
        $this->loginMod = new Login_Model();
        $this->loginMod->setPostData($this->postPara, true);
    }
    public function Index() {
        $this->baseview->setHeader('Header.php');
        $this->baseview->setBody('Index');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function signIn() {
        $this->baseview->setjsonData($this->loginMod->signIn());
        echo $this->baseview->renderJson();
    }
}
?>