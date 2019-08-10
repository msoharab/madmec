<?php
class Profile extends BaseController {

    private $para;

    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->ProfilePicMod = new Profile_Model();
        $this->ProfilePicMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->setHeader('Header.php');
        $this->baseview->setBody('Profile');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function ProfilePic() {
        $this->baseview->setjsonData($this->ProfilePicMod->ProfilePic());
        echo $this->baseview->renderJson();
    }
}
?>