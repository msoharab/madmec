<?php
class Register extends BaseController {

    private $para,$registerMod;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->registerMod = new Register_Model();
        $this->registerMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->setHeader('commonHeader.php');
        $this->baseview->setBody('Register');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function signUp() {
        $this->baseview->setjsonData($this->registerMod->signUp());
        echo $this->baseview->renderJson();
    }
    public function checkEmail() {
        $this->baseview->setjsonData($this->registerMod->checkEmailDB());
        echo $this->baseview->renderJson();
    }
}
?>