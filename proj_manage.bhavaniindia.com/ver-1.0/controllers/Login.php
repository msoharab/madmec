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
        $this->baseview->title = 'Welcome To Bhavani Enterprises';
        $this->baseview->setHeader('IndexHeader.php');
        $this->baseview->setBody('Index');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function signIn() {
        $this->baseview->setjsonData($this->loginMod->signIn());
        echo $this->baseview->renderJson();
    }
    public function ForgotPassword() {
        $this->baseview->setjsonData($this->loginMod->forgotPassword());
        echo $this->baseview->renderJson();
    }

}

?>