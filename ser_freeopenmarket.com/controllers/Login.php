<?php

class Login extends BaseController {

    private $para, $loginMod, $indexController;

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
        $this->indexController = new Index();
        $this->indexController->Index();
    }

    public function signIn() {
        $this->baseview->setjsonData($this->loginMod->signIn());
        echo $this->baseview->renderJson();
    }

}

?>