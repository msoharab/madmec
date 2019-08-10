<?php

class User extends BaseController {

    private $para, $logindata, $UserId, $UserMod;

    function __construct($para = false) {
        parent::__construct();
        $this->gotoIndex();
        $this->para = $para;
        $this->UserMod = new User_Model();
        $this->UserMod->setPostData($this->postPara);
        $this->UserMod->setPostFile($this->postFile);
        if (isset($_SESSION["USERDATA"]["logindata"])) {
            $this->logindata = $_SESSION["USERDATA"]["logindata"];
            $this->UserId = $this->logindata["users_pk"];
            $this->baseview->UserDets = $this->logindata;
        }
    }

    public function Index() {
        $this->baseview->UserDets = $this->logindata;
        $this->baseview->title = 'Process Personal Info';
        $this->baseview->setMenuFile($this->logindata["users_type_nav_menu_file"]);
        $this->baseview->setHeader($this->logindata["users_type_header_file"]);
        $this->baseview->setBody('User');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }

    public function ProcessUser() {
        $this->baseview->setjsonData($this->UserMod->ProcessUser());
        echo $this->baseview->renderJson();
    }

    public function AddUser() {
        $this->baseview->setjsonData($this->UserMod->AddUser());
        echo $this->baseview->renderJson();
    }

    public function DisplayUserList() {
        $this->baseview->setjsonData($this->UserMod->DisplayUserList());
        echo $this->baseview->renderJson();
    }

}

?>