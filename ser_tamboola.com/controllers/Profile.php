<?php
class Profile extends BaseController {
    private $para, $profileMod, $logindata, $UserId, $GymId, $GymData;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->profileMod = new Profile_Model();
        $this->profileMod->setPostData($this->postPara);
        $this->profileMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["user_pk"];
        $this->baseview->UserDets = $this->logindata;
    }
    public function Index() {
        $this->baseview->title = 'Tamboola - Process Personal Info';
        $this->baseview->setMenuFile(NULL);
        $this->baseview->setHeader($this->config["DEFAULT_HEADER"]);
        $this->baseview->setHTML('Profile', 'Index.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function changePassword() {
        $this->baseview->setjsonData($this->profileMod->changePassword());
        echo $this->baseview->renderJson();
    }
    public function changeProfile() {
        $this->baseview->setjsonData($this->profileMod->changeProfile());
        echo $this->baseview->renderJson();
    }
}
?>