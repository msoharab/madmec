<?php
class Register extends BaseController {
    private $para, $registerMod;
    function __construct($para = false) {
        parent::__construct();
        $this->gotoDashboard();
        $this->para = $para;
        $this->registerMod = new Register_Model();
        $this->registerMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->title = 'Register to Tamboola';
        $this->baseview->setMenuFile('IndexLeftNavMenu.php');
        $this->baseview->setHeader('IndexHeader.php');
        $this->baseview->setBody('Register');
        $this->baseview->setFooter('RegisterFooter.php');
        $this->baseview->RenderView(true);
    }
    public function signUp() {
        $this->baseview->setjsonData($this->registerMod->signUp());
        echo $this->baseview->renderJson();
    }
}
?>