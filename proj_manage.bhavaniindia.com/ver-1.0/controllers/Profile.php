<?php
class Profile extends BaseController {
    private $para, $profileMod, $logindata, $UserId;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->profileMod = new Profile_Model();
        $this->profileMod->setPostData($this->postPara);
        $this->profileMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }
    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Personal Info';
        $this->baseview->setHeader('Header.php');
        $this->baseview->setHTML('Profile', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function changePassword() {
        $this->baseview->setjsonData($this->profileMod->changePassword());
        echo $this->baseview->renderJson();
    }
}
?>