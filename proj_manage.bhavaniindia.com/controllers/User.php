<?php
class User extends BaseController {
    private $para, $UserMod, $logindata, $UserId;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        $this->UserMod = new User_Model();
        $this->UserMod->setPostData($this->postPara);
        $this->UserMod->setPostFile($this->postFile);
        $this->logindata = $_SESSION["USERDATA"]["logindata"];
        $this->UserId = $this->logindata["id"];
    }
    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Personal Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_profile.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserPersonal() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Personal Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setHTML('User', 'user_profile.php');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function UserEdit($id = false) {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Edit User';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        if ($id) {
            $uid = base64_decode($id);
            $this->baseview->getuserDet = $this->UserMod->getUser($uid);
            $this->baseview->setHTML('User', 'user_personal_edit.php');
        } else {
            $this->baseview->setHTML('User', 'user_personal_edit_error.php');
        }
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function AddUser() {
        $this->baseview->setjsonData($this->UserMod->AddUser());
        echo $this->baseview->renderJson();
    }
    public function ListUserPersonal() {
        $this->baseview->setjsonData($this->UserMod->ListUserPersonal());
        echo $this->baseview->renderJson();
    }
    public function EditUserPersonal() {
        $this->baseview->setjsonData($this->UserMod->EditUserPersonal());
        echo $this->baseview->renderJson();
    }
    public function DeleteUser($id) {
        $this->baseview->setjsonData($this->UserMod->DeleteUser($id));
        echo $this->baseview->renderJson();
    }
}
?>