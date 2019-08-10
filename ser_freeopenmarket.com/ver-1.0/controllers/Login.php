<?php

class Login extends BaseController {

    private $para, $loginMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoDashboard();
        $this->para = $para;
        if (!$para) {
            $this->loginMod = new Login_Model();
            $this->loginMod->setPostData($this->postPara);
        }
    }

    public function Index() {
        $this->baseview->title = 'Login to OnlineFood';
        $this->baseview->setMenuFile('IndexLeftNavMenu.php');
        $this->baseview->setHeader('IndexHeader.php');
        $this->baseview->setBody('Login');
        $this->baseview->setFooter('LoginFooter.php');
        $this->baseview->RenderView(true);
    }

    public function signIn() {
        $this->baseview->setjsonData($this->loginMod->signIn());
        echo $this->baseview->renderJson();
    }

}

?>